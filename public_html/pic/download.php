<?php
ini_set( 'display_errors', 1 ); 

session_start();
$id = session_id();

$data = 'http://www.jawhm.or.jp/pic/pics/'.$id.'.png';

$mail1 = @$_GET['e'];
$mail2 = @$_GET['d'];

?>
<html>
<head>
<title>すまいるしょっと</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Refresh" content="1800;URL=./index.php">
<link rel="stylesheet" type="text/css" href="css/style.css" />

<script>
function fncEnter()	{

	var mail1 = document.getElementById('write').value;
	var mail2 = document.getElementById('ato').value;

	var mail = String(mail1 + mail2);

	if (!mail.match(/^[A-Za-z0-9]+[\w-]+@[\w\.-]+\.\w{2,}$/))	{
		$.blockUI({ message: $('#errorform'),
		css: { 
			top:  ($(window).height() - 500) /2 + 'px', 
			left: ($(window).width() - 1000) /2 + 'px', 
			width: '1000px' 
			}
		}); 
	}else{
		$('#mailadd').html(mail);
		$.blockUI({ message: $('#entryform'),
		css: { 
			top:  ($(window).height() - 500) /2 + 'px', 
			left: ($(window).width() - 1000) /2 + 'px', 
			width: '1000px' 
			}
		}); 
	}

}

function btn_cancel()	{
	$.unblockUI();
}
function fncEntry(mail)	{

	$('#entryform').html('<div style="font-size:26pt; color:navy; font-weight:bold; margin: 80px 0 80px 0;">エントリー中です...</div>');

	$.ajax({
		type: "POST",
		url: "./entry.php",
		data: "e=" + mail,
		success: function(msg){
			$('#entryform').html('<div style="font-size:26pt; color:navy; font-weight:bold; margin: 80px 0 80px 0;">ありがとうございました。<br/>エントリーが完了しました。</div>');
			setTimeout(function()	{
				$.unblockUI();
				document.location = './index.php';
			}, 10000);
		},
		error:function(){
			alert('通信エラーが発生しました。');
			$.unblockUI();
		}
	});

}

</script>

<style>
.button_cancel	{
	font-size:20pt;
	width: 220px;
	height: 80px;
}
.button_submit	{
	font-size:20pt;
	width: 320px;
	height: 80px;
}

</style>

</head>
<body>

<div id="entryform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">

	<div style="font-size:20pt; font-weight:bold; color:navy; margin:30px 0 10px 0;">
		以下のメールアドレスでよろしいですか？
	</div>
	<div id="mailadd" style="font-size:16pt; font-weight:bold; color:navy; margin:10px 0 50px 0;">
	</div>

	<input type="button" class="button_cancel" value=" 戻る " onclick="btn_cancel();">　　
	<input type="button" class="button_submit" value=" エントリーする " onclick="fncEntry($('#mailadd').html());">
	<div style="margin-top:30px;">&nbsp;</div>
</div>

<div id="errorform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="font-size:28pt; font-weight:bold; color:red; margin:50px 0 50px 0;">
		メールアドレスの入力に誤りがあります。<br/>
	</div>
	<input type="button" class="button_cancel" value=" 戻る " onclick="btn_cancel();">
	<div style="margin-top:30px;">&nbsp;</div>
</div>

<div style="margin-top:-60px;">&nbsp;</div>

<div id="container">
	<span style="font-size:22pt;">
		素敵な写真が取れたら、メアドを入力してエントリー！！<br/>
	</span>
	<table>
	<tr>
	<td>
		<textarea id="write" rows="1" cols="60" style="ime-mode:inactive;"><? echo $mail1; ?></textarea>
	</td>
	<td>
		<select id="ato" style="font: 1em/1.5 Verdana, Sans-Serif; font-size:32pt;">
			<option value="">[選択しない]</option>
			<option value="@docomo.ne.jp">@docomo.ne.jp</option>
			<option value="@softbank.ne.jp">@softbank.ne.jp</option>
			<option value="@i.softbank.jp">@i.softbank.jp</option>
			<option value="@hotmail.com">@hotmail.com</option>
			<option value="@yahoo.com">@yahoo.com</option>
		</select>
	</td>
	</tr>
	</table>

	<ul id="keyboard">
		<li class="symbol"><span class="off">`</span><span class="on">~</span></li>
		<li class="symbol"><span class="off">1</span><span class="on">!</span></li>
		<li class="symbol"><span class="off">2</span><span class="on">@</span></li>
		<li class="symbol"><span class="off">3</span><span class="on">#</span></li>
		<li class="symbol"><span class="off">4</span><span class="on">$</span></li>
		<li class="symbol"><span class="off">5</span><span class="on">%</span></li>
		<li class="symbol"><span class="off">6</span><span class="on">^</span></li>
		<li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
		<li class="symbol"><span class="off">8</span><span class="on">*</span></li>
		<li class="symbol"><span class="off">9</span><span class="on">(</span></li>
		<li class="symbol"><span class="off">0</span><span class="on">)</span></li>
		<li class="symbol"><span class="off">-</span><span class="on">_</span></li>
		<li class="symbol"><span class="off">=</span><span class="on">+</span></li>
		<li class="delete lastitem">DEL</li>
		<li class="tab">TAB</li>
		<li class="letter">q</li>
		<li class="letter">w</li>
		<li class="letter">e</li>
		<li class="letter">r</li>
		<li class="letter">t</li>
		<li class="letter">y</li>
		<li class="letter">u</li>
		<li class="letter">i</li>
		<li class="letter">o</li>
		<li class="letter">p</li>
		<li class="symbol"><span class="off">[</span><span class="on">{</span></li>
		<li class="symbol"><span class="off">]</span><span class="on">}</span></li>
		<li class="symbol lastitem"><span class="off">@</span><span class="on">|</span></li>
		<li class="capslock">Caps</li>
		<li class="letter">a</li>
		<li class="letter">s</li>
		<li class="letter">d</li>
		<li class="letter">f</li>
		<li class="letter">g</li>
		<li class="letter">h</li>
		<li class="letter">j</li>
		<li class="letter">k</li>
		<li class="letter">l</li>
		<li class="symbol"><span class="off">;</span><span class="on">:</span></li>
		<li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
		<li class="return lastitem" onclick="fncEnter();">Enter</li>
		<li class="left-shift">Shift</li>
		<li class="letter">z</li>
		<li class="letter">x</li>
		<li class="letter">c</li>
		<li class="letter">v</li>
		<li class="letter">b</li>
		<li class="letter">n</li>
		<li class="letter">m</li>
		<li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
		<li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
		<li class="symbol"><span class="off">/</span><span class="on">?</span></li>
		<li class="right-shift lastitem">Shift</li>
	</ul>
</div>


	<table style="margin:70px 0 0 440px;">
	<tr>
		<td>
			<div style="border:5px dotted orange; text-align:center; padding: 20px 40px 20px 40px; font-size:18pt;">
				あなたの写真はこちら。ハッピースマイルできてるかなぁ？<br/>
				&nbsp;<br/>
				<img src="<? echo $data; ?>" width="320px" height="240px"><br/>
				&nbsp;<br/>
				<input type="button" value="もう一度、写真を撮り直す" onclick="document.location='./picture.html'" style="font-size:16pt; width:340px; height:60px;">
			</div>
		</td>
		<td>
			<div style="border:0px dotted orange; text-align:center; padding: 10px 20px 10px 20px; margin-left:100px; font-size:16pt; font-weight:bold;">
				このＱＲから写真が見られるよ<br/>
				&nbsp;<br/>
				<img src="qr.php">
			</div>
		</td>
	</tr>
	</table>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

<script type="text/javascript" src="js/keyboard.js"></script>


</body>

</html>

