<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";

$replace = array();
$replace['([\r\n])[ 	]{0,}<idno>([0-9a-zA-Z\.]{1,})</idno>([\r\n]{0,})([ 	]{0,})<fileDesc>'] = '$1$4<idno>$2</idno>$3$4<fileDesc>';
$replace['([\r\n])([ 	]{0,})<title>([ a-zA-Z/]{1,})</title>([\r\n]{0,})[ 	]{0,}<biblScope'] = '$1$2<title>$3</title>$4$2<biblScope';
$replace['([\r\n])([ 	]{0,})<biblScope unit="volIss">([0-9\.]{1,})</biblScope>([\r\n]{0,})[ 	]{0,}<biblScope'] = '$1$2<biblScope unit="volIss">$3</biblScope>$4$2<biblScope';
$replace['([\r\n])([ 	]{0,})<biblScope unit="volume">([0-9\.]{1,})</biblScope>([\r\n]{0,})[ 	]{0,}<biblScope'] = '$1$2<biblScope unit="volume">$3</biblScope>$4$2<biblScope';

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
					foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

							$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
							}
							
							if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else if ($XMLstringNew == '') {
								echo '<p style="color: red;">ERROR: transformed '.$fn_t['fn'].' is blank.</p>';
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

