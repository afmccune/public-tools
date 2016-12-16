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
				
			//print '<p>$vg_for = array();</p>';
			$vgs = array();
			$vgs[] = 'allegropenseroso';
			$vgs[] = 'biblicaltemperas';
			$vgs[] = 'biblicalwc';
			$vgs[] = 'but543';
			$vgs[] = 'cpd';
			$vgs[] = 'gravepd';
			$vgs[] = 'gravewc';
			$vgs[] = 'gravewd';
			$vgs[] = 'letters';
			$vgs[] = 'miltons';
			$vgs[] = 'pid';
			
			foreach (new DirectoryIterator("./wba/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);

					$FullXML = simplexml_load_file('./wba/'.$fn_t['fn']); 
					
					$nl = '
';
					print '<h4>'.$fn_t['file'].'</h4>';
					
					$fn_t['types'] = $FullXML->xpath('//bad/@type'); // array
					foreach($fn_t['types'] as $type) {
						//if(in_array($type, $vgs)) {
							print '<p>'.$type.'</p>';
							//print '<p>$vg_for["'.$bad.'"] = "'.$fn_t['file'].'";</p>';
							//print '$replace[\'work-copy="'.$bad.'"\'] = \'work-copy="'.$fn_t['file'].'"\';<br/>';
						//}
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

