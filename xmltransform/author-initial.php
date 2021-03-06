<!DOCTYPE html>
<html>
<?php
require('include/functions.php');

$dir = ''; // enter directory path
	
$nl = "
";

$replace = array();
$replace['<author n="([a-zA-Zö ]{1,})">([a-zA-Z ]\.)([a-zA-Z ]\. [a-zA-Zö \.,]{1,})<\/author>'] = '<author n="$1">$2 $3</author>';
$replace['<author n="([a-zA-Zö ]{1,})">([a-zA-Z ]\.)([a-zA-Z ]\.)([a-zA-Z ]\. [a-zA-Zö \.,]{1,})<\/author>'] = '<author n="$1">$2 $3 $4</author>';


?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (metadata author tags: space between initials)</h1>
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
								$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
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

