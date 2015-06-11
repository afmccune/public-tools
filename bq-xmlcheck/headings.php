<!DOCTYPE html>
<html>
	<?php
	require('include/functions.php');
	require('include/head.php');
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
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
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
					$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
					$fn_t['headingTypes'] = $XMLheadingTypes; //array
							$XMLsection = $FullXML->xpath('//text//head/title[@type="section"]');
							$XMLsection = (count($XMLsection) > 0) ? $XMLsection : array('');
							$XMLsectionChild = $FullXML->xpath('//text//head/title[@type="section"]/*');
							$XMLsectionChild = (count($XMLsectionChild) > 0) ? $XMLsectionChild : array('');
							$XMLsectionChildChild = $FullXML->xpath('//text//head/title[@type="section"]/*/*');
							$XMLsectionChildChild = (count($XMLsectionChildChild) > 0) ? $XMLsectionChildChild : array('');
							$fn_t['section'] = $XMLsection[0].$XMLsectionChild[0].$XMLsectionChildChild[0];
							$XMLmain = $FullXML->xpath('//text//head/title[@type="main"]');
							$XMLmainText = (count($XMLmain) > 1) ? implode(' ', $XMLmain) : $XMLmain[0];
							$XMLmainChild = $FullXML->xpath('//text//head/title[@type="main"]/*');
							$XMLmainChildChild = $FullXML->xpath('//text//head/title[@type="main"]/*/*');
							$XMLmainDescendants = '';
							$XMLmainDescendants .= (count($XMLmainChild) > 1) ? implode(' ', $XMLmainChild) : $XMLmainChild[0];
							$XMLmainDescendants .= (count($XMLmainChildChild) > 1) ? implode(' ', $XMLmainChildChild) : $XMLmainChildChild[0];
							$fn_t['main'] = $XMLmainText.$XMLmainDescendants;
							

					$XMLauthorLast = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author/@n');
					$fn_t['authorLast'] = (count($XMLauthorLast) > 0) ? $XMLauthorLast[0] : 'Anonymous';
					$XMLauthor = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
					$fn_t['author'] = (count($XMLauthor) > 0) ? $XMLauthor[0] : '';
					
					$fn_t['errors'] = array();
					if(count($fn_t['headings']) > 0 && count($fn_t['headingTypes']) < 1 && $fn_t['fileSplit'] != 'toc') {
						$fn_t['errors'][] = "Headings have not been assigned types.";
					}
					if(count($fn_t['headingTypes']) > 0) {
						if($fn_t['main'] != '' && !preg_match('/'.preg_quote($fn_t['title'], '/i').'/', $fn_t['main'])) {
							$title = str_replace(',', '', $fn_t['title']);
							$title = str_replace(';', '', $title);
							$title = str_replace(':', '', $title);
							$title = str_replace('“', '', $title);
							$title = str_replace('”', '', $title);
							$titleWords = (strstr($title, ' ') === false) ? array($title) : explode(' ', $title);
							foreach($titleWords as $word) {
								if(!preg_match('/'.preg_quote($word, '/').'/i', $fn_t['main'])) {
									$fn_t['errors'][] = "Word (".$word.") in header title (".$fn_t['title'].") does not match main heading (".$fn_t['main'].")";
								}
							}
							//$fn_t['errors'][] = "Header title (".$fn_t['title'].") does not match main heading (".$fn_t['main'].")";
						}
						
						if($fn_t['section'] != '' && !preg_match('/'.$fn_t['type'].'/i', $fn_t['section'])) {
							if($fn_t['type'] == 'query' && preg_match('/quer/i', $fn_t['section'])) {
								// fine
							} else if($fn_t['type'] == 'poem' && preg_match('/poetry/i', $fn_t['section'])) {
								// fine
							} else if($fn_t['type'] == 'correction' && preg_match('/corrigend/i', $fn_t['section'])) {
								// fine
							} else if($fn_t['type'] == 'correction' && preg_match('/errat/i', $fn_t['section'])) {
								// fine
							} else {
								$fn_t['errors'][] = "Type (".$fn_t['type'].") does not match section (".$fn_t['section'].")";
							}
						}
						
					}
					
					$docsXml[] = $fn_t;
	
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
				foreach($docsXml[$i]['errors'] as $error) {
					print '<p>'.$error.'</p>';
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

