<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require('../../include.php');
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
							<h1>Word List (non-Roman)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$filesList = file_get_contents('wordlist/_scannedFilesNonRoman.txt');
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
									$fn_t['text'] = strip_tags($fn_t['text']);
									$fn_t['text'] = html_entity_decode($fn_t['text']);
								
									mb_regex_encoding('UTF-8');
									mb_internal_encoding("UTF-8");
								
									$fn_t['wordlist'] = mb_split('[\s—]+', $fn_t['text']);
									$fn_t['wordlist'] = array_unique($fn_t['wordlist']);
								
									for($i=0; $i<count($fn_t['wordlist']); $i++) {
										if(preg_match('/[a-zA-Z]/', $fn_t['wordlist'][$i])) {
											// if contains Roman letters, it's in the other wordlist already
											$fn_t['wordlist'][$i] = '';
										} else {
											// if contains no Roman letters, strip punctuation off beginning and end
											$fn_t['wordlist'][$i] = str_replace('"', '', $fn_t['wordlist'][$i]);
											$fn_t['wordlist'][$i] = mb_ereg_replace("^[\*\[\(“'‘]{1,}", '', $fn_t['wordlist'][$i]);
											$fn_t['wordlist'][$i] = mb_ereg_replace("[,!\.\?;:’'”\)\]\*]{1,}$", '', $fn_t['wordlist'][$i]);
											// get rid of whatever is only numbers, punctuation, and currency symbols
											$fn_t['wordlist'][$i] = mb_ereg_replace("^[\$¢£¥€0-9⅛⅙⅕¼⅖⅜⅓½⅝¾⅞\*\{\[\(“'‘,!\.\?;:’'”\)\]\}#\+&\/%:°;§©×•∞–−\-′″‴=<>·º\|_¶]{1,}$", '', $fn_t['wordlist'][$i]);
										}
									}
								
									$masterList = array_merge($masterList, $fn_t['wordlist']);
									$masterList = array_unique($masterList);
									sort($masterList);

									$listStr = implode($nl, $masterList);
									file_put_contents('wordlist/_wordlist-nonroman-'.$start.'.txt', $listStr);
								
									echo '<h4>'.$fn_t['fn'].'</h4>';
									$scannedFiles[] = $fn_t['file'];
									$filesStr = implode($nl, $scannedFiles);
									file_put_contents('wordlist/_scannedFilesNonRoman.txt', $filesStr);

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

