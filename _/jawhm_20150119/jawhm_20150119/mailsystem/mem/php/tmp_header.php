<?php

header("Content-Type: text/html; charset=utf-8");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<html>
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<script type="text/javascript" src="<?php echo $base; ?>js/base.js"></script>
<script type="text/javascript" src="<?php echo $base; ?>js/script.js"></script>
<!--
<link href="<?php echo $base; ?>css/screen.css" rel="stylesheet" type="text/css" />
-->
<link href="<?php echo $base; ?>css/contents.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>css/window.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $base; ?>css/sexybuttons.css" rel="stylesheet" type="text/css" />
<link id="calendar_style" href="<?php echo $base; ?>/css/simple.css" media="screen" rel="Stylesheet" type="text/css" />

<script src="<?php echo $base; ?>js/prototype.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/effects.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/protocalendar.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/lang_ja.js" type="text/javascript"></script>

<script src="<?php echo $base; ?>js/jquery.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/interface.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/window.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/jquery.blockUI.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/jquery.validate.js" type="text/javascript"></script>

<script type="text/javascript">
	jQuery.noConflict();
</script>

<?php
	if ($script <> '')	{
		print '<script>'.$script.'</script>';
	}
?>


</head>
<title><?php print $title; ?></title>
<body>

<center>
	<div class="bar_top" onclick="location.href='<?php print $url_full; ?>';">
		<?php print $title; ?>
	</div>
</center>

<?php
	if ($user_id <> '')	{
		print '<div id="bar_loginuser">';
		print '<span id="processing" style="color:white; display:none;">Processing... <img src="'.$base.'images/ajax-loader.gif">　　　　</span>';
		print 'USER : '.$user_name.'　&nbsp;　<input type="button" value="LOGOUT" class="button_logout" onclick="fnc_logout();">';
		print '</div>';
	}
?>

<div id="bar_status">
	<img src="images/waitting.gif">
</div>



