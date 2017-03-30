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

function isImage($url) {
	 $params = array('http' => array(
				  'method' => 'HEAD'
			   ));
	 $ctx = stream_context_create($params);
	 $fp = @fopen($url, 'rb', false, $ctx);
	 if (!$fp) 
		return false;  // Problem with url

	$meta = stream_get_meta_data($fp);
	if ($meta === false)
	{
		fclose($fp);
		return false;  // Problem reading data from url
	}

	$wrapper_data = $meta["wrapper_data"];
	if(is_array($wrapper_data)){
	  foreach(array_keys($wrapper_data) as $hh){
		  if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19 
		  {
			fclose($fp);
			return true;
		  }
	  }
	}

	fclose($fp);
	return false;
  }

// trouble with this is the answer is always yes on the new WBA, which gives you a custom 404 page if the URL is wrong
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

function newWH($src, $rend, $w, $h, $isCover) {
	global $base_path;
	global $base_url_local;
	
	if($src == '') {
		$return = array();
		$return['width'] = $w; 
		$return['height'] = $h; 
		return $return;
	} else {
		$maxWidth = ($w == '') ? 958 : $w;
		$maxHeight = ($h == '') ? 1000 : $h;
		
		if($isCover) {
			$maxWidth = 258;
			$maxHeight = 500;
		}

		$fullSrc = '';
		
		if($rend=='db') {
			$fullSrc = 'http://www.blakearchive.org/images/'.$src.'.300.jpg';
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
			//echo '<p>'.$src.': '.$ix.' x '.$iy.'</p>';
			
			$return = resize_dimensions($maxWidth,$maxHeight,$ix,$iy);
			
			return $return;
		} else {
			$return = array();
			$return['width'] = $w; 
        	$return['height'] = $h; 
			return $return;
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
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="" height=""$3>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)" width="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="$3" height=""$4>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)" height="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="" height="$3"$4>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="" width="$3" height="$4"$5>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)" type="reviewed-cover" width="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="reviewed-cover" width="$3" height=""$4>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" rend="(file|db)" type="reviewed-cover" width="([0-9]{1,})" height="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="" rend="$2" type="reviewed-cover" width="$3" height="$4"$5>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" type="" width="" height=""$4>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" type="" width="$4" height=""$5>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="$2" rend="$3" type="" width="$4" height="$5"$6>';
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_\.]{1,})" work-copy="([a-zA-Z0-9-_\.]{1,})" rend="(file|db)" width="([0-9]{1,})" height="([0-9]{1,})"([ ]{0,1}[\/]{0,1})>'] = '<figure n="$1" id="$2" work-copy="$3" rend="$4" type="" width="$5" height="$6"$7>';
$replace['<figure type="(reviewed-cover|ad)"([ ]{0,1}[\/]{0,1})>'] = '<figure n="" id="" rend="" type="$1" width="" height=""$2>';

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
				if (preg_match('/[0-9]{1,2}.[0-9]{1}[-a-z0-9]{0,3}.[-a-z0-9]{1,20}.xml/', $fn->getFilename())) {
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
							if($fn_t['width'][$i] > 958) {
								$errors = true;
								'<p style="color: red;">ERROR: '.$fn_t['fn'].': '.$fn_t['src'][$i].' set to width of '.$fn_t['width'][$i].'</p>';
							}
							if($fn_t['width'][$i] == '' || $fn_t['height'][$i] == '') {
								$isCover = (count($fn_t['cover']) < 1 || $i > 0) ? false : true;
								
								$wh = newWH($fn_t['src'][$i], $fn_t['rend'][$i], $fn_t['width'][$i], $fn_t['height'][$i], $isCover);
								$newWidth = $wh['width'];
								$newHeight = $wh['height'];

								$escCode = ' n="'.preg_quote($fn_t['src'][$i]).'" id="'.$fn_t['id'][$i].'" rend="'.$fn_t['rend'][$i].'" type="'.$fn_t['type'][$i].'"';
								$code = ' n="'.$fn_t['src'][$i].'" id="'.$fn_t['id'][$i].'" rend="'.$fn_t['rend'][$i].'" type="'.$fn_t['type'][$i].'"';
								$oldWidthCode = ' width="'.$fn_t['width'][$i].'"';
								$oldHeightCode = ' height="'.$fn_t['height'][$i].'"';

								$XMLstringNew = preg_replace('/<figure'.$escCode.$oldWidthCode.$oldHeightCode.'([ ]{0,}[\/]{0,})>/', '<figure'.$code.' width="'.$newWidth.'" height="'.$newHeight.'"$1>', $XMLstringNew);
							}
						}
					} else {
						$errors = true;
						echo '<p style="color: red;">ERROR (mid-process): '.$fn_t['fn'].': unequal numbers of src('.count($fn_t['src']).')/rend('.count($fn_t['rend']).')/width('.count($fn_t['width']).')/height('.count($fn_t['height']).')/id('.count($fn_t['id']).')/type('.count($fn_t['type']).')</p>';
					}

					$XMLstringNew = str_replace(' n=""', '', $XMLstringNew);
					$XMLstringNew = str_replace(' rend=""', '', $XMLstringNew);
					$XMLstringNew = str_replace(' width=""', '', $XMLstringNew);
					$XMLstringNew = str_replace(' height=""', '', $XMLstringNew);
					$XMLstringNew = str_replace(' id=""', '', $XMLstringNew);
					$XMLstringNew = str_replace(' type=""', '', $XMLstringNew);
										
					$FullXML2 = simplexml_load_string($XMLstringNew);
					$fn_t['src2'] = $FullXML2->xpath('//text//figure/@n'); // array
					$fn_t['rend2'] = $FullXML2->xpath('//text//figure/@rend'); // array
					$fn_t['width2'] = $FullXML2->xpath('//text//figure/@width'); // array
					$fn_t['height2'] = $FullXML2->xpath('//text//figure/@height'); // array

					if ( (count($fn_t['src2']) == count($fn_t['rend2'])) && (count($fn_t['rend2']) == count($fn_t['width2'])) && (count($fn_t['width2']) == count($fn_t['height2'])) ) {
						// fine
					} else {
						$errors = true;
						echo '<p style="color: red;">ERROR (end): '.$fn_t['fn'].': unequal numbers of src('.count($fn_t['src2']).')/rend('.count($fn_t['rend2']).')/width('.count($fn_t['width2']).')/height('.count($fn_t['height2']).')</p>';
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

