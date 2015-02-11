<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>たいとる</title>
<body>

<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$act = @$_POST['act'];

	if ($act == 'mail')	{

		$onamae = @$_POST['onamae'];
		echo '<a href="mailto:info@jawhm.or.jp?subject=メアドです&body='.$onamae.'">メールをする</a>';


	}else{
?>
	<form method="post" action="./meadoget.php">
		<input type="hidden" name="act" value="mail">
		お名前：<input type="text" size="30" name="onamae">
		<input type="submit" value="ＯＫ">
	</form>
<?php
	}

?>

</body>
</html>
