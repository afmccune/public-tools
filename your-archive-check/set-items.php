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
							<h1>Archive items in sets</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			//print '<p>$set_for = array();</p>';
			$sets = array();
			$sets[] = 'set1';
			$sets[] = 'set2';
			
			foreach (new DirectoryIterator("./archive/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);

					$FullXML = simplexml_load_file('./archive/'.$fn_t['fn']); 
					
					$nl = '
';
					print '<h4>'.$fn_t['file'].'</h4>';
					
					$fn_t['types'] = $FullXML->xpath('//'.$itemCode.'/@type'); // array
					foreach($fn_t['types'] as $type) {
						//if(in_array($type, $sets)) {
							print '<p>'.$type.'</p>';
							//print '<p>$set_for["'.$item.'"] = "'.$fn_t['file'].'";</p>';
							//print '$replace[\'work-copy="'.$item.'"\'] = \'work-copy="'.$fn_t['file'].'"\';<br/>';
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

