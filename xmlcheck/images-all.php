<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
	
	$base_path = ($_SERVER['SERVER_NAME'] == $mainServer || $_SERVER['SERVER_NAME'] == $devServer) ? '' : $mainDir;
	$base_url = ($_SERVER['SERVER_NAME'] == $mainServer) ? 'http://'.$mainServer.'/' : 'http://localhost:8888'.$url;
	$base_url_local = 'http://localhost:8888'.$url;
	
	require('include/functions.php');
	require('include/head.php');
	    
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
							<h1>Listing image filepaths</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
							
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

					print '<h4><a href="'.$base_url.$fn_t['file'].'">'.$fn_t['file'].'</a></h4>';

					if(count($fn_t['src']) > 0) {
						foreach($fn_t['src'] as $src) {
							$srcBase = '';
							if(strpos($src, 'scan') !== false){
								$srcBase = $src.'.png';
							} else if (strpos($src, '.100') !== false || strpos($src, '.bonus') !== false) {
								$srcBase = $src.'.jpg';
							} else {
								$srcBase = $src.'.300.jpg';
							}
							$srcFull = $base_path.'img/illustrations/'.$srcBase;
							$srcLocalLink = $base_url_local.'img/illustrations/'.$srcBase;
							$srcArch = $archiveImageUrl.$srcBase;

							print '<p><a href="'.$srcLocalLink.'">'.$srcFull.'</a> / <a href="'.$srcArch.'">'.$srcArch.'</a></p>';
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
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

