<!DOCTYPE html>
<html>
	<?php
	require('../include.php');

	$pt = '';
	$nl = '
';
	$style = '
body {
	font: "Times New Roman", Times, Georgia, serif;
}
div#logo {
	padding: 60px 0 15px 0;
}
div#logo img {
}
div#main {
	width: 500px;
	float: left;
	margin: 10px 30px 10px 10px;
}
h4#type {
    text-transform: uppercase;
    letter-spacing: 10px;
    color: #555555;
    font-weight: normal;
}
h2#article-title {
    /*font-variant: small-caps;*/
    font-weight: normal;
}
h3#author {
    font-weight: normal;
}
p {
}
div#cover {
	width: 160px;
	float: left;
	margin: 10px 10px 10px 10px;
}
div#cover img {
}
';
	
	require('include/functions.php');
	require('include/head.php');
	
	function intval_cmp($a, $b)
	{
		if (intval($a) == intval($b)) {
			return 0;
		}
		return (intval($a) < intval($b)) ? -1 : 1;
	}
	
	function range_string_nonarabic($csv) {
		if(preg_match('/[-a-zA-Z]/',$csv)) {
			$csv = str_replace('37,37b,37c', '37_37b-37c', $csv);
			$one_list = explode(',', $csv);
			$alpha = array();
			$num = array();
			foreach($one_list as $p) {
				if(preg_match('/[a-zA-Z]/',$p)) {
					$alpha[] = $p;
				} else if(strpos($p, '-') === false) {
					$num[] = $p;
				} else {
					$pbMinMax = explode('-', $p);
					$range = range($pbMinMax[0], $pbMinMax[1]);
					foreach($range as $rp) {
						$num[] = $rp;
					}
				}
			}
			$alpha_range = (count($alpha) > 0) ? implode(',', $alpha) : '';
			$alpha_range = str_replace('i,ii,iii', 'i-iii', $alpha_range);
			$alpha_range = str_replace('i,ii', 'i-ii', $alpha_range);
			$num_range = (count($num) > 0) ? range_string(implode(',',$num)) : '';
			$num_range = str_replace(' ', '', $num_range);
			$one_range = ($num_range == '' || $alpha_range == '') ? $alpha_range.$num_range : $alpha_range.','.$num_range;
			$one_list_new = explode(',', $one_range);
			usort($one_list_new, intval_cmp);
		
			$range_string = implode(', ', $one_list_new);
			$range_string = str_replace('37_37b-37c', '37, 37b-37c', $range_string);
			
			return $range_string;
		} else {
			return range_string($csv);
		}
	}
	
	function range_string($csv)
	{
		// split string using the , character
		$number_array = array_map('intval', explode(',', $csv));
		sort($number_array);

		// Loop through array and build range string
		$previous_number = intval(array_shift($number_array)); 
		$range = false;
		$range_string = "" . $previous_number; 
		foreach ($number_array as $number) {
		  $number = intval($number);
		  if ($number == $previous_number + 1) {
			$range = true;
		  }
		  else {
			if ($range) {
			  $range_string .= "-$previous_number";
			  $range = false;
			}
			$range_string .= ", $number";
		  }
		  $previous_number = $number;
		}
		if ($range) {
		  $range_string .= "-$previous_number";
		}
			
		return $range_string;
	}
	
	function issueCover($volIss) {
		$tocXML = simplexml_load_file($dir.$volIss.'.toc.xml'); 
		$XMLimg = $tocXML->xpath('//div1[@id="cover"]/figure/@n');
		return $XMLimg[0];
	}
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>PDF title pages</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			$cmd = '#!/bin/bash'.$nl.$nl;
			
			foreach (new DirectoryIterator($dir) as $fn) {
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

					$FullXML = simplexml_load_file($dir.$fn_t['fn']); 
					$fn_t['volume'] = $fn_t['volNum'];
					$fn_t['issue'] = $fn_t['issueNum'];
					$XMLdate = $FullXML->xpath('//editionStmt/edition');
					$fn_t['date'] = $XMLdate[0];
					$XMLyear = $FullXML->xpath('//teiHeader/fileDesc/publicationStmt/date');
					$fn_t['year'] = $XMLyear[0];
					$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
					$fn_t['title'] = $XMLtitle[0];
					$fn_t['title'] = preg_replace('/[ \r\n]{1,3}/', ' ', $fn_t['title']);
					$fn_t['title'] = html_entity_decode( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
					//$fn_t['title'] = str_replace('&', 'and', $fn_t['title']);
					$fn_t['title'] = htmlentities( $fn_t['title'], ENT_QUOTES, "UTF-8" ); 
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					if($fn_t['type'] == 'toc') {
						$fn_t['type'] = 'contents';
						$fn_t['title'] = '';
					} else if($fn_t['type'] == 'minute') {
						$fn_t['type'] = 'minute<br/>particular';
					}
					$XMLauthors = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
					$fn_t['author'] = implode(', ', $XMLauthors);
					$fn_t['author'] = htmlentities( $fn_t['author'], ENT_QUOTES, "UTF-8" ); 
					$XMLpbs = $FullXML->xpath('//pb/@n'); // array
					$fn_t['pb'] = implode(',', $XMLpbs);
					$fn_t['pageRange'] = range_string_nonarabic($fn_t['pb']);
					$fn_t['pAbbr'] = (count($XMLpbs) > 1) ? 'pp.' : 'p.';
					$fn_t['cover'] = issueCover($fn_t['volIss']).'.thumb.png';
					
					// need to alter page range to handle non-numeric pages

					$fn_t['HTML']  = '<html>'.$nl;
					$fn_t['HTML'] .= '	<head>'.$nl;
					$fn_t['HTML'] .= '		<title>'.$fn_t['title'].'</title>'.$nl;
					$fn_t['HTML'] .= '		<style>'.$style.'</style>'.$nl;
					$fn_t['HTML'] .= '	</head>'.$nl;
					$fn_t['HTML'] .= '	<body>'.$nl;
					$fn_t['HTML'] .= '		<div id="logo">'.$nl;
					$fn_t['HTML'] .= '			<img src="'.$logo.'''" alt="'.$archiveTitle.'"/>'.$nl;
					$fn_t['HTML'] .= '		</div>'.$nl;
					$fn_t['HTML'] .= '		<div id="main">'.$nl;
					$fn_t['HTML'] .= '		<h4 id="type">'.$fn_t['type'].'</h4>'.$nl;
					if($fn_t['title'] != '') {
					$fn_t['HTML'] .= '		<h2 id="article-title">'.$fn_t['title'].'</h2>'.$nl;
					}
					if($fn_t['author'] != '') {
					$fn_t['HTML'] .= '		<h3 id="author">'.$fn_t['author'].'</h3>'.$nl;
					}
					$fn_t['HTML'] .= '		<p>'.$archiveTitle.', ';
					$fn_t['HTML'] .= 		'Volume '.$fn_t['volume'].', ';
					$fn_t['HTML'] .= 		'Issue '.$fn_t['issue'].', ';
					$fn_t['HTML'] .= 		''.$fn_t['date'].', ';
					$fn_t['HTML'] .= 		''.$fn_t['pAbbr'].' '.$fn_t['pageRange'].'</p>'.$nl;
					$fn_t['HTML'] .= '		</div>'.$nl;
					$fn_t['HTML'] .= '		<div id="cover">'.$nl;
					$fn_t['HTML'] .= '			<img src="'.$illustrationDir.$fn_t['cover'].'" width="160"/>'.$nl;
					$fn_t['HTML'] .= '		</div>'.$nl;
					$fn_t['HTML'] .= '	</body>'.$nl;
					$fn_t['HTML'] .= '</html>'.$nl;

					$html_dir = 'pdf-title-html/';
					if (file_exists($html_dir)) {
						// okay
					} else {
						mkdir($html_dir);
					}
					
					$inputName = $html_dir.$fn_t['file'].'.title.html';
					
					file_put_contents($inputName, $fn_t['HTML']);
					
					$pdf_dir = '/Applications/MAMP/htdocs/public-tools/xmltransform/pdf-title-pdf/';
					if (file_exists($pdf_dir)) {
						// okay
					} else {
						mkdir($pdf_dir);
					}

					$outputName = $pdf_dir.$fn_t['file'].'.title.pdf';

					$cmd .= 'echo '.$fn_t['file'].$nl;
					$cmd .= 'wkhtmltopdf --dpi 350 http://localhost:8888/public-tools/xmltransform/'.$inputName.' '.$outputName.$nl;
				}
			}
			
			// Create bash file
			file_put_contents('bash/title_pdfs.sh', $cmd);
			echo '<h4>Refreshed title_pdfs.sh</h4>';
			
			// Set permissions for bash file
			$result = shell_exec('cd /Applications/MAMP/htdocs/public-tools/xmltransform/bash'.$nl.'chmod 775 title_pdfs.sh');
			
			// Instructions to run bash file from Terminal (since we can't seem to get it to run from PHP)
			echo '<h4>To convert title pages from HTML to PDF, execute the following in Terminal: <br/> /Applications/MAMP/htdocs/public-tools/xmltransform/bash/title_pdfs.sh</h4>';
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

