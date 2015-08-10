<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org') ? '' : '../../bq/';
	$base_url = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org') ? 'http://bq.blakearchive.org/' : 'http://localhost:8888/bq/';
	$base_url_local = 'http://localhost:8888/bq/';
	
	$numDouble = 0;
	$doubleByDecade = array();
	$doubleByDecade['1960s'] = 0;
	$doubleByDecade['1970s'] = 0;
	$doubleByDecade['1980s'] = 0;
	$doubleByDecade['1990s'] = 0;
	$doubleByDecade['2000s'] = 0;
	$doubleByDecade['2010s'] = 0;

	
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
							<h1>Checking image for correct rend value</h1>
							<p>If image exists both locally and on public WBA site, rend value may point to local file ("file") when it should point to WBA ("db").</p>
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
							$srcWBA = 'http://www.blakearchive.org/blake/images/'.$srcBase;
							if(file_exists($srcFull)) {
								if (url_exists($srcWBA)) {
									$fn_t['errors'][] = 'Image exists both locally and on public WBA site: <a href="'.$srcLocalLink.'">'.$srcFull.'</a> / <a href="'.$srcWBA.'">'.$srcWBA.'</a>';
									$numDouble = $numDouble + 1;
									$doubleByDecade[$decade] = $doubleByDecade[$decade] + 1;
								}
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
			
			print '<h3>Double images (1960s): '.$doubleByDecade['1960s'].'</h3>';
			print '<h3>Double images (1970s): '.$doubleByDecade['1970s'].'</h3>';
			print '<h3>Double images (1980s): '.$doubleByDecade['1980s'].'</h3>';
			print '<h3>Double images (1990s): '.$doubleByDecade['1990s'].'</h3>';
			print '<h3>Double images (2000s): '.$doubleByDecade['2000s'].'</h3>';
			print '<h3>Double images (2010s): '.$doubleByDecade['2010s'].'</h3>';
			print '<h3>Total double images: '.$numDouble.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

