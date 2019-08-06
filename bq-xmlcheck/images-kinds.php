<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	$totalImages = 0;
	$imagesByType = array();
	$imagesByType['ad-cover'] = 0;
	$imagesByType['WBA'] = 0;
	$imagesByType['WBAlocal'] = 0;
	$imagesByType['bqscan'] = 0;
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Image kinds</h1>
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
					$fn_t['imgCount'] = count($FullXML->xpath('//text//figure')); // count array
					$fn_t['omittedAdsAndCovers'] =  count($FullXML->xpath('//text//figure/@type')) - count($FullXML->xpath('//text//figure[@n != ""]/@type')); // count array; all images of type "ad" or "reviewed-cover", minus images of those types with an image filepath
					$fn_t['WBApublic'] = count($FullXML->xpath('//text//figure[@rend="db"]')); // count array
					$fn_t['other'] = $FullXML->xpath('//text//figure[@rend="file"]/@n'); // array
					
					$totalImages = $totalImages + $fn_t['imgCount'];
					$imagesByType['ad-cover'] = $imagesByType['ad-cover'] + $fn_t['omittedAdsAndCovers'];
					$imagesByType['WBA'] = $imagesByType['WBA'] + $fn_t['WBApublic'];
					
					foreach($fn_t['other'] as $img) {
						if(strpos($img, 'bqscan') === false) {
							$imagesByType['WBAlocal'] = $imagesByType['WBAlocal'] + 1;
						} else {
							$imagesByType['bqscan'] = $imagesByType['bqscan'] + 1;
						}
					}

				}
			}
			
			print '<h3>Omitted images (ads and covers): '.$imagesByType['ad-cover'].'</h3>';
			print '<h3>Public WBA images: '.$imagesByType['WBA'].'</h3>';
			print '<h3>Local WBA images: '.$imagesByType['WBAlocal'].'</h3>';
			print '<h3>Scans from BQ: '.$imagesByType['bqscan'].'</h3>';
			print '<h3>Total images: '.$totalImages.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

