<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.4                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

// Check if the file is accessed only via index.php if not stop the script from running
if (!defined('JAK_PREVENT_ACCESS')) die('You cannot access this file directly.');

if ($page1 != $mycheck) jak_redirect(BASE_URL);

?>

<!DOCTYPE html>
<html lang="<?php echo $BT_LANGUAGE;?>">
<head>
	<title><?php echo JAK_TITLE;?></title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="JAKWEB" />
	<link rel="stylesheet" href="<?php echo BASE_URL;?>css/stylesheet.css" type="text/css" media="screen" />
	
	<!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	 <![endif]-->
	 
	 <!-- Le fav and touch icons -->
	 <link rel="shortcut icon" href="<?php echo BASE_URL;?>img/ico/favicon.ico">
	 
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Installation Check</h1>
			<ul>
				<li>Full Site Domain: <?php echo FULL_SITE_DOMAIN;?></li>
				<li>License Number: <?php echo JAK_O_NUMBER;?></li>
				<li>Main Email Address: <?php echo JAK_EMAIL;?>
				<li>PHP Version: <?php echo PHP_VERSION;?></li>
				<li>Version: <?php echo JAK_VERSION;?></li>
			</ul>
		</div>
	</div>
</div>

</body>
</html>