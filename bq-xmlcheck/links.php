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
				
			$files = array();
			$links = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fileParts = explode('.', $fn_t['fn']);
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['fileSplit'] = $fileParts[2];
					
					$files[] = $fn_t['file'];
					
					$FullXML = simplexml_load_file('../../bq/docs/'.$fn_t['fn']); 

					$fn_t['links'] = $FullXML->xpath('//text//ref/@issue'); // array
					foreach($fn_t['links'] as $link) {
						$links[] = (string)$link;
					}
					//$links = array_merge($links, $fn_t['links']);
					
					
					$docsXml[] = $fn_t;
						
				}
			}
						
			for ($i=0; $i<count($docsXml); $i++) {
				print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
				
				foreach($docsXml[$i]['links'] as $link) {
					if(!in_array($link, $files)) {
						print '<p>Link '.$link.' does not correspond to any file.</p>';
					}
				}
				if($docsXml[$i]['fileSplit'] != 'toc' && !in_array($docsXml[$i]['file'], $links)) {
					print '<p>There are no links to this article.</p>';
				}	
			}
			
			//print_r($links);
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

