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
							<h1>XML Diff Guide (compare files in old and new folders)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../xmltransform/new/") as $fn) {
							if (preg_match('/(.xml|.txt)/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								//$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								
								echo '<p><a target="_blank" href="old-new-diff.php?file='.$fn_t['fn'].'">'.$fn_t['fn'].'</a></p>';
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

