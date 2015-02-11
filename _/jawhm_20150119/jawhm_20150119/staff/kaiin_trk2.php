<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>会員情報－新規会員登録</title>
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
	$gmn_id = 'kaiin_trk2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_trk1.php');

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" ){
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
					}else{
						//ログイン時間更新
						require( './zs_staff_loginupd.php' );	
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

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		
		
		//ページ編集
		$kaiin_nm1 = $_POST['kaiin_nm1'];			//会員名（姓）
		$kaiin_nm2 = $_POST['kaiin_nm2'];			//会員名（名）
		$kaiin_nm_k1 = $_POST['kaiin_nm_k1'];		//会員名カナ（セイ）
		$kaiin_nm_k2 = $_POST['kaiin_nm_k2'];		//会員名カナ（メイ）
		$input_kaiin_no = $_POST['input_kaiin_no'];	//希望する会員番号
		$kaiin_tel = $_POST['kaiin_tel'];			//会員電話番号
		$kaiin_tel_keitai = $_POST['kaiin_tel_keitai'];	//会員携帯電話
		$kaiin_mail = $_POST['kaiin_mail'];			//会員メールアドレス
		$kaiin_pw = $_POST['kaiin_pw'];				//会員パスワード
		$kaiin_kyoumi = $_POST['kaiin_kyoumi'];		//会員興味のある国
		$kaiin_zip_cd = $_POST['kaiin_zip_cd'];		//会員郵便番号
		$kaiin_adr1 = $_POST['kaiin_adr1'];			//会員住所１
		$kaiin_adr2 = $_POST['kaiin_adr2'];			//会員住所２
		$birth_year = $_POST['birth_year'];			//会員生年月日（年）
		$birth_month = $_POST['birth_month'];		//会員生年月日（月）
		$birth_day = $_POST['birth_day'];			//会員生年月日（日）
		$kaiin_seibetsu = $_POST['kaiin_seibetsu'];	//会員性別
		$kaiin_syokugyo_kbn = $_POST['kaiin_syokugyo_kbn'];	//会員職業区分
		$kaiin_sc_nm = $_POST['kaiin_sc_nm'];		//会員学校名・会社名
		$kikkake = $_POST['kikkake'];				//きっかけ
		$kaiin_bikou = $_POST['kaiin_bikou'];		//会員備考


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

		//希望する会員番号
		$err_input_kaiin_no = 0;
		if( $input_kaiin_no != '' ){
			if( is_numeric($input_kaiin_no) ){
				$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = ' . $input_kaiin_no . ';';
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
					$log_naiyou = '会員番号の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
	
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] > 0 ){
						$err_input_kaiin_no = 2;
						$err_cnt++;
					}
				}
				
			}else{
				$err_input_kaiin_no = 1;
				$err_cnt++;
			}
		}

		//会員電話番号
		$err_kaiin_tel = 0;
		$kaiin_tel_c = '';		
		$strcng_bf = $kaiin_tel;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_tel = $strcng_af;
		if( $kaiin_tel != "" ){
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
				
				//会員（非メンバー）の「電話番号」重複チェック
				$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and ( DECODE(KAIIN_TEL_C,"' . $ANGpw . '") = "' . $kaiin_tel_c . '" or DECODE(KAIIN_TEL_KEITAI_C,"' . $ANGpw . '") = "' . $kaiin_tel_c . '" );';
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
					$log_naiyou = '会員情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] > 0 ){
						$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
						$err_kaiin_tel = 5;
						$err_cnt++;
					}
				}

			}
		}

		//会員携帯電話
		$err_kaiin_tel_keitai = 0;
		$kaiin_tel_keitai_c = '';
		$strcng_bf = $kaiin_tel_keitai;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_tel_keitai = $strcng_af;
		if( $kaiin_tel_keitai != "" ){
			$telchk_bf = $kaiin_tel_keitai;
			require( '../zz_telchk.php' );	// 禁止文字（ ”’$ ）を全角変換する
			if( $telchk_rtncd != 0 ){
				$err_cnt++;
				$err_kaiin_tel_keitai = $telchk_rtncd;
			}else{
				//登録済みであるかチェックする
				
				//入力された電話番号を数字のみに変換する
				$tmp_length = mb_strlen( $kaiin_tel_keitai );
				$tmp_idx = 0;
				while( $tmp_idx < $tmp_length ){
					if( is_numeric( mb_substr( $kaiin_tel_keitai , $tmp_idx , 1 ) ) ){
						$kaiin_tel_keitai_c .= mb_substr( $kaiin_tel_keitai , $tmp_idx , 1 );
					}
					$tmp_idx++;
				}
				
				//会員（非メンバー）の「携帯電話」重複チェック
				$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and ( DECODE(KAIIN_TEL_C,"' . $ANGpw . '") = "' . $kaiin_tel_keitai_c . '" or DECODE(KAIIN_TEL_KEITAI_C,"' . $ANGpw . '") = "' . $kaiin_tel_keitai_c . '" );';
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
					$log_naiyou = '会員情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] > 0 ){
						$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
						$err_kaiin_tel_keitai = 5;
						$err_cnt++;
					}
				}
			}
		}

		//電話番号が両方とも未入力の場合はエラーとする
		if( $kaiin_tel == "" && $kaiin_tel_keitai == "" ){
			//未入力エラー
			$err_cnt++;
			$err_kaiin_tel = 1;
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
		}
		
		//会員パスワード
		$err_kaiin_pw = 0;
		if( strlen($kaiin_pw) > 0 ){
			if( strlen($kaiin_pw) < 4 ){
				$err_kaiin_pw = 1;
				$err_cnt++;
			
			}else{
				$i = 0;
				while( $i < strlen($kaiin_pw) && $err_kaiin_pw == 0 ){
					$tmp_moji = substr($kaiin_pw,$i,1);
					if( $tmp_moji == "'" || $tmp_moji == '"' || $tmp_moji == '$' ){
						$err_kaiin_pw = 2;
						$err_cnt++;
						
						$strcng_bf = $kaiin_pw;
						require( '../zz_strdel.php' );	// 禁止文字（ ”’）を削除する
						$kaiin_pw = $strcng_af;
					}
					$i++;
				}
			}
		}
		
		//興味のある国
		$err_kaiin_kyoumi = 0;
		$strcng_bf = $kaiin_kyoumi;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_kyoumi = $strcng_af;
		
		//会員郵便番号
		$err_kaiin_zip_cd = 0;
		$strcng_bf = $kaiin_zip_cd;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_zip_cd = $strcng_af;

		//会員住所１
		$err_kaiin_adr1 = 0;
		$strcng_bf = $kaiin_adr1;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_adr1 = $strcng_af;

		//会員住所２
		$err_kaiin_adr2 = 0;
		$strcng_bf = $kaiin_adr2;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_adr2 = $strcng_af;

		//会員生年月日（年）
		$err_birth_year = 0;
		if($birth_year != ''){
			if(!ereg('[0-9]{4}',$birth_year)){
				$err_birth_year = 1;
				$err_cnt++;
			}else if( $birth_year < 1912 || $birth_year >= $now_yyyy ){
				$err_birth_year = 1;
				$err_cnt++;
			}
		}

		//会員生年月日（月）
		$err_birth_month = 0;
		if($birth_month != ''){
			if(!ereg('[1-9]',$birth_month) or $birth_month < 1 or $birth_month > 12){
				$err_birth_month = 1;
				$err_cnt++;
			}
		}
		
		//会員生年月日（日）
		$err_birth_day = 0;
		if( $err_birth_year == 0 && $err_birth_month == 0 && $birth_year != '' && $birth_month != '' ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $birth_month , $birth_year );
			if($birth_day == ''){
				$err_birth_day = 1;
				$err_cnt++;
			}elseif(!ereg('[1-9]',$birth_day) or $birth_day < 1 or $birth_day > $DFmaxdd ){
				$err_birth_day = 1;
				$err_cnt++;
			}
		}
		
		//会員性別
		$err_kaiin_seibetsu = 0;
		
		//会員職業区分
		$err_kaiin_syokugyo_kbn = 0;
		
		//会員学校名・会社名
		$err_kaiin_sc_nm = 0;
		$strcng_bf = $kaiin_sc_nm;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_sc_nm = $strcng_af;
		
		//きっかけ
		$err_kikkake = 0;

		//会員備考
		$err_kaiin_bikou = 0;
		$strcng_bf = $kaiin_bikou;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_bikou = $strcng_af;

		//会員名での重複チェック
		$chk_kaiin_nm = $kaiin_nm1 . $kaiin_nm2;
			
//		//会員（非メンバー）の「名前」重複チェック
//		$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and DECODE(KAIIN_NM,"' . $ANGpw . '") = "' . $chk_kaiin_nm . '";';
//		$result = mysql_query($query);
//		if (!$result) {
//		$err_flg = 4;
//			//エラーメッセージ表示
//			require( './zs_errgmn.php' );
//					
//			//**ログ出力**
//			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//			$log_office_cd = $office_cd;	//オフィスコード
//			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
//			$log_naiyou = '会員情報の参照に失敗しました。';	//内容
//			$log_err_inf = $query;			//エラー情報
//			require( './zs_log.php' );
//			//************
//			
//		}else{
//			$row = mysql_fetch_array($result);				
//			if( $row[0] > 0 ){
//				$err_kaiin_nm1 = 2;
//				$err_kaiin_nm2 = 2;
//			}
//		}

		//会員（非メンバー）の「名前」重複チェック
		$query = 'select KAIIN_NO,DECODE(KAIIN_NM,"' . $ANGpw . '") from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" order by KAIIN_NO';
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
			$log_naiyou = '会員情報の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			while( $row = mysql_fetch_array($result) ){
				$tmp_kaiin_no = $row[0];
				$tmp_kaiin_nm = $row[1];
				if( strpos($tmp_kaiin_nm, $chk_kaiin_nm) !== false ){
					//見つかる
					if( $dup_id_nm_k_cnt < 3 ){
						$err_kaiin_nm1 = 2;
						$err_kaiin_nm2 = 2;
						$dup_id_nm_k[$dup_id_nm_k_cnt] = sprintf("%05d",$tmp_kaiin_no);
					}
					$dup_id_nm_k_cnt++;
				}
			}
		}

		//正規メンバーの「名前」重複チェック
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


		//会員（非メンバー）の「メールアドレス」重複チェック
		if( $kaiin_mail != "" ){
			$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and DECODE(KAIIN_MAIL,"' . $ANGpw . '") = "' . $kaiin_mail . '";';
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
				$log_naiyou = '会員情報の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
								
			}else{
				$row = mysql_fetch_array($result);
				if( $row[0] > 0 ){
					$err_cd = 2;	//「入力された会員メールアドレスは既に登録されているため、新規登録できません。」
					$err_kaiin_mail = 5;
					$err_cnt++;
				}
			}
		}


//		//メンバー（正会員）の「名前」「メールアドレス」重複チェック
//		$m = 0;
//		while( $m < $Mmemlist_cnt ){
//			//名前チェック
//			if( $chk_kaiin_nm != "" ){
//				if( $chk_kaiin_nm == $Mmemlist_namae[$m] ){
//					$err_kaiin_nm1 = 2;
//					$err_kaiin_nm2 = 2;					
//					if( $dup_id_nm_cnt == 0 ){
//						$dup_id_nm = $Mmemlist_id[$m];
//					}
//					$dup_id_nm_cnt++;
//				}
//			}
//			//電話番号チェック
//			if( $kaiin_tel_c != "" ){
//				if( $kaiin_tel_c == $Mmemlist_tel[$m] ){
//					//電話番号一致
//					$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
//					$err_kaiin_tel = 5;
//					if( $dup_id_tel_cnt == 0 ){
//						$dup_id_tel = $Mmemlist_id[$m];
//					}
//					$dup_id_tel_cnt++;
//					$err_cnt++;
//				}
//			}
//			//携帯電話チェック
//			if( $kaiin_tel_keitai_c != "" ){
//				if( $kaiin_tel_keitai_c == $Mmemlist_tel[$m] ){
//					//電話番号一致
//					$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
//					$err_kaiin_tel_keitai = 5;
//					if( $dup_id_tel_keitai_cnt == 0 ){
//						$dup_id_tel_keitai = $Mmemlist_id[$m];
//					}
//					$dup_id_tel_keitai_cnt++;
//					$err_cnt++;
//				}
//			}
//			//メールアドレスチェック
//			if( $kaiin_mail != "" ){
//				if( $kaiin_mail == $Mmemlist_email[$m] ){
//					//メールアドレス一致
//					$err_cd = 2;	//「入力された会員メールアドレスは既に登録されているため、新規登録できません。」
//					$err_kaiin_mail = 5;
//					if( $dup_id_email_cnt == 0 ){
//						$dup_id_email = $Mmemlist_id[$m];
//					}
//					$dup_id_email_cnt++;
//					$err_cnt++;
//				}
//			}
//			
//			$m++;	
//		}
		

		//現在の会員番号最大値を求める
		$max_kaiin_no = '';
		$query = 'select MAX_KAIIN_NO from M_KAIIN_NO where KG_CD = "' . $DEF_kg_cd . '";';
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
			$log_naiyou = '会員番号の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$max_kaiin_no = $row[0] + 1;
			if( $max_kaiin_no > 9999999 ){
				$max_kaiin_no = 1;
			}
			$tmp_flg = 0;
			while( $tmp_flg == 0 && $err_flg == 0 ){
				$query = 'select count(*) from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = ' . $max_kaiin_no . ';';
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
					$log_naiyou = '会員番号の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
	
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] == 0 ){
						$tmp_flg = 1;
					}else{
						$max_kaiin_no++;
					}
				}
			}
		}


		//会員登録を行う		
		if( $err_flg == 0 && $err_cnt == 0 ){
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
			
			$query = 'insert into M_KAIIN values("' . $DEF_kg_cd . '",';
			if( $input_kaiin_no == "" ){
				 $query .= $max_kaiin_no . ',ENCODE("' . $chk_kaiin_nm . '","' . $ANGpw . '"),ENCODE("' . $kaiin_nm1 . '","' . $ANGpw . '"),';
			}else{
				 $query .= $input_kaiin_no . ',ENCODE("' . $chk_kaiin_nm . '","' . $ANGpw . '"),ENCODE("' . $kaiin_nm1 . '","' . $ANGpw . '"),';
			}
			if( $kaiin_nm2 != "" ){
				$query .= 'ENCODE("' . $kaiin_nm2 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_nm_k1 != "" || $kaiin_nm_k2 != "" ){
				$query .= 'ENCODE("' . $kaiin_nm_k1 . $kaiin_nm_k2 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_nm_k1 != "" ){
				$query .= 'ENCODE("' . $kaiin_nm_k1 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_nm_k2 != "" ){
				$query .= 'ENCODE("' . $kaiin_nm_k2 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_mail != "" ){
				$query .= 'ENCODE("' . $kaiin_mail . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_tel != "" ){
				$query .= 'ENCODE("' . $kaiin_tel . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_tel_c != "" ){
				$query .= 'ENCODE("' . $kaiin_tel_c . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_tel_keitai != "" ){
				$query .= 'ENCODE("' . $kaiin_tel_keitai . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_tel_keitai_c != "" ){
				$query .= 'ENCODE("' . $kaiin_tel_keitai_c . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_pw != "" ){
				$query .= 'ENCODE("' . $kaiin_pw . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_kyoumi != "" ){
				$query .= 'ENCODE("' . $kaiin_kyoumi . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_bikou != "" ){
				$query .= 'ENCODE("' . $kaiin_bikou . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_zip_cd != "" ){
				$query .= '"' . $kaiin_zip_cd . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $kaiin_adr1 != "" ){
				$query .= 'ENCODE("' . $kaiin_adr1 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kaiin_adr2 != "" ){
				$query .= 'ENCODE("' . $kaiin_adr2 . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $birth_year != "" && $birth_month != "" && $birth_day != "" ){
				$query .= '"' . sprintf("%04d",$birth_year) . sprintf("%02d",$birth_month) . sprintf("%02d",$birth_day) . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $kaiin_seibetsu != "" ){
				$query .= $kaiin_seibetsu . ',';
			}else{
				$query .= 'NULL,';
			}
			if( $kaiin_syokugyo_kbn != "" ){
				$query .= '"' . $kaiin_syokugyo_kbn . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $kaiin_sc_nm != "" ){
				$query .= 'ENCODE("' . $kaiin_sc_nm . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $kikkake != "" ){
				$query .= '"' . $kikkake . '",';
			}else{
				$query .= 'NULL,';
			}
			$query .= '"' . $select_office_cd . '","KBT",0,NULL,"' . $now_time . '","' . $staff_cd . '");';
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
				$log_naiyou = '会員情報の登録に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}else{

				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '会員情報を登録しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
				if( $input_kaiin_no == "" ){
					//会員番号を更新する
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
					
					$query = 'update M_KAIIN_NO set MAX_KAIIN_NO = ' . $max_kaiin_no . ' where KG_CD = "' . $DEF_kg_cd . '";';
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
						$log_naiyou = '会員番号の更新に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
	
					}else{
		
						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = '会員番号を更新しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
					
					}
				}
			}
		}


		//メール送信
		$send_mail_flg = 0;
		if( $err_flg == 0 && $err_cnt == 0 && $kaiin_mail != "" ){
			
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
			
			// 登録完了メールを送信
			$yusen_tel = $kaiin_tel_keitai;
			if( $yusen_tel == '' ){
				$yusen_tel = $kaiin_tel;
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
			$subject .= '一般会員登録を受け付けました';
	
			// 本文
			$content = $kaiin_nm1 . " " . $kaiin_nm2 . " 様\n\n";
			$content .= $Mkanri_meishou . "です。\n";
			$content .= "当協会の一般会員登録をさせて頂きましたので\n";
			$content .= "お知らせします。\n\n";
			$content .= "---------------\n";
			$content .= "▼会員内容(一部抜粋)\n";
			$content .= "---------------\n";
			$content .= "一般会員(無料)です。(※メンバーではありません。)\n";
			$content .= "会員No: " . sprintf("%05d",$max_kaiin_no) . "\n";
			$content .= "お名前: " . $kaiin_nm1 . " " . $kaiin_nm2 . " 様\n";
			if( $yusen_tel != "" ){
				$content .= "電話  : " . $yusen_tel . "\n";
			}
			$content .= "\n";
			$content .= "※各種ご予約は以下ホームページから行えます。\n";
			$content .= "(メンバー専用の機能や特別セミナーの参加はできません。)\n\n";
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
			$mailhead = "From:\"$frname0\" <$from_mail>\r\n";
			$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
		
			$send_mail_flg = 1;
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

				//使用機種を求める
				// $mobile_kbn	:A:Android(mb) B:Android(tab) I:iPhone J:iPad D:DoCoMo(mb) U:au(mb) S:Softbank(mb) W:WILLCOM M:Macintosh P:PC
				require( '../zz_uachk.php' );
				

				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '一般会員(無料)を登録しました。<br>会員番号[' . sprintf("%07d",$tmp_kaiin_no) . ']';	//内容
				$log_err_inf = '会員番号[' . sprintf("%07d",$tmp_kaiin_no) . '] 会員名[' . $kaiin_nm1 . " " . $kaiin_nm2 . ']';			//エラー情報
				require( './zs_log.php' );
				//************


				//ページ編集
				print('<center>');
				
				//ページ編集
				print('<table><tr>');
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kaiininfo_shinkikaiintrk.png" border="0"></td>');
				print('</tr></table>');
				
				//「登録しました」
				print('<img src="./img_' . $lang_cd . '/title_trk_ok.png" border="0"><br>');
				if( $send_mail_flg == 1 ){
					//「会員へメール送信しました。」
					print('<img src="./img_' . $lang_cd . '/title_mailsend.png" border="0"><br>');
				}
				
			
				print('<table border="0">');	//sub02
				print('<tr>');	//sub02
				//会員番号
				print('<td width="150" align="center" valign="top" >');	//sub02
				print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0"><br>');
				print('<font size="6" color="blue">');
				if( $input_kaiin_no == "" ){
					print( sprintf("%05d",$max_kaiin_no) );
				}else{
					print( sprintf("%05d",$input_kaiin_no) );
				}
				print('</font>');
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
					if( $dup_id_nm_k_cnt > 0 ){
						//非メンバー
						print('<br>');
						print(' [' . $dup_id_nm_k[0] . ']');
						if( $dup_id_nm_k[1] != "" ){
							print(' [' . $dup_id_nm_k[1] . ']');
						}
						if( $dup_id_nm_k[2] != "" ){
							print(' [' . $dup_id_nm_k[2] . ']');
						}
						if( $dup_id_nm_k_cnt > 3 ){
							print('(他' . ($dup_id_nm_k_cnt - 3) . '件)');
						}
					}
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
				print('<form method="post" action="kaiin_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
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
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kaiininfo_shinkikaiintrk.png" border="0"></td>');
				print('</tr></table>');
				
				//「エラーがあります。」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0"><br>');
	
				if( $err_cd == 1 ){
					print('<font color="red">※入力された会員名は既に登録されているため、新規登録できません。</font><br>');	//ここは通らない
				}else if( $err_cd == 2 ){
					print('<font color="red">※入力された会員メールアドレスは既に登録されているため、新規登録できません。</font><br>');
				}else if( $err_cd == 3 ){
					print('<font color="red">※入力された会員電話番号は既に登録されているため、新規登録できません。</font><br>');
				}

				//会員番号、会員名、会員電話番号、会員メールアドレス、会員携帯電話 を表示する

				print('<table border="0">');	//sub01
				print('<tr>');	//sub01
				print('<td align="left">');	//sub01
				
				print('<table border="0">');	//sub02
				print('<tr>');	//sub02
				//会員番号
				print('<td width="150" align="center" valign="top" >');	//sub02
				print('<img src="./img_' . $lang_cd . '/title_kaiinno.png" border="0"><br>');
				print('<font size="6" color="blue">');
				if( $input_kaiin_no == "" ){
					print( sprintf("%05d",$max_kaiin_no) );
				}else{
					print( sprintf("%05d",$input_kaiin_no) );
				}
				print('</font>');
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
					if( $dup_id_nm_k_cnt > 0 ){
						//非メンバー
						print('<br>');
						print(' [' . $dup_id_nm_k[0] . ']');
						if( $dup_id_nm_k[1] != "" ){
							print(' [' . $dup_id_nm_k[1] . ']');
						}
						if( $dup_id_nm_k[2] != "" ){
							print(' [' . $dup_id_nm_k[2] . ']');
						}
						if( $dup_id_nm_k_cnt > 3 ){
							print('(他' . ($dup_id_nm_k_cnt - 3) . '件)');
						}
					}
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

				print('<table border="0">');
				print('<tr>');
				//会員携帯電話
				print('<td width="300" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinkeitaitel.png" border="0"><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_tel_keitai" maxlength="15" size="16" value="' . $kaiin_tel_keitai . '" tabindex="' . $tabindex . '" class="');
				if( $err_kaiin_tel_keitai == 0 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
				if( $err_kaiin_tel_keitai == 0 ){
					print('<font size="2">(半角英数字)</font>');
				}else if( $err_kaiin_tel_keitai == 1 ){
					//未入力
					print('<font size="2" color="red">入力必須です</font>');
				}else if( $err_kaiin_tel_keitai == 2 ){
					//携帯電話なのに１０桁しかないのでエラー
					print('<font size="2" color="red">電話番号を確認してください</font>');
				}else if( $err_kaiin_tel_keitai == 3 ){
					//携帯電話なのに[050][060][070][080][090]で始まらないのでエラー
					print('<font size="2" color="red">電話番号を確認してください</font>');
				}else if( $err_kaiin_tel_keitai == 4 ){
					//10桁・11桁以外なのでエラー
					print('<font size="2" color="red">電話番号を確認してください</font>');
				}else if( $err_kaiin_tel_keitai == 5 ){
					//正メンバーまたは会員登録されている
					print('<font size="2" color="red">既に登録されています');
					if( $dup_id_tel_keitai != "" ){
						print(' [' . $dup_id_tel_keitai . ']');
					}
					if( $dup_id_tel_keitai_cnt > 1 ){
						print('(他' . ($dup_id_tel_keitai_cnt - 1) . '件)');
					}
					print('</font>');
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
				print('<form method="post" action="kaiin_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
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
