<!DOCTYPE html>
<html>
<?php
require('../../include.php');
require('include/functions.php');
	
$nl = "
";

$openTag = '<title type="review">';
$author = '[a-zA-Zö\. '.$nl.']{1,}';
$authorNoPeriod = '[a-zA-Zö]{2,} [a-zA-Zö]{2,}';
$title = '[a-zA-Z0-9’:,\.&; '.$nl.']{1,}';
$sp = '[ '.$nl.']{1,2}';
$closeTagEsc = '<\/title>';
$closeTag = '</title>';

$replace = array();
$replace[$openTag.'('.$author.$sp.'and'.$sp.$author.'),'.$sp.'eds\.'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, eds., $2'.$closeTag; // add comma
//$replace[$openTag.'('.$author.$sp.'and'.$sp.$author.'),'.$sp.'eds\.,'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, eds., $2'.$closeTag; // fine
//$replace[$openTag.'('.$author.$sp.'and'.$sp.'and '.$author.'), ('.$title.')'.$closeTagEsc] = $openTag.'$1, $2'.$closeTag; // fine
$replace[$openTag.'('.$author.'),'.$sp.'ed\.'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, ed., $2'.$closeTag; // add comma
//$replace[$openTag.'('.$author.'),'.$sp.'ed\., ('.$title.')'.$closeTagEsc] = $openTag.'$1, ed., $2'.$closeTag; // fine
//$replace[$openTag.'('.$author.'), ('.$title.')'.$closeTagEsc] = $openTag.'$1, $2'.$closeTag; // fine
$replace[$openTag.'('.$author.'),'.$sp.'trans\.'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, trans., $2'.$closeTag; // add comma
$replace[$openTag.'('.$author.'),'.$sp.'ed\.'.$sp.'and'.$sp.'trans\.'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, ed. and trans., $2'.$closeTag; // add comma
$replace[$openTag.'('.$author.')’s'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, $2'.$closeTag; // ’s => ,
$replace[$openTag.'('.$title.'),'.$sp.'edited'.$sp.'by'.$sp.'('.$author.$sp.'and'.$sp.$author.')'.$closeTagEsc] = $openTag.'$2, eds., $1'.$closeTag; // , edited by => , eds.,
$replace[$openTag.'('.$title.'),'.$sp.'edited'.$sp.'by'.$sp.'('.$author.')'.$closeTagEsc] = $openTag.'$2, ed., $1'.$closeTag; // , edited by => , ed.,
$replace[$openTag.'('.$title.')'.$sp.'edited'.$sp.'by'.$sp.'('.$author.$sp.'and'.$sp.$author.')'.$closeTagEsc] = $openTag.'$2, eds., $1'.$closeTag; // edited by => , eds.,
$replace[$openTag.'('.$title.')'.$sp.'edited'.$sp.'by'.$sp.'('.$author.')'.$closeTagEsc] = $openTag.'$2, ed., $1'.$closeTag; // edited by => , ed.,
$replace[$openTag.'('.$title.')'.$sp.'by'.$sp.'('.$author.')'.$sp.'and'.$sp.'('.$title.')'.$sp.'by'.$sp.'('.$author.')'.$closeTagEsc] = $openTag.'$2, $1; $4, $3'.$closeTag; // by => , [for two works]
$replace[$openTag.'('.$title.'),'.$sp.'by'.$sp.'('.$author.')'.$closeTagEsc] = $openTag.'$2, $1'.$closeTag; // , by => ,
$replace[$openTag.'('.$title.')'.$sp.'by'.$sp.'('.$author.')'.$closeTagEsc] = $openTag.'$2, $1'.$closeTag; // by => ,
$replace[$openTag.'('.$authorNoPeriod.')\.'.$sp.'('.$title.')'.$closeTagEsc] = $openTag.'$1, $2'.$closeTag; // . => ,


?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Standardize Review Titles)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator($dir) as $fn) {
						if (preg_match('/.xml/', $fn->getFilename())) {
							$fn_t = array();
							$fn_t['fn'] = $fn->getFilename();	
							
							$fileParts = explode('.', $fn_t['fn']);
							//$fn_t['volIss'] = $fileParts[0].'.'.$fileParts[1];
							$fn_t['file'] = implode('.', array($fileParts[0], $fileParts[1], $fileParts[2]));
							$fn_t['volNum'] = $fileParts[0];
							$fn_t['issueNum'] = $fileParts[1];
							$fn_t['issueShort'] = substr($fn_t['issueNum'], 0, 1);
							//$fn_t['fileSplit'] = $fileParts[2];

							$XMLstring = file_get_contents($dir.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
							}
							
							if ($XMLstringNew == '') {
								echo '<p style="color: red;">ERROR: transformed '.$fn_t['fn'].' is blank.</p>';
							} else if($XMLstring !== $XMLstringNew) {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else {
								echo '<p>'.$fn_t['fn'].': no change</p>';
							}

						}	
					}
						
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

