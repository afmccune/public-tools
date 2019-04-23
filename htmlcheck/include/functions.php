<?php
   			require('../../include.php');
   			include('include/simple_html_dom.php');
			
			$minVol = 33;
			$minIss = 4;
			$maxVol = 43;
			$maxIss = 1;
			
			function inPubRange ($vol, $iss) {
				global $minVol, $minIss, $maxVol, $maxIss;
				
				if(($vol > $minVol || ($vol == $minVol && $iss >= $minIss)) && ($vol < $maxVol || ($vol == $maxVol && $iss <= $maxIss))) {
					return true;
				} else {
					return false;
				}
			}
			
			function showable ($vol, $iss) {
				if($_SERVER['SERVER_NAME'] == $mainServer && inPubRange($vol, $iss)) {
					return true;
				} else if ($_SERVER['SERVER_NAME'] == $devServer || $_SERVER['SERVER_NAME'] == 'localhost') {
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
				if (($cmp = strcmp($a['authorLast'], $b['authorLast'])) !== 0) {
					return $cmp;
				} else if(($cmp2 = strcmp($a['author'], $b['author'])) !== 0) {
					return $cmp2;
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
			
			function getHtmlIssueDate($volIss) {
				$tocHTML = file_get_html('html/'.$volIss.'.toc.html');
				$HTMLdesc = array();
				foreach($tocHTML->find('div[id=issueDescription] p') as $e) {
					$HTMLdesc[] = $e->innertext;
				}
				$descParts = explode(':', $HTMLdesc[0]);
				return $descParts[0];
			}
?>
