<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-Type: text/html; charset=utf-8');
mb_language("Ja");
mb_internal_encoding("utf8");

$str = 'アイウエオ｜ｱｲｳｴｵ｜あいうえお｜AIUEO｜aiueo';

$str = mb_convert_kana($str, "Hc");

echo $str;