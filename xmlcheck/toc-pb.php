<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	
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
							<h1>Comparing article start page (from TOC) with page breaks in article file</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			$docsXml = array();
			$issueSections = array();
			
			foreach (new DirectoryIterator($dir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.toc.xml/', $fn->getFilename())) {
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
					$fn_t['articles'] = $FullXML->xpath('//text//table[@id="contents"]//cell//ref[1]/@issue'); // array 
					// We use "cell//ref[1]" to try to get only the first link in a cell, since if there are multiple news  
					// items in one cell, only the first will definitely start on the page in the neighboring cell. However, 
					// "cell//ref[1]" also matches the first ref in (say) a <corr> tag inside a cell, which may result in 
					// two refs from the same cell being processed.
					
					print '<table>';
					for($i=0; $i<count($fn_t['articles']); $i++) {
						$pageArr = $FullXML->xpath('//text//table[@id="contents"]//cell[preceding-sibling::cell//ref[@issue="'.$fn_t['articles'][$i].'"]]'); // array
						$page = $pageArr[0];
						
						if(preg_match('/[0-9]/', $page)) {
							if(strpos($page, '-') === false) {
								// nothing
							} else {
								// if there is a hyphen, take page before hyphen
								$pageParts = explode('-', $page);
								$page = $pageParts[0];
							}
							$page = intval($page);
						
							$articleXML = simplexml_load_file($dir.$fn_t['articles'][$i].'.xml'); 
							$articlePbsXML = $articleXML->xpath('//pb/@n'); // array
							$articlePbs = array();
							foreach($articlePbsXML as $pb) {
								if(strpos($pb, '-') === false) {
								// nothing
								} else {
									// if there is a hyphen, take page before hyphen
									$pageParts = explode('-', $pb);
									$pb = $pageParts[0];
								}
								$articlePbs[] = intval($pb);
							}
							
							if(!in_array($page, $articlePbs)) {
								$message = '';
								
								// doesn't work
								if($page+1 == $articlePbs[0]) {
									$message = '<strong>Missing first pb?</strong>';
								} else {
									$message = '<span style="color:red;">ODD</span>';
								}
								
								print '<tr><td><a href="'.$url.$fn_t['articles'][$i].'">'.$fn_t['articles'][$i].'</a></td><td>'.$message.'</td><td>TOC page: '.$page.'</td><td>first page break: '.$articlePbs[0].'</td></tr>';
							} else if($articlePbs[0] != $page) {
								$message = '<span style="color:red;">page present but not first</span>';
								print '<tr><td><a href="'.$url.$fn_t['articles'][$i].'">'.$fn_t['articles'][$i].'</a></td><td>'.$message.'</td><td>TOC page: '.$page.'</td><td>first page break: '.$articlePbs[0].'</td></tr>';
							}

						
							//print '<tr><td>'.$fn_t['articles'][$i].'</td><td>'.$page.'</td></tr>';
						} else {
							// nothing
						}
					}
					print '</table>';
					
					/*
					$fn_t['errors'] = array();
					if(count($fn_t['table-pbs']) > 0) {
						$error = 'Page break(s) in tables: <br/>';
						foreach($fn_t['table-pbs'] as $pb) {
							$error .= '<a href="'.$url.$fn_t['file'].'#p'.$pb.'" target="_blank">'.$pb.'</a><br/>';
						}
						$fn_t['errors'][] = $error;
					} else {
						//echo '<p>'.$fn_t['file'].': No images in tables.</p>';
					}

					$docsXml[] = $fn_t;
					*/
				}
			}
			
			/*
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="'.$url.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
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

