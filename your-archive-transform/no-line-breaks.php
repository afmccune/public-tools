<!DOCTYPE html>
<html>
	<?php
	$pt = "";
	
	require('include/functions.php');
	require('include/head.php');
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Object Transcripts</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$sorted = array();
			
			foreach (new DirectoryIterator("./archive/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();

					//$FullXML = simplexml_load_file('./archive/'.$fn_t['fn']); 
					
					$nl = '
';

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						//$XML->load( './archive/'.$fn_t['fn'] );
						$XMLstring = file_get_contents( './archive/'.$fn_t['fn'] );
						$remove = array("\n", "\r\n", "\r");
						$XMLstring = str_replace($remove, ' ', $XMLstring);
						$XML->loadXML($XMLstring);

					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/strip-incl-lb.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 

						//file_put_contents('new/'.$fn_t['fn'], $stripped);
						
						$FullXML = simplexml_load_string($stripped);
						
						$fn_t['descIDs'] = $FullXML->xpath('//desc/@id');
						$fn_t['transcripts'] = $FullXML->xpath('//desc');
						
						for($i=0; $i<count($fn_t['transcripts']); $i++) {
							if(isset($fn_t['descIDs'][$i])) {
								file_put_contents('new/'.$fn_t['descIDs'][$i].'.txt', $fn_t['transcripts'][$i]);
								echo "<p>Success: ".$fn_t['descIDs'][$i]." processed.</p>";
							} else {
								echo "<p>ERROR: ".$fn_t['fn']." missing a descID (#".$i.").</p>";
							}
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

