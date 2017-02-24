<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
	require('include/functions.php');
	require('include/head.php');

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
			if($_GET["l"] && $_GET["t"]) {
				$list = $_GET["l"];
				$text = $_GET["t"];
				// Write the contents to the file, 
				// using the FILE_APPEND flag to append the content to the end of the file
				// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
				if(file_put_contents('lists/'.$list, $text.$nl, FILE_APPEND | LOCK_EX)) {
					print '<p>Wrote '.$text.' to lists/'.$list.'</p>';
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

