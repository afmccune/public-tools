<!DOCTYPE html>
<html>
	<?php
	require('../../include.php');
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
			
			foreach (new DirectoryIterator("../xmltransform/new/") as $fn) {
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

					$FullXML = simplexml_load_file('../xmltransform/new/'.$fn_t['fn']);
					/*
					$XMLidno = $FullXML->xpath('//teiHeader/idno');
					$fn_t['idno'] = $XMLidno[0];
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					$XMLtitleHi = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/hi');
					$fn_t['titleHi'] = $XMLtitleHi[0];
					$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
					$fn_t['title'] = $XMLtitle[0];
					$XMLotherTitle = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title');
					$fn_t['otherTitle'] = $XMLotherTitle[0];
					$XMLheadings = $FullXML->xpath('//text//head/title');
					$fn_t['headings'] = $XMLheadings; //array
					$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
					$fn_t['headingTypes'] = $XMLheadingTypes; //array

					$XMLauthorLast = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author/@n');
					$fn_t['authorLast'] = (count($XMLauthorLast) > 0) ? $XMLauthorLast[0] : 'Anonymous';
					$XMLauthor = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
					$fn_t['author'] = (count($XMLauthor) > 0) ? $XMLauthor[0] : '';
					*/
					
					$XMLtoc = $FullXML->xpath('//text//table/@id');
					$fn_t['toc'] = (count($XMLtoc) > 0) ? $XMLtoc[0] : '';
					$XMLtocPB = $FullXML->xpath('//text//table[@id = "contents"]//pb');
					$fn_t['tocPB'] = (count($XMLtocPB) > 0) ? 'pb' : '';
					$XMLtocRef = $FullXML->xpath('//text//table[@id = "contents"]//ref');
					$fn_t['tocRef'] = (count($XMLtocRef) > 0) ? 'ref' : '';
					
					$fn_t['errors'] = array();
					/*
					if($fn_t['idno'] != $fn_t['file']) {
						$fn_t['errors'][] = "File idno does not match filename, but idno is: ".$fn_t['idno'];
					}
					if($fn_t['type'] != 'toc' && $fn_t['type'] != 'article' && $fn_t['type'] != 'discussion' && $fn_t['type'] != 'minute' && $fn_t['type'] != 'news' && $fn_t['type'] != 'review' && $fn_t['type'] != 'note' && $fn_t['type'] != 'query' && $fn_t['type'] != 'poem' && $fn_t['type'] != 'corrigenda' && $fn_t['type'] != 'checklist') {
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
					if(strlen($fn_t['titleHi']) > 0) {
						$fn_t['errors'][] = "Header title should not contain highlight.";
					}
					if(count($fn_t['headings']) > 0 && count($fn_t['headingTypes']) < 1 && $fn_t['fileSplit'] != 'toc') {
						$fn_t['errors'][] = "Headings have not been assigned types.";
					}
					*/
					if($fn_t['toc'] != 'contents') {
						$fn_t['errors'][] = "There is no table of contents.";
					}
					if($fn_t['tocPB'] != '') {
						$fn_t['errors'][] = "There is a page break in the table of contents.";
					}
					if($fn_t['tocRef'] != '') {
						$fn_t['errors'][] = "There is a ref in the table of contents.";
					}

					$docsXml[] = $fn_t;
	
					
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				print '<h4>'.$docsXml[$i]['file'].'</h4>';
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

