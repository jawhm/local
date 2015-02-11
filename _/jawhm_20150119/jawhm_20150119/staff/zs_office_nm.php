<?php
	//オフィス名取得
	//オフィスマスタ：オフィスコードから店舗名を求める
	
	//店舗コードの入力チェック
	if( $office_cd == "" ){
		//未入力なので 名称も空白
		$office_nm = '';
	}else{
		//オフィスマスタを読み込む
		$STF_query = 'select OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '";';
		$STF_result = mysql_query($STF_query);
		if (!$STF_result) {
			//参照失敗
			$office_nm = 'オフィス名取得エラー';
			
		}else{
			$STF_row = mysql_fetch_array($STF_result);
			//データの格納
			$office_nm = $STF_row[0];	//オフィス名
		}
	}
?>