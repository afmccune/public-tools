<!DOCTYPE html>
<html>
<?php
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
						
						$compositeText = '';
						
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
								
								$XMLtocFile = $fn_t['newVolIss'].'.toc';

								$compositeText .= simplexml_load_file('../../bq/docs/'.$fn_t['fn']);
								
								echo '<p>'.$fn_t['fn'].' added to composite.</p>';
																
							}	
						}


						//file_put_contents('composite/_all.xml', $compositeText);
						
						$allWords = explode(' ', $compositeText);
						//$allWordsUnique = array_unique($allWords);
						
						print '<pre>';
						print_r($allWords);
						print '</pre>';
						
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

