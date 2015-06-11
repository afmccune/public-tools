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
							<h1>XML Transform</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("./old/") as $fn) {
							if (preg_match('/[0-9]{3}-[0-9]{2}[-a-z0-9]*.xml/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
								$fn_t['volNum'] = volFromFile($fn_t['file']);
								$fn_t['issueNum'] = substr($fn_t['file'], 5);
								$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
								$fn_t['newVolIss'] = $fn_t['volNum'].'.'.$fn_t['issueNum'];
								
								$XMLstring = file_get_contents('old/'.$fn_t['fn']);
																
								//$oldCode = '/<idno>'.$fn_t['file'].'</idno>[\n 	]*<fileDesc>[\n 	]*<titleStmt>[\n 	]*<title>[\n.]*</title>[\n 	]</titleStmt>/';
								//$newCode = '<idno>'.$fn_t['newVolIss'].'.toc</idno>\n		<fileDesc>\n			<titleStmt>\n				<title type="toc">Contents</title>\n				<author n=""></author>\n			</titleStmt>';
								$oldCode = '<idno>'.$fn_t['file'].'</idno>';
								$newCode = '<idno>'.$fn_t['newVolIss'].'.toc</idno>';
								
									$XMLstringNew = str_replace($oldCode, $newCode, $XMLstring);
									file_put_contents('new/'.$fn_t['newVolIss'].'.toc.xml', $XMLstringNew);
									
									if($XMLstringNew == $XMLstring) {
										echo '<p>'.$fn_t['fn'].' COPIED WITHOUT CHANGE</p>';
									} else {
										echo '<p>Converted '.$fn_t['fn'].'</p>';
									
										$FullXMLnew = simplexml_load_file('new/'.$fn_t['newVolIss'].'.toc.xml');
										if ($FullXMLnew->xpath('//teiHeader/idno')[0] == $fn_t['newVolIss'].'.toc') {
											echo '<p>'.$fn_t['fn'].' header title set to '.$fn_t['newVolIss'].'.toc</p>';
										} else {
											echo '<p>ERROR: '.$fn_t['fn'].' idno set to '.$FullXMLnew->xpath('//teiHeader/idno')[0].'</p>';
										}
										/*
										if ($FullXMLnew->xpath('//teiHeader/fileDesc/titleStmt/title') == 'Contents') {
											echo '<p>'.$fn_t['fn'].' header title set to "Contents"</p>';
										} else {
											echo '<p>ERROR: '.$fn_t['fn'].' header title set to '.$FullXMLnew->xpath('//teiHeader/fileDesc/titleStmt/title').'</p>';
										}
										if ($FullXMLnew->xpath('//teiHeader/fileDesc/titleStmt/author')) {
											echo '<p>'.$fn_t['fn'].' author exists</p>';
										} else {
											echo '<p>ERROR: '.$fn_t['fn'].' author does not exist</p>';
										}
										*/
									}
								//}
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

