<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－スタッフ（新規登録）結果</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
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
	$gmn_id = 'kanri_staff_trk2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_staff_trk1.php');

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
	
	//固有引数の取得
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
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//固有引数の取得
		$stf_cd = $_POST['stf_cd'];			//登録対象のスタッフコード
		$stf_nm = $_POST['stf_nm'];			//登録対象のスタッフ名
		$open_stf_nm = $_POST['open_stf_nm'];	//登録対象の公開スタッフ名
		$kanri_flg = $_POST['kanri_flg'];	//管理者フラグ
		$stf_tel = $_POST['stf_tel'];		//電話番号
		$stf_mail = $_POST['stf_mail'];		//メールアドレス
		$class_cd1 = $_POST['class_cd1'];	//クラス１
		$class_cd2 = $_POST['class_cd2'];	//クラス２
		$class_cd3 = $_POST['class_cd3'];	//クラス３
		$class_cd4 = $_POST['class_cd4'];	//クラス４
		$class_cd5 = $_POST['class_cd5'];	//クラス５
		$ope_auth = $_POST['ope_auth'];		//業務権限
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日
		$yukou_flg = $_POST['yukou_flg'];	//有効・無効フラグ


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
		}

		//クラスマスタの取得
		$Mclass_cnt = 0;
		$query = 'select CLASS_CD,CLASS_NM from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 order by ST_DATE,CLASS_CD;';
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
			while( $row = mysql_fetch_array($result) ){
				$Mclass_class_cd[$Mclass_cnt] = $row[0];	//クラスコード
				$Mclass_class_nm[$Mclass_cnt] = $row[1];	//クラス名
				$Mclass_cnt++;
			}
		}

		//クラス名の編集
		$class_nm1 = '';
		$class_nm2 = '';
		$class_nm3 = '';
		$class_nm4 = '';
		$class_nm5 = '';
		
		if( $class_cd1 != '' ){
			$find = 0;
			$i = 0;
			while( $i < $Mclass_cnt && $find == 0 ){
				if( $class_cd1 == $Mclass_class_cd[$i] ){
					$class_nm1 = $Mclass_class_nm[$i];
					$find = 1;
				}else{
					$i++;
				}
			}
		}

		if( $class_cd2 != '' ){
			$find = 0;
			$i = 0;
			while( $i < $Mclass_cnt && $find == 0 ){
				if( $class_cd2 == $Mclass_class_cd[$i] ){
					$class_nm2 = $Mclass_class_nm[$i];
					$find = 1;
				}else{
					$i++;
				}
			}
		}

		if( $class_cd3 != '' ){
			$find = 0;
			$i = 0;
			while( $i < $Mclass_cnt && $find == 0 ){
				if( $class_cd3 == $Mclass_class_cd[$i] ){
					$class_nm3 = $Mclass_class_nm[$i];
					$find = 1;
				}else{
					$i++;
				}
			}
		}

		if( $class_cd4 != '' ){
			$find = 0;
			$i = 0;
			while( $i < $Mclass_cnt && $find == 0 ){
				if( $class_cd4 == $Mclass_class_cd[$i] ){
					$class_nm4 = $Mclass_class_nm[$i];
					$find = 1;
				}else{
					$i++;
				}
			}
		}
			
		if( $class_cd5 != '' ){
			$find = 0;
			$i = 0;
			while( $i < $Mclass_cnt && $find == 0 ){
				if( $class_cd5 == $Mclass_class_cd[$i] ){
					$class_nm5 = $Mclass_class_nm[$i];
					$find = 1;
				}else{
					$i++;
				}
			}
		}

		//スタッフマスタの存在チェック
		$query = 'select count(*) from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
		
			if( $row[0] > 0 ){
				//データが既に存在する場合

				//**ログ出力**
				$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフコードが既に登録されている。スタッフコード[' . $stf_cd . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_staff.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_staff_select.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				print('<font color="red">※以下のスタッフコードは既に登録されています。</font><br>');

				//スタッフコード・クラス名
				print('<table border="0">');
				print('<tr>');
				print('<td><b>スタッフコード(*)</b>&nbsp;&nbsp;<br>');
				print('<font size="5" color="red">' . $stf_cd . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('<td><b>スタッフ名(*)</b>&nbsp;&nbsp;<br>');
				print('<font size="5" color="gray">' . $stf_nm . '</font>&nbsp;&nbsp;<br>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</center>');
				
				print('<hr>');
				
			}else{
				
				//開始年月日
				$st_date = sprintf("%04d",$st_year).sprintf("%02d",$st_month).sprintf("%02d",$st_day);
				//終了年月日
				$ed_date = sprintf("%04d",$ed_year).sprintf("%02d",$ed_month).sprintf("%02d",$ed_day);


				$dbtrk_sts = 0;		//ＤＢ登録ステータス


				//スタッフマスタの登録
				//文字コード設定（insert/update時に必須）
				require( '../zz_mojicd.php' );
				
				$query = 'insert into M_STAFF values ("' . $DEF_kg_cd . '","' . $select_office_cd . '","' . $stf_cd . '",' .
						'ENCODE("' . $stf_nm . '","' . $ANGpw  . '"),ENCODE("' . $open_stf_nm . '","' . $ANGpw  . '"),ENCODE("303pittst","' . $ANGpw  . '"),';
				if( $class_cd1 == '' ){
					$query .= 'NULL,';
				}else{
					$query .= '"' . $class_cd1 . '",';
				}
				if( $class_cd2 == '' ){
					$query .= 'NULL,';
				}else{
					$query .= '"' . $class_cd2 . '",';
				}
				if( $class_cd3 == '' ){
					$query .= 'NULL,';
				}else{
					$query .= '"' . $class_cd3 . '",';
				}
				if( $class_cd4 == '' ){
					$query .= 'NULL,';
				}else{
					$query .= '"' . $class_cd4 . '",';
				}
				if( $class_cd5 == '' ){
					$query .= 'NULL,';
				}else{
					$query .= '"' . $class_cd5 . '",';
				}
				$query .= $ope_auth . ',' . $kanri_flg . ',' . $yukou_flg . ',"' . $st_date . '","' . $ed_date . '","' . $now_time .'","' . $staff_cd . '")';
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
					$log_naiyou = 'スタッフマスタの登録に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************

				}else{
					
					$dbtrk_sts = 1;
					
					//**トランザクション出力**
					$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'スタッフマスタを登録しました。[' . $select_office_cd . '-' . $stf_cd . ']';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************

				}
				
				//スタッフ連絡情報の登録
				if( $err_flg == 0 ){
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
				
					$query = 'insert into M_STAFF_RNR values ("' . $DEF_kg_cd . '","' . $select_office_cd . '","' . $stf_cd . '",';
					if( $stf_tel != '' ){
						$query .= 'ENCODE("' . $stf_tel . '","' . $ANGpw  . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw  . '"),';
					}
					if( $stf_mail != '' ){
						$query .= 'ENCODE("' . $stf_mail . '","' . $ANGpw  . '"),';
					}else{
						$query .= 'ENCODE(NULL,"' . $ANGpw  . '"),';
					}
					$query .= 'NULL,NULL,"' . $now_time . '","' . $staff_cd . '")';
					
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
						$log_naiyou = 'スタッフ連絡情報の登録に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
							
					}else{
						
						$dbtrk_sts = 2;
						
						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'スタッフ連絡情報を登録しました。[' . $select_office_cd . '-' . $stf_cd . ']';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************

					}
				}
				
				//スタッフログイン情報の登録
				if( $err_flg == 0 ){
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
				
					$query = 'insert into D_STAFF_LOGIN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '","' . $stf_cd . '",0,NULL,NULL,0);';
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
						$log_naiyou = 'スタッフログイン情報の登録に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
						
					
					}else{

						$dbtrk_sts = 3;

						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = 'スタッフマスタを登録しました。[' . $select_office_cd . '-' . $stf_cd . ']';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************

						
					}
				}
				
				if( $err_flg == 0 ){
					//正常登録
					
					//**ログ出力**
					$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = 'スタッフを登録しました。<br>オフィス[' . $Moffice_office_nm . '] スタッフ[' . $stf_nm . ']';	//内容
					$log_err_inf = '';			//エラー情報
					require( './zs_log.php' );
					//************

					print('<center>');
			
					//ページ編集
					print('<table bgcolor="pink"><tr><td width="950">');
					print('<img src="./img_' . $lang_cd . '/bar_kanri_staff.png" border="0">');
					print('</td></tr></table>');
			
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
					print('<form method="post" action="kanri_staff_select.php">');
					print('<td align="right">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" 	onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
	
					print('<hr>');
					
					print('<font color="blue">※登録しました。</font><br>');
				
					print('<table border="0">');
					print('<tr>');
					print('<td align="left">');
					
					//スタッフコード・スタッフ名・管理者フラグ
					print('<table border="0">');
					print('<tr>');
					print('<td><b>スタッフコード(*)</b>&nbsp;&nbsp;<br>');
					print('<font size="5" color="blue">' . $stf_cd . '</font>&nbsp;&nbsp;</font>');
					print('</td>');
					print('<td><b>スタッフ名(*)</b>&nbsp;&nbsp;&nbsp;&nbsp;<br>');
					print('<font size="5" color="blue">' . $stf_nm . '</font>&nbsp;&nbsp;&nbsp;&nbsp;</font>');
					print('</td>');
					print('<td><b>管理者フラグ</b><br>');
					if( $kanri_flg == 0 ){
						print('<font size="5" color="gray">管理者ではない</font>');
					}else{
						print('<font size="5" color="red">管理者</font>');
					}
					print('</td>');
					print('</tr>');
					print('</table>');

					//公開スタッフ名
					print('<table border="0">');
					print('<tr>');
					print('<td><b>会員サイトに表示するスタッフ名</b><br>');
					if( $open_stf_nm == '' ){
						print('<font size="5" color="gray">（未登録）</font>');
					}else{
						print('<font size="5" color="blue">' . $open_stf_nm . '</font>');
					}
					print('</td>');
					print('</tr>');
					print('</table>');

					//電話番号
					print('<table border="0">');
					print('<tr>');
					print('<td align="left"><b>電話番号</b>&nbsp;&nbsp;<br>');
					if( $stf_tel == '' ){
						print('<font size="5" color="gray">（未登録）</font>');
					}else{
						print('<font size="5" color="blue">' . $stf_tel . '</font>');
					}
					print('</td>');
					print('</tr>');
					print('</table>');
					
					//メールアドレス
					print('<table border="0">');
					print('<tr>');
					print('<td align="left" valign="top"><b>メールアドレス</b>&nbsp;&nbsp;<br>');
					if( $stf_mail == '' ){
						print('<font size="5" color="gray">（未登録）</font>');
					}else{
						print('<font size="4" color="blue">' . $stf_mail . '</font>&nbsp;&nbsp;');
					}
					print('</td>');
					print('</tr>');
					print('</table>');
		
					//予約種別１～５
					print('<table border="0">');
					print('<tr>');
					print('<td align="left" colspan="5"><b>予約種別</b>･･･カウンセラー／講師の場合は担当する予約種別を選択して下さい。</td>');
					print('</tr>');
					
					if( $class_cd1 == '' ){
						print('<tr>');
						print('<td colspan="5">');
						print('<font size="5" color="gray">（カウンセラー／講師ではない）</font>');
						print('</td>');
						print('</tr>');
						
					}else{
						print('<tr>');
						//予約種別（１）
						print('<td align="left">予約種別（１）<br>');
						if( $class_cd1 == '' ){
							print('<font size="2" color="gray">（未選択）</font>');
						}else{
							print('<font size="4" color="blue">' . $class_nm1 . '</font>&nbsp;&nbsp;');
						}
						print('</td>');
						
						//予約種別（２）
						print('<td align="left">予約種別（２）<br>');
						if( $class_cd2 == '' ){
							print('<font size="2" color="gray">（未選択）</font>');
						}else{
							print('<font size="4" color="blue">' . $class_nm2 . '</font>&nbsp;&nbsp;');
						}
						print('</td>');
			
						//予約種別（３）
						print('<td align="left">予約種別（３）<br>');
						if( $class_cd3 == '' ){
							print('<font size="2" color="gray">（未選択）</font>');
						}else{
							print('<font size="4" color="blue">' . $class_nm3 . '</font>&nbsp;&nbsp;');
						}
						print('</td>');
			
						//予約種別（４）
						print('<td align="left">予約種別（４）<br>');
						if( $class_cd4 == '' ){
							print('<font size="2" color="gray">（未選択）</font>');
						}else{
							print('<font size="4" color="blue">' . $class_nm4 . '</font>&nbsp;&nbsp;');
						}
						print('</td>');
			
						//予約種別（５）
						print('<td align="left">予約種別（５）<br>');
						if( $class_cd5 == '' ){
							print('<font size="2" color="gray">（未選択）</font>');
						}else{
							print('<font size="4" color="blue">' . $class_nm5 . '</font>&nbsp;&nbsp;');
						}
						print('</td>');
						
						print('</tr>');
					}
					print('</table>');

					//業務権限
					print('<table border="0">');
					print('<tr>');
					print('<td align="left"><b>業務権限</b>&nbsp;&nbsp;<br>');
					print('<font size="5" color="blue">' . sprintf("%03d",$ope_auth) . '</font>');
					print('</td>');
					print('</tr>');
					print('</table>');
		
					print('<br>');
					
					//有効期間
					print('<b>有効期間(*)</b>・・・上記スタッフの有効期間<br>');
					print('<table border="0">');
					print('<tr>');
					print('<td align="left">');
					print('開始日<br>');
					print('<font color="blue" size="5">&nbsp;<b>' . $st_year . '</b></font>');
					print('年');
					print('<font color="blue" size="5">&nbsp;<b>' . $st_month . '</b></font>');
					print('月');
					print('<font color="blue" size="5">&nbsp;<b>' . $st_day . '</b></font>');
					print('日 から');
					print('</td>');
					print('<td align="left">');
					print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
					print('<font color="blue" size="5">&nbsp;<b>' . $ed_year . '</b></font>');
					print('年');
					print('<font color="blue" size="5">&nbsp;<b>' . $ed_month . '</b></font>');
					print('月');
					print('<font color="blue" size="5">&nbsp;<b>' . $ed_day . '</b></font>');
					print('日 まで');
					print('</td>');
					print('</tr>');
					print('</table>');
		
					print('</td>');
					print('</tr>');
					print('</table>');
	
					//有効無効／登録ボタン／戻るボタン
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">');
					print('<b>有効／無効(*)</b><br>');
					if( $yukou_flg == 1 ){
						print('<font color="blue" size="5"><b>有効</b></font>');
					}else{
						print('<font color="red" size="5"><b>無効</b></font>');
					}
					print('<br><font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
					print('</td>');
					print('<td align="right">');
					print('<form method="post" action="kanri_staff_select.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
		
					print('</center>');
				
					print('<hr>');
					
				}else{
					//登録済みのＤＢを削除する
					
					if( $dbtrk_sts >= 1 ){
						//スタッフマスタの削除
						$query = 'delete from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
							$log_naiyou = 'スタッフマスタの削除に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
						
						}else{
	
							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'スタッフマスタを削除しました。[' . $select_office_cd . '-' . $stf_cd . ']';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
						}
					}

					if( $dbtrk_sts >= 2 ){
						//スタッフ連絡情報の削除
						$query = 'delete from M_STAFF_RNR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $stf_cd . '";';
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
							$log_naiyou = 'スタッフ連絡情報の削除に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
						}else{
	
							//**トランザクション出力**
							$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = $office_cd;	//オフィスコード
							$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
							$log_naiyou = 'スタッフ連絡情報を削除しました。[' . $select_office_cd . '-' . $stf_cd . ']';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************

						}
					}
				}
			}
		}
	}

	mysql_close( $link );
?>
</body>
</html>
