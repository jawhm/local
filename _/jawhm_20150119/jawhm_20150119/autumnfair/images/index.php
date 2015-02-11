<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>一般社団法人 日本ワーキング・ホリデー協会　秋の留学＆ワーキングホリデーフェア2011</title>

<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館," />

<meta name="description" content="オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />

<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="一般社団法人 日本ワーキング・ホリデー協会" />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />
<link href="http://www.jawhm.or.jp/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://www.jawhm.or.jp/js/jquery.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/jquery-easing.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/scroll.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/linkboxes.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/jquery.tipTip.minified.js"></script>

<link href="http://www.jawhm.or.jp/css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="css/contents_wide.css" rel="stylesheet" type="text/css" />
<link href="css/tipTip.css" rel="stylesheet" type="text/css" />

<style>
.button_yoyaku	{
	background-color: navy;
	color: white;
	cursor: pointer;
	padding: 0 5px 0 5px;
	margin: 0 0 3px 0;
	font-weight: bold;
}
.button_submit	{
	background: url(../images/button_submit.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_cancel	{
	background: url(../images/button_cancel.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_next	{
	background: url(../images/button_next.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

</style>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20563699-1']);
  _gaq.push(['_setDomainName', '.jawhm.or.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>
$(function(){  
	$('.tip').tipTip( { delay:0, maxWidth:"600px", keepAlive:true,
		enter:function()	{

		}
	 } );
}); 

function fnc_next()	{
	document.getElementById('form1').style.display = 'none';
	document.getElementById('form2').style.display = '';
}

function fnc_nittei(id)	{
	$.blockUI({ message: $('#nittei_'+id),
	css: { 
		top:  ($(window).height() - 500) /2 + 'px', 
		left: ($(window).width() - 600) /2 + 'px', 
		width: '600px' 
	}
 }); 
}

function fnc_yoyaku(obj)	{
	document.getElementById('form1').style.display = '';
	document.getElementById('form2').style.display = 'none';

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = 'none';
	document.getElementById('form_title').innerHTML = obj.getAttribute('title');
	document.getElementById('txt_title').value = obj.getAttribute('title');
	document.getElementById('txt_id').value = obj.getAttribute('uid');
	$.blockUI({ message: $('#yoyakuform'),
	css: { 
		top:  ($(window).height() - 500) /2 + 'px', 
		left: ($(window).width() - 600) /2 + 'px', 
		width: '600px' 
	}
 }); 
}

function btn_cancel()	{
	document.getElementById('form1').style.display = '';
	document.getElementById('form2').style.display = 'none';
	$.unblockUI();
}

function btn_nittei_hide()	{
	$.unblockUI();
}

function btn_submit()	{
	obj = document.getElementById('txt_name');
	if (obj.value == '')	{
		alert('お名前（氏）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_name2');
	if (obj.value == '')	{
		alert('お名前（名）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_furigana');
	if (obj.value == '')	{
		alert('フリガナ（氏）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_furigana2');
	if (obj.value == '')	{
		alert('フリガナ（名）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_mail');
	if (obj.value == '')	{
		alert('メールアドレスを入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_tel');
	if (obj.value == '')	{
		alert('電話番号を入力してください。');
		obj.focus();
		return false;
	}

	if (!confirm('ご入力頂いた内容を送信します。よろしいですか？'))	{
		return false;
	}

	$senddata = $("form").serialize();

	document.getElementById("div_wait").style.display = '';

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "../yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait").style.display = 'none';
			alert(msg);
			$.unblockUI();
		},
		error:function(){
			alert('通信エラーが発生しました。');
			$.unblockUI();
		}
	});
}

</script>


</head>
<body>

<?
	// イベント読み込み
	$cal = array();

	$tyo_ymd   = array();
	$tyo_title = array();
	$tyo_desc  = array();
	$tyo_img   = array();
	$tyo_btn   = array();
	$tyo_id	   = array();
	$tyo_msg   = array();

	$osa_ymd   = array();
	$osa_title = array();
	$osa_desc  = array();
	$osa_img   = array();
	$osa_btn   = array();
	$osa_id	   = array();
	$osa_msg   = array();

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
//		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 ORDER BY hiduke, starttime, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];
			$aridx  = $row['id'];

			if ($row['place'] == 'tokyo')	{
				// 東京
				$tyo_id[$aridx] = $row['id'];
				$tyo_ymd[$aridx] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$tyo_title[$aridx]	= $row['k_title1'].'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$tyo_title[$aridx] = $row['k_title1'];
					}
				}else{
					$tyo_title[$aridx] = $row['k_title1'];
				}
				$tyo_desc[$aridx]  = $row['k_desc2'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$tyo_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
					}else{
						$tyo_img[$aridx]   	= '<img src="../images/semi_now.jpg">';
					}
				}elseif ($row['k_stat'] == 2)	{
					$tyo_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$tyo_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$tyo_img[$aridx]   	= '<img src="../images/semi_now.jpg">';
						}else{
							$tyo_img[$aridx]	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$tyo_btn[$aridx]	= '';
					}else{
						if ($row['k_stat'] == 2)	{
							$tyo_btn[$aridx]	= '';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}else{
								$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[東京]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$tyo_btn[$aridx]	= '';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}else{
							$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[東京]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}
					}
				}

				$msg = '';
				$msg .= '<div style="font-size:11pt;">';
				if ($tyo_ymd[$aridx] < date('Ymd'))	{
					$msg .= '終了しました　<s>'.$tyo_title[$aridx].'</s>';
				}else{
					$msg .= $tyo_btn[$aridx].'&nbsp;&nbsp;'.$tyo_title[$aridx];
				}
				$msg .= '<table style="font-size:8pt;"><tr><td>'.$tyo_img[$aridx].'</td>';
				$msg .= '<td><p>'.nl2br($tyo_desc[$aridx]).'</p></td></tr></table>';
				$msg .= '</biv>';

				$tyo_msg[$aridx]   = mb_ereg_replace('"', '', $msg);

			}

			if ($row['place'] == 'osaka')	{
				// 大阪
				$osa_id[$aridx] = $row['id'];
				$osa_ymd[$aridx] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$osa_title[$aridx]	= $row['k_title1'].'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="./member">ログイン</a>するとご予約が可能となります。</div>';
					}else{
						$osa_title[$aridx] = $row['k_title1'];
					}
				}else{
					$osa_title[$aridx] = $row['k_title1'];
				}
				$osa_desc[$aridx]  = $row['k_desc2'];
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$osa_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
					}else{
						$osa_img[$aridx]   	= '<img src="../images/semi_now.jpg">';
					}
				}elseif ($row['k_stat'] == 2)	{
					$osa_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$osa_img[$aridx]   	= '<img src="../images/semi_full.jpg">';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$osa_img[$aridx]   	= '<img src="../images/semi_now.jpg">';
						}else{
							$osa_img[$aridx]	= '';
						}
					}
				}
				if ($row['free'] == 1)	{
					if ($mem_id == '')	{
						$osa_btn[$aridx]	= '';
					}else{
						if ($row['k_stat'] == 2)	{
							$osa_btn[$aridx]	= '';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}else{
								$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$osa_btn[$aridx]	= '';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}else{
							$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}
					}
				}

				$msg = '';
				$msg .= '<div style="font-size:11pt;">';
				if ($osa_ymd[$aridx] < date('Ymd'))	{
					$msg .= '終了しました　<s>'.$osa_title[$aridx].'</s>';
				}else{
					$msg .= $osa_btn[$aridx].'&nbsp;&nbsp;'.$osa_title[$aridx];
				}
				$msg .= '<table style="font-size:8pt;"><tr><td>'.$osa_img[$aridx].'</td>';
				$msg .= '<td><p>'.nl2br($osa_desc[$aridx]).'</p></td></tr></table>';
				$msg .= '</biv>';

				$osa_msg[$aridx]   = mb_ereg_replace('"', '', $msg);

			}

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>


<!-- 東京  １０月７日 -->
<div id="nittei_tyo1007" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="45%" style="text-align:center; font-size:14pt;">
					【１０月７日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['487']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['504']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>			
<br/>
			<img  src="images/2.gif" /> <img  src="images/cicsemi.gif" /><br/>
			<? echo $tyo_btn['490']; ?>　<b>13:00～　（対象国：オーストラリア）<br/></b>
			<font size="1">
				
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/kgibcsemi.gif" /><br/>
			<? echo $tyo_btn['491']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
			<br/>
			</font>
			<br/><br/>
			<div align="center">
				<img  src="images/time/1007.gif" />
			</div>
		</div>
	</div>
</div>

<!-- 東京  １０月８日 -->
<div id="nittei_tyo1008" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月８日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['479']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['506']; ?>　<b>12:00～　(対象国：オーストラリア)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/ilscsemi.gif" /><br/>
			<? echo $tyo_btn['483']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/brownssemi.gif" /><br/>
			<? echo $tyo_btn['484']; ?>　<b>14:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1008.gif" />
			</div>
		</div>
	</div>
</div>

<!-- 東京  １０月９日 -->
<div id="nittei_tyo1009" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月９日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['480']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['507']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性・現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/inforumsemi.gif" /><br/>
			<? echo $tyo_btn['485']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/ilacsemi.gif" /><br/>
			<? echo $tyo_btn['486']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1009.gif" />
			</div>
		</div>
	</div>
</div>


<!-- 東京  １０月１０日 -->
<div id="nittei_tyo1010" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１０日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['488']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['508']; ?>　<b>12:00～　(対象国：オーストラリア)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/vivasemi.gif" /><br/>
			<? echo $tyo_btn['492']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1010.gif" />
			</div>
		</div>
	</div>
</div>



<!-- 東京  １０月１１日 -->
<div id="nittei_tyo1011" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１１日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['528']; ?>　予約する＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['528']; ?>　<b>14:00～　(対象国：デンマーク)</b><br/>
			<font size="1">
			・デンマークの魅力・ビザの内容・現地での生活・お仕事/お住まいの探し方　…等々
				<br/>
			</font>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1011.gif" />
			</div>
		</div>
	</div>
</div>




<!-- 東京  １０月１２日 -->
<div id="nittei_tyo1012" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１２日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['529']; ?>　予約する＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['529']; ?>　<b>14:00～　(対象国：フランス)</b><br/>
			<font size="1">
			・フランスの魅力・ビザの内容・語学学校の必要性・現地で出来ること<br/>
			・フランス語の伸ばし方等・現地でのお仕事/お住まいの探し方・経験談　．．．<br/>
<br/>
			:::フランス経験のあるスタッフによるフランスセミナー:::<br/>
				<br/>
			</font>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1012.gif" />
			</div>
		</div>
	</div>
</div>

<!-- 東京  １０月１３日 -->
<div id="nittei_tyo1013" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１３日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['530']; ?>　予約する＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['506']; ?>　<b>14:00～　(対象国：イギリス)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
				<br/>
			</font>
			<br/>
			<div align="center">
				<img  src="images/time/1013.gif" />
			</div>
		</div>
	</div>
</div>





<!-- 東京  １０月１７日 -->
<div id="nittei_tyo1017" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１７日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['518']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/nzsemi.gif" /><br/>
			<? echo $tyo_btn['519']; ?>　<b>12:00～　(対象国：ニュージーランド)</b><br/>
			<font size="1">
				ニュージランド大使館の方による特別セミナーです。滅多にない機会ですので是非ご参加下さい。<br>
			</font>			
<br/>
			<img  src="images/2.gif" /> <img  src="images/nzlcsemi.gif" /><br/>
			<? echo $tyo_btn['497']; ?>　<b>13:00～　（対象国：ニュージーランド）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/><br/>
			<div align="center">
				<img  src="images/time/1017.gif" />
			</div>
		</div>
	</div>
</div>





<!-- 東京  １０月２０日 -->
<div id="nittei_tyo1020" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月２０日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['489']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $tyo_btn['523']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>
	<br/>
			<img  src="images/2.gif" /> <img  src="images/selcsemi.gif" /><br/>
			<? echo $tyo_btn['493']; ?>　<b>13:00～　（対象国：オーストラリア）</b><br />
			</font>
<br/>
			<img  src="images/3.gif" /> <img  src="images/kgicsemi.gif" /><br/>
			<? echo $tyo_btn['494']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
			<br/>
				<br/>
			</font>
				<br/>
			</font>

			<div align="center">
				<img  src="images/time/1020.gif" />
			</div>
		</div>
	</div>
</div>


<!-- 東京  １０月２１日 -->
<div id="nittei_tyo1021" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月２１日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['539']; ?>　予約する＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/ausseminar.gif" /><br/>
			<? echo $tyo_btn['539']; ?>　<b>13:00～</b><br/>
			<font size="1">
				オーストラリア大使館の方による特別セミナーです。滅多にない機会ですので是非ご参加下さい。<br>
			</font>
	<br/>
				<br/>
			</font>

			<div align="center">
				<img  src="images/time/1021.gif" />
			</div>
		</div>
	</div>
</div>


<!-- 大阪  １０月７日 -->
<div id="nittei_osa1007" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月７日開催内容】
				</td>

				<td>
				<img  src="images/osakaform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['498']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['525']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>			
<br/>
			<img  src="images/2.gif" /> <img  src="images/cicsemi.gif" /><br/>
			<? echo $osa_btn['499']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/kgibcsemi.gif" /><br/>
			<? echo $osa_btn['500']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
				<br/>
			</font>
			<br/><br/>
			</div>
		</div>
	</div>
</div>

<!-- 大阪  １０月８日 -->
<div id="nittei_osa1008" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月８日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['502']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['509']; ?>　<b>12:00～　(対象国：オーストラリア)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/ilscsemi.gif" /><br/>
			<? echo $osa_btn['503']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/brownssemi.gif" /><br/>
			<? echo $osa_btn['505']; ?>　<b>14:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>

<!-- 大阪  １０月９日 -->
<div id="nittei_osa1009" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月９日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['510']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['511']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性・現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/inforumsemi.gif" /><br/>
			<? echo $osa_btn['512']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<img  src="images/3.gif" /> <img  src="images/ilacsemi.gif" /><br/>
			<? echo $osa_btn['513']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>


<!-- 大阪  １０月１０日 -->
<div id="nittei_osa1010" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１０日開催内容】
				<td>
				<img  src="images/osakaform.gif" />
				</td>

				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['514']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['515']; ?>　<b>12:00～　(対象国：オーストラリア)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				<br/>
			</font>
			<img  src="images/2.gif" /> <img  src="images/vivasemi.gif" /><br/>
			<? echo $osa_btn['516']; ?>　<b>13:00～　（対象国：オーストラリア）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>

<!-- 大阪  １０月１３日 -->
<div id="nittei_osa1013" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１３日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['526']; ?><b>15：00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>			
<br/>
			<img  src="images/2.gif" /> <img  src="images/cicsemi.gif" /><br/>
			<b>　　　（オーストラリア・カナダ）</b><br/>
			<br/>
	<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['481']; ?><b>17：00～　(対象国：オーストラリア)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>
<br/>
			<img  src="images/2.gif" /> <img  src="images/brownssemi.gif" /><br/>
			<b>　　　（対象国：オーストラリア）</b><br/>


				<br/>
			</font>
			<br/><br/>
			</div>
		</div>
	</div>
</div>



<!-- 大阪  １０月14日 -->
<div id="nittei_osa1014" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１４日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><b>＜＜<? echo $osa_btn['527']; ?>　11:00～ 予約する＞＞</b></div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			　<b>11:00～　(対象国：カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>
	<br/>
			<img  src="images/2.gif" /> <img  src="images/kgicsemi.gif" /><br/>
			　<b>　（対象国：カナダ）</b><br />
			</font>
				<br/>
			</font>
		</div>
	</div>
</div>






<!-- 大阪  １０月１７日 -->
<div id="nittei_osaka1017" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月１７日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><b>＜＜<? echo $osa_btn['517']; ?>　予約する＞＞</b></div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/nzsemi.gif" /><br/>
			　<b>12:00～　(対象国：ニュージーランド)</b><br/>
			<font size="1">
				ニュージランド大使館の方による特別セミナーです。滅多にない機会ですので是非ご参加下さい。<br>
			</font>			
<br/>
			<img  src="images/2.gif" /> <img  src="images/nzlcsemi.gif" /><br/>
			　<b>13:00～　（対象国：ニュージーランド）</b>
			<font size="1">
				<br/>
				<br/>
			</font>
			<br/><br/>
		</div>
	</div>
</div>


<!-- 大阪  １０月２０日 -->
<div id="nittei_osa1020" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月２０日開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['520']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/seminar1.gif" /><br/>
			<? echo $osa_btn['524']; ?>　<b>12:00～　(対象国：オーストラリア・カナダ)</b><br/>
			<font size="1">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
			</font>
	<br/>
			<img  src="images/2.gif" /> <img  src="images/selcsemi.gif" /><br/>
			<? echo $osa_btn['521']; ?>　<b>13:00～　（対象国：オーストラリア）</b><br />
			</font>
<br/>
			<img  src="images/3.gif" /> <img  src="images/kgicsemi.gif" /><br/>
			<? echo $osa_btn['522']; ?>　<b>14:00～　（対象国：カナダ）</b>
			<font size="1">
			<br/>
				<br/>
			</font>
				<br/>
			</font>
		</div>
	</div>
</div>

<!-- 大阪  １０月２１日 -->
<div id="nittei_osa1021" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月２１日開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['540']; ?>　予約する＞＞</div>
		<div style="line-height:1.2">
			<img  src="images/1.gif" /> <img  src="images/ausseminar.gif" /><br/>
			<? echo $tyo_btn['540']; ?>　<b>13:00～</b><br/>
			<font size="1">
				オーストラリア大使館の方による特別セミナーです。滅多にない機会ですので是非ご参加下さい。<br>
			</font>
	<br/>
				<br/>
			</font>

			<div align="center">
				<img  src="images/time/1021.gif" />
			</div>
		</div>
	</div>
</div>







<div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">

	<div id="form1" style="display:none;">

		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			セミナーのご予約に際し、以下の内容をご確認ください。
		</div>

		<div style="font-size:9pt; font-weight:; text-align:left; margin:10px 0 10px 20px;">
			１．　このフォームでは、仮予約の受付を行います。<br/>
			　　　予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>
			　　　ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされ<br/>
			　　　セミナーにご参加頂けません。ご注意ください。<br/>
			&nbsp;<br/>
			２．　携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が<br/>
			　　　受信できるできる状態にしておいてください。<br/>
			&nbsp;<br/>
			３．　Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて<br/>
			　　　到着する場合があります。時間をおいてから受信確認を行うようにしてください。<br/>
			&nbsp;<br/>
			４．　予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>
			　　　なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。<br/>
			&nbsp;<br/>
			最近、会場を間違えてご予約される方が増えております。<br/>
			セミナー内容・会場・日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。<br/>
		</div>

		<div style="margin-top:10px;">
			<input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" value="次へ" onclick="fnc_next();">
		</div>

	</div>

	<div id="form2" style="display:none;">

	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

<?	if ($mem_id <> '')	{	?>
	<form name="form_yoyaku">
	<table style="width:560px;font-size:10pt;">
		<tr style="background-color:lightblue;">
			<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
			<td id="form_title" style="text-align:left;"></td>
			<input type="hidden" name="セミナー名" id="txt_title" value="">
			<input type="hidden" name="セミナー番号" id="txt_id" value="">
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><? echo $mem_namae; ?>様
				<input type="hidden" name="お名前" id="txt_name" value="<? echo $mem_namae; ?>" size=20>
				<input type="hidden" name="フリガナ" id="txt_furigana" value="<? echo $mem_furigana; ?>" size=20>
				<input type="hidden" name="メール" id="txt_mail" value="<? echo $mem_email; ?>" size=40><br/>
				<input type="hidden" name="電話番号" id="txt_tel" value="<? echo $mem_tel; ?>" size=20>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="<? echo $mem_country; ?>" size=50></td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>
	</table>
	</form>
<?	}else{		?>
	<form name="form_yoyaku">
	<table style="width:560px;font-size:10pt;">
		<tr style="background-color:lightblue;">
			<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
			<td id="form_title" style="text-align:left;"></td>
			<input type="hidden" name="セミナー名" id="txt_title" value="">
			<input type="hidden" name="セミナー番号" id="txt_id" value="">
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				(氏)<input type="text" name="お名前" id="txt_name" value="" size=10>
				(名)<input type="text" name="お名前2" id="txt_name2" value="" size=10>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">フリガナ&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				(氏)<input type="text" name="フリガナ" id="txt_furigana" value="" size=10>
				(名)<input type="text" name="フリガナ2" id="txt_furigana2" value="" size=10>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">メールアドレス&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				<input type="text" name="メール" id="txt_mail" value="" size=40><br/>
				<span style="font-size:8pt;">
				※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。<br/>
				</span>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">当日連絡の付く電話番号&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="電話番号" id="txt_tel" value="" size=20></td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="" size=50></td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>
		</tr>
		<tr>
			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">同伴者有無&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				<input type="checkbox" name="同伴者" id="txt_dohan"> 同伴者あり<br/>
				<span style="font-size:8pt;">
				　　※同伴者ありの場合、２人分の席を確保致します。<br/>
				　　※３名以上でご参加の場合は、メールにてご連絡ください。<br/>
				</span>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">今後のご案内&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="checkbox" name="メール会員" id="txt_mailmem" checked> このメールアドレスをメール会員(無料)に登録する</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>
	</table>
	</form>
<?	}	?>
	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
		このフォームでは仮予約を行います。<br/>
		予約確認のメールをお送りしますので、メールの指示に従って予約を確定させてください。<br/>
	</div>

	<div id="div_wait" style="display:none;">
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onclick="btn_submit();">

	</div>

</div>


<div id="header">
    <h1><a href="http://www.jawhm.or.jp/index.html"><img src="http://www.jawhm.or.jp/images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
  <img id="top-mainimg" src="http://www.jawhm.or.jp/images/top-mainimg.jpg" alt="" width="970" height="170" />
</div>
  <div id="contentsbox"><img id="bgtop" src="http://www.jawhm.or.jp/images/contents-bgtop.gif" alt="" />
  <div id="contents">

<div align="center"><img  src="images/topimage.jpg" width="950" /></div>

	<div id="maincontent" style="margin-left:40px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

		<div class="top-entry01" style="width:850px;">

　 <div align="center">
	<div align="left"  style="width:700px;" ><Font Size="2">　本年、オーストラリアとの協定から始まったワーキングホリデー制度が30周年を迎え、
		日本人がワーキングホリデーを使って生活できる国は11カ国まで増えました。
		そんな節目の年に、日本ワーキング・ホリデー協会では秋の留学＆ワーキングホリデーフェアを開催します。
		皆様が留学＆ワーキングホリデーを考えるきっかけとして、また、より一層素晴らしい留学＆ワーキング
		ホリデーにする為に、是非この機会にフェアにご参加下さい！</font><br /></div></div>

<br />
<!--<div align="center"><img  src="images/candobanner.jpg" /></div> -->


<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="800" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td>
				<img src="images/photo01.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"  align="left">
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/check1.gif" />
					</td>
					<td style="text-align:right;">
						<A Href="#school"><img src="images/school01.gif" /></a>
					</td>
					</tr>
				</table>
			<HR size="1" color="#000000" style="border-style:dotted">

			<Font Size="2">
				　現地の学校スタッフから直接お話を聞くことができます。
				今回ワーキングホリデー協定各国からたくさんの語学学校がフェアに参加します！
				自分に合った学校を探しましょう。</font>

			</td>
			</tr>
		</table>

	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

<br />

<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="800" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td>
				<img src="images/photo2.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"  align="left">
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/check2.gif" />
					</td>
					<td style="text-align:right;">
						<A Href="#tokyo"><img src="images/tokyo.gif" /></A>
						 <A Href="#osaka"><img src="images/osaka.gif" /></A><br />
					</td>
					</tr>
				</table>
				<HR size="1" color="#000000" style="border-style:dotted">
				<Font Size="2">　ビザの取り方から各国の魅力まで、初めてでもわかりやすく楽しいセミナーを行います。
						また、フェアでしか聞けない現地の学校スタッフによる特別セミナーも！</font>
			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

<br />

<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="800" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td>
				<img src="images/photo03.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"  align="left">
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/check3.gif" />
					</td>
					<td style="text-align:right;">
						 <A Href="#tokyo"><img src="images/tokyo.gif" /></A>
						 <A Href="#osaka"><img src="images/osaka.gif" /></A><br />
					</td>
					</tr>
				</table>
					<HR size="1" color="#000000" style="border-style:dotted">

				<Font Size="2">　まだイメージが湧かない方からすでにプランが決まっている方まで、
					実際に渡航経験のあるスタッフが皆様の留学・ワーホリをお手伝いします。なんでもご相談して下さい。</font>
			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

<br />


<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="800" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td>
				<img src="images/photo04.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"  align="left">
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/check4.gif" />
					</td>
					<td style="text-align:right;">
						<A Href="#taikendan"><img src="images/taikendan.gif" /></a>
					</td>
					</tr>
				</table>
			<HR size="1" color="#000000" style="border-style:dotted">

			<Font Size="2">
				　実際に留学・ワーキングホリデーに行った方のセミナー・ブースをご用意しております。
				経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！</font>

			</td>
			</tr>
		</table>

	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>



<br />

<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="800" height="100" background="images/back.gif" style="padding: 10px 20px 15px 20px;">
		<table>
			<tr>
			<td>
				<img src="images/photo05.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;" align="left">
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<img src="images/check5.gif" /><br />
					<HR size="1" color="#000000" style="border-style:dotted" width="620px;">
				<Font Size="2">　フェアにご参加して頂いた方全員にうれしい特典をいくつかご用意しております。<br/>
					　なにが貰えるかはお楽しみに！
				</font>
			</td>
			</tr>
		</table>

	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

<br /><br /><br />

<h2 class="sec-title">東京会場詳細</h2><br /><br />
<br /><br />

<div style="border: 2px dotted #cccccc; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;" >
			ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
<br/>
			<b><big>会場を選んで下さい。</big></b>
			<A Href="#tokyo"><img src="images/tokyo.gif" /></A>
				 <A Href="#osaka"><img src="images/osaka.gif" /></A><br />
<br />

			<div style="line-height:1.2"><b>【ご注意：予約フォームが正しく機能しない場合】</b><br />
			<font size="1.5">スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br />
			この場合、お手数ですが、以下の内容を <b>toiawase@jawhm.or.jp</b> までご連絡ください。<br />
			　・　参加希望のセミナー日程<br />
			　・　お名前<br />
			　・　当日連絡の付く電話番号<br />
			　・　興味のある国<br />
			　・　出発予定時期<br /></font></div>
<br />
		</div>

<br />
<br />
<h3 id="tokyo">　<img src="images/tokyocarendar.gif" >　　<A Href="#school"><img src="images/school01.gif" /></a></h3>
<div align="center">
<table border="0" bordercolor="black" cellspacing="0" cellpadding="0" width="839" style="font: 12px; color: #666666; background-image: url('images/carendar_tokyo.jpg'); background-position: left top;" >

<tr>
<td align="center" width="110" height="34" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">
          <div style="font-size:14pt"><font color="#767676"><b></b></div>
</td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1007');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/cic.gif">
		<img src="images/kgibc.gif">
	</div></div>
</td>
<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1008');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/ILSC.gif">
		<img src="images/browns.gif">
	</div></div>
</td>
</tr>

<tr>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1009');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/inforum.gif">
		<img src="images/ilac.gif">
		
	</div></div>
</td>


<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1010');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/viva.gif">
	</div></div>



<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1011');">
	<div style="line-height:0.5; margin-top:1px;">
		<img src="images/denmark.gif"></br>
	</div></div>
</td>


<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1012');">
	<div style="line-height:0.5; margin-top:1px;">
		<img src="images/france.gif"></br>
	</div></div>
</td>


<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1013');">
	<div style="line-height:0.5; margin-top:1px;">
		<img src="images/uk.gif"></br>
	</div></div>
</td>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1017');">
	<div style="line-height:0.5; margin-top:15px;">
		<img src="images/nz.gif"></br>
		<img src="images/nzlc.gif">
	</div></div>
</td>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1020');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/selc.gif"><img src="images/kgic.gif">
	</div></div>
</td>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1021');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aus.gif"></br>
	</div></div>
</td>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
</tr>
<tr>
<td align="center" height="80"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></font></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center"  style="color: #000000;">　</td>
<td align="center"  style="color: #000000;">　</td>
<td align="center"  style="color: #000000;">　</td>
<td align="center" 　style="color: #000000;">　</td>
<td align="center" 　style="color: #000000;">　</td>
</tr>
</table>
<font size=3><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=green>緑</font>⇒ニュージーランド語学学校セミナー</font></b>
</div>

<br />
<br />
<br />


<h2 class="sec-title">大阪会場詳細</h2><br />

<br /><br /><br />


<div style="border: 2px dotted #cccccc; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;" >
			ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
<br/>
			<b><big>会場を選んで下さい。</big></b>
			<A Href="#tokyo"><img src="images/tokyo.gif" /></A>
				 <A Href="#osaka"><img src="images/osaka.gif" /></A>
				 <br />
<br />

			<div style="line-height:1.2"><b>【ご注意：予約フォームが正しく機能しない場合】</b><br />
			<font size="1.5">スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br />
			この場合、お手数ですが、以下の内容を <b>toiawase@jawhm.or.jp</b> までご連絡ください。<br />
			　・　参加希望のセミナー日程<br />
			　・　お名前<br />
			　・　当日連絡の付く電話番号<br />
			　・　興味のある国<br />
			　・　出発予定時期<br /></font></div>
<br />
		</div>

<br />
<br />
<h3 id="osaka">　<img src="images/osakacarendar.gif" >　　<A Href="#school"><img src="images/school01.gif" /></a></h3>
<div align="center">
<table border="0" bordercolor="black" cellspacing="0" cellpadding="0" width="839" style="font: 12px; color: #666666; background-image: url('images/carendar_osaka.jpg'); background-position: left top;" >

<tr>
<td align="center" width="110" height="34" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
<td align="center" width="110" style="color: #000000;"></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">　</td>
<td align="center" style="color: #000000;">
          <div style="font-size:14pt"><font color="#767676"><b></b></div>
</td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1007');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/cic.gif">
		<img src="images/kgibc.gif">
	</div></div>
</td>
<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1008');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/ILSC.gif">
		<img src="images/browns.gif">
	</div></div>
</td>
</tr>

<tr>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1009');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/inforum.gif">
		<img src="images/ilac.gif">
	</div></div>
</td>


<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1010');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/viva.gif">
	</div></div>

<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1013');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/cic.gif"><img src="images/browns.gif">
	</div></div>
</td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1014');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/kgic.gif">
	</div></div>
</td>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osaka1017');">
	<div style="line-height:0.4; margin-top:15px;">
		<img src="images/nz.gif"></br><img src="images/nzlc.gif">
	</div></div>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1020');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/selc.gif"><img src="images/kgic.gif">
	</div></div>
</td>

<td align="center" height="80" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1021');">
	<div style="line-height:0.5; margin-top:20px;">
		<img src="images/aus.gif">
	</div></div>
</td>


<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
</tr>
<tr>
<td align="center" height="80"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></font></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
</tr>
<tr>
<td align="center" height="80" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
<td align="center"  style="color: #000000;">　</td>
<td align="center"  style="color: #000000;">　</td>
<td align="center"  style="color: #000000;">　</td>
<td align="center" 　style="color: #000000;">　</td>
<td align="center" 　style="color: #000000;">　</td>
</tr>
</table>
<font size=3><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=green>緑</font>⇒ニュージーランド語学学校セミナー</font><br />
</b>


</div>
<br />
<br /><br /><br />


<h2 class="sec-title" id="school">フェア参加校一覧</h2><br />
<br /><br />



<a href="browns.html" target="school"><img src="browns/tab.gif" ></a> <a href="ilac.html" target="school"><img src="ilac/tab.gif" ></a> <a href="ilsc.html" target="school"><img src="ilsc/tab.gif" ></a>
 <a href="inforum.html" target="school"><img src="inforum/tab.gif" ></a> <a href="viva.html" target="school"><img src="viva/tab.gif"></a><br/>
<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="850" height="2800" background="images/back.gif" style="padding: 0px 0px 0px 20px;">


<iframe src="top.html" width="800" height="2800" frameborder="0" name="school" marginwidth="0" marginheight="0" hspace="0" vspace="0">ここに未対応ブラウザ向けの内容</iframe>


</td>
      <td width="10" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>


<br />
<br />
<br />




<h2 class="sec-title" id="taikendan">帰国者体験談</h2><div align="center"><br /><br /><br />
<br />
<br />
<b><font size=4>＜＜帰国者体験談セミナー、ブースにご予約は必要ございません。ご自由にご参加下さい＞＞</font></b><br /><br />
<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="700" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						　<img src="images/kikokusya/1007.gif" />
					</td>
					</tr>
				</table>
				<HR size="1" color="#000000" style="border-style:dotted">
				<Font Size="2">初めての海外は高校1年の時メルボルンに3週間ホームステイでした。<br />
				海外旅行が好きで行った事がある国は、オーストラリア・アメリカ・カナダ・韓国・バリ・北京・イタリア・ベトナム・台湾・ハワイ・ニュージーランド。<br />
				<br />
				大学卒業後就職をした会社が海外営業部という部署になり英語が飛び交う環境の中で使える英語力がない無力感と英語を使えるようになりたいと思い
				5年働いた会社を辞めオーストラリアのワーキングホリデーで2年間過ごしました。体験としては語学学校、ラウンド、ファーム、ダイビング、仕事経験。<br />
				<br />
				海外に行くと決めた方、行くか行かないか悩んでいる方、興味はあるが、心配と不安が多い方へ行ったからこそ、見れた物、感じた事、
				出会えた仲間、トラブルをどう対処したか、初めて体験したホームシック等のお話しも踏まえながら、伝えたいメッセージも含めてお話しさせて頂きます。<br />
				体験談セミナーで皆様にお会い出来るのを楽しみにしております。<br />
				

				<br />
				<div align="center">
				<img src="images/kikokusya/1007photo.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"><br />
				（松村　奈保子）<br /></font>
<div align="right"><A Href="#tokyo"><img src="images/taikendan_link.gif" /></A></div>
				</div>


			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>





<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="700" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/kikokusya/1008.gif" />
					</td>
					</tr>
				</table>
				<HR size="1" color="#000000" style="border-style:dotted">
				<Font Size="2">初めてオーストラリアを訪れたのは高校1年生の時。<br />
				ブリスベンが私にとって初めてのオーストラリアでした。<br />
				そして、いつか必ず海外で勉強する！という目標を抱いたのもこの頃です。<br />
				その後も何度か旅行で訪れ、ケアンズからメルボルンまで、東側の主要都市は訪れています。<br />
				<br />
				そして海外留学の夢を叶えることなく学校を卒業してしまいましたが、ついに「その時」が来ました。<br />
				18歳の頃に「ワーホリ」という言葉を初めて知ってから数年がたち…念願のオーストラリアでのワーキングホリデーを実現させました。<br />
				<br />
				帰国後の就職を考え、資格取得を目指される方が多いですが、私もその一人でした。<br />
				語学学校で、日本ではあまり馴染みのない「IELTS（アイエルツ）」の準備コースを受講し、最終的に受験してから帰国しました。<br />
				オーストラリアのこと、海外での生活はもちろん、どんな資格を取得したら良いのか、他のコースと資格準備コースの違い等もお話いたします。<br />
				当日お会い出来ることを楽しみにしております。<br />
				

<br />
<div align="center">
<img src="images/kikokusya/1008photo.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"><br />
（水口　沙央理）<br /></font>
<div align="right"><A Href="#tokyo"><img src="images/taikendan_link.gif" /></A></div>

</div>


			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>





<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="700" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td>
				
			</td>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="620px;">
					<tr>
					<td>
						<img src="images/kikokusya/1009.gif" />
					</td>
					</tr>
				</table>
				<HR size="1" color="#000000" style="border-style:dotted">
				<Font Size="2">日本ではミュージシャンとして活動し、まったく英語が出来ないままカナダ・トロントにワーキングホリデーで渡航。<br />
						学校で英語を学びながらメキシカン料理とテキーラのショットバーで仕事をしてカナダ生活を１年間満喫する。<br />
						<br />
						日本に帰国後すぐにオーストラリアにワーキングホリデーで渡豪。<br />
						オーストラリアではセカンドワーキングホリデービザを取得のためにファームでスーパーバイザーをして通訳や仕事の割り振りなどの仕事も経験。<br />
						オーストラリアには約１年半滞在して、途中にニュージランドを車で一周もして2010年に帰国。<br />
						<br />
						いろいろな国の経験や英語がまったく話せなかった時の失敗談、海外での英語の伸ばし方などを話せればと思います。<br />

<br />
<div align="center">
<img src="images/kikokusya/1009photo.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"><br />
(永島　拓也)<br /></font>
<div align="right"><A Href="#tokyo"><img src="images/taikendan_link.gif" /></A></div>

</div>
			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>








<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="700" height="100" background="images/back.gif" style="padding: 15px 20px 15px 20px;">

		<table>
			<tr>
			<td width="5px">&nbsp;</td>
			<td>
				<table width="690px;">
					<tr>
					<td>
						<img src="images/kikokusya/1020.gif" />
					</td>
					</tr>
				</table>
				<HR size="1" color="#000000" style="border-style:dotted">
				<Font Size="2">初一人旅、初海外、すべてが初めての体験。<br />
				１６歳の時に、海外に行き、日本では経験できない事をたくさんしました。<br />
				英語がまったくできない私が、半年後には現地のハイスクールに!!!<br />
<br />
				英語はできなくてもいいんです！　渡航してから学びましょう！<br />
				当日は、英語の伸ばし方や、私が経験した事、ホームステイの事に関して、お話させて頂きます!!<br />
<br />
				また、学生ビザとワーキングホリデービザで悩んでいる方！　<br />
				両方ともに経験した、私からいいお話がが出来たらと思います!!<br />
				当日、みなさまと楽しい時間が過ごせるのを楽しみにしております！<br />
				

<br />
<div align="center">
<img src="images/kikokusya/1020photo.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"><br />
(翁長　幸三朗)<br /></font>
<div align="right"><A Href="#tokyo"><img src="images/taikendan_link.gif" /></A></div>

</div>
			</td>
			</tr>
		</table>
	</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

</div>


<br /><br /><br /><br /><br /><br /><br />



<div align="center">
<Table Borderline="0" cellpadding="30">
<Td>
▼ワーキング・ホリデーについて知りたい<br />
<a href="../system.html">・ワーキングホリデー制度について</a><br />
<a href="../start.html">・はじめてのワーキングホリデー</a><br />
<a href="../visa/visa_top.html">・ワーキングホリデー協定国（ビザ情報）</a><br />

<br />
▼お役立ち情報<br />
<a href="../info.html">・お役立ち情報</a><br />
<a href="../school.html">・語学学校（海外・国内）</a><br />
<a href="../support.html">・サポート機関（海外・国内）</a><br />
<a href="../service.html">・サービス（保険・アコモデーション等）</a><br />
<a href="../company.html">・会員企業一覧（企業会員について）</a><br />

</Td>

<Td>

▼協会について知りたい<br />
<a href="../about.html">・一般社団法人日本ワーキング・ホリデー協会について</a><br />
<a href="../mem/">・協会のサポート内容（メンバー登録）</a><br />
<br />
▼協会のサポートを受けたい<br />
<a href="../seminar.html">・無料セミナー</a><br />
<a href="../event.html">・イベントカレンダー</a><br />
<a href="../return.html">・帰国者の方へ</a><br />
<a href="../qa.html">・Q&A</a><br />
<a href="../trans.html"・翻訳サービス</a><br />
<a href="../gogaku-spec.html">・語学講座</a><br />
</Td>

<Td>
<br />

▼協賛企業を求めています<br />
<a href="../mem-com.html">・企業会員について（会員制度ご紹介・意義・メリット）</a><br />
<a href="../adv.html">・広告掲載のご案内</a><br />
<br />
<a href="../volunteer.html">・ボランティア・インターン募集</a><br />
<br />
<a href="../privacy.html">・個人情報の取り扱い</a><br />
<a href="../about.html#deal">・特定商取引に関する表記</a><br />
<a href="../sitemap.html">・サイトマップ</a><br />

<br />
<a href="../attention.html">・外国人ワーキング・ホリデー青年</a><br />
<br />
<a href="../access.html">・アクセス（東京本部）</a><br />


</Tr>
</Td>
</Table> 
</div>
		</div><!--top-entry01END-->

	</div><!--top-mainEND-->
	</div><!--maincontentEND-->

  </div><!--contentsEND-->
  </div><!--contentsboxEND-->
  <div id="footer">
    <div id="footer-box">
	<img src="http://www.jawhm.or.jp/images/foot-co.gif" alt="" />
	</div>
  </div>
</body>
</html>