<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require('include/functions.php');
	
$nl = "
";

$seek = array();
$seek[] = 'cavernl';
/*
$seek[] = '16“further';
$seek[] = '2008])(“These';
$seek[] = '40“Denen';
$seek[] = '46“Ryusei';
$seek[] = 'Albion”[';
$seek[] = 'Amateur.”13';
$seek[] = 'Argument”’s';
$seek[] = 'Arte”/4';
$seek[] = 'B.§”Four';
$seek[] = 'Blake”s';
$seek[] = 'Christiana”(';			
$seek[] = 'Employer”in';			
$seek[] = 'E”s';			
$seek[] = 'Fate”(';			
$seek[] = 'G”s';			
$seek[] = 'HC“';			
$seek[] = 'Holdgate.”1';			
$seek[] = 'Introduction,”“The';			
$seek[] = 'Lamb’”s';			
$seek[] = 'Life”(3';			
$seek[] = 'Los”[';			
$seek[] = 'Luvah”(';			
$seek[] = 'Mutton.”35';			
$seek[] = 'Peace”5';			
$seek[] = 'Sexuality”of';			
$seek[] = 'Sweeper”s';			
$seek[] = 'Thel”[';			
$seek[] = 'Thursday”s';			
$seek[] = 'VIIb.“';			
$seek[] = 'William”(';			
$seek[] = 'all”(22';			
$seek[] = 'annihilation.”“Void';			
$seek[] = 'barbarism”[128';			
$seek[] = 'boards”(';			
$seek[] = 'cloth”(';			
$seek[] = 'commitments”(15';			
$seek[] = 'culture:“he';			
$seek[] = 'delay”(PL';			
$seek[] = 'do.’”11';			
$seek[] = 'd’”s';			
$seek[] = 'd”s';			
$seek[] = 'edition”(';			
$seek[] = 'enimy.”51';			
$seek[] = 'equalled.”6';			
$seek[] = 'flowers”(3.12';			
$seek[] = 'folio”(';			
$seek[] = 'form”(The';			
$seek[] = 'g”s';			
$seek[] = 'history.“';			
$seek[] = 'his“[E';			
$seek[] = 'h”s';			
$seek[] = 'if“Harmitage';			
$seek[] = 'improvement”(as';			
$seek[] = 'i”s';			
$seek[] = 'make.”4';			
$seek[] = 'matches,”“m/';			
$seek[] = 'misunderstood.”30';			
$seek[] = 'mythology”(94';			
$seek[] = 'neologisms.”16';			
$seek[] = 'of‘Four';			
$seek[] = 'of“Pity';			
$seek[] = 'of“female';			
$seek[] = 'original”(';			
$seek[] = 'own.”43';			
$seek[] = 'pleasant”(';			
$seek[] = 'processes”(262';			
$seek[] = 'profession.”10';			
$seek[] = 'region.”9';			
$seek[] = 'say,”29';			
$seek[] = 'sense,”“empiricism,”“practice';			
$seek[] = 'spring”(p';			
$seek[] = 'term[“Finishd';			
$seek[] = 'them.”12';			
$seek[] = 'thought.”17';			
$seek[] = 'utmost”(';			
$seek[] = 'v’”s';			
$seek[] = 'woman:“.H';			
$seek[] = 'works.”35';			
$seek[] = 'wound.”14';			
$seek[] = '§”Mythology';			
$seek[] = 'utmost”(';	
*/		
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Word List: Seek</h1>
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
								
									$fn_t['text'] = file_get_contents('../../bq/docs/'.$fn_t['fn']);
									$fn_t['text'] = strip_tags($fn_t['text']);
									$fn_t['text'] = html_entity_decode($fn_t['text']);
								
									mb_regex_encoding('UTF-8');
									mb_internal_encoding("UTF-8");
									
									foreach($seek as $keyword) {
										if(mb_ereg_match('.*'.$keyword, $fn_t['text'])) {
											echo '<h4>'.$fn_t['fn'].' contains: '.$keyword.'</h4>';
											// indicate file in which it appears
											$masterList[] = '['.$fn_t['file'].'] '.$keyword;
										} else {
											// if does not contain keyword
											echo '<p>'.$fn_t['fn'].' does not contain: '.$keyword.'</p>';
										}
								
										sort($masterList);
																
										$listStr = implode($nl, $masterList);
										file_put_contents('wordlist/_wordlist-seek-'.$start.'.txt', $listStr);
								
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

