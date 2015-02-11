<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>すまいるしょっと</title>

<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />

<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="一般社団法人 日本ワーキング・ホリデー協会" />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />
<link href="css/base-fair.css" rel="stylesheet" type="text/css" />
<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="css/contents_wide.css" rel="stylesheet" type="text/css" />

<link rel='stylesheet' id='style-css'  href='css/diapo.css' type='text/css' media='all'> 
<script type='text/javascript' src='js/jquery.min.js'></script>
<!--[if !IE]><!--><script type='text/javascript' src='js/jquery.mobile-1.0b2.min.js'></script><!--<![endif]-->
<script type='text/javascript' src='js/jquery.easing.1.3.js'></script> 
<script type='text/javascript' src='js/jquery.hoverIntent.minified.js'></script> 
<script type='text/javascript' src='js/diapo.js'></script> 

<style>
section {
	display: block;
	overflow: hidden;
	position: relative;
}
</style>

<script>
$(function(){
	$('.pix_diapo').diapo( {thumbs : false } );
});

function fncjump()	{
	document.location='./picture.html';
}
</script>

</head>
<body onclick="fncjump();">
<center>

	<table style="margin:50px 0 60px 0;">
		<tr>
			<td>
				<div style="font-size:44pt; font-weight:bold; color:orange;">
					すまいるしょっと！！
				</div>
			</td>
			<td>
				HEY!! Just touch me!!
			</td>
		</tr>
	</table>

<!--
	<HR size="1" color="#000000" style="border-style:dotted">
-->

	    <section> 
	    	<div style="overflow:hidden; width:960px; margin-left: -20px; padding:0 20px;"> 
	                <div class="pix_diapo">
<?
	//ディレクトリ・ハンドルをオープン
	$res_dir = opendir( './pics/' );

	//ディレクトリ内のファイル名を１つずつを取得
	while( $file_name = readdir( $res_dir ) ){
		if (strpos($file_name, '.png') === false)	{
			// 出力しない
		}else{
			//取得したファイル名を表示
			print '<div data-thumb="./pics/'.$file_name.'">';
			print '<img src="./pics/'.$file_name.'">';
			print '</div>';
		}
	}

	//ディレクトリ・ハンドルをクローズ
	closedir( $res_dir );
?>

	              </div>
	        </div>
	    </section> 

</center>

</body>
</html>