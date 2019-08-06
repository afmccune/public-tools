<!DOCTYPE html>
<html>
	<?php
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes
	
	$pt = "";
	
	require('include/functions.php');
	require('include/head.php');
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Characteristics</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$masterCharList = array();
			$noCharacteristics = array();
			
			foreach (new DirectoryIterator("./archive/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
					$nl = '
';
						
					$FullXML = simplexml_load_file('./archive/'.$fn_t['fn']); 
						
					$fn_t['itemIDs'] = $FullXML->xpath('//'.$itemCode.'/@id');
					$fn_t['itemID'] = (count($fn_t['itemIDs']) > 0) ? $fn_t['itemIDs'][0] : '';
					
					$fn_t['characteristics'] = $FullXML->xpath('//characteristic');
					$fn_t['characteristics'] = array_unique($fn_t['characteristics']);
					sort($fn_t['characteristics'], SORT_NATURAL | SORT_FLAG_CASE);
					
					$masterCharList = array_merge($masterCharList, $fn_t['characteristics']);
					$fn_t['charlist'] = (count($fn_t['characteristics']) > 0) ? implode($nl, $fn_t['characteristics']) : '';
					
					if($fn_t['itemID'] != '' && $fn_t['charlist'] != '') {
						file_put_contents('characteristics/'.$fn_t['itemID'].'.txt', $fn_t['charlist']);
						print '<p>Processed characteristics for '.$fn_t['fn'].'</p>';
					} else if ($fn_t['charlist'] == ''){
						$noCharacteristics[] = $fn_t['fn'];
						//print '<p>'.$fn_t['fn'].' has no characteristics.</p>';
					} else {
						print '<p>'.$fn_t['fn'].' is missing item id. Saving characteristics to '.$fn_t['fn'].'.txt</p>';
						file_put_contents('characteristics/'.$fn_t['fn'].'.txt', $fn_t['charlist']);
						print '<p>Processed characteristics for '.$fn_t['fn'].'</p>';
					} 
				}
			}
			
			$masterCharList = array_unique($masterCharList);
			sort($masterCharList, SORT_NATURAL | SORT_FLAG_CASE);
			$mcl_string = implode($nl, $masterCharList);
			file_put_contents('characteristics/_masterCharList.txt', $mcl_string);
			print '<p>Master Characteristic List saved to _masterCharList.txt</p>';

			print '<p>The following files contain no characteristics:</p>';
			foreach($noCharacteristics as $filename) {
				print '<p>'.$filename.'</p>';
			}

			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

