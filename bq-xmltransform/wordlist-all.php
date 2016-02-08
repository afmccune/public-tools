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
						$filesList = file_get_contents('wordlist/_scannedFiles.txt');
						$scannedFiles = explode($nl, $filesList);
						
						$start = date('Y.m.d.H.i');
						
						$masterList = array();
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
							if (preg_match('/.xml/', $fn->getFilename()) && !preg_match('/Emend/', $fn->getFilename())) {
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
								
									$fn_t['text'] = file_get_contents('../../bq/docs/'.$fn_t['fn']);
									$fn_t['text'] = strip_tags($fn_t['text']);
									$fn_t['text'] = html_entity_decode($fn_t['text']);
								
									mb_regex_encoding('UTF-8');
									mb_internal_encoding("UTF-8");
								
									// All delimiters (newline, tab, mdash, hyphen, space) are now space
									$fn_t['text'] = mb_ereg_replace('[\s—-]+', ' ', $fn_t['text']);
									$fn_t['text'] = ' '.$fn_t['text'].' ';
									// Strip punctuation from beginnings of words (after space) and/or from ends of words (before space)
									$fn_t['text'] = str_replace(' "', ' ', $fn_t['text']);
									$fn_t['text'] = str_replace('" ', ' ', $fn_t['text']);
									$fn_t['text'] = mb_ereg_replace("[†\|,!\.\?;:’'”\)\]\*\} ]{0,} [†\|\{#\$£§\*\[\(“'‘ ]{0,}", ' ', $fn_t['text']);
									$fn_t['text'] = str_replace(' "', ' ', $fn_t['text']);
									$fn_t['text'] = str_replace('" ', ' ', $fn_t['text']);
									// Remove "words" that consist only of numbers and symbols
									$fn_t['text'] = mb_ereg_replace(" [\$¢£¥€0-9⅛⅙⅕¼⅖⅜⅓½⅝¾⅞\*\{\[\(“'‘,!\.\?;:’'”\)\]\}#\+&\/%:°;§©×•∞–−\-′″‴=<>·º\|_¶ ]{1,} ", ' ', $fn_t['text']);
									
									// Split into array and make unique
									$fn_t['wordlist'] = explode(' ', $fn_t['text']);
									$fn_t['wordlist'] = array_unique($fn_t['wordlist']);
								
									// Join to master list
									$masterList = array_merge($masterList, $fn_t['wordlist']);
									$masterList = array_unique($masterList);
									sort($masterList);
								
									// Store list in file								
									$listStr = implode($nl, $masterList);
									file_put_contents('wordlist/_wordlist-'.$start.'.txt', $listStr);
								
									echo '<h4>'.$fn_t['fn'].'</h4>';
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

