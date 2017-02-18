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
			
			$fileArray = array('2.1.pdf','2.2.pdf');
			
			$input_dir = '/Applications/MAMP/htdocs/bq/pdfs/';
			$output_dir = '/Applications/MAMP/htdocs/bq-tools/bq-xmltransform/pdf-split/';

			$cmd = '#!/bin/bash'.$nl.$nl;
			//Add each pdf file to the end of the command
			foreach($fileArray as $file) {
				$fileShort = str_replace('.pdf','',$file);
				$cmd .= 'gs -sDEVICE=pdfwrite -dSAFER -o '.$output_dir.$fileShort.'.p%d.pdf '.$input_dir.$file.$nl;
			}
			
			// Create bash file
			file_put_contents('bash/split.sh', $cmd);
			echo '<h4>Refreshed split.sh</h4>';
			
			// Set permissions for bash file
			$result = shell_exec('cd /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash'.$nl.'chmod 775 split.sh');
			
			// Instructions to run bash file from Terminal (since we can't seem to get it to run from PHP)
			echo '<h4>To run the split, execute the following in Terminal: <br/> /Applications/MAMP/htdocs/bq-tools/bq-xmltransform/bash/split.sh</h4>';
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

