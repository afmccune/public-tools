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
							<h1>Cyrillic</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php

						for ($i = 1040; $i < 1104; $i++) {
							echo "$"."list['&#".$i."'] = '&amp;#".$i.";';<br/>".$nl;
						}
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

