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
							
							$FullXML = simplexml_load_file('old/'.$fn_t['fn']); 
							$fn_t['pbs'] = $FullXML->xpath('//pb/@n'); // array

							$XMLstring = file_get_contents('old/'.$fn_t['fn']);
							$XMLstring = preg_replace('@<div([1-9]) ([a-zA-Z0-9="\. ]{0,})><pb n="([0-9a-zA-Z]{1,})"[ ]{0,1}/>@', '<div$1 page="$3" $2><pb n="$3"/>', $XMLstring); // for div right before pb
							
							$pages = preg_split('@<pb n="[0-9a-zA-Z]{1,}"[ ]{0,1}/>@', $XMLstring);
							$XMLstringNew = $pages[0];
							// note that page values need to be added manually for divs before the first pb
												
							for($x=0; $x<count($fn_t['pbs']); $x++) {
								$pages[$x+1] = preg_replace('@<div([1-9]) @', '<div$1 page="'.$fn_t['pbs'][$x].'" ', $pages[$x+1]);
								$pages[$x+1] = preg_replace('@<div([1-9]) page="'.$fn_t['pbs'][$x].'" page="([0-9a-zA-Z]{1,})"@', '<div$1 page="$2"', $pages[$x+1]); // remove doubling for div right before pb
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

