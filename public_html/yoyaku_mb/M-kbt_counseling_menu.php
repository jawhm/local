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
	$gmn_id = 'M-kbt_counseling_menu.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//オールOK

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = 'J';


	//サーバー接続
	require( './zm_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//メンテナンス期間チェック
		require( './zm_mntchk.php' );

		if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
			$err_flg = 80;	//メンテナンス中
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
		//（携帯サイトの場合は名前の横に移動）

		//接続キーを取得
		$yykkey_ang_str = htmlspecialchars($_GET['k'],ENT_QUOTES,'auto');
		if( $yykkey_ang_str == "" ){
			$yykkey_ang_str = $_POST['yykkey_ang_str'];
		}
			
		if( strlen($yykkey_ang_str) == 20 ){
			//キーを複合化
			$yykkey_ang_str = $yykkey_ang_str;
			require( '../yoyaku/zy_yykkey_fkg.php' );
			
		}else{
			//２０文字ではない
			$yykkey_err_flg = 1;
			
		}

		if( $yykkey_err_flg == 0 ){
			//正常処理
			
			if( $prc_gmn == "" ){
				
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングのメニューを表示しました。';	//内容
				$log_err_inf = 'kbn[' . $mobile_kbn . '] ip[' . $ip_adr . '] agent1[' . $agent1 . ']';	//エラー情報
				require( './zm_log.php' );
				//************
			
			}
			
			$err_cnt = 0;
			$data_cnt = 0;
			
			//顧客情報を参照する			
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $yykkey_kaiin_id
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
				$err_cnt++;
				
			}

			if( $data_cnt == 1 ){
				//１件ヒット
				
				//現在（今日以降）の予約数を求める
				$new_yyk_cnt = 0;
				$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
				         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $yykkey_kaiin_id . '" and A.YMD >= "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
						 ' order by A.YMD desc,A.JKN_KBN;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					print('<font color="red">エラーが発生しました。</font>');

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zm_log.php' );
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
						 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $yykkey_kaiin_id . '" and A.YMD < "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
						 ' order by A.YMD desc,A.JKN_KBN;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					print('<font color="red">エラーが発生しました。</font>');

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zm_log.php' );
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
				print('<table border="0">');
				print('<tr>');
				print('<td>');
				print('<font size="4">' . $data_kaiin_nm[0] . '</font>&nbsp;様');
				print('</td>');
				print('<td>');
				//画像事前読み込み
				print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');
				print('<img src="./img_' . $lang_cd . '/btn_mini_change_2.png" width="0" height="0" style="visibility:hidden;">');
				print('<img src="./img_' . $lang_cd . '/btn_mini_syousai_2.png" width="0" height="0" style="visibility:hidden;">');
				print('</td>');
				print('</tr>');
				print('</table>');				

				print('<hr>');

				//***現在の予約********************************************************************
				print('<table border="0">');	//genzai
				print('<tr>');	//genzai
				print('<td width="320" align="center">');	//genzai
				
				print('<table bgcolor="orange"><tr><td width="320">');
				print('<img src="./img_' . $lang_cd . '/bar_genzaiyyk.png" border="0">');
				print('</td></tr></table>');
	
				//現在の予約
				if( $new_yyk_cnt == 0 ){
					//「※現在、予約はありません。」
					print('<br><img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" border="0"><br>');
					
					//予約するボタン
					print('<table border="0">');
					print('<tr>');
					print('<td width="320" align="center">');
					if( $mobile_kbn == 'I' ){
						//iPhoneのみ
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php#kbtcounseling">');
					}else{
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php">');
					}
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
					print('</form>');
					print('</td>');
					print('</tr>');
					print('</table>');
					
				}else{
					//予約あり
					
					print('<table border="1" bordercolor="black">');
					print('<tr bgcolor="powderblue">');
					print('<td width="55" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約内容
					print('</tr>');

					$mirai_cnt = 0;
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
							print('<font color="red">エラーが発生しました。</font>');
		
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
							$log_err_inf = $query;	//エラー情報
							require( './zm_log.php' );
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
							if( $new_yyk_st_time[$i] >= (($now_hh * 100) + $now_ii) ){
								$mirai_cnt++;
							}
							
						}else{
							//未来日
							$bgfile = "bg_yellow";
							$mirai_cnt++;
						}
					
						print('<tr>');
						//変更／取消ボタン
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
						if( $mobile_kbn == 'I' ){
							//iPhoneのみ
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_kkn.php#kbtcounseling">');
						}else{
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_kkn.php">');
						}
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
						print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
						print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
						print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
						print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
						print('<input type="hidden" name="select_yyk_no" value="' . $new_yyk_yyk_no[$i] . '">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_change_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_change_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_change_1.png\';" border="0">');
						print('</form>');
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
						//予約会場
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
						print('<font size="1">予約No.' . sprintf("%05d",$new_yyk_yyk_no[$i]) . '</font><br>');
						print('<font size="2" color="blue">&nbsp;&nbsp;' . $new_yyk_office_nm[$i] . '</font>');
						print('</td>');
						print('</tr>');
				
						$i++;
					}
					print('</table>');
					
					
					if( $mirai_cnt == 0 ){
						//明日以降の予約が無ければ、予約するボタンを表示する
						
						//予約するボタン
						print('<table border="0">');
						print('<tr>');
						print('<td width="600" align="center">');
						if( $mobile_kbn == 'I' ){
							//iPhoneのみ
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php#kbtcounseling">');
						}else{
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php">');
						}
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
						print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
						print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
						print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
						print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
						print('</form>');
						print('</td>');
						print('</tr>');
						print('</table>');
						
					}else{
						//明日以降の予約がある場合は、新規の予約は出来ない
						//「※新たな予約は１人１件とさせていただいております。」
						//print('<img src="./img_' . $lang_cd . '/title_1kenmade.png" border="0">');
						print('<font size="1">※ 新たな予約は１人１件とさせていただいております。</font>');
						
					}
	
				}
				
				print('</td>');	//genzai
				print('</tr>');	//genzai
				print('</table>');	//genzai
	
				print('<hr>');
				
				//***過去の予約********************************************************************
				print('<table border="0">');	//kako
				print('<tr>');	//kako
				print('<td width="320" align="center">');	//kako
				
				print('<table bgcolor="lightgrey"><tr><td width="320">');
				print('<img src="./img_' . $lang_cd . '/bar_kakoyyk.png" border="0">');
				print('</td></tr></table>');
				
				if( $old_yyk_cnt == 0 ){
					//「※現在、予約はありません。」
					print('<br><img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" border="0"><br>');
					
				}else{
					//予約あり
					
					print('<table border="1" bordercolor="black">');
					print('<tr bgcolor="powderblue">');
					print('<td width="55" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約内容
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
							print('<font color="red">エラーが発生しました。</font>');
		
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
							$log_err_inf = $query;	//エラー情報
							require( './zm_log.php' );
							//************
			
						}else{
							while( $row = mysql_fetch_array($result) ){
								$eigyoubi_flg = $row[0];	//営業日フラグ
							}
						}
								
						//背景色
						$bgfile = "bg_lightgrey";
					
						print('<tr>');
						//詳細ボタン
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_55x20.png">');
						if( $mobile_kbn == 'I' ){
							//iPhoneのみ
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_kkn.php#kbtcounseling">');
						}else{
							print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_kkn.php">');
						}
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
						print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
						print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
						print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
						print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
						print('<input type="hidden" name="select_yyk_no" value="' . $old_yyk_yyk_no[$i] . '">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_1.png\';" border="0">');
						print('</form>');
						print('</td>');
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
						//予約会場
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
						print('<font size="1">予約No.' . sprintf("%05d",$old_yyk_yyk_no[$i]) . '</font><br>');					
						print('<font size="2" color="blue">&nbsp;&nbsp;' . $old_yyk_office_nm[$i] . '</font>');
						print('</td>');
						print('</tr>');
						
						$i++;
					}
					print('</table>');
					
				}
				
				print('</td>');	//kako
				print('</tr>');	//kako
				print('</table>');	//kako

				print('<br>');	//調整
			
				print('<hr>');
	
				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
				
			}
			
			print('</center>');


		}else if( $yykkey_err_flg == 1 ){
			//複合エラー
		
			//画面編集
			print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" border="0"><br>');
			
			//「アドレス確認エラーとなりました」
			print('<img src="./img_' . $lang_cd . '/title_adr_err.png" border="0"><br>');

			//「下記のメールアドレスへ空メールを送信してください。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_kakinomail.png" border="0"><br>');
		
			//「予約受付メールアドレス」
			print('<img src="./img_' . $lang_cd . '/title_yyk_uketsuke.png" border="0"><br>');
			print('<a href="mailto:' . $sv_yyk_request_mailadr . '?subject=Request&body=Request" style="text-decoration: none;"><font size="5" color="blue">' . $sv_yyk_request_mailadr . '</font></a><br>');
		
			print('<hr>');
			
			print('<font color="red" size="1">・初回の方は申し訳ありませんが、オフィスへご連絡ください。</font><br>');
			print('<font size="1">・事前に登録済みのメールアドレスで送信してください。</font><br>');
			print('<font size="1">（未登録の場合はオフィスへご連絡ください。）</font><br>');
			print('<font size="1">・自動的に 個別カウンセリングの予約ページのアドレスを送られてきたメールアドレス宛に返信します。</font><br>');
			print('<font size="1">（ ' . $sv_yyk_send_mailadr . ' から送信しますので、メールが受信できるようメール受信設定をお願いします。）</font><br>');
	
			print('<hr>');

			
		}else if( $yykkey_err_flg == 2 ){
			//有効期限切れ
			
			//画面編集
			//「有効期限切れとなりました」
			print('<img src="./img_' . $lang_cd . '/title_yukoukigengire.png" border="0"><br>');

			//「下記のメールアドレスへ空メールを送信してください。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_kakinomail.png" border="0"><br>');
		
			//「予約受付メールアドレス」
			print('<img src="./img_' . $lang_cd . '/title_yyk_uketsuke.png" border="0"><br>');
			print('<a href="mailto:' . $sv_yyk_request_mailadr . '?subject=Request&body=Request" style="text-decoration: none;"><font size="5" color="blue">' . $sv_yyk_request_mailadr . '</font></a><br>');
		
			print('<hr>');
			
			print('<font color="red" size="1">・初回の方は申し訳ありませんが、オフィスへご連絡ください。</font><br>');
			print('<font size="1">・事前に登録済みのメールアドレスで送信してください。</font><br>');
			print('<font size="1">（未登録の場合はオフィスへご連絡ください。）</font><br>');
			print('<font size="1">・自動的に 個別カウンセリングの予約ページのアドレスを送られてきたメールアドレス宛に返信します。</font><br>');
			print('<font size="1">（ ' . $sv_yyk_send_mailadr . ' から送信しますので、メールが受信できるようメール受信設定をお願いします。）</font><br>');
	
			print('<hr>');
			
		}else{
			//エラー（3お客様番号エラー　5:システムエラー）
			print('<font size="3" color="red">エラーが発生しました。<br>お手数ですが、オフィスまでお問い合わせください。</font>');
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = '個別カウンセリングのメニューにて、システムエラーが発生しました。<br>';	//内容
			$log_err_inf = 'yykkey_err_flg[' . $yykkey_err_flg . '] yykkey_ang_str[' . $yykkey_ang_str . ']';	//エラー情報
			require( './zm_log.php' );
			//************

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