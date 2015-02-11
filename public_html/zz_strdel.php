<?php
	//半角の ' " を削除する
	
	$strcng_af = str_replace("'","",$strcng_bf );
	$strcng_af = str_replace('"','',$strcng_af );
	//$strcng_af = str_replace('\\','￥',$strcng_af );
	//半角\の置換はsjisコードを壊してしまうのでコメント化
?>