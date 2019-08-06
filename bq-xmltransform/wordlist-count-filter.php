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
							<h1>Word List with Counted Instances: filter by type of characters</h1>
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
						
						$romanList = array(); // for keywords with only Roman characters
						$nonRomanList = array(); // for keywords with non-Roman characters
						
						foreach (new DirectoryIterator("wordlist/") as $fn) {
							if (preg_match('/_count-combined/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();									
								
								$fn_t['text'] = file_get_contents('wordlist/'.$fn_t['fn']);
								$seek = explode($nl, $fn_t['text']);
							}
						}
						
						foreach($seek as $keyword) {
							if(in_array($keyword, $countedWords)) {
								echo '<p>'.$keyword.' has previously been processed.</p>';
							} else {
								if(preg_match('/^\[[0-9]{9}\] [a-zA-Z’\.]+$/', $keyword)) { // if bracketed 9-digit number followed by all Roman characters
									echo '<h4>'.$keyword.': Roman</h4>';
									$romanList[] = $keyword;
					
									$listStr = implode($nl, $romanList);
									file_put_contents('wordlist/_count-roman-'.$start.'.txt', $listStr);
					
									$countedWords[] = $keyword;
									$wordsStr = implode($nl, $countedWords);
									file_put_contents('wordlist/_countedWords.txt', $wordsStr);
								} else { // if some non-Roman
									echo '<h4>'.$keyword.': non-Roman</h4>';
									$nonRomanList[] = $keyword;
					
									$listStr = implode($nl, $nonRomanList);
									file_put_contents('wordlist/_count-nonroman-'.$start.'.txt', $listStr);
					
									$countedWords[] = $keyword;
									$wordsStr = implode($nl, $countedWords);
									file_put_contents('wordlist/_countedWords.txt', $wordsStr);
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

