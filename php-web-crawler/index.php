<!DOCTYPE html>
<html>
 <head>
  <title>Web Crawler in PHP</title>
 </head>
 <body>
  <div id="content" style="margin-top:10px;height:100%;">
   <center><h1>Web Crawler in PHP</h1></center>
   <form action="index.php" method="POST">
    URL : <input name="url" size="35" placeholder="http://www.blakearchive.org/blake/"/>
    <input type="submit" name="submit" value="Start Crawling"/>
   </form>
   <br/>
   <b>The URL's you submit for crawling are recorded.</b><br/>See All Crawled URL's <a href="url-crawled.html">here</a>.
   <?
   $nl = '
';
   
   include("simple_html_dom.php");
   $crawled_urls=array();
   $found_urls=array();
   function rel2abs($rel, $base){
    if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
    extract(parse_url($base));
    $path = preg_replace('#/[^/]*$#', '', $path);
    if ($rel[0] == '/') $path = '';
    $abs = "$host$path/$rel";
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0;$abs=preg_replace($re,'/', $abs,-1,$n)){}
    $abs=str_replace("../","",$abs);
    return $scheme.'://'.$abs;
   }
   function perfect_url($u,$b){
    $bp=parse_url($b);
    /*
    if(($bp['path']!="/" && $bp['path']!="") || $bp['path']==''){
     if($bp['scheme']==""){$scheme="http";}else{$scheme=$bp['scheme'];}
     $b=$scheme."://".$bp['host']."/";
    }
    */
    if(strpos($u, '#') !== false) {
    	$u_arr = explode('#', $u);
    	$u = $u_arr[0];
    }
    if(substr($u,0,2)=="//"){
     $u="http:".$u;
    }
    if(substr($u,0,4)!="http"){
     $u=rel2abs($u,$b);
    }
    return $u;
   }
   function crawl_site($u){
    global $crawled_urls;
    global $found_urls;
    $uen=urlencode($u);
    if((array_key_exists($uen,$crawled_urls)==0 || $crawled_urls[$uen] < date("YmdHis",strtotime('-25 seconds', time())))){
     $html = file_get_html($u);
     $crawled_urls[$uen]=date("YmdHis");
     foreach($html->find("a") as $li){
      $url=perfect_url($li->href,$u);
      if(strpos($url, 'www.blakearchive.org') !== false) {
      	$enurl=urlencode($url);
      	if($url!='' && substr($url,0,4)!="mail" && substr($url,0,4)!="java" && array_key_exists($enurl,$found_urls)==0){
      	 if(url_exists($url)) {
      	  $found_urls[$enurl]=1;
      	  echo "<li><a target='_blank' href='".$url."'>".$url."</a></li>";
      	  crawl_site($url);
      	 } else {
      	  //echo "<li>Does not exist: ".$url."</li>";
      	 }
    	}
      }
     }
    }
   }
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
            $fileStr = htmlentities(fread($fh, 22));
            if ($fileStr == "HTTP/1.1 404 Not Found") { return FALSE; }
            else if ($fileStr == "HTTP/1.1 403 Forbidden") { return FALSE; }
            else {
            	//echo '<pre>'.$fileStr.'</pre>';
            	return TRUE;
            }

        } else { return FALSE;}
   }
   if(isset($_POST['submit'])){
    $url=$_POST['url'];
    if($url==''){
     echo "<h2>A valid URL please.</h2>";
    }else{
     $f=fopen("url-crawled.html","a+");
     fwrite($f,"<div><a href='$url'>$url</a> - ".date("Y-m-d H:i:s")."</div>".$nl);
     fclose($f);
     echo "<h2>Result - URL's Found</h2><ul style='word-wrap: break-word;width: 400px;line-height: 25px;'>";
     crawl_site($url);
     echo "</ul>";
    }
   }
   ?>
  </div>
  <style>
  input{
   border:none;
   padding:8px;
  }
  </style>
<!-- http://www.subinsb.com/2013/10/simple-web-crawler-in-php.html -->
 </body>
</html>
