                    <div id="header">
                        <div id="header-inner">
                        	<div id="logo-search">
								<div id="logo">
                            		<a href="<?php echo $root; ?>">d b<br/>q p</a>
                            	</div>
                            	<div id="archive-label">
									<a href="<?php echo $root; ?>"><span>Deus Benedicet Qui Patiuntur <em>Project</em></span></a>
								</div>
                            	<div class="clear"></div>
                            </div>
                            <div id="global_nav">
                                <a href="<?php echo $root; ?>">Issues</a> | <a href="articles.php">Articles</a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
					<div id="minMaxVI" style="display:none;"><?php 
					if($_SERVER['SERVER_NAME'] != 'localhost') {
						echo '<span id="minVol">'.$minVol.'</span><span id="minIss">'.$minIss.'</span><span id="maxVol">'.$maxVol.'</span><span id="maxIss">'.$maxIss.'</span>'; 
					}
					?></div>
