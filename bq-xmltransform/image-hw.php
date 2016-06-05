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

function url_exists($url){
	$url = str_replace("http://", "", $url);
	if (strstr($url, "/")) {
		$url = explode("/", $url, 2);
		$url[1] = "/".$url[1];
	} else {
		$url = array($url, "/");
	}

	$fh = fsockopen($url[0], 80);
	if ($fh) {
		fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
		if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
		else { return TRUE;    }

	} else { 
		//echo '<p>no fh</p>';
		return FALSE;
	}
}

$replace = array();
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" width="0" height="0" $3>';
$replace['<figure[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$2" rend="$1" width="0" height="0" $3>';
$replace['<figure[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$2" rend="$1" width="$3" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" width="$3" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}height="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" width="0" height="$3" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}type="reviewed-cover"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" type="reviewed-cover" width="$3" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$3" id="$2" width="0" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" id="$3" width="0" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$2" rend="$3" id="$1" width="0" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$3" rend="$2" id="$1" width="0" height="0" $4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$3" id="$2" width="$4" height="0" $5>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([\/]{0,1})>'] = '<figure n="$1" rend="$2" id="$3" width="$4" height="0" $5>';

?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Set image display dimensions based on image file dimensions</h1>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			//$docsXml = array();
			
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
					/*
					$fileParts = explode('.', $fn_t['fn']);
					//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
					$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
					$fn_t['volNum'] = $fileParts[0];
					$fn_t['issueNum'] = $fileParts[1];
					$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
					$fn_t['fileSplit'] = $fileParts[2];
					
					$FullXML = simplexml_load_file($base_path.'docs/'.$fn_t['fn']);
					*/
					
					$XMLstring = file_get_contents($base_path.'docs/'.$fn_t['fn']);
					$XMLstringNew = $XMLstring;

					foreach($replace as $key => $value) {
						$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
					}
					
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

					if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') { // && $errors == false
						file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
						echo '<h4>Converted '.$fn_t['fn'].'</h4>';
					} else {
						echo '<p>'.$fn_t['fn'].': no change</p>';
					}
					
					
					

					/*
					
					$fn_t['src'] = $FullXML->xpath('//text//figure/@n'); // array
										
					$fn_t['errors'] = array();

					if(count($fn_t['src']) > 0) {
						foreach($fn_t['src'] as $src) {
							if(strpos($src, 'http://') === false) {
								$srcFull = $base_path.$src;
								$srcLocalLink = $base_url_local.$src;
								if(file_exists($srcFull)) {
									//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcLocalLink.'">'.$srcFull.'</a></p>';
								} else {
									$fn_t['errors'][] = 'Missing image: <a href="'.$srcLocalLink.'">'.$srcFull.'</a>';
									$numMissing = $numMissing + 1;
									$missingByDecade[$decade] = $missingByDecade[$decade] + 1;
								}
							} else {
								$srcFull = $src;
								if(url_exists($srcFull)) {
									//echo '<p>'.$fn_t['file'].': Image found: <a href="'.$srcFull.'">'.$srcFull.'</a></p>';
								} else {
									$fn_t['errors'][] = 'Missing image: <a href="'.$srcFull.'">'.$srcFull.'</a>';
								}
							}
							
						}
					} else {
						//echo '<p>'.$fn_t['file'].': No images.</p>';
					}
					*/

					//$docsXml[] = $fn_t;
	
					
				}
			}
			
			/*			
			for ($i=0; $i<count($docsXml); $i++) {
				if(count($docsXml[$i]['errors']) > 0) {
					print '<h4><a href="/bq/'.$docsXml[$i]['file'].'">'.$docsXml[$i]['file'].'</a></h4>';
					foreach($docsXml[$i]['errors'] as $error) {
						print '<p>'.$error.'</p>';
					}
				}
			}
			*/
			
			?>
							
						</div> <!-- #articles-reviews-index -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

