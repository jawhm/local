<?
	header("Content-Type: text/html; charset=utf-8");
?>
<html>
<head>
<title>アイコンリスト</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="JavaScript" type="text/JavaScript">
function copytext(arg){
    var obj=document.all && document.all(arg) || document.getElementById && document.getElementById(arg);
    if (obj.value) {
        var doc = document.body.createTextRange();
        doc.moveToElementText(obj);
        doc.execCommand("copy");
        alert('クリップボードにコピーしました。');
    } else {
        alert('コピーするデータがありません。');
    }
}
</script>
</head>
<body>

<?php

$rep = 0; // 最終更新日(表示=1 非表示=0)
$sze = 0; // ファイルサイズ(表示=1 非表示=0)
$lst = "../event/getlist/img"; // 表示するリストの名前(パス)
$url = "http://www.jawhm.or.jp/event/getlist/img/";

/*
$drc=dir($lst);
print("<table border=1>");

while($fl=$drc->read()) {
	$lfl = $lst."/".$fl;
	$din = pathinfo($lfl);
	if(is_dir($lfl) && ($fl!=".." && $fl!=".")){
		print("<tr><td>".$din["basename"]."<FONT size='-1'> (ディレクトリ)</FONT></td></tr>");
	} else if($fl!=".." && $fl!=".") {
		print("<tr>");
		print("<td><img src=".$lst."/".$fl."></td>");
		print("<td><a href=".$lst."/".$fl.">&lt;img src=\"".$url.$fl."\"&gt;</a></td>");
//		print("<td><input type=button value='コピー' onclick='copytext(\"".$url.$fl."\")'></td>");
		// ファイル更新日
		if($rep == 1 || $sze == 1) print("<FONT size='-1'> (");
		if($rep == 1) echo date("m/d",filemtime($lfl));
		if($rep == 1 && $sze == 1) print(", ");
		// ファイルサイズ
		if($sze == 1) echo round(filesize($lfl)/1024)."KB";
		if($rep == 1 || $sze == 1) print(")</FONT> ");
		print("</tr>");
	}
}
print("</OL>");
$drc->close();
*/

$filelist = scandir( $lst );
print("<table border=1>");
for ($idx=0; $idx<count($filelist); $idx++)	{
	if ($filelist[$idx] <> '.' && $filelist[$idx] <> '..')	{
		print ('<tr><td><img src="'.$lst.'/'.$filelist[$idx].'"></td>');
		print ('<td>&lt;img src="'.$url);
		print ($filelist[$idx]);
		print ('"&gt;</td></tr>');
	}
}
print ("</table>");
?>

</body>
</html>
