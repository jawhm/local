<?php
	//*********************************************************
	//  予約番号から予約内容を取得する
	//
	// [input]
	// $zz_yykinfo_yyk_no		: 予約番号
	//
	// [output]
	// $zz_yykinfo_rtncd		: リターンコード 0:正常 1:エラー 8:データなし
	// $zz_yykinfo_office_cd	: オフィスコード
	// $zz_yykinfo_office_nm	: オフィス名（ [オフィス]→[会場] に置換する）
	// $zz_yykinfo_class_cd		: クラスコード KBT:個別カウンセリング
	// $zz_yykinfo_ymd			: 年月日 [yyyy-mm-dd]形式
	// $zz_yykinfo_youbi_cd		: 曜日コード 0:日,1:月,2:火,3:水,4:木,5:金,6:土
	// $zz_yykinfo_eigyoubi_flg	: 営業日フラグ 0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
	// $zz_yykinfo_teikyubi_flg	: 定休日フラグ 0:営業日 1:定休日
	// $zz_yykinfo_jkn_kbn		: 時間区分
	// $zz_yykinfo_st_time		: 開始時刻 (HHii形式 数字4桁)
	// $zz_yykinfo_ed_time		: 終了時刻 (HHii形式 数字4桁)
	// $zz_yykinfo_kaiin_kbn	: 会員区分 0:仮登録 1:メンバー 9:一般（非メンバー）
	// $zz_yykinfo_kaiin_id		: 会員ＩＤ
	// $zz_yykinfo_kaiin_mixi	: 会員ＭＩＸＩ名
	// $zz_yykinfo_kaiin_nm		: 会員名
	// $zz_yykinfo_kaiin_nm_1	: 会員名（姓）
	// $zz_yykinfo_kaiin_nm_2	: 会員名（名）
	// $zz_yykinfo_kaiin_nm_k	: 会員名フリガナ
	// $zz_yykinfo_kaiin_nm_k_1	: 会員名フリガナ（セイ）
	// $zz_yykinfo_kaiin_nm_k_2	: 会員名フリガナ（メイ）
	// $zz_yykinfo_mailadr		: 会員メールアドレス [,]区切り
	// $zz_yykinfo_staff_cd		: カウンセラー指名したスタッフコード
	// $zz_yykinfo_staff_nm		: カウンセラー指名したスタッフ名
	// $zz_yykinfo_open_staff_nm: カウンセラー指名した公開スタッフ名
	// $zz_yykinfo_status		: ステータス 0:本人登録 1:スタッフ受付 2:非来店 3:来店 8:本人キャンセル登録 9:スタッフキャンセル登録
	// $zz_yykinfo_kyoumi		: 興味のある国
	// $zz_yykinfo_jiki			: 出発予定時期
	// $zz_yykinfo_soudan		: 相談内容
	// $zz_yykinfo_bikou		: 備考（予備）
	// $zz_yykinfo_znz_mail_send_flg	: 前日メール送信フラグ 0:未送信  1:前日メール送信済み
	// $zz_yykinfo_tjt_mail_send_flg	: 当日メール送信フラグ 0:未送信  1:当日メール送信済み
	// $zz_yykinfo_yyk_time		: 予約日時 [yyyy-mm-dd HH:ii:ss]形式
	// $zz_yykinfo_cancel_time	: キャンセル可能日時 [yyyy-mm-dd HH:ii:ss]形式
	// $zz_yykinfo_yyk_staff_cd	: 予約受付したスタッフコード
	// $zz_yykinfo_yyk_staff_nm	: 予約受付したスタッフ名
	//
	//*********************************************************
	if( $zz_yykinfo_yyk_no == "" ){
		//予約番号が未設定
		$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー 8:データなし
		
	}else{
		$zz_yykinfo_rtncd = 0;	//リターンコード 0:正常 1:エラー 8:データなし

		//予約内容を読み込む
		$zz_yykinfo_office_cd = "";			//オフィスコード
		$zz_yykinfo_class_cd = "";			//クラスコード
		$zz_yykinfo_ymd = "";				//年月日
		$zz_yykinfo_jkn_kbn = "";			//時間区分
		$zz_yykinfo_kaiin_kbn = "";			//会員区分
		$zz_yykinfo_kaiin_id = "";			//会員ＩＤ
		$zz_yykinfo_kaiin_mixi = "";		//会員ＭＩＸＩ名
		$zz_yykinfo_staff_cd = "";			//スタッフコード
		$zz_yykinfo_status = "";			//ステータス
		$zz_yykinfo_kyoumi = "";			//興味のある国
		$zz_yykinfo_jiki = "";				//出発予定時期
		$zz_yykinfo_soudan = "";			//相談内容
		$zz_yykinfo_bikou = "";				//備考（予備）
		$zz_yykinfo_znz_mail_send_flg = "";	//前日メール送信フラグ
		$zz_yykinfo_tjt_mail_send_flg = "";	//当日メール送信フラグ
		$zz_yykinfo_yyk_time = "";			//予約日時
		$zz_yykinfo_cancel_time = "";		//キャンセル可能日時
		$zz_yykinfo_yyk_staff_cd = "";		//予約受付スタッフコード
		$zz_yykinfo_youbi_cd = "";			//曜日コード

		$zz_yykinfo_cnt = 0;
		$zz_query = 'select OFFICE_CD,CLASS_CD,YMD,JKN_KBN,KAIIN_KBN,KAIIN_ID,MIXI,STAFF_CD,STATUS,DECODE(KYOUMI,"' . $ANGpw . '"),DECODE(JIKI,"' . $ANGpw . '"),DECODE(SOUDAN,"' . $ANGpw . '"),DECODE(BIKOU,"' . $ANGpw . '"),ZNZ_MAIL_SEND_FLG,TJT_MAIL_SEND_FLG,YYK_TIME,CANCEL_TIME,YYK_STAFF_CD from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and YYK_NO = "' . $zz_yykinfo_yyk_no . '";';
		$zz_result = mysql_query($zz_query);
		if (!$zz_result) {
			$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
			
		}else{
			while( $zz_row = mysql_fetch_array($zz_result) ){
				$zz_yykinfo_office_cd = $zz_row[0];				//オフィスコード
				$zz_yykinfo_class_cd = $zz_row[1];				//クラスコード
				$zz_yykinfo_ymd = $zz_row[2];					//年月日
				$zz_yykinfo_jkn_kbn = $zz_row[3];				//時間区分
				$zz_yykinfo_kaiin_kbn = $zz_row[4];				//会員区分
				$zz_yykinfo_kaiin_id = $zz_row[5];				//会員ＩＤ
				$zz_yykinfo_kaiin_mixi = $zz_row[6];			//会員ＭＩＸＩ名
				$zz_yykinfo_staff_cd = $zz_row[7];				//スタッフコード
				$zz_yykinfo_status = $zz_row[8];				//ステータス
				$zz_yykinfo_kyoumi = $zz_row[9];				//興味のある国
				$zz_yykinfo_jiki = $zz_row[10];					//出発予定時期
				$zz_yykinfo_soudan = $zz_row[11];				//相談内容
				$zz_yykinfo_bikou = $zz_row[12];				//備考（予備）
				$zz_yykinfo_znz_mail_send_flg = $zz_row[13];	//前日メール送信フラグ
				$zz_yykinfo_tjt_mail_send_flg = $zz_row[14];	//当日メール送信フラグ
				$zz_yykinfo_yyk_time = $zz_row[15];				//予約日時
				$zz_yykinfo_cancel_time = $zz_row[16];			//キャンセル可能日時
				$zz_yykinfo_yyk_staff_cd = $zz_row[17];			//予約受付スタッフコード
				
				//曜日コードを求める
				if( $zz_yykinfo_ymd != "" ){
					$zz_yykinfo_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($zz_yykinfo_ymd,5,2)), sprintf("%d",substr($zz_yykinfo_ymd,8,2)), sprintf("%d",substr($zz_yykinfo_ymd,0,4))));
				}else{
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
				}
				
				$zz_yykinfo_cnt++;
			}
		}
		
		if( $zz_yykinfo_cnt == 0 ){
			//データなしエラー
			$zz_yykinfo_rtncd = 8;	//リターンコード 0:正常 1:エラー 8:データなし
			
			$zz_yykinfo_ymd = date( "Y-m-d", time() );
			
			//予約キャンセルから対象日を求める
			$zz_query = 'select YMD from D_CLASS_YYK_CAN where KG_CD = "' . $DEF_kg_cd . '" and YYK_NO = "' . $select_yyk_no . '";';
			$zz_result = mysql_query($zz_query);
			if (!$zz_result) {
				$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
			
			}else{
				while( $zz_row = mysql_fetch_array($zz_result) ){
					$zz_yykinfo_ymd = $zz_row[0];	//年月日
				}
			}

		}else{
		
			//会場名（オフィス名）を取得する
			$zz_yykinfo_office_nm = "";	//オフィス名
			if( $zz_yykinfo_rtncd == 0 ){
				$zz_query = 'select OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '";';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
					
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_office_nm = $zz_row[0];	//オフィス名
					}
					
					//「オフィス」を「会場」に置換する
					$zz_yykinfo_office_nm = str_replace('オフィス','会場',$zz_yykinfo_office_nm );			
					
				}
			}

			//クラス名を取得する
			$zz_yykinfo_class_nm = "";	//クラス名
			if( $zz_yykinfo_rtncd == 0 ){
				$zz_query = 'select CLASS_NM from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '";';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
					
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_class_nm = $zz_row[0];	//クラス名
					}
				}
			}
	
			//時間帯を求める
			$zz_yykinfo_st_time = "";	//開始時刻
			$zz_yykinfo_ed_time = "";	//終了時刻
			if( $zz_yykinfo_rtncd == 0 ){
				$zz_query = 'select ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and ST_DATE <= "' . $zz_yykinfo_ymd . '" and ED_DATE >= "' . $zz_yykinfo_ymd . '" and YUKOU_FLG = 1;';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
					
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_st_time = $zz_row[0];	//開始時刻
						$zz_yykinfo_ed_time = $zz_row[1];	//終了時刻
					}
				}
			}
			
			//会員名を求める
			$zz_yykinfo_kaiin_nm = "";
			$zz_yykinfo_kaiin_nm_1 = "";
			$zz_yykinfo_kaiin_nm_2 = "";
			$zz_yykinfo_kaiin_nm_k = "";
			$zz_yykinfo_kaiin_nm_k_1 = "";
			$zz_yykinfo_kaiin_nm_k_2 = "";
			
			if( $zz_yykinfo_rtncd == 0 ){
				if( $zz_yykinfo_kaiin_kbn == 0 ){
					//仮登録（スタッフコードでスタッフ名を求める
					$zz_query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $zz_yykinfo_yyk_staff_cd . '";';
					$zz_result = mysql_query($zz_query);
					if (!$zz_result) {
						$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
											
					}else{
						while( $zz_row = mysql_fetch_array($zz_result) ){
							$zz_yykinfo_kaiin_nm = $zz_row[0];	//スタッフ名（仮登録者）
						}
					}
								
				}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
					//メンバー または 一般（無料メンバー）
										
					//初期値
					$zz_yykinfo_kaiin_nm = "取得エラー";
					
					//半角小文字を半角大文字に変換する
					$serch_id = strtoupper( $zz_yykinfo_kaiin_id );	//小文字を大文字にする
						
					// ＣＲＭに転送
					$data = array( 'pwd' => '303pittST'
								  ,'serch_id' => $serch_id
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
							$name = "data_name_0";
							$zz_yykinfo_kaiin_nm = $ret[$name];			//会員名
							$name = "data_name_k_0";
							$zz_yykinfo_kaiin_nm_k = $ret[$name];		//会員名ふりがな
							$name = "data_mail_0";
							$zz_yykinfo_mailadr = $ret[$name];			//会員メールアドレス
							
							if( $zz_yykinfo_kaiin_nm_k == "　" ){
								$zz_yykinfo_kaiin_nm_k = "";
							}
							
							//会員名を姓名に分ける
							$zz_yykinfo_kaiin_nm_1 = "";
							$zz_yykinfo_kaiin_nm_2 = "";
							$zz_tmp_pos = strpos($zz_yykinfo_kaiin_nm,"　");
							if( $tmp_pos !== false ){
								$zz_yykinfo_kaiin_nm_1 = substr($zz_yykinfo_kaiin_nm,0,$zz_tmp_pos);
								$zz_yykinfo_kaiin_nm_2 = substr($zz_yykinfo_kaiin_nm,($zz_tmp_pos+2), (strlen($zz_yykinfo_kaiin_nm) - $zz_tmp_pos - 2) );
							}else{
								$zz_yykinfo_kaiin_nm_1 = $zz_yykinfo_kaiin_nm;
							}
							
							//会員名フリガナをセイメイに分ける
							$zz_yykinfo_kaiin_nm_k_1 = "";
							$zz_yykinfo_kaiin_nm_k_2 = "";
							$zz_tmp_pos = strpos($zz_yykinfo_kaiin_nm_k,"　");
							if( $tmp_pos !== false ){
								$zz_yykinfo_kaiin_nm_k_1 = substr($zz_yykinfo_kaiin_nm_k,0,$zz_tmp_pos);
								$zz_yykinfo_kaiin_nm_k_2 = substr($zz_yykinfo_kaiin_nm_k,($zz_tmp_pos+2), (strlen($zz_yykinfo_kaiin_nm_k) - $zz_tmp_pos - 2) );
							}else{
								$zz_yykinfo_kaiin_nm_k_1 = $zz_yykinfo_kaiin_nm_k;
							}
						}
					}
										
				}else{
					//その他（ここは通らない）	
					$zz_yykinfo_kaiin_nm = "エラー";
										
				}
			}
			
			//カウンセラー指名の場合、スタッフ名を求める
			$zz_yykinfo_staff_nm = "";
			$zz_yykinfo_open_staff_nm = "";
			if( $zz_yykinfo_rtncd == 0 && $zz_yykinfo_staff_cd != "" ){
				$zz_query = 'select DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $zz_yykinfo_staff_cd . '";';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
										
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_staff_nm = $zz_row[0];		//スタッフ名
						$zz_yykinfo_open_staff_nm = $zz_row[1];	//公開スタッフ名
					}
				}
			}
		
			//予約受付スタッフ名を求める
			$zz_yykinfo_yyk_staff_nm = "";
			if( $zz_yykinfo_rtncd == 0 ){
				$zz_query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $zz_yykinfo_yyk_staff_cd . '";';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
										
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_yyk_staff_nm = $zz_row[0];	//スタッフ名（予約受付者）
					}
				}
			}
	
			//営業日フラグを求める
			$zz_yykinfo_eigyoubi_flg = 0;	//営業日フラグ 0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			if( $zz_yykinfo_rtncd == 0 ){
				//営業日フラグを求める
				$zz_query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and YMD  = "' . $zz_yykinfo_ymd . '";';
				$zz_result = mysql_query($zz_query);
				if (!$zz_result) {
					$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
						
				}else{
					while( $zz_row = mysql_fetch_array($zz_result) ){
						$zz_yykinfo_eigyoubi_flg = $zz_row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					}
				}
				
				if( $zz_yykinfo_eigyoubi_flg == 0 || $zz_yykinfo_eigyoubi_flg == 1 ){
					//定休日であるかチェックする
				
					//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
					$zz_yykinfo_Meigyojkn_cnt = 0;
					$zz_query = 'select YOUBI_CD,TEIKYUBI_FLG from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and YUKOU_FLG = 1 and ST_DATE <= "' . $zz_yykinfo_ymd . '" and ED_DATE >= "' . $zz_yykinfo_ymd . '" order by YOUBI_CD,ST_DATE;';
					$zz_result = mysql_query($zz_query);
					if (!$zz_result) {
						$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
						
					}else{
						while( $zz_row = mysql_fetch_array($zz_result) ){
							$zz_yykinfo_Meigyojkn_youbi_cd[$zz_yykinfo_Meigyojkn_cnt] = $zz_row[0];		//曜日コード  0:日,1:月,2:火,3:水,4:木,5:金,6:土,7:土日祝の前日.8:祝日
							$zz_yykinfo_Meigyojkn_teikyubi_flg[$zz_yykinfo_Meigyojkn_cnt] = $zz_row[1];	//定休日フラグ  0:営業日 1:定休日
							$zz_yykinfo_Meigyojkn_cnt++;
						}
					}
					
					//定休日フラグを求める
					$zz_yykinfo_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
					if( $select_eigyoubi_flg == 1 || $select_eigyoubi_flg == 9 ){
						//祝日のみ対応（土日祝の前日は非対応）
						$zz_idx = 0;
						$zz_find_flg = 0;
						while( $zz_idx < $zz_yykinfo_Meigyojkn_cnt && $zz_find_flg == 0 ){
							if( $zz_yykinfo_Meigyojkn_youbi_cd[$zz_idx] == 8 ){
								$zz_yykinfo_teikyubi_flg = $zz_yykinfo_Meigyojkn_teikyubi_flg[$zz_idx];
								$find_flg = 1;
							}
							$zz_idx++;
						}
						
						if( $zz_yykinfo_teikyubi_flg != 1 ){
							//曜日で検索しなおし
							$zz_idx = 0;
							$zz_find_flg = 0;
							while( $zz_idx < $zz_yykinfo_Meigyojkn_cnt && $zz_find_flg == 0 ){
								if( $zz_yykinfo_Meigyojkn_youbi_cd[$zz_idx] == $zz_yykinfo_youbi_cd ){
									$zz_yykinfo_teikyubi_flg = $zz_yykinfo_Meigyojkn_teikyubi_flg[$zz_idx];
									$find_flg = 1;
								}
								$zz_idx++;
							}
						}
					}
					
				}else{
					//非祝日
					$zz_idx = 0;
					$zz_find_flg = 0;
					while( $zz_idx < $zz_yykinfo_Meigyojkn_cnt && $zz_find_flg == 0 ){
						if( $zz_yykinfo_Meigyojkn_youbi_cd[$zz_idx] == $zz_yykinfo_youbi_cd ){
							$zz_yykinfo_teikyubi_flg = $zz_yykinfo_Meigyojkn_teikyubi_flg[$zz_idx];
							$find_flg = 1;
						}
						$zz_idx++;
					}
				}
				
				//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
				if( $zz_yykinfo_teikyubi_flg == 1 ){
					$zz_query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and YMD = "' . $zz_yykinfo_ymd . '";';
					$zz_result = mysql_query($zz_query);
					if (!$zz_result) {
						$zz_yykinfo_rtncd = 1;	//リターンコード 0:正常 1:エラー
									
					}else{
						while( $zz_row = mysql_fetch_array($zz_result) ){
							if( $zz_row[0] != "" ){
								//個別の開店時間があれば定休日を解除する
								$select_teikyubi_flg = 0;
							}
						}
					}
				}
				
				//定休日の場合、営業日フラグを調整する
				if( $zz_yykinfo_teikyubi_flg == 1 ){
					if( $zz_yykinfo_eigyoubi_flg == 0 ){
						$zz_yykinfo_eigyoubi_flg = 8;
					}else if( $zz_yykinfo_eigyoubi_flg == 1 ){
						$zz_yykinfo_eigyoubi_flg = 9;
					}
				}
			}
		}
	}
?>