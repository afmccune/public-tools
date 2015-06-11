<!DOCTYPE html>
<html>
<?php
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
												
						foreach (new DirectoryIterator("../../bq/html/") as $fn) {
							//if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
							if (preg_match('/45.1.bentley.html/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
													
								//$HTMLstring = file_get_contents('../bq/html/'.$fn_t['fn']);
								
								$FullHTML = file_get_html('../../bq/html/'.$fn_t['fn']);
								$FullHTML->find('div[id=custFooter]', 0)->innertext = '';
								
								echo $FullHTML->plaintext;
								
								//$date = '';
								/*
								if($fn_t['volIss'] != $previousVolIss) {
									//echo '<h4>'.$fn_t['volIss'].'</h4>';
									$previousVolIss = $fn_t['volIss'];
								}
								
								if (getHtmlElementArray($FullHTML, 'div[id=content] a', 'href')) {
									$HTMLlinks = getHtmlElementArray($FullHTML, 'div[id=content] a', 'href');
									foreach($HTMLlinks as $link) {
										if(preg_match('/http:\/\/blake.lib.rochester.edu\/blakeojs/i', $link)) {
											//$link = str_replace('http://blake.lib.rochester.edu/blakeojs', '', $link);
											//echo '<p>'.$fn_t['file'].': '.$link.'</p>';
											if(isset($allLinks[$link]) && count($allLinks[$link]['articles']) > 0) {
												$allLinks[$link]['articles'][] = $fn_t['file'];
											} else {
												$allLinks[$link] = array();
												$allLinks[$link]['link'] = $link;
												$allLinks[$link]['articles'] = array();
												$allLinks[$link]['articles'][] = $fn_t['file'];
											}
										}
									}
								} else {
									print '<p>'.$fn_t['file'].' contains no "div[id=content] a".</p>';
								}
								*/
								
							}	
						}
						
						usort($allLinks, 'linkCmp');
						
						foreach ($allLinks as $l) {
							print '<h4><a href="'.$l['link'].'">'.$l['link'].'</a></h4>';
							print '<p>';
							foreach($l['articles'] as $article) {
								print '<a href="/bq/'.$article.'">'.$article.'</a>, ';
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

