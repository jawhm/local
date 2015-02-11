<?php
	require_once('include/mobile_function.php');
	require_once ('include/where_condition.php');

	ini_set ('session.bug_compat_42', 0);
	ini_set ('session.bug_compat_warn', 0); 
	
	session_start();

	list(,$para1, $para2, $para3, $para4, $para5, $para6) = explode('/', $_SERVER['PATH_INFO']);
	$c_base = $_SERVER['REQUEST_URI'];

	$c_footer = '
		<div id="footer-jquerymobile" data-role="footer" data-position="fixed">
			<a class="footer-link-mobile" id="about-link" href="/system.html" data-ajax="false"><span>ワーホリ</span></a><a class="footer-link-mobile" id="seminar-link" href="/seminar/ser" data-ajax="false"><span>予約</span></a><a class="footer-link-mobile" id="visa-link" href="/country" data-ajax="false"><span>Visa</span></a><a class="footer-link-mobile" id="school-link" href="/school.html" data-ajax="false"><span>語学学校</span></a><a class="footer-link-mobile" id="step-link" href="/start.html" data-ajax="false"><span>Steps</span></a><a class="footer-link-mobile" id="menu-link" href="/" data-ajax="false"><span>Menu</span></a>
		</div>
	';
	
	$url_home = '/seminar/ser';
	$url_top  = '/';

	if ($para1 <> 'id')	{
		$_SESSION['para1'] = $para1;
		$_SESSION['para2'] = $para2;
		$_SESSION['para3'] = $para3;
		$_SESSION['para4'] = $para4;
		$_SESSION['para5'] = $para5;
		$_SESSION['para6'] = $para6;
	}
	
	//general header
	function display_header ($h1)
	{
		$c_header = '
			<div id="switch-btn">';
						
		//display logout button			
		if($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1):
		$c_header .= '
				<div id="btn-logout"><input  data-theme="z" type="button" value="ログアウト" onClick="fnc_logout();"></div>';
		endif;
		
		if($_SESSION['para6'] != '')
			$num ='?num='.$_SESSION['para6'].'#calendar_start';
		else
			$num='';

						
		$c_header .=' 				
				<form name="change_view" method="POST" action="/seminar/seminar.php'.$num.'" data-ajax="false">
					<input type="hidden" name="pc" value="on" />
					<div id="btn-for-pc"><input data-theme="z" type="submit" value="PC view" /></div>
				</form>
			</div>
			<div id="header-box">
				<a href="/" alt="ワーホリ・留学の日本ワーキングホリデー協会" rel="external">
					<h1>'.$h1.'</h1>
				</a>
			</div>
		';
		
		return $c_header;
	}

	
	if($_SESSION['para1'] == 'kouen')	{
		$page_tile = '留学・ワーホリ講演セミナー';
	}else{

		$page_tile = 'ワーホリ説明会 ';
		if ($para2 == 'tokyo')		{	$page_tile .= '【東京】';	}
		if ($para2 == 'osaka')		{	$page_tile .= '【大阪】';	}
		if ($para2 == 'nagoya')		{	$page_tile .= '【名古屋】';	}
		if ($para2 == 'fukuoka')	{	$page_tile .= '【福岡】';	}
		if ($para2 == 'okinawa')	{	$page_tile .= '【沖縄】';	}

		if ($para2 == 'first')		{	$page_tile .= '【初心者セミナー】';	}
		if ($para2 == 'school')		{	$page_tile .= '【語学学校セミナー】';	}
		if ($para2 == 'kouen')		{	$page_tile .= '【講演会】';		}
		if ($para2 == 'student')	{	$page_tile .= '【情報収集】';		}
		if ($para2 == 'foot')		{	$page_tile .= '【人数限定】';		}
		if ($para2 == 'abili')		{	$page_tile .= '【人気のセミナー】';	}

		if ($para2 == 'aus')		{	$page_tile = 'オーストラリアの'.$page_tile;	}
		if ($para2 == 'can')		{	$page_tile = 'カナダの'.$page_tile;		}
		if ($para2 == 'nz')		{	$page_tile = 'ニュージーランドの'.$page_tile;	}
		if ($para2 == 'uk')		{	$page_tile = 'イギリスの'.$page_tile;		}
		if ($para2 == 'fra')		{	$page_tile = 'フランスの'.$page_tile;		}
		if ($para2 == 'other')		{	$page_tile = '色々な国の'.$page_tile;		}

	}
	$page_tile .= ' | 日本ワーキングホリデー協会';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">
	<title><?php echo $page_tile; ?></title>
	<link rel="stylesheet" href="/seminar/css/jquery.mobile-1.0rc2.min.css" />
    <link rel="stylesheet" href="/css/base_mobile.css" />
	<link rel="stylesheet" href="/seminar/css/themes/jawhm.css" />
    <link rel="stylesheet" href="/seminar/css/ser.css" />
	<script src="/seminar/js/jquery.js"></script>
	<script src="/seminar/js/jquery.mobile-1.0rc2.min.js"></script>
<script type="text/javascript">

	$(document).ready(function()
	{
		function last_msg_funtion()
		{
            var msgID=$(".message_box:last").attr("id");
            var msgDate=$(".message_link:last").attr("alt");
			
			$('div#last_msg_loader').html('Loading...<img src="'+location.protocol + '//' + location.host + '/seminar/bigLoader.gif" />');
			
			setTimeout($.ajax({
				type: "POST",
				url: location.protocol + '//' + location.host + "/seminar/load_next_ser.php",
				data:  "last_msg_id="+msgID+"&last_msg_date="+msgDate,
				success: function(msg){
					//alert(msg);
					$(".message_box:last").after(msg);	
					$('div[data-role=collapsible]').collapsible();
					$('div#last_msg_loader').empty();
				},
				error:function(){
					alert('通信エラーが発生しました。');
				},
			}),2000);
		};
		
		$(document).bind("scrollstop", function() {
			//alert("stopped scrolling");
			//alert( ($(window).scrollTop()+100) +' compare '+ ($(document).height()- $(window).height()));
			
			if (($(window).scrollTop()+100) > ($(document).height() - $(window).height())){
				
				//alert('bottom');
				var lastcount =	$(".title-date:last").attr("title");
				
				if(lastcount >= 5) // check if there is more content to dislay (avoid loading more
				{
					last_msg_funtion();
				}

			}
		});
		
	});

</script>
<script>
	function fncyoyaku()	{
	
		// 入力チェック
		if (!jQuery('#namae').val())	{
			alert('お名前を入力してください。');
			jQuery('#namae').focus();
			return false;
		}
		if (!jQuery('#furigana').val())	{
			alert('フリガナを入力してください。');
			jQuery('#furigana').focus();
			return false;
		}
		if (!jQuery('#email').val())	{
			alert('メールアドレスを入力してください。');
			jQuery('#email').focus();
			return false;
		}
		if (!jQuery('#tel').val())	{
			alert('お電話番号を入力してください。');
			jQuery('#tel').focus();
			return false;
		}
	
		jQuery('#yoyakubtn').val('予約処理中...');
		jQuery('#yoyakubtn').button('disable');
		$senddata = $("#form_yoyaku").serialize();
		$.ajax({
			type: "POST",
			url: "http://www.jawhm.or.jp/yoyaku/yoyaku.php",
			data: $senddata,
			success: function(msg){
				alert(msg);
				location.href = '<?php print $url_home; ?>';
			},
			error:function(){
				alert('通信エラーが発生しました。');
			}
		});
	
		return false;
	}

	//Action after Select option button in seminarpage list
	$('.select-choice').live('change', function(e) {
		$.mobile.changePage($(this).val(),{transition: "fade"});
//		$('.select-choice').listview('refresh');
	});
	
	function fnc_logout()	
	{
		if (confirm("ログアウトしますか？"))	
		{
			location.href = "/member/logout.php";
		}
	}
</script>
</head>
<body>
<?php
	if ($para1 == '')	{
		// トップページを表示
?>

<div data-role="page" id="toppage" class="jquery">
	<?php
    	print display_header('無料セミナーを探そう');
     ?>   
	<p id="topicpath"><a href="<?php echo $url_top;?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;無料セミナー情報</p>
    <div data-role="content">

		<div id="jqm-homeheader">
			<p>きっと見つかる　あなたにピッタリの無料セミナー</p>
		</div>
		<p class="intro">日本ワーキング・ホリデー協会が随時開催している無料セミナーに参加して、留学・ワーホリの色々な情報をGETしよう！！</p>
        	
        <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
            <li data-role="list-divider">開催地からセミナーを探す</li>
        </ul>
        
        <div class="ui-grid-a large-text">
            <div class="ui-block-a"><a href="/seminar/ser/place/tokyo" data-mini="true" data-role="button" data-theme="d">東京</a></div>
            <div class="ui-block-b"><a href="/seminar/ser/place/osaka" data-mini="true" data-role="button" data-theme="d">大阪</a></div>
        </div>
 
        <div class="ui-grid-a large-text">
            <div class="ui-block-a"><img src="/css/images/new-rounded.png" alt="" style="position:relative;float:left;top:15px;left:10px;z-index:50;" /><a href="/seminar/ser/place/nagoya" data-mini="true" data-role="button" data-theme="d">名古屋</a></div>
            <div class="ui-block-b"><a href="/seminar/ser/place/fukuoka" data-mini="true" data-role="button" data-theme="d">福岡</a></div>
        </div>
           
        <div class="ui-grid-a large-text">
            <div class="ui-block-a"><a href="/seminar/ser/place/okinawa" data-mini="true" data-role="button" data-theme="d">沖縄</a></div>
            <div class="ui-block-b"><a href="/seminar/ser/place/event" data-mini="true" data-role="button" data-theme="d">イベント</a></div>
        </div>
                
        <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
            <li data-role="list-divider">内容からセミナーを探す</li>
            <?php //button for member
			if ($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1):?>
            <li data-icon="arrow-r-red" id="member-btn"><a href="/seminar/ser/page/member"><img src="/seminar/css/themes/images/icon7-18x18.png" alt="" class="ui-li-icon" />専門セミナーを予約する</a></li>
			<?php endif;?>
            <li data-icon="arrow-r-lblue" id="first-btn"><a href="/seminar/ser/know/first"><img src="/seminar/css/themes/images/icon1-18x18.png" alt="" class="ui-li-icon" />初心者セミナー</a></li>
            <li data-icon="arrow-r-orange" id="school-btn"><a href="/seminar/ser/know/school"><img src="/seminar/css/themes/images/icon2-18x18.png" alt="" class="ui-li-icon" />語学学校セミナー</a></li>
            <li data-icon="arrow-r-pink" id="kouen-btn"><a href="/seminar/ser/know/kouen"><img src="/seminar/css/themes/images/icon3-18x18.png" alt="" class="ui-li-icon" />講演セミナー</a></li>
            <li data-icon="arrow-r-dblue" id="student-btn"><a href="/seminar/ser/know/student"><img src="/seminar/css/themes/images/icon4-18x18.png" alt="" class="ui-li-icon" />もっと詳しく情報収集</a></li>
            <li data-icon="arrow-r-yellow" id="foot-btn"><a href="/seminar/ser/know/foot"><img src="/seminar/css/themes/images/icon5-18x18.png" alt="" class="ui-li-icon" />人数限定！懇談セミナー</a></li>
            <li data-icon="arrow-r-green" id="abili-btn"><a href="/seminar/ser/know/abili"><img src="/seminar/css/themes/images/icon6-18x18.png" alt="" class="ui-li-icon" />注目！！人気のセミナー</a></li>
            <li id="all-btn"><a href="/seminar/ser/know/all">全て</a></li>
        </ul>
        
        <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
            <li data-role="list-divider">興味のある国からセミナーを探す</li>
        </ul>
       
        <div class="ui-grid-b">
            <div class="ui-block-a"><a href="/seminar/ser/country/aus" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag01.gif" /><span class="smaller-text">オーストラリア</span></a></div>
            <div class="ui-block-b"><a href="/seminar/ser/country/can" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag03.gif" /><span class="smaller-text">カナダ</span></a></div>
            <div class="ui-block-c"><a href="/seminar/ser/country/nz" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag02.gif" /><span class="smaller-text">ニュージーランド</span></a></div>
        </div>
        <div class="ui-grid-b">
            <div class="ui-block-a"><a href="/seminar/ser/country/uk"  data-role="button" data-theme="d"><img src="/images/flag07.gif" /><span class="smaller-text">イギリス</span></a></div>
            <div class="ui-block-b"><a href="/seminar/ser/country/fra"  data-role="button" data-theme="d"><img src="/images/flag05.gif" /><span class="smaller-text">フランス</span></a></div>
            <div class="ui-block-c"><a href="/seminar/ser/country/other" data-role="button" data-theme="d"><img src="/images/earth-medium.png" /><span class="smaller-text">その他</span></a></div>
        </div>

	</div>
	<?php print $c_footer; ?>
</div>

<?php
	}
	if ($para1 == 'id')	{
		// 予約ページを表示
?>
<div data-role="page" id="yoyaku<?php print $para1; ?>" class="jquery">
	<?php
    	print display_header('セミナー予約フォーム');
     ?>   
    <p id="topicpath">
    	<?php
        if($_SESSION['para1'] == 'kouen')
		{ ?>
            <a href="<?php echo $url_top;?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="/kouenseminar.php" data-ajax="false" data-inline="true">留学・ワーホリ講演セミナー</a>&nbsp;&gt;&nbsp;セミナー予約フォーム
        <?php
		}
		else
		{ ?>
            <a href="<?php echo $url_top;?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;セミナー予約フォーム
        <?php
		} ?>
    </p>

	<div data-role="content" data-theme="a">

		<h2>ご参加予定のセミナー</h2>

<?php

	$formon = false;

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE id = '.$para2);
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$formon = true;

			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			$title	= $row['k_title1'];

			if ($row['free'] == 1)	{
				// 有料セミナー
				if ($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1)	{
					$formon = true;
				}else{
					// 未ログイン
					$formon = false;
					print '<a target="_blank" href="'.$url_top.'member" data-role="button" data-rel="back" data-theme="a">ご予約にはログインが必要です</a>';
				}
			}
//			$c_desc = $row['k_desc1'];
			$c_desc = strip_tags($row['k_desc1'], '<font><b><table><tr><td><img>');


			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席です。キャンセル待ちとなります。]';
				}else{
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$formon = false;
				$c_img   	= '[満席です]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
//					$formon = false;
					$c_img   	= '[満席です。キャンセル待ちとなります。]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}else{
						$c_img	= '';
					}
				}
			}

			print '<div data-role="content" data-collapsed="true" data-theme="a">';
			print '<div style="color:red; font-weight:bold;">'.$c_img.'</div>';

			print '<table>';
			print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">';
			switch($row['place'])	{
				case 'tokyo':
					$place = '東京';
					break;
				case 'osaka':
					$place = '大阪';
					break;
				case 'fukuoka':
					$place = '福岡';
					break;
				case 'sendai':
					$place = '仙台';
					break;
				case 'toyama':
					$place = '富山';
					break;
				case 'okinawa':
					$place = '沖縄';
					break;
				case 'nagoya':
					$place = '名古屋';
					break;
				case 'event':
					$place = 'イベント';
					break;
			}
			if ($row['place'] <> 'event')	{
				print $place.'会場</td></tr>';
			}else{
				print $place.'（会場を必ずご確認の上、ご予約ください）</td></tr>';
			}
			print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">'.$start.'</td></tr>';
			print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">'.$title.'</td></tr>';
			print '</table>';

			print '</div>';
			print '<p style="color:red;">';
			print '最近、会場を間違えてご予約される方が増えております。<br/>';
			print 'セミナー内容、会場、日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。';
			print '</p>';

		}

	} catch (PDOException $e) {
		die($e->getMessage());
	}
?>
<!--
		<a href="/seminar/ser/<?php print @$_SESSION['para1'].'/'.@$_SESSION['para2'].'/'.@$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>
-->

<?php
	if ($formon)	{
?>

<!--
	<br/>
-->
	<form action="/seminar/ser/book" method="post" id="form_yoyaku" data-ajax="false" onsubmit="return(fncyoyaku());">

		<span style="color:red;font-weight:bold;">●</span>印の項目は必ずご入力ください。

		<input type="hidden" name="セミナー番号" id="seminarno" value="<?php print $para2; ?>" />
        <?php 
		//set letter for booking
		if($_SESSION['para1'] == 'kouen')
			$letter = 'R';
		elseif($_SESSION['para2'] == 'event')
			$letter = 'W';
		else
			$letter = 'S'; 
							?>
                            
		<input type="hidden" name="セミナー名" id="seminarname" value="<?php print '['.$place.$letter.']'.$start.' '.$title; ?>" />

		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>お名前</legend>
				<input type="text" name="お名前" id="namae" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>フリガナ</legend>
				<input type="text" name="フリガナ" id="furigana" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>メールアドレス</legend>
				<input type="text" name="メール" id="email" value="" /><br/>
				※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend><span style="color:red;font-weight:bold;">●</span>当日連絡の付く電話番号</legend>
				<input type="text" name="電話番号" id="tel" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>興味のある国</legend>
				<input type="text" name="興味国" id="country" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>出発予定時期</legend>
				<input type="text" name="出発時期" id="jiki" value="" />
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>同伴者有無</legend>
				<input type="checkbox" name="同伴者" id="dohan" class="custom" />
				<label for="dohan">同伴者あり</label>
				※同伴者ありの場合、２人分の席を確保致します。<br/>
				※３名以上でご参加の場合は、メールにてご連絡ください。
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>今後のご案内</legend>
				<input type="checkbox" name="メール会員" id="mailkaiin" class="custom" checked />
				<label for="mailkaiin">このメールアドレスをメール会員（無料）に登録する</label>
			</fieldset>
			<fieldset data-role="controlgroup">
				<legend>その他</legend>
				<input type="text" name="その他" id="sonota" value="" />
			</fieldset>
		</div>

		<h3>セミナーのご予約に際し、以下の内容をご確認ください。</h3>
		<table>
		<tr><td style="vertical-align:top;"><img src="/seminar/images/b-001.gif"></td><td>このフォームでは、仮予約の受付を行います。<br/>予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされセミナーにご参加頂けません。ご注意ください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/seminar/images/b-002.gif"></td><td>携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が受信できるできる状態にしておいてください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/seminar/images/b-003.gif"></td><td>Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて到着する場合があります。時間をおいてから受信確認を行うようにしてください。</td></tr>
		<tr><td style="vertical-align:top;"><img src="/seminar/images/b-004.gif"></td><td>予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。</td></tr>
		</table>

		<input type="submit" data-role="button" data-rel="back" data-theme="c" id="yoyakubtn" value="予約する(無料)">

	</form>


<?php	}	?>

		<br/>
		<a href="/seminar/ser/<?php print @$_SESSION['para1'].'/'.@$_SESSION['para2'].'/'.@$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>
		<br/>
	</div>
	<?php print $c_footer; ?>
</div>


<?php
	}else{

	if ($para1 == 'ana')
	{
		// 情報ページ表示
		switch($para2)	
		{
			case 'first':
			break;
			case 'wh':
			break;
			case 'mem':
			break;
		}
	}
	else
	{
		// 各ページを表示
?>

<div data-role="page" id="serpage<?php print $para1.$para2.$para3; ?>" class="jquery">
	<?php
    	print display_header('無料セミナーを探そう');
     ?>   
    <p id="topicpath">
    	<?php
        if($para1 == 'kouen')
		{ ?>
            <a href="<?php echo $url_top;?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="/kouenseminar.php" data-ajax="false" data-inline="true">留学・ワーホリ講演セミナー</a>&nbsp;&gt;&nbsp;会場選択
        <?php
		}
		else
		{ ?>
            <a href="<?php echo $url_top;?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>" data-inline="true">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;会場選択
        <?php
		} ?>
    </p>
   
    <div data-role="content">
		<?php
			if ($para1 == 'place')
				$para3 = $para2;
			elseif( $para1 != 'kouen')
			{ ?>
                <div class="locallist">
                   <p>会場選択</p>
                   <select name="select-choice-city" id="select-choice-city" class="select-choice"  data-native-menu="true" data-theme="a">
                        <optgroup label="会場選択">
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/tokyo/'.$para4; ?>" <?php if ($para3 == 'tokyo') { print ' selected'; } ?>>東京</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/osaka/'.$para4; ?>" <?php if ($para3 == 'osaka') { print ' selected'; } ?>>大阪</option>
<!--                           <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/sendai/'.$para4; ?>" <?php if ($para3 == 'sendai') { print ' selected'; } ?>>仙台</option>	-->
<!--                           <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/toyama/'.$para4; ?>" <?php if ($para3 == 'toyama') { print ' selected'; } ?>>富山</option>	-->
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/fukuoka/'.$para4; ?>" <?php if ($para3 == 'fukuoka') { print ' selected'; } ?>>福岡</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/nagoya/'.$para4; ?>" <?php if ($para3 == 'nagoya') { print ' selected'; } ?>>名古屋</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/okinawa/'.$para4; ?>" <?php if ($para3 == 'okinawa') { print ' selected'; } ?>>沖縄</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/event/'.$para4; ?>" <?php if ($para3 == 'event') { print ' selected'; } ?>>イベント</option>
                        </optgroup>
                    </select>
                </div>
              <?php
				if ($para3 == '')	
					$para3 = 'tokyo';
		
			  	if($para1 == 'know')
				{ 
				    $array_icon_available = array('all','aus','can','nz','uk','fra','other');
					
					if(in_array($para4,$array_icon_available))
						$display_title =' select-country-'.$para4;
					else
						$display_title ='';
				
				?>
                    <div class="locallist<?php echo $display_title;?>">
                    	<p>興味のある国選択</p>
                    	<select name="select-choice-country" id="select-choice-country" class="select-choice" data-native-menu="true" data-theme="a">
                            <optgroup label="興味のある国選択">
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/all" <?php if ($para4 == 'all') { print ' selected'; } ?>>全て</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/aus" <?php if ($para4 == 'aus') { print ' selected'; } ?>>オーストラリア</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/can" <?php if ($para4 == 'can') { print ' selected'; } ?>>カナダ</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/nz" <?php if ($para4 == 'nz') { print ' selected'; } ?>>ニュージーランド</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/uk" <?php if ($para4 == 'uk') { print ' selected'; } ?>>イギリス</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/fra" <?php if ($para4 == 'fra') { print ' selected'; } ?>>フランス</option>
                                <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/other" <?php if ($para4 == 'other') { print ' selected'; } ?>>その他</option>
                        	</optgroup>
                    	</select>
                    </div>
              <?php
				}
			  	elseif($para1 == 'country')
				{
				    $array_icon_available = array('all','first','school','kouen','student','foot','abili');
					
					if(in_array($para4,$array_icon_available))
						$display_title =' select-'.$para4;
					else
						$display_title ='';
				?>
                <div class="locallist<?php echo $display_title;?>">
                    <p>セミナーの内容選択</p>
	             	<select name="select-choice-know" id="select-choice-know" class="select-choice" data-native-menu="true" data-theme="a">
                        <optgroup label="セミナーの内容選択">
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/all" <?php if ($para4 == 'all') { print ' selected'; } ?>>全て</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/first" <?php if ($para4 == 'first') { print ' selected'; } ?>>初心者向け</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/school" <?php if ($para4 == 'school') { print ' selected'; } ?>>語学学校セミナー</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/kouen" <?php if ($para4 == 'kouen') { print ' selected'; } ?>>講演セミナー</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/student" <?php if ($para4 == 'student') { print ' selected'; } ?>>もっと詳しく情報収集</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/foot" <?php if ($para4 == 'foot') { print ' selected'; } ?>>人数限定！懇談セミナー</option>
                            <option value="/seminar/ser/<?php print $para1.'/'.$para2.'/'.$para3; ?>/abili" <?php if ($para4 == 'abili') { print ' selected'; } ?>>注目！！人気のセミナー</option>
                       </optgroup>
                    </select>
                </div>
             <?php
				}
                    
				if (($para1 == 'know' && $para4 == '') || ($para1 == 'country' && $para4 == ''))
					$para4 = 'all';
	
			}	?>

		<?php
			switch ($para1.$para2)	{
				case 'pagemember':
					print '<h2 id="p-member">専門セミナーを予約する</h2>';
					break;
				case 'countryaus':
					print '<h2 class="title-country" id="c-aus">オーストラリアのセミナー</h2>';
					break;
				case 'countrynz':
					print '<h2 class="title-country" id="c-nz">ニュージーランドのセミナー</h2>';
					break;
				case 'countrycan':
					print '<h2 class="title-country" id="c-can">カナダのセミナー</h2>';
					break;
				case 'countryuk':
					print '<h2 class="title-country" id="c-uk">イギリスのセミナー</h2>';
					break;
				case 'countryfra':
					print '<h2 class="title-country" id="c-fra">フランスのセミナー</h2>';
					break;
				case 'countryother':
					print '<h2 class="title-country" id="c-other">その他の国のセミナー</h2>';
					break;
				case 'countryall':
					print '<h2 class="title-country" id="c-all">全て国のセミナー</h2>';
					break;
				case 'knowfirst':
					print '<h2 class="title-know" id="k-first">初心者セミナー</h2>';
					print '<p>初めてセミナーにご参加される場合にお勧めのセミナーです。</p>';
					break;
				case 'knowfoot':
					print '<h2 class="title-know" id="k-foot">人数限定！懇談セミナー</h2>';
					print '<p>人数限定！少人数で何でも質問できるセミナーです。</p>';
					break;
				case 'knowstudent':
					print '<h2 class="title-know" id="k-student">もっと詳しく情報収集</h2>';
					print '<p>国比較や現地の詳しい情報など、もっともっと深いセミナーです。</p>';
					break;
				case 'knowschool':
					print '<h2 class="title-know" id="k-school">語学学校セミナー</h2>';
					print '<p>語学学校の必要性や、様々な特徴のある語学学校を紹介するセミナーです。</p>';
					break;
				case 'knowabili':
					print '<h2 class="title-know" id="k-abili">注目！！人気のセミナー</h2>';
					print '<p>注目・人気のセミナーを集めました。満席になるまでに予約しよう！！</p>';
					break;
				case 'knowkouen':
					print '<h2 class="title-know" id="k-kouen">講演セミナー</h2>';
					print '<p>外部講師をお招きしての貴重なセミナーです。</p>';
					break;
				case 'knowall':
					print '<h2 class="title-know" id="k-all">全て</h2>';
					print '<p>全て、内容からセミナーを探す</p>';
					break;
				case 'placetokyo':
					print '<h2 class="title-city">東京会場のセミナー</h2>';
					print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/mob.php?p=tokyo">会場のご案内</a> TEL:<a href="tel:03-6304-5858">03-6304-5858</a></p>';
					break;
				case 'placeosaka':
					print '<h2 class="title-city">大阪会場のセミナー</h2>';
					print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/mob.php?p=osaka">会場のご案内</a> TEL:<a href="tel:06-6346-3774">06-6346-3774</a></p>';
					break;
				case 'placesendai':
					print '<h2 class="title-city">仙台会場のセミナー</h2>';
					break;
				case 'placetoyama':
					print '<h2 class="title-city">富山会場のセミナー</h2>';
					break;
				case 'placefukuoka':
					print '<h2 class="title-city">福岡会場のセミナー</h2>';
					break;
				case 'placenagoya':
					print '<h2 class="title-city">名古屋会場のセミナー</h2>';
					print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/mob.php?p=nagoya">会場のご案内</a> TEL:<a href="tel:052-462-1585">052-462-1585</a></p>';
					break;
				case 'placeokinawa':
					print '<h2 class="title-city">沖縄会場のセミナー</h2>';
					break;
				case 'placeevent':
					print '<h2 class="title-city">イベント情報</h2>';
					break;
			}
		?>
		<br/>


<?php

	// イベント読み込み
	$cal = array();

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
//		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');

		// パラメータ確認
		$where_place = '';
		

		//Keyword Where_country Where_know
		//-------------------------------
		$where_country = ' ( 1=0';
		$where_know = ' ( 1=0';
		
		if ($para1 == 'country')
		{
			$where_country .= where_country($para2);
			$where_know .= where_know($para4);
		}
		elseif($para1 == 'know')
		{
			$where_country .= where_country($para4);
			$where_know .= where_know($para2);
		}
		
		$where_country .= ' ) ';
		$where_know .= ' ) ';


		if ($para3 == 'fukuoka')
			$where_place = ' ( place = \''.$para3.'\' or k_title1 like \'%福岡%\' ) ';
		else
			$where_place = ' ( place = \''.$para3.'\' ) ';

		$keyword  = '';
		
		if ($where_place <> '')	
			$keyword .= ' and '.$where_place;
		
		if ($where_country != ' ( 1=0 ) ')
			$keyword .= ' and '.$where_country;
			
		if ($where_know <> ' ( 1=0 ) ')	
			$keyword .= ' and '.$where_know;

		//---------------------------------
		//Selected day from calendar module
		//---------------------------------
		if($_SESSION['para1'] == 'place' && $_SESSION['para2']!= 'event' && !empty($_SESSION['para6']))
		{
			$rs_selected = $db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, group_color, indicated_option, broadcasting, country_code FROM event_list WHERE id=\''.$_SESSION['para6'].'\'');
			
			$row_selected = $rs_selected->fetch(PDO::FETCH_ASSOC);
			
			$year	= $row_selected['yy'];
			$month  = $row_selected['mm'];
			$day	= $row_selected['dd'];

			$start	= $row_selected['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			
			$title	= $start.' '.$row_selected['k_title1'];
			
			$japanese_city_name = translate_city($row_selected['place']);

			$c_desc = strip_tags($row_selected['k_desc1'], '<font><b><table><tr><td><img>');
			
			if ($row['k_stat'] == 1)	
			{
				if ($row_selected['booking'] >= $row_selected['pax'])	
					$c_img   	= '[満席です]';
				else
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
			}
			elseif ($row_selected['k_stat'] == 2)	
				$c_img   	= '[満席です]';
			else
			{
				if ($row_selected['booking'] >= $row_selected['pax'])	
					$c_img   	= '[満席です]';
				else
				{
					if ($row_selected['booking'] >= $row_selected['pax'] / 3)	
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					else
						$c_img	= '';
				}
			}
			
			if ($c_img <> '')
				$c_img = '<h3 class="last-seat">'.$c_img.'</h3>';
			
			//check flag
			if(!empty($row_selected['country_code']))
				$flag = '<span class="flag '.$row_selected['country_code'].'"></span>';
			else
				$flag = '';
			
			//Check if live or not
			if ($row_selected['broadcasting'] != 0)
				$icon_live = '<span class="broadcast"></span>';
			else
				$icon_live = '';
				
			//Check the option statut 
			switch ($row_selected['indicated_option']) 
			{
				case 0:
					$indication ='';
					break;
				case 1:
					$indication = '<span class="osusume"></span>';
					break;
				case 2:
					$indication = '<span class="shinchyaku"></span>';
					break;
			}
			
			//get color groupe or set gray if empty
			if($row_selected['group_color'] == '')
				$color_group = '#999';
			else
				$color_group = $row_selected['group_color'];
						
			$yobi = array ('日','月','火','水','木','金','土');
			$print_selected = mktime(0, 0, 0, $_SESSION['para4'], $_SESSION['para5'], $_SESSION['para3']);

			// message to display
			$c_msg  = '<h3 class="title-date selected-title-date">'.$flag.date('n月j日 ('.$yobi[date('w', $print_selected)].')', $print_selected).'&nbsp;&nbsp;'.$icon_live.$indication.'</h3>';
			$c_msg .= '<div id="'.$row_selected['id'].'-0" class="message_box">';
			if ($row_selected['hiduke'] < date('Y-m-d') )	{
				$c_msg .= '<div class="">';
			}else{
				$c_msg .= '<div onclick="window.open(\'/seminar/ser/id/'.$row_selected['id'].'\',\'_self\')" alt="'.$row_selected['hiduke'].'" class="message_link selected_day">';
			}
			$c_msg .= $c_img;
			$c_msg .= '<h3 class="time-place-seminar" style="border-color:'.$color_group.';">'.$flag.$row_selected['starttime'].'～　'.$japanese_city_name.'会場&nbsp;'.$icon_live.$indication.'</h3>';
			$c_msg .= '<h3 style="border-color:'.$color_group.';" class="title-seminar">'.$row_selected['k_title1'].'</h3>';
			$c_msg .= '<div class="detail">'.nl2br($c_desc).'';
			$c_msg .= '<br/>';
			if ($row_selected['hiduke'] < date('Y-m-d') )	{
				$c_msg .= '<br/>[[ このセミナーは終了しました。 ]]<br/>';
				$c_msg .= 'ワーホリ・留学に役立つセミナーを日本ワーキングホリデー協会では毎日開催しております。<br/>';
				$c_msg .= '皆様のご参加をお待ちしております。<a href="/seminar/seminar" alt="ワーホリセミナー" rel="external">別のセミナーを探す</a><br/>';
			}else{
				$c_msg .= '<button value="ご予約はこちら" / >';
			}
			$c_msg .= '<br/>';
			$c_msg .= '<br/></div>';
			$c_msg .= '</div></div>';

			$cal_msg_selected[$year.$month.$day] = $c_msg;
		}
		
		//---------------------------
		//first 5 seminar to display
		//---------------------------
		$just_one = false; //only one seminar
		$free = 0; //set for free seminar

		$query = 'SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, group_color, indicated_option, broadcasting, country_code FROM event_list WHERE k_use = 1 AND ';
		
		if($para1 == 'kouen') /**** Kouenseminar ****/
		{
			$query .='k_desc2 like \'%'.$para2.'%\' ORDER BY hiduke, starttime, id';
		}
		elseif($para1 == 'place' && $para2 == 'event' && !empty($para6) )  //if we get num/id for event we only choose one seminar
		{
			$just_one = true;
			$query .='id = \''.$para6.'\'';
		}
		elseif($para2 == 'member')
		{
			$query .='free = 1 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id  LIMIT 0,15';
			$free = 1;
		}
		else
		{
			$query .='free = 0 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id  LIMIT 0,15';
		}
		
		$rs = $db->query($query);
		
		$cnt = 0;

		while($row = $rs->fetch(PDO::FETCH_ASSOC))
		{
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			
			$title	= $start.' '.$row['k_title1'];
			
			$japanese_city_name = translate_city($row['place']);

			$c_desc = strip_tags($row['k_desc1'], '<font><b><table><tr><td><img>');
			
			if ($row['k_stat'] == 1)	
			{
				if ($row['booking'] >= $row['pax'])	
					$c_img   	= '[満席です]';
				else
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
			}
			elseif ($row['k_stat'] == 2)	
				$c_img   	= '[満席です]';
			else
			{
				if ($row['booking'] >= $row['pax'])	
					$c_img   	= '[満席です]';
				else
				{
					if ($row['booking'] >= $row['pax'] / 3)	
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					else
						$c_img	= '';
				}
			}

			if ($c_img <> '')
				$c_img = '<p class="last-seat">'.$c_img.'</p>';
			
			//check flag
			if(!empty($row['country_code']))
				$flag = '<span class="flag '.$row['country_code'].'"></span>';
			else
				$flag = '';
			
			//Check if live or not
			if ($row['broadcasting'] != 0)
				$icon_live = '<span class="broadcast"></span>';
			else
				$icon_live = '';
				
			//Check the option statut 
			switch ($row['indicated_option']) 
			{
				case 0:
					$indication ='';
					break;
				case 1:
					$indication = '<span class="osusume"></span>';
					break;
				case 2:
					$indication = '<span class="shinchyaku"></span>';
					break;
			}
			
			//get color groupe or set gray if empty
			if($row['group_color'] == '')
				$color_group = '#999';
			else
				$color_group = $row['group_color'];
			
			//Set the selected day class only for 'Place'
			if($_SESSION['para1'] == 'place' && !empty($_SESSION['para6']) && $just_one === false)
			{
				if($row['id'] == $_SESSION['para6'])
					$class_selected_day = ' selected_day';
				else
					$class_selected_day = '';
			}
			else
				$class_selected_day = '';
				
			// message to display
			
			$cal[$year.$month.$day] .= '<img src="images/sa01.jpg">';
			$c_msg  = '<div id="'.$row['id'].'-'.$cnt.'" class="message_box" data-role="collapsible" style="background-color:white;">';
			$c_msg .= '<h3 class="time-place-seminar" style="border:0px;">'.$c_img;
			$c_msg .= $flag.$row['starttime'].'～　'.$japanese_city_name.'会場&nbsp;'.$icon_live.$indication.'<br/>';
			$c_msg .= $row['k_title1'].'</h3>';
			$c_msg .= '<div onclick="window.open(\'/seminar/ser/id/'.$row['id'].'\',\'_self\')" alt="'.$row['hiduke'].'" class="message_link'.$class_selected_day.'">';
			$c_msg .= '<div class="detail">'.nl2br($c_desc).'';
			$c_msg .= '<br/><button value="ご予約はこちら">ご予約はこちら</button><br/>';
			$c_msg .= '<br/></div>';
			$c_msg .= '</div></div>';

			$cal_msg[$year.$month.$day] .= $c_msg;
			
			if($just_one === false)
			{
				$cal_cnt[$year.$month.$day] = count_number_of_seminar($keyword,$row['hiduke'],$free);
				$cal_iconlist[$year.$month.$day] = icon_list_of_the_day($keyword,$row['hiduke'],$free);
				$cal_flaglist[$year.$month.$day] = flag_list_of_the_day($keyword,$row['hiduke'],$free);
			}
		}
	} 
	catch (PDOException $e) 
	{
		die($e->getMessage());
	}

?>

<?php

	if ($cnt == 0)
		print '<p>該当するセミナーがありません。検索条件を変更してください。</p>';
	else
	{
		if($just_one === false)
			print '<p>'.count_number_of_seminar($keyword,'',$free).'件のセミナーがあります。</p>';
	}
	echo '<br/>';
?>
<div class="legend">
	<p><strong>【アイコンの意味】</strong><br/>
	<span style="margin-left:20px;"><img src="/css/images/au.png" alt="Australian Flag" />&nbsp;<img src="/css/images/ca.png" alt="Canadian Flag" />&nbsp;<img src="/css/images/uk.png" alt="Union Jack" />&nbsp;&nbsp;国別セミナー</span>
	<span style="margin-left:20px;"><img src="/css/images/wd.png" alt="World" />&nbsp;&nbsp;英語圏セミナー</span>
	<span style="margin-left:20px;"><img src="/css/images/hoshi.png" alt="osusume" />&nbsp;&nbsp;おススメ</span>
	<span style="margin-left:20px;"><img src="/css/images/full.png" alt="fullybooked" />&nbsp;&nbsp;満席</span>
	<span style="margin-left:20px;"><img src="/css/images/camera.png" alt="camera" />&nbsp;&nbsp;中継対象</span><br/>
	</p>
</div>
<?php
	calendar_list();

?>
			<br/>
            <div id="last_msg_loader"></div>

			<p>
				セミナーに参加されるほとんどの方が、お一人でのご参加です。<br/>
				どうぞ、お気軽にご予約の上、ご参加ください。<br/>
			</p>

	<?php
		if($para1=='kouen')
		{ ?>
            <br/>
            <a href="/kouenseminar.php" data-role="button" data-ajax="false" data-inline="true" data-theme="a">戻る</a>
            <br/>
	<?php
		}
		else
		{ ?>

            <br/>
<!--
            <a href="<?php print $url_home; ?>" data-role="button" data-transition="fade" data-ajax="true" data-icon="arrow-l" data-inline="true" data-theme="a">セミナーＴＯＰへ</a>
            <br/>
-->
	<?php
		}?>
    </div>
	<?php print $c_footer; ?>
    

</div>
<?php
		}
	}
?>
</body>
</html>
