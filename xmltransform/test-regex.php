<!DOCTYPE html>
<html>
<?php
//ini_set('memory_limit', '500M');
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require('include/functions.php');
	
$nl = "
";
								
?>
	<body>
        <div id="outer">
				
			<div id="content">
				<div id="content-inner">
					<div id="issue-heading">
						<div class="issue-heading-inner">
							<h1>Test Regex</h1>
						</div>
					</div>
					<div id="main">
						<div id="allIssues">
			
						<?php
							$fn = array();
							$fn_t['text'] = 'Foley, Matthew Joseph. "English Printing &amp; Book Illustration
                        1780-1820." Diss. University of California, Santa Cruz, 1977.
                        Dissertation Abstracts International, 38 (1978), 6368-A.';
							
							mb_regex_encoding('UTF-8');
							mb_internal_encoding("UTF-8");
						
									// All delimiters (newline, tab, mdash, hyphen, space) are now space
									$fn_t['text'] = mb_ereg_replace('[\s—-]+', ' ', $fn_t['text']);
									// Strip punctuation from beginnings of words (after space)
									$fn_t['text'] = mb_ereg_replace(" [†\|\{#\$£§\*\[\(“'‘]{1,}", ' ', $fn_t['text']);
									$fn_t['text'] = str_replace(' "', ' ', $fn_t['text']);
									// Strip punctuation from ends of words (before space)
									$fn_t['text'] = mb_ereg_replace("[†\|,!\.\?;:’'”\)\]\*\}]{1,} ", ' ', $fn_t['text']);
									$fn_t['text'] = str_replace('" ', ' ', $fn_t['text']);
									// Remove "words" that consist only of numbers and symbols
									$fn_t['text'] = mb_ereg_replace(" [\$¢£¥€0-9⅛⅙⅕¼⅖⅜⅓½⅝¾⅞\*\{\[\(“'‘,!\.\?;:’'”\)\]\}#\+&\/%:°;§©×•∞–−\-′″‴=<>·º\|_¶ ]{1,} ", ' ', $fn_t['text']);
							
							echo '<p>'.$fn_t['text'].'</p>';
						?>
						</div> <!-- #allIssues -->
					</div> <!-- #main -->
				</div> <!-- #content-inner -->
			</div> <!-- #content -->
		</div> <!-- #outer -->
	</body>
</html>

