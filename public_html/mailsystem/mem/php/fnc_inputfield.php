<?php

// 入力フィールド設定
function field_text($fld_name, $fld_size, $fld_value) {
    // テキスト
    $res = '';
    $res .= '<input id="' . $fld_name . '" type="text" name="' . $fld_name . '" size="' . $fld_size . '" value="' . htmlspecialchars($fld_value) . '">';
    $res .= '';
    return $res;
}

function field_required($fld_name, $fld_size, $fld_value) {
    // テキスト
    $res = '';
    $res .= '<input id="' . $fld_name . '" type="text" name="' . $fld_name . '" size="' . $fld_size . '" value="' . htmlspecialchars($fld_value) . '" required="yes">';
    $res .= '';
    return $res;
}

function field_password($fld_name, $fld_size, $fld_value) {
    // パスワード
    $res = '';
    $res .= '<input id="' . $fld_name . '" type="password" name="' . $fld_name . '" size="' . $fld_size . '" value="' . $fld_value . '" required="no">';
    $res .= '';
    return $res;
}

function dropdown_list($fld_name, $select = '', $data = array(), $options = array()) {
    // プルダウン
    $st_options = '';
    $st_empty = '';
    if (isset($options) && is_array($options)) {
        foreach ($options as $key => $value) {
            if ($key != 'empty') {
                $st_options .= $key . '="' . $value . '"';
            } else {
                $st_empty .= '<option value="">' . $value . '</option>';
            }
        }
    }
    $res = '<select id="' . $fld_name . '" name="' . $fld_name . '" ' . $st_options . '>';
    $res .= $st_empty;
    //
    if (isset($data) && is_array($data)) {
        foreach ($data as $key => $value) {
            if ($select != '' && $select == $key) {
                $res .= '<option value="' . $key . '" selected>' . $value . '</option>';
            } else {
                $res .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
    }
    $res .= '</select>';
    return $res;
}

?>