<?php

/**
 * num指定時のpopup用JS
 * @param $id
 * @return string
 */
function list_get_popup_js($uid)
{
	$str = '
		<script type="text/javascript">
			$(document).ready(function() {
				fnc_yoyaku($("input[uid=' . $uid . ']").get(0));
			});
		</script>
';
	return $str;
}

/**
 * セミナー用JSの取得
 * @return string
 */
function list_get_seminar_js()
{
	return '<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
function fnc_next()	{
	$.ajax({
		type: "GET",
		url: "/seminar_module/seminar_yoyaku_input.php",
		data: "",
		success: function(msg){
			first = true;
			$("#form_yoyaku table tr").each(function() {
				if (first == false) {
					$(this).remove();
				}
				first = false;
			});
			$("#form_yoyaku table tr:last").after(msg);
		},
		error:function(){
			alert("通信エラーが発生しました。");
		}
	});
	document.getElementById("form_area").style.display = "none";
	document.getElementById("form0").style.display = "none";
	document.getElementById("form1").style.display = "none";
	document.getElementById("form2").style.display = "";
}

function fnc_area(obj) {
	document.getElementById("form_area").style.display = "";
	document.getElementById("form0").style.display = "none";
	document.getElementById("form1").style.display = "none";
	document.getElementById("form2").style.display = "none";

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait_login").style.display = "none";
	document.getElementById("div_wait").style.display = "none";

	document.getElementById("area_name").innerHTML = obj.getAttribute("area");
	document.getElementById("form_title").innerHTML = obj.getAttribute("name");
	document.getElementById("txt_title").value = obj.getAttribute("name");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
		css: {
			top:  ($(window).height() - 500) /2 + "px",
			left: ($(window).width() - 600) /2 + "px",
			width: "600px"
		}
	});
}


function fnc_login(obj)	{
	document.getElementById("form_area").style.display = "none";
	document.getElementById("form0").style.display = "";
	document.getElementById("form1").style.display = "none";
	document.getElementById("form2").style.display = "none";

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait_login").style.display = "none";
	document.getElementById("div_wait").style.display = "none";

	document.getElementById("form_title").innerHTML = obj.getAttribute("name");
	document.getElementById("txt_title").value = obj.getAttribute("name");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
		css: {
			top:  ($(window).height() - 500) /2 + "px",
			left: ($(window).width() - 600) /2 + "px",
			width: "600px"
		}
	});
}

function fnc_do_login(){

	obj = document.getElementById("login_email");
	if (obj.value == "")	{
		alert("メールアドレスを入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("login_pwd");
	if (obj.value == "")	{
		alert("パスワードを入力してください。");
		obj.focus();
		return false;
	}

	document.getElementById("div_wait_login").style.display = "";
	document.getElementById("btn_login").value = "処理中...";
	document.getElementById("btn_login").disabled = true;

	$senddata = $("#yoyaku_login").serialize();
	$.ajax({
		type: "POST",
		url: "/seminar_module/login.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait_login").style.display = "none";
			document.getElementById("btn_login").value = "ログイン";
			document.getElementById("btn_login").disabled = false;
			if (msg == true) {
				document.getElementById("login_email").value = "";
				document.getElementById("login_pwd").value = "";
				fnc_yoyaku2();
			} else {
				alert(msg);
			}
		},
		error:function(){
			alert("通信エラーが発生しました。");
		}
	});
}

function fnc_yoyaku2() {
	document.getElementById("form_area").style.display = "none";
	document.getElementById("form0").style.display = "none";
	document.getElementById("form1").style.display = "";
	document.getElementById("form2").style.display = "none";
}

function fnc_yoyaku(obj)	{
	document.getElementById("form_area").style.display = "none";
	document.getElementById("form0").style.display = "none";
	document.getElementById("form1").style.display = "";
	document.getElementById("form2").style.display = "none";

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = "none";
	document.getElementById("form_title").innerHTML = obj.getAttribute("title");
	document.getElementById("txt_title").value = obj.getAttribute("title");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
	css: {
		top:  ($(window).height() - 500) /2 + "px",
		left: ($(window).width() - 600) /2 + "px",
		width: "600px"
	}
 });
}
function btn_cancel()	{
	$.unblockUI();
}
function btn_submit()	{
	obj = document.getElementById("txt_name");
	if (obj.value == "")	{
		alert("お名前（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_name2");
	if (obj)	{
		if (obj.value == "")	{
			alert("お名前（名）を入力してください。");
			obj.focus();
			return false;
		}
	}
	obj = document.getElementById("txt_furigana");
	if (obj.value == "")	{
		alert("フリガナ（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana2");
	if (obj)	{
		if (obj.value == "")	{
			alert("フリガナ（名）を入力してください。");
			obj.focus();
			return false;
		}
	}
	obj = document.getElementById("txt_mail");
	if (obj.value == "")	{
		alert("メールアドレスを入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_tel");
	if (obj.value == "")	{
		alert("電話番号を入力してください。");
		obj.focus();
		return false;
	}

	if (!confirm("ご入力頂いた内容を送信します。よろしいですか？"))	{
		return false;
	}

	$senddata = $("#form_yoyaku").serialize();

	document.getElementById("div_wait").style.display = "";

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "/yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait").style.display = "none";
			alert(msg);
			$.unblockUI();
		},
		error:function(){
			alert("通信エラーが発生しました。");
			$.unblockUI();
		}
	});
}
</script>
<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
	});
});
</script>
';
}

/**
 * セミナー用CSSの取得
 * @return string
 */
function list_get_seminar_css()
{
	return '<link type="text/css" href="/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />';
}

/**
 * セミナー用STYLE属性の取得
 * @return string
 */
function list_get_seminar_style()
{
	return '
<style>
.open {
	font-size:9pt;
	font-weight:bold;
	color : orange;
	cursor:pointer;
	margin: 0 0 10px 0;
}
</style>
';
}
