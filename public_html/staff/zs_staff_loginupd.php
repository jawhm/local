<?php
	//スタッフログイン時間のみ更新する
	$LCU_err_flg = 0;
	$LCU_query = 'update D_STAFF_LOGIN  set LOGIN_TIME = "' . $now_time . '"' .
				 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
	$LCU_result = mysql_query($LCU_query);
	if (!$LCU_result) {
		$LCU_err_flg = 1;
	}
?>