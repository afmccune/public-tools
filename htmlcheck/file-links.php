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
							<h1>HTML Check (File Links)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						foreach (new DirectoryIterator($dir) as $fn) {
							if (preg_match('/[.a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
								$fn_t['split'] = $fileParts[2];
													
								
								$FullHTML = file_get_html($dir.$fn_t['fn']);
								$FullHTML->find('div[id=custFooter]', 0)->innertext = '';
								
								
								if ($fn_t['split'] != 'toc' && getHtmlElementArray($FullHTML, 'div[id=content] a', 'href')) {
									$HTMLlinks = getHtmlElementArray($FullHTML, 'div[id=content] a', 'href');
									foreach($HTMLlinks as $link) {
										if(preg_match('/http:\/\/blake.lib.rochester.edu\/blakeojs\/index.php\/blake\/article\/viewFile\//i', $link)) {
											$shortlink = str_replace('http://blake.lib.rochester.edu/blakeojs/index.php/blake/article/viewFile/', '', $link);
											//echo '<p>'.$fn_t['file'].': <a href="'.$link.'">'.$shortlink.'</a></p>';
											$source = 'http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewFile/'.$shortlink;
											echo '<p>';
											echo '<a href="'.$url.$fn_t['file'].'">'.$fn_t['file'].'</a>: <a href="'.$source.'">'.$shortlink.'</a> ';
											
											// Check if images are there
											$linkParts = explode('/', $shortlink);
											$volume = substr($linkParts[1], -7, 2);
											$issue = substr($linkParts[1], -5, 1);
											$file = $linkParts[2];
											
											if(file_exists($illustrationDir.$volume.'.'.$issue.'/'.$file.'.jpg')) {
												echo '(in archive: <a href="'.$illustrationDir.$volume.'.'.$issue.'/'.$file.'.jpg">'.$volume.'.'.$issue.'/'.$file.'.jpg</a>)';
											} else {
												echo '(error: '.$volume.'.'.$issue.'/'.$file.'.jpg not downloaded to archive)';
											}
											
											echo '</p>';

											/*
											// Download images -- note: at least off campus, this downloads login pages rather than images
											$linkParts = explode('/', $shortlink);
											$volume = substr($linkParts[1], -7, 2);
											$issue = substr($linkParts[1], -5, 1);
											$file = $linkParts[2];
											
											if(!file_exists('files/'.$volume.'.'.$issue)) {
												mkdir ('files/'.$volume.'.'.$issue);
											}
											if(!file_exists('files/'.$volume.'.'.$issue.'/'.$file.'.jpg')) {
												copy($source, 'files/'.$volume.'.'.$issue.'/'.$file.'.jpg');
											}
											*/
										}
									}
								} else if ($fn_t['split'] == 'toc') {
								} else {
									//print '<p>'.$fn_t['file'].' contains no "div[id=content] a".</p>';
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

