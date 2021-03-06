<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
		
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');
			
	function replaceInFile($keys, $values, $filename) {
		$XMLstring = file_get_contents($dir.$filename);
		$XMLstringNew = $XMLstring;
		
		$XMLstringNew = preg_replace($keys, $values, $XMLstringNew);
		
		if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
			file_put_contents('new/'.$filename, $XMLstringNew);
			echo '<h4>Converted '.$filename.'</h4>';
		} else if ($XMLstringNew == '') {
			echo '<p style="color: red;">ERROR: transformed '.$filename.' is blank.</p>';
		} else {
			echo '<p>'.$filename.': no change</p>';
		}
	}
	
	function pdfForPage($vol, $iss, $p) {
		$volTwoDig = str_pad($vol, 2, '0', STR_PAD_LEFT);
		$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT);
		
		//$toolsDir = '/Applications/MAMP/htdocs/public-tools/xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$toolsDir = '/public-tools/xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$fn = $volTwoDig.'.'.$iss.'.'.$pThreeDig.'.pdf';
		
		return $toolsDir.$fn;
	}
	

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Remove section heading if it precedes first page break</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$volCount = 0;

			$all_pages = array();
			
			
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
					$fn_t['pb'] = $FullXML->xpath('//pb/@n'); // array
					$fn_t['pbFront'] = $FullXML->xpath('//front//pb/@n'); // array
					
					if(count($fn_t['pbFront']) > 0) {
						// ignore if there are pbs in <front> (instead of <body>)
					} else {
						$XMLstring = file_get_contents($dir.$fn_t['fn']);
						
						$sp = '[ 	\r\n]{0,}';
						$patterns = array();
						$patterns[] = '@<body>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<head>'.$sp.'<title type="section">'.$sp.'[ 	\r\na-zA-Z</>="]{1,}'.$sp.'</title>'.$sp.'</head>('.$sp.')<pb @';
						$patterns[] = '@<body>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<head>'.$sp.'<title type="section">'.$sp.'[ 	\r\na-zA-Z</>="]{1,}'.$sp.'</title>'.$sp.'</head>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<pb @';
						$patterns[] = '@<body>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<head>'.$sp.'<title type="section">'.$sp.'[ 	\r\na-zA-Z</>="]{1,}'.$sp.'</title>'.$sp.'</head>('.$sp.'</div[0-9]>'.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<pb @';
						$patterns[] = '@<body>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<head>'.$sp.'<title type="section">'.$sp.'[ 	\r\na-zA-Z</>="]{1,}'.$sp.'</title>'.$sp.'</head>('.$sp.'</div[0-9]>'.$sp.')<pb @';
						$patterns[] = '@<body>('.$sp.'<div[0-9][- a-zA-Z0-9="/]{0,}>'.$sp.')<head>'.$sp.'<title type="section">'.$sp.'[ 	\r\na-zA-Z</>="]{1,}'.$sp.'</title>'.$sp.'<title type="section-subtitle">'.$sp.'[\r\n 	a-zA-Z</>="&;]{1,}'.$sp.'</title>'.$sp.'</head>('.$sp.')<pb @';
						//$patterns[] = '@[\r\n]{1,}[ 	]{0,}[\r\n]{1,}@';
						
						$rep = array();
						$rep[] = '<body>$1$2<pb ';
						$rep[] = '<body>$1$2<pb ';
						$rep[] = '<body>$1$2<pb ';
						$rep[] = '<body>$1$2<pb ';
						$rep[] = '<body>$1$2<pb ';
						//$rep[] = $nl;
						
						if(preg_match($patterns[0], $XMLstring) || preg_match($patterns[1], $XMLstring) || preg_match($patterns[2], $XMLstring) || preg_match($patterns[3], $XMLstring)) {
						//if(preg_match($patterns[0], $XMLstring)) {
							replaceInFile($patterns, $rep, $fn_t['fn']);
						
							$prev = $fn_t['pb'][0] - 1;
							$prevPdfLink = pdfForPage($fn_t['volNum'], $fn_t['issueNum'], $prev);
							print '<p>';
							print '<a href="'.$url.$fn_t['file'].'" target="_blank">OLD</a> ';
							print '<a href="/public-tools/xmltransform/pdf-merge/'.$fn_t['file'].'.pdf" target="_blank">PDF</a> ';
							print '<a href="'.$prevPdfLink.'" target="_blank">(prev page)</a> ';
							print '<a href="/public-tools/diff/trans-diff.php?file='.$fn_t['file'].'" target="_blank">DIFF</a> ';
							print '<a href="/public-tools/xmltransform/move-to-main.php?f='.$fn_t['file'].'.xml" target="_blank" style="color:red;">APPROVE</a> ';
							print '</p>';
						}
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

