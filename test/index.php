<!DOCTYPE html>
<html>
	<?php
	require('../../include.php');
	
	$nl = '
';
	
	function restrict($str) {
		// deal with comma separation (classes but not fonts!) and "body"
		$str = preg_replace('/@media (screen|print) {/', '@media $1 {'.PHP_EOL.PHP_EOL, $str);
		return preg_replace('/(?<!;|{)[\n|\r]([#|\.|:|[a-zA-Z])/', PHP_EOL.'*$1', $str);
	}
	
	function stripComment($str) {
		return preg_replace('/<!--|-->/', '', $str);
	}
	
	
	require('include/functions.php');
	$pt = array();
	$q = '';
	$qw = '';
	$html = false;
	$lastDecade = '';
	$lastVol = '';
	$thumbwidth = '158';
	require('include/head.php');
	?>
	<body>
        <div id="outer">
			<?php
			//require('include/header.php');
			?>
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Issue Archive</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues" >
			
			<?php
			// First, HTML
			
			$docsHtml = array(); 
			foreach (new DirectoryIterator($htmlDir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[a-z]{1,}.html/', $fn->getFilename())) {
					$fn_t = array();
					
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					
					// Only continue and show if on testing sites or published
					if(showable($fn_t['volNum'], $fn_t['issueShort'])) {
						$FullHTML = file_get_html($htmlDir.$fn_t['fn']);
						$HTMLsrc = getHtmlElementArray($FullHTML, 'div[id=issueCoverImage] img', 'src');
						$HTMLdate = getHtmlElementArray($FullHTML, 'div[id=issueDescription] p', 'innertext');
						$fn_t['date'] = (strstr($HTMLdate[0], ':', true)) ? strstr($HTMLdate[0], ':', true) : $HTMLdate[0];
						$HTMLyear = substr($fn_t['date'], stripos($fn_t['date'], ' ')+1, 4);
						$fn_t['decade'] = substr($HTMLyear, 0, 3).'0s';
						$HTMLstyle = getHtmlElementArray($FullHTML, 'style', 'innertext');
						$style = (count($HTMLstyle)>0) ? implode(' ', $HTMLstyle) : '';
						$fn_t['style'] = stripComment(restrict($style));
						
						$docsHtml[] = $fn_t;
					}
				
					print '<p><a href="'.$fn_t['file'].'">'.$fn_t['file'].'</a></p>';
					print '<pre>'.$fn_t['style'].'</pre>';
				
					
				}
			}


			
			?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
					<?php
					//include('include/footer.php');
					?>
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

