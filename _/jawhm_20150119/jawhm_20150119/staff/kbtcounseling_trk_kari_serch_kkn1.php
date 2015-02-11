<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>個別カウンセリング（仮登録からの会員検索予約登録）</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
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
	$gmn_id = 'kbtcounseling_trk_kari_serch_kkn1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbtcounseling_trk_kari_serch_kkn0.php','kbtcounseling_trk_kari_serch_kkn1.php');

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
	$select_yyk_no = $_POST['select_yyk_no'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" || $select_jknkbn == "" || $select_yyk_no == "" ){
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
		

		//ページ編集
		//固有引数の取得
		$serch_flg = $_POST['serch_flg'];					//検索フラグ　1:会員番号,2:会員名,3:会員メールアドレス,4:会員電話番号
		$select_kaiin_no = $_POST['select_kaiin_no'];		//会員番号
		$select_kaiin_nm = $_POST['select_kaiin_nm'];		//会員名
		$select_kaiin_mail = $_POST['select_kaiin_mail'];	//会員メールアドレス
		$select_kaiin_tel = $_POST['select_kaiin_tel'];		//会員電話番号
		$kaiin_soudan = $_POST['kaiin_soudan'];				//備考（相談内容）

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));

		//予約内容を取得する
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


		$err_cnt = 0;	//エラー件数

		//対象件数を取得する
		$data_cnt = 0;
		if( $err_flg == 0 ){
			//エラーなし
			
			//無条件で会員番号で検索
			$err_select_kaiin_no = 0;
			//引数チェック
			if( $select_kaiin_no == '' ){
				$err_select_kaiin_no = 1;
				$err_cnt++;
			
			}else{
				
				//顧客情報を参照する
					
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
					$data_cnt = $ret['data_cnt'];
					if( $data_cnt > 0 ){
						$i = 0;
						while( $i < $data_cnt ){
							$name = "data_id_" . $i;
							$data_kaiin_no[$i] = $ret[$name];			//会員番号
							$name = "data_name_" . $i;
							$data_kaiin_nm[$i] = $ret[$name];			//会員名
							$name = "data_name_k_" . $i;
							$data_kaiin_nm_k[$i] = $ret[$name];			//会員名カナ
							$name = "data_mixi_" . $i;
							$data_kaiin_mixi[$i] = $ret[$name];	//ＭＩＸＩ名
							$name = "data_mail_" . $i;
							$tmp_mail = $ret[$name];					//会員メールアドレス
							$data_kaiin_mail_google[$i] = $tmp_mail;	//googleカレンダー用メールアドレス
							$tmp_mail = str_replace(',','<br>',$tmp_mail );
							$data_kaiin_mail[$i] = $tmp_mail;			//会員メールアドレス
							$name = "data_tel_" . $i;
							$tmp_tel = $ret[$name];						//電話番号
							$data_kaiin_tel_google[$i] = $tmp_tel;		//googleカレンダー用電話番号

							//電話番号調整
							list($tmp_tel_1,$tmp_tel_2) = split('[,]',$tmp_tel);
							$data_kaiin_tel[$i] = $tmp_tel_1;			//電話番号１
							$data_kaiin_tel_keitai[$i] = $tmp_tel_2;	//電話番号２
							
							//会員区分の判定
							$data_kaiin_mixi[$i] = strtoupper($data_kaiin_mixi[$i]);	//小文字を大文字に変換する
							$tmp_pos = strpos($data_kaiin_mixi[$i],"JW");
							if( $tmp_pos !== false ){
								//有料メンバー
								$data_kaiin_kbn[$i] = 1;	//会員区分  0:仮登録　1:有料メンバー　9:無料メンバー
							}else{
								//無料メンバー
								$data_kaiin_kbn[$i] = 9;	//会員区分  0:仮登録　1:有料メンバー　9:無料メンバー
							}
							
							//会員名を姓名に分ける
							$data_kaiin_nm_1[$i] = "";
							$data_kaiin_nm_2[$i] = "";
							$tmp_pos = strpos($data_kaiin_nm[$i],"　");
							if( $tmp_pos !== false ){
								$data_kaiin_nm_1[$i] = substr($data_kaiin_nm[$i],0,$tmp_pos);
								$data_kaiin_nm_2[$i] = substr($data_kaiin_nm[$i],($tmp_pos+2), (strlen($data_kaiin_nm[$i]) - $tmp_pos - 2) );
							}else{
								$data_kaiin_nm_1[$i] = $data_kaiin_nm[$i];
							}

							//会員名フリガナをセイメイに分ける
							$data_kaiin_nm_k_1[$i] = "";
							$data_kaiin_nm_k_2[$i] = "";
							$tmp_pos = strpos($data_kaiin_nm_k[$i],"　");
							if( $tmp_pos !== false ){
								$data_kaiin_nm_1_k[$i] = substr($data_kaiin_nm_k[$i],0,$tmp_pos);
								$data_kaiin_nm_2_k[$i] = substr($data_kaiin_nm_k[$i],($tmp_pos+2), (strlen($data_kaiin_nm_k[$i]) - $tmp_pos - 2) );
							}else{
								$data_kaiin_nm_1_K[$i] = $data_kaiin_nm_k[$i];
							}
							
							$i++;
						}
					}
					
				}else{
					// NG	
					$err_select_kaiin_no = 1;
					$err_cnt++;
					
				}
			}
		}
			

		//空きチェック
		if( $err_flg == 0 && $err_cnt == 0 && $data_cnt == 1 ){

//			//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する
//			$tmp_yyk_cnt = 0;
//			$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '";';
//			$result = mysql_query($query);
//			if (!$result) {
//				$err_flg = 4;
//				//エラーメッセージ表示
//				require( './zs_errgmn.php' );
//						
//				//**ログ出力**
//				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//				$log_office_cd = $office_cd;	//オフィスコード
//				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
//				$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
//				$log_err_inf = $query;			//エラー情報
//				require( './zs_log.php' );
//				//************
//								
//			}else{
//				while( $row = mysql_fetch_array($result) ){
//					$tmp_yyk_cnt = $row[0];		//現在予約数
//				}
//			}
//			
//			//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
//			$tmp_uktk_ninzu = '';
//			$query = 'select UKTK_NINZU from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '";';
//			$result = mysql_query($query);
//			if (!$result) {
//				$err_flg = 4;
//				//エラーメッセージ表示
//				require( './zs_errgmn.php' );
//				
//				//**ログ出力**
//				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//				$log_office_cd = $office_cd;	//オフィスコード
//				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
//				$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
//				$log_err_inf = $query;			//エラー情報
//				require( './zs_log.php' );
//				//************
//						
//			}else{
//				while( $row = mysql_fetch_array($result) ){
//					$tmp_uktk_ninzu = $row[0];	//受付人数
//				}
//			}
//
//			if( $tmp_yyk_cnt >= $tmp_uktk_ninzu ){
//				//満室になってしまった
//				$err_cd = 4;
//				
//			}else{
			if( 1 ){
				//個別カウンセリングの登録を行う

				//キャンセル有効時間を求める
				if( $Moffice_cancel_mk_kkn == 0 && $Moffice_cancel_yk_jkn_dd == 0 && $Moffice_cancel_yk_jkn_hh == 0 ){
					//いつでもキャンセル可能の場合
					$cancel_ymdhis = sprintf("%04d",substr($select_ymd,0,4)) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';

				}else if( $select_ymd < $now_yyyymmdd || ($select_ymd == $now_yyyymmdd && $Mclass_st_time <= ($now_hh * 100 + $now_ii)) ){
					//過去時間区分の場合
					$cancel_ymdhis = sprintf("%04d",substr($select_ymd,0,4)) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';

				}else{
					$yyk_yyyy = substr($select_ymd,0,4);
					$yyk_mm = substr($select_ymd,4,2);
					$yyk_dd = substr($select_ymd,6,2);
					$yyk_bf_yyyy = $yyk_yyyy;
					$yyk_bf_mm = $yyk_mm - 1;
					if( $yyk_bf_mm < 1 ){
						$yyk_bf_yyyy--;
						$yyk_bf_mm = 12;
					}
					$yyk_bf_maxdd = cal_days_in_month(CAL_GREGORIAN, $yyk_bf_mm  , $yyk_bf_yyyy );
					$tmp_yyyy = $yyk_yyyy;
					$tmp_mm = $yyk_mm;
					$tmp_dd = $yyk_dd;
					
					if( $now_mm != $yyk_mm ){
						//該当月前月までの日数を加算する
						$wk_yyyy = $now_yyyy;
						$wk_mm = $now_mm;
						$wk_add_dd = 0;
						while( $wk_yyyy != $yyk_yyyy || $wk_mm != $yyk_mm ){
							$wk_maxdd = cal_days_in_month(CAL_GREGORIAN, $wk_mm , $wk_yyyy );
							$wk_add_dd += $wk_maxdd;
							$wk_mm++;
							if( $wk_mm > 12 ){
								$wk_yyyy++;
								$wk_mm = 1;
							}
						}
						$tmp_dd += $wk_add_dd;
					}
							
					if( ($tmp_dd - $now_dd) < $Moffice_cancel_mk_kkn ){
						//キャンセル無効期間内なのでキャンセル時間で設定する（上限２４時間までとする）
						$cancel_yyyy = $now_yyyy;
						$cancel_mm = $now_mm;
						$cancel_dd = $now_dd + $Moffice_cancel_yk_jkn_dd;
						$cancel_hh = $now_hh + $Moffice_cancel_yk_jkn_hh;
						$cancel_ii = $now_ii;
						$cancel_ss = $now_ss;
						if( $cancel_hh >= 24 ){
							$cancel_dd++;
							$cancel_hh -= 24;
						}
						//対象月の末日を求める
						$calcel_maxdd = cal_days_in_month(CAL_GREGORIAN, $cancel_mm , $cancel_yyyy );
						if( $cancel_dd > $calcel_maxdd ){
							$cancel_mm++;
							$cancel_dd -= $calcel_maxdd;
						}
						if( $cancel_mm > 12 ){
							$cancel_yyyy++;
							$cancel_mm -= 12;
						}
						$cancel_ymdhis = sprintf("%04d",$cancel_yyyy) . '-' . sprintf("%02d",$cancel_mm) . '-' . sprintf("%02d",$cancel_dd) . ' ' . sprintf("%02d",$cancel_hh) . ':' . sprintf("%02d",$cancel_ii) . ':' . sprintf("%02d",$cancel_ss);

					}else{
						//予約日の無効期間前の前日の 23:59:59 で設定する
						if( $yyk_dd <= $Moffice_cancel_mk_kkn ){
							$tmp_yyyy = $yyk_bf_yyyy;
							$tmp_mm = $yyk_bf_mm;
							if( ($yyk_bf_maxdd - $Moffice_cancel_mk_kkn + $yyk_dd - 1) >= 1 ){
								$tmp_dd = $yyk_bf_maxdd - $Moffice_cancel_mk_kkn + $yyk_dd - 1;
							}else{
								$tmp_mm--;
								if( $tmp_mm < 1 ){
									$tmp_yyyy--;
									$tmp_mm = 12;
								}
								$tmp_dd = cal_days_in_month(CAL_GREGORIAN, $tmp_mm , $tmp_yyyy );
							}
						}else{
							$tmp_yyyy = $yyk_yyyy;
							$tmp_mm = $yyk_mm;
							$tmp_dd = $yyk_dd - $Moffice_cancel_mk_kkn;
						}
						$cancel_ymdhis = sprintf("%04d",$tmp_yyyy) . '-' . sprintf("%02d",$tmp_mm) . '-' . sprintf("%02d",$tmp_dd) . ' 23:59:59';
					
					}
				}
		
				//文字コード設定（insert/update時に必須）
				require( '../zz_mojicd.php' );
	
				//クラス予約（個別カウンセリング）を更新する
				$query = 'update D_CLASS_YYK set KAIIN_KBN = ' . $data_kaiin_kbn[0] . ',KAIIN_ID = "' . $select_kaiin_no . '",KAIIN_NM = ENCODE("' . $data_kaiin_nm[0] . '","' . $ANGpw . '"),';
				if( $data_kaiin_kbn[0] == 1 && $data_kaiin_mixi[0] != "" ){
					$query .= 'MIXI = "' . $data_kaiin_mixi[0] . '",';
				}else{
					$query .= 'MIXI = NULL,';
				}
				if( $kaiin_soudan != "" ){
					$query .= 'SOUDAN = ENCODE("' . $kaiin_soudan . '","' . $ANGpw . '"),';
				}else{
					$query .= 'SOUDAN = ENCODE(NULL,"' . $ANGpw . '"),';
				}
				$query .= 'YYK_TIME = "' . $now_time . '",CANCEL_TIME = "' . $cancel_ymdhis . '",YYK_STAFF_CD = "' . $staff_cd . '" ';
				$query .= ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '" and YMD = "' . $zz_yykinfo_ymd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and YYK_NO = ' . $select_yyk_no . ' and KAIIN_ID = "' . $zz_yykinfo_kaiin_id . '";';
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
					$log_naiyou = 'クラス予約の更新に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
			
				}else{
				
					//**トランザクション出力**
					$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約を更新しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
								
					//googleカレンダーへの登録
								
					//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
					$yoyakudate = substr($zz_yykinfo_ymd,0,4) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';

					// カレンダー登録
					$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
					$data = array(
							'kbn'	=> 1,
							'id'	=> $select_kaiin_no,
							'place' => $Moffice_office_nm,
							'yoyakudate' => $yoyakudate,
							'tantou' => $zz_yykinfo_staff_nm,
							'yoyakumsg' => $kaiin_soudan,
							'namae1' 	=> $data_kaiin_nm_1[0],
							'namae2' 	=> $data_kaiin_nm_2[0],
							'firigana1' => $data_kaiin_nm_k_1[0],
							'firigana2' => $data_kaiin_nm_k_2[0],
							'tel'	=> $data_kaiin_tel_google[0],
							'email' => $data_kaiin_mail_google[0]
					);
		
					$options = array('http' => array(
									'method' => 'POST',
									'content' => http_build_query($data),
								));
					$contents = file_get_contents($url, false, stream_context_create($options));
					$ret = json_decode($contents, true);
					if ($ret['result'] == 'OK')	{
				
//						//**ログ出力**
//						$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//						$log_office_cd = $office_cd;	//オフィスコード
//						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
//						$log_naiyou = 'googleカレンダー連動に登録しました。';	//内容
//						$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] 名前[' . $kaiin_nm1 . ' ' . $kaiin_nm2 . '] フリガナ[' . $kaiin_nm_k1 . ' ' . $kaiin_nm_k2 . '] 電話番号[' . $kaiin_tel . '] メアド[' . $kaiin_mail . '] 相談内容[' . $kaiin_soudan . ']';			//エラー情報
//						require( './zs_log.php' );
//						//************
					
					}else{
						//登録失敗
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zs_errgmn.php' );
			
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'googleカレンダーへの登録に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
						$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $select_kaiin_no . ']';			//エラー情報
						require( './zs_log.php' );
						//************
				
					}
				}
			}
		}

		//メール送信
		$send_mail_flg = 0;
		if( $err_flg == 0 && $err_cnt == 0 && $data_kaiin_mail[0] != "" && ($data_kaiin_kbn[0] == 1 || $data_kaiin_kbn[0] == 9) ){
			
			//処理時点以降の時間帯であればメール送信する
			if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclass_st_time > ($now_hh * 100 + $now_ii) ) ){
				//管理情報から略称を求める
				$Mkanri_meishou = '';
				$Mkanri_ryakushou = '';
				$Mkanri_hp_adr = '';
				$query = 'select MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
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
					$log_naiyou = '管理情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					
				}else{
					$row = mysql_fetch_array($result);
					$Mkanri_meishou = $row[0];			//名称
					$Mkanri_ryakushou = $row[1];		//略称
					$Mkanri_hp_adr = $row[2];			//ホームページアドレス
					$Mkanri_send_mail_adr = $row[3];	//送信メールアドレス
				}
				
				//送信先メールアドレスを確定する
				$send_mail_adr_cnt = 0;		//送信対象メアド
				$tmp_member_mail_adr = $data_kaiin_mail[0];
				$tmp_mail_len = strlen($tmp_member_mail_adr);
				while( $tmp_mail_len > 0 ){
					$tmp_mail_pos = strpos($tmp_member_mail_adr,"<br>");
					if( $tmp_mail_pos === false ){
						//見つからなかった
						//メアドの整合性チェック
						$chk_mailadr_flg = 0;
						if( strlen( $tmp_member_mail_adr ) != mb_strlen( $tmp_member_mail_adr ) ){
							//全角が含まれている
							$chk_mailadr_flg = 1;
						}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $tmp_member_mail_adr) ){
							//メールアドレスとしてふさわしくない
							$chk_mailadr_flg = 2;
						}
						
						if( $chk_mailadr_flg == 0 ){
							//メアドチェックＯＫ なので 送信対象とする
							$send_mail_adr[$send_mail_adr_cnt] = $tmp_member_mail_adr;
							$send_mail_adr_cnt++;
						
						}else{
							
							//**ログ出力**
							$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $select_kaiin_no . '] メアド[' . $tmp_member_mail_adr . ']';	//内容
							$log_err_inf = '';			//エラー情報
							require( './zs_log.php' );
							//************
							
						}
						
						$tmp_mail_len = 0;
					
					}else{
						//見つかった
						//メアドの整合性チェック
						$chk_mailadr = substr($tmp_member_mail_adr,0,$tmp_mail_pos);
						$chk_mailadr_flg = 0;
						if( strlen( $chk_mailadr ) != mb_strlen( $chk_mailadr ) ){
							//全角が含まれている
							$chk_mailadr_flg = 1;
						}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $chk_mailadr) ){
							//メールアドレスとしてふさわしくない
							$chk_mailadr_flg = 2;
						}
						
						if( $chk_mailadr_flg == 0 ){
							//メアドチェックＯＫ なので 送信対象とする
							$send_mail_adr[$send_mail_adr_cnt] = substr($tmp_member_mail_adr,0,$tmp_mail_pos);
							$send_mail_adr_cnt++;
						
						}else{
							
							//**ログ出力**
							$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $select_kaiin_no . '] メアド[' . $chk_mailadr . ']';	//内容
							$log_err_inf = '';			//エラー情報
							require( './zs_log.php' );
							//************
							
						}
						
						$tmp_member_mail_adr = substr($tmp_member_mail_adr,($tmp_mail_pos + 4),($tmp_mail_len - ($tmp_mail_pos + 4)));
						$tmp_mail_len = strlen($tmp_member_mail_adr);
						
					}
				}

//##############################################################
//開発テスト時はお客様へメールせず、設定されたメアドに変更する
				if( $SVkankyo == 9 ){
					$send_mail_adr_cnt = $sv_test_cs_mailadr_cnt;
					$m = 0;
					while( $m < $send_mail_adr_cnt ){
						$send_mail_adr[$m] = $sv_test_cs_mailadr[$m];
						$m++;
					}
				}
//##############################################################

				
				// 登録完了メールを送信
				$m = 0;
				while( $m < $send_mail_adr_cnt ){
			
					//登録完了メール送信
					//送信元
					$from_nm = $Mkanri_meishou;
					$from_mail = $Mkanri_send_mail_adr;
					//宛て先
					$to_nm = $data_kaiin_nm[0] . ' 様';
					$to_mail = $send_mail_adr[$m];
				
					//タイトル
					if( $Mkanri_ryakushou != '' ){
						$subject = '(' . $Mkanri_ryakushou . ')';
					}else{
						$subject = '';	
					}
					$subject .= '個別カウンセリング予約を受け付けました';
			
					// 本文
					$content = $data_kaiin_nm[0] . " 様\n\n";
					$content .= $Mkanri_meishou . "です。\n";
					$content .= "この度は、当協会の個別カウンセリングの予約を\n";
					$content .= "以下の日時で受け付けましたのでお知らせします。\n\n";
					$content .= "---------------\n";
					$content .= "▼予約内容\n";
					$content .= "---------------\n";
					$content .= "個別カウンセリング\n";
					$content .= "予約No: " . sprintf("%05d",$select_yyk_no) . "\n";
					$content .= "会場: " . $Moffice_office_nm . "\n";
					$content .= "日付: " . substr($select_ymd,0,4) . "年" . sprintf("%d",substr($select_ymd,4,2)) . "月" . sprintf("%d",substr($select_ymd,6,2)) . "日(" . $week[$select_youbi_cd] . ")\n";
					$content .= "時間: " . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . " - " . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) ."\n";
					if( $zz_yykinfo_open_staff_nm != "" ){
						$content .= "担当: " . $zz_yykinfo_open_staff_nm . "\n";
					}
					$content .= "\n";
					$content .= "---------------\n";
					$content .= $Mkanri_meishou . "\n";
					$content .= $Mkanri_hp_adr . "\n";
					$content .= "メール: " . $Mkanri_send_mail_adr . "\n";
					if( $Moffice_bikou != '' ){
						$content .=  $Moffice_bikou . "\n";
					}
					$content .= "---------------\n";
					   
					//メール送信
					mb_language("Ja");				//使用言語：Ja
					mb_internal_encoding("utf-8");	//文字コード：UTF-8
					$frname0 = mb_encode_mimeheader($from_nm);
					$toname0 = mb_encode_mimeheader($to_nm);
					$sdmail0 = "$toname0 <$to_mail>";
					$mailhead = "From:\"$frname0\" <$from_mail>\n";
					if( $sv_bcc_mailadr != "" ){
						$mailhead .= "Bcc: $sv_bcc_mailadr";
					}
					$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
				
					$m++;

					$send_mail_flg = 1;

				}
			}
		}



		if( $err_flg == 0 ){
			if( $err_cnt == 0 ){
				//エラーなし
				
				if( $data_cnt == 1 ){
					//１件ヒット
					
					//現在（今日以降）の予約数を求める
					$new_yyk_cnt = 0;
					$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
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
							$new_yyk_yyk_time[$new_yyk_cnt] = $row[5];		//予約日時
							$new_yyk_cancel_time[$new_yyk_cnt] = $row[6];	//キャンセル可能日時
							$new_yyk_staff_cd[$new_yyk_cnt] = $row[7];		//予約受付スタッフコード
							$new_yyk_office_nm[$new_yyk_cnt] = $row[8];		//オフィス名
							$new_yyk_st_time[$new_yyk_cnt] = $row[9];		//開始時刻
							$new_yyk_ed_time[$new_yyk_cnt] = $row[10];		//終了時刻
							
							//「オフィス」を「会場」に置換する
							$new_yyk_office_nm[$new_yyk_cnt] = str_replace('オフィス','会場',$new_yyk_office_nm[$new_yyk_cnt] );			
							
							$new_yyk_cnt++;
						}
					}


					//過去の予約数を求める
					$old_yyk_cnt = 0;
					$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
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
							$old_yyk_yyk_time[$old_yyk_cnt] = $row[5];		//予約日時
							$old_yyk_cancel_time[$old_yyk_cnt] = $row[6];	//キャンセル可能日時
							$old_yyk_staff_cd[$old_yyk_cnt] = $row[7];		//予約受付スタッフコード
							$old_yyk_office_nm[$old_yyk_cnt] = $row[8];		//オフィス名
							$old_yyk_st_time[$old_yyk_cnt] = $row[9];		//開始時刻
							$old_yyk_ed_time[$old_yyk_cnt] = $row[10];		//終了時刻
							
							//「オフィス」を「会場」に置換する
							$old_yyk_office_nm[$old_yyk_cnt] = str_replace('オフィス','会場',$old_yyk_office_nm[$old_yyk_cnt] );			
							
							$old_yyk_cnt++;
						}
					}
					
					//使用機種を求める
					// $mobile_kbn	:A:Android(mb) B:Android(tab) I:iPhone J:iPad D:DoCoMo(mb) U:au(mb) S:Softbank(mb) W:WILLCOM M:Macintosh P:PC
					require( '../zz_uachk.php' );
					
					//**ログ出力**
					$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = '個別カウンセリングを予約しました。予約No[' . sprintf("%05d",$select_yyk_no) . '] 会員番号[' . $data_kaiin_no[0] . ']<br>会場[' . $Moffice_office_nm . '] 日付[' . $select_ymd . '] 時間[' . $Mclass_st_time . '-' . $Mclass_ed_time . ']';	//内容
					$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
					require( './zs_log.php' );
					//************
					
					
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
					//予約番号
					print('<tr>');
					print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
					print('<td width="565" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
					print('</tr>');
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
					if( $zz_yykinfo_staff_nm != "" ){
						print('<font size="5">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;(' . $zz_yykinfo_staff_nm . ')' );
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
					
					//戻るボタン
					print('</td>');	//sub01
					print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
					print('<td width="135" align="center" valign="top">');	//sub01
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');	//sub01
					print('</form>');
					print('</tr>');	//sub01
					print('</table>');	//sub01
						
					//「登録しました」
					print('<img src="./img_' . $lang_cd . '/title_trk_ok.png" border="0"><br>');
					if( $send_mail_flg == 1 ){
						//「会員へメール送信しました。」
						print('<img src="./img_' . $lang_cd . '/title_mailsend.png" border="0"><br>');
//####################################################
//開発テスト時はお客様へメールせず、設定されたメアドに変更する
						if( $SVkankyo == 9 ){	//開発テスト用
							print('<font color="red">※テスト中のため、お客様に送信せず、確認用メールアドレスへ送信しました。</font><br>');
						}
//####################################################						
						
					}

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
						print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0"></font>');
					}
					print('</td>');
					//氏名
					print('<td width="480" align="left" valign="top">');
					print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
					if( $data_kaiin_nm_k[0] != '' && $data_kaiin_nm_k[0] != '　'){
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

					//相談内容
					print('<table border="0">');
					print('<tr>');
					print('<td width="750" align="left">');
					print('<img src="./img_' . $lang_cd . '/title_soudan.png" border="0"><br>');
					if( $kaiin_soudan != "" ){
						print('<div style="margin: 10px"><pre>' . $kaiin_soudan . '</pre></div>');
					}else{
						print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
					}
					print('</td>');
					print('</tr>');
					print('</table>');
					
					print('</td>');	//sub1					
					print('</tr>');	//sub1
					print('</table>');	//sub1
						
					print('</td>');	//main1
					print('</tr>'); //main1
					print('</table>');	//main1
						
						

					//戻るボタン
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">&nbsp;</td>');
					print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
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
							print('<font size="2" color="' . $fontcolor . '"><b>' . $new_yyk_ymd[$i] . '&nbsp;(' . $week[$youbi_cd] .')</font></b><br><font size="2">' . intval($new_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_st_time[$i] % 100 )) . '～' . intval($new_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_ed_time[$i] % 100 )) . '</font>');
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
							print('</td>');
							//予約登録日／受付者
							$new_yyk_staff_nm[$i] = '';
							if( $new_yyk_staff_cd[$i] != '' ){
								//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
								$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $new_yyk_staff_cd[$i] . '";';
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
							}
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
							print('<font size="2">&nbsp;&nbsp;' . $new_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
							if( $new_yyk_staff_cd[$i] == '' ){
								print('会員入力');
							}else{
								print('<font size="1">受付：</font>'. $new_yyk_staff_nm[$i] );
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
							print('<form method="post" action="yoyaku_info.php?tnp=' . $old_yyk_tenpo_cd[$i] . '&s=' . $staff_cd . '&y=' . $old_yyk_yyk_no[$i] . '&d=' . substr($old_yyk_ymd[$i],0,4) . substr($old_yyk_ymd[$i],5,2) . substr($old_yyk_ymd[$i],8,2) . '" target="window_name" onClick="disp(\'yoyaku_info.php?tnp=' . $old_yyk_tenpo_cd[$i] . '&s=' . $staff_cd . '&y=' . $old_yyk_yyk_no[$i] . '&d=' . substr($old_yyk_ymd[$i],0,4) . substr($old_yyk_ymd[$i],5,2) . substr($old_yyk_ymd[$i],8,2) . ' \')">');
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
							print('<font size="2" color="' . $fontcolor . '"><b>' . $old_yyk_ymd[$i] . '&nbsp;(' . $week[$youbi_cd] .')</font></b><br><font size="2">' . intval($old_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_st_time[$i] % 100 )) . '～' . intval($old_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_ed_time[$i] % 100 )) . '</font>');
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
							print('</td>');
							//予約登録日／受付者
							$old_yyk_staff_nm[$i] = '';
							if( $old_yyk_staff_cd[$i] != '' ){
								//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
								$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $old_yyk_staff_cd[$i] . '";';
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
							}
							print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
							print('<font size="2">&nbsp;&nbsp;' . $old_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
							if( $old_yyk_staff_cd[$i] == '' ){
								print('会員入力');
							}else{
								print('<font size="1">受付：</font>'. $old_yyk_staff_nm[$i] );
							}
							print('</font>');
							print('</td>');
							print('</tr>');
						
							$i++;
						}
						print('</table>');
						
					}

					print('<hr>');
				

				}else{
					//データなし

					//**ログ出力**
					$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = '処理途中で会員・メンバーが削除されたため、個別予約ができませんでした。';	//内容
					$log_err_inf = '';			//エラー情報
					require( './zs_log.php' );
					//************

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
					if( $zz_yykinfo_staff_nm != "" ){
						print('<font size="5">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;(' . $zz_yykinfo_staff_nm . ')' );
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

					//「会員が削除されました。」
					print('<font color="red">※会員が削除されたため、登録できませんでした。</font>');
						
					print('</center>');
				
					print('<hr>');

				}
				
			
			}else{
				//引数エラーあり

				//**ログ出力**
				$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '引数エラー発生。';	//内容
				$log_err_inf = '';			//エラー情報
				require( './zs_log.php' );
				//************

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
				if( $zz_yykinfo_staff_nm != "" ){
					print('<font size="5">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;(' . $zz_yykinfo_staff_nm . ')' );
				}else{
					print('(カウンセラー指定なし)');
				}
				print('</td>');
				print('</tr>');
				print('</table>');

				
				//「エラーがあります。」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0">');
		
				print('<br><br><br>');
				
				print('<font color="red">※システム管理者へ連絡してください。</font>');

				print('</center>');
				
				print('<hr>');
				
			}
			
		}else if( $err_flg == 5 ){
			//既に予約キャンセルされている
			
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="135">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle">');
			//「個別カウンセリング　日時変更　（現在の予約内容）」
			print('<img src="./img_' . $lang_cd . '/title_kbtcounseling_genzainaiyou.png" border="0"><br>');
			print('</td>');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . substr($zz_yykinfo_ymd,0,4) . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			print('<br>');
			
			//「この予約はキャンセル済みです。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_delzumi.png" border="0"><br>');

			print('<table border="1">');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="6" color="gray">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('</tr>');
			print('</table>');
			
			print('<br><br><br><br><br><br><br><br>');
			
			print('<hr>');
			
			print('</center>');


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
