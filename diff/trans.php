<!DOCTYPE html>
<html>
<?php
require('../../include.php');
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
							if (preg_match('/43.[1-4]{1}[-a-z0-9]*.[a-z]{1,20}.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								
								echo '<p><a target="_blank" href="trans-diff.php?file='.$fn_t['file'].'">'.$fn_t['file'].'</a></p>';
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

