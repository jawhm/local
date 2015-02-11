<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->frontpage=false;

$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->add_js_files = '
<script src="https://www.google.com/jsapi?key=ABQIAAAA1GaXyTxfx_EDrRX444NPQhQ3fj4XOcTTnvyZdGafpHojXl1fMRSD3wXKQgd9LOOX8nS2J9CjTLfu7A" type="text/javascript"></script>
<script src="../js/top.js" type="text/javascript"></script>
';

$header_obj->pcredirect='/';
$header_obj->fncMenuHead_h1text = '日本ワーキング・ホリデー協会';
$header_obj->fncMenubar_advertisement='';
$header_obj->display_header();

?>
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'M-kbt_counseling_select_res.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('M-kbt_counseling_select_kkn.php','M-kbt_counseling_select_res.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$yykkey_ang_str = $_POST['yykkey_ang_str'];
	$kaiin_id = $_POST['kaiin_id'];
	$kaiin_nm = $_POST['kaiin_nm'];
	$kaiin_kbn = $_POST['kaiin_kbn'];
	$select_office_cd = $_POST['select_office_cd'];
	$select_staff_cd = $_POST['select_staff_cd'];		//未入力OK
	$select_ymd = $_POST['select_ymd'];
	$select_jknkbn = $_POST['select_jknkbn'];
	//日時変更時のみ
	$select_yyk_no = $_POST['select_yyk_no'];
	
	//ユーザーエージェントチェック
	require( './zm_uachk.php' );
	
	//サーバー接続
	require( './zm_svconnect.php' );

	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" || $select_ymd == "" || $select_jknkbn == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( '../yoyaku/zy_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				}
			}
		}
	}

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zm_errgmn.php' );
		
	}else{

		//ページ編集
		//ユーザーエージェント
		require( '../yoyaku/zy_uachk.php' );

		//画像事前読み込み
		if( !($mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W') ){
			//スマホのみ
			print('<center>');
			print('<table border="0">');
			print('<tr>');
			print('<td width="185" align="left">');
			print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
			print('</td>');
			//メニューへ戻るボタン
			print('<td width="135" align="right" valign="middle">');
			if( $mobile_kbn == 'I' ){
				//iPhoneのみ
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
			}else{
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
			}
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_menu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_menu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_menu_1.png\';" border="0">');
			print('</form>');
			print('</td>');
			print('</tr>');
			print('</table>');
			print('</center>');
			
		}

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));


		//固有引数の取得
		$kyoumi = $_POST['kyoumi'];
		$jiki = $_POST['jiki'];
		$soudan = $_POST['soudan'];

		//エラーチェック
		$err_cnt = 0;
		$data_cnt = 0;
		
		//興味のある国
		$err_kyoumi = 0;
		//禁止文字を全角化
//		$kyoumi = str_replace("'","’",$kyoumi );
//		$kyoumi = str_replace('"','”',$kyoumi );
//		$kyoumi = str_replace('$','＄',$kyoumi );
//		if( $kyoumi == "" ){
//			$err_cnt++;
//			$err_kyoumi = 1;
//		}
		//出発予定時期
		$err_jiki = 0;
		//禁止文字を全角化
//		$jiki = str_replace("'","’",$jiki );
//		$jiki = str_replace('"','”',$jiki );
//		$jiki = str_replace('$','＄',$jiki );
//		if( $jiki == "" ){
//			$err_cnt++;
//			$err_jiki = 1;
//		}
		//相談内容
		$err_soudan = 0;
		//禁止文字を全角化
		$soudan = str_replace("'","’",$soudan );
		$soudan = str_replace('"','”',$soudan );
		$soudan = str_replace('$','＄',$soudan );
		if( $soudan == "" ){
			$err_cnt++;
			$err_soudan = 1;
		}


		if( $select_yyk_no != "" ){
			//更新前の状況把握のため、最初に処理する
			
			//予約内容を取得する
			$zz_yykinfo_yyk_no = $select_yyk_no;
			require( '../zz_yykinfo.php' );
			if( $zz_yykinfo_rtncd == 1 ){
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zm_log.php' );
				//************
				
			}else if( $zz_yykinfo_rtncd == 8 ){
				//予約が無い
				if( $err_flg == 0 ){
					$err_flg = 9;
				}
				
			}
			
		}else{
			//新規登録時
			
			//二重登録防止チェック(F5対応)
			$tmp_nijyu_cnt = 0;
			$tmp_nijyu_yyk_no = "";
			
			$query = 'select YYK_NO from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '" and KAIIN_ID = "' . $kaiin_id . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
				$log_err_inf = $query;	//エラー情報
				require( './zm_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$tmp_nijyu_yyk_no = $row[0];	//予約済みの予約番号
					$tmp_nijyu_cnt++;
				}
					
				if( $tmp_nijyu_cnt > 0 ){
					//既に登録されている
					if( $err_flg == 0 ){
						$err_flg = 6;
					}

					//予約内容を取得する
					$zz_yykinfo_yyk_no = $tmp_nijyu_yyk_no;
					require( '../zz_yykinfo.php' );
					if( $zz_yykinfo_rtncd == 1 ){
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zm_errgmn.php' );
						
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
						$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
						require( './zm_log.php' );
						//************
					
					}
					
//					//**ログ出力**
//					$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//					$log_office_cd = '';			//オフィスコード
//					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
//					$log_naiyou = '二重登録の可能性があります。通常画面（予約しました）を表示しました。';	//内容
//					$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
//					require( './zm_log.php' );
//					//************
					
				}
			}
		}
		
		if( $err_flg == 0 && $err_cnt == 0 ){
			//顧客情報を参照する
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $kaiin_id
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
						$name = "data_yotei_" . $i;
						$data_kaiin_kyoumi[$data_cnt] = $ret[$name];		//予定国（興味のある国に設定）
						$name = "data_bikou_" . $i;
						$data_kaiin_bikou[$data_cnt] = $ret[$name];			//基本情報メモ（備考）
						$name = "data_mail_" . $i;
						$tmp_mail = $ret[$name];			//会員メールアドレス
						$tmp_mail = str_replace(',','<br>',$tmp_mail );
						$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
						$name = "data_tel_" . $i;
						$tmp_tel = $ret[$name];			//会員電話番号
					
//						$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
						$data_kaiin_tel[$data_cnt] = $tmp_tel;
						$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
							
						//会員名カナの調整
						if( $data_kaiin_nm_k[$data_cnt] == "　" ){
							$data_kaiin_nm_k[$data_cnt] = "";	
						}
							
//						//電話番号調整
//						list($tmp_tel_1,$tmp_tel_2) = split('[,]',$tmp_tel);
//						$data_kaiin_tel[$$data_cnt] = $tmp_tel_1;			//電話番号１
//						$data_kaiin_tel_keitai[$$data_cnt] = $tmp_tel_2;	//電話番号２
				
						//会員区分の判定
//						$data_kaiin_mixi[$i] = strtoupper($data_kaiin_mixi[$i]);	//小文字を大文字に変換する
//						$tmp_pos = strpos($data_kaiin_mixi[$i],"JW");
//						if( $tmp_pos !== false ){
//							//有料メンバー
//							$data_kaiin_kbn[$i] = 1;	//会員区分  0:仮登録　1:有料メンバー　9:無料メンバー
//						}else{
//							//無料メンバー
//							$data_kaiin_kbn[$i] = 9;	//会員区分  0:仮登録　1:有料メンバー　9:無料メンバー
//						}
						
						//会員名を姓名に分ける
						$data_kaiin_nm_1[$data_cnt] = "";
						$data_kaiin_nm_2[$data_cnt] = "";
						$tmp_pos = strpos($data_kaiin_nm[$data_cnt],"　");
						if( $tmp_pos !== false ){
							$data_kaiin_nm_1[$data_cnt] = substr($data_kaiin_nm[$data_cnt],0,$tmp_pos);
							$data_kaiin_nm_2[$data_cnt] = substr($data_kaiin_nm[$data_cnt],($tmp_pos+2), (strlen($data_kaiin_nm[$data_cnt]) - $tmp_pos - 2) );
						}else{
							$data_kaiin_nm_1[$data_cnt] = $data_kaiin_nm[$data_cnt];
						}
						
						//会員名フリガナをセイメイに分ける
						$data_kaiin_nm_k_1[$data_cnt] = "";
						$data_kaiin_nm_k_2[$data_cnt] = "";
						$tmp_pos = strpos($data_kaiin_nm_k[$data_cnt],"　");
						if( $tmp_pos !== false ){
							$data_kaiin_nm_1_k[$data_cnt] = substr($data_kaiin_nm_k[$data_cnt],0,$tmp_pos);
							$data_kaiin_nm_2_k[$data_cnt] = substr($data_kaiin_nm_k[$data_cnt],($tmp_pos+2), (strlen($data_kaiin_nm_k[$data_cnt]) - $tmp_pos - 2) );
						}else{
							$data_kaiin_nm_1_K[$data_cnt] = $data_kaiin_nm_k[$data_cnt];
						}
					
						$i++;								
						$data_cnt++;
					}
					
				}else{
					//会員IDが見つからない	
					if( $err_flg == 0 ){
						$err_flg = 10;
					}
					
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = '会員情報が取得できなかった。err01';	//内容
					$log_err_inf = '';			//エラー情報
					require( './zm_log.php' );
					//************
					
				}
						
			}else{
				// NG	
				if( $err_flg == 0 ){
					$err_flg = 10;
				}
					
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '会員情報が取得できなかった。err02';	//内容
				$log_err_inf = '';			//エラー情報
				require( './zm_log.php' );
				//************
					
			}
		}


		//選択した会場（オフィス）を取得する
		$Moffice_cnt = 0;
		$query = 'select OFFICE_NM,CANCEL_YK_JKN,CANCEL_MK_KKN,START_YOUBI,DECODE(BIKOU,"' . $ANGpw . '") from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			
			//エラーメッセージ表示
			require( './zm_errgmn.php' );

			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zm_log.php' );
			//************

		}else{
			while( $row = mysql_fetch_array($result) ){
				$Moffice_office_nm = $row[0];		//オフィス名
				$Moffice_cancel_yk_jkn_dd = intval($row[1] / 24);	//キャンセル有効時間（日）
				$Moffice_cancel_yk_jkn_hh = $row[1] % 24;			//キャンセル有効時間（時）
				$Moffice_cancel_mk_kkn = $row[2];					//キャンセル無効期間（日）
				$Moffice_start_youbi = $row[3];						//開始曜日（ 0:日曜始まり 1:月曜始まり ）
				$Moffice_bikou = $row[4];							//備考
	
				//オフィスを会場に置換する
				$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );
				
				$Moffice_cnt++;
			
			}
		}

		//カウンセラー指名がある場合、公開スタッフ名を求める
		$Mstaff_cnt = 0;
		$Mstaff_staff_nm = '';
		$Mstaff_open_staff_nm = '(指名なし)';
		if( $select_staff_cd != "" ){
			$query = 'select DECODE(STAFF_NM,"' . $ANGpw. '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw. '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $select_staff_cd . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zy_errgmn.php' );
			
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zy_log.php' );
				//************
	
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Mstaff_staff_nm = $row[0];			//スタッフ名
					$Mstaff_open_staff_nm = $row[1];	//公開スタッフ名
					$Mstaff_cnt++;
				}
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
				require( './zm_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
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
				require( './zm_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '営業時間個別の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
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
			require( './zm_errgmn.php' );
				
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zm_log.php' );
			//************
					
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Mclass_st_time = $row[0];	//開始時刻
				$Mclass_ed_time = $row[1];	//終了時刻
			}

			//過去時間チェック
			if( $select_ymd < $now_yyyymmdd ||
			   ( $select_ymd == $now_yyyymmdd && $Mclass_st_time <= (($now_hh * 100) + $now_ii) )  ){
				//開始時刻が過去時間
				if( $err_flg == 0 ){
					$err_flg = 8;	//過去日時を選択
				}
			}

		}


		//会員の明日以降の予約数をチェックする
		if( $select_yyk_no == "" ){
			//新規登録時のみチェック対象とする
			$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and CLASS_CD = "KBT" and YMD > "' . $now_yyyymmdd . '" and KAIIN_ID = "' . $kaiin_id . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
					
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
				//************
						
			}else{
				$row = mysql_fetch_array($result);
				if( $row[0] > 0 ){
					//明日以降の予約がある（明日以降は１件のみなのでエラー）
					if( $err_flg == 0 ){
						$err_flg = 7;	//予約数オーバー
					}
					
				}else{
					//本日の予約数をチェックする
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and CLASS_CD = "KBT" and YMD = "' . $now_yyyymmdd . '" and KAIIN_ID = "' . $kaiin_id . '";';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zm_errgmn.php' );
							
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zm_log.php' );
						//************
								
					}else{
						$row = mysql_fetch_array($result);
						if( $row[0] >= 2 ){
							//本日の予約は２件まで
							if( $err_flg == 0 ){
								$err_flg = 7;	//予約数オーバー
							}
						}
					}
				}
			}
		}
	

		$login_mail_adr = "";
		if( $err_flg == 0 && $err_cnt == 0 ){
			//ログインキー発行に存在する場合はログインキー取得時のメアドのみとする
			$query = 'select DECODE(LOGIN_MAIL_ADR,"' . $ANGpw . '") from D_LOGIN_KEY where KG_CD = "' . $DEF_kg_cd . '" and LOGIN_KEY = "' . $yykkey_ang_str . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
						
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'ログインキー発行の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$login_mail_adr = $row[0];
				}
			}
		}


		if( $err_flg == 0 && $err_cnt == 0 ){
			//エラーなし

			//空きチェック
			//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する（全員分）
			$tmp_yyk_cnt = 0;
			$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
					
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
				//************
								
			}else{
				while( $row = mysql_fetch_array($result) ){
					$tmp_yyk_cnt = $row[0];		//現在予約数
				}
			}
			
			//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する（全員分）
			$tmp_uktk_ninzu = '';
			$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );
					
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
				//************
						
			}else{
				while( $row = mysql_fetch_array($result) ){
					$tmp_uktk_ninzu = $row[0];	//受付人数
				}
			}
			
			//カウンセラー指名の場合
			$tmp_shimei_flg = 0;
			if( $select_staff_cd != "" ){
				$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '" and STAFF_CD = "' . $select_staff_cd . '";';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zy_errgmn.php' );
						
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zy_log.php' );
					//************
									
				}else{
					while( $row = mysql_fetch_array($result) ){
						if( $row[0] > 0 ){
							$tmp_shimei_flg = 1;
						}
					}
				}
				
				//受付可能かチェックする
				$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and STAFF_CD = "' . $select_staff_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zy_errgmn.php' );
						
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zy_log.php' );
					//************
							
				}else{
					while( $row = mysql_fetch_array($result) ){
						if( $row[0] == 0 ){
							$tmp_shimei_flg = 1;	//受付可能では無くなった。（満席扱いとする）
						}
					}
				}
			}			

			if( $tmp_yyk_cnt >= $tmp_uktk_ninzu || $tmp_shimei_flg == 1 ){
				//満室になってしまった
				if( $err_flg == 0 ){
					$err_flg = 5;
				}
				
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
		
				
				if( $select_yyk_no == "" ){
					//新規登録時
					
					//まず予約番号を確定する
					$yyk_no = 0;
					$query = 'select MAX_YYK_NO from M_YYK_NO where KG_CD = "' . $DEF_kg_cd . '";';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zm_errgmn.php' );
							
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = '予約番号の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zm_log.php' );
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
							require( './zm_errgmn.php' );
								
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = '予約番号の更新に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zm_log.php' );
							//************
		
						}else{
			
							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = '予約番号を更新しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zm_log.php' );
							//************
	
							//文字コード設定（insert/update時に必須）
							require( '../zz_mojicd.php' );
	
							//クラス予約（個別カウンセリング）を登録する
							$query = 'insert into D_CLASS_YYK values("' . $DEF_kg_cd . '","' . $select_office_cd . '","KBT","' . $select_ymd . '","' . $select_jknkbn . '",' . $yyk_no . ',' . $kaiin_kbn . ',"' . $kaiin_id . '",ENCODE("' . $data_kaiin_nm[0] . '","' . $ANGpw . '"),';
							if( $data_kaiin_mixi[0] != "" ){
								$query .= '"' . $data_kaiin_mixi[0] . '",';
							}else{
								$query .= 'NULL,';
							}
							if( $select_staff_cd != "" ){
								$query .= '"' . $select_staff_cd . '",';
							}else{
								$query .= 'NULL,';
							}
							$query .= '0,';
							if( $kyoumi != "" ){
								$query .= 'ENCODE("' . $kyoumi . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $jiki != "" ){
								$query .= 'ENCODE("' . $jiki . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $soudan != "" ){
								$query .= 'ENCODE("' . $soudan . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $login_mail_adr != "" ){
								$query .= 'ENCODE("' . $login_mail_adr . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							$query .= '0,0,"' . $now_time. '","' . $cancel_ymdhis . '",NULL);';
							$result = mysql_query($query);
							if (!$result) {
								//ＤＢエラー
								
								//登録されている予約番号を求め、内容を取得する
								$tmp_nijyu_cnt = 0;
								$tmp_nijyu_yyk_no = "";
								
								$query = 'select YYK_NO from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '" and KAIIN_ID = "' . $kaiin_id . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zm_errgmn.php' );
				
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
									$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
									$log_err_inf = $query;	//エラー情報
									require( './zm_log.php' );
									//************
								
								}else{
									while( $row = mysql_fetch_array($result) ){
										$tmp_nijyu_yyk_no = $row[0];	//予約済みの予約番号
										$tmp_nijyu_cnt++;
									}
								
									if( $tmp_nijyu_cnt > 0 ){
										//既に登録されている
										if( $err_flg == 0 ){
											$err_flg = 6;
										}

										//予約内容を取得する
										$zz_yykinfo_yyk_no = $tmp_nijyu_yyk_no;
										require( '../zz_yykinfo.php' );
										if( $zz_yykinfo_rtncd == 1 ){
											$err_flg = 4;
											//エラーメッセージ表示
											require( './zm_errgmn.php' );
											
											//**ログ出力**
											$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
											$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
											$log_office_cd = '';			//オフィスコード
											$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
											$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
											$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
											require( './zm_log.php' );
											//************
										
										}
									}
								}

								if( $err_flg == 0 ){
									$err_flg = 4;
								}

//								//**ログ出力**
//								$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//								$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//								$log_office_cd = '';			//オフィスコード
//								$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
//								$log_naiyou = '二重登録の可能性があります。通常画面（予約しました）を表示しました。';	//内容
//								$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
//								require( './zm_log.php' );
//								//************
	
							}else{
				
								//**トランザクション出力**
								$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = '';			//オフィスコード
								$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
								$log_naiyou = 'クラス予約を登録しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zm_log.php' );
								//************
							
							
								//*** googleカレンダーへの登録 ***
								//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
								$yoyakudate = substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';
		
								// カレンダー登録
								//$yoyakumsg = "興味のある国：" .$kyoumi . "\n出発予定時期：" . $jiki . "\n" . $soudan;
								$yoyakumsg = $soudan;
								
								$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
								$data = array(
									'kbn'	=> 1,
									'id'	=> $kaiin_id,
									'place' => $Moffice_office_nm,
									'yoyakudate' => $yoyakudate,
									'tantou' => $Mstaff_staff_nm,
									'yoyakumsg' => $yoyakumsg,
									'namae1' 	=> $data_kaiin_nm_1[0],
									'namae2' 	=> $data_kaiin_nm_2[0],
									'firigana1' => $data_kaiin_nm_k_1[0],
									'firigana2' => $data_kaiin_nm_k_2[0],
									'tel'	=> "",
									'email' => ""
								);
				
								$options = array('http' => array(
												'method' => 'POST',
												'content' => http_build_query($data),
											));
								$contents = file_get_contents($url, false, stream_context_create($options));
								$ret = json_decode($contents, true);
								if ($ret['result'] != 'OK')	{
									//登録失敗
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zm_errgmn.php' );
										
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
									$log_naiyou = 'googleカレンダーの登録に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
									$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $kaiin_id . ']';			//エラー情報
									require( './zm_log.php' );
									//************
				
								}
							}
						}
					}
					
				}else{
					//日時更新時	
					$yyk_no = $select_yyk_no;
					
					//最初に新しい日時で登録する
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
	
					//クラス予約（個別カウンセリング）を登録する
					$query = 'insert into D_CLASS_YYK values("' . $DEF_kg_cd . '","' . $select_office_cd . '","KBT","' . $select_ymd . '","' . $select_jknkbn . '",' . $select_yyk_no . ',' . $zz_yykinfo_kaiin_kbn . ',';
					$query .= '"' . $zz_yykinfo_kaiin_id . '",ENCODE("' . $zz_yykinfo_kaiin_nm . '","' . $ANGpw . '"),';
					if( $zz_yykinfo_kaiin_kbn == 1 && $zz_yykinfo_kaiin_mixi != "" ){
						$query .= '"' . $zz_yykinfo_kaiin_mixi . '",';
					}else{
						$query .= 'NULL,';
					}
					if( $zz_yykinfo_staff_cd != "" ){
						$query .= '"' . $zz_yykinfo_staff_cd . '",';
					}else{
						$query .= 'NULL,';
					}
					$query .= '0,';
					if( $kyoumi != "" ){
						$query .= 'ENCODE("' . $kyoumi . '","' . $ANGpw . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
					}
					if( $jiki != "" ){
						$query .= 'ENCODE("' . $jiki . '","' . $ANGpw . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
					}
					if( $soudan != "" ){
						$query .= 'ENCODE("' . $soudan . '","' . $ANGpw . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
					}
					if( $login_mail_adr != "" ){
						$query .= 'ENCODE("' . $login_mail_adr . '","' . $ANGpw . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
					}
					$query .= '0,0,"' . $now_time. '","' . $cancel_ymdhis . '",NULL);';
					$result = mysql_query($query);
					if (!$result) {
						//既に予約済み
						
						//登録されている予約番号を求め、内容を取得する
						$tmp_nijyu_cnt = 0;
						$tmp_nijyu_yyk_no = "";
								
						$query = 'select YYK_NO from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jknkbn . '" and KAIIN_ID = "' . $kaiin_id . '";';
						$result = mysql_query($query);
						if (!$result) {
							$err_flg = 4;
							//エラーメッセージ表示
							require( './zm_errgmn.php' );
		
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
							$log_err_inf = $query;	//エラー情報
							require( './zm_log.php' );
							//************
						
						}else{
							while( $row = mysql_fetch_array($result) ){
								$tmp_nijyu_yyk_no = $row[0];	//予約済みの予約番号
								$tmp_nijyu_cnt++;
							}
						
							if( $tmp_nijyu_cnt > 0 ){
								//既に登録されている
								if( $err_flg == 0 ){
									$err_flg = 6;
								}
								
								//予約内容を取得する
								$zz_yykinfo_yyk_no = $tmp_nijyu_yyk_no;
								require( '../zz_yykinfo.php' );
								if( $zz_yykinfo_rtncd == 1 ){
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zm_errgmn.php' );
									
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
									$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
									$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
									require( './zm_log.php' );
									//************
								
								}
							}
						}
					
						if( $err_flg == 0 ){
							$err_flg = 4;
						}

//						//**ログ出力**
//						$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
//						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
//						$log_office_cd = '';			//オフィスコード
//						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
//						$log_naiyou = '二重登録の可能性があります。通常画面（予約しました）を表示しました。';	//内容
//						$log_err_inf = '予約番号[' . $tmp_nijyu_yyk_no . ']';	//エラー情報
//						require( './zm_log.php' );
//						//************

					}else{
		
						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';	//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'クラス予約を登録しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zm_log.php' );
						//************

						//*** googleカレンダーへの登録 ***
						//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
						$yoyakudate = substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . ':00';

						// カレンダー登録
						//$yoyakumsg = "興味のある国：" .$kyoumi . "\n出発予定時期：" . $jiki . "\n" . $soudan;
						$yoyakumsg = $soudan;
						
						$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
						$data = array(
							'kbn'	=> 1,
							'id'	=> $zz_yykinfo_kaiin_id,
							'place' => $zz_yykinfo_office_nm,
							'yoyakudate' => $yoyakudate,
							'tantou' => $Mstaff_staff_nm,
							'yoyakumsg' => $yoyakumsg,
							'namae1' 	=> $zz_yykinfo_kaiin_nm_1,
							'namae2' 	=> $zz_yykinfo_kaiin_nm_2,
							'firigana1' => $zz_yykinfo_kaiin_nm_k_1,
							'firigana2' => $zz_yykinfo_kaiin_nm_k_2,
							'tel'	=> '',
							'email' => ''
						);
		
						$options = array('http' => array(
										'method' => 'POST',
										'content' => http_build_query($data),
									));
						$contents = file_get_contents($url, false, stream_context_create($options));
						$ret = json_decode($contents, true);
						if ($ret['result'] != 'OK')	{
							//登録失敗
							$err_flg = 4;
							//エラーメッセージ表示
							require( './zm_errgmn.php' );
							
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'googleカレンダーへの登録に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
							$log_err_inf = '会場[' . $select_office_cd . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $select_kaiin_no . ']';			//エラー情報
							require( './zm_log.php' );
							//************
											
						}else{
							
							//文字コード設定（insert/update時に必須）
							require( '../zz_mojicd.php' );
							
							//変更前のクラス予約をクラス予約キャンセルへ登録する
							$query = 'insert into D_CLASS_YYK_CAN values("' . $DEF_kg_cd . '","' . $zz_yykinfo_office_cd . '","' . $zz_yykinfo_class_cd . '","' . $zz_yykinfo_ymd . '","' . $zz_yykinfo_jkn_kbn . '",' . $select_yyk_no . ',' . $zz_yykinfo_kaiin_kbn . ',';
							$query .= '"' . $zz_yykinfo_kaiin_id . '",ENCODE("' . $zz_yykinfo_kaiin_nm . '","' . $ANGpw . '"),';
							if( $zz_yykinfo_kaiin_mixi != "" ){
								$query .= '"' . $zz_yykinfo_kaiin_mixi . '",';
							}else{
								$query .= 'NULL,';
							}
							if( $zz_yykinfo_staff_cd != "" ){
								$query .= '"' . $zz_yykinfo_staff_cd . '",';
							}else{
								$query .= 'NULL,';
							}
							$query .= '7,';
							if( $zz_yykinfo_kyoumi != "" ){
								$query .= 'ENCODE("' . $zz_yykinfo_kyoumi . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $zz_yykinfo_jiki != "" ){
								$query .= 'ENCODE("' . $zz_yykinfo_jiki . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $zz_yykinfo_soudan != "" ){
								$query .= 'ENCODE("' . $zz_yykinfo_soudan . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							if( $zz_yykinfo_bikou != "" ){
								$query .= 'ENCODE("' . $zz_yykinfo_bikou . '","' . $ANGpw . '"),';
							}else{
								$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
							}
							$query .= $zz_yykinfo_znz_mail_send_flg . ',' . $zz_yykinfo_tjt_mail_send_flg . ',"' . $zz_yykinfo_yyk_time. '","' . $zz_yykinfo_cancel_time . '","' . $now_time . '",';
							if( $zz_yykinfo_yyk_staff_cd != "" ){
								$query .= '"' . $zz_yykinfo_yyk_staff_cd . '",';
							}else{
								$query .= 'NULL,';
							}
							$query .= 'NULL);';
							$result = mysql_query($query);
							if (!$result) {
								//登録失敗
								$err_flg = 4;
								//エラーメッセージ表示
								require( './zm_errgmn.php' );
								
								//**ログ出力**
								$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
								$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = '';			//オフィスコード
								$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
								$log_naiyou = 'クラス予約キャンセルへの登録に失敗しました。';	//内容
								$log_err_inf = $query;			//エラー情報
								require( './zm_log.php' );
								//************
							
							}else{
							
								//変更前のクラス予約を削除する
								$query = 'delete from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $zz_yykinfo_ymd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and YYK_NO = ' . $select_yyk_no . ' and KAIIN_ID = "' . $zz_yykinfo_kaiin_id . '";';
								$result = mysql_query($query);
								if (!$result) {
									$err_flg = 4;
									//エラーメッセージ表示
									require( './zm_errgmn.php' );
									
									//**ログ出力**
									$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
									$log_naiyou = 'クラス予約の削除に失敗しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zm_log.php' );
									//************
									
								}else{

									//**トランザクション出力**
									$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
									$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
									$log_office_cd = '';			//オフィスコード
									$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
									$log_naiyou = 'クラス予約を削除しました。';	//内容
									$log_err_inf = $query;			//エラー情報
									require( './zm_log.php' );
									//************

									//*** googleカレンダーから削除する ***
									//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
									$yoyakudate = substr($zz_yykinfo_ymd,0,4) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . ' ' . sprintf("%02d",intval($zz_yykinfo_st_time / 100)) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . ':00';
			
									// カレンダー削除
									$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
									$data = array(
										'kbn'	=> 2,
										'id'	=> $zz_yykinfo_kaiin_id,
										'place' => $zz_yykinfo_office_nm,
										'yoyakudate' => $yoyakudate,
										'tantou' 	=> "",
										'yoyakumsg' => "",
										'namae1' 	=> "",
										'namae2' 	=> "",
										'firigana1' => "",
										'firigana2' => "",
										'tel'	=> "",
										'email' => ""
									);
									$options = array('http' => array(
													'method' => 'POST',
													'content' => http_build_query($data),
												));
									$contents = file_get_contents($url, false, stream_context_create($options));
									$ret = json_decode($contents, true);
									if ($ret['result'] != 'OK')	{
										//削除失敗
										$err_flg = 4;
										//エラーメッセージ表示
										require( './zm_errgmn.php' );
										
										//**ログ出力**
										$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
										$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
										$log_office_cd = '';			//オフィスコード
										$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
										$log_naiyou = 'googleカレンダーの削除に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
										$log_err_inf = '会場[' . $zz_yykinfo_office_cd . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $zz_yykinfo_kaiin_id . ']';			//エラー情報
										require( './zm_log.php' );
										//************
										
									}
								}
							}
						}
					}
				}
			}
		}


		//メール送信
		$send_mail_flg = 0;
		if( $err_flg == 0 && $err_cnt == 0 && $data_kaiin_mail[0] != "" ){
			//エラーなし
			
			//処理時点以降の時間帯であればメール送信する
			if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclass_st_time >= ($now_hh * 100 + $now_ii) ) ){
				//管理情報から略称を求める
				$Mkanri_meishou = '';
				$Mkanri_ryakushou = '';
				$Mkanri_hp_adr = '';
				$query = 'select MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zm_errgmn.php' );
							
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = '管理情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zm_log.php' );
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
				
				if( $login_mail_adr != "" ){
					//ログインキー取得時のメアドが存在する場合
					$send_mail_adr[0] = $login_mail_adr;
					$send_mail_adr_cnt = 1;
				
				}else{
					//無かった（ログイン画面から予約した場合）
				
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
								$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = '';			//オフィスコード
								$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
								$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $kaiin_id . '] メアド[' . $tmp_member_mail_adr . ']';	//内容
								$log_err_inf = '';			//エラー情報
								require( './zm_log.php' );
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
								$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
								$log_office_cd = '';			//オフィスコード
								$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
								$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $kaiin_id . '] メアド[' . $chk_mailadr . ']';	//内容
								$log_err_inf = '';			//エラー情報
								require( './zm_log.php' );
								//************
	
							}
							
							$tmp_member_mail_adr = substr($tmp_member_mail_adr,($tmp_mail_pos + 4),($tmp_mail_len - ($tmp_mail_pos + 4)));
							$tmp_mail_len = strlen($tmp_member_mail_adr);
						}
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
					
					if( $select_yyk_no == "" ){
						//新規登録時
				
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
						$content .= "予約No: " . sprintf("%05d",$yyk_no) . "\n";
						$content .= "会場: " . $Moffice_office_nm . "\n";
						$content .= "日付: " . substr($select_ymd,0,4) . "年" . sprintf("%d",substr($select_ymd,4,2)) . "月" . sprintf("%d",substr($select_ymd,6,2)) . "日(" . $week[$select_youbi_cd] . ")\n";
						$content .= "時間: " . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . " - " . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) ."\n";
						if( $select_staff_cd != "" ){
							$content .= "担当: " . $Mstaff_open_staff_nm . "\n";
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
						
					}else{
						//日時変更時
						
						//タイトル
						if( $Mkanri_ryakushou != '' ){
							$subject = '(' . $Mkanri_ryakushou . ')';
						}else{
							$subject = '';	
						}
						$subject .= '個別カウンセリング予約の日時変更を受け付けました';
			
						// 本文
						$content = $data_kaiin_nm[0] . " 様\n\n";
						$content .= $Mkanri_meishou . "です。\n";
						$content .= "この度は、当協会の個別カウンセリングの予約について\n";
						$content .= "以下の日時への変更を受け付けましたのでお知らせします。\n\n";
						$content .= "---------------\n";
						$content .= "▼予約内容\n";
						$content .= "---------------\n";
						$content .= "個別カウンセリング\n\n";
						$content .= "予約No: " . sprintf("%05d",$select_yyk_no) . "\n";
						$content .= "*** 変更前 ***\n";
						$content .= "会場: " . $zz_yykinfo_office_nm . "\n";
						$content .= "日付: " . substr($zz_yykinfo_ymd,0,4) . "年" . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . "月" . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . "日(" . $week[$zz_yykinfo_youbi_cd] . ")\n";
						$content .= "時間: " . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . " - " . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) ."\n";
						if( $zz_yykinfo_staff_cd != "" ){
							$content .= "担当: " . $zz_yykinfo_open_staff_nm . "\n";
						}
						$content .= "\n";
						$content .= "*** 変更後 ***\n";
						$content .= "会場: " . $Moffice_office_nm . "\n";
						$content .= "日付: " . substr($select_ymd,0,4) . "年" . sprintf("%d",substr($select_ymd,4,2)) . "月" . sprintf("%d",substr($select_ymd,6,2)) . "日(" . $week[$select_youbi_cd] . ")\n";
						$content .= "時間: " . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . " - " . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) ."\n";
						if( $zz_yykinfo_staff_cd != "" ){
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
						
					}
					   
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
		

		if( $err_flg == 0 && $err_cnt == 0 ){
			//エラーなし
			
			if( $select_yyk_no == "" ){
				//新規登録時
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングを予約しました。<br>予約No[' . sprintf("%05d",$yyk_no) . '] 会場[' . $Moffice_office_nm . '] 日時[' . substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '-' . sprintf("%02d",intval($Mclass_ed_time / 100)) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . ']';
				if( $select_staff_cd != "" ){
					$log_naiyou .= ' 指名[' . $Mstaff_open_staff_nm . ']';
				}
				$log_naiyou .= '<br>お客様番号[' . $kaiin_id . '] ';	//内容
				$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
				require( './zm_log.php' );
				//************
				
			}else{
				//日時変更時
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングを変更しました。<br>予約No[' . sprintf("%05d",$yyk_no) . '] ';
				$log_naiyou .= '会場[' . $Moffice_office_nm . '] 日時[' . substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '-' . sprintf("%02d",intval($Mclass_ed_time / 100)) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . ']';
				if( $zz_yykinfo_staff_cd != "" ){
					$log_naiyou .= ' 指名[' . $zz_yykinfo_open_staff_nm . ']';
				}
				$log_naiyou .= '<br>お客様番号[' . $kaiin_id . '] ';	//内容
				$log_err_inf = '変更前：会場[' . $Moffice_office_nm . '] 日時[' . substr($zz_yykinfo_ymd,0,4) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . ' ' . sprintf("%02d",intval($zz_yykinfo_st_time / 100)) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '-' . sprintf("%02d",intval($zz_yykinfo_ed_time / 100)) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . ']';
				$log_err_inf .= '<br>変更後：会場[' . $zz_yykinfo_office_nm . '] 日時[' . substr($select_ymd,0,4) . '-' . sprintf("%02d",substr($select_ymd,4,2)) . '-' . sprintf("%02d",substr($select_ymd,6,2)) . ' ' . sprintf("%02d",intval($Mclass_st_time / 100)) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '-' . sprintf("%02d",intval($Mclass_ed_time / 100)) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . ']<br>mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';			//エラー情報
				require( './zm_log.php' );
				//************
				
			}
			
			//画面編集
			print('<center>');

			//*** 携帯電話（スマホ以外） ************************************************************************************
			if( $mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W' ){
				//携帯電話（スマホ以外）
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}

				print('<br><font size="2" color="red">※お使いの機種では、<br>現在ご利用できません。</font><br><br><font size="1" color="blue">パソコンから予約できます</font>');
				
//print('<input type="submit" name="button" style="padding: 10px 10px 10px 10px;" value="予約する">');
				
			//*** スマホ ************************************************************************************
			}else{
				//スマホ
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}
	
				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td width="320" aling="left valign="top">');	//main
			
				//「個別カウンセリング」
				print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" id="kbtcounseling" border="0"><br>');
				
				//お客様氏名
				print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様<br>');
			
				print('<hr>');

				//「予約を受け付けました。」
				//print('<img src="./img_' . $lang_cd . '/title_kbt_res_ok.png" border="0"><br>');
				print('<font color="blue">予約を受け付けました。</font><br>');
				
				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_235x20.png"><font color="blue" size="4">' . sprintf("%05d",$yyk_no) . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $Moffice_office_nm . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor_78x20.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $Mstaff_open_staff_nm . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				//興味のある国
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $kyoumi . '</font></td>');
//				print('</tr>');
				//出発予定時期
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $jiki . '</font></td>');
//				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
				print('<td align="left" valign="top" background="../img_' . $lang_cd . '/bg_yellow_235x20.png">');
				print('<font size="1"><div style="margin: 10px"><pre>' . $soudan . '</pre></div></font>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
	
				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td width="135" align="right" valign="middle">');
				//戻るボタン
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main

			}
	
			
		}else if( $err_flg == 0 && $err_cnt != 0 ){
			//エラーあり（いまのところ、相談内容が空白の場合のみ）
			
			//画面編集
			print('<center>');
			
			//*** 携帯電話（スマホ以外） ************************************************************************************
			if( $mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W' ){
				//携帯電話（スマホ以外）
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}

				print('<br><font size="2" color="red">※お使いの機種では、<br>現在ご利用できません。</font><br><br><font size="1" color="blue">パソコンから予約できます</font>');
				
//print('<input type="submit" name="button" style="padding: 10px 10px 10px 10px;" value="予約する">');
				
			//*** スマホ ************************************************************************************
			}else{
				//スマホ
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}
	
				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td width="320" aling="left valign="top">');	//main
			
				//「個別カウンセリング」
				print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" id="kbtcounseling" border="0"><br>');
				
				//お客様氏名
				print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様<br>');
			
				print('<hr>');
			
				//「エラーがあります」
				print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0"><br>');			

				if( $select_yyk_no == "" ){
					//新規予約登録時

					print('<table border="1" bordercolor="black">');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $Moffice_office_nm . '</font></td>');
					print('</tr>');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor_78x20.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $Mstaff_open_staff_nm . '</font></td>');
					print('</tr>');
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
					print('</tr>');
					print('</table>');
					
				}else{
					//日時変更時
					
					print('<table border="0"');
					print('<tr>');
					print('<td width="320" align="center" valign="middle">');
					//「現在の予約内容です。」
					//print('<img src="./img_' . $lang_cd . '/title_now_yykinfo.png" border="0">');
					print('<font color="blue">※ 現在の予約内容です。</font>');
					print('</td>');
					print('</tr>');
					print('</table>');

					print('<table border="1" bordercolor="black">');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_pink_235x20.png"><font color="blue" size="4">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
					print('</tr>');
					//print('<tr>');
					//print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					//print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $select_yyk_office_nm . '</font></td>');
					//print('</tr>');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor_78x20.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png">');
					if( $zz_yykinfo_staff_cd != "" ){
						print( $zz_yykinfo_open_staff_nm );
					}else{
						print('(指名なし)');
					}
					print('</td>');
					print('</tr>');
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $zz_yykinfo_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
					print('</tr>');
					print('</table>');
					
					//「↓」
					print('<img src="./img_' . $lang_cd . '/title_kbt_datecng_yajirushi.png" border="0"><br>');
				
					print('<table border="1" bordercolor="black">');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
					print('</tr>');
					print('</table>');
				
				}
				
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_res.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_res.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			
				//「相談内容を記入後「予約する」ボタンを押してください。」
				//print('<img src="./img_' . $lang_cd . '/title_kbt_kkn.png" border="0"><br>');
				print('<font color="blue">※ 相談内容を入力後「予約する」ボタンを押下してください。</font><br>');
				print('<font size="2" color="red">（まだ予約確定していません。）</font><br>');

				//興味のある国
				print('<input type="hidden" name="kyoumi" value="' . $kyoumi . '">');
//				print('<table border="0">');
//				print('<tr>');
//				print('<td width="320" align="left">');
//				print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
//				if( $err_kyoumi == 1 ){
//					print('<font size="2" color="red">エラー：興味のある国を入力してください。</font><br>');
//				}
//				$tabindex++;
//				print('<input type="text" name="kyoumi" maxlength="100" value="' . $kyoumi . '" class="normal" tabindex="' . $tabindex . '" style="font-size: 15px; background-color: #E0FFFF; width:100%;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//				print('</td>');
//				print('</tr>');
//				print('</table>');

				//出発予定時期
				print('<input type="hidden" name="jiki" value="' . $jiki . '">');
//				print('<table border="0">');
//				print('<tr>');
//				print('<td width="320" align="left">');
//				print('<img src="./img_' . $lang_cd . '/title_jiki.png" border="0"><br>');
//				if( $err_jiki == 1 ){
//					print('<font size="2" color="red">エラー：出発予定時期を入力してください。</font><br>');
//				}
//				$tabindex++;
//				print('<input type="text" name="jiki" maxlength="100" value="' . $jiki . '" class="normal" tabindex="' . $tabindex . '" style="font-size: 15px; background-color: #E0FFFF; width:100%;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//				print('</td>');
//				print('</tr>');
//				print('</table>');

				//相談内容記入例
				print('<table border="0">');
				print('<tr>');
				print('<td width="320" align="left" valign="top">');
				print('<font size="2">(相談内容記入例)</font><br>');				
				print('<font size="1">');
				print('「５月中旬頃からオーストラリアにワーキングホリデーで行きたいが、どの都市にしようか迷っている」<br>');
				print('「将来、海外での就職に役立つ留学プランについて相談したい」<br>');
				print('「カナダのワーホリビザ申請をしたい」<br>');
				print('「オーストラリアで海の近くの語学学校を探しているのでおススメを教えてほしい」<br>');
				print('</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				//相談内容
				print('<table border="0">');
				print('<tr>');
				print('<td width="320" align="left">');
				print('<img src="./img_' . $lang_cd . '/title_soudan.png" border="0"><br>');
				if( $err_soudan == 1 ){
					print('<font size="2" color="red">エラー：相談内容を入力してください。</font><br>');
				}
				$tabindex++;
//				print('<textarea name="soudan" rows="8" style="ime-mode:active; background-color: #E0FFFF; width:100%; font-size: 15px; font-family: sans-serif;" tabindex="' . $tabindex . '" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $soudan . '</textarea>');
				print('<textarea name="soudan" rows="8"  style="background-color: #E0FFFF; width:98%;">' . $soudan . '</textarea>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				//個別カウンセリングを予約する ボタン
				print('<td width="135" align="right" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('</form>');
			
				print('<hr>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td width="135" align="right" valign="middle">');
				//戻るボタン
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_jknkbn.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_jknkbn.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');

				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
			}
			
			print('</center>');

		
		}else if( $err_flg == 6 ){
			//二重登録（Ｆ５キーやボタン連打時を想定）
			
			//画面編集
			print('<center>');

			//*** 携帯電話（スマホ以外） ************************************************************************************
			if( $mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W' ){
				//携帯電話（スマホ以外）
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}

				print('<br><font size="2" color="red">※お使いの機種では、<br>現在ご利用できません。</font><br><br><font size="1" color="blue">パソコンから予約できます</font>');
				
//print('<input type="submit" name="button" style="padding: 10px 10px 10px 10px;" value="予約する">');
				
			//*** スマホ ************************************************************************************
			}else{
				//スマホ
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}
	
				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td width="320" aling="left valign="top">');	//main
			
				//「個別カウンセリング」
				print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" id="kbtcounseling" border="0"><br>');
				
				//お客様氏名
				print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様<br>');
			
				print('<hr>');

				//「予約を受け付けました。」
				//print('<img src="./img_' . $lang_cd . '/title_kbt_res_ok.png" border="0"><br>');
				print('<font color="blue">予約を受け付けました。</font><br>');
				
				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_pink_235x20.png"><font color="blue" size="4">' . sprintf("%05d",$tmp_nijyu_yyk_no) . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $zz_yykinfo_office_nm . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $zz_yykinfo_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
				print('</tr>');
				//興味のある国
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $zz_yykinfo_kyoumi . '</font></td>');
//				print('</tr>');
				//出発予定時期
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $zz_yykinfo_jiki . '</font></td>');
//				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
				print('<td align="left" valign="top" background="../img_' . $lang_cd . '/bg_yellow_235x20.png">');
				print('<font size="1"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
	
				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td width="135" align="right" valign="middle">');
				//戻るボタン
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main

			}


		}else if( $err_flg != 4 ){
			//その他エラー（mySQLエラーを除く）

			//画面編集
			print('<center>');
			
			//*** 携帯電話（スマホ以外） ************************************************************************************
			if( $mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W' ){
				//携帯電話（スマホ以外）
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}

				print('<br><font size="2" color="red">※お使いの機種では、<br>現在ご利用できません。</font><br><br><font size="1" color="blue">パソコンから予約できます</font>');
				
//print('<input type="submit" name="button" style="padding: 10px 10px 10px 10px;" value="予約する">');
				
			//*** スマホ ************************************************************************************
			}else{
				//スマホ
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}
	
				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td width="320" aling="left valign="top">');	//main
			
				//「個別カウンセリング」
				print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" id="kbtcounseling" border="0"><br>');
				
				//お客様氏名
				print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様<br>');
			
				print('<hr>');
			
			
				if( $err_flg == 0 && $data_cnt != 1 ){
				//顧客情報が取得できなかった
					print('<br><font size="2" color="red">お手数ですが、始めからお願いします。</font><br><br>');
				
				}else if( $err_flg == 5 ){
					//満席になった
					print('<br><font size="2" color="red">選択した日時は満席となりました。<br><br>お手数ですが、始めからお願いします。</font><br><br>');
				 
				}else if( $err_flg == 7 ){
					//未来予約がある
					print('<br><font size="2" color="red">個別カウンセリングの予約は１人１件までとさせていただいております。<br><br>（選択した日時の予約はできませんでした。）</font><br><br>');
					
				}else if( $err_flg == 8 ){
					//過去日時を選択した
					print('<br><font size="2" color="red">選択した日時は過去日時のため<br>予約できませんでした。</font><br><br>');

				}else if( $err_flg == 9 ){
					//予約が取り消されている（日時変更のみ）
					print('<br><font size="2" color="red">予約が取消されていますので、始めからお願いします。</font><br><br>');

				}else if( $err_flg == 10 ){
					//会員が見つからなかった
					print('<br><font size="2" color="red">お手数ですが、始めからお願いします。</font><br><br>');

				}else{
					//不明	
					print('<br><font size="2" color="red">お手数ですが、始めからお願いします。</font><br><br>');
					
				}

				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td width="135" align="center" valign="middle">');
				//戻るボタン
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');
		
				print('<hr>');
				
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
				
			}
			
			print('</center>');
			
		}
	}


	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>

  </div><!--contentsEND-->
  </div><!--contentsboxEND-->

<?php
	fncMenuFooter($header_obj->footer_type);
?>
</body>
</html>