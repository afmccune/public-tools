<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org') ? '' : '../../bq/';
	$base_url_local = 'http://localhost:8888/bq/';
	
	$numMissing = 0;
	$missingByDecade = array();
	$missingByDecade['1960s'] = 0;
	$missingByDecade['1970s'] = 0;
	$missingByDecade['1980s'] = 0;
	$missingByDecade['1990s'] = 0;
	$missingByDecade['2000s'] = 0;
	$missingByDecade['2010s'] = 0;

	require('include/functions.php');
	require('include/head.php');
	
	function url_exists($url){
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        } else {
            $url = array($url, "/");
        }

        $fh = fsockopen($url[0], 80);
        if ($fh) {
            fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
            else { return TRUE;    }

        } else { 
        	//echo '<p>no fh</p>';
        	return FALSE;
        }
    }

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking image paths after XSLT</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						$XMLstring = file_get_contents( '../../bq/docs/'.$fn_t['fn'] );
						$remove = array("\n", "\r\n", "\r");
						$XMLstring = str_replace($remove, ' ', $XMLstring);
						$XMLstring = preg_replace('/[ ]+/', ' ', $XMLstring);
						$XML->loadXML($XMLstring);
					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/img.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 
						//file_put_contents('new/'.$fn_t['fn'], $stripped);

						$FullXML = simplexml_load_string($stripped);
						
						//echo $stripped;
											
					$XMLsrc = $FullXML->xpath('//img/@src');
					$fn_t['src'] = $XMLsrc; // array
					
					$XMLyear = $FullXML->xpath('//fileDesc/publicationStmt/date');
					$decade = substr($XMLyear[0], 0, 3).'0s';
					
					$fn_t['errors'] = array();

					if(count($fn_t['src']) > 0) {
						foreach($fn_t['src'] as $src) {
							if(strpos($src, 'http://') === false) {
								$srcFull = $base_path.$src;
								$srcLocalLink = $base_url_local.$src;
								$srcPublic = 'http://bq.blakearchive.org/'.$src;
								if(file_exists($srcFull)) {
									//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcLocalLink.'">'.$srcFull.'</a></p>';
								} else if(url_exists($srcPublic)) {
									//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcPublic.'">'.$srcPublic.'</a></p>';
								} else {
									$fn_t['errors'][] = 'Missing image: <a href="'.$srcLocalLink.'">'.$srcFull.'</a>';
									$numMissing = $numMissing + 1;
									$missingByDecade[$decade] = $missingByDecade[$decade] + 1;
								}
							} else {
								$srcFull = $src;
								if(url_exists($srcFull)) {
									//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcFull.'">'.$srcFull.'</a></p>';
								} else {
									$fn_t['errors'][] = 'Missing image: <a href="'.$srcFull.'">'.$srcFull.'</a>';
									$numMissing = $numMissing + 1;
									$missingByDecade[$decade] = $missingByDecade[$decade] + 1;
								}
							}
							
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
					}
					
					$docsXml[] = $fn_t;
	
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
				}
			}
			
			print '<h3>Missing images (1960s): '.$missingByDecade['1960s'].'</h3>';
			print '<h3>Missing images (1970s): '.$missingByDecade['1970s'].'</h3>';
			print '<h3>Missing images (1980s): '.$missingByDecade['1980s'].'</h3>';
			print '<h3>Missing images (1990s): '.$missingByDecade['1990s'].'</h3>';
			print '<h3>Missing images (2000s): '.$missingByDecade['2000s'].'</h3>';
			print '<h3>Missing images (2010s): '.$missingByDecade['2010s'].'</h3>';
			print '<h3>Total missing images: '.$numMissing.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

