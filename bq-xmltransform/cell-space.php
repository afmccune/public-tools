<!DOCTYPE html>
<html>
<?php
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
							<h1>XML Transform (add space between cell and row tags)</h1>
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
							$fn_t['fileSplit'] = $fileParts[2];

							$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							$XMLstringNew = str_replace("</cell><cell>", "</cell>".$nl."	<cell>", $XMLstringNew);
							$XMLstringNew = str_replace("<cell/><cell>", "<cell/>".$nl."	<cell>", $XMLstringNew);
							$XMLstringNew = str_replace("</cell><cell/>", "</cell>".$nl."	<cell/>", $XMLstringNew);
							$XMLstringNew = str_replace("</row><row>", "</row>".$nl."<row>", $XMLstringNew);
							$XMLstringNew = str_replace("<row><cell>", "<row>".$nl."	<cell>", $XMLstringNew);
							$XMLstringNew = str_replace("<row><cell/>", "<row>".$nl."	<cell/>", $XMLstringNew);
							$XMLstringNew = str_replace("</cell></row>", "</cell>".$nl."</row>", $XMLstringNew);
							$XMLstringNew = str_replace("<cell/></row>", "<cell/>".$nl."</row>", $XMLstringNew);
							
							if($XMLstring != $XMLstringNew) {
								file_put_contents('cell-space/'.$fn_t['fn'], $XMLstringNew);
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

