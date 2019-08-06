<!DOCTYPE html>
<html>
<?php
$pt = '';
	
$nl = '
';
	
$base_path = ($_SERVER['SERVER_NAME'] == 'bq.blakearchive.org' || $_SERVER['SERVER_NAME'] == 'bq-dev.blakearchive.org') ? '' : '../../bq/';
$base_url_local = 'http://localhost:8888/bq/';

require('include/functions.php');
require('include/head.php');

$replace = array();
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" rend="$2"$3>';
$replace['<figure[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$2" rend="$1"$3>';
$replace['<figure[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$2" rend="$1" width="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" rend="$2" width="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}height="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" rend="$2" height="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}type="reviewed-cover"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" rend="$2" type="reviewed-cover" width="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$3" rend="$2"$4>';
$replace['<figure[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$2" id="$1" rend="$3"$4>';
$replace['<figure[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$3" id="$1" rend="$2"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" width="$4"$5>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$3" rend="$2" width="$4"$5>';

?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Standardize format of figure tag</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
			
			foreach (new DirectoryIterator($base_path.'docs/') as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
					$XMLstring = file_get_contents($base_path.'docs/'.$fn_t['fn']);
					$XMLstringNew = $XMLstring;

					foreach($replace as $key => $value) {
						$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
					}
					
					/*
					$FullXML = simplexml_load_string($XMLstringNew);
					
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
					$fn_t['rend'] = $FullXML->xpath('//text//figure/@rend'); // array
					$fn_t['width'] = $FullXML->xpath('//text//figure/@width'); // array
					$fn_t['height'] = $FullXML->xpath('//text//figure/@height'); // array

					$errors = false;

					if ( (count($fn_t['src']) == count($fn_t['rend'])) && (count($fn_t['rend']) == count($fn_t['width'])) && (count($fn_t['width']) == count($fn_t['height'])) ) {
						// fine
					} else {
						$errors = true;
						echo '<p style="color: red;">ERROR: '.$fn_t['fn'].': unequal numbers of src/rend/width/height</p>';
					}
					*/

					if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
						file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
						echo '<h4>Converted '.$fn_t['fn'].'</h4>';
					} else {
						echo '<p>'.$fn_t['fn'].': no change</p>';
					}
										
				}
			}
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

