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
							<h1>Headings that may need to be labeled as section headings</h1>
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
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					$XMLheadings = $FullXML->xpath('//text//head/title');
					$fn_t['headings'] = $XMLheadings; //array
					$XMLfirstHeadingHi = $FullXML->xpath('//text//head[1]/title//hi');
					$fn_t['firstHeadingHi'] = (count($XMLfirstHeadingHi)>0) ? implode(' ', $XMLfirstHeadingHi) : '';
					$fn_t['firstHeadingCombo'] = (count($XMLheadings)>0) ? $XMLheadings[0].' '.$fn_t['firstHeadingHi'] : '';
					$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
					$fn_t['headingTypes'] = $XMLheadingTypes; //array					
					$XMLsectionHeadings = $FullXML->xpath('//text//head/title[@type="section"]');
					$fn_t['sectionHeadings'] = $XMLsectionHeadings; //array					
					
					$fn_t['errors'] = array();
					
					$checkType='note'; // article // correction // discussion // minute // news // note // poem [poetry] // query [queries] // remembrance // review // index
					if(count($fn_t['headings']) > 0 && count($fn_t['sectionHeadings']) < 1 && $fn_t['type'] == $checkType && stripos($fn_t['firstHeadingCombo'],$checkType) !== false) {
						$fn_t['errors'][] = "Type: ".$fn_t['type']."<br/>First heading: ".$fn_t['firstHeadingCombo'];
					} else {
						//echo '.';
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

