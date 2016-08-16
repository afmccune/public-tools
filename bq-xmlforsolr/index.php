<!DOCTYPE html>
<html>
<?php

header("Content-Type: text/html; charset=utf-8");
ini_set("default_charset", 'utf-8');

$nl = '
';

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML for Solr</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						//$previousVolIss = '0.0';
						
						//$firstTime = true;
						
						$solrFile = '<add>'.$nl;
												
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
							if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}/', $fn->getFilename())) { // add Emend, Contact, About
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['fileVol'] = $fileParts[0];
								$fn_t['fileIss'] = $fileParts[1];
								$fn_t['fileSplit'] = $fileParts[2];
								$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
													
								$fn_t['encoding'] = '';
								
								$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
								$fn_t['volume'] = $fn_t['fileVol'];
								$fn_t['issue'] = $fn_t['fileIss'];
								$XMLvolIss = $FullXML->xpath("//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/biblScope[@unit='volIss']");
								$fn_t['volIss'] = $XMLvolIss[0];
								$XMLdate = $FullXML->xpath('//editionStmt/edition');
								$fn_t['date'] = $XMLdate[0];
								$XMLyear = $FullXML->xpath('//teiHeader/fileDesc/publicationStmt/date');
								$fn_t['year'] = $XMLyear[0];
								$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
								$fn_t['type'] = $XMLtype[0];
								$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
								$fn_t['title'] = $XMLtitle[0];
								$fn_t['title'] = preg_replace('/[ \r\n]{1,3}/', ' ', $fn_t['title']);
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = str_replace('&', 'and', $fn_t['title']);
								$XMLfirstAuthorLastName = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author/@n');
								$fn_t['authorLast'] = (count($XMLfirstAuthorLastName) > 0) ? $XMLfirstAuthorLastName[0] : ''; // First author's last name
								$XMLauthors = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
								$fn_t['author'] = $XMLauthors; // array
								$fn_t['format'] = '';

								$fn_t['fulltext'] = file_get_contents('../../bq/docs/'.$fn_t['fn']);
								$fn_t['fulltext'] = preg_replace('/<teiHeader(.*)<\/teiHeader>/s', '', $fn_t['fulltext']);

								/* Convert to UTF-8 before doing anything else */
								$fn_t['fulltext'] = iconv( $fn_t['encoding'], "utf-8", $fn_t['fulltext'] );

								/* Strip tags */
								$fn_t['fulltext'] = strip_tags($fn_t['fulltext']);

								$fn_t['fulltext'] = preg_replace('/[ 	]*'.$nl.'[ 	]*/', $nl, $fn_t['fulltext']);
								$fn_t['fulltext'] = preg_replace('/['.$nl.']{2,}/', $nl, $fn_t['fulltext']);

								//$fn_t['fulltext'] = str_replace($nl, ' '.$nl.' ', $fn_t['fulltext']);
								//$fn_t['fulltext'] = str_replace('	', '   ', $fn_t['fulltext']);

								/* Decode HTML entities */
								$fn_t['fulltext'] = html_entity_decode( $fn_t['fulltext'], ENT_QUOTES, "UTF-8" ); 
						
								$fn_t['fulltext'] = str_replace('<', '', $fn_t['fulltext']);
								$fn_t['fulltext'] = str_replace('>', '', $fn_t['fulltext']);
								$fn_t['fulltext'] = str_replace('&', 'and', $fn_t['fulltext']);
								//$fn_t['fulltext'] = preg_replace('/[\r\n]{2,}/', $nl, $fn_t['fulltext']);
								
								//print('<pre>');
								//print_r($fn_t);
								//print('</pre>');
								
								$fn_t['XML']  = '<doc>'.$nl;
								$fn_t['XML'] .= '		<field name="idno">'.$fn_t['file'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="volIss">'.$fn_t['volIss'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="volume">'.$fn_t['volume'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="issue">'.$fn_t['issue'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="date">'.$fn_t['date'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="year">'.$fn_t['year'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="title">'.$fn_t['title'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="type">'.$fn_t['type'].'</field>'.$nl;
								foreach ($XMLauthors as $author) {
								$fn_t['XML'] .= '		<field name="author">'.$author.'</field>'.$nl;
								}
								$fn_t['XML'] .= '		<field name="authorLast">'.$fn_t['authorLast'].'</field>'.$nl;
								$fn_t['XML'] .= '		<field name="fulltext">'.$fn_t['fulltext'];
								$fn_t['XML'] .= '		</field>'.$nl;
								$fn_t['XML'] .= '</doc>'.$nl;

								//print($fn_t['XML']);
								//file_put_contents('new/'.$fn_t['file'].'.xml', $fn_t['XML']);
								echo '<p>Processed '.$fn_t['file'].'</p>';

								//$firstTime = false;
								
								$solrFile .= $fn_t['XML'];
							}	
						}
						
						$solrFile .= '</add>';
						file_put_contents('new/solrFile.xml', $solrFile);
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

