<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');
	
	function vol_cmp(array $a, array $b) {
		if (($a['vol'] - $b['vol']) !== 0) {
			return $a['vol'] - $b['vol'];
		} else {
			return strcmp($a['iss'], $b['iss']);
		}
	}
	
	function page_cmp(array $a, array $b) {
		return strcmp($a['id'], $b['id']);
	}
	
	function replaceInFile($key, $value, $filename) {
		$XMLstring = file_get_contents('../../bq/docs/'.$filename);
		$XMLstringNew = $XMLstring;
		
		$XMLstringNew = preg_replace("@".$key."@", "".$value."", $XMLstringNew);
		
		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
			file_put_contents('new/'.$filename, $XMLstringNew);
			echo '<h4>Converted '.$filename.'</h4>';
		} else if ($XMLstringNew == '') {
			echo '<p style="color: red;">ERROR: transformed '.$filename.' is blank.</p>';
		} else {
			echo '<p>'.$filename.': no change</p>';
		}
	}
	
	function copyFile ($oldPath, $newPath, $volIss) {
		$newDir = 'pdf-rename/'.$volIss;
		if (file_exists($newDir)) {
			// okay
		} else {
			mkdir($newDir);
		}
		if (!copy ('pdf-split/'.$oldPath, $newDir.'/'.$newPath)) {
			echo '<p>Failed to copy pdf-split/'.substr($oldPath, 2).'</p>';
		} else {
			//echo '<p>Copied pdf-split/'.substr($oldPath, 2).' to '.$newDir.'/'.$newPath.'</p>';
		}
	}
	
		
	$vol_pages = array();
	
	foreach (new DirectoryIterator('pdf-split/') as $fn) {
		if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.p[0-9]{1,3}.pdf/', $fn->getFilename())) {
			$pdf = $fn->getFilename();
			$pdfParts = explode('.', $pdf);
			$vol = $pdfParts[0];
			$iss = $pdfParts[1];
			$page = str_replace('p','',$pdfParts[2]);
			if($vol<45) { // exclude HTML issues, which have PDFs for each article
				if(isset($vol_pages[$vol])) {
					// nothing
				} else {
					$vol_pages[$vol] = array();
					$vol_pages[$vol]['vol'] = $vol;
				}
				if(isset($vol_pages[$vol][$iss])) {
					// nothing
				} else {
					$vol_pages[$vol][$iss] = array();
					$vol_pages[$vol][$iss]['pdf-page-count'] = 0;
				}
				$vol_pages[$vol][$iss][] = $pdf;
				$vol_pages[$vol][$iss]['pdf-page-count'] = $vol_pages[$vol][$iss]['pdf-page-count'] + 1;
			}
		}
	}

	
	
	unset($vol_pages['23']['4a']); // 23.4a.pdf is a duplicate of 23.4.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	unset($vol_pages['21']['2b']); // 21.2b.pdf is a duplicate of 21.2.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	unset($vol_pages['26']['3a']); // 26.3a.pdf is a duplicate of 26.3.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	
	// add dummy vol. 0 so usort will set the volume numbers correctly
	$vol_pages['0'] = array();
	$vol_pages['0']['vol'] = 0;
	
	usort($vol_pages, 'vol_cmp');
	
	unset($vol_pages['0']); // remove dummy vol. 0
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>PDF pages</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$volCount = 0;

			$all_pages = array();
			
			foreach($vol_pages as $arr) {
				$vol = $arr['vol'];
				$volCount = 0;
				$pdfRange = array();
				foreach($arr as $iss => $items) {
					if($iss != 'vol') {
						$pages = $items['pdf-page-count'];
						$oldVolCount = $volCount;
						$volCount += $pages;
						$pdfRange = range($oldVolCount+1, $volCount);
						// ADJUSTMENTS
						if($vol == 1 && $iss == 1) {
							// 1.1 ends on a blank page, which is not transcribed
							//$pdfRange = range(1, ($pages-1));
						} else if($vol == 1) {
							// 1.2, 1.3, and 1.4 all restart at page 1
							$pdfRange = range(1, $pages);
						} else if ($vol == 2 && $iss === '4b') {
							// 2.4b begins with I-III, then 1
							$pdfRange = array_merge(array('I','II','III'), range(1, ($pages-3)));
						} else if ($vol == 2) {
							// The rest of volume 2 seems to lack both spreads and non-content pages
						} else if ($vol == 3 && $iss == 1) {
							// 3.1 seems to lack both spreads and non-content pages
						} else if ($vol == 3 && $iss == 2) {
							// 3.1 ends on page 20, but 3.2 begins on page 22 (not 21)
							$oldVolCount = $oldVolCount+1;
							$volCount = $volCount+1;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 3 && $iss == 3) {
							// 3.3 ends on a blank (unnumbered) page
							$volCount = $volCount-1;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 3 && $iss == 4) {
							// 3.4 seems to lack both spreads and non-content pages
						} else if ($vol == 4 && $iss == 1) {
							// 4.1 seems to lack both spreads and non-content pages
						} else if ($vol == 4 && $iss == 2) {
							// 4.2 has two blank pages, one at the end and the other third from the end,
							// which count but are not transcribed.
							//unset($pdfRange[count($pdfRange)-1]); // remove the last page; third-to-last is now second-to-last
							//unset($pdfRange[count($pdfRange)-2]); // remove new second-to-last (formerly third-to-last) page
						} else if ($vol == 4 && $iss == 3) {
							// 4.3 ends on two blank pages WHICH DO NOT COUNT
							$volCount = $volCount-2;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 4 && $iss == 4) {
							// 4.4 ends on two non-content pages: one blank, 
							// the other an extension of the front cover design / an elaboration 
							// of the illus. on page 135 (AND with the unique caption 
							// "In this issue John Grant (p. 117) and Judith Rhodes (p. 135) 
							// discuss Blake's designs for L'Allegro and Il Penseroso"
							//$volCount = $volCount-2;
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 5 && $iss === '1-2') {
							// 5.1-2 seems to lack both spreads and non-content pages
						} else if ($vol == 5 && $iss == 3) {
							// 5.3 seems to lack both spreads and non-content pages
						} else if ($vol == 5 && $iss == 4) {
							// 5.4 ends with two blank pages, which count but are not transcribed
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 6 && $iss == 1) {
							// 6.1 seems to lack both spreads and non-content pages
						} else if ($vol == 6 && $iss == 2) {
							// 6.2 has a foldout (37b and 37c, following 37, which is the cover)
							$volCount = $volCount-2;
							$pdfRange = array_merge(array('37', '37b', '37c'), range($oldVolCount+2, $volCount));
						} else if ($vol == 6 && $iss == 3) {
							// 6.3 ends on a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 6 && $iss == 4) {
							// 6.4 seems to lack both spreads and non-content pages
						} else if ($vol == 7 && $iss == 1) {
							// 7.1 ends on a non-content page (repetition of illus. on page 4), which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 7 && $iss == '2') {
							// 7.2 has an ad near (but not at) the end, which counts but is not transcribed.
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 7 && $iss == 3) {
							// 7.3 seems to lack both spreads and non-content pages
						} else if ($vol == 7 && $iss == 4) {
							// 7.4 ends on a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 8 && $iss == '1-2') {
							// 8.1-2 has two non-content pages (repetitions of the motif of the inside front cover) 
							// near (but not at) the end, which count but are not transcribed.
							// (note: each time we remove one, another becomes the second-to-last)
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 8 && $iss == 3) {
							// 8.3 ends with a repeated illus., two blank pages, and a repeated illus., which count but are not transcribed
							//$volCount = $volCount-4; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+4; // add back pages back in for next issue's count
						} else if ($vol == 8 && $iss == 4) {
							// 8.4 ends with two blank pages, which count but are not transcribed
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 9 && $iss == 1) {
							// 9.1 ends with a blank page and then a wordless back cover, which count but are not transcribed
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 9 && $iss.'' == '2') {
							// 9.2 begins on page 33, for some reason, although 9.1 ends on page 30
							// 9.2 ends on a blank page, which counts but is not transcribed
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 9 && $iss === '2b') {
							// 9.2b starts with i, then 1
							// 9.2b ends with an ad page, which is not transcribed
							//$pages = $pages-1; // omit back page
							$pdfRange = array_merge(array('i'), range(1, ($pages-1)));
							$volCount = $oldVolCount; // 9.3 starts where 9.2 left off
						} else if ($vol == 9 && $iss == 3) {
							// 9.3 ends on two ad pages and a blank page, which count but are not transcribed.
							//$volCount = $volCount-3; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 9 && $iss == 4) {
							// 9.4 has three ad pages (or something like ads) near (but not at) the end, which count but are not transcribed.
							// (note: each time we remove one, another becomes the second-to-last)
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 10 && $iss == 1) {
							// 10.1 ends on an ad page and a non-content page (extension of front cover design), which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 10 && $iss == 2) {
							// 10.2 ends on an ad page and a non-content page (extension of front cover design), which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 10 && $iss == 3) {
							// 10.3 ends on a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 10 && $iss == 4) {
							// 10.4 has a 120-121 page spread (one PDF page, 24th in PDF), but this doesn't seem to have created page count problems--
							// perhaps because the final page is a non-content back cover, which counts but is not transcribed.
							// replace page 120
							$pdfRange[23] = '120-121';
							// since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add to the volCount
							$volCount = $volCount + 1;
							// remove page 121
							unset($pdfRange[24]);
						} else if ($vol == 11 && $iss == 1) {
							// 11.1 ends on a non-content page (repetition of illus. on page 34), which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 11 && $iss == 2) {
							// 11.1 ends on page 66, but 11.2 begins on page 69 (not 67)
							$oldVolCount = $oldVolCount+2;
							$volCount = $volCount+2;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 11 && $iss == 3) {
							// In 11.3, there are two spreads.
							// Since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and again for the other spread
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add these to the volCount
							$volCount = $volCount + 2;
							// 158-159 are scanned as a single PDF page (26th in PDF),
							// replace page 158
							$pdfRange[25] = '158-159';
							// remove page 159
							unset($pdfRange[26]);
							// and 170-171 are scanned as a single PDF page (37th in PDF).
							// replace page 170
							$pdfRange[37] = '170-171';
							// remove page 171
							unset($pdfRange[38]);
							// The content ends on page 208, and is followed
							// by two non-content pages (an ad and a wordless back cover).
						} else if ($vol == 11 && $iss == 4) {
							// 11.4 begins on 213 even though 11.3 ends on 210.
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							$pdfRange = range($oldVolCount+1, $volCount);
							// 11.4 also has a 226-227 spread (14th page in PDF)
							// replace page 226
							$pdfRange[13] = '226-227';
							// since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add to the volCount
							$volCount = $volCount + 1;
							// remove page 227
							unset($pdfRange[14]);
						} else if ($vol == 12 && $iss == 1) {
							// 12.1 ends with two ad pages and a blank page, which count but are not transcribed.
							//$volCount = $volCount-3; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 12 && $iss == 2) {
							// 12.2 seems to lack both spreads and non-content pages
						} else if ($vol == 12 && $iss == 3) {
							// 12.3 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 12 && $iss == 4) {
							// 12.4 has an ad page in the middle (page 257, 36th page in PDF), which counts but is not transcribed.
							//unset($pdfRange[36]);
							// 12.4 has an ad page in the middle (page 263, 42nd page in PDF), which counts but is not transcribed.
							//unset($pdfRange[42]);
							// 12.4 also has a 252-253 spread (32nd page in PDF)
							// replace page 252
							$pdfRange[31] = '252-253';
							// since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add to the volCount
							$volCount = $volCount + 1;
							// remove page 253
							unset($pdfRange[32]);
						} else if ($vol == 13 && $iss == 1) {
							// 13.1 ends on two non-BQ pages (an ad insert?)
							$volCount = $volCount-2;
							$pdfRange = array_merge(range($oldVolCount+1, $volCount), array('extra1','extra2'));
							// 13.1 also has some pages near (but not at) the end, which count but are not transcribed:
							// ("from the last page" is based on the page count when the non-BQ pages are removed)
							// - page 58 (third from the last page): an ad page
							// - page 59 (second from the last page): an ad page
							// (note: each time we remove one, another becomes the second-to-last)
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 13 && $iss == 2) {
							// 13.2 seems to lack both spreads and non-content pages
						} else if ($vol == 13 && $iss == 3) {
							// In print, 13.3 ends with four non-content pages--three in the PDF.
							// 157: ad
							// 158-159 spread: repetition of illus. on page 118 (46th page in PDF)
							// 160: back cover--wordless extension of front cover design
							// SO:
							// Add additional page to the count for the two-page spread (counted as one because it is one in the PDF)
							$volCount = $volCount+1;
							// and add it to the range
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// replace page 158
							$pdfRange[45] = '158-159';
							// remove page 159
							unset($pdfRange[46]);
							// Omit back pages
							//$volCount = $volCount-4;
							//$pdfRange = range($oldVolCount+1, $volCount);
							// Add back page back in for next issue's count
							//$volCount = $volCount+4;
							// Also, page 139 (the 27th page in the PDF) is an ad page, which counts but is not transcribed
							//unset($pdfRange[26]);
						} else if ($vol == 13 && $iss == 4) {
							// 13.4 has a 166-167 spread (6th page in PDF) 
							// and a 174-175 spread (13th page in PDF).
							// Since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and again for the other spread
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add these to the volCount
							$volCount = $volCount + 2;
							// replace page 166
							$pdfRange[5] = '166-167';
							// remove page 167
							unset($pdfRange[6]);
							// replace page 174
							$pdfRange[13] = '174-175';
							// remove page 175
							unset($pdfRange[14]);
							// There is also an ad page on page 191 (29th page in PDF), which counts but is not transcribed.
							//unset($pdfRange[30]); // At this point the print page count is two ahead of the PDF page count because of the two spreads.
							// The last two pages are an ad (for an exhibition)
							// and a wordless back cover.
						} else if ($vol == 14 && $iss == 1) {
							// 14.1 includes an index numbered i-ii
							$volCount = $volCount-2; // omit index pages (from Arabic numeral count)
							// The last regular page is a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							$pdfRange = array_merge(range($oldVolCount+1, $volCount), array('i', 'ii'));
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 14 && $iss == 2) {
							// 14.2 includes a 68-69 spread (27th in PDF)
							$volCount = $volCount+1;
							// Since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// replace page 68
							$pdfRange[27] = '68-69';
							// remove page 69
							unset($pdfRange[28]);
							// 14.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
							// 14.2 also has an ad page in the middle--page 65 (25th in PDF)--which counts but is not transcribed.
							//unset($pdfRange[24]);
						} else if ($vol == 14 && $iss == 3) {
							// 14.3 seems to lack both spreads and non-content pages
						} else if ($vol == 14 && $iss == 4) {
							// 14.4 has an ad page in the middle--page 195 (19th in PDF)--which counts but is not transcribed.
							//unset($pdfRange[18]);
							// 14.4 also has a blank page, page 205 (29th in PDF), which counts but is not transcribed.
							//unset($pdfRange[28]);
						} else if ($vol == 15 && $iss == 1) {
							// 15.1 has an ad page in the middle--page 23 (also 23rd in PDF)--which counts but is not transcribed.
							//unset($pdfRange[22]);
						} else if ($vol == 15 && $iss == 2) {
							// 15.2 includes an index numbered i-ii
							$volCount = $volCount-2;
							$pdfRange = array_merge(range($oldVolCount+1, $oldVolCount+2), array('i', 'ii'), range($oldVolCount+3, $volCount));
						} else if ($vol == 15 && $iss == 3) {
							// 15.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 15 && $iss == 4) {
							// 15.4 seems to lack both spreads and non-content pages
						} else if ($vol == 16 && $iss == 1) {
							// 16.1 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 16 && $iss == 2) {
							// 16.2 has some pages near (but not at) the end, which count but are not transcribed:
							// - page 141 (fourth from the last page): an ad page
							// - page 142 (third from the last page): repetition of illustration on page 76
							// - page 143 (second to last page): repetition of illustration on page 75
							// (note: each time we remove one, another becomes the second-to-last)
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 16 && $iss == 3) {
							// The last three regular (unnumbered) print pages (186-188) count, but are not transcribed.
							// They consist of two PDF pages (a 186-187 spread and a blank 188).
							// (The 186-187 spread is a simple image motif that does not seem to be an illustration.)
							// These should count so that the next issue begins at 189.
							// The final two irregular pages are the index, numbered i-ii in the transcription.
							// These do not count towards the start page of the next issue.
							// FOR THE SPREAD
							// The 186-187 spread counts for two pages (+1).
							// 16.3 includes a 186-187 spread (42nd in PDF)
							$volCount = $volCount+1;
							// FOR MATCHING THIS ISSUE'S TRANSCRIPTION:
							// Two index pages do not count (-2), but i-ii is added to the page range.
							$volCount = $volCount-2;
							// The 186-187 page spread and blank 188 count but are not transcribed (-2).
							//$volCount = $volCount-2;
							$pdfRange = array_merge(range($oldVolCount+1, $volCount), array('i', 'ii'));
							// replace page 186
							$pdfRange[41] = '186-187';
							// remove page 187
							unset($pdfRange[42]);
							// FOR MATCHING THE PAGE COUNT OF THE NEXT ISSUE:
							// Add back in the two PDF pages that count but are not transcribed, for the count for the next issue.
							//$volCount = $volCount+2;
						} else if ($vol == 16 && $iss == 4) {
							// 16.4 seems to lack both spreads and non-content pages
						} else if ($vol == 17 && $iss == 1) {
							// 17.1 seems to lack both spreads and non-content pages
						} else if ($vol == 17 && $iss == 2) {
							// 17.2 has three ad pages at and near the end, which count but are not transcribed: 
							// print pages 77-78 (37th and 38th in PDF)
							// print page 80 (40th in PDF), the back page
							//unset($pdfRange[36]);
							//unset($pdfRange[37]);
							//unset($pdfRange[39]);
						} else if ($vol == 17 && $iss == 3) {
							// 17.3 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 17 && $iss == 4) {
							// 17.4 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 18 && $iss == 1) {
							// 18.1 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 18 && $iss == 2) {
							// 18.2 includes an index numbered i-ii.
							// Also, the last page (before the index) is a full-page ad, which counts but is not transcribed.
							$volCount = $volCount-2; // omit index pages
							//$volCount = $volCount-1; // omit ad page
							$pdfRange = array_merge(range($oldVolCount+1, $volCount), array('i', 'ii'));
							//$volCount = $volCount+1; // add ad page back in for next issue's count
						} else if ($vol == 18 && $iss == 3) {
							// 18.3 ends with a wordless back cover, which counts but is not transcribed.
							// This back cover and the front cover are details of the illustration at
							// 18.3.bennett#p133.
						} else if ($vol == 18 && $iss == 4) {
							// 18.4 ends with two ad pages, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 19 && $iss == 1) {
							// 19.1 has a non-content back cover (repetition of illustration on page 44), which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 2) {
							// 19.2 has a wordless back cover, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 3) {
							// 19.3 starts on page 93, although the previous issue ends on page 90. Who knows why.
							// 19.3 ends with a non-content page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 4) {
							// 19.4 ends with a non-content page (detail of illustration on page 130), which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 20 && $iss == 1) {
							// 20.1 ends with a non-content page (repetition of illustration on page 29), which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 20 && $iss == 2) {
							// 20.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 20 && $iss == 3) {
							// 20.3 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 20 && $iss == 4) {
							// 20.4 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 21 && $iss == 1) {
							// 21.1 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 21 && $iss == 2) {
							// 21.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 21 && $iss == 3) {
							// 21.3 ends with three ad pages and a non-content page, which count but are not transcribed.
							//$volCount = $volCount-4; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+4; // add back pages back in for next issue's count
						} else if ($vol == 21 && $iss == 4) {
							// 21.4 ends with two ad pages and a blank page, which count but are not transcribed.
							//$volCount = $volCount-3; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 22 && $iss == 1) {
							// 22.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 2) {
							// 22.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 3) {
							// 22.3 ends with a wordless back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 4) {
							// 22.4 ends with an ad page and a non-content page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
							// 22.4 has an ad page in the middle (page 135, 23rd page in PDF), which counts but is not transcribed.
							//unset($pdfRange[22]);
						} else if ($vol == 23 && $iss == 1) {
							// 24.3 has a penultimate ad page, which counts but is not transcribed.
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 23 && $iss == 2) {
							// 23.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 23 && $iss == 3) {
							// 23.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 23 && $iss == 4) {
							// 23.4 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 24 && $iss == 1) {
							// 24.1 was accidentally numbered continuing from the last page of the previous volume
							// 24.1 ends with an ad page and a blank page, which count but are not transcribed.
							$oldVolCount = 216;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $pages; // reset count for next issue (24.2 is numbered as if 24.1 had been numbered correctly)
						} else if ($vol == 24 && $iss == 2) {
							// 24.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 24 && $iss == 3) {
							// 24.3 has a blank penultimate page, which counts but is not transcribed.
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 24 && $iss == 4) {
							// 24.4 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 25 && $iss == 1) {
							// 25.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 25 && $iss == 2) {
							// 25.2 ends with an ad page and a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 25 && $iss == 3) {
							// 25.3 has an ad page in the middle (page 132, 32nd page in PDF), which counts but is not transcribed.
							//unset($pdfRange[31]);
							// 25.3 ends with an ad page (page 140, 40th page in PDF), which counts but is not transcribed.
							//unset($pdfRange[39]);
						} else if ($vol == 25 && $iss == 4) {
							// 25.4 has 152-153 spread (12th page in PDF)
							// replace page 152
							$pdfRange[11] = '152-153';
							// since the count is off, add a number onto the end
							$addPage = $pdfRange[count($pdfRange)-1] + 1;
							$pdfRange[] = $addPage;
							// and also add to the volCount
							$volCount = $volCount + 1;
							// remove page 153
							unset($pdfRange[12]);
						} else if ($vol == 26 && $iss == 1) {
							// 26.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 26 && $iss == 2) {
							// 26.2 ends with an ad page and two blank pages, which count but are not transcribed.
							//$volCount = $volCount-3; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 26 && $iss == 3) {
							// 26.3 has a full-page ad on the last page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 26 && $iss == 4) {
							// 26.4 starts on page 137, although the previous issue ends on page 134.
							// 26.4 ends with an ad page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 27 && $iss == 1) {
							// 27.1 seems to lack both spreads and non-content pages
						} else if ($vol == 27 && $iss == 2) {
							// 27.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 27 && $iss == 3) {
							// 27.3 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 27 && $iss == 4) {
							// 27.4 seems to lack both spreads and non-content pages
						} else if ($vol == 28 && $iss == 1) {
							// 28.1 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 2) {
							// 28.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 3) {
							// 28.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 4) {
							// 28.4 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 29 && $iss == 1) {
							// 29.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 29 && $iss == 2) {
							// 29.2 seems to lack both spreads and non-content pages
						} else if ($vol == 29 && $iss == 3) {
							// 29.3 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 29 && $iss == 4) {
							// 29.4 seems to lack both spreads and non-content pages
						} else if ($vol == 30 && $iss == 1) {
							// 30.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 2) {
							// 30.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 3) {
							// 30.3 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 4) {
							// 30.4 seems to lack both spreads and non-content pages
						} else if ($vol == 31 && $iss == 1) {
							// 31.1 seems to lack both spreads and non-content pages
						} else if ($vol == 31 && $iss == 2) {
							// 31.2 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 31 && $iss == 3) {
							// 31.3 has a blank back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 31 && $iss == 4) {
							// 31.4 seems to lack both spreads and non-content pages
						} else if ($vol == 32 && $iss == 1) {
							// 32.1 has a blank back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 2) {
							// 32.2 starts on page 29, although the previous issue ends on page 24.
							// 32.2 has a blank back page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+4; // skip non-existent pages between last issue and this one
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 3) {
							// 32.3 starts on page 57, although the previous issue ends on page 52.
							// 32.3 has a blank back page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+4;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 4) {
							// 32.4 seems to lack both spreads and non-content pages
						} else if ($vol == 33 && $iss == 1) {
							// 33.1 ends with an ad page and then a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 33 && $iss == 2) {
							// 33.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 33 && $iss == 3) {
							// 33.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 33 && $iss == 4) {
							// 33.4 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 34 && $iss == 1) {
							// 34.1 seems to lack both spreads and non-content pages
						} else if ($vol == 34 && $iss == 2) {
							// 34.2 seems to lack both spreads and non-content pages
						} else if ($vol == 34 && $iss == 3) {
							// 34.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 34 && $iss == 4) {
							// 34.4 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 35 && $iss == 1) {
							// 35.1 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 35 && $iss == 2) {
							// 35.2 seems to lack both spreads and non-content pages
						} else if ($vol == 35 && $iss == 3) {
							// 35.3 seems to lack both spreads and non-content pages
						} else if ($vol == 35 && $iss == 4) {
							// 35.4 seems to lack both spreads and non-content pages
						} else if ($vol == 36 && $iss == 1) {
							// 36.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 2) {
							// 36.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 3) {
							// 36.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 4) {
							// 36.4 ends with an ad page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 37 && $iss == 1) {
							// 37.1 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 37 && $iss == 2) {
							// 37.2 seems to lack both spreads and non-content pages
						} else if ($vol == 37 && $iss == 3) {
							// 37.3 seems to lack both spreads and non-content pages
						} else if ($vol == 37 && $iss == 4) {
							// 37.4 seems to lack both spreads and non-content pages
						} else if ($vol == 38 && $iss == 1) {
							// 38.1 ends with a page of ads, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 2) {
							// 38.2 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 3) {
							// 38.3 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 4) {
							// 38.4 ends with a blank page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 39 && $iss == 1) {
							// 39.1 ends with a full page ad and then a blank page, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 39 && $iss == 2) {
							// 39.2 seems to lack both spreads and non-content pages
						} else if ($vol == 39 && $iss == 3) {
							// 39.3 starts on page 105, although the previous issue ends on page 103.
							// 39.3 has a back page ad, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+1;
							$volCount = $oldVolCount + $pages;
							//$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 39 && $iss == 4) {
							// 39.4 has a blank back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 40 && $iss == 1) {
							// 40.1 seems to lack both spreads and non-content pages
						} else if ($vol == 40 && $iss == 2) {
							// 40.2 seems to lack both spreads and non-content pages
						} else if ($vol == 40 && $iss == 3) {
							// 40.3 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 40 && $iss == 4) {
							// 40.4 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 41 && $iss == 1) {
							// 41.1 seems to lack both spreads and non-content pages
						} else if ($vol == 41 && $iss == 2) {
							// 41.2 seems to lack both spreads and non-content pages
						} else if ($vol == 41 && $iss == 3) {
							// 41.3 has a blank back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 41 && $iss == 4) {
							// 41.4 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 42 && $iss == 1) {
							// 42.1 seems to lack both spreads and non-content pages
						} else if ($vol == 42 && $iss == 2) {
							// 42.2 has a blank back page, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 42 && $iss == 3) {
							// 42.3 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 42 && $iss == 4) {
							// 42.4 has a full-page ad on the penultimate page, which counts but is not transcribed.
							//unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 43 && $iss == 1) {
							// 43.1 seems to lack both spreads and non-content pages
						} else if ($vol == 43 && $iss == 2) {
							// 43.2 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 43 && $iss == 3) {
							// 43.3 seems to lack both spreads and non-content pages
						} else if ($vol == 43 && $iss == 4) {
							// 43.4 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 44 && $iss == 1) {
							// 44.1 seems to lack both spreads and non-content pages
						} else if ($vol == 44 && $iss == 2) {
							// 44.2 has ads on the last two pages, which count but are not transcribed.
							//$volCount = $volCount-2; // omit back pages
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 44 && $iss == 3) {
							// 44.3 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
							//$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 44 && $iss == 4) {
							// 44.4 has a back page ad, which counts but is not transcribed.
							//$volCount = $volCount-1; // omit back page
							//$pdfRange = range($oldVolCount+1, $volCount);
						}
						
						$vol_pages[$vol][$iss]['pdf-page-range'] = $pdfRange;
						
						$x = 1;
						
						foreach($pdfRange as $pdfPage) {
							$volTwoDig = str_pad($vol, 2, '0', STR_PAD_LEFT); // sprintf('%02d', $vol);
							$pdfPageThreeDig = str_pad($pdfPage, 3, '0', STR_PAD_LEFT); // sprintf('%03d', $pdfPage);
							$id = $volTwoDig.'.'.$iss.'.'.$pdfPageThreeDig;
							
							$splitPDF = $vol.'.'.$iss.'.p'.$x.'.pdf';
							$x = $x+1;
							
							$pageInfo = array('id' => $id, 'vol' => $vol, 'iss' => $iss, 'page' => $pdfPage, 'pdf' => $vol.'.'.$iss.'.pdf', 'splitPDF' => $splitPDF, 'articles' => array());
							
							$all_pages[$id] = $pageInfo;
						}
					}
				}
			}
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 
					$fn_t['pb'] = $FullXML->xpath('//pb/@n'); // array
					
					$pbs = array();
					foreach($fn_t['pb'] as $pb) {
						if (strpos($pb, '-') === false) {
							$pbs[] = $pb;
						} else if(in_array($pb.'', $vol_pages[$fn_t['volNum']][$fn_t['issueNum']]['pdf-page-range'], TRUE)) {
							$pbs[] = $pb;
						} else {
							$pbMinMax = explode('-', $pb);
							$pbs = array_merge($pbs, range($pbMinMax[0], $pbMinMax[1]));
						}
					}
					
					$volTwoDig = str_pad($fn_t['volNum'], 2, '0', STR_PAD_LEFT); // sprintf('%02d', $fn_t['volNum']);
					
					foreach($pbs as $p) {
						$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT); // sprintf('%03d', $p);
						$id = $volTwoDig.'.'.$fn_t['issueNum'].'.'.$pThreeDig;

						if(isset($all_pages[$id])) {
							// nothing
						} else {
							$all_pages[$id] = array('id' => $id, 'vol' => $fn_t['volNum'], 'iss' => $fn_t['issueNum'], 'page' => $p, 'pdf' => '', 'splitPDF' => '', 'articles' => array());
						}

						$all_pages[$id]['articles'][] = $fn_t['file'];
					}
				}
			}

			// only do usort if there are "no PDF!" messages; if all page numbers come from the PDF, they are in order already
			// usort($all_pages, 'page_cmp');
			
			print '<table>';
			print '<tr><td>ID</td><td>PDF</td><td>SPLIT-PDF</td><td>RENAMED-PDF</td><td>VOL</td><td>ISS</td><td>PAGE</td><td>ARTICLES</td></tr>';
			foreach($all_pages as $arr) {
				$articles = '';
				if(count($arr['articles']) > 0) {
					$art_arr = array();
					foreach($arr['articles'] as $art) {
						$art_arr[] = '<a href="/bq/'.$art.'#p'.$arr['page'].'" target="_blank">'.$art.'</a>';
					}
					$articles = implode (', ', $art_arr);					
				} else {
					$articles = '<span style="color:red;">NO ARTICLES!</span>';
				}
				if($arr['pdf'] == '') {
					$arr['pdf'] = '<span style="color:red;">NO PDF!</span>';
				} else {
					$arr['pdf'] = '<a href="/bq/pdfs/'.$arr['pdf'].'" target="_blank">'.$arr['pdf'].'</a>';
				}
				
				$newPDF = '';
				if($arr['splitPDF'] == '') {
					$arr['splitPDF'] = '<span style="color:red;">NO PDF!</span>';
				} else if (in_array($arr['splitPDF'], $vol_pages[$arr['vol']][$arr['iss']])) {
					$newPDF = $arr['id'].'.pdf';
					copyFile($arr['splitPDF'], $newPDF, $arr['vol'].'.'.$arr['iss']);
					$newPDF = '<a href="/bq-tools/bq-xmltransform/pdf-rename/'.$arr['vol'].'.'.$arr['iss'].'/'.$newPDF.'" target="_blank">'.$newPDF.'</a>';
					$arr['splitPDF'] = '<a href="/bq-tools/bq-xmltransform/pdf-split/'.$arr['splitPDF'].'" target="_blank">'.$arr['splitPDF'].'</a>';
				} else {
					$val = $arr['splitPDF'];
					$arr['splitPDF'] = '<span style="color:red;">PDF name error!</span>';
					//$arr['splitPDF'] .= $nl;
					//$arr['splitPDF'] .= "\$arr['splitPDF'] = ".$val.$nl;
					//$arr['splitPDF'] .= "\$vol_pages[".$arr['vol']."][".$arr['iss']."] = ".implode(',',$vol_pages[$arr['vol']][$arr['iss']]);
				}
				print '<tr><td>'.$arr['id'].'</td><td>'.$arr['pdf'].'</td><td>'.$arr['splitPDF'].'</td><td>'.$newPDF.'</td><td>'.$arr['vol'].'</td><td>'.$arr['iss'].'</td><td>'.$arr['page'].'</td><td>'.$articles.'</td></tr>';
			}
			print '</table>';
			
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

