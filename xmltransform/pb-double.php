<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$dir = ''; // enter directory path
	$url = ''; // enter url
	
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');
			
	function replaceInFile($key, $value, $filename) {
		$XMLstring = file_get_contents($dir.$filename);
		$XMLstringNew = $XMLstring;
		
		$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
		
		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
			file_put_contents('new/'.$filename, $XMLstringNew);
			echo '<h4>Converted '.$filename.'</h4>';
			return true;
		} else if ($XMLstringNew == '') {
			echo '<p style="color: red;">ERROR: transformed '.$filename.' is blank.</p>';
			return false;
		} else {
			echo '<p>'.$filename.': no change</p>';
			return false;
		}
	}
	
	function pdfForPage($vol, $iss, $p) {
		$volTwoDig = str_pad($vol, 2, '0', STR_PAD_LEFT);
		$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT);
		
		//$dir = '/Applications/MAMP/htdocs/public-tools/xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$dir = '/public-tools/xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$fn = $volTwoDig.'.'.$iss.'.'.$pThreeDig.'.pdf';
		
		return $dir.$fn;
	}
	
	$files = file_get_contents('lists/notes-bottom-ok.txt');
	$filesList = explode($nl, $files);

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Check for two page breaks in a row (and combine)</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
							
			foreach (new DirectoryIterator($dir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename()) && !in_array($fn->getFilename(), $filesList)) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					/*
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];

					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					$fn_t['pb'] = $FullXML->xpath('//pb/@n'); // array
					$fn_t['pbHidden'] = $FullXML->xpath('//pb/@rend'); // array
					$fn_t['pbHiddenFront'] = $FullXML->xpath('//front//pb/@rend'); // array
					$fn_t['pbHiddenBack'] = $FullXML->xpath('//back//pb/@rend'); // array
					$fn_t['notes'] = $FullXML->xpath('//note/@id'); // array (unreferenced notes have no ids, but are also rarely endnotes except in the company of notes with ids)
					*/
				
					if (replaceInFile('<pb id="(p[0-9]{2}-[0-9]{1,3})" n="([0-9]{1,3})"[ ]{0,1}/>[ 	\r\n]{0,}<pb id="p[0-9]{2}-[0-9]{1,3}" n="([0-9]{1,3})"[ ]{0,1}/>', '	<pb id="$1-$4" n="$2-$4"/>', $fn_t['fn'])) {
						$nextPdfLink = pdfForPage($fn_t['volNum'], $fn_t['issueNum'], $next);
						print '<p>';
						print '<a href="'.$url.$fn_t['file'].'" target="_blank">OLD</a> ';
						print '<a href="'.$url.'pdfs/'.$fn_t['file'].'.pdf" target="_blank">PDF</a> ';
						print '<a href="'.$nextPdfLink.'" target="_blank">(next page)</a> ';
						print '<a href="/public-tools/diff/trans-diff.php?file='.$fn_t['file'].'" target="_blank">DIFF</a> ';
						print '<a href="/public-tools/xmltransform/move-to-main.php?f='.$fn_t['file'].'.xml" target="_blank" style="color:red;">ADD PAGE</a> ';
						print '<a href="/public-tools/xmltransform/notes-bottom-ok.php?l=notes-bottom-ok.txt&t='.$fn_t['file'].'.xml" target="_blank" style="color:red;">OK AS IS</a> ';
						print '</p>';
					} else {
						//
					}
					
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

