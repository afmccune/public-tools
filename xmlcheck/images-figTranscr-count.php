<!DOCTYPE html>
<html>
	<head>
		<title>Images (no figTranscr)</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" media="screen" href="../../bq/style.css"></link>
        <!--
		<script src="../../bq/js/expand.js"></script>
		<script src="../../bq/js/bq.js"></script>
		<link rel="stylesheet" media="screen" href="../../bq/js/fancybox/jquery.fancybox-1.3.4.css"></link>
		<script type="text/javascript" src="../../bq/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		-->
	</head>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org' || $_SERVER['SERVER_NAME'] == 'bq-dev.blakearchive.org') ? '' : '../../bq/';
	$base_url_local = 'http://localhost:8888/bq/';
	
	$numFig = 0;
	$numNoFigTranscr = 0;
	/*
	$missingByDecade = array();
	$missingByDecade['1960s'] = 0;
	$missingByDecade['1970s'] = 0;
	$missingByDecade['1980s'] = 0;
	$missingByDecade['1990s'] = 0;
	$missingByDecade['2000s'] = 0;
	$missingByDecade['2010s'] = 0;
	*/

	require('include/functions.php');
		
	?>
	<body>
       <div id="outer">
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Images (no figTranscr)</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];
					
					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['figure'] = $FullXML->xpath('//text//figure'); // array
					$fn_t['figTranscr'] = $FullXML->xpath('//text//figure/figTranscr'); // array
					
					$noFigTranscrInFile = count($fn_t['figure']) - count($fn_t['figTranscr']);
					
					$numFig = $numFig + count($fn_t['figure']);
					$numNoFigTranscr = $numNoFigTranscr + $noFigTranscrInFile;
					
					if($noFigTranscrInFile > 0) {						
						print '<h4><a href="/bq/'.$fn_t['file'].'">'.$fn_t['file'].'</a></h4>';
						echo '<p>'.count($fn_t['figure']).' images, '.$noFigTranscrInFile.' missing transcripts.</p>';
					}	
					
				}
			}
			
			/*		
			print '<h3>Missing images (1960s): '.$missingByDecade['1960s'].'</h3>';
			print '<h3>Missing images (1970s): '.$missingByDecade['1970s'].'</h3>';
			print '<h3>Missing images (1980s): '.$missingByDecade['1980s'].'</h3>';
			print '<h3>Missing images (1990s): '.$missingByDecade['1990s'].'</h3>';
			print '<h3>Missing images (2000s): '.$missingByDecade['2000s'].'</h3>';
			print '<h3>Missing images (2010s): '.$missingByDecade['2010s'].'</h3>';
			*/
			print '<h3>Total images: '.$numFig.'</h3>';
			print '<h3>Total images without figTranscr: '.$numNoFigTranscr.'</h3>';

			print $nav;
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

