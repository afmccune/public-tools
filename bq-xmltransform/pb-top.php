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
	

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Make sure there is a page break at the top of each article</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$volCount = 0;

			$all_pages = array();
			
			
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
					$fn_t['pbFront'] = $FullXML->xpath('//front//pb/@n'); // array
					
					//if(count($fn_t['pbFront']) > 1 && $fn_t['pbFront'][0] == $fn_t['pb'][0]) {
						// ignore if first pb is in <front> instead of <body>
					//} else {
						$prev = $fn_t['pb'][0] - 1;
						$volTwoDig = str_pad($fn_t['volNum'], 2, '0', STR_PAD_LEFT);
					
						$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
						$XMLstringTest = $XMLstring;
					
						$XMLstringTest = preg_replace('@<div[0-9][- a-zA-Z0-9="/]{0,}>@', '', $XMLstringTest);
						$XMLstringTest = preg_replace('@[	 ]{0,}[\r\n]{1,}[	 ]{0,}@', '', $XMLstringTest);
					
						if (strpos($XMLstringTest, '<body><pb') !== false) {
							//print '<p>'.$fn_t['file'].': Page break at top.</p>';
						} else {
							replaceInFile('<body>', '<body>'.$nl.'	<pb id="'.$volTwoDig.'-'.$prev.'" n="'.$prev.'"/>', $fn_t['fn']);
							print '<p><a href="/bq/'.$fn_t['file'].'" target="_blank">OLD</a> <a href="/bq-tools/bq-xmltransform/pdf-merge/'.$fn_t['file'].'.pdf" target="_blank">PDF</a> <a href="/bq-tools/bq-diff/trans-diff.php?file='.$fn_t['file'].'" target="_blank">DIFF</a></p>';
						}
					//}
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

