<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>管理画面－予約種別時間割（更新）確認</title>
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
	$gmn_id = 'kanri_classtime_ksn1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_classtime_ksn0.php','kanri_classtime_ksn1.php');

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
	$select_office_cd = $_POST['select_office_cd'];	//選択したオフィスコード
	$select_class_cd = $_POST['select_class_cd'];	//選択したクラスコード
	$select_st_date = $_POST['select_st_date'];
	$select_ed_date = $_POST['select_ed_date'];
	$lock_flg = $_POST['lock_flg'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_class_cd == "" || $select_st_date == "" || $select_ed_date == "" || $lock_flg == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//固有引数の取得
		$i = 0;
		while( $i < 48 ){
			$name = 'jyoren' . $i;
			$jyoren[$i] = $_POST[$name];	//常連フラグ　"on"：チェックあり => 1に変換
			if( $jyoren[$i] == 'on' || $jyoren[$i] == 1 ){
				$jyoren[$i] = 1;
			}else{
				$jyoren[$i] = 0;
			}
			$name = 'st_time' . $i;
			$st_time[$i] = $_POST[$name];	//開始時刻
			$name = 'ed_time' . $i;
			$ed_time[$i] = $_POST[$name];	//終了時刻
			
			$i++;
		}
		$yukou_flg = $_POST['yukou_flg'];	//有効フラグ
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日

		$err_sts = 0;	//エラーステータス  0:エラーなし 1:数字・範囲エラー  2:時間重複エラー

		//入力チェック
		$mdata_ttl_cnt = 0;		//合計明細データカウンタ
		$mdata_ttl_err_cnt = 0;	//再整列後のエラーカウンタ
		$mdata_ipn_cnt = 0;		//一般向け明細データカウンタ
		$mdata_jrn_cnt = 0;		//常連向け明細データカウンタ
		
		
		$i = 0;
		while( $i < 48 ){
			//常連フラグ・開始時刻・終了時刻のいずれかに入力がある場合、エラーチェックを実施する
			if( $jyoren[$i] == 1 || $st_time[$i] != '' || $ed_time[$i] != '' ){
				//開始時刻
				$err_st_time[$i] = 0;
				if( $st_time[$i] == ''){
					$err_st_time[$i] = 1;
					$err_sts = 1;	//1:数字・範囲エラー
				}else{
					if( is_numeric($st_time[$i]) ){
						$st_time[$i] = sprintf("%04d",$st_time[$i]);
						$div = intval($st_time[$i] / 100);
						$mod = $st_time[$i] % 100;
						if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
							$err_st_time[$i] = 1;
							$err_sts = 1;	//1:数字・範囲エラー
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_st_time[$i] = 1;
							$err_sts = 1;	//1:数字・範囲エラー
						}
					}else{
						$err_st_time[$i] = 1;
						$err_sts = 1;	//1:数字・範囲エラー
					}
				}
				//終了時刻
				$err_ed_time[$i] = 0;
				if( $ed_time[$i] == ''){
					$err_ed_time[$i] = 1;
					$err_sts = 1;	//1:数字・範囲エラー
				}else{
					if( is_numeric($ed_time[$i]) ){
						$ed_time[$i] = sprintf("%04d",$ed_time[$i]);
						$div = intval($ed_time[$i] / 100);
						$mod = $ed_time[$i] % 100;
						if(	$div  < 0 || $div >= 25 ){	//25時以降の入力はエラー
							$err_ed_time[$i] = 1;
							$err_sts = 1;	//1:数字・範囲エラー
						}
						if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
							$err_ed_time[$i] = 1;
							$err_sts = 1;	//1:数字・範囲エラー
						}
					}else{
						$err_ed_time[$i] = 1;
						$err_sts = 1;	//1:数字・範囲エラー
					}
				}
				//開始時刻と終了時刻の比較
				if( $data_err_flg[$i] == 0 ){
					if( $st_time[$i] >= $ed_time[$i] ){
						$err_ed_time[$i] = 1;
						$err_sts = 1;	//1:数字・範囲エラー
					}
				}
			}
			$i++;
		}

		//日付チェック
		$err_st_year = 0;
		if($st_year == ''){
			$err_st_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if(!ereg('[0-9]{4}',$st_year)){
			$err_st_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if( $st_year < 2011 ){
			$err_st_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}

		$err_st_month = 0;
		if($st_month == ''){
			$err_st_month = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}elseif(!ereg('[1-9]',$st_month) or $st_month < 1 or $st_month > 12){
			$err_st_month = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}

		$err_st_day = 0;
		if( $err_st_year == 0 && $err_st_month == 0 ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $st_month , $st_year );
			if($st_day == ''){
				$err_st_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			}elseif(!ereg('[1-9]',$st_day) or $st_day < 1 or $st_day > $DFmaxdd ){
				$err_st_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			}
		}else{
			$err_st_day = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}
		
		//有効期間（終了年月日）
		$err_ed_year = 0;
		if($ed_year == ''){
			$err_ed_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if(!ereg('[0-9]{4}',$ed_year)){
			$err_ed_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if( $ed_year < $now_yyyy || $ed_year >= 2038 ){
			$err_ed_year = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}
		
		$err_ed_month = 0;
		if($ed_month == ''){
			$err_ed_month = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if(!ereg('[1-9]',$ed_month) or $ed_month < 1 or $ed_month > 12){
			$err_ed_month = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}else if( $ed_year == $now_yyyy && $ed_month < $now_mm ){
			$err_ed_month = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}

		$err_ed_day = 0;
		if( $err_ed_year == 0 && $err_ed_month == 0 ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $ed_month , $ed_year );
			if($ed_day == ''){
				$err_ed_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			}else if(!ereg('[1-9]',$ed_day) or $ed_day < 1 or $ed_day > $DFmaxdd ){
				$err_ed_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			}else if( $ed_year == $now_yyyy && $ed_month == $now_mm && $ed_day < $now_dd ){
				$err_ed_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			}
		}else{
			$err_ed_day = 1;
			$err_sts = 1;	//1:数字・範囲エラー
		}
		
		//日付の逆転チェックと予約有無確認
		if( $err_cnt == 0 ){
			
			$old_st_date = substr($select_st_date,0,4) . substr($select_st_date,5,2) . substr($select_st_date,8,2);
			$old_ed_date = substr($select_ed_date,0,4) . substr($select_ed_date,5,2) . substr($select_ed_date,8,2);
			$new_st_date = $st_year . sprintf("%02d",$st_month) . sprintf("%02d",$st_day);
			$new_ed_date = $ed_year . sprintf("%02d",$ed_month) . sprintf("%02d",$ed_day);
			
			if( $new_st_date > $new_ed_date ){
				//開始日と終了日が逆転しているので開始日と終了日をエラーとする
				$err_st_year = 1;
				$err_st_month = 1;
				$err_st_day = 1;
				$err_ed_year = 1;
				$err_ed_month = 1;
				$err_ed_day = 1;
				$err_sts = 1;	//1:数字・範囲エラー
			
			}else{
				
				//変更前の適用期間から除外される期間に予約があるか確認する	
				if( $new_st_date > $old_st_date ){
					//適用開始日から除外される期間に予約があるか？				
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD ="' . $select_class_cd . '" and YMD >= "' . $old_st_date . '" and YMD < "' . $new_st_date . '";';
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
						$row = mysql_fetch_array($result);
						if( $row[0] > 0 ){
							//予約データがあるので開始日をエラーとする
							$err_st_year = 3;
							$err_st_month = 3;
							$err_st_day = 3;
							$err_sts = 1;	//1:数字・範囲エラー
						}
					}
				}
				
				if( $new_ed_date < $old_ed_date ){
					//適用終了日から除外される期間に予約があるか？				
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD ="' . $select_class_cd . '" and YMD <= "' . $old_ed_date . '" and YMD > "' . $new_ed_date . '";';
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
						$row = mysql_fetch_array($result);
						if( $row[0] > 0 ){
							//予約データがあるので終了日をエラーとする
							$err_ed_year = 3;
							$err_ed_month = 3;
							$err_ed_day = 3;
							$err_sts = 1;	//1:数字・範囲エラー
						}
					}
				}
			}
		}

		//有効期間の重複チェック
		if( $err_sts == 0 ){
			//現在登録されている開始日・終了日を求める
			$query = 'select distinct(ST_DATE),ED_DATE from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD ="' . $select_class_cd . '" and ST_DATE != "' . $select_st_date . '" order by ST_DATE;';
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
				$trk_cnt = 0;
				while( $row = mysql_fetch_array($result)){
					$trk_st_date[$trk_cnt] = substr( $row[0],0,4) . substr( $row[0],5,2) . substr( $row[0],8,2);
					$trk_ed_date[$trk_cnt] = substr( $row[1],0,4) . substr( $row[1],5,2) . substr( $row[1],8,2);
					$trk_cnt++;					
				}
				//今回登録予定の有効期間を配列に含める
				$trk_st_date[$trk_cnt] = $st_year . sprintf("%02d",$st_month) . sprintf("%02d",$st_day);
				$trk_ed_date[$trk_cnt] = $ed_year . sprintf("%02d",$ed_month) . sprintf("%02d",$ed_day);
				$trk_cnt++;					

				$i = 0;
				while( $i < $trk_cnt ){
					$j = 0;
					while( $j < $trk_cnt ){
						if( $i != $j ){
							//開始時刻が他の時間帯に含まれる
							if( $trk_st_date[$j] <= $trk_st_date[$i] && $trk_st_date[$i] <= $trk_ed_date[$j] ){
								$err_st_year = 2;
								$err_st_month = 2;
								$err_st_day = 2;
								$err_ed_year = 2;
								$err_ed_month = 2;
								$err_ed_day = 2;
								$err_sts = 1;	//1:数字・範囲エラー
							}
							//終了時刻が他の時間帯に含まれる
							if( $trk_st_date[$j] <= $trk_ed_date[$i] && $trk_ed_date[$i] <= $trk_ed_date[$j] ){
								$err_st_year = 2;
								$err_st_month = 2;
								$err_st_day = 2;
								$err_ed_year = 2;
								$err_ed_month = 2;
								$err_ed_day = 2;
								$err_sts = 1;	//1:数字・範囲エラー
							}
						}
						$j++;
					}
					$i++;
				}
			}
		}

		//入力チェックにてエラーが無ければ開始時刻の昇順で再整列する
		if( $err_sts == 0 ){
			$i = 0;
			while( $i < 48 ){
				if( $st_time[$i] != '' ){
					$set_flg = 0;	//セットフラグ（配列にセットしたら 1 ）
					$j = 0;
					while( $j < $mdata_ttl_cnt ){
						if( $st_time[$i] < $mdata_st_time[$j] ){
							//[$j]以降を１つずらす
							$k = $mdata_ttl_cnt;
							while( $k != $j ){
								$mdata_jyoren[$k] = $mdata_jyoren[($k - 1)];
								$mdata_st_time[$k] = $mdata_st_time[($k - 1)];
								$mdata_ed_time[$k] = $mdata_ed_time[($k - 1)];
								$k--;
							}
							//間に入れる
							$mdata_jyoren[$j] = $jyoren[$i];
							$mdata_st_time[$j] = $st_time[$i];
							$mdata_ed_time[$j] = $ed_time[$i];
							$mdata_ttl_cnt++;
							$set_flg = 1;
							$j =  $mdata_ttl_cnt;
						}else{
							$j++;
						}
					}
					if( $set_flg == 0 ){
						$mdata_jyoren[$j] = $jyoren[$i];
						$mdata_st_time[$j] = $st_time[$i];
						$mdata_ed_time[$j] = $ed_time[$i];
						$mdata_ttl_cnt++;
						$set_flg = 1;
					}
				}
				$i++;
			}
		
			//再整列後のデータチェック
			$i = 0;
			while( $i < $mdata_ttl_cnt ){
				$mdata_err_st_time[$i] = 0;
				$mdata_err_ed_time[$i] = 0;
				$j = 0;
				while( $j < $mdata_ttl_cnt ){
					if( $i != $j ){
						//開始時刻が他の時間帯に含まれる
						if( $mdata_st_time[$j] < $mdata_st_time[$i] && $mdata_st_time[$i] < $mdata_ed_time[$j] ){
							$mdata_err_st_time[$i] = 1;
							$err_sts = 2;	//2:時間重複エラー
						}
						//終了時刻が他の時間帯に含まれる
						if( $mdata_st_time[$j] < $mdata_ed_time[$i] && $mdata_ed_time[$i] < $mdata_ed_time[$j] ){
							$mdata_err_ed_time[$i] = 1;
							$err_sts = 2;	//2:時間重複エラー
						}
					}
					$j++;
				}
				$i++;
			}
			if( $mdata_ttl_err_cnt == 0 ){
				//時間区分を設定する
				$i = 0;
				while( $i < $mdata_ttl_cnt ){
					if( $mdata_jyoren[$i] == 0 ){
						$mdata_jkn_kbn[$i] = $jkn_kbn_array_1[$mdata_ipn_cnt];
						$mdata_ipn_cnt++;
					}else{
						$mdata_jkn_kbn[$i] = $jkn_kbn_array_2[$mdata_jrn_cnt];
						$mdata_jrn_cnt++;
					}
			
					$i++;
				}
			}
		}
		
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
			$Moffice_office_nm = $row[0];	//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}
				
		//クラスマスタの取得
		$select_class_nm = '';
		$query = 'select CLASS_NM from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "' . $select_class_cd . '"';
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
			$row = mysql_fetch_array($result);
			$select_class_nm = $row[0];	//クラス名
			
		}


		if( $err_flg == 0 ){
			
			//明細データにエラーがあるか？
			if( $err_sts == 0 ){
				//エラーなし

				print('<center>');
		
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_classjknwr.png" border="0">');
				print('</td></tr></table>');
	
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_classtime_ksn0.php">');
				print('<td align="right" rowspan="2">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				$i = 0;
				while( $i < 48 ){
					print('<input type="hidden" name="jyoren' . $i . '" value="' . $mdata_jyoren[$i] . '">');
					print('<input type="hidden" name="st_time' . $i . '" value="' . $mdata_st_time[$i] . '">');
					print('<input type="hidden" name="ed_time' . $i . '" value="' . $mdata_ed_time[$i] . '">');
					$i++;
				}
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_classnm.png"><br><font size="5" color="blue">' . $select_class_nm . '</font></td>');
				print('</tr>');			
				print('</table>');
	
				print('<hr>');
				
				print('<font color="blue">※以下の内容でよろしければ登録ボタンを押下してください。</font><br><font color="red" size="2">（まだ登録されていません。）</font><br>');

				print('<table border="1">');
				print('<tr bgcolor="powderblue">');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th></tr>');
				$i = 0;
				while( $i < 16 ){	//16x3
					print('<tr>');
					//１列目（１～１６）
					print('<td bgcolor="powderblue" align="center">' . ($i + 1) . '</td>');
					if( $mdata_jyoren[$i] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $mdata_st_time[$i] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					if( $mdata_jyoren[$i] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');
					}
					print('</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_st_time[$i] . '</font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_ed_time[$i] . '</font></td>');
					//２列目（１７～３２）
					print('<td bgcolor="powderblue" align="center">' . ($i + 17) . '</td>');
					if( $mdata_jyoren[($i+16)] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $mdata_st_time[($i+16)] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					if( $mdata_jyoren[($i + 16)] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');
					}
					print('</td>');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_st_time[($i + 16)] . '</font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_ed_time[($i + 16)] . '</font></td>');
					//３列目（３３～４８）
					print('<td bgcolor="powderblue" align="center">' . ($i + 33) . '</td>');
					if( $mdata_jyoren[($i+32)] == 1 ){
						$bgfile = 'bg_yellow';
					}else if( $mdata_st_time[($i+32)] != "" ){
						$bgfile = 'bg_mizu';
					}else{
						$bgfile = 'bg_lightgrey';
					}
					print('<td align="center"  background="../img_' . $lang_cd . '/' . $bgfile . '_40x20.png">');
					if( $mdata_jyoren[($i + 32)] == 1 ){
						print('<font size="2" color="blue">会員</font>');
					}else{
						print('&nbsp;');
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_st_time[($i + 32)] . '</font></td>');
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><font size="5" color="blue">' . $mdata_ed_time[($i + 32)] . '</font></td>');
					print('</tr>');
					$i++;
				}
				print('</table>');
	
				print('<br>');
		
				//有効期間
				print('<b>有効期間(*)</b>・・・予約種別時間割の有効期間<br>');
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
				print('<form method="post" action="kanri_classtime_ksn2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');
				$i = 0;
				while( $i < 48 ){
					print('<input type="hidden" name="jyoren' . $i . '" value="' . $mdata_jyoren[$i] . '">');
					print('<input type="hidden" name="jkn_kbn' . $i . '" value="' . $mdata_jkn_kbn[$i] . '">');
					print('<input type="hidden" name="st_time' . $i . '" value="' . $mdata_st_time[$i] . '">');
					print('<input type="hidden" name="ed_time' . $i . '" value="' . $mdata_ed_time[$i] . '">');
					$i++;
				}
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_classtime_ksn0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');
				$i = 0;
				while( $i < 48 ){
					print('<input type="hidden" name="jyoren' . $i . '" value="' . $mdata_jyoren[$i] . '">');
					print('<input type="hidden" name="st_time' . $i . '" value="' . $mdata_st_time[$i] . '">');
					print('<input type="hidden" name="ed_time' . $i . '" value="' . $mdata_ed_time[$i] . '">');
					$i++;
				}
				print('<input type="hidden" name="yukou_flg" value="' . $yukou_flg . '">');
				print('<input type="hidden" name="st_year" value="' . $st_year . '">');
				print('<input type="hidden" name="st_month" value="' . $st_month . '">');
				print('<input type="hidden" name="st_day" value="' . $st_day . '">');
				print('<input type="hidden" name="ed_year" value="' . $ed_year . '">');
				print('<input type="hidden" name="ed_month" value="' . $ed_month . '">');
				print('<input type="hidden" name="ed_day" value="' . $ed_day . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
		
				print('</center>');
				
				print('<hr>');


			}else if( $err_sts == 1 ){
				//エラーがある場合（数字・範囲エラー：並び替えなし）
				
				print('<center>');
		
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_classjknwr.png" border="0">');
				print('</td></tr></table>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_classtime_select_2.php">');
				print('<td align="right" rowspan="2">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_classnm.png"><br><font size="5" color="blue">' . $select_class_nm . '</font></td>');
				print('</tr>');			
				print('</table>');
	
				print('<hr>');
				
				print('<font color="red">※エラーの箇所があります。</font><br>');
				print('入力例：９時００分は 900 、１５時３０分は 1530 で入力してください。<br>');
				print('（メンバーのみ利用可能な時間割は会員にチェックしてください。）<br>');
	
				print('<form name="form2" method="post" action="kanri_classtime_ksn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');
	
				print('<table border="1">');
				print('<tr bgcolor="powderblue">');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th></tr>');
				$i = 0;
				while( $i < 16 ){	//16x3
					print('<tr>');
					//通番（１列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 1) . '</td>');
					//常連（１列目）
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 1) . '"');
					if( $jyoren[$i] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
					//開始時刻（１列目）
					if( $err_st_time[$i] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 2) . '" value="' . $st_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_st_time[$i] != 0 ){
						print('err');
					}else{
						print('normal');	
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（１列目）
					if( $err_ed_time[$i] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 3) . '" value="' . $ed_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_ed_time[$i] != 0 ){
						print('err');
					}else{
						print('normal');	
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					
					//通番（２列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 17) . '</td>');
					//常連（２列目）
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . ($i + 16) . '" tabindex="' . ($tabindex + 48 + ($i * 3) +  1) . '"');
					if( $jyoren[($i + 16)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
					//開始時刻（２列目）
					if( $err_st_time[($i + 16)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . ($i + 16) . '" value="' . $st_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_st_time[($i + 16)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（２列目）
					if( $err_ed_time[($i + 16)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . ($i + 16) . '" value="' . $ed_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_ed_time[($i + 16)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					
					//通番（３列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 33) . '</td>');
					//常連（３列目）
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . ($i + 32) . '" tabindex="' . ($tabindex + 96 + ($i * 3) +  1) . '"');
					if( $jyoren[($i + 32)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					//開始時刻（３列目）
					if( $err_st_time[($i + 32)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . ($i + 32) . '" value="' . $st_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_st_time[($i + 32)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（３列目）
					if( $err_ed_time[($i + 32)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . ($i + 32) . '" value="' . $ed_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $err_ed_time[($i + 32)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					print('</tr>');
					$i++;
				}
				print('</table>');
	
				$tabindex += (48*3);
				
				print('<br>');
	
				//有効期間

				print('<b>有効期間(*)</b>・・・予約種別時間割の有効期間<br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				$tabindex++;
				print('<select name="st_year" class="');
				if( $err_st_year == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 2012;
				while( $i < 2038 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="st_month" class="');
				if( $err_st_month == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 13 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="st_day" class="');
				if( $err_st_day == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_day ){
						print('selected');
					}
						print('>' . $i. '</option>');
				
					$i++;
				}
					print('</select>');
				print('日 から');
				if( $err_st_year == 2 && $err_st_month == 2 && $err_st_day == 2 ){
					print('<br><font color="red">※期間重複あり</font>');	
				}else if( $err_st_year == 3 && $err_st_month == 3 && $err_st_day == 3 ){
					print('<br><font color="red">※除外期間に予約データあり</font>');	
				}else if( $err_st_year == 1 || $err_st_month == 1 || $err_st_day == 1 ){
					print('<br><font color="red">※エラー</font>');	
				}
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				$tabindex++;
				print('<select name="ed_year" class="');
				if( $err_ed_year == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 2012;
				while( $i < 2038 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="ed_month" class="');
				if( $err_ed_month == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 13 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
			
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="ed_day" class="');
				if( $err_ed_day == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_day ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('日 まで');
				if( $err_ed_year == 2 && $err_ed_month == 2 && $err_ed_day == 2 ){
					print('<br><font color="red">※期間重複あり</font>');	
				}else if( $err_ed_year == 3 && $err_ed_month == 3 && $err_ed_day == 3 ){
					print('<br><font color="red">※除外期間に予約データあり</font>');	
				}else if( $err_ed_year == 1 || $err_ed_month == 1 || $err_ed_day == 1 ){
					print('<br><font color="red">※エラー</font>');	
				}
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
				$tabindex++;
				print('<select name="yukou_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
				if( $yukou_flg == 0 ){
					print('<option value="0" selected>無効</option>');
					print('<option value="1">有効</option>');
				}else{
					if(	$lock_flg == 1 ){
						print('<option value="1" selected>有効</option>');
					}else{
						print('<option value="0">無効</option>');
						print('<option value="1" selected>有効</option>');
					}
				}
				print('</select>');
				print('<font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
				print('</td>');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_classtime_select_2.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('</center>');

				print('<hr>');
				
				
			}else{
				//エラーがある場合（時間重複：並び替え後）
				
				print('<center>');
		
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_classjknwr.png" border="0">');
				print('</td></tr></table>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_classtime_select_2.php">');
				print('<td align="right" rowspan="2">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_classnm.png"><br><font size="5" color="blue">' . $select_class_nm . '</font></td>');
				print('</tr>');			
				print('</table>');
	
				print('<hr>');
				
				print('<font color="red">※時刻が重複している箇所があります。</font><br>');
				print('入力例：９時００分は 900 、１５時３０分は 1530 で入力してください。<br>');
				print('（メンバーのみ利用可能な時間割は会員にチェックしてください。）<br>');
	
				print('<form name="form2" method="post" action="kanri_classtime_ksn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
				print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
				print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
				print('<input type="hidden" name="lock_flg" value="' . $lock_flg . '">');
	
				print('<table border="1">');
				print('<tr bgcolor="powderblue">');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th>');
				print('<th width="40"><font size="2">通番</font></th>');
				print('<th width="40"><font size="2">会員</font></th>');
				print('<th width="80">開始時刻</th>');
				print('<th width="80">終了時刻</th></tr>');
				$i = 0;
				while( $i < 16 ){	//16x3
					print('<tr>');
					//通番（１列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 1) . '</td>');
					//常連（１列目）
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 1) . '"');
					if( $mdata_jyoren[$i] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
					//開始時刻（１列目）
					if( $mdata_err_st_time[$i] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 2) . '" value="' . $mdata_st_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_st_time[$i] != 0 ){
						print('err');
					}else{
						print('normal');	
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（１列目）
					if( $mdata_err_ed_time[$i] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . $i . '" tabindex="' . ($tabindex + ($i * 3) + 3) . '" value="' . $mdata_ed_time[$i] . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_ed_time[$i] != 0 ){
						print('err');
					}else{
						print('normal');	
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					
					//通番（２列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 17) . '</td>');
					//常連（２列目）
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . ($i + 16) . '" tabindex="' . ($tabindex + 48 + ($i * 3) +  1) . '"');
					if( $mdata_jyoren[($i + 16)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					print('</td>');
					//開始時刻（２列目）
					if( $mdata_err_st_time[($i + 16)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . ($i + 16) . '" value="' . $mdata_st_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_st_time[($i + 16)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（２列目）
					if( $mdata_err_ed_time[($i + 16)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . ($i + 16) . '" value="' . $mdata_ed_time[($i + 16)] . '" tabindex="' . ($tabindex + 48 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_ed_time[($i + 16)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					
					//通番（３列目）
					print('<td bgcolor="powderblue" align="center">' . ($i + 33) . '</td>');
					//常連（３列目）
					print('<td align="center"  background="../img_' . $lang_cd . '/bg_mizu_40x20.png"><input type="checkbox" name="jyoren' . ($i + 32) . '" tabindex="' . ($tabindex + 96 + ($i * 3) +  1) . '"');
					if( $mdata_jyoren[($i + 32)] == 1 ){
						print(' checked>');
					}else{
						print('>');
					}
					//開始時刻（３列目）
					if( $mdata_err_st_time[($i + 32)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="st_time' . ($i + 32) . '" value="' . $mdata_st_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 2) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_st_time[($i + 32)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					//終了時刻（３列目）
					if( $mdata_err_ed_time[($i + 32)] != 0 ){
						$bgfile = 'bg_red';
					}else{
						$bgfile = 'bg_mizu';
					}
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png"><input type="text" name="ed_time' . ($i + 32) . '" value="' . $mdata_ed_time[($i + 32)] . '" tabindex="' . ($tabindex + 96 + ($i * 3) + 3) . '" style="ime-mode:disabled; font-size: 24px;" size="4" maxlength="4" class="');
					if( $mdata_err_ed_time[($i + 32)] != 0 ){
						print('err');
					}else{
						print('normal');
					}
					print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" ></td>');
					print('</tr>');
					$i++;
				}
				print('</table>');
	
				$tabindex += (48*3);
				
				print('<br>');
	
				//有効期間
				print('<b>有効期間(*)</b>・・・予約種別時間割の有効期間<br>');
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('開始日<br>');
				$tabindex++;
				print('<select name="st_year" class="');
				if( $err_st_year == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 2012;
				while( $i < 2038 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="st_month" class="');
				if( $err_st_month == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 13 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="st_day" class="');
				if( $err_st_day == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $st_day ){
						print('selected');
					}
						print('>' . $i. '</option>');
				
					$i++;
				}
					print('</select>');
				print('日 から');
				if( $err_st_year == 2 && $err_st_month == 2 && $err_st_day == 2 ){
					print('<br><font color="red">※期間重複あり</font>');	
				}else if( $err_st_year == 3 && $err_st_month == 3 && $err_st_day == 3 ){
					print('<br><font color="red">※除外期間に予約データあり</font>');	
				}else if( $err_st_year == 1 || $err_st_month == 1 || $err_st_day == 1 ){
					print('<br><font color="red">※エラー</font>');	
				}
				print('</td>');
				print('<td align="left">');
				print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
				$tabindex++;
				print('<select name="ed_year" class="');
				if( $err_ed_year == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 2012;
				while( $i < 2038 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="ed_month" class="');
				if( $err_ed_month == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 13 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
			
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="ed_day" class="');
				if( $err_ed_day == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $ed_day ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('日 まで');
				if( $err_ed_year == 2 && $err_ed_month == 2 && $err_ed_day == 2 ){
					print('<br><font color="red">※期間重複あり</font>');	
				}else if( $err_ed_year == 3 && $err_ed_month == 3 && $err_ed_day == 3 ){
					print('<br><font color="red">※除外期間に予約データあり</font>');	
				}else if( $err_ed_year == 1 || $err_ed_month == 1 || $err_ed_day == 1 ){
					print('<br><font color="red">※エラー</font>');	
				}
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
				$tabindex++;
				print('<select name="yukou_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
				if( $yukou_flg == 0 ){
					print('<option value="0" selected>無効</option>');
					print('<option value="1">有効</option>');
				}else{
					if(	$lock_flg == 1 ){
						print('<option value="1" selected>有効</option>');
					}else{
						print('<option value="0">無効</option>');
						print('<option value="1" selected>有効</option>');
					}
				}
				print('</select>');
				print('<font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
				print('</td>');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_classtime_select_2.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_class_cd" value="' . $select_class_cd . '">');
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
?>
</body>
</html>