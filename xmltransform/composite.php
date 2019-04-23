<!DOCTYPE html>
<html>
<?php
require('../include.php');
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
							<h1>XML Diff Guide</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator($dir) as $fn) {
							if (preg_match('/[0-9]{3}-[0-9]{2}[-a-z0-9]*.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								$fn_t['volNum'] = volFromFile($fn_t['file']);
								$fn_t['issueNum'] = substr($fn_t['file'], 5);
								$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
								$fn_t['newVolIss'] = $fn_t['volNum'].'.'.$fn_t['issueNum'];
								
								$XMLtocFile = $fn_t['newVolIss'].'.toc';

								$XMLtoc = simplexml_load_file($dir.$XMLtocFile.'.xml');
								$articles = $XMLtoc->xpath('//table//ref/@issue');
								$fn_t['articles'] = array_merge(array($XMLtocFile), $articles);
								
								$compositeText = '';
								
								echo '<h4>'.$fn_t['file'].'</h4>';
								foreach($fn_t['articles'] as $article) {
									if(substr($article,0,strlen($fn_t['newVolIss'])) == $fn_t['newVolIss']) {
										# LOAD XML FILE 
										$XML = new DOMDocument(); 
										$XMLstring = file_get_contents($dir.$article.'.xml');
										//$XMLstring = str_replace($nl, "\r", $XMLstring);
										$XML->loadXML($XMLstring);

										# START XSLT 
										$xslt = new XSLTProcessor(); 
										$XSL = new DOMDocument(); 
										$XSL->load( 'xsl/composite.xsl'); // This should remove teiHeader from all but the TOC
										$xslt->importStylesheet( $XSL ); 
										
										# ADD TO COMPOSITE 
										$compositeText .= $xslt->transformToXML( $XML );

										echo '<p>'.$article.' processed.</p>';
										
									} else {
										//echo '<p>Excluded: '.$article.'</p>';
									}
								}
								
								file_put_contents('composite/'.$fn_t['file'].'-composite.xml', $compositeText);

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

