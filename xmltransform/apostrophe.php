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
							<h1>XML Transform (Apostrophe)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator($dir) as $fn) {
						if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
							
							$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							$fn_t['fileSplit'] = $fileParts[2];

							$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
							$XMLtitleHi = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/hi');
							$fn_t['titleHi'] = (count($XMLtitleHi) > 0) ? $XMLtitleHi[0] : '';
							$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
							$fn_t['title'] = $XMLtitle[0];
						
								if(preg_match("/'s /", $fn_t['title'])) {
									$XMLstring = file_get_contents($dir.$fn_t['fn']);
																
									$oldTitle = $fn_t['title'];
									$newTitle = preg_replace("/'s /", "’s ", $oldTitle, 1);
								
									$XMLstringNew = preg_replace('/'.$oldTitle.'/', $newTitle, $XMLstring, 1);
									
										file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);

										echo '<p>Converted '.$fn_t['fn'].'</p>';									
								} else if(preg_match("/'s /", $fn_t['titleHi'])){
									$XMLstring = file_get_contents($dir.$fn_t['fn']);
																
									$oldTitle = $fn_t['titleHi'];
									$newTitle = preg_replace("/'s /", "’s ", $oldTitle, 1);
								
									$XMLstringNew = preg_replace('/'.$oldTitle.'/', $newTitle, $XMLstring, 1);
									
										file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);

										echo '<p>Converted '.$fn_t['fn'].'</p>';									
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

