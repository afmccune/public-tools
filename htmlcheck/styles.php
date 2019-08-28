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
							<h1>HTML Styles</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						foreach (new DirectoryIterator($dir) as $fn) {
							if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
								$fn_t['fileSplit'] = $fileParts[2];
													
								$FullHTML = file_get_html($dir.$fn_t['fn']);

								$HTMLstyle = getHtmlElementArray($FullHTML, 'style', 'innertext');
								$styles = htmlentities(implode(' ', $HTMLstyle));
								
								echo '<h4><a href="'.$url.$fn_t['file'].'">'.$fn_t['file'].'</a></h4>';
								echo '<pre>'.$styles.'</pre>';
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

