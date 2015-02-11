<?php
require_once 'include/header.php';

$header_obj = new Header();

$header_obj->title_page='アイルランド大使館協力 アイルランドワーキングホリデーセミナー';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/ireland/top.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ワーキングホリデー協会　アイルランドワーキングホリデーセミナー';




$header_obj->add_js_files = '<script type="text/javascript" src="js/linkboxes.js"></script>
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(["_setAccount", "UA-20563699-1"]);
  _gaq.push(["_setDomainName", ".jawhm.or.jp"]);
  _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(["_setAccount", "UA-20563699-1"]);
  _gaq.push(["_setDomainName", ".jawhm.or.jp"]);
  _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>

function fnc_next()	{
	document.getElementById("form1").style.display = "none";
	document.getElementById("form2").style.display = "";
}

function fnc_nittei(id)	{
	$.blockUI({ message: $("#nittei_"+id),
	css: { 
		top:  ($(window).height() - 600) /2 + "px", 
		left: ($(window).width() - 600) /2 + "px", 
		width: "600px" 
	}
 }); 
}

function fnc_yoyaku(obj)	{
	document.getElementById("form1").style.display = "";
	document.getElementById("form2").style.display = "none";

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = "none";
	document.getElementById("form_title").innerHTML = obj.getAttribute("title");
	document.getElementById("txt_title").value = obj.getAttribute("title");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
	css: { 
		top:  ($(window).height() - 500) /2 + "px", 
		left: ($(window).width() - 600) /2 + "px", 
		width: "600px" 
	}
 }); 
}

function btn_cancel()	{
	document.getElementById("form1").style.display = "";
	document.getElementById("form2").style.display = "none";
	$.unblockUI();
}

function btn_nittei_hide()	{
	$.unblockUI();
}

function btn_submit()	{
	obj = document.getElementById("txt_name");
	if (obj.value == "")	{
		alert("お名前（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_name2");
	if (obj.value == "")	{
		alert("お名前（名）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana");
	if (obj.value == "")	{
		alert("フリガナ（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana2");
	if (obj.value == "")	{
		alert("フリガナ（名）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_mail");
	if (obj.value == "")	{
		alert("メールアドレスを入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_tel");
	if (obj.value == "")	{
		alert("電話番号を入力してください。");
		obj.focus();
		return false;
	}

	if (!confirm("ご入力頂いた内容を送信します。よろしいですか？"))	{
		return false;
	}

	$senddata = $("form").serialize();

	document.getElementById("div_wait").style.display = "";

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait").style.display = "none";
			alert(msg);
			$.unblockUI();
		},
		error:function(){
			alert("通信エラーが発生しました。");
			$.unblockUI();
		}
	});
}

</script>
';
$header_obj->add_css_files='
<style>
a.steps	{
	color:	red;
	font-size: 16pt;
	text-decoration: none;
	border-bottom: 2px dotted navy;
	padding-bottom: 5px;
	margin-bottom: 10px;
}


#maincontent .ireland-title {
	font-size: 14px;
	color: #333333;
	background-image: url(images/ireland/title.gif);
	background-repeat: no-repeat;
	font-weight: bold;
	margin-left: 11px;
	padding-left: 20px;
	padding-top: 3px;
}

#step11box {
	margin-bottom: 10px;
	background-repeat: no-repeat;
	padding-top: 5px;
	padding-left: 20px;
	clear: both;
}

#tyo_btn {
	font-weight: bold;
	font-size: 14px;
}
</style>';


$header_obj->display_header();


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
		$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
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
						$tyo_img[$aridx]   	= '<img src="images/semi_full.jpg">';
					}else{
						$tyo_img[$aridx]   	= '<img src="images/semi_now.jpg">';
					}
				}elseif ($row['k_stat'] == 2)	{
					$tyo_img[$aridx]   	= '<img src="images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$tyo_img[$aridx]   	= '<img src="images/semi_full.jpg">';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$tyo_img[$aridx]   	= '<img src="images/semi_now.jpg">';
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
							$tyo_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="　　ご予約はこちら　　" onclick="fnc_yoyaku(this);" title="[東京A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
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
						$osa_img[$aridx]   	= '<img src="images/semi_full.jpg">';
					}else{
						$osa_img[$aridx]   	= '<img src="images/semi_now.jpg">';
					}
				}elseif ($row['k_stat'] == 2)	{
					$osa_img[$aridx]   	= '<img src="images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$osa_img[$aridx]   	= '<img src="images/semi_full.jpg">';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$osa_img[$aridx]   	= '<img src="images/semi_now.jpg">';
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
							$osa_btn[$aridx]	= '<input class="button_yoyaku" type="button" value="　　大阪会場　　" onclick="fnc_yoyaku(this);" title="[大阪A]'.$row['k_title1'].'" uid="'.$row['id'].'">';
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


	<div id="maincontent">
       <?php echo $header_obj->breadcrumbs('none'); ?>
	<img src="images/ireland/main.jpg" alt="アイルランドセミナー">
<br/>

<br/>
	<div style="font-size:20pt; color: #333333; margin-left:5%; margin-bottom:10px;">


		<strong>アイルランド<br/>
		ワーキングホリデーセミナー開催のご案内</strong>
	
	</div>

	<div style="width:50%; margin-left:430px; font-size:10pt;">
		主催　：　日本ワーキング・ホリデー協会<br/>
		協力　：　アイルランド大使館<br/>
	</div>

	<h2 class="ireland-title">アイルランドワーキングホリデーセミナーは終了致しました</h2>
	<p class="text01">
		アイルランドワーキングホリデーセミナーは2013年5月27日をもちまして終了致しました。<br/>
		たくさんのご参加本当にありがとうございました。<br/>
		今回残念ながらご参加できなかった方は次回のご参加を心よりお待ちしております。<br/>
		次回開催が決定した際には、<strong><a href="/">当協会トップページ</a></strong>、<strong><a href="http://www.jawhm.or.jp/seminar.html">無料セミナーページ</a></strong>より順次お知らせいたします。<br/>

	<center><a href="http://www.jawhm.or.jp/seminar.html"><img src="../images/fair_seminar_off.png" width="40%"></a>　<a href="http://www.jawhm.or.jp/ja/4377"><img src="../images/fair_log_off.png"  width="40%"></a></center><br/>
	</p>


	<h2 class="ireland-title">アイルランドワーキングホリデーセミナー内容</h2>
	<div id="step11box">
	&nbsp;<br/>
	<table>
		<tr>
		<td style="vertical-align:top;">
		<table>
			
			<tr>
				<td style="vertical-align:top;">
				16:00~
				<h3 class="text01b10"><strong><big><font color="#84ba24">1.ワーキングホリデー協会セミナー</font></big></strong></h3>
				<p>
				《内容》
			<ul class="list-disc">
		<li>日本ワーキングホリデー協会のご紹介</li>
		<li>ワーキングホリデー制度の概要</li>
		<li>ワーキングホリデー協定国（ヨーロッパ）のご紹介</li>
			</ul>
							<div style="height:20px;">&nbsp;</div>
<img src="images/ireland/line.gif">
	&nbsp;<br/>
				</p></td>
			</tr>
			<tr><td>&nbsp;</td><td></td></tr>
			<tr>
				<td style="vertical-align:top;">
						17:10~
				<h3 class="text01b10"><strong><big><font color="#84ba24">2.アイルランド大使館セミナー</font></big></strong></h3>
				<p>
				《内容》
			<ul class="list-disc">
		<li>アイルランドワーキングホリデープログラムの概要・申請方法</li>
		<li>アイルランドの魅力</li>
			</ul>
							<div style="height:20px;">&nbsp;</div>
<img src="images/ireland/line.gif">
	&nbsp;<br/>
				</p></td>
			</tr>
				<tr><td>&nbsp;</td><td></td></tr>
			<tr>
				<td style="vertical-align:top;">
						18:00 ～ 18:30
				<h3 class="text01b10"><strong><big><font color="#84ba24">3.アイルランド体験談セミナー</big></strong></font></h3>
				<p>
				《内容》
			<ul class="list-disc">
		<li>渡航のきっかけ</li>
		<li>現地での体験談（学校・住まい・お仕事・アイルランドの魅力）</li>
		<li>失敗・成功談</li>
			</ul>
							<div style="height:20px;">&nbsp;</div>
			</p></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<img src="images/ireland/nohata.jpg">
				</td>
				<td>
				<p><small>講演者：野畑　智史<br/>
					都内大学にてIT関連技術を専攻する傍ら写真技術を独学で学ぶ。
					卒業後は都内企業でシステムエンジニアとして勤務。<br/>
					退職した後にアイルランドへ渡航し、撮影をおこなう。<br/>
					現在はフリーの写真家として風景をはじめ人物やスポーツ、<br/>
				イベント等の撮影で活動中。長野県松本市在住<br/></p></small>
				</td>
			</tr>
		</table>
	&nbsp;<br/>
		<a href="http://gallery.jawhm.or.jp/gallery/ireland/"><img src="images/ireland/irelandgallery.jpg"></a><br/>
	&nbsp;<br/>


<img src="images/ireland/line.gif">
	&nbsp;<br/>
<br/>
<p>アイルランドの魅力満載のセミナーとなっております。　　　　　　　　　　　　<br/>
				アイルランド大使館の方のお話が聞ける機会は滅多にありません。<br/>
				アイルランドにご興味のある方、ぜひこの機会にご参加ください。<br/>
			</p>
		</td>
		<td>
		<div style="margin-top:-300px;">&nbsp;</div>

			<img src="images/ireland/photo2.jpg">
		</td>
		</tr>
	</table>
	</div>


		<div style="font-size:8pt; margin:20px 0 0 30px;">
			【ご注意】セミナー内容の詳細については、一部変更になる可能性もあります。予めご了承ください。
		</div>
		<div style="height:20px;">&nbsp;</div>
		
		
	<h2 class="ireland-title">アイルランドってどんなところ？ <img src="images/ireland/d2.gif" width="4%"></h2>
	&nbsp;<br/>
	<p style="margin-left: 15px;">
	　アイルランドは首都をダブリンとする北欧に位置する島。自然な豊かなアイルランドは別名“エメラルドの島”と呼ばれ、多くの神秘的な物語、
	巨大遺跡群やケルト文化が生まれました。その昔、ケルト人は自然のすべてに精霊が宿っていると信じ、神や妖精と生きていました。
	その神秘的な文化は今も各地に息づいており、訪れた者は心を奪われるに違いありません。
	今回は、その魅力的なアイルランドでワーキングホリデーを利用し、人々と生活を共にするための魅力と方法をご紹介いたします。<br/>
		<div style="height: 35px;">&nbsp;</div>
<center><img src="images/ireland/photo01.jpg" width="30%">　<img src="images/ireland/photo02.jpg" width="30%">　<img src="images/ireland/photo03.jpg" width="30%"></center>

</p>
		<div style="height: 20px;">&nbsp;</div>
<center><a href="visa/v-ire.html" target="_blank"><img src="images/ireland/visa.jpg"></center></a>
	
		<div style="height:30px;">&nbsp;</div>
	
<p class="text01"> 
	<center>
		<?php
		  //irelandgalley

		  // The MAX_PATH below should point to the base of your OpenX installation
		  define('MAX_PATH', '/var/www/html/ad');
		  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
		    if (!isset($phpAds_context)) {
		      $phpAds_context = array();
		    }
		    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
		    $phpAds_raw = view_local('', 134, 0, 0, '_blank', '', '0', $phpAds_context, '');
		    $phpAds_context[] = array('!=' => 'campaignid:'.$phpAds_raw['campaignid']);
		  }
		  echo $phpAds_raw['html'];
		?>
	</center>
</p>	
	
	

	<div style="height:50px;">&nbsp;</div>


	</div>
	</div>
    </div>
 


			<br/>
				<br/>
				<br/>
			</font>
		</div>
	</div>
</div>




<?php fncMenuFooter($header_obj->footer_type); ?>
</body>
</html>