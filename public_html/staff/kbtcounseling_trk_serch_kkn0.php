<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>個別カウンセリング（会員検索）</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
textarea{
	width:100%;
}
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
option.color0 {
	color:#696969;
}
option.color1 {
	color:#0000ff;
}
</style>
<SCRIPT type="text/javascript" language="JavaScript"> 
<!--
function winclose(){
	//「閉じようとしています」を表示させないため（２行追加）
　　var w=window.open("","_top");
　　w.opener=window;

	window.close(); // サブウィンドウを閉じる
}
//ローディングくるくる
function kurukuru(){
	jQuery(function($){
		$.fixedActivity(true)
	});
//	jQuery(function($){
//		$.fixedActivity(false)
//	});
}
jQuery(function($){
	$.fixedActivity = function(show){
		var o = $.fixedActivity;
		var body = $('body'),win = $(window);

		//ローディング中画面を透過にさせるラッパー要素
		if(!o.pageWrapper){
			o.pageWrapper = body.wrapInner('<div/>').find('> div').eq(0);
		}

		//アイコン表示
		body.activity(show);

		//表示位置を画面中央に設定
		if(show){
			//IE8以下だとshape、モダンブラウザだとdivになる
			var icon = body.find('> *').eq(0);
			icon.css({
				margin :0,
				position:'fixed',
				top:(win.height() - icon.height()) / 2,
				left:(win.width() - icon.width()) / 2
			});
		}

		//画面透過の切り替え
		o.pageWrapper.css({opacity: show ? .3 : 1});
	}
});
// -->
</script>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kbtcounseling_trk_serch_kkn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbtcounseling_trk_selectjknkbn.php','kbtcounseling_trk_serch.php','kbtcounseling_trk_serch_kkn0.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//祝日情報
	require_once('../jp-holiday.php');

	if( $now_youbi == 0 || $dt->is_jp_holiday == true ){
		//日曜・祝日
		$zs_youbi_color = 'red';
	}else if( $now_youbi == 6 ){
		//土曜
		$zs_youbi_color = 'blue';
	}else{
		//平日
		$zs_youbi_color = 'black';
	}

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];
	$select_office_cd = $_POST['select_office_cd'];
	$select_ymd = $_POST['select_ymd'];
	$select_jknkbn = $_POST['select_jknkbn'];
	$select_staff_cd = $_POST['select_staff_cd'];	//未入力可（カウンセラーを指定した場合のみ設定される）
	//日時変更用
	$select_yyk_no = $_POST['select_yyk_no'];		//(未入力OK)　日時変更時に変更対象となる予約番号が設定される


	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" || $select_jknkbn == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( './zs_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				
				}else{
					//ログインチェック
					require( './zs_staff_loginchk.php' );	
					if ($LC_rtncd == 1){
						$err_flg = 9;
					}
				}
			}
		}
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{
		
		//ログイン時間更新
		require( './zs_staff_loginupd.php' );
		
		//店舗メニューボタン表示
		require( './zs_menu_button.php' );
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_sentaku_mini2_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_shinki_kaiin_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kari_yyk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns1_kaiinno_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns2_kaiinnm_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns3_mail_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kns4_kaiintel_2.png" width="0" height="0" style="visibility:hidden;">');
		
		
		//配列格納最大件数
		$max_cnt = 30;

		if( $select_yyk_no != "" ){
			//予約内容を読み込む
			$zz_yykinfo_yyk_no = $select_yyk_no;
			require( '../zz_yykinfo.php' );
			if( $zz_yykinfo_rtncd == 1 ){
			$err_flg = 4;
				
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zs_log.php' );
				//************
			
			}else if( $zz_yykinfo_rtncd == 8 ){
				//予約が無い
				$err_flg = 5;
				
			}
			
		}


		//ページ編集
		//固有引数の取得
		$serch_flg = $_POST['serch_flg'];					//検索フラグ　1:会員番号,2:会員名,3:会員メールアドレス,4:会員電話番号
		$select_kaiin_no = $_POST['select_kaiin_no'];		//会員番号
		$select_kaiin_nm = $_POST['select_kaiin_nm'];		//会員名
		$select_kaiin_mail = $_POST['select_kaiin_mail'];	//会員メールアドレス
		$select_kaiin_tel = $_POST['select_kaiin_tel'];		//会員電話番号

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));


		//固有引数の取得
		$kaiin_kyoumi = '未使用';	//興味のある国
		$kaiin_jiki = '未使用';		//出発予定時期
		$kaiin_soudan = '';	//相談内容
		if( $prc_gmn == "kbtcounseling_trk_serch_kkn1.php" ){
			$kaiin_kyoumi = $_POST['kaiin_kyoumi'];	//興味のある国
			$kaiin_jiki = $_POST['kaiin_jiki'];		//出発予定時期
			$kaiin_soudan = $_POST['kaiin_soudan'];	//相談内容
		}else{
			$kaiin_kyoumi = $zz_yykinfo_kyoumi;		//興味のある国
			$kaiin_jiki = $zz_yykinfo_jiki;			//出発予定時期
			$kaiin_soudan = $zz_yykinfo_soudan;		//相談内容
		}

		//オフィスマスタの取得
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			$row = mysql_fetch_array($result);
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
			
			//「オフィス」を「会場」に置換する
			$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );			
			
		}

		//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
		$Meigyojkn_cnt = 0;
		$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $select_ymd . '" order by YOUBI_CD,ST_DATE;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
				
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '営業時間マスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Meigyojkn_youbi_cd[$Meigyojkn_cnt] = $row[0];		//曜日コード  0:日,1:月,2:火,3:水,4:木,5:金,6:土,7:土日祝の前日.8:祝日
				$Meigyojkn_teikyubi_flg[$Meigyojkn_cnt] = $row[1];	//定休日フラグ  0:営業日 1:定休日
				$Meigyojkn_st_time[$Meigyojkn_cnt] = $row[2];		//開始時刻
				$Meigyojkn_ed_time[$Meigyojkn_cnt] = $row[3];		//終了時刻
				$tmp_date = $row[4];
				$Meigyojkn_st_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
				$tmp_date = $row[5];
				$Meigyojkn_ed_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
				$Meigyojkn_cnt++;
			}
		}


		//営業日フラグを求める
		$select_eigyoubi_flg = 0;
		if( $err_flg == 0 ){
			$select_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_ymd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
			
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'カレンダーマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$select_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
				}
			}
		}
				
				
		//営業時間と定休日フラグを求める
		$select_eigyou_st_time = 0;
		$select_eigyou_ed_time = 0;
		$select_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
		$find_flg = 0;
		if( $select_eigyoubi_flg == 1 || $select_eigyoubi_flg == 9 ){
			//祝日のみ対応（土日祝の前日は非対応）
			$a = 0;
			while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
				if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ){
					if( $Meigyojkn_st_time[$a] != "" ){
						$select_eigyou_st_time = $Meigyojkn_st_time[$a];
						$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
						
					}else{
						if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
							//曜日で検索しなおし
							$a = 0;
							while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
								if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
									( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
									$select_eigyou_st_time = $Meigyojkn_st_time[$a];
									$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
									$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}
								$a++;
							}
						}else{
							$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							$find_flg = 1;
						}
					}
				}
						
				$a++;
			}
			
		}else{
			//非祝日
			$a = 0;
			while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
				if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
					( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
					if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
						$select_eigyou_st_time = $Meigyojkn_st_time[$a];
						$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
					}else{
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
					}
				}
				$a++;
			}
		}
				
		//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
		if( $select_teikyubi_flg == 1 ){
			$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
						
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '営業時間個別の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
						
			}else{
				while( $row = mysql_fetch_array($result) ){
					if( $row[0] != "" ){
						$select_eigyou_st_time = $row[0];
					}
					if( $row[1] != "" ){
						$select_eigyou_ed_time = $row[1];
					}
					$select_teikyubi_flg = 0;
				}
			}
		}

		//時間区分に該当する時間を取得する
		$Mclass_st_time = 0;
		$Mclass_ed_time = 0;
		$query = 'select ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '" and ST_DATE <= "' . $select_ymd . '" and ED_DATE >= "' . $select_ymd . '" and YUKOU_FLG = 1;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
					
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
					
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Mclass_st_time = $row[0];	//開始時刻
				$Mclass_ed_time = $row[1];	//終了時刻
			}
		}

		//カウンセラー指定の場合、スタッフ名を求める
		$select_staff_nm = "";
		$select_open_staff_nm = "";
		
		if( $select_staff_cd != "" && $err_flg == 0 ){
			$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $select_staff_cd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
						
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
						
			}else{
				while( $row = mysql_fetch_array($result) ){
					$select_staff_nm = $row[0];			//スタッフ名
					$select_open_staff_nm = $row[1];	//公開スタッフ名
				}
			}
		}


		$err_cnt = 0;	//エラー件数

		//対象件数を取得する
		$data_cnt = 0;
		if( $serch_flg == 1 ){
			//会員番号で検索
			
			$err_select_kaiin_no = 0;
			//引数チェック
			if( $select_kaiin_no == '' ){
				$err_select_kaiin_no = 1;
				$err_cnt++;
			
			}else{
				
				//半角小文字を半角大文字に変換する
				$select_kaiin_no = strtoupper( $select_kaiin_no );	//小文字を大文字にする
					
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'serch_id' => $select_kaiin_no
				);
				$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);
				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$member_cnt = $ret['data_cnt'];
					if( $member_cnt > 0 ){
						$i = 0;
						while( $i < $member_cnt ){
							$name = "data_id_" . $i;
							$data_kaiin_no[$data_cnt] = $ret[$name];			//会員番号
							$name = "data_name_" . $i;
							$data_kaiin_nm[$data_cnt] = $ret[$name];			//会員名
							$name = "data_name_k_" . $i;
							$data_kaiin_nm_k[$data_cnt] = $ret[$name];			//会員名カナ
							$name = "data_mixi_" . $i;
							$data_kaiin_mixi[$data_cnt] = $ret[$name];			//ＭＩＸＩ名
							$name = "data_mail_" . $i;
							$tmp_mail = $ret[$name];			//会員メールアドレス
							$tmp_mail = str_replace(',','<br>',$tmp_mail );
							$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
							$name = "data_tel_" . $i;
							$tmp_tel = $ret[$name];			//会員電話番号
							$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
							$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
							
							//会員名カナの調整
							if( $data_kaiin_nm_k[$data_cnt] == "　" ){
								$data_kaiin_nm_k[$data_cnt] = "";	
							}
								
							//会員区分の判定
							$data_kaiin_mixi[$data_cnt] = strtoupper($data_kaiin_mixi[$data_cnt]);	//小文字を大文字に変換する
							$tmp_pos = strpos($data_kaiin_mixi[$data_cnt],"JW");
							if( $tmp_pos !== false ){
								//メンバー
								$data_kaiin_kbn[$data_cnt] = 1;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
							}else{
								//一般（無料メンバー）
								$data_kaiin_kbn[$data_cnt] = 9;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
							}
							
							$i++;
							$data_cnt++;
						}
					}
					
				}else{
					// NG	
					$err_select_kaiin_no = 1;
					$err_cnt++;
					
				}
			}
		
		}else if( $serch_flg == 2 ){
			//会員名で検索
			$err_select_kaiin_nm = 0;
			
			$strcng_bf = $select_kaiin_nm;
			require( '../zz_strcng.php' );	// 禁止文字（ ”’）を全角にする
			$select_kaiin_nm = $strcng_af;

			$select_kaiin_nm = str_replace("　","",$select_kaiin_nm );	//全角スペースを削除
			$select_kaiin_nm = str_replace(" ","",$select_kaiin_nm );	//半角スペースを削除

			//引数チェック
			if( $select_kaiin_nm == '' ){
				$err_select_kaiin_nm = 1;
				$err_cnt++;
			
			}else{
				
				
				//メンバー顧客情報を参照する
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'serch_name' => $select_kaiin_nm
				);

				$url = 'https://toratoracrm.com/crm/CS_serch_name.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$member_cnt = $ret['data_cnt'];
					
					if( $member_cnt > 0 ){
						$i = 0;
						while( $i < $member_cnt ){
							if( $data_cnt < $max_cnt ){
								$name = "data_id_" . $i;
								$data_kaiin_no[$data_cnt] = $ret[$name];			//会員番号
								$name = "data_name_" . $i;
								$data_kaiin_nm[$data_cnt] = $ret[$name];			//会員名
								$name = "data_name_k_" . $i;
								$data_kaiin_nm_k[$data_cnt] = $ret[$name];			//会員名カナ
								$name = "data_mixi_" . $i;
								$data_kaiin_mixi[$data_cnt] = $ret[$name];			//ＭＩＸＩ名
								$name = "data_mail_" . $i;
								$tmp_mail = $ret[$name];			//会員メールアドレス
								$tmp_mail = str_replace(',','<br>&nbsp;',$tmp_mail );
								$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
								$name = "data_tel_" . $i;
								$tmp_tel = $ret[$name];			//会員電話番号
								
								//会員名カナの調整
								if( $data_kaiin_nm_k[$data_cnt] == "　" ){
									$data_kaiin_nm_k[$data_cnt] = "";	
								}
								
								//電話番号調整
								$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
								$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
								
								//会員区分の判定
								$data_kaiin_mixi[$data_cnt] = strtoupper($data_kaiin_mixi[$data_cnt]);	//小文字を大文字に変換する
								$tmp_pos = strpos($data_kaiin_mixi[$data_cnt],"JW");
								if( $tmp_pos !== false ){
									//メンバー
									$data_kaiin_kbn[$data_cnt] = 1;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}else{
									//一般（無料メンバー）
									$data_kaiin_kbn[$data_cnt] = 9;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}
							}
							$i++;
							$data_cnt++;
						}
					}
					
				}else{
					// NG	
					$err_select_kaiin_nm = 2;
					$err_cnt++;
					
				}
			}
		
		}else if( $serch_flg == 3 ){
			//会員メールアドレスで検索
			$err_select_kaiin_mail = 0;
			
			$strcng_bf = $select_kaiin_mail;
			require( '../zz_strdel.php' );	// 禁止文字（ ”’）を削除する
			$select_kaiin_mail = $strcng_af;
			
			//引数チェック
			if( $select_kaiin_mail == '' ){
				$err_select_kaiin_mail = 1;
				$err_cnt++;
			
			}else{
				
				//メンバー顧客情報を参照する
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'serch_mailadr' => $select_kaiin_mail
				);

				$url = 'https://toratoracrm.com/crm/CS_serch_mailadr.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$member_cnt = $ret['data_cnt'];
					
					if( $member_cnt > 0 ){
						$i = 0;
						while( $i < $member_cnt ){
							if( $data_cnt < $max_cnt ){
								$name = "data_id_" . $i;
								$data_kaiin_no[$data_cnt] = $ret[$name];			//会員番号
								$name = "data_name_" . $i;
								$data_kaiin_nm[$data_cnt] = $ret[$name];			//会員名
								$name = "data_name_k_" . $i;
								$data_kaiin_nm_k[$data_cnt] = $ret[$name];			//会員名カナ
								$name = "data_mixi_" . $i;
								$data_kaiin_mixi[$data_cnt] = $ret[$name];			//ＭＩＸＩ名
								$name = "data_mail_" . $i;
								$tmp_mail = $ret[$name];			//会員メールアドレス
								$tmp_mail = str_replace(',','<br>&nbsp;',$tmp_mail );
								$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
								$name = "data_tel_" . $i;
								$tmp_tel = $ret[$name];			//会員電話番号
								
								//会員名カナの調整
								if( $data_kaiin_nm_k[$data_cnt] == "　" ){
									$data_kaiin_nm_k[$data_cnt] = "";	
								}
								
								//電話番号調整
								$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
								$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
								
								//会員区分の判定
								$data_kaiin_mixi[$data_cnt] = strtoupper($data_kaiin_mixi[$data_cnt]);	//小文字を大文字に変換する
								$tmp_pos = strpos($data_kaiin_mixi[$data_cnt],"JW");
								if( $tmp_pos !== false ){
									//メンバー
									$data_kaiin_kbn[$data_cnt] = 1;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}else{
									//一般（無料メンバー）
									$data_kaiin_kbn[$data_cnt] = 9;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}
								
							}
							$i++;
							$data_cnt++;
						}
					}
					
				}else{
					// NG	
					$err_select_kaiin_mail = 2;
					$err_cnt++;
					
				}
			}
			
		
		}else if( $serch_flg == 4 ){
			//会員電話番号で検索
			$err_select_kaiin_tel = 0;
			
			$strcng_bf = $select_kaiin_tel;
			require( '../zz_strdel.php' );	// 禁止文字（ ”’）を削除する
			$select_kaiin_tel = $strcng_af;
						
			//引数チェック
			if( $select_kaiin_tel == '' ){
				$err_select_kaiin_tel = 1;
				$err_cnt++;
			
			}else{
				
				//入力電話番号を数字のみにする
				$select_kaiin_tel_length = mb_strlen( $select_kaiin_tel );
				$select_kaiin_tel_idx = 0;
				$select_kaiin_tel_num = '';		//数字のみの入力電話番号
				while( $select_kaiin_tel_idx < $select_kaiin_tel_length ){
					if( is_numeric( mb_substr( $select_kaiin_tel , $select_kaiin_tel_idx , 1 ) ) ){
						$select_kaiin_tel_num .= mb_substr( $select_kaiin_tel , $select_kaiin_tel_idx , 1 );
					}
					$select_kaiin_tel_idx++;
				}

				//メンバー顧客情報を参照する
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'serch_tel' => $select_kaiin_tel_num
				);

				$url = 'https://toratoracrm.com/crm/CS_serch_tel.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$member_cnt = $ret['data_cnt'];
					
					if( $member_cnt > 0 ){
						$i = 0;
						while( $i < $member_cnt ){
							if( $data_cnt < $max_cnt ){
								$name = "data_id_" . $i;
								$data_kaiin_no[$data_cnt] = $ret[$name];			//会員番号
								$name = "data_name_" . $i;
								$data_kaiin_nm[$data_cnt] = $ret[$name];			//会員名
								$name = "data_name_k_" . $i;
								$data_kaiin_nm_k[$data_cnt] = $ret[$name];			//会員名カナ
								$name = "data_mixi_" . $i;
								$data_kaiin_mixi[$data_cnt] = $ret[$name];			//ＭＩＸＩ名
								$name = "data_mail_" . $i;
								$tmp_mail = $ret[$name];			//会員メールアドレス
								$tmp_mail = str_replace(',','<br>&nbsp;',$tmp_mail );
								$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
								$name = "data_tel_" . $i;
								$tmp_tel = $ret[$name];			//会員電話番号
								
								//会員名カナの調整
								if( $data_kaiin_nm_k[$data_cnt] == "　" ){
									$data_kaiin_nm_k[$data_cnt] = "";	
								}
								
								//電話番号調整
								$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
								$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
								
								//会員区分の判定
								$data_kaiin_mixi[$data_cnt] = strtoupper($data_kaiin_mixi[$data_cnt]);	//小文字を大文字に変換する
								$tmp_pos = strpos($data_kaiin_mixi[$data_cnt],"JW");
								if( $tmp_pos !== false ){
									//メンバー
									$data_kaiin_kbn[$data_cnt] = 1;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}else{
									//一般（無料メンバー）
									$data_kaiin_kbn[$data_cnt] = 9;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
								}
								
							}
							$i++;
							$data_cnt++;
						}
					}
					
				}else{
					// NG	
					$err_select_kaiin_tel = 2;
					$err_cnt++;
					
				}
				
			}
		
		}else{
			//該当なし
			$err_cnt++;
		}
			

		if( $err_flg == 0 ){
			if( $err_cnt == 0 ){
				//エラーなし
				
				if( $data_cnt == 1 ){
					//１件ヒット
					
					//現在（今日以降）の予約数を求める
					$new_yyk_cnt = 0;
					$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.STAFF_CD,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
					         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
							 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $data_kaiin_no[0] . '" and A.YMD >= "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
							 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
							 ' order by A.YMD desc,A.JKN_KBN;';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zs_errgmn.php' );
								
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約のselectに失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
						
					}else{
						while( $row = mysql_fetch_array($result) ){
							$new_yyk_office_cd[$new_yyk_cnt] = $row[0];		//店舗コード
							$new_yyk_class_cd[$new_yyk_cnt] = $row[1];		//クラスコード
							$new_yyk_ymd[$new_yyk_cnt] = $row[2];			//年月日
							$new_yyk_jkn_kbn[$new_yyk_cnt] = $row[3];		//時間区分
							$new_yyk_yyk_no[$new_yyk_cnt] = $row[4];		//予約番号
							$new_yyk_staff_cd[$new_yyk_cnt] = $row[5];		//スタッフコード（カウンセラー指名）
							$new_yyk_yyk_time[$new_yyk_cnt] = $row[6];		//予約日時
							$new_yyk_cancel_time[$new_yyk_cnt] = $row[7];	//キャンセル可能日時
							$new_yyk_yyk_staff_cd[$new_yyk_cnt] = $row[8];	//予約受付スタッフコード
							$new_yyk_office_nm[$new_yyk_cnt] = $row[9];		//オフィス名
							$new_yyk_st_time[$new_yyk_cnt] = $row[10];		//開始時刻
							$new_yyk_ed_time[$new_yyk_cnt] = $row[11];		//終了時刻
							
							//「オフィス」を「会場」に置換する
							$new_yyk_office_nm[$new_yyk_cnt] = str_replace('オフィス','会場',$new_yyk_office_nm[$new_yyk_cnt] );			
							
							$new_yyk_cnt++;
						}
					}


					//過去の予約数を求める
					$old_yyk_cnt = 0;
					$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.STAFF_CD,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
					         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
							 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $data_kaiin_no[0] . '" and A.YMD < "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
							 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
							 ' order by A.YMD desc,A.JKN_KBN;';
							 
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zs_errgmn.php' );
								
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約のselectに失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
			
					}else{
						while( $row = mysql_fetch_array($result) ){
							$old_yyk_office_cd[$old_yyk_cnt] = $row[0];		//店舗コード
							$old_yyk_class_cd[$old_yyk_cnt] = $row[1];		//クラスコード
							$old_yyk_ymd[$old_yyk_cnt] = $row[2];			//年月日
							$old_yyk_jkn_kbn[$old_yyk_cnt] = $row[3];		//時間区分
							$old_yyk_yyk_no[$old_yyk_cnt] = $row[4];		//予約番号
							$old_yyk_staff_cd[$new_yyk_cnt] = $row[5];		//スタッフコード（カウンセラー指名）
							$old_yyk_yyk_time[$old_yyk_cnt] = $row[6];		//予約日時
							$old_yyk_cancel_time[$old_yyk_cnt] = $row[7];	//キャンセル可能日時
							$old_yyk_yyk_staff_cd[$old_yyk_cnt] = $row[8];	//予約受付スタッフコード
							$old_yyk_office_nm[$old_yyk_cnt] = $row[9];		//オフィス名
							$old_yyk_st_time[$old_yyk_cnt] = $row[10];		//開始時刻
							$old_yyk_ed_time[$old_yyk_cnt] = $row[11];		//終了時刻

							//「オフィス」を「会場」に置換する
							$old_yyk_office_nm[$old_yyk_cnt] = str_replace('オフィス','会場',$old_yyk_office_nm[$old_yyk_cnt] );			

							$old_yyk_cnt++;
						}
					}
					
					//使用機種を求める
					// $mobile_kbn	:A:Android(mb) B:Android(tab) I:iPhone J:iPad D:DoCoMo(mb) U:au(mb) S:Softbank(mb) W:WILLCOM M:Macintosh P:PC
					require( '../zz_uachk.php' );
					
					//***画面編集****************************************************************************************************
					
					print('<center>');
					
					//ページ編集
					print('<table><tr>');
					print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
					print('</tr></table>');
					
					if( $select_yyk_no == "" ){
						//新規予約時
						
						print('<table border="0">');	//sub01
						print('<tr>');	//sub01
						print('<td width="85">&nbsp;</td>');	//sub01
						print('<td width="730" align="center">');	//sub01
						
						print('<table border="1">');
						//会場
						print('<tr>');
						print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
						print('<td width="565" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_565x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
						print('</tr>');
						//日時
						print('<tr>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
						if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
							$fontcolor = "red";	//祝日/日曜
						}else if( $select_youbi_cd == 6 ){
							$fontcolor = "blue";	//土曜
						}else{
							$fontcolor = "black";	//平日
						}
						print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="6" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
						print('</tr>');
						//カウンセラー
						print('<tr>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png">');
						if( $select_staff_nm != "" ){
							print('<font size="5">' . $select_open_staff_nm . '</font>&nbsp;(' . $select_staff_nm . ')' );
						}else{
							print('(カウンセラー指名なし)');
						}
						print('</td>');
						print('</tr>');
						print('</table>');
						
						if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
							//非営業日
							print('<font color="red">非営業日です。</font>');
						}else if( $select_ymd < $now_yyyymmdd ){
							//「過去日を選択しています」
							print('<img src="./img_' . $lang_cd . '/warning_kakobi.png" border="0">');
						}else if( $select_ymd == $now_yyyymmdd && $Mclass_ed_time <= ($now_hh * 100 + $now_ii) ){
							//「過去時刻を選択しています」
							print('<img src="./img_' . $lang_cd . '/warning_kakojikoku.png" border="0">');
						}
						
						print('</td>');	//sub01
						//戻るボタン
						print('<form method="post" action="kbtcounseling_trk_serch.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
						print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
						print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
						print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
						
						print('<td width="135" align="center" valign="top">');	//sub01
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');	//sub01
						print('</form>');
						print('</tr>');	//sub01
						print('</table>');	//sub01
	
						//「入力内容を確認後、登録ボタンを押下してください。」
						print('<img src="./img_' . $lang_cd . '/title_kbtkaiin_kkn2.png" border="0"><br>');
	
						print('<form method="post" action="kbtcounseling_trk_serch_kkn1.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						print('<input type="hidden" name="serch_flg" value="' . $serch_flg . '">');
						print('<input type="hidden" name="select_kaiin_no" value="' . $data_kaiin_no[0] . '">');
						print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
						print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
						print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
						print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
							
						print('<table border="0">');	//main
						print('<tr>');	//main
						print('<td align="left">');	//main
	
						print('<table border="0">');	//sub1
						print('<tr>');	//sub1
						print('<td width="630" align="left" valign="top">');	//sub1

						//お客様番号・氏名
						print('<table border="0">');
						print('<tr>');
						//お客様番号
						print('<td width="150" align="left" valign="top">');
						print('<img src="./img_' . $lang_cd . '/title_okyakusamano.png" border="0"><br>');
						print('<font size="4" color="blue">' . $data_kaiin_no[0] . '</font>');
						if( $data_kaiin_kbn[0] == 1 ){
							//有料メンバー
							print('<br><font size="2">(' . $data_kaiin_mixi[0] . ')</font>');
						}else{
							//無料メンバー
							print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
						}
						print('</td>');
						//氏名
						print('<td width="480" align="left" valign="top">');
						print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
						if( $data_kaiin_nm_k[0] != '' ){
							print('<font size="2" color="blue">' . $data_kaiin_nm_k[0] . '</font><br>');
						}
						print('<font size="5" color="blue">' . $data_kaiin_nm[0] . '</font>');
						print('</td>');
						print('</tr>');	
						print('</table>');
						
						print('</td>');	//sub1					
						
						print('</tr>');	//sub1
						print('<tr>');	//sub1
						print('<td align="left" valign="top">');	//sub1
					
						print('<table border="0">');
						print('<tr>');
						//電話番号
						print('<td width="250" align="left" valign="top">');
						print('<img src="./img_' . $lang_cd . '/title_kaiintel.png" border="0"><br>');
						if( $data_kaiin_tel[0] == "" && $data_kaiin_tel_keitai[0] == "" ){
							print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
						}else{
							if( $data_kaiin_tel[0] != "" ){
								print('<font size="5" color="blue">' . $data_kaiin_tel[0] . '</font><br>');
							}
							if( $data_kaiin_tel_keitai[0] != "" ){
								print('<font size="5" color="blue">' . $data_kaiin_tel_keitai[0] . '</font><br>');
							}
						}
						print('</td>');
						print('<td align="left" valign="top">');
						//メールアドレス
						print('<img src="./img_' . $lang_cd . '/title_kaiinmail.png" border="0"><br>');
						if( $data_kaiin_mail[0] != '' ){
							print('<font color="blue">' . $data_kaiin_mail[0] . '</font>');
						}else{
							print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
						}
						print('</td>');
						print('</tr>');	
						print('</table>');

						//興味のある国
						print('<input type="hidden" name="kaiin_kyoumi" value="' . $kaiin_kyoumi . '" />');
//						print('<table border="0">');
//						print('<tr>');
//						print('<td width="750" align="left">');
//						print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
//						$tabindex++;
//						print('<input type="text" name="kaiin_kyoumi" maxlength="100" size="30" value="' . $kaiin_kyoumi . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; background-color: #E0FFFF; ime-mode:active; font-family: sans-serif;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//						print('</td>');
//						print('</tr>');
//						print('</table>');

						//出発予定時期
						print('<input type="hidden" name="kaiin_jiki" value="' . $kaiin_jiki . '" />');
//						print('<table border="0">');
//						print('<tr>');
//						print('<td width="750" align="left">');
//						print('<img src="./img_' . $lang_cd . '/title_jiki.png" border="0"><br>');
//						$tabindex++;
//						print('<input type="text" name="kaiin_jiki" maxlength="100" size="30" value="' . $kaiin_jiki . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; background-color: #E0FFFF; ime-mode:active; font-family: sans-serif;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//						print('</td>');
//						print('</tr>');
//						print('</table>');

						//相談内容
						print('<table border="0">');
						print('<tr>');
						print('<td width="750" align="left">');
						print('<img src="./img_' . $lang_cd . '/title_soudan.png" border="0"><br>');
						$tabindex++;
						print('<textarea name="kaiin_soudan" rows="5"  style="ime-mode:active;" tabindex="' . $tabindex . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $kaiin_soudan . '</textarea>');
						print('</td>');
						print('</tr>');
						print('</table>');

						print('</td>');	//sub1					
						print('</tr>');	//sub1
						print('</table>');	//sub1
					
					}else{
						//日時変更時

						print('<table border="0">');
						print('<tr>');
						print('<td width="135">&nbsp;</td>');
						print('<td width="680" align="center" valign="middle">');
						//「個別カウンセリング　日時変更　（現在の予約内容）」
						print('<img src="./img_' . $lang_cd . '/title_kbtcounseling_genzainaiyou.png" border="0"><br>');
						print('</td>');
						print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						//日時変更引数
						print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
						print('<td align="right">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						print('</tr>');
						print('</table>');
						
						//現在の予約内容を表示する
						//背景色
						if( $zz_yykinfo_ymd > $now_yyyymmdd2 || ($zz_yykinfo_ymd == $now_yyyymmdd2 && $zz_yykinfo_st_time > ($now_hh * 100 + $now_ii) )){
							//未来
							$bgfile_1 = "mizu";
							$bgcolor_1 = "#d6fafa";
						}else{
							//過去
							$bgfile_1 = "lightgrey";
							$bgcolor_1 = "#d3d3d3";
						}
						
						if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
							//仮登録
							$bgcolor_2 = "#fffa6e";
							$bgfile_2 = "yellow";
						}else if( $zz_yykinfo_kaiin_kbn == 1 ){
							//メンバー
							$bgcolor_2 = "#aefd9f";
							$bgfile_2 = "kimidori";
						}else if( $zz_yykinfo_kaiin_kbn == 9 ){
							//一般（無料メンバー）
							$bgcolor_2 = "#ffc0cb";
							$bgfile_2 = "pink";
						}
								
						//年月日表示
						if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
							//祝日
							$fontcolor_2 = "red";
						}else if( $zz_yykinfo_youbi_cd == 0 ){
							//日曜
							$fontcolor_2 = "red";
						}else if( $zz_yykinfo_youbi_cd == 6 ){
							//土曜
							$fontcolor_2 = "blue";
						}else{
							//平日
							$fontcolor_2 = "black";
						}
					
						print('<table border="1">');
						//予約番号／会場
						print('<tr>');
						print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
						print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
						print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
						print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="4" color="blue">' . $zz_yykinfo_office_nm . '</font>');
						if( $zz_yykinfo_staff_cd != "" ){
							print('<font size="2" color="blue">&nbsp;(&nbsp;' . $zz_yykinfo_open_staff_nm . '&nbsp;)</font>');
						}
						print('</td>');
						print('</tr>');
						
						//日時
						print('<tr>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
						print('<td colspan="3" align="center" valign="middle" bgcolor="' . $bgcolor_1 . '"><font size="6" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;年&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;月&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
						print('</tr>');
						
						//お客様番号／氏名
						print('<tr>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
						if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
							print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
						}else if( $zz_yykinfo_kaiin_kbn == 1 ){
							//メンバー
							print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font><br>(' . $zz_yykinfo_kaiin_mixi . ')');
						}else if( $zz_yykinfo_kaiin_kbn == 9 ){
							//一般（無料メンバー）
							print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font><br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
						}else{
							print('<font size="4" color="red">エラー</font>');
						}
						print('</td>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
						if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
							print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
						}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
							print('<table border="0">');
							print('<tr>');
							print('<td align="left" valign="middle">');
							if( $zz_yykinfo_kaiin_nm_k != "" ){
								print('<font size="2" color="blue">' . $zz_yykinfo_kaiin_nm_k . '</font><br>');
							}
							print('<font size="4" color="blue">' . $zz_yykinfo_kaiin_nm . '</font>');
							print('</td>');
							print('<td valign="bottom"><font size="2">様</font></td>');
							print('</tr>');
							print('</table>');
							
						}else{
							print('<font size="4" color="red">エラー</font>');
						}
						print('</td>');
						print('</tr>');
						print('</table>');

						//「変更後の日時」
						print('<img src="./img_' . $lang_cd . '/title_henkougo_nichiji.png" border="0"><br>');
						
						print('<table border="1">');
						print('<tr>');
						print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
						print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font color="gray">未確定</font></td>');
						print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
						print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="4" color="gray">' . $Moffice_office_nm . '</font>');
						if( $select_staff_cd != "" ){
							//カウンセラー編集
							print('&nbsp;<font size="2" color="gray">(&nbsp;' . $select_open_staff_nm . '&nbsp;)</font>');
						}
						print('</td>');
						print('</tr>');
						print('<tr>');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
						if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
							$fontcolor = "red";	//祝日/日曜
						}else if( $select_youbi_cd == 6 ){
							$fontcolor = "blue";	//土曜
						}else{
							$fontcolor = "black";	//平日
						}
						print('<td colspan="3" align="center" valign="bottom" bgcolor="#d3d3d3"><font size="6" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
						print('</tr>');
						print('</table>');
						
						if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
							//非営業日
							print('<font color="red">非営業日です。</font>');
						}else if( $select_ymd < $now_yyyymmdd ){
							//「過去日を選択しています」
							print('<img src="./img_' . $lang_cd . '/warning_kakobi.png" border="0">');
						}else if( $select_ymd == $now_yyyymmdd && $Mclass_ed_time <= ($now_hh * 100 + $now_ii) ){
							//「過去時刻を選択しています」
							print('<img src="./img_' . $lang_cd . '/warning_kakojikoku.png" border="0">');
						}
						
						//変更前と変更後が同じ日時の場合、登録ボタンは表示させない。
						$tmp_zz_yykinfo_ymd = substr($zz_yykinfo_ymd,0,4) . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . sprintf("%02d",substr($zz_yykinfo_ymd,8,2));
						if( $select_office_cd == $zz_yykinfo_office_cd && $select_ymd == $tmp_zz_yykinfo_ymd && $select_jknkbn == $zz_yykinfo_jkn_kbn ){
							
							
							//「変更前と同一日時のため、変更できません。」	
							print('<img src="./img_' . $lang_cd . '/title_err_douitsunichiji.png" border="0">');
						}else{
							
							print('<form method="post" action="kbtcounseling_trk_serch_kkn1.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
							print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
							print('<input type="hidden" name="serch_flg" value="' . $serch_flg . '">');
							print('<input type="hidden" name="select_kaiin_no" value="' . $data_kaiin_no[0] . '">');
							print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
							print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
							print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
							//日時変更引数
							print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
						}
					}

					print('</td>');	//main1
					print('</tr>'); //main1
					print('</table>');	//main1


					print('<table border="0">');
					print('<tr>');
					print('<td width="90" rowspan="2">&nbsp;</td>');
					print('<td width="725" rowspan="2" align="left" valign="top">');
					if( $select_yyk_no == "" ){
						//新規予約時
						//記入例
						print('<img src="./img_' . $lang_cd . '/title_kinyurei.png" border="0">');
					}else{
						print('&nbsp;');	
					}
					print('</td>');
					print('<td width="135" align="right">');
					//変更前と変更後が同じ日時の場合、登録ボタンは表示させない。
					if( !($select_office_cd == $zz_yykinfo_office_cd && $select_ymd == $tmp_zz_yykinfo_ymd && $select_jknkbn == $zz_yykinfo_jkn_kbn) ){
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
					}else{
						print('&nbsp;');	
					}
					print('</td>');
					if( !($select_office_cd == $zz_yykinfo_office_cd && $select_ymd == $tmp_zz_yykinfo_ymd && $select_jknkbn == $zz_yykinfo_jkn_kbn) ){
						print('</form>');
					}
					print('</tr>');
					print('<tr>');
					if( $select_yyk_no == "" ){
						//新規予約時
						print('<form method="post" action="kbtcounseling_trk_serch.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
						print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
						print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
						print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
						
					}else{
						//日時変更時
						print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php#' . $select_ymd . '">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						//日時変更引数
						print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
						
					}
					print('<td align="right">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');

					print('<hr>');

					//***現在の予約********************************************************************
					print('<table bgcolor="orange"><tr><td width="950">');
					print('<img src="./img_' . $lang_cd . '/bar_genzaiyyk.png" border="0">');
					print('</td></tr></table>');
					
					//「本日以降の予約数」
					print('<table border="0">');
					print('<tr>');
					print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_honjitsuikounoyyksu.png" border="0"></td>');
					print('<td valign="bottom"><font size="5" color="blue">' . $new_yyk_cnt . '</font></td>');
					print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_ken.png" border="0"></td>');
					print('</tr>');
					print('</table>');
					
					if( $new_yyk_cnt == 0 ){
						//「※現在、予約はありません。」
						print('<img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br>');
					
					}else{
						
						print('<table border="1">');
						print('<tr bgcolor="powderblue">');
						print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
						print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
						print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_naiyou_80x20.png" border="0"></td>');	//予約内容
						print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約会場
						print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_trkbi_170x20.png" border="0"></td>');	//予約登録日／登録者
						print('</tr>');
						
						$i = 0;
						while( $i < $new_yyk_cnt ){
							
							//曜日コードを求める
							$youbi_cd = date("w", mktime(0, 0, 0, substr($new_yyk_ymd[$i],5,2), substr($new_yyk_ymd[$i],8,2) , substr($new_yyk_ymd[$i],0,4)) );							
							//営業日フラグを求める
							$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
							$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $new_yyk_office_cd[$i] . '" and YMD = "' . $new_yyk_ymd[$i] . '";';
							$result = mysql_query($query);
							if (!$result) {
								$err_flg = 4;
								//エラーメッセージ表示
								require( './zs_errgmn.php' );
										
								//**ログ出力**
								$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = $office_cd;	//オフィスコード
								$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
								$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zs_log.php' );
								//************
								
							}else{
								while( $row = mysql_fetch_array($result) ){
									$eigyoubi_flg = $row[0];	//営業日フラグ
								}
							}
							
							//背景色
							if( $new_yyk_ymd[$i] == $now_yyyymmdd2 ){
								//本日予約
								$bgfile = "bg_mizu";
							}else{
								//未来日
								$bgfile = "bg_yellow";
							}
						
							print('<tr>');
							//予約No
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
							print('<font size="2">' . sprintf("%05d",$new_yyk_yyk_no[$i]) . '</font>');
							print('</td>');
							//予約日／時間
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
							if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
								//日曜・祝日
								$fontcolor = 'red';
							}else if( $youbi_cd == 6 ){
								//土曜
								$fontcolor = 'blue';
							}else{
								$fontcolor = 'black';
							}
							print('<font size="2" color="' . $fontcolor . '">' . $new_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($new_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_st_time[$i] % 100 )) . '～' . intval($new_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_ed_time[$i] % 100 )) . '</font>');
							print('</td>');
							//予約内容
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
							//クラス名を求める
							$Dclass_class_nm = "";
							$query = 'select CLASS_NM from M_CLASS ' .
									 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $new_yyk_office_cd[$i] . '" and CLASS_CD = "' . $new_yyk_class_cd[$i] . '";';
							$result = mysql_query($query);
							if (!$result) {
								$err_flg = 4;
								//エラーメッセージ表示
								require( './zs_errgmn.php' );
										
								//**ログ出力**
								$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = $office_cd;	//オフィスコード
								$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
								$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zs_log.php' );
								//************
								
							}else{
								$row = mysql_fetch_array($result);
								$Dclass_class_nm = $row[0];	//クラス名
							}
							print('<font color="blue">&nbsp;&nbsp;' . $Dclass_class_nm . '</font>');
							print('</td>');
							//予約会場
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
							print('<font size="2" color="blue">&nbsp;&nbsp;' . $new_yyk_office_nm[$i] . '</font>');
							if( $new_yyk_staff_cd[$i] != "" ){
								//カウンセラー指名あり
								$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $new_yyk_staff_cd[$i] . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zs_errgmn.php' );
											
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = $office_cd;	//オフィスコード
									$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
									$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zs_log.php' );
									//************
					
								}else{
									$row = mysql_fetch_array($result);
									$new_yyk_staff_nm[$i] = $row[0];
								}
								print('<br><font size="1" color="blue">&nbsp;&nbsp;(&nbsp;' . $new_yyk_staff_nm[$i] . '&nbsp;)</font>');
							}
							print('</td>');
							//予約登録日／受付者
							$new_yyk_yyk_staff_nm[$i] = '';
							if( $new_yyk_yyk_staff_cd[$i] != '' ){

								//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
								$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $new_yyk_yyk_staff_cd[$i] . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zs_errgmn.php' );
											
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = $office_cd;	//オフィスコード
									$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
									$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zs_log.php' );
									//************
					
								}else{
									$row = mysql_fetch_array($result);
									$new_yyk_yyk_staff_nm[$i] = $row[0];
								}
							}
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
							print('<font size="2">&nbsp;&nbsp;' . $new_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
							if( $new_yyk_yyk_staff_cd[$i] == '' ){
								print('会員入力');
							}else{
								print('<font size="1">受付：</font>'. $new_yyk_yyk_staff_nm[$i] );
							}
							print('</font>');
							print('</td>');
							print('</tr>');
						
							$i++;
						}
						print('</table>');
						
					}

					print('<hr>');

					//***過去の予約********************************************************************
					print('<table bgcolor="lightgrey"><tr><td width="950">');
					print('<img src="./img_' . $lang_cd . '/bar_kakoyyk.png" border="0">');
					print('</td></tr></table>');

					//「過去の予約数」
					print('<table border="0">');
					print('<tr>');
					print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_kakonoyyksu.png" border="0"></td>');
					print('<td valign="bottom"><font size="5" color="blue">' . $old_yyk_cnt . '</font></td>');
					print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_ken.png" border="0"></td>');
					print('</tr>');
					print('</table>');

					if( $old_yyk_cnt == 0 ){
						//「※現在、予約はありません。」
						print('<img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br>');
					
					}else{
						
						print('<table border="1">');
						print('<tr bgcolor="powderblue">');
						print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
						print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
						print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_naiyou_80x20.png" border="0"></td>');	//予約内容
						print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約会場
						print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_trkbi_170x20.png" border="0"></td>');	//予約登録日／登録者
						print('</tr>');
						
						$i = 0;
						while( $i < $old_yyk_cnt ){
							
							//曜日コードを求める
							$youbi_cd = date("w", mktime(0, 0, 0, substr($old_yyk_ymd[$i],5,2), substr($old_yyk_ymd[$i],8,2) , substr($old_yyk_ymd[$i],0,4)) );							
							//営業日フラグを求める
							$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
							$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $old_yyk_office_cd[$i] . '" and YMD = "' . $old_yyk_ymd[$i] . '";';
							$result = mysql_query($query);
							if (!$result) {
								$err_flg = 4;
								//エラーメッセージ表示
								require( './zs_errgmn.php' );
										
								//**ログ出力**
								$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = $office_cd;	//オフィスコード
								$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
								$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zs_log.php' );
								//************
				
							}else{
								while( $row = mysql_fetch_array($result) ){
									$eigyoubi_flg = $row[0];	//営業日フラグ
								}
							}
							
							//背景色
							$bgfile = "bg_lightgrey";
						
							print('<tr>');
							//予約No
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
							print('<font size="2">' . sprintf("%05d",$old_yyk_yyk_no[$i]) . '</font>');
							print('</td>');
							//予約日／時間
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
							if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
								//日曜・祝日
								$fontcolor = 'red';
							}else if( $youbi_cd == 6 ){
								//土曜
								$fontcolor = 'blue';
							}else{
								$fontcolor = 'black';
							}
							print('<font size="2" color="' . $fontcolor . '">' . $old_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($old_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_st_time[$i] % 100 )) . '～' . intval($old_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_ed_time[$i] % 100 )) . '</font>');
							print('</td>');
							//予約内容
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
							//クラス名を求める
							$query = 'select CLASS_NM from M_CLASS ' .
									 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $old_yyk_office_cd[$i] . '" and CLASS_CD = "' . $old_yyk_class_cd[$i] . '";';
							$result = mysql_query($query);
							if (!$result) {
								$err_flg = 4;
								//エラーメッセージ表示
								require( './zs_errgmn.php' );
										
								//**ログ出力**
								$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = $office_cd;	//オフィスコード
								$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
								$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zs_log.php' );
								//************
					
							}else{
								$row = mysql_fetch_array($result);
								$Dclassyyk_class_nm = $row[0];	//クラス名
							}
							print('<font color="blue">&nbsp;&nbsp;' . $Dclassyyk_class_nm . '</font>');
							print('</td>');
							//予約会場
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
							print('<font size="2" color="blue">&nbsp;&nbsp;' . $old_yyk_office_nm[$i] . '</font>');
							if( $old_yyk_staff_cd[$i] != "" ){
								//カウンセラー指名あり
								$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $old_yyk_staff_cd[$i] . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zs_errgmn.php' );
											
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = $office_cd;	//オフィスコード
									$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
									$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zs_log.php' );
									//************
					
								}else{
									$row = mysql_fetch_array($result);
									$old_yyk_staff_nm[$i] = $row[0];
								}
								print('<br><font size="1" color="blue">&nbsp;&nbsp;(&nbsp;' . $old_yyk_staff_nm[$i] . '&nbsp;)</font>');
							}
							print('</td>');
							//予約登録日／受付者
							$old_yyk_yyk_staff_nm[$i] = '';
							if( $old_yyk_yyk_staff_cd[$i] != '' ){
								//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
								$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $old_yyk_yyk_staff_cd[$i] . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zs_errgmn.php' );
											
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = $office_cd;	//オフィスコード
									$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
									$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zs_log.php' );
									//************
					
								}else{
									$row = mysql_fetch_array($result);
									$old_yyk_yyk_staff_nm[$i] = $row[0];
								}
							}
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
							print('<font size="2">&nbsp;&nbsp;' . $old_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
							if( $old_yyk_yyk_staff_cd[$i] == '' ){
								print('会員入力');
							}else{
								print('<font size="1">受付：</font>'. $old_yyk_yyk_staff_nm[$i] );
							}
							print('</font>');
							print('</td>');
							print('</tr>');
						
							$i++;
						}
						print('</table>');
						
					}

					print('<hr>');
				
				
				}else if( $data_cnt >= 2 ){
					//複数ヒット
					
					//***画面編集****************************************************************************************************
					
					print('<center>');
					
					//ページ編集
					print('<table><tr>');
					print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
					print('</tr></table>');
					
					print('<table border="0">');	//sub01
					print('<tr>');	//sub01
					print('<td width="85">&nbsp;</td>');	//sub01
					print('<td width="730" align="center">');	//sub01
					
					print('<table border="1">');
					//会場
					print('<tr>');
					print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_565x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
					print('</tr>');
					//日時
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="6" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
					print('</tr>');
					//カウンセラー
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png">');
					if( $select_staff_nm != "" ){
						print('<font size="5">' . $select_open_staff_nm . '</font>&nbsp;(' . $select_staff_nm . ')' );
					}else{
						print('(カウンセラー指定なし)');
					}
					print('</td>');
					print('</tr>');
					print('</table>');
					
					if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
						//非営業日
						print('<font color="red">非営業日です。</font>');
					}else if( $select_ymd < $now_yyyymmdd ){
						//「過去日を選択しています」
						print('<img src="./img_' . $lang_cd . '/warning_kakobi.png" border="0">');
					}else if( $select_ymd == $now_yyyymmdd && $Mclass_ed_time <= ($now_hh * 100 + $now_ii) ){
						//「過去時刻を選択しています」
						print('<img src="./img_' . $lang_cd . '/warning_kakojikoku.png" border="0">');
					}
					
					print('</td>');	//sub01
					//戻るボタン
					print('<form method="post" action="kbtcounseling_trk_serch.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
					print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
					print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
					print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
					print('<td width="135" align="center" valign="top">');	//sub01
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');	//sub01
					print('</form>');
					print('</tr>');	//sub01
					print('</table>');	//sub01



					if( $serch_flg == 2 ){
						print('会員名で検索：[&nbsp;<font color="red">' . $select_kaiin_nm . '</font>&nbsp;]<br>');
					}else if( $serch_flg == 3 ){
						print('メールアドレスで検索：[&nbsp;<font color="red">' . $select_kaiin_mail . '</font>&nbsp;]<br>');
					}else if( $serch_flg == 4 ){
						print('電話番号で検索：[&nbsp;<font color="red">' . $select_kaiin_tel . '</font>&nbsp;]<br>');
					}
					
					print('<table border="0">');
					print('<tr>');
					//「※」
					print('<td align="center" valign="bottom"><img src="./img_' . $lang_cd . '/title_kome.png" border="0"></td>');
					//該当件数
					print('<td align="center" valign="bottom"><font size="6" color="red">' . $data_cnt . '</font></td>');
					//「件のデータが該当しました。会員を選択してください。」
					print('<td align="center" valign="bottom"><img src="./img_' . $lang_cd . '/title_data_gaitou.png" border="0"></td>');
					print('</tr>');
					print('</table>');

					print('<table border="0">');
					print('<tr>');
					print('<td width="950" align="right">');
					print('<font size="2">(&nbsp;' . date( "Y-m-d H:i:s", time() ) . '&nbsp;時点)</font>');
					print('</td>');
					print('</tr>');
					print('</table>');
					
					print('<table border="1">');
					print('<tr bgcolor="powderblue">');
					print('<td width="55">&nbsp;</td>');
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');	//「会員番号」
					print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');	//「会員名」
					print('<td width="350" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kaiin_mail_150x20.png" border="0"></td>');	//「会員メールアドレス」
					print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kaiin_tel_100x20.png" border="0"></td>');	//「会員電話番号」
					print('</tr>');
					$i = 0;
					while ($i < $data_cnt && $i < $max_cnt ){
						
						if( $data_kaiin_kbn[$i] == 1 ){
							//メンバー
							$bgfile = 'bg_kimidori';
						}else if( $data_kaiin_kbn[$i] == 9 ){
							//一般（無料メンバー）
							$bgfile = 'bg_pink';
						}else{
							//その他
							$bgfile = 'bg_yellow';
						}
						print('<tr>');
						print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
						print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						print('<input type="hidden" name="serch_flg" value="1">');
						print('<input type="hidden" name="select_kaiin_no" value="' . $data_kaiin_no[$i] . '">');
						print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
						print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
						print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						//会員番号
						print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">' . $data_kaiin_no[$i] );
						if( $data_kaiin_kbn[$i] == 1 && $data_kaiin_mixi[$i] != "" ){
							print('<br>(' . $data_kaiin_mixi[$i] . ')');
						}else if( $data_kaiin_kbn[$i] == 9 ){
							print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
						}
						print('</td>');
						//会員名
						print('<td align="left" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						if( $data_kaiin_nm_k[$i] != '' ){
							print('&nbsp;<font size="1">' . $data_kaiin_nm_k[$i] . '</font><br>');
						}
						print('&nbsp;' . $data_kaiin_nm[$i] .'</td>');
						//メールアドレス
						print('<td align="left" background="../img_' . $lang_cd . '/' . $bgfile . '_350x20.png">');
						if( $data_kaiin_mail[$i] != '' ){
							print('&nbsp;' . $data_kaiin_mail[$i] );
						}else{
							print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
						}
						print('</td>');
						//電話番号
						print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
						if( $data_kaiin_tel[$i] != '' ){
							print( $data_kaiin_tel[$i] );
							if( $$data_kaiin_tel_keitai[$i] != '' ){
								print('<br>' . $$data_kaiin_tel_keitai[$i] );
							}
						}else{
							if( $$data_kaiin_tel_keitai[$i] != '' ){
								print( $$data_kaiin_tel_keitai[$i] );
							}else{
								print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
							}
						}
						print('</td>');
						print('</tr>');
						$i++;
					}
					print('</table>');

					if( $data_cnt > $max_cnt ){
						print('<table border="0">');
						print('<tr>');
						//「上記の他に」
						print('<td align="center" valign="bottom"><img src="./img_' . $lang_cd . '/title_hokani_1.png" border="0"></td>');
						//該当件数
						print('<td align="center" valign="middle"><font size="5" color="blue">' . ($data_cnt - $max_cnt)  . '</font></td>');
						//「件あります。」
						print('<td align="center" valign="bottom"><img src="./img_' . $lang_cd . '/title_hokani_2.png" border="0"></td>');
						print('</tr>');
						print('</table>');
						
					}


					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="right">');
					print('&nbsp;');
					print('</td>');
					print('<form method="post" action="kbtcounseling_trk_serch.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '">');
					print('<input type="hidden" name="select_kaiin_nm" value="' . $select_kaiin_nm . '">');
					print('<input type="hidden" name="select_kaiin_mail" value="' . $select_kaiin_mail . '">');
					print('<input type="hidden" name="select_kaiin_tel" value="' . $select_kaiin_tel . '">');
					print('<td align="center">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
		
					print('<hr>');
					

				}else{
					//データなし

					//***画面編集****************************************************************************************************
					
					print('<center>');
					
					//ページ編集
					print('<table><tr>');
					print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
					print('</tr></table>');
					
					print('<table border="0">');	//sub01
					print('<tr>');	//sub01
					print('<td width="85">&nbsp;</td>');	//sub01
					print('<td width="730" align="center">');	//sub01
					
					print('<table border="1">');
					//会場
					print('<tr>');
					print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_565x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
					print('</tr>');
					//日時
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="6" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
					print('</tr>');
					//カウンセラー
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png">');
					if( $select_staff_nm != "" ){
						print('<font size="5">' . $select_open_staff_nm . '</font>&nbsp;(' . $select_staff_nm . ')' );
					}else{
						print('(カウンセラー指定なし)');
					}
					print('</td>');
					print('</tr>');
					print('</table>');
					
					if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
						//非営業日
						print('<font color="red">非営業日です。</font>');
					}else if( $select_ymd < $now_yyyymmdd ){
						//「過去日を選択しています」
						print('<img src="./img_' . $lang_cd . '/warning_kakobi.png" border="0">');
					}else if( $select_ymd == $now_yyyymmdd && $Mclass_ed_time <= ($now_hh * 100 + $now_ii) ){
						//「過去時刻を選択しています」
						print('<img src="./img_' . $lang_cd . '/warning_kakojikoku.png" border="0">');
					}
					
					print('</td>');	//sub01
					//戻るボタン
					print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php#' . $select_ymd . '">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<td width="135" align="center" valign="top">');	//sub01
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');	//sub01
					print('</form>');
					print('</tr>');	//sub01
					print('</table>');	//sub01

					print('<table border="0">');
					print('<tr>');
					print('<td width="750">');

					//新規会員（非メンバー）の登録
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_new0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<td align="left" valign="top">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinki_kaiin_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinki_kaiin_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinki_kaiin_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('<td align="left" valign="top">');
					//「初めてカウンセリングを予約する」
					print('<img src="./img_' . $lang_cd . '/title_shinki_kaiin.png" border="0">');			
					print('</td>');
					print('</tr>');
					print('</table>');
			
					//仮予約（会員入力なし）
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_kari.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<td align="left" valign="top">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kari_yyk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kari_yyk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kari_yyk_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('<td align="left" valign="top">');
					//「メンバー（会員）情報は入力せず、時間枠だけ仮押さえしたい場合はこちら」
					print('<img src="./img_' . $lang_cd . '/title_kari_yyk.png" border="0">');			
					print('</td>');
					print('</tr>');
					print('</table>');
	
					print('<hr>');
			
					//「条件に該当する会員が見つかりませんでした。」
					print('<img src="./img_' . $lang_cd . '/title_jyoukennigaitousuru_0.png" border="0">');
					
					//「予約するメンバー（会員）の検索条件を入力し、検索します」
					print('<img src="./img_' . $lang_cd . '/title_member_serch.png" border="0">');

					//会員番号のテーブル
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="serch_flg" value="1">');
					print('<td align="left" valign="top">');
					print('<img src="./img_' . $lang_cd . '/title_kns1_kaiinno.png" border="0"><br>');
					print('<table boeder="0">');
					print('<tr>');
					print('<td align="left" valign="bottom">');
					$tabindex++;
					print('<input type="text" name="select_kaiin_no" maxlength="10" size="10" value="' . $select_kaiin_no . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
					print('</td>');
					print('<td align="left" valign="middle">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</tr>');
					print('</table>');
					if( $serch_flg == 1 ){
						print('<font size="2" color="red">「' . $select_kaiin_no . '」で見つかりませんでした。</font>');	
					}
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
					
					//会員名のテーブル
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="serch_flg" value="2">');
					print('<td align="left">');
					print('<img src="./img_' . $lang_cd . '/title_kns2_kaiinnm.png" border="0"><br>');
					print('<table boeder="0">');
					print('<tr>');
					print('<td align="left" valign="bottom">');
					$tabindex++;
					print('<input type="text" name="select_kaiin_nm" maxlength="40" size="16" value="' . $select_kaiin_nm . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
					print('</td>');
					print('<td align="left" valign="middle">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</tr>');
					print('</table>');
					if( $serch_flg == 2 ){
						print('<font size="2" color="red">「' . $select_kaiin_nm . '」で見つかりませんでした。</font>');	
					}
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
					
					//メールアドレスのテーブル
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="serch_flg" value="3">');
					print('<td align="left">');
					print('<img src="./img_' . $lang_cd . '/title_kns3_mail.png" border="0"><br>');
					print('<table boeder="0">');
					print('<tr>');
					print('<td align="left" valign="bottom">');
					$tabindex++;
					print('<input type="text" name="select_kaiin_mail" maxlength="40" size="30" value="' . $select_kaiin_mail . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
					print('</td>');
					print('<td align="left" valign="middle">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns3_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</tr>');
					print('</table>');
					if( $serch_flg == 3 ){
						print('<font size="2" color="red">「' . $select_kaiin_mail . '」で見つかりませんでした。</font>');	
					}
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
			
					//電話番号のテーブル
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="serch_flg" value="4">');
					print('<td align="left">');
					print('<img src="./img_' . $lang_cd . '/title_kns4_kaiintel.png" border="0"><br>');
					print('<table boeder="0">');
					print('<tr>');
					print('<td align="left" valign="bottom">');
					$tabindex++;
					print('<input type="text" name="select_kaiin_tel" maxlength="15" size="15" value="' . $select_kaiin_tel . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
					print('</td>');
					print('<td align="left" valign="middle">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</tr>');
					print('</table>');
					if( $serch_flg == 4 ){
						print('<font size="2" color="red">「' . $select_kaiin_tel . '」で見つかりませんでした。</font>');	
					}
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
			
					print('</td>');
					print('</tr>');
					print('</table>');
									
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">&nbsp;</td>');
					print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php#' . $select_ymd . '">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<td align="right">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
						
					print('</center>');
				
					print('<hr>');

				}
				
			}else{
				//引数エラーあり

				//***画面編集****************************************************************************************************
					
				print('<center>');
					
				//ページ編集
				print('<table><tr>');
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
				print('</tr></table>');
				
				print('<table border="0">');	//sub01
				print('<tr>');	//sub01
				print('<td width="85">&nbsp;</td>');	//sub01
				print('<td width="730" align="center">');	//sub01
				
				print('<table border="1">');
				//会場
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_office.png" border="0"></td>');
				print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_565x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
				print('</tr>');
				//日時
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="6" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="6" color="' . $fontcolor . '">&nbsp;' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				//カウンセラー
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png">');
				if( $select_staff_nm != "" ){
					print('<font size="5">' . $select_open_staff_nm . '</font>&nbsp;(' . $select_staff_nm . ')' );
				}else{
					print('(カウンセラー指定なし)');
				}
				print('</td>');
				print('</tr>');
				print('</table>');

				//「エラーがあります。」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0">');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="center" valign="middle">');
				//「確認する会員の条件を入力後、検索ボタンを押下してください。」		
				print('<img src="./img_' . $lang_cd . '/title_kakuninsurukaiin.png" border="0">');
				print('</td>');
				print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php#' . $select_ymd . '">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="750">');
				
				//会員番号のテーブル
				print('<table border="0">');
				print('<tr>');
				print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kns1_kaiinno.png" border="0"><br>');
				print('<table boeder="0">');
				print('<tr>');
				print('<td align="left" valign="bottom">');
				$tabindex++;
				print('<input type="text" name="select_kaiin_no" maxlength="10" size="10" value="' . $select_kaiin_no . '" class="');
				if( $err_select_kaiin_no == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns1_kaiinno_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				if( $err_select_kaiin_no == 1 ){
					print('<font size="2" color="red">※未入力&nbsp;または&nbsp;数字以外エラー&nbsp;です。</font>');
				}
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				//会員名のテーブル
				print('<table border="0">');
				print('<tr>');
				print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="serch_flg" value="2">');
				print('<td align="left">');
				print('<img src="./img_' . $lang_cd . '/title_kns2_kaiinnm.png" border="0"><br>');
				print('<table boeder="0">');
				print('<tr>');
				print('<td align="left" valign="bottom">');
				$tabindex++;
				print('<input type="text" name="select_kaiin_nm" maxlength="40" size="16" value="' . $select_kaiin_nm . '" class="');
				if( $err_select_kaiin_nm == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns2_kaiinnm_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				if( $err_select_kaiin_nm == 1 ){
					print('<font size="2" color="red">※未入力です。</font>');
				}else if( $err_select_kaiin_nm == 2 ){
					print('<font size="2" color="red">※顧客情報の参照に失敗しました。</font>');	//確認用
				}
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				//メールアドレスのテーブル
				print('<table border="0">');
				print('<tr>');
				print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="serch_flg" value="3">');
				print('<td align="left">');
				print('<img src="./img_' . $lang_cd . '/title_kns3_mail.png" border="0"><br>');
				print('<table boeder="0">');
				print('<tr>');
				print('<td align="left" valign="bottom">');
				$tabindex++;
				print('<input type="text" name="select_kaiin_mail" maxlength="40" size="30" value="' . $select_kaiin_mail . '" class="');
				if( $err_select_kaiin_mail == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns3_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns3_mail_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				if( $err_select_kaiin_mail == 1 ){
					print('<font size="2" color="red">※未入力です。</font>');
				}else if( $err_select_kaiin_mail == 2 ){
					print('<font size="2" color="red">※顧客情報の参照に失敗しました。</font>');	//確認用
				}
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				//電話番号のテーブル
				print('<table border="0">');
				print('<tr>');
				print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="serch_flg" value="4">');
				print('<td align="left">');
				print('<img src="./img_' . $lang_cd . '/title_kns4_kaiintel.png" border="0"><br>');
				print('<table boeder="0">');
				print('<tr>');
				print('<td align="left" valign="bottom">');
				$tabindex++;
				print('<input type="text" name="select_kaiin_tel" maxlength="15" size="15" value="' . $select_kaiin_tel . '" class="');
				if( $err_select_kaiin_tel == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" tabindex="' . $tabindex . '" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kns4_kaiintel_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				if( $err_select_kaiin_tel == 1 ){
					print('<font size="2" color="red">※未入力です。</font>');
				}else if( $err_select_kaiin_tel == 2 ){
					print('<font size="2" color="red">※顧客情報の参照に失敗しました。</font>');	//確認用
				}
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				print('</td>');
				print('</tr>');
				print('</table>');
								
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kbtcounseling_trk_selectjknkbn.php#' . $select_ymd . '">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
				
				print('</center>');
				
			}
		}
	}

	mysql_close( $link );

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>
</body>
</html>
