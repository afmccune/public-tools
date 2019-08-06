<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');

function seasonYearFromDate($date) {
	$seasons = array();
	$seasons[1] = 'Winter';
	$seasons[2] = 'Winter'; // no examples
	$seasons[3] = 'Spring';
	$seasons[4] = 'Spring';
	$seasons[5] = 'Summer';
	$seasons[6] = 'Summer';
	$seasons[7] = 'Summer';
	$seasons[8] = 'Summer'; // no examples
	$seasons[9] = 'Fall'; // no examples
	$seasons[10] = 'Fall';
	$seasons[11] = 'Fall'; // no examples
	$seasons[12] = 'Winter'; // no examples
	
	$dateParts = explode('-', $date);
	$monthStr = $dateParts[1];
	$month = intval($monthStr);
	
	$year = $dateParts[0];
	if($seasons[$month] == 'Winter') {
		$oldYear = $year - 1;
		$year = $oldYear.'-'.substr($year, 2, 2);
	}
	
	return $seasons[$month].' '.$year;
}

$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML Check</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						$previousVolIss = '0.0';
												
						$docsHtml = array(); 
						foreach (new DirectoryIterator($htmlDir) as $fn) {
							if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = $fileParts[2];
													
								$HTMLstring = file_get_contents($htmlDir.$fn_t['fn']);
								
								$FullHTML = file_get_html($htmlDir.$fn_t['fn']);
								
								$date = '';
								
								if($fn_t['volIss'] != $previousVolIss) {
									echo '<h4>'.$fn_t['volIss'].'</h4>';
									$previousVolIss = $fn_t['volIss'];
								}
								
								if (getHtmlElementArray($FullHTML, 'div[id=issueDescription] p', 'innertext')) {
									$HTMLdate = getHtmlElementArray($FullHTML, 'div[id=issueDescription] p', 'innertext');
									$date = (strstr($HTMLdate[0], ':', true)) ? strstr($HTMLdate[0], ':', true) : $HTMLdate[0];
									$date = str_replace('–', '-', $date);
									echo '<p>'.$fn_t['file'].': '.$date.'</p>';
								} else if(getHtmlElementArray($FullHTML, 'meta[name=DC.Date.dateSubmitted]', 'content')) {
									$HTMLdate = getHtmlElementArray($FullHTML, 'meta[name=DC.Date.dateSubmitted]', 'content');						
									$date = $HTMLdate[0];						
									echo '<p>'.$fn_t['file'].': '.seasonYearFromDate($date).' ('.$date.')</p>';
								} else {
									echo '<p>'.$fn_t['file'].': ERROR (no date)</p>';
								}
							}	
						}
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

