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
						foreach (new DirectoryIterator("./old/") as $fn) {
							if (preg_match('/[-a-z0-9]*.html/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);
								
								$HTMLstring = file_get_contents('old/'.$fn_t['fn']);
								
								$FullHTMLold = file_get_html('old/'.$fn_t['fn']);
								
								$HTMLstring = str_replace('<="" div=""', '/', $HTMLstring);
								
									$srcs = getHtmlElementArray($FullHTMLold, 'img', 'src');
									foreach($srcs as $oldSrc) {
										$newSrc = (strpos($oldSrc, '/') !== false) ? substr($oldSrc, strrpos($oldSrc, '/') + 1) : $oldSrc;
										$HTMLstring = str_replace('src="'.$oldSrc.'"', 'src="'.$newSrc.'"', $HTMLstring);
									}
									
									file_put_contents('new/'.$fn_t['file'].'.html', $HTMLstring);
									echo '<p>Converted '.$fn_t['fn'].'</p>';
									
								
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

