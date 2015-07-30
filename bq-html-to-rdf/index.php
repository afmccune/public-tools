<!DOCTYPE html>
<html>
<?php
require('../../bq/include/functions.php');
	
$nl = "
";

function collexGenre($thisType) {
	$standardBQtype = standardBQtype($thisType);
	$collexCrit = array('article', 'discussion', 'minute', 'note', 'query');
	$collexReview = array('review');
	$collexNonf = array('news');
	$collexPoetry = array('poem');
	$collexLife = array('remembrance');
	$collexRef = array('context', 'correction');
	$collexBibl = array('toc', 'index', 'checklist');
	$collexVisual = array('illustration'); // HTML only
	if (in_array($standardBQtype, $collexCrit)) {
		return 'Criticism';
	} else if (in_array($standardBQtype, $collexReview)) {
		return 'Review';
	} else if (in_array($standardBQtype, $collexNonf)) {
		return 'Nonfiction';
	} else if (in_array($standardBQtype, $collexPoetry)) {
		return 'Poetry';
	} else if (in_array($standardBQtype, $collexLife)) {
		return 'Life Writing';
	} else if (in_array($standardBQtype, $collexRef)) {
		return 'Reference Works';
	} else if (in_array($standardBQtype, $collexBibl)) {
		return 'Bibliography';
	}  else if (in_array($standardBQtype, $collexVisual)) {
		return 'Visual Art';
	} else {
		echo '<p>Error: '.$thisType.' (standardized '.$standardBQtype.') does not correspond to collex genre.</p>';
		return '';
	}
}

// we use this for HTML; XML is standardized already
function standardBQtype($thisType) {
	$standard = '';
	global $articleTypes;
	foreach($articleTypes as $type) {
		if(in_array ($thisType, $type['keys'])) {
			$standard = $type['keys'][0];
		}
	}
	return $standard;
}

function issueCover($volIss) {
	$tocHTML = file_get_html('../../bq/html/'.$volIss.'.toc.html'); 
	$HTMLimg = getHtmlElementArray($tocHTML, 'div[id=issueCoverImage] img', 'src');
	return $HTMLimg[0];
}

function dateFromSeasonYear($date) {
	$seasons = array();
	$seasons['Winter'] = '01';
	$seasons['Spring'] = '03';
	$seasons['Summer'] = '06';
	$seasons['Fall']   = '10';
	
	$dateParts = explode(' ', $date);
	$season = $dateParts[0];
	$year = substr($dateParts[1], 0, 4);
	
	return $year.'-'.$seasons[$season].'-01';
}

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML to RDF</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/html/") as $fn) {
							if (preg_match('/[a-z0-9\.]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = ($fileParts[0] == 'bonus') ? $fileParts[0] : $fileParts[0].'.'.$fileParts[1];
								$fn_t['fileVol'] = ($fileParts[0] == 'bonus') ? '' : $fileParts[0];
								$fn_t['fileIss'] = ($fileParts[0] == 'bonus') ? '' : $fileParts[1];
								$fn_t['fileSplit'] = ($fileParts[0] == 'bonus') ? $fileParts[1] : $fileParts[2];
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);
								
								$FullHTML = file_get_html('../../bq/html/'.$fn_t['fn']);
													
								$fn_t['idno'] = $fn_t['file'];
								$HTMLtype = getHtmlElementArray($FullHTML, 'meta[name=DC.Type.articleType]', 'content');
								$fn_t['type'] = ($HTMLtype[0] == '' && $fn_t['fileSplit'] == 'toc') ? 'toc' : $HTMLtype[0];
								$fn_t['collexGenre'] = collexGenre($fn_t['type']);
								$HTMLtitle = getHtmlElementArray($FullHTML, 'meta[name=DC.Title]', 'content');
								$fn_t['title'] = $HTMLtitle[0];
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = str_replace('&', 'and', $fn_t['title']);
								$XMLauthors = getHtmlElementArray($FullHTML, 'meta[name=DC.Creator.PersonalName]', 'content');
								$XMLauthors = ($XMLauthors == array('G. E. Bentley', 'Jr.')) ? array('G. E. Bentley, Jr.') : $XMLauthors;
								$fn_t['authors'] = $XMLauthors; // array
								
								$HTMLdate = getHtmlElementArray($FullHTML, 'div[id=issueDescription] p', 'innertext');
								$HTMLfullDate = getHtmlElementArray($FullHTML, 'meta[name=DC.Date.dateSubmitted]', 'content');
								$fn_t['seasonYear'] = (count($HTMLdate)>0) ? $HTMLdate[0] : seasonYearFromDate($HTMLfullDate[0]);
								$fn_t['seasonYear'] = (strtok($fn_t['seasonYear'], ':')) ? strtok($fn_t['seasonYear'], ':') : $fn_t['seasonYear'];
								$fn_t['seasonYear'] = (preg_match('/(Spring)|(Summer)|(Fall)|(Winter)/', $fn_t['seasonYear'])) ? $fn_t['seasonYear'] : '';
								$fn_t['fullDate'] = (count($HTMLfullDate)>0) ? $HTMLfullDate[0] : dateFromSeasonYear($fn_t['seasonYear']);

								$fn_t['issueCover'] = issueCover($fn_t['volIss']);
								
								$HTMLvolume = getHtmlElementArray($FullHTML, 'meta[name=DC.Source.Volume]', 'content');
								$fn_t['volume'] = ($HTMLvolume[0] == '') ? $fn_t['fileVol'] : $HTMLvolume[0];
								$HTMLissue = getHtmlElementArray($FullHTML, 'meta[name=DC.Source.Issue]', 'content');
								$fn_t['issue'] = ($HTMLissue[0] == '') ? $fn_t['fileIss'] : $HTMLissue[0];
								
								$fn_t['rdf']  = '<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/"'.$nl;
								$fn_t['rdf'] .= ' xmlns:bq="http://bq.blakearchive.org/schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:role="http://www.loc.gov/loc.terms/relators/"'.$nl;
								$fn_t['rdf'] .= ' xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:collex="http://www.collex.org/schema#"'.$nl;
								$fn_t['rdf'] .= ' xmlns:dcterms="http://purl.org/dc/terms/">'.$nl;
								$fn_t['rdf'] .= $nl;
								$fn_t['rdf'] .= '	<bq:TEI.2 rdf:about="http://bq.blakearchive.org/'.$fn_t['idno'].'">'.$nl;
								$fn_t['rdf'] .= '		<collex:source_xml rdf:resource="http://bq.blakearchive.org/docs/'.$fn_t['file'].'"/>'.$nl;
								$fn_t['rdf'] .= '		<rdfs:seeAlso rdf:resource="http://bq.blakearchive.org/'.$fn_t['idno'].'"/>'.$nl;
								$fn_t['rdf'] .= '		<dc:title>'.$fn_t['title'].'</dc:title>'.$nl;
								foreach ($fn_t['authors'] as $author) {
								$fn_t['rdf'] .= '		<role:AUT>'.$author.'</role:AUT>'.$nl;
								}
								$fn_t['rdf'] .= '		<collex:genre>'.$fn_t['collexGenre'].'</collex:genre>'.$nl;
								$fn_t['rdf'] .= '		<collex:thumbnail rdf:resource="http://bq.blakearchive.org/img/illustrations/'.$fn_t['issueCover'].'"/>'.$nl;
								$fn_t['rdf'] .= '		<dc:date>'.$nl;
								$fn_t['rdf'] .= '			<collex:date>'.$nl;
								$fn_t['rdf'] .= '				<rdfs:label>'.$fn_t['seasonYear'].'</rdfs:label>'.$nl;
								$fn_t['rdf'] .= '				<rdf:value>'.$fn_t['fullDate'].'</rdf:value>'.$nl;
								$fn_t['rdf'] .= '			</collex:date>'.$nl;
								$fn_t['rdf'] .= '		</dc:date>'.$nl;
								$fn_t['rdf'] .= '		'.$nl;
								$fn_t['rdf'] .= '		<dcterms:isPartOf rdf:resource="http://bq.blakearchive.org/'.$fn_t['volume'].'.'.$fn_t['issue'].'.toc"/>'.$nl;
								$fn_t['rdf'] .= '		<role:PBL>Blake/An Illustrated Quarterly</role:PBL>'.$nl;
								$fn_t['rdf'] .= '		<collex:archive>bq</collex:archive>'.$nl;
								$fn_t['rdf'] .= '		<collex:federation>NINES</collex:federation>'.$nl;
								$fn_t['rdf'] .= '		<collex:federation>18thConnect</collex:federation>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>Literature</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>Art History</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '		<collex:discipline>History</collex:discipline>'.$nl;
								$fn_t['rdf'] .= '	</bq:TEI.2>'.$nl;
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

