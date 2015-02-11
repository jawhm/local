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
	$gmn_id = 'kaiin_trk1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kaiin_trk0.php','kaiin_trk1.php');

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
		$dup_id_nm_k_cnt = 0;	//名前重複（会員：非メンバー）
		$dup_id_nm_k[0] = '';
		$dup_id_nm_k[1] = '';
		$dup_id_nm_k[2] = '';
		$dup_id_nm_m_cnt = 0;	//名前重複（メンバー）
		$dup_id_nm_m[0] = '';
		$dup_id_nm_m[1] = '';
		$dup_id_nm_m[2] = '';
		$dup_id_tel_k_cnt = 0;	//電話番号重複（会員：非メンバー）
		$dup_id_tel_k[0] = '';	
		$dup_id_tel_m_cnt = 0;	//電話番号重複（メンバー）
		$dup_id_tel_m[0] = '';	
		$dup_id_tel_keitai_k_cnt = 0;	//携帯電話重複（会員：非メンバー）
		$dup_id_tel_keitai_k[0] = '';
		$dup_id_tel_keitai_m_cnt = 0;	//携帯電話重複（メンバー）
		$dup_id_tel_keitai_m[0] = '';
		$dup_id_email_k_cnt = 0;	//メールアドレス重複（会員：非メンバー）
		$dup_id_email_k[0] = '';
		$dup_id_email_m_cnt = 0;	//メールアドレス重複（メンバー）
		$dup_id_email_m[0] = '';


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

		//会員名カナ（せい）
		$err_kaiin_nm_k1 = 0;
		$strcng_bf = $kaiin_nm_k1;
		require( '../zz_strcng.php' );	// 禁止文字（ ”’$ ）を全角変換する
		$kaiin_nm_k1 = $strcng_af;
		$kaiin_nm_k1 = mb_convert_kana( $kaiin_nm_k1 , "KC" , "utf-8");	//半角カタカナ・全角ひらがなを全角カタカナに変換する

		//会員名カナ（めい）
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
			require( '../zz_telchk.php' );	// 電話番号チェック
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
				$query = 'select KAIIN_NO from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and ( DECODE(KAIIN_TEL_C,"' . $ANGpw . '") = "' . $kaiin_tel_c . '" or DECODE(KAIIN_TEL_KEITAI_C,"' . $ANGpw . '") = "' . $kaiin_tel_c . '" );';
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
						if( $dup_id_tel_k_cnt == 0 ){
							$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
							$err_kaiin_tel = 5;
							$err_cnt++;
							$dup_id_tel_k[0] = $row[0];		//会員電話番号
						}
						$dup_id_tel_k_cnt++;
					}
				}
				
				//正規メンバーの「電話番号」重複チェック
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
				$query = 'select KAIIN_NO from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and ( DECODE(KAIIN_TEL_C,"' . $ANGpw . '") = "' . $kaiin_tel_keitai_c . '" or DECODE(KAIIN_TEL_KEITAI_C,"' . $ANGpw . '") = "' . $kaiin_tel_keitai_c . '" );';
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
						if( $dup_id_tel_keitai_k_cnt == 0 ){
							$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
							$err_kaiin_tel_keitai = 5;
							$err_cnt++;
							$dup_id_tel_keitai_k[0] = $row[0];		//会員電話番号
						}
						$dup_id_tel_keitai_k_cnt++;
					}
				}
				
				//正規メンバーの「電話番号」重複チェック
				// ＣＲＭに転送
				$data = array(
					 'pwd' => '303pittST'
					,'chk_tel' => $kaiin_tel_keitai_c
				);
				
				$url = 'https://toratoracrm.com/crm/CS_chk_tel.php';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);
				if ($ret['result'] == 'OK')	{
					// OK
					$msg = $ret['msg'];
					$rtn_cd = $ret['rtn_cd'];
					$dup_id_tel_keitai_m_cnt = $ret['err_data_cnt'];
					if( $dup_id_tel_keitai_m_cnt > 0 ){
						$err_cd = 3;	//「入力された会員電話番号は既に登録されているため、新規登録できません。」
						$err_kaiin_tel_keitai = 5;
						$err_cnt++;
						
						$i = 0;
						while( $i < $dup_id_tel_keitai_m_cnt && $i < 3 ){
							$name = "err_id_" . $i;
							$dup_id_tel_keitai_m[$i] = $ret[$name];
							$i++;
						}
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
//なぜかLIKEが反応しない adminページでは反応するのに。
//		$query = 'select KAIIN_NO from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and DECODE(KAIIN_NM,"' . $ANGpw . '") LIKE "%' . $chk_kaiin_nm . '%";';
//		$result = mysql_query($query);
//		if (!$result) {
//			$err_flg = 4;
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
//			while( $row = mysql_fetch_array($result) ){
//				if( $dup_id_nm_k_cnt < 3 ){
//					$err_kaiin_nm1 = 2;
//					$err_kaiin_nm2 = 2;
//					$dup_id_nm_k[$dup_id_nm_k_cnt] = sprintf("%05d",$row[0]);
//				}
//				$dup_id_nm_k_cnt++;
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
		

		if( $kaiin_mail != "" ){
			//会員（非メンバー）の「メールアドレス」重複チェック
			$query = 'select KAIIN_NO from M_KAIIN where KG_CD = "' . $DEF_kg_cd . '" and DECODE(KAIIN_MAIL,"' . $ANGpw . '") = "' . $kaiin_mail . '";';
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
					//見つかる
					$tmp_kaiin_no = $row[0];
					if( $dup_id_email_k_cnt < 1 ){
						$err_cd = 2;	//「入力された会員メールアドレスは既に登録されているため、新規登録できません。」
						$err_kaiin_mail = 5;
						$err_cnt++;
						$dup_id_email_k[$dup_id_email_k_cnt] = sprintf("%05d",$tmp_kaiin_no);
					}
					$dup_id_email_k_cnt++;
				}
			}
			
			//正規メンバーの「メールアドレス」重複チェック
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


		if( $err_flg == 0 ){
			//エラーなし

			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				
				//ページ編集
				print('<center>');
				
				print('<table><tr>');
				print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kaiininfo_shinkikaiintrk.png" border="0"></td>');
				print('</tr></table>');
								
				//「内容確認後、登録ボタンを押下してください。」
				print('<img src="./img_' . $lang_cd . '/title_kbtkaiin_kkn2.png" border="0"><br>');
	
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
	
				print('<table border="0">');
				print('<tr>');
				//会員名
				print('<td width="550" align="left" valign="top" >');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0"><br>');
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
				print('</td>');
				//会員パスワード
//				print('<td width="300" valign="top">');
//				print('<img src="./img_' . $lang_cd . '/title_kaiinpw.png" border="0"><br>');
//				if( $kaiin_pw != '' ){
//					print('<font size="5" color="blue">' . $kaiin_pw . '</font>');
//				}else{
//					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
//				}
//				print('</td>');
				print('</tr>');
				print('<tr>');
				//会員カナ
				print('<td width="550" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm_k.png" border="0"><br>');
				if( $kaiin_nm_k1 != '' ){
					print('<font size="5" color="blue">' . $kaiin_nm_k1 . '　' . $kaiin_nm_k2 . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				//希望する会員番号
//				print('<td width="200" valign="top">');
//				print('<img src="./img_' . $lang_cd . '/title_kibou_kaiinno.png" border="0"><br>');
//				if( $input_kaiin_no != '' ){
//					print('<font size="5" color="blue">' . sprintf("%05d",$input_kaiin_no) . '</font>');
//				}else{
//					print('<img src="./img_' . $lang_cd . '/jidousaiban.png" border="0">');	//「自動採番」
//				}
//				print('</td>');
				print('</tr>');
				print('</table>');
			
				print('<table border="0">');
				print('<tr>');
				//会員電話番号
				print('<td width="300" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiintel.png" border="0"><br>');
				if( $kaiin_tel != '' ){
					print('<font size="5" color="blue">' . $kaiin_tel . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('<br>');
				print('<font size="2">(半角英数字)<br></font>');
				print('</td>');
				//会員メールアドレス
				print('<td width="450" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinmail.png" border="0"><br>');
				if( $kaiin_mail != '' ){
					print('<font size="5" color="blue">' . $kaiin_mail . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('<br>');
				print('<font size="2">(半角英数字)</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
		
				print('<table border="0">');
				print('<tr>');
				//会員携帯電話
				print('<td width="300" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinkeitaitel.png" border="0"><br>');
				if( $kaiin_tel_keitai != '' ){
					print('<font size="5" color="blue">' . $kaiin_tel_keitai . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('<br>');
				print('<font size="2">(半角英数字)</font>');
				print('</td>');
				//興味のある国
				print('<td width="450" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
				if( $kaiin_kyoumi != '' ){
					print('<font size="5" color="blue">' . $kaiin_kyoumi . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				print('</tr>');
				print('</table>');

				//print('<img src="./img_' . $lang_cd . '/title_ikanokoumoku.png" border="0"><br>');
				print('<hr>');
				
				print('<table border="0">');
				print('<tr>');
				//郵便番号
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_yubinbangou.png" border="0"><br>');
				if( $kaiin_zip_cd != '' ){
					print('<font size="5" color="blue">' . $kaiin_zip_cd . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				
				print('<td width="100">&nbsp;</td>');	//（調整空白）
				
				//性別
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_seibetsu.png" border="0"><br>');
				if( $kaiin_seibetsu == 1 ){
					print('<font size="5" color="blue">男性</font>');
				}else if( $kaiin_seibetsu == 2 ){
					print('<font size="5" color="blue">女性</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				//生年月日
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_seinengappi.png" border="0"><br>');
				if( $birth_year != '' ){
					print('<table border="0">');
					print('<tr>');
					print('<td valign="bottom"><font size="5" color="blue">' . $birth_year . '</font></td>');
					print('<td valign="bottom">年&nbsp;</td>');
					print('<td valign="bottom"><font size="5" color="blue">' . sprintf("%d",$birth_month) . '</font></td>');
					print('<td valign="bottom">月&nbsp;</td>');
					print('<td valign="bottom"><font size="5" color="blue">' . sprintf("%d",$birth_day) . '</font></td>');
					print('<td valign="bottom">日</td>');
					print('</tr>');
					print('</table>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//住所１
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_adr.png" border="0"><br>');
				if( $kaiin_adr1 != '' ){
					print('<font size="5" color="blue">' . $kaiin_adr1 . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('<br>');
				if( $kaiin_adr2 != '' ){
					print('<font size="5" color="blue">' . $kaiin_adr2 . '</font>');
				}
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//職業区分
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_syokugyokbn.png" border="0"><br>');
				if( $kaiin_syokugyo_kbn == 'A' ){
					print('<font size="5" color="blue">小・中学生</font>');
				}else if( $kaiin_syokugyo_kbn == 'B' ){
					print('<font size="5" color="blue">高校生・受験生</font>');
				}else if( $kaiin_syokugyo_kbn == 'C' ){
					print('<font size="5" color="blue">専門学校・大学生</font>');
				}else if( $kaiin_syokugyo_kbn == 'D' ){
					print('<font size="5" color="blue">大学院・研究生</font>');
				}else if( $kaiin_syokugyo_kbn == 'E' ){
					print('<font size="5" color="blue">会社員</font>');
				}else if( $kaiin_syokugyo_kbn == 'F' ){
					print('<font size="5" color="blue">公務員</font>');
				}else if( $kaiin_syokugyo_kbn == 'G' ){
					print('<font size="5" color="blue">自営業</font>');
				}else if( $kaiin_syokugyo_kbn == 'H' ){
					print('<font size="5" color="blue">フリーランス・自由業</font>');
				}else if( $kaiin_syokugyo_kbn == 'I' ){
					print('<font size="5" color="blue">会社経営・役員</font>');
				}else if( $kaiin_syokugyo_kbn == 'J' ){
					print('<font size="5" color="blue">団体職員</font>');
				}else if( $kaiin_syokugyo_kbn == 'K' ){
					print('<font size="5" color="blue">主婦</font>');
				}else if( $kaiin_syokugyo_kbn == 'L' ){
					print('<font size="5" color="blue">フリーター</font>');
				}else if( $kaiin_syokugyo_kbn == 'M' ){
					print('<font size="5" color="blue">家事手伝い</font>');
				}else if( $kaiin_syokugyo_kbn == 'N' ){
					print('<font size="5" color="blue">無職</font>');
				}else if( $kaiin_syokugyo_kbn == 'Z' ){
					print('<font size="5" color="blue">その他</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				//学校名・会社名
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_sc_nm.png" border="0"><br>');
				if( $kaiin_sc_nm != '' ){
					print('<font size="5" color="blue">' . $kaiin_sc_nm . '</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//きっかけ
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kikkake.png" border="0"><br>');
				if( $kikkake == 'A' ){
					print('<font size="5" color="blue">インターネット</font>');
				}else if( $kikkake == 'B' ){
					print('<font size="5" color="blue">看板</font>');
				}else if( $kikkake == 'C' ){
					print('<font size="5" color="blue">学校</font>');
				}else if( $kikkake == 'D' ){
					print('<font size="5" color="blue">知人の紹介</font>');
				}else if( $kikkake == 'Z' ){
					print('<font size="5" color="blue">その他</font>');
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</td>');
				print('</tr>');
				print('</table>');
				
				//備考
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">');
				print('<img src="./img_' . $lang_cd . '/title_bikou.png" border="0"><br>');
				print('<div style="margin: 10px"><pre><font color="blue">');
				if( $kaiin_bikou != '' ){
					print( $kaiin_bikou );
				}else{
					print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//「未登録」
				}
				print('</font></pre></div>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('</td>');
				print('</tr>');
				print('</table>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kaiin_trk2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="kaiin_nm1" value="' . $kaiin_nm1 . '">');
				print('<input type="hidden" name="kaiin_nm2" value="' . $kaiin_nm2 . '">');
				print('<input type="hidden" name="kaiin_nm_k1" value="' . $kaiin_nm_k1 . '">');
				print('<input type="hidden" name="kaiin_nm_k2" value="' . $kaiin_nm_k2 . '">');
				print('<input type="hidden" name="input_kaiin_no" value="' . $input_kaiin_no . '">');
				print('<input type="hidden" name="kaiin_tel" value="' . $kaiin_tel . '">');
				print('<input type="hidden" name="kaiin_tel_keitai" value="' . $kaiin_tel_keitai . '">');
				print('<input type="hidden" name="kaiin_mail" value="' . $kaiin_mail . '">');
				print('<input type="hidden" name="kaiin_pw" value="' . $kaiin_pw . '">');
				print('<input type="hidden" name="kaiin_kyoumi" value="' . $kaiin_kyoumi . '">');
				print('<input type="hidden" name="kaiin_zip_cd" value="' . $kaiin_zip_cd . '">');
				print('<input type="hidden" name="kaiin_adr1" value="' . $kaiin_adr1 . '">');
				print('<input type="hidden" name="kaiin_adr2" value="' . $kaiin_adr2 . '">');
				print('<input type="hidden" name="birth_year" value="' . $birth_year . '">');
				print('<input type="hidden" name="birth_month" value="' . $birth_month . '">');
				print('<input type="hidden" name="birth_day" value="' . $birth_day . '">');
				print('<input type="hidden" name="kaiin_seibetsu" value="' . $kaiin_seibetsu . '">');
				print('<input type="hidden" name="kaiin_syokugyo_kbn" value="' . $kaiin_syokugyo_kbn . '">');
				print('<input type="hidden" name="kaiin_sc_nm" value="' . $kaiin_sc_nm . '">');
				print('<input type="hidden" name="kikkake" value="' . $kikkake . '">');
				print('<input type="hidden" name="kaiin_bikou" value="' . $kaiin_bikou . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kaiin_trk0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="kaiin_nm1" value="' . $kaiin_nm1 . '">');
				print('<input type="hidden" name="kaiin_nm2" value="' . $kaiin_nm2 . '">');
				print('<input type="hidden" name="kaiin_nm_k1" value="' . $kaiin_nm_k1 . '">');
				print('<input type="hidden" name="kaiin_nm_k2" value="' . $kaiin_nm_k2 . '">');
				print('<input type="hidden" name="input_kaiin_no" value="' . $input_kaiin_no . '">');
				print('<input type="hidden" name="kaiin_tel" value="' . $kaiin_tel . '">');
				print('<input type="hidden" name="kaiin_tel_keitai" value="' . $kaiin_tel_keitai . '">');
				print('<input type="hidden" name="kaiin_mail" value="' . $kaiin_mail . '">');
				print('<input type="hidden" name="kaiin_pw" value="' . $kaiin_pw . '">');
				print('<input type="hidden" name="kaiin_kyoumi" value="' . $kaiin_kyoumi . '">');
				print('<input type="hidden" name="kaiin_zip_cd" value="' . $kaiin_zip_cd . '">');
				print('<input type="hidden" name="kaiin_adr1" value="' . $kaiin_adr1 . '">');
				print('<input type="hidden" name="kaiin_adr2" value="' . $kaiin_adr2 . '">');
				print('<input type="hidden" name="birth_year" value="' . $birth_year . '">');
				print('<input type="hidden" name="birth_month" value="' . $birth_month . '">');
				print('<input type="hidden" name="birth_day" value="' . $birth_day . '">');
				print('<input type="hidden" name="kaiin_seibetsu" value="' . $kaiin_seibetsu . '">');
				print('<input type="hidden" name="kaiin_syokugyo_kbn" value="' . $kaiin_syokugyo_kbn . '">');
				print('<input type="hidden" name="kaiin_sc_nm" value="' . $kaiin_sc_nm . '">');
				print('<input type="hidden" name="kikkake" value="' . $kikkake . '">');
				print('<input type="hidden" name="kaiin_bikou" value="' . $kaiin_bikou . '">');
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
					print('<font color="red">※入力された会員名は既に登録されているため、新規登録できません。</font><br>');
				}else if( $err_cd == 2 ){
					print('<font color="red">※入力された会員メールアドレスは既に登録されているため、新規登録できません。</font><br>');
				}else if( $err_cd == 3 ){
					print('<font color="red">※入力された会員電話番号は既に登録されているため、新規登録できません。</font><br>');
				}

				//「会員情報を入力後、登録ボタンを押下してください。」
				print('<img src="./img_' . $lang_cd . '/title_kaiinnyuuryoku_go_trk.png" border="0"><br>');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');

				print('<form method="post" action="kaiin_trk1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				
				//明細フォーム
				print('<table border="0">');
				print('<tr>');
				//会員名
				print('<td width="450" align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm.png" border="0"><br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<font size="2">(姓)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_nm1" maxlength="20" size="9" value="' . $kaiin_nm1 . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_nm1 == 0 || $err_kaiin_nm1 == 2 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<font size="2">(名)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_nm2" maxlength="20" size="9" value="' . $kaiin_nm2 . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_nm2 == 0 || $err_kaiin_nm2 == 2 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('</tr>');
				print('</table>');
				if( $err_kaiin_nm1 == 2 ){
					print('<font size="2" color="red">重複している名前です。');
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
				print('</td>');
				//希望する会員番号
//				print('<td width="200" valign="top">');
//				print('<img src="./img_' . $lang_cd . '/title_kibou_kaiinno.png" border="0"><br>');
//				$tabindex++;
//				print('<input type="text" name="input_kaiin_no" maxlength="5" size="5" value="' . $input_kaiin_no . '" tabindex="' . $tabindex . '"  class="');
//				if( $err_input_kaiin_no == 0 ){
//				   print('normal');
//				}else{
//				   print('err');
//				}
//				print('" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
//				if( $err_input_kaiin_no == 2 ){
//					print('<font size="2" color="red">この番号は登録されています。</font></td>');
//				}else{
//					print('<font size="2" color="#aaaaaa">未入力時：' . sprintf('%05d',$max_kaiin_no) . ' 予定</font></td>');
//				}
				print('</tr>');
				print('<tr>');
				//会員名カナ
				print('<td width="450" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kaiinnm_k.png" border="0"><br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<font size="2">(セイ)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_nm_k1" maxlength="20" size="9" value="' . $kaiin_nm_k1 . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_nm_k1 == 0 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('<td align="left" valign="top">');
				print('<font size="2">(メイ)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_nm_k2" maxlength="20" size="9" value="' . $kaiin_nm_k2 . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_nm_k2 == 0 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('</tr>');
				print('</table>');
				print('</td>');
				//会員パスワード
//				print('<td width="300" valign="top">');
//				print('<img src="./img_' . $lang_cd . '/title_kaiinpw.png" border="0"><br>');
//				$tabindex++;
//				print('<input type="text" name="kaiin_pw" maxlength="30" size="16" value="' . $kaiin_pw . '" tabindex="' . $tabindex . '" class="');
//				if( $err_kaiin_pw == 0 ){
//				   print('normal');
//				}else{
//				   print('err');
//				}
//				print('" style="font-size:20pt;ime-mode:disabled" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
//				print('<font size="2">(半角英数字：4文字以上)</font>');
//				print('</td>');
				print('</tr>');
				print('</table>');

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
					print('<font size="2" color="red">既に登録されています<br>');
					if( $dup_id_tel_k_cnt > 0 ){
						print(' [' . sprintf("%05d",$dup_id_tel_k[0]) . ']');
						if( $dup_id_tel_k_cnt > 1 ){
							print('(他' . ($dup_id_tel_k_cnt - 1) . '件)<br>');
						}
					}
					if( $dup_id_tel_m_cnt > 0 ){
						print(' [' . $dup_id_tel_m[0] . ']');
						if( $dup_id_tel_m_cnt > 1 ){
							print('(他' . ($dup_id_tel_m_cnt - 1) . '件)');
						}
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
					print('<br><font size="2" color="red">このアドレスは既に登録されています<br>');
					if( $dup_id_email_k_cnt > 0 ){
						print(' [' . $dup_id_email_k[0] . ']');
						if( $dup_id_email_k_cnt > 1 ){
							print('(他' . ($dup_id_email_k_cnt - 1) . '件)<br>');
						}
					}
					if( $dup_id_email_m_cnt > 0 ){
						print(' [' . $dup_id_email_m[0] . ']');
						if( $dup_id_email_m_cnt > 1 ){
							print('(他' . ($dup_id_email_m_cnt - 1) . '件)');
						}
					}
					print('</font>');
				}else if( $err_kaiin_mail == 2 ){
					print('<br><font size="2" color="red">全角文字は使えません</font>');
				}else if( $err_kaiin_mail == 3 || $err_kaiin_mail == 4 ){
					print('<br><font size="2" color="red">メールアドレスを確認してください</font>');
				}else if( $err_kaiin_mail == 5 ){
					print('<br><font size="2" color="red">このアドレスは既に登録されています<br>');
					if( $dup_id_email_k_cnt > 0 ){
						print(' [' . sprintf("%05d",$dup_id_email_k[0]) . ']');
						if( $dup_id_email_k_cnt > 1 ){
							print('(他' . ($dup_id_email_k_cnt - 1) . '件)<br>');
						}
					}
					if( $dup_id_email_m_cnt > 0 ){
						print(' [' . $dup_id_email_m[0] . ']');
						if( $dup_id_email_m_cnt > 1 ){
							print('(他' . ($dup_id_email_m_cnt - 1) . '件)');
						}
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
					print('<font size="2" color="red">既に登録されています<br>');
					if( $dup_id_tel_keitai_k_cnt > 0 ){
						print(' [' . $dup_id_tel_keitai_k[0] . ']');
						if( $dup_id_tel_keitai_k_cnt > 1 ){
							print('(他' . ($dup_id_tel_keitai_k_cnt - 1) . '件)<br>');
						}
					}
					if( $dup_id_tel_keitai_m_cnt > 0 ){
						print(' [' . $dup_id_tel_keitai_m[0] . ']');
						if( $dup_id_tel_keitai_m_cnt > 1 ){
							print('(他' . ($dup_id_tel_keitai_m_cnt - 1) . '件)');
						}
					}
					print('</font>');
				}
				print('</td>');
				//興味のある国
				print('<td width="450" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_kyoumi" maxlength="60" size="30" value="' . $kaiin_kyoumi . '" tabindex="' . $tabindex . '" class="');
				if( $err_kaiin_kyoumi == 0 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt;ime-mode:active" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('</tr>');
				print('</table>');
			
				print('<hr>');
	
				print('<table border="0">');
				print('<tr>');
				//郵便番号
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_yubinbangou.png" border="0"><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_zip_cd" maxlength="8" size="10" value="' . $kaiin_zip_cd . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_zip_cd == 0 ){
				   print('normal');
				}else{
				   print('err');
				}
				print('" style="font-size:20pt; ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'"><br>');
				print('</td>');
				print('<td width="100">&nbsp;</td>');	//（調整空白）
				//性別
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_seibetsu.png" border="0"><br>');
				$tabindex++;
				print('<select name="kaiin_seibetsu" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
				if( $kaiin_seibetsu == 0 ){
					print('<option value="0" class="color0" selected>&nbsp;</option>');
					print('<option value="1" class="color1">男性</option>');
					print('<option value="2" class="color2">女性</option>');
				}else if( $kaiin_seibetsu == 1 ){
					print('<option value="0" class="color0">&nbsp;</option>');
					print('<option value="1" class="color1" selected>男性</option>');
					print('<option value="2" class="color2">女性</option>');
				}else{
					print('<option value="0" class="color0">&nbsp;</option>');
					print('<option value="1" class="color1">男性</option>');
					print('<option value="2" class="color2" selected>女性</option>');
				}
				print('</select>');
				print('</td>');
				//生年月日
				print('<td align="left" valign="bottom">');
				print('<img src="./img_' . $lang_cd . '/title_seinengappi.png" border="0"><br>');
				$tabindex++;
				print('<select name="birth_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				print('<option value="">&nbsp;</option>');
				$i = $now_yyyy;
				while( $i > ($now_yyyy - 100) ){
					print('<option value="' . $i . '" ');
					if( $i == $birth_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
					$i--;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="birth_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				print('<option value="">&nbsp;</option>');
				$i = 1;
					while( $i < 13 ){
					print('<option value="' . $i . '" ');
						if( $i == $birth_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
					
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="birth_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				print('<option value="">&nbsp;</option>');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $birth_day ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('日');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//住所１
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_adr.png" border="0"><br>');
				print('&nbsp;&nbsp;<font size="2">（住所１）都道府県名・市区町村(例：</font><font color="blue" size="2">' . $ex_adr1 . '</font><font size="2">&nbsp;)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_adr1" maxlength="80" size="50" value="' . $kaiin_adr1 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('<br>&nbsp;&nbsp;<font size="2">（住所２）丁目/番地・マンション名・部屋番号(例：</font><font color="blue" size="2">' . $ex_adr2 . '</font><font size="2">&nbsp;)</font><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_adr2" maxlength="80" size="50" value="' . $kaiin_adr2 . '" tabindex="' . $tabindex . '"  class="normal" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//職業区分
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_syokugyokbn.png" border="0"><br>');
				$tabindex++;
				print('<select name="kaiin_syokugyo_kbn" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
				//--(初期値)
				print('<option value="" class="color0" ');
				if( $kaiin_syokugyo_kbn == '' ){
					print('selected');
				}
				print('>&nbsp;</option>');
				//-- 小・中学生
				print('<option value="A" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'A' ){
					print('selected');
				}
				print('>小・中学生</option>');
				//-- 高校生・受験生
				print('<option value="B" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'B' ){
					print('selected');
				}
				print('>高校生・受験生</option>');
				//-- 専門学校・大学生
				print('<option value="C" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'C' ){
					print('selected');
				}
				print('>専門学校・大学生</option>');
				//-- 大学院・研究生
				print('<option value="D" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'D' ){
					print('selected');
				}
				print('>大学院・研究生</option>');
				//-- 会社員
				print('<option value="E" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'E' ){
					print('selected');
				}
				print('>会社員</option>');
				//-- 公務員
				print('<option value="F" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'F' ){
					print('selected');
				}
				print('>公務員</option>');
				//-- 自営業
				print('<option value="G" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'G' ){
					print('selected');
				}
				print('>自営業</option>');
				//-- フリーランス・自由業
				print('<option value="H" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'H' ){
					print('selected');
				}
				print('>フリーランス・自由業</option>');
				//-- 会社経営・役員
				print('<option value="I" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'I' ){
					print('selected');
				}
				print('>会社経営・役員</option>');
				//-- 団体職員
				print('<option value="J" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'J' ){
					print('selected');
				}
				print('>団体職員</option>');
				//-- 主婦
				print('<option value="K" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'K' ){
					print('selected');
				}
				print('>主婦</option>');
				//-- フリーター
				print('<option value="L" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'L' ){
					print('selected');
				}
				print('>フリーター</option>');
				//-- 家事手伝い
				print('<option value="M" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'M' ){
					print('selected');
				}
				print('>家事手伝い</option>');
				//-- 無職
				print('<option value="N" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'N' ){
					print('selected');
				}
				print('>無職</option>');
				//-- その他
				print('<option value="Z" class="color0" ');
				if( $kaiin_syokugyo_kbn == 'Z' ){
					print('selected');
				}
				print('>その他</option>');
				print('</select>');
				print('</td>');
				//学校名・会社名
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_sc_nm.png" border="0"><br>');
				$tabindex++;
				print('<input type="text" name="kaiin_sc_nm" maxlength="80" size="32" value="' . $kaiin_sc_nm . '" tabindex="' . $tabindex . '"  class="');
				if( $err_kaiin_sc_nm == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt; ime-mode:active;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//きっかけ
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/title_kikkake.png" border="0"><br>');
				$tabindex++;
				print('<select name="kikkake" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
				//--(初期値)
				print('<option value="" class="color0" ');
				if( $kikkake == '' ){
					print('selected');
				}
				print('>&nbsp;</option>');
				//-- インターネット
				print('<option value="A" class="color0" ');
				if( $kikkake == 'A' ){
					print('selected');
				}
				print('>インターネット</option>');
				//-- 看板
				print('<option value="B" class="color0" ');
				if( $kikkake == 'B' ){
					print('selected');
				}
				print('>看板</option>');
				//-- 学校
				print('<option value="C" class="color0" ');
				if( $kikkake == 'C' ){
					print('selected');
				}
				print('>学校</option>');
				//-- 知人の紹介
				print('<option value="D" class="color0" ');
				if( $kikkake == 'D' ){
					print('selected');
				}
				print('>知人の紹介</option>');
				//-- その他
				print('<option value="Z" class="color0" ');
				if( $kikkake == 'Z' ){
					print('selected');
				}
				print('>その他</option>');
				print('</select>');
				print('</td>');
				
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				//備考
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">');
				print('<img src="./img_' . $lang_cd . '/title_bikou.png" border="0"><br>');
				$tabindex++;
				print('<textarea name="kaiin_bikou" rows="4" cols="60" tabindex="' . $tabindex . '" class="');
				if( $err_kaiin_bikou == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $kaiin_bikou . '</textarea>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
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
