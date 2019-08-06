<!DOCTYPE html>
<html>
<?php
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
							<h1>HTML Transform</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/html/") as $fn) {
							if (preg_match('/[\.a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);
								
								$HTMLstring = file_get_contents('../../bq/html/'.$fn_t['fn']);
								
								if(preg_match('/<!-- Google Analytics -->/', $HTMLstring)) {
								
									$HTMLstring = preg_replace('/<!-- Google Analytics -->.+?<!-- \/Google Analytics -->/s', '', $HTMLstring);
								
									
									file_put_contents('new/'.$fn_t['file'].'.html', $HTMLstring);
									echo '<p>Converted '.$fn_t['fn'].'</p>';
									
								} else {
									echo '<p>'.$fn_t['fn'].': "< !-- Google Analytics -- >" not found.</p>';
									//echo '<pre>'.$HTMLstring.'</pre>';
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

