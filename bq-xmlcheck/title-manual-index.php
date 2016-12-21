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
						
						$FullHTML = str_get_html($HTMLstring);
						
						$links = array();
						$titles = array();
						
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
								$manualIndexTitle = preg_replace('/[ ]{2,}/', ' ', $manualIndexTitle);
								
								if($XMLtitle != $manualIndexTitle) {
									echo '<p>MISMATCH for <a href="http://localhost:8888/bq/'.$file.'" target="_blank">'.$file.'</a>: "'.$XMLtitle.'" (XML) vs "'.$titles[$i].'" (manual index)</p>';
								} else {
									//echo '<p>Titles match: '.$links[$i].'</p>';
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

