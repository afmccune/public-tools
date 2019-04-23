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
							<h1>Make sure the same title is not used 
							for emendation notes for different files, 
							and that the page/note link matches the page/note text</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			/*
			$docs = array();
			
			foreach (new DirectoryIterator($dir) as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
					
					$fn_t['xml'] = simplexml_load_file($dir.$fn_t['fn']);
					$fn_t['corrs'] = $fn_t['xml']->xpath('//text//corr[@type="emend"]'); // array
					$fn_t['supplieds'] = $fn_t['xml']->xpath('//text//supplied[@type="emend"]'); // array
					$fn_t['gaps'] = $fn_t['xml']->xpath('//text//gap[@type="emend"]'); // array
					$fn_t['emends'] = count($fn_t['corrs']) + count($fn_t['supplieds']) + count($fn_t['gaps']);
					
					if($fn_t['emends'] > 0) {
						$docs[$fn_t['file']] = $fn_t;
					}
				}
			}
			*/
			
			$emendString = file_get_contents($dir.'Emend.xml');
			$emendString = preg_replace('/<[\/]?hi[ rend="abcilmpsu]{0,17}>/', '', $emendString);
			$emendXML = simplexml_load_string($emendString);
			$emendNoteSubheadings = $emendXML->xpath('//p/ref[1][@target]'); // array
			$emendNoteTextTitles = array();
			$emendNoteTextTargets = array();
			
			for($i=0; $i<count($emendNoteSubheadings); $i++) {
				$headFix = preg_replace('/[,’” \r\n	]{0,}(p|n)(age[s]{0,}|ote)[ \r\n	]{0,}/', '|$1', $emendNoteSubheadings[$i]);
				$splitHead = explode('|', $headFix);
				$splitHead[0] = mb_ereg_replace('^(“[ ‘]{0,2}|Review of )', '', $splitHead[0]);
				$emendNoteTextTitles[$i] = ($splitHead[0] !== '') ? $splitHead[0] : '';
				$emendNoteTextTargets[$i] = ($splitHead[1] !== '') ? $splitHead[1] : '';
				//echo "<p>".$headFix." => ".$splitHead[0]."|".$splitHead[1]."</p>";
			}
			
			
			// check pages/notes against text
			
			$emendNoteTargets = $emendXML->xpath('//p/ref[1]/@target'); // array
			$emendNoteTargetsStr = array();
			
			foreach($emendNoteTargets as $target) {
				$targetArr = (array)$target;
				$emendNoteTargetsStr[] = $targetArr['@attributes']['target'];
			}
			
			for($i=0; $i<count($emendNoteTargetsStr); $i++) {
				if($emendNoteTargetsStr[$i] !== $emendNoteTextTargets[$i]) {
					echo '<p>'.$emendNoteTextTitles[$i].': '.$emendNoteTargetsStr[$i].' !== '.$emendNoteTextTargets[$i].'</p>';
				}
			}
			
			
			// get titles from individual docs (XML files)
			
			$emendNoteDocs = $emendXML->xpath('//p/ref[1][@target]/@issue'); // array
			$emendNoteDocsStr = array();
			
			foreach($emendNoteDocs as $note) {
				$noteArr = (array)$note;
				$emendNoteDocsStr[] = $noteArr['@attributes']['issue'];
			}
			
			$emendNoteTitles = array();

			for($i=0; $i<count($emendNoteDocsStr); $i++) {
				if(($emendNoteDocsStr[$i] < '45.1' || $emendNoteDocsStr[$i] > '49.1') && !preg_match('/bonus/', $emendNoteDocsStr[$i])) {
					$FullXML = simplexml_load_file($dir.$emendNoteDocsStr[$i].'.xml'); 
					$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
					$emendNoteTitles[$i] = $XMLtitle[0];
				} else {
					$emendNoteTitles[$i] = '';
					//$emendNoteDocsStr[$i] = '';
					//unset($emendNoteDocsStr[$i]);
				}
			}
			
			// compare emendation note titles to doc titles
			
			/*
			$numTextTitles = count($emendNoteTextTitles);
			$numDocTitles = count($emendNoteTitles);
			$titleDiff = $numTextTitles-$numDocTitles;
			echo '<h4>'.$numTextTitles.'-'.$numDocTitles.' = '.$titleDiff.' [docs: '.count($emendNoteDocsStr).']</h4>';
			
			echo "<table>";
			for($i=0; $i<count($emendNoteTextTitles); $i++) {
				echo "<tr><td>".$emendNoteTextTitles[$i]."</td><td>".$emendNoteTitles[$i]."</td><td>".$emendNoteDocsStr[$i]."</td></tr>";
			}
			echo "</table>";
			*/
			
			for($i=0; $i<count($emendNoteTextTitles); $i++) {
				//$emendNoteTitles[$i] vs. $emendNoteTextTitles[$i]
				$textTitle = preg_replace('/[\r\n	 ]{1,}/', ' ', $emendNoteTextTitles[$i]);
				$textTitle = str_replace(',', '', $textTitle);
				$textTitle = str_replace(';', '', $textTitle);
				$textTitle = str_replace(':', '', $textTitle);
				$textTitle = str_replace('?', '', $textTitle);
				$textTitle = str_replace('“', '', $textTitle);
				$textTitle = str_replace('”', '', $textTitle);
				$textTitle = str_replace('(', '', $textTitle);
				$textTitle = str_replace(')', '', $textTitle);
				$textTitle = str_replace('’s ', ' ', $textTitle);
				$textTitle = str_replace('‘', '', $textTitle);
				$textTitle = str_replace('’ ', ' ', $textTitle);
				$textTitle = preg_replace('/’$/', '', $textTitle);
				$textTitle = preg_replace('/edition (of |by )?/', '', $textTitle);
				$textTitle = str_replace('edited by ', '', $textTitle);
				$textTitle = str_replace(' and ', ' ', $textTitle);
				$textTitleWords = (strstr($textTitle, ' ') === false) ? array($textTitle) : explode(' ', $textTitle);
				foreach($textTitleWords as $word) {
					//if (strpos($a, 'are') !== false) {
					if(!preg_match('/'.preg_quote($word, '/').'/i', $emendNoteTitles[$i])) {
						echo "<p>Word (".$word.") in emendation note title (".$emendNoteTextTitles[$i].") does not match doc title (".$emendNoteTitles[$i].")</p>";
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

