<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	$numVala = 0;
	$ValaByDecade = array();
	$ValaByDecade['1960s'] = 0;
	$ValaByDecade['1970s'] = 0;
	$ValaByDecade['1980s'] = 0;
	$ValaByDecade['1990s'] = 0;
	$ValaByDecade['2000s'] = 0;
	$ValaByDecade['2010s'] = 0;
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Images with no filepath given, with "Vala" in the caption</h1>
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
					$fn_t['pathlessImg'] = $FullXML->xpath('//text//figure[not(@n)]'); // array
					$fn_t['pathlessHead'] = $FullXML->xpath('//text//figure[not(@n)]/head'); // array
					$fn_t['pathlessDesc'] = $FullXML->xpath('//text//figure[not(@n)]/figDesc'); // array
					$fn_t['pathlessCaptions'] = implode(' ', $fn_t['pathlessHead']).' '.implode(' ', $fn_t['pathlessDesc']);
					/*
					$fn_t['imgTypes'] = $FullXML->xpath('//text//figure/@type'); // array
					$fn_t['adsAndCovers'] = array();
					foreach($fn_t['imgTypes'] as $imgType) {
						if($imgType == 'ad' || $imgType == 'reviewed-cover') {
							$fn_t['adsAndCovers'][] = $imgType;
						}
					}
					*/
					
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					
					$XMLyear = $FullXML->xpath('//fileDesc/publicationStmt/date');
					$fn_t['year'] = substr($XMLyear[0], 0, 4);
					$decade = substr($fn_t['year'], 0, 3).'0s';
					
					$fn_t['errors'] = array();
					
					$missing = count($fn_t['pathlessImg']);
					$vala = substr_count($fn_t['pathlessCaptions'], 'Vala');
					
					if($vala > 0) {
						$fn_t['errors'][] = 'Images missing filepath: '.$missing;
						$fn_t['errors'][] = 'Mention of "Vala" in pathless image captions: '.$vala;
						$numVala = $numVala + $vala;
						$ValaByDecade[$decade] = $ValaByDecade[$decade] + $vala;
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
			
			print '<h3>Vala mentions (1960s): '.$ValaByDecade['1960s'].'</h3>';
			print '<h3>Vala mentions (1970s): '.$ValaByDecade['1970s'].'</h3>';
			print '<h3>Vala mentions (1980s): '.$ValaByDecade['1980s'].'</h3>';
			print '<h3>Vala mentions (1990s): '.$ValaByDecade['1990s'].'</h3>';
			print '<h3>Vala mentions (2000s): '.$ValaByDecade['2000s'].'</h3>';
			print '<h3>Vala mentions (2010s): '.$ValaByDecade['2010s'].'</h3>';
			print '<h3>Total Vala mentions: '.$numVala.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

