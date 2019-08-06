	<head>
                <title>Blake/An Illustrated Quarterly <?php echo $pt; ?></title>
                <meta http-equiv="content-type" content="text/html;charset=utf-8" />
                <link rel="shortcut icon" href="img/general/favicon.ico" type="image/x-icon">
				<link rel="icon" href="img/general/favicon.ico" type="image/x-icon">
                <link rel="stylesheet" media="screen" href="style.css"></link>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
                <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js" type="text/javascript"></script>
                <script src="js/expand.js"></script>
                <script src="js/jquery.highlight.js"></script>
                <script src="js/bq.js"></script>
                <link rel="stylesheet" media="screen" href="js/fancybox/jquery.fancybox-1.3.4.css"></link>
                <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
                <?php
                if(basename($_SERVER['PHP_SELF']) == 'hdoc.php') {
					echo '<style>'.$styles.'</style>';
					echo $scripts;
                }
                ?>
    </head>
