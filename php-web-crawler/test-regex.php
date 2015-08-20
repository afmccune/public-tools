<!DOCTYPE html>
<html>
 <head>
  <title>Test</title>
 </head>
 <body>
  <div id="content" style="margin-top:10px;height:100%;">
   <h1>Test</h1>
   <?
   $nl = '
';
   
   function perfect_url($u){
    $old_u = $u;
    if(strpos($u, '&java=') !== false) {
    	$u = preg_replace('/&java\=(yes|no)?/', '', $u);
    }
    echo '<pre>Before: '.$old_u.'<br/>After : '.$u.'</pre>';
   }
     perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=');
     perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=yes');
     perfect_url('http://www.blakearchive.org/exist/blake/archive/object.xq?objectid=thel.d.illbk.07&java=no');
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
