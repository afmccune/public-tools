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
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = $fileParts[0].'.'.$fileParts[1].'.'.$fileParts[2];
					
					$fn_t['xml'] = simplexml_load_file('../../bq/docs/'.$fn_t['fn']);
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
			
			$emendString = file_get_contents('../../bq/docs/Emend.xml');
			$emendString = preg_replace('/<[\/]?hi[ rend="abcilmpsu]{0,17}>/', '', $emendString);
			$emendXML = simplexml_load_string($emendString);
			$emendNoteSubheadings = $emendXML->xpath('//p/ref[1][@target]'); // array
			$emendNoteTextTitles = array();
			$emendNoteTextTargets = array();
			
			for($i=0; $i<count($emendNoteSubheadings); $i++) {
				$headFix = preg_replace('/[,’” \r\n	]{0,}(p|n)(age[s]{0,}|ote)[ \r\n	]{0,}/', '|$1', $emendNoteSubheadings[$i]);
				$splitHead = explode('|', $headFix);
				$splitHead[0] = mb_ereg_replace('^(“[ ‘]{0,2}|Review of )', '', $splitHead[0]);
				$emendNoteTextTitles[$i] = ($splitHead[0] == '') ? '' : $splitHead[0];
				$emendNoteTextTargets[$i] = ($splitHead[1] == '') ? '' : $splitHead[1];
				//echo "<p>".$splitHead[0]."|".$splitHead[1]."</p>";
			}
			
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
			
			/*
			$emendNoteDocs = $emendXML->xpath('//p/ref[1]/@issue'); // array
			$emendNoteDocsStr = array();
			
			foreach($emendNoteDocs as $note) {
				$noteArr = (array)$note;
				$emendNoteDocsStr[] = $noteArr['@attributes']['issue'];
			}
			
			$emendNoteDocsUnique = array_unique($emendNoteDocsStr);
			$emendNotesByDoc = array();
			
			foreach($emendNoteDocsUnique as $item) {
				$emendNotesByDoc[$item] = 0;
			}
			
			foreach($emendNoteDocsStr as $note) {
				$emendNotesByDoc[$note] = $emendNotesByDoc[$note] + 1;
			}
			
			$keys = array_merge (array_keys($docs), array_keys($emendNotesByDoc));
			$keys = array_unique($keys);
			sort($keys);
			foreach($keys as $k) {
				$emend = (array_key_exists($k, $docs)) ? $docs[$k]['emends'] : 0;
				$note = (array_key_exists($k, $emendNotesByDoc)) ? $emendNotesByDoc[$k] : 0;
				if($emend == $note && $emend != 0) {
					//echo '<p>'.$k.': '.$emend.' emendation(s), '.$note.' note(s)</p>';
				} else {
					echo '<h4>'.$k.': '.$emend.' emendation(s), '.$note.' note(s)';
					if($note > $emend) {
						echo '*';
					}
					echo '</h4>';
				}
			}
			*/
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>
