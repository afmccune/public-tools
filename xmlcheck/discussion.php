<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
	require('include/functions.php');
	require('include/head.php');
	
	function array_find($needle, $haystack)
	{
	   $itIsInThere = false;
		
	   foreach ($haystack as $item)
	   {
		  if (strpos($item, $needle) !== FALSE)
		  {
			 $itIsInThere = true;
		  }
	   }
	   
	   return $itIsInThere;
	}
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Checking for "Discussion" section headings</h1>
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
					$XMLtype = $FullXML->xpath('//teiHeader/fileDesc/titleStmt/title/@type');
					$fn_t['type'] = $XMLtype[0];
					$XMLheadings = $FullXML->xpath('//text//head/title');
					$fn_t['headings'] = $XMLheadings; //array
					$XMLheadingsHi = $FullXML->xpath('//text//head/title/hi');
					$fn_t['headingsHi'] = $XMLheadingsHi; //array
					$XMLheadingTypes = $FullXML->xpath('//text//head/title/@type');
					$fn_t['headingTypes'] = $XMLheadingTypes; //array
					
					$fn_t['errors'] = array();
					
					if($fn_t['type'] == 'discussion' && array_find(":", $fn_t['headings']) || array_find("DISCUSSION", $fn_t['headings'])) {
						$fn_t['errors'][] = "Heading contains ':'. <a href='http://localhost/bq/xdoc.php?file=".$fn_t['file']."'>Link</a>";
					}
					if(strpos(":", $fn_t['headingsHi'][0]) != false) {
						$fn_t['errors'][] = "Heading contains ':'. <a href='http://localhost/bq/xdoc.php?file=".$fn_t['file']."'>Link</a>";
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

