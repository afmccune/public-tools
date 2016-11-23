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
							<h1>Transform Erdman</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator("old/") as $fn) {
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

							$FullXML = simplexml_load_file('old/'.$fn_t['fn']); 
							$fn_t['pbs'] = $FullXML->xpath('//pb/@n'); // array

							$XMLstring = file_get_contents('old/'.$fn_t['fn']);
							$pages = preg_split('@<pb n="[0-9]{1,}"[ ]{0,1}/>@', $XMLstring);
							$XMLstringNew = $pages[0];
												
							for($x=0; $x<count($fn_t['pbs']); $x++) {
								$pages[$x+1] = preg_replace('@<div([1-9]) @', '<div$1 page="'.$fn_t['pbs'][$x].'" ', $pages[$x+1]);
								$XMLstringNew .= '<pb n="'.$fn_t['pbs'][$x].'"/>'.$pages[$x+1];
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

