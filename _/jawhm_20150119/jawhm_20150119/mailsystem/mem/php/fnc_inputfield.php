<?php

// 入力フィールド設定
function field_text($fld_name, $fld_size, $fld_value)	{
	// テキスト
	$res = '';
	$res .= '<input id="'.$fld_name.'" type="text" name="'.$fld_name.'" size="'.$fld_size.'" value="'.$fld_value.'" required="no">';
	$res .= '';
	return $res;
}

function field_required($fld_name, $fld_size, $fld_value)	{
	// テキスト
	$res = '';
	$res .= '<input id="'.$fld_name.'" type="text" name="'.$fld_name.'" size="'.$fld_size.'" value="'.$fld_value.'" required="yes">';
	$res .= '';
	return $res;
}

function field_password($fld_name, $fld_size, $fld_value)	{
	// パスワード
	$res = '';
	$res .= '<input id="'.$fld_name.'" type="password" name="'.$fld_name.'" size="'.$fld_size.'" value="'.$fld_value.'" required="no">';
	$res .= '';
	return $res;
}






?>