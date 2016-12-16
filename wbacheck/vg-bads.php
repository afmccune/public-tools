<!DOCTYPE html>
<html>
	<?php
	$pt = "";
	
	require('include/functions.php');
	require('include/head.php');
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>BADs in Virtual Groups</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			print '<p>$vg_for = array();</p>';
			
			foreach (new DirectoryIterator("./vg/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);

					$FullXML = simplexml_load_file('./vg/'.$fn_t['fn']); 
					
					$nl = '
';
					//print '<h4>'.$fn_t['file'].'</h4>';
					
					$fn_t['bads'] = $FullXML->xpath('//include/@bad'); // array
					foreach($fn_t['bads'] as $bad) {
						//print '<p>'.$bad.'</p>';
						print '<p>$vg_for["'.$bad.'"] = "'.$fn_t['file'].'";</p>';
					}
					
				}
			}
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

