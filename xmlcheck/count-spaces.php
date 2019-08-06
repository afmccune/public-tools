<!DOCTYPE html>
<html>
<?php

header("Content-Type: text/html; charset=utf-8");
ini_set("default_charset", 'utf-8');

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
							<h1>XML Check (count spaces)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$previousVolIss = '0.0';
												
						$docsHtml = array(); 
						foreach (new DirectoryIterator($dir) as $fn) {
							if (preg_match('/.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['fileSplit'] = $fileParts[2];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
													
								$XMLstring = file_get_contents($dir.$fn_t['fn']);
								$ct = substr_count($XMLstring, ' ');
								
								echo '<p>'.$fn_t['file'].':	'.$ct.'	spaces</p>';
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

