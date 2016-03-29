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
							<h1>Word List: Count Instances of Words</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$filesList = file_get_contents('wordlist/_countedWords.txt');
						$countedWords = explode($nl, $filesList);
						
						$start = date('Y.m.d.H.i');
						
						$seek = array(); // for keywords
						//$seek[] = 'the';
						
						$masterList = array(); // for keywords with counts
						
						foreach (new DirectoryIterator("wordlist/") as $fn) {
							if (preg_match('/_wordlist/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();									
								$fn_t['text'] = preg_quote(file_get_contents('wordlist/'.$fn_t['fn']));
								$fn_t['text'] = str_replace ('’', 'RSQUO', $fn_t['text']);
								
								$seek = explode($nl, $fn_t['text']);
							}
						}
						
						foreach (new DirectoryIterator("wordlist/") as $fn) {
							if (preg_match('/_huge-text/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();									
								$fn_t['text'] = file_get_contents('wordlist/'.$fn_t['fn']);
								$fn_t['text'] = str_replace ('’', 'RSQUO', $fn_t['text']);
								//$fn_t['text'] = html_entity_decode($fn_t['text']);
							
								mb_regex_encoding('UTF-8');
								mb_internal_encoding("UTF-8");
								
								foreach($seek as $keyword) {
									if(in_array($keyword, $countedWords)) {
										echo '<p>'.$keyword.' has previously been counted.</p>';
									} else {
										$count = preg_match_all('/\b'.$keyword.'\b/', $fn_t['text']);
										echo '<h4>'.$keyword.': '.$count.'</h4>';
										$formatted_count = sprintf("%'.09d", $count);
										$masterList[] = '['.$formatted_count.'] '.$keyword;
							
										sort($masterList);
															
										$listStr = implode($nl, $masterList);
										$listStr = str_replace ('RSQUO', '’', $listStr);
										$listStr = str_replace ('\\', '', $listStr);
										file_put_contents('wordlist/_count-'.$start.'.txt', $listStr);
							
										$countedWords[] = $keyword;
										$wordsStr = implode($nl, $countedWords);
										file_put_contents('wordlist/_countedWords.txt', $wordsStr);
									}
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

