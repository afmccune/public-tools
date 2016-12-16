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
							<table>
								<tr><th>descid</th><th>supplementalid</th></tr>
			<?php
				
			$sorted = array();
			
			foreach (new DirectoryIterator("./wba/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
					$nl = '
';

						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						//$XML->load( './wba/'.$fn_t['fn'] );
						$XMLstring = file_get_contents( './wba/'.$fn_t['fn'] );
						$remove = array("\n", "\r\n", "\r");
						$XMLstring = str_replace($remove, ' ', $XMLstring);
						$XMLstring = preg_replace('/[ ]+/', ' ', $XMLstring);
						$XML->loadXML($XMLstring);

					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/supp.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 

						//file_put_contents('new/'.$fn_t['fn'], $stripped);
						
						$FullXML = simplexml_load_string($stripped);
						
						$fn_t['descIDs'] = $FullXML->xpath('//desc/@id');
						$fn_t['transcripts'] = $FullXML->xpath('//desc');

						if(count($fn_t['transcripts']) > 0) {
							for($i=0; $i<count($fn_t['transcripts']); $i++) {
								if(isset($fn_t['descIDs'][$i]) && $fn_t['transcripts'][$i] != '' && $fn_t['transcripts'][$i] != ' ') {
									echo '<tr><td>'.$fn_t['descIDs'][$i].'</td><td>'.$fn_t['transcripts'][$i].'</td></tr>'.$nl;
								} else {
									// nothin'
									//echo '<tr><td>NOPE</td></tr>';
								}
							}
						} else {
							//echo 'NOPE!<br/>';
						}
				}
			}						


			?>
							</table>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

