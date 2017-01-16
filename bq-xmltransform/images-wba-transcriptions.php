<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	// note this function is @id based, not @n based like the one in image-duplicate
	//function addFigTranscr($file, $imageArr, $figTranscrArr){
	function addFigTranscr($file, $imageArr){
		$nl = '
';

		$XMLstring = file_get_contents('../../bq/docs/'.$file);
		$XMLstringNew = $XMLstring;
		
		//print_r($imageArr);
		
		for($i=0; $i<count($imageArr); $i++) {
			$image = $imageArr[$i];
			
			$figTranscr = file_get_contents('../wbatransform/new/'.$image.'.txt');
			
			print '<pre>';
			print '<p>file: '.$file.'; image: '.$image.'</p>';
			
			$image = str_replace('.','\.',$image);

			$figTranscr = change_quotes($figTranscr);
			$figTranscr = preg_replace('@[\r\n]{1,}@',$nl,$figTranscr);
			$figTranscr = str_replace(' '.$nl,$nl,$figTranscr);
			$figTranscr = str_replace('atmo-'.$nl.'-sphere'.$nl,'atmosphere'.$nl.$nl,$figTranscr);
			$figTranscr = str_replace('eve-'.$nl.'-ry ','every'.$nl.'',$figTranscr);
			$figTranscr = str_replace('unact-'.$nl.'-ed ','unacted'.$nl.'',$figTranscr);
			$figTranscr = str_replace('A-'.$nl.'-merican ','American'.$nl.'',$figTranscr);
			$figTranscr = str_replace('thun-'.$nl.'-derous ','thunderous'.$nl.'',$figTranscr);
			$figTranscr = str_replace('unbuck-'.$nl.'-led ','unbuckled'.$nl.'',$figTranscr);
			$figTranscr = str_replace('councel-'.$nl.'-lors,','councellors,'.$nl.'',$figTranscr);
			$figTranscr = str_replace('gol-'.$nl.'-den ','golden'.$nl.'',$figTranscr);
			$figTranscr = str_replace('vani-'.$nl.'-ty ','vanity'.$nl.'',$figTranscr);
			$figTranscr = str_replace('systema-'.$nl.'-tic ','systematic'.$nl.'',$figTranscr);
			$figTranscr = str_replace('be-'.$nl.'-cause ','because'.$nl.'',$figTranscr);
			$figTranscr = str_replace('se-'.$nl.'-ven ','seven'.$nl.'',$figTranscr);
			$figTranscr = str_replace('im-'.$nl.'-agines ','imagines'.$nl.'',$figTranscr);
			$figTranscr = str_replace('to-'.$nl.'-gether ','together'.$nl.'',$figTranscr);
			$figTranscr = str_replace('unre-'.$nl.'-deemable ','unredeemable'.$nl.'',$figTranscr);
			$figTranscr = str_replace('lea-'.$nl.'ving ','leaving'.$nl.'',$figTranscr);
			$figTranscr = str_replace('Hea-'.$nl.'-ven ','Heaven'.$nl.'',$figTranscr);
			$figTranscr = str_replace('des-'.$nl.'-pise ','despise'.$nl.'',$figTranscr);
			$figTranscr = str_replace('Gos-'.$nl.'-pel:','Gospel:'.$nl.'',$figTranscr);
			$figTranscr = str_replace('Jerusa-'.$nl.'-lem:','Jerusalem:'.$nl.'',$figTranscr);
			$figTranscr = str_replace('count'.$nl.'ting','counting'.$nl.'',$figTranscr);
			$figTranscr = str_replace('in-'.$nl.'coherent ','incoherent'.$nl.'',$figTranscr);
			$figTranscr = str_replace('Eter'.$nl.'-nity','Eternity',$figTranscr);
			$figTranscr = str_replace('(vision'.$nl.'The King of England looking westward trembles at the','The King of England looking westward trembles at the vision',$figTranscr);
			$figTranscr = str_replace('-tion'.$nl.'1. Earth was not: nor globes of attrac-','1. Earth was not: nor globes of attraction',$figTranscr);
			$figTranscr = str_replace('(woe'.$nl.'Sweetest the fruit that the worm feeds on. & the soul prey’d on by',$nl.'Sweetest the fruit that the worm feeds on. & the soul prey’d on by woe',$figTranscr);
			$figTranscr = str_replace('(drop'.$nl.'Where the cold miser spreads his gold? or does the bright cloud',$nl.'Where the cold miser spreads his gold? or does the bright cloud drop',$figTranscr);
			$figTranscr = preg_replace('@^[\r\n ]{1,}@','',$figTranscr);
			$figTranscr = preg_replace('@[\r\n ]{1,}$@','',$figTranscr);
			$figTranscr = preg_replace('@([ 	'.$nl.'])&([ '.$nl.'])@','$1&amp;$2',$figTranscr);
			$figTranscr = preg_replace('@ &c([ \.])@',' &amp;c$1',$figTranscr);
			$figTranscr = str_replace($nl,'<lb/>'.$nl.'	',$figTranscr);
			$figTranscr = str_replace(" th' ",' th’ ',$figTranscr);
			$figTranscr = str_replace(" thro' ",' thro’ ',$figTranscr);
			$figTranscr = str_replace("Subscribers'","Subscribers’",$figTranscr);
			$figTranscr = str_replace(" 'tis "," ’tis ",$figTranscr);
			$figTranscr = str_replace(" tho' "," tho’ ",$figTranscr);
			$figTranscr = str_replace("Tho'","Tho’",$figTranscr);
			$figTranscr = preg_replace("@([a-zA-Z])'([a-zA-Z])@",'$1’$2',$figTranscr);
			$figTranscr = preg_replace("@[ ]{2,}@",' ',$figTranscr);
			$figTranscr = str_replace("	 ",'	',$figTranscr); // tab space replaced with tab
				
			print '<p>transcription: '.$figTranscr.'</p>';
			print '</pre>';
			
			// ***
	
			$replace = array();
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="db" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}>'] = '<figure n="$1" id="$2" work-copy="$3" rend="db" width="$4" height="$5">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>';
			$replace['<figure n="([a-zA-Z0-9-_\.]{1,})" id="('.$image.')" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="db" width="([0-9]{1,})" height="([0-9]{1,})"[ ]{0,}/>'] = '<figure n="$1" id="$2" work-copy="$3" rend="db" width="$4" height="$5">'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'</figure>';
			$replace['<figTranscr></figTranscr>'] = '<figTranscr/>';
			//$replace[$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'.$nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'] = $nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'; // if an id appears twice in a file (say, for a full image and a detail), we could get duplicate transcripts; this will eliminate them
			
			$figTranscrRegex = preg_quote($figTranscr);
			$replace[$nl.'	<figTranscr>'.$figTranscrRegex.'</figTranscr>'.$nl.'	<figTranscr>'.$figTranscrRegex.'</figTranscr>'] = $nl.'	<figTranscr>'.$figTranscr.'</figTranscr>'; // if an id appears twice in a file (say, for a full image and a detail), we could get duplicate transcripts; this will eliminate them

			foreach($replace as $key => $value) {
				$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
			}
		}

		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
			file_put_contents('new/'.$file, $XMLstringNew);
			
			$fileId = str_replace('.xml','',$file);
			echo '<h4>Added figTranscr to <a href="/bq/'.$fileId.'" target="_blank">'.$fileId.'</a></h4>';
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
							<h1>Providing image transcriptions from WBA</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$wbaTranscr = array();
			$wbaTranscrIDs = array();
			
			$transcrFixesForFile = array();
			
			// First, an array of ids for transcriptions from the WBA
			
			foreach (new DirectoryIterator('../wbatransform/new/') as $fn) {
				if (preg_match('/\.txt/', $fn->getFilename())) {
					
					$file = str_replace('.txt', '', $fn->getFilename());

					$wbaTranscrIDs[] = $file;
				}
			}
						
			// Now we go through BQ docs
			
			foreach (new DirectoryIterator('../../bq/docs/') as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['id'] = $FullXML->xpath('//text//figure/@id'); // array
					
					$fn_t['imageArr'] = array();
					
					foreach($fn_t['id'] as $id) {
						if($id != '') {
							$transcr = $FullXML->xpath('//text//figure[@id="'.$id.'"]/figTranscr'); // array
							if(count($transcr) < 1 && in_array($id,$wbaTranscrIDs)) {
								$fn_t['imageArr'][] = $id;
							}
						} else {
							print '<p>'.$fn_t['fn'].' contains a blank figure ID.</p>';
						}
					}
					
					if(count($fn_t['imageArr']) > 0) {
						$transcrFixesForFile[$fn_t['fn']]['imageArr'] = $fn_t['imageArr'];	
						//$transcrFixesForFile[$fn_t['fn']]['imageArr'] = array($fn_t['imageArr'][0]);
					}
				}
			}
			
			foreach($transcrFixesForFile as $file => $arr) {
				//addFigTranscr($file, $arr['imageArr'], $arr['figTranscrArr']);
				if(count($arr['imageArr']) > 0) {
					addFigTranscr($file, $arr['imageArr']);
				} else {
					//print '<p>'.$file.' has no untranscribed images with WBA IDs.</p>';
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

