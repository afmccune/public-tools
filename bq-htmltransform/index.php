<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>HTML Transform</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
						$docsHtml = array(); 
						foreach (new DirectoryIterator("./old/") as $fn) {
							if (preg_match('/[-a-z0-9]*.htm[l]?/', $fn->getFilename())) {
								$fn_t = array();
								
								$fn_t['fn'] = $fn->getFilename();	
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);
								
								$HTMLstring = file_get_contents('old/'.$fn_t['fn']);
								
								$FullHTMLold = file_get_html('old/'.$fn_t['fn']);
								
								if ($FullHTMLold->find('body', 0)->id) {
									echo '<p>ERROR: '.$fn_t['fn'].' body id already set to '.$FullHTMLold->find('body', 0)->id.' Copied without change.</p>';
									file_put_contents('new/'.$fn_t['fn'], $HTMLstring); // unchanged
								} else {
								
									$HTMLstring = str_replace('<body', '<body id="'.$fn_t['file'].'" ', $HTMLstring);
									//$HTMLstring = str_replace('<div id="articlecontent">', '<div id="articlecontent"><div id="idno">'.$fn_t['file'].'</div>', $HTMLstring);
								
									$srcs = getHtmlElementArray($FullHTMLold, 'img', 'src');
									foreach($srcs as $oldSrc) {
										$newSrc = (strpos($oldSrc, '/') !== false) ? substr($oldSrc, strrpos($oldSrc, '/') + 1) : $oldSrc;
										$HTMLstring = str_replace('src="'.$oldSrc.'"', 'src="'.$newSrc.'"', $HTMLstring);
									}
									
									file_put_contents('new/'.$fn_t['file'].'.html', $HTMLstring);
									echo '<p>Converted '.$fn_t['fn'].'</p>';
									
									$FullHTMLnew = file_get_html('new/'.$fn_t['file'].'.html');
									if ($FullHTMLnew->find('body', 0)->id == $fn_t['file']) {
										echo '<p>'.$fn_t['file'].'.html body id set to '.$fn_t['file'].'</p>';
									} else {
										echo '<p>ERROR: '.$fn_t['file'].'.html body id set to '.$FullHTMLnew->find('body', 0)->id.'</p>';
									}
								}
							}	
						}
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

