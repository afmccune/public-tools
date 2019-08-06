<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../../include.php');
	
	require('include/functions.php');
	require('include/head.php');
	
	// note this function is @id based, not @n based like the one in image-duplicate
	//function addFigTranscr($file, $imageArr, $figTranscrArr){
	function addFigTranscr($file, $imageArr){
		$nl = '
';

		$XMLstring = file_get_contents($dir.$file);
		$XMLstringNew = $XMLstring;
		
		for($i=0; $i<count($imageArr); $i++) {
			$image = $imageArr[$i];
			
			$figTranscr = file_get_contents('../your-archive-transform/new/'.$image.'.txt');
			
			print '<pre>';
			print '<p>file: '.$file.'; image: '.$image.'</p>';
			
			$image = str_replace('.','\.',$image);

			$figTranscr = change_quotes($figTranscr);
			$figTranscr = preg_replace('@^[\r\n ]{1,}@','',$figTranscr);
			$figTranscr = preg_replace('@[\r\n ]{1,}$@','',$figTranscr);
			$figTranscr = str_replace($nl,'<lb/>'.$nl.'	',$figTranscr);
			$figTranscr = preg_replace('@( |	)&( |'.$nl.')@','$1&amp;$2',$figTranscr);
			$figTranscr = preg_replace('@ &c( |\.)@',' &amp;c$1',$figTranscr);
			$figTranscr = str_replace(" th' ",' th’ ',$figTranscr);
			$figTranscr = str_replace(" thro' ",' thro’ ',$figTranscr);
			$figTranscr = preg_replace("@([a-zA-Z])'([a-zA-Z])@",'$1’$2',$figTranscr);
			$figTranscr = preg_replace("@[ ]{2,}@",' ',$figTranscr);
			$figTranscr = str_replace("	 ",'	',$figTranscr); // tab space replaced with tab
	
			print '<p>transcription: '.$figTranscr.'</p>';
			print '</pre>';
			
			// ***
	
			$replace = array();
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>';
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}/>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" width="$5" height="$6">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'</figure>';
			$replace['<figTranscr></figTranscr>'] = '<figTranscr/>';
			$replace[$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'] = $nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'; // if an id appears twice in a file (say, for a full image and a detail), we could get duplicate transcripts; this will eliminate them

			foreach($replace as $key => $value) {
				$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
			}
		}

		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
			file_put_contents('new/'.$file, $XMLstringNew);
			
			$fileId = str_replace('.xml','',$file);
			echo '<h4>Added figTranscr to <a href="'.$url.$fileId.'" target="_blank">'.$fileId.'</a></h4>';
		} else if ($XMLstringNew == '') {
			echo '<p>'.$file.': ERROR, blank</p>';
		} else {
			echo '<p>'.$file.': no change</p>';
		}
    }
    
    function change_quotes($string){
		$quotes = substr_count($string, '"');
		
		if($quotes % 2 == 0) {
			// even
		} else {
			echo '<p>WARNING: Number of quotes is odd.';
		}
		
		$quote_pairs = ceil($quotes/2);
		
		for($i=0; $i<$quote_pairs; $i++) {
			$string = preg_replace('/"/', '”', preg_replace('/"/', '“', $string, 1), 1);
		}
		
		return $string;
    }
    
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Providing image transcriptions from your archive</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$archiveTranscr = array();
			$archiveTranscrIDs = array();
			
			$transcrFixesForFile = array();
			
			// First, an array of ids for transcriptions from your archive
			
			foreach (new DirectoryIterator('../your-archive-transform/new/') as $fn) {
				if (preg_match('/\.txt/', $fn->getFilename())) {
					
					$file = str_replace('.txt', '', $fn->getFilename());

					$archiveTranscrIDs[] = $file;
				}
			}
						
			// Now we go through docs
			
			foreach (new DirectoryIterator($dir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					$fn_t['id'] = $FullXML->xpath('//text//figure/@id'); // array
					
					foreach($fn_t['id'] as $id) {
						$transcr = $FullXML->xpath('//text//figure[@id="'.$id.'"]/figTranscr'); // array
						if(count($transcr) < 1 && in_array($id,$archiveTranscrIDs)) {
							if(isset($transcrFixesForFile[$fn_t['fn']])) {
								//nothing
							} else {
								$transcrFixesForFile[$fn_t['fn']] = array();
								$transcrFixesForFile[$fn_t['fn']]['imageArr'] = array();
								//$transcrFixesForFile[$fn_t['fn']]['figTranscrArr'] = array();
							}
							$transcrFixesForFile[$fn_t['fn']]['imageArr'][] = $id;
							//$transcrFixesForFile[$fn_t['fn']]['figTranscrArr'][] = $archiveTranscr[$id];							
						}
					}
					
				}
			}
			
			foreach($transcrFixesForFile as $file => $arr) {
				//addFigTranscr($file, $arr['imageArr'], $arr['figTranscrArr']);
				addFigTranscr($file, $arr['imageArr']);
			}
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>