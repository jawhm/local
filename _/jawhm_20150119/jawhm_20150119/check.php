<html>
<title>ƒpƒ‰ƒ[ƒ^ƒ`ƒFƒbƒN</title>
<body>

y‚f‚d‚sƒpƒ‰ƒ[ƒ^z<br/>
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

y‚o‚n‚r‚sƒpƒ‰ƒ[ƒ^z<br/>
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

y‚r‚uƒpƒ‰ƒ[ƒ^z<br/>
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
