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

	/*
	[To refresh the following data, use the following commands in Terminal:]
	cd Desktop/BQ
	mdls -name kMDItemFSName -name kMDItemNumberOfPages  ./*.pdf | cut -d= -f 2 | paste - -
	[then copy and paste the results.]
	*/
	$lg_pdf_pages_str = ' "001-01.pdf"	 10
 "001-02.pdf"	 14
 "001-03.pdf"	 18
 "001-04.pdf"	 12
 "002-01.pdf"	 14
 "002-02.pdf"	 20
 "002-03.pdf"	 24
 "002-04.pdf"	 16
 "002-04b.pdf"	 32
 "003-01.pdf"	 20
 "003-02.pdf"	 24
 "003-03.pdf"	 28
 "003-04.pdf"	 38
 "004-01.pdf"	 30
 "004-02.pdf"	 32
 "004-03.pdf"	 48
 "004-04.pdf"	 44
 "005-01_02.pdf"	 160
 "005-03.pdf"	 60
 "005-04.pdf"	 40
 "006-01.pdf"	 36
 "006-02.pdf"	 22
 "006-03.pdf"	 24
 "006-04.pdf"	 24
 "007-01.pdf"	 24
 "007-02.pdf"	 24
 "007-03.pdf"	 24
 "007-04.pdf"	 28
 "008-01_02.pdf"	 44
 "008-03.pdf"	 56
 "008-04.pdf"	 60
 "009-01.pdf"	 30
 "009-02.pdf"	 24
 "009-02b.pdf"	 12
 "009-03.pdf"	 32
 "009-04.pdf"	 52
 "010-01.pdf"	 40
 "010-02.pdf"	 24
 "010-03.pdf"	 32
 "010-04.pdf"	 43
 "011-01.pdf"	 66
 "011-02.pdf"	 64
 "011-03.pdf"	 76
 "011-04.pdf"	 87
 "012-01.pdf"	 76
 "012-02.pdf"	 84
 "012-03.pdf"	 60
 "012-04.pdf"	 55
 "013-01.pdf"	 62
 "013-02.pdf"	 52
 "013-03.pdf"	 47
 "013-04.pdf"	 46
 "014-01.pdf"	 42
 "014-02.pdf"	 71
 "014-03.pdf"	 64
 "014-04.pdf"	 56
 "015-01.pdf"	 60
 "015-02.pdf"	 46
 "015-03.pdf"	 48
 "015-04.pdf"	 48
 "016-01.pdf"	 68
 "016-02.pdf"	 76
 "016-03.pdf"	 45
 "016-04.pdf"	 52
 "017-01.pdf"	 40
 "017-02.pdf"	 40
 "017-03.pdf"	 40
 "017-04.pdf"	 56
 "018-01.pdf"	 64
 "018-02.pdf"	 66
 "018-03.pdf"	 64
 "018-04.pdf"	 48
 "019-01.pdf"	 52
 "019-02.pdf"	 38
 "019-03.pdf"	 32
 "019-04.pdf"	 32
 "020-01.pdf"	 32
 "020-02.pdf"	 40
 "020-03.pdf"	 40
 "020-04.pdf"	 48
 "021-01.pdf"	 48
 "021-02.pdf"	 32
 "021-03.pdf"	 48
 "021-04.pdf"	 48
 "022-01.pdf"	 32
 "022-02.pdf"	 44
 "022-03.pdf"	 36
 "022-04.pdf"	 36
 "023-01.pdf"	 44
 "023-02.pdf"	 72
 "023-03.pdf"	 56
 "023-04.pdf"	 44
 "023-04a.pdf"	 44
 "024-01.pdf"	 48
 "024-02.pdf"	 28
 "024-03.pdf"	 36
 "024-04.pdf"	 48
 "025-01.pdf"	 60
 "025-02.pdf"	 40
 "025-03.pdf"	 40
 "025-04.pdf"	 35
 "026-01.pdf"	 36
 "026-02.pdf"	 36
 "026-03.pdf"	 62
 "026-03a.pdf"	 62
 "026-04.pdf"	 36
 "027-01.pdf"	 32
 "027-02.pdf"	 32
 "027-03.pdf"	 36
 "027-04.pdf"	 32
 "028-01.pdf"	 40
 "028-02.pdf"	 40
 "028-03.pdf"	 36
 "028-04.pdf"	 74
 "029-01.pdf"	 36
 "029-02.pdf"	 36
 "029-03.pdf"	 32
 "029-04.pdf"	 64
 "030-01.pdf"	 32
 "030-02.pdf"	 32
 "030-03.pdf"	 32
 "030-04.pdf"	 56
 "031-01.pdf"	 40
 "031-02.pdf"	 32
 "031-03.pdf"	 32
 "031-04.pdf"	 72
 "032-01.pdf"	 24
 "032-02.pdf"	 24
 "032-03.pdf"	 32
 "032-04.pdf"	 64
 "033-01.pdf"	 32
 "033-02.pdf"	 32
 "033-03.pdf"	 32
 "033-04.pdf"	 72
 "034-01.pdf"	 32
 "034-02.pdf"	 32
 "034-03.pdf"	 32
 "034-04.pdf"	 64
 "035-01.pdf"	 32
 "035-02.pdf"	 32
 "035-03.pdf"	 40
 "035-04.pdf"	 32
 "036-01.pdf"	 40
 "036-02.pdf"	 32
 "036-03.pdf"	 40
 "036-04.pdf"	 40
 "037-01.pdf"	 40
 "037-02.pdf"	 40
 "037-03.pdf"	 32
 "037-04.pdf"	 40
 "038-01.pdf"	 48
 "038-02.pdf"	 40
 "038-03.pdf"	 32
 "038-04.pdf"	 40
 "039-01.pdf"	 56
 "039-02.pdf"	 47
 "039-03.pdf"	 40
 "039-04.pdf"	 48
 "040-01.pdf"	 48
 "040-02.pdf"	 32
 "040-03.pdf"	 32
 "040-04.pdf"	 40
 "041-01.pdf"	 48
 "041-02.pdf"	 48
 "041-03.pdf"	 40
 "041-04.pdf"	 32
 "042-01.pdf"	 48
 "042-02.pdf"	 32
 "042-03.pdf"	 32
 "042-04.pdf"	 48
 "043-01.pdf"	 48
 "043-02.pdf"	 32
 "043-03.pdf"	 32
 "043-04.pdf"	 40
 "044-01.pdf"	 48
 "044-02.pdf"	 32
 "044-03.pdf"	 32
 "044-04.pdf"	 32';

	/*
	[To refresh the following data, use the following commands in Terminal:]
	cd ../../../Applications/MAMP/htdocs/bq/pdfs/issues
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
	
	$pdf_pages_lines = preg_split('/[\n\r]{1,2}/', $pdf_pages_str);
	
	$vol_pages = array();
	
	foreach($pdf_pages_lines as $line) {
		$parts = explode('"', $line);
		$pdf = $parts[0];
		$pdfParts = explode('.', $pdf);
		$vol = $pdfParts[0];
		$iss = $pdfParts[1];
		$pages = $parts[1];
		if(isset($vol_pages[$vol])) {
			// nothing
		} else {
			$vol_pages[$vol] = array();
			$vol_pages[$vol]['vol'] = $vol;
		}
		$vol_pages[$vol][$iss] = array();
		$vol_pages[$vol][$iss]['pdf-page-count'] = $pages;
	}

/* *** */

 	$lg_pdf_pages_str = str_replace(' "', '', $lg_pdf_pages_str);
	$lg_pdf_pages_str = str_replace('	 ', '', $lg_pdf_pages_str);
	$lg_pdf_pages_str = str_replace('.pdf', '', $lg_pdf_pages_str);
	
	$lg_pdf_pages_lines = preg_split('/[\n\r]{1,2}/', $lg_pdf_pages_str);
	
	foreach($lg_pdf_pages_lines as $line) {
		$parts = explode('"', $line);
		$pdf = $parts[0];
		$pdfParts = explode('-0', $pdf);
		$vol = $pdfParts[0];
		$vol = ltrim($vol, '0');
		$iss = $pdfParts[1];
		$iss = str_replace('_0', '-', $iss);
		$pages = $parts[1];
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
		}
		$vol_pages[$vol][$iss]['lg-pdf-page-count'] = $pages;
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
			
			print '<table>'.$nl.'<tr><td>VOL.ISS</td><td>SM PP</td><td>LG PP</td></tr>'.$nl;
			foreach($vol_pages as $arr) {
				$vol = $arr['vol'];
				$volCount = 0;
				$pdfRange = array();
				foreach($arr as $iss => $items) {
					if($iss != 'vol') {
						$sm_pages = $items['pdf-page-count'];
						$lg_pages = $items['lg-pdf-page-count'];
						
						print '<tr><td>'.$vol.'.'.$iss.'</td>';
						if ($sm_pages != $lg_pages) {
							print '<td><span style="color:red;">'.$sm_pages.'</span></td><td><span style="color:red;">'.$lg_pages.' *</span></td>';
						} else {
							print '<td>'.$sm_pages.'</td><td>'.$lg_pages.'</td>';
						}
						print '</tr>'.$nl;
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

