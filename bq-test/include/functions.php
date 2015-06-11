<?php
   			include('include/simple_html_dom.php');
			
			$minVol = 33;
			$minIss = 4;
			$maxVol = 43;
			$maxIss = 3;
			
			$articleTypes = array();
			$articleTypes[0] = array();
			$articleTypes[0]['name'] = 'Article';
			$articleTypes[0]['nameShort'] = 'Article';
			$articleTypes[0]['namePlural'] = 'Articles';
			$articleTypes[0]['namePluralShort'] = 'Articles';
			$articleTypes[0]['keys'] = array('article','Article','Articles','index');
			$articleTypes[1] = array();
			$articleTypes[1]['name'] = 'Checklist of Publications';
			$articleTypes[1]['nameShort'] = 'Checklist';
			$articleTypes[1]['namePlural'] = 'Checklists of Publications';
			$articleTypes[1]['namePluralShort'] = 'Checklists';
			$articleTypes[1]['keys'] = array('checklist');
			$articleTypes[2] = array();
			$articleTypes[2]['name'] = 'Correction';
			$articleTypes[2]['nameShort'] = 'Correction';
			$articleTypes[2]['namePlural'] = 'Corrections';
			$articleTypes[2]['namePluralShort'] = 'Corrections';
			$articleTypes[2]['keys'] = array('correction','Addenda');
			$articleTypes[3] = array();
			$articleTypes[3]['name'] = 'Discussion';
			$articleTypes[3]['nameShort'] = 'Discussion';
			$articleTypes[3]['namePlural'] = 'Discussion';
			$articleTypes[3]['namePluralShort'] = 'Discussion';
			$articleTypes[3]['keys'] = array('discussion','Discussion');
			$articleTypes[4] = array();
			$articleTypes[4]['name'] = 'Minute Particular';
			$articleTypes[4]['nameShort'] = 'Minute Particular';
			$articleTypes[4]['namePlural'] = 'Minute Particulars';
			$articleTypes[4]['namePluralShort'] = 'Minute Particulars';
			$articleTypes[4]['keys'] = array('minute','Minute Particulars');
			$articleTypes[5] = array();
			$articleTypes[5]['name'] = 'News';
			$articleTypes[5]['nameShort'] = 'News';
			$articleTypes[5]['namePlural'] = 'News';
			$articleTypes[5]['namePluralShort'] = 'News';
			$articleTypes[5]['keys'] = array('news','News','Journal News');
			$articleTypes[6] = array();
			$articleTypes[6]['name'] = 'Note';
			$articleTypes[6]['nameShort'] = 'Note';
			$articleTypes[6]['namePlural'] = 'Notes';
			$articleTypes[6]['namePluralShort'] = 'Notes';
			$articleTypes[6]['keys'] = array('note');
			$articleTypes[7] = array();
			$articleTypes[7]['name'] = 'Poem';
			$articleTypes[7]['nameShort'] = 'Poem';
			$articleTypes[7]['namePlural'] = 'Poems';
			$articleTypes[7]['namePluralShort'] = 'Poems';
			$articleTypes[7]['keys'] = array('poem','Poems');
			$articleTypes[8] = array();
			$articleTypes[8]['name'] = 'Query';
			$articleTypes[8]['nameShort'] = 'Query';
			$articleTypes[8]['namePlural'] = 'Queries';
			$articleTypes[8]['namePluralShort'] = 'Queries';
			$articleTypes[8]['keys'] = array('query');
			$articleTypes[9] = array();
			$articleTypes[9]['name'] = 'Remembrance';
			$articleTypes[9]['nameShort'] = 'Remembrance';
			$articleTypes[9]['namePlural'] = 'Remembrances';
			$articleTypes[9]['namePluralShort'] = 'Remembrances';
			$articleTypes[9]['keys'] = array('remembrance');
			$articleTypes[10] = array();
			$articleTypes[10]['name'] = 'Review';
			$articleTypes[10]['nameShort'] = 'Review';
			$articleTypes[10]['namePlural'] = 'Reviews';
			$articleTypes[10]['namePluralShort'] = 'Reviews';
			$articleTypes[10]['keys'] = array('review','Reviews');
			$articleTypes[11] = array();
			$articleTypes[11]['name'] = 'Context (About, Contact, Emendations)';
			$articleTypes[11]['nameShort'] = 'Context';
			$articleTypes[11]['namePlural'] = 'Context (About, Contact, Emendations)';
			$articleTypes[11]['namePluralShort'] = 'Context';
			$articleTypes[11]['keys'] = array('context');
			$articleTypes[12] = array();
			$articleTypes[12]['name'] = 'Table of Contents';
			$articleTypes[12]['nameShort'] = 'Contents';
			$articleTypes[12]['namePlural'] = 'Tables of Contents';
			$articleTypes[12]['namePluralShort'] = 'Contents';
			$articleTypes[12]['keys'] = array('toc');
			$articleTypes[13] = array();
			$articleTypes[13]['name'] = 'Illustration';
			$articleTypes[13]['nameShort'] = 'Illustration';
			$articleTypes[13]['namePlural'] = 'Illustrations';
			$articleTypes[13]['namePluralShort'] = 'Illustrations';
			$articleTypes[13]['keys'] = array('illustration');
			
			function inPubRange ($vol, $iss) {
				global $minVol, $minIss, $maxVol, $maxIss;
				
				if(($vol > $minVol || ($vol == $minVol && $iss >= $minIss)) && ($vol < $maxVol || ($vol == $maxVol && $iss <= $maxIss))) {
					return true;
				} else {
					return false;
				}
			}
			
			function showable ($vol, $iss) {
				if($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org' && inPubRange($vol, $iss)) {
					return true;
				} else if ($_SERVER['SERVER_NAME'] == 'bq-dev.blakearchive.org' || $_SERVER['SERVER_NAME'] == 'localhost') {
					return true;
				} else {
					return false;
				}
			}
			
    		function volFromFile ($f) {
				$v = substr($f, 1, 2);
				
				if(substr($v,0,1) == '0') {
					$v = substr($v,1,1);
				}
				
				return $v;
			}
			
			function cmp(array $a, array $b) {
				if (($cmp = strcmp($b['decade'], $a['decade'])) !== 0) {
					return $cmp;
				} else if(($b['volNum'] - $a['volNum']) !== 0) {
					return $b['volNum'] - $a['volNum'];
				} 
				else {
					return strcmp($a['file'], $b['file']);
				}
			}

			function cmpArticle(array $a, array $b) {
				if (($cmp = strcmp($a['firstAuthorLastName'], $b['firstAuthorLastName'])) !== 0) {
					return $cmp;
				} else if(($cmp2 = strcmp($a['author'], $b['author'])) !== 0) {
					return $cmp2;
				} else {
					return strcmp($a['title'], $b['title']);
				}
			}

			function cmpIllus(array $a, array $b) {
				if (($cmp = strcmp($a['firstAuthorLastName'], $b['firstAuthorLastName'])) !== 0) {
					return $cmp;
				} else if(($cmp2 = strcmp($a['author'], $b['author'])) !== 0) {
					return $cmp2;
				} else if(($cmp3 = strcmp($a['mainArticleTitle'], $b['mainArticleTitle'])) !== 0) {
					return $cmp3;
				} else {
					return strcmp($a['title'], $b['title']);
				}
			}

			function htmlentities_savetags($str_in) {
				$list = get_html_translation_table(HTML_ENTITIES);
				unset($list["'"]);
				unset($list['"']);
				unset($list['<']);
				unset($list['>']);
				unset($list['&']);
				$list['​'] = '&#8203;'; // Zero Width Space
				$list['﻿'] = '&#65279;'; // Byte Order Mark
				$list['А'] = '&#1040;';
				$list['Б'] = '&#1041;';
				$list['В'] = '&#1042;';
				$list['Г'] = '&#1043;';
				$list['Д'] = '&#1044;';
				$list['Е'] = '&#1045;';
				$list['Ж'] = '&#1046;';
				$list['З'] = '&#1047;';
				$list['И'] = '&#1048;';
				$list['Й'] = '&#1049;';
				$list['К'] = '&#1050;';
				$list['Л'] = '&#1051;';
				$list['М'] = '&#1052;';
				$list['Н'] = '&#1053;';
				$list['О'] = '&#1054;';
				$list['П'] = '&#1055;';
				$list['Р'] = '&#1056;';
				$list['С'] = '&#1057;';
				$list['Т'] = '&#1058;';
				$list['У'] = '&#1059;';
				$list['Ф'] = '&#1060;';
				$list['Х'] = '&#1061;';
				$list['Ц'] = '&#1062;';
				$list['Ч'] = '&#1063;';
				$list['Ш'] = '&#1064;';
				$list['Щ'] = '&#1065;';
				$list['Ъ'] = '&#1066;';
				$list['Ы'] = '&#1067;';
				$list['Ь'] = '&#1068;';
				$list['Э'] = '&#1069;';
				$list['Ю'] = '&#1070;';
				$list['Я'] = '&#1071;';
				$list['а'] = '&#1072;';
				$list['б'] = '&#1073;';
				$list['в'] = '&#1074;';
				$list['г'] = '&#1075;';
				$list['д'] = '&#1076;';
				$list['е'] = '&#1077;';
				$list['ж'] = '&#1078;';
				$list['з'] = '&#1079;';
				$list['и'] = '&#1080;';
				$list['й'] = '&#1081;';
				$list['к'] = '&#1082;';
				$list['л'] = '&#1083;';
				$list['м'] = '&#1084;';
				$list['н'] = '&#1085;';
				$list['о'] = '&#1086;';
				$list['п'] = '&#1087;';
				$list['р'] = '&#1088;';
				$list['с'] = '&#1089;';
				$list['т'] = '&#1090;';
				$list['у'] = '&#1091;';
				$list['ф'] = '&#1092;';
				$list['х'] = '&#1093;';
				$list['ц'] = '&#1094;';
				$list['ч'] = '&#1095;';
				$list['ш'] = '&#1096;';
				$list['щ'] = '&#1097;';
				$list['ъ'] = '&#1098;';
				$list['ы'] = '&#1099;';
				$list['ь'] = '&#1100;';
				$list['э'] = '&#1101;';
				$list['ю'] = '&#1102;';
				$list['я'] = '&#1103;';
				$list['Ć'] = '&#262;';
				$list['ć'] = '&#263;';
				$list['Č'] = '&#268;';
				$list['č'] = '&#269;';
				$list['Đ'] = '&#272;';
				$list['đ'] = '&#273;';
				$list['Š'] = '&#352;';
				$list['š'] = '&#353;';
				$list['Ž'] = '&#381;';
				$list['ž'] = '&#382;';
				$list[' '] = '';
				$list['ǚ'] = '&#474;';
				$list['Ă'] = '&#258;';
				$list['ă'] = '&#259;';
				$list['Ș'] = '&#x218;';
				$list['ș'] = '&#x219;';
				$list['Ț'] = '&#538;';
				$list['ț'] = '&#539;';
				$list['א'] = '&#1488;';
				$list['ב'] = '&#1489;';
				$list['ג'] = '&#1490;';
				$list['ד'] = '&#1491;';
				$list['ה'] = '&#1492;';
				$list['ו'] = '&#1493;';
				$list['ז'] = '&#1494;';
				$list['ח'] = '&#1495;';
				$list['ט'] = '&#1496;';
				$list['י'] = '&#1497;';
				$list['ך'] = '&#1498;';
				$list['כ'] = '&#1499;';
				$list['ל'] = '&#1500;';
				$list['ם'] = '&#1501;';
				$list['מ'] = '&#1502;';
				$list['ן'] = '&#1503;';
				$list['נ'] = '&#1504;';
				$list['ס'] = '&#1505;';
				$list['ע'] = '&#1506;';
				$list['ף'] = '&#1507;';
				$list['פ'] = '&#1508;';
				$list['ץ'] = '&#1509;';
				$list['צ'] = '&#1510;';
				$list['ק'] = '&#1511;';
				$list['ר'] = '&#1512;';
				$list['ש'] = '&#1513;';
				$list['ת'] = '&#1514;';
				$list['בּ'] = '&#64305;';
				$list['כּ'] = '&#64315;';
				$list['פּ'] = '&#64324;';
				$list['שׁ'] = '&#64298;';
				$list['שׂ'] = '&#64299;';
				$list['וּ'] = '&#64309;';
				$list['תּ'] = '&#64330;';
				$list['וֹ'] = '&#64331;';
				$list['ְ'] = '&#1456;';
				$list['ִ'] = '&#1460;';
				$list['ֵ'] = '&#1461;';
				$list['ֶ'] = '&#1462;';
				$list['ַ'] = '&#1463;';
				$list['ָ'] = '&#1464;';
				$list['ֹ'] = '&#1465;';
				$list['ֺ'] = '&#1466;';
				$list['ֻ'] = '&#1467;';
				$list['ּ'] = '&#1468;';
				$list['耿'] = '&#32831;';
				$list['力'] = '&#21147;';
				$list['平'] = '&#24179;';
				$list['ʼ'] = '&#700;';
				$list['ʻ'] = '&#699;';
				$list['Ḳ'] = '&#7730;';
				$list['ḳ'] = '&#7731;';
				$list['̣'] = '&#803;';
				
				$search = array_keys($list);
				$values = array_values($list);
				$search = array_map('utf8_encode', $search);

				$str_out = str_replace($search, $values, $str_in);
				return $str_out;
			}
			
			function getHtmlElementArray($HMTL, $selector, $context) {
				$elementArray = array();
				foreach($HMTL->find($selector) as $e) {
					$elementArray[] = $e->$context;
				}
				return $elementArray;
			}
			
			function getHtmlTocDate($volIss) {
				$tocHTML = file_get_html('html/'.$volIss.'.toc.html');
				$HTMLdesc = array();
				foreach($tocHTML->find('div[id=issueDescription] p') as $e) {
					$HTMLdesc[] = $e->innertext;
				}
				$descParts = explode(':', $HTMLdesc[0]);
				return $descParts[0];
			}
			
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
			
			function credits() {
						# LOAD XML FILE 
						$XML = new DOMDocument(); 
						$XML->load( 'docs/About.xml' );
						
						# Remove text (leaving only teiHeader)
						$TEI = $XML->documentElement;
						$text = $TEI->getElementsByTagName('text')->item(0);
						$TEI->removeChild($text);

						# START XSLT 
						$xslt = new XSLTProcessor(); 
						$XSL = new DOMDocument(); 
						$XSL->load( 'xsl/quarterly.xsl'); 
						$xslt->importStylesheet( $XSL ); 
						#PRINT 
						print $xslt->transformToXML( $XML ); 
			}
			
			function adv_search($q, $searchFields, $fields, $types) {
							global $articleTypes;
			
							echo '<div id="search-advanced-holder">';
							echo '<h4 class="search-advanced-heading">Advanced search options</h4>';
							echo '<div id="search-advanced" class="collapse" >';
							echo '<form action="search" method="get">';
							echo '<h4>Keywords:</h4>';
							echo '<input name="q" type="search" value="'.$q.'" /><br/>';
							
							echo '<h4>Search only within these fields:</h4>';
							foreach($searchFields as $key => $name) {
								$checked = '';
								if(in_array($key, $fields)) {
									$checked = 'checked="checked"';
								}
								echo '<label><input type="checkbox" name="field[]" value="'.$key.'" '.$checked.' />'.$name.'</label><br/>';
							}
							
							echo '<h4>Filter search by type of content:</h4>';
							foreach($articleTypes as $type) {
								$checked = '';
								if(in_array($type['keys'][0], $types)) {
									$checked = 'checked="checked"';
								}
								echo '<label><input type="checkbox" name="type[]" value="'.$type['keys'][0].'" '.$checked.' />'.$type['name'].'</label><br/>';
							}
							echo '<button type="submit">Search</button>';
							echo '</form>';
							echo '</div>';
							echo '</div>';
			}
			
			function typeNameShort ($key) {
				global $articleTypes;
				
				$nameShort = $key;
				foreach($articleTypes as $type) {
					if(in_array($key, $type['keys'])) {
						$nameShort = $type['nameShort'];
					}
				}
				return $nameShort;
			}
?>
