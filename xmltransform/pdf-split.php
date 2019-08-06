<!DOCTYPE html>
<html>
	<?php
	$pt = '';
	$nl = '
';
	
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
							<h1>PDF split</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			$fileArray = array();
			
			$input_dir = '/Applications/MAMP/htdocs/'.$pdfIssuesDirShort;
			$output_dir = '/Applications/MAMP/htdocs/public-tools/xmltransform/pdf-split/';

			$cmd = '#!/bin/bash'.$nl.$nl;
			
			foreach (new DirectoryIterator($pdfIssuesDir) as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.pdf/', $fn->getFilename())) {
					$file = $fn->getFilename();	
					$fileShort = str_replace('.pdf','',$file);
					$cmd .= 'echo '.$fileShort.$nl;
					$cmd .= 'gs -sDEVICE=pdfwrite -dSAFER -o '.$output_dir.$fileShort.'.p%d.pdf '.$input_dir.$file.$nl;
				}
			}
			
			// Create bash file
			file_put_contents('bash/split.sh', $cmd);
			echo '<h4>Refreshed split.sh</h4>';
			
			// Set permissions for bash file
			$result = shell_exec('cd /Applications/MAMP/htdocs/public-tools/xmltransform/bash'.$nl.'chmod 775 split.sh');
			
			// Instructions to run bash file from Terminal (since we can't seem to get it to run from PHP)
			echo '<h4>To run the split, execute the following in Terminal: <br/> /Applications/MAMP/htdocs/public-tools/xmltransform/bash/split.sh</h4>';
			
			?>
			
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

