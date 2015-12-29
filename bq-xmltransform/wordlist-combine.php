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
							<h1>Word List: Combine</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$start = date('Y.m.d.H.i');
						
						$masterList = array();
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("wordlist/") as $fn) {
							if (preg_match('/_wordlist/', $fn->getFilename())) {
								$wordsHere = file_get_contents('wordlist/'.$fn->getFilename());
								$wordlist = explode($nl, $wordsHere);
							
									$masterList = array_merge($masterList, $wordlist);
									$masterList = array_unique($masterList);
								
									$listStr = implode($nl, $masterList);
									file_put_contents('wordlist/_wordlist-combined-'.$start.'.txt', $listStr);
								
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

