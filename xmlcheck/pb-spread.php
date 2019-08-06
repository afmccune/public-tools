<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('../../include.php');
	require('include/functions.php');
	require('include/head.php');
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for PDF spreads</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			$cmd = '#!/bin/bash'.$nl.$nl;
			
			$pdfs = array();

			foreach (new DirectoryIterator("../xmltransform/pdf-rename/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}/', $fn->getFilename())) {
					$volIss = $fn->getFilename();
					$pdfs[$volIss] = array();
					
					foreach (new DirectoryIterator("../xmltransform/pdf-rename/".$volIss."/") as $fn) {
						if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-0-9]{3,7}.pdf/', $fn->getFilename())) {
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
			
			foreach (new DirectoryIterator($dir) as $fn) {
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
					
					if($fn_t['fileSplit'] != 'toc') { // ignore TOCs, which always have hyphenated pages but never (I think) spreads
						$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
						$fn_t['pb'] = $FullXML->xpath('//pb/@n'); // array
						$fn_t['pbHidden'] = $FullXML->xpath('//pb[@rend="hidden"]/@n'); // array

						$hidden = implode(', ', $fn_t['pbHidden']);
						
						$fileArray = array();

						$volTwoDig = str_pad($fn_t['volNum'], 2, '0', STR_PAD_LEFT);

						foreach($fn_t['pb'] as $p) {
							if(strpos($hidden, $p) === false) { // ignore hidden pages
								$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT); // sprintf('%03d', $p);
						
								if (strpos($p, '-') === false) {
									// ignore: not a spread
								} else if (in_array($pThreeDig.'', $pdfs[$fn_t['volIss']], TRUE)) {
									// ignore: already recognized as a spread, with a matching PDF
								} else {
									$pbMinMax = explode('-', $p);
									$pThreeDig1 = str_pad($pbMinMax[0], 3, '0', STR_PAD_LEFT);
									$pdf1 = '/public-tools/xmltransform/pdf-rename/'.$fn_t['volNum'].'.'.$fn_t['issueNum'].'/'.$volTwoDig.'.'.$fn_t['issueNum'].'.'.$pThreeDig1.'.pdf';
									$pThreeDig2 = str_pad($pbMinMax[1], 3, '0', STR_PAD_LEFT);
									$pdf2 = '/public-tools/xmltransform/pdf-rename/'.$fn_t['volNum'].'.'.$fn_t['issueNum'].'/'.$volTwoDig.'.'.$fn_t['issueNum'].'.'.$pThreeDig2.'.pdf';
									print '<p style="color:red;"><a href="'.$url.$fn_t['file'].'#p'.$p.'" target="_blank">'.$fn_t['file'].'</a>: No PDF for '.$p.'. (<a href="'.$pdf1.'" target="_blank">PDF for '.$pbMinMax[0].'</a>; <a href="'.$pdf2.'" target="_blank">PDF for '.$pbMinMax[1].'</a>)</p>';

									if(count($fn_t['pbHidden']) > 0) {
										print '<p>'.$fn_t['file'].' hidden pages: '.$hidden.'</p>';
									}
								}
							}
						}
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

