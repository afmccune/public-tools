<!DOCTYPE html>
<html>
<?php
require('../../include.php');
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
							<h1>XML Transform (Newline)</h1>
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
							$XMLidno = $FullXML->xpath('//teiHeader/idno');
							$fn_t['idno'] = $XMLidno[0];
							$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
							$fn_t['type'] = $XMLtype[0];
							$XMLtitleHi = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/hi');
							$fn_t['titleHi'] = (count($XMLtitleHi) > 0) ? $XMLtitleHi[0] : '';
							$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
							$fn_t['title'] = $XMLtitle[0];
							$XMLotherTitle = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title');
							$fn_t['otherTitle'] = $XMLotherTitle[0];
							$XMLheadings = $FullXML->xpath('//text//head/title');
							$fn_t['headings'] = $XMLheadings; //array
							$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
							$fn_t['headingTypes'] = $XMLheadingTypes; //array
							$XMLsection = $FullXML->xpath('//text//head/title[@type="section"]');
							$XMLsection = (count($XMLsection) > 0) ? $XMLsection : array('');
							$XMLsectionChild = $FullXML->xpath('//text//head/title[@type="section"]/*');
							$XMLsectionChild = (count($XMLsectionChild) > 0) ? $XMLsectionChild : array('');
							$XMLsectionChildChild = $FullXML->xpath('//text//head/title[@type="section"]/*/*');
							$XMLsectionChildChild = (count($XMLsectionChildChild) > 0) ? $XMLsectionChildChild : array('');
							$fn_t['section'] = $XMLsection[0].$XMLsectionChild[0].$XMLsectionChildChild[0];
							$XMLmain = $FullXML->xpath('//text//head/title[@type="main"]');
							$XMLmain = (count($XMLmain) > 0) ? $XMLmain : array('');
							$XMLmainChild = $FullXML->xpath('//text//head/title[@type="main"]/*');
							$XMLmainChild = (count($XMLmainChild) > 0) ? $XMLmainChild : array('');
							$XMLmainChildChild = $FullXML->xpath('//text//head/title[@type="main"]/*/*');
							$XMLmainChildChild = (count($XMLmainChildChild) > 0) ? $XMLmainChildChild : array('');
							$XMLmainDescendants = '';
							$XMLmainDescendants .= (count($XMLmainChild) > 1) ? implode(' ', $XMLmainChild) : $XMLmainChild[0];
							$XMLmainDescendants .= (count($XMLmainChildChild) > 1) ? implode(' ', $XMLmainChildChild) : $XMLmainChildChild[0];
							$fn_t['main'] = $XMLmain[0].$XMLmainDescendants;
							
							// This detects newlines but does not replace them, for some reason...
						
								//if($fn_t['main'] != '' && preg_match('/"/', $fn_t['title']) && !preg_match('/"/', $fn_t['main'])) {
								if(preg_match('/\r\n|\n|\r/', $fn_t['title'])) {
									$XMLstring = file_get_contents($dir.$fn_t['fn']);
																
									$oldTitle = $fn_t['title'];
									$newTitle = preg_replace('/\r\n|\n|\r/', " ", $oldTitle, 1);
								
									$XMLstringNew = preg_replace('/'.$oldTitle.'/', $newTitle, $XMLstring, 1);
									
									//if($XMLstringNew == $XMLstring) {
									//	echo '<p>'.$fn_t['fn'].': NO CHANGE</p>';
									//} else {
										file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);

										echo '<p>Converted '.$fn_t['fn'].'</p>';									
									//}
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

