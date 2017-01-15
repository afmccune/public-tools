<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	// note this function is @id based, not @n based like the one in image-duplicate
	function addFigTranscr($file, $imageArr, $figTranscrArr){
		$nl = '
';

		$XMLstring = file_get_contents('../../bq/docs/'.$file);
		$XMLstringNew = $XMLstring;
		
		for($i=0; $i<count($figTranscrArr); $i++) {
			$image = $imageArr[$i];
			$figTranscr = $figTranscrArr[$i];
			
			print '<p>file: '.$file.'; image: '.$image.'</p>';
			print '<p>transcription: '.$figTranscr.'</p>';
		
			$image = str_replace('.','\.',$image);

			$figTranscr = str_replace($nl,'<lb/>'.$nl,$figTranscr);
			$figTranscr = preg_replace('@( |	)& @','$1&amp; ',$figTranscr);
			$figTranscr = preg_replace('@ &c( |\.)@',' &amp;c$1',$figTranscr);
			$figTranscr = preg_replace("@([a-zA-Z])'([a-zA-Z])@",'$1’$2',$figTranscr);
	
			// ***
	
			$replace = array();
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>';
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}/>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'</figure>';
			$replace['<figTranscr></figTranscr>'] = '<figTranscr/>';

			foreach($replace as $key => $value) {
				$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
			}
		}

		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
			file_put_contents('new/'.$file, $XMLstringNew);
			
			$fileId = str_replace('.xml','',$file);
			echo '<h4>Added figTranscr to <a href="/bq/'.$fileId.'">'.$fileId.'</a></h4>';
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
							<h1>Providing image transcriptions from WBA</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$wbaTranscr = array();
			$wbaTranscrIDs = array();
			
			$transcrFixesForFile = array();
			
			// First, an array of transcriptions from the WBA
			
			foreach (new DirectoryIterator('../wbatransform/new/') as $fn) {
				if (preg_match('/\.txt/', $fn->getFilename())) {
					
					$file = str_replace('.txt', '', $fn->getFilename());

					$XMLstring = file_get_contents( '../wbatransform/new/'.$fn->getFilename());
					
					$wbaTranscr[$file] = $XMLstring;
					//print '<p>'.$wbaTranscr[$file].'</p>';

					//$wbaTranscrIDs[] = $file;
				}
			}
			
			$wbaTranscrIDs = array_keys($wbaTranscr);
			
			print_r($wbaTranscr);
						
			// Now we go through BQ docs
			
			foreach (new DirectoryIterator('../../bq/docs/') as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					/*
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					*/

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					//$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					$fn_t['id'] = $FullXML->xpath('//text//figure/@id'); // array

					foreach($fn_t['id'] as $id) {
						$transcr = $FullXML->xpath('//text//figure[@id="'.$id.'"]/figTranscr'); // array
						if(count($transcr) < 1 && in_array($id,$wbaTranscrIDs)) {
							if(isset($transcrFixesForFile[$fn_t['fn']])) {
								//nothing
							} else {
								$transcrFixesForFile[$fn_t['fn']] = array();
								$transcrFixesForFile[$fn_t['fn']]['imageArr'] = array();
								$transcrFixesForFile[$fn_t['fn']]['figTranscrArr'] = array();
							}
							$transcrFixesForFile[$fn_t['fn']]['imageArr'][] = $id;
							$transcrFixesForFile[$fn_t['fn']]['figTranscrArr'][] = $wbaTranscr[$id];
							
							print '<p>id: '.$id.'</p>';
							//print_r($wbaTranscr);
							print '<p>transcription: '.$wbaTranscr[$id].'</p>';
						}
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

