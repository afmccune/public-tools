<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";

function copyImg ($oldSrc, $newSrc, $volIss) {
	$newImgDir = 'new/'.$volIss;
	if (file_exists($newImgDir)) {
		// okay
	} else {
		mkdir($newImgDir);
	}
	if (!copy ('old/'.substr($oldSrc, 2), $newImgDir.'/'.$newSrc)) {
		echo '<p>Failed to copy old/'.substr($oldSrc, 2).'</p>';
	} else {
		echo '<p>Copied old/'.substr($oldSrc, 2).' to '.$newImgDir.'/'.$newSrc.'</p>';
	}
}
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
								$fileParts = explode('.', $fn_t['fn']);
								$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
								$fn_t['file'] = str_replace('.html', '', $fn_t['fn']);
								
								$HTMLstring = file_get_contents('old/'.$fn_t['fn']);
								
								$FullHTMLold = file_get_html('old/'.$fn_t['fn']);
								
								if ($FullHTMLold->find('body', 0)->id) {
									echo '<p>ERROR: '.$fn_t['fn'].' body id already set to '.$FullHTMLold->find('body', 0)->id.' Copied without change.</p>';
									file_put_contents('new/'.$fn_t['fn'], $HTMLstring); // unchanged
								} else {
								
									// add id to body
									$HTMLstring = str_replace('<body', '<body id="'.$fn_t['file'].'" ', $HTMLstring);
									
									// fix weird cover image code glitch
									$HTMLstring = preg_replace('/<img src="([\.\/0-9a-zA-Z_]{1,})" \<\="" div\=""\>/', '<img src="$1" />', $HTMLstring);
									
									$FullHTMLmiddle = str_get_html($HTMLstring);
								
									$srcs = getHtmlElementArray($FullHTMLmiddle, 'img', 'src');
									foreach($srcs as $oldSrc) {
										$newSrc = (strpos($oldSrc, '/') !== false) ? substr($oldSrc, strrpos($oldSrc, '/') + 1) : $oldSrc;
										$newSrc = (preg_match('/[.flv|.gif|.png|.jpg|.jpeg]/', $newSrc)) ? $newSrc : $newSrc.'.jpg';
										$HTMLstring = str_replace('src="'.$oldSrc.'"', 'src="'.$newSrc.'"', $HTMLstring);
										echo '<p>'.$fn_t['file'].'.html: image filepath '.$oldSrc.' changed to '.$newSrc.'</p>';
										if($newSrc == 'homeHeaderTitleImage_en_US.flv' || $newSrc == 'UofR.gif' || $newSrc == 'fulltext_open_medium.gif' || $newSrc == 'fulltext_restricted_medium.gif') {
											// do not copy--not part of the article proper
										} else {
											copyImg($oldSrc, $newSrc, $fn_t['volIss']);
										}
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

