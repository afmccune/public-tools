<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org' || $_SERVER['SERVER_NAME'] == 'bq-dev.blakearchive.org') ? '' : '../../bq/';
	$base_url = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org') ? 'http://bq.blakearchive.org/' : 'http://localhost:8888/bq/';
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
	
	function isImage($url) {
		$params = array('http' => array(
					  'method' => 'HEAD'
				   ));
		$ctx = stream_context_create($params);
		/* Note: on public server, fopen fails for external URLs */
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) 
			return false;  // Problem with url

		$meta = stream_get_meta_data($fp);
		if ($meta === false)
		{
			fclose($fp);
			return false;  // Problem reading data from url
		}

		$wrapper_data = $meta["wrapper_data"];
		if(is_array($wrapper_data)){
		  foreach(array_keys($wrapper_data) as $hh){
			  if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19 
			  {
				fclose($fp);
				return true;
			  }
		  }
		}

		fclose($fp);
		return false;
	  }
	
	// trouble with this is the answer is always yes on the new WBA, which gives you a custom 404 page if the URL is wrong
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

        } else { return FALSE;}
    }
    
    function filecmp(array $a, array $b) {
					return strcmp($a['file'], $b['file']);
			}
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for missing image files</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator($base_path."docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];

					$FullXML = simplexml_load_file($base_path.'docs/'.$fn_t['fn']); 
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					
					$XMLyear = $FullXML->xpath('//fileDesc/publicationStmt/date');
					$decade = substr($XMLyear[0], 0, 3).'0s';

					$fn_t['errors'] = array();
					if(count($fn_t['src']) > 0) {
						foreach($fn_t['src'] as $src) {
							$srcBase = '';
							if(strpos($src, 'bqscan') !== false){
								$srcBase = $src.'.png';
							} else if (strpos($src, '.100') !== false || strpos($src, '.bonus') !== false) {
								$srcBase = $src.'.jpg';
							} else {
								$srcBase = $src.'.300.jpg';
							}
							$srcFull = $base_path.'img/illustrations/'.$srcBase;
							$srcLocalLink = $base_url_local.'img/illustrations/'.$srcBase;
							$srcWBA = 'http://www.blakearchive.org/images/'.$srcBase;
							if(file_exists($srcFull)) {
								//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcLocalLink.'">'.$srcFull.'</a></p>';
							} else if(isImage($srcWBA)) {
								//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcWBA.'">'.$srcWBA.'</a></p>';
							} else {
								$fn_t['errors'][] = 'Missing image: <a href="'.$srcLocalLink.'">'.$srcFull.'</a> / <a href="'.$srcWBA.'">'.$srcWBA.'</a>';
								$numMissing = $numMissing + 1;
								$missingByDecade[$decade] = $missingByDecade[$decade] + 1;
							}
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
					}

					$docsXml[] = $fn_t;
					
				}
			}
			
			usort($docsXml, 'filecmp');
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$base_url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
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

