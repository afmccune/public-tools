<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');
			
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
	
	function pdfForPage($vol, $iss, $p) {
		$volTwoDig = str_pad($vol, 2, '0', STR_PAD_LEFT);
		$pThreeDig = str_pad($p, 3, '0', STR_PAD_LEFT);
		
		//$dir = '/Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$dir = '/bq-tools/bq-xmltransform/pdf-rename/'.$vol.'.'.$iss.'/';
		$fn = $volTwoDig.'.'.$iss.'.'.$pThreeDig.'.pdf';
		
		return $dir.$fn;
	}
	
	$filesList = file_get_contents('lists/notes-bottom-ok.txt');

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Check for notes-only page at the end of an article</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
							
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename()) && strpos($filesList, $fn->getFilename()) === false) {
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
					$fn_t['pbHidden'] = $FullXML->xpath('//pb/@n/@rend'); // array
					$fn_t['pbHiddenFront'] = $FullXML->xpath('//front//pb/@n/@rend'); // array
					$fn_t['pbHiddenBack'] = $FullXML->xpath('//back//pb/@n/@rend'); // array
					$fn_t['notes'] = $FullXML->xpath('//note/@id'); // array (unreferenced notes have no ids, but are also rarely endnotes except in the company of notes with ids)
					
					if(count($fn_t['pbHiddenFront']) > 0) {
						// if there are hidden pbs in <front> (instead of <body>)
						print '<p>'.$fn_t['file'].': hidden pbs in &lt;front&gt; (instead of &lt;body&gt;)</p>';
					} else if(count($fn_t['pbHiddenBack']) > 0) {
						// ignore if there are hidden pbs in <back> (instead of <body>)
						print '<p>'.$fn_t['file'].': hidden pbs in &lt;back&gt; (instead of &lt;body&gt;)</p>';
					} else {
						$next = $fn_t['pb'][count($fn_t['pb'])-1] + 1;
						$volTwoDig = str_pad($fn_t['volNum'], 2, '0', STR_PAD_LEFT);
					
						if (count($fn_t['notes']) > 0 && count($fn_t['pbHidden']) < 1) {
							replaceInFile('([	 ]{0,})</body>', '	<pb id="'.$volTwoDig.'-'.$next.'" n="'.$next.'" rend="hidden"/>'.$nl.'$1</body>', $fn_t['fn']);
							$nextPdfLink = pdfForPage($fn_t['volNum'], $fn_t['issueNum'], $next);
							print '<p>';
							print '<a href="/bq/'.$fn_t['file'].'" target="_blank">OLD</a> ';
							print '<a href="/bq-tools/bq-xmltransform/pdf-merge/'.$fn_t['file'].'.pdf" target="_blank">PDF</a> ';
							print '<a href="'.$nextPdfLink.'" target="_blank">(next page)</a> ';
							print '<a href="/bq-tools/bq-diff/trans-diff.php?file='.$fn_t['file'].'" target="_blank">DIFF</a> ';
							print '<a href="/bq-tools/bq-xmltransform/move-to-bq.php?f='.$fn_t['file'].'.xml" target="_blank" style="color:red;">ADD PAGE</a> ';
							print '<a href="/bq-tools/bq-xmltransform/notes-bottom-ok.php?l=notes-bottom-ok.txt&t='.$fn_t['file'].'.xml" target="_blank" style="color:red;">OK AS IS</a> ';
							print '</p>';
						} else {
							//
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

