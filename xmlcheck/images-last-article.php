<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
	
	require('include/functions.php');
	require('include/head.php');
	
	$numBlank = 0;
	$blankByDecade = array();
	$blankByDecade['2010s'] = 0;
	$blankByDecade['2020s'] = 0;
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Images with no filepath given in last article in issue</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$lastArticles = array();
			
			$docsXml = array();
			
			foreach (new DirectoryIterator($dir) as $toc_fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.toc.xml/', $toc_fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $toc_fn->getFilename();	
					
					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					
					$articles = $FullXML->xpath('//table//ref/@issue');
					$lastArticles[] = $articles[count($articles)-1];
				}
			}

			foreach($lastArticles as $fn) {
					$fn_t = array();
					$fn_t['fn'] = $fn.'.xml';

					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];

					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					
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
					$fn_t['year'] = substr($XMLyear[0], 0, 4);
					$decade = substr($fn_t['year'], 0, 3).'0s';
					
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
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
				}
			}
			
			print '<h3>Blank images (2010s): '.$blankByDecade['2010s'].'</h3>';
			print '<h3>Blank images (2020s): '.$blankByDecade['2020s'].'</h3>';
			print '<h3>Total blank images: '.$numBlank.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

