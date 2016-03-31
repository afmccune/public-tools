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
							<h1>Word List: Combine lists with counts of each word (filtered)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$start = date('Y.m.d.H.i');
						
						$romanList = array();
						$nonRomanList = array();
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("wordlist/") as $fn) {
							if (preg_match('/_count-roman/', $fn->getFilename())) {
								$wordsHere = file_get_contents('wordlist/'.$fn->getFilename());
								$wordlist = explode($nl, $wordsHere);
							
									$romanList = array_merge($romanList, $wordlist);
									$romanList = array_unique($romanList);
									sort($romanList);
								
									$listStr = implode($nl, $romanList);
									file_put_contents('wordlist/_count-roman-combined-'.$start.'.txt', $listStr);
								
									echo '<h4>'.$fn->getFilename().'</h4>';
					
							} else if (preg_match('/_count-nonroman/', $fn->getFilename())) {
								$wordsHere = file_get_contents('wordlist/'.$fn->getFilename());
								$wordlist = explode($nl, $wordsHere);
							
									$nonRomanList = array_merge($nonRomanList, $wordlist);
									$nonRomanList = array_unique($nonRomanList);
									sort($nonRomanList);
								
									$listStr = implode($nl, $nonRomanList);
									file_put_contents('wordlist/_count-nonroman-combined-'.$start.'.txt', $listStr);
								
									echo '<h4>'.$fn->getFilename().'</h4>';
					
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

