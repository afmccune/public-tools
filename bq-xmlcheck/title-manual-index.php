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
							<h1>Check Titles Against Manual Index</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$HTMLstring = file_get_contents('manual-index/index.html');
						$HTMLstring = str_replace('<em>', '', $HTMLstring);
						$HTMLstring = str_replace('</em>', '', $HTMLstring);
						$HTMLstring = str_replace('<p>', '', $HTMLstring);
						$HTMLstring = str_replace('</p>', '', $HTMLstring);
						$HTMLstring = str_replace('<sup>', '', $HTMLstring);
						$HTMLstring = str_replace('</sup>', '', $HTMLstring);
						
						$FullHTML = str_get_html($HTMLstring);
						
						$links = array();
						$titles = array();
						
						$messages = array();
						
						if (getHtmlElementArray($FullHTML, 'a', 'href')) {
							$links = getHtmlElementArray($FullHTML, 'a', 'href');
							$titles = getHtmlElementArray($FullHTML, 'a', 'innertext');
						} else {
							echo '<p>ERROR: no a hrefs found in manual index</p>';
						}
						
						if(count($links) != count($titles)) {
							echo '<p>ERROR: '.count($links).' links and '.count($titles).' titles</p>';
						}
						
						for($i=0; $i<count($links); $i++) {
							if(strpos($links[$i], 'http://bq.blakearchive.org/') !== false) {
								$file = str_replace('http://bq.blakearchive.org/', '', $links[$i]);
								
								$FullXML = simplexml_load_file('../../bq/docs/'.$file.'.xml'); 
								$XMLtitleArr = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
								$XMLtitle = $XMLtitleArr[0];
								$XMLtitle = preg_replace('/['.$nl.'	 ]{1,}/', ' ', $XMLtitle);
								
								$manualIndexTitle = $titles[$i];
								//$manualIndexTitle = preg_replace('/['.$nl.'	 ]{1,}/', ' ', $manualIndexTitle);
								$manualIndexTitle = preg_replace('/[ ]{2,}/', ' ', $manualIndexTitle);
								$manualIndexTitle = preg_replace('/ $/', '', $manualIndexTitle); // remove space at end of title
								$manualIndexTitle = preg_replace('/^ /', '', $manualIndexTitle); // remove space at beginning of title
								$manualIndexTitle = str_replace('&amp;', '&', $manualIndexTitle);
								
								$unpickyXMLtitle = strtoupper($XMLtitle);
								$unpickyXMLtitle = str_replace(' AND ', ' & ', $unpickyXMLtitle);
								
								$unpickyManualIndexTitle = strtoupper($manualIndexTitle);
								$unpickyManualIndexTitle = str_replace(' AND ', ' & ', $unpickyManualIndexTitle);
								
								if($unpickyXMLtitle != $unpickyManualIndexTitle) {
									$messages[] = '<p>MISMATCH for <a href="http://localhost:8888/bq/'.$file.'" target="_blank">'.$file.'</a>: <br/>"'.$XMLtitle.'" (XML) vs <br/>"'.$manualIndexTitle.'" (manual index)</p>';
									//$messages[] = '<p>MISMATCH for <a href="http://localhost:8888/bq/'.$file.'" target="_blank">'.$file.'</a>: <br/>"'.$unpickyXMLtitle.'" (XML) vs <br/>"'.$unpickyManualIndexTitle.'" (manual index)</p>';
								} else if($XMLtitle != $manualIndexTitle) {
									$messages[] = '<p>Non-matching capitalization (or &) for <a href="http://localhost:8888/bq/'.$file.'" target="_blank">'.$file.'</a>: <br/>"'.$XMLtitle.'" (XML) vs <br/>"'.$manualIndexTitle.'" (manual index)</p>';
								} else {
									//$messages[] = '<p>Titles match: '.$links[$i].'</p>';
								}								
							}
						}
						
						sort($messages);
						
						foreach($messages as $m) {
							echo $m.$nl;
						}
				
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

