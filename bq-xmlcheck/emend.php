<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>How many issues have been emended?</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$allXmlVolIss = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.toc.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					
					$allXmlVolIss[] = $fn_t['volIss'];
				
				}
			}
			
			$emendXML = simplexml_load_file('../../bq/docs/Emend.xml'); 
			$emendedIssues = $emendXML->xpath('//text//div1/@id'); // array
			
			$nonEmendedXmlIssues = array_diff($allXmlVolIss, $emendedIssues);
			
			foreach($nonEmendedXmlIssues as $iss) {
				print '<p>Not emended: '.$iss.'</p>';
			}
			
			$numNonEmendedXmlIssues = count($nonEmendedXmlIssues);
			$numXmlIssues = count($allXmlVolIss);
			$numEmendedXmlIssues = $numXmlIssues - $numNonEmendedXmlIssues;
			$percentXmlIssuesEmended = number_format(($numEmendedXmlIssues/$numXmlIssues)*100, 2);
			
			print '<p>'.$numEmendedXmlIssues.'/'.$numXmlIssues.' issues emended ('.$percentXmlIssuesEmended.'%)</p>';
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

