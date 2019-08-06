<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');
	
$nl = "
";

$replace = array();
$replace['[\r\n]{0,}([	 ]){1,}([“"\(\[]{0,})<([a-zA-Z]{1,})[\r\n]{1,}([ 	]{0,})([a-zA-Z0-9-:\/\.="]{1,})[ 	]{0,}>'] = "$1".$nl."$4$2<$3 $5>";
$replace['[\r\n]{0,}([	 ]){1,}([“"\(\[]{0,})<([a-zA-Z]{1,} [a-zA-Z0-9-:\/\.="]{1,})[\r\n]{1,}([ 	]{0,})>'] = "$1".$nl."$4$2<$3>";
$replace['[\r\n]([“"\(\[]{0,})<([a-zA-Z]{1,})[\r\n]{1,}([ 	]{0,})([a-zA-Z0-9-:\/\.="]{1,})[ 	]{0,}>'] = $nl."$3$1<$2 $4>";
$replace['[\r\n]([“"\(\[]{0,})<([a-zA-Z]{1,} [a-zA-Z0-9-:\/\.="]{1,})[\r\n]{1,}([ 	]{0,})>'] = $nl."$3$1<$2>";
$replace[' <([a-zA-Z]{1,})[\r\n	 ]{0,}([a-zA-Z0-9-:\/\.="]{1,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}><([a-zA-Z]{1,})[\r\n]{1,}([ 	]{0,})([a-zA-Z0-9-:\/\.="]{1,})[ 	]{0,}>'] = " ".$nl."$5<$1 $2 $3><$4 $6>";
$replace[' <([a-zA-Z]{1,})[\r\n	 ]{0,}([a-zA-Z0-9-:\/\.="]{1,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}><([a-zA-Z]{1,} [a-zA-Z0-9-:\/\.="]{1,})[\r\n]{1,}([ 	]{0,})>'] = " ".$nl."$5<$1 $2 $3><$4>";
$replace[' <([a-zA-Z]{1,})[\r\n]{1,}([ 	]{0,})([a-zA-Z0-9-:\/\.="]{1,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}>'] = " ".$nl."$2<$1 $3 $4>";
$replace[' <([a-zA-Z]{1,})[\r\n	 ]{0,}([a-zA-Z0-9-:\/\.="]{1,})[\r\n]{1,}([ 	]{0,})([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}>'] = " ".$nl."$3<$1 $2 $4>";
$replace[' <([a-zA-Z]{1,})[\r\n]{1,}([ 	]{0,})([a-zA-Z0-9-:\/\.="]{1,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}>'] = " ".$nl."$2<$1 $3 $4 $5>";
$replace[' <([a-zA-Z]{1,})[\r\n	 ]{0,}([a-zA-Z0-9-:\/\.="]{1,})[\r\n]{1,}([ 	]{0,})([ a-zA-Z0-9-:\/\.="]{0,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}>'] = " ".$nl."$3<$1 $2 $4 $5>";
$replace[' <([a-zA-Z]{1,})[\r\n	 ]{0,}([a-zA-Z0-9-:\/\.="]{1,})[\r\n	 ]{0,}([ a-zA-Z0-9-:\/\.="]{0,})[\r\n]{1,}([ 	]{0,})([ a-zA-Z0-9-:\/\.="]{0,})[ 	]{0,}>'] = " ".$nl."$4<$1 $2 $3 $5>";
$replace['" >'] = '">';
$replace['" \/>'] = '"/>';
//$replace['"[\r\n]{1,}[	 ]{0,}>'] = '">';

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (remove newlines inside tags)</h1>
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
							
							if($XMLstring !== $XMLstringNew) {
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

