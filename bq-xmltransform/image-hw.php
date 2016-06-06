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

function newWH($src, $rend, $w, $h) {
	global $base_path;
	global $base_url_local;
	
	if($src == '') {
		return array('', '');
	} else {
		$maxWidth = ($w == '') ? 958 : $w;
		$maxHeight = ($h == '') ? 1000 : $h;

		$fullSrc = '';
		
		if($rend=='db') {
			$fullSrc = 'http://www.blakearchive.org/blake/images/'.$src.'.300.jpg';
		} else if (strpos($src, 'bqscan') !== false) {
			$fullSrc = '../../bq/img/illustrations/'.$src.'.png';
		} else if (strpos($src, '.100') !== false || strpos($src, '.bonus') !== false) {
			$fullSrc = '../../bq/img/illustrations/'.$src.'.jpg';
		} else {
			$fullSrc = '../../bq/img/illustrations/'.$src.'.300.jpg';
		}
	
		$imageinfo = getimagesize($fullSrc);
		
		if($imageinfo) {
			$ix=$imageinfo[0];
			$iy=$imageinfo[1];
			
			$return = resize_dimensions($maxWidth,$maxHeight,$ix,$iy);
			
			return $return;
		} else {
			return array('', '');
		}
	}
}

function resize_dimensions($goal_width,$goal_height,$width,$height) {
    $return = array('width' => $width, 'height' => $height); 
    
    // If the ratio > goal ratio and the width > goal width resize down to goal width 
    if ($width/$height > $goal_width/$goal_height && $width > $goal_width) { 
        $return['width'] = $goal_width; 
        $return['height'] = ceil($goal_width/$width * $height); 
    } 
    // Otherwise, if the height > goal, resize down to goal height 
    else if ($height > $goal_height) { 
        $return['width'] = ceil($goal_height/$height * $width); 
        $return['height'] = $goal_height; 
    } 
    
    return $return; 
}

$replace = array();
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="" height=""$3>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="$3" height=""$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}height="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="" height="$3"$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}type="reviewed-cover"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="reviewed-cover" width="$3" height=""$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" type="" width="" height=""$4>';
$replace['<figure[ 	\n\r]{1,}n="([a-zA-Z0-9-_\.\+]{1,})"[ 	\n\r]{1,}id="([a-zA-Z0-9-_\.]{1,})"[ 	\n\r]{1,}rend="(file|db)"[ 	\n\r]{1,}width="([0-9]{1,})"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" type="" width="$4" height=""$5>';
$replace['<figure[ 	\n\r]{1,}type="(reviewed-cover|ad)"[ 	\n\r]{0,}([ ]{0,}[\/]{0,1})>'] = '<figure n="" id="" rend="" type="$1" width="" height=""$2>';

?>
	<body>
       <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Set image display dimensions based on image file dimensions</h1>
							<p><strong>(Use image-std.php first to standardize format of figure tags.)</strong></p>
						</div>
					</div>
					<div id="main">
						<div id="articles-reviews-index">
			<?php
				
			foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
				//if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
				if (preg_match('/10.1.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
					$fn_t = array();
					$fn_t['fn'] = $fn->getFilename();
					
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
					$fn_t['id'] = $FullXML->xpath('//text//figure/@id'); // array
					$fn_t['type'] = $FullXML->xpath('//text//figure/@type'); // array

					$fn_t['cover'] = $FullXML->xpath('//text//div1[@id="cover"]'); // array
					//$fn_t['coverSrc'] = $FullXML->xpath('//text//div1[@id="cover"]//figure/@n'); // array

					//print('<p style="color: red;">'.count($fn_t['cover']).'</p>');

					$errors = false;

					if ( (count($fn_t['src']) == count($fn_t['rend'])) && (count($fn_t['rend']) == count($fn_t['width'])) && (count($fn_t['width']) == count($fn_t['height'])) && (count($fn_t['height']) == count($fn_t['id'])) && (count($fn_t['id']) == count($fn_t['type'])) ) {
						// fine
						for($i=0; $i<count($fn_t['src']); $i++) {
							//if(count($fn_t['coverSrc']) < 1 || (string)$fn_t['src'][$i] !== (string)$fn_t['coverSrc'][0]) { // this weirdly DOES NOT WORK
							if(count($fn_t['cover']) < 1 || $i > 0) {
								//print('<p>"'.$fn_t['src'][$i].'" !== "'.$fn_t['coverSrc'][0].'"</p>'); // literally says: "cover.001.01.bqscan" !== "cover.001.01.bqscan"
								/*
								if((string)$fn_t['src'][$i] !== (string)$fn_t['coverSrc'][0]) {
									print('<p style="color: red;">');
									print_r($fn_t['src']);
									print('</p><p style="color: green;">');
									print_r($fn_t['src']);
									print('</p>');
								}
								*/
								$wh = newWH($fn_t['src'][$i], $fn_t['rend'][$i], $fn_t['width'][$i], $fn_t['height'][$i]);
								$newWidth = $wh['width'];
								$newHeight = $wh['height'];
								/*
								$srcCode = ($fn_t['src'][$i] == '') ? '' : ' n="'.$fn_t['src'][$i].'"';
								$idCode = ($fn_t['id'][$i] == '') ? '' : ' id="'.$fn_t['id'][$i].'"';
								$rendCode = ($fn_t['rend'][$i] == '') ? '' : ' id="'.$fn_t['rend'][$i].'"';
								$typeCode = ($fn_t['type'][$i] == '') ? '' : ' id="'.$fn_t['type'][$i].'"';
								$oldWidthCode = ($fn_t['width'][$i] == '') ? '' : ' id="'.$fn_t['width'][$i].'"';
								$oldHeightCode = ($fn_t['width'][$i] == '') ? '' : ' id="'.$fn_t['height'][$i].'"';
								*/
								$srcCode = ' n="'.$fn_t['src'][$i].'"';
								$idCode = ' id="'.$fn_t['id'][$i].'"';
								$rendCode = ' rend="'.$fn_t['rend'][$i].'"';
								$typeCode = ' type="'.$fn_t['type'][$i].'"';
								$oldWidthCode = ' width="'.$fn_t['width'][$i].'"';
								$oldHeightCode = ' height="'.$fn_t['height'][$i].'"';

								$XMLstringNew = preg_replace('/<figure'.$srcCode.$idCode.$rendCode.$typeCode.$oldWidthCode.$oldHeightCode.'([ ]{0,}[\/]{0,})>/', '<figure'.$srcCode.$idCode.$rendCode.$typeCode.' width="'.$newWidth.'" height="'.$newHeight.'"$1>', $XMLstringNew);
							}
						}
						$XMLstringNew = str_replace(' n=""', '', $XMLstringNew);
						$XMLstringNew = str_replace(' rend=""', '', $XMLstringNew);
						$XMLstringNew = str_replace(' width=""', '', $XMLstringNew);
						$XMLstringNew = str_replace(' height=""', '', $XMLstringNew);
						$XMLstringNew = str_replace(' id=""', '', $XMLstringNew);
						$XMLstringNew = str_replace(' type=""', '', $XMLstringNew);
					} else {
						$errors = true;
						echo '<p style="color: red;">ERROR: '.$fn_t['fn'].': unequal numbers of src('.count($fn_t['src']).')/rend('.count($fn_t['rend']).')/width('.count($fn_t['width']).')/height('.count($fn_t['height']).')/id('.count($fn_t['id']).')/type('.count($fn_t['type']).')</p>';
					}				

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

