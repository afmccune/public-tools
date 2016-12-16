<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org' || $_SERVER['SERVER_NAME'] == 'bq-dev.blakearchive.org') ? '' : '../../bq/';
	$base_url = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org') ? 'http://bq.blakearchive.org/' : 'http://localhost:8888/bq/';
	$base_url_local = 'http://localhost:8888/bq/';
	
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
							<h1>Checking for images appearing in multiple articles</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			//$docsXml = array();
			
			$filesWithImage = array();
			$filesWithDupImage = array();
			$dupImagesInFile = array();
			$transcrCountsForImg = array();
			
			foreach (new DirectoryIterator($base_path."docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					/*
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];
					*/

					$FullXML = simplexml_load_file($base_path.'docs/'.$fn_t['fn']); 
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					
					//$fn_t['errors'] = array();
					
					// each image gets an array of articles
					if(count($fn_t['src']) > 0) {
						foreach($fn_t['src'] as $src) {
							if(isset($filesWithImage[(string)$src])) {
								// nothing
							} else {
								$filesWithImage[(string)$src] = array();
							}
							$filesWithImage[(string)$src][] = $fn_t['fn'];
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
					}

					//$docsXml[] = $fn_t;
					
				}
			}
			
			// we create a new array of images with array counts > 1 (all duplicate images)
			// we create another array of articles with duplicate images
			
			foreach($filesWithImage as $img => $fileArray) {
				if(count($fileArray) > 1) {
					$filesWithDupImage[$img] = $fileArray;
					foreach($fileArray as $file) {
						if(isset($dupImagesInFile[(string)$file])) {
							// nothing
						} else {
							$dupImagesInFile[(string)$file] = array();
						}
						$dupImagesInFile[(string)$file][] = $img;
					}
				}
			}
			
			/*
			print '<pre>';
			print '<h3>filesWithDupImage</h3>';
			print_r($filesWithDupImage);
			print '<h3>dupImagesInFile</h3>';
			print_r($dupImagesInFile);
			print '</pre>';
			*/
			
			// for each duplicate image in an article, count figTranscr of that image : figure[@n='$this']/figTranscr
			// associative array for each duplicate image: article = figTranscr count [IF it has the image at all]
			
			foreach($dupImagesInFile as $file => $images) {
				$FullXML = simplexml_load_file($base_path.'docs/'.$file); 
				
				foreach($images as $img) {
					$figTranscr = $FullXML->xpath('//text//figure[@n="'.$img.'"]/figTranscr'); // array
					if(isset($transcrCountsForImg[$img])) {
						// nothing
					} else {
						$transcrCountsForImg[$img] = array();
					}
					$transcrCountsForImg[$img][] = array('file' => $file, 'count' => count($figTranscr));
				}
					
			}
			
			// if the articles displaying the same image do not have the same count, ALERT
			
			print '<pre>';
			print '<h3>Duplicate images where we can duplicate transcriptions</h3>';
			
			foreach($transcrCountsForImg as $img => $fileCounts) {
				$unequal = false;
				for($i=0; $i<count($fileCounts); $i++) {
					if($i>0 && $fileCounts[$i]['count'] != $fileCounts[$i-1]['count']) {
						$unequal = true;
					}
				}
				if($unequal) {
					print('<h4>'.$img.'</h4>');
					print_r($fileCounts);
				}
			}
			
			print '</pre>';
			
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
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

