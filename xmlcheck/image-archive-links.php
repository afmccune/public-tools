<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');

	$base_path = ($_SERVER['SERVER_NAME'] == $mainServer || $_SERVER['SERVER_NAME'] == $devServer) ? '' : $mainDir;
	$base_url = ($_SERVER['SERVER_NAME'] == $mainServer) ? 'http://'.$mainServer.'/' : 'http://localhost:8888'.$url;
	$base_url_local = 'http://localhost:8888'.$url;

	$numMissing = 0;
	
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
							<h1>Checking for missing URLs (image archive links)</h1>
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
					$fn_t['link'] = $FullXML->xpath('//text//figure/@id'); // array
					
					$fn_t['errors'] = array();
					if(count($fn_t['link']) > 0) {
						foreach($fn_t['link'] as $link) {
							$linkParts = explode('.', $link);
							$copy = $linkParts[0].'.'.$linkParts[1];
							$linkWBA = 'http://blakearchive.org/copy/'.$copy.'?descId='.$link;
							if(url_exists($linkWBA)) {
								echo '<p>'.$fn_t['file'].': Link found: <a href="'.$linkWBA.'">'.$linkWBA.'</a></p>';
							} else {
								echo '<p><strong>'.$fn_t['file'].': Broken link: <a href="'.$linkWBA.'">'.$linkWBA.'</a></strong></p>';
								//$fn_t['errors'][] = 'Broken link: <a href="'.$linkWBA.'">'.$linkWBA.'</a>';
								$numMissing = $numMissing + 1;
							}
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
					}

					$docsXml[] = $fn_t;
					
				}
			}
			/*
			usort($docsXml, 'filecmp');
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$base_url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
				}
			}
			*/
			
			print '<h3>Total missing URLs: '.$numMissing.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

