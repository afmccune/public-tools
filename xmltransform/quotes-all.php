<!DOCTYPE html>
<html>
<?php
require('../../include.php');
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
					foreach (new DirectoryIterator($dir) as $fn) {
						//if (preg_match('/4[3-4].[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
						//if (preg_match('/^[1-4]{0,1}[0-9]\.[0-9]{1}[-a-z0-9]{0,3}\.[-a-z0-9]{1,20}\.xml$/', $fn->getFilename())) {
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

							$XMLstring = file_get_contents($dir.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							$quotes = substr_count($XMLstring, '"');
							
							if($quotes % 2 == 0) {
								// even
							} else {
								$ws = $fn_t['file'].' : Number of quotes is odd.';
								$warningDoc .= $ws.$nl;
								echo '<h4>'.$ws.'</h4>';
							}
							
							$quote_pairs = ceil($quotes/2);
							
							for($i=0; $i<$quote_pairs; $i++) {
								$XMLstringNew = preg_replace('/"/', '”', preg_replace('/"/', '“', $XMLstringNew, 1), 1);
							}
							
							// repeat for up to four quote pairs in each tag
							for($i=0; $i<4; $i++) {
								$XMLstringNew = preg_replace('/=[ ]{0,1}“([ -\/_:@a-zA-Z0-9\.łöéá]{1,})”([ 	-\/_:@a-zA-Z0-9\.łöéá="“”\?\r\n]{0,})>/', '="$1"$2>', $XMLstringNew);
								$XMLstringNew = preg_replace('/=[ ]{0,1}”([ -\/_:@a-zA-Z0-9\.łöéá]{1,})“([ 	-\/_:@a-zA-Z0-9\.łöéá="“”\?\r\n]{0,})>/', '="$1"$2>', $XMLstringNew); // quotes are backwards--e.g., for quotes in pb tag between two quotes in text
							}
							$XMLstringNew = preg_replace('/=“Documents, vols. 1-([0-9]{1,3})”/', '="Documents, vols. 1-$1"', $XMLstringNew);
							$XMLstringNew = preg_replace('/=“volume_([0-9]{1,3})”/', '="volume_$1"', $XMLstringNew);
							$XMLstringNew = preg_replace('/=“issue_([0-9]{1,3})”/', '="issue_$1"', $XMLstringNew);
							
							$quoteMisplacements1 = preg_match_all('/[a-zA-Z,!\?\.]“/', $XMLstringNew);
							$quoteMisplacements2raw = preg_match_all('/“[ '.$nl.',!\?\.]/', $XMLstringNew);
								$quoteMisplacements2offset1 = preg_match_all('/“[ ]{0,1}\.[ ]{0,1}\.[ ]{0,1}\./', $XMLstringNew); // quote beginning with ellipsis
								$quoteMisplacements2offset2 = preg_match_all('/“ ‘/', $XMLstringNew);
								$quoteMisplacements2 = $quoteMisplacements2raw - ($quoteMisplacements2offset1 + $quoteMisplacements2offset2);
							$quoteMisplacements3 = preg_match_all('/”[a-zA-Z]/', $XMLstringNew);
							$quoteMisplacements4raw = preg_match_all('/[ '.$nl.']”/', $XMLstringNew);
								$quoteMisplacements4offset1 = preg_match_all('/\.[ ]{0,1}\.[ ]{0,1}\. ”/', $XMLstringNew);
								$quoteMisplacements4offset2 = preg_match_all('/’ ”/', $XMLstringNew);
								$quoteMisplacements4 = $quoteMisplacements4raw - ($quoteMisplacements4offset1 + $quoteMisplacements4offset2);
							$quoteMisplacements5 = preg_match_all('/“</(p|cell)>/', $XMLstringNew);
							$quoteMisplacements6 = preg_match_all('/<(p|cell)>”/', $XMLstringNew);
							$quoteMisplacements = $quoteMisplacements1 + $quoteMisplacements2 + $quoteMisplacements3 + $quoteMisplacements4 + $quoteMisplacements5 + $quoteMisplacements6;
							if($quoteMisplacements > 0) {
								$ws = $fn_t['file'].' : '.$quoteMisplacements.' quote misplacements ('.$quoteMisplacements1.' + '.$quoteMisplacements2.' + '.$quoteMisplacements3.' + '.$quoteMisplacements4.' + '.$quoteMisplacements5.' + '.$quoteMisplacements6.').';
								$warningDoc .= $ws.$nl;
								echo '<h4>'.$ws.'</h4>';
							}
							
							/*
							$XMLstringNew = preg_replace("/“'/", "“‘", $XMLstringNew);
							$XMLstringNew = preg_replace("/”'/", "”’", $XMLstringNew);
							$XMLstringNew = preg_replace("/'s /", "’s ", $XMLstringNew);
							*/
							
							file_put_contents('new/_quoteWarnings.txt', $warningDoc);
							
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

