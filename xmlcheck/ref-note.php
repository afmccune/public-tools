<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
	require('include/functions.php');
	require('include/head.php');
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Refs without notes, notes without refs</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
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
					$fn_t['refTargets'] = $FullXML->xpath('//text//ref/@target'); // array
					$fn_t['refTargetsUniqueXml'] = array_unique($fn_t['refTargets']); // array
					$fn_t['notesXml'] = $FullXML->xpath('//text//note/@id'); // array
					
					$fn_t['refTargetsUnique'] = array();
					$fn_t['notes'] = array();
					
					foreach($fn_t['refTargetsUniqueXml'] as $r) {
						$fn_t['refTargetsUnique'][] = $r.'';
					}
					foreach($fn_t['notesXml'] as $n) {
						$fn_t['notes'][] = $n.'';
					}
					
					$fn_t['errors'] = array();
					
					foreach($fn_t['refTargetsUnique'] as $ref) {
						if(!in_array($ref, $fn_t['notes'])) {
							$fn_t['errors'][] = 'Ref for '.$ref.' missing corresponding note.';
						}
					}
					foreach($fn_t['notes'] as $note) {
						if(!in_array($note, $fn_t['refTargetsUnique'])) {
							$fn_t['errors'][] = 'Note '.$note.' missing corresponding ref.';
						}
					}
					
					/*
					$discrepancy = count($fn_t['refTargets']) - count($fn_t['refTargetsUnique']);
					
					if($discrepancy > 0) {
						$targetsDiff = implode(', ', array_unique(array_diff_assoc($fn_t['refTargets'], $fn_t['refTargetsUnique'])));
						$fn_t['errors'][] = 'Multiple refs for a single note: '.$targetsDiff;
						if(count($fn_t['refN']) > 0) {
							$fn_t['errors'][] = 'Refs with a @n attribute: '.count($fn_t['refN']).' out of '.$discrepancy.' extra refs';
						}
					} else if(count($fn_t['refN']) > 0) {
						$fn_t['errors'][] = 'Refs with a @n attribute: '.count($fn_t['refN']).' but no multiple refs';
					}
					*/
					
					$docsXml[] = $fn_t;
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
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

