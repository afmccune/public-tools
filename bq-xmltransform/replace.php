<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";

$replace = array();
$replace["Astrologer's"] = "Astrologer’s";
$replace["BLAKE'S"] = "BLAKE’S";
$replace["Blake's"] = "Blake’s";
$replace["Bride's"] = "Bride’s";
$replace["Cowper's"] = "Cowper’s";
$replace["DIDN'T"] = "DIDN’T";
$replace["Enamel'd"] = "Enamel’d";
$replace["Engrav'd"] = "Engrav’d";
$replace["Erdman's"] = "Erdman’s";
$replace["HE'S"] = "HE’S";
$replace["I'll"] = "I’ll";
$replace["L'Allegro"] = "L’Allegro";
$replace["MILTON'S"] = "MILTON’S";
$replace["Martin's"] = "Martin’s";
$replace["Nature's"] = "Nature’s";
$replace["PARRY'S"] = "PARRY’S";
$replace["Publish'd"] = "Publish’d";
$replace["Rossetti's"] = "Rossetti’s";
$replace["Rossetti's"] = "Rossetti’s";
$replace["SAMBO'S"] = "SAMBO’S";
$replace["Sotheby's"] = "Sotheby’s";
$replace["Unnam'd"] = "Unnam’d";
$replace["Wordsworth's"] = "Wordsworth’s";
$replace["YOUNG'S"] = "YOUNG’S";
$replace["Zoa's"] = "Zoa’s";
$replace["appear'd"] = "appear’d";
$replace["bow'd"] = "bow’d";
$replace["don't"] = "don’t";
$replace["enslav'd"] = "enslav’d";
$replace["escap'd"] = "escap’d";
$replace["l'etablie"] = "l’etablie";
$replace["men's"] = "men’s";
$replace["quench'd"] = "quench’d";
$replace["w'd"] = "w’d";
$replace["we'd"] = "we’d";
$replace["world's"] = "world’s";

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Replace)</h1>
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

