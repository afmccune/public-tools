<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
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
					$XMLidno = $FullXML->xpath('//teiHeader/idno');
					$fn_t['idno'] = $XMLidno[0];
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					$XMLtitleHi = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/hi');
					$fn_t['titleHi'] = (count($XMLtitleHi) > 0) ? $XMLtitleHi[0] : '';
					$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
					$fn_t['title'] = $XMLtitle[0];
					$XMLotherTitle = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title');
					$fn_t['otherTitle'] = $XMLotherTitle[0];
					$XMLheadings = $FullXML->xpath('//text//head/title');
					$fn_t['headings'] = $XMLheadings; //array
					$XMLfirstHeadingHi = $FullXML->xpath('//text//head[1]/title//hi');
					$fn_t['firstHeadingHi'] = (count($XMLfirstHeadingHi)>0) ? implode(' ', $XMLfirstHeadingHi) : '';
					$fn_t['firstHeadingCombo'] = (count($XMLheadings)>0) ? $XMLheadings[0].' '.$fn_t['firstHeadingHi'] : '';
					$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
					$fn_t['headingTypes'] = $XMLheadingTypes; //array
					$XMLpb = $FullXML->xpath('//text//pb/@n');
					$fn_t['pb'] = array();
					foreach($XMLpb as $pb) {
						if(preg_match('/-/', $pb)) {
							$pages = explode('-', $pb);
							for($i=0; $i<count($pages); $i++) {
								$fn_t['pb'][] = $pages[$i];
								if(isset($pages[$i+1]) && ($pages[$i]+1 != $pages[$i+1])) {
									$fn_t['pb'][] = $pages[$i]+1;
								}
							}
						} else {
							$fn_t['pb'][] = $pb;
						}
					}
					$fn_t['figHead'] = $FullXML->xpath('//text//figure//head'); // array
					$fn_t['figDesc'] = $FullXML->xpath('//text//figure//figDesc'); // array
					$fn_t['fig-pb'] = $FullXML->xpath('//text//figure//pb/@n'); // array
					$XMLrefCorr = $FullXML->xpath('//text//ref//corr'); // array
					$XMLrefSupp = $FullXML->xpath('//text//ref//supplied'); // array
					$XMLrefGap = $FullXML->xpath('//text//ref//gap'); // array
					$fn_t['ref-emend'] = array_merge($XMLrefCorr, $XMLrefSupp, $XMLrefGap);
					$XMLrefCorrRend = $FullXML->xpath('//text//ref//corr/@rend'); // array
					$XMLrefSuppRend = $FullXML->xpath('//text//ref//supplied/@rend'); // array
					$XMLrefGapRend = $FullXML->xpath('//text//ref//gap/@rend'); // array
					$fn_t['ref-emend-rend'] = array_merge($XMLrefCorrRend, $XMLrefSuppRend, $XMLrefGapRend);
					

					$XMLauthorLast = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author/@n');
					$fn_t['authorLast'] = (count($XMLauthorLast) > 0) ? $XMLauthorLast[0] : 'Anonymous';
					$XMLauthor = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
					$fn_t['author'] = (count($XMLauthor) > 0) ? $XMLauthor[0] : '';
					
					$fn_t['errors'] = array();
					if($fn_t['idno'] != $fn_t['file']) {
						$fn_t['errors'][] = "File idno does not match filename, but idno is: ".$fn_t['idno'];
					}
					if($fn_t['type'] != 'toc' && $fn_t['type'] != 'article' && $fn_t['type'] != 'discussion' && $fn_t['type'] != 'minute' && $fn_t['type'] != 'news' && $fn_t['type'] != 'review' && $fn_t['type'] != 'note' && $fn_t['type'] != 'query' && $fn_t['type'] != 'poem' && $fn_t['type'] != 'correction' && $fn_t['type'] != 'checklist' && $fn_t['type'] != 'remembrance') {
						$fn_t['errors'][] = "Type is not one of the standard ones, but instead: ".$fn_t['type'];
					}
					if($fn_t['fileSplit'] == 'toc' && $fn_t['type'] != 'toc') {
						$fn_t['errors'][] = "Type should be 'toc', but it is: ".$fn_t['type'];
					}
					if($fn_t['fileSplit'] != 'toc' && $fn_t['type'] == 'toc') {
						$fn_t['errors'][] = "Type should not be 'toc', but it is.";
					}
					if($fn_t['fileSplit'] == 'toc' && $fn_t['title'] != 'Contents') {
						$fn_t['errors'][] = "Header title should be 'Contents'.";
					}
					if(count($fn_t['type']) < 1) {
						$fn_t['errors'][] = "Type should not be empty.";
					}
					if($fn_t['author'] != '' && $fn_t['authorLast'] == 'Anonymous') {
						$fn_t['errors'][] = "Author should have last name.";
					}
					//if($fn_t['author'] != '' && strpos($fn_t['author'], $fn_t['authorLast']) === false) {
					if($fn_t['author'] != '' && !preg_match('/'.$XMLauthorLast[0].'/', $XMLauthor[0])) {
						$fn_t['errors'][] = "Author's last name is not part of author's full name.";
					}
					if(strlen($fn_t['titleHi']) > 0) {
						$fn_t['errors'][] = "Header title should not contain highlight.";
					}
					if(count($fn_t['headings']) > 0 && count($fn_t['headingTypes']) < 1 && $fn_t['fileSplit'] != 'toc') {
						$fn_t['errors'][] = "Headings have not been assigned types.";
					}
					if(count($fn_t['pb']) > 0) {
						for ($i=0; $i<count($fn_t['pb']); $i++) {
							if($fn_t['type'] != 'toc' && isset($fn_t['pb'][$i+1]) && ($fn_t['pb'][$i]+1 != $fn_t['pb'][$i+1])) {
								$fn_t['errors'][] = "Page ".$fn_t['pb'][$i]." followed by page ".$fn_t['pb'][$i+1].".";
							}
						}
					} else {
						$fn_t['errors'][] = "Contains no page breaks.";
					}
					if(count($fn_t['fig-pb']) > 0) {
						$fn_t['errors'][] = "Page break (".$fn_t['fig-pb'][0].") inside figure.";
					}
					if(count($fn_t['ref-emend']) > 0 && count($fn_t['ref-emend']) > count($fn_t['ref-emend-rend'])) {
						$fn_t['errors'][] = "Emendation inside ref.";
					}
					if(count($fn_t['headingTypes']) > 0) {
						if($fn_t['headingTypes'][0] = 'section') {
							$section = $fn_t['firstHeadingCombo'];
							if(isset($issueSections[$fn_t['volIss']])) {
								if(isset($issueSections[$fn_t['volIss']][$section])) {
									$others = (count($issueSections[$fn_t['volIss']][$section]) > 1) ? implode(", ", $issueSections[$fn_t['volIss']][$section]) : $issueSections[$fn_t['volIss']][$section][0];
									$issueSections[$fn_t['volIss']][$section][] = $fn_t['file'];
									$fn_t['errors'][] = "Not the first use of section heading (".$section."); also used by: ".$others;
								} else {
									$issueSections[$fn_t['volIss']][$section] = array();
									$issueSections[$fn_t['volIss']][$section][] = $fn_t['file'];
								}
							} else {
								$issueSections[$fn_t['volIss']] = array();
								$issueSections[$fn_t['volIss']][$section] = array();
								$issueSections[$fn_t['volIss']][$section][] = $fn_t['file'];
							}
						}
					}
					if(count($fn_t['figHead']) > 1) {
						$lastFigHead = $fn_t['figHead'][count($fn_t['figHead'])-1];
						$lastFigHeadNum = substr($lastFigHead,0,2);
						if($lastFigHeadNum == '1.' || $lastFigHeadNum == '1 ') {
							$fn_t['errors'][] = "Last figure (which is not also the first figure) has head beginning: '".$lastFigHeadNum."' -- does this figure belong to the following article?";
						}
					}
					if(count($fn_t['figDesc']) > 1) {
						$lastFigDesc = $fn_t['figDesc'][count($fn_t['figDesc'])-1];
						$lastFigDescNum = substr($lastFigDesc,0,2);
						if($lastFigDescNum == '1.' || $lastFigDescNum == '1 ') {
							$fn_t['errors'][] = "Last figure (which is not also the first figure) has figDesc beginning: '".$lastFigDescNum."' -- does this figure belong to the following article?";
						}
					}
					$capTitle = checkCapitalization($fn_t['title'], 'Header title');
					$capAuthor = checkCapitalization($fn_t['author'], 'Author');
					$capAuthorLast = checkCapitalization($fn_t['authorLast'], 'Author last');
					if($capTitle != '' || $capAuthor != '' || $capAuthorLast != '') {
						$fn_t['errors'][] = $capTitle.$capAuthor.$capAuthorLast;
					}

					$docsXml[] = $fn_t;
	
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
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

