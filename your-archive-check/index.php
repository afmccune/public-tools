<!DOCTYPE html>
<html>
	<?php
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
							<h1>Book: Object Matchup</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$sorted = array();
			
			foreach (new DirectoryIterator("./archive/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					//$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);

					$fn_t['objIDs'] = array();
					$fn_t['workID'] = '';
					$fn_t['bCodes'] = array();
					
					$FullXML = simplexml_load_file('./archive/'.$fn_t['fn']); 
					
					$nl = '
';
					
					$objIDs = $FullXML->xpath('//desc/@id'); // array
					foreach($objIDs as $objID) {
						$stringID = print_r($objID, true);
						$stringID = str_replace('SimpleXMLElement Object', '', $stringID);
						$stringID = str_replace('[@attributes] => Array', '', $stringID);
						$stringID = str_replace('[id] =>', '', $stringID);
						$stringID = str_replace('(', '', $stringID);
						$stringID = str_replace(')', '', $stringID);
						$stringID = preg_replace('/\r|\n/', '', $stringID );
						$stringID = str_replace(' ', '', $stringID);
						$fn_t['objIDs'][] = $stringID;
					}
					
					$objIDparts = (count($fn_t['objIDs']) > 0) ? explode('.', $fn_t['objIDs'][0]) : array('');
					$fn_t['workID'] = $objIDparts[0];
					
					$bCodes = $FullXML->xpath('//desc//objcode/@code[contains(.,"B")]'); // array
					
					foreach($bCodes as $bCode) {
						$stringCode = print_r($bCode, true);
						$stringCode = str_replace('SimpleXMLElement Object', '', $stringCode);
						$stringCode = str_replace('[@attributes] => Array', '', $stringCode);
						$stringCode = str_replace('[code] =>', '', $stringCode);
						$stringCode = str_replace('(', '', $stringCode);
						$stringCode = str_replace(')', '', $stringCode);
						$stringCode = preg_replace('/\r|\n/', '', $stringCode );
						$stringCode = str_replace(' ', '', $stringCode);
						$fn_t['bCodes'][] = $stringCode;
					}
					
					for($i=0; $i<count($fn_t['bCodes']); $i++) {
						$workB = $fn_t['workID'].'('.$fn_t['bCodes'][$i].')';
						if(!$sorted[$workB]) {
							$sorted[$workB] = array();
						}
						$sorted[$workB][] = $fn_t['objIDs'][$i];
					}
					
				}
			}
			
			//print_r($sorted);
			
			$keyHolder = '';
			$valueHolder = array();
			$entryHolder = '';
			
			print '<table>';
			/*
			foreach ($sorted as $key => $value) {
				print '<tr>';
				print '<td>'.$key.'</td>';
				foreach($value as $v) {
					print '<td>'.$v.'</td>';
				}
				print '</tr>';
			}
			*/
			foreach ($sorted as $key => $value) {
				$keyHolder = $key;
				$valueHolder = $value;
				
				foreach($value as $entry) {
					$entryHolder = $entry;
					
					print '<tr>';
					//print '<td>'.$keyHolder.'</td>';
					print '<td>'.$entry.'</td>';
					
					$matches = str_replace($entry, '', str_replace(','.$entry, '', str_replace($entry.',', '', implode(',', $valueHolder))));
					print '<td>'.$matches.'</td>';
					
					print '</tr>';
				}
			}
			print '</table>';

			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

