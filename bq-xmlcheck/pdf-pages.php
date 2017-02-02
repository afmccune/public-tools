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
	
	$vol_pages = array();

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
 "5.1-2.pdf"	 158
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
				
			$docsXml = array();
			$issueSections = array();
			
			
			print '<table>';
			foreach($vol_pages as $arr) {
				$vol = $arr['vol'];
				foreach($arr as $iss => $items) {
					if($iss != 'vol') {
						$pdf = $vol.'.'.$iss.'.pdf';
						$pages = $items['pdf-page-count'];
						print '<tr><td><a href="/bq/pdfs/'.$pdf.'" target="_blank">'.$pdf.'</a></td><td>'.$vol.'</td><td>'.$pages.'</td></tr>';
					}
				}
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

