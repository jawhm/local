<?php
	//半角の ' " を 全角の ’” に置換する
	
	$strcng_af = str_replace("'","’",$strcng_bf );
	$strcng_af = str_replace('"','”',$strcng_af );
	$strcng_af = str_replace('$','＄',$strcng_af );
	//$strcng_af = str_replace('\\','￥',$strcng_af );
	//半角\の置換はsjisコードを壊してしまうのでコメント化
?>