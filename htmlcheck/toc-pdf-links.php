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
							<h1>HTML Check (TOC PDF Links)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
												
						foreach (new DirectoryIterator($htmlDir) as $fn) {
							if (preg_match('/toc.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = ($fileParts[0] == 'bonus') ? 'bonus' : $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
								$fn_t['split'] = $fileParts[2];
								
								echo '<h4>'.$fn_t['file'].'</h4>';
								
								# LOAD HTML FILE 
								$HTML = file_get_html($htmlDir.$fn_t['fn']);
								$xpath = 'div[id=artInfo]'; //(count(getHtmlElementArray($HTML, 'div[id=articlecontent]', 'outertext'))>0) ? 'div[id=articlecontent]' : 'div[id=content]';
								$HTMLbody = getHtmlElementArray($HTML, $xpath, 'outertext');
								$HTMLstring = $HTMLbody[0];
								$HTMLstring = str_replace('<div id="artInfo">', '<div id="artInfo"><div id="idno">'.$fn_t['volIss'].'</div>', $HTMLstring); // for toc
								//$HTMLstring = str_replace('<div id="articlecontent">', '<div id="articlecontent"><div id="idno">'.$fn_t['volIss'].'</div>', $HTMLstring); // for articles
								//$HTMLstring = str_replace('<div id="content">', '<div id="content"><div id="idno">'.$fn_t['volIss'].'</div>', $HTMLstring); // for other articles
								$HTMLdoc = DOMDocument::loadHTML ($HTMLstring);							
								# START XSLT 
								$xslt = new XSLTProcessor(); 
								$XSL = new DOMDocument();
								$XSL->load('xsl/htmlToc.xsl'); 
								$xslt->importStylesheet( $XSL ); 
								# TRANSFORM
								$transformed = $xslt->transformToXML( $HTMLdoc ); 


								$FullHTML = str_get_html($transformed);
								
								if (getHtmlElementArray($FullHTML, 'div[id=artInfo] a', 'href')) {
									$HTMLlinks = getHtmlElementArray($FullHTML, 'div[id=artInfo] a', 'href');
									if(count($HTMLlinks) < 1) {
										echo '<p>'.$fn_t['file'].' contains no PDF links.</p>';
									} 
									foreach($HTMLlinks as $link) {
										if(preg_match('/pdf/i', $link)) {
											echo '<p>';
											echo '<a href="'.$url.$fn_t['file'].'">'.$fn_t['file'].'</a>: <a href="'.$link.'">'.$link.'</a> ';
											
											// Check if files are there
											
											if(file_exists($mainDir.$link)) {
												echo '(in archive: <a href="'.$url.$link.'.pdf">'.$link.'</a>)';
											} else {
												echo '('.$link.' not downloaded locally)';
											}
											
											echo '</p>';

										}
									}
								} else {
									print '<p>'.$fn_t['file'].' contains no "div[id=artInfo] a".</p>';
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

