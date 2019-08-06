<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../../include.php');
	
	require('include/functions.php');
	require('include/head.php');
	
	$totalImages = 0;
	$imagesByType = array();
	$imagesByType['ad-cover'] = 0;
	$imagesByType['archive'] = 0;
	$imagesByType['archiveLocal'] = 0;
	$imagesByType['scan'] = 0;
	
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
					$fn_t['imgCount'] = count($FullXML->xpath('//text//figure')); // count array
					$fn_t['omittedAdsAndCovers'] =  count($FullXML->xpath('//text//figure/@type')) - count($FullXML->xpath('//text//figure[@n != ""]/@type')); // count array; all images of type "ad" or "reviewed-cover", minus images of those types with an image filepath
					$fn_t['archivePublic'] = count($FullXML->xpath('//text//figure[@rend="db"]')); // count array
					$fn_t['other'] = $FullXML->xpath('//text//figure[@rend="file"]/@n'); // array
					
					$totalImages = $totalImages + $fn_t['imgCount'];
					$imagesByType['ad-cover'] = $imagesByType['ad-cover'] + $fn_t['omittedAdsAndCovers'];
					$imagesByType['archive'] = $imagesByType['archive'] + $fn_t['archivePublic'];
					
					foreach($fn_t['other'] as $img) {
						if(strpos($img, 'scan') === false) {
							$imagesByType['archiveLocal'] = $imagesByType['archiveLocal'] + 1;
						} else {
							$imagesByType['scan'] = $imagesByType['scan'] + 1;
						}
					}

				}
			}
			
			print '<h3>Omitted images (ads and covers): '.$imagesByType['ad-cover'].'</h3>';
			print '<h3>Public archive images: '.$imagesByType['archive'].'</h3>';
			print '<h3>Local archive images: '.$imagesByType['archiveLocal'].'</h3>';
			print '<h3>Scans from journal: '.$imagesByType['scan'].'</h3>';
			print '<h3>Total images: '.$totalImages.'</h3>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

