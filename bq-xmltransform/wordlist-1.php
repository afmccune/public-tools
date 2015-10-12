<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');

require('include/functions.php');
	
$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Word List</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$compositeText = '';
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
							if (preg_match('/.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								$fn_t['volNum'] = volFromFile($fn_t['file']);
								$fn_t['issueNum'] = substr($fn_t['file'], 5);
								$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
								$fn_t['newVolIss'] = $fn_t['volNum'].'.'.$fn_t['issueNum'];
								
								$compositeText .= file_get_contents('../../bq/docs/'.$fn_t['fn']);
								
								/*
								# LOAD XML FILE 
								$XML = new DOMDocument(); 
								$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
								//$XMLstring = str_replace($nl, "\r", $XMLstring);
								$XML->loadXML($XMLstring);

								# START XSLT 
								$xslt = new XSLTProcessor(); 
								$XSL = new DOMDocument(); 
								$XSL->load( 'xsl/text.xsl'); // This should convert to tagless text
								$xslt->importStylesheet( $XSL ); 
										
								# ADD TO COMPOSITE 
								$compositeText .= $xslt->transformToXML( $XML );			
								*/
								
								//echo '<p>'.$fn_t['fn'].' added to composite.</p>';
								echo '<span>'.$fn_t['fn'].' added to composite. </span>';
																
							}	
						}
						
						$compositeText = preg_replace('/[ ]{2,}/', ' ', $compositeText);

						file_put_contents('composite/_all.txt', $compositeText);

						$allWords = explode(' ', $compositeText);
						$allWordsUnique = array_unique($allWords);
						
						print '<pre>';
						print_r($allWords);
						print '</pre>';
						
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

