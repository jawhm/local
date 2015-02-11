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
	$gmn_id = 'M-kbt_counseling_select_jknkbn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('M-kbt_counseling_select_date.php','M-kbt_counseling_select_jknkbn.php','M-kbt_counseling_select_kkn.php','M-kbt_counseling_select_res.php');

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
	$select_staff_cd = $_POST['select_staff_cd'];
	$select_ymd = $_POST['select_ymd'];
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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" || $select_ymd == "" ){
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
			print('<img src="./img_' . $lang_cd . '/btn_znjt_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_ykjt_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_sentaku_mini2_2.png" width="0" height="0" style="visibility:hidden;">');
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
				require( './zm_errgmn.php' );
			
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
				//************
	
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Mstaff_open_staff_nm = $row[0];	//公開スタッフ名
					$Mstaff_cnt++;
				}
			}
		}

		//選択日情報
		$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)) , sprintf("%d",substr($select_ymd,0,4))) );
		$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
		
		//表示最大日付の判定用日付
		$tmp_sabun = 0;
		if( $Moffice_start_youbi == 0 ){
			//*** 日曜始まり ***
			$tmp_sabun = 7 - $now_youbi + (($sv_max_disp_week - 2) * 8);
		}else{
			//*** 月曜始まり ***
			if( $now_youbi == 0 ){
				$tmp_sabun = 1 + (($sv_max_disp_week - 2) * 8);
			}else{
				$tmp_sabun = 7 + 1 - $now_youbi + (($sv_max_disp_week - 2) * 8);
			}
		}
		$max_disp_yyyymmdd = date("Ymd", mktime(0, 0, 0, $now_mm, ($now_dd + $tmp_sabun) , $now_yyyy) );

		//選択日の前日
		$bf_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) - 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
		//選択日の翌日
		$af_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
		
		if( $err_flg == 0 ){
			//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $target_yyyymmdd . '" order by YOUBI_CD,ST_DATE;';
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
				$log_naiyou = '営業時間マスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zm_log.php' );
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
		}

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

			}else{
				//比較用に予約日のyyyymmdd型を用意する
				$zz_yykinfo_ymd_yyyymmdd = substr($zz_yykinfo_ymd,0,4) . substr($zz_yykinfo_ymd,5,2) . substr($zz_yykinfo_ymd,8,2);
				
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
					
					print('<table border="0"');
					print('<tr>');
					print('<td width="160" align="left" valign="top">');
					//「会場」
					print('<img src="./img_' . $lang_cd . '/bar_kaijyou.png" width="160" border="0"><br>');
					print('<font size="3" color="blue">' . $Moffice_office_nm . '</font>');
					print('</td>');
					print('<td width="160" align="left" valign="top">');
					//「カウンセラー」
					print('<img src="./img_' . $lang_cd . '/bar_counselor_180.png" width="160" border="0"><br>');
					print('<font size="3" color="blue">' . $Mstaff_open_staff_nm . '</font>');
					print('</td>');
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
//					print('<tr>');
//					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
//					print('<td width="235" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $zz_yykinfo_office_nm . '</font></td>');
//					print('</tr>');
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
					
				}
	
				print('<hr>');

				if( $select_yyk_no != "" ){
					//日時変更時のみ

					print('<table border="0"');
					print('<tr>');
					print('<td width="160" align="left" valign="top">');
					//「会場」
					print('<img src="./img_' . $lang_cd . '/bar_kaijyou.png" width="160" border="0"><br>');
					print('<font size="3" color="blue">' . $Moffice_office_nm . '</font>');
					print('</td>');
					print('<td width="160" align="left" valign="top">');
					//「カウンセラー」
					print('<img src="./img_' . $lang_cd . '/bar_counselor_180.png" width="160" border="0"><br>');
					print('<font size="3" color="blue">' . $Mstaff_open_staff_nm . '</font>');
					print('</td>');
					print('</tr>');
					print('</table>');

				}

				print('<table border="0">');
				print('<tr>');
				print('<td width="80">');
				//前日表示ボタン
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
				print('<input type="hidden" name="select_ymd" value="' . $bf_date . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				if( $target_yyyymmdd > $now_yyyymmdd ){
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_znjt_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_znjt_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_znjt_1.png\';" border="0">');
				}else{
					print('&nbsp;');	
				}
				print('</form>');
				print('</td>');
				print('<td width="160" align="center" valign="middle">');
				//「時間帯を選択してください。」
				print('<img src="./img_' . $lang_cd . '/title_select_jikantai.png" border="0">');
				print('</td>');
				print('<td width="80">');
				//翌日表示ボタン
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
				print('<input type="hidden" name="select_ymd" value="' . $af_date . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				if( $af_date <= $max_disp_yyyymmdd ){
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_ykjt_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_ykjt_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_ykjt_1.png\';" border="0">');
				}else{
					print('&nbsp;');	
				}
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');


				$t = 0;
				while( $t < 1 ){
		
					//選択日に有効な時間割を取得する
					$Mclassjknwr_cnt = 0;
					$query = 'select JKN_KBN,ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and ST_DATE <= "' . $target_yyyymmdd . '" and "' . $target_yyyymmdd . '" <= ED_DATE and YUKOU_FLG = 1 order by TSUBAN;';
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
							$Mclassjknwr_jkn_kbn[$Mclassjknwr_cnt] = $row[0];	//時間区分
							$Mclassjknwr_st_time[$Mclassjknwr_cnt] = $row[1];	//開始時刻
							$Mclassjknwr_ed_time[$Mclassjknwr_cnt] = $row[2];	//終了時刻
							$Mclassjknwr_cnt++;
						}
					}
					
					//営業日フラグを求める
					$target_eigyoubi_flg = 0;
					if( $err_flg == 0 ){
						$target_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
						$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $target_yyyymmdd . '";';
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
								$target_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
							}
						}
					}
					
					
					//営業時間と定休日フラグを求める
					$target_eigyou_st_time = 0;
					$target_eigyou_ed_time = 0;
					$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
					$find_flg = 0;
					if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
						//祝日のみ対応（土日祝の前日は非対応）
						$a = 0;
						while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
							if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ){
								if( $Meigyojkn_st_time[$a] != "" ){
									$target_eigyou_st_time = $Meigyojkn_st_time[$a];
									$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
									
								}else{
									if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
										//曜日で検索しなおし
										$a = 0;
										while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
											if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
												( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
												$target_eigyou_st_time = $Meigyojkn_st_time[$a];
												$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
												$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
												$find_flg = 1;
											}
											$a++;
										}
									}else{
										$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
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
								( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
								if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
									$target_eigyou_st_time = $Meigyojkn_st_time[$a];
									$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}else{
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}
							}
							$a++;
						}
					}
					
					//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
					if( $target_teikyubi_flg == 1 ){
						$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '";';
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
									$target_eigyou_st_time = $row[0];
								}
								if( $row[1] != "" ){
									$target_eigyou_ed_time = $row[1];
								}
								$target_teikyubi_flg = 0;
							}
						}
					}

					//その日にスケジュールを公開しているスタッフがいるか？
					$tmp_open_flg = 0;
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and OPEN_FLG = 1;';
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
						$row = mysql_fetch_array($result);
						if( $row[0] > 0 ){
							$tmp_open_flg = 1;
						}
					}

					//年月日表示
					if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
						//祝日
						$fontcolor = "red";
					}else if( $target_youbi_cd == 0 ){
						//日曜
						$fontcolor = "red";
					}else if( $target_youbi_cd == 6 ){
						//土曜
						$fontcolor = "blue";
					}else{
						//平日
						$fontcolor = "black";
					}
						
					//年月日表示
					print('<table border="0">');
					print('<tr>');
					print('<td id="' . $target_yyyymmdd . '" width="80" align="left" valign="bottom"><img src="../yoyaku/img_' . $lang_cd . '/yyyy_' . substr($target_yyyymmdd,0,4) . '_black.png" border="0"></td>');	//年
					print('<td width="65" align="left" valign="bottom"><img src="../yoyaku/img_' . $lang_cd . '/mm_' . sprintf("%d",substr($target_yyyymmdd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
					print('<td width="65" align="left" valign="bottom"><img src="../yoyaku/img_' . $lang_cd . '/dd_' . sprintf("%d",substr($target_yyyymmdd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
					print('<td width="40" align="left" valign="bottom"><img src="../yoyaku/img_' . $lang_cd . '/youbi_' . $target_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
					print('<td width="150">&nbsp;</td>');
					print('</tr>');
					print('</table>');
	
					
					print('<table border="0">');	//sub
					print('<tr>');	//sub
					print('<td width="320" align="center">');	//sub
					
					print('<table border="1" bordercolor="black">');
					//時間帯表示
					$j = 0;
					while( $j < $Mclassjknwr_cnt ){
						
						//非メンバーの予約数を求める
						$notmember_yyk_cnt[$j] = 0;
						$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and KAIIN_KBN = 9;';
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
							$notmember_yyk_cnt[$j] = $row[0];	//非メンバーの予約数
						}
						
						print('<tr>');
						print('<td width="130" align="center" valign="middle" ');
						if( $target_teikyubi_flg == 1 ){
							//定休日
							print('background="../img_' . $lang_cd . '/bg_yellow_130x20.png"');
						}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
							//非営業日
							print('background="../img_' . $lang_cd . '/bg_lightgrey_130x20.png"');
						}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
							//営業時間外
							print('background="../img_' . $lang_cd . '/bg_lightgrey_130x20.png"');
						}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
							//過去時間帯
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
							
							
	//					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
						}else{
							//非メンバーの予約可能数を下回っている場合
							//メンバー および 一般 の時間区分
							print('background="../img_' . $lang_cd . '/bg_mizu_130x20.png"');
//						}else{
//							//メンバーのみ の時間区分
//							print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
						}
						print('>');
						
						print( intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) );
						print('</td>');
						
						//*** 選択ボタン ***
						//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する（全員分）
						$tmp_yyk_cnt = 0;
						$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
						$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
						$tmp_uktk_flg = 0;
						if( $select_staff_cd != "" ){
							//カウンセラー指名の場合、指名予約があるかチェックする
							$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
									$tmp_shimei_flg = 1;
								}
							}
							
							//そのカウンセラーは予約受付登録しているかチェックする
							$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' .  $select_staff_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
								$row = mysql_fetch_array($result);
								if( $row[0] > 0 ){
								$tmp_uktk_flg = 1;
								}
							}
						}

						print('<td width="110" align="center" valign="middle" ');
						if( $target_teikyubi_flg == 1 ){
							//定休日
							print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
						}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
							//非営業日
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
						}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
							//営業時間外
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
						}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
							//過去時間帯
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
//						}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
						}else{
							//非メンバーの予約可能数を下回っている場合
							//メンバー および 一般 の時間区分
							print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png"');
//						}else{
//							//メンバーのみ の時間区分
//							print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
						}
						print('>');
						
						//選択ボタン
						if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
							if( $mobile_kbn == 'I' ){
								//iPhoneのみ
								print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_kkn.php#kbtcounseling">');
							}else{
								print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_kkn.php">');
							}
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '" />');
							print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
							print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
							print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $target_yyyymmdd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');						
							//日時変更引数
							print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
						}
					
	
						if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
							//営業時間外
							print('<img src="./img_' . $lang_cd . '/title_eigyou_jkngai_78x30.png" border="0">');
							
						}else{
							//営業時間内
							if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
	
								//過去日／過去時間はダメ
								if( $target_yyyymmdd < $now_yyyymmdd || ($target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] <= (($now_hh * 100) + $now_ii)) ){
									//「終了しました。」
									print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0">');
									
								}else if( $zz_yykinfo_ymd_yyyymmdd == $target_yyyymmdd && $zz_yykinfo_st_time == $Mclassjknwr_st_time[$j] ){
									//日時変更時の変更前の時間帯
									//「現在の選択」
									print('<img src="./img_' . $lang_cd . '/title_mini_now_selecttime.png" border="0">');

								}else{
									if( $select_staff_cd == "" ){
										//全員分
										if( $tmp_uktk_ninzu > 0 ){
											//選択ボタン
											$tabindex++;
											print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_1.png\';" border="0">');
										}else{
											//受付不可	
											print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
										}
									}else{
										//カウンセラー指名
										if( $tmp_shimei_flg == 0 && $tmp_uktk_flg == 1 ){
											//指名予約は無いので選択ボタンを表示
											//選択ボタン
											$tabindex++;
											print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini2_1.png\';" border="0">');
										}else if( $tmp_shimei_flg == 1 && $tmp_uktk_flg == 1 ){
											//指名予約があるので満席表示
											print('<img src="./img_' . $lang_cd . '/title_manseki_78x30.png" border="0">');
										}else{
											//受付不可	
											print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
										}
									}
								}
							
							}else{
								if( $target_teikyubi_flg == 1 ){
									print('&nbsp;<br>定休日<br>&nbsp;');							
								}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
									print('&nbsp;<br>お休みです<br>&nbsp;');
								}else if( $zz_yykinfo_ymd_yyyymmdd == $target_yyyymmdd && $zz_yykinfo_st_time == $Mclassjknwr_st_time[$j] ){
									//日時変更時の変更前の時間帯
									//「現在の選択」
									print('<img src="./img_' . $lang_cd . '/title_mini_now_selecttime.png" border="0">');
								}else if( $target_yyyymmdd < $now_yyyymmdd || ($target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] <= (($now_hh * 100) + $now_ii)) ){
									//「終了しました。」
									print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0">');
								}else if( $tmp_open_flg == 0 ){
									//「受付開始前」
									print('<img src="./img_' . $lang_cd . '/title_mini_kaishimae.png" border="0">');							
								}else if( $tmp_uktk_ninzu != 0 && $tmp_yyk_cnt == $tmp_uktk_ninzu ){
									//満席
									print('<img src="./img_' . $lang_cd . '/title_manseki_78x30.png" border="0">');
								}else{
									//受付不可	
									print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
								}
							}
						}

						if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
							print('</form>');
						}

						print('</td>');
						
						
						print('</tr>');
						
						$j++;
					}			
					
					print('</table>');

					print('</td>');	//sub
					print('</tr>');	//sub
					print('</table>');	//sub

					print('<hr>');
		
					//翌日にする
					$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
					$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
					$t++;
					
					
					if( $target_yyyymmdd > $max_disp_yyyymmdd ){
						//表示最大日を越えた場合は、終了
						break;
					}
				}
	
				print('<table border="0">');
				print('<tr>');
				print('<td width="80">');
				//前日表示ボタン
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
				print('<input type="hidden" name="select_ymd" value="' . $bf_date . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				if( $target_yyyymmdd > $ykjt_yyyymmdd ){
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_znjt_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_znjt_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_znjt_1.png\';" border="0">');
				}else{
					print('&nbsp;');	
				}
				print('</form>');
				print('</td>');
				print('<td width="160" align="center" valign="middle">&nbsp;</td>');
				print('<td width="80">');
				//翌日表示ボタン
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
				print('<input type="hidden" name="select_ymd" value="' . $af_date . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				if( $afweek_date <= $max_disp_yyyymmdd ){
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_ykjt_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_ykjt_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_ykjt_1.png\';" border="0">');
				}else{
					print('&nbsp;');	
				}
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<hr>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td align="right" valign="middle">');
				//戻るボタン
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_date.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_date.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
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
		}
		
		print('</center>');
	}

	mysql_close( $link );


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