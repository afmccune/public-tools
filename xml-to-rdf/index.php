<!DOCTYPE html>
<html>
<?php
require('../include.php');
//require($mainDir.'include/functions.php');
	
$nl = "
";

function collexGenre($thisType) {
	//$standardType = standardType($thisType);
	$collexCrit = array('article', 'discussion', 'minute', 'note', 'query');
	$collexReview = array('review');
	$collexNonf = array('news');
	$collexPoetry = array('poem');
	$collexLife = array('remembrance');
	$collexRef = array('context', 'correction');
	$collexBibl = array('toc', 'index', 'checklist');
	//$collexVisual = array('illustration'); // HTML only
	if (in_array($thisType, $collexCrit)) {
		return 'Criticism';
	} else if (in_array($thisType, $collexReview)) {
		return 'Review';
	} else if (in_array($thisType, $collexNonf)) {
		return 'Nonfiction';
	} else if (in_array($thisType, $collexPoetry)) {
		return 'Poetry';
	} else if (in_array($thisType, $collexLife)) {
		return 'Life Writing';
	} else if (in_array($thisType, $collexRef)) {
		return 'Reference Works';
	} else if (in_array($thisType, $collexBibl)) {
		return 'Bibliography';
	} else {
		echo '<p>Error: '.$thisType.' does not correspond to collex genre.</p>';
		return '';
	}
}

/*
// actually, we should use this for HTML; XML is standardized already
function standardType($thisType) {
	$standard = '';
	foreach($articleTypes as $type) {
		if(in_array ($thisType, $type['keys'])) {
			$standard = $type['keys'][0];
		}
	}
	return $standard;
}
*/

function issueCover($volIss) {
	global $dir;

	$tocXML = simplexml_load_file($dir.$volIss.'.toc.xml'); 
	print $dir.$volIss.'.toc.xml';
	$XMLimg = $tocXML->xpath('//div1[@id="cover"]/figure/@n');
	return $XMLimg[0];
}
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML to RDF</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
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
								$XMLidno = $FullXML->xpath('//teiHeader/idno');
								$fn_t['idno'] = $XMLidno[0];
								$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
								$fn_t['type'] = $XMLtype[0];
								$fn_t['collexGenre'] = collexGenre($fn_t['type']);
								$fn_t['title'] = '';
								if($fn_t['fileSplit'] == 'toc') {
									$fn_t['title'] = 'Volume '.$fn_t['volNum'].' &middot; Issue '.$fn_t['issueNum'];
								} else {
									$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
									$fn_t['title'] = $XMLtitle[0];
									$fn_t['title'] = preg_replace('/[ \r\n]{1,3}/', ' ', $fn_t['title']);
								}
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = str_replace('&', 'and', $fn_t['title']);
								$XMLauthors = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
								$fn_t['authors'] = $XMLauthors; // array
								
								$XMLseasonYear = $FullXML->xpath('//editionStmt/edition');
								$fn_t['seasonYear'] = $XMLseasonYear[0];
								$XMLyear = $FullXML->xpath('//fileDesc/publicationStmt/date');
								$fn_t['year'] = substr($XMLyear[0], 0, 4);

								$fn_t['issueCover'] = issueCover($fn_t['volIss']);
								
								$articles = $FullXML->xpath('//table//ref/@issue');
								$fn_t['articles'] = $articles; // array
								
								
								$fn_t['rdf']  = '<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"'.$nl;
								$fn_t['rdf'] .= ' xmlns:'.$rdfCode.'="http://'.$mainServer.'/schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:role="http://www.loc.gov/loc.terms/relators/"'.$nl;
								$fn_t['rdf'] .= ' xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:collex="http://www.collex.org/schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:dcterms="http://purl.org/dc/terms/">'.$nl;
								$fn_t['rdf'] .= $nl;
								$fn_t['rdf'] .= '	<'.$rdfCode.':TEI.2 rdf:about="http://'.$mainServer.'/'.$fn_t['idno'].'">'.$nl;
								$fn_t['rdf'] .= '		<collex:source_xml rdf:resource="http://'.$mainServer.'/docs/'.$fn_t['file'].'"/>'.$nl;
								$fn_t['rdf'] .= '		<rdfs:seeAlso rdf:resource="http://'.$mainServer.'/'.$fn_t['idno'].'"/>'.$nl;
								$fn_t['rdf'] .= '		<dc:title>'.$fn_t['title'].'</dc:title>'.$nl;
								if($fn_t['fileSplit'] != 'toc') { // in our RDF, the TOC masquerades as the whole issue, and the author of material in the TOC did not author the whole issue
								 foreach ($fn_t['authors'] as $author) {
								$fn_t['rdf'] .= '		<role:AUT>'.$author.'</role:AUT>'.$nl;
								 }
								}
								$fn_t['rdf'] .= '		<collex:genre>'.$fn_t['collexGenre'].'</collex:genre>'.$nl;
								$fn_t['rdf'] .= '		<collex:thumbnail rdf:resource="http://'.$mainServer.'/img/illustrations/'.$fn_t['issueCover'].'.thumb.png"/>'.$nl;
								$fn_t['rdf'] .= '		<dc:date>'.$nl;
								$fn_t['rdf'] .= '			<collex:date>'.$nl;
								$fn_t['rdf'] .= '				<rdfs:label>'.$fn_t['seasonYear'].'</rdfs:label>'.$nl;
								$fn_t['rdf'] .= '				<rdf:value>'.$fn_t['year'].'</rdf:value>'.$nl;
								$fn_t['rdf'] .= '			</collex:date>'.$nl;
								$fn_t['rdf'] .= '		</dc:date>'.$nl;
								$fn_t['rdf'] .= '		'.$nl;
								if($fn_t['fileSplit'] != 'toc') {
								$fn_t['rdf'] .= '		<dcterms:isPartOf rdf:resource="http://'.$mainServer.'/'.$fn_t['volNum'].'.'.$fn_t['issueNum'].'.toc"/>'.$nl;
								} else {
								 foreach($fn_t['articles'] as $article) {
								$fn_t['rdf'] .= '		<dcterms:hasPart rdf:resource="http://'.$mainServer.'/'.$article.'"/>'.$nl;
								 }
								}
								$fn_t['rdf'] .= '		<dc:type>Periodical</dc:type>'.$nl;
								$fn_t['rdf'] .= '		<dc:source>'.$archiveTitle.'</dc:source>'.$nl;
								$fn_t['rdf'] .= '		<role:PBL>'.$archiveTitle.'</role:PBL>'.$nl;
								$fn_t['rdf'] .= '		<collex:archive>'.$rdfCode.'</collex:archive>'.$nl;
								$fn_t['rdf'] .= '		<collex:federation>NINES</collex:federation>'.$nl;
								$fn_t['rdf'] .= '		<collex:federation>18thConnect</collex:federation>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>Literature</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>Art History</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>History</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '	</'.$rdfCode.':TEI.2>'.$nl;
								$fn_t['rdf'] .= '</rdf:RDF>'.$nl;
							
								file_put_contents('new/'.$fn_t['file'].'.rdf.xml', $fn_t['rdf']);
									
								echo '<p>Converted '.$fn_t['fn'].'</p>';
							}
						}
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

