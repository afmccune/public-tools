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
							<h1>Hebrew</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php

						for ($i = 1488; $i < 1515; $i++) {
							echo "$"."list['&#".$i."'] = '&amp;#".$i.";';<br/>".$nl;
						}
						foreach(array('64305', '64315', '64324', '64298', '64299', '64309', '64330', '64331', '1456') as $i) {
							echo "$"."list['&#".$i."'] = '&amp;#".$i.";';<br/>".$nl;
						}
						for ($i = 1460; $i < 1469; $i++) {
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

