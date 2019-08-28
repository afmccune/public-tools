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
							<h1>HTML Check (Image Src)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
												
						foreach (new DirectoryIterator($htmlDir) as $fn) {
							if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = ($fileParts[0] == 'bonus') ? 'bonus' : $fileParts[0].'.'.$fileParts[1];
								$fn_t['volume'] = $fileParts[0];
								$fn_t['issue'] = $fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
								$fn_t['split'] = $fileParts[2];
													
								
								$FullHTML = file_get_html($htmlDir.$fn_t['fn']);
								$FullHTML->find('div[id=custFooter]', 0)->innertext = '';
								
								
								if (getHtmlElementArray($FullHTML, 'div[id=content] img', 'src')) {
									$HTMLsrcs = getHtmlElementArray($FullHTML, 'div[id=content] img', 'src');
									
									$ignore = array('UofR.gif', 'fulltext_open_medium.gif', 'fulltext_restricted_medium.gif');
									
									foreach($HTMLsrcs as $src) {
											$src = (strpos($src, '.jpg') || strpos($src, '.JPG') || strpos($src, '.png') || strpos($src, '.jpeg') || strpos($src, '.gif')) ? $src : $src.'.jpg';
										
											echo '<p>';
											echo '<a href="'.$url.$fn_t['file'].'">'.$fn_t['file'].'</a>: ';
											
											if(in_array($src, $ignore)) {
												echo '(ignore)';
											} else if(file_exists($illustrationDir.$fn_t['volIss'].'/'.$src)) {
												echo '(in archive: <a href="'.$illustrationDir.$fn_t['volIss'].'/'.$src.'">'.$fn_t['volume'].'.'.$fn_t['issue'].'/'.$src.'</a>)';
											} else {
												echo '('.$fn_t['volIss'].'/'.$src.' not downloaded locally)';
											}
											
											echo '</p>';

										
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

