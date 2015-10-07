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
							<h1>Characteristics</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$sorted = array();
			
			foreach (new DirectoryIterator("./wba/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
					$nl = '
';
						
					$FullXML = simplexml_load_file('./wba/'.$fn_t['fn']); 
						
					//$fn_t['badIDs'] = $FullXML->xpath('//bad/@id');
					//$fn_t['badID'] = (count($fn_t['badIDs'] > 0) ? $fn_t['badIDs'][0] : '';
					$fn_t['characteristics'] = $FullXML->xpath('//characteristic');
					$fn_t['charlist'] = '';
						
					for($i=0; $i<count($fn_t['characteristics']); $i++) {
						$fn_t['charlist'] .= $fn_t['characteristics'][$i].$nl;
					}
						
					file_put_contents('characteristics/'.$fn_t['fn'], $fn_t['charlist']);
					
					print '<p>Processed characteristics for '.$fn_t['fn'].'</p>';
					
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

