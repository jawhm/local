<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング（新規会員登録:結果）</title>
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
option.color2 {
	color:#ff0000;
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
	$gmn_id = 'kbtcounseling_trk_new2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbtcounseling_trk_new1.php');

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

	//ユーザーエージェントチェック
	require( '../zz_uachk.php' );
	
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
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );
		
		//ページ編集
		$kaiin_nm1 = $_POST['kaiin_nm1'];			//会員名（姓）
		$kaiin_nm2 = $_POST['kaiin_nm2'];			//会員名（名）
		$kaiin_nm_k1 = $_POST['kaiin_nm_k1'];		//会員名カナ（セイ）
		$kaiin_nm_k2 = $_POST['kaiin_nm_k2'];		//会員名カナ（メイ）
		$kaiin_tel = $_POST['kaiin_tel'];			//会員電話番号
		$kaiin_mail = $_POST['kaiin_mail'];			//会員メールアドレス
		$kaiin_kyoumi = $_POST['kaiin_kyoumi'];		//興味のある国
		$kaiin_jiki = $_POST['kaiin_jiki'];			//出発予定時期
		$kaiin_soudan = $_POST['kaiin_soudan'];		//相談内容

		$err_cnt = 0;	//エラー件数
		$err_cd = 0;	//エラーコード

		//重複ID（先頭３件のみ格納）
		$dup_id_nm_k_cnt = 0;
		$dup_id_nm_k[0] = '';
		$dup_id_nm_k[1] = '';
		$dup_id_nm_k[2] = '';
		$dup_id_nm_m_cnt = 0;
		$dup_id_nm_m[0] = '';
		$dup_id_nm_m[1] = '';
		$dup_id_nm_m[2] = '';
		$dup_id_tel_cnt = 0;
		$dup_id_tel = '';
		$dup_id_tel_keitai_cnt = 0;
		$dup_id_tel_keitai = '';
		$dup_id_email_cnt = 0;
		$dup_id_email = '';

		//引数チェック
		//会員名（姓）
		$err_kaiin_nm1 = 0;
		$strcng_bf = $kaiin_nm1;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_nm1 = $strcng_af;
		if( strlen($kaiin_nm1) == 0 ){
			//未入力エラー
			$err_kaiin_nm1 = 1;
			$err_cnt++;
		}

		//会員名（名）
		$err_kaiin_nm2 = 0;
		$strcng_bf = $kaiin_nm2;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_nm2 = $strcng_af;
		//if( strlen($kaiin_nm2) == 0 ){
		//	//未入力エラー
		//	$err_kaiin_nm2 = 1;
		//	$err_cnt++;
		//}
		
		$kaiin_nm = $kaiin_nm1;
		if( $kaiin_nm2 != "" ){
			$kaiin_nm .= "　" . $kaiin_nm2;
		}

		//会員名での重複チェック
		if( $kaiin_nm1 != "" ){
			$chk_kaiin_nm = $kaiin_nm1 . $kaiin_nm2;
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'chk_name' => $chk_kaiin_nm
			);
			
			$url = 'https://toratoracrm.com/crm/CS_chk_name.php';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);
	
			if ($ret['result'] == 'OK')	{
				// OK
				$msg = $ret['msg'];
				$rtn_cd = $ret['rtn_cd'];
				$dup_id_nm_m_cnt = $ret['err_data_cnt'];
				if( $dup_id_nm_m_cnt > 0 ){
					$err_kaiin_nm1 = 2;
					$err_kaiin_nm2 = 2;
					
					$i = 0;
					while( $i < $dup_id_nm_m_cnt && $i < 3 ){
						$name = "err_id_" . $i;
						$dup_id_nm_m[$i] = $ret[$name];
						$i++;
					}
				}
			}
		}


		//会員名カナ（セイ）
		$err_kaiin_nm_k1 = 0;
		$strcng_bf = $kaiin_nm_k1;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_nm_k1 = $strcng_af;
		$kaiin_nm_k1 = mb_convert_kana( $kaiin_nm_k1 , "KC" , "utf-8");	//半角カタカナ・全角ひらがなを全角カタカナに変換する

		//会員名カナ（メイ）
		$err_kaiin_nm_k2 = 0;
		$strcng_bf = $kaiin_nm_k2;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_nm_k2 = $strcng_af;
		$kaiin_nm_k2 = mb_convert_kana( $kaiin_nm_k2 , "KC" , "utf-8");	//半角カタカナ・全角ひらがなを全角カタカナに変換する

		//会員電話番号
		$err_kaiin_tel = 0;
		$kaiin_tel_c = '';		
		$strcng_bf = $kaiin_tel;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_tel = $strcng_af;
		if( $kaiin_tel == "" ){
			//未入力エラー
			$err_cnt++;
			$err_kaiin_tel = 1;

		}else{
			//電話番号チェック
			$telchk_bf = $kaiin_tel;
			require( '../zz_telchk.php' );	// 禁止文字（ ”’$ ）を全角変換する
			if( $telchk_rtncd != 0 ){
				$err_cnt++;
				$err_kaiin_tel = $telchk_rtncd;
			}else{
				//登録済みであるかチェックする
				
				//入力された電話番号を数字のみに変換する
				$tmp_length = mb_strlen( $kaiin_tel );
				$tmp_idx = 0;
				$kaiin_tel_c = '';
				while( $tmp_idx < $tmp_length ){
					if( is_numeric( mb_substr( $kaiin_tel , $tmp_idx , 1 ) ) ){
						$kaiin_tel_c .= mb_substr( $kaiin_tel , $tmp_idx , 1 );
					}
					$tmp_idx++;
				}

				//「電話番号」重複チェック
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'chk_tel' => $kaiin_tel_c
				);
				
				$url = 'https://toratoracrm.com/crm/CS_chk_tel.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);
				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$dup_id_tel_m_cnt = $ret['err_data_cnt'];
					if( $dup_id_tel_m_cnt > 0 ){
						$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
						$err_kaiin_tel = 5;
						$err_cnt++;
						
						$i = 0;
						while( $i < $dup_id_tel_m_cnt && $i < 3 ){
							$name = "err_id_" . $i;
							$dup_id_tel_m[$i] = $ret[$name];
							$i++;
						}
					}
				}

			}
		}


		//会員メールアドレス
		$err_kaiin_mail = 0;
		$strcng_bf = $kaiin_mail;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_mail = $strcng_af;
		if( $kaiin_mail != '' ){
			if( strlen( $kaiin_mail ) != mb_strlen( $kaiin_mail ) ){
				//全角が含まれている
				$err_cnt++;
				$err_kaiin_mail = 2;
			}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $kaiin_mail) ){
				//メールアドレスとしてふさわしくない
				$err_cnt++;
				$err_kaiin_mail = 3;
			}else if( strlen( $kaiin_mail ) < 4 ){
				//４文字未満の場合
				$err_cnt++;
				$err_kaiin_mail = 4;
			}
			
			//「メールアドレス」重複チェック
			if( $err_kaiin_mail == 0 ){
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'chk_mail' => $kaiin_mail
				);
				
				$url = 'https://toratoracrm.com/crm/CS_chk_mail.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);
		
				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$dup_id_email_m_cnt = $ret['err_data_cnt'];
					if( $dup_id_email_m_cnt > 0 ){
						$err_cd = 2;	//「入力された会員メールアドレスは既に登録されているため、新規登録できません。」
						$err_kaiin_mail = 5;
						$err_cnt++;
						
						$i = 0;
						while( $i < $dup_id_email_m_cnt && $i < 3 ){
							$name = "err_id_" . $i;
							$dup_id_email_m[$i] = $ret[$name];
								$i++;
						}
					}
				}
				
			}
		}
		
		//興味のある国
		$err_kaiin_kyoumi = 0;
		$strcng_bf = $kaiin_kyoumi;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_kyoumi = $strcng_af;

		//出発予定時期
		$err_kaiin_jiki = 0;
		$strcng_bf = $kaiin_jiki;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_jiki = $strcng_af;

		//相談内容
		$err_kaiin_soudan = 0;
		$strcng_bf = $kaiin_soudan;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_soudan = $strcng_af;

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));

		//オフィスマスタの取得
		$query = 'select OFFICE_NM,CANCEL_YK_JKN,CANCEL_MK_KKN,START_YOUBI,DECODE(BIKOU,"' . $ANGpw . '") from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
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
			$Moffice_cancel_yk_jkn_dd = intval($row[1] / 24);	//キャンセル有効時間（日）
			$Moffice_cancel_yk_jkn_hh = $row[1] % 24;			//キャンセル有効時間（時）
			$Moffice_cancel_mk_kkn = $row[2];					//キャンセル無効期間（日）
			$Moffice_start_youbi = $row[3];						//開始曜日（ 0:日曜始まり 1:月曜始まり ）
			$Moffice_bikou = $row[4];							//備考

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


		//先にgoogleカレンダー連動により、お客様番号を取得する
		$kaiin_id = "";
		if( $err_flg == 0 && $err_cnt == 0 ){
			
			//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
			$yoyakudate = substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';

			// カレンダー登録
			$yoyakumsg = "";
//			if( $kaiin_kyoumi != "" ){
//				$yoyakumsg .= "興味のある国：" . $kaiin_kyoumi . "\n";
//			}
//			if( $kaiin_jiki != "" ){
//				$yoyakumsg .= "出発予定時期：" . $kaiin_jiki . "\n";
//			}
			if( $kaiin_soudan != "" ){
				$yoyakumsg .= $kaiin_soudan . "\n";
			}
			if( $yoyakumsg == "" ){
				$yoyakumsg = "（相談内容：未記入）";
			}
			
			$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
			$data = array(
				'kbn'	=> 1,
				'id'	=> '',
				'place' => $Moffice_office_nm,
				'yoyakudate' => $yoyakudate,
				'tantou'	=> $select_staff_nm,
				'yoyakumsg' => $yoyakumsg,
				'namae1' 	=> $kaiin_nm1,
				'namae2' 	=> $kaiin_nm2,
				'furigana1' => $kaiin_nm_k1,
				'furigana2' => $kaiin_nm_k2,
				'tel'	=> $kaiin_tel,
				'email' => $kaiin_mail
			);
		
			$options = array('http' => array(
				'method' => 'POST',
				'content' => http_build_query($data),
			));
			$contents = file_get_contents($url, false, stream_context_create($options));
			$ret = json_decode($contents, true);
			if ($ret['result'] == 'OK')	{
				
				//お客様番号を取得する
				$kaiin_id = $ret['id'];
				
				if( $kaiin_id == "" ){
					//お客様番号が未設定
					
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zs_errgmn.php' );
				
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'googleカレンダー連動によるお客様番号の取得に失敗しました。(未設定)';	//内容
					$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] 名前[' . $kaiin_nm1 . ' ' . $kaiin_nm2 . '] フリガナ[' . $kaiin_nm_k1 . ' ' . $kaiin_nm_k2 . '] 電話番号[' . $kaiin_tel . '] メアド[' . $kaiin_mail . '] 相談内容[' . $kaiin_soudan . ']';			//エラー情報
					require( './zs_log.php' );
					//************
					
				}
		
			}else{
				//お客様番号の登録失敗
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
			
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'googleカレンダー連動によるお客様番号の取得に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
				$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] 名前[' . $kaiin_nm1 . ' ' . $kaiin_nm2 . '] フリガナ[' . $kaiin_nm_k1 . ' ' . $kaiin_nm_k2 . '] 電話番号[' . $kaiin_tel . '] メアド[' . $kaiin_mail . '] 相談内容[' . $kaiin_soudan . ']';			//エラー情報
				require( './zs_log.php' );
				//************
				
			}
		}


		//空きチェック
		if( $err_flg == 0 && $err_cnt == 0 ){

			//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する
			$tmp_yyk_cnt = 0;
			$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '";';
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
				$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
								
			}else{
				while( $row = mysql_fetch_array($result) ){
					$tmp_yyk_cnt = $row[0];		//現在予約数
				}
			}
			
			//カウンセラー指定の場合、他の予約があるかチェックする
			if( $select_staff_cd != "" ){
				$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
									
				}else{
					while( $row = mysql_fetch_array($result) ){
						if( $row[0] > 0 ){
							//既にカウンセラー指定の予約あり
							$err_cd = 4;
						}
					}
				}
			}
			
			//該当日／時間割のスタッフスケジュールを参照し、受付可能数を取得する
			$tmp_uktk_ninzu = '';
			$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
				$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
						
			}else{
				while( $row = mysql_fetch_array($result) ){
					$tmp_uktk_ninzu = $row[0];	//受付可能数
				}
			}

			if( $tmp_yyk_cnt >= $tmp_uktk_ninzu ){
				//満室になってしまった
				$err_cd = 4;
				
			}else{
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
		
				
				//まず予約番号を確定する
				$yyk_no = 0;
				$query = 'select MAX_YYK_NO from M_YYK_NO where KG_CD = "' . $DEF_kg_cd . '";';
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
					$log_naiyou = '予約番号の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
		
				}else{
					$row = mysql_fetch_array($result);
					$yyk_no = $row[0] + 1;
					if( $yyk_no > 9999999 ){
						$yyk_no = 1;
					}
					//予約番号を更新する
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
					
					$query = 'update M_YYK_NO set MAX_YYK_NO = ' . $yyk_no . ' where KG_CD = "' . $DEF_kg_cd . '";';
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
						$log_naiyou = '予約番号の更新に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
	
					}else{
		
						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = '予約番号を更新しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************

						//文字コード設定（insert/update時に必須）
						require( '../zz_mojicd.php' );

						//クラス予約（個別カウンセリング）を登録する
						$query = 'insert into D_CLASS_YYK values("' . $DEF_kg_cd . '","' . $select_office_cd . '","KBT","' . $select_ymd . '","' . $select_jknkbn . '",' . $yyk_no . ',9,"' . $kaiin_id . '",ENCODE("' . $kaiin_nm . '","' . $ANGpw . '"),NULL,';
						if( $select_staff_cd != "" ){
							$query .= '"' . $select_staff_cd . '",';
						}else{
							$query .= 'NULL,';
						}
						$query .= '1,';
						if( $kaiin_kyoumi != "" ){
							$query .= 'ENCODE("' . $kaiin_kyoumi . '","' . $ANGpw . '"),';
						}else{
							$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
						}
						if( $kaiin_jiki != "" ){
							$query .= 'ENCODE("' . $kaiin_jiki . '","' . $ANGpw . '"),';
						}else{
							$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
						}
						if( $kaiin_soudan != "" ){
							$query .= 'ENCODE("' . $kaiin_soudan . '","' . $ANGpw . '"),';
						}else{
							$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
						}
						$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
						$query .= '0,0,"' . $now_time. '","' . $cancel_ymdhis . '","' . $staff_cd . '");';
						$result = mysql_query($query);
						if (!$result) {
							
							//Ｆ５対応
							$err_flg = 6;
							
							//**ログ出力**
							$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = '同一日時に二重登録された。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
		
						}else{
			
							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'クラス予約を登録しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
						}
					}
				}
			}
		}


		//メール送信
		$send_mail_flg = 0;
		if( $err_flg == 0 && $err_cnt == 0 && $kaiin_mail != "" ){
			
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
				
				//登録完了メール送信
				//送信元
				$from_nm = $Mkanri_meishou;
				$from_mail = $Mkanri_send_mail_adr;
				//宛て先
				$to_nm = $kaiin_nm1 . ' ' . $kaiin_nm2 . ' 様';
				$to_mail = $kaiin_mail;
			
				//タイトル
				if( $Mkanri_ryakushou != '' ){
					$subject = '(' . $Mkanri_ryakushou . ')';
				}else{
					$subject = '';	
				}
				$subject .= '個別カウンセリング予約を受け付けました';
	
				// 本文
				$content = $kaiin_nm1 . " " . $kaiin_nm2 . " 様\n\n";
				$content .= $Mkanri_meishou . "です。\n";
				$content .= "この度は、当協会の個別カウンセリングの予約を\n";
				$content .= "以下の日時で受け付けましたのでお知らせします。\n\n";
				$content .= "---------------\n";
				$content .= "▼予約内容\n";
				$content .= "---------------\n";
				$content .= "個別カウンセリング\n";
				$content .= "予約No: " . sprintf("%05d",$yyk_no) . "\n";
				$content .= "会場: " . $Moffice_office_nm . "\n";
				$content .= "日付: " . substr($select_ymd,0,4) . "年" . sprintf("%d",substr($select_ymd,4,2)) . "月" . sprintf("%d",substr($select_ymd,6,2)) . "日(" . $week[$select_youbi_cd] . ")\n";
				$content .= "時間: " . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . " - " . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) ."\n";
				if( $select_staff_cd != "" ){
					$content .= "担当: " . $select_open_staff_nm . "\n";
				}
				$content .= "\n";
				$content .= "お名前: " . $kaiin_nm1 . " " . $kaiin_nm2 . " 様\n";
				$content .= "電話  : " . $kaiin_tel . "\n\n";
				$content .= "※予約の変更・キャンセルは、お手数ですが\n";
				$content .= "必ずご連絡いただきますようお願いします。\n\n";
				$content .= "◆このメールに覚えが無い場合◆\n";
				$content .= "他の方がメールアドレスを間違えた可能性があります。\n";
				$content .= "お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。\n";
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
			
				$send_mail_flg = 1;
			}
		}


		//画面編集
		if( $err_flg == 0 ){
			//エラーなし

			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				if( $input_kaiin_no == "" ){
					$tmp_kaiin_no = $max_kaiin_no;
				}else{
					$tmp_kaiin_no = $input_kaiin_no;
				}

				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングを予約しました。（新規顧客）<br>予約No[' . sprintf("%05d",$yyk_no) . '] 会場[' . $Moffice_office_nm . '] 日時[' . substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '-' . sprintf("%02d",intval($Mclass_ed_time / 100)) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '] カウンセラー[' . $select_open_staff_nm . ']<br>お客様番号[' . $kaiin_id . ']';	//内容
				$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
				require( './zs_log.php' );
				//************


				//ページ編集
				print('<center>');
				
				//ページ編集
				print('<table><tr>');
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
				print('</tr></table>');
				
				//「登録しました」
				print('<img src="./img_' . $lang_cd . '/title_trk_ok.png" border="0"><br>');
				if( $send_mail_flg == 1 ){
					//「会員へメール送信しました。」
					print('<img src="./img_' . $lang_cd . '/title_mailsend.png" border="0"><br>');
				}
				
				print('<table border="1">');
				//予約番号
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="565" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png"><font size="6" color="blue">' . sprintf("%05d",$yyk_no) . '</font>&nbsp;&nbsp;<font size="1">(' . $now_time . ')</font></td>');
				print('</tr>');
				//会場
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_565x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
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
			
				print('<table border="0">');	//sub02
				print('<tr>');	//sub02
				//お客様番号
				print('<td width="150" align="center" valign="top" >');	//sub02
				print('<img src="./img_' . $lang_cd . '/title_okyakusamano.png" border="0"><br>');
				print('<font size="5" color="blue">' . $kaiin_id . '</font>');
				print('</td>');	//sub02
				//会員名
				print('<td width="550" align="left" valign="top" >');	//sub02
				print('<img src="./img_' . $lang_cd . '/title_shimei.png" border="0"><br>');
				if( $kaiin_nm_k1 != '' || $kaiin_nm_k2 != '' ){
					print('<font size="2" color="blue">' . $kaiin_nm_k1 . '&nbsp;' . $kaiin_nm_k2 . '</font><br>');
				}
				print('<font size="5" color="blue">' . $kaiin_nm1 . '　' . $kaiin_nm2 );
				if( $err_kaiin_nm1 == 2 ){
					print('<br><font size="2" color="red">重複している名前です。 ');
					if( $dup_id_nm_m_cnt > 0 ){
						//正規メンバー
						print('<br>');
						print(' [' . $dup_id_nm_m[0] . ']');
						if( $dup_id_nm_m[1] != "" ){
							print(' [' . $dup_id_nm_m[1] . ']');
						}
						if( $dup_id_nm_m[2] != "" ){
							print(' [' . $dup_id_nm_m[2] . ']');
						}
						if( $dup_id_nm_m_cnt > 3 ){
							print('(他' . ($dup_id_nm_m_cnt - 3) . '件)');
						}
					}
					print('</font>');
				}				
				print('</td>');	//sub02
				print('</tr>');	//sub02
				print('</table>');	//sub02
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
				print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
					
				print('</center>');


			}else if( $err_cnt > 0 ){
				//エラーがある場合

				//ページ編集
				print('<center>');
				
				//ページ編集
				print('<table><tr>');
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
				print('</tr></table>');
				
				//「エラーがあります。」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0"><br>');
	
				if( $err_cd == 1 ){
					print('<font color="red">※入力された会員名は既に登録されているため、新規登録できません。</font><br>');	//ここは通らない
				}else if( $err_cd == 2 ){
					print('<font color="red">※入力された会員メールアドレスは既に登録されているため、新規登録できません。</font><br>');
				}else if( $err_cd == 3 ){
					print('<font color="red">※入力された会員電話番号は既に登録されているため、新規登録できません。</font><br>');
				}else if( $err_cd == 4 ){
					print('<font color="red">※選択日時は満席になってしまいました。</font><br>');
				}

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
			
			
				if( $err_cd == 4 ){
					//満室になってしまった
					
					//会員番号と会員名だけ表示
					print('<table border="0">');	//sub02
					print('<tr>');	//sub02
					//会員番号
					print('<td width="150" align="center" valign="top" >');	//sub02
					print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0"><br>');
					print('<font size="6" color="blue">' . $kaiin_id . '</font>');
					print('</td>');	//sub02
					//会員名
					print('<td width="550" align="left" valign="top" >');	//sub02
					print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0"><br>');
					if( $kaiin_nm_k1 != '' || $kaiin_nm_k2 != '' ){
						print('<font size="2" color="blue">' . $kaiin_nm_k1 . '&nbsp;' . $kaiin_nm_k2 . '</font><br>');
					}
					print('<font size="5" color="blue">' . $kaiin_nm1 . '　' . $kaiin_nm2 );
					if( $err_kaiin_nm1 == 2 ){
						print('<br><font size="2" color="red">重複している名前です。 ');
						if( $dup_id_nm_m_cnt > 0 ){
							//メンバー
								print('<br>');
							print(' [' . $dup_id_nm_m[0] . ']');
							if( $dup_id_nm_m[1] != "" ){
								print(' [' . $dup_id_nm_m[1] . ']');
							}
							if( $dup_id_nm_m[2] != "" ){
								print(' [' . $dup_id_nm_m[2] . ']');
							}
							if( $dup_id_nm_m_cnt > 3 ){
								print('(他' . ($dup_id_nm_m_cnt - 3) . '件)');
							}
						}
						print('</font>');
					}				
					print('</td>');	//sub02
					print('</tr>');	//sub02
					print('</table>');	//sub02
					
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">&nbsp;</td>');
					print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
					print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
					print('<td align="right">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
		
					print('<hr>');
						
					print('</center>');
					
				}else{
					//会員番号、会員名、会員電話番号、会員メールアドレス、会員携帯電話、予約情報メール連絡、店舗からのお知らせを表示する

					print('<table border="0">');	//sub01
					print('<tr>');	//sub01
					print('<td align="left">');	//sub01

					print('<table border="0">');	//sub02
					print('<tr>');	//sub02
					//会員番号
					print('<td width="150" align="center" valign="top" >');	//sub02
					print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0"><br>');
					print('<font size="6" color="blue">' . $kaiin_id . '</font>');
					print('</td>');	//sub02
					//会員名
					print('<td width="550" align="left" valign="top" >');	//sub02
					print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0"><br>');
					if( $kaiin_nm_k1 != '' || $kaiin_nm_k2 != '' ){
						print('<font size="2" color="blue">' . $kaiin_nm_k1 . '&nbsp;' . $kaiin_nm_k2 . '</font><br>');
					}
					print('<font size="5" color="blue">' . $kaiin_nm1 . '　' . $kaiin_nm2 );
					if( $err_kaiin_nm1 == 2 ){
						print('<br><font size="2" color="red">重複している名前です。 ');
						if( $dup_id_nm_m_cnt > 0 ){
							//正規メンバー
							print('<br>');
							print(' [' . $dup_id_nm_m[0] . ']');
							if( $dup_id_nm_m[1] != "" ){
								print(' [' . $dup_id_nm_m[1] . ']');
							}
							if( $dup_id_nm_m[2] != "" ){
								print(' [' . $dup_id_nm_m[2] . ']');
							}
							if( $dup_id_nm_m_cnt > 3 ){
								print('(他' . ($dup_id_nm_m_cnt - 3) . '件)');
							}
						}
						print('</font>');
					}				
					print('</td>');	//sub02
					print('</tr>');	//sub02
					print('</table>');	//sub02


					print('<table border="0">');
					print('<tr>');
					//会員電話番号
					print('<td width="300" valign="top">');
					print('<img src="./img_' . $lang_cd . '/title_kaiintel.png" border="0"><br>');
					$tabindex++;
					print('<input type="text" name="kaiin_tel" maxlength="15" size="16" value="' . $kaiin_tel . '" tabindex="' . $tabindex . '" class="');
					if( $err_kaiin_tel == 0 ){
					   print('normal');
					}else{
					   print('err');
					}
					print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
					if( $err_kaiin_tel == 0 ){
						print('<font size="2">(半角英数字)</font>');
					}else if( $err_kaiin_tel == 1 ){
						//未入力
						print('<font size="2" color="red">入力必須です</font>');
					}else if( $err_kaiin_tel == 2 ){
						//携帯電話なのに１０桁しかないのでエラー
						print('<font size="2" color="red">電話番号を確認してください</font>');
					}else if( $err_kaiin_tel == 3 ){
						//携帯電話なのに[050][060][070][080][090]で始まらないのでエラー
						print('<font size="2" color="red">電話番号を確認してください</font>');
					}else if( $err_kaiin_tel == 4 ){
						//10桁・11桁以外なのでエラー
						print('<font size="2" color="red">電話番号を確認してください</font>');
					}else if( $err_kaiin_tel == 5 ){
						//正メンバーまたは会員登録されている
						print('<font size="2" color="red">既に登録されています');
						if( $dup_id_tel != "" ){
							print(' [' . $dup_id_tel . ']');
						}
						if( $dup_id_tel_cnt > 1 ){
							print('(他' . ($dup_id_tel_cnt - 1) . '件)');
						}
						print('</font>');
					}
					print('</td>');
					//会員メールアドレス
					print('<td width="450" valign="top">');
					print('<img src="./img_' . $lang_cd . '/title_kaiinmail.png" border="0"><br>');
					$tabindex++;
					print('<input type="text" name="kaiin_mail" maxlength="60" size="30" value="' . $kaiin_mail . '" tabindex="' . $tabindex . '" class="');
					if( $err_kaiin_mail == 0 ){
					   print('normal');
					}else{
					   print('err');
					}
					print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
					if( $err_cd == 2 ){
						print('<br><font size="2" color="red">このアドレスは既に登録されています。');
						if( $dup_id_email != "" ){
							print(' [' . $dup_id_email . ']');
						}
						if( $dup_id_email_cnt > 1 ){
							print('(他' . ($dup_id_email_cnt - 1) . '件)');
						}
						print('</font>');
					}else if( $err_kaiin_mail == 2 ){
						print('<br><font size="2" color="red">全角文字は使えません</font>');
					}else if( $err_kaiin_mail == 3 || $err_kaiin_mail == 4 ){
						print('<br><font size="2" color="red">メールアドレスを確認してください</font>');
					}else if( $err_kaiin_mail == 5 ){
						print('<br><font size="2" color="red">このアドレスは既に登録されています。');
						if( $dup_id_email != "" ){
							print(' [' . $dup_id_email . ']');
						}
						if( $dup_id_email_cnt > 1 ){
							print('(他' . ($dup_id_email_cnt - 1) . '件)');
						}
						print('</font>');
					}else{
						print('<br><font size="2">(半角英数字)</font>');
					}
					print('</td>');
					print('</tr>');
					print('</table>');
	
					print('</td>');	//sub01
					print('</tr>');	//sub01
					print('</table>');	//sub01
				
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">&nbsp;</td>');
					print('<form method="post" action="kbtcounseling_trk_serch.php">');
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
			}
			
		}else if( $err_flg == 6 ){
			//既に登録済み（ F5 対応）
			
			//ページ編集
			print('<center>');
			
			//ページ編集
			print('<table><tr>');
			print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');

			print('<br><br><br><font color="blue">既に登録済みの可能性があります。</font><br><br><br>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kbtcounseling_trk_serch.php">');
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