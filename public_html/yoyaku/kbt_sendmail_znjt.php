<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング　前日メール送信</title>
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kbt_sendmail_znjt.php';

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	//日付関係
	require( '../zz_datetime.php' );

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	//（なし）
	print('個別カウンセリング　前日メール送信バッチ start[' . date( "Y-m-d H:i:s", time() ) . ']<br>');
	flush();
	ob_flush();

	//サーバー接続
	require( './zy_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		//サーバー接続ＮＧ
		$err_flg = 4;
		
		//**ログ出力**
		$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
		$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
		$log_office_cd = '';			//オフィスコード
		$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
		$log_naiyou = 'サーバー接続に失敗しました。前日メール送信を中止しました。';	//内容
		$log_err_inf = 'kbt_sendmail_znjt';	//エラー情報
		require( './zy_log.php' );
		//************
		
	}else{
		//サーバー接続ＯＫ

		//**ログ出力**
		$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
		$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
		$log_office_cd = '';			//オフィスコード
		$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
		$log_naiyou = '<font color=blue>個別カウンセリング 前日メール送信 を開始します。</font>';	//内容
		$log_err_inf = '';	//エラー情報
		require( './zy_log.php' );
		//************

		//翌日の個別カウンセリングを予約している予約番号を取得する
		$yyk_cnt = 0;
		$query = 'select YYK_NO,KAIIN_ID from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and YMD = "' . $ykjt_yyyymmdd . '" and ZNZ_MAIL_SEND_FLG = 0;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
			$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
			$log_err_inf = $query;	//エラー情報
			require( './zy_log.php' );
			//************

		}else{
			while( $row = mysql_fetch_array($result) ){
				$yyk_no[$yyk_cnt] = $row[0];	//予約No
				$kaiin_id[$yyk_cnt] = $row[1];	//会員ID
				$yyk_cnt++;
			}
			
			if( $yyk_cnt > 0 ){
				//管理情報から略称を求める
				$Mkanri_meishou = '';
				$Mkanri_ryakushou = '';
				$Mkanri_hp_adr = '';
				$query = 'select MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
					$log_naiyou = '管理情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zy_log.php' );
					//************
					
				}else{
					$row = mysql_fetch_array($result);
					$Mkanri_meishou = $row[0];			//名称
					$Mkanri_ryakushou = $row[1];		//略称
					$Mkanri_hp_adr = $row[2];			//ホームページアドレス
					$Mkanri_send_mail_adr = $row[3];	//送信メールアドレス
				}
			}
			
		}
		
		//メール送信
		$send_mail_cnt = 0;
		
		if( $err_flg == 0 ){
			
			$m = 0;
			while( $m < $yyk_cnt ){

print('[' . sprintf("%03d",($m + 1)) . ']-yykno[' . $yyk_no[$m] . ']-id[' . $kaiin_id[$m] . ']<br>');
flush();
ob_flush();
			
				//予約内容を読み込む
				$zz_yykinfo_yyk_no = $yyk_no[$m];
				require( '../zz_yykinfo.php' );
				if( $zz_yykinfo_rtncd != 0 ){
					$err_flg = 4;

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
					$log_naiyou = '個別カウンセリング 前日メール送信 が異常終了しました。<br>予約内容の取り込みに失敗しました。予約No[' . sprintf("%05d",$yyk_no[$m]) . ']';	//内容
					$log_err_inf = 'zz_yykinfo_rtncd[' . $zz_yykinfo_rtncd . ']';	//エラー情報
					require( './zy_log.php' );
					//************

				}else{

					//会場（オフィス）の備考を求める
					$Moffice_bikou = "";
					$query = 'select DECODE(BIKOU,"' . $ANGpw . '") from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '"';
					$result = mysql_query($query);
					if (!$result) {
						
						//**ログ出力**
						$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
						$log_naiyou = 'オフィスの参照に失敗しました。';	//内容
						$log_err_inf = $query;	//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						while( $row = mysql_fetch_array($result) ){
							$Moffice_bikou = $row[0];	//オフィスの備考
						}
					}
					
					
					//前日送信フラグを 1:前日メール送信済み に更新する
					$query = 'update D_CLASS_YYK set ZNZ_MAIL_SEND_FLG = 1 where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '" and YMD = "' . $zz_yykinfo_ymd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and YYK_NO = ' . $yyk_no[$m] . ' and KAIIN_ID = "' . $zz_yykinfo_kaiin_id . '"';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
					
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約の更新に失敗しました。';	//内容
						$log_err_inf = $query;	//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						
						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約を更新しました。（前日メール送信フラグ  1:前日メール送信済み）';	//内容
						$log_err_inf = $query;	//エラー情報
						require( './zy_log.php' );
						//************
						
					}
					
					
					//メールアドレスの切り出し＆チェック
					$send_mail_adr_cnt = 0;
					
					if( $zz_yykinfo_bikou != "" ){
						//予約アドレス要求したメールアドレスが設定されている場合は、そのメアドのみに送信する
						$send_kaiin_nm[0] = $zz_yykinfo_kaiin_nm;
						$send_mail_adr[0] = $zz_yykinfo_bikou;
						$send_mail_adr_cnt = 1;
					
					}else{
						//登録されている全メールアドレスに送信する
						$tmp_mail = str_replace(',','<br>',$zz_yykinfo_mailadr );
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
									$send_kaiin_nm[$send_mail_adr_cnt] = $zz_yykinfo_kaiin_nm;
									$send_mail_adr[$send_mail_adr_cnt] = $tmp_mail;
									$send_mail_adr_cnt++;
							
								}else{
									//**ログ出力**
									$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
									$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $zz_yykinfo_kaiin_id . '] メアド[' . $tmp_member_mail_adr . ']';	//内容
									$log_err_inf = '';	//エラー情報
									require( './zy_log.php' );
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
									$send_kaiin_nm[$send_mail_adr_cnt] = $zz_yykinfo_kaiin_nm;
									$send_mail_adr[$send_mail_adr_cnt] = substr($tmp_mail,0,$tmp_mail_pos);
									$send_mail_adr_cnt++;
							
								}else{
									
									//**ログ出力**
									$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
									$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $zz_yykinfo_kaiin_id . '] メアド[' . $chk_mailadr . ']';	//内容
									$log_err_inf = '';	//エラー情報
									require( './zy_log.php' );
									//************
								
								}
										
								$tmp_mail = substr($tmp_mail,($tmp_mail_pos + 4),($tmp_mail_len - ($tmp_mail_pos + 4)));
								$tmp_mail_len = strlen($tmp_mail);
								
							}
						}
					}
					
//##############################################################
//開発テスト時はお客様へメールせず、設定されたメアドに変更する
					if( $SVkankyo == 9 ){
						$send_mail_adr_cnt = $sv_test_cs_mailadr_cnt;
						$z = 0;
						while( $z < $send_mail_adr_cnt ){
							//$send_kaiin_nm[$z] = 'テスト会員';
							$send_mail_adr[$z] = $sv_test_cs_mailadr[$z];
							$z++;
						}
					}
//##############################################################

				}
			
				// 登録完了メールを送信
				$send_mail_flg = 0;
				
				$c = 0;
				while( $c < $send_mail_adr_cnt ){
			
					//登録完了メール送信
					//送信元
					$from_nm = $Mkanri_meishou;
					$from_mail = $Mkanri_send_mail_adr;
					//宛て先
					$to_nm = $send_kaiin_nm[$c] . ' 様';
					
					//メールアドレス
					$to_mail = $send_mail_adr[$c];
				
					//タイトル
					if( $Mkanri_ryakushou != '' ){
						$subject = '(' . $Mkanri_ryakushou . ')';
					}else{
						$subject = '';	
					}
					$subject .= '個別カウンセリングのお知らせ(前日送信)';
			
					// 本文
					$content = $send_kaiin_nm[$c] . " 様\n\n";
					$content .= $Mkanri_meishou . "です。\n";
					$content .= "当協会の個別カウンセリングの予約が\n";
					$content .= "明日となりましたのでお知らせします。\n\n";
					$content .= "---------------\n";
					$content .= "▼予約内容\n";
					$content .= "---------------\n";
					$content .= "個別カウンセリング\n\n";
					$content .= "予約No: " . sprintf("%05d",$yyk_no[$m]) . "\n";
					$content .= "会場: " . $zz_yykinfo_office_nm . "\n";
					$content .= "日付: " . substr($zz_yykinfo_ymd,0,4) . "年" . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . "月" . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . "日(" . $week[$zz_yykinfo_youbi_cd] . ")\n";
					$content .= "時間: " . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . " - " . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) ."\n\n";
					$content .= "※日時の変更および予約取消の場合は必ずご連絡ください。\n";
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
				
					$c++;

					$send_mail_flg = 1;

				}
			
				if( $send_mail_flg == 1 ){
					$send_mail_cnt++;
				}
			
				$m++;
			}
		}


		if( $err_flg == 0 ){
			
			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = 'batch';		//会員番号 または スタッフコード
			$log_naiyou = '<font color=blue>個別カウンセリング 前日メール送信 を終了しました。</font><br>対象メンバー数[' . $yyk_cnt . ']件　送信メンバー数[' . $send_mail_cnt . ']件';	//内容
			$log_err_inf = '';	//エラー情報
			require( './zy_log.php' );
			//************
		
		}

	}

	mysql_close( $link );
	
print('個別カウンセリング　前日メール送信バッチ end[' . date( "Y-m-d H:i:s", time() ) . ']<br>');


	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>
</body>
</html>