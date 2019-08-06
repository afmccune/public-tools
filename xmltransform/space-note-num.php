<!DOCTYPE html>
<html>
<?php
require('../../include.php');
//require('include/functions.php');
	
$nl = "
";

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform: space between note number and italics text</h1>
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
							$fn_t['fileSplit'] = $fileParts[2];

							$XMLstring = file_get_contents($dir.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							$XMLstringNew = preg_replace('/<note id="n([0-9]{1,4})"><hi rend="s">([0-9]{1,4})<\/hi><hi rend="i">/', '<note id="n$1"><hi rend="s">$2</hi> <hi rend="i">', $XMLstringNew);
							$XMLstringNew = preg_replace('/<note id="n([0-9]{1,4})"><hi rend="s">([0-9]{1,4})<\/hi> <hi rend="i"> /', '<note id="n$1"><hi rend="s">$2</hi><hi rend="i"> ', $XMLstringNew);
							
							if($XMLstringNew == '') {
								echo '<p>Blank: '.$fn_t['fn'].'</p>';
							} else if($XMLstring != $XMLstringNew) {
								file_put_contents('space-note-num/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else {
								echo '<p>No change to '.$fn_t['fn'].'</p>';
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

