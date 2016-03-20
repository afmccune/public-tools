<!DOCTYPE html>
<html>
	<head>
                <!--<meta http-equiv="content-type" content="text/html;charset=utf-8" />-->
    </head>
<?php
require('include/functions.php');

			function strip_chars($str_in) {
				$str_out = strip_regular_chars($str_in);
				$str_out = strip_special_chars($str_out);
				return $str_out;
			}

			function strip_regular_chars($str_in) {
				$search = "A-Za-z0-9 !\-\?=:\.\|,\(\)\/;_\{}%'#\[\]\*\$\+\@\^~\r\n	";
				//$search = utf8_encode($search);
				//$search = iconv(mb_detect_encoding($search, mb_detect_order(), true), "UTF-8", $search);

				//$str_out = preg_replace('/['.$search.']{1,}[\\]?/', '', $str_in);
				$str_out = preg_replace('/['.$search.']{1,}/', '', $str_in);
				$str_out = str_replace('\\', '', $str_out);
				return $str_out;
			}
			
			function strip_special_chars($str_in) {
				$list = get_html_translation_table(HTML_ENTITIES);
				unset($list['[']);
				unset($list[']']);
				unset($list['-']);
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
				$list['♈'] = '&#9800;'; // Astrological signs
				$list['♉'] = '&#9801;';
				$list['♊'] = '&#9802;';
				$list['♋'] = '&#9803;';
				$list['♌'] = '&#9804;';
				$list['♍'] = '&#9805;';
				$list['♎'] = '&#9806;';
				$list['♏'] = '&#9807;';
				$list['♐'] = '&#9808;';
				$list['♑'] = '&#9809;';
				$list['♒'] = '&#9810;';
				$list['♓'] = '&#9811;';
				$list['█'] = '&#9608;'; // full block (which renders just fine without encoding)
				$list['ł'] = '&#322;'; // 
				$list['ń'] = '&#324;'; //
				$list['ę'] = '&#281;'; //
				$list['ą'] = '&#261;'; //
				$list['‑'] = '&#8209;'; // non-breaking hyphen
			
				$search = array_keys($list);
				$values = array_values($list);
				//$search = array_map('utf8_encode', $search);
				
				/*
				print('<div style="red"><h1>SEARCH</h1><pre>');
				print_r($search);
				print('</pre></div>');
				*/
				
				$str_out = $str_in;
				//$str_out = array_map('utf8_encode', $str_out);

				//$str_out = mb_str_replace($search, $values, $str_out);
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

						
$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML Check (Broken Characters)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$previousVolIss = '0.0';
												
						$docsHtml = array(); 
						foreach (new DirectoryIterator("../../bq/html/") as $fn) {
							if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
							//if (preg_match('/46.1.bentley.html/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['fileSplit'] = $fileParts[2];
								$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
													
								$HTMLstring = file_get_contents('../../bq/html/'.$fn_t['fn']);
								$chars = strip_chars($HTMLstring);
								$ct = strlen($chars);
								
								echo '<p>'.$fn_t['file'].': "'.$chars.'" ['.$ct.']</p>';
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

