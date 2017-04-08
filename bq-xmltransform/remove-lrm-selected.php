<!DOCTYPE html>
<html>
<?php
//require('include/functions.php');

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


//ini_set('memory_limit', '128M');
ini_set('memory_limit', '256M');

//header("Content-Type: text/html; charset=utf-8");
//ini_set("default_charset", 'utf-8');

$nl = "
";

$replaceMB = array();
$replaceMB["—"] = " - ";
$replaceMB["’"] = "'";
$replaceMB["‘"] = "'";
$replaceMB["“"] = '"';
$replaceMB["”"] = '"';

$char = html_entity_decode('&lrm;');

$replace = array();
$replace[$char] = "";

?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform - remove left-to-right mark in selected files (in "old" directory)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator("old/") as $fn) {
						if (preg_match('/[a-zA-Z]/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
							
							//$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);
							//$fn_t['volNum'] = $fileParts[0];
							//$fn_t['issueNum'] = $fileParts[1];
							//$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							//$fn_t['fileSplit'] = $fileParts[2];

							$XMLstring = file_get_contents('old/'.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							/* Convert to UTF-8 before doing anything else */
							//$XMLstringNew = iconv( "ASCII", "UTF-8", $XMLstringNew );
							
							// replace MB
							$search = array_keys($replaceMB);
							$values = array_values($replaceMB);
							$XMLstringNew = mb_str_replace($search, $values, $XMLstringNew);
							
							// replace
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
							}
							
							if($XMLstring !== $XMLstringNew) {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else {
								echo '<p>'.$fn_t['fn'].': no change</p>';
							}

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

