<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('../include.php');
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
	cd ../../../Applications/MAMP/htdocs/public-tools/xmltransform/pdf-large
	mdls -name kMDItemFSName -name kMDItemNumberOfPages  ./*.pdf | cut -d= -f 2 | paste - -
	[then copy and paste the results.]
	*/
	$lg_pdf_pages_str = ' "001-01.pdf"	 10
 "001-02.pdf"	 14
 "002-01.pdf"	 14
 "002-02.pdf"	 20
 "003-01.pdf"	 20';

	/*
	[To refresh the following data, use the following commands in Terminal,]
	[typing the value of $pdfIssuesDirShort instead of the variable name in brackets:]
	cd ../../../Applications/MAMP/htdocs/[$pdfIssuesDirShort]
	mdls -name kMDItemFSName -name kMDItemNumberOfPages  ./*.pdf | cut -d= -f 2 | paste - -
	[then copy and paste the results.]
	*/
	$pdf_pages_str = ' "1.1.pdf"	 10
 "1.2.pdf"	 14
 "2.1.pdf"	 14
 "2.2.pdf"	 20
 "3.1.pdf"	 20';
 	
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

