<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require('include/functions.php');
	
$nl = "
";

$seekStr = '104Observations
10Biographia
12Jerusalem
13Mysterium
14Reprints
15America
16Thel
17Blake
17Reprints
1Fearful
1See
1The
1f
1instead
20Winter
22Sporting
23Sporting
2Nor
31SHOE
32The
3Blake’s
3Erasmus
3Jerusalem
3Taken
3To
46Macbeth
4America
4Visions
5Feet
5Jerusalem
5Milton’s
5The
6America
6Blake
74Schuchard
8Jerusalem
9The
Alberich.9';

$seek = explode($nl, $seekStr);
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
										if(mb_ereg_match('.*\b'.$keyword.'\b', $fn_t['text'])) {
											echo '<h4>'.$fn_t['fn'].' contains: '.$keyword.'</h4>';
											// indicate file in which it appears
											$masterList[] = '['.$fn_t['file'].'] '.$keyword;
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

