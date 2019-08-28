<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('../include.php');
	require('include/functions.php');
	require('include/head.php');
	
	function checkCapitalization($str, $field) {
		$errors = '';
		$words = preg_split('/[- “”‘’\/—()\[\]]/', $str);
		foreach($words as $word) {
			if($word != strtolower($word) && $word != strtoupper($word) && $word != ucfirst(strtolower($word))) {
				$errors .= "<p>".$field.": Word (".$word.") has unusual capitalization.</p>";
			}
		}
		return $errors;
	}
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for errors</h1>
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
					$XMLvolume = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/biblScope[@unit="volume"]');
					$fn_t['XMLvol'] = $XMLvolume[0];
					$XMLissue = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/biblScope[@unit="issue"]');
					$fn_t['XMLiss'] = $XMLissue[0];
					
					$fn_t['errors'] = array();
					if($fn_t['volNum'] != $fn_t['XMLvol'] || $fn_t['issueNum'] != $fn_t['XMLiss']) {
						$fn_t['errors'][] = "Filename volume (".$fn_t['volNum'].") does not match header volume (".$fn_t['XMLvol']."), or filename issue (".$fn_t['issueNum'].") does not match header issue (".$fn_t['XMLiss'].")";
					}

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

