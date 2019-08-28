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
							<h1>XML Check (figure/@id vs. figure/@work-copy)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator($dir) as $fn) {
						if (preg_match('/.xml/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
							
							$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							//$fn_t['fileSplit'] = $fileParts[2];

							$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
							$fn_t['work-copy'] = $FullXML->xpath('//text//figure/@work-copy'); // array
							$fn_t['id'] = $FullXML->xpath('//text//figure/@id'); // array
							
							$missingWorkCopies = count($fn_t['id']) - count($fn_t['work-copy']);

							if($missingWorkCopies > 0) {
								echo '<h4>Error: '.$fn_t['fn'].' missing '.$missingWorkCopies.' work-copies.</h4>';
							} else {
								echo '<p>'.$fn_t['fn'].' has the right number of work-copies.</h4>';
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

