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
	$gmn_id = 'M-kbt_counseling_select_kkn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('M-kbt_counseling_select_jknkbn.php');

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

		//日時変更の場合のみ
		if( $select_yyk_no != "" ){
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
				$log_naiyou = '予約内容の取り込みに失敗しました。[1]';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zm_log.php' );
				//************
				
			}else if( $zz_yykinfo_rtncd == 8 ){
				//予約が無くなった
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zm_errgmn.php' );

				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '予約内容の取り込みに失敗しました。[8]';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zm_log.php' );
				//************

			}
		}

		//初期化
		//興味のある国
		$kyoumi = "未使用";
		if( $select_yyk_kyoumi != "" ){
			$kyoumi = $select_yyk_kyoumi;
		}
		//出発予定時期
		$jiki = "未使用";
		if( $select_yyk_jiki != "" ){
			$jiki = $select_yyk_jiki;
		}
		//相談内容
		$soudan = "";
		if( $select_yyk_soudan != "" ){
			$soudan = $select_yyk_soudan;
		}else if( $select_yyk_no != "" && $soudan == "" ){
			$soudan = $zz_yykinfo_soudan;
		}

		$err_cnt = 0;
		$data_cnt = 0;
		
		//選択した会場（オフィス）を取得する
		$Moffice_cnt = 0;
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
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
				$Moffice_office_nm = $row[0];	//オフィス名
				$Moffice_start_youbi = $row[1];	//開始曜日  0:日曜始まり 1:月曜始まり
				
				//オフィスを会場に置換する
				$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );				
				
				$Moffice_cnt++;
			}
		}

		//カウンセラー指名がある場合、公開スタッフ名を求める
		$Mstaff_cnt = 0;
		$Mstaff_open_staff_nm = '(指名なし)';
		if( $select_staff_cd != "" ){
			$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw. '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
					$Mstaff_open_staff_nm = $row[0];	//公開スタッフ名
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
				$err_flg = 5;	//過去日時を選択
			}
		}


		if( $err_flg == 0 ){
			//エラーなし

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
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png">&nbsp;&nbsp;<font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
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
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $zz_yykinfo_office_nm . '</font></td>');
					print('</tr>');
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
				
				if( $select_yyk_no == "" ){
					//新規予約登録時
						
					print('<font color="blue">※ 相談内容を入力後「予約する」ボタンを押下してください。</font><br>');
					print('<font size="2" color="red">（まだ予約確定していません。）</font><br>');
				
				}

				//興味のある国
				print('<input type="hidden" name="kyoumi" value="' . $kyoumi . '">');
//				print('<table border="0">');
//				print('<tr>');
//				print('<td width="320" align="center">');
//				print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
//				$tabindex++;
//				print('<input type="text" name="kyoumi" maxlength="100" value="' . $kyoumi . '" class="normal" tabindex="' . $tabindex . '" style="font-size: 15px; background-color: #E0FFFF; width:100%;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//				print('</td>');
//				print('</tr>');
//				print('</table>');

				//出発予定時期
				print('<input type="hidden" name="jiki" value="' . $jiki . '">');
//				print('<table border="0">');
//				print('<tr>');
//				print('<td width="320" align="center">');
//				print('<img src="./img_' . $lang_cd . '/title_jiki.png" border="0"><br>');
//				$tabindex++;
//				print('<input type="text" name="jiki" maxlength="100" value="' . $jiki . '" class="normal" tabindex="' . $tabindex . '" style="font-size: 15px; background-color: #E0FFFF; width:100%;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//				print('</td>');
//				print('</tr>');
//				print('</table>');

				if( $select_yyk_no == "" ){
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
				}

				//相談内容
				print('<table border="0">');
				print('<tr>');
				print('<td width="320" align="center">');
				print('<img src="./img_' . $lang_cd . '/title_soudan.png" border="0"><br>');
				$tabindex++;
//				print('<textarea name="soudan" rows="8"  style="ime-mode:active; background-color: #E0FFFF; width:100%; font-size: 15px; font-family: sans-serif;" tabindex="' . $tabindex . '" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $soudan . '</textarea>');
				print('<textarea name="soudan" rows="8"  style="background-color: #E0FFFF; width:98%;">' . $soudan . '</textarea>');
				print('</td>');
				print('</tr>');
				print('</table>');
	
				print('<table border="0">');
				print('<tr>');
				if( $select_yyk_no == "" ){
					//新規予約登録時
					print('<td width="185">&nbsp;</td>');
				}else{
					//日時変更時
					print('<td width="185" align="right" valign="middle">');
					//「日時変更をする場合はこのボタンを押下してください。」
					//print('<img src="./img_' . $lang_cd . '/title_kbt_ksnkkn_btn.png" border="0">');
					print('<font size="1" color="red">このボタンで押すことで<br>日時変更が行われます</font>');
					print('</td>');
				}
				//個別カウンセリングを予約する ボタン
				print('<td width="135" align="right" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('</form>');
				
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
			
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


		}else if( $err_flg == 5 ){
			//過去日時を選択
			
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

					//「選択日時は過去日時のため、選択できません」
					print('<img src="./img_' . $lang_cd . '/title_err_kakonichiji.png" border="0">');

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
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png">&nbsp;&nbsp;<font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
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
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $select_yyk_office_nm . '</font></td>');
					print('</tr>');
					print('<tr>');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_yyk_eigyoubi_flg == 1 || $select_yyk_youbi == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_yyk_youbi == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($select_yyk_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_yyk_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_yyk_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_yyk_youbi] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($select_yyk_st_time / 100) . ':' . sprintf("%02d",($select_yyk_st_time % 100)) . '&nbsp;-&nbsp;' . intval($select_yyk_ed_time / 100) . ':' . sprintf("%02d",($select_yyk_ed_time % 100)) . '</font></td>');
					print('</tr>');
					print('</table>');
					
					//「選択日時は過去日時のため、選択できません」
					print('<img src="./img_' . $lang_cd . '/title_err_kakonichiji.png" border="0">');
				
					print('<table border="1" bordercolor="black">');
					print('<tr>');
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
					if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
						$fontcolor = "red";	//祝日/日曜
					}else if( $select_youbi_cd == 6 ){
						$fontcolor = "blue";	//土曜
					}else{
						$fontcolor = "black";	//平日
					}
					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
					print('</tr>');
					print('</table>');
				
				}
				
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
			
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