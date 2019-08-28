<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require('../include.php');
require('include/functions.php');
	
$nl = "
";

$seekStr = '[0-9⅛¼½¾⅞]{1,}[ ]{0,1}["″] [x×] [0-9]{1,}[ 0-9\/⅛¼½¾⅞]{0,}[ ]{0,1}["″]';
//"\b[a-zA-Z0-9]{1,}--[a-zA-Z0-9]{1,}\b";
//"\b[a-zA-Z]{1,}'[a-zA-Z]{1,}\b";

$seek = explode($nl, $seekStr);
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Word List: Seek (return matches)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$filesList = file_get_contents('wordlist/_scannedFiles.txt');
						$scannedFiles = explode($nl, $filesList);
						
						$start = date('Y.m.d.H.i');
						
						$masterList = array();
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator($dir) as $fn) {
							if (preg_match('/.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								
								if(in_array($fn_t['file'], $scannedFiles)) {
									echo '<p>'.$fn_t['file'].' has previously been scanned.</p>';
								} else {
								
									$fn_t['volNum'] = volFromFile($fn_t['file']);
									$fn_t['issueNum'] = substr($fn_t['file'], 5);
									$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
									$fn_t['newVolIss'] = $fn_t['volNum'].'.'.$fn_t['issueNum'];
								
									$fn_t['text'] = file_get_contents($dir.$fn_t['fn']);
									$fn_t['text'] = html_entity_decode($fn_t['text']);
								
									mb_regex_encoding('UTF-8');
									mb_internal_encoding("UTF-8");
									
									foreach($seek as $keyword) {
										if(preg_match('/'.$keyword.'/', $fn_t['text'])) 
										{
											preg_match('/'.$keyword.'/', $fn_t['text'], $matches);
											//mb_ereg_match('.*'.$keyword.'', $fn_t['text']);
											$matchStr = implode('|', $matches);
											echo '<h4>'.$fn_t['fn'].' contains: '.$matchStr.'</h4>';
											// indicate file in which it appears
											$masterList[] = '['.$fn_t['file'].'] '.$matchStr;
										} else {
											// if does not contain keyword
											echo '<p>'.$fn_t['fn'].' does not contain: '.$keyword.'</p>';
										}
								
										sort($masterList);
																
										$listStr = implode($nl, $masterList);
										file_put_contents('wordlist/_seek-'.$start.'.txt', $listStr);
								
										//echo '<h4>'.$fn_t['fn'].'</h4>';
									}
										
									$scannedFiles[] = $fn_t['file'];
									$filesStr = implode($nl, $scannedFiles);
									file_put_contents('wordlist/_scannedFiles.txt', $filesStr);

								}						
							}	
						}
												
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

