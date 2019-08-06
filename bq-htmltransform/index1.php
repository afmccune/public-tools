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
								
								$FullHTML = file_get_html('old/'.$fn_t['fn']);
									
								$FullHTML->find('body', 0)->id = $fn_t['file']; //http://simplehtmldom.sourceforge.net/
								$HTMLstring = (string)$FullHTML; //$FullHTML->saveHTML();
								$HTMLstring = str_replace('<', $nl.'<', $HTMLstring);
								file_put_contents('new/'.$fn_t['fn'], $HTMLstring); // DOMDocument::saveHTMLFile() - Dumps the internal document into a file using HTML formatting
									
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

