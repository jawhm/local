<html>
<title>�p�����[�^�`�F�b�N</title>
<body>

�y�f�d�s�p�����[�^�z<br/>
<?
	$body = '';
	foreach($_GET as $post_name => $post_value){
		$body .= $post_name." : ".htmlspecialchars($post_value);
		$body .= '<br/>';
	}
	print $body;
?>

<br/>
<hr/>
<br/>

�y�o�n�r�s�p�����[�^�z<br/>
<?
	$body = '';
	foreach($_POST as $post_name => $post_value){
		$body .= $post_name." : ".htmlspecialchars($post_value);
		$body .= '<br/>';
	}
	print $body;
?>

<br/>
<hr/>
<br/>

�y�r�u�p�����[�^�z<br/>
<?
	$body = '';
	foreach($_SERVER as $post_name => $post_value){
		$body .= $post_name." : ".htmlspecialchars($post_value);
		$body .= '<br/>';
	}
	print $body;
?>

</body>
</html>
