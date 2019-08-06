<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';

	$files = file_get_contents('lists/notes-bottom-ok.txt');
	$filesList = explode($nl, $files);
	
	function volIssCmp ($a, $b) {
		$aSplit = explode('.', $a);
		$bSplit = explode('.', $b);		
		if($aSplit[0] == $bSplit[0]) {
			return strcmp($a, $b);
		} else {
			$aVolTwoDig = str_pad($aSplit[0], 2, '0', STR_PAD_LEFT);
			$bVolTwoDig = str_pad($bSplit[0], 2, '0', STR_PAD_LEFT);
			return strcmp($aVolTwoDig, $bVolTwoDig);
		}
	}
	
	require('include/functions.php');
	require('include/head.php');

	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>OK file (does not have notes-only page at bottom)</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			if($_GET["l"] && $_GET["t"]) {
				$list = $_GET["l"];
				$text = $_GET["t"];
				
				$filesList[] = $text;
				usort($filesList, volIssCmp);
				$filesNew = implode($nl, $filesList);

				if(file_put_contents('lists/'.$list, $filesNew)) {
					print '<p>Wrote '.$text.' to lists/'.$list.'</p>';
					if(!unlink('new/'.$text)) {
						echo '<p>Failed to delete new/'.$text.'</p>';
					} else {
						echo '<p>Deleted new/'.$text.'</p>';
					}
				} else {
					print '<p>Failed to write '.$text.' to lists/'.$list.'</p>';
				}
			} else {
				print '<p>Missing variable (l and/or t) which should be passed in the URL.</p>';
			}
									
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

