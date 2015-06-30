<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
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

        } else { return FALSE;}
    }
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for errors</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					
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
							$srcFull = '../../bq/img/illustrations/'.$srcBase;
							$srcLocalLink = 'http://localhost/bq/img/illustrations/'.$srcBase;
							$srcWBA = 'http://www.blakearchive.org/blake/images/'.$srcBase;
							if(file_exists($srcFull)) {
								//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcLocalLink.'">'.$srcFull.'</a></p>';
							} else if(url_exists($srcWBA)) {
								//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcWBA.'">'.$srcWBA.'</a></p>';
							} else {
								$fn_t['errors'][] = 'Missing image: <a href="'.$srcLocalLink.'">'.$srcFull.'</a> / <a href="'.$srcWBA.'">'.$srcWBA.'</a>';
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
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>
