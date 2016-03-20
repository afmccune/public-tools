<?php

			function htmlentities_savetags($str_in) {
				$singleQuote = "SoLuthienOverthrewSauronWithSong";
				$doubleQuote = "EarendilWasAMariner";
				$lessThan = "FarOverTheMistyMountainsCold";
				$greaterThan = "NineForMortalMenDoomedToDie";
				$ampersand = "TheRoadGoesEverOnAndOn";
				
				$codes = array();
				$codes["'"] = $singleQuote;
				$codes['"'] = $doubleQuote;
				$codes['<'] = $lessThan;
				$codes['>'] = $greaterThan;
				$codes['&amp;'] = $ampersand;
				
				$search = array_keys($codes);
				$values = array_values($codes);
				$search = array_map('utf8_encode', $search);

				$str_out = str_replace($search, $values, $str_in);
				
				$str_out = mb_convert_encoding($str_out, 'UTF-8', 'WINDOWS-1252'); 
				$str_out = htmlentities($str_out, ENT_HTML5, "UTF-8");
				
				$str_out = str_replace($values, $search, $str_in); 
				
				return $str_out;
			}
			
			function htmlentities_savetags_original($str_in) {
				$list = get_html_translation_table(HTML_ENTITIES);
				unset($list["'"]);
				unset($list['"']);
				unset($list['<']);
				unset($list['>']);
				unset($list['&']);
				$list['​'] = '&#8203;'; // Zero Width Space
				$list['﻿'] = '&#65279;'; // Byte Order Mark
				$list[' '] = ''; // ?
				$list['А'] = '&#1040;'; // Cyrillic alphabet
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
				$list['ſ'] = '&#383;'; // Long s
				$list['Ć'] = '&#262;'; // Extended Roman characters
				$list['ć'] = '&#263;';
				$list['Č'] = '&#268;';
				$list['č'] = '&#269;';
				$list['Đ'] = '&#272;';
				$list['đ'] = '&#273;';
				$list['Š'] = '&#352;';
				$list['š'] = '&#353;';
				$list['Ž'] = '&#381;';
				$list['ž'] = '&#382;';
				$list['ǚ'] = '&#474;';
				$list['Ă'] = '&#258;';
				$list['ă'] = '&#259;';
				$list['Ș'] = '&#x218;';
				$list['ș'] = '&#x219;';
				$list['Ț'] = '&#538;';
				$list['ț'] = '&#539;';
				$list['Ḳ'] = '&#7730;';
				$list['ḳ'] = '&#7731;';
				$list['א'] = '&#1488;'; // Hebrew alphabet
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
				$list['ְ'] = '&#1456;'; // Hebrew vowels and special characters
				$list['ִ'] = '&#1460;';
				$list['ֵ'] = '&#1461;';
				$list['ֶ'] = '&#1462;';
				$list['ַ'] = '&#1463;';
				$list['ָ'] = '&#1464;';
				$list['ֹ'] = '&#1465;';
				$list['ֺ'] = '&#1466;';
				$list['ֻ'] = '&#1467;';
				$list['ּ'] = '&#1468;';
				$list['耿'] = '&#32831;'; // Selected Chinese, Japanese and Korean ideographs
				$list['力'] = '&#21147;';
				$list['平'] = '&#24179;';
				$list['ʼ'] = '&#700;'; // modifier apostrophe / glottal stop
				$list['ʻ'] = '&#699;'; // turned comma / okina
				$list['̣'] = '&#803;'; // combining dot below
				
				$search = array_keys($list);
				$values = array_values($list);
				$search = array_map('utf8_encode', $search);

				$str_out = str_replace($search, $values, $str_in);
				return $str_out;
			}
		
			function strip_special_chars($str_in) {
				$list = get_html_translation_table(HTML_ENTITIES);
				//print_r($list);
				unset($list["'"]);
				unset($list['"']);
				unset($list['<']);
				unset($list['>']);
				unset($list['&']);
				unset($list['[']);
				unset($list[']']);
				unset($list['-']);
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

				//$str_out = mb_str_replace($search, $values, $str_in);
				$str_out = mb_str_replace($search, '', $str_in);

				return $str_out;
			}
			
			

			/**
			 * Replace all occurrences of the search string with the replacement string.
			 *
			 * @author Sean Murphy <sean@iamseanmurphy.com>
			 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
			 * @license http://creativecommons.org/publicdomain/zero/1.0/
			 * @link http://php.net/manual/function.str-replace.php
			 *
			 * @param mixed $search
			 * @param mixed $replace
			 * @param mixed $subject
			 * @param int $count
			 * @return mixed
			 */
			if (!function_exists('mb_str_replace')) {
				function mb_str_replace($search, $replace, $subject, &$count = 0) {
					if (!is_array($subject)) {
						// Normalize $search and $replace so they are both arrays of the same length
						$searches = is_array($search) ? array_values($search) : array($search);
						$replacements = is_array($replace) ? array_values($replace) : array($replace);
						$replacements = array_pad($replacements, count($searches), '');
						foreach ($searches as $key => $search) {
							$parts = mb_split(preg_quote($search), $subject);
							$count += count($parts) - 1;
							$subject = implode($replacements[$key], $parts);
						}
					} else {
						// Call mb_str_replace for each subject in array, recursively
						foreach ($subject as $key => $value) {
							$subject[$key] = mb_str_replace($search, $replace, $value, $count);
						}
					}
					return $subject;
				}
			}


			
			function contains_any_multibyte($string)
			{
				return !mb_check_encoding($string, 'ASCII') && mb_check_encoding($string, 'UTF-8');
			}

print('<h1>Handle special chars with HTML entities (not working)</h1>');

$str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0115)http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>William Blake and His Circle: A Checklist of Publications and Discoveries in 2014 | Bentley, Jr. | Blake/An Illustrated Quarterly</title>
	
	<meta name="description" content="William Blake and His Circle: A Checklist of Publications and Discoveries in 2014">
	
	
	<link rel="schema.DC" href="http://purl.org.libproxy.lib.unc.edu/dc/elements/1.1/">

	<meta name="DC.Contributor.Sponsor" xml:lang="en" content="">
	<meta name="DC.Creator.PersonalName" content="G. E. Bentley">
	<meta name="DC.Creator.PersonalName" content="Jr.">
	<meta name="DC.Date.available" scheme="ISO8601" content="2020-07-23">
	<meta name="DC.Date.created" scheme="ISO8601" content="2015-06-02">
	<meta name="DC.Date.dateSubmitted" scheme="ISO8601" content="2015-06-02">
	<meta name="DC.Date.issued" scheme="ISO8601" content="2015-07-23">
	<meta name="DC.Date.modified" scheme="ISO8601" content="2015-07-23">
	<meta name="DC.Description" xml:lang="en" content="">
	<meta name="DC.Format" scheme="IMT" content="text/html">		
	<meta name="DC.Format" scheme="IMT" content="application/pdf">		
	<meta name="DC.Identifier" content="bentley491">
		<meta name="DC.Identifier.URI" content="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491">
	<meta name="DC.Language" scheme="ISO639-1" content="en">
	<meta name="DC.Source" content="Blake/An Illustrated Quarterly">
	<meta name="DC.Source.Issue" content="1">
	<meta name="DC.Source.URI" content="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake">
	<meta name="DC.Source.Volume" content="49">
	<meta name="DC.Title" content="William Blake and His Circle: A Checklist of Publications and Discoveries in 2014">
		<meta name="DC.Type" content="Text.Serial.Journal">
	<meta name="DC.Type.articleType" content="Articles">	
		<meta name="gs_meta_revision" content="1.1">
	<meta name="citation_journal_title" content="Blake/An Illustrated Quarterly">
        <meta name="citation_author" content="G. E. Bentley, Jr.">
	
<meta name="citation_title" content="William Blake and His Circle: A Checklist of Publications and Discoveries in 2014">

	<meta name="citation_date" content="2015/06/02">

	<meta name="citation_volume" content="49">
	<meta name="citation_issue" content="1">
		<meta name="citation_abstract_html_url" content="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491">
	<meta name="citation_language" content="en">
	<meta name="citation_fulltext_html_url" content="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html">
	<meta name="citation_pdf_url" content="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/download/bentley491/pdf">
	
<link rel="stylesheet" type="text/css" href="./49.1.bentley_files/articleViewFix.css">
	<link rel="stylesheet" href="./49.1.bentley_files/pkp.css" type="text/css">
	<link rel="stylesheet" href="./49.1.bentley_files/common.css" type="text/css">
	<link rel="stylesheet" href="./49.1.bentley_files/common(1).css" type="text/css">
	<link rel="stylesheet" href="./49.1.bentley_files/articleView.css" type="text/css">
			<link rel="stylesheet" href="./49.1.bentley_files/rtEmbedded.css" type="text/css">
	
	
	
	<link rel="stylesheet" href="./49.1.bentley_files/sidebar.css" type="text/css">	<link rel="stylesheet" href="./49.1.bentley_files/leftSidebar.css" type="text/css">		
			<link rel="stylesheet" href="./49.1.bentley_files/classicRed.css" type="text/css">
			<link rel="stylesheet" href="./49.1.bentley_files/journalStyleSheet.css" type="text/css">
	
	<!-- Base Jquery -->
	<script type="text/javascript" src="./49.1.bentley_files/jsapi"></script>
	<script type="text/javascript">
		// Provide a local fallback if the CDN cannot be reached
		if (typeof google == "undefined") {
			document.write(unescape("%3Cscript src="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/lib/pkp/js/lib/jquery/jquery.min.js" type="text/javascript"%3E%3C/script%3E"));
			document.write(unescape("%3Cscript src="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/lib/pkp/js/lib/jquery/plugins/jqueryUi.min.js" type="text/javascript"%3E%3C/script%3E"));
		} else {
			google.load("jquery", "1.4.2");
			google.load("jqueryui", "1.8.1");
		}
	</script><script src="./49.1.bentley_files/jquery.min.js" type="text/javascript"></script><script src="./49.1.bentley_files/jquery-ui.min.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="./49.1.bentley_files/jquery.cookie.js"></script>
	<script type="text/javascript" src="./49.1.bentley_files/fontController.js"></script>
	<script type="text/javascript">
		$(function(){
			fontSize("#sizer", "body", 9, 16, 32, "/blakeojs"); // Initialize the font sizer
		});
	</script>


	<script type="text/javascript" src="./49.1.bentley_files/general.js"></script>
	
	<script language="javascript" type="text/javascript" src="./49.1.bentley_files/articleView.js"></script>
	<script language="javascript" type="text/javascript" src="./49.1.bentley_files/pdfobject.js"></script>

</head>
<body id="49.1.bentley"  class="articleView">

<div id="container">
<div id="fade" class="black_overlay"></div>
<div id="header">
<div id="headerTitle">
<h1>
	<div id="altHeader"><div id="altImage"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs"><img src="homeHeaderTitleImage_en_US.flv" alt=""></a></div><div id="userNav"><div id="altSearch"><form action="http://128.151.244.100/blakeojs/index.php/blake/search/advancedResults" enctype="application/x-www-form-urlencoded" method="post"><table border="0"><tbody><tr><td><select class="selectMenu" name="searchField" size="1"> <option label="All" selected="selected">All</option> <option label="Authors" value="1">Authors</option> <option label="Title" value="2">Title</option> <option label="Abstract" value="4">Abstract</option> <option label="Full Text" value="128">Full Text</option></select></td><td><input id="query" class="textField2" title="SEARCH ISSUES" maxlength="255" name="query" size="15" type="text"></td><td><input class="button" type="submit" value="Search Issues"></td></tr></tbody></table></form></div><div id="altBrowse"><ul><li class="browseBy">Browse:</li><li><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/archive">By Issue</a></li><li><span class="bDivide">|</span><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/search/authors">By Author</a></li><li><span class="bDivide">|</span><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/search/titles">By Title</a></li></ul></div></div></div>
</h1>
</div>
</div>

<div id="body">

	<div id="sidebar">
					<div id="leftSidebar">
				<div class="block" id="sidebarSubscription">
	<span class="blockTitle">Subscription</span>
							Access provided by: <strong>UNC Chapel Hill</strong><br>From: 152.2.176.242<br>
		</div>
			</div>
					</div>

<div id="main">



<div id="headerSubscription">
	<span class="hide">Subscription</span>
					
			Access provided by: <strong>UNC Chapel Hill</strong><br>

		<span class="hide">From: 152.2.176.242<br></span>
					
		</div>
<div id="userbar">
<ul>
					<li id="login"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/login">LOG IN</a></li>
			<li id="register"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/user/register">Register</a></li>

		</ul>
</div>
<div id="navbar">
	<ul class="menu">
		<li id="home"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/index">Home</a></li>

			<span class="navdiv"> | </span> <li id="current"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/current">current issue</a></li>
			<span class="navdiv"> | </span> <li id="archives"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/archive">back issues</a></li>
            <span class="navdiv"> | </span><li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/public/journals/2/index.html" target="_blank">index</a></li>
		
		
					<span class="navdiv"> | </span><li id="subscribe"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/about/subscriptions?journal=">subscribe</a></li><span class="navdiv2"> | </span>

		 


					<li id="search"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/search">Search</a></li>
		
		

					<li id="announcements"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/announcement">Announcements</a></li>
				

									<span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/submit">submit</a></li>
												<span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/relatedsites">related sites</a></li>
												<span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/BonusContent">Bonus Content</a></li>
					<span class="navdiv"> | </span><li id="navItem"><a target="_blank" href="https://blakearchive-wordpress-com.libproxy.lib.unc.edu/">BLOG</a></li>
<span class="navdiv"> | </span> <li id="about"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/About" }"="">About</a></li> 
<span class="navdiv"> | </span><li id="contact2"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/Contact">help</a></li>

	</ul>
</div>
<div id="breadcrumb">
	<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/index" target="_parent">Home</a> &gt;
	<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/view/56" target="_parent">Vol. 49, No. 1</a> &gt;	<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html" class="current" target="_parent">Bentley, Jr.</a>
</div>

<div id="content">

			



<title>William Blake and His Circle: A Checklist of Publications and Discoveries in 2014</title>
<style type="text/css">
<!--
#articlecontent {
position: relative;
top: 20px;
left: 30px;
padding-bottom: 50px;
width: 600px;
counter-reset: sidenote;
font: 16px/25px Georgia, "Times New Roman", Times, serif;
text-align: left;
}
td, th {
vertical-align:top;
}
p.mainheading {
text-align:center;
font-weight: bold;
font-size: 16px;
margin-top: 40px;
}
p.mainheading+p.mainheading {
margin-top: 0;
}
p.reviewheading {
text-align:center;
font-weight: normal;
font-size: 16px;
margin-bottom: 0;
margin-top: 0;
}
p.gapcenter {
text-align:center;
font-weight: normal;
font-size: 16px;
margin-bottom: 0px;
margin-top: 30px;
}
p.reviewheading+p.gapcenter {margin-top: 0}
p.gapleft {
text-align:left;
font-weight: bold;
font-size: 16px;
margin-top: 30px;
}
p.gapleftnormal {
text-align:left;
font-weight: normal;
font-size: 16px;
margin-top: 30px;
margin-bottom: 0;
}
.header {
font-family: Georgia, "Times New Roman", Times, serif;
text-align: left;
padding-bottom:10px;
padding-left: 10px;
padding-right: 10px;
border-top:1px solid #7E7E7E;
border-bottom:2px solid #000000;
}
.title {
font-size: 24px;
line-height: 40px;
text-align: center;
}
.byline {
font-size: 20px;
line-height: 35px;
font-variant: small-caps;
text-align: center;
}
.note {
font-size: 14px;
line-height: 1.5;
color: #202020;
}
.ednote {
font-size: 14px;
line-height: 1.5;
color: #202020;
font-style: italic
}
a:link {
text-decoration: none;
color: #818181;
font-weight: 100;
}
a:visited {
text-decoration: none;
color: #818181;
font-weight: 100;
}
a:active {
text-decoration: none;
color: #818181;
font-weight: 100;
}
a:hover {
text-decoration: underline;
color: #818181;
font-weight: 100;
}
p.author {
margin-bottom: 0;
margin-top: 30px;
}
p.desc {
text-indent: 15px;
margin-top: 0;
margin-bottom: 0;
}
.left {
text-align: left;
}
.bottom {
vertical-align: bottom
}
.totals {
font-weight:bold;
}
.sections {
margin-top: 20px;
margin-left: 50px;
line-height: 2;
}
sup { line-height: 0; vertical-align: super; font-size: 0.7em; }
sub { line-height: 0; vertical-align: sub; font-size: 0.7em; }
#sections, #abbreviations {
width:600px;
border-collapse:collapse;
margin-top:0;
margin-left:0;
margin-bottom:0;
line-height:1.5;
}
#collections {
width:600px;
border-collapse:collapse;
margin-top:0;
margin-left:0;
margin-bottom:0;
text-align: left;
}
#Songs {
width:600px;
border-collapse: collapse;
font-size: 14px;
line-height: 1.5;
margin-top:0px;
margin-left:0;
margin-bottom:10px;
text-align: left;
}
#Marriage {
width:200px;
border-collapse:collapse;
font-size: 14px;
line-height: 1.75;
margin-top:0px;
margin-left:0;
margin-bottom:0px;
text-align: left;
}
#Designs, #costs {
margin: auto;
border-collapse:collapse;
font-size: 14px;
line-height: 1.5;
margin-top:10px;
margin-bottom:10px;
text-align: left;
}
#distribution {
width: 600px;
border-collapse:collapse;
font-size: 14px;
line-height: 1.5;
margin-top:0px;
margin-bottom:10px;
text-align: left;
}
#stats {
width: 600px;
text-align: right;
font-size:14px;
line-height: 1.75;
}
caption {
padding-bottom: 10px;
font-size:16px;
}
span.fn {
float:right;
margin-right: -375px;
margin-left: 75px;
clear: right;
width: 300px;
text-align: left;
font-weight: normal;
font-style: normal;
font-size: 14px;
line-height: 21px;
text-indent: 0;
margin-top: .5ex;
margin-bottom: 10px;
}
span.fn:before {
content: counter(sidenote) ". ";
counter-increment: none;
}
span.notecall:after {
font-weight: normal;
font-style: normal;
font-size: 9pt;
content: "\a0["counter(sidenote)"]";
counter-increment: sidenote;
vertical-align: super;
line-height: 0;
}
.text {
counter-reset: paragraph;
}
.text p:before {
position: absolute;
margin-left: -25px;
content: counter(paragraph);
counter-increment: paragraph;
}
.text p.gapleft:before {
content: none;
}
p.subtitle {
font-weight:bold;
}
.text p.subtitle:before {
content: none;
}
.sites p:before {
content: none;
}
.text p.gapcenter:before {
content: none;
}
.text p.reviewheading:before {
content: none;
}
.text p.reviewheading+p {
margin-top: 0
}
.tablenote {
font-weight: normal;
font-size: 9pt;
vertical-align: super;
line-height: 0;
}
.footnotes {
font-weight: normal;
font-size: 14px;
line-height: 1.5;
background-color: #f0f0f0;
padding: 10px 5px 10px 10px;
}
.discoveries {
margin-top: 20px;
padding-left: 20px;
}
.text .discoveries p:before {
content: none
}
div.illus {
margin-top: 30px;
margin-bottom: 40px;
text-align: center;
}
div.illus div, div.float div {
font: 14px/1.75 Georgia, "Times New Roman", Times, serif;
text-align: left;
background-color: #f0f0f0;
margin: 20px 0px 0px 0px;
padding: 10px;
}
span .fnp, div.illus div span.fnp, .ednote span.fnp {text-indent: 15px; margin-top: 0; display: inline-block}
div.illus a:hover {background-color: #f0f0f0;}
div.float { float: left; margin-top: 30px; margin-bottom: 30px; }
.clear { clear: left; }
table.lot {border-collapse: collapse;}
td.lotnumber {width: 35px; padding-left: 15px; text-align: left; vertical-align: top;}
td.lottext {padding-left: 10px; text-align: left; vertical-align: top;}
span.extract {
 display: block;
 margin-top: 15px;
 margin-bottom: 15px;
 font-size: 14px;
 line-height:1.5;
 padding-left: 30px;
 padding-right: 30px;
}
span.extract span.fn {margin-right: -405px;}
:lang(he) {
font: 20px/25px "Times New Roman", Times, serif;
letter-spacing: normal;
white-space: nowrap;}
span.dot1 {display: inline-block; padding-left: 2px; vertical-align: 0; position: relative; bottom: .35ex;}
span.dot2 {display: inline-block; vertical-align: 0; position: relative; bottom: .35ex;}
span.dot3 {vertical-align: 0; position: relative; right: 10px;}
span.dot4 {vertical-align: 0; position: relative; right: 1px; bottom: .35ex;}
:lang(he) {
font: 20px/25px "Times New Roman", Times, serif;
letter-spacing: normal;
white-space: nowrap;}
.Flaxman td {vertical-align: bottom}
.endnotes {
	font-size: 14px;
	line-height: 21px;
	margin-top: 50px;
}
-->
</style>
<script language="javascript">
var popupWindow = null;
function positionedPopup(url,winName,w,h,t,l,scroll){
settings =
"height="+h+",width="+w+",top="+t+",left="+l+",scrollbars="+scroll+",resizable"
popupWindow = window.open(url,winName,settings)
}
</script>


<div id="articlecontent">
<div class="header">
<p class="title">William Blake and His Circle:<br> A Checklist of Publications and Discoveries in 2014</p>
<p class="byline">By G. E. Bentley, Jr.<br>
<img src="1116.jpg" width="288" height="130" style="text-align: center; margin-top: 15px; margin-bottom: 15px"><br>
with the assistance of Hikari Sato <img src="1117.jpg" width="24" height="24" style="vertical-align: text-bottom"> for Japanese publications,<br>
of Li-Ping Geng 耿力平 for Chinese publications,<br>
and of Fernando Castanedo for Spanish publications</p>
<p class="note">G. E. B<span style="font-variant: small-caps; font-size: 16px; line-height: 21px; color: #202020">entley</span>, J<span style="font-variant: small-caps; font-size: 16px; line-height: 21px; color: #202020">r</span>., (<a href="mailto:gbentley@chass.utoronto.ca">gbentley@chass.utoronto.ca</a>) has a book forthcoming from University of Toronto Press and articles upcoming in <em>Language. Philology. Culture</em> (in Russian) and <em>Blake</em>.</p>
<p class="ednote" style="margin-top: 30px">Editors’ notes:<br>
The invaluable Bentley checklist has grown to the point where we are unable to publish it in its entirety. All the material will be incorporated into the cumulative “William Blake and His Circle” and “Sale Catalogues of William Blake’s Works” on the <a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">Bentley Blake Collection</a> site, Victoria University in the University of Toronto. The article below includes previously unrecorded copy, binding, and history information for the works of Blake and his circle, catalogues and editions from the last ten years (2005 on), and criticism from the last ten years and prior to the publication of Gilchrist’s <span style="font-style: normal">Life</span> (1863).</p>
<p class="ednote">A number of entries below have a link to an online article or catalogue. Some such items are freely accessible, and others may be behind a subscription barrier, depending on your or your institution’s access. All are included on the ground that even those with restricted access often provide a freely available abstract or excerpt.</p>
<p class="ednote"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/public/journals/2/BonusFeatures/Addenda/BR2addenda.htm" target="_blank">Addenda and corrigenda</a> to <span style="font-style: normal">Blake Records</span>, 2nd ed. (2004), now appear online. They are updated yearly in conjunction with the publication of the checklist.</p>
</div>
<div class="sections">
<p class="author"><strong>Table of Contents:</strong></p>
<p class="author"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Introduction">Introductory Essay</a>
</p><div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Symbols">Symbols</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Abbreviations">Abbreviations</a></div>
<p></p>
<p class="author"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#DivisionI">Division I: William Blake</a><br>
</p><div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartI">Part I: Blake’s Writings</a></div>
<div style="margin-left: 50px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIA">Section A: Original Editions, Facsimiles, Reprints, and Translations</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIB">Section B: Collections and Selections</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIappendix">Appendix: Writings Improbably Alleged to Be by Blake</a></div>
<div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartII">Part II: Reproductions of Drawings and Paintings</a></div>
<div style="margin-left: 50px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIIA">Section A: Illustrations of Individual Authors</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIIB">Section B: Collections and Selections</a></div>
<div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIII">Part III: Commercial Engravings</a></div>
<div style="margin-left: 50px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIIIA">Section A: Illustrations of Individual Authors</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIIIappendix">Appendix: Books Improbably Alleged to Have Blake Engravings</a></div>
<div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIV">Part IV: Catalogues and Bibliographies</a></div>
<div style="margin-left: 50px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIVA">Section A: Individual Catalogues</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIVB">Section B: Collections and Selections</a></div>
<div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartV">Part V: Books Owned by William Blake the Poet</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartVI">Part VI: Criticism, Biography, and Scholarly Studies</a></div>
<p></p>
<p class="author"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#DivisionII">Division II: Blake’s Circle</a><br>
</p><div style="margin-left: 40px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Barry">Barry, James</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Butts">Butts, Thomas</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Cumberland">Cumberland, George</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Flaxman">Flaxman, John</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Frost">Frost, William Edward</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Fuseli">Fuseli, John Henry</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Hayley">Hayley, William</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Johnson">Johnson, Joseph</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Linnell">Linnell, John</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Stedman">Stedman, John Gabriel</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Tatham">Tatham, Frederick</a><br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Watson">Watson, Caroline</a><br></div>
<p></p>
</div>
<div class="text">
<p class="subtitle" style="padding-top:30px"><a name="Introduction" id="Introduction"></a>Blake Publications and Discoveries in 2014</p>

<p>The checklist of Blake publications in 2014 includes works in Chinese, French, German, Japanese, Portuguese, Romanian, Russian, Serbian, Spanish, and Swedish, and there are newly recorded doctoral dissertations from Cornell, Glasgow, Kragujevac, Ochanomizu, Pompeu Fabra [Barcelona], and Salford.</p>
<p>An electronic resource new to me is <em>EThOS</em> (<em>Electronic Theses Online Service</em>) &lt;﻿<a href="http://ethos.bl.uk.libproxy.lib.unc.edu/" target="_blank">http://​ethos.​bl.​uk</a>﻿&gt;, mounted by the British Library. It records 380,000 British theses, including a number on William Blake—but not that of GEB (1956). In some cases the details given are pretty minimal, but in others the full text is available.</p>
<p>A curious series of electronic books was published by e-artnow in 2013–14. It includes Milton, <em>Das verlorene Paradies (Paradise Lost) mit Illustrationen von William Blake</em>, many illuminated books (as listed in Part I, Section A, below), and <span class="notecall"><em>The Complete Illuminated Books of William Blake</em>.</span><span class="fn">The series also includes <em>Job</em>, Blair’s <em>Grave</em>, and Flaxman’s <em>Odyssey</em>, but not <em>The Book of Los</em> and <em>On Homers Poetry</em> [and] <em>On Virgil</em>. It contains such classics as <em>Brunette Striptease</em> and the <em>Kama Sutra</em>.</span> Each work is said to be an “Illuminated Manuscript [<em>sic</em>] with the Original Illustrations of William Blake,” and each copy is said to be a “carefully crafted ebook.” The coloring in all Blake’s works reproduced seems dubious. The series appears to omit all Blake’s “Illuminated Manuscripts” such as <em>Tiriel</em> and <em>Vala</em> or <em>The Four Zoas</em>.</p>
<p>An Association William Blake &lt;﻿<a href="http://www.williamblake.fr/" target="_blank">http://​www.​williamblake.​fr</a>﻿&gt; was formed in France in August 2013 and an exhibition was held in Nérac (Aquitaine) 27 May–6 July 2014.</p>
<p>There was a flurry of newspaper articles on <span class="notecall">the sale of Blake’s cottage in Felpham,</span><span class="fn">See, for example, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Chainey">Chainey</a>, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Cripps">Cripps</a>, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Holledge">Holledge</a>, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Luyssen">Luyssen</a>, and <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Mackintosh">Mackintosh</a> in Part VI.</span> most of them highly derivative.</p>
<p>The exhibition of Blake at the Ashmolean Museum (Oxford) in 2014 stimulated a cataract of responses, the focus of which was often on the mock-up of Blake’s printing studio in Hercules Buildings, where he lived 1790–1800. Only a few of these responses are reported here, their frequently derivative character and vapidness discouraging further exploration. Most are exclamatory and a few dismissive. The valuable catalogue is profusely illustrated, including numerous manuscript documents about Blake. It does not, however, provide photographs of Blake’s studio, which created such a stir in the press.</p>
<p>A proof of a newly recorded engraving by Blake for the two title pages of Stedman’s <em>Surinam</em> (1796) was acquired in 2014 by Victoria University in the University of Toronto. Before that, the last Blake plates newly recorded were for Rees’s <em>Cyclopaedia</em>, pl. 3a (1819) &lt;﻿see <em>BBS</em> p. 246﻿&gt; and a relief etching <span class="notecall">for Virgil, <em>Pastorals</em> (1821).</span><span class="fn">See Robert N. Essick, “A Relief Etching of Blake’s Virgil Illustrations,” <em>Blake</em> 25.3 (winter 1991-92): 117-27.<span class="fnp">The print of “A Lady Embracing a Bust” (Stothard–Blake) was recorded in Essick, <em>The Separate Plates of William Blake: A Catalogue</em> (1983) 242-43, but the work in which it appeared, [Elizabeth Blower], <em>Maria: A Novel</em> (1785), was identified first in &lt;﻿<a href="http://bq.blakearchive.org.libproxy.lib.unc.edu/pdf/034-04.pdf" target="_blank"><em>Blake</em> (2001)</a>﻿&gt;, pp. 138-40.</span></span></p>
<p><em>Songs of Innocence and of Experience</em> (i), a posthumous copy watermarked with fragments of J W<span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">hatman</span> | 1831, lacking ten of fifty-four prints, was also acquired by Victoria University in the University of Toronto. A curious feature of copy i is that one print (pl. 23) is watercolored <span class="notecall">(see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#1a">illus. 1a</a>),</span><span class="fn"><em>Songs</em> (i) pls. 1, 3, and 23 are reproduced in Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#1" target="_blank">illus. 1-3</a>. Essick describes the coloring of pl. 23 as “better, and more Blake-like, than one usually finds in tinted examples of posthumous copies of the <em>Songs</em>” (caption to illus. 3).</span> perhaps by Catherine Blake (d. 18 October 1831 [<em>BR</em>(2) 546]) or Frederick Tatham, who printed the posthumous copies of Blake’s works in illuminated printing. The coloring is distinct from the color-printed copy of the same etching in Victoria University in the University of Toronto (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#1b">illus 1b</a>). The public appearance of <em>Songs</em> (i), which was previously in private hands, has permitted the correction of minor errors in the account of it in <em>Blake Books</em>.</p>
<p class="gapcenter" style="margin-top: 20px; margin-bottom: 20px">* * * * * * * * *</p>
<p>The annual checklist of scholarship and discoveries concerning William Blake and his circle records publications and discoveries for the current year (say, 2014) and those for previous years that are not recorded in <em>Blake Books</em>, <em>Blake Books Supplement</em>, and “William Blake and His Circle.” Installments of “William Blake and His Circle” are continuations of <em>Blake Books</em> and <em>Blake Books Supplement</em>, with similar principles and conventions.</p>
<p>I have made no systematic attempt to record audio books and magazines, blogs, broadcasts on radio and television, <span class="notecall">broadsides,</span><span class="fn">For instance, a wood-engraved broadside of “Jerusalem” “From William Blake’s ‘Milton,’” signed “H. C. Whaite,” reproduced in Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#11" target="_blank">illus. 11.</a></span> <span class="notecall">calendars,</span><span class="fn">For example, <em><a href="http://www.flametreepublishing.com/Tate-William-Blake-wall-calendar-2015-Art-calendar.html" target="_blank">Tate William Blake Wall Calendar 2015</a></em> (Flame Tree Publishing, 2014); ISBN: 9781783610303.</span> <span class="notecall">cards,</span><span class="fn">For instance, a card (6.5 x 3.5 cm.) in the “Where Nature Ends” series depicting artists, with a colored reproduction of the Phillips portrait of Blake and a palette below it, “TOPPS 2014 | Allen &amp; Ginter’s,” the verso with a description of Blake (copy in Victoria University in the University of Toronto). The firm of Allen &amp; Ginter usually produces baseball cards.</span> CD-ROMs, chinaware, coffee mugs, comic books, computer printouts (unpublished), <span class="notecall">conferences,</span><span class="fn">For example, <a href="http://www.bbk.ac.uk/events-calendar/blake-the-flaxmans-and-romantic-sociability" target="_blank">Blake, the Flaxmans, and Romantic Sociability</a>, Birkbeck College, University of London, 18-19 July 2014.</span> DVDs, e-mails, festivals and lecture series, flash cards, furniture, interactive multimedia, jewelry, lectures on audiocassettes, lipstick, manuscripts about Blake, microforms, mosaics, movies, murals, music, notebooks (blank), novels merely tangentially about Blake, pageants, performances, pillows, places named after Blake, playing cards, plays, podcasts, poems about Blake, portraits, postcards, posters and individual pictures, recorded readings and singings, refrigerator magnets, stained-glass windows, stamps (postage and rubber), stickers, sweatshirts, tapestries, T-shirts, tattoos (temporary and permanent), tiles, typescripts (unpublished), video recordings, and web sites.</p>
<p>Research for this checklist was carried out particularly in the libraries of the University of Toronto and Victoria University in the University of Toronto, as well as with the electronic resources of <a href="http://copac.ac.uk.libproxy.lib.unc.edu/" target="_blank"><em>Copac</em></a>, <a href="http://www.google.com.libproxy.lib.unc.edu/" target="_blank"><em>Google</em></a>, <a href="http://books.google.com.libproxy.lib.unc.edu/" target="_blank"><em>Google Books</em></a>, <a href="http://scholar.google.com.libproxy.lib.unc.edu/" target="_blank"><em>Google Scholar</em></a>, and <a href="http://www.worldcat.org.libproxy.lib.unc.edu/" target="_blank"><em>WorldCat</em></a>. Works published in Japan were found in <a href="http://ci.nii.ac.jp.libproxy.lib.unc.edu/" target="_blank"><em>CiNii</em></a> (National Institute of Informatics Scholarly and Academic Information Navigator), the National Diet Library <a href="https://ndlopac-ndl-go-jp.libproxy.lib.unc.edu/" target="_blank">online catalogue</a>, Komaba Library and General Library of the University of Tokyo, and the National Diet Library. Information for works published in China derives from the National Library of China (Beijing). Research for works in Spanish was carried out in the Biblioteca Nacional de España.</p>
<p>I am grateful for assistance from Jeff Mertz (for reproductions of obscure essays), Robert N. Essick (particularly for an early sight of his “Blake in the Marketplace, 2014” for <em>Blake</em>), Sarah Jones (for superlative editing), and Morton D. Paley, as well as from my collaborators, Hikari Sato, Li-Ping Geng, and Fernando Castanedo.</p>
</div>
<a name="Symbols" id="Symbols"></a><p class="gapleft"><!--<span class="notecall">--><strong>Symbols</strong><!--</span><span class="fn">In the checklist, English translations of the titles of articles, books, and journals in other languages are contained in either parentheses or brackets. Parentheses indicate that the title is also included in English in the work; brackets that it is not.</span>--></p>
<table>
<tbody><tr>
<td>*</td>
<td style="padding-left:.25in">Works prefixed by an asterisk include one or more illustrations by Blake or depicting him. If there are more than 19, the number is specified. If the illustrations include all those for a work by Blake, say <em>Thel</em> or his illustrations to <em>L’ Allegro</em>, the work is identified.</td>
</tr>
<tr>
<td>§</td>
<td style="padding-left:.25in">Works preceded by a section mark are reported on second-hand authority.</td>
</tr>
</tbody></table>
<a name="Abbreviations" id="Abbreviations"></a><p class="gapleft">Abbreviations</p>
<table id="abbreviations">
<tbody><tr>
<td><em>BB</em></td>
<td style="padding-left:20px">G. E. Bentley, Jr., <em>Blake Books</em> (1977)</td>
</tr>
<tr>
<td><em>BBS</em></td>
<td style="padding-left:20px">G. E. Bentley, Jr., <em>Blake Books Supplement</em> (1995)</td>
</tr>
<tr>
<td><em>Blake</em></td>
<td style="padding-left:20px"><em>Blake/An Illustrated Quarterly</em></td>
</tr>
<tr>
<td width="125px">&lt;﻿<em>Blake</em> ([year])﻿&gt;</td>
<td style="padding-left:20px">The installment of “William Blake and His Circle” published in <em>Blake</em> in the year specified</td>
</tr>
<tr>
<td><em>BR</em>(2)</td>
<td style="padding-left:20px">G. E. Bentley, Jr., <em>Blake Records</em>, 2nd ed. (2004)</td>
</tr>
<tr>
<td>Butlin</td>
<td style="padding-left:20px">Martin Butlin, <em>The Paintings and Drawings of William Blake</em> (1981)</td>
</tr>
<tr>
<td>ISBN</td>
<td style="padding-left:20px">International Standard Book Number</td>
</tr>
</tbody></table>
<p class="desc" style="margin-top: 15px">Note that characters in works in Chinese, Japanese, and Russian have been transliterated to Roman script.</p>
<p class="desc">English translations of the titles of articles, books, and journals in other languages are often contained in either parentheses or brackets. Parentheses indicate that the title is also included in English in the work; brackets that it is not.</p>
<p class="mainheading"><a name="DivisionI" id="DivisionI"></a>Division I: William Blake</p>
<p class="mainheading"><a name="PartI" id="PartI"></a>Part I: Blake’s Writings</p>
<p class="mainheading"><a name="PartIA" id="PartIA"></a>Section A: Original Editions, Facsimiles, Reprints, and Translations</p>
<p class="ednote">Editors’ note:<br>
Please consult Bentley, “<a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">Sale Catalogues of William Blake’s Works</a>,” for further particulars of catalogues mentioned in this section.</p>
<p class="gapcenter">Table of Collections</p>
<p class="reviewheading">Addenda</p>
<table id="collections" cellpadding="3">
<tbody><tr style="background-color: #f0f0f0">
<td width="214"><em>Robert N. Essick</em></td>
<td width="374" style="padding-left:20px"><em>For Children: The Gates of Paradise</em> pl. 15</td>
</tr>
<tr>
<td><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">fitzwilliam museum</span></td>
<td style="padding-left:20px"><span style="display: inline-block; padding-left: 15px; text-indent: -15px">Letter 4 Nov. 1826 (Denny to Blake via Linnell); letter 25 Nov. 1827 (Cumberland to Catherine Blake)</span></td>
</tr>
<tr style="background-color: #f0f0f0">
<td><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">harvard</span></td>
<td style="padding-left:20px">Letter 7 Oct. 1803 (Blake to Hayley)</td>
</tr>
<!--<tr>
<td style="vertical-align: bottom"><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;"><span style="display: inline-block; padding-left: 15px; text-indent: -15px">national library of scotland</span></span></td>
<td style="padding-left:20px">Letter 25? Nov. 1825 (Blake to Linnell)</td>
</tr>-->
<tr>
<td style="vertical-align: bottom"><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;"><span style="display: inline-block; padding-left: 15px; text-indent: -15px">victoria university in the university of toronto</span></span></td>
<td style="padding-left:20px"><em>Songs</em> (i)</td>
</tr>
<tr style="background-color: #f0f0f0">
<td><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">yale</span></td>
<td style="padding-left:20px"><span style="display: inline-block; padding-left: 15px; text-indent: -15px">Letter autumn 1800? (Blake to Butts?) &lt;﻿see <em>BBS</em> pp. 93-94﻿&gt;</span></td>
</tr>
</tbody></table>

<p class="gapcenter">Private Owners and Public Institutions That Have Disposed of Original Blakes</p>
<p class="reviewheading">Addenda</p>
<table id="collections">
<tbody><tr style="background-color: #f0f0f0">
<td width="214"><em>Joan Linnell Ivimy Burton</em></td>
<td width="374" style="padding-left:20px">Letter 4 Nov. 1826; letter 25 Nov. 1827</td>
</tr>
<tr>
<td><em>Lord Cunliffe</em></td>
<td style="padding-left:20px"><em>Songs</em> (i)</td>
</tr>
<tr style="background-color: #f0f0f0">
<td><em>Mary Hyde</em></td>
<td style="padding-left:20px">Letter 7 Oct. 1803</td>
</tr>
</tbody></table>

<p class="gapcenter">Table of Watermarks</p>
<p class="reviewheading">Addendum</p>
<table id="collections" cellpadding="3" style="background-color: #f0f0f0">
<tbody><tr>
<td style="text-align: center"><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">J Whatman</span> | 1831<br>
<em>Songs of Innocence and of Experience</em> (i)</td>
</tr>
</tbody></table>

<p class="gapcenter"><em>All Religions are One</em> (1788?)</p>
<p class="desc">It is reproduced, presumably chiefly from the prints in the Huntington, in the e-artnow edition (2013) (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Religions"><em>All Religions are One</em> &amp; <em>There is No Natural Religion</em></a> in Part I, Section B) and in <em>Todas las religiones son una, No hay religión natural</em>, trans. David Francisco (2014) (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Todaslasreligiones"><em>Todas las religiones son una</em></a> in Part I, Section B).</p>

<p class="gapcenter"><em>America</em> (1793)</p>
Copy E<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="author">Copy M</p>
<p class="desc">It is reproduced in <em>Libros proféticos</em>, trans. Bernardo Santano, vol. 1  (2013) (see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Libros" target="_blank"><em>Blake</em> [2014]</a>﻿&gt;).</p>

<p class="gapcenter">Editions</p>
*<em>America a Prophecy (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844119.<br>
<p class="desc">Probably <em>America</em> (E)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">§<em>America: A Prophecy</em>. Charleston: BiblioLife, 2014. 44 pp.; ISBN: 9781293813065.</p>

<p class="gapcenter"><em>The Book of Ahania</em> (1795)</p>
Copy A<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>The Book of Ahania (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844157.<br>
<p class="desc">Probably <em>The Book of Ahania</em> (A)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>The Book of Thel</em> (1789)</p>
Copy N<br>
<p class="desc">It is reproduced in the <em>William Blake Archive</em> edition (2014), below.</p>

<p class="gapcenter">Editions</p>
*<em>The Book of Thel (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844058.<br>
<p class="desc">Probably <em>Thel</em> (F, H, or O)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">*<em>The Book of Thel</em> [N]. <a href="http://www.blakearchive.org.libproxy.lib.unc.edu/" target="_blank"><em>William Blake Archive</em></a>. Ed. Morris Eaves, Robert N. Essick, and Joseph Viscomi. 2014.</p>

<p class="gapcenter"><em>Europe</em> (1794)</p>
Copy B<br>
<p class="desc">It is reproduced in various sizes in the 2014-15 Ashmolean catalogue (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Ashmolean">2014 4 <span style="font-variant: small-caps;">December</span>–2015 1 <span style="font-variant: small-caps;">March</span></a> in Part IV, Section A).</p>

<p class="author">Copy E</p>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>Europe a Prophecy (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844102.<br>
<p class="desc">Probably <em>Europe</em> (E)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<a name="Fresco" id="Fresco"></a><p class="gapcenter">“Exhibition of Paintings in Fresco” (1809)</p>
Copy A<br>
History: Sold with Blake’s letter to Ozias Humphry of May 1809 at Sotheby’s, 3-4 June 1907, lot 385 [for £10.15.0 to B. F. Stevens].

<a anme="Fairy" id="Fairy"></a><p class="gapcenter">“A Fairy leapt” (1793)</p>
History: Acquired by Dante Gabriel Rossetti, from whom it passed to his brother William Michael Rossetti, who apparently gave it to his physician; James Rimell &amp; Son, <em>No. 288 Illustrated Catalogue of Rare Books</em> (London, 1933), lot 64, offered at £225 “A Fairy leapt upon my knee,” “1 page, small 4to.,” reproduced, the first two lines quoted, with, on the verso, a pencil sketch of <em>The Infant Hercules Throttling the Serpents</em> &lt;﻿Butlin #253﻿&gt;, plus another leaf with a pencil sketch for “‘L<span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">os in his rage</span>’” &lt;﻿Butlin #561 verso﻿&gt;, 
<span class="extract">engraved as a decoration for the lower half of page 6 of “Jerusalem,” 1804 (8 x 6¼ inches); <em>on reverse</em>:--<br>
P<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">encil</span> S<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">ketch</span>, also with ruled scale lines for engraving, his interpretation of Fuseli’s design for S<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">hakespeare’s</span> H<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">enry</span> VIII, Act IV, Scene II, “Queen Katherine Awakening from her dream” [&lt;﻿Butlin #561 recto﻿&gt;], which Blake engraved for Chalmers’ Shakespeare, 1805 (vol. 7, p. 235).</span>
<p class="desc">The two leaves were “‘given by William Rossetti, taken from the collection of Blake Manuscripts which had been in possession of Dante Gabriel Rossetti,’ in return for professional services rendered to William Rossetti’s daughter when she dislocated her arm. <span class="notecall">A written declaration of authenticity by the late owner-recipient to this effect will be passed to the purchaser.”</span><span class="fn">These leaves are now at the US National Gallery.</span>

</p><p class="gapcenter"><em>The First Book of Urizen</em> (1794)</p>
Copy A<br>
<p class="desc">It is reproduced in <em>Libros proféticos</em>, trans. Bernardo Santano, vol. 1  (2013) (see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Libros" target="_blank"><em>Blake</em> [2014]</a>﻿&gt;).</p>

<p class="author">Copy G</p>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="author">Plate 9<br>
History: Given by Dorothy Braude Edinburg in 2012 to the Art Institute of Chicago (inventory number 2012.74), where it is reproduced <a href="http://www.artic.edu/aic/collections/artwork/151451?search_no=1&amp;index=0" target="_blank">online</a>.</p>

<p class="gapcenter">Edition</p>
*<em>The</em> [First] <em>Book of Urizen (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844096.
<p class="desc">Probably <em>Urizen</em> (G)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>For Children: The Gates of Paradise</em> (1793)</p>
<p class="reviewheading">Edition</p>
*<em>For Children: The Gates of Paradise (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844133.
<p class="desc">Probably <em>For Children</em> (A or D)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>For the Sexes: The Gates of Paradise</em> ([1826?])</p>
Copy K<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>For the Sexes: The Gates of Paradise (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844188.
<p class="desc">Probably <em>For the Sexes</em> (K)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>The Ghost of Abel</em> (1822)</p>
Copy A<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>The Ghost of Abel: A Revelation in the Visions of Jehovah Seen by William Blake (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844195.
<p class="desc">Probably <em>The Ghost of Abel</em> (A)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>An Island in the Moon</em> (1784?)</p>
<p class="reviewheading">Edition</p>
*<em>Una isla en la luna</em>. Edición bilingüe de Fernando Castanedo. Traducción de Fernando Castanedo. Madrid: Cátedra, 2014. Colección Letras Universales. 8º, 239 pp., 88 illustrations, including all of <em>An Island in the Moon</em> and the formation of letters and words in it; ISBN: 9788437633343. English and Spanish on facing pages.<br>
<span style="display: block; text-align: center">“Introducción”</span>
“Vida de William Blake.” 9-37.<br>
“<em>Una isla en la luna</em> [description of the text].” 38-41.<br>
“Fecha de composición.” 41-48.<br>
“Historia y características del manuscrito.” 48-54.<br>
“La inscripción a lápiz del folio 9 recto.” 54-66.<br>
“Género literario.” 66-71.<br>
“La laguna fingida.” 71-79.<br>
*“<em>Una isla en la luna</em>: lo ordinario y lo respetable.” 79-86.<br>
“Esta edición.” 87-89.<br>
“Bibliografía.” 91-99.<br><br>
Text of <em>An Island</em>. 100-209.<br>
“Manuscrito de <em>Una isla en la luna</em>” [reduced-size color reproductions of the manuscript, 8.3 x 14.0 cm. vs. 18.3 x 30.8 cm. in the original]. 211-30. He argues for 1786 as the date of composition and attributes to Blake the diagonal pencil inscription on f. 9r.<br>
“Apéndice 1” [texts of “Holy Thursday,” “Nurse’s Song,” and “The Little Boy Lost” from <em>Songs of Innocence</em>]. 233-35.<br>
“Apéndice 2” [names of persons in <em>An Island</em> and of those they represent: “Quid the Cynic Quid el Cínico William Blake”]. 237-38.<br>
<p class="desc">A sophisticated and meticulous edition.</p>

<p class="gapcenter"><em>Jerusalem</em> (1804[–20])</p>
Copy I<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="author">Plate 6</p>
<p class="desc">See <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Fairy">“A Fairy leapt,”</a> above.

</p><p class="gapcenter">Editions</p>
<em>Jerusalem</em>. Ed. E. R. D. Maclagan and A. G. B. Russell. 1904. &lt;﻿<em>BB</em> #77﻿&gt;<br>
<p class="reviewheading">Review</p>
[John Bailey], <em>Times Literary Supplement</em> 6 May 1904. B. <a href="http://www.the-tls.co.uk/tls/public/article1365536.ece" target="_blank">Partially reprinted</a>, with the author’s name, in <em>Times Literary Supplement</em> 17 Jan. 2014: 16.

<p class="author">*<em>Jerusalem (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844171.</p>
<p class="desc">Probably <em>Jerusalem</em> (I)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter">Letters</p>
1800 1 April<br>
History: Offered in Quaritch Rough List 201 (Oct. 1900), lot 1077, for £5.5.0.<p></p>

<p class="author">1800 14 September<br>
History: Sold at Sotheby’s, 3-4 June 1907, lot 384 (partly quoted) [£15.10.0 to Pearson].</p>

<p class="author">1801 19 October<br>
History: According to the Rosenbach acquisition card, it was bought at the sale of William Harris Arnold at Anderson Galleries, 10-11 November 1924, lot 53, for <span class="notecall">“HKSNS” [$190.00],</span><span class="fn">Another price on the card is “hrsns” [$150.00]. <span class="fnp">Kathy Haas of the Rosenbach Library tells me that the Rosenbach price code was <span style="display: block; text-align: center; margin-bottom: 0">H O V E R Z A C K S [1 2 3 4 5 6 7 8 9 0].</span> In addition, “NS” means “.00,” “X” stands for a repeat of the previous non-zero digit, and “N” is used as an alternate “0.” The cards are typed, with ms. additions, particularly of customers to whom the work was offered. Occasionally they are clippings from sale catalogues.</span></span> and offered for $350.</p>

<p class="author">1804 22 June<br>
History: Sold at Sotheby’s, 3-4 June 1907, lot 383 (partly quoted) [£12.10.0 to Pearson].</p>

<p class="author">1809 May<br>
History: See <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Fresco">“Exhibition of Paintings in Fresco,”</a> above.</p>

<p class="author">1826 31 March<br>
History: Offered in Charles Boesen, <em>Rare Books, Manuscripts, Autograph, First Editions, Letters from the Estate of the Late Gabriel Wells Catalogue 1</em> (New York, 1948), lot 28, for $350, bought by Rosenbach (according to his acquisition card), and offered for <span class="notecall">$575.</span><span class="fn">I am puzzled by the card notes “12/26/50 | G. Wells Estate | OEARS” [$24,750].</span></p>

<p class="gapcenter">Editions</p>
<em>The Letters of William Blake, Together with a Life by Frederick Tatham</em>. Ed. A. G. B. Russell. 1906. &lt;﻿<em>BB</em> #88﻿&gt; C. §“Volume 1.” Charleston: BiblioLife, 2014. 312 pp.; ISBN: 9781295534098.<br>
<p class="desc">I have no record of a second volume for 2014.</p>

<p class="desc" style="margin-top: 30px">For letters published in 2014 by the <em>William Blake Archive</em>, see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Archive"><em>William Blake Archive</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>The Marriage of Heaven and Hell</em> ([1790–93?])</p>
Copy D<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Editions</p>
*<em>The Marriage of Heaven and Hell</em> [B]. Ed. Michael Phillips. 2011. &lt;﻿<em>Blake</em> (2012)﻿&gt;<br>
<p class="reviewheading">Review</p>
Julianne Simpson, <em>Library</em> 7th ser., 15.3 (Sept. 2014): 363 (one paragraph description).<br>

<p class="author">*<em>The Marriage of Heaven and Hell (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844065.
</p><p class="desc">Probably <em>Marriage</em> (D)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">§<em>The Marriage of Heaven and Hell</em>. Charleston: BiblioLife, 2014. 60 pp.; ISBN: 9781293809099.</p>

<p class="author">§*<em>The Marriage of Heaven and Hell</em>. Ed. Will Jonson. San Bernardino [California]: CreateSpace Independent Publishing Platform, 2014. 24 pp.; ISBN: 9781495923869.</p>

<p class="gapcenter"><em>Milton</em> (1804[–11?])</p>
Copy D<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Editions</p>
<em>Milton</em>. Ed. E. R. D. Maclagan and A. G. B. Russell. 1907, 1973. &lt;﻿<em>BB</em> #119, <em>BBS</em> p. 102﻿&gt; C. §2010. &lt;﻿§<em>Blake</em> (2011)﻿&gt; D. §Charleston: BiblioLife, 2014. 90 pp.; ISBN: 9781294798804.<br>

<p class="author">*<em>Milton a Poem (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844164.</p>
<p class="desc">Probably <em>Milton</em> (D)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter">Notebook</p>
<p class="desc">Blake’s Notebook seems to be reproduced entire in the British Library’s online <em>Discovering Literature: Romantics and Victorians</em> (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#BL">British Library</a> under Part I, Section B, below).</p>

<p class="gapcenter"><em>Poetical Sketches</em> (1783)</p>
<p class="reviewheading">Edition</p>
<em>Poetical Sketches. Now First Reprinted from the Original Edition of 1783</em>. Ed. Richard Herne Shepherd. 1868. &lt;﻿<em>BB</em> #129﻿&gt; B. §2009. &lt;﻿§<em>Blake</em> (2011)﻿&gt; C. §Charleston: Nabu Press, 2014. 116 pp.; ISBN: 9781295725236.

<p class="gapcenter"><em>The Song of Los</em> (1795)</p>
Copy B<br>
<p class="desc">It is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>The Song of Los (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844140.
<p class="desc">Probably <em>The Song of Los</em> (B)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>Songs of Experience</em> (1794)</p>
<p class="reviewheading">Edition</p>
*<em>Songs of Experience (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844089.
<p class="desc">Probably from <em>Songs</em> (C or Z)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em>Songs of Innocence</em> (1789)</p>
Copy B<br>
<span style="display: inline-block; text-indent: 15px">It is probably reproduced in the e-artnow edition (2013), below.</span><br>
History: W. E. Moss sold it at Sotheby’s, 2 March 1937, lot 143, <span class="notecall">for £750 to Rosenbach &lt;﻿<em>BB</em> p. 405﻿&gt;.</span><span class="fn">According to the Rosenbach acquisition card, it was bought for stock, not on commission from Rosenwald. The card says: “full red levant morocco,” “HZAR” [$1675], “?Sold Mrs Isaac Hieste[?] | [words illeg.] D[?] cat[?] 7/37.” However, <em>Innocence</em> (B) is in brown blind-stamped russia.</span><p></p>

<p class="author">Copy L</p>
<p class="desc">It is reproduced in the <em>William Blake Archive</em> edition (2014), below.</p>

<p class="gapcenter">Editions</p>
*<em>Songs of Innocence</em>. With illustrations by Geraldine Morris. 1902. &lt;﻿<em>BB</em> #149﻿&gt; B. §Charleston: BiblioLife, 2014. 68 pp.; ISBN: 9781293456392.<br>

<p class="author">*<em>Songs of Innocence (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844027.</p>
<p class="desc">Probably <em>Songs of Innocence</em> (B)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">*<em>Songs of Innocence</em> [L, “never before reproduced”]. <a href="http://www.blakearchive.org.libproxy.lib.unc.edu/" target="_blank"><em>William Blake Archive</em></a>. Ed. Morris Eaves, Robert N. Essick, and Joseph Viscomi. 2014.</p>

<p class="gapcenter"><em>Songs of Innocence and of Experience</em> (1794[–1831])</p>
<p class="reviewheading">Table</p>
<table cellpadding="10" id="Songs">
  <tbody><tr style="background-color: #f0f0f0">
   <th width="85">Copy</th>
   <th width="85">Plates<br> missing<br> or added</th>
   <th width="30">Leaves</th>
   <th width="235">Watermarks</th>
   <th width="35">Blake<br> nos.</th>
   <th width="80">Leaf size<br> in cm.</th>
   <th width="50">Printing<br> color</th>
  </tr>
  <tr>
   <td>i<br>
    <span style="font-variant: small-caps">victoria university in the university of toronto</span></td>
   <td>-12, 15, 30-32, 44-45, 47, 50-51</td>
   <td>44</td>
   <td><span style="font-variant: small-caps">Whatman</span> | 1831<br> (pl. 39);<span class="tablenote">&nbsp;<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fna1" name="fra1" id="fra1">[a]</a></span><br>
   <span style="font-variant: small-caps">J Wh</span> | 18<br> (pls. 6, 13, 28);<br>
   <span style="font-variant: small-caps">J Wh</span> | 1<br> (pls. 19, 29);<br>
   <span style="font-variant: small-caps">J Wh</span><br> (pl. 14);<br>
   J W<br> (pls. 11, 20);<br>
   <span style="font-variant: small-caps">hatman</span> | 1831<br> (pls. 16-17);<br>
   <span style="font-variant: small-caps">atman</span> | 831<br> (pls. 8, 10, 22, 27, 33);<br>
   <span style="font-variant: small-caps">tman</span> | 831<br> (pl. 42)
   </td>
   <td>—</td>
   <td>19.8 x 24.1<span class="tablenote">&nbsp;<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fna2" name="fra2" id="fra2">[b]</a></span></td>
   <td>Gray<span class="tablenote">&nbsp;<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fna3" name="fra3" id="fra3">[c]</a></span></td>
  </tr>
 </tbody></table>
<div class="footnotes">
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fra1" name="fna1" id="fna1">a</a>. <em>BB</em> p. 371 says that the watermark is an undifferentiated <span style="font-variant: small-caps">J Whatman</span> | 1831 on pls. 6, 8, 10-11, 14, 16-17, 19-20, 22, 24, 27-29, 33, 39, 42<!--, omitting pl. 13-->.<br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fra2" name="fna2" id="fna2">b</a>. All the edges are a trifle ragged, and therefore the dimensions are not quite uniform. <em>BB</em> p. 374, note 47, says that pl. 48 is on thinner paper than the other leaves, but this does not seem to be the case. The paper is quite thick.<br>
<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#fra3" name="fna3" id="fna3">c</a>. The color is often very faint, though the text is exceptionally clear. A few plates shade to black. There is heavy embossing, especially on the title pages.</div>

<p class="gapcenter">Order of the Plates in <em>Songs of Innocence and of Experience</em></p>
<p class="reviewheading"><em>Innocence</em></p>
<span class="notecall">Copy i</span><span class="fn">The prints are loose, but the pencil numeration at the top right corner gives the order. Pls. 13 and 37 have a pencil note at the top right: “Qy[?]? Does this not belong to Songs of Experience” (no, yes). <em>BB</em> gives erroneous pencil pagination for both <em>Innocence</em> and <em>Experience</em>.</span> <span style="padding-left: 25px">1-11, 37, 13-14, 16-25, 48, 26-27</span>
<p class="reviewheading"><em>Experience</em></p>
<span class="notecall">Copy i</span><span class="fn">The prints are loose, but the pencil numeration at the top right corner gives the order. Pl. 34 is numbered “<span style="text-decoration: line-through">50</span> 31,” pl. 39 is numbered “<span style="text-decoration: line-through">39</span> 35,” and pl. 54 “<span style="text-decoration: line-through">43 last</span> 44.” <em>BB</em> gives erroneous pencil pagination for both <em>Innocence</em> and <em>Experience</em>.</span> <span style="padding-left: 25px">28, 33, 29, 34-36, 38-43, 46, 49, 52-54</span>

<p class="author">Copy i<br>
Binding: Loose, never sewn, printed on one side only. The uncut prints regularly show the irrelevant borders. The last verso (pl. 54) is somewhat browned.
</p><p class="desc">The prints are uncolored except for pl. 23 (“Spring,” second print), where the text is watercolored faintly pink, yellow, and gray, the vines green, the orange-haired child is strongly pink, his sky blue, his ground green (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#1a">illus. 1a</a>). Compare the color-printed copy of the design only in Victoria University in the University of Toronto, in which the child’s hair is brown and the sky pale blue (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#1b">illus 1b</a>).</p>
<p class="desc">The copperplate-maker’s mark (“LONDON”) is clearly visible at the top left of pl. 28 (the frontispiece to <em>Experience</em>). This is not visible in copies printed by the Blakes.</p>
History: It was sold for a descendant of Henry Cunliffe (1826-94) on 18 June 2014 at Bonhams (London), lot 73 [to Victoria University in the University of Toronto] (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Bonhams">2014 18 <span style="font-variant: small-caps;">June</span></a> in Part IV, Section A).<p></p>

<a name="1a" id="1a"></a><div class="illus"><img src="1109.jpg" width="600" height="702">
<div>1a. “Spring” (<em>Songs of Innocence and of Experience</em> [i], pl. 23), unwatermarked but among prints watermarked 1831 (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewFile/153/bentley491html/1110" onclick="positionedPopup(this.href,&#39;myWindow&#39;,&#39;600&#39;,&#39;785&#39;,&#39;50&#39;,&#39;600&#39;,&#39;yes&#39;);return false">enlargement</a>). 7.7 x 10.5 cm. on leaf approximately 19.8 x 24.1 cm. The somewhat simplistic coloring could therefore have been added before 1831 by Catherine Blake (d. 18 October 1831), or by an anonymous hand before or after 1831 (Victoria University in the University of Toronto).</div>
</div>

<a name="1b" id="1b"></a><div class="illus"><img src="1111.jpg" width="600" height="379">
<div>1b. “Spring” (<em>Songs</em> pl. 23), color printed about 1796 (Victoria University in the University of Toronto) (see &lt;﻿<a href="http://bq.blakearchive.org.libproxy.lib.unc.edu/pdfs/43.1.pdf" target="_blank"><em>Blake</em> [2009]</a>﻿&gt;).</div>
</div>

<p class="gapcenter">Editions</p>
*<em>Facsimile of the Original Outlines before Colouring of the Songs of Innocence and of Experience</em> [U]. 1893. &lt;﻿<em>BB</em> #173﻿&gt; B. §<em>Facsimile of What Is Believed to Be the Last Replica of the Songs of Innocence and of Experience</em>. 2012. &lt;﻿<em>Blake</em> (2014)﻿&gt; C. Charleston: BiblioLife, 2014. 146 pp.; ISBN: 9781294573968.<br>

<p class="author">§<em>Songs of Innocence and of Experience</em>. Ed. Ramji Lall. New Delhi: Rama Brothers, 2006.</p>

<p class="author">§<em>Songs of Innocence and</em> [<em>of</em>] <em>Experience</em>. Trans. Iana Maravis. Bilingual ed. Bucharest: Rao Publishing, 2006. In English and Romanian.</p>

<p class="author"><em>William Blake’s Songs of Innocence and</em> [<em>of</em>] <em>Experience Illustrated by Robert Crayola “Shewing the Two Contrary States of the Human Soul.”</em> 2011. &lt;﻿§<em>Blake</em> (2013)﻿&gt;</p>
Robert Crayola. “Epilogue.” 99. (“William Blake was referred to by other Romantic poets as ‘the cool, old man’ of the group. … Had he escaped the assassin’s bullet that prematurely took his life, William Blake would turn 254 this year.”)<br>
Rachel Yee. “Afterword.” 101.<br>
Robert Crayola. “Note on the Afterword.” 103-04.<br>
Rachel Yee. “A Commentary on the Illustrations: For Elucidation and Pleasure.” 105-13.<br>
Robert Crayola. “Postscript to the Commentary.” 115.<br>
Anon. “An Interview with Robert Crayola.” 117-19.<br>
Robert Crayola. “An Interview with William Blake (via Ouija Board).” 121-22.<br>
Anon. “About the Author [i.e., William Blake].” 123.<br>
Anon. “About the Artist.” 125-26.<br>

<p class="author">*<em>Songs of Innocence and of Experience Showing</em> [<em>sic</em>] <em>the Two Contrary States of the Human Soul (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844041.</p>
<p class="desc">Probably <em>Songs of Innocence and of Experience</em> (C or Z)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">§<em>Songs of Innocence and Songs of Experience by William Blake</em>. [San Bernardino (California): CreateSpace Independent Publishing Platform, 2013]. [43 pp.]; ISBN: 9781483929538.</p>

<p class="author">§*<em>Songs of Innocence and of Experience</em>. London: Urban Romantics, 2014. ISBN: 9781910150528.</p>
<p class="desc">The only reproduction, from <em>Oberon, Titania, and Puck with Fairies Dancing</em> &lt;﻿Butlin #161﻿&gt;, is on the cover.</p> 

<p class="gapcenter"><em>There is No Natural Religion</em> (1788?)</p>
<p class="desc">It is reproduced in the e-artnow edition (2013) (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Religions"><em>All Religions are One</em> &amp; <em>There is No Natural Religion</em></a> in Part I, Section B) and in <em>Todas las religiones son una, No hay religión natural</em>, trans. David Francisco (2014) (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Todaslasreligiones"><em>Todas las religiones son una</em></a> in Part I, Section B).</p>

<p class="gapcenter"><em>Visions of the Daughters of Albion</em> (1793)</p>
Copy J<br>
<p class="desc">It is reproduced in <em>Libros proféticos</em>, trans. Bernardo Santano, vol. 1  (2013) (see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Libros" target="_blank"><em>Blake</em> [2014]</a>﻿&gt;), and it is probably reproduced in the e-artnow edition (2013), below.</p>

<p class="gapcenter">Edition</p>
*<em>Visions of the Daughters of Albion (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844072.
<p class="desc">Probably <em>Visions</em> (J)—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="mainheading"><a name="PartIB" id="PartIB"></a>Section B: Collections and Selections</p>
<p class="gapcenter">Blake’s Works Reprinted in Conventional Typography before 1863</p>
 <p class="reviewheading">Addendum</p>
 <p class="reviewheading">1831</p>
 “To the Muses” (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Cameos">below</a>).<br>
 
<p class="gapcenter" style="margin-top: 20px; margin-bottom: 20px">* * * * * * * * *</p>
<a name="Religions" id="Religions"></a><p class="author" style="margin-top: 20px">*<em>All Religions are One</em> &amp; <em>There is No Natural Religion (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake)</em>. e-artnow, 2013. ISBN: 9788074844126.</p>
<p class="desc"><em>All Religions are One</em> must be from the unique copy in the Huntington Library (A), and <em>There is No Natural Religion</em> is probably from copy C or F—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a>, below.</p>

<p class="author"><em>Blake: Poems</em>. Selected by Peter Washington. 1994. &lt;﻿<em>Blake</em> (1995)﻿&gt; B. §New York: Knopf–Random House, 2014. ISBN: 9780375712555.</p>

<a name="BL" id="BL"></a><p class="gapcenter">British Library online</p>
<p class="reviewheading"><a href="http://www.bl.uk.libproxy.lib.unc.edu/romantics-and-victorians" target="_blank"><em>Discovering Literature: Romantics and Victorians</em></a></p>
<p class="desc">Under Blake, the collection is very miscellaneous, many items having nothing to do with him. It includes <em>Songs of Innocence and of Experience</em> (1923 Liverpool facsimile—the library does not have an original colored copy of the <em>Songs</em>); Malkin, <em>A Father’s Memoirs</em> (1806), only pp. xxviii-xxx with “Holy Thursday” from <em>Innocence</em>; letters of 6 Dec. 1795, 23 Dec. 1796, and 19 Dec. 1808; Blake’s Notebook (seems to be entire); and <em>Vala</em> (seems not to be entire).</p>
<p class="desc">There are associated essays:</p>
*Linda Freedman. “Blake’s Two Chimney Sweepers.”<br>
*Linda Freedman. “Looking at the Manuscript of William Blake’s ‘London.’”<br>
*Andrew Lincoln. “William Blake’s Radical Politics.”<br>
*George Norton. “An Introduction to ‘The Tyger.’”<br>
*George Norton. “William Blake’s Chimney Sweeper Poems: A Close Reading.”<br>
*Michael Phillips. “The Title Page of William Blake’s <em>Songs of Innocence</em> (1789).”<br>
*Julian Walker. “The Music of William Blake’s Poetry.”<br>
*Julian Walker. “William Blake and Eighteenth-Century Children’s Literature.”<br>
<p class="desc">There are also accompanying lessons.</p>

<a name="Complete" id="Complete"></a><p class="author">*<em>The Complete Illuminated Books of William Blake (Unabridged—With All the Original Illustrations)</em>. e-artnow, 2013. ISBN: 9788074844034.</p>
<p class="desc">“Images are taken from books in the Lessing J. Rosenwald Collection of the Library of Congress.” The Library of Congress collection includes <em>America</em> (E), <em>The Book of Ahania</em> (A*), <em>The Book of Thel</em> (F*, H*, O*), <em>Europe</em> (E*), <em>The First Book of Urizen</em> (G*), <em>For Children: The Gates of Paradise</em> (A, D), <em>For the Sexes: The Gates of Paradise</em> (K), <em>The Ghost of Abel</em> (A), <em>Jerusalem</em> (I), <em>The Marriage of Heaven and Hell</em> (D*), <em>Milton</em> (D*), <em>The Song of Los</em> (B*), <em>Songs of Innocence</em> (B*), <em>Songs of Innocence and of Experience</em> (C*, Z*), <em>There is No Natural Religion</em> <span class="notecall">(C*, F*),</span><span class="fn">Copy F consists of nineteenth-century reproductions, except for pl. a7, which is genuine.</span> <em>Visions of the Daughters of Albion</em> (J*) (* = colored).</p>
<p class="desc">The e-artnow series also includes <em>All Religions are One</em>, the only copy of which is in the Huntington Library, Blake’s illustrations for <em>Paradise Lost</em>, the only complete set of which in one location is in the Huntington Library &lt;﻿Butlin #529﻿&gt;, and the engravings for <em>Job</em> (1826) and Blair’s <em>Grave</em>, copies of both of which are in the Library of Congress. The <em>Complete Illuminated Books</em> omits <em>The Book of Los</em>, the only copy of which is in the British Museum.</p>

<p class="author">§<em>El demonio es parco: aforismos</em>. Selected and trans. Heriberto Yépez. Mexico City: Editorial Verdehalago, 2006. 69 pp.; ISBN: 9789689103103. In Spanish.</p>
Yépez. “Introducción.” 7-15.<br>
<em>Todas las religiones son una</em>. 19-21.<br>
<em>No hay ninguna religión natural</em>. 23-26.<br>
“De <em>Las bodas del cielo y el infierno</em>.” 27-34.<br>
<em>Augurios de la inocencia</em>. 35-40.<br>
<em>Laocoonte</em>. 41-46.<br>
“Los comentarios proféticos de W. Blake.” 47-56.<br>
<em>Sobre la poesía de Homero</em>. 57-58.<br>
<em>Sobre Virgilio</em>. 59.<br>

<p class="author"><em>The Everlasting Gospel &amp; Other Poems</em>. Ed. Sasha Newborn. Santa Barbara: Bandanna Books, 2011. 8º, 68 pp.; ISBN: 9780942208078.</p>
<p class="desc">The “other poems” are <em>There is No Natural Religion</em> (35-37), <em>All Religions are One</em> (38-39), and <em>The Marriage of Heaven and Hell</em> (40-68) [which of course are not “poems”]. According to the preface ([i-ii]), “This text has been modernized where practicable, replacing antiquated usages such as <em>thee</em> and <em>thine</em> with <em>you</em> and <em>your</em>. More problematic in editing for modern readers is Blake’s use of ‘man’ and ‘men’ to describe humanity. In his visual art, Blake portrays men and women with a clear eye, but, fair warning: his language is not as equitable.”</p>

<p class="author">*<em>Libros proféticos</em> I [-II]. Trans. Bernardo Santano. Vilaür [Girona]: Atalanta, 2013 [2014, vol. 2]. Colección Imaginatio vera 80 [84, vol. 2]. 4º, 704 pp. [618 pp., vol. 2]; ISBN: 9788494094156 [9788494227622, vol. 2]. 127 color reproductions in vol. 1 and 72 in vol. 2.</p>
<p class="desc">For volume 1, see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Libros" target="_blank"><em>Blake</em> (2014)</a>﻿&gt;. 
</p><p class="desc">Volume 2 contains *<em>Milton: poema en dos libros</em> (9-162), with 22 (of 50) reproductions from copy D; <em>Jerusalén: la Emanación del Gigante Albion</em> (163-517), with 50 (of 100) reproductions from copy I; Bernardo Santano, “Glosario” (519-616) (largely from Damon, <em>A Blake Dictionary</em>).</p>
<p class="reviewheading">Review (of vol. 1)</p>
*Adriana Díaz Enciso, “<a href="http://www.milenio.com/cultura/metodo-profecia-William-Blake_0_203380178.html" target="_blank">El método de profecía de William Blake</a>,” <em>Milenio</em> [Mexico City] 7 Dec. 2013 (in Spanish), reprinted as “<a href="http://www.blakesociety.org/wp-content/uploads/2014/01/William-Blakes-Method-of-Prophecy.pdf" target="_blank">William Blake’s Method of Prophecy</a>” on the Blake Society web site (a “vast and outstanding … feat”; “All the illustrations are neatly and faithfully reproduced”; “This edition of William Blake’s Prophetic Books in Spanish is one of the most important publishing events in that language for decades.”)
<p class="reviewheading">Reviews (of vol. 2)</p>
*Maica Rivera, “Cómo ser William Blake,” <em>Leer</em> no. 249 (Feb. 2014): 76-77 (in Spanish).<br>
*Antonio Lucas, “Los delirios de un visionario,” <em>El Mundo</em> [Madrid] 22 April 2014: 39-41 (in Spanish).<br>

<p class="author">§<em>Poemas y prosas. Símbolos y fuentes</em>. Selected and trans. Cristóbal Serra. Palma de Mallorca: Edicions Cort, 2010. In Spanish.</p>

<p class="author">*<em>The Poems of William Blake</em>. Ed. W. H. Stevenson. 1971, 1972. &lt;﻿<em>BB</em> #296A-B﻿&gt; C. <em>Blake: The Complete Poems</em>. 2nd ed. 1989. &lt;﻿<em>BBS</em> p. 161﻿&gt; D. 3rd ed. 2007. &lt;﻿<em>Blake</em> (2008)﻿&gt; E. 2014.

</p><p class="author">§<em>Poems of William Blake</em>. [San Bernardino (California): CreateSpace Independent Publishing Platform, 2013]. 65 pp.; ISBN: 9781482717655.</p>

<p class="author">§<em>Poesía Completa</em>. Trans. Andrés Maldonado. Buenos Aires: Editorial Cygnus, 2012. 256 pp.; ISBN: 9789872398446. In Spanish.</p>

<p class="author">*<em>The Poetical Works of William Blake, Lyrical and Miscellaneous</em>. Ed. William Michael Rossetti. 1874 …. &lt;﻿<em>BB</em> #299, <em>BBS</em> p. 162, <em>Blake</em> (2009)﻿&gt; §﻿[Whitefish (Montana)]: Literary Licensing LLC, 2014. 372 pp.; ISBN: 9781498054133.</p>

<p class="author">§<em>Proverbs of Hell</em>. Images by James Putnam Abbott. N.p.: Blurb, 2014. ISBN: 9781320905183.</p>

<p class="author">§<em>Selected Poems by William Blake</em>. [San Bernardino (California): CreateSpace Independent Publishing Platform, 2013]. 40 pp.; ISBN: 9781483928876.</p>

<p class="author">§<em>Songs of Life</em>. Illus. Mark Sheeky. N.p.: Pentangel Books, 2014. ISBN: 9780957194724.</p>

<p class="author">§<em>Tiger, Tiger Burning Bright Journal: Famous Manuscripts, the Tyger</em>. Cover art by Cheryl Casey. N.p.: CreateSpace Independent Publishing Platform, 2014. 6 x 9″, 200 pp.; ISBN: 9781500839703.</p>
<p class="desc">Blake’s poem is followed by “lined pages … for creative writing, personal reflection, song writing, wherever the imagination leads.”</p>

<a name="Todaslasreligiones" id="Todaslasreligiones"></a><p class="author">*<em>Todas las religiones son una, No hay religión natural</em>. Trans. David Francisco. Zaragoza: Pregunta Ediciones, 2014. 12º, 80 pp.; ISBN: 9788494304422. English text with Spanish translation on versos facing reproductions.</p>
<em>Todas las religiones son una</em>. 7-27.<br>
<em>No hay religión natural</em>. 29-69.<br>
David Francisco. “Nota a la edición.” 71-73.<br>

<a name="Cameos" id="Cameos"></a><p class="author">“To the Muses.” <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=XdCdXKMOJS4C&amp;pg=PR1#v=onepage&amp;q&amp;f=false" target="_blank">CAMEOS | FROM THE ANTIQUE;</a> | OR, THE | CABINET OF MYTHOLOGY: | SELECTIONS ILLUSTRATIVE | OF THE | MYTHOLOGY OF GREECE AND ITALY, | FOR THE USE OF CHILDREN, | AND INTENDED AS | A SEQUEL TO THE POETICAL PRIMER. | = | BY MRS. LAWRENCE. | — | “The task is a humble one, but not mean; for to lay the first stone of | a noble building is no disgrace to any hand.” | — | LIVERPOOL: | <span class="notecall">EVANS, CHEGWIN AND HALL,</span><span class="fn">Colophon (p. 175): “Printed by Evans, Chegwin &amp; Hall.”</span> CASTLE-STREET; | AND | LONGMAN, REES AND CO., LONDON. | — | 1831. <span class="notecall">&lt;﻿Bodleian, Harvard, Robert N. Essick﻿&gt;</span><span class="fn">The work was generously called to my attention by Robert N. Essick in July 2014.</span><br>
B. <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=XsUDAAAAQAAJ&amp;pg=PR1#v=onepage&amp;q&amp;f=false" target="_blank">… <em>for the Use of Young Persons</em> …</a>. 2nd ed., rev. Liverpool: Deighton and Laughton; London: Whittaker and Co., 1849. &lt;﻿<em>Blake</em> (2010)﻿&gt;</p>
<p class="desc">In 1831, “To the Muses” is retitled “THE POET COMPLAINS TO THE MUSES | OF THE DECLINE OF POETRY,” and the author is identified only on contents p. xii: “The Poet’s Complaint to the Muses …… <em>Blake</em> 75.” According to the preface ([v]), Rose Lawrence had to “alter and modify them [the poems] as might best suit their peculiar purpose.” All her modifications seem to be merely stylistic (“ancient” for “antient,” “crystal” for “chryſtal,” “heaven” for “Heav’n,” “poesie” for “Poetry!”) except “now” for “do” (line 15) and “bottom” for “boſom” (line 10). The last alteration was presumably made from motives of delicacy, though even “bottom” could be the subject of risible adolescent fancy. She also added a footnote to “Ida’s”: “A mountain of Crete.”</p>
<p class="desc">The only previous reprint of “To the Muses” was in [H. C. Robinson], <em>Vaterländisches Museum</em> (1811) (<em>BR</em>[2] 585), but there the even-numbered lines are not indented as they are in <em>Poetical Sketches</em> (1783) and <em>Cameos</em>. The evidence is not clear, but the obscurity of <em>Vaterländisches Museum</em> and the fact that Lawrence indents even-numbered lines, as Blake did but Robinson did not, suggest to me that she is quoting directly from <em>Poetical Sketches</em>.</p>

<a name="Archive" id="Archive"></a><p class="author"><em>William Blake Archive</em> &lt;﻿<a href="http://www.blakearchive.org.libproxy.lib.unc.edu/" target="_blank">http://​www.​blakearchive.​org</a>﻿&gt;</p>
<p class="desc"><em>The Book of Thel</em> (N), <em>Songs of Innocence</em> (L), a selection of letters for 1800 to 1805, <em>Enoch Walked with God</em>, preliminary pencil sketches, monochrome wash drawings, and watercolor drawings for Blair’s <em>Grave</em>, the Blake collection list of the Cincinnati Art Museum, and back issues of <em>Blake</em> from 2000 to 2009 were added to the archive in 2014.</p>

<p class="author">*<em>The Works of William Blake, Poetic, Symbolic, and Critical</em>. Ed. E. J. Ellis and W. B. Yeats. 3 vols. 1893 …. &lt;﻿<em>BB</em> #369, <em>BBS</em> p. 169﻿&gt; D. §Charleston: BiblioBazaar, 2014. Vol. 1 [?], 452 pp.; ISBN: 9781295800438; vol. 2, 454 pp.; ISBN: 9781294642190 [vol. 3 with the lithographs is not listed].</p>

<p class="mainheading"><a name="PartIappendix" id="PartIappendix"></a>Appendix: Writings Improbably Alleged to Be by Blake</p>
<p class="gapcenter">Manuscript Newly Attributed to Blake</p>
<p class="reviewheading">Inscription for Hogarth’s <em>Beggar’s Opera</em> (1790)</p>
Description: A print of Blake’s engraving for Hogarth’s <em>Beggar’s Opera</em> is enclosed in a heavy frame with a “secret” compartment in which is a manuscript description of the actors, actresses, and spectators seated on the stage as they appear in Hogarth’s painting <span class="notecall">(they are described as clad “in Scarlet,” “in Brown,” and “in blue”).</span><span class="fn">All my information about the print, its frame, and the manuscript derives from the 2014 exhibition and from A. Furlan in correspondence with me.</span> The same text is printed with published versions of Hogarth’s prints.<br>
<p class="desc">The finished versions of Blake’s print bear the imprint “<em>Publish’d July 1.<sup>st</sup> 1790, by J. &amp; J. Boydell</em> ….” The imprint cannot be seen because the frame covers it.</p>
<p class="desc">The manuscript does not appear to me to be “in Blake’s own hand” (see History, below). Note, for instance, that the “C” for the Hogarth print goes below the line (“Clark,” “Collection,” “Charles,” “Cock,” “Cooke,” “Conyers” [2]), while Blake’s “C” of the same date does not go below the line (“Come” [2] and “Curse,” <em>Tiriel</em> [1789?], p. 1). The “F” for the Hogarth print has a downward flourish at the right end of the cross bar (“Filch,” “Fenton,” “From”), while in Blake there is no such flourish (“For” in <em>Tiriel</em>, p. 1).</p>
History: This may be the copy in Philip C. Duschnes <em>Catalogue Number 140</em> (New York, November 1959), lot 57, <em>Beggar’s Opera</em>, “State One,” “inscribed in Blake’s own hand, ‘Beggar’s Opera,’” “the <span class="notecall">Wolpe</span><span class="fn">Perhaps the owner was Stefan Wolpe (1902–72), a German composer who lived in New York from 1938.</span> copy,” $750; the print with its frame and manuscript were acquired at Butterfield Auctions (San Francisco), 23 June 1969, by Adrian Furlan (as he told me), who lent it to the exhibition at the Château de Nérac (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Hogarth">2014 27 <span style="font-variant: small-caps;">May</span>–6 <span style="font-variant: small-caps;">July</span></a> in Part IV, Section A), where it was the only work exhibited.<p></p>

<p class="gapcenter">Letter of Ozias Humphry to “D<sup>r</sup> William,” 15 June 1806</p>
<p class="desc">For details, see <em>BR</em>(2) xxvii, under “Seven Red Herrings.”</p>

<p class="gapcenter">Sophocles Manuscript</p>
<p class="desc">For details, see &lt;﻿<em>Blake</em> (1996)﻿&gt; (“The Sophocles Enigma” in Part I, Section A), and the articles by Michael Phillips and G. E. Bentley, Jr., in <em>Blake</em> 31.2 (fall 1997).</p>

<p class="mainheading"><a name="PartII" id="PartII"></a>Part II: Reproductions of Drawings and Paintings</p>
<p class="mainheading"><a name="PartIIA" id="PartIIA"></a>Section A: Illustrations of Individual Authors</p>

<p class="gapcenter">Bible</p>
<p class="reviewheading"><em>Genesis</em> (1826–27)</p>
<p class="reviewheading">Edition</p>
<em>*Genesis: William Blake’s Last Illuminated Work</em>. Ed. Mark Crosby and Robert N. Essick. 2012. &lt;﻿<em>Blake</em> (2013)﻿&gt;<br>
<p class="reviewheading">Review</p>
Morton D. Paley (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake482"><em>Blake</em> 48.2</a> in Part VI).<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Blair</span>, Robert, <em>The Grave</em> (1805)</p>
<p class="desc">For preliminary drawings added to the <em>William Blake Archive</em> in 2014, see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Archive"><em>William Blake Archive</em></a> in Part I, Section B.</p>
 
<p class="author" style="text-indent: 15px">A Rosenbach <span class="notecall">acquisition card records:</span><span class="fn">The card is a continuation of another, and it is not certain that the host work was Blair’s <em>Grave</em>.</span> “Inserted are two original sketches by Blake drawn on both sides of a sheet of paper. The more complete one is in ink and the one on the verso is in pencil. This one has a small part cut off and lacking. It is probably a tentative drawing of plate VI [“The Soul Hovering”] in the book as the idea differs very slightly. Also inserted is an engraving by Blake extracted from another book. AN EXTREMELY FINE COPY. 12/29 OXRNS [$225.00].” These drawings are apparently not in Butlin.</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Dante</span>, <em>Divine Comedy</em> (1826–27)</p>
<p class="desc">All the Dante watercolors are reproduced in <em>Los dibujos para la</em> Divina Comedia <em>de Dante</em>, ed. Sebastian Schütze and Maria Antonietta Terzoli (see below).</p>
<p class="gapcenter">Edition</p>
<a name="Dante" id="Dante"></a>*<em>Los dibujos para la</em> Divina Comedia <em>de Dante</em>. Ed. Sebastian Schütze and Maria Antonietta Terzoli. Cologne: Taschen, 2014. Folio (29.5 x 40.5 cm.), 324 pp.; ISBN: 9783836555166. Reproduces all 102 watercolors and all 7 prints. In Spanish. Also available in German, English, French, and Italian.<br>
Maria Antonietta Terzoli. “El más allá de Dante: entre mitología clásica y teología cristiana.” 6-31.<br>
Sebastian Schütze. “Dos maestros del ‘visibile parlare’: Dante y Blake.” 32-51.<br>
Sebastian Schütze. “William Blake. Catálogo de los grabados.” 310-17.<p></p>

<p class="gapcenter"><span style="font-variant: small-caps;">Gray</span>, Thomas, <em>Poems</em> (1797–98)</p>
<p class="desc">Blake’s watercolors, first added to the <em>William Blake Archive</em> in April 2005, were made fully searchable in September 2014.</p>

<p class="gapcenter">Edition</p>
*[<em>Poems of Thomas Gray with Watercolour Illustrations by William Blake</em>. London: Folio Society, 2013.] &lt;﻿<em>Blake</em> (2014)﻿&gt;<br>
<p class="reviewheading">Review</p>
*G. E. Bentley, Jr. (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake483"><em>Blake</em> 48.3</a> in Part VI).<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Milton</span>, John, <em>Paradise Lost</em></p>
<p class="reviewheading">Edition</p>
§*<em>Das verlorene Paradies (Paradise Lost) mit Illustrationen von William Blake</em>. Trans. Adolf Böttger. e-artnow, 2014. 448 pp.; ISBN: 9788026808794. In German.<br>
<p class="desc">Perhaps a silent translation of the edition of 1906 &lt;﻿<em>BB</em> #390﻿&gt;. The only complete set of Blake’s illustrations to <em>Paradise Lost</em> in one location is in the Huntington Library—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Virgil</span>, <em>Pastorals</em> (1821)</p>
<p class="reviewheading"><span class="notecall">A Cumulative List</span><span class="fn">The list of Virgil drawings is provided courtesy of Robert N. Essick.</span></p>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://data.fitzmuseum.cam.ac.uk/id/object/8859" target="_blank">Thenot Remonstrates with Colinet</a></em> &lt;﻿Butlin #769 1﻿&gt; Fitzwilliam Museum (Keynes Collection)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://www.blakearchive.org.libproxy.lib.unc.edu/exist/blake/archive/object.xq?objectid=but769.1.wd.02&amp;java=no" target="_blank">Thenot and Colinet Converse Seated beneath Two Trees</a></em> &lt;﻿#769 2﻿&gt; Robert N. Essick</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick474/essick474html#6" target="_blank">Colinet and Thenot, with Shepherds’ Crooks, Leaning against Trees</a></em> &lt;﻿#769 3﻿&gt; Robert N. Essick</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://www.themorgan.org/collection/William-Blakes-World/239" target="_blank">Colinet and Thenot Stand Together Conversing, Their Sheep Behind</a></em>, unused design &lt;﻿#769 4﻿&gt; Morgan Library and Museum</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Thenot, with Colinet Swaying His Arms in Sorrow</em> &lt;﻿#769 5﻿&gt; Untraced since 1924</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://data.fitzmuseum.cam.ac.uk/id/object/8858" target="_blank">The Blighted Corn</a></em> &lt;﻿#769 6﻿&gt; Fitzwilliam Museum (Keynes Collection)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://brbl-dl.library.yale.edu.libproxy.lib.unc.edu/vufind/Record/3726650" target="_blank">“Nor Fox, Nor Wolf, Nor Rat among Our Sheep”</a></em> &lt;﻿#769 7﻿&gt; Beinecke Library, Yale</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://ids.lib.harvard.edu.libproxy.lib.unc.edu/ids/view/46494762?buttons=y" target="_blank">Sabrina’s Silvery Flood</a></em> &lt;﻿#769 8﻿&gt; Houghton Library, Harvard</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://ids.lib.harvard.edu.libproxy.lib.unc.edu/ids/view/46494761?buttons=y" target="_blank">Colinet Passing a Milestone</a></em> &lt;﻿#769 9﻿&gt; Houghton Library, Harvard</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://www.blakearchive.org.libproxy.lib.unc.edu/exist/blake/archive/object.xq?objectid=but769.1.wd.05&amp;java=no" target="_blank">“A Rolling Stone Is Ever Bare of Moss”</a></em> &lt;﻿#769 10﻿&gt; Morgan Library and Museum</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Colinet Resting by a Stream by Night</em> &lt;﻿#769 11﻿&gt; Untraced since 1927</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Colinet with His Shepherd’s Pipe</em> &lt;﻿#769 12﻿&gt; Untraced since 1924</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://www.blakearchive.org.libproxy.lib.unc.edu/exist/blake/archive/object.xq?objectid=but769.1.wd.06&amp;java=no" target="_blank">“For Him Our Yearly Wakes and Feasts We Hold”</a></em> &lt;﻿#769 13﻿&gt; Robert N. Essick</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>First Comparison, Birds Flying over a Cornfield</em> &lt;﻿#769 14﻿&gt; Untraced since 1939</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://www.blakearchive.org.libproxy.lib.unc.edu/exist/blake/archive/object.xq?objectid=but769.1.wd.07&amp;java=no" target="_blank">Second Comparison, “The Briny Ocean Turns to Pastures Dry”</a></em> &lt;﻿#769 15﻿&gt; Morgan Library and Museum</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Third Comparison, A Winding River</em> &lt;﻿#769 16﻿&gt; Untraced since 1927</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Thenot and Colinet Leading Their Flocks Home Together at Sunset</em> &lt;﻿#769 17﻿&gt; Untraced since 1927</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>Thenot and Colinet at Supper</em> &lt;﻿#769 18﻿&gt; Untraced since 1924</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em>“With Songs the Jovial Hinds Return from Plow”</em> &lt;﻿#769 19﻿&gt; Maurice Sendak estate</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px"><em><a href="http://artmuseum.princeton.edu.libproxy.lib.unc.edu/collections/objects/5211" target="_blank">“And Unyok’d Heifers, Loitering Homewards, Low”</a></em> &lt;﻿#769 20﻿&gt; Princeton University Art Museum</span><br>

<p class="gapcenter"><span style="font-variant: small-caps;">Young</span>, Edward, <em>Night Thoughts</em> (1794–96)</p>
<p class="desc">Benedict, the bookbinder of the <em>Night Thoughts</em> watercolors, is one of the family of London bookbinders: Francis (fl. 1807–23), his sons Francis (fl. 1824–28) and Charles (fl. 1815–30) (Ellic Howe, <em>A List of London Bookbinders 1648–1815</em> [London: Bibliographical Society, 1950] 10).</p>

<p class="mainheading"><a name="PartIIB" id="PartIIB"></a>Section B: Collections and Selections</p>

<p class="gapcenter">Folio Blake-Varley Sketchbook (1819–25)</p>
<p class="desc">The visionary head of <em>A Man Wearing a Tall Hat</em> (not in Butlin), offered in Agnew’s <em>130<sup>th</sup> Annual Exhibition of Watercolours &amp; Drawings</em>, 5-28 March 2003, lot 18, 36 x 27.7 cm. (trimmed on right and left), may have come from the Folio Blake-Varley Sketchbook, whose leaves were c. 27 x 42 cm.</p>

<p class="author">*Binyon, Laurence. <em>The Drawings and Engravings of William Blake</em>. Ed. Geoffrey Holme. 1922 …. &lt;﻿<em>BB</em> #404, §<em>Blake</em> ﻿(2011, 2013)﻿&gt; E. §Charleston: Nabu Press, 2014. 290 pp.; ISBN: 9781295752362.</p>

<p class="mainheading"><a name="PartIII" id="PartIII"></a><span class="notecall">Part III: Commercial Engravings</span><span class="fn">From 2010 I record pre-1863 references to separately issued prints by Blake.</span></p>
<p class="mainheading"><a name="PartIIIA" id="PartIIIA"></a>Section A: Illustrations of Individual Authors</p>

<p class="ednote">Editors’ note:<br>
Please consult Bentley, “<a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">Sale Catalogues of William Blake’s Works</a>,” for further particulars of catalogues mentioned in this section.</p>

<p class="gapcenter">Bible</p>
 <p class="reviewheading"><span lang="he">ספר איוב</span>‎ <em>Illustrations of the Book of Job</em> (1826, 1874)</p>
1826 New Locations: Cincinnati Art Museum (india paper plus another plus pre-publication proofs of plates numbered 6-7 plus “plates 3, 8, 17 [numbered ‘2,’ ‘7,’ and ‘16’]”), Duke University, Trinity College (Oxford, given in 1899; see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Downing">Downing</a> in Part VI).<p></p>
<p class="author" style="text-indent: 15px">According to Rosenbach’s acquisition card, a copy in “original boards, with label, having on it an Ms. note: ‘---’s copy of proofs presented to G. Wyther, Esqr. by John Linnell, Dec. 2 1863,” “Horns” [$125.00], sale price “260.<sup>00</sup>,” was “sold to Mrs Landon K Thorne 2|25|63.”</p>
<p class="desc">Another copy was recorded on the Rosenbach acquisition card as “21 plates. Folio, green morocco. Inscribed on fly ‘Milton Riviere. This book came to me at my Father’s death in <span class="notecall">1876.</span><span class="fn">David Valentine Riviere, drawing master, subscribed to <em>Job</em> on 30 Sept. 1825 (£1.0.0), paying the balance (£1.12.6) on 29 April 1826 (<em>BR</em>[2] 784, 787).</span> He had it from Blake, having subscribed for it on its publication,’” “[fr. P. Hofer, on exchg.].”</p>
<p class="author">Proofs: “Illustrations to the Book of Job; 22 plates, artist’s proofs on india paper, large paper, with MS. draft of the binder’s label in the autograph of John Linnell, Senr. (the friend of Blake), with a note to the effect that ‘These plates are engraved by Mr. Blake with the graver only (that is without the aid of aqua fortis),’ bds. From the Collection of the late John Linnell, Junr. Fol. Published by the author, 1825,” were sold by <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=oLUaAAAAYAAJ&amp;pg=RA1-PA177#v=onepage&amp;q&amp;f=false" target="_blank">Hodgson &amp; Co., 28-30 April 1908</a>, lot 574 <span class="notecall">[£11.5.0].</span><span class="fn">Sets of <em>Job</em> pre-publication proofs with 22 plates are in the Fitzwilliam Museum (ex Riches), National Gallery (Washington, DC, ex White), University of Texas (El Dieff set), and Yale. The title page in the El Dieff and Yale sets is not in the pre-publication state. The Hofer set of pre-publication proofs at the Houghton Library, Harvard University, lacks only the title page. <span class="fnp">The same quotation about aqua fortis appears in Linnell’s <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/public/journals/2/BonusFeatures/Spring2012/Essick/Job.html" target="_blank">draft description</a> (collection of Robert N. Essick).</span></span></p>
<p class="desc">“Illustrations of the Book of Job; 22 plates, a set of artist’s proofs before the imprint, showing several interesting points of difference when compared with the finished proofs in the preceding, cut down lot to sm. 4to. size, hf. russ. From the Collection of J. Linnell, Senr. 1825” were sold in the same Hodgson catalogue, lot 575 [£2.0.0].</p>

<p class="gapcenter">Editions</p>
*<em>William Blake’s Illustrations of the Book of Job</em>. e-artnow, 2013. ISBN: 9788074844225.<br>
<p class="desc">Probably from a copy in the Library of Congress—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.</p>

<p class="author">*<em>Ilustraciones al Libro de Job</em>. Trans. Raquel Duato. Madrid: La Felguera Editores, 2014. Colección Artefactos. 8º, 128 pp.; ISBN: 9788494218736, with reproductions of all the prints. Spanish translations of inscriptions facing each print.<br>
“Nota de los editores.” 11-12.<br>
Javier Calvo. “Prólogo: Satanás contra la imaginación.” 13-27 (mostly paraphrasing Kathleen Raine).<br>
“Nota de la traductora.” 31-32.</p>

<p class="author">§*<em>Illustrations of the Book of Job</em>. N.p.: Bookpubber, 2014. 64 pp., with reproductions of 22 engravings. [No edition identified, no ISBN given.]</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Blair</span>, Robert, <em>The Grave</em> (1808, 1813)</p>
1808 Quarto New Location: Cincinnati Art Museum.<br>
<p class="gapcenter">Working Proof</p>
<p class="desc">A working proof of “Death’s Door” (pl. 11) etched by Schiavonetti was acquired in 2014 through Sotheran’s by Victoria University in the University of Toronto.</p>
Leaf size: 21.5 x 32 cm.<br>
Wartermark: None<br>
Plate size: 17.3 x 29.2 cm. (as in 1808)<br>
Inscriptions: “<em>Drawn by W. Blake</em>,” “<em>Etched by L. Schiavonetti</em>,” “<em>London Published May 1.<sup>st</sup> 1806 by Cadell &amp; Davies Strand</em>” (the version in 1808 adds at the top right “<em>P. 32</em>” and below the title “<em>’Tis but a Night, a long and moonleſs Night,</em> | <em>We make the Grave our Bed, and then are gone!</em>,” and the year is changed to “<em>1808</em>”) &lt;﻿<em>BBS</em> p. 200 reports other proofs of “Death’s Door” in the Fitzwilliam, Morgan, and Trinity College (Hartford, Connecticut)﻿&gt;.<p></p>
<p class="author" style="text-indent: 15px">The frontispiece portrait of Blake (T. Phillips–L. Schiavonetti) exists in a recently discovered “pre-publication proof lacking all letters and before considerable finishing work in the design, India paper laid on heavy wove without watermark, leaf trimmed inside the platemark to 33.6 x 24.3 cm.” (collection of Robert N. Essick). “The Blake portrait is in the same early st. as the proof, on heavy laid paper” in the Fitzwilliam Museum. Perhaps these are the two “unfinished” proofs of the portrait of Blake for Blair’s <em>Grave</em> offered at Christie’s, 22-23 July 1814, <span class="notecall">lot 250.</span><span class="fn">Robert N. Essick, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#Schiavonetti" target="_blank">“Blake in the Marketplace, 2014,”</a> <em>Blake</em> 48.4 (spring 2015).</span></p>

<p class="gapcenter">Editions</p>
*<em>The Grave (Illuminated Manuscript</em> [<em>sic</em>] <em>with the Original Illustrations of William Blake to Robert Blair’s</em> The Grave). e-artnow, 2013. ISBN: 9788074844218.<br>
<p class="desc">Probably reproduced from a copy in the Library of Congress—see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B. The cover reproduces one of Blake’s watercolors.</p>

<p class="author">§<em>The Grave: A Poem Illustrated by Twelve Etchings</em> [1808]. [Whitefish (Montana)]: Literary Licensing LLC, 2014. 24 pp.; ISBN: 9781497911321.</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Brown</span>, John, <em>The Elements of Medicine</em> (1795)</p>
<p class="desc">The copy with Coleridge’s initials on the half-title of vol. 1 was sold with the H. B. Forman collection at Anderson Galleries, 15-17 March 1920, lot 39 [$80 to Rosenbach], and offered by him at $150 (according to his acquisition card).</p>

<p class="gapcenter">“Carfax Conduit, Oxford” (1810)</p>
<p class="desc">The earliest reproduction of the Carfax Conduit I have found is in the <em>Gentleman’s Magazine</em> (1771): 553.</p>
<p class="desc">Essick suggests that <span class="notecall">“the style of engraving indicates that [Blake’s] pl. was engraved in the 1780s.”</span><span class="fn">Robert N. Essick, <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#Carfax" target="_blank">“Blake in the Marketplace, 2014,”</a> <em>Blake</em> 48.4 (spring 2015).</span> Perhaps the date was 1787, when the Carfax Conduit was moved out of Oxford.</p>
<p class="desc">A copy was offered in the online catalogue of Sanders of Oxford (Aug. 2014).</p>
<p class="reviewheading">Reviews, puffs, notices (see also &lt;﻿<em>Blake</em> [2010]﻿&gt;)</p>
<em>Monthly Repertory of English Literature</em> 13 (Paris, 1811): <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=G9hMAAAAcAAJ&amp;lpg=PA381&amp;ots=gJhQOQp5Sy&amp;pg=PA381#v=onepage&amp;q&amp;f=false" target="_blank">381</a>, at 1s. 6d.<br>

<p class="gapcenter">“Chaucers Canterbury Pilgrims” (1810)</p>
Newly Recorded Copy: Cincinnati Art Museum.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Cumberland</span>, George, Card (1827)</p>
Newly Recorded Copy: Cincinnati Art Museum.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Dante</span>, <em>Blake’s Illustrations of Dante</em> (1838)</p>
<p class="desc">All the prints are reproduced in *<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Dante"><em>Los dibujos para la</em> Divina Comedia <em>de Dante</em></a> (see Part II, Section A, under Dante).</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Earle</span>, James, <em>Practical Observations on the Operation for the Stone</em><br> (1793, 1796, 1803)</p>
1793 New Locations: Collection of Robert N. Essick (2), one with the <em>Appendix</em> (J. Johnson, 1796).<br>
1803 New Location: Collection of Robert N. Essick.<br>
Plate 3, marked “<em>To face p. 8, Appendix</em>”: “The inscriptions bottom center and lower right, added in [the] 2<sup>nd</sup> st., are in Blake’s hand. The letter forms, particularly the ‘g,’ are characteristic of his engraved lettering—compare his inscriptions in George Cumberland, <em>Thoughts on Outline</em>, <span class="notecall">1796.”</span><span class="fn">Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#5" target="_blank">illus. 5</a>. <em>BB</em> p. 550 dismissed the attribution to Blake as “far from conclusive,” and <em>BBS</em> p. 211 concluded, “I am now willing to include the plate as Blake’s, though balking at their [Keynes’s and Essick’s] certainty.”</span>

<p class="gapcenter">Newly Recorded Edition</p>
<p class="reviewheading"><span style="font-variant: small-caps;">Fenning</span>, D., and J. <span style="font-variant: small-caps;">Collyer</span>, <em>A New System of Geography</em><br> (2 vols., J. Johnson, 1785-86, 1787)</p>
<p class="reviewheading">John Payne, <em>Universal Geography Formed into a New and Entire System</em><br> (London: J. Johnson and C. Stalker, 1791)</p>
Payne Locations: British Library, University of Edinburgh.
<p class="desc">The Payne edition includes a third state of plate 2; for details, see Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#Fenning" target="_blank">“Appendix: New Information on Blake’s Engravings.”</a></p>
<!--<p class="desc">The frontispiece to vol. 1 (1785), probably engraved by Blake, is replaced in 1803 by another plate not related to Blake.--><p></p>

<p class="gapcenter"><span style="font-variant: small-caps;">Flaxman</span>, John, <em>The Iliad of Homer</em> (1805)</p>
<p class="reviewheading">Edition</p>
<em>Compositions of John Flaxman, Sculptor: Being Designs in Illustration of the Iliad of Homer</em>. Charleston: Nabu Press, 2014. 380 pp.; ISBN: 9781294911548.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Hayley</span>, William, <em>Ballads</em> (1805)</p>
<p class="reviewheading">Edition</p>
William Hayley. <em>Ballads</em>. N.p.: CreateSpace Independent Publishing Platform, 2014. 56 pp.; ISBN: 9781499539301.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Hayley</span>, William, <em>Designs to a Series of Ballads</em> (1802)</p>
<p class="desc">A copy of parts 1-2 “in I vol., 4to., old paper boards, backed with vellum at a later date …. Entirely uncut, some edges browned with age, and a little frayed in places” (“Winchester” [i.e., Chichester], 1802) was offered in James Rimell &amp; Son, <em>No. 288 Illustrated Catalogue of Rare Books</em> (London, 1933), lot 63, for £21.</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Hogarth</span>, William, <em>The Original Works of William Hogarth</em> (1790)</p>
<p class="desc">A copy of <em>The Original and Genuine Works of William Hogarth</em> (1795) was offered at §Sotheby’s (London), 15 July 2014, lot 518, with an 1809 watermark.</p>
<p class="desc">A previously unrecorded copy of the etched “proof” <span class="notecall">(probably published)</span><span class="fn">It is inscribed at bottom left “<em>Painted by Will.<sup>m</sup> Hogarth 1729</em>,” at bottom right “<em>Etch’d by Will<sup>m</sup> Blake 1788</em>,” and, in the center, “<em>Publishd October 29: 1788: by Ald<sup>m</sup> Boydel &amp; C<sup>o</sup> Cheapside</em>.” Ten other copies are known.</span> with the two kneeling actresses and some other individuals left largely blank was acquired from John Windle in June 2014 by <span class="notecall">Victoria University in the University of Toronto.</span><span class="fn">In the gloom at the top, much clearer in the proof than in the greatly darkened published version, are the royal arms in an oval inscribed “HONI SOIT QUI MAL Y PENSE”; below it is “DIEU ET MON DROIT”; on either side is a floating ribbon with “VELUTI IN SPECULUM” and “UTILE DULCI”. These are not recorded in Robert N. Essick, <em>William Blake’s Commercial Book Illustrations</em> (Oxford: Clarendon Press, 1991) 42-45.</span></p>

<p class="gapcenter"><span style="font-variant: small-caps;">Lavater</span>, John Caspar, <em>Essays on Physiognomy</em><br> (1789-98; 1792 [perhaps 1810]; 1810 [perhaps 1817])</p>
New Location (“1792”): Victoria University in the University of Toronto.<br>
<p class="desc">The newly recorded copy in Victoria University is dated “1792” on all three title pages, though it includes “The English Translator’s Preface” dated “December 24, 1798.” This is plainly a <span class="notecall">fraudulent edition,</span><span class="fn">Some sets of the “1792” Lavater bear watermarks as late as 1817. In a very cursory search, I found no watermark in the Victoria copy.</span> though the prints are genuine and the text is very handsome. “T. Bensley, Printer, | Bolt Court, Fleet Street, London” is named in the colophon to <span class="notecall">vol. 2, part 2.</span><span class="fn">T. Bensley is named on the title page of Lavater, <em>Physiognomy</em> (“1810,” i.e., 1817?).</span> In vol. 1, the contents leaf has a printed note—“TYPE I. WAYLAND”—that seems to appear nowhere else in this copy or any other which has been recorded. Levi Wayland finished his apprenticeship as a printer in 1789 and is known only for works in 1789-93.</p>
<p class="desc">This set is bound in handsome, uniform, contemporary black morocco gilt and blind stamped. The paste-down of each volume bears the armorial bookplate of “L. E. Holden” (beneath paste-marks suggesting that a previous bookplate has been removed) and each volume is inscribed “Gift of Mrs L. E. Holden. June. 1914.” Each title page has a small embossed stamp, “WESTERN RESERVE HISTORICAL SOCIETY,” “1857 | CLEVELAND | 1897,” and each fly-leaf verso is inscribed “Plates are not to be embossed.”</p>

<p class="gapcenter">“The Man Sweeping the Interpreter’s Parlour” (c. 1822)</p>
Newly Recorded Copy (second state): Cincinnati Art Museum.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Salzmann</span>, C. G., <em>Elements of Morality</em> (1791, 1792, 1799, 1805, 1815?)</p>
<p class="reviewheading">Edition</p> 
§*Christian Gotthilf Salzmann. <em>Elements of Morality, for the Use of Children: With an Introductory Address to Parents</em>. Vol. 3. Charleston: BiblioLife, 2014. 248 pp.; ISBN: 9781295470846. [Vols. 1-2 are not listed.]<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Shakespeare</span>, William, <em>The Plays</em>,<br> ed. George Steevens, with engravings after Henry Fuseli (1805, 1811, [1812])</p>
Plate 1: Blake’s pencil sketch of the design, “with ruled scale lines for engraving,” was offered in 1933 (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Fairy">“A Fairy leapt”</a> in Part I, Section A).

<p class="gapcenter"><span style="font-variant: small-caps;">Stedman</span>, J. G., <em>Narrative, of a Five Years’ Expedition</em> (1796, 1806, 1813)</p>
New Locations: Robert N. Essick (colored), John Rylands Library (University of Manchester) (colored), Royal Ontario Museum (Toronto), South Carolina (2).<br>
<p class="gapcenter">Newly Recorded Engraving</p>
<p class="desc">A previously unknown unwatermarked proof of the oval vignette of five ships at sea on both title pages, signed “Blake,” was offered by Bonhams (London) (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Bonhams">2014 18 <span style="font-variant: small-caps;">June</span></a>, lot 71, in Part IV, Section A) and acquired by Victoria University in the University of Toronto (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#2a">illus. 2a</a>). The proof image is 7.5 x 5.6 cm. on a sheet <span class="notecall">19.8 x 25 cm.</span><span class="fn">The top of the leaf seems to be cut off. On the verso (which is dirty) are three words in pencil, only the first of which, “The,” is legible to me. On the recto is written “Blake” in pencil.</span> “On the flag draped over the top of the oval vignette,” “executed in drypoint by Blake, not by a writing engraver,” is “cuncta mea mecum” (“my all is with me”), <span class="notecall">“the Stedman family motto.”</span><span class="fn">Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), caption to <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#6" target="_blank">illus. 6</a>, the reproduction of the proof.</span></p>
<a name="2a" id="2a"></a><div class="illus"><img src="1112.jpg" width="600" height="769">
<div>2a. Previously unrecorded proof of the vignette of five ships (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewFile/153/bentley491html/1114" onclick="positionedPopup(this.href,&#39;myWindow&#39;,&#39;1500&#39;,&#39;1194&#39;,&#39;50&#39;,&#39;700&#39;,&#39;yes&#39;);return false">enlargement</a>) on the two title pages of Stedman’s <em>Narrative</em>, signed “Blake” (just above the muzzle of the cannon at lower left). Image 7.5 x 5.6 cm. on leaf 19.8 x 25 cm. (Victoria University in the University of Toronto).</div>
</div>
<p class="desc">The published version was slightly modified: “An additional flag has been added to the mast of each ship, the clouds have been amended and Blake’s signature has been removed” (Bonhams catalogue). The pennants (not flags) on the five ships are unidentifiable and are unchanged in the final version (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#2b">illus. 2b</a>). However, flags, like the one just above the oval, have been added at the stern of the first ship at the left and the second ship from the right. The flags consist of three horizontal stripes; in colored copies of Stedman (1796) (collection of Robert N. Essick, Huntington Library, Victoria University in the University of Toronto) they are, from top to bottom, red, white, and blue, the colors of the Dutch flag. Stedman was a soldier of fortune with the Dutch.</p>
<p class="desc">The states of the title-page vignette are described in Robert N. Essick, “Blake in the Marketplace, 2014,” <em>Blake</em> 48.4 (spring 2015), <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick484/essick484html#10" target="_blank">illus. 10</a>.</p>
<a name="2b" id="2b"></a><div class="illus"><img src="1113.jpg" width="600" height="817">
<div>2b. Vignette (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewFile/153/bentley491html/1115" onclick="positionedPopup(this.href,&#39;myWindow&#39;,&#39;1500&#39;,&#39;1197&#39;,&#39;50&#39;,&#39;700&#39;,&#39;yes&#39;);return false">enlargement</a>) in a colored copy of Stedman’s <em>Narrative</em> (1796), vol. 2 (Victoria University in the University of Toronto). 
<span class="fnp">Blake’s name is only barely visible (and not previously recorded) in vol. 1 and invisible in vol. 2. The clouds are altered, and Dutch flags have been added at the stern of the first ship at the left and the second ship from the right (not on “the mast of each ship,” as described in the Bonhams catalogue).</span><p></p>
</div>
</div>

<p class="gapcenter">Edition</p>
<em>Narrative of Joanna, an Emancipated Slave of Surinam: From Stedman’s</em> Narrative of a Five Years’ Expedition against the Revolted Negroes of Surinam. Charleston: BiblioLife, 2014. 92 pp.; ISBN: 9781293527399.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Stuart</span>, James, and Nicholas <span style="font-variant: small-caps;">Revett</span>, <em>The Antiquities of Athens</em>, vol. 3 (1796)</p>
<p class="desc">According to the <a href="http://nucat.library.northwestern.edu.libproxy.lib.unc.edu/cgi-bin/Pwebrecon.cgi?BBID=1876424" target="_blank">library description</a> of the set in Northwestern University (5 vols., 1762-1830):</p>
<span class="extract">Substantial sections of v. 1 and 3 were reprinted, with the type reset, using paper with countermarks reading J Whatman 1808. They are: (v. 1) t.p.; dedic.; p. i-x, 1-4, 9-12, 15-end; and errata leaf; (v. 3) preface; p. xxi-[xxvi]; and errata leaf. The v. 1 errata may not have a corresponding original printing; the other reprintings do.<br>
The following parts of v. 1 and 2 are known in two settings of type, neither of which use 1808 paper: (v. 1) dedication, and list of subscribers; <span class="notecall">(v. 2) t.p.</span><span class="fn">The description was brought to my attention by Robert N. Essick.</span></span>
To this may be added the fact that Blake’s prints in the collection of D. W. Dörrbecker are on paper watermarked J W<span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">hatman</span> 1806.<p></p>

<p class="gapcenter"><span style="font-variant: small-caps;">Virgil</span>, <em>Pastorals</em> (1821)</p>
New Location: John Rylands Library (University of Manchester).<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Wollstonecraft</span>, Mary, <em>Original Stories from Real Life</em> (1791, 1796)</p>
1796 New Location: John Rylands Library (University of Manchester) (frontispiece cut out and pasted to the page facing the title page).<br>
<p class="gapcenter">Edition</p>
§*Mary Wollstonecraft. <em>Original Stories from Real Life: With Conversations Calculated to Regulate the Affections and Form the Mind to Truth and Goodness</em> [<em>With Five Illustrations by William Blake With an Introduction by E. V. Lucas</em> (1906)]. [Whitefish (Montana)]: Literary Licensing LLC, 2014. 124 pp.; ISBN: 9781498181822.<br>

<p class="gapcenter"><span style="font-variant: small-caps;">Young</span>, Edward, <em>Night Thoughts</em> (1797)</p>
New Location: Duke University (with the bookplate of “Bernard, Lord Coleridge”).<br>
<p class="reviewheading" style="margin-top: 25px">Colored Copies</p>
Copy Q<br>
History: Sold with <em>The Late C. D. Halford’s Library, and Other Properties</em> by Puttick &amp; Simpson, 15-16 January 1908, lot 643 [£52] “col. by the artist himself, inscription on fly-leaf: ‘This copy was coloured for me by Mr. Blake, W. E.,’ orig. bds.”<br>

<p class="mainheading"><a name="PartIIIappendix" id="PartIIIappendix"></a>Appendix: Books Improbably Alleged to Have Blake Engravings</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Mylius</span>, William Frederick, <em>The Junior Class-Book</em> (1809 ff.)</p>
Title page: William Frederick Mylius, <em>The Junior Class-Book; or, Reading Lessons for Every Day in the Year: Selected from the Most Approved Authors. For the Use of Schools</em> (London: Printed for M. J. Godwin, at the Juvenile Library, No. 41, Skinner Street, and to Be Had of All Booksellers, 1809).<br>
Format: 12mo., 18 cm.<br>
Illustrations: The “6 plates engraved by Blake” (according to the Rosenbach acquisition card) <span class="notecall">are untitled and unsigned.</span><span class="fn">According to the Anderson Galleries sale catalogue of H. Buxton Forman, 26 April 1920, lot 53, the book is “illustrated with six plates by Blake.”</span><br>
Location: <span class="notecall">Bodleian, <a href="http://solo.bodleian.ox.ac.uk/primo_library/libweb/action/dlDisplay.do?vid=OXVU1&amp;docId=oxfaleph019569691" target="_blank">Vet. A6 e.2927</a>.</span><span class="fn">The Bodleian copy is bound after John Hornsey, <em>The Child’s Monitor</em>, 2nd ed. (1809).<span class="fnp">In a list of <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=6ekIAAAAQAAJ&amp;lpg=PR1&amp;ots=hNtomW_4Rr&amp;pg=PR1#v=onepage&amp;q&amp;f=false" target="_blank">WORKS PUBLISHED BY BALDWIN, CRADOCK, AND JOY</a> [1826] is “The Seventh Edition, price 5<em>s</em>. boards.” I have neither seen nor located a copy of the 7th ed. and do not know whether it is illustrated. <em>The Junior Class-Book</em> is said to include bits of Lamb’s <em>Poetry for Children</em>.</span></span><br>
<p class="desc">The six unsigned and untitled prints have no significant resemblance to those associated with Blake’s commercial engravings. The attribution to Blake seems to be somewhere between casual and wanton.</p>

<p class="mainheading"><a name="PartIV" id="PartIV"></a>Part IV: Catalogues and Bibliographies</p>
<p class="mainheading"><a name="PartIVA" id="PartIVA"></a>Section A: Individual Catalogues</p>

<p class="ednote">Editors’ note:<br>
Please consult Bentley, “<a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">Sale Catalogues of William Blake’s Works</a>,” for pre-2013 catalogues.</p>

<p class="gapcenter">2013 8 <span style="font-variant: small-caps;">February</span>–23 <span style="font-variant: small-caps;">June</span></p>
*Stella Halkyard. <em>Burning Bright: William Blake and the Art of the Book</em>. [2013]. &lt;﻿<em>Blake</em> (2014)﻿&gt;<br>
<p class="reviewheading">Review</p>
*Sibylle Erle (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake483"><em>Blake</em> 48.3</a> in Part VI).

<p class="gapcenter">2013 14 <span style="font-variant: small-caps;">May</span>–6 <span style="font-variant: small-caps;">October</span></p>
§<a href="http://www.tate.org.uk.libproxy.lib.unc.edu/whats-on/tate-britain/display/bp-spotlight-landscape-blake" target="_blank">Landscape in Blake</a>. [Exhibition at Tate Britain devised by Hayley Flynn.]<br>
<p class="desc">Apparently there was no catalogue.</p>

<p class="gapcenter">2014 4 <span style="font-variant: small-caps;">April</span>–31 <span style="font-variant: small-caps;">August</span></p>
*Cathy Leahy. <em>William Blake</em>. [Exhibition at the] National Gallery of Victoria. Melbourne: National Gallery of Victoria, 2014. 28 cm., 112 pp.; ISBN: 9780724103805. 104 <span class="notecall">reproductions,</span><span class="fn">The reproductions vary in size by the whim of the layout person, not by the size of the originals.</span> some of them double page, including all 14 prints from <em>Innocence</em> (X), all 22 <em>Job</em> engravings, and all their Dante watercolors.<br>
Tony Ellwood. “Foreword.” 4. (“This publication, which presents the NGV’s Blake holdings, accompanies the exhibition of <em>William Blake</em>.”)<br>
<p class="reviewheading">Reviews, etc.</p>
*Rachael Kohn, <a href="http://www.abc.net.au.libproxy.lib.unc.edu/radionational/programs/spiritofthings/william-blake27s-erotic-spirituality/5341078" target="_blank">“William Blake’s Erotic Spirituality,”</a> <em>The Spirit of Things</em> 30 March 2014 (a broadcast interview with Marsha Keith Schuchard and Catherine Leahy).<br>
*Sandra Kerbent, <a href="http://www.weekendnotes.com/william-blake-exhibition-the-ngv/" target="_blank">“William Blake Exhibition @ the NGV,”</a> <em>Weekend Notes</em> [Melbourne] [2014].<br>

<p class="gapcenter">2014 5 <span style="font-variant: small-caps;">April</span>–3 <span style="font-variant: small-caps;">May</span></p>
<em>Sapientia ubi invenitur</em>. Espacio Valverde, Madrid. Curated by Antonio Betancor. In Spanish.<br>
<p class="desc">All the reproductions are of <em>Job</em> “Proof” plates numbered “1,” “8,” “11,” “13,” “18,” “20,” and “21,” which show how Blake served as inspiration for eight young Spanish artists.</p>

<a name="Hogarth" id="Hogarth"></a><p class="gapcenter">2014 27 <span style="font-variant: small-caps;">May</span>–6 <span style="font-variant: small-caps;">July</span></p>
“Une oeuvre … un secret.” Exhibition at the Château de Nérac [Aquitaine, France] sponsored by L’association William Blake, whose president is André Furlan.<br>
<p class="desc">The account of it suggests that the only work exhibited was Blake’s engraving after Hogarth for <em>The Beggar’s Opera</em>, with manuscript additions attributed to Blake (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIappendix">Part I, Appendix</a>).</p>

<a name="Bonhams" id="Bonhams"></a><p class="gapcenter">2014 18 <span style="font-variant: small-caps;">June</span></p>
*Bonhams. <a href="http://www.bonhams.com/auctions/21763" target="_blank"><em>Books, Maps, Manuscripts and Historical Photographs</em></a>. London, 2014.<br>
<table class="lot">
<tbody><tr><td class="lotnumber"><a href="http://www.bonhams.com/auctions/21763/lot/71" target="_blank">71</a></td>
<td class="lottext">“Unpublished proof of an engraved vignette [1791], <em>oval device enclosing ships at sea, surround with anchor, cannon, flags and banner with motto ‘cuncta mea mecum’, signed in the plate lower left ‘Blake’</em> ” above the muzzle of a cannon, image 7.5 x 5.6 cm., sheet size 25.0 x 19.0 cm., designed for the “title-pages” of John Gabriel Stedman, <em>Narrative, of a Five Years’ Expedition, against the Revolted Negroes of Surinam</em> (1796), presumably one of “above 40 Engravings from London, Some well Some very ill” that Stedman received in December 1791; “I wrote to the Engraver Blake to thank him twice for his excellent work” (<em>BR</em>[2] 62). “This vignette … as it appears in the book varies in a number of ways: an additional flag has been added to the mast of each ship, the clouds have been amended and Blake’s signature has been removed.” Estimate: £1000-£1500 [sold for £5625 (including the buyer’s premium) to Victoria University in the University of Toronto (see illus. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#2a">2a</a> and <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#2b">2b</a>)].</td></tr>
<tr><td class="lotnumber"><a href="http://www.bonhams.com/auctions/21763/lot/72" target="_blank">72</a></td> <td class="lottext"><em>Job</em> (1826), wove paper, watermark J. Whatman Turkey Mill 1825, 37.0 x 25.0 cm., “FINE AND RICHLY PRINTED 			IMPRESSIONS,” “one of 100 copies issued shortly after the initial 215 ‘Proof’ copies,” “<em>bound into slightly earlier</em> [<em>sic</em>] <em>crushed red morocco</em>,” “Provenance: Henry Cunliffe (1826-1894), bookplate; thence by descent to the present owner.” Estimate £25,000-£35,000 [sold for £27,500 (including the buyer’s premium)].</td></tr>
<tr><td class="lotnumber"><a href="http://www.bonhams.com/auctions/21763/lot/73" target="_blank">73</a></td> <td class="lottext"><em>Songs of Innocence and of Experience</em> [i], “<em>44 relief etchings, including 3 decorated titles, 2 pictorial frontispieces, and 39 plates … printed in grey ink on wove paper, several sheets watermarked J. Whatman 1831, plate 23 hand-coloured, plate 48 on a slightly smaller sheet of thinner paper (240 x 185mm.), pencilled numbers at upper right corners, occasional light dust-soiling at edges, a handful of spots, plates 6-7 and 13 with notch at one edge, plates 12-13 with nineteenth century pencil notes in margin, final plate bumped at fore-edge, preserved in red morocco pull-off box</em>.” “A SUBSTANTIALLY COMPLETE COPY,” with “plates 1-14, 16-29, 33-36, 38-43, 46, 48-49, 52-54. (Bentley erroneously records this copy having plate 30 instead of plate 29.)” “Acquired by Henry Cunliffe (1826-1894); <span class="notecall">thence by descent to the present owner.”</span><span class="fn"><em>BB</em> p. 428 reports that at the death of Lord Cunliffe in 1963 the prints “passed to his son … The present <em>Lord Cunliffe</em>.”</span> Reproductions of pls. 1 (combined title page), 3 (<em>Innocence</em> title page), 23 (“Spring,” second plate), and 42 (“The Tyger”). Estimate: £50,000-£70,000 [sold for £62,500 (including the buyer’s premium) to Victoria University in the University of Toronto].</td></tr>
</tbody></table>

<p class="gapcenter">2014 17 <span style="font-variant: small-caps;">October</span>–7 <span style="font-variant: small-caps;">November</span></p>
*Henry Sotheran Limited [and John Windle]. <a href="http://www.sotherans.co.uk/catalogue/PDF/william_blake.pdf" target="_blank"><em>William Blake</em></a>. London: Henry Sotheran Limited, 2014. 4º, [ii], 42 pp., 93 lots; no ISBN.<br>
<p class="desc">An exhibition and sale, consisting chiefly of prints taken from contemporary books (including two prints by Samuel Palmer) (lots 1-49), facsimiles and editions illustrated by others (lots 53-62), contemporary books with Blake engravings (lots 63-72), and facsimiles (lots 75-86). The most important are:</p>
<table class="lot">
<tbody><tr><td class="lotnumber">51</td>
<td class="lottext"><em>Job</em> (“1825”), with the bookplate of Henry Cunliffe, £57,000.</td></tr>
<tr><td class="lotnumber">52</td>
<td class="lottext">George Cumberland’s card, £12,750.</td></tr>
<tr><td class="lotnumber">64</td>
<td class="lottext">Young, <em>Night Thoughts</em> (1797), with the bookplate of Bernard, Lord Coleridge, and signatures of “J.T., Mary, and Jane Coleridge,” £11,150.</td></tr>
<tr><td class="lotnumber">67</td>
<td class="lottext">Hayley, <em>The Triumphs of Temper</em> (1803), with the signature of W. M. Rossetti, 1868, £625.</td></tr>
</tbody></table>

<p class="gapcenter">2014 <span style="font-variant: small-caps;">November</span></p>
Sophie Schneideman Rare Books. <a href="http://www.ssrbooks.com/downloads?cat=schneideman024.pdf&amp;browserview=true" target="_blank"><em>William Blake and His Followers</em></a>.<br>
<p class="desc">It includes <em>Job</em>, “Proof” printing on “French” wove paper (£65,000).</p>

<a name="Ashmolean" id="Ashmolean"></a><p class="gapcenter">2014 4 <span style="font-variant: small-caps;">December</span>–2015 1 <span style="font-variant: small-caps;">March</span></p>
*Michael Phillips [with Martin Butlin and Colin Harrison (Senior Curator of European Art, Ashmolean Museum)]. <em>William Blake: Apprentice &amp; Master</em>. Oxford: Ashmolean Museum, 2014. 23.2 x 30 cm., [i-vi], 7-272 pp., 341 illustrations! (many not by Blake, rarely true size, often trimmed, including <em>Europe</em> [B] in various sizes); ISBN: 9781854442888.<br>
Alexander Sturgis. “Director’s Foreword.” 7.<br>
[Michael Phillips]. “Author’s Acknowledgements.” 9.<br>
“William Blake: Apprentice &amp; Master: Introduction.” [10]-15.<br>
<p class="reviewheading">Part One: Education</p>
I. “Childhood and Pars’s Drawing School: 1757-1772.” [18]-25.<br>
II. “Apprentice Engraver: 1772-1779.” [26]-[37].<br>
III. “Westminster Abbey.” [38]-47.<br>
IV. “The Royal Academy Schools.” [48]-59.<br>
V. “Out into the World: 1779-1785.” [60]-[65].<br>
VI. “First Poems.” [66]-69.<br>
VII. “The Manuscripts of <em>An Island in the Moon</em> and <em>Tiriel</em>.” [70]-[79].<br>
VIII. “Master of His Trade: 1785-1791.” [80]-85.<br>
<p class="reviewheading">Part Two: Innovation</p>
IX. “‘A Method of Printing which Combines the Painter and Poet.’” [88]-101.<br>
X. “‘Illuminated Printing.’” [102]-[07].<br>
XI. “<em>Songs of Innocence</em>, 1789.” [108]-11.<br>
XII. “No. 13 Hercules Buildings, Lambeth: 1791-1800.” [112]-21.<br>
XIII. “<em>The Marriage of Heaven and Hell</em>: 1790-1793.” [122]-29.<br>
XIV. “The <em>Manuscript Notebook</em> and the Creation of <em>Songs of Experience</em>.” [130]-[43].<br>
XV. “Colour Printing before Blake.” [144]-[51].<br>
XVI. “The Large Colour Prints of 1795.” [152]-63.<br>
XVII. “‘Fit Audience find tho’ Few.’” [164]-79.<br>
XVIII. “Blake’s Last Residence: No. 3 Fountain Court, the Strand: c. 1820-1827.” [180]-85.<br>
XIX. “‘A Correct and Finished Line Manner of Engraving.’” [186]-205.<br>
XX. “Illustrations to Dante.” [206]-[15].<br>
<p class="reviewheading">Part Three: Inspiration</p>
XXI. Martin Butlin. “The Interpreter and the Ancients.” [218]-23.<br>
XXII. Colin Harrison. “Samuel Palmer 1805-1881.” [224]-[31].<br>
XXIII. Colin Harrison. “Edward Calvert 1799-1873 [<em>sic</em>].” [232]-[35].<br>
XXIV. Colin Harrison. “George Richmond 1809-1896.” [236]-[39].<br>
XXV. “The Last Furrow.” [240]-47.<br>
<p class="reviewheading">Reviews, notices, etc. (a selection)</p>
*Anon., <a href="https://stationers.org/latest-news/863-stationers-register-goes-to-ashmolean-exhibition.html" target="_blank">“Stationers’ Register Goes to Ashmolean Exhibition,”</a> <em>Stationer’s Company</em> 4 Nov. 2014 (Blake’s apprenticeship record).<br>
*Maev Kennedy, “<a href="http://www.theguardian.com/culture/2014/nov/07/william-blake-studio-ashmolean-exhibition" target="_blank">William Blake’s Lambeth Studio Recreated for Ashmolean Exhibition</a>: Victorian floor plans and descriptions by contemporaries help curators envisage work space from home demolished in 1918,” <em>Guardian</em> [London] 7 Nov. 2014 (digest from a press release).<br>
*Jonathan Jones, “<a href="http://www.theguardian.com/artanddesign/jonathanjonesblog/2014/nov/18/william-blake-the-tyger-art-poem-tigers" target="_blank">How William Blake Keeps Our Eye on ‘The Tyger,’</a>” <em>Guardian</em> [London] 18 Nov. 2014.<br>
*Andrew Ffrench, <a href="http://www.oxfordmail.co.uk/news/11612862.Oxford_s_Ashmolean_Museum_prepares_to_celebrate_work_of_artist_William_Blake_in_new_exhibition/" target="_blank">“Oxford’s Ashmolean Museum Prepares to Celebrate Work of Artist William Blake in New Exhibition,”</a> <em>Oxford Mail</em> 20 Nov. 2014.<br>
*Philip Pullman, “<a href="http://www.theguardian.com/books/2014/nov/28/philip-pullman-william-blake-and-me" target="_blank">William Blake and Me</a>: As an exhibition of Blake’s paintings opens in Oxford, Philip Pullman reflects on how his poetry has influenced and intoxicated him for more than 50 years,” <em>Guardian</em> 28 Nov. 2014 (long and eloquent).<br>
*Anon., <a href="http://broadconversation.com/2014/12/01/inspired-by-blake-festival/" target="_blank">“Inspired by Blake Festival,”</a> <em>Broad Conversation: Events, news and opinion from Blackwell’s, Broad Street,	Oxford</em> ” 1 Dec. 2014 (“We’ll be posting on Tuesdays and Fridays, all the way up to and through the festival,” 18-31 January 2015).<br>
*Zoe Pilger, “<a href="http://www.independent.co.uk/arts-entertainment/art/features/william-blakes-printing-and-engraving-new-show-does-not-do-his-vision-justice-9896554.html" target="_blank">William Blake’s Printing and Engraving</a>: New show does not do his vision justice,” <em>Independent</em> [London] 1 Dec. 2014 (“I was underwhelmed”; “There is too much technical detail about engraving”).<br>
*Fleur MacDonald, “<a href="http://www.catholicherald.co.uk/issues/december-5th-2014/the-ghostly-brother-who-inspired-a-revolution/" target="_blank">William Blake</a>: the ghostly brother who inspired a revolution: William Blake emerges, not as a mad visionary, but as a fan of progressive Christianity in a new show at the Ashmolean,” <em>Catholic Herald Magazine</em> 4 Dec. 2014.<br>
*Laura Cumming, “<a href="http://www.theguardian.com/culture/2014/dec/07/william-blake-apprentice-master-ashmolean-oxford-review-master-monoprint-radical" target="_blank">William Blake: Apprentice and Master Review</a>—the most erratic exhibition in recent history: This frustrating show places more emphasis on William Blake’s technique than his revolutionary vision,” <em>Observer</em> [London] 6 Dec. 2014.<br>
*Martin Gayford, “<a href="http://www.countrylife.co.uk/art-and-antiques/exhibition-review-william-blake-ashmolean-oxford-66782" target="_blank">Exhibition Review: William Blake at the Ashmolean, Oxford</a>: Martin Gayford argues that Blake’s visions and his homemade philosophy can be a barrier to appreciation of his art,” <em>Country Life</em> 7 Dec. 2014 (Gayford’s conclusion is, as he acknowledges, merely an echo of that of Sir Kenneth Clark).<br>
*Anon., <a href="http://www.oxfordmail.co.uk/news/11649082.Blake_s_vision_brings_big_crowds_to_Ashmolean_exhibition/" target="_blank">“Blake’s Vision Brings Big Crowds to Ashmolean Exhibition,”</a> <em>Oxford Mail</em> 8 Dec. 2014.<br>
Ben Stevens, “<a href="http://englandevents.co.uk/oxford-inspired-by-blake-festival/90518" target="_blank">Oxford: Inspired By Blake Festival</a>: January 18, 2015 at Blackwell’s Bookshop Oxford in Oxford [<em>sic</em>],” <em>England Events</em> 9 Dec. 2014.<br>
*Rupert Toovey, <a href="http://www.worthingherald.co.uk/news/columnists/william-blake-exhibition-unites-sussex-and-oxford-1-6469291" target="_blank">“William Blake Exhibition Unites Sussex and Oxford,”</a> <em>Worthing Herald</em> 11 Dec. 2014.<br>

<p class="gapcenter">2015 21 <span style="font-variant: small-caps;">January</span></p>
&lt;﻿Christie’s (New York) sale of Maurice Sendak﻿&gt;<br>
<p class="desc">In the autumn of 2014 there were a number of highly derivative newspaper articles about the sale, though none names Blake in the title. Among them was Peter Dobrin, <a href="http://articles.philly.com/2014-11-11/news/56395085_1_sendak-items-rosenbach-museum-the-rosenbach" target="_blank">“Rosenbach Sues Sendak Foundation over Rare Books,”</a> <em>Inquirer</em> [Philadelphia] 9 Nov. 2014:</p>
<span class="extract">The [Sendak] estate also claims two illuminated books by William Blake, <em>Songs of Experience</em> [<em>Songs</em> (H)] and <em>Songs of Innocence</em> [J], are not rare books because one lacks a binding and the other has pages that do not correspond to another copy of the same title. [The Rosenbach says that] “the executors have advised the Rosenbach that they intend to sell the Blakes.”</span>
By December 2014 the sale had been postponed sine die because of legal actions.<br>
<p class="desc">For a list of works by Blake that Sendak owned, see the introduction to &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/bentley471/bentley471html#Sendak" target="_blank"><em>Blake</em> (2013)</a>﻿&gt;.</p>

<p class="mainheading"><a name="PartIVB" id="PartIVB"></a>Section B: Collections and Selections</p>

<p class="author">G. E. Bentley, Jr. “Sale Catalogues of Blake’s Works.” &lt;﻿<a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">http://​library.​vicu.​utoronto.​ca/​collections/​special_collections/​bentley_​blake_​collection</a>﻿&gt;. &lt;﻿<em>Blake</em> (2014)﻿&gt;</p>
<p class="desc">The document was updated in May 2014 (550 pages added) and March 2015.</p>

<p class="mainheading"><a name="PartV" id="PartV"></a>Part V: Books Owned by William Blake the Poet</p>

<p class="ednote">Editors’ note:<br>
Please consult Bentley, “<a href="http://library.vicu.utoronto.ca.libproxy.lib.unc.edu/collections/special_collections/bentley_blake_collection" target="_blank">Sale Catalogues of William Blake’s Works</a>,” for further particulars of catalogues mentioned in this section.</p>

<p class="gapcenter"><span style="font-variant: small-caps;">Chatterton</span>, Thomas,<br> <em>Poems, Supposed to Have Been Written … by Thomas Rowley</em> (1778)</p>
History: Sold by <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=oLUaAAAAYAAJ&amp;pg=RA1-PA177#v=onepage&amp;q&amp;f=false" target="_blank">Hodgson &amp; Co., 28-30 April 1908</a>, lot 581, “Blake’s copy with his autograph on title, bds., uncut. 8vo.” [£2.18.0].<br>

<p class="gapcenter"><span class="notecall">Spectacles</span><span class="fn">For an account of Blake’s use of his spectacles, see <em>BR</em>(2) 290.</span></p>
History: Sold by <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=oLUaAAAAYAAJ&amp;pg=RA1-PA177#v=onepage&amp;q&amp;f=false" target="_blank">Hodgson &amp; Co., 28-30 April 1908</a>, lot 582 (“William Blake’s Spectacles, in old case, … ‘much valued by … Samuel Palmer’”) [£6]; as in &lt;﻿<em>Blake</em> (1996)﻿&gt;, under Part I, Section A.<br>

<p class="mainheading"><a name="PartVI" id="PartVI"></a>Part VI: Criticism, Biography, and Scholarly Studies</p>
<p style="text-align: center; margin-top: 30px"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#A">A</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#B">B</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#C">C</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#D">D</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#E">E</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#F">F</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#G">G</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#H">H</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#I">I</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#J">J</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#K">K</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#L">L</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#M">M</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#N">N</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#P">P</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#R">R</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#S">S</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#T">T</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#U">U</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#W">W</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#X">X</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Y">Y</a> &nbsp; <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Z">Z</a></p>
<p class="mainheading" style="margin-top: 30px"><a name="A">A</a></p>
<p class="author">*Adams, Hazard. <em>Thinking through Blake</em>. Jefferson [North Carolina]: McFarland &amp; Company, 2014. 4º, viii, 195 pp.; ISBN: 9780786479580.</p>
<p class="desc">It consists of</p>
“Blake, <em>Jerusalem</em>, and Symbolic Form (1975).” 17-39.<br>
“Contemporary Ideas of Literature: Terrible Beauty or Rough Beast? (1977).” 40-64.<br>
“Essay on Frye (1991).” 65-69.<br>
“Reynolds, Vico, <em>Blackwell</em>, Blake: The Fate of Allegory (1993).” 70-85. [From <em>Enlightening Allegory</em>, ed. Kevin Cope (1993).]<br>
“The World-View of William Blake in Relation to Cultural Policy (1993).” 86-97. [From <em>Cultural Policy, Past, Present, and Future</em>, ed. Harold Coward (1990), <em>Critical Essays on William Blake</em>, ed. Adams (1991), and <em>Reflections on Cultural Policy: Past, Present and Future</em>, ed. Evan Alderson et al. (1993).]<br>
“Conference 2: Chinese and Japanese-American Literary Relations (1995).” 98-107.<br>
“Is (Was) There No Tradition of Defense of Poetry in Chinese Culture? Why Has There Had to Be One in the West? (1995).” 108-21.<br>
“Four Problems (among Many) for Humanistic Thought (1995).” 122-26.<br>
“‘Literature’ and the Visionary Tradition (1995).” 127-30.<br>
“‘Literature’ into ‘Ecriture’? (1995).” 131-33.<br>
“‘An Antithetical Turn’ (1996).” 134-47.<br>
“Ekphrasis Revisited, or Antitheticality Reconstructed (2000).” 148-60.<br>
“Quest and Cycle (2005).” 161-64.<br>
“Origin(ality) (2007).” 165-70.<br>
“The Marriage of Imagination and Intellect (2013).” 171-82.<br>
Chapter Notes. 183-90.<br>
<p class="desc">Most of the essays are not explicitly related to Blake.</p>

<p class="author">§Allingham, William. Manuscript copies of poems from <em>Songs of Innocence</em>, <em>Poetical Sketches</em>, Notebook, etc. (1857). British Library Department of Manuscripts: <a href="http://searcharchives.bl.uk.libproxy.lib.unc.edu/primo_library/libweb/action/display.do?tabs=detailsTab&amp;ct=display&amp;doc=IAMS040-001592683&amp;displayMode=full&amp;vid=IAMS_VU2" target="_blank">Add MS 49460</a>.</p>
<p class="desc">See D. F. McKenzie, “William Allingham’s Notebook of Poems by Blake” &lt;﻿<em>BB</em> #2203﻿&gt;, Allingham, “Some Chat about William Blake” &lt;﻿<em>BB</em> #803﻿&gt;, and <em>Nightingale Valley</em>, ed. Giraldus [Allingham] &lt;﻿<em>BB</em> #264﻿&gt;.</p>

<p class="author">§Anon. “<a href="https://books-google-com.libproxy.lib.unc.edu/books?id=IHtBAAAAYAAJ&amp;pg=PA17#v=onepage&amp;q&amp;f=false" target="_blank">Parnassian Pastimes</a>.” <em>Baltimore Literary Monument</em> 2.1 (May 1839): 17.</p>
<p class="desc">It reprints Blake’s “Tyger” to show its “singular beauty, originality, and strength.”</p>

<p class="author">§Antonielli, Arianna. <a href="http://www.estudiosirlandeses.org.libproxy.lib.unc.edu/wp-content/uploads/2013/06/pdfAriannaAntonielli.pdf" target="_blank">“William Butler Yeats’s ‘The Symbolic System’ of William Blake.”</a> <em>Estudios Irlandeses</em> 3 (2008): 10-28.</p>

<p class="author">§Antonielli, Arianna, and Mark Nixon. “Towards an Edition of Edwin John Ellis and William Butler Yeats’s <em>The Works of William Blake: Poetic, Symbolic and Critical</em>.” <em>Variants</em> 10 (2013): 271-84.</p>

<p class="author">§*Arnaldo, Javier. “<em>Behemot y Leviatán</em> (1825), de William Blake.” <a href="http://recursos.march.es/web/prensa/boletines/pdf/2014/n-428-marzo-2014.pdf" target="_blank"><em>Revista de la Fundación Juan March</em> no. 428</a> (2014): 2-8. In Spanish.</p>

<p class="author">§*Arvelo Ramos, Alberto. <em>Deus inversus: los universos religiosos, políticos, ontológicos y poéticos de William Blake</em>. Mérida [Venezuela]: Universidad de Los Andes, Dirección General de Cultura y Extensión, Ediciones Actual, 2010. In Spanish.</p>
<p class="reviewheading">Review</p>
§Mauricio Navia, “<a href="http://erevistas.saber.ula.ve.libproxy.lib.unc.edu/index.php/actualdivulgacion/article/view/4721/4490" target="_blank">Libro de Alberto Arvelo Ramos: Los elementos religiosos, políticos, ontológicos y poéticos de William Blake</a>,” <em>Actual Divulgación</em> 72 (2012) (in Spanish).<br>
  
<p class="author">§Attar, Samar. “Poetic Intuition and Mystic Vision: William Blake’s Quest for Equality and Freedom.” <em>Borrowed Imagination: The British Romantic Poets and Their Arabic-Islamic Sources</em>. Lanham [Maryland]: Lexington Books, 2014. 99-118 (chapter 4).</p>

<p class="author">§[Author given only in Chinese]. “[The Comparative Analysis on William Wordsworth and William Blake on the Art of Naturalism and Realism].” [<em>Blooming Season</em>] 6 (2014). In Chinese.</p>

<p class="mainheading"><a name="B">B</a></p>

<p class="author">*Bančević Pejović, Ivana. “<a href="https://phaidrakg-kg-ac-rs.libproxy.lib.unc.edu/detail_object/o:453?tab=0#mda" target="_blank">Odbrana kreativnosti: Vilijam Blejk u savremenoj književnoj kritici, pedagogiji i umetnosti</a> [A Defense of Creativity: William Blake in Contemporary Criticism, Pedagogy, and Art].” University of Kragujevac [Serbia] PhD, 2014. In Serbian, with a summary in English.</p>

<p class="author">*Bentley, G. E., Jr. <em>William Blake in the Desolate Market</em>. Montreal and Kingston: McGill–Queen’s University Press, 2014. 4º, xx, 244 pp., 34 reproductions; ISBN: 9780773543065. “Issued in print and electronic formats.”</p>
<p class="reviewheading">Review</p>
*Gregory Dart, “To Colour and to Sell,” <em>Times Literary Supplement</em> 21 Nov. 2014: 12 (Bentley “reorganize[s] and re-present[s] everything that is currently known about Blake’s commercial activities in a new and highly compelling form …,” “<em>Desolate Market</em> will prove an indispensable resource for Blake scholars, but it may also, because of its fascinating appendix, have something to say to more general enthusiasts of the period”).<p></p>

<p class="author">Billington, Michael. “<a href="http://www.theguardian.com/stage/2014/jul/15/in-lambeth-review-blake-paine" target="_blank"><em>In Lambeth</em> [play by Jack Shepherd] Review—Blake v. Paine in Lively Imaginary Encounter</a>.” <em>Guardian</em> [London] 15 July 2014.</p>

<p class="gapcenter"><em>Blake/An Illustrated Quarterly</em></p>
<p class="desc">For the inclusion of some back issues of the journal in the <em>William Blake Archive</em> in 2014, see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Archive"><em>William Blake Archive</em></a> in Part I, Section B.</p>

<p class="gapcenter"><em><a name="Blake474" id="Blake474"></a>Blake/An Illustrated Quarterly</em></p>
 <p class="reviewheading">Volume 47, number 4 (spring 2014)</p>
 <p class="reviewheading">Article</p>
*Robert N. Essick. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/essick474/essick474html" target="_blank">Blake in the Marketplace, 2013</a>.” 15 invaluable reproductions. (A stupendous labor admirably accomplished.)<br>
<p class="reviewheading">Minute Particulars</p>
Mary Lynn Johnson. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/johnson474/johnson474html" target="_blank">Newfound Particulars of Blake’s Patrons, Thomas and Elizabeth Butts, 1767–1806</a>.” 12 pars. (Wonderful details of Elizabeth Mary Cooper [Butts] as a school mistress [1767-1801] and of Thomas Butts [1786-1806], particularly his residences and work in the office of the Commissary General of Musters.)<br>
*Paul Miner. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/miner474/miner474html" target="_blank">Francis Quarles’s Influence on <em>Europe</em> 11</a>.” 5 pars.
<p class="reviewheading">Reviews</p>
*Grant F. Scott. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/scott474/scott474html" target="_blank">Steve Clark, Tristanne Connolly, and Jason Whittaker, eds., <em>Blake 2.0: William Blake in Twentieth-Century Art, Music and Culture</em></a>. 15 pars. (“Most of the essays read like standard reception studies,” pace the editors.)<br>
*Tristanne Connolly. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/connolly474/connolly474html" target="_blank">Sibylle Erle, <em>Blake, Lavater and Physiognomy</em></a>. 9 pars. (“What is most impressive about her study is the careful detail on the publication history of Lavater’s work and the personal relationships involved.”)<br>

<p class="gapcenter"><em><a name="Blake481" id="Blake481"></a>Blake/An Illustrated Quarterly</em></p>
<p class="reviewheading">Volume 48, number 1 (summer 2014)</p>
<p class="reviewheading">Articles</p>
*G. E. Bentley, Jr. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/inscriptions481/bentley481html" target="_blank">Inscriptions by Blake for His Designs</a>.” 5 reproductions.<br>
*G. E. Bentley, Jr., with the assistance of Hikari Sato for Japanese publications and of Fernando Castanedo for Spanish publications. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html" target="_blank">William Blake and His Circle: A Checklist of Publications and Discoveries in 2013</a>.” 7 reproductions.<br>

<a name="Blake482" id="Blake482"></a><p class="gapcenter"><em>Blake/An Illustrated Quarterly</em></p>
<p class="reviewheading">Volume 48, number 2 (fall 2014)</p>
<p class="reviewheading">Article</p>
*Eliza Borkowska. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/borkowska482/borkowska482html" target="_blank">‘Did he who made the Lamb make the… Tyger’?</a>” 25 pars. (The question in “The Tyger” “expresses the most fundamental guideline of his philosophy ….”)<br>
<p class="reviewheading">Reviews</p>
G. A. Rosso. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/rosso482/rosso482html" target="_blank">Steven Goldsmith, <em>Blake’s Agitation: Criticism and the Emotions</em></a>. 11 pars. (“An imaginative, deeply learned, and passionately argued book,” though it “does not add much to readings of any of Blake’s major poems.”)<br>
*Sibylle Erle. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/erle482/erle482html" target="_blank">Susan Matthews, <em>Blake, Sexuality and Bourgeois Politeness</em></a>. 8 pars. (“A must-read,” “fierce, fascinating, and passionate.”)<br>
Morton D. Paley. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/paley482/paley482html" target="_blank">Mark Crosby and Robert N. Essick, eds., <em>Genesis: William Blake’s Last Illuminated Work</em></a>. 16 pars. (Primarily an analysis of Blake’s manuscript.)<br>
<p class="reviewheading">Addenda</p>
[G. E. Bentley, Jr.]. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/bentley482/bentley482html" target="_blank">Inscriptions by Blake for His Designs</a>.”<br>

<a name="Blake483" id="Blake483"></a><p class="gapcenter"><em>Blake/An Illustrated Quarterly</em></p>
<p class="reviewheading">Volume 48, number 3 (winter 2014–15)</p>
<p class="reviewheading">Article</p>
*James F. Moyer. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/moyer483/moyer483html" target="_blank">‘The Daughters Weave their Work in loud cries’: Blake, Slavery, and Cotton</a>.” 33 pars. (“It [<em>Visions</em>] shows the brutal facts of New World slavery.”)<br>
<p class="reviewheading">Reviews</p>
*Ossian Lindberg. <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/lindberg483/lindberg483html" target="_blank">Carl-Johan Malmberg, <em>Stjärnan i foten. Dikt och bild, bok och tanke hos William Blake</em></a> [<em>The Star in the Foot: Poetry and Image, Book and Thought in William Blake</em>]. 14 pars. (“The first book on Blake in Swedish”; “The book would be well worth translating into English.”)<br>
*G. E. Bentley, Jr. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/bentley483/bentley483html" target="_blank">Shades of Gray</a>.” [<em>Poems of Thomas Gray with Watercolour Illustrations by William Blake</em>. Folio Society, 2013.] 10 pars. (Compares the different reproductions of Blake’s designs for Gray, concluding that “none of these printed works is a facsimile,” but “the Folio Society edition seems to me distinctly the most reliable.” There is a record and reproduction of the four fingerprints on p. [158], probably those of William or Catherine Blake.)<br>
*Sibylle Erle. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/erle483/erle483html" target="_blank">What New Is There to Learn from Old Familiars?</a>” Burning Bright: William Blake and the Art of the Book, John Rylands Library, University of Manchester, 8 February–23 June 2013. 11 pars. (“None of what was on display was actually new”; she felt a “sense of disappointed excitement.”)<br>
*Morton D. Paley. “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/paley483/paley483html" target="_blank">Tate Britain’s New Blake Room</a>.” 6 pars. (It was opened on 14 May 2013; “There is something about the room itself that encourages peaceful contemplation.” He gives a “timeline of William Blake at the Tate,” 1897–2013; the institution was “re-renamed Tate Britain” in 2000.)<br>

<p class="author">*Blake Society. <em>Calendar of Events for 2014</em>. London, [May] 2014. Small quarto [i.e., square], 20 pp., no ISBN.</p>

<p class="author">*Bonnefoy, Yves, ed. <em>William Blake</em>. N.p.: Éditions Hazan, 2013. 224 pp., 34 reproductions; ISBN: 9782754106030. In French.</p>
1. Yves Bonnefoy. “Blake aujourd’hui.” 1-13.<br>
[2]. Roland Recht. “Entre Moyen Age et avènement d’un art nouveau: William Blake et la ligne prophétique.” 14-51.<br>
[3]. Patrizia Lombardo. “La netteté du trait.” 52-77.<br>
[4]. Michael Phillips. “Parodie et jeu dans l’art composite de William Blake.” Trans. Jean-François Allain. 78-120.<br>
[5]. E. P. Thompson. “‘London’ (‘Londres’).” Trans. Jean-François Allain. First published in <em>Interpreting Blake</em>, ed. Michael Phillips (1978). 121-62.<br>
[6]. Pascal Griener. “<span lang="he">יה</span>‎ and his two Sons Satan &amp; Adam: La planche du <em>Laocoon</em>, un testament artistique de William Blake.” 163-85.<br>
[7]. Michael Edwards. “Voir: Blake et Dante.” 186-209.<br>
[8]. Michael Phillips. “Recréer les plaques des livres enluminés de William Blake (ill. 31 à 34).” Trans. Jean-François Allain. 210-17.<br>

<p class="author">Botero, Manuel José. “<a href="http://revistas.ucm.es.libproxy.lib.unc.edu/index.php/EIUC/article/view/43276/40994" target="_blank">Física y Metafísica: notas sobre el espíritu poético de Blake y Whitman</a>.” <em>Estudios Ingleses de la Universidad Complutense</em> 21 (2013): 107-25. In Spanish.</p>

<p class="author">*Boutilier, Emily Gold. “<a href="https://www.amherst.edu/aboutamherst/magazine/issues/2012winter/showstopper" target="_blank">Showstopper</a>.” <em>Amherst</em> 64.2 (winter 2012): 26-29. &lt;﻿§<em>Blake</em> (2014)﻿&gt;</p>
<p class="desc">About the acquisition of <em>The Raising of Jairus’s Daughter</em> &lt;﻿Butlin #417﻿&gt; by Amherst College from Henry deForest Webster, who received it as a gift from his mother, “who’d inherited it from her second husband, Webster’s stepfather, who’d received it from his own father, William Augustus White.”</p>

<p class="author">*Bray, Mrs. [A. E.] <em>Life of Thomas Stothard, R. A.</em> 1851. &lt;﻿<em>BB</em> #1273﻿&gt; B. §[Whitefish (Montana)]: Literary Licensing LLC, 2014. 272 pp.; ISBN: 9781497909267.

</p><p class="author">§*Broeke, Isabelle van den. “<a href="https://openaccess-leidenuniv-nl.libproxy.lib.unc.edu/bitstream/handle/1887/23299/JLGC%202-6%20Broeke.pdf?sequence=1" target="_blank">Visions of Death: Robertson’s Phantasmagoria as a Visual Paradigm for Goya and Blake</a>.” <em>Journal of the LUCAS Graduate Conference</em> [Leiden] no. 2 (2014): 60-81.</p>

<p class="author">§Broeke, Isabelle van den. “Visual Anti-Tales: The Phantasmagoric Prints of Francisco Goya and William Blake.”  <em>Anti-Tales: The Uses of Disenchantment</em>. Ed. Catriona McAra and David Calvin. Newcastle upon Tyne: Cambridge Scholars, 2011. 142-51.</p>

<p class="author">*Brooks, Richard. “Bring Me My Buyers: Blake Homes for Sale.” <em>Sunday Times</em> [London] 16 March 2014.</p>
<p class="desc">“The public relations guru Sir Alan Parker is weighing up plans to buy the former London home of the poet [17 South Molton Street] … and preserve it for the nation.” He “would need to raise £7m.”</p>

<p class="author">Bryan, Michael. <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=V5pFAQAAMAAJ&amp;pg=PR1#v=onepage&amp;q&amp;f=false" target="_blank"><em>A Biographical and Critical Dictionary of Painters and Engravers</em></a>. 2 vols. London, 1816. B. 1849. &lt;﻿<em>BB</em> #1305﻿&gt; C. §1865. &lt;﻿<em>BBS</em> p. 427﻿&gt;</p>
<p class="desc">In an appendix to vol. 2 of 1816 (p. <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=PH5OAAAAYAAJ&amp;pg=PA717#v=onepage&amp;q&amp;f=false" target="_blank">717</a>) is a list of the “principal works” of Luigi Schiavonetti, including “a set of etchings, illustrative of Blair’s Grave; after the designs of <em>Blake</em>.” A biographical account of Blake was added to the 1849 edition (see &lt;﻿<em>BB</em> #1305﻿&gt;).</p>

<p class="author">Byrne, Joseph. “Blake, Joseph Johnson, and <em>The Gates of Paradise</em>.” <em>Wordsworth Circle</em> 44.2-3 (spring-summer 2013): 131-36.</p>
<p class="desc">Johnson did not publish <em>The Gates of Paradise</em>.</p>

<p class="mainheading"><a name="C">C</a></p>
<p class="author">Cao, Liang-Cheng. “Qing Ai de Xian Zhuang Shi Jian He Li Xiang—Bu Lai Ke Ai Qing Shi Lun Li Fen Xi: The Reality, Practice, and Ideal of Love—Ethical Analysis of William Blake’s Love Poems.” <em>Changchun Gong Cheng Xue Yuan Xue Bao: Journal of Changchun Institute of Technology (Social Science Edition)</em> 14.2 (2013): 76-78. In Chinese, with an abstract in English.</p>
<p class="desc">“Blake’s love ideal involves the love morals of the ideal human society.”</p>

<p class="author">§Cárcano, Enzo. “El cuerpo como ‘via mystica’ en algunos textos de Blake y de Viel Temperley.” <em>Palabra</em> no. 25 (2014): 81-92. Abstract in Spanish and English.</p>
<p class="desc">Héctor Viel Temperley is a prestigious Argentine poet.</p>

<p class="author">§Carnevale, Susana. <em>Fotos tan íntimas: Emily Dickinson, William Blake, Jacques Lacan</em>. Buenos Aires: Vinciguerra, 2010. 23 cm., 118 pp.; ISBN: 9789508437969. In Spanish.</p>

<p class="author">*Carpenter, Caroline. “<a href="http://www.thebookseller.com/news/blake-society-urges-support-jerusalem-cottage-buy" target="_blank">Blake Society Urges Support for ‘Jerusalem’ Cottage [in Felpham] Buy</a>.” <em>The Bookseller</em> 26 Nov. 2014.</p>

<a name="Chainey" id="Chainey"></a><p class="author">*Chainey, Graham. “<a href="http://brightonandhoveindependent.co.uk/site-literary-pilgrimage-deserves-saved/" target="_blank">A Site of Literary Pilgrimage That Deserves to Be Saved</a>.” <em>Brighton &amp; Hove Independent</em> 9 Oct. 2014.</p>
<p class="desc">On the proposed sale of Blake’s cottage in Felpham.</p>

<p class="author">Chatto, William Andrew. <em>A Treatise on Wood Engraving Historical and Practical with Upwards of Five Hundred Illustrations Engraved on Wood by John Jackson. A New Edition with an Additional Chapter by Henry G. Bohn</em>. London: Chatto and Windus, n.d. [1840?]. 4º.</p>
<p class="desc">The frontispiece represents “Death’s Door” (William Blake-W. J. Linton). See John Jackson [and William A. Chatto], <em>A Treatise on Wood Engraving</em> (1839, 1861) &lt;﻿<em>BB</em> #1932﻿&gt;, in which the 1839 edition has “Upwards of Three Hundred Illustrations” and that of 1861 has “145 additional wood engravings.”</p>

<p class="author">Chen, Jing, and Li Zhang. “Wei Lian Bu Lai Ke Shi Ge de Yi Xiang Te Se [Analysis of Characteristic Images in William Blake’s Poems].” <em>Qing Nian Wen Xue Jia</em> [<em>Young Writers of Literature</em>] 27 (2012): 11. In Chinese.</p>

<p class="author">*Chesterton, G. K. <em>William Blake</em>. 1910 …. &lt;﻿<em>BB</em> #1381, <em>BBS</em> p. 436, <em>Blake</em> (2003, 2013)﻿&gt; O. <em>William Blake y otros temperamentos</em>. Trans. Juan Antonio Montiel and Natalia Babarovic. Santiago: Universidad Diego Portales, 2012. 8º, 208 pp.; ISBN: 9789563141801. In Spanish. Life of Blake on pp. 17-137. P. §Charleston: BiblioLife, 2014. 224 pp.; ISBN: 9781294784616.</p>
<p class="reviewheading">Review (of 2012)</p>
Camilo Marks, “<a href="http://www.elmercurio.com/blogs/2013/08/11/14291/Brillante-heterodoxo-inclasificable.aspx" target="_blank">Brillante, heterodoxo, inclasificable</a>,” <em>El Mercurio</em> 11 Aug. 2013: E14 (in Spanish).<p></p>

<p class="author">§*Chevrier, Jean-François. <em>L’hallucination artistique: de William Blake à Sigmar Polke</em>. Paris: L’Arachnéen, 2012. 23 x 18 cm., 683 pp.; ISBN: 9782952930291. In French.</p>
<p class="reviewheading">Review</p>
§Tristan Trémeau, <em><a href="http://critiquedart.revues.org.libproxy.lib.unc.edu/5562" target="_blank">Critique d’art</a></em> (2013). In French.<br>

<p class="author">*Clark, Steve, Tristanne Connolly, and Jason Whittaker, eds. <em>Blake 2.0: William Blake in Twentieth-Century Art, Music and Culture</em>. 2012. &lt;﻿<em>Blake</em> (2013)﻿&gt;</p>
<p class="reviewheading">Reviews</p>
*Grant F. Scott (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake474"><em>Blake</em> 47.4</a>, above).<br>
Masashi Suzuki, <em>Igirisu Romanha Kenkyu</em> (<em>Essays in English Romanticism</em>) 38 (2014): 85-88 (in Japanese).<br>
<p></p>
<p class="author">§*Clayton, Ellie. <a href="http://www.ian.mulder.clara.net/books/DivineEconomyS.pdf" target="_blank"><em>Divine Economy</em></a>. With illustrations by William Blake. [2014]. A free e-book.</p>

<p class="author">Cooper, Andrew M. <em>William Blake and the Productions of Time</em>. 2013. &lt;﻿<em>Blake</em> (2014)﻿&gt;</p>
<p class="reviewheading">Review</p>
Mark Crosby, <a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/res/hgu052" target="_blank"><em>Review of English Studies</em></a> 66, no. 273 (Feb. 2015 [review first published online June 2014]): 182-83 (“intriguing readings of Blake’s particular formulation of time as an eternally recurring moment”).<br>

<p class="author">*Crespo Martín, Bibiana. “<a href="http://www.arteindividuoysociedad.es/articles/N26.2/Bibiana_Crespo.pdf" target="_blank">El Libro de Artista de ayer a hoy: seis ancestros del Libro de Artista contemporáneo. Primeras aproximaciones y precedentes inmediatos</a>.” <em>Arte, Individuo y Sociedad</em> 26.2 (2014): 311-28. In Spanish.</p>
<p class="desc">Pp. 317-19 are about Blake’s printing method and <em>Songs of Innocence</em> as precursors of the artist’s book.</p>

<a name="Cripps" id="Cripps"></a><p class="author">*Cripps, Charlotte. “<a href="http://www.independent.co.uk/property/william-blakes-cottage-for-sale-9614092.html" target="_blank">William Blake’s [Felpham] Cottage for Sale</a>.” <em>Independent</em> [London] 18 July 2014.</p>

<p class="author">Crocco, Francesco. “Conclusion: William Blake’s Prophecies and the Limits of Nationalism.” <em>Literature and the Growth of British Nationalism: The Influence of Romantic Poetry and Bardic Criticism</em>. Jefferson [North Carolina]: McFarland &amp; Company, 2014. 182-91.</p>

<p class="mainheading"><a name="D">D</a></p>

<p class="author">*Damon, S. Foster. <em>A Blake Dictionary: The Ideas and Symbols of William Blake</em>. 1965 …. &lt;﻿<em>BB</em> #1445, <em>BBS</em> p. 447﻿&gt; G. Hanover [New Hampshire]: Dartmouth College Press, 2013. 4º, xxviii, 532 pp.; ISBN: 9781611684438. &lt;﻿<em>Blake</em> (2014)﻿&gt;</p> 
<p class="desc">2013 is an “updated edition with a new foreword and annotated bibliography by Morris Eaves.”</p>
<p class="reviewheading">Review</p>
*Shirley Dent, <em>Times Literary Supplement</em> 8 Aug 2014: 25 (Eaves’s “excellent” foreword is appropriate to Damon’s book, 		which succeeds “brilliantly but peculiarly”).<br>

<a name="Daniel" id="Daniel"></a><p class="author">§[Daniel, John Moncure]. “<a href="https://books-google-com.libproxy.lib.unc.edu/books?id=r2AAAAAAYAAJ&amp;lpg=PA182&amp;ots=Qj1g7NHh0s&amp;pg=PA172#v=onepage&amp;q&amp;f=false" target="_blank">Edgar Allan Poe</a> [book review].” <em>Southern Literary Messenger</em> 16.3 (March 1850): 172-87.</p>
<p class="desc">Like “the mad artist Blake,” Poe “is a painter of ideas, not of men and things” (182). He cites Cunningham’s <em>Lives</em>.</p>

<p class="author">§Davidson, Ryan J. “<a href="http://theses.gla.ac.uk/5590/" target="_blank">Affinities of Influence: Exploring the Relationship between Walt Whitman and William Blake</a>.” Glasgow PhD, 2014.</p>

<p class="author">*De Luca, Vincent. <em>Words of Eternity: Blake and the Poetics of the Sublime</em>. 1991. &lt;﻿<em>BBS</em> p. 450﻿&gt; B. §Princeton: Princeton Legacy Library, 2014.</p>

<p class="author">Ding, Xiao-Xia. “Qian Xi Bu Lai Ke Lao Hu de Xiang Zheng Yi Yi [Analysis of the Symbolic Meaning of Blake’s ‘Tyger’].” <em>Qing Nian Wen Xue Jia</em> [<em>Young Writers of Literature</em>] 27 (2012): 13-15. In Chinese.</p>

<p class="author">Ding, Yan. “Hu Dan Ying Xiong Q—‘Lao Hu’ Yu ‘Tie Lan Yu Huo’ zhi Bi Jiao [As Brave as a Tyger—A Comparative Study of ‘The Tyger’ and ‘Metal Railing and Fire’].” <em>Zuo Jia</em> [<em>Writers</em>] 16 (2013): 114-15. In Chinese.</p>

<p class="author">Dixon, Jeffrey John. <em>The Glory of Arthur: The Legendary King in Epic Poems of Layamon, Spenser and Blake</em>. Jefferson [North Carolina]: McFarland &amp; Company, 2014. 4º, viii, 204 pp.; ISBN: 9780786494569. Especially pp. 1-23, 26-32, 35-41, 73-80, 171-82.</p>
<p class="desc">“I explore some of the ways in which Blake was himself inspired by … Edmund Spenser” (1).</p>

<a name="Downing" id="Downing"></a><p class="author">*Downing, Jonathan. “How I Discovered a Priceless Set of William Blake Engravings: Jonathan Downing, a theology DPhil student at Trinity, agreed to feature in our latest video feature to share his big discovery.” <a href="http://www.oxfordtoday.ox.ac.uk/sites/files/oxford/OXF10.ebook_lo.pdf" target="_blank"><em>Oxford Today</em> 26.2</a> (2014): 6.</p>
<p class="desc">The discovery is of Blake’s <em>Job</em>, one of “100 [copies] which Blake [recte Lahee] had printed in 1826,” in Trinity College. The video is at &lt;﻿<a href="http://www.oxfordtoday.ox.ac.uk/culture/videos-podcasts-galleries/serendipity-library" target="_blank">http://​www.​oxfordtoday.​ox.​ac.​uk/​culture/​videos-​podcasts-​galleries/​serendipity-​library</a>﻿&gt;.</p>

<p class="author">Dumitrana, Magdalena. “<a href="http://euromentor.ucdc.ro.libproxy.lib.unc.edu/en/2012/vol3n22012/en/9_the-christian-poetry-and-the-formation-of-an-intercultural.pdf" target="_blank">The Christian Poetry and the Formation of an Intercultural Attitude: ‘The Little Black Boy’ by William Blake</a>.” <em>Euromentor Journal</em> 3.2 (June 2012) [9 pp.]. &lt;﻿§<em>Blake</em> (2014)﻿&gt;</p>
<p class="desc">“William Blake’s small poem [“The Little Black Boy”], romantic poet and painter, could serve, we think, to reaching our goal—the inducing of the feeling of intercultural understanding” [5].</p>

<p class="mainheading"><a name="E">E</a></p>

<p class="author">El Younssi, Anouar. “<a href="http://www.moroccoworldnews.com/2012/08/52293/the-sufis-and-william-blake-when-islamic-mysticism-and-english-romanticism-intersect/" target="_blank">The Sufis and William Blake: When Islamic Mysticism and English Romanticism Intersect</a>.” <em>Morocco World News</em> 17 Aug. 2012.</p>
<p class="desc">A learned essay arguing that Blake’s views “echo the views of a number of Muslim sufis.”</p>

<p class="author">Erle, Sibylle. <em>Blake, Lavater and Physiognomy</em>. 2010.&nbsp;&lt;﻿§<em>Blake</em> ﻿(2011)﻿&gt;</p>
<p class="reviewheading">Review</p>
*Tristanne Connolly (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake474"><em>Blake</em> 47.4</a>, above).<p></p>

<p class="mainheading"><a name="F">F</a></p>

<p class="author">§Fallon, David. “The Sensational Mind of William Blake.” <em>Réfléchir (sur) la sensation</em>. Vol. 2: Littérature et création dans le monde britannique. Ed. M. Poisson. Paris: Éditions des archives contemporaines, 2014. 103-22.</p>
<p class="desc">“His narration of the mind’s development has a much closer and more nuanced relationship to the Enlightenment than has previously been recognised.”</p>

<p class="author">*Farrell, Michael. <em>Blake and the Methodists</em>. Basingstoke: Palgrave Macmillan, 2014. 21.4 cm. high, x, 259 pp.; ISBN: 9781137455499.</p>
<p class="desc">A survey of Blake’s religious sources, including chapter 2 (30-50) on “The Moravians.” “There was … a Methodist influence on Blake’s works, but it was combined with a number of other religious sympathies” (193).</p>

<p class="author">Ferber, Michael. <em>The Social Vision of William Blake</em>. 1985. &lt;﻿<em>BBS</em> p. 471﻿&gt; B. §Princeton: Princeton Legacy Library, 2014. ISBN: 9780691611464.</p>

<p class="author">*Flood, Alison. “<a href="http://www.theguardian.com/culture/2014/sep/11/crowdfunding-campaign-william-blake-cottage" target="_blank">Crowdfunding Campaign Hopes to Save William Blake’s Cottage for Nation</a>: Fundraisers looking to raise £520,000 to buy the house where he wrote, ‘Heaven opens here on all sides her golden Gates.’” <em>Guardian</em> [London] 11 Sept. 2014.</p>

<p class="author">§Fosso, Kurt. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1080/10509585.2013.865524" target="_blank">‘Feet of Beasts’: Tracking the Animal in Blake</a>.” <em>European Romantic Review</em> 25.2 (2014): 113-38.</p>

<p class="author">*Freed, Eugenie R. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1080/00138398.2014.963281" target="_blank">‘By Wondrous Birth’: The Nativity of William Blake’s ‘The Tyger.’</a>” <em>English Studies in Africa</em> 57.2 (Oct. 2014): 13-32.</p>
<p class="desc">A persuasive argument that “the ‘Notebook’ sketches [illustrating <em>Paradise Lost</em>] have a direct bearing on the drafts of ‘The Tyger’ that Blake subsequently inscribed near” them (19).</p>

<p class="mainheading"><a name="G">G</a></p>

<p class="author">*Garcia, Humberto. “Blake, Swedenborg, and Muhammad: The Prophetic Tradition, Revisited.” <em>Religion &amp; Literature</em> 44.2 (summer 2012): 35-65.</p>

<p class="author">*Gardner, Charles. <em>William Blake the Man</em>. 1919 …. &lt;﻿<em>BB</em> #1662, §<em>Blake</em> (2010)﻿&gt; D. §[Whitefish (Montana)]: Literary Licensing LLC, 2014. 224 pp.; ISBN: 9781497901568.</p>

<p class="author">§*Ghiţă, Cătălin. <em>Demiurgul din Londra: Introducere în poetica lui William Blake</em>. Iaşi: Institutul European, 2014. 264 pp., 14 x 19 cm.; ISBN: 9786062400569. In Romanian.</p>

<p class="author">*Gilchrist, Alexander. <em>Life of William Blake, “Pictor Ignotus.”</em> 1863, 1880, 1907 …. &lt;﻿<em>BB</em> #1680, <em>BBS</em> p. 484, <em>Blake</em> (1999, 2002, 2007, 2010, 2011, 2012, 2013, 2014)﻿&gt;
T. <em>The Life of William Blake, “Pictor Ignotus”</em>. [Whitefish (Montana)]: Literary Licensing LLC, 2014. Vol. 1, 426 pp.; ISBN: 9781498077286; vol. 2, 352 pp.; ISBN: 9781498045704. U. <em>The Life of William Blake</em>. Ed. Walford Graham Robertson [1907]. Charleston: BiblioLife, 2014. 660 pp.; ISBN: 9781293815274.</p>
<p class="reviewheading">1863</p>
<p class="reviewheading">Copies annotated by early owners <span class="notecall">(see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Gilchrist" target="_blank"><em>Blake</em> [2014]</a>﻿&gt; for others)</span><span class="fn">See also Thomas Carlyle’s letter [to the publishers Chapman &amp; Hall] (1859) relating to Gilchrist’s <em>Life of William Blake</em> (British Library Department of Manuscripts: <a href="http://searcharchives.bl.uk.libproxy.lib.unc.edu/primo_library/libweb/action/display.do?tabs=detailsTab&amp;ct=display&amp;doc=IAMS040-001603269&amp;displayMode=full&amp;vid=IAMS_VU2" target="_blank">RP 6421</a>).</span></p>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Edwin J. Ellis, with his annotations (collection of Robert N. Essick)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Frederick Locker-Lampson, with a few annotations (collection of Robert N. Essick)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Dante Gabriel Rossetti, a volume labeled DANTE | GABRIEL | ROSSETTI | LETTERS TO | ANN | GILCHRIST AND | MANUSCRIPT NOTES | FOR LIFE OF BLAKE, with 44 loose letters and notes of 1860–80 (collection of Mrs. Landon K. Thorne [d. 1974], presumably now in the Morgan Library)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Dante Gabriel Rossetti, a collection with a printed title page: DANTE G. ROSSETTI. | — | ORIGINAL | AUTOGRAPH LETTERS | (1862-3 AND 1880) | WRITTEN BY DANTE GABRIEL ROSSETTI TO MRS. GILCHRIST | (WIDOW OF | ALEXANDER GILCHRIST THE BIOGRAPHER OF WILLIAM BLAKE) | CONCERNING BLAKE AND HIS WORKS. | INCLUDED ALSO IS A LETTER FROM ROSSETTI TO | ALEXANDER GILCHRIST IN 1861 ON THE SAME SUBJECT, with 21 letters (collection of Mrs. Landon K. Thorne [d. 1974], presumably now in the Morgan Library)</span><br>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Dante Gabriel Rossetti, page proofs for Gilchrist (1863) vol. 2 for the sections of <em>Songs of Innocence</em> and <em>Songs of Experience</em> with ms. corrections by D. G. Rossetti and perhaps W. M. Rossetti, with two leaves of ms. notes “by Rossetti” (Mark Samuels Lasner, on loan to the University of Delaware)</span><br>
William Michael Rossetti, with his annotations <span class="notecall">(Harvard)</span><span class="fn">Martin Butlin, “William Rossetti’s Annotations to Gilchrist’s <em>Life of William Blake</em>,” <em>Blake</em> 2.3 (1968): 39-40.</span><br>
<span style="display: block; padding-left: 15px; text-indent: -15px">James <span class="notecall">Smetham,</span><span class="fn">Smetham’s review of Gilchrist in the <em>London Quarterly Review</em> &lt;﻿<em>BB</em> #2716﻿&gt; was revised and printed in Gilchrist (1880) <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=XXZAAAAAYAAJ&amp;pg=PA311#v=onepage&amp;q&amp;f=false" target="_blank">2: 311-51</a>.</span> with his <span class="notecall">pictorial annotations</span><span class="fn">Frances A. Carey, “James Smetham (1821–1889) and Gilchrist’s <em>Life of Blake</em>,” <em>Blake</em> 8.1-2 (summer-fall 1974): 17-25, about marginal sketches in a copy of Gilchrist (1863).</span> (collection of Robert N. Essick)</span>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">Extra-illustrated with over 200 Blake prints, especially those from <em>For the Sexes</em> (N), sold by “a Gentleman” at Sotheby’s (London), 9 May 1991, lot 8, to Anon.</span><br>
<span style="display: block; padding-left: 15px; text-indent: -15px">Extra-illustrated with <em>There is No Natural Religion</em> (J), sold with the library of Ogden Goelet at American Art Association/Anderson Galleries, 3 Jan. 1935, <span class="notecall">lot 26,</span><span class="fn">Goelet’s copy of <em>Night Thoughts</em> (1797), colored (Z), was lot 25 in the 1935 sale.</span> to Anon.</span>
<p class="reviewheading">1880</p>
<p class="reviewheading">Copy annotated by early owner</p>
<span style="display: inline-block; padding-left: 15px; text-indent: -15px">William Michael Rossetti, presentation inscription by Mrs. Gilchrist, with his annotations (collection of Robert N. Essick)</span><br>

<p class="author">§*Gizzo, Luciana Del. “<a href="http://2012.cil.filo.uba.ar.libproxy.lib.unc.edu/sites/2012.cil.filo.uba.ar/files/0127%20DEL%20GIZZO,%20LUCIANA.pdf" target="_blank">Temporalidades encontradas en <em>The Marriage of Heaven and Hell</em> de William Blake</a>.” <em>V Congreso Internacional de Lettras</em> (2012). Abstract in Spanish and English.</p>

<p class="author">*Goldsmith, Steven. <em>Blake’s Agitation: Criticism and the Emotions</em>. 2013. &lt;﻿<em>Blake</em> (2014)﻿&gt;</p>
<p class="reviewheading">Reviews</p>
*Simon Jarvis, “Eternal Great Humanity Divine-ist,” <em>Times Literary Supplement</em> 17 Jan. 2014: 7-8 (Goldsmith’s book is 			“subtle, complicated and counterintuitive” but with “a certain arbitrariness”).<br>
G. A. Rosso (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake482"><em>Blake</em> 48.2</a>, above).<br>

<p class="author">§Gonçalves, Davi Silva, and Ricardo Heffel Farias. “<a href="http://www.falasbreves.ufpa.br.libproxy.lib.unc.edu/artigos/primeira-edicao/the-voice-of-the-devil.pdf" target="_blank">‘The voice of the Devil’: a reconstrução do mito cristão por José Saramago e William Blake</a>.” <em>Falas Breves</em> no. 1 (Feb. 2014). Abstract in Portuguese and English.</p>

<p class="mainheading"><a name="H">H</a></p>

<p class="author">*Haggarty, Sarah. <em>Blake’s Gifts: Poetry and the Politics of Exchange</em>. 2010. &lt;﻿<em>Blake</em> (§2011, 2012, 2013, 2014)﻿&gt; B. §Cambridge: Cambridge University Press, 2014. 254 pp.; ISBN: 9781107449152.</p>
<p class="reviewheading">Review</p>
§Jennifer Davis Michael, “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1353/ecy.2014.0022" target="_blank">Drawn Dry with Thanks and Compliments: Blake and the Gift</a>,” <em>Eighteenth Century</em> 55.2-3 (summer-fall 2014): 295-99.<br>

<p class="author">Haggarty, Sarah, and Jon Mee, eds.; consultant ed. Nicolas Tredell. <em>William Blake: Songs of Innocence and of Experience</em>. Basingstoke: Palgrave Macmillan, 2013. Readers’ Guides to Essential Criticism Series. ix, 200 pp., no reproduction; ISBN: 9780230220096.</p>

<p class="author">Han, Fang, and Wei-Jing Yan. “Jie Du Lao Hu de Ge Ming Xiang Zheng Yi Yi: Interpretations of the Revolutionary Symbol in ‘The Tyger.’” <em>Wai Yu Jiao Yu Jiao Xue</em> [<em>Journal of Language and Literature Studies</em>] 8 (2013): 64-66. In English.</p>

<p class="author">§Hanson, Lenora. “<a href="http://www.cairn.info.libproxy.lib.unc.edu/revue-multitudes-2014-1-page-94.htm" target="_blank">Allégorie des multitudes, ou William Blake comme économe défaillant</a>.” <em>Multitudes</em> no. 55 (2014): 94-100. Abstract in French and English.</p>

<p class="author">Hao, Xiang-Li. “Shi Hua Gong Sheng de Bu Lai Ke Shi Ge [The Coexistence of Painting and Poem in Blake’s Poetry].” <em>Zuo Jia</em> [<em>Writers</em>] 12 (2012): 95-96. In Chinese.</p>
<p class="desc">A discussion of how Blake’s poems are illustrated by his paintings.</p>

<p class="author">*Hargraves, Matthew. “<a href="http://openglam.org/2014/10/07/william-blake-and-paul-mellon-the-life-of-the-mind/" target="_blank">William Blake and Paul Mellon: The Life of the Mind</a>.” <em>OpenGLAM</em> 7 Oct. 2014.</p>
<p class="desc">A valuable summary.</p>

<p class="author">Hayes, Kevin J. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt243" target="_blank">Poe’s Knowledge of William Blake</a>.” <em>Notes and Queries</em>, n.s., 61.1 (March 2014): 83-84.</p>
<p class="desc">Though “nowhere in his collected works does Poe mention him [Blake],” John Moncure Daniel wrote in 1850 that, like “the mad artist Blake,” Poe “is a painter of ideas, not of men and things” (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Daniel">Daniel</a>, above). The “fearful symmetry” of Blake’s “Tyger” is like “the fearful scimitar” moving “with the stealthy pace of the tiger” in Poe’s “The Pit and the Pendulum.”</p>

<p class="author">He, Lin. “Tan Tao Wei Lian Bu Lai Ke Shi Zhong Fu Mu Yu Hai Zi Yi Xiang de Mao Dun Xing [Exploring Contradictoriness of Parents and Children in Blake’s Poems].” <em>Kao Shi Zhou Kan</em> [<em>Examination Weekly</em>] 57 (2013): 13-15. In Chinese.</p>

<p class="author">§*Holden, Harry. <em>William Blake 44 Success Facts—Everything You Need to Know about William Blake</em>. N.p.: Emereo Publishing, 2014. 44 pp.; ISBN: 9781488551482. There are both print-on-demand and Kindle versions.</p>

<a name="Holledge" id="Holledge"></a><p class="author">Holledge, Richard. “<a href="http://www.nytimes.com.libproxy.lib.unc.edu/2014/11/21/greathomesanddestinations/society-hopes-to-buy-william-blake-cottage.html?_r=0" target="_blank">Society Hopes to Buy William Blake Cottage</a> [at Felpham].” <em>New York Times</em> 20 Nov 2014.</p>

<p class="author">Huo, Yue-Hong, and Xiao-Hong Li. “Tian Zhen de Yu Yan Zhong Fan Za Yi Xiang de Yuan Xing Jie Du [An Interpretation of Images in ‘Auguries of Innocence’].” <em>Duan Pian Xiao Shuo</em> [<em>Short Fiction</em>] 13 (2013): 49-50. In Chinese.</p>

<p class="author">Hutton, Ronald. “Interlude: A Pair of Williams.” <em>Blood and Mistletoe: The History of the Druids in Britain</em>. New Haven: Yale University Press, 2009. 183-209.</p>
<p class="desc">The two Williams are Blake and Wordsworth.</p>

<p class="mainheading"><a name="I">I</a></p>

<p class="author">*Ikegame, Naoko. <em>Igirisu Geijutsu Kyoiku Shiso niokeru Dokusosei to Kokyosei: Reynolds, Blake to Romanshugi no Kodomokan</em> [<em>The Originality and Publicness of the Thoughts on Arts Education in Britain: Reynolds, Blake, and Views on Children in Romanticism</em>]. Tokyo: Kazama Shobo, 2014. 220 pp.; ISBN: 9784759920383. In Japanese.</p>
<p class="desc">Based on her thesis, below.</p>

<p class="author">§Ikegame, Naoko. “Igirisu Geijutsu Kyoiku Shiso niokeru Dokusosei to Kokyosei: Reynolds, Blake to Romanshugi no Kodomokan [The Originality and Publicness of the Thoughts on Arts Education in Britain: Reynolds, Blake, and Views on Children in Romanticism].” Ochanomizu University PhD, 2011. In Japanese.</p>
<p class="desc">The basis of her book with the same title, above.</p>

<p class="author">Ikezawa, Natsuki. “Shi no Nagusame (25): Blake no Rhythm to Shiso [Comfort in Poetry (25): The Rhythm and Thoughts of Blake].” <em>Tosho</em> [<em>Book</em>] 782 (2014): 30-33. In Japanese.</p>

<p class="mainheading"><a name="J">J</a></p>

<p class="author">Jiang, Jian-Jun. “Wei Lian Bu Lai Ke de Zong Jiao Xiang Xiang Li [The Religious Imagination of William Blake].” <em>Wen Xue Jie</em> [<em>Field of Literature</em>] 3 (2012): 124-25. In Chinese.</p>
<p class="desc">An analysis in terms of falling and being saved.</p>

<p class="author">§Jordis, Christine. “<a href="http://www.cairn.info.libproxy.lib.unc.edu/revue-etudes-2014-4-page-77.htm" target="_blank">Vision prophétique de William Blake</a>.” <em>Études</em> (April 2014): 77-86. In French.</p>

<p class="author">*Jordis, Christine. <em>William Blake ou l’infini</em>. Paris: Éditions Albin Michel, 2014. 20.5 x 14.0 cm., 287 pp.; ISBN: 9782226254672. In French.</p>
<p class="desc">Described on the back cover as an “essai biographique passionné et passionnant.”</p>

<p class="mainheading"><a name="K">K</a></p>

<p class="author">Kang, Li-Ying. “Cong Wen Ti Jiao Du Fen Xi Wei Lian Bu Lai Ke Shi Ge Lao Hu Yin Yu Yi Yi de Ti Xian: The Analysis of Metaphorical Meaning of Poetry—Take from Stylistic Point of View <em>The Tyger</em> by William Blake as an Example].” <em>Xin Zhou Shi Fan Xue Yuan Xue Bao: Journal of Xinzhou Teachers University</em> 28.6 (Dec. 2012): 68-70. In Chinese, with an abstract in English.</p>
<p class="desc">Analyzes “the metaphorical meaning of <em>The Tyger</em>” in terms of its “rhythm and meter, written forms, and lexical semantics.”</p>

<p class="author">§Keshavarzian, Ramin, and Pyeaam Abbasi. “<a href="http://www.researchgate.net/profile/Ramin_Keshavarzian/publication/265874497_Visions_of_the_Daughters_of_Albion_The_Influence_of_Mary_Wollstonecraft&#39;s_Life_and_Career_on_William_Blake/links/542016e60cf203f155c2a32b.pdf" target="_blank"><em>Visions of the Daughters of Albion</em>: The Influence of Mary Wollstonecraft’s Life and Career on William Blake</a>.” <em>International Letters of Social and Humanistic Sciences</em> 29 (2014): 48-63.</p>

<p class="author">Kingston, Beryl. <em>Gates of Paradise</em>. 2006. &lt;﻿§<em>Blake</em> ﻿(2007)﻿&gt; B. §2007. &lt;﻿§<em>Blake</em> ﻿(2008)﻿&gt; C. §London: Bloomsbury Reader, 2014 [e-book]. ISBN: 9781448213931.</p>
<p class="desc">A fictional work in which she “reimagines the historical events which led to William Blake’s trial for sedition in 1803.”</p>

<p class="author">§Kostova, Ludmilla. “<a href="http://www.academia.edu/4718439/_Re-_Gaining_Prophetic_Authority_through_the_Poetic_Genius_William_Blake_and_Eighteenth-Century_Religious_Enthusiasm" target="_blank">(Re-)Gaining Prophetic Authority through the Poetic Genius: William Blake and Eighteenth-Century Religious Enthusiasm</a>.” <em>Peregrinations of the Text: Reading, Translation, Rewriting: Essays in Honour of Alexander Shurbanov</em>. Ed. Evgenia Pancheva, Christo Stamenov, Maria Pipeva, and Georgi Niagolov. Sofia [Bulgaria]: Sofia University Press “St. Kliment Ohridski,” 2013. 189-200.</p>

<p class="author">Koyama, Keita. “Kagaku Tsurezuregusa (3): William Blake no Shi to Kenbikyo [An Essay on Science (3): The Poetry of William Blake and Microscope].” <em>Gakuto</em> [<em>Academic Lamp</em>] 110 (2013): 50-53. In Japanese.</p>

<p class="author">Kumar, R. Ashok. “<a href="http://www.languageinindia.com.libproxy.lib.unc.edu/oct2012/ashokkumarblakepoemfinal.pdf" target="_blank">Perception of Syntactic Deviations in Poetry—A Study of William Blake’s <em>Songs of Innocence</em></a>.” <em>Language in India</em> 12.10 (Oct. 2012): 83-97. &lt;﻿§<em>Blake</em> ﻿(2014)﻿&gt;</p>
<p class="desc">“The PP ‘down the <span class="notecall">valley</span><span class="fn">I.e., “valleys,” from the “Introduction” to <em>Innocence</em>.</span> wild’ contains a DP ‘the valley wild’. Within the DP we have an NP ‘valley wild’. The words ‘valley’ and ‘wild’ belong respectively to N and A categories” (83).</p>

<p class="mainheading"><a name="L">L</a></p>

<p class="author">Langridge, Irene. <em>William Blake: A Study of His Life and Art Work</em>. 1904. &lt;﻿<em>BB</em> #2098﻿&gt; B. §2010. &lt;﻿§<em>Blake</em> ﻿(2011)﻿&gt; C. §Charleston: BiblioLife, 2014. 282 pp.; ISBN: 9781293766460.</p>

<p class="gapcenter"><em>Language. Philology. Culture</em></p>
<p class="reviewheading"><em>Язык. Словесность. Культура</em></p>
<p class="reviewheading"><a href="http://publishing-vak.ru/archive-2014/philology-1.htm" target="_blank">Nos. 1-2 ([December] 2014)</a></p>
1. *Andrew Solomon. “Divine Vision: Blake’s <em>Job</em>, Plate 14.” 9-11 (in English), 12-15 (in Russian, trans. Vera Serdechnaya).<br>
2. Daniel Gustafsson. “Blake and Orthodoxy.” 16-34 (in Russian, trans. Evgeniy Serdechniy and Vera Serdechnaya), “Abstract” and “References” (35-36) in English. Translated from issue <a href="http://publishing-vak.ru/archive-2013/philology-1.htm" target="_blank">no. 1</a> of 2013.<br>  
3. Daniel Gustafsson. “Blake and Orthodoxy. Part 2: Fourfold and Trinitarian Personality.” 37-63 (in English), abstract (64) in Russian.<br>
<p class="desc">Part 1 (in English) is in the issue for 2013. “The theme of this paper is the <em>ecstatic</em> nature of personality and the understanding of human 	personhood as Trinitarian, in the image of the Trinity” (37); “What he [Blake] calls a ‘fourfold’ vision …, we may read this in terms of a Trinitarian model” (41). “Orthodoxy” is apparently that of the Russian Orthodox Church rather than that of, say, the Greek Orthodox Church or the Roman Catholic Church.</p>
4. *Gerald Eades Bentley, Jr. “Blake’s Loose Canons.” 65-90 (in Russian, trans. Vera Serdechnaya), “Abstract” and “References” (91-92) in English. Translated from issue <a href="http://publishing-vak.ru/archive-2013/philology-1.htm" target="_blank">no. 1</a> of 2013.<br>
5. Galina Al’bertovna Tokareva. “The Northern and the Southern Bars, or the Courage to Live in W. Blake’s ‘The Book of Thel.’” 	93-104 (in Russian), “Abstract” and “References” (104-06) in English.<br>
<p class="desc">“<em>The Book of Thel</em> is analyzed from the viewpoint of its genre affiliation” (105).</p>
6. *Tat’yana Eduardovna Koksharova. “‘Ear,’ ‘auricle,’ ‘vortex’ as an Isomorph Shaped Models [<em>sic</em>] of the World in the Works of William Blake.” 107-17 (trans. into English by the author).<br>
7. *Dmitri Smirnov-Sadovsky. “‘The Mental Traveller’ by William Blake.”  118-42 (in Russian, including his translation of “The Mental Traveller”), “Abstract” and “References” (142-43) in English.<br>
<p class="reviewheading">Announcements and events</p>
8. *“Blake in Nerac: In the town of Nerac (France), an artistic treasure of William Blake (re)discovered by André Furlan.” 144-45 (in English), 146-47 (in Russian).<br>
<p class="desc">“Furlan has discovered a secret drawer with a key, which contains a manuscript on which Blake noted the signatures and the description of the audience and actors who were present at the time <span class="notecall">chosen by Hogarth.”</span><span class="fn">For more on this manuscript, see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#PartIappendix">Part I, Appendix</a>.</span></p>

<p class="author">§Lenihan, Liam. “Wollstonecraft’s Reading of Milton and the Sublime of Barry, Fuseli and Blake.” <em>The Writings of James Barry and the Genre of History Painting, 1775-1809</em>. Farnham: Ashgate, 2014. 127-52.</p>

<p class="author">Li, Jing-Jing. “Bu Lai Ke ‘Fei Mang’ de Yu Yi Jie Du [The Interpretation of Implied Meaning of Blake’s Poem ‘The Fly’].” <em>Wen Jiao Zi Liao</em> [<em>High School Years</em>] 24 (2012): 103-04. In Chinese.</p>
<p class="desc">An interpretation of the implied meaning of the fly, with a consideration of Blake’s personal experience and artistic creation.</p>

<p class="author">Li, Jing-Jing. “Bu Lai Ke San Bu Shi Ji de Yi Xiang Jie Xi [Analysis of Images of Three Blake Books of Poetry].” <em>Hu Bei Han Shou Da Xue Xue Bao: Journal of Hubei Correspondence University</em> 25.12 (Dec. 2012): 169-70. In Chinese.</p>
<p class="desc">Interprets the images in <em>Poetical Sketches</em>, <em>Songs of Innocence</em>, and <em>Songs of Experience</em> and analyzes their connections.</p>

<p class="author">Li, Jing-Jing. “Bu Lai Ke Shi Ge Zhong de ‘Ye’ Yi Xiang Jie Xi [An Analysis of the Images in Blake’s ‘Night’].” <em>Qing Nian Wen Xue Jia</em> [<em>Young Writers of Literature</em>] 27 (2012): 78. In Chinese.</p>

<p class="author">Li, Jing-Jing. “Bu Lai Ke Shi Ge Zhong Duo Yang Mei Gui de Yu Yi Jie Du [An Interpretation of the Imagery of the Rose in Blake’s Poems].” <em>Jin Tian</em> [<em>Jin Tian</em>] 11 (2012): 63. In Chinese.</p>

<p class="author">Li, Jing-Jing. “Cong Tian Zhen Zhi Ge Dao Tian Zhen Zhi Zhao de Tian Zhen Zhi Lu—Bu Lai Ke Shi Ge Zhong de Tian Zhen Qing Jie: The Journey of Innocence from Songs of Innocence to Auguries of Innocence—On Deciphering the Code of Innocence in Blake’s Poems.” <em>Ji Lin Hua Gong Xue Yuan Xue Bao: Journal of Jilin Institute of Chemical Technology</em> 30.10 (Oct. 2013): 61-63. In Chinese, with an abstract in English.</p>
<p class="desc">The code of innocence begins in <em>Songs of Innocence</em>, where it “expresses true feelings,” continues in “Auguries of Innocence,” where it “reveals the true reality,” and may also be found in <em>Jerusalem</em>.</p>

<p class="author">Li, Jing-Jing. “Sao Yan Cong Hai Zi de Shang Di—Bu Lai Ke ‘Sao Yan Cong de Hai Zi’ Shang Xi [On God in ‘The Chimney Sweeper’: An Appreciation of Blake’s ‘The Chimney Sweeper’].” <em>Ke Ji Zi Xun</em> [<em>Science and Technology Information</em>] 35 (2012): 244. In Chinese.</p>
<p class="desc">Analyzes the roles of children and God in “The Chimney Sweeper.”</p>

<p class="author">Li, Jing-Jing. “Shi Shui Rang Hai Zi Men Mi Lu—Tan Bu Lai Ke ‘Mi Shi Hai Zi’ Gu Shi de Yu Yi [Who Leads Children to Get Lost—Talking about the Implied Meaning of Blake’s Story of Lost Children].” <em>Ke Ji Shi Jie</em> [<em>The World of Science and Technology</em>] 31 (2012): 172. In Chinese.</p>
<p class="desc">Presumably about “The Little Boy Lost” from <em>Songs of Innocence</em> and “The Little Girl Lost,” “A Little Boy Lost,” and “A Little Girl Lost” from <em>Songs of Experience</em>, which are said to explore the poet’s personal experience.</p>

<p class="author">Li, Jing-Jing. “Yi Hua Yi Tian Tang—Bu Lai Ke Shi Ge Zhong de Hua Yi Xiang Jie Du [One Flower One Heaven: An Interpretation of the Flower Imagery in Blake’s Poems].” <em>Tong Hua Shi Fan Xue Yuan Xue Bao: Journal of Tonghua Normal University</em> 34.6 (Nov. 2013): 66-69. In Chinese.</p>
<p class="desc">A discussion of the flower imagery in Blake’s poems, such as <em>Poetical Sketches</em>, <em>Songs of Innocence</em>, and <em>Songs of Experience</em>.</p>

<p class="author">Lin, Fang. “Ren Xing Fa Zhan de Liang Zhong Dui Li Zhuang Tai—Dui Bu Lai Ke de ‘Lao Hu’ de Jian Gou Xing Jie Du: On the Two Opposing States in the Development of Human Nature—The Constructive Interpretation of William Blake’s ‘The Lamb’ and ‘The Tyger.’” <em>Hu Nan Gong Ye Zhi Ye Ji Shu Xue Yuan Xue Bao: Journal of Hunan Industry Polytechnic</em> 13.6 (Dec. 2013): 33-34. In Chinese, with an abstract in English.</p>
<p class="desc">“The Lamb symbolizes the purity of the initial state of human nature, while The Tyger represents the secular life in the world of experience.”</p>

<p class="author">Lin, Xiaoxiao. “Wei Lian Bu Lai Ke Zai Xi Fang de Jing Dian Hua Guo Cheng: The Canonization of William Blake in the West.” <em>Guo Wai Wen Xue</em> [<em>Foreign Literatures</em>] 3 (2013): 50-56. In Chinese.</p>
<p class="desc">Describes “four major phases” in the canonization of Blake.</p>

<p class="author">Liu, Jun-Chi. “Jue Xing, Xian Shi Yu Xu Wu—Bu Lai Ke ‘A Xiang Ri Kui’ zhi Xiang Zheng Xing Chan Shi [Awakening, Reality, and Nihilism: The Symbolic Meaning in Blake’s ‘Sunflower’].” <em>Xin Xiang Xue Yuan Xue Bao: Journal of Xinxiang University (Social Science Edition)</em> 28.2 (April 2013): 73-76. In Chinese.</p>

<p class="author">Liu, Yun-Yan, and Hong Wu. “Wei Lian Bu Lai Ke Shi Ge de Fan Shen Zhu Yi Qing Xiang: The Pantheistic Interpretation of Flora and Fauna Images in William Blake’s Poems.” <em>Hu Nan Da Xue Xue Bao: Journal of Hunan University (Social Sciences)</em> 26.1 (Jan. 2012): 111-14. In Chinese, with an abstract in English.</p>
<p class="desc">Blake advocated a subversive return from monotheism to polytheism. “The animal and plant images in his poetry could be interpreted according to his unique pantheistic doctrine.”</p>

<p class="author">Lu, Jiande. “Shi Ren Yu She Hui—Lue Tan Da Jiang Jian San Lang Yu Wei Lian Bu Lai Ke: The Poet and Society—A Comparative Study of Kenzaburō Ōe and William Blake.” <em>Shang Hai Shi Fan Da Xue Xue Bao: Journal of Shanghai Normal University (Philosophy and Social Sciences Edition)</em> 41.2 (March 2012): 106-09. In Chinese, with an abstract in English.</p>
<p class="desc">“Kenzaburō Ōe was attracted by Blake’s prophecy poems,” but “he stayed at a respectful distance from the mysticism of Blake’s prophecy poems.”</p>

<p class="author">§*Lüdeke, Roger. <em>Zur Schreibkunst von William Blake: Ästhetische Souveränität und politische Imagination</em>. 2013. &lt;﻿<em>Blake</em> (2014)﻿&gt;</p>
<p class="reviewheading">Review</p>
Gerold Sedlmayr, <em>Zeitschrift für Anglistik und Amerikanistik</em> 62.1 (April 2014): <a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1515/zaa-2014-0009" target="_blank">79-82</a>. In English.<br>

<a name="Luyssen" id="Luyssen"></a><p class="author">Luyssen, Johanna. “<a href="http://www.lemonde.fr/livres/article/2014/09/16/le-crowdfunding-au-secours-du-cottage-de-william-blake_4487960_3260.html" target="_blank">Le crowdfunding au secours du [Felpham] cottage de William Blake</a>.” <em>Le Monde</em> [Paris] 16 Sept. 2014. In French.</p>

<p class="mainheading"><a name="M">M</a></p>

<a name="Mackintosh" id="Mackintosh"></a><p class="author">*Mackintosh, Paul St. John. “<a href="http://www.teleread.com/poetry/step-now-save-blakes-cottage/" target="_blank">Step Up Now to Save Blake’s [Felpham] Cottage</a>.” <em>TeleRead</em> 25 July 2014.</p>

<p class="author">*Maddocks, Fiona. “<a href="http://www.theguardian.com/culture/2014/nov/21/the-10-best-works-by-william-blake" target="_blank">The Ten Best Works by William Blake</a>: On the eve of a major exhibition [at the Ashmolean] on the printmaker, painter and poet, Fiona Maddocks chooses her 10 favourite [visual] works.” <em>Guardian</em> 21 Nov. 2014.</p>

<p class="author">*Malmberg, Carl-Johan. <em>Stjärnan i foten. Dikt och bild, bok och tanke hos William Blake</em> [<em>The Star in the Foot: Poetry and Image, Book and Thought in William Blake</em>]. [Stockholm]: Wahlström och Widstrand, 2013. 4º, 458 pp., 101 reproductions; ISBN: 9789146220763. In Swedish.</p>
<p class="desc">There are chapters on “Albion Rose,” “The Ancient of Days,” <em>Newton</em>, <em>Songs of Innocence and of Experience</em>, <em>Laocoön</em>, and <em>Jerusalem</em>.</p>
<p class="reviewheading">Review</p>
*Ossian Lindberg (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake483"><em>Blake</em> 48.3</a>, above).

<p class="author">Marguet, Ita. “William Blake: Forerunner of Romanticism.” <em>Diva International</em> Oct. 2009.</p>
<p class="desc">Prompted by a performance in Geneva on 18 September 2009 of a “condensed version” of <em>William Blake’s Divine Humanity</em> by the Theatre of Eternal Values.</p>

<p class="author">Marsh, John. <em>The John Marsh Journals: The Life and Times of a Gentleman Composer (1752 .. 1828)</em>. Ed. Brian Robins. Vol. 1. 1998. &lt;﻿§<em>Blake</em> ﻿(2008)﻿&gt; B. Rev. ed. 2011. The Sociology and Social History of Music no. 9A.<br> Vol. 2. Hillsdale [New York]: Pendragon Press, 2013. The Sociology and Social History of Music no. 10.</p>
<p class="desc">There are references to Blake in vol. 1 (edition of 2011), pp. 721 (October 1800), 734 (May 1801), and 750 (5 April 1802, kitten given to Blake), and vol. 2, p. 37 (1804, Blake’s trial).</p>

<p class="author">*Matthews, Susan. <em>Blake, Sexuality and Bourgeois Politeness</em>. 2011. &lt;﻿§<em>Blake</em> (2012)﻿&gt;</p>
<p class="reviewheading">Review</p>
Sibylle Erle (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake482"><em>Blake</em> 48.2</a>, above).

<p class="author">McSmith, Andy. “<a href="http://www.independent.co.uk/arts-entertainment/books/features/blakes-heaven-a-man-ahead-of-his-time-760500.html" target="_blank">Blake’s Heaven: A Man ahead of His Time</a>.” <em>Independent</em> [London] 26 Nov. 2007.</p>
<p class="desc">On Blake’s 250th anniversary.</p>

<p class="author">Melloni, Javier. “El rincón de la mística: William Blake.” <em>El Ciervo: revista mensual de pensamiento y cultura</em> no. 671 (2007): 13. In Spanish.</p>

<p class="author">§Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt066" target="_blank">Agape and Morality: Blake’s Caterpillar-Man</a>.” <em>Notes and Queries</em>, n.s., 60.2 (June 2013): 210-14.</p>

<p class="author">§Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt067" target="_blank">Blake: A Hope-Fostered Visionary</a>.” <em>Notes and Queries</em>, n.s., 60.2 (June 2013): 214-17.</p>

<p class="author">Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt255" target="_blank">Blake and Burke: The Dread Majesty of the Foetus</a>.” <em>Notes and Queries</em>, n.s., 61.1 (March 2014): 22-27.</p>
<p class="desc">About Burke’s <em>A Philosophical Enquiry into the Origin of Our Ideas of the Sublime and Beautiful</em>.</p>

<p class="author">§Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gju159" target="_blank">Blake: Re-Visioning Book Six of <em>Paradise Lost</em></a>.” <em>Notes and Queries</em>, n.s., 61.4 (Dec. 2014): 486-94.</p>

<p class="author">Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt256" target="_blank">Blake: The Metaphors of Generation</a>.” <em>Notes and Queries</em>, n.s., 61.1 (March 2014): 33-38.</p>

<p class="author">Miner, Paul. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt257" target="_blank">Blake: Thoughts on <em>Night Thoughts</em></a>.” <em>Notes and Queries</em>, n.s., 61.1 (March 2014): 27-33.</p>
<p class="desc">In Blake’s watercolors for Young’s <em>Night Thoughts</em>, “submerged <em>borrowings</em>” “create a new mythology.”</p>

<p class="author">Miyamachi, Seiichi. “Honyaku [Translation] Nicholas Marsh, William Blake: The Poems.” <em>Sapporo Gakuin Daigaku Jimbun Gakkai Kiyo</em> (<em>Journal of the Society of Humanities, Sapporo Gakuin University</em>) 94 (2013): 155-202. In Japanese.</p>
<p class="desc">A translation of chapter 3 of Marsh’s elementary book for students about Blake &lt;﻿<em>Blake</em> (2003)﻿&gt;. His translation of chapter 2 appeared in the same journal in 2012; see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/checklist481/checklist481html#Miyamachi" target="_blank"><em>Blake</em> (2014)</a>﻿&gt;.</p>

<p class="mainheading"><a name="N">N</a></p>

<p class="author">Newbury, Richard. “<a href="http://www.lastampa.it/2014/06/16/tecnologia/british-library-puts-william-blake-and-oscar-wilde-treasures-online-567e1J9HHNGhokaORJOTMM/pagina.html" target="_blank">British Library Puts William Blake and Oscar Wilde Treasures Online</a>.” <em>La Stampa</em> 16 June 2014.</p>
<p class="desc">The online version does not mention Blake in the body of the text.</p>

<p class="mainheading"><a name="P">P</a></p>

<p class="author">Paley, Morton D. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gju160" target="_blank">James Barry as Rintrah in William Blake’s <em>Milton</em></a>.” <em>Notes and Queries</em>, n.s., 61.4 (Dec. 2014): 494-97.</p>
<p class="desc">The “Great Solemn Assembly” at which “Judgment … fell on Rintrah and his rage” (<em>Milton</em> 6.46, 7.10) may represent the meeting of the Royal Academy (1799) at which Barry was expelled from the academy.</p>

<p class="author">§Park, David. <em>The Poets’ Wives</em>. London: Bloomsbury Publishing, 2014.</p>
<p class="desc">Novellas about three women; the one about Catherine Blake is factually challenged.</p>
<p class="reviewheading">Reviews</p>
*Alexandra Harris, <a href="http://www.theguardian.com/books/2014/mar/08/poets-wives-review-david-park" target="_blank"><em>Guardian</em></a> [London] 8 March 2014 (the lives “leave the reader feeling somewhat puzzled”).<br>
Hephzibah Anderson, <a href="http://www.dailymail.co.uk/home/books/article-2585244/David-Park-THE-POETS-WIVES.html" target="_blank"><em>MailOnline</em></a> [London] 20 March 2014 (written in “classy prose”).<br>
Holly Williams, <a href="http://www.independent.co.uk/arts-entertainment/books/reviews/book-review-the-poets-wives-by-david-park-9208069.html" target="_blank"><em>Independent</em></a> [London] 23 March 2014 (“Catherine is an impossibly wet blanket”).<br>

<p class="author">*Piccitto, Diane. <em>Blake’s Drama: Theatre, Performance, and Identity in the Illuminated Books</em>. Basingstoke: Palgrave Macmillan, 2014. Narrow 4º, viii, 254 pp.; ISBN: 9781137378002.</p>
<p class="desc">She is concerned with “the theatricalization of inspiration” (206), especially with <em>The First Book of Urizen</em>, but not much with theatres or performances.</p>

<p class="author">§Picón Bruno, Daniela. “<a href="http://www.tdx.cat/handle/10803/285267" target="_blank">Recepción de William Blake : desde su público contemporáneo hasta el Surrealismo</a>.” Universitat Pompeu Fabra [Barcelona] PhD, 2014. In Spanish.</p>

<p class="author">§*Picón, Daniela. “<a href="http://www.revistaliteratura.uchile.cl.libproxy.lib.unc.edu/index.php/RCL/article/viewFile/31499/33256" target="_blank">Beulah: intermundo, surrealidad. El territorio del subconsciente y los sueños en el mundo visionario de William Blake</a>.” <em>Revista Chilena de Literatura</em> no. 86 (2014): 177-97. In Spanish.</p>

<p class="author">*Popova, Maria. “<a href="http://www.brainpickings.org/2014/02/13/william-blake-paradise-lost/" target="_blank">William Blake’s Mesmerizing Illustrations for John Milton’s <em>Paradise Lost</em></a>: Aesthetic rapture between heaven and hell.” <em>Brain Pickings</em> (2014).</p>

<p class="author">*Pyle, Eric. <em>William Blake’s Illustrations for Dante’s <em>Divine Comedy</em>: A Study of the Engravings, Pencil Sketches and Watercolors</em>. Jefferson [North Carolina]: McFarland &amp; Company, 2015. 25.2 x 17 cm., vi, 283 pp., 93 illustrations (including all Blake’s Dante engravings); ISBN: 9780786494880.</p>
<p class="desc">Apparently derived silently from his Hiroshima PhD (2012) &lt;﻿§<em>Blake</em> (2014)﻿&gt;. “Unlike Dante, he [Blake] believes that he can show us everything; he can make the text incarnate, in the visual medium, in a way that Dante could not” (268).</p>

<p class="mainheading"><a name="R">R</a></p>

<p class="author">§Richards, Ernie. <em>Blake’s Jerusalem: The Story of the Women’s Institute Song</em>. N.p.: CreateSpace Independent Publishing Platform, 2014. 24 pp.; ISBN: 9781501019227.</p>

<p class="author">Rix, Robert. <em>William Blake and the Cultures of Radical Christianity</em>. 2007. &lt;﻿<em>Blake</em> (2008)﻿&gt;</p>
<p class="reviewheading">Review</p>
§David Dunér, <a href="http://septentrio.uit.no.libproxy.lib.unc.edu/index.php/1700/article/view/2865/2733" target="_blank"><em>Sjuttonhundratal</em></a> (2008): 127-28. In Swedish.<br>

<p class="gapcenter">Rosenwald, Lessing J. (1891–1979)</p>
<p class="reviewheading">Major Blake collector</p>
<p class="desc">The Manuscript Division of the Library of Congress holds about 28,000 items of the <a href="http://lccn.loc.gov.libproxy.lib.unc.edu/mm81059469" target="_blank">papers of Rosenwald</a>, mostly of 1932–79. These include about 500 pp. of correspondence concerning the Rosenbach Foundation (1946–79), of which Rosenwald was president. Very few of the letters are between Rosenwald and Rosenbach, from whom Rosenwald bought most of his Blakes.</p>

<p class="mainheading"><a name="S">S</a></p>

<p class="author">*Samaranayake, Sajeeva. <a href="http://groundviews.org/2014/09/25/william-blake-buddhism-and-human-rights-value-of-praxis-over-ideology/" target="_blank">“William Blake, Buddhism and Human Rights—Value of Praxis over Ideology</a>.” <em>Groundviews: Journalism for Citizens</em> 25 Sept. 2014.</p>
<p class="desc">The author is from Sri Lanka.</p>

<p class="author">§Santos, Andrio J. R. dos, and Enéias Farias Tavares. “<a href="http://www.uel.br.libproxy.lib.unc.edu/pos/letras/EL/vagao/EL12-Art7.pdf" target="_blank">‘Energia é Eterno Deleite’: A Figura Satânica em <em>Matrimônio de Céu e Inferno</em>, de William Blake</a>.” <em> Estação Literária</em> 12 (2014): 123-42. In Portuguese.</p>

<p class="author">Sato, Hikari. “Laurence Binyon to Yanagi Muneyoshi: Blake Kenkyusha niyoru Hikaku Bunka Kenkyu (Laurence Binyon and Yanagi Muneyoshi: Comparative Cultural Studies by Blake Scholars).” <em>Choiki Bunka Kagaku Kiyo</em> (<em>Interdisciplinary Cultural Studies</em>) 19 (2014): 5-26. In Japanese.</p>
<p class="desc">A discussion of the reception of Blake by Yanagi and Binyon.</p>

<p class="author">Schuchard, Marsha Keith. *<em>William Blake’s Sexual Path to Spiritual Vision</em>. 2008. &lt;﻿<em>Blake</em> (2009)﻿&gt;</p>
<p class="reviewheading">Review</p>
*Andrei Burke, “<a href="http://ultraculture.org/blog/2014/09/26/william-blake-sexual-rebellion-secret-world/" target="_blank">The Secret World, and Sexual Rebellion, of William Blake</a>,” <em>Ultraculture Journal: Essays on Magick, Tantra and the Deconditioning of Consciousness</em> 26 Sept. 2014 (a credulous summary).<br>

<p class="author">Shi, Chun-Xia. “Bu Lai Ke ‘Lao Hu’ Zhi Xin Pi Ping Jie Du [The Critical Interpretation of Blake’s ‘The Tyger’].” <em>Xian Dai Yu Wen</em> [<em>Modern Chinese</em>] 5 (2012): 50-51. In Chinese.</p>
<p class="desc">An interpretation from the perspective of Anglo-American New Criticism.</p>

<p class="author">Simmons, Robert E. <em>A New Interpretation of Four of William Blake’s Minor Prophecies: His Use of the “Four Zoas” as an Organizing Principle</em>. With a foreword by G. E. Bentley [Jr.]. Lewiston: Edwin Mellen Press, 2014. 8º, [10], vii, 276 pp.; ISBN: 9780773442696.</p>
G. E. Bentley [Jr.]. “Foreword.” iii-iv.<br>
<p class="desc">The book focuses especially on <em>The Book of Thel</em> (“Fall, A Christian Reading”) (chapter 5, 127-60), <em>The Book of Urizen</em> (“Creation”) (chapter 6, 161-96), “The Mental Traveller” (“Redemption”) (chapter 7, 197-225), and <em>Illustrations of the Book of Job</em> (“Judgment”) (chapter 8, 227-59).</p>

<p class="author">*Sklar, Susanne M. <em>Blake’s</em> Jerusalem <em>as Visionary Theatre: Entering the Divine Body</em>. 2011. &lt;﻿<em>Blake</em> (2012)﻿&gt;</p>
<p class="reviewheading">Review</p>
§Luisa Calè, <em>European Romantic Review</em> 24.4 (June 2013): <a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1080/10509585.2013.807632" target="_blank">469-76</a> (with another).<br>

<p class="author">*Stein, Sarah B. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1080/10509585.2013.845770" target="_blank">The <em>Laocoön</em> and the <em>Book of Job</em> as Micrography: The Influence of Miniature Hebrew Illumination on the Work of William Blake</a>.” <em>European Romantic Review</em> 24.6 (Oct. 2013): 623-44.</p>
<p class="desc">Stein uses Avrin’s definition of “micrography as ‘minute script … written into either geometric or abstract forms or woven into the shapes of objects” (624). However, we may note that Blake does not make designs composed entirely of letters, either Hebrew or Roman. In practice, what she seems to be talking about is marginalia on designs; “Blake embraced the use of a marginal, miniature script at the end of his career” (632). This is scarcely micrography.</p>

<p class="author">Stock, R. D. “Religious Love and Fear in Late Eighteenth Century Poetry: Smart, Wesley, Cowper, Blake.” <em>The Holy and the Daemonic from Sir Thomas Browne to William Blake</em>. 1982. &lt;﻿<em>BBS</em> p. 647﻿&gt; B. §Princeton: Princeton Legacy Library, 2014.</p>

<p class="author">Sun, Li. “Zhou Zuo Ren Ling Rou Yi Zhi Si Xiang Yu Ying Guo Shi Ren Bu Lai Ke Zhi Jian de Guan Lian: Union of Spirit and Flesh: Relation between Blake and Chou Tso-Jen.” <em>Chu Xiong Shi Fan Xue Yuan Xue Bao: Journal of Chuxiong Normal University</em> 28.10 (Oct. 2013): 61-67. In Chinese.</p>
<p class="desc">An analysis of Blake and Chou Tso-Jen, who “played an important role in Modern Chinese Literature …. Chou accepted Blake’s thoughts selectively by eliminating mysterious meaning and adding enlightenment of it.”</p>

<p class="author">Suzuki, Masashi. “Kenbikyo teki Sozoryoku no Keifu (3): Kenbikyogaku teki Hakubutsugaku to Baikaisei [The Genealogy of Microscopic Imagination (3): Microscopic Natural History as Intermediator].” <em>Eibun Gakkaishi</em> [<em>Journal of the English Literary Society</em>] 42 (2014): 21-43. In Japanese.</p>
<p class="desc">It includes an argument about “Auguries of Innocence.”</p>

<p class="author">Symons, Arthur. <em>William Blake</em>. 1907 …. &lt;﻿<em>BB</em> #2804, <em>Blake</em> (2011)﻿&gt; G. §[Whitefish (Montana)]: Literary Licensing LLC, 2014. 450 pp.; ISBN: 9781498085762.</p>

<p class="mainheading"><a name="T">T</a></p>

<p class="author">Tang, Mei-Xiu, and Rong Zhou. “Bu Lai Ke Yu Qu Yuan de Lang Man Zhu Yi Jing Shen Tan Xun: A Comparative Study  of the Romantic Spirit in William Blake and Qu Yuan.” <em>Xi Nan Ke Ji Da Xue Xue Bao</em>: <em>Journal of Southwest University of Science and Technology (Philosophy and Social Sciences Edition)</em> 30.4 (Aug. 2013): 50-53. In Chinese.</p>
<p class="desc">The content of this essay is very similar to the next article.</p>

<p class="author">Tang, Mei-Xiu, and Rong Zhou. “Huo Yi Jue Shen Chen Huo Qi Miao Xiao Yao—Bu Lai Ke Yu Qu Yuan Lang Man Zhu Yi Jing Shen de Yi Tong Bi Jiao: Gorgeous Profound or Miraculous Unfettered—A Comparative Study of the Romantic Spirit between William Blake and Qu Yuan.” <em>Xi Hua Da Xue Xue Bao</em>: <em>Journal of Xihua University (Philosophy and Social Sciences)</em> 32.5 (Sept. 2013): 18-22. In Chinese, with an abstract in English.</p>
<span class="extract">Qu Yuan and William Blake use similar poetic styles. Despite different influences of the times, aesthetics, and cultural backgrounds, and despite their respective life experiences, individual temperament, and mode of thinking, the two poets display strikingly heterogeneous features of romanticism in their works. This essay offers a comparative study of four aspects in their poems: purposes of writing, aesthetic principles, archetypal images, and innovative poetic forms.</span>

<p class="author">Tatham, Frederick. Manuscript “Life of Blake” (<em>BR</em>[2] 661-91), once bound with <em>Jerusalem</em> (E), now with it in the Yale Center for British Art.</p>
<p class="desc">A manuscript copy belongs to Gill Tatham, widow of George Tatham (1929–86) of <span class="notecall">Ladysmith, South Africa.</span><span class="fn">Information from <em>Tathamfamilyhistory</em>, &lt;﻿http://​www.​saxonlodge.​net​/index.​php﻿&gt;.</span></p>

<p class="author">§Tavares, Enéias Farias, and Leandro Cardoso de Oliveira. “‘The Little Girl Lost’ e ‘The Little Girl Found,’ de William Blake: Canções de Inocência ou de Experiência?” <em>Crítica Cultural</em> 9.1 (Jan.-June 2014): 105-17. In Portuguese.</p>

<p class="author">*Tayler, Irene. <em>Blake’s Illustrations to the Poems of Gray</em>. 1971. &lt;﻿<em>BB</em> #2824﻿&gt; B. Published to accompany the Folio Society facsimile (2013). &lt;﻿<em>Blake</em> (2014)﻿&gt;</p>
<p class="reviewheading">Review</p>
*G. E. Bentley, Jr. (see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Blake483"><em>Blake</em> 48.3</a>, above).<p></p>

<p class="author">*Thompson, Michael. “William Blake and the Illustrations for Blair’s <em>Grave</em>. Part II.” <em>The Fellowship of American Bibliophilic Societies</em> 18.1 (winter 2014): 9-21.</p>
<p class="desc">“There’s little evidence to suggest that his work on The Grave had any motivation that was not commercial,” and, because of the dispersal of the drawings for Blair’s <em>Grave</em>, “important Blake material in the long run may well be more readily available, and available in more places” than if the drawings had been sold en bloc (19).
</p><p class="desc">Part 1 was in the fall 2013 issue; see &lt;﻿<em>Blake</em> (2014)﻿&gt;.</p>

<p class="author">§Todd, Ruthven. Calligraphic list of books in his library, many about William Blake (c. 1941). British Library Department of Manuscripts: <a href="http://searcharchives.bl.uk.libproxy.lib.unc.edu/primo_library/libweb/action/dlDisplay.do?docId=IAMS032-001986235&amp;vid=IAMS_VU2&amp;indx=1&amp;dym=false&amp;dscnt=1&amp;onCampus=false&amp;group=ALL&amp;institution=BL&amp;ct=search&amp;vl(freeText0)=032-001986235&amp;vid=IAMS_VU2" target="_blank">Egerton MS 3865</a>.</p>

<p class="author">§Todd, Ruthven. Correspondence (1970-73) with David Bindman, especially about William Blake and Alexander Gilchrist. Most of Todd’s letters are from Spain. British Library Department of Manuscripts: <a href="http://searcharchives.bl.uk.libproxy.lib.unc.edu/primo_library/libweb/action/dlDisplay.do?docId=IAMS032-001969113&amp;vid=IAMS_VU2&amp;indx=1&amp;dym=false&amp;dscnt=1&amp;onCampus=false&amp;group=ALL&amp;institution=BL&amp;ct=search&amp;vl(freeText0)=032-001969113&amp;vid=IAMS_VU2" target="_blank">Add MS 74783</a>, presented by Bindman 10 Aug. 1998.</p>

<p class="author">§*Trodd, Colin. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1080/14714787.2014.945201" target="_blank">Ford Madox Brown and the William Blake Brotherhood</a>.” <em>Visual Culture in Britain</em> 15.3 (2014): 277-98.</p>

<p class="mainheading"><a name="U">U</a></p>

<p class="gapcenter">Upcott, William</p>
<p class="desc">A “catalogue of the art collection of Ozias Humphry (d. 1810), the portrait painter, compiled by his natural son, William Upcott (d. 1845), the antiquary, to whom he bequeathed it” was presented to the Department of Manuscripts of the British Museum (now British Library) in 1958 (<a href="http://searcharchives.bl.uk.libproxy.lib.unc.edu/primo_library/libweb/action/dlDisplay.do?docId=IAMS032-002016525&amp;vid=IAMS_VU2&amp;indx=1&amp;dym=false&amp;dscnt=1&amp;onCampus=false&amp;group=ALL&amp;institution=BL&amp;ct=search&amp;vl(freeText0)=032-002016525&amp;vid=IAMS_VU2" target="_blank">Add MS 49682</a>). It includes f. 26, “pen-and-ink drawing of man’s head, in style of W. Blake: late 18th cent.”</p>
<p class="desc">The connection with Humphry, who owned several Blake works, is plausible; the drawing, however, is not by Blake in the opinions of Robert N. Essick, David Bindman (e-mails of June 2014), and GEB.</p>

<p class="mainheading"><a name="W">W</a></p>

<p class="author">Wang, Hong. “Fen Xi Bu Lai Ke de Gao Yang Ji Qi Pei Shi Lao Hu [An Analysis of Blake’s ‘Lamb’ and ‘Tyger’ Poems].” <em>Ke Wai Yu Wen</em> [<em>Extracurricular Chinese Studies</em>] 16 (2013): 138. In Chinese.</p>

<p class="author">Wang, Ying-Ying. “Tan Suo Wei Lian Bu Lai Ke de ‘Lun Dun’ [A Reading of William Blake’s ‘London’].” <em>Chang Chun Li Gong Da Xue Xue Bao</em>: <em>Journal of Changchun University of Science and Technology</em> 8.1 (Jan. 2013): 86-87. In Chinese.</p>
<p class="desc">On images and sounds in “London.”</p>

<p class="author">*Warner, Janet. <em>Other Sorrows, Other Joys: The Marriage of Catherine Sophia Boucher and William Blake</em>. 2003. &lt;﻿<em>Blake</em> (2004)﻿&gt; B. 2014 (e-book).</p>

<p class="author">*Watson, Ben. <em>Blake in Cambridge: or “The Opposite of David Willetts”: How Blake’s Vortex Anticipates So Much We Might Call His Books “Prophetic”</em>. 2012. &lt;﻿§<em>Blake</em> (2014)﻿&gt;</p>
“Preface.” v-x.<br>
“E. P. Thompson’s Blake.” 1-23.<br>
“Blake’s Vortex.” 25-29.<br>
“Blake as a Head of His Time.” 31-34.<br>
“Art verses [<em>sic</em>] Hirelings.” 37-39.<br>
“Thirteen-Minute Introduction.” 41-83.<br>
“A Mixed Cheer for <em>Kazoo Dreamboats</em>.” 85-132. (“Blake in Cambridge? It’s an oxymoron, comrades and fellow AMMers [Association of Musical Marxists]” [132].)<br>
<p class="desc">David Willetts was Minister of State for Universities and Science.</p>

<p class="author">§*Welling, Lloyd C. <em>Eternity’s Sunrise: William Blake’s Vision of Christ</em>. Pittsburgh: River of Life Press, 2014. 356 pp.; 43 reproductions, including 21 of the <em>Job</em> engravings. ISBN: 9780615924731.</p>
<p class="reviewheading">Review</p>
Virginia Ramey Mollenkott, <a href="http://www.eewc.com/BookReviews/eternitys-sunrise-william-blakes-vision-of-christ/" target="_blank"><em>Christian Feminism Today</em></a> (2014) (“full of brilliant insight”).<br>

<p class="gapcenter">White, William Augustus (1843–1927)</p>
<p class="reviewheading">who collected more Blakes than anyone else ever has</p>
<p class="desc">White’s extraordinarily detailed acquisition notes are in the Houghton Library, Harvard University (<a href="http://lms01.harvard.edu.libproxy.lib.unc.edu/F/9YPI73GSBTSJTMV266U3K4CDBEPTYAC2RL3GNAF46SGAVH265Q-13037?func=full-set-set&amp;set_number=140358&amp;set_entry=000008&amp;format=999" target="_blank">MS Am 2087</a>), <span class="notecall">in six volumes.</span><span class="fn">White’s acquisition books are not recorded in the <em>Catalogue of Manuscripts in the Houghton Library, Harvard University</em>, 8 vols. (Alexandria: Chadwyck-Healey, 1986–87). See GEB, “White on Blake,” <em>Harvard Library Bulletin</em>, in the press.</span> Each volume has been digitized and is available online.</p>

<p class="author">Whitson, Roger, and Jason Whittaker. <em>William Blake and the Digital Humanities: Collaboration, Participation, and Social Media</em>. 2013. &lt;﻿§<em>Blake</em> (2014)﻿&gt;</p>
<p class="reviewheading">Review</p>
§Laura Mandell, <em>Studies in Romanticism</em> 53.1 (spring 2014): 133-44 (“an excellent job”).<br>

<p class="author">Wu, Hai-Xia. “Bu Lai Ke Shi Ge Zhong de Sheng Tai Si Xiang [Ecological Thought in William Blake’s Poems].” <em>Chang Zhou Gong Xue Yuan Xue Bao: Journal of Changzhou Institute of Technology (Social Sciences Edition)</em> 30.2 (April 2012): 33-35. In Chinese.</p>

<p class="mainheading"><a name="X">X</a></p>

<p class="author">Xiao, Dan. “Xin Ling de Qing Yin Yue Yu Zhong Yin Yue—Wei Lian Bu Lai Ke Shi Ge ‘Ying Er De Huan Le’ Yu ‘Ying Er De You Shang’ Zhi Sheng Xiao Dui Bi: Light and Heavy Music upon Souls: A Contrastive Analysis of Sound Effects in ‘Infant Joy’ and ‘Infant Sorrow.’” <em>Hu Bei Di Er Shi Fan Xue Yuan Xue Bao: Journal of Hubei University of Education</em> 29.10 (Oct. 2012): 27-29. In Chinese, with an abstract in English.</p>
<p class="desc">“A contrastive analysis of how different sound effects brought about by different rhyme schemes, phonemes distribution, word’s syllable length … affect the feeling the poet intended to express and the themes these two poems were designed to emphasize.”</p>

<p class="author">Xie, Qi-Yuan. “Sheng Tai Pi Ping Shi Jiao Xia de ‘Sai Er Shu’: <em>The Book of Thel</em> from the Perspective of Ecocriticism.” <em>Hai Wai Ying Yu: Overseas English</em> 9 (2013): 211-13. In Chinese, with an abstract in English.</p>
<p class="desc">“Blake … was for the value of nature while against Anthropocentrism. In spite of some limitations, his attitude towards nature is still worth admiring.”</p>

<p class="author">Xu, Jie. “Er Sho Shi Ji Dui Bu Lai Ke Shi Ge ‘Hei Pi Fu de Xiao Nan Hai’ De Yan Jiu [A Study of Blake’s Poem ‘The Little Black Boy’].” <em>Jin Tian</em> [<em>Jin Tian</em>] 12 (2012): 50-52. In Chinese.</p>

<p class="author">Xu, Jie, and Zhao Xu Han. “Qian Xi Wei Lian Bu Lai Ke Shi Zhong de Dui Bi Shou Fa Ji Yi Shu Te Se [An Analysis of Artistic Methods in William Blake’s Poems].” <em>Duan Pian Xiao Shuo</em> [<em>Short Story</em>] 2 (2012): 77-78. In Chinese.&nbsp;</p>

<p class="author">Xue, Dong-Yan. “Bu Lai Ke Shi Ge Zhong Yan Se Yi Xiang Yu Yi Tan Xi [An Interpretation of the Allegorical Images of Color in Blake’s Poems].” <em>Duan Pian Xiao Shuo</em> [<em>Short Fiction</em>] 15 (2013): 31-32. In Chinese.</p>

<p class="mainheading"><a name="Y">Y</a></p>

<p class="author">Yang, Zhang-Hui. “Hei An Zhi Lin Zhong de Dou Shi—Bu Lai Ke de Ji Qi Shi Ge Zhu Ti Yan Jiu [The Fighter of Darkness—A Study of Blake’s Themes].” <em>An Hui Wen Xue</em> [<em>An Hui Literature</em>] 6 (2012): 20-26. In Chinese.</p>

<p class="author">Yano, Atsushi. “Uchi ni Arishi Tenkai tono Kizuna, soshite Reality no Eiensei (The Inner Connection with the Eternal Realities in Dante Gabriel Rossetti’s Sonnets).” <em>Nishinippon Kogyo Daigaku Kiyo</em> [<em>Bulletin of Nishinippon Institute of Technology</em>] 44 (2014): 171-78. In Japanese.</p>
<p class="desc">Blake and eternity are discussed in the latter half of the paper.</p>

<p class="author">§Yates, Mark. “<a href="http://usir.salford.ac.uk/id/eprint/31967" target="_blank">Illuminated Instruction: A Paratextual, Intertextual, and Iconotextual Study of William Blake</a>.” University of Salford [Manchester] PhD, 2014.</p>

<p class="author">*Yeats, William Butler. “William Blake and His Illustrations to the Divine Comedy.” <em>Savoy</em> nos. 3-5 (1896), subtitled “His Opinions upon Art” (no. 3, pp. 41-57), “His Opinions on Dante” (no. 4, pp. 25-41), and “The Illustrations of Dante” (no. 5, pp. 31-36). &lt;﻿<em>BB</em> #3051, <em>BBS</em> p. 692, Blake (2004, 2010)﻿&gt; T. <em>William Blake and His Illustrations to the Divine Comedy, Part 2</em>. Charleston: BiblioLife, 2014. 228 pp. [<em>sic</em>]; ISBN: 9781294745976. [Part 1 is not listed. I cannot account for 228 pp. or “Part 2.”]</p>

<p class="author">Yu, Fang, and Juan Yu. “Ke Shi Yu Yan: Wei Lian Bu Lai Ke de Kua Mei Jie Xu Shi Yi Shu: Visual Language: Art of Cross-Media Narrative in William Blake’s Poetry.” <em>Ji Ning Xue Yuan Xue Bao: Journal of Jining University</em> 34.5 (2013): 22-26. In Chinese, with an abstract in English.</p>
<p class="desc">With his illuminated printing, “Blake uses word and image in his <em>Songs of Innocence and</em> [<em>of</em>] <em>Experience</em> and <em>Marriage of Heaven and Hell</em> to construct the cross-media narrative, reflecting human psychology and imagery consciousness. His sensual letters and italic writing visualize the picturesque principles and indicate the combination of the two forms of art.”</p>

<p class="author">Yuan, Li-Li. “Xiao Yi Bu Lai Ke de ‘Lun Don’ [Discussing Blake’s ‘London’].” <em>Jian Nan Wen Xue</em> [<em>Jian Nan Literature</em>] 10 (2012): 66. In Chinese.</p>
<p class="desc">Discusses “London” in terms of its rhyme and other techniques.</p>

<p class="author">*Yue, Hui. “Qian Tan Wei Lian Bu Lai Ke ‘Lun Dun’ de Kong Jian Jie Gou [On the Spatial Structure of ‘London’ by William Blake].” <em>Ke Jiao Wen Hui</em> [<em>Essays on Science and Education</em>] 11 (2013): 53-55. In Chinese.</p>
<p class="desc">The structure of “London” is based on the two concepts of space—“the thematic space” and “the static space,” where the location changes are matched by the thematic changes. As a result, this poem could be taken as a union of poetry and painting.</p>

<p class="mainheading"><a name="Z">Z</a></p>

<p class="author">Zhang, Jin, and Jing Wang. “Bu Lai Ke Zao Qi Shi Ge Zhong Nv Xing Xing Yi Shi de Dui Li Xing [The Contradiction in Gender Consciousness in William Blake’s Early Poems].” <em>Wai Guo Yu Wen</em>: <em>Foreign Language and Literature</em> 29.1 (Feb. 2013): 51-55. In Chinese, with an abstract in English.</p>
<span class="extract">In William Blake’s poetry, female sexuality is presented as in a state of struggle between two contrary forces: liberation and submission. Women strive to liberate themselves from sexual repression; however, the liberating force comes up against the resistance of the submissive in this process. Women are forced to submit to male sexual aggression, and they are even subtly influenced by the doctrines of sexual oppression and introject submission. Submission results in the loss of female subjectivity, even self destruction of women. Meanwhile, the feminine wish for dominance is latent in both liberation and submission when they run to an extreme. Negation of the contrary forces is destructive because it is through the struggle between liberation and submission that female sexuality remains in a state of dynamic harmony.</span>

<p class="author">Zhang, Xiao-Ning. “Wei Lian Bu Lai Ke Shi Ge de She Hui Pi Pan Xing Tan Xi [A Comment on the Social Criticism in William Blake’s Poetry].” <em>Shan Hua</em> [<em>Mountain Flowers</em>] 10 (2013): 135-36. In Chinese.</p>

<p class="author">*Zhao, Hui. “Wei Lian Bu Lai Ke Chuang Zuo Wan Qi de ‘Shi Hua Xi Ju’ [William Blake’s Poetic Drama in His Late Work].” <em>Mei Shu</em> [<em>Art</em>] 1 (2013): 124-28. In Chinese.</p>
<p class="desc">An analysis of the dramatic quality in Blake’s late poems.</p>

<p class="author">*Zheng, Ya-Hong. “Li Tian Zhen You Duo Yuan, Li Jing Yan You Duo Jin?—Du Wei Lian Bu Lai Ke Shi Ji <em>Tian Zhen Yu Jing Yan Zhi Ge</em> [How Far Is It from Innocence and How Close Is It to Experience?—A Reading of William Blake’s <em>Songs of Innocence and of Experience</em>].” <em>Shu Cheng</em> [<em>Book City</em>] 4 (2013): 88-90. In Chinese.</p>

<p class="author">§Ziolkowski, Eric. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1515/jbr-2014-0002" target="_blank">Great Code or Great Codex? Northrop Frye, William Blake, and Construals of the Bible</a>.” <em>Journal of the Bible and Its Reception</em> 1.1 (June 2014): 3-28.</p>

<p class="author">§Zukovic, Brad. “<a href="http://hdl.handle.net.libproxy.lib.unc.edu/1813/37025" target="_blank">Reflexive Figurality in the Poetry of Blake, Wordsworth, Ashbery and A. R. Ammons</a>.” Cornell PhD, 2014.</p>

<p class="mainheading"><a name="DivisionII" id="DivisionII"></a>Division II: Blake’s Circle</p>

<p class="author" style="text-indent: 15px">Note that Robert N. Essick’s “Blake in the Marketplace” regularly lists sales of pictures, etc., by Barry, Basire, Calvert, Flaxman, Fuseli, Linnell, Mortimer, Palmer, Richmond, Romney, and Stothard.</p>

<a name="Barry" id="Barry"></a><p class="gapcenter"><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">Barry</span>, James (1741–1806)</p>
<p class="reviewheading">History painter</p>
<p class="author">§Lenihan, Liam. <em>The Writings of James Barry and the Genre of History Painting, 1775-1809</em>. Farnham: Ashgate, 2014. 202 pp.; ISBN: 9781409467526.</p>

<a name="Butts" id="Butts"></a><p class="gapcenter"><span style="font-variant: small-caps; font-size: 18px; line-height: 25px;">Butts</span>, Thomas (1759–1845)</p>
<p class="reviewheading">Clerk and patron</p>
<p class="author" style="text-indent: 15px">A good deal of new information about Butts and his first wife, née Elizabeth Mary Cooper, has been revealed by Mary Lynn Johnson, “<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/johnson474/johnson474html" target="_blank">Newfound Particulars of Blake’s Patrons, Thomas and Elizabeth Butts, 1767-1806</a>,”<em> Blake</em> 47.4 (spring 2014).</p> 

<a name="Cumberland" id="Cumberland"></a><p class="gapcenter"><span style="font-variant: small-caps;">Cumberland</span>, George (1754–1848)</p>
<p class="reviewheading">Polymath, artist, friend of Blake</p>

<p class="author">Bentley, G. E., Jr. “<a href="http://dx.doi.org.libproxy.lib.unc.edu/10.1093/notesj/gjt221" target="_blank">George Cumberland Sketchbook Discovered</a>.” <em>Notes and Queries</em>, n.s., 61.1 (March 2014): 39-43.</p>
<p class="desc">The sketchbook was recently acquired by Victoria University in the University of Toronto (see &lt;﻿<a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/viewArticle/bentley471/bentley471html#Cumberland" target="_blank"><em>Blake</em> [2013]</a>﻿&gt;).</p>

<p class="author">Yerburgh, David S. <em>An Attempt to Depict Hafod in Cardiganshire the Seat of Thomas Johnes, Esq. M.P. from 1783-1813. A Pictorial Journey around the Estate of Hafod Illustrated with a Variety of Artistic Skills.</em> N.p.: n.p., [preface dated 2000]. 8º, iv, 80 pp.; ISBN: 9780953563517.</p>
<p class="desc">The book is “based upon George Cumberland’s book entitled ‘An Attempt to Describe Hafod’” and is designed as a “complement” to it (5). The images are enchanting, including Johnes’s pictorial chinaware.</p>

<p class="gapcenter"><a name="Flaxman" id="Flaxman"></a><span style="font-variant: small-caps;">Flaxman</span>, John (1755–1826)</p>
<p class="reviewheading">Sculptor, friend of Blake</p>

<p class="author" style="text-indent: 15px">Eight letters, 1783-1805, 21 pp., to William Hayley, with “numerous references to Blake, Romney, the engraving of Cowper’s portrait, &amp;c.,” were sold at Sotheby’s, 3-4 June 1907, lot 387 <span class="notecall">[£5.5.0 to Pearson].</span><span class="fn">These might be the letters of Flaxman to Hayley in the Morgan Library.</span></p>

<p class="author" style="text-indent: 15px">In 2014 Victoria University in the University of Toronto acquired an undated card of Flaxman’s lecture at the Royal Academy.</p>
<table class="Flaxman" cellpadding="3" align="center" style="margin-top: 10px; margin-bottom: 10px; background-color: #f0f0f0; padding: 10px">
<tbody><tr><td width="100px"><em>Monday</em></td><td width="100px"><em>Day of</em></td><td width="145px"><em>18</em></td></tr>
<tr><td colspan="3"><em>Admit to the Lecture this Evening</em></td><td></td></tr><tr>
</tr><tr><td rowspan="3">[Red seal of<br> “ROYAL<br> ACADEMY<br> LONDON”]</td><td colspan="2">[Rev.<sup>d</sup> M.<sup>r</sup> Agutter]</td></tr>
<tr><td colspan="2" style="padding-top: 10px">[John Flaxman] <em>R.A.</em></td></tr>
<tr><td colspan="2"><em>The Lecture will begin at 8 o’Clock</em></td></tr>
</tbody></table>
<p class="desc">William Agutter (1758-1835) was chaplain and secretary of the Asylum for Female Orphans (London, 1797) and fellow of Magdalen College (Oxford).</p>

<p class="author"><a href="https://books-google-com.libproxy.lib.unc.edu/books?id=M4h8mPlf3e0C&amp;pg=PR3#v=onepage&amp;q&amp;f=false" target="_blank">POPULAR | ENGLISH SPECIMENS | OF THE | GREEK DRAMATIC POETS;</a> | WITH | INTRODUCTORY ESSAYS, | AND | EXPLANATORY NOTES. [Trans. Robert Potter (1721-1804)] | — | ÆSCHYLUS. | — | LONDON: | JOHN MURRAY, ALBEMARLE STREET. | MDCCCXXXI. [1831]. 291 pp., 6″ tall.</p>
<table id="collections" cellpadding="2">
<tbody><tr>
<th style="padding-left: 20px">Prints [by Flaxman] facing pp.</th>
<th>Play</th>
</tr>
<tr>
<td style="padding-left: 100px">78, 103</td>
<td><em>Agamemnon</em></td>
</tr>
<tr>
<td style="padding-left: 100px">142, 144</td>
<td><em>The Choephoræ</em></td>
</tr>
<tr>
<td style="padding-left: 100px">147, 154, 173</td>
<td><em>Eumenides</em></td>
</tr>
<tr>
<td style="padding-left: 100px">178, 202</td>
<td><em>The Seven Chiefs against Thebes</em></td>
</tr>
<tr>
<td style="padding-left: 100px">230</td>
<td><em>Prometheus Chained</em></td>
</tr>
<tr>
<td style="padding-left: 100px">244, 249</td>
<td><em>The Persians</em></td>
</tr>
<tr>
<td style="padding-left: 100px">270</td>
<td><em>The Suppliants</em></td>
</tr>
</tbody></table>
	<p class="desc">The thirteen Flaxman designs, printed sideways, are the same as those first printed (1795) by Flaxman’s aunt Jane Matthews and reprinted (15 April 1831) by [his half-sister] Miss [Mary Ann] Flaxman and [his sister-in-law] Miss [Maria] Denman. John Murray is not known to have had any other connection with publishing <span class="notecall">Flaxman’s classical designs.</span><span class="fn">G. E. Bentley, Jr., <em>The Early Engravings of Flaxman’s Classical Designs: A Bibliographical Study</em> (New York: New York Public Library, 1964), which does not mention <em>Popular English Specimens of the Greek Dramatic Poets</em>.</span></p>

<p class="author">Homer, <em>Ilias und Odyssee: Die Zeichnungen von John Flaxman</em>. Ed. Elke Austermühl. Darmstadt: Wissenschaftliche Buchgesellschaft, 2013. 160 pp.; ISBN: 9783650251343. In German. Also available as an e-book (ISBN: 9783650729613).</p>

<p class="author">Homero, <em>Odisea con ilustraciones de John Flaxman</em>. e-artnow, 2013. ISBN: 9788074840296. In Spanish.</p>
<p class="desc">Probably reproduced from a copy in the Library of Congress. (For e-artnow’s use of copies from the Library of Congress, see <a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/article/view/bentley491/bentley491html#Complete"><em>The Complete Illuminated Books of William Blake</em></a> in Part I, Section B.)</p>

<p class="gapcenter"><a name="Frost" id="Frost"></a><span style="font-variant: small-caps;">Frost</span>, William Edward (1810–77)</p>
<p class="reviewheading">Painter, collector of Stothard and Blake</p>
<p class="author" style="text-indent: 15px">Frost’s peculiar importance for Blake studies is that he provides the only evidence for Blake’s “To the Public” <span class="notecall">(1793).</span><span class="fn">According to Alexander Gilchrist, <em>Life of William Blake, “Pictor Ignotus”</em> (1863) <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=o9oDAAAAYAAJ&amp;pg=PA263#v=onepage&amp;q&amp;f=false" target="_blank">2: 263</a>, “Mr. Frost” helped to obtain “at the last moment” a copy of “To the Public.”</span></p>
<p class="desc">William Edward Frost of 8 Southampton Street, Fitzroy Square, wrote to Edward B. Jupp, 17 May 1861, to say:
<span class="extract">I am exceedingly gratified by your Kind offer of the “Calisto” [Stothard–Blake]—and shall be happy if I can supply you with a Bartollozzi or any other master that will afford you half the gratification tha[t] possession of the “Calisto” will give me—I am endeavouring to make as complete a collection of the engraved works of Stothard <sub>^</sub>as possible<sub>^</sub> and hope and intend to <span style="text-decoration: underline">print a list</span> of his works—my collection is not arranged at present but my bookbinder is now making ten folio volumes in which to insert them. I have a volume containing a few drawings and a number of slight sketches, I do not propose to <span class="notecall">collect his drawings.</span><span class="fn">Victoria University in the University of Toronto, watermark T<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">owgoods</span> | E<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">xtra</span> S<span style="font-variant: small-caps; font-size: 16px; line-height: 21px">quare</span>.</span></span>
</p><p class="desc">Frost wrote from the same address to F. S. Ellis (bookseller), 9 November 1861, saying, “I had much pleasure in looking through your Catalogue. I regret the names of Stothard and Blake do not occur more frequently—I beg to enclose a list of a few works I am seeking and shall feel greatly obliged if by any means you could <span class="notecall">procure them for me.”</span><span class="fn">Victoria University in the University of Toronto. The list is not with the letter.</span></p>
<p class="desc">The twelve-volume collection in the Royal Academy entitled <em>Engravings, from the Works of Thomas Stothard, R. A. … Collected by W. E. Frost, <span style="white-space: nowrap">A.R. A.,</span> …</em> (London, 1861) contains the very rare Stothard–Blake prints of “Four Classical Figures” ([1779?]), “The Morning Amusements of Her Royal Highness …” and “A Lady in the Full Dress …” (on one plate, 1782 [for <em>The Ladies New and Polite Pocket Memorandum-Book, for … 1783</em>]), “The Fall of Rosamond” (1783), “Zephyrus and Flora” (1784), “Calisto” (1784), and “A Lady Embracing a Bust” [for (Elizabeth Blower), <em>Maria: A Novel</em> (1785)]—see Robert N. Essick, <em>The Separate Plates of William Blake</em> (Princeton: Princeton University Press, 1983) 135, 140, 143, 233, 240, 242.</p>

<p class="gapcenter"><a name="Fuseli" id="Fuseli"></a><span style="font-variant: small-caps;">Fuseli</span>, John Henry (1741–1825)</p>
<p class="reviewheading">Swiss-born painter, friend of Blake</p>
<p class="author"><em>Henry Fuseli: 80 Drawings</em>. Ed. Narim Bender. Osmora Inc., 2014. 85 pp.; ISBN: 9782897284756.<br>

</p><p class="gapcenter"><a name="Hayley" id="Hayley"></a><span style="font-variant: small-caps;">Hayley</span>, William (1745–1820)</p>
 <p class="reviewheading">Man of letters and patron</p>

<p class="author">William Hayley, <em>The Life of Milton …</em>. Charleston: BiblioLife, 2014. 360 pp.; ISBN: 9781293597590.</p>

<p class="gapcenter"><a name="Johnson" id="Johnson"></a><span style="font-variant: small-caps;">Johnson</span>, Joseph (1738–1809)</p>
 <p class="reviewheading">Liberal bookseller, patron of Blake</p>
 
<p class="author">Barfoot, C. C. “In the Churchyard and under the Full Moon: The Radical Publisher and His Clients and Guests.” <em>The Literary Utopias of Cultural Communities, 1790-1910</em>. Ed. Marguérite Corporaal and Evert Jan van Leeuwen. Amsterdam: Rodopi, 2010. 9-22.</p>

<p class="author" style="text-indent: 15px">At the end of the <a href="https://books-google-com.libproxy.lib.unc.edu/books?id=yT4TAAAAYAAJ&amp;pg=PA449#v=onepage&amp;q&amp;f=false" target="_blank"><em>Analytical Review</em></a> (printed for J. Johnson) 28 (Oct. 1798) is an added list of “<em>Books printed for J. Johnson, in St. Paul’s Church-Yard</em>,” including the <em>Ladies New and Polite Pocket Memorandum-Book</em> for 1799, 1s.</p>

<p class="gapcenter"><a name="Linnell" id="Linnell"></a><span style="font-variant: small-caps;">Linnell</span>, John (1792–1882)</p>
<p class="reviewheading">Painter, Blake’s patron</p>

<p class="author" style="text-indent: 15px">Linnell’s letter to Bernard Barton of 3 April 1830 about Blake (<em>BR</em>[2] 526-28) sold at Sotheby’s, 3-4 June 1907, lot 386 [£2.18.0 to Pearson].

</p><p class="gapcenter"><a name="Stedman" id="Stedman"></a><span style="font-variant: small-caps;">Stedman</span>, John Gabriel (1744–97)</p>
<p class="reviewheading">Soldier of fortune, friend of Blake</p>
<p class="author">Bohls, Elizabeth A. “Stedman’s Tropics: The Mercenary as Naturalist.” <em>Slavery and the Politics of Place: Representing the Colonial Caribbean, 1770-1833</em>. Cambridge: Cambridge University Press, 2014. 54-81 (chapter 2).</p>

<p class="gapcenter"><a name="Tatham" id="Tatham"></a><span style="font-variant: small-caps;">Tatham</span>, Frederick (1805–78)</p>
<p class="reviewheading">Sculptor and painter, Blake’s disciple</p>

<p class="author" style="text-indent: 15px">A remarkably detailed and excellent web site, <em>Tathamfamilyhistory</em>, “The Tathams of County Durham” &lt;﻿<a href="http://www.saxonlodge.net/" target="_blank">http://​www.​saxonlodge.​net</a>﻿&gt; [conducted by Robert Collingwood], gives a great deal of information about Frederick Tatham and his family. The record for Frederick &lt;﻿<a href="http://www.saxonlodge.net/getperson.php?personID=I0840&amp;tree=Tatham" target="_blank">http://​www.​saxonlodge.​net/​getperson.​php?personID=I0840​&amp;tree=Tatham</a>﻿&gt; has information and documents pertaining to his marriage, children, and residences. Of note is a transcription of a letter he wrote in 1877 to his much younger brother Robert Bristow Tatham (1824–81) in South Africa: &lt;﻿<a href="http://www.saxonlodge.net/showmedia.php?mediaID=1062&amp;medialinkID=1352&amp;tngpage=1" target="_blank">http://​www.​saxonlodge.​net/​showmedia.​php?​mediaID=1062​&amp;medialinkID=1352​&amp;tngpage=1</a>﻿&gt;.</p>

<p class="gapcenter"><a name="Watson" id="Watson"></a><span style="font-variant: small-caps;">Watson</span>, Caroline (1761?–1814)</p>
<p class="reviewheading">Engraver</p>

<p class="gapcenter" style="margin-top: 30px">2014 23 <span style="font-variant: small-caps;">September</span>–2015 4 <span style="font-variant: small-caps;">January</span></p>
David Alexander. <em>Caroline Watson and Female Printmaking in Late Georgian England</em>. Cambridge: Fitzwilliam Museum, 2014. 126 pp.; ISBN: 9780957443464.<br>
<p class="desc">It includes a catalogue of over 100 prints by Watson and sixteen letters from her to William Hayley.</p>
</div>
</div>


	

<link rel="stylesheet" type="text/css" href="./49.1.bentley_files/LoggedOut.css"><br><br>
<div id="custFooter"><div id="navbar"><ul class="menu"> <li id="home"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/index" target="_parent">Home</a></li> <span class="navdiv"> | </span> <li id="current"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/current" target="_parent">current issue</a></li> <span class="navdiv"> | </span> <li id="archives"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/issue/archive" target="_parent">back issues</a></li> <span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/public/journals/2/index.html" target="_blank">Index</a></li><span class="navdiv"> | </span><li id="subUser"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/user/subscriptions#pay" target="_parent">subscribe</a></li><span class="navdiv2"> | </span><li id="subAbout"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/about/subscriptions" target="_parent">subscribe</a></li><span class="navdiv2"> | </span> <li id="search"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/search" target="_parent">Search</a></li> <li id="announcements"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/announcement" target="_parent">Announcements</a></li> <span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/submit" target="_parent">submit</a></li> <span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/relatedsites" target="_parent">related sites</a></li> <span class="navdiv"> | </span> <li id="navItem"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/BonusContent" target="_parent">Bonus Content</a></li> <span class="navdiv"> | </span> <li id="navItem"><a href="https://blakearchive-wordpress-com.libproxy.lib.unc.edu/" target="_blank">blog</a></li> <span class="navdiv"> | </span> <li id="about"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/About" target="_parent">About</a></li> <span class="navdiv"> | </span><li id="contact2"><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/pages/view/Contact" target="_parent">Help</a></li> </ul></div> <div id="footerLog">Individual Subscriber? <br><a href="http://blake.lib.rochester.edu.libproxy.lib.unc.edu/blakeojs/index.php/blake/login">Log In</a></div> <div id="UofR" style="margin-top: 20px;"><img style="float: right;" src="UofR.gif" alt=""><br> <span style="float: right; clear: both; display: block;"> <a href="http://www.rochester.edu.libproxy.lib.unc.edu/college/eng/" target="_blank">Department of English</a></span><br><span style="float: right; clear: both; display: block;">© Blake/An Illustrated Quarterly</span></div></div>
<!-- Google Analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src="" + gaJsHost + "google-analytics.com/ga.js" type="text/javascript"%3E%3C/script%3E"));
</script><script src="./49.1.bentley_files/ga.js" type="text/javascript"></script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-26093986-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
<!-- /Google Analytics -->

</div><!-- content -->
</div><!-- main -->
</div><!-- body -->



<!-- container -->



</body></html>';

print ('<p>Test string: '.contains_any_multibyte($str).'</p>');

$output_original = htmlentities_savetags_original($str);
$output = htmlentities_savetags($str);
$output_stripped = strip_special_chars($str);

print ('<p>Test string after original processing: '.contains_any_multibyte($output_original).'</p>');
print ('<p>Test string after new processing: '.contains_any_multibyte($output).'</p>');
print ('<p>Test string after special chars stripped: '.contains_any_multibyte($output_stripped).'</p>');


print '<div>"'.$output_stripped.'"</div>';
file_put_contents('output.html', $output_stripped);

?>