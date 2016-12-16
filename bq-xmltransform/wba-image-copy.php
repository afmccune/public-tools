<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";

$vg_bads = array();
$vg_bads['biblicalwc'] = array('but146.1', 'but435.1', 'but436.1', 'but438.1', 'but439.1', 'but440.1', 'but441.1', 'but442.1', 'but445.1', 'but446.1', 'but447.1', 'but448.1', 'but449.1', 'but450.1', 'but452.1', 'but453.1', 'but455.1', 'but457.1', 'but458.1', 'but461.1', 'but462.1', 'but463.1', 'but466.1', 'but467.1', 'but468.1', 'but469.1', 'but470.1', 'but472.1', 'but473.1', 'but475.1', 'but476.1', 'but478.1', 'but480.1', 'but482.1', 'but484.1', 'but485.1', 'but486.1', 'but488.1', 'but489.1', 'but494.1', 'but495.1', 'but496.1', 'but497.1', 'but498.1', 'but499.1', 'but500.1', 'but501.1', 'but502.1', 'but503.1', 'but504.1', 'but505.1', 'but506.1', 'but507.1', 'but511.1', 'but512.1', 'but515.1', 'but517.1', 'but518.1', 'but519.1', 'but520.1', 'but521.1', 'but522.1', 'but523.1', 'but524.1', 'but525.1');
$vg_bads['letters'] = array('lt18feb1800.1', 'lt1april1800.1', 'lt6may1800.1', 'lt2july1800.1', 'lt1sept1800.1', 'lt12sept1800.1', 'lt14sept1800.1', 'lt16sept1800.1', 'lt21sept1800.1', 'lt26nov1800.1', 'lt19oct1801.1', 'lt30jan1803.1', 'lt26oct1803.1', 'lt14jan1804.1', 'lt27jan1804.1', 'lt23feb1804.1', 'lt12march1804.1', 'lt16march1804.1', 'lt2april1804.1', 'lt7april1804.1', 'lt27april1804.1', 'lt4may1804.1', 'lt28may1804.1', 'lt22june1804.1', 'lt7aug1804.1', 'lt28sept1804.1', 'lt23oct1804.1', 'lt4dec1804.1', 'lt18dec1804.1', 'lt22jan1805.1', 'lt22march1805.1', 'lt4june1805.1', 'lt27nov1805.1', 'lt1825.1', 'lt7june1825.1', 'lt11oct1825.1', 'lt10nov1825.1', 'lt31jan1826.1', 'lt5feb1826.1', 'lt31march1826.1', 'lt19may1826.1', 'lt5july1826.1', 'lt14july1826.1', 'lt16july1826.1', 'lt29july1826.1', 'lt1aug1826.1', 'lt27jan1827.1', 'lt1827.1', 'ltfeb1827.1', 'lt15march1827.1', 'lt12april1827.1', 'lt25april1827.1', 'lt3july1827.1', 'lt15aug1827.1');
$vg_bads['gravepd'] = array('but614r.1', 'but614v.1', 'but619.1', 'but621r.1', 'but623.1', 'but624r.1', 'but624v.1', 'but625.1', 'but629.1');
$vg_bads['biblicaltemperas'] = array('but379.1', 'but381.1', 'but382.1', 'but387.1', 'but390.1', 'but392.1', 'but394.1', 'but396.1', 'but400.1', 'but401.1', 'but403.1', 'but404.1', 'but406.1', 'but409.1', 'but410.1', 'but411.1', 'but415.1', 'but416.1', 'but417.1', 'but419.1', 'but420.1', 'but424.1', 'but425.1', 'but426.1', 'but429.1');
$vg_bads['gravewc'] = array('but611.1', 'but613.1', 'but616.1', 'but620.1', 'but635.1', 'but638.1');
$vg_bads['cpd'] = array('but325.1', 'but326.1', 'but327.1', 'but289.1', 'but294.1', 'but295.1', 'but296.1', 'but323.1', 'but324.1', 'but316.1', 'but317.1', 'but318.1', 'but320.1', 'but321.1', 'but322.1', 'but297.1', 'but298.1', 'but299.1', 'but300.1', 'but301.1', 'but302.1', 'but303.1', 'but306.1', 'but307.1', 'but313.1', 'but310.1', 'but311.1', 'but312.1', 'but291.1', 'but292.1');
$vg_bads['gravewd'] = array('but612.1', 'but636.1');
$vg_bads['pid'] = array('but1.1', 'but6.1', 'but85v.1', 'but86v.1', 'btu94.1', 'but99.1', 'but100.1', 'but118r.1', 'but119Ar.1', 'but120r.1', 'but122v.1', 'but174.1', 'but175.1', 'but178r.1', 'but370.1', 'but773.1', 'but801.1');

$replace = array();
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_]{1,}\.[0-9]{1,})(\.[a-zA-Z0-9-_\.]{1,})"'] = '<figure n="$1" id="$2$3" work-copy="$2"';
$replace['work-copy="([a-zA-Z0-9-_\.]{1,})" work-copy="[a-zA-Z0-9-_\.]{1,}"'] = 'work-copy="$1"';
// virtual groups
foreach($vg_bads as $key => $value) {
	$vg = $key;
	foreach($value as $bad) {
		$replace['work-copy="'.$bad.'"'] = 'work-copy="'.$vg.'"';
	}
}
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>XML Transform (Replace)</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
						
					$docsXml = array(); 
					foreach (new DirectoryIterator("../../bq/docs/") as $fn) {
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

							$XMLstring = file_get_contents('../../bq/docs/'.$fn_t['fn']);
							$XMLstringNew = $XMLstring;
							
							foreach($replace as $key => $value) {
								$XMLstringNew = preg_replace("/".$key."/", "".$value."", $XMLstringNew);
							}
							
							if($XMLstring !== $XMLstringNew && $XMLstringNew !== '') {
								file_put_contents('new/'.$fn_t['fn'], $XMLstringNew);
								echo '<h4>Converted '.$fn_t['fn'].'</h4>';
							} else if ($XMLstringNew == '') {
								echo '<p style="color: red;">ERROR: transformed '.$fn_t['fn'].' is blank.</p>';
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

