<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
	require('include/functions.php');
	require('include/head.php');
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for images inside tables</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator($dir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];

					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					$fn_t['table-images'] = $FullXML->xpath('//text//table//figure'); // array
					$fn_t['widths'] = $FullXML->xpath('//text//table//figure/@width'); // array
					$fn_t['heights'] = $FullXML->xpath('//text//table//figure/@height'); // array
					
					$fn_t['errors'] = array();
					if(count($fn_t['table-images']) > 0) {
						$w_h = count($fn_t['widths']) + count($fn_t['heights']);
						$fn_t['errors'][] = 'Image(s) in tables: '.count($fn_t['table-images']);
						$fn_t['errors'][] = 'Number of image widths/heights: '.$w_h;
					} else {
						//echo '<p>'.$fn_t['file'].': No images in tables.</p>';
					}

					$docsXml[] = $fn_t;
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
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

