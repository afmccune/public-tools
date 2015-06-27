<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
    function in_arrayi($needle, $haystack) {
        return in_array(mb_strtolower($needle, 'UTF-8'), array_map('mb_strtolower', $haystack));
    }
	
	function lastChar($str) {
		return substr($str, strlen($str)-1, 1);
	}
	
	function last3Char($str) {
		return substr($str, strlen($str)-3, 3);
	}
	
	function allButLastChar($str) {
		return substr($str, 0, strlen($str)-1);
	}
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for errors</h1>
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
						$XSL->load( 'xsl/docAuthor.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						$stripped = $xslt->transformToXML( $XML ); 
						//file_put_contents('new/'.$fn_t['fn'], $stripped);

						$FullXML = simplexml_load_string($stripped);
											
					$XMLdocAuthors = $FullXML->xpath('//docAuthor');
					$XMLdocAuthors = array_unique($XMLdocAuthors); //array
					$fn_t['docAuthors'] = array();
					$XMLdocAuthorsNames = $FullXML->xpath('//docAuthor/name');
					$XMLdocAuthorsNames = array_unique($XMLdocAuthorsNames); //array
					$fn_t['docAuthorsNames'] = array();
					//$surname = 'surname';//(isset($fn_t['docAuthorsNames'][$i])) ? $fn_t['docAuthorsNames'][$i] : $fn_t['docAuthorsNames'][0];
					
					for($i=0; $i<count($XMLdocAuthors); $i++) {
						if($XMLdocAuthors[$i] == 'MDP' || trim(preg_replace('/[ ]{2,}/', ' ', preg_replace('/[\r\n]{0,}/', '', $XMLdocAuthors[$i]))) == 'MDP') {
							$fn_t['docAuthors'][$i] = 'Morton D. Paley';
							global $XMLdocAuthorsNames;
							$XMLdocAuthorsNames[] = 'Paley';
						} else if($XMLdocAuthors[$i] == 'DDA') {
							$fn_t['docAuthors'][$i] = 'Donald D. Ault';
							global $XMLdocAuthorsNames;
							$XMLdocAuthorsNames[] = 'Ault';
						} else if($XMLdocAuthors[$i] == 'ALG') {
							$fn_t['docAuthors'][$i] = 'Andrew L. Griffin';
							global $XMLdocAuthorsNames;
							$XMLdocAuthorsNames[] = 'Griffin';
						} else {
							
							$fn_t['docAuthors'][$i] = trim(preg_replace('/[ ]{2,}/', ' ', preg_replace('/[\r\n]{0,}/', '', preg_replace('/(Mrs.|Professor|Dr.|Mr.) /', '', $XMLdocAuthors[$i]))));
							
							$lc = lastChar($fn_t['docAuthors'][$i]);
							if($lc == ',' || $lc == ':' || ($lc == '.' && last3Char($fn_t['docAuthors'][$i]) != 'Jr.' && last3Char($fn_t['docAuthors'][$i]) != 'JR.')) {
								$fn_t['docAuthors'][$i] = trim(allButLastChar($fn_t['docAuthors'][$i]));
							}

						}
					}
					
					$fn_t['docAuthorsNames'] = $XMLdocAuthorsNames;
					for($i=0; $i<count($fn_t['docAuthorsNames']); $i++) {
							$fn_t['docAuthorsNames'][$i] = trim(preg_replace('/[ ]{2,}/', ' ', preg_replace('/[\r\n]{0,}/', '', $fn_t['docAuthorsNames'][$i])));
					}					
					/*
					for($i=0; $i<count($XMLdocAuthorsNames); $i++) {
							$fn_t['docAuthorsNames'][$i] = $XMLdocAuthorsNames[$i];
					}
					*/

					$XMLauthors = $FullXML->xpath('//author');
					$fn_t['authors'] = $XMLauthors; //array
					$XMLauthorsLast = $FullXML->xpath('//author/@n');
					$fn_t['authorsLast'] = $XMLauthorsLast; //array
										
					$fn_t['errors'] = array();

					if(count($fn_t['docAuthors']) > 0) {
						if(count($fn_t['authors']) < count($fn_t['docAuthors'])) {
							$fn_t['errors'][] = "Fewer header authors than in-text docAuthors.";
						}
						foreach($fn_t['authors'] as $author){
							if(in_arrayi($author, $fn_t['docAuthors']) !== true) {
								$fn_t['errors'][] = "Header author (".$author.") does not match in-text docAuthors (".implode(', ', $fn_t['docAuthors']).").";
							}
						}
						foreach($fn_t['authorsLast'] as $authorLast){
							if(in_arrayi($authorLast, $fn_t['docAuthorsNames']) !== true) {
								$fn_t['errors'][] = "Header author last name (".$authorLast.") does not match in-text docAuthor last names (".implode(', ', $fn_t['docAuthorsNames']).").";
							}
						}
					}
					
					$docsXml[] = $fn_t;
	
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
				foreach($docsXml[$i]['errors'] as $error) {
					print '<p>'.$error.'</p>';
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

