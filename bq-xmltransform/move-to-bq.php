<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');

	function moveFile ($oldPath, $newPath) {
		// copy old file to new file location
		if (!copy ($oldPath, $newPath)) {
			echo '<p>Failed to copy '.$oldPath.'</p>';
		} else {
			echo '<p>Copied '.$oldPath.' to '.$newPath.'</p>';
			// delete old file
			if(!unlink($oldPath)) {
				echo '<p>Failed to delete '.$oldPath.'</p>';
			} else {
				echo '<p>Deleted '.$oldPath.'</p>';
			}
		}
	}
	
	$f = '';
	$oldDir = 'new/';
	$newDir = '../../bq/docs/';
	
	?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Move edited file from bq-tools/bq-xmltransform/new to bq/docs</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			if($_GET["f"]) {
				$f = $_GET["f"];
				if(file_get_contents($oldDir.$f)) {
					moveFile($oldDir.$f, $newDir.$f);
				} else {
					print '<p>File '.$oldDir.$f.' not found.</p>';
				}
			} else {
				print '<p>No variable (f) has been passed in the URL.</p>';
			}
									
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

