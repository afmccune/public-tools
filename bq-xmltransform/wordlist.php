<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

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
						
						$masterList = array();
						
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
								
								//$compositeText .= file_get_contents('../../bq/docs/'.$fn_t['fn']);
								$fn_t['text'] = file_get_contents('../../bq/docs/'.$fn_t['fn']);
								$fn_t['text'] = strip_tags($fn_t['text']);
								//$fn_t['text'] = preg_replace('/[ 	\n\r]{1,}/', ' ', $fn_t['text']);
								
								mb_regex_encoding('UTF-8');
								mb_internal_encoding("UTF-8");
								
								$fn_t['wordlist'] = mb_split('[\s—]+', $fn_t['text']);
								$fn_t['wordlist'] = array_unique($fn_t['wordlist']);
								
								for($i=0; $i<count($fn_t['wordlist']); $i++) {
									if(preg_match('/[a-zA-Z]/', $fn_t['wordlist'][$i])) {
										echo '<p>'.$fn_t['wordlist'][$i];
										// if contains letters, strip punctuation off beginning and end
										$fn_t['wordlist'][$i] = mb_ereg_replace('^[\*\[\(“"‘]{1,}', '', $fn_t['wordlist'][$i]);
										$fn_t['wordlist'][$i] = mb_ereg_replace('[,!\.\?;:’"”\)\]\*]{1,}$', '', $fn_t['wordlist'][$i]);
										echo ' becomes '.$fn_t['wordlist'][$i].'</p>';
									} else {
										echo '<p>Deleted: '.$fn_t['wordlist'][$i].'</p>';
										unset($fn_t['wordlist'][$i]);
									}
								}
								
								$masterList = array_merge($masterList, $fn_t['wordlist']);
								$masterList = array_unique($masterList);
								sort($masterList);
								
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
								//echo '<span>'.$fn_t['fn'].' added to composite. </span>';
								
								$listStr = implode($nl, $masterList);
								file_put_contents('composite/_wordlist.txt', $listStr);
								
								echo '<h4>'.$fn_t['fn'].'</h4>';
						
								/*
								print '<pre>';
								print_r($masterList);
								print '</pre>';
								*/
																
							}	
						}
						
						/*
						print '<pre>';
						print_r($masterList);
						print '</pre>';
						*/
						
						/*
						$compositeText = preg_replace('/[ ]{2,}/', ' ', $compositeText);

						file_put_contents('composite/_all.txt', $compositeText);

						$allWords = explode(' ', $compositeText);
						$allWordsUnique = array_unique($allWords);
						
						print '<pre>';
						print_r($allWords);
						print '</pre>';
						*/
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

