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
							<h1>Survey of Header Titles</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			
			foreach (new DirectoryIterator("./old/") as $fn) {
				if (preg_match('/[-a-z0-9]*.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();	
					
					$fn_t['file'] = str_replace('.xml', '', $fn_t['fn']);

						$FullXML = simplexml_load_file('old/'.$fn_t['fn']); 
						$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
						$fn_t['type'] = $XMLtype[0];
						$XMLtitleHi = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/hi');
						$fn_t['titleHi'] = $XMLtitleHi[0];
						$XMLtitle = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title');
						$fn_t['title'] = $XMLtitle[0];
						$XMLotherTitle = $FullXML->xpath('//teiHeader/fileDesc/sourceDesc/biblFull/titleStmt/title');
						$fn_t['otherTitle'] = $XMLotherTitle[0];
						/*
						$XMLauthorLast = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author/@n');
						$fn_t['authorLast'] = (count($XMLauthorLast) > 0) ? $XMLauthorLast[0] : 'Anonymous';
						$XMLauthor = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/author');
						$XMLauthor2 = (count($XMLauthor) > 0) ? $XMLauthor[0] : '';
						$fn_t['author'] = ($fn_t['authorLast'] == 'Anonymous') ? '' : $fn_t['authorLast'].', '.str_replace(' '.$fn_t['authorLast'], '', $XMLauthor2);
						*/
						$docsXml[] = $fn_t;
						
					
				}
			}
						
			?>
								<table>
			<?php
			for ($i=0; $i<count($docsXml); $i++) {
				print '<tr><td>'.$docsXml[$i]['file'].'</td><td>'.$docsXml[$i]['titleHi'].$docsXml[$i]['title'].'</td><td>'.$docsXml[$i]['otherTitle'].'</td></div>';
			}
			?>
								</table>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

