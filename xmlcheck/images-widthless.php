<!DOCTYPE html>
<html>
	<head>
		<title>Images (widthless or heightless)</title>
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
	
	$numWidthless = 0;
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
	
	$vols = '[1-5]';

	if($_GET["vols"]) {
		$vols = $_GET["vols"];
	}
	
	$nav  = '<div id="global_nav">';
    $nav .=		'<strong>Volumes:</strong> ';
    $nav .=		'<a href="images-widthless.php?vols=[1-5]">1-5</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=[6-9]">6-9</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=1[0-5]">10-15</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=1[6-9]">16-19</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=2[0-5]">20-25</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=2[6-9]">26-29</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=3[0-5]">30-35</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=3[6-9]">36-39</a> | ';
    $nav .=		'<a href="images-widthless.php?vols=4[0-4]">40-44</a>';
    $nav .=		'<div class="clear"></div>';
    $nav .=	'</div>';
	
	?>
	<body>
       <div id="outer">
			<?php print $nav; ?>
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Images (widthless or heightless): can check images displayed too large</h1>
							<h2>(Volumes <?php echo $vols; ?>)</h2>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				//if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
				if (preg_match('/^'.$vols.'.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
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
					$fn_t['width'] = $FullXML->xpath('//text//figure/@width'); // array
					$fn_t['height'] = $FullXML->xpath('//text//figure/@height'); // array
					
					$widthsAndHeights = count($fn_t['width']) + count($fn_t['height']); // note that we're assuming the same figure won't have both a width and a height					
					$widthlessInFile = count($fn_t['figure']) - $widthsAndHeights;
					
					$numWidthless = $numWidthless + $widthlessInFile;
					
					if($widthlessInFile > 0) {

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						$XMLstring = file_get_contents( '../../bq/docs/'.$fn_t['fn'] );
						$remove = array("\n", "\r\n", "\r");
						$XMLstring = str_replace($remove, ' ', $XMLstring);
						$XMLstring = preg_replace('/[ ]+/', ' ', $XMLstring);
						$XML->loadXML($XMLstring);
					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/img-widthless.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 
						//file_put_contents('new/'.$fn_t['fn'], $stripped);

						//$FullXML = simplexml_load_string($stripped);
						
						print '<h4><a href="/bq/'.$fn_t['file'].'">'.$fn_t['file'].'</a></h4>';
						echo '<p>'.count($fn_t['figure']).' - '.$widthsAndHeights.' = '.$widthlessInFile.'</p>';
						echo $stripped;
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
			print '<h3>Total widthless/heightless images (volumes '.$vols.'): '.$numWidthless.'</h3>';

			print $nav;
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

