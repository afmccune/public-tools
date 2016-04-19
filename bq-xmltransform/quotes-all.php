<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Quotes)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$warningDoc = '';
						
					$docsXml = array(); 
					foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
						//if (preg_match('/4[3-4].[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
						if (preg_match('/.xml/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
							
							$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							$fn_t['fileSplit'] = $fileParts[2];

							$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							$quotes = substr_count($XMLstring, '"');
							
							if($quotes % 2 == 0) {
								// even
							} else {
								$ws = '<p>WARNING: Number of quotes in '.$fn_t['file'].' is odd.</p>'.$nl;
								$warningDoc .= $ws;
								echo $ws;
							}
							
							$quote_pairs = ceil($quotes/2);
							
							for($i=0; $i<$quote_pairs; $i++) {
								$XMLstringNew = preg_replace('/"/', '”', preg_replace('/"/', '“', $XMLstringNew, 1), 1);
							}
							
							$XMLstringNew = preg_replace('/=[ ]{0,1}“([-a-zA-Z0-9\.]{1,})”/', '="$1"', $XMLstringNew);
							$XMLstringNew = preg_replace('/=[ ]{0,1}”([-a-zA-Z0-9\.]{1,})“/', '="$1"', $XMLstringNew); // quotes are backwards--e.g., for quotes in pb tag between two quotes in text
							$XMLstringNew = preg_replace('/=“BQ_Documents, vols. 1-([0-9]{1,3})”/', '="BQ_Documents, vols. 1-$1"', $XMLstringNew);
							$XMLstringNew = preg_replace('/=“volume_([0-9]{1,3})”/', '="volume_$1"', $XMLstringNew);
							$XMLstringNew = preg_replace('/=“issue_([0-9]{1,3})”/', '="issue_$1"', $XMLstringNew);
							
							$quoteMisplacements1 = substr_count($XMLstringNew, '“ ');
							$quoteMisplacements2 = substr_count($XMLstringNew, '“'.$nl);
							$quoteMisplacements3 = substr_count($XMLstringNew, ' ”');
							$quoteMisplacements4 = substr_count($XMLstringNew, $nl.'”');
							$quoteMisplacements = $quoteMisplacements1 + $quoteMisplacements2 + $quoteMisplacements3 + $quoteMisplacements4;
							if($quoteMisplacements > 0) {
								$ws = '<p>WARNING: Number of quote misplacements in '.$fn_t['file'].' is '.$quoteMisplacements.' ('.$quoteMisplacements1.' + '.$quoteMisplacements2.' + '.$quoteMisplacements3.' + '.$quoteMisplacements4.').</p>'.$nl;
								$warningDoc .= $ws;
								echo $ws;
							}
							
							/*
							$XMLstringNew = preg_replace("/“'/", "“‘", $XMLstringNew);
							$XMLstringNew = preg_replace("/”'/", "”’", $XMLstringNew);
							$XMLstringNew = preg_replace("/'s /", "’s ", $XMLstringNew);
							*/
							
							file_put_contents('new/_quoteWarnings.xml', $warningDoc);
							
							if($XMLstring != $XMLstringNew) {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<p>Converted '.$fn_t['fn'].'</p>';
							} else {
								echo '<p>Unchanged: '.$fn_t['fn'].'</p>';
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

