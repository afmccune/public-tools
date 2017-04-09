<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>PDF merge</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			$cmd = '#!/bin/bash'.$nl.$nl;
			
			$pdfs = array();

			foreach (new DirectoryIterator("pdf-rename/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}/', $fn->getFilename())) {
					$volIss = $fn->getFilename();
					$pdfs[$volIss] = array();
					
					foreach (new DirectoryIterator("pdf-rename/".$volIss."/") as $fn) {
						if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{3,7}.pdf/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
					
							$fileParts = explode('.', $fn_t['fn']);
							/*
							$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							*/
							$fn_t['p'] = $fileParts[2];
						
							$pdfs[$volIss][] = $fn_t['p'];
						}
					}
				}
			}
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['pb'] = $FullXML->xpath('//pb/@n'); // array

					$fileArray = array();
					
					$volTwoDig = str_pad($fn_t['volNum'], 2, '0', STR_PAD_LEFT); // sprintf('%02d', $fn_t['volNum']);
					
					foreach($fn_t['pb'] as $p) {
						$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT); // sprintf('%03d', $p);
						
						if (strpos($p, '-') === false) {
							$id = $volTwoDig.'.'.$fn_t['issueNum'].'.'.$pThreeDig;
							$fileArray[] = $id.'.pdf';
							if(in_array($pThreeDig.'', $pdfs[$fn_t['volIss']], TRUE)) {
								//fine
							} else {
								print '<p style="color:red;">'.$fn_t['volIss'].': No PDF for '.$p.'</p>';
							}
						} else if (in_array($pThreeDig.'', $pdfs[$fn_t['volIss']], TRUE)) {
							$id = $volTwoDig.'.'.$fn_t['issueNum'].'.'.$pThreeDig;
							$fileArray[] = $id.'.pdf';
						} else {
							$pbMinMax = explode('-', $p);
							$range = range($pbMinMax[0], $pbMinMax[1]);
							foreach($range as $rp) {
								$rpThreeDig = str_pad($rp, 3, '0', STR_PAD_LEFT);
								if(in_array($rpThreeDig.'', $pdfs[$fn_t['volIss']], TRUE)) {
									$id = $volTwoDig.'.'.$fn_t['issueNum'].'.'.$rpThreeDig;
									$fileArray[] = $id.'.pdf';
								} else {
									print '<p style="color:red;">'.$fn_t['volIss'].': No PDF for '.$rp.'</p>';
								}
							}
						}
					}

					$base_dir = '/Applications/MAMP/htdocs/bq-tools/bq-xmltransform/';
					
					$titlePage = $base_dir.'pdf-title-pdf/'.$fn_t['file'].'.title.pdf';
					if(!file_exists($titlePage)) {
						print '<p style="color:red;">'.$fn_t['volIss'].': No PDF for '.$fn_t['file'].' title page</p>';;
					}
					
					$input_dir = $base_dir.'pdf-rename/'.$fn_t['volIss'].'/';
					$output_dir = $base_dir.'pdf-merge/';
					if (file_exists($output_dir)) {
						// okay
					} else {
						mkdir($output_dir);
					}

					$outputName = $output_dir.$fn_t['file'].'.pdf';

					$cmd .= 'echo '.$fn_t['file'].$nl;
					$cmd .= 'gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile='.$outputName.' ';
					//Add pdf title page to the end of the command
					$cmd .= $titlePage.' ';
					//Add each pdf file to the end of the command
					foreach($fileArray as $file) {
						$cmd .= $input_dir.$file.' ';
					}
					
					$cmd .= $nl;
				}
			}
			
			// Create bash file
			file_put_contents('bash/merge.sh', $cmd);
			echo '<h4>Refreshed merge.sh</h4>';
			
			// Set permissions for bash file
			$result = shell_exec('cd /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash'.$nl.'chmod 775 merge.sh');
			
			// Instructions to run bash file from Terminal (since we can't seem to get it to run from PHP)
			echo '<h4>To run the merge, execute the following in Terminal: <br/> /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash/merge.sh</h4>';
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

