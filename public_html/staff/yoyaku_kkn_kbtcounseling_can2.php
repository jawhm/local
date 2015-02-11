<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング予約一覧　キャンセル</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
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
	$gmn_id = 'yoyaku_kkn_kbtcounseling_can2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('yoyaku_kkn_kbtcounseling_can1.php');

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
	$select_yyk_no = $_POST['select_yyk_no'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" || $select_yyk_no == "" ){
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

			//クラス予約キャンセルから最新内容を取得する
			$zz_yykinfo_yyk_no = $select_yyk_no;
			require( '../zz_yykinfo_kako.php' );
			if( $zz_yykinfo_rtncd == 1 ){
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
						
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約キャンセル内容の取り込みに失敗しました。';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zs_log.php' );
				//************
			
			}

		}
		
		
		if( $err_flg == 0 ){
			
			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
			
			//クラス予約キャンセルへ登録する
			$query = 'insert into D_CLASS_YYK_CAN values("' . $DEF_kg_cd . '","' . $zz_yykinfo_office_cd . '","' . $zz_yykinfo_class_cd . '","' . $zz_yykinfo_ymd . '","' . $zz_yykinfo_jkn_kbn . '",' . $select_yyk_no . ',' . $zz_yykinfo_kaiin_kbn . ',"' . $zz_yykinfo_kaiin_id . '",ENCODE("' . $zz_yykinfo_kaiin_nm . '","' . $ANGpw . '"),';
			if( $zz_yykinfo_kaiin_mixi == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_kaiin_mixi . '",';
			}
			if( $zz_yykinfo_staff_cd == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_staff_cd . '",';
			}
			$query .= '9,';
			if( $zz_yykinfo_kyoumi == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_kyoumi . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_jiki == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_jiki . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_soudan == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_soudan . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_bikou == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_bikou . '","' . $ANGpw . '"),';
			}
			$query .= $zz_yykinfo_znz_mail_send_flg . ',' . $zz_yykinfo_tjt_mail_send_flg . ',"' . $zz_yykinfo_yyk_time . '","' . $zz_yykinfo_cancel_time . '","' . $now_time . '",';
			if( $zz_yykinfo_yyk_staff_cd == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_yyk_staff_cd . '",';
			}
			$query .= '"' . $staff_cd . '");';
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
				$log_naiyou = 'クラス予約キャンセルの登録に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}else{

				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約キャンセルを登録しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
				//クラス予約を削除する
				$query = 'delete from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '" and YMD = "' . $zz_yykinfo_ymd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and YYK_NO = ' . $select_yyk_no . ';';
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
					$log_naiyou = 'クラス予約の削除に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
	
				}else{

					//**トランザクション出力**
					$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約を削除しました。（予約キャンセル）';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					
					//googleカレンダーから削除する
					if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
						
						//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
						$yoyakudate = substr($zz_yykinfo_ymd,0,4) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . ' ' . sprintf("%02d",intval($zz_yykinfo_st_time / 100)) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . ':00';


//print('cal_delete<br>');
//print('kbn[2]<br>');
//print('id[' . $zz_yykinfo_kaiin_id . ']<br>');
//print('date[' . $yoyakudate . ']<br>');

						// カレンダー削除
						$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
						$data = array(
							'kbn'	=> 2,
							'id'	=> $zz_yykinfo_kaiin_id,
							'place' => $zz_yykinfo_office_nm,
							'yoyakudate' => $yoyakudate,
							'tantou' 	=> "",
							'yoyakumsg' => $zz_yykinfo_bikou,
							'namae1' 	=> $zz_yykinfo_kaiin_nm_1,
							'namae2' 	=> $zz_yykinfo_kaiin_nm_2,
							'firigana1' => $zz_yykinfo_kaiin_nm_k_1,
							'firigana2' => $zz_yykinfo_kaiin_nm_k_2,
							'tel'	=> "",
							'email' => ""
						);
			
						$options = array('http' => array(
										'method' => 'POST',
										'content' => http_build_query($data),
									));
						$contents = file_get_contents($url, false, stream_context_create($options));
						$ret = json_decode($contents, true);
						if ($ret['result'] == 'OK')	{
					
//							//**ログ出力**
//							$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//							$log_office_cd = $office_cd;	//オフィスコード
//							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
//							$log_naiyou = 'googleカレンダーから削除しました。';	//内容
//							$log_err_inf = '会場[' . $zz_yykinfo_office_nm . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $zz_yykinfo_kaiin_id . '] 名前[' . $zz_yykinfo_kaiin_nm_1 . ' ' . $zz_yykinfo_kaiin_nm_2 . '] フリガナ[' . $kaiin_nm_k1 . ' ' . $kaiin_nm_k2 . '] 相談内容[' . $zz_yykinfo_bikou . ']';			//エラー情報
//							require( './zs_log.php' );
//							//************
						
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
							$log_naiyou = 'googleカレンダーからの削除に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
							$log_err_inf = '会場[' . $zz_yykinfo_office_nm . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $zz_yykinfo_kaiin_id . ']';			//エラー情報
							require( './zs_log.php' );
							//************
						
						}
					}
				}
			}
		}
			
		//*** メール通知 ***
		$send_mail_flg = 0;			//メール送信フラグ  0:未送信 1:送信した
		$send_mail_adr_cnt = 0;
		$ipn_kaiin_tel = "";		//会員電話番号
		$ipn_kaiin_tel_keitai = "";	//会員携帯電話

		if( $err_flg == 0 && ($zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9) ){
			
			
			//半角小文字を半角大文字に変換する
			$zz_yykinfo_kaiin_id = strtoupper( $zz_yykinfo_kaiin_id );	//小文字を大文字にする
				
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST',
				 'serch_id' => $zz_yykinfo_kaiin_id
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
						$data_kaiin_no[$i] = $ret[$name];	//会員番号
						$name = "data_name_" . $i;
						$data_kaiin_nm[$i] = $ret[$name];	//会員名
						$name = "data_name_k_" . $i;
						$data_kaiin_nm_k[$i] = $ret[$name];	//会員名カナ
						$name = "data_mail_" . $i;
						$tmp_mail = $ret[$name];			//会員メールアドレス
						$tmp_mail = str_replace(',','<br>',$tmp_mail );
						
						if( $zz_yykinfo_bikou != "" ){
							//登録時にログインメールアドレスが存在する場合は、そのメールアドレスのみ送信する
							$send_kaiin_nm[0] = $data_kaiin_nm[$i];
							$send_mail_adr[0] = $zz_yykinfo_bikou;
							$send_mail_adr_cnt = 1;
							
						}else{
						
							$tmp_mail_len = strlen($tmp_mail);
							while( $tmp_mail_len > 0 ){
								$tmp_mail_pos = strpos($tmp_mail,"<br>");
								if( $tmp_mail_pos === false ){
									//見つからなかった
									//メアドの整合性チェック
									$chk_mailadr_flg = 0;
									if( strlen( $tmp_mail ) != mb_strlen( $tmp_mail ) ){
										//全角が含まれている
										$chk_mailadr_flg = 1;
									}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $tmp_mail) ){
										//メールアドレスとしてふさわしくない
										$chk_mailadr_flg = 2;
									}
							
									if( $chk_mailadr_flg == 0 ){
										//メアドチェックＯＫ なので 送信対象とする
										$send_kaiin_nm[$send_mail_adr_cnt] = $data_kaiin_nm[$i];
										$send_mail_adr[$send_mail_adr_cnt] = $tmp_mail;
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
									$chk_mailadr = substr($tmp_mail,0,$tmp_mail_pos);
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
										$send_kaiin_nm[$send_mail_adr_cnt] = $data_kaiin_nm[$i];
										$send_mail_adr[$send_mail_adr_cnt] = substr($tmp_mail,0,$tmp_mail_pos);
										$send_mail_adr_cnt++;
									
									}else{
										
										//**ログ出力**
										$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
										$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
										$log_office_cd = $office_cd;	//オフィスコード
										$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
										$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $zz_yykinfo_kaiin_id . '] メアド[' . $chk_mailadr . ']';	//内容
										$log_err_inf = '';			//エラー情報
										require( './zs_log.php' );
										//************
											
									}
										
									$tmp_mail = substr($tmp_mail,($tmp_mail_pos + 4),($tmp_mail_len - ($tmp_mail_pos + 4)));
									$tmp_mail_len = strlen($tmp_mail);
								}
							}
						}
						
						$i++;
					}
				}
					
//##############################################################
//開発テスト時はお客様へメールせず、設定されたメアドに変更する
				if( $SVkankyo == 9 ){
					$send_mail_adr_cnt = $sv_test_cs_mailadr_cnt;
					$m = 0;
					while( $m < $send_mail_adr_cnt ){
						$send_kaiin_nm[$m] = "テスト会員";
						$send_mail_adr[$m] = $sv_test_cs_mailadr[$m];
						$m++;
					}
				}
//##############################################################

			}

			//メアドがあり、処理時点以降の時間帯であればメール送信する
			$tmp_zz_yykinfo_ymd = substr($zz_yykinfo_ymd,0,4) . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . sprintf("%02d",substr($zz_yykinfo_ymd,8,2));
			if( $send_mail_adr_cnt > 0 && ($tmp_zz_yykinfo_ymd > $now_yyyymmdd || ( $tmp_zz_yykinfo_ymd == $now_yyyymmdd && $zz_yykinfo_st_time >= ($now_hh * 100 + $now_ii) )) ){

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
				

				//電話番号を判定する（携帯電話優先）･･･一般（非メンバー）のみ
				$yusen_tel = "";
				if( $zz_yykinfo_kaiin_kbn == 9 ){
					 $yusen_tel = $ipn_kaiin_tel_keitai;
					if( $yusen_tel == '' ){
						$yusen_tel = $ipn_kaiin_tel;
					}
				}
				
				
				// 登録完了メールを送信
				
				$m = 0;
				while( $m < $send_mail_adr_cnt ){
			
					//登録完了メール送信
					//送信元
					$from_nm = $Mkanri_meishou;
					$from_mail = $Mkanri_send_mail_adr;
					//宛て先
					$to_nm = $send_kaiin_nm[$m] . ' 様';
					
					//メールアドレス
					$to_mail = $send_mail_adr[$m];
				
					//タイトル
					if( $Mkanri_ryakushou != '' ){
						$subject = '(' . $Mkanri_ryakushou . ')';
					}else{
						$subject = '';	
					}
					$subject .= '個別カウンセリングの予約を取消しました';
			
					// 本文
					$content = $send_kaiin_nm[$m] . " 様\n\n";
					$content .= $Mkanri_meishou . "です。\n";
					$content .= "当協会の個別カウンセリングの予約を\n";
					$content .= "取消しましたのでお知らせします。\n\n";
					$content .= "---------------\n";
					$content .= "▼取消した予約内容\n";
					$content .= "---------------\n";
					$content .= "個別カウンセリング\n\n";
					$content .= "予約No: " . sprintf("%05d",$select_yyk_no) . "\n";
					$content .= "会場: " . $zz_yykinfo_office_nm . "\n";
					$content .= "日付: " . substr($zz_yykinfo_ymd,0,4) . "年" . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . "月" . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . "日(" . $week[$zz_yykinfo_youbi_cd] . ")\n";
					$content .= "時間: " . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . " - " . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) ."\n";
					$content .= "※予約取消しました。\n\n";
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
			
			if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '個別カウンセリングをキャンセルしました。<br>予約No[' . sprintf("%05d",$select_yyk_no) . '] 会場[' . $zz_yykinfo_office_nm . '] 日時[' . $zz_yykinfo_ymd . ' ' . intval($zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . "-" . intval($zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . ']<br>お客様番号[' . $zz_yykinfo_kaiin_id . ']';	//内容
				$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else if( $zz_yykinfo_kaiin_kbn == 0 ){
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングをキャンセルしました。（仮登録）<br>予約No[' . sprintf("%05d",$select_yyk_no) . '] 会場[' . $zz_yykinfo_office_nm . '] 日時[' . $zz_yykinfo_ymd . ' ' . intval($zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . "-" . intval($zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . ']<br>スタッフ[' . $zz_yykinfo_yyk_staff_nm . ']';	//内容
				$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
				require( './zs_log.php' );
				//************
			
			}
			
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
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
	
			//「以下の予約を取消しました。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_ok.png" border="0"><br>');

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


			//年月日表示
			if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
				//祝日
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 0 ){
				//日曜
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 6 ){
				//土曜
				$fontcolor = "blue";
			}else{
				//平日
				$fontcolor = "black";
			}
			
			
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
				$bgfile_2 = "yellow";
			}else if( $zz_yykinfo_kaiin_kbn == 1 ){
				//メンバー
				$bgfile_2 = "kimidori";
			}else if( $zz_yykinfo_kaiin_kbn == 9 ){
				//非メンバー（一般）
				$bgfile_2 = "pink";
			}
			
			print('<table border="1">');
			//予約番号／ステータス
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="6" color="gray">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_status.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			print('<font size="4" color="gray">スタッフキャンセル</font>');
			print('</td>');
			print('</tr>');
			
			//日時
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			print('<td colspan="3" align="center" valign="middle" bgcolor="#d3d3d3"><font size="6" color="gray">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="gray">&nbsp;年&nbsp;</font><font size="6" color="gray">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="gray">&nbsp;月&nbsp;</font><font size="6" color="gray">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="gray">&nbsp;日</font>&nbsp;<font size="5" color="gray">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="gray">&nbsp;曜日</font>&nbsp;<font size="6" color="gray">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
			print('</tr>');
			
			//会場／カウンセラー
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="4" color="gray">' . $zz_yykinfo_office_nm . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_staff_nm == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else{
				print('<font size="4" color="gray">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_staff_nm . ')</font>');
			}
			print('</td>');
			print('</tr>');
			
			//お客様番号／氏名
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				print('<font size="5" color="gray">' . $zz_yykinfo_kaiin_id . '</font>');
				if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					print('<br><font size="2" color="gray">(' . $zz_yykinfo_kaiin_mixi . ')</font>');
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
				}
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="middle">');
				if( $zz_yykinfo_kaiin_nm_k != "" ){
					print('<font size="2" color="gray">' . $zz_yykinfo_kaiin_nm_k . '</font><br>');
				}
				print('<font size="4" color="gray">' . $zz_yykinfo_kaiin_nm . '</font>');
				print('</td>');
				print('<td valign="bottom"><font size="2" color="gray">様</font></td>');
				print('</tr>');
				print('</table>');
				
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');

			//興味のある国／出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
//			if( $zz_yykinfo_kyoumi != "" ){
//				print('<font color="gray">' . $zz_yykinfo_kyoumi . '</font>');
//			}else{
//				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
//			if( $zz_yykinfo_jiki != "" ){
//				print('<font color="gray">' . $zz_yykinfo_jiki . '</font>');
//			}else{
//				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('</tr>');

			//相談内容
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td colspan="3" align="left" valign="middle" bgcolor="#d3d3d3">');
			if( $zz_yykinfo_soudan != "" ){
				print('<font color="gray"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
			}else{
				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}
			print('</td>');
			print('</tr>');
			
			//前日メール／当日メール
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_znjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_znz_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_znz_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_znz_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_tjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_tjt_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_tjt_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_tjt_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('</tr>');
			
			//予約日時／キャンセル可能期限
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yyktime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font color="gray">' . $zz_yykinfo_yyk_time . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_canceltime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font color="gray">' . $zz_yykinfo_cancel_time . '</font></td>');
			print('</tr>');

			print('</table>');

			print('<hr>');

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
			
			print('</center>');


		}else if( $err_flg == 5 ){
			//既に予約キャンセルされている

			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
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
	
			//「以下の予約を取消しました。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_ok.png" border="0"><br>');

			//年月日表示
			if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
				//祝日
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 0 ){
				//日曜
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 6 ){
				//土曜
				$fontcolor = "blue";
			}else{
				//平日
				$fontcolor = "black";
			}
			
			
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
				$bgfile_2 = "yellow";
			}else if( $zz_yykinfo_kaiin_kbn == 1 ){
				//メンバー
				$bgfile_2 = "kimidori";
			}else if( $zz_yykinfo_kaiin_kbn == 9 ){
				//非メンバー（一般）
				$bgfile_2 = "pink";
			}
			
			print('<table border="1">');
			//予約番号／ステータス
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="6" color="gray">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_status.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			print('<font size="4" color="gray">スタッフキャンセル</font>');
			print('</td>');
			print('</tr>');
			
			//日時
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			print('<td colspan="3" align="center" valign="middle" bgcolor="#d3d3d3"><font size="6" color="gray">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="gray">&nbsp;年&nbsp;</font><font size="6" color="gray">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="gray">&nbsp;月&nbsp;</font><font size="6" color="gray">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="gray">&nbsp;日</font>&nbsp;<font size="5" color="gray">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="gray">&nbsp;曜日</font>&nbsp;<font size="6" color="gray">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
			print('</tr>');
			
			//会場／カウンセラー
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="4" color="gray">' . $zz_yykinfo_office_nm . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_staff_nm == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else{
				print('<font size="4" color="gray">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_staff_nm . ')</font>');
			}
			print('</td>');
			print('</tr>');
			
			//お客様番号／氏名
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				print('<font size="5" color="gray">' . $zz_yykinfo_kaiin_id . '</font>');
				if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					print('<br><font size="2" color="gray">(' . $zz_yykinfo_kaiin_mixi . ')</font>');
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
				}
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="gray">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="middle">');
				if( $zz_yykinfo_kaiin_nm_k != "" ){
					print('<font size="2" color="gray">' . $zz_yykinfo_kaiin_nm_k . '</font><br>');
				}
				print('<font size="4" color="gray">' . $zz_yykinfo_kaiin_nm . '</font>');
				print('</td>');
				print('<td valign="bottom"><font size="2" color="gray">様</font></td>');
				print('</tr>');
				print('</table>');
				
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');

			//興味のある国／出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
//			if( $zz_yykinfo_kyoumi != "" ){
//				print('<font color="gray">' . $zz_yykinfo_kyoumi . '</font>');
//			}else{
//				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
//			if( $zz_yykinfo_jiki != "" ){
//				print('<font color="gray">' . $zz_yykinfo_jiki . '</font>');
//			}else{
//				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('</tr>');

			//相談内容
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td colspan="3" align="left" valign="middle" bgcolor="#d3d3d3">');
			if( $zz_yykinfo_bikou != "" ){
				print('<font color="gray"><div style="margin: 10px"><pre>' . $zz_yykinfo_bikou . '</pre></div></font>');
			}else{
				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}
			print('</td>');
			print('</tr>');
			
			//前日メール／当日メール
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_znjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_znz_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_znz_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_znz_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_tjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png">');
			if( $zz_yykinfo_tjt_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_tjt_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_tjt_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('</tr>');
			
			//予約日時／キャンセル可能期限
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yyktime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font color="gray">' . $zz_yykinfo_yyk_time . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_canceltime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font color="gray">' . $zz_yykinfo_cancel_time . '</font></td>');
			print('</tr>');

			print('</table>');

			print('<hr>');

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