<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for page breaks inside divs</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator("old/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = $fileParts[0];

					$FullXML = simplexml_load_file('old/'.$fn_t['fn']); 
					$fn_t['pbs'] = $FullXML->xpath('//pb/@n'); // array
					$fn_t['div1-pbs'] = $FullXML->xpath('//div1//pb/@n'); // array
					/*
					$fn_t['div2-pbs'] = $FullXML->xpath('//div2//pb/@n'); // array
					$fn_t['div3-pbs'] = $FullXML->xpath('//div3//pb/@n'); // array
					$fn_t['div4-pbs'] = $FullXML->xpath('//div4//pb/@n'); // array
					*/
					
					$fn_t['pbs-count'] = count($fn_t['pbs']);
					$fn_t['div-pbs-count'] = count($fn_t['div1-pbs']);
					//$fn_t['div-pbs-count'] = count($fn_t['div1-pbs'])+count($fn_t['div2-pbs'])+count($fn_t['div3-pbs'])+count($fn_t['div4-pbs']);
					
					$fn_t['errors'] = array();
					/*
					$fn_t['errors'][] = 'Page break(s) in div1: '.count($fn_t['div1-pbs']).'';
					$fn_t['errors'][] = 'Page break(s) in div2: '.count($fn_t['div2-pbs']).'';
					$fn_t['errors'][] = 'Page break(s) in div3: '.count($fn_t['div3-pbs']).'';
					$fn_t['errors'][] = 'Page break(s) in div4: '.count($fn_t['div4-pbs']).'';
					*/
					$fn_t['errors'][] = 'Total page break(s) in divs: '.$fn_t['div-pbs-count'].'';
					$fn_t['errors'][] = 'Total page break(s): '.count($fn_t['pbs']).'';

					$docsXml[] = $fn_t;
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4>'.$docsXml[$i]['file'].'</h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
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

