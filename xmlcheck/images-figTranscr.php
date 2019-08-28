<?php
require('../include.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Images (no figTranscr)</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" media="screen" href="<?php echo $mainDir; ?>style.css"></link>
        <!--
		<script src="<?php echo $mainDir; ?>js/expand.js"></script>
		<script src="<?php echo $mainDir; ?>js/main.js"></script>
		<link rel="stylesheet" media="screen" href="<?php echo $mainDir; ?>js/fancybox/jquery.fancybox-1.3.4.css"></link>
		<script type="text/javascript" src="<?php echo $mainDir; ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		-->
	</head>
	<?php
	$pt = '';
	
	$base_path = ($_SERVER['SERVER_NAME'] == $mainServer || $_SERVER['SERVER_NAME'] == $devServer) ? '' : $mainDir;
	$base_url_local = 'http://localhost:8888'.$url;
	
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
	
	$vols = '[1-5]';

	if($_GET["vols"]) {
		$vols = $_GET["vols"];
	}
	
	$nav  = '<div id="global_nav">';
    $nav .=		'<strong>Volumes:</strong> ';
    $nav .=		'<a href="images-figTranscr.php?vols=[1-5]">1-5</a> | ';
    $nav .=		'<a href="images-figTranscr.php?vols=[6-9]">6-9</a> | ';
    $nav .=		'<a href="images-figTranscr.php?vols=1[0-5]">10-15</a>';
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
							<h1>Images (no figTranscr)</h1>
							<h2>(Volumes <?php echo $vols; ?>)</h2>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator($dir) as $fn) {
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
					
					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					$fn_t['figure'] = $FullXML->xpath('//text//figure'); // array
					$fn_t['figTranscr'] = $FullXML->xpath('//text//figure/figTranscr'); // array
					
					$noFigTranscrInFile = count($fn_t['figure']) - count($fn_t['figTranscr']);
					
					$numNoFigTranscr = $numNoFigTranscr + $noFigTranscrInFile;
					
					if($noFigTranscrInFile > 0) {

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						$XMLstring = file_get_contents( $dir.$fn_t['fn'] );
						$remove = array("\n", "\r\n", "\r");
						$XMLstring = str_replace($remove, ' ', $XMLstring);
						$XMLstring = preg_replace('/[ ]+/', ' ', $XMLstring);
						$XML->loadXML($XMLstring);
					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/img-figTranscr.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 
						//file_put_contents('new/'.$fn_t['fn'], $stripped);

						//$FullXML = simplexml_load_string($stripped);
						
						print '<h4><a href="'.$url.$fn_t['file'].'">'.$fn_t['file'].'</a></h4>';
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
			print '<h3>Total images without figTranscr (volumes '.$vols.'): '.$numNoFigTranscr.'</h3>';

			print $nav;
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

