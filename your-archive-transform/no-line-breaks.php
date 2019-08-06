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
			
			foreach (new DirectoryIterator("./wba/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();

					//$FullXML = simplexml_load_file('./wba/'.$fn_t['fn']); 
					
					$nl = '
';

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						//$XML->load( './wba/'.$fn_t['fn'] );
						$XMLstring = file_get_contents( './wba/'.$fn_t['fn'] );
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
						
						/*
						$descs = explode('</desc>', $stripped);
						
						for($i=0; $i<count($descs)-1; $i++) {
							$desc = array();
							$open = '';//($i == count($descs)-1) ? '<bad>' : '';
							$close = ($i == count($descs)-1) ? '' : '</desc>';
							//$close = ($i == 0) ? '</desc></bad>' : $close;
							
							$chunk = $open.$descs[$i].$close;
							if($chunk != '') { //if($chunk != '<bad></bad>') {
								$FullXML = simplexml_load_string($chunk);
								$XMLdescIDs = $FullXML->xpath('//desc/@id');
								$desc['descID'] = (count($XMLdescIDs) > 0) ? $XMLdescIDs[0] : '';
								$XMLphystexts = $FullXML->xpath('//desc//phystext');	
								$desc['phystext'] = (count($XMLphystexts) > 0) ? $XMLphystexts[0] : '';
								$desc['phystext'] = (count($XMLphystexts) > 1) ? implode(' ', $XMLphystexts) : $desc['phystext'];
								
								if($desc['descID'] == '') {
									echo "<p>ERROR: ".$fn_t['fn']." missing a descID.</p>";
								} else if ($desc['phystext'] == '') {
									echo "<p>ERROR: ".$fn_t['fn']." (".$desc['descID'].") missing a phystext.</p>";
								} else {
									file_put_contents('new/'.$desc['descID'].'.txt', $desc['phystext']);
									echo "<p>Success: ".$desc['descID']." processed.</p>";
								}
							}
						}
						*/
					
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

