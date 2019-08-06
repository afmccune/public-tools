<!DOCTYPE html>
<html>
<?php
require('include/functions.php');

header("Content-Type: text/html; charset=utf-8");
ini_set("default_charset", 'utf-8');

$nl = '
';

function seasonYearFromDate($date) {
	$seasons = array();
	$seasons[1] = 'Winter';
	$seasons[2] = 'Winter'; // no examples
	$seasons[3] = 'Spring';
	$seasons[4] = 'Spring';
	$seasons[5] = 'Summer';
	$seasons[6] = 'Summer';
	$seasons[7] = 'Summer';
	$seasons[8] = 'Summer'; // no examples
	$seasons[9] = 'Fall'; // no examples
	$seasons[10] = 'Fall';
	$seasons[11] = 'Fall'; // no examples
	$seasons[12] = 'Winter'; // no examples
	
	$dateParts = explode('-', $date);
	$monthStr = $dateParts[1];
	$month = intval($monthStr);
	
	$year = $dateParts[0];
	if($seasons[$month] == 'Winter') {
		$oldYear = $year - 1;
		$year = $oldYear.'-'.substr($year, 2, 2);
	}
	
	return $seasons[$month].' '.$year;
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

/**
 * Remove HTML tags, including invisible text such as style and
 * script code, and embedded objects.  Add line breaks around
 * block-level tags to prevent word joining after tag removal.
 * http://nadeausoftware.com/articles/2007/09/php_tip_how_strip_html_tags_web_page
 */
function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            $nl."\$0", $nl."\$0", $nl."\$0", $nl."\$0", $nl."\$0", $nl."\$0",
            $nl."\$0", $nl."\$0",
        ),
        $text );
    return strip_tags( $text );
}

$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML &amp; XML for Solr</h1>
							<p>(creates or updates bq/solr/solrFile.xml)</p>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						//$previousVolIss = '0.0';
						
						//$firstTime = true;
						
						$solrFile = '<add>'.$nl;

						// HTML articles
												
						foreach (new DirectoryIterator("../../bq/html/") as $fn) {
							if (preg_match('/[-a-z0-9\.]*\.htm[l]?/', $fn->getFilename())) { //$firstTime && 
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = ($fileParts[0] == 'bonus') ? $fileParts[0] : $fileParts[0].'.'.$fileParts[1];
								$fn_t['fileVol'] = ($fileParts[0] == 'bonus') ? '' : $fileParts[0];
								$fn_t['fileIss'] = ($fileParts[0] == 'bonus') ? '' : $fileParts[1];
								$fn_t['fileSplit'] = ($fileParts[0] == 'bonus') ? $fileParts[1] : $fileParts[2];
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);//$fileParts[2];
													
								$HTMLstring = file_get_contents('../../bq/html/'.$fn_t['fn']);
								preg_match( '@<meta\s+http-equiv="Content-Type"\s+content="([\w/]+)(;\s+charset=([^\s"]+))?@i', $HTMLstring, $matches );
								$fn_t['encoding'] = $matches[3];
								
								$FullHTML = file_get_html('../../bq/html/'.$fn_t['fn']);
								$HTMLvolume = getHtmlElementArray($FullHTML, 'meta[name=DC.Source.Volume]', 'content');
								$fn_t['volume'] = ($HTMLvolume[0] == '') ? $fn_t['fileVol'] : $HTMLvolume[0];
								$HTMLissue = getHtmlElementArray($FullHTML, 'meta[name=DC.Source.Issue]', 'content');
								$fn_t['issue'] = ($HTMLissue[0] == '') ? $fn_t['fileIss'] : $HTMLissue[0];
								$fn_t['volIss'] = ($fn_t['volIss'] == 'bonus' && $fn_t['fileSplit'] != 'toc') ? $fn_t['volume'].'.'.$fn_t['issue'] : $fn_t['volIss'];
								$HTMLdate = getHtmlElementArray($FullHTML, 'div[id=issueDescription] p', 'innertext');
								$HTMLfullDate = getHtmlElementArray($FullHTML, 'meta[name=DC.Date.dateSubmitted]', 'content');
								$fn_t['date'] = (count($HTMLdate)>0) ? $HTMLdate[0] : '';//$fn_t['date'] = (count($HTMLdate)>0) ? $HTMLdate[0] : seasonYearFromDate($HTMLfullDate[0]);
								$fn_t['date'] = (strtok($fn_t['date'], ':')) ? strtok($fn_t['date'], ':') : $fn_t['date'];
								$fn_t['date'] = (preg_match('/(Spring)|(Summer)|(Fall)|(Winter)/', $fn_t['date'])) ? $fn_t['date'] : '';
								$fn_t['fullDate'] = (count($HTMLfullDate)>0) ? $HTMLfullDate[0] : '';//$fn_t['fullDate'] = (count($HTMLfullDate)>0) ? $HTMLfullDate[0] : dateFromSeasonYear($HTMLdate[0]);
								$HTMLtype = getHtmlElementArray($FullHTML, 'meta[name=DC.Type.articleType]', 'content');
								$fn_t['type'] = ($HTMLtype[0] == '' && $fn_t['fileSplit'] == 'toc') ? 'toc' : $HTMLtype[0];
								$HTMLtitle = getHtmlElementArray($FullHTML, 'meta[name=DC.Title]', 'content');
								$fn_t['title'] = $HTMLtitle[0];
								//$fn_t['title'] = str_replace($charKeys, $charValues, $fn_t['title']);
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
								$fn_t['title'] = str_replace('&', 'and', $fn_t['title']);
								$HTMLmainArticle = getHtmlElementArray($FullHTML, 'meta[name=mainArticle]', 'content');
								$fn_t['mainArticle'] = (count($HTMLmainArticle) > 0) ? $HTMLmainArticle[0] : '';
								$HTMLmainArticleTitle = getHtmlElementArray($FullHTML, 'meta[name=mainArticleTitle]', 'content');
								$fn_t['mainArticleTitle'] = (count($HTMLmainArticleTitle) > 0) ? $HTMLmainArticleTitle[0] : '';
								$HTMLformat = getHtmlElementArray($FullHTML, 'meta[name=DC.Format]', 'content');
								$fn_t['format'] = $HTMLformat[0];
								$XMLauthors = getHtmlElementArray($FullHTML, 'meta[name=DC.Creator.PersonalName]', 'content');
								$XMLauthors = ($XMLauthors == array('G. E. Bentley', 'Jr.')) ? $XMLauthors = array('G. E. Bentley, Jr.') : $XMLauthors;
								$fn_t['author'] = implode(', ', $XMLauthors);
								$XMLfirstAuthorNames = explode(' ', $XMLauthors[0]);
								$fn_t['authorLast'] = (strpos($XMLauthors[0],', Jr.') !== false) ? str_replace(',', '', $XMLfirstAuthorNames[count($XMLfirstAuthorNames)-2]) : $XMLfirstAuthorNames[count($XMLfirstAuthorNames)-1]; // First author's last name
								$XMLcustFooter = getHtmlElementArray($FullHTML, 'div[id=custFooter]', 'outertext');
								$fn_t['custFooter'] = $XMLcustFooter[0];
								$XMLfulltext = getHtmlElementArray($FullHTML, 'div[id=content]', 'innertext');
								$fn_t['fulltext'] = $XMLfulltext[0];
								$fn_t['fulltext'] = str_replace($fn_t['custFooter'], '', $fn_t['fulltext']); // removing footer so it isn't indexed
								//htmlentities_savetags($XMLfulltext[0]); //strip_tags(htmlentities_savetags($XMLfulltext[0])); //
								//http://nadeausoftware.com/articles/2007/09/php_tip_how_strip_html_tags_web_page
								
								/* Convert to UTF-8 before doing anything else */
								$fn_t['fulltext'] = iconv( $fn_t['encoding'], "utf-8", $fn_t['fulltext'] );
								//$fn_t['fulltext'] = mb_convert_encoding($fn_t['fulltext'], 'HTML-ENTITIES', "UTF-8");
								
								/* Strip HTML tags and invisible text */
								$fn_t['fulltext'] = str_replace ('<br/>', $nl, $fn_t['fulltext']);
								$fn_t['fulltext'] = str_replace ('<br />', $nl, $fn_t['fulltext']);
								$fn_t['fulltext'] = strip_html_tags( $fn_t['fulltext'] );
								
								/* Decode HTML entities */
								$fn_t['fulltext'] = html_entity_decode( $fn_t['fulltext'], ENT_QUOTES, "UTF-8" ); 
								//$fn_t['fulltext'] = htmlentities ($fn_t['fulltext']);
								
								$fn_t['fulltext'] = str_replace('<', '', $fn_t['fulltext']);
								$fn_t['fulltext'] = str_replace('>', '', $fn_t['fulltext']);
								$fn_t['fulltext'] = str_replace('&', 'and', $fn_t['fulltext']);
								//$fn_t['fulltext'] = preg_replace('/[\r\n]{2,}/', $nl, $fn_t['fulltext']);
								$fn_t['fulltext'] = preg_replace('/[ 	]{2,}/', $nl, $fn_t['fulltext']);
								$fn_t['fulltext'] = wordwrap($fn_t['fulltext'], 110, $nl);
								
								//print('<pre>');
								//print_r($fn_t);
								//print('</pre>');
								
								$fn_t['HTML']  = '<doc>'.$nl;
								foreach ($XMLauthors as $author) {
								$fn_t['HTML'] .= '		<field name="author">'.$author.'</field>'.$nl;
								}
								$fn_t['HTML'] .= '		<field name="authorLast">'.$fn_t['authorLast'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="idno">'.$fn_t['file'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="volIss">'.$fn_t['volIss'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="volume">'.$fn_t['volume'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="issue">'.$fn_t['issue'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="date">'.$fn_t['date'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="fullDate">'.$fn_t['fullDate'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="format">text/html</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="title">'.$fn_t['title'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="type">'.$fn_t['type'].'</field>'.$nl;
								if($fn_t['type'] == 'illustration') {
								$fn_t['HTML'] .= '		<field name="mainArticle">'.$fn_t['mainArticle'].'</field>'.$nl;
								$fn_t['HTML'] .= '		<field name="mainArticleTitle">'.$fn_t['mainArticleTitle'].'</field>'.$nl;
								}
								$fn_t['HTML'] .= '		<field name="fulltext">'.$fn_t['fulltext'].'</field>'.$nl;
								$fn_t['HTML'] .= '</doc>'.$nl;

								//print($fn_t['HTML']);
								//file_put_contents('../../bq/solr/'.$fn_t['file'].'.xml', $fn_t['HTML']);
								echo '<p>Processed '.$fn_t['file'].'</p>';

								//$firstTime = false;
								
								$solrFile .= $fn_t['HTML'];
							}	
						}
						
						// XML articles
						
						foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
							if (preg_match('/[-a-z0-9\.]*\.xml/', $fn->getFilename())) { // add Emend, Contact, About
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
								//file_put_contents('../../bq/solr/'.$fn_t['file'].'.xml', $fn_t['XML']);
								echo '<p>Processed '.$fn_t['file'].'</p>';

								//$firstTime = false;
								
								$solrFile .= $fn_t['XML'];
							}	
						}
						
						$solrFile .= '</add>';
						file_put_contents('../../bq/solr/solrFile.xml', $solrFile);
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

