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

</style><script type="text/javascript">
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

<!-- 東京  １０月８日 -->
<div id="nittei_tyo1008" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:14pt;">
					【１０月８日（土）開催内容】
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

<br/>
		<div style="line-height:1">
			<? echo $tyo_btn['506']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $tyo_btn['483']; ?>　13:00～　<b><font size=2><font color=red>TOEIC</font>を極める！<font size=2><font color=red>ILSC</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			質の高い教師陣やTOEIC等の英語検定対策コースの充実しており
			English　Only　Policyを徹底している学校</font>			
<br/><br/>


			<? echo $tyo_btn['484']; ?>　14:00～<b><font size=2><font color=red>英語を最大限伸ばす</font>コツ！</font><font color=red>BROWNS</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
ゴールドコーストとブリスベンにあり、４技能（読む・書く・聞く・話す）各々をレベル分けにより、<br/>
苦手な分野をしっかり勉強することができる学校<br/>			</font>			
<br/>


			<b>【予約不要】</b>　<b><font size=2><font color=red>お金の持って行き方セミナー</font></b></font><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			留学、ワーキングホリデーをご予定のみなさん、大切なお金をどのような方法で持って行きますか？
			利便性と安全性を兼ね備えたベストな方法をスペシャリストがお話致します。
			たくさんある持って行き方の中で、であなたにあったお金の持って行き方とは？<br/>
			</font>
<br/>
			<? echo $tyo_btn['545']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>オーストラリア</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>

		</font>

			
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月９日（日）開催内容】
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
<br/>

		<div style="line-height:1">
			<? echo $tyo_btn['507']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア・カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $tyo_btn['485']; ?>　13:00～<b><font size=2>ベストスクール<font color=red>世界第６位</font>！<font size=2><font color=red>Inforum</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
アットホームで生徒のケアに定評があり、エコツアーガイドなどの他にはないアクティビティー・プログラムが充実している。<br/>
世界各国から留学生が来る、国籍MIXが良い学校</font>			
<br/><br/>


			<? echo $tyo_btn['486']; ?>　14:00～　<b><font size=2><font color=red>遊びも勉強も資格も！</font>全てを叶える！</font><font color=red>ILAC</font>語学学校セミナー</font></font></b>　(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			トロント・バンクーバーにあり、日本人率が低く様々な国籍の生徒が通う大規模な学校<br/>
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
			<? echo $tyo_btn['546']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>オーストラリア・カナダ</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>

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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１０日（月）開催内容】
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

				<br/>

		<div style="line-height:1">
			<? echo $tyo_btn['508']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $tyo_btn['492']; ?>　13:00～　<b><font size=2><font color=red>実用的な会話術</font>を取得！<font size=2><font color=red>Viva</font>語学学校セミナー</font></font></b>　(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			Smart Talkコースでは日常的なものをトピックにしたり、ゲストスピーカを招いたりと<br/>
			実践的な授業内容によって英語を話す実力をつけることができる学校</font>			
<br/><br/>


			<? echo $tyo_btn['552']; ?>　14:00～　<b><font size=2><font color=red>オーストラリア</font>歩き方セミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				現地でのお仕事/お住まいの探し方・注意点をメインに
				カナダの魅力・各都市の案内・ビザの種類・出来ること・取得できる資格等<br/>
				カナダに留学＆ワーホリを考えている方オススメのセミナーです。<br/>
			</font>			
<br/>


			<b>【予約不要】</b>　<b><font size=2><font color=red>お金の持って行き方セミナー</font></b></font><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			留学、ワーキングホリデーをご予定のみなさん、大切なお金をどのような方法で持って行きますか？
			利便性と安全性を兼ね備えたベストな方法をスペシャリストがお話致します。
			たくさんある持って行き方の中で、であなたにあったお金の持って行き方とは？<br/>
			</font>
		</font>
<br/>
			<? echo $tyo_btn['547']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>オーストラリア</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>

		</font>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１１日（火）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="line-height:1">
			<? echo $tyo_btn['528']; ?>　14:00～　<b><font size=3><font color=red>デンマーク</font>初心者向けセミナー</font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
				・デンマークの魅力<br>
				・ビザの種類、内容<br/>
				・デンマークでの生活<br>
				・デンマークの学校<br>
				・デンマーク語について…等<br>
<br/>
				デンマークの留学＆ワーホリに興味がある方にオススメのセミナーです。<br/></font>
<br/>
		<font size="1">	※10月11日（火）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。


				<br/>
			</font>
			<br/>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１２日（水）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $tyo_btn['529']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>
<br/>

		<div style="line-height:1">

			<? echo $tyo_btn['529']; ?>　14:00～　<b><font size=3><font color=red>フランス</font>初心者向けセミナー</font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
			<b>:::フランス経験のあるスタッフによるフランスセミナー:::</b><br/>
<br/>
			・フランスの魅力<br>
			・ビザの種類、内容<br>
			・語学学校の必要性<br>
			・現地で出来ること<br/>
			・フランス語の伸ばし方等<br>
			・現地でのお仕事/お住まいの探し方・経験談　．．．<br/>
<br/>
			フランスの留学＆ワーホリに興味がある方にオススメのセミナーです。<br/></font>
<br/>
<br/>
			<? echo $tyo_btn['529']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>フランス</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>
<br/><br/><br/>
		<font size="1">	※10月12日（水）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。</font><br/>

				<br/>
				<br/>
			</font>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>

<!-- 東京  １０月１３日 -->
<div id="nittei_tyo1013" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１３日（木）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>

<br/>
		<div style="line-height:1">
			<? echo $tyo_btn['530']; ?>　14:00～　<b><font size=3><font color=red>イギリス</font>初心者向けセミナー</font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
				・イギリス各国の魅力<br>
				・ビザの種類、内容・語学学校の必要性<br>
				・現地で出来ること<br>
				・取得できる資格<br>
				・英語の伸ばし方…等<br>
<br/>
				イギリスの留学＆ワーホリに興味がある方にオススメのセミナーです。<br/></font>
<br/><br/>
			<? echo $tyo_btn['565']; ?>　17:00～　<br/><b><font size=2><font color=red>英語圏</font>初心者向けセミナー</font>（オーストラリア・カナダ・ニュージーランド・イギリス）</b></b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/><br/>

		<font size="1">	※10月13日（木）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。



			</font>			
<br/>
			</font>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>




<!-- 東京  １０月14日 -->
<div id="nittei_tyo1014" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="45%" style="text-align:center; font-size:14pt;">
					【１０月１４日（金）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
<br/>
		<div style="line-height:2">
			<? echo $tyo_btn['566']; ?>　12:00～　<b><font size=3><font color=red>大学進学</font>セミナー（オーストラリア)</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
			<b>ゼロからの英語力</b>でも海外の大学に進学できます！<br/>
			<b>現地の大学/専門学校</b>に進学したい方必見です。<br/>
			進学まで実際どんな流れなのか、どんなことをすればいいのか、大学／専門学校はどんなところなのか…<br/>
			実際にワーホリ・留学経験のあるスタッフが、一からわかりやすく説明します。<br/>

<br/>

		<font size="1">	※10月14日（金）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。

			</font>			
<br/>
			<br/>
			</div>
		</div>
	</div>
</div>



<!-- 東京  １０月１５日 -->
<div id="nittei_tyo1015" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１５日（土）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><img src="../images/flag03.gif" width="25px"><font color=red><b>　　CANADA DAY !!　　</b></font><img src="../images/flag03.gif" width="25px"><br />　　＜＜<? echo $tyo_btn['543']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞　　</div>
<br/>
		<div style="line-height:1">
			<? echo $tyo_btn['557']; ?>　12:00～　<b><font size=2><font color=red>初心者向けセミナー</font></font></b>　(対象国：<b>カナダ)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>


		<div style="line-height:1">
			<? echo $tyo_btn['558']; ?>　13:00～　<b><font size=2><font color=red>カナダ歩き方セミナー</font></font></b>　(対象国：<b>カナダ)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				現地でのお仕事/お住まいの探し方・注意点をメインに
				カナダの魅力・各都市の案内・ビザの種類・出来ること・取得できる資格等<br/>
				カナダに留学＆ワーホリを考えている方オススメのセミナーです。<br/>
			</font>			
<br/>



		<div style="line-height:1">
			<? echo $tyo_btn['559']; ?>　14:00～　<b><font size=2><font color=red>協会サポートオフィスによる語学学校比較セミナー</font></font></b>　(対象国：<b>カナダ)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			学校とは/メリット・学校選びのポイント・流れ・予算・体験談等<br/>
			<font color=red>この日は特別に協会の現地サポートオフィスのスタッフがカナダの学校についてご案内いたします。</font>			</font>			
<br/><br/>

			<? echo $tyo_btn['560']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>カナダ</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>
			</font>
				<br/>
			</font>
				<br/>
			</font>

			<div align="center">
				<img  src="images/time/1015.gif" />
			</div>
		</div>
	</div>
</div>



<!-- 東京  １０月１６日 -->
<div id="nittei_tyo1016" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１６日（日）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>

<br/>
		<div style="line-height:1.5">
			<? echo $tyo_btn['567']; ?>　11:00～　<br/><b><font size=2><font color=red>英語圏</font>初心者向けセミナー／<font color=red>語学学校比較</font>セミナー</font><br/>（オーストラリア・カナダ・ニュージーランド・イギリス）</b></b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
				≪一部≫11：00～<br/>
				<b>初心者向けセミナー（オーストラリア・カナダ・ニュージーランド・イギリス）</b><br/>
<br/>
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来る事・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
<br/>
				≪二部≫12：00～<br/>
				<b>語学学校比較セミナー（オーストラリア・カナダ・ニュージーランド・イギリス）</b><br/>
<br/>
				語学学校って？<br/>
				学校に通うメリット・学校選びのポイント・流れ・予算・体験談等<br/>
	<br/>
			</font>			
			<? echo $tyo_btn['569']; ?>　16:00～　<b><font size=3><font color=red>学生限定</font>セミナー</font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			就職前の学生時代に海外を体感しようセミナー<br/>
			春休み・夏休みの短期留学から休学し半年1年のワーキングホリデー、留学プランのご提案<br/>
			語学留学、資格取得、習い事留学、インターンシップ経験、ボランティア、ホームステイ、海外でのお仕事経験等<br/>

<br/>
		<font size="1">	※10月16日（日）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。



			</font>			
<br/>
			</font>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>


<!-- 東京  １０月１７日 -->
<div id="nittei_tyo1017" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１７日（月）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><img src="../images/flag02.gif" width="25px"><font color=red><b>　　NEW ZEALAND DAY !!　　</b></font><img src="../images/flag02.gif" width="25px"><br />　　＜＜<? echo $tyo_btn['518']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞　　</div>
<br/>
		<div style="line-height:1">
			<? echo $tyo_btn['519']; ?>　12:00～<b>　<font size=3><font color=green>ニュージーランド大使館セミナー</font></font></b>　(対象国：<b>ニュージーランド)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			　<b>ニュージーランド大使館の方によるフェアだけの<font color=red>特別セミナー</font>です。</b><br/></font>
<br/>
			　　<b><font color=red>ニュージーランド　? 自分発見の旅</font></b><br/>
			<br/><font size="1">
			　　<b>セミナー内容</b><br/>
			　　ニュージーランドで過ごすワーキングホリデーの素晴らしさについて<br/>
			<br/>
			　　<b><<ワーキング渡航者へのメッセージ>></b><br/>
			　　ワーキングホリデーとは、発見の旅です。<br/>
			　　新しい場所に行き、新たな人々と出会い、新しい経験を重ねることがワーキングホリデーの醍醐味です。<br/>
			　　この旅を通して、本当の自分らしさも発見できるかもしれません。<br/>
<br/>			</font>			
<br/>
			</font>
			</font>	
			<? echo $tyo_btn['497']; ?>　13:00～<b>　<font size=2><font color=red>最高の環境</font>で英語資格をとろう！<font size=2><font color=red>NZLC</font>語学学校セミナー</font></font></b><br/>
					<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			<font size="1">
			オークランド、クライストチャーチ、ウィリングトンにキャンパスを持ち、ニュージーランドで最も歴史のある語学学校のひとつに数えられる学校。
			クラスの少人数制を徹底している<br/>
			</font>
<br/>
			<div align="center">
				<img  src="images/time/1017.gif" />
			</div>
		</div>
	</div>
</div>



<!-- 東京  １０月１８日 -->
<div id="nittei_tyo1018" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１８日（火）開催内容】
				</td>
				<td>
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="line-height:1.5">
			<? echo $tyo_btn['635']; ?>　16：00～　<b><font size=3><font color=red>誰も教えてくれなかった英語がうまくなるコツ セミナー</font></font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
（対象国：<b>アメリカ・イギリス・オーストラリア・カナダ・ニュージーランド</b>）<br/>
<br/>

≪内容≫<br/>
カナダ在住の講師が<b>「誰も教えてくれなかった英語がうまくなるコツ」</b>と題したセミナーを行います。<br/>
まだ国を迷っている方も必見のセミナーとなっておりますので、ぜひこの機会にご参加ください。<br/>
<br/>
<b>＝＝＝＝講師紹介＝＝＝</b><br/>
<img src="images/photo2.jpg" style="border: 1px dotted navy;padding: 5px 5px 5px 5px;"><br/>
<b>サミー高橋氏</b><br/>
<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
カリフォルニア州立大学フレズノ校言語学部卒業、帰国後複数の英会話スクールで教鞭をとり、<br/>
２０年前にカナダのバンクーバーへ移住。<br/>
元パシフィックゲートウェイ・インターナショナルカレッジ学長、<br/>
現スタディー・グループ、ビジネス開発ディレクター<br/>
グローバル人材育成塾、Global SAVVY Education塾長<br/>
　<br/>

		<font size="1">	※10月18日（火）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。


				<br/>
			</font>
			<br/>
			</div>
		</div>
	</div>
</div>




<!-- 東京  １０月１９日 -->
<div id="nittei_tyo1019" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１９日（水）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="line-height:1.5">

			<? echo $tyo_btn['568']; ?>　<br/><b><font size=2><font color=red>英語圏</font>初心者向けセミナー／<font color=red>語学学校比較</font>セミナー</font><br/>（オーストラリア・カナダ・ニュージーランド・イギリス）</b></b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
				≪一部≫14：00～<br/>
				<b>初心者向けセミナー（オーストラリア・カナダ・ニュージーランド・イギリス）</b><br/>
<br/>
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来る事・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
<br/>	<br/>
				≪二部≫15：00～<br/>
				<b>語学学校比較セミナー（オーストラリア・カナダ・ニュージーランド・イギリス）</b><br/>
<br/>
				語学学校って？<br/>
				学校に通うメリット・学校選びのポイント・流れ・予算・体験談等<br/>
	<br/>
			</font>			
<br/>



		<font size="1">	※10月19日（水）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。



			</font>			
<br/>
			</font>
				<br/>
			</font>
			<br/>
		</div>
	</div>
</div>



<!-- 東京  １０月２０日 -->
<div id="nittei_tyo1020" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月２０日（木）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><b>＜＜<? echo $tyo_btn['489']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div></b>

		<div style="line-height:1">
			<? echo $tyo_btn['523']; ?>　12:00～<b>　<font size=2><font color=red>初心者向けセミナー</font></font></b>　(対象国：<b>オーストラリア・カナダ)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>
			<? echo $tyo_btn['493']; ?>　13:00～<b>　<font size=2><font color=red>バリスタ</font>になろう！<font size=2><font color=red>SELC</font>語学学校セミナー</font></font></b>　(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			オーストラリアの語学学校SELCの現地スタッフによるフェア期間中だけの特別セミナー<br/>
			キャンパスがシドニーのビーチまですぐの絶好のロケーション<br/>
			学生のケアやサポートの厚さでも定評があり、バリスタ取得のコースも人気<br/>
			</font>				
		
<br/>
			<? echo $tyo_btn['494']; ?>　14:00～　<b><font size=2><font color=red>ビジネス</font>で世界で活躍！<font size=2><font color=red>KGIC</font>語学学校セミナー</font></font></b>　(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">カナダの語学学校KGICの現地スタッフによるフェア期間中だけの特別セミナー<br/>
			一般英語プログラムのレベル分けが「読む・書く・聞く・話す」の4スキルごとに分かれており、効率的にレベルアップを図れる　<br/>
			</font>
<br/>
			<? echo $tyo_btn['548']; ?>　15:00～　<b><font size=2><font color=red>帰国者体験談</font></b>　(<b>オーストラリア</b>)</font><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			経験者だから話せる現地での生活、語学学校、ホームステイ、失敗談…などこれから留学＆ワーホリに行かれる方必見です！<br/>


		</font>

			</font>
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
				<td width="45%" style="text-align:center; font-size:13pt;">
				<b>【１０月２１日(金)開催内容】</b>
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><font color=red><b>AUSTLARIA DAY !!</b></font><br /><b><img src="../images/flag01.gif"width="25px">　＜＜<? echo $tyo_btn['539']; ?>　予約する＞＞　<img src="../images/flag01.gif"width="25px"></b></div>
<br/><div style="margin-top:-10px;">
		<div style="line-height:1">
			　13:00～　<b><font size=2><font color=green>日本ワーキング・ホリデー協会の紹介</font></font>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			　
						</font>			
<br/>
			
			　13:30～　<b><font size=3><font color=green>オーストラリア大使館セミナー</font></font>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1"><div align="right">オーストラリア大使館マーケティング事務所 商務官 市川　智子 様</div></font>
			<font size="2">
<br/>
			　<b>オーストラリア大使館の方によるフェアだけの<font color=red>特別セミナー</font>です。</b><br/></font>
			<font size="1">　　●オーストラリアの魅力<br/>
			　　●オーストラリアのビザの種類<br/>
			　　●オーストラリアの生活と治安　など<br/>
<br/>
			　　オーストラリアの魅力満載のセミナーとなっております。<br/>
			　　大使館の方によるセミナーはなかなかございませんので、ぜひこの機会にご参加ください。<br/>
						
<br/>
			</font>			
<br/>
			　15:00～　<b><font color=green>帰国者体験談</font>　</b>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">	　　実際にオーストラリアにワーホリで行った経験者からの帰国者体験談セミナー。<br/>
			　　実際に海外で生活した人、学校に通った人だからこそ分かる、現地の生活をお話します。<br/>
			</font>
<br/>

			</font>
<br/>
			　16：00～<b>　<font color=green>ワインセミナー・懇談会</font></b>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">
			　　オーストラリアで有名な物の一つ、ワイン。<br/>
			　　ワインの専門店よりスタッフの方をお招きします。<br/>
			　　軽食やジュースもご用意いたしますので、帰国者との懇談会もお楽しみください。（ご参加は無料です）<br/>
<br /></div></div><div style="margin-top:10px;">
			</div></div>
		</div>
	</div>
</div>


<!-- 東京  １０月２２日 -->
<div id="nittei_tyo1022" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月２２日（土）開催内容】
				</td>
				<td>
				<img  src="images/tokyoform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="line-height:1.5">
			<? echo $tyo_btn['554']; ?>　17:00～　<b><font size=3><font color=red>★ワーホリ帰国者交流会★</font></font></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
<br/>
<b><big>《参加費》　2000円<br/></big></b>
<br/>
現地を経験した方々の<b>お仕事の経験</b>や<b>リアルな生活情報</b>を聞く事ができる機会！<br/>
<br/>
帰国者から色々な情報やアドバイスをもらったり、<br/>
<b>ワーホリ仲間</b>を見つけて楽しい時間を過ごしましょう！<br/>
<br/>

＊　ご予約は電話にても承ります。<br/>
＊　当日キャンセルはご遠慮くださいませ。<br/>
＊　締め切り　<b>10月21日（金）19:00</b><br/>
　<br/>
<br/>
<div align="center"><font color=deeppink>::::軽食とお飲物をご用意してお待ちしております::::</font></div><br/>

<br/>
		<font size="1">	※10月22日（土）は語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。


				<br/>
			</font>
			<br/>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月７日（金）開催内容】
				</td>

				<td>
				<img  src="images/osakaform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><font size=2>＜＜<? echo $osa_btn['498']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>

<br/>
		<div style="line-height:1">
			<? echo $osa_btn['525']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア・カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $osa_btn['499']; ?>　13:00～　<b><font size=2><font color=red>海外大学生と交流</font>してみたい！<font size=2><font color=red>CIC／CWA</font>語学学校セミナー</font></b><br />
			(<b>オーストラリア・カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			一般英語、TOEIC・TOEFL対策コース以外に、豊富なコースを持つ<br/>
			また、メルボルン大学の学生とのConversation Clubが週に4回あるのが魅力

			</font>			
<br/><br/>


			<? echo $osa_btn['500']; ?>　14:00～<b><font size=2><font color=red>海外進学・国際人間</font>になる！<font color=red>KGIBC</font>語学学校セミナー</font></font></b>(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			「グローバル人材育成」を掲げ、世界を舞台に活躍できる人材育成により組んでいる学校<br/>
			</font>	
<br/><br/>
		<font size="1">	※語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。<br/>
		
</font>	
			<br/>

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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月８日（土）開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
<font size=2>
		<div style="text-align:center; margin-bottom:5px;">＜＜<? echo $osa_btn['502']; ?>　全てに参加・ご相談のみ・とりあえず参加してみたい…な方はこちら！＞＞</div>


<br/>
		<div style="line-height:1">
			<? echo $osa_btn['509']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $osa_btn['503']; ?>　13:00～　<b><font size=2><font color=red>TOEIC</font>を極める！<font size=2><font color=red>ILSC</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			質の高い教師陣やTOEIC等の英語検定対策コースの充実しており
			English　Only　Policyを徹底している学校</font>			
<br/><br/>


			<? echo $osa_btn['505']; ?>　14:00～<b><font size=2><font color=red>英語を最大限伸ばす</font>コツ！</font><font color=red>BROWNS</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
ゴールドコーストとブリスベンにあり、４技能（読む・書く・聞く・話す）各々をレベル分けにより、<br/>
苦手な分野をしっかり勉強することができる学校<br/>			</font>			
<br/><br/>
		<font size="1">	※語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。<br/>
		
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月９日（日）開催内容】
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

<br/>
		<div style="line-height:1">
			<? echo $osa_btn['511']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア・カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $osa_btn['512']; ?>　13:00～<b><font size=2>ベストスクール<font color=red>世界第６位</font>！<font size=2><font color=red>Inforum</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
アットホームで生徒のケアに定評があり、エコツアーガイドなどの他にはないアクティビティー・プログラムが充実している。<br/>
世界各国から留学生が来る、国籍MIXが良い学校</font>			
<br/><br/>


			<? echo $osa_btn['513']; ?>　14:00～　<b><font size=2><font color=red>遊びも勉強も資格も！</font>全てを叶える！</font><font color=red>ILAC</font>語学学校セミナー</font></font></b>　(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			トロント・バンクーバーにあり、日本人率が低く様々な国籍の生徒が通う大規模な学校<br/>
			</font>			
<br/>


			<br/>
			<br/>

		<font size="1">	※語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。<br/>

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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１０日（月）開催内容】
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

<br/>


		<div style="line-height:1">
			<? echo $osa_btn['515']; ?>　12:00～　<b><font size=2><font color=red>オーストラリア</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

			<? echo $osa_btn['516']; ?>　13:00～　<b><font size=2><font color=red>実用的な会話術</font>を取得！<font size=2><font color=red>Viva</font>語学学校セミナー</font></font></b>　(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			Smart Talkコースでは日常的なものをトピックにしたり、ゲストスピーカを招いたりと<br/>
			実践的な授業内容によって英語を話す実力をつけることができる学校</font>			
<br/><br/>


			<? echo $osa_btn['553']; ?>　14:00～　<b><font size=2><font color=red>オーストラリア</font>歩き方セミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				現地でのお仕事/お住まいの探し方・注意点をメインに
				カナダの魅力・各都市の案内・ビザの種類・出来ること・取得できる資格等<br/>
				カナダに留学＆ワーホリを考えている方オススメのセミナーです。<br/>
			</font>			
<br/>
<br/>
		</font>
		<font size="1">	※語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。<br/>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１３日（木）開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>



		<div style="line-height:1">
<div style="margin-top:-10px;"><b><font color=orange>＜＜第一部＞＞</font></b><br/></div>
			<? echo $osa_btn['550']; ?>　11:00～　<b><font size=2><font color=red>ニュージーランド</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>
<div style="margin-left:55px;line-height:1" >
			<b>　<font size=2><font color=red>最高の環境</font>で英語資格をとろう！<font size=2><font color=red>NZLC</font>語学学校セミナー</font></font></b><br/>
					<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			<font size="1">
			オークランド、クライストチャーチ、ウィリングトンにキャンパスを持ち、ニュージーランドで最も歴史のある語学学校のひとつに数えられる学校。
			クラスの少人数制を徹底している<br/>
			</font></div>
			<br/>
<br/>
		<div style="line-height:1">
<div style="margin-top:-10px;"><b><font color=orange>＜＜第二部＞＞</font></b><br/></div>
			<? echo $osa_btn['526']; ?>　15:00～　<b><font size=2><font color=red>オーストラリア・カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>
<div style="margin-left:55px;line-height:1" >
			<b><font size=2><font color=red>海外大学生と交流</font>してみたい！<font size=2><font color=red>CIC</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			一般英語、TOEIC・TOEFL対策コース以外に、豊富なコースを持つ<br/>
			また、メルボルン大学の学生とのConversation Clubが週に4回あるのが魅力
			</font></div>
			<br/>
</div>
<br/>

		<div style="line-height:1">
<div style="margin-top:-10px;"><font color=orange><b>＜＜第三部＞＞</font></b></font><br/></div>
			<? echo $osa_btn['481']; ?>　17:00～　<b><font size=2><font color=red>オーストラリア</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>
<div style="margin-left:55px;line-height:1" >
			<b><font size=2><font color=red>英語を最大限伸ばす</font>コツ！</font><font color=red>BROWNS</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			ゴールドコーストとブリスベンにあり、４技能（読む・書く・聞く・話す）各々をレベル分けにより、<br/>
			苦手な分野をしっかり勉強することができる学校<br/>			</font>			
			</div>
			<br/>
</div>
<br/>
				<br/>
			</font>
			</div>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１４日（金）開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>



<br/>
		<div style="line-height:1">
<div style="margin-top:-10px;"><b><font color=orange>＜＜第一部＞＞</font></b><br/></div>
			<? echo $osa_btn['527']; ?>　11:00～　<b><font size=2><font color=red>カナダ</font>初心者向けセミナー</font></b></b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>

<div style="margin-left:55px;line-height:1" >
			<b><font size=2><font color=red>ビジネス</font>で世界で活躍！<font size=2><font color=red>KGIC</font>語学学校セミナー</font></font></b>　(<b>カナダ</b>)<br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">カナダの語学学校KGICの現地スタッフによるフェア期間中だけの特別セミナー<br/>
			一般英語プログラムのレベル分けが「読む・書く・聞く・話す」の4スキルごとに分かれており、効率的にレベルアップを図れる　<br/>
			</font></div>

<br/><br/>

<div style="margin-top:-10px;"><b><font color=orange>＜＜第二部＞＞</font></b><br/></div>

			<? echo $osa_btn['551']; ?>　17:00～　<b><font size=2><font color=red>TOEIC</font>を極める！<font size=2><font color=red>ILSC</font>語学学校セミナー</font></font></b>(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			質の高い教師陣やTOEIC等の英語検定対策コースの充実しており
			English　Only　Policyを徹底している学校</font>			
			</font>			
<br/>
<br/><br/><br/>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月１７日（月）開催内容】
				</td>
				<td>
				<img  src="images/osakaform.gif" />
				</td>
				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table>
		<div style="text-align:center; margin-bottom:5px;"><font color=red><b>NEW ZEALAND DAY !!</b></font><br /><img src="../images/flag02.gif" width="30px">　　<b>＜＜<? echo $osa_btn['517']; ?>　予約する＞＞　　<img src="../images/flag02.gif" width="30px"></b></div>
		


<br/>
		<div style="line-height:1">
			　12:00～<b>　<font size=3><font color=green>ニュージーランド大使館セミナー</font></font></b>　(対象国：<b>ニュージーランド)</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			　<font size="1"><b>ニュージーランド大使館の方によるフェアだけの<font color=red>特別セミナー</font>です。</b><br/></font>
<br/>
　　<b><font color=red>ニュージーランド　? 自分発見の旅</font></b><br/>
<br/><font size="1">
　　<b>セミナー内容</b><br/>
　　ニュージーランドで過ごすワーキングホリデーの素晴らしさについて<br/>
<br/>
　　<b><<ワーキング渡航者へのメッセージ>></b><br/>
　　ワーキングホリデーとは、発見の旅です。<br/>
　　新しい場所に行き、新たな人々と出会い、新しい経験を重ねることがワーキングホリデーの醍醐味です。<br/>
　　この旅を通して、本当の自分らしさも発見できるかもしれません。<br/>
<br/>
		　　ニュージーランドの魅力満載のセミナーとなっております。<br/>
		　　大使館の方によるセミナーはなかなかございませんので、ぜひこの機会にご参加ください。<br/>			</font>			
<br/><br/>
			</font>
			</font>	
			13:00～<b>　<font size=2><font color=red>最高の環境</font>で英語資格をとろう！<font size=2><font color=red>NZLC</font>語学学校セミナー</font></font></b><br/>
					<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="2">
			<font size="1">
			オークランド、クライストチャーチ、ウィリングトンにキャンパスを持ち、ニュージーランドで最も歴史のある語学学校のひとつに数えられる学校。
			クラスの少人数制を徹底している<br/>
			</font>
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
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月２０日（木）開催内容】
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




<br/>
		<div style="line-height:1">
			<? echo $osa_btn['524']; ?>　12:00～<b>　<font size=2><font color=red>初心者向けセミナー</font></font></b>　(対象国：<b>オーストラリア・カナダ)</b><br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
				各国の魅力・ビザの内容・語学学校の必要性
				現地で出来ること・取得できる資格・英語の伸ばし方等<br>
				留学＆ワーホリを考えている方の第一歩としてオススメのセミナーです。<br/>
			</font>			
<br/>
			<? echo $osa_btn['521']; ?>　13:00～<b>　<font size=2><font color=red>バリスタ</font>になろう！<font size=2><font color=red>SELC</font>語学学校セミナー</font></font></b>　(<b>オーストラリア</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1.5">
			オーストラリアの語学学校SELCの現地スタッフによるフェア期間中だけの特別セミナー<br/>
			キャンパスがシドニーのビーチまですぐの絶好のロケーション<br/>
			学生のケアやサポートの厚さでも定評があり、バリスタ取得のコースも人気<br/>
			</font>				
		
<br/>
			<? echo $osa_btn['522']; ?>　14:00～　<b><font size=2><font color=red>ビジネス</font>で世界で活躍！<font size=2><font color=red>KGIC</font>語学学校セミナー</font></font></b>　(<b>カナダ</b>)<br/>
			<div style="margin-top:-10px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">カナダの語学学校KGICの現地スタッフによるフェア期間中だけの特別セミナー<br/>
			一般英語プログラムのレベル分けが「読む・書く・聞く・話す」の4スキルごとに分かれており、効率的にレベルアップを図れる　<br/>
			</font>
			<br/>
			</font>
				<br/>
			</font>
				<br/>
			</font>
		<font size="1">	※語学学校ブース・帰国者体験談ブース・カウンセリングブースの開放はございません。<br/>
<br/><br/>
		</div>
	</div>
</div>



<!-- 大阪  １０月２1日 -->
<div id="nittei_osa1021" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div style="margin:10px 10px 10px 10px; text-align:left;">
		<table width="540px" style="margin-bottom:10px;">
			<tr>
				<td width="30%"></td>
				<td width="40%" style="text-align:center; font-size:13pt;">
					【１０月２１日(金)開催内容】
				</td>
				<td>
				
				</td>

				<td width="30%" style="text-align:right;">
					<input type="button" class="button_cancel" value=" 戻る " onclick="btn_nittei_hide();">
				</td>
			</tr>
		</table><font size="2">
		<div style="text-align:center; margin-bottom:5px;"><b><font color=red><b>AUSTLARIA DAY !!</b></font><br /><img src="../images/flag01.gif">　＜＜<? echo $osa_btn['540']; ?>　予約する＞＞　<img src="../images/flag01.gif"></b></div>
<br/>


		<div style="line-height:1">
			　13:00～　<b><font size=2><font color=green>日本ワーキング・ホリデー協会の紹介</font></font>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			
			　
						</font>			
<br/>
			　13:30～　<b><font size=3><font color=red>オーストラリア大使館セミナー</font></font>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1"><div align="right">オーストラリア大使館マーケティング事務所 商務官 市川　智子 様</div></font>

			<font size="2">
<br/>
			　<b>オーストラリア大使館の方によるフェアだけの<font color=red>特別セミナー</font>です。</b><br/></font>
			　　オーストラリアの魅力満載のセミナーとなっております。<br/>
			　　大使館の方によるセミナーはなかなかございませんので、ぜひこの機会にご参加ください。<br/>
<br/>
					
<br/>
			<font size="2">　15:00～　<b><font color=green>帰国者体験談</font>　</b>　</b><br/>
			<div style="margin-top:-5px;"><HR size="1" color="#000000" style="border-style:dotted"></div>
			<font size="1">	　　実際にオーストラリアにワーホリで行った経験者からの帰国者体験談セミナー。<br/>
			　　実際に海外で生活した人、学校に通った人だからこそ分かる、現地の生活をお話します。<br/>
			</font>
<br/>




			</font>
	<br/>
			<br/>
				<br/>
				<br/>
			</font>
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
</div>
  <div id="contentsbox"><img id="bgtop" src="http://www.jawhm.or.jp/images/contents-bgtop.gif" alt="" />
  <div id="contents">

	<div id="maincontent" style="margin-left:20px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">


		<div class="top-entry01" style="width:900px;" >


<div id="hc1" class="haccordion">
<ul>
	<li>
		<div class="hpanel" style="width:680px">
		<img src="03.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:680px">
		<img src="01.png" style="float:left; padding-right:8px;" />
	</li>

	<li>
		<div class="hpanel" style="width:680px">
		<img src="04.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:680px">
		<img src="02.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:680px">
		<img src="05.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:680px">
		<img src="00.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

</ul>
</div>

<p style="clear:center"><a href="javascript:haccordion.expandli('hc1', 0)">留学&ワーホリセミナー</a> | <a href="javascript:haccordion.expandli('hc1', 1)">語学学校セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 2)">講演会セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 3)">帰国者体験談</a> | <a href="javascript:haccordion.expandli('hc1', 4)">個別カウンセリング</a> | <a href="javascript:haccordion.expandli('hc1', 5)">春の留学＆ワーホリフェア</a> </p>

<br />
<img src="images/01.gif" /><br />

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
<img src="images/01_tokyo.gif" /><br />


<h3 id="tokyo">　<img src="images/tokyocarendar.gif" >　　<A Href="#school"><img src="images/school01.gif" /></a></h3>
<div align="center">
<img src="images/week.gif" ><br />
<table border="0" bordercolor="black" cellspacing="0" cellpadding="0" width="850" style="font: 12px; color: #666666; background-image: url('images/carendartokyo.gif'); background-position: left top;" >

<tr>
<td align="center" height="154" width="120" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;" width="120"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;" width="120"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;" width="120"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;" width="120"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" height="154" width="120" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1007');">
	<div style="line-height:2; margin-top:30px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/cic.gif"><br/>
		<img src="images/kgibc.gif">
	</div></div>
</td>


<td align="center" width="120" style="color: #000000;  cursor:pointer;" onclick="fnc_nittei('tyo1008');">
	<div style="line-height:2; margin-top:30px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/ILSC.gif"><br/>
		<img src="images/browns.gif">
	</div></div>
</td>
</tr>

<tr>

<td align="center"  style="color: #000000; width="154" cursor:pointer;" onclick="fnc_nittei('tyo1009');">
	<div style="line-height:2; margin-top:30px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/inforum.gif"><br/>
		<img src="images/ilac.gif">
		
	</div></div>
</td>


<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1010');">
	<div style="line-height:2; margin-top:25px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/arukikata.gif"></br>
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
	<div style="line-height:1.5; margin-top:1px;">
		<img src="images/new.gif"><br/><img src="images/uk.gif"></br><img src="images/aussemi.gif">
	</div></div>
</td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1014');">
	<div style="line-height:1.5; margin-top:1px;">
		<img src="images/new.gif"><br/><img src="images/shingaku.gif">
	</div></div>
</td>


<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1015');">
	<div style="line-height:1.5; margin-top:15px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/arukikata.gif"></br>
		<img src="images/hikaku.gif"></br>
	</div></div>
</td>


</tr>
<tr>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1016');">
	<div style="line-height:1.8; margin-top:0px;">
		<img src="images/new.gif"><br/><img src="images/aussemi.gif"><br/><img src="images/studentonly.gif">
	</div></div>
</td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1017');">
	<div style="line-height:2; margin-top:38px;">
		<img src="images/nz.gif"></br>
		<img src="images/nzlc.gif">
	</div></div>
</td>


<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1018');">
	<div style="line-height:1.8; margin-top:px;">
		<img src="images/new.gif"><br/><img src="images/eigojoutatu.gif"></br>
	</div></div>
</td>


<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1019');">
	<div style="line-height:1.8; margin-top:px;">
		<img src="images/new.gif"><br/><img src="images/aussemi.gif"></br>
		<img src="images/hikaku.gif"></br>
	</div></div>
</td>


<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1020');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/selc.gif"><br/>
		<img src="images/kgic.gif">
	</div></div>
</td>

<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1021');">
	<div style="line-height:0.5; margin-top:-3px;">
		<img src="images/aus.gif"></br>
	</div></div>
</td>

<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('tyo1022');">
	<div style="line-height:0.5; margin-top:-3px;">
		<img src="images/party.gif"></br>
	</div></div>
</td>

</tr>

</table>
<font size=2><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=green>緑</font>⇒ニュージーランド語学学校セミナー</font></b>
<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />
</div>

<br /><br />
<img src="images/02.gif" /><br />
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
		</div>

<br />

<h3 id="osaka">　<img src="images/osakacarendar.gif" >　　<A Href="#school"><img src="images/school01.gif" /></a></h3>
<div align="center">
<img src="images/week.gif" ><br />
<table border="0" bordercolor="black" cellspacing="0" cellpadding="0" width="850" style="font: 12px; color: #666666; background-image: url('images/carendarosaka.gif'); background-position: left top;" >


<tr>
<td align="center" height="154" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" width="120" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" width="120" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" width="120" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" width="120" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" width="120" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1007');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/cic.gif"><br/>
		<img src="images/kgibc.gif">
	</div></div>
</td>
<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1008');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/ILSC.gif"><br/>
		<img src="images/browns.gif">
	</div></div>
</td>
</tr>

<tr>

<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1009');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/inforum.gif"><br/>
		<img src="images/ilac.gif">
	</div></div>
</td>


<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1010');">
	<div style="line-height:2; margin-top:15px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/arukikata.gif"></br>
		<img src="images/viva.gif">
	</div></div>

<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1013');">
	<div style="line-height:1.3; margin-top:26px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/nzlc.gif"></br>
		<img src="images/cic.gif"><br/>
		<img src="images/browns.gif">
		
	</div></div>
</td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1014');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/kgic.gif"><br/>
		 <img src="images/ILSC.gif">
	</div></div>
</td>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
</tr>
<tr>
<td align="center" height="154" style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>

<td align="center" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osaka1017');">
	<div style="line-height:2; margin-top:40px;">
		<img src="images/nz.gif"></br><img src="images/nzlc.gif">
	</div></div>

<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></div></td>
<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>

<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1020');">
	<div style="line-height:2; margin-top:20px;">
		<img src="images/aussemi.gif"></br>
		<img src="images/selc.gif"><br/>
		<img src="images/kgic.gif">
	</div></div>
</td>

<td align="center" height="154" style="color: #000000; cursor:pointer;" onclick="fnc_nittei('osa1021');">
	<div style="line-height:0.5; margin-top:0px;">
		<img src="images/aus.gif">
	</div></div>
</td>


<td align="center"  style="color: #000000;"><div style="font-size:15pt"><font color="#767676"><b></b></td>
</tr>
</table>
<font size=3><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=green>緑</font>⇒ニュージーランド語学学校セミナー</font><br />
</b>


</div>
<br />
<h2 class="sec-title" id="school2">あなたにぴったりな語学学校って？？</h2><br /><br />

<font size=2>ワーキングホリデーを一年間存分に楽しむには、英語力は必要不可欠です。<br />
多くのワーホリメーカーは現地に行って語学学校に通い英語を学びます。<br />
学べる事、取得できる資格、設備、スタッフ、雰囲気…語学学校によって様々な特徴があります。<br />
この機会に自分にぴったりの学校を見つけて、留学＆ワーキングホリデーを100パーセント楽しみましょう！！<br /></font>
<br />


<a href="browns.html" target="school"><img src="browns/tab.gif" width="80px" height="33px"></a>
<a href="cic.html" target="school"><img src="cic/tab.gif" width="80px" height="33px"></a>
<a href="cwa.html" target="school"><img src="cwa/tab.gif" width="80px" height="33px"></a>
<a href="ilac.html" target="school"><img src="ilac/tab.gif" width="80px" height="33px" ></a>
<a href="ilsc.html" target="school"><img src="ilsc/tab.gif" width="80px" height="33px" ></a>
<a href="inforum.html" target="school"><img src="inforum/tab.gif" width="80px" height="33px" ></a>
<a href="kgic.html" target="school"><img src="kgic/tab.gif" width="80px" height="33px" ></a>
<a href="nzlc.html" target="school"><img src="nzlc/tab.gif" width="80px" height="33px"></a>
<a href="selc.html" target="school"><img src="selc/tab.gif" width="80px" height="33px" ></a>
<a href="viva.html" target="school"><img src="viva/tab.gif" width="80px" height="33px"></a><br/>


<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="850" height="" background="images/back.gif" style="padding: 0px 0px 0px 20px;">


<iframe src="top.html" width="800" height="500" frameborder="0" name="school" marginwidth="0" marginheight="0" hspace="0" vspace="0" onload="fitIfr();">お使いのブラウザはフレームに対応しておりません。</iframe>


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
<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />

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