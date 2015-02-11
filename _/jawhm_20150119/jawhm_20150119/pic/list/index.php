<?php
/*********************************************
シンプルギャラリー 3.01
http://php.lemon-s.com/
*********************************************/
//---------------設定ここから---------------

//このスクリプト名
define('PHP', "index.php");

//タイトル
define('TITLE', "Happy Times");

//見出し
define('TITLE2', "Photo Gallery");

//説明
define('INFO', "");

//読み込む画像形式
define('EXT', "jpg|gif|png");

//表示順(1=昇順 2=降順 3=ランダム)
define('SHUFFLE', 3);

//1ページの表示枚数
define('NUM', 20);

//画像の横幅
define('WIDTH', "200");

//カテゴリ(複数可)：ディレクトリ名(/なし)と名前
$dir = array(
"photo" => "Color",
);

//---------------設定ここまで---------------

header("Content-type: text/html; charset=UTF-8");

if($_GET["c"]){
	$c = $_GET["c"];
}else{
	$c = "top";
}
if($c == "top"){
	$del = '$("li.all").addClass("active");';
}else{
	$del = '$("li.none").remove();';
}

//ヘッダ
$head = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>'.TITLE.' - '.INFO.'</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="description" content="'.INFO.'" />
<meta name="keywords" content="'.TITLE.','.TITLE2.','.INFO.'" />
<link rel="stylesheet" href="./css/style.css" type="text/css" />
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery.lightbox.js"></script>
<script type="text/javascript" src="./js/easypaginate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".selecterBtns li.'.$c.'").addClass("active");
	$(".selecterContent li.'.$c.'").removeClass("none");
	'.$del.'
	$("a[rel^=lightbox]").lightBox();
	$(".selecterContent ul").easyPaginate({
		step:'.NUM.'
	});
});
</script>

<script language="JavaScript">
function rld()
{
	if (!document.getElementById(\'norld\').checked)	{
		location.reload();
	}
}
</script>

</head>
<body>
<div id="wrapper">
<h1>'.TITLE.'</h1>
<div class="info">'.INFO.'</div>
<div class="selecter selecter1">
';

//フッタ
$foot = '
<div id="foot">
<!--著作権表示削除不可-->
<div class="copy">Powered by : <a href="http://php.lemon-s.com/" target="_blank">Simple Gallery</a>.</div>
</div>
</div><!-- /selecte -->
</div><!-- /wrapper -->
</body>
</html>
';

function main(){
	global $dir,$mode,$name,$p,$c;
	$all = 0;
	$catlist = "";
	$imgrand = array();
	while(list ($key, $val) = each($dir)){
		if (is_dir($key)) {
			if ($dh = opendir($key)) {
				$catlist.= '<li class="'.$key.'"><a href="?c='.$key.'">'.$val.'</a></li>';
				while (($files = readdir($dh)) !== false) {
					$file[] = $files;
				}
				for($i=0;$i<count($file);$i++) {
					if(ereg(EXT,$file[$i])){
						if(exif_imagetype($key.'/'.$file[$i]) !== IMAGETYPE_JPEG){
							$exif_dat = "";
						}elseif(($exif = exif_read_data($key.'/'.$file[$i], 'IFD0', 1)) == FALSE){
							$exif_dat = "";
						}else{
							$com = $exif['EXIF']['UserComment'];
							$com = substr("$com", 8);
							$com = mb_convert_encoding($com ,"UTF-8", "UCS-2LE");
							$exif_dat = "メーカー:".$exif['IFD0']['Make'].",モデル:".$exif['IFD0']['Model'].",F値:".$exif['EXIF']['FNumber'].",露出時間:".$exif['EXIF']['ExposureTime'].",ISO:".$exif['EXIF']['ISOSpeedRatings'].",コメント:".$com."";
						}
						$imglist.= '<li class="'.$key.' none"><a href="'.$key.'/'.$file[$i].'" title="'.$val.','.$file[$i].','.$exif_dat.'" rel="lightbox_'.$c.'" class="kage">';
						$imglist.= '<img src="'.$key.'/'.$file[$i].'" alt="'.$file[$i].'" width="'.WIDTH.'" /></a></li>';
						$imgrand[] = $imglist;
						$imglist = "";
						$all++;
					}
				}
				closedir($dh);
				$file = array();
			}
		}
	}

	$main = '<div class="selecterBtns">
<ul class="nolist clearfix"><li class="all"><a href="'.PHP.'">ALL</a></li>'.$catlist.'</ul>
<h2>'.TITLE2.'</h2>
</div>
<div class="selecterContent">
<ul class="clearfix nolist">
';
	if(SHUFFLE == 1){
		sort($imgrand);
	}elseif(SHUFFLE == 2){
		rsort($imgrand);
	}else{
		shuffle($imgrand);
	}

	for($i=0;$i<count($imgrand);$i++){
		$main.= "$imgrand[$i]\n";
	}

	$main.= '</ul>
</div>
<p class="total">'.$all.' Photographs.</p>
';

	return $main;
}

echo "$head";
echo main();

?>
<script>
setInterval("rld()",60000);
</script>

　　<input type="checkbox" id="norld" name="norld">　リロードしない<br/>

<?

echo "$foot";

?>