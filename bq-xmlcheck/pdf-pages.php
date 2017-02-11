<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
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
	
	/*
	[To refresh the following data, use the following commands in Terminal:]
	cd ../../../Applications/MAMP/htdocs/bq/pdfs
	mdls -name kMDItemFSName -name kMDItemNumberOfPages  ./*.pdf | cut -d= -f 2 | paste - -
	[then copy and paste the results.]
	*/
	$pdf_pages_str = ' "1.1.pdf"	 10
 "1.2.pdf"	 14
 "1.3.pdf"	 18
 "1.4.pdf"	 12
 "10.1.pdf"	 40
 "10.2.pdf"	 24
 "10.3.pdf"	 32
 "10.4.pdf"	 43
 "11.1.pdf"	 66
 "11.2.pdf"	 64
 "11.3.pdf"	 76
 "11.4.pdf"	 87
 "12.1.pdf"	 76
 "12.2.pdf"	 84
 "12.3.pdf"	 60
 "12.4.pdf"	 55
 "13.1.pdf"	 62
 "13.2.pdf"	 52
 "13.3.pdf"	 47
 "13.4.pdf"	 46
 "14.1.pdf"	 42
 "14.2.pdf"	 71
 "14.3.pdf"	 64
 "14.4.pdf"	 56
 "15.1.pdf"	 60
 "15.2.pdf"	 46
 "15.3.pdf"	 48
 "15.4.pdf"	 48
 "16.1.pdf"	 68
 "16.2.pdf"	 76
 "16.3.pdf"	 45
 "16.4.pdf"	 52
 "17.1.pdf"	 40
 "17.2.pdf"	 40
 "17.3.pdf"	 40
 "17.4.pdf"	 56
 "18.1.pdf"	 64
 "18.2.pdf"	 66
 "18.3.pdf"	 64
 "18.4.pdf"	 48
 "19.1.pdf"	 52
 "19.2.pdf"	 38
 "19.3.pdf"	 32
 "19.4.pdf"	 32
 "2.1.pdf"	 14
 "2.2.pdf"	 20
 "2.3.pdf"	 24
 "2.4.pdf"	 16
 "2.4b.pdf"	 32
 "20.1.pdf"	 32
 "20.2.pdf"	 40
 "20.3.pdf"	 40
 "20.4.pdf"	 48
 "21.1.pdf"	 48
 "21.2.pdf"	 32
 "21.2b.pdf"	 32
 "21.3.pdf"	 48
 "21.4.pdf"	 48
 "22.1.pdf"	 32
 "22.2.pdf"	 44
 "22.3.pdf"	 36
 "22.4.pdf"	 36
 "23.1.pdf"	 44
 "23.2.pdf"	 72
 "23.3.pdf"	 56
 "23.4.pdf"	 44
 "23.4a.pdf"	 44
 "24.1.pdf"	 48
 "24.2.pdf"	 28
 "24.3.pdf"	 36
 "24.4.pdf"	 48
 "25.1.pdf"	 60
 "25.2.pdf"	 40
 "25.3.pdf"	 40
 "25.4.pdf"	 35
 "26.1.pdf"	 36
 "26.2.pdf"	 36
 "26.3.pdf"	 62
 "26.3a.pdf"	 62
 "26.4.pdf"	 36
 "27.1.pdf"	 32
 "27.2.pdf"	 32
 "27.3.pdf"	 36
 "27.4.pdf"	 32
 "28.1.pdf"	 40
 "28.2.pdf"	 40
 "28.3.pdf"	 36
 "28.4.pdf"	 74
 "29.1.pdf"	 36
 "29.2.pdf"	 36
 "29.3.pdf"	 32
 "29.4.pdf"	 64
 "3.1.pdf"	 20
 "3.2.pdf"	 24
 "3.3.pdf"	 28
 "3.4.pdf"	 38
 "30.1.pdf"	 32
 "30.2.pdf"	 32
 "30.3.pdf"	 32
 "30.4.pdf"	 56
 "31.1.pdf"	 40
 "31.2.pdf"	 32
 "31.3.pdf"	 32
 "31.4.pdf"	 72
 "32.1.pdf"	 24
 "32.2.pdf"	 24
 "32.3.pdf"	 32
 "32.4.pdf"	 64
 "33.1.pdf"	 32
 "33.2.pdf"	 32
 "33.3.pdf"	 32
 "33.4.pdf"	 72
 "34.1.pdf"	 32
 "34.2.pdf"	 32
 "34.3.pdf"	 32
 "34.4.pdf"	 64
 "35.1.pdf"	 32
 "35.2.pdf"	 32
 "35.3.pdf"	 40
 "35.4.pdf"	 32
 "36.1.pdf"	 40
 "36.2.pdf"	 32
 "36.3.pdf"	 40
 "36.4.pdf"	 40
 "37.1.pdf"	 40
 "37.2.pdf"	 40
 "37.3.pdf"	 32
 "37.4.pdf"	 40
 "38.1.pdf"	 48
 "38.2.pdf"	 40
 "38.3.pdf"	 32
 "38.4.pdf"	 40
 "39.1.pdf"	 56
 "39.2.pdf"	 47
 "39.3.pdf"	 40
 "39.4.pdf"	 48
 "4.1.pdf"	 30
 "4.2.pdf"	 32
 "4.3.pdf"	 48
 "4.4.pdf"	 44
 "40.1.pdf"	 48
 "40.2.pdf"	 32
 "40.3.pdf"	 32
 "40.4.pdf"	 40
 "41.1.pdf"	 48
 "41.2.pdf"	 48
 "41.3.pdf"	 40
 "41.4.pdf"	 32
 "42.1.pdf"	 48
 "42.2.pdf"	 32
 "42.3.pdf"	 32
 "42.4.pdf"	 48
 "43.1.pdf"	 48
 "43.2.pdf"	 32
 "43.3.pdf"	 32
 "43.4.pdf"	 40
 "44.1.pdf"	 48
 "44.2.pdf"	 32
 "44.3.pdf"	 32
 "44.4.pdf"	 32
 "45.1.bentley.pdf"	 33
 "45.1.rowland.pdf"	 2
 "45.1.simpson.pdf"	 2
 "45.2.essick.pdf"	 5
 "45.2.gourlay.pdf"	 2
 "45.2.michael.pdf"	 7
 "45.2.paley.pdf"	 16
 "45.3.connolly.pdf"	 2
 "45.3.freeman.pdf"	 2
 "45.3.gourlay.pdf"	 3
 "45.3.hilton.pdf"	 3
 "45.3.hobson.pdf"	 3
 "45.3.rothenberg.pdf"	 3
 "45.3.silverstein.pdf"	 1
 "45.3.whitehead.pdf"	 15
 "45.4.essick.pdf"	 36
 "45.4.miner.pdf"	 1
 "45.4.online.pdf"	 1
 "45.4.whitehead.pdf"	 2
 "46.1.bentley.pdf"	 43
 "46.1.borkowska.pdf"	 8
 "46.1.gourlay.pdf"	 3
 "46.1.scott.pdf"	 3
 "46.2.bentley.pdf"	 2
 "46.2.gourlay.pdf"	 3
 "46.2.shiff.pdf"	 28
 "46.2.yoder.pdf"	 3
 "46.3.crosby.pdf"	 3
 "46.3.eron.pdf"	 13
 "46.3.read.pdf"	 2
 "46.3.ullrich.pdf"	 9
 "46.3.wittreich.pdf"	 2
 "46.4.bentley.pdf"	 10
 "46.4.essick.pdf"	 48
 "46.4.luczynska.pdf"	 14
 "46.4.whitehead.pdf"	 2
 "47.1.bentley.pdf"	 68
 "47.1.fosso.pdf"	 4
 "47.1.freedman.pdf"	 2
 "47.1.mertz.pdf"	 3
 "47.1.serdechnaya.pdf"	 5
 "47.1.serdechnayasongs.pdf"	 2
 "47.2.butlin.pdf"	 2
 "47.2.ferreira.pdf"	 4
 "47.2.freedman.pdf"	 13
 "47.2.mertz.pdf"	 3
 "47.2.roberts.pdf"	 23
 "47.2.yoder.pdf"	 3
 "47.3.crosby.pdf"	 8
 "47.3.graver.pdf"	 2
 "47.3.lussier.pdf"	 2
 "47.3.ripley.pdf"	 3
 "47.3.shiff.pdf"	 24
 "47.4.connolly.pdf"	 3
 "47.4.essick.pdf"	 40
 "47.4.johnson.pdf"	 5
 "47.4.miner.pdf"	 3
 "47.4.scott.pdf"	 4
 "48.1.checklist.pdf"	 36
 "48.1.inscriptions.pdf"	 34
 "48.2.bentley.pdf"	 1
 "48.2.borkowska.pdf"	 12
 "48.2.erle.pdf"	 3
 "48.2.paley.pdf"	 6
 "48.2.rosso.pdf"	 4
 "48.3.bentley.pdf"	 4
 "48.3.erle.pdf"	 5
 "48.3.lindberg.pdf"	 3
 "48.3.moyer.pdf"	 14
 "48.3.paley.pdf"	 4
 "48.4.essick.pdf"	 35
 "48.4.mertz.pdf"	 2
 "48.4.miner.pdf"	 9
 "48.4.wittreich.pdf"	 7
 "49.1.bentley.pdf"	 39
 "49.1.gourlay.pdf"	 4
 "49.1.knowles.pdf"	 7
 "49.1.newman.pdf"	 3
 "49.1.rovira.pdf"	 3
 "5.1-2.pdf"	 160
 "5.3.pdf"	 60
 "5.4.pdf"	 40
 "6.1.pdf"	 36
 "6.2.pdf"	 22
 "6.3.pdf"	 24
 "6.4.pdf"	 24
 "7.1.pdf"	 24
 "7.2.pdf"	 24
 "7.3.pdf"	 24
 "7.4.pdf"	 28
 "8.1-2.pdf"	 44
 "8.3.pdf"	 56
 "8.4.pdf"	 60
 "9.1.pdf"	 30
 "9.2.pdf"	 24
 "9.2b.pdf"	 12
 "9.3.pdf"	 32
 "9.4.pdf"	 52';
 	
 	$pdf_pages_str = str_replace(' "', '', $pdf_pages_str);
	$pdf_pages_str = str_replace('	 ', '', $pdf_pages_str);
	
	//print '<pre>'.$pdf_pages_str.'</pre>';
	
	$pdf_pages_lines = preg_split('/[\n\r]{1,2}/', $pdf_pages_str);
	
	$vol_pages = array();
	
	foreach($pdf_pages_lines as $line) {
		$parts = explode('"', $line);
		$pdf = $parts[0];
		$pdfParts = explode('.', $pdf);
		$vol = $pdfParts[0];
		$iss = $pdfParts[1];
		$pages = $parts[1];
		if($vol<45) { // exclude HTML issues, which have PDFs for each article
			if(isset($vol_pages[$vol])) {
				// nothing
			} else {
				$vol_pages[$vol] = array();
				$vol_pages[$vol]['vol'] = $vol;
			}
			$vol_pages[$vol][$iss] = array();
			$vol_pages[$vol][$iss]['pdf-page-count'] = $pages;
		}
	}
	
	unset($vol_pages['23']['4a']); // 23.4a.pdf is a duplicate of 23.4.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	unset($vol_pages['21']['2b']); // 21.2b.pdf is a duplicate of 21.2.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	unset($vol_pages['26']['3a']); // 26.3a.pdf is a duplicate of 26.3.pdf (UNLIKE 2.4b and 9.2b which are distinct supplements)
	
	
	usort($vol_pages, 'vol_cmp');

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
							$pdfRange = range(1, ($pages-1));
						} else if($vol == 1) {
							// 1.2, 1.3, and 1.4 all restart at page 1
							$pdfRange = range(1, $pages);
						} else if ($vol == 2 && $iss === '4b') {
							// 2.4b begins with I-III, then 1
							$pdfRange = array_merge(array('I','II','III'), range(1, ($pages-3)));
						} else if ($vol == 3 && $iss == 2) {
							// 3.1 ends on page 20, but 3.2 begins on page 22 (not 21)
							$oldVolCount = $oldVolCount+1;
							$volCount = $volCount+1;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 3 && $iss == 3) {
							// 3.3 ends on a blank (unnumbered) page
							$volCount = $volCount-1;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 4 && $iss == 3) {
							// 4.3 ends on two blank (unnumbered) pages
							$volCount = $volCount-2;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 6 && $iss == 2) {
							// 6.2 has a foldout
							$volCount = $volCount-2;
							$pdfRange = array_merge(array('37b', '37c'), range($oldVolCount+1, $volCount));
						} else if ($vol == 9 && $iss == 1) {
							// 9.1 ends on page 28, followed by a blank page and then a wordless back cover
							$pdfRange = range(1, $pages-2);
						} else if ($vol == 9 && $iss.'' == '2') {
							// 9.2 begins on page 33, for some reason
							$volCount = 32 + $pages;
							$pdfRange = range(33, $volCount);
						} else if ($vol == 9 && $iss === '2b') {
							// 9.2b starts with i, then 1
							$pdfRange = array_merge(array('i'), range(1, ($pages-1)));
							$volCount = $oldVolCount; // 9.3 starts where 9.2 left off
						} else if ($vol == 11 && $iss == 2) {
							// 11.1 ends on page 66, but 11.2 begins on page 69 (not 67)
							$oldVolCount = $oldVolCount+2;
							$volCount = $volCount+2;
							$pdfRange = range($oldVolCount+1, $volCount);
						// } else if ($vol == 11 && $iss == 3) {
							// Leave it alone.
							// 11.3 would normally be two PDF pages short, since
							// 158-159 are scanned as a single PDF page, and
							// 170-171 are scanned as a single PDF page.
							// But the content ends on page 208, and is followed
							// by two non-content pages (an ad and a wordless back cover),
							// cancelling out the two double-page scans.
						} else if ($vol == 11 && $iss == 4) {
							// 11.4 begins 213; who even knows how this screwy volume works
							$volCount = 212 + $pages;
							$pdfRange = range(213, $volCount);
						} else if ($vol == 13 && $iss == 1) {
							// 13.1 ends on two non-BQ pages (an ad insert?)
							$volCount = $volCount-2;
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 13 && $iss == 3) {
							// 13.3 has a 158-159 spread
							$volCount = $volCount+1;
							$pdfRange = range($oldVolCount+1, $volCount);
						// } else if ($vol == 13 && $iss == 4) {
							// Leave it alone.
							// 13.4 has a 166-167 spread and a 174-175 spread (need +2),
							// but the last two pages are an ad (for an exhibition)
							// and a wordless back cover (need -2).
						} else if ($vol == 14 && $iss == 1) {
							// 14.1 includes an index numbered i-ii
							$volCount = $volCount-2;
							$pdfRange = array_merge(array('i', 'ii'), range($oldVolCount+1, $volCount));
						} else if ($vol == 15 && $iss == 2) {
							// 15.2 includes an index numbered i-ii
							$volCount = $volCount-2;
							$pdfRange = array_merge(range($oldVolCount+1, $oldVolCount+2), array('i', 'ii'), range($oldVolCount+3, $volCount));
						} else if ($vol == 16 && $iss == 3) {
							// The last three regular (unnumbered) print pages (186-188) count, but are not transcribed.
							// They consist of two PDF pages (a 186-187 spread and a blank 188).
							// (The 186-187 spread is a simple image motif that does not seem to be an illustration.)
							// These should count so that the next issue begins at 189.
							// The final two irregular pages are the index, numbered i-ii in the transcription.
							// These do not count towards the start page of the next issue.
							// FOR MATCHING THIS ISSUE'S TRANSCRIPTION:
							// Two index pages do not count (-2), but i-ii is added to the page range.
							// The 186-187 page spread and blank 188 are not transcribed (-2).
							// Total -4.
							// FOR MATCHING THE PAGE COUNT OF THE NEXT ISSUE:
							// Two index pages do not count (-2), but the 186-187 spread counts for two pages (+1).
							// Total -1 (+3 compared to the -4 total).
							$volCount = $volCount-4;
							$pdfRange = array_merge(array('i', 'ii'), range($oldVolCount+1, $volCount));
							$volCount = $volCount+3;
						} else if ($vol == 18 && $iss == 2) {
							// 18.2 includes an index numbered i-ii.
							// Also, the last page is a full-page ad, which counts but is not transcribed.
							$volCount = $volCount-3; // omit index and ad pages
							$pdfRange = array_merge(array('i', 'ii'), range($oldVolCount+1, $volCount));
							$volCount = $volCount+1; // add ad page back in for next issue's count
						} else if ($vol == 19 && $iss == 1) {
							// 19.1 has a non-content back cover (repetition of illustration on page 44), which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 2) {
							// 19.2 has a wordless back cover, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 3) {
							// 19.3 starts on page 93, although the previous issue ends on page 90. Who knows why.
							// 19.3 ends with a non-content page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 19 && $iss == 4) {
							// 19.4 ends with a non-content page (detail of illustration on page 130), which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 20 && $iss == 1) {
							// 20.1 ends with a non-content page (repetition of illustration on page 29), which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 20 && $iss == 2) {
							// 20.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 20 && $iss == 3) {
							// 20.3 ends with an ad page and a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 20 && $iss == 4) {
							// 20.4 ends with an ad page and a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 21 && $iss == 1) {
							// 21.1 ends with an ad page and a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 21 && $iss == 2) {
							// 21.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 21 && $iss == 3) {
							// 21.3 ends with three ad pages and a non-content page, which count but are not transcribed.
							$volCount = $volCount-4; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+4; // add back pages back in for next issue's count
						} else if ($vol == 21 && $iss == 4) {
							// 21.4 ends with two ad pages and a blank page, which count but are not transcribed.
							$volCount = $volCount-3; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 22 && $iss == 1) {
							// 22.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 2) {
							// 22.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 3) {
							// 22.3 ends with a wordless back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 22 && $iss == 4) {
							// 22.4 ends with an ad page and a non-content page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 23 && $iss == 1) {
							// 24.3 has a penultimate ad page, which counts but is not transcribed.
							unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 23 && $iss == 2) {
							// 23.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 23 && $iss == 3) {
							// 23.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 23 && $iss == 4) {
							// 23.4 ends with an ad page and a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 24 && $iss == 1) {
							// 24.1 was accidentally numbered continuing from the last page of the previous volume
							// 24.1 ends with an ad page and a blank page, which count but are not transcribed.
							$oldVolCount = 216;
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $pages; // reset count for next issue (24.2 is numbered as if 24.1 had been numbered correctly)
						} else if ($vol == 24 && $iss == 2) {
							// 24.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 24 && $iss == 3) {
							// 24.3 has a blank penultimate page, which counts but is not transcribed.
							unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 24 && $iss == 4) {
							// 24.4 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 25 && $iss == 1) {
							// 25.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 25 && $iss == 2) {
							// 25.2 ends with an ad page and a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 25 && $iss == 3) {
							// 25.3 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 26 && $iss == 1) {
							// 26.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 26 && $iss == 2) {
							// 26.2 ends with an ad page and two blank pages, which count but are not transcribed.
							$volCount = $volCount-3; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+3; // add back pages back in for next issue's count
						} else if ($vol == 26 && $iss == 3) {
							// 26.3 has a full-page ad on the last page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 26 && $iss == 4) {
							// 26.4 starts on page 137, although the previous issue ends on page 134.
							// 26.4 ends with an ad page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+2;
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 27 && $iss == 2) {
							// 27.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 27 && $iss == 3) {
							// 27.3 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 1) {
							// 28.1 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 2) {
							// 28.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 3) {
							// 28.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 28 && $iss == 4) {
							// 28.4 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 29 && $iss == 1) {
							// 29.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 29 && $iss == 3) {
							// 29.3 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 1) {
							// 30.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 2) {
							// 30.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 30 && $iss == 3) {
							// 30.3 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 31 && $iss == 2) {
							// 31.2 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 31 && $iss == 3) {
							// 31.3 has a blank back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 1) {
							// 32.1 has a blank back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 2) {
							// 32.2 starts on page 29, although the previous issue ends on page 24.
							// 32.2 has a blank back page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+4; // skip non-existent pages between last issue and this one
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 32 && $iss == 3) {
							// 32.3 starts on page 57, although the previous issue ends on page 52.
							// 32.3 has a blank back page, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+4;
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 33 && $iss == 1) {
							// 33.1 ends with an ad page and then a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 33 && $iss == 2) {
							// 33.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 33 && $iss == 3) {
							// 33.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 33 && $iss == 4) {
							// 33.4 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 34 && $iss == 3) {
							// 34.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 34 && $iss == 4) {
							// 34.4 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 35 && $iss == 1) {
							// 35.1 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 1) {
							// 36.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 2) {
							// 36.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 3) {
							// 36.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 36 && $iss == 4) {
							// 36.4 ends with an ad page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 37 && $iss == 1) {
							// 37.1 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 1) {
							// 38.1 ends with a page of ads, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 2) {
							// 38.2 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 3) {
							// 38.3 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 38 && $iss == 4) {
							// 38.4 ends with a blank page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 39 && $iss == 1) {
							// 39.1 ends with a full page ad and then a blank page, which count but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 39 && $iss == 3) {
							// 39.3 starts on page 105, although the previous issue ends on page 103.
							// 39.3 has a back page ad, which counts but is not transcribed.
							$oldVolCount = $oldVolCount+1;
							$volCount = $oldVolCount + $pages;
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);							
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 39 && $iss == 4) {
							// 39.4 has a blank back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 40 && $iss == 3) {
							// 40.3 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 40 && $iss == 4) {
							// 40.4 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 41 && $iss == 3) {
							// 41.3 has a blank back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 41 && $iss == 4) {
							// 41.4 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 42 && $iss == 2) {
							// 42.2 has a blank back page, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 42 && $iss == 3) {
							// 42.3 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 42 && $iss == 4) {
							// 42.4 has a full-page ad on the penultimate page, which counts but is not transcribed.
							unset($pdfRange[count($pdfRange)-2]); // $pdfRange[count($pdfRange)-1] would be the last page
						} else if ($vol == 43 && $iss == 2) {
							// 43.2 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 43 && $iss == 4) {
							// 43.4 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						} else if ($vol == 44 && $iss == 2) {
							// 44.2 has ads on the last two pages, which counts but are not transcribed.
							$volCount = $volCount-2; // omit back pages
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+2; // add back pages back in for next issue's count
						} else if ($vol == 44 && $iss == 3) {
							// 44.3 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
							$volCount = $volCount+1; // add back page back in for next issue's count
						} else if ($vol == 44 && $iss == 4) {
							// 44.4 has a back page ad, which counts but is not transcribed.
							$volCount = $volCount-1; // omit back page
							$pdfRange = range($oldVolCount+1, $volCount);
						}
						
						$vol_pages[$vol][$iss]['pdf-page-range'] = $pdfRange;
						
						foreach($pdfRange as $pdfPage) {
							$volTwoDig = str_pad($vol, 2, '0', STR_PAD_LEFT); // sprintf('%02d', $vol);
							$pdfPageThreeDig = str_pad($pdfPage, 3, '0', STR_PAD_LEFT); // sprintf('%03d', $pdfPage);
							$id = $volTwoDig.'.'.$iss.'.'.$pdfPageThreeDig;
							$pageInfo = array('id' => $id, 'vol' => $vol, 'iss' => $iss, 'page' => $pdfPage, 'pdf' => $vol.'.'.$iss.'.pdf', 'articles' => array());
							
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
							$all_pages[$id] = array('id' => $id, 'vol' => $fn_t['volNum'], 'iss' => $fn_t['issueNum'], 'page' => $p, 'pdf' => '', 'articles' => array());
						}

						$all_pages[$id]['articles'][] = $fn_t['file'];
					}
				}
			}

			usort($all_pages, 'page_cmp');
			
			print '<table>';
			print '<tr><td>ID</td><td>PDF</td><td>VOL</td><td>ISS</td><td>PAGE</td><td>ARTICLES</td></tr>';
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
				print '<tr><td>'.$arr['id'].'</td><td>'.$arr['pdf'].'</td><td>'.$arr['vol'].'</td><td>'.$arr['iss'].'</td><td>'.$arr['page'].'</td><td>'.$articles.'</td></tr>';
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

