<!DOCTYPE html>
<html>
<?php
require('../include.php');
require('include/functions.php');

$nl = "
";


function linkCmp(array $a, array $b) {
				return strcmp($a['link'], $b['link']);
				}

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML Check (Internal Links)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$previousVolIss = '0.0';
						
						$allLinks = array();
												
						foreach (new DirectoryIterator($htmlDir) as $fn) {
							//if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
							if (preg_match('/45.1.bentley.html/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
													
								//$HTMLstring = file_get_contents($htmlDir.$fn_t['fn']);
								
								$FullHTML = file_get_html($htmlDir.$fn_t['fn']);
								$FullHTML->find('div[id=custFooter]', 0)->innertext = '';
								
								echo $FullHTML->plaintext;
								
								
							}	
						}
						
						usort($allLinks, 'linkCmp');
						
						foreach ($allLinks as $l) {
							print '<h4><a href="'.$l['link'].'">'.$l['link'].'</a></h4>';
							print '<p>';
							foreach($l['articles'] as $article) {
								print '<a href="'.$url.$article.'">'.$article.'</a>, ';
							}
							print '</p>';
						}
						
						//print '<pre>';
						//print_r($allLinks);
						//print '</pre>';
						
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

