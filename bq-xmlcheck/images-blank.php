<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	$numBlank = 0;
	$blankByDecade = array();
	$blankByDecade['1960s'] = 0;
	$blankByDecade['1970s'] = 0;
	$blankByDecade['1980s'] = 0;
	$blankByDecade['1990s'] = 0;
	$blankByDecade['2000s'] = 0;
	$blankByDecade['2010s'] = 0;
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Images with no filepath given</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['img'] = $FullXML->xpath('//text//figure'); // array
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					$fn_t['imgTypes'] = $FullXML->xpath('//text//figure/@type'); // array
					$fn_t['adsAndCovers'] = array();
					foreach($fn_t['imgTypes'] as $imgType) {
						if($imgType == 'ad' || $imgType == 'reviewed-cover') {
							$fn_t['adsAndCovers'][] = $imgType;
						}
					}
					
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					
					$XMLyear = $FullXML->xpath('//fileDesc/publicationStmt/date');
					$decade = substr($XMLyear[0], 0, 3).'0s';
					
					$fn_t['errors'] = array();
					
					$missing = count($fn_t['img']) - (count($fn_t['src']) + count($fn_t['adsAndCovers']));
					
					if($fn_t['type'] != 'review' && $missing > 0) {
						$fn_t['errors'][] = 'Images missing filepath: '.$missing;
						$numBlank = $numBlank + $missing;
						$blankByDecade[$decade] = $blankByDecade[$decade] + $missing;
					} else if($fn_t['type'] == 'review' && $missing > 0) {
						$fn_t['errors'][] = 'Images missing filepath: '.$missing.' (review)';
						$numBlank = $numBlank + $missing;
						$blankByDecade[$decade] = $blankByDecade[$decade] + $missing;
					} else {
						//
					}

					$docsXml[] = $fn_t;
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
				}
			}
			
			print '<h3>Blank images (1960s): '.$blankByDecade['1960s'].'</h3>';
			print '<h3>Blank images (1970s): '.$blankByDecade['1970s'].'</h3>';
			print '<h3>Blank images (1980s): '.$blankByDecade['1980s'].'</h3>';
			print '<h3>Blank images (1990s): '.$blankByDecade['1990s'].'</h3>';
			print '<h3>Blank images (2000s): '.$blankByDecade['2000s'].'</h3>';
			print '<h3>Blank images (2010s): '.$blankByDecade['2010s'].'</h3>';
			print '<h3>Total blank images: '.$numBlank.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

