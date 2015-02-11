/**
 *
 */


/* ログアウトスクリプト */
function fnc_logout()	{
	if (confirm('ログアウトしますか？'))	{
		location.href = 'http://www.jawhm.or.jp/mailsystem/mem/login.php?act=logout';
	}
}

function fncShow(strDiv, intWidth, intHeight)	{
	jQuery.blockUI({ message: jQuery("#" + strDiv),
		css: {
			top:  (jQuery(window).height() - intHeight) /2 + "px",
			left: (jQuery(window).width() - intWidth) /2 + "px",
			width: intWidth + "px"
		}
	});
}

function fncHide()	{
	jQuery.unblockUI();
}

