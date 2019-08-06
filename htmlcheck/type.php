<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');

			function cmpType(array $a, array $b) {
				if (($cmp = strcmp($b['type'], $a['type'])) !== 0) {
					return $cmp;
				} else {
					return strcmp($a['file'], $b['file']);
				}
			}

$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML Types</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
												
						$docsHtml = array(); 
						foreach (new DirectoryIterator($htmlDir) as $fn) {
							if (preg_match('/.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[2];
													
								$HTMLstring = file_get_contents($htmlDir.$fn_t['fn']);
								
								$FullHTML = file_get_html($htmlDir.$fn_t['fn']);
								
								$HTMLtype = getHtmlElementArray($FullHTML, 'meta[name=DC.Type.articleType]', 'content');
								$fn_t['type'] = $HTMLtype[0];
								
								$docsHtml[] = $fn_t;
								
							}	
						}
						
						usort($docsHtml, 'cmpType');
						//usort($docsHtml, 'cmp');
						
						foreach($docsHtml as $doc) {
							echo '<p>'.$doc['type'].'</p>';
						}
						
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

