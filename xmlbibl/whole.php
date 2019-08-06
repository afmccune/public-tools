<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');
	
$nl = "
";
$ind = "                        ";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (biblScope)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator($dir) as $fn) {
						if (preg_match('/[0-9]{3}-[0-9]{2}[-a-z0-9]{0,}.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								$fn_t['volNum'] = volFromFile($fn_t['file']);
								$fn_t['issueNum'] = substr($fn_t['file'], 5);
								$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
								$fn_t['newVolIss'] = ($fn_t['volNum'] < 10) ? '0'.$fn_t['volNum'].'.'.$fn_t['issueNum'] : $fn_t['volNum'].'.'.$fn_t['issueNum'];
								
								$XMLstring = file_get_contents($dir.$fn_t['fn']);
								$FullXMLold = simplexml_load_file($dir.$fn_t['fn']);
								
								$oldCode = '';
								$newCode = '';
								
								if(strpos($XMLstring,'<biblScope') === false) {
									if($FullXMLold->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title')[0] == '') {
										$oldCode = '<title/>';
										$newCode = '<title>Blake Newsletter</title>'.$nl.$ind.'<biblScope unit="volIss">'.$fn_t['newVolIss'].'</biblScope>'.$nl.$ind.'<biblScope unit="volume">'.$fn_t['volNum'].'</biblScope>'.$nl.$ind.'<biblScope unit="issue">'.$fn_t['issueNum'].'</biblScope>';
									} else {
										$oldCode = '<title>'.$FullXMLold->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title')[0].'</title>';
										$newCode = $oldCode.$nl.$ind.'<biblScope unit="volIss">'.$fn_t['newVolIss'].'</biblScope>'.$nl.$ind.'<biblScope unit="volume">'.$fn_t['volNum'].'</biblScope>'.$nl.$ind.'<biblScope unit="issue">'.$fn_t['issueNum'].'</biblScope>';
									}
								
									$XMLstringNew = str_replace($oldCode, $newCode, $XMLstring);
									file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
									
									if($XMLstringNew == $XMLstring) {
										echo '<p>'.$fn_t['fn'].' COPIED WITHOUT CHANGE</p>';
									} else {
										echo '<p>Converted '.$fn_t['fn'].'</p>';
									
										$FullXMLnew = simplexml_load_file('new/'.$fn_t['fn']);
										if ($FullXMLnew->xpath('//teiHeader/biblScope[@unit="volIss"]')[0] == $fn_t['newVolIss']) {
											echo '<p>'.$fn_t['fn'].' volIss set to '.$fn_t['newVolIss'].'.toc</p>';
										} else {
											//echo '<p>ERROR: '.$fn_t['fn'].' volIss set to '.$FullXMLnew->xpath('//teiHeader/biblScope[@unit="volIss"]')[0].'</p>';
										}
									}
								} else {
									// echo '<p>'.$fn_t['fn'].' already processed.</p>';
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

