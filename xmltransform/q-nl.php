<!DOCTYPE html>
<html>
<?php
require('../include.php');
require('include/functions.php');
	
$nl = "
";

$replace = array();
/*
$replace['[\r\n]{1,}([	 ]{0,})([a-zA-Z0-9-⅛¼½¾⅞ —‘’“”"£:&;,!\?\(\)\[\]\/\.<>]{1,})<q>'] = $nl.'$1$2'.$nl.'$1<q>';
$replace['[\r\n]{1,}[ ]{1,7}<q>'] = $nl.'	<q>';
$replace['[\r\n]{1,}[ ]{8,11}<q>'] = $nl.'		<q>';
$replace['[\r\n]{1,}[ ]{12,15}<q>'] = $nl.'			<q>';
$replace['[\r\n]{1,}[ ]{16,19}<q>'] = $nl.'				<q>';
$replace['[\r\n]{1,}[ ]{20,23}<q>'] = $nl.'					<q>';
$replace['[\r\n]{1,}[ ]{24,27}<q>'] = $nl.'						<q>';
$replace['[\r\n]{1,}[ ]{1,7}<\/q>'] = $nl.'	</q>';
$replace['[\r\n]{1,}[ ]{8,11}<\/q>'] = $nl.'		</q>';
$replace['[\r\n]{1,}[ ]{12,15}<\/q>'] = $nl.'			</q>';
$replace['[\r\n]{1,}[ ]{16,19}<\/q>'] = $nl.'				</q>';
$replace['[\r\n]{1,}[ ]{20,23}<\/q>'] = $nl.'					</q>';
$replace['[\r\n]{1,}[ ]{24,27}<\/q>'] = $nl.'						</q>';
$replace[' <q>'] = $nl.'<q>';
$replace['[\r\n]{1,}<q>'] = $nl.'<q>';
$replace['[\r\n]{1,}([	]{0,})<\/q> '] = $nl.'$1</q>'.$nl.'$1';
$replace['<\/q> '] = '</q>'.$nl;
$replace['<\/q>[\r\n]{1,}'] = '</q>'.$nl;
$replace['[\r\n]{1,}[ ]{1,}[\r\n]{1,}'] = $nl;
*/
//$replace['<q>(.*)([\r\n]{1,}[	 ]{0,})<note (.*)<\/note>(.*)<\/q>'] = '<q>$1$4</q>$2<note $3</note>';

$replaceRepeat1 = array();
$replaceRepeat1['(<q>.*<lb\/>.*)([\r\n]{1,}[	 ]{0,}<note .*<\/note>)([\r\n	 a-zA-Z0-9-⅛¼½¾⅞—‘’“”"£:&;,!\?\(\)\[\]\/\.]{0,}<\/q>)'] = '$1$3$2';
$replaceRepeat1['<q>(.*)[\r\n]{1,}(.*)<lb\/>(.*)<\/q>'] = '<q>$1 $2<lb/>$3</q>';
$replaceRepeat1['<q>(.*)<lb\/>(.*)[\r\n]{1,}(.*)<\/q>'] = '<q>$1<lb/>$2 $3</q>';

$replaceRepeat2 = array();
//$replaceRepeat2['<q>(.*)<lb\/>(.*)<\/q>'] = '<q>$1<lb/>'.$nl.'$2</q>';
$replaceRepeat2['<q>(.*)<lb\/>(.*)<\/q>'] = '<q>$1<lb/>'.$nl.'$2<lb/></q>'; // for some perverse reason this breaks without the second line break; fixed below
$replaceRepeat2['<q>(.*)<lb\/>[\r\n]{1,}(.*)<\/q>'] = '<q>$1<lb/>'.$nl.'$2</q>';

$replace2 = array();
$replace2['<q>[\r\n]{0,}(.*<lb\/>)'] = '<q>'.$nl.'$1';
$replace2['[ ]{0,}<[<lb\/> \r\n]{4,}<\/q>'] = $nl.'</q>';
$replace2['([\r\n])([ 	]{1,})([a-zA-Z].*)[\r\n]{1,]<\/q>'] = '$1$2$3'.$nl.'$2</q>';
$replace2['<lb\/>[\r\n]{1,} ([a-zA-Z0-9-⅛¼½¾⅞—‘’“”"£:&;,!\?\(\)\[\]\/\.<>])'] = '<lb/>'.$nl.'$1';

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Replace)</h1>
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
							
							/*
							$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							//$fn_t['fileSplit'] = $fileParts[2];
							*/

							$XMLstring = file_get_contents($dir.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/s", "".$value."", $XMLstringNew);
							}
							
							for($i=0; $i<20; $i++) {
								foreach($replaceRepeat1 as $key => $value) {
									$XMLstringNew = preg_replace("/".$key."/s", "".$value."", $XMLstringNew);
								}
								foreach($replaceRepeat2 as $key => $value) {
									$XMLstringNew = preg_replace("/".$key."/s", "".$value."", $XMLstringNew);
								}
							}
							
							foreach($replace2 as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
							}
							
							if ($XMLstringNew == '') {
								echo '<p style="color: red;">'.$fn_t['fn'].': ERROR (blank)</p>';
							} else if($XMLstring !== $XMLstringNew) {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
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

