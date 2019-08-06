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
							<h1>Compare number of emendations in a file to number of emendation notes for file</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
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
			
			$emendXML = simplexml_load_file($dir.'Emend.xml'); 
			$emendNoteDocs = $emendXML->xpath('//ref/@issue'); // array
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
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

