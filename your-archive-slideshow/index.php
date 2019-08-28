<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';

	require('../include.php');
	
	?>
	<head>
		<title>Convert Slideshow</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" media="screen" href="<?php echo $mainDir; ?>style.css"></link>
	</head>
	<body>
       <div id="outer">
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Convert Slideshow</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator("old/") as $fn) {
				if (preg_match('/\.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
										
						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						$XMLstring = file_get_contents( 'old/'.$fn_t['fn'] );
						$XML->loadXML($XMLstring);
					
						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/slideshow.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$changed = $xslt->transformToXML( $XML );
						$changed = preg_replace('/[\r\n]+[ 	]{0,}[\r\n]+[ 	]{0,}[\r\n]+/', $nl, $changed);
						$changed = preg_replace('/[\r\n]+[ 	]{0,}[\r\n]+/', $nl, $changed);
						$changed = preg_replace('/([a-zA-Z\.])[\r\n 	]+<\//', '$1 </', $changed);
						
												
						if($changed == '') {
							print '<p>Error: '.$fn_t['fn'].' is blank after processing.</p>';
						} else if($changed == $XMLstring) {
							print '<p>Ignore: '.$fn_t['fn'].' is unchanged after processing.</p>';
						} else {
							file_put_contents('new/'.$fn_t['fn'], $changed);
							print '<h4>Processed '.$fn_t['fn'].'</a></h4>';
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

