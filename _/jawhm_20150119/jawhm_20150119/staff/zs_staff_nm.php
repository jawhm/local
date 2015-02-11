<?php
	//スタッフ名取得
	//スタッフマスタ：スタッフコードから担当者名を求める
	
	//スタッフコードの入力チェック
	if( $office_cd == "" || $staff_cd == ""){
		//未入力なので 名称も空白
		$staff_nm = '';
		$zs_ope_auth = 0;
		$zs_kanrisya_flg = 0;
		
	}else{
		//スタッフマスタを読み込む
		$STF_query = 'select DECODE(STAFF_NM,"' . $ANGpw . '"),OPE_AUTH,KANRISYA_FLG from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd .
					  '" and STAFF_CD = "' . $staff_cd . '";';
		$STF_result = mysql_query($STF_query);
		if (!$STF_result) {
			//参照失敗
			$staff_nm = '';
			$zs_ope_auth = 0;
			$zs_kanrisya_flg = 0;
			
		}else{
			$STF_row = mysql_fetch_array($STF_result);
			//データの格納
			$staff_nm = $STF_row[0];			//スタッフ名
			$zs_ope_auth = $STF_row[1];			//業務権限
			$zs_kanrisya_flg = $STF_row[2];		//管理者フラグ	0：非管理者　1：管理者
		}
	}
?>