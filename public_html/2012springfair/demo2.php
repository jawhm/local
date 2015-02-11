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
<script type="text/javascript" src="js/fitiframe.js?auto=0"></script>

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


<script>
$(function(){
     $('a img').hover(function(){
        $(this).attr('src', $(this).attr('src').replace('_off', '_on'));
          }, function(){
             if (!$(this).hasClass('currentPage')) {
             $(this).attr('src', $(this).attr('src').replace('_on', '_off'));
        }
   });
});
</script>


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
		top:  ($(window).height() - 600) /2 + 'px', 
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


<!--Make sure your page contains a valid doctype at the very top--><link rel="stylesheet" type="text/css" href="css/haccordion.css" /><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script><script type="text/javascript" src="js/haccordion.js">
/***********************************************
* Horizontal Accordion script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script><style type="text/css">

/*CSS for example Accordion #hc1*/

#hc1 li{
margin:0 3px 0 0; /*Spacing between each LI container*/
}

#hc1 li .hpanel{
padding: 5px; /*Padding inside each content*/
background: #91c835;
}

/*CSS for example Accordion #hc2*/

#hc2 li{
margin:0 0 0 0; /*Spacing between each LI container*/
border: 12px solid black;
}

#hc2 li .hpanel{
padding: 5px; /*Padding inside each content*/
background: #E2E9FF;
cursor: hand;
cursor: pointer;
}

</style>

<script type="text/javascript">
haccordion.setup({
	accordionid: 'hc1', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'600px', h:'400px'},
	selectedli: [0, true], //[selectedli_index, persiststate_bool]
	collapsecurrent: false //<- No comma following very last setting!

})

haccordion.setup({
	accordionid: 'hc2', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'600px', h:'400px'},
	selectedli: [-1, true], //[selectedli_index, persiststate_bool]
	collapsecurrent: true //<- No comma following very last setting!
})

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
						$tyo_title[$aridx]	= $row['k_title1'].'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
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
								$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}else{
								$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[東京A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$tyo_btn[$aridx]	= '';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}else{
							$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[東京A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
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
						$osa_title[$aridx]	= $row['k_title1'].'<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
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
								$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}else{
								$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[大阪A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$osa_btn[$aridx]	= '';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}else{
							$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[大阪A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
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
					【１０月７日（金）開催内容】
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


		<div style="line-height:1">
			<? echo $tyo_btn['504']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア・カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $tyo_btn['490']; ?>　13:00～　<b><font size=2><font color=red>海外大学生と交流</font>してみたい！<font size=2><font color=red>CIC／CWA</font>語学学校セミナー</font></font><br/></b>
			<div align="right">(<b>オーストラリア・カナダ</b>)</div><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			一般英語、TOEIC・TOEFL対策コース以外に、豊富なコースを持つ<br/>
			また、メルボルン大学の学生とのConversation Clubが週に4回あるのが魅力

			</font>			
<br/><br/>


			<? echo $tyo_btn['491']; ?>　14:00～<b><font size=2><font color=red>海外進学・国際人間</font>になる！</font><font color=red>KGIBC</font>語学学校セミナー</font></font></b>(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			「グローバル人材育成」を掲げ、世界を舞台に活躍できる人材育成により組んでいる学校<br/>
			</font>			
<br/>

			<b>【予約不要】</b>　<b><font size=2><font color=red>お金の持って行き方セミナー</font></b></font><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			留学、ワーキングホリデーをご予定のみなさん、大切なお金をどのような方法で持って行きますか？
			利便性と安全性を兼ね備えたベストな方法をスペシャリストがお話致します。
			たくさんある持って行き方の中で、であなたにあったお金の持って行き方とは？<br/>
			</font>
<br/>
			<? echo $tyo_btn['544']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>オーストラリア</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>


		</font>


			<br/>
			<div align="center">
				<img  src="images/time/1007.gif" />
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


</div>
<div id="header">
    <h1><a href="http://www.jawhm.or.jp/index.html"><img src="http://www.jawhm.or.jp/images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
</div>
  <div id="contentsbox"><img id="bgtop" src="http://www.jawhm.or.jp/images/contents-bgtop.gif" alt="" />
  <div id="contents">

	<div id="maincontent" style="margin-left:40px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

		<div class="top-entry01" style="width:850px;">

<h2 class="sec-title" id="school">フェア参加校一覧</h2><br />
<br />

<div id="hc1" class="haccordion">
	<ul>

	<li>	<div class="hpanel" style="width:500px">
		<a href=""><img src="03.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>
	<li>
		<div class="hpanel" style="width:500px">
		<a href=""><img src="01.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>
	<li>
		<div class="hpanel" style="width:500px">
		<a href=""><img src="04.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<a href=""><img src="02.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<a href=""><img src="05.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:600px">
		<a href=""><img src="00.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>


	</ul>
</div>

<p style="clear:center"><a href="javascript:haccordion.expandli('hc1', 0)">留学&ワーホリセミナー</a> | <a href="javascript:haccordion.expandli('hc1', 1)">語学学校セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 2)">講演会セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 3)">帰国者体験談</a> | <a href="javascript:haccordion.expandli('hc1', 4)">個別カウンセリング</a> | <a href="javascript:haccordion.expandli('hc1', 5)">春の留学＆ワーホリフェア</a> </p>


<br />





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