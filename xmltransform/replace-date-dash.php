<!DOCTYPE html>
<html>
<?php
require('../include.php');
require('include/functions.php');
	
$nl = "
";
$day = '([0-3]{0,1}[0-9]{1,2})';
$month = '(Jan\.|January|Feb\.|February|Mar\.|March|Apr\.|April|May|Jun\.|June|Jul\.|July|Aug\.|August|Sep\.|Sept\.|September|Oct\.|October|Nov\.|November|Dec\.|December)';
$year = '(1[0-9]{3})';
$sp = '([ 	'.$nl.']{0,})';
$dm = $day.$sp.$month;
$dmy = $day.$sp.$month.$sp.$year;

$replace = array();
$replace[$dmy.$sp.'—'.$sp.$dmy] = '$1$2$3$4$5$6–$7$8$9$10$11$12';
$replace[$dm.$sp.'—'.$sp.$dm] = '$1$2$3$4–$5$6$7$8';
$replace[$month.$sp.'—'.$sp.$month] = '$1$2–$3$4';
$replace[$year.$sp.'—'.$sp.$year] = '$1$2–$3$4';

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Replace M-Dash with N-Dash in date ranges)</h1>
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

							$XMLstring = file_get_contents($dir.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/U", "".$value."", $XMLstringNew);
							}
							
							if($XMLstring !== $XMLstringNew) {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else if ($XMLstringNew == '') {
								echo '<p>'.$fn_t['fn'].': converted string is empty.</p>';
							} else {
								echo '<p>'.$fn_t['fn'].': no change</p>';
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

