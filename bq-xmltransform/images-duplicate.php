<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	function addFigTranscr($file, $imageArr, $figTranscrArr){
		$nl = '
';

		$XMLstring = file_get_contents('../../bq/docs/'.$file);
		$XMLstringNew = $XMLstring;
		
		for($i=0; $i<count($figTranscrArr); $i++) {
			$image = $imageArr[$i];
			$figTranscr = $figTranscrArr[$i];
			
			print '<p>file: '.$file.'; image: '.$image.'</p>';
		
			$image = str_replace('.','\.',$image);

			$figTranscr = str_replace($nl,'<lb/>'.$nl,$figTranscr);
			$figTranscr = str_replace(' & ',' &amp; ',$figTranscr);
	
			// ***
	
			$replace = array();
			$replace['<figure n="('.$image.')" id="([a-zA-Z0-9-_\.]{1,})" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>';
			$replace['<figure n="('.$image.')" id="([a-zA-Z0-9-_\.]{1,})" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}/>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'</figure>';
			$replace['<figure n="('.$image.')" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}>'] = '<figure n="$1" rend="$2" width="$3" height="$4">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>';
			$replace['<figure n="('.$image.')" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}/>'] = '<figure n="$1" rend="$2" width="$3" height="$4">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'</figure>';

			foreach($replace as $key => $value) {
				$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
			}
		}

		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
			file_put_contents('new/'.$file, $XMLstringNew);
			echo '<h4>Added figTranscr to '.$file.'</h4>';
		} else if ($XMLstringNew == '') {
			echo '<p>'.$file.': ERROR, blank</p>';
		} else {
			echo '<p>'.$file.': no change</p>';
		}
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
			$transcrFixesForFile = array();
			
			foreach (new DirectoryIterator('../../bq/docs/') as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
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
			
			// for each duplicate image in an article, count figTranscr of that image : figure[@n='$this']/figTranscr
			// associative array for each duplicate image: article = figTranscr count [IF it has the image at all]
			
			foreach($dupImagesInFile as $file => $images) {
				$FullXML = simplexml_load_file('../../bq/docs/'.$file); 
				
				foreach($images as $img) {
					$figTranscrArr = $FullXML->xpath('//text//figure[@n="'.$img.'"]/figTranscr'); // array
					$figTranscr = '';
					if(count($figTranscrArr) > 0) {
						$figTranscr = $figTranscrArr[0];
					}
					if(isset($transcrCountsForImg[$img])) {
						// nothing
					} else {
						$transcrCountsForImg[$img] = array();
					}
					$transcrCountsForImg[$img][] = array('file' => $file, 'count' => count($figTranscrArr), 'figTranscr' => (string)$figTranscr);
				}
					
			}
			
			// if the articles displaying the same image do not have the same count, COPY figTranscr from one that has it to one that does not
			
			foreach($transcrCountsForImg as $img => $fileCounts) {
				$unequal = false;
				for($i=0; $i<count($fileCounts); $i++) {
					if($i>0 && $fileCounts[$i]['count'] < $fileCounts[$i-1]['count']) {
						$file = $fileCounts[$i]['file'];
						$figTranscr = $fileCounts[$i-1]['figTranscr'];
						//print '<p>FILE: '.$file.'; IMAGE: '.$img.'; figTRANSCR: '.$figTranscr.'</p>';
						if(isset($transcrFixesForFile[$file])) {
							//nothing
						} else {
							$transcrFixesForFile[$file] = array();
							$transcrFixesForFile[$file]['imageArr'] = array();
							$transcrFixesForFile[$file]['figTranscrArr'] = array();
						}
						$transcrFixesForFile[$file]['imageArr'][] = $img;
						$transcrFixesForFile[$file]['figTranscrArr'][] = $figTranscr;
						$fileCounts[$i]['count'] = $fileCounts[$i]['count'] + 1;
					} else if ($i>0 && $fileCounts[$i]['count'] > $fileCounts[$i-1]['count']) {
						$file = $fileCounts[$i-1]['file'];
						$figTranscr = $fileCounts[$i]['figTranscr'];
						//print '<p>FILE: '.$file.'; IMAGE: '.$img.'; figTRANSCR: '.$figTranscr.'</p>';
						if(isset($transcrFixesForFile[$file])) {
							//nothing
						} else {
							$transcrFixesForFile[$file] = array();
							$transcrFixesForFile[$file]['imageArr'] = array();
							$transcrFixesForFile[$file]['figTranscrArr'] = array();
						}
						$transcrFixesForFile[$file]['imageArr'][] = $img;
						$transcrFixesForFile[$file]['figTranscrArr'][] = $figTranscr;
						$fileCounts[$i-1]['count'] = $fileCounts[$i-1]['count'] + 1;
					}
				}
			}
			
			foreach($transcrFixesForFile as $file => $arr) {
				addFigTranscr($file, $arr['imageArr'], $arr['figTranscrArr']);
			}
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

