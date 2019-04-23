<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');
	
$nl = "
";

$arch_sets = array(); // enter archive set of items (individual images)
$arch_sets['set1'] = array('item1', 'item2');
$arch_sets['set2'] = array('item1', 'item2');

$replace = array();
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_]{1,}\.[a-zA-Z0-9]{1,})(\.[a-zA-Z0-9-_\.]{1,})"'] = '<figure n="$1" id="$2$3" work-copy="$2"';
$replace['work-copy="([a-zA-Z0-9-_\.]{1,})" work-copy="[a-zA-Z0-9-_\.]{1,}"'] = 'work-copy="$1"';
// virtual groups
foreach($arch_sets as $key => $value) {
	$set = $key;
	foreach($value as $item) {
		$replace['work-copy="'.$item.'"'] = 'work-copy="'.$set.'"';
	}
}
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
							
							if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else if ($XMLstringNew == '') {
								echo '<p style="color: red;">ERROR: transformed '.$fn_t['fn'].' is blank.</p>';
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

