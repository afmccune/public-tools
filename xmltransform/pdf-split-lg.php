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
							<h1>PDF split</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			$fileArray = array();
			
			$input_dir = '/Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-large/';
			$output_dir = '/Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-split/';

			$cmd = '#!/bin/bash'.$nl.$nl;
			
			foreach (new DirectoryIterator('pdf-large/') as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.pdf/', $fn->getFilename())) {
					$file = $fn->getFilename();	
					$fileShort = str_replace('.pdf','',$file);
					$parts = explode('-0', $fileShort);
					$vol = $parts[0];
					$vol = ltrim($vol, '0');
					$iss = $parts[1];
					$iss = str_replace('_0', '-', $iss);
					$volIss = $vol.'.'.$iss;
					$cmd .= 'echo '.$volIss.$nl;
					$cmd .= 'gs -sDEVICE=pdfwrite -dSAFER -o '.$output_dir.$volIss.'.p%d.pdf '.$input_dir.$file.$nl;
				}
			}
			
			// Create bash file
			file_put_contents('bash/split-lg.sh', $cmd);
			echo '<h4>Refreshed split-lg.sh</h4>';
			
			// Set permissions for bash file
			$result = shell_exec('cd /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash'.$nl.'chmod 775 split-lg.sh');
			
			// Instructions to run bash file from Terminal (since we can't seem to get it to run from PHP)
			echo '<h4>To run the split, execute the following in Terminal: <br/> /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash/split-lg.sh</h4>';
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

