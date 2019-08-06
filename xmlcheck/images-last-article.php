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
	$blankByYear['1970'] = 0;
	$blankByYear['1971'] = 0;
	$blankByYear['1972'] = 0;
	$blankByYear['1973'] = 0;
	$blankByYear['1974'] = 0;
	$blankByYear['1975'] = 0;
	$blankByYear['1976'] = 0;
	$blankByYear['1977'] = 0;
	$blankByYear['1978'] = 0;
	$blankByYear['1979'] = 0;
	$blankByYear['1980'] = 0;
	$blankByYear['1981'] = 0;
	$blankByYear['1982'] = 0;
	$blankByYear['1983'] = 0;
	$blankByYear['1984'] = 0;
	$blankByYear['1985'] = 0;
	$blankByYear['1986'] = 0;
	$blankByYear['1987'] = 0;
	$blankByYear['1988'] = 0;
	$blankByYear['1989'] = 0;
	
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
			
			foreach (new DirectoryIterator("../../bq/docs/") as $toc_fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.toc.xml/', $toc_fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $toc_fn->getFilename();	
					
					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					
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
					$fn_t['year'] = substr($XMLyear[0], 0, 4);
					$decade = substr($fn_t['year'], 0, 3).'0s';
					
					$fn_t['errors'] = array();
					
					$missing = count($fn_t['img']) - (count($fn_t['src']) + count($fn_t['adsAndCovers']));
					
					if($fn_t['type'] != 'review' && $missing > 0) {
						$fn_t['errors'][] = 'Images missing filepath: '.$missing;
						$numBlank = $numBlank + $missing;
						$blankByDecade[$decade] = $blankByDecade[$decade] + $missing;
						if($fn_t['year'] > 1969 && $fn_t['year'] < 1990) {
							$blankByYear[$fn_t['year']] = $blankByYear[$fn_t['year']] + $missing;
						}
					} else if($fn_t['type'] == 'review' && $missing > 0) {
						$fn_t['errors'][] = 'Images missing filepath: '.$missing.' (review)';
						$numBlank = $numBlank + $missing;
						$blankByDecade[$decade] = $blankByDecade[$decade] + $missing;
						if($fn_t['year'] > 1969 && $fn_t['year'] < 1990) {
							$blankByYear[$fn_t['year']] = $blankByYear[$fn_t['year']] + $missing;
						}
					} else {
						//
					}

					$docsXml[] = $fn_t;
					
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
			print '<h4>Blank images (1970): '.$blankByYear['1970'].'</h4>';
			print '<h4>Blank images (1971): '.$blankByYear['1971'].'</h4>';
			print '<h4>Blank images (1972): '.$blankByYear['1972'].'</h4>';
			print '<h4>Blank images (1973): '.$blankByYear['1973'].'</h4>';
			print '<h4>Blank images (1974): '.$blankByYear['1974'].'</h4>';
			print '<h4>Blank images (1975): '.$blankByYear['1975'].'</h4>';
			print '<h4>Blank images (1976): '.$blankByYear['1976'].'</h4>';
			print '<h4>Blank images (1977): '.$blankByYear['1977'].'</h4>';
			print '<h4>Blank images (1978): '.$blankByYear['1978'].'</h4>';
			print '<h4>Blank images (1979): '.$blankByYear['1979'].'</h4>';
			print '<h3>Blank images (1980s): '.$blankByDecade['1980s'].'</h3>';
			print '<h4>Blank images (1980): '.$blankByYear['1980'].'</h4>';
			print '<h4>Blank images (1981): '.$blankByYear['1981'].'</h4>';
			print '<h4>Blank images (1982): '.$blankByYear['1982'].'</h4>';
			print '<h4>Blank images (1983): '.$blankByYear['1983'].'</h4>';
			print '<h4>Blank images (1984): '.$blankByYear['1984'].'</h4>';
			print '<h4>Blank images (1985): '.$blankByYear['1985'].'</h4>';
			print '<h4>Blank images (1986): '.$blankByYear['1986'].'</h4>';
			print '<h4>Blank images (1987): '.$blankByYear['1987'].'</h4>';
			print '<h4>Blank images (1988): '.$blankByYear['1988'].'</h4>';
			print '<h4>Blank images (1989): '.$blankByYear['1989'].'</h4>';
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

