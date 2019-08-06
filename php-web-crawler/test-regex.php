<!DOCTYPE html>
<html>
 <head>
  <title>Test</title>
 </head>
 <body>
  <div id="content" style="margin-top:10px;height:100%;">
   <h1>Test</h1>
   <?
   include("simple_html_dom.php");
   
   function perfect_url($u){
    $old_u = $u;
    if(strpos($u, '&amp;java=') !== false) {
    	$u = preg_replace('/&amp;java\=(yes|no)?/', '', $u);
    }
    echo '<pre>Before: '.$old_u.'<br/>After : '.$u.'</pre>';
   }
     //perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=');
     //perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=yes');
     //perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=no');
     
     $html = file_get_html('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.g.illbk.06');
     foreach($html->find("a") as $li){
     	perfect_url($li->href);
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
