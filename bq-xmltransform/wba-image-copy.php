<!DOCTYPE html>
<html>
<?php
require('include/functions.php');
	
$nl = "
";

$replace = array();
$replace['<figure n="([a-zA-Z0-9-_\.\+]{1,})" id="([a-zA-Z0-9-_]{1,}\.[0-9]{1,})(\.[a-zA-Z0-9-_\.]{1,})"'] = '<figure n="$1" id="$2$3" work-copy="$2"';
//$replace['work-copy="([a-zA-Z0-9-_]{1,}\.[0-9]{1,})" work-copy="[a-zA-Z0-9-_]{1,}\.[0-9]{1,}"'] = 'work-copy="$1"';
// virtual groups
$replace['work-copy="but543.1"'] = 'work-copy="allegropenseroso"';
$replace['work-copy="bb69.1"'] = 'work-copy="allegropenseroso"';
$replace['work-copy="but379.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but381.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but382.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but387.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but390.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but392.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but394.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but396.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but400.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but401.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but403.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but404.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but406.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but409.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but410.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but411.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but415.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but416.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but417.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but419.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but420.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but424.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but425.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but426.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but429.1"'] = 'work-copy="biblicaltemperas"';
$replace['work-copy="but146.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but435.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but436.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but438.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but439.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but440.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but441.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but442.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but445.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but446.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but447.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but448.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but449.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but450.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but452.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but453.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but455.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but457.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but458.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but461.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but462.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but463.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but466.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but467.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but468.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but469.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but470.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but472.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but473.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but475.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but476.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but478.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but480.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but482.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but484.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but485.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but486.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but488.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but489.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but494.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but495.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but496.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but497.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but498.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but499.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but500.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but501.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but502.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but503.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but504.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but505.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but506.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but507.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but511.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but512.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but515.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but517.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but518.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but519.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but520.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but521.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but522.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but523.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but524.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but525.1"'] = 'work-copy="biblicalwc"';
$replace['work-copy="but325.1"'] = 'work-copy="cpd"';
$replace['work-copy="but326.1"'] = 'work-copy="cpd"';
$replace['work-copy="but327.1"'] = 'work-copy="cpd"';
$replace['work-copy="but289.1"'] = 'work-copy="cpd"';
$replace['work-copy="but294.1"'] = 'work-copy="cpd"';
$replace['work-copy="but295.1"'] = 'work-copy="cpd"';
$replace['work-copy="but296.1"'] = 'work-copy="cpd"';
$replace['work-copy="but323.1"'] = 'work-copy="cpd"';
$replace['work-copy="but324.1"'] = 'work-copy="cpd"';
$replace['work-copy="but316.1"'] = 'work-copy="cpd"';
$replace['work-copy="but317.1"'] = 'work-copy="cpd"';
$replace['work-copy="but318.1"'] = 'work-copy="cpd"';
$replace['work-copy="but320.1"'] = 'work-copy="cpd"';
$replace['work-copy="but321.1"'] = 'work-copy="cpd"';
$replace['work-copy="but322.1"'] = 'work-copy="cpd"';
$replace['work-copy="but297.1"'] = 'work-copy="cpd"';
$replace['work-copy="but298.1"'] = 'work-copy="cpd"';
$replace['work-copy="but299.1"'] = 'work-copy="cpd"';
$replace['work-copy="but300.1"'] = 'work-copy="cpd"';
$replace['work-copy="but301.1"'] = 'work-copy="cpd"';
$replace['work-copy="but302.1"'] = 'work-copy="cpd"';
$replace['work-copy="but303.1"'] = 'work-copy="cpd"';
$replace['work-copy="but306.1"'] = 'work-copy="cpd"';
$replace['work-copy="but307.1"'] = 'work-copy="cpd"';
$replace['work-copy="but313.1"'] = 'work-copy="cpd"';
$replace['work-copy="but310.1"'] = 'work-copy="cpd"';
$replace['work-copy="but311.1"'] = 'work-copy="cpd"';
$replace['work-copy="but312.1"'] = 'work-copy="cpd"';
$replace['work-copy="but291.1"'] = 'work-copy="cpd"';
$replace['work-copy="but292.1"'] = 'work-copy="cpd"';
$replace['work-copy="but614r.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but614v.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but619.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but621r.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but623.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but624r.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but624v.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but625.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but629.1"'] = 'work-copy="gravepd"';
$replace['work-copy="but611.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but613.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but616.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but620.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but635.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but638.1"'] = 'work-copy="gravewc"';
$replace['work-copy="but612.1"'] = 'work-copy="gravewd"';
$replace['work-copy="but636.1"'] = 'work-copy="gravewd"';
$replace['work-copy="lt18feb1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt1april1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt6may1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt2july1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt1sept1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt12sept1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt14sept1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt16sept1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt21sept1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt26nov1800.1"'] = 'work-copy="letters"';
$replace['work-copy="lt19oct1801.1"'] = 'work-copy="letters"';
$replace['work-copy="lt30jan1803.1"'] = 'work-copy="letters"';
$replace['work-copy="lt26oct1803.1"'] = 'work-copy="letters"';
$replace['work-copy="lt14jan1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt27jan1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt23feb1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt12march1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt16march1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt2april1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt7april1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt27april1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt4may1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt28may1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt22june1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt7aug1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt28sept1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt23oct1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt4dec1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt18dec1804.1"'] = 'work-copy="letters"';
$replace['work-copy="lt22jan1805.1"'] = 'work-copy="letters"';
$replace['work-copy="lt22march1805.1"'] = 'work-copy="letters"';
$replace['work-copy="lt4june1805.1"'] = 'work-copy="letters"';
$replace['work-copy="lt27nov1805.1"'] = 'work-copy="letters"';
$replace['work-copy="lt1825.1"'] = 'work-copy="letters"';
$replace['work-copy="lt7june1825.1"'] = 'work-copy="letters"';
$replace['work-copy="lt11oct1825.1"'] = 'work-copy="letters"';
$replace['work-copy="lt10nov1825.1"'] = 'work-copy="letters"';
$replace['work-copy="lt31jan1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt5feb1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt31march1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt19may1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt5july1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt14july1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt16july1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt29july1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt1aug1826.1"'] = 'work-copy="letters"';
$replace['work-copy="lt27jan1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt1827.1"'] = 'work-copy="letters"';
$replace['work-copy="ltfeb1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt15march1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt12april1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt25april1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt3july1827.1"'] = 'work-copy="letters"';
$replace['work-copy="lt15aug1827.1"'] = 'work-copy="letters"';

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

