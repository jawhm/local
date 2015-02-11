/**
 *
 */


var numGetIdString = 0;
var g_fncwait_now = null;
var g_fncwait_eternal = null;

/* 処理中表示 */
function gfncWait(flg)	{
	try{
		if (gfncWait.arguments.length == 1)	{
			var eternal = false;
		}else{
			var eternal = gfncWait.arguments[1];
		}
		if (eternal)	{
			g_fncwait_eternal = flg;
		}else{
			if (g_fncwait_eternal)	{
				return true;
			}
		}
		var waitform  = eID('bar_loginuser');
		if (flg)	{
			waitform.style.display="";
		} else {
			waitform.style.display="none";
		}
		g_fncwait_now = flg;
	} catch(e) {
	}
	return true;
}


/* 一意の文字列を返却する */
function fncGetIdString()	{
	var ymd = new Date();
	var h = new String (ymd.getHours());
	var m = new String (ymd.getMinutes());
	var s = new String (ymd.getSeconds());
	h = '00' + h;
	m = '00' + m;
	s = '00' + s;
	numGetIdString ++;
	return 'id' +  h.slice(-2) + m.slice(-2) + s.slice(-2) + numGetIdString.toString();
}

/* 画面項目をロックする */
function fncObjectLock(doc)	{
	var obj = doc.getElementsByTagName('select');
	for (var i=0; i<obj.length; i++)	{
		if (!obj[i].style.display && !obj[i].disabled)	{
			obj[i].setAttribute('apautodisabled','true');
			obj[i].setAttribute('apautotabindex',obj[i].tabIndex);
			obj[i].disabled = true;
			obj[i].tabIndex = -1;
		}
	}
	var obj = doc.getElementsByTagName('input');
	for (var i=0; i<obj.length; i++)	{
		if (!obj[i].style.display && !obj[i].disabled)	{
			obj[i].setAttribute('apautodisabled','true');
			obj[i].setAttribute('apautotabindex',obj[i].tabIndex);
			obj[i].disabled = true;
			obj[i].tabIndex = -1;
		}
	}
	var obj = doc.getElementsByTagName('textarea');
	for (var i=0; i<obj.length; i++)	{
		if (!obj[i].style.display && !obj[i].disabled)	{
			obj[i].setAttribute('apautodisabled','true');
			obj[i].setAttribute('apautotabindex',obj[i].tabIndex);
			obj[i].disabled = true;
			obj[i].tabIndex = -1;
		}
	}
}

/* 画面項目をアンロックする(fncObjectLockでロックされたオブジェクトの解除) */
function fncObjectUnLock(doc)	{
	var obj = doc.getElementsByTagName('select');
	for (var i=0; i<obj.length; i++)	{
		if (obj[i].getAttribute('apautodisabled') == 'true')	{
			obj[i].setAttribute('apautodisabled','false');
			obj[i].disabled = false;
			obj[i].tabIndex = obj[i].getAttribute('apautotabindex');;
		}
	}
	var obj = doc.getElementsByTagName('input');
	for (var i=0; i<obj.length; i++)	{
		if (obj[i].getAttribute('apautodisabled') == 'true')	{
			obj[i].setAttribute('apautodisabled','false');
			obj[i].disabled = false;
			obj[i].tabIndex = obj[i].getAttribute('apautotabindex');;
		}
	}
	var obj = doc.getElementsByTagName('textarea');
	for (var i=0; i<obj.length; i++)	{
		if (obj[i].getAttribute('apautodisabled') == 'true')	{
			obj[i].setAttribute('apautodisabled','false');
			obj[i].disabled = false;
			obj[i].tabIndex = obj[i].getAttribute('apautotabindex');;
		}
	}
}


/* ダイアログを表示する */
function fncShowDialog(strDiv, numWidth, numHeight, strTitle, strHtml, optFilter, noclose, lockpanel)	{

	if (!noclose) { var noclose = false; }
	if (!lockpanel) { var lockpanel = ''; }

	var uid = fncGetIdString();

	/* IE6の場合、コンボボックスを非表示（ＩＥのバグで透過してしまうため。） */
	var userAgent = window.navigator.userAgent.toLowerCase();
	var appVersion = window.navigator.appVersion.toLowerCase();
	if (userAgent.indexOf("msie") > -1) {
		if (appVersion.indexOf("msie 6.0") > -1) {
			var obj = document.getElementsByTagName('select');
			for (var i=0; i<obj.length; i++)	{
				if (!obj[i].style.display)	{
					obj[i].style.display = 'none';
					obj[i].setAttribute('apdialoghide','true');
					obj[i].setAttribute('apdialoghide_uid',uid);
				}
			}
		}
	}

	/* 下層画面をロック */
	if (isIE() && lockpanel != '')	{
		/* ＩＥでロックパネル指定がある場合 */
		var panel = eID(lockpanel)
		if (panel)	{
			panel.disabled = true;
		}else{
			lockpanel = '';
		}
	}
	if (lockpanel == '')	{
		fncObjectLock(document);
	}

	var ph = document.body.clientHeight;	/* ブラウザ幅 */
	var pw = document.body.clientWidth;	/* ブラウザ高 */

	/* フィルター領域計算 */
	var hh = document.body.scrollHeight + Number(numHeight / 2);	/* 表示ページ幅 */
	var hw = document.body.scrollWidth  + Number(numWidth  / 2);	/* 表示ページ高 */
	if (ph > hh)	{	hh = ph;	}
	if (pw > hw)	{	hw = pw;	}

	var sh = Number(numHeight + 0);
	var sw = Number(numWidth);
	if (sh > hh )	{	hh = sh;	}
	if (sw > hw )	{	hw = sw;	}

	/* ダイアログ表示位置計算 */
	var dx = (pw - numWidth) / 2;
	if (dx < 1)	{	dx = 30;	}
	var dy = (ph - numHeight) / 2;
	if (dy < 1)	{	dy = 30;	}
	dy = dy + document.body.scrollTop;

	/* ダイアログ雛形生成 */
	var dialog = '';
	dialog += '<div id="dialog_filter_' + uid + '" style="position:absolute; display:none; top:0px; left:0px; width:' + hw + 'px; height:' + hh + 'px; background-color:black; z-index:9005;"></div>';
	dialog += '<div id="dialog_float_' + uid + '" style="position:absolute; display:none; top:' + dy + 'px; left:' + dx + 'px; width:' + numWidth + 'px; height:' + numHeight + 'px; z-index:9010;">';
	dialog += '<div class="cap_sort_sel" style="width:100%; height:100%; border: 3px outset; cursor:default; ';
	dialog += ' background-image:url(\'./stylesheet/pattern/#session.SYSTEM_COLOR#/02-back2.gif\'); background-repeat:repeat-x; background-position:left top;">';
	dialog += '<div id="dialog_back" style="width:100%; height:100%; cursor:default; ';
	dialog += ' background-image:url(\'./stylesheet/pattern/#session.SYSTEM_COLOR#/02-back1.gif\'); background-repeat:repeat-x; background-position:left top;">';
	dialog += '<span id="dialog_title" style="position:absolute; top:10px; left:18px; font-size:12pt; font-weight:bold; color:white; z-index:9003;">' + strTitle + '</span>';
	if (!noclose) {
		dialog += '<span id="dialog_close" style="position:absolute; top:7px; left:' + (numWidth - 70) + 'px; font-size:11pt; cursor:pointer; z-index:9030;" onclick="fncDialogClose(\'' + uid + '\');"><input type=button id="close_' + uid + '" class="input_blue" style="font-size:10pt;" value="閉じる" onclick="fncDialogClose(\'' + uid + '\');"></span>';
//		dialog += '<span id="dialog_close" style="position:absolute; top:8px; left:' + (numWidth - 95) + 'px; font-size:11pt; cursor:pointer; z-index:9030;" onclick="fncDialogClose(\'' + uid + '\');"><input type=button id="close_' + uid + '" value="閉じる" onclick="fncDialogClose(\'' + uid + '\');"></span>';
	}
	dialog += '<span id="dialog_move_' + uid + '" apdraguse="on" apdragid="dialog_float_' + uid + '" style="position:absolute; top:0px; left:0px; width:100%; height:38px; cursor:move; z-index:9020;"></span>';
	dialog += '<span id="dialog_contents" style="position:absolute; top:45px; left:0px; width:100%; z-index:9001;">' + strHtml + '</span>';
	dialog += '</div></div></div>';

	/* ダイアログ表示 */
	var obj = document.getElementById(strDiv);
	obj.innerHTML = '';
	fncreplaceInnerHtml(obj, dialog);
	obj.style.display = '';
	document.getElementById('dialog_float_' + uid).style.display = '';

	/* フィルター設定 */
	if (optFilter)	{
		document.getElementById('dialog_filter_' + uid).style.display = '';
		fncSetOpacity (document.getElementById('dialog_filter_' + uid), 0.6);
	}
	eID('dialog_filter_' + uid).setAttribute('lockpanelname',lockpanel);

	/* イベント設定 */
	var draghandle = document.getElementById('dialog_move_' + uid);
	draghandle.onmousedown = evtmousedown;
	document.onmouseup = evtmouseup;
	document.onmousemove = evtmousemove;

	/* フォーカス設定 */
	if (!noclose) {
		document.getElementById('close_' + uid).focus();
	}

	return uid;
}

/* ダイアログの非表示 */
function fncDialogClose(strDlg)	{
	document.mouseup = null;
	document.mousemove = null;

	var lockpanel = eID('dialog_filter_' + strDlg).getAttribute('lockpanelname');

	/* ダイアログ表示時に非表示化されたコンボを元に戻す */
	var obj = document.getElementsByTagName('select');
	for (var i=0; i<obj.length; i++)	{
		if (obj[i].getAttribute('apdialoghide') == 'true')	{
			if (obj[i].getAttribute('apdialoghide_uid') == strDlg)	{
				obj[i].style.display = '';
				obj[i].setAttribute('apdialoghide','');
			}
		}
	}

	document.getElementById('dialog_filter_' + strDlg).style.display = 'none';
	document.getElementById('dialog_filter_' + strDlg).innerHTML = '';
	document.getElementById('dialog_float_' + strDlg).style.display = 'none';
	document.getElementById('dialog_float_' + strDlg).innerHTML = '';

	/* 下層画面のロック解除 */
	if (lockpanel != '')	{
		eID(lockpanel).disabled = false;
	} else {
		fncObjectUnLock(document);
	}

}


/* ダイアログを表示する */
function fncShowDialogSimple(strDiv, numWidth, numHeight, strTitle, strHtml, optFilter, noclose)	{

	if (!noclose) { var noclose = false; }

	var uid = fncGetIdString();

	/* IE6の場合、コンボボックスを非表示（ＩＥのバグで透過してしまうため。） */
	var userAgent = window.navigator.userAgent.toLowerCase();
	var appVersion = window.navigator.appVersion.toLowerCase();
	if (userAgent.indexOf("msie") > -1) {
		if (appVersion.indexOf("msie 6.0") > -1) {
			var obj = document.getElementsByTagName('select');
			for (var i=0; i<obj.length; i++)	{
				if (!obj[i].style.display)	{
					obj[i].style.display = 'none';
					obj[i].setAttribute('apdialoghide','true');
					obj[i].setAttribute('apdialoghide_uid',uid);
				}
			}
		}
	}

	var ph = document.body.clientHeight;	/* ブラウザ幅 */
	var pw = document.body.clientWidth;	/* ブラウザ高 */

	/* フィルター領域計算 */
	var hh = document.body.scrollHeight;	/* 表示ページ幅 */
	var hw = document.body.scrollWidth;	/* 表示ページ高 */
	if (ph > hh)	{	hh = ph;	}
	if (pw > hw)	{	hw = pw;	}

	var sh = Number(numHeight + 300);
	var sw = Number(numWidth);
	if (sh > hh )	{	hh = sh;	}
	if (sw > hw )	{	hw = sw;	}

	/* ダイアログ表示位置計算 */
	var dx = (pw - numWidth) / 2;
	if (dx < 1)	{	dx = 30;	}
	var dy = (ph - numHeight) / 2;
	if (dy < 1)	{	dy = 30;	}
	dy = dy + document.body.scrollTop;

	/* ダイアログ雛形生成 */
	var dialog = '';
	dialog += '<div id="dialog_filter_' + uid + '" style="position:absolute; display:none; top:0px; left:0px; width:' + hw + 'px; height:' + hh + 'px; background-color:black; z-index:9105;"></div>';
	dialog += '<div id="dialog_float_' + uid + '" style="position:absolute; display:none; top:' + dy + 'px; left:' + dx + 'px; width:' + numWidth + 'px; height:' + numHeight + 'px; z-index:9110;">';
	dialog += '<div class="cap_sort_sel" style="width:100%; height:100%; padding: 28px 2% 2% 1%; cursor:default; background-color:##c9fed5; border:2px outset;">';
	dialog += '<div id="dialog_back" style="width:100%; height:100%; cursor:default; border:2px solid ##2bae94;">';
	dialog += '<span id="dialog_title" style="position:absolute; top:8px; left:18px; font-size:11pt; font-weight:bold; color:black; z-index:9103;">' + strTitle + '</span>';
	if (!noclose) {
		dialog += '<span id="dialog_close" style="position:absolute; top:5px; left:' + (numWidth - 70) + 'px; font-size:11pt; cursor:pointer; z-index:9030;" onclick="fncDialogCloseSimple(\'' + uid + '\');"><input type=button id="close_' + uid + '" class="input_blue" style="font-size:8pt;" value="閉じる" onclick="fncDialogCloseSimple(\'' + uid + '\');"></span>';
	}
	dialog += '<span id="dialog_contents" style="position:absolute; top:40px; left:22px; width:100%; z-index:9101;">' + strHtml + '</span>';
	dialog += '</div></div></div>';

	/* ダイアログ表示 */
	var obj = document.getElementById(strDiv);
	obj.innerHTML = '';
	fncreplaceInnerHtml(obj, dialog);
	obj.style.display = '';
	document.getElementById('dialog_float_' + uid).style.display = '';

	// フィルター指定
	document.getElementById('dialog_filter_' + uid).style.display = '';
	fncSetOpacity (document.getElementById('dialog_filter_' + uid), 0);

	return uid;
}
/* ダイアログの非表示(simpelダイアログ用) */
function fncDialogCloseSimple(strDlg)	{

	/* ダイアログ表示時に非表示化されたコンボを元に戻す */
	var obj = document.getElementsByTagName('select');
	for (var i=0; i<obj.length; i++)	{
		if (obj[i].getAttribute('apdialoghide') == 'true')	{
			if (obj[i].getAttribute('apdialoghide_uid') == strDlg)	{
				obj[i].style.display = '';
				obj[i].setAttribute('apdialoghide','');
			}
		}
	}
	document.getElementById('dialog_filter_' + strDlg).style.display = 'none';
	document.getElementById('dialog_float_' + strDlg).style.display = 'none';

}

// HTMLソースをエレメント化
function fncToElement(html)	{
	var div = document.createElement('div');
	div.innerHTML = html;
	var el = div.childNodes[0];
	div.removeChild(el);
	return el;
}

// 新規のフォームリクエストを実行する
function fncRequestForm(url, target)	{

	var id = fncGetIdString();

	if (target == null)	{
		// ターゲット指定が無い場合は、ダミーフレームを準備
		var iframe = fncToElement('<iframe src="javascript:false;" name="iframe_' + id + '" />');
		iframe.setAttribute('id', 'iframe_' + id);
		iframe.setAttribute('name' , 'iframe_' + id);
		iframe.style.display = 'none';
		document.body.appendChild(iframe);
	}

	// フォームエレメントを準備
	var form = fncToElement('<form method="post" name="form_' + id + '"></form>');
	form.setAttribute('id', 'form_' + id);
	form.style.display = 'none';
	form.action = url;
	if (target == null)	{
		// ターゲット指定が無い場合は、ダミーフレームで処理
		form.target = iframe.name;
	}else{
		// ターゲット指定がある場合
		form.target = target;
	}
	document.body.appendChild(form);

	// フォーム実行
	form.submit();
	return form;
}

/* ポップアップウィンドウを表示する（オブジェクト版） */
//インラインフレーム上のダイアログフレームにも表示対応
var OBJ_CALL_POPUP;
Call_Popup = callpopup = function(options){
	this.status = false;		// 表示中はtrue
	this._windowid	= '';
	this._basedivid = '';
	this._idnum	= 0;
	this._settings = {}
	this._reset();	// パラメータリセット
	for (var i in options) { this._settings[i] = options[i]; }	// パラメータ設定
	this.init();	// 初期処理
}
callpopup.prototype = {
	init	: function()	{
		// 初期処理
		this.status = false;
		this._basedivid = 'div_'+this._getID();
		this._windowid = this._basedivid + '_win';
		var ifrmode = this._settings['iframe'];		//true:インラインフレームで開く

		//生成ダイアログのdivの生成
		if(ifrmode==true){
			//インラインフレームでの処理
			var objfr  = top.fra_system.document.getElementById('ifr_daialog');
			var objroot = objfr.contentWindow.document.getElementById('dialog_div');
			var win = objfr.contentWindow.document.createElement('div');
			win.setAttribute ('id', this._basedivid);
			objroot.appendChild(win);
		}else{
			//同一フレーム内での処理
			var win = document.createElement('div');
			win.setAttribute ('id', this._basedivid);
			document.body.appendChild(win);
		}
		OBJ_CALL_POPUP = this;
		return true;
	},
	show	: function(strHtml)	{
		// ポップアップ表示
		//    numWidth   :
		//    numHeight  :
		//    strTitle   :
		//    strHtml    :
		//    optFilter  :
		//    noclose    :
		//    ifrmode    :
		//    selffr     :  ※ifrmodeがtrueのとき
		//    callback_open  :  ※open時のコールバック関数
		//    callback_close :  ※close時のコールバック関数

		var numWidth = this._settings['width'];
		var numHeight = this._settings['height'];
		var strTitle = this._settings['title'];
		var optFilter = this._settings['filter'];
		var noclose = !this._settings['closebutton'];
		var ifrmode = this._settings['iframe'];		//true:インラインフレームで開く

		var tagetfr='';
		if(ifrmode==true){
			var selffr=this._settings['selfframe']; //呼び元フレーム名
			if(selffr!=''){
				var tagetfr='top.fra_system.document.getElementById(\'ifr_operation\').contentWindow.main.'+selffr+'.';
			}
		}

		if (!noclose) { var noclose = false; }

		if(ifrmode==true){
			var objwin  = top.fra_system.document.getElementById('dialog_win');
			var objfr  = top.fra_system.document.getElementById('ifr_daialog');
		}

		// IE6の場合、コンボボックスを非表示（ＩＥのバグで透過してしまうため。）
		var userAgent = window.navigator.userAgent.toLowerCase();
		var appVersion = window.navigator.appVersion.toLowerCase();
		if (userAgent.indexOf("msie") > -1) {
			if (appVersion.indexOf("msie 6.0") > -1) {
				var obj = document.getElementsByTagName('select');
				for (var i=0; i<obj.length; i++)	{
					if (!obj[i].style.display)	{
						obj[i].style.display = 'none';
						obj[i].setAttribute('apdialoghide','true');
					}
				}
			}
		}

		/* 下層画面をロック */
		fncObjectLock(document);

		var ph = document.body.clientHeight;
		var pw = document.body.clientWidth;

		// フィルター領域計算
		var hh = document.body.scrollHeight;
		var hw = document.body.scrollWidth;
		if (ph > hh)	{	hh = ph;	}
		if (pw > hw)	{	hw = pw;	}

		//インラインフレームの場合はインラインフレームのサイズを基準
		if(ifrmode==true){
			hh = objfr.height;
			hw = objfr.width;
			//ブラウザによっては単位が入ってしまう場合があるので除去
			hh=hh.replace('px', '');
			hw=hw.replace('px', '');
		}

		var sh = Number(this._settings['height'] + 300);
		var sw = Number(this._settings['width']);
		if (sh > hh )	{	hh = sh;	}
		if (sw > hw )	{	hw = sw;	}

		// ダイアログ表示位置計算
		var dx = (pw - numWidth) / 2;
		if (dx < 1)	{	dx = 30;	}
		var dy = (ph - numHeight) / 2;
		if (dy < 1)	{	dy = 30;	}
		dy = dy + document.body.scrollTop;

		// top,leftの指定がある場合は、それを優先
		if (this._settings['top'] != '')	{  var dy = this._settings['top'];	}
		if (this._settings['left'] != '')	{  var dx = this._settings['left'];	}

		// ポジション指定がある場合
		if (this._settings['position'] != null)	{
			if (document.all) {
				var dx = event.clientX + document.body.scrollLeft;
				var dy = event.clientY + document.body.scrollTop;
			}else{
				var dx = this._settings['position'].pageX;
				var dy = this._settings['position'].pageY;
			}
		}

		// ダイアログ雛形生成
		var uid = this._windowid;
		var dialog = '';
		dialog += '<div id="dialog_filter_' + uid + '" style="position:absolute; display:none; top:0px; left:0px; width:' + hw + 'px; height:' + hh + 'px; background-color:black; z-index:9105;"></div>';
		dialog += '<div id="dialog_float_' + uid + '" style="position:absolute; display:none; top:' + dy + 'px; left:' + dx + 'px; width:' + numWidth + 'px; height:' + numHeight + 'px; z-index:9110;">';
		dialog += '<div style="width:100%; height:100%; padding: 28px 2% 2% 1%; cursor:default; background-color:' + this._settings['bgcolor'] + '; border:2px outset;">';
		dialog += '<div id="dialog_back" style="width:100%; height:100%; cursor:default; border:2px solid ' + this._settings['linecolor'] + '">';
		dialog += '<span id="dialog_title_' + uid + '" style="position:absolute; top:8px; left:18px; font-size:11pt; font-weight:bold; color:black; z-index:9103;">' + strTitle + '</span>';
		if (!noclose) {
			dialog += '<span id="dialog_close" style="position:absolute; top:5px; left:' + (numWidth - 40) + 'px; font-size:11pt; cursor:pointer; z-index:9030;">';
			dialog += '<input type="button" id="close_' + uid + '" style="font-size:9pt; text-align:center; vertical-align:middle; background-color:white; width:20px;" value="×" onclick="' + tagetfr + 'OBJ_CALL_POPUP.close(' + ifrmode + ');"></span>';
			dialog += '</span>';
		}
		dialog += '<span id="dialog_contents_' + uid + '" style="position:absolute; top:40px; left:22px; width:100%; z-index:9101;">' + strHtml + '</span>';
		dialog += '</div></div></div>';

		// ダイアログ表示
		if(ifrmode==true){
			//インラインフレームでの処理
			var obj = objfr.contentWindow.document.getElementById(this._basedivid);
			obj.innerHTML = '';
			fncreplaceInnerHtml(obj, dialog);
			obj.style.display = '';
			objwin.style.display='';
			objfr.contentWindow.document.getElementById('dialog_float_' + uid).style.display = '';

			// フィルター指定
			objfr.contentWindow.document.getElementById('dialog_filter_' + uid).style.display = '';
			fncSetOpacity (objfr.contentWindow.document.getElementById('dialog_filter_' + uid), optFilter);
		}else{
			//同一フレーム内での処理
			var obj = document.getElementById(this._basedivid);
			obj.innerHTML = '';
			fncreplaceInnerHtml(obj, dialog);
			obj.style.display = '';
			document.getElementById('dialog_float_' + uid).style.display = '';

			// フィルター指定
			document.getElementById('dialog_filter_' + uid).style.display = '';
			fncSetOpacity (document.getElementById('dialog_filter_' + uid), optFilter);
		}
		//コールバック関数を指定していたら、それを実行する
		if (this._settings['callback_open'] != ""){
			eval(this._settings['callback_open']);
		}


		this.status = true;

		return true;
	},
	refresh	: function(strTitle,strHtml)	{
		// 表示内容をリフレッシュ
		var obj = document.getElementById('dialog_contents_' + this._windowid);
		obj.innerHTML = '';
		fncreplaceInnerHtml(obj, strHtml);
		var obj = document.getElementById('dialog_title_' + this._windowid);
		obj.innerHTML = '';
		fncreplaceInnerHtml(obj, strTitle);
		return true;
	},
	close	: function(ifrmode)	{
		// 閉じる

		/* 下層画面のロック解除 */
		fncObjectUnLock(document);

		//IE6対応で非表示にしたコンボを再表示
		var obj = document.getElementsByTagName('select');
		for (var i=0; i<obj.length; i++)	{
			if (obj[i].getAttribute('apdialoghide') == 'true')	{
				obj[i].style.display = '';
				obj[i].setAttribute('apdialoghide','');
			}
		}

		if(ifrmode==true){
			//インラインフレームでの処理
			var objwin  = top.fra_system.document.getElementById('dialog_win');
			var objfr  = top.fra_system.document.getElementById('ifr_daialog');
			var objroot = objfr.contentWindow.document.getElementById('dialog_div');
			var obj = objfr.contentWindow.document.getElementById(this._basedivid);
			//「右クリックでリロードされたときに存在しない」対策
			if(!obj){
			}else{
				obj.style.display = 'none';
				objwin.style.display='none';
				obj.innerHTML = ' ';
				objroot.removeChild(obj);
			}
		}else{
			//同一フレーム内での処理
			document.getElementById('dialog_filter_' + this._windowid).style.display = 'none';
			document.getElementById('dialog_float_' + this._windowid).style.display = 'none';
			var obj = document.getElementById(this._basedivid);
			obj.innerHTML = ' ';
			document.body.removeChild(obj);
		}

		//コールバック関数を指定していたら、それを実行する
		if (this._settings['callback_close'] != ""){
			eval(this._settings['callback_close']);
		}
		this.status = false;

		return true;
	},
	_reset  : function()	{
		this._settings['top'] = '';
		this._settings['left'] = '';
		this._settings['position'] = null;
		this._settings['width'] = 300;
		this._settings['height'] = 300;
		this._settings['title'] = 'タイトル';
		this._settings['filter'] = 0;
		this._settings['closebutton'] = true;
		this._settings['bgcolor'] = '##c9fed5';
		this._settings['linecolor'] = '##2bae94';
		this._settings['iframe'] = false;
		this._settings['selfframe'] = '';
		this._settings['callback_open'] = "";
		this._settings['callback_close'] = "";
	},
	_getID	: function()	{
		var ymd = new Date();
		var h = new String (ymd.getHours());
		var m = new String (ymd.getMinutes());
		var s = new String (ymd.getSeconds());
		h = '00' + h;
		m = '00' + m;
		s = '00' + s;
		this._idnum ++;
		return 'id' +  h.slice(-2) + m.slice(-2) + s.slice(-2) + this._idnum.toString();
	}
};



/* ドラック用ファンクション一式 */
function evtmousedown(e)	{	return (fncmousedown(this,e));	}
function evtmouseup(e)		{	return (fncmouseup(this,e));	}
function evtmousemove(e)	{	return (fncmousemove(this,e));	}

var drag_obj_drag = null;
var drag_obj_handle = null;
var drag_num_offsetX;
var drag_num_offsetY;
var drag_cns_zindex = 30;
var drag_cns_zindex_normal = 1;

function fncmousedown(evtobj,e,offsetX,offsetY)	{

	if (!offsetX)	{ var offsetX = 2; }
	if (!offsetY)	{ var offsetY = 2; }

	/* ドラッグ状況確認 */
	if (evtobj.getAttribute('apdraguse') == 'on')	{
		/* ドラッグ対象設定 */
		var drag_obj_handle = evtobj;
		var dragid = evtobj.getAttribute('apdragid');
		if (dragid)	{
			drag_obj_drag = document.getElementById(dragid);
		}else{
			drag_obj_drag = drag_obj_handle;
		}
		/* ドラッグ対象のz-indexを操作 */
		drag_obj_drag.style.zIndex += drag_cns_zindex;
		/* オフセット計算 */
		if (document.all) {
			drag_num_offsetX = event.offsetX + offsetX;
			drag_num_offsetY = event.offsetY + offsetY;
		} else if (evtobj.getElementsByTagName) {
			drag_num_offsetX = e.pageX - parseInt(drag_obj_drag.style.left);
			drag_num_offsetY = e.pageY - parseInt(drag_obj_drag.style.top);
		}
	}
	return true;
}
function fncmousemove(evtobj,e)	{
	/* ドラッグ処理 */
	if (drag_obj_drag)	{
		/* マウスの絶対位置計算 */
		if (document.all) {
			var mouseX = event.clientX + document.body.scrollLeft;
			var mouseY = event.clientY + document.body.scrollTop;
		} else if (drag_obj_drag.getElementsByTagName) {
			var mouseX = e.pageX;
			var mouseY = e.pageY;
		}

		/* 画面をはみ出ない範囲でドラッグ */
		if (mouseX < 50) { mouseX = 50; }
		if (mouseY < 30) { mouseY = 30; }

		/* 移動処理 */
		drag_obj_drag.style.left = mouseX - drag_num_offsetX;
		drag_obj_drag.style.top  = mouseY - drag_num_offsetY;
		return false;
	}
}
function fncmouseup(evtobj,e)	{
	/* ドラック状況確認 */
	if (drag_obj_drag)	{
		/* ドラック対象のz-indexを操作 */
		drag_obj_drag.style.zIndex -= drag_cns_zindex;
		/* ドラック終了 */
		drag_obj_drag = null;
		drag_obj_handle = null;
	}
	return true;
}

/* 透過の設定 */
function fncSetOpacity(elem, op){
	if (isIE())	{
		elem.style.filter = 'alpha(opacity=' + (op * 100) + ')';
	} else {
		elem.style.MozOpacity = op;
	}
	// Chrome, Safari, Opera
	// elem.style.opacity = op;
}


/* ブラウザの判定 */
function isIE(){
	var userAgent = window.navigator.userAgent.toLowerCase();
	var appVersion = window.navigator.appVersion.toLowerCase();
	var ret = null;

	if (userAgent.indexOf("msie") > -1) {
		if (appVersion.indexOf("msie 6.0") > -1) {
			ret = true;
		}
		else if (appVersion.indexOf("msie 7.0") > -1) {
			ret = true;
		}
		else if (appVersion.indexOf("msie 8.0") > -1) {
			ret = true;
		}
		else {
			ret = true;
		}
	}
	else if (userAgent.indexOf("firefox") > -1) {
		ret = false;
	}
	else if (userAgent.indexOf("opera") > -1) {
		ret = false;
	}
	else if (userAgent.indexOf("chrome") > -1) {
		ret = false;
	}
	else if (userAgent.indexOf("safari") > -1) {
		ret = false;
	}
	else {
		ret = false;
	}

	return ret;
}


/* DIV内の入力チェックを行う */
function fncInputCheckDiv(strDiv)	{

	if (fncInputCheckDiv.arguments.length == 2)	{
		var silent = fncInputCheckDiv.arguments[1];
	}else{
		var silent = false;
	}

	var i;
	var searchdiv = document.getElementById(strDiv);
	var obj = searchdiv.getElementsByTagName('input');
	for (i=0; i<obj.length; i++)	{
		switch (obj[i].type.toUpperCase())	{
			/* テキストボックスの場合 */
			case "TEXT":{
				/* class定義を取得 */
				if (isIE())	{
					var inpcls = obj[i].getAttribute('className');
				} else {
					var inpcls = obj[i].getAttribute('class');
				}
				if (inpcls.match('input|required'))	{
					if (inpcls.match('required'))	{
						/* 必須チェック */
						var val = new String(fncTrim(obj[i].value));
						if (val.length == 0)	{
							if (!silent)	{
								obj[i].focus();
								obj[i].select();
								alert('#request.msg.noitem#');
							}
							return false;
						}
					}
					if (inpcls.match('str'))	{
						/* 文字列チェック */
						/* 文字列長を取得 */
						var maxlen = obj[i].getAttribute('maxlength');
						if (maxlen == null)	{	maxlen = 0;	}
						if (isIE())	{
							if (maxlen > 1000000)	{	maxlen = 0;	}
						}
						if (maxlen > 0)	{
							if (obj[i].value.getvarcharBytes() > maxlen)	{
								if (!silent)	{
									obj[i].focus();
									obj[i].select();
									alert('#request.msg.nolength#\n（' + maxlen + 'バイト以下で入力してください。）');
								}
								return false;
							}
						}
					}
					if (inpcls.match('ymd'))	{
						/* 日付チェック */
					}
					if (inpcls.match('num'))	{
						/* 数値チェック */
						if (obj[i].value != '')	{
							if (obj[i].getAttribute('apmin'))	{
								if (Number(fncUnformatCurrency(obj[i].value)) < Number(obj[i].getAttribute('apmin')))	{
									if (!silent)	{
										obj[i].focus();
										obj[i].select();
										alert(obj[i].getAttribute('apmin') + '以上の値を入力してください。');
									}
									return false;
								}
							}
							if (obj[i].getAttribute('apmax'))	{
								if (Number(fncUnformatCurrency(obj[i].value)) > Number(obj[i].getAttribute('apmax')))	{
									if (!silent)	{
										obj[i].focus();
										obj[i].select();
										alert(obj[i].getAttribute('apmax') + '以下の値を入力してください。');
									}
									return false;
								}
							}
						}
					}
				}
				break;
			}
			/* ラジオボタンの場合 */
			case "RADIO":{
				break;
			}
			/* チェックボックスの場合 */
			case "CHECKBOX":{
				break;
			}
		}
	}
	/* コンボボックスの場合 */
	var obj = searchdiv.getElementsByTagName('select');
	for (i=0; i<obj.length; i++)	{
		switch (obj[i].type.toUpperCase())	{
			case "SELECT-ONE":{
				break;
			}
		}
	}
	return true;
}


/* 単体オブジェクトを使用不可にする */
function fncObjEnabledOne(blnEnabled, strId)	{

	var i;
	if (blnEnabled)	{
		/* 使用不可項目を復活する */
		var obj = document.getElementById(strId);
		switch (obj.type.toUpperCase())	{
			/* ボタンの場合 */
			case "BUTTON":{
				if (obj.getAttribute('aphidden') == 'on')	{
					obj.setAttribute('aphidden','off');
					obj.tabIndex = obj.getAttribute('aptabindex');
					obj.disabled = false;
				}
				break;
			}
			/* テキストボックスの場合 */
			case "TEXT":{
				if (obj.getAttribute('aphidden') == 'on')	{
					obj.setAttribute('aphidden','off');
					obj.tabIndex = obj.getAttribute('aptabindex');
					obj.className = obj.getAttribute('apclass');
					obj.readOnly = '';
				}
				break;
			}
			/* ラジオボタンの場合 */
			case "RADIO":{
				if (obj.getAttribute('aphidden') == 'on')	{
					obj.setAttribute('aphidden','off');
					obj.tabIndex = obj.getAttribute('aptabindex');
					obj.disabled = false;
				}
				break;
			}
			/* チェックボックスの場合 */
			case "CHECKBOX":{
				if (obj[i].getAttribute('aphidden') == 'on')	{
					obj[i].setAttribute('aphidden','off');
					obj[i].tabIndex = obj[i].getAttribute('aptabindex');
					obj[i].disabled = false;
				}
				break;
			}
			/* コンボボックスの場合 */
			case "SELECT-ONE":{
				if (obj.getAttribute('aphidden') == 'on')	{
					obj.setAttribute('aphidden','off');
					obj.tabIndex = obj.getAttribute('aptabindex');
					obj.disabled = false;
				}
				break;
			}
		}
	} else {
		/* 使用不可にする */
		var obj = document.getElementById(strId);
		switch (obj.type.toUpperCase())	{
			/* ボタンの場合 */
			case "BUTTON":{
				if (!obj.disabled)	{
					obj.setAttribute('aphidden','on');
					obj.setAttribute('aptabindex',obj.tabIndex);
					obj.tabIndex = -1;
					obj.disabled = true;
				}
				break;
			}
			/* テキストボックスの場合 */
			case "TEXT":{
				if (!obj.readOnly)	{
					obj.setAttribute('aphidden','on');
					obj.setAttribute('aptabindex',obj.tabIndex);
					obj.tabIndex = -1;
					obj.setAttribute('apclass',obj.className);
					var classstring = new String(obj.className);
					classstring = classstring.replace('input','label');
					classstring = classstring.replace('required','label');
					obj.className = classstring
					obj.readOnly = 'readonly';
				}
				break;
			}
			/* ラジオボタンの場合 */
			case "RADIO":{
				if (!obj.disabled)	{
					obj.setAttribute('aphidden','on');
					obj.setAttribute('aptabindex',obj.tabIndex);
					obj.tabIndex = -1;
					obj.disabled = true;
				}
				break;
			}
			/* チェックボックスの場合 */
			case "CHECKBOX":{
				if (!obj[i].disabled)	{
					obj[i].setAttribute('aphidden','on');
					obj[i].setAttribute('aptabindex',obj[i].tabIndex);
					obj[i].tabIndex = -1;
					obj[i].disabled = true;
				}
				break;
			}
			/* コンボボックスの場合 */
			case "SELECT-ONE":{
				if (!obj.disabled)	{
					obj.setAttribute('aphidden','on');
					obj.setAttribute('aptabindex',obj.tabIndex);
					obj.tabIndex = -1;
					obj.disabled = true;
				}
				break;
			}
		}
	}
	return true;
}

/* DIV内のオブジェクトを使用不可にする */
function fncObjEnabled(blnEnabled, strDiv)	{

	var i;
	if (blnEnabled)	{
		/* 使用不可項目を復活する */
		var searchdiv = document.getElementById(strDiv);
		var obj = searchdiv.getElementsByTagName('input');
		for (i=0; i<obj.length; i++)	{
			switch (obj[i].type.toUpperCase())	{
				/* ボタンの場合 */
				case "BUTTON":{
					if (obj[i].getAttribute('aphidden') == 'on')	{
						obj[i].setAttribute('aphidden','off');
						obj[i].disabled = false;
					}
					break;
				}
				/* テキストボックスの場合 */
				case "TEXT":{
					if (obj[i].getAttribute('aphidden') == 'on')	{
						obj[i].setAttribute('aphidden','off');
						obj[i].className = obj[i].getAttribute('apclass');
						obj[i].readOnly = '';
					}
					break;
				}
				/* ラジオボタンの場合 */
				case "RADIO":{
					if (obj[i].getAttribute('aphidden') == 'on')	{
						obj[i].setAttribute('aphidden','off');
						obj[i].disabled = false;
					}
					break;
				}
				/* チェックボックスの場合 */
				case "CHECKBOX":{
					if (obj[i].getAttribute('aphidden') == 'on')	{
						obj[i].setAttribute('aphidden','off');
						obj[i].disabled = false;
					}
					break;
				}
			}
		}
		/* コンボボックスの場合 */
		var obj = searchdiv.getElementsByTagName('select');
		for (i=0; i<obj.length; i++)	{
			switch (obj[i].type.toUpperCase())	{
				case "SELECT-ONE":{
					if (obj[i].getAttribute('aphidden') == 'on')	{
						obj[i].setAttribute('aphidden','off');
						obj[i].disabled = false;
					}
					break;
				}
			}
		}
	} else {
		/* 使用不可にする */
		var searchdiv = document.getElementById(strDiv);
		var obj = searchdiv.getElementsByTagName('input');
		for (i=0; i<obj.length; i++)	{
			switch (obj[i].type.toUpperCase())	{
				/* ボタンの場合 */
				case "BUTTON":{
					if (!obj[i].disabled)	{
						obj[i].setAttribute('aphidden','on');
						obj[i].disabled = true;
					}
					break;
				}
				/* テキストボックスの場合 */
				case "TEXT":{
					if (!obj[i].readOnly)	{
						obj[i].setAttribute('aphidden','on');
						obj[i].setAttribute('apclass',obj[i].className);
						var classstring = new String(obj[i].className);
						classstring = classstring.replace('input','label');
						classstring = classstring.replace('required','label');
						obj[i].className = classstring
						obj[i].readOnly = 'readonly';
					}
					break;
				}
				/* ラジオボタンの場合 */
				case "RADIO":{
					if (!obj[i].disabled)	{
						obj[i].setAttribute('aphidden','on');
						obj[i].disabled = true;
					}
					break;
				}
				/* チェックボックスの場合 */
				case "CHECKBOX":{
					if (!obj[i].disabled)	{
						obj[i].setAttribute('aphidden','on');
						obj[i].disabled = true;
					}
					break;
				}
			}
		}
		/* コンボボックスの場合 */
		var obj = searchdiv.getElementsByTagName('select');
		for (i=0; i<obj.length; i++)	{
			switch (obj[i].type.toUpperCase())	{
				case "SELECT-ONE":{
					if (!obj[i].disabled)	{
						obj[i].setAttribute('aphidden','on');
						obj[i].disabled = true;
					}
					break;
				}
			}
		}
	}
	return true;
}

/* DIV内のオブジェクトをリセットする */
function fncObjReset(strMode, strDiv)	{

	var i;
	switch (strMode){
		case "keep":	{
			/* 現在の表示内容を保存する */
			var searchdiv = document.getElementById(strDiv);
			var obj = searchdiv.getElementsByTagName('input');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					/* テキストボックスの場合 */
					case "TEXT":{
						obj[i].setAttribute('apkeep',obj[i].value);
						break;
					}
					/* 隠し項目の場合 */
					case "HIDDEN":{
						obj[i].setAttribute('apkeep',obj[i].value);
						break;
					}
					/* ラジオボタンの場合 */
					case "RADIO":{
						obj[i].setAttribute('apkeep',fncGetOption(obj[i].name));
						break;
					}
					/* チェックボックスの場合 */
					case "CHECKBOX":{
						obj[i].setAttribute('apkeep',obj[i].checked);
						break;
					}
				}
			}
			/* コンボボックスの場合 */
			var obj = searchdiv.getElementsByTagName('select');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					case "SELECT-ONE":{
						obj[i].setAttribute('apkeep',obj[i].selectedIndex);
						break;
					}
				}
			}
			/* テキストエリアの場合 */
			var obj = searchdiv.getElementsByTagName('textarea');
			for (i=0; i<obj.length; i++)	{
				if (obj[i].name != '')	{
					switch (obj[i].type.toUpperCase())	{
						case "TEXTAREA":{
							obj[i].setAttribute('apkeep',obj[i].value);
							break;
						}
					}
				}
			}
			break;
		}
		case "reset":	{
			/* 初期状態に戻す */
			var searchdiv = document.getElementById(strDiv);
			var obj = searchdiv.getElementsByTagName('input');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					/* テキストボックスの場合 */
					case "TEXT":{
						obj[i].value = obj[i].getAttribute('apkeep');
						break;
					}
					/* 隠し項目の場合 */
					case "HIDDEN":{
						obj[i].value = obj[i].getAttribute('apkeep');
						break;
					}
					/* ラジオボタンの場合 */
					case "RADIO":{
						if (obj[i].value == obj[i].getAttribute('apkeep'))	{
							obj[i].checked = true;
						}
						break;
					}
					/* チェックボックスの場合 */
					case "CHECKBOX":{
						if (obj[i].getAttribute('apkeep') == 'true' || obj[i].getAttribute('apkeep') == true)	{
							obj[i].checked = true;
						}else{
							obj[i].checked = false;
						}
						break;
					}
				}
			}
			/* コンボボックスの場合 */
			var obj = searchdiv.getElementsByTagName('select');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					case "SELECT-ONE":{
						obj[i].selectedIndex = obj[i].getAttribute('apkeep');
						/* 連動部署対応 */
						if (obj[i].name == 'cmbtantoubusho')	{
							obj[i].onchange();
						}
						break;
					}
				}
			}
			/* テキストエリアの場合 */
			var obj = searchdiv.getElementsByTagName('textarea');
			for (i=0; i<obj.length; i++)	{
				if (obj[i].name != '')	{
					switch (obj[i].type.toUpperCase())	{
						case "TEXTAREA":{
							obj[i].value = obj[i].getAttribute('apkeep');
							break;
						}
					}
				}
			}
			break;
		}
		case "check":	{
			/* 変更をチェックする true:変更なし false:変更あり*/
			var searchdiv = document.getElementById(strDiv);
			var obj = searchdiv.getElementsByTagName('input');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					/* テキストボックスの場合 */
					case "TEXT":{
						if (obj[i].value != obj[i].getAttribute('apkeep'))	{
							return false;
						}
						break;
					}
					/* 隠し項目の場合 */
					case "HIDDEN":{
						if (obj[i].value != obj[i].getAttribute('apkeep'))	{
							return false;
						}
						break;
					}
					/* ラジオボタンの場合 */
					case "RADIO":{
						if (ojb[i].checked)	{
							if (obj[i].value != obj[i].getAttribute('apkeep'))	{
								return false;
							}
						}
						break;
					}
					/* チェックボックスの場合 */
					case "CHECKBOX":{
						if (obj[i].getAttribute('apkeep') == 'true' || obj[i].getAttribute('apkeep') == true)	{
							if (!obj[i].checked)	{
								return false;
							}
						}else{
							if (obj[i].checked)	{
								return false;
							}
						}
						break;
					}
				}
			}
			/* コンボボックスの場合 */
			var obj = searchdiv.getElementsByTagName('select');
			for (i=0; i<obj.length; i++)	{
				switch (obj[i].type.toUpperCase())	{
					case "SELECT-ONE":{
						if (obj[i].selectedIndex != obj[i].getAttribute('apkeep'))	{
							return false;
						}
						break;
					}
				}
			}
			/* テキストエリアの場合 */
			var obj = searchdiv.getElementsByTagName('textarea');
			for (i=0; i<obj.length; i++)	{
				if (obj[i].name != '')	{
					switch (obj[i].type.toUpperCase())	{
						case "TEXTAREA":{
							if (obj[i].value != obj[i].getAttribute('apkeep'))	{
								return false;
							}
							break;
						}
					}
				}
			}
			break;
		}
	}
	return true;
}


/* リストページ処理 */
function fncListPage(strList, numPage, strCtl)	{

	// １ページの最大行数
	var linemax = 50;

	// テーブルの制御を行う
	var table = document.getElementById(strList);
	var count = table.getElementsByTagName('tr').length;
	var linestart = (numPage - 1) * linemax + 1;
	var lineend   = linestart + linemax -1;
	if (lineend > count)	{ lineend = count; }
	for (i=1; i<count; i++)	{
		if (i>=linestart & i<=lineend)	{
			table.getElementsByTagName('tr').item(i).style.display='';
		} else {
			table.getElementsByTagName('tr').item(i).style.display='none';
		}
	}
	table.style.display = '';

	// 現在表示中のページ番号を設定
	table.setAttribute('apnowpage','' + numPage);

	// ページコントロールの表示を行う
	var firstpage = 1;
	var lastpage  = Math.ceil((count-1) / linemax);
	var txtctl = '';
	txtctl  = '該当件数　' + (count-1) + '件';
	if (numPage == firstpage)	{
		txtctl += '　　　<<';
		txtctl += '　<　　';
	} else{
		txtctl += '　　　<a href="##' + strList + 'jump" onclick="fncListPage(\'' + strList + '\',1,\'' + strCtl + '\');"><<</a>';
		txtctl += '　<a href="##' + strList + 'jump" onclick="fncListPage(\'' + strList + '\',' + (numPage-1) + ',\'' + strCtl + '\');"><</a>　　';
	}
	for (i=firstpage; i<=lastpage; i++)	{
		if (numPage == i)	{
			txtctl += i + '　';
		} else {
			txtctl += '<a href="##' + strList + 'jump" onclick="fncListPage(\'' + strList + '\',' + i + ',\'' + strCtl + '\');">' + i + '</a>　';
		}
	}
	if (numPage == lastpage)	{
		txtctl += '　>';
		txtctl += '　>>';
	} else {
		txtctl += '　<a href="##' + strList + 'jump" onclick="fncListPage(\'' + strList + '\',' + (numPage+1) + ',\'' + strCtl + '\');">></a>';
		txtctl += '　<a href="##' + strList + 'jump" onclick="fncListPage(\'' + strList + '\',' + lastpage + ',\'' + strCtl + '\');">>></a>';
	}
	/* コントローラーの指定がある場合にページ遷移ボタンを表示する */
	if (strCtl != '')	{
		var objctl = document.getElementsByTagName('div');
		for (i=0; i<objctl.length; i++)	{
			if (objctl[i].getAttribute('aptype') == strCtl)	{
				fncreplaceInnerHtml (objctl[i], txtctl);
			}
		}
	}
	return true;
}

/* JSON形式の改行コードを変換する */
function fncGetCrLfData(data)	{

	var strold = new String (data);
	var strnew = new String ("");
	var idx;

	for(idx=0; idx<strold.length; idx++) {
		if (strold.substring(idx,idx + 2) == '\\n')	{
			// ＬＦは \n に変換
			strnew += '\n';
			idx++;
		} else if (strold.substring(idx,idx + 2) == '\\r')	{
			// ＣＲは捨てる
			idx++;
		} else {
			strnew += strold.substring(idx,idx + 1);
		}
	}
	return strnew;

}

/* オプションボタンから選択肢を抽出する */
function fncGetOption(strOption)	{
	var i;
	var obj = document.getElementsByTagName('input');
	for (i=0; i<obj.length; i++)	{
		switch (obj[i].type.toUpperCase())	{
			/* ラジオボタンの場合 */
			case "RADIO":{
				if (obj[i].name == strOption)	{
					if (obj[i].checked)	{
						return obj[i].value;
					}
				}
				break;
			}
		}
	}
	return null;
}

/* 小数点以下を必ず表示する */
function fncFormatDecimal(str, keta)	{
	if (fncFormatDecimal.arguments.length == 2)	{
		var blnspace = false;
	} else {
		var blnspace = fncFormatDecimal.arguments[2];
	}

	var atai = new String (fncUnformatCurrency(str));
	var zero = new String ('0000000000');
	var ue = fncFormatCurrency(atai);
	var kazu = new Number (str);

	if ((kazu == 0) && (blnspace))	{
		return '';
	}
	if (atai.match(/\./))	{
		/* 小数点以下あり */
		var ichi = atai.length - atai.search(/\./) - 1;
		return ue + fncLeftStr(zero, keta - ichi);
	} else {
		/* 小数点以下なし */
		return ue + '.' + fncLeftStr(zero, keta);
	}

}


/* 金額をカンマ区切りにする */
function fncFormatCurrency(str) {
	var num = new String(str).replace(/,/g, "");
	while(num != (num = num.replace(/^(-?\d+)(\d{3})/, "$1,$2")));
	return num;
}

/* カンマ区切りを外す */
function fncUnformatCurrency(str) {
	var num = new String(str).replace(/,/g, "");
	var ret = new Number(num);
	return ret;
}

/* 文字列を左から切り出し */
function fncLeftStr(str, len)	{
	var data = new String(str);
	return data.substring(0,len);
}
/* 文字列を右から切り出し */
function fncRightStr(str, len)	{
	var data = new String(str);
	return data.substring(data.length - len, data.length);
}

/* ダブルクオートの抑制 */
function fncHTMLFormat(str)	{
	var moji = new String(str);
	moji = moji.replace(/"/g,"&quot;");
	return moji;
}

/* ＨＴＭＬサニタイズ */
function fncHTMLXss(str)	{
	var moji = new String(str);
	moji = moji.replace(/</g,"&lt;");
	moji = moji.replace(/>/g,"&gt;");
	moji = moji.replace(/&/g,"&amp;");
	return moji;
}

/* オブジェクト名で使用不可にする */
function fncEnabledObjname(strName, blnEnabled)	{
	var obj = document.getElementsByName(strName);
	for (var i=0; i<obj.length; i++)	{
		obj[i].disabled = blnEnabled;
	}
}

/* オブジェクト名で表示、非表示を設定する */
function fncDisplayObjname(strName, blnDisplay)	{
	var i;
	var obj = document.getElementsByName(strName);
	for (i=0; i<obj.length; i++)	{
		if (blnDisplay)	{
			obj[i].style.display = '';
		} else {
			obj[i].style.display = 'none';
		}
	}
}


/* DIV内のオブジェクトを送信用データに加工する */
function fncDivSerialize(strDiv)	{

	var radioitem = new Array();
	var radioidx = 0;
	var i,j;
	var senddata = '';
	var searchdiv = document.getElementById(strDiv);
	var obj = searchdiv.getElementsByTagName('input');
	for (i=0; i<obj.length; i++)	{
		if (obj[i].name != '')	{
			switch (obj[i].type.toUpperCase())	{
				/* テキストボックスの場合 */
				case "TEXT":{
					senddata += '&' + obj[i].name + '=' + encodeURIComponent(obj[i].value);
					senddata += '&' + obj[i].name + '_len=' + obj[i].value.getvarcharBytes();
					break;
				}
				/* 非表示の場合 */
				case "HIDDEN":{
					senddata += '&' + obj[i].name + '=' + encodeURIComponent(obj[i].value);
					break;
				}
				/* ラジオボタンの場合 */
				case "RADIO":{
					var sendok = true;
					for (j=0; j<radioidx; j++)	{
						if (radioitem[j] == obj[i].name)	{
							sendok = false;
						}
					}
					if (sendok)	{
						senddata += '&' + obj[i].name + '=' + encodeURIComponent(fncGetOption(obj[i].name));
						radioitem[radioidx] = obj[i].name;
						radioidx ++;
					}
					break;
				}
				/* チェックボックスの場合 */
				case "CHECKBOX":{
					senddata += '&' + obj[i].name + '=' + encodeURIComponent(obj[i].checked);
					break;
				}
			}
		}
	}
	/* コンボボックスの場合 */
	var obj = searchdiv.getElementsByTagName('select');
	for (i=0; i<obj.length; i++)	{
		if (obj[i].name != '')	{
			switch (obj[i].type.toUpperCase())	{
				case "SELECT-ONE":{
					senddata += '&' + obj[i].name + '=' + encodeURIComponent(obj[i].value);
					break;
				}
			}
		}
	}
	/* テキストエリアの場合 */
	var obj = searchdiv.getElementsByTagName('textarea');
	for (i=0; i<obj.length; i++)	{
		if (obj[i].name != '')	{
			switch (obj[i].type.toUpperCase())	{
				case "TEXTAREA":{
					senddata += '&' + obj[i].name + '=' + encodeURIComponent(obj[i].value);
					senddata += '&' + obj[i].name + '_len=' + obj[i].value.getvarcharBytes();
					break;
				}
			}
		}
	}
	return senddata;
}

/* テーブルに行を追加する */
function fncTableAddrow(strTable, strHtml, LineNum, cellcnt)	{
	var i;
	var table = document.getElementById(strTable);
	var newline = table.insertRow(LineNum);
	for (i=1; i<=cellcnt; i++)	{
		var newCell = newline.insertCell(-1);
	}
	fncreplaceInnerHtml (newline, strHtml);
	newline.setAttribute('datatr','list');		// IE用
//	newline.setAttribute('datatr','list');		// IE以外用
//	for (i=0; i<arrCells.length; i++)	{
//		var newCell = newline.insertCell(-1);
//		fncreplaceInnerHtml (newCell, arrCells[i]);
//		newCell.setAttribute('className','list');	// IE用
//		newCell.setAttribute('class','list');		// IE以外用
//	}
	return true;
}
/* テーブルから行を削除する */
function fncTableDelrow(strTable, LineNum)	{
	var table = document.getElementById(strTable);
	table.deleteRow(LineNum);
	return true;
}
/* テーブルの行数を返却する */
function fncTableMaxline(strTable)	{
	var table = document.getElementById(strTable);
	return table.getAttribute('apmax');
}
/* テーブルの行を入れ替える */
function fncTableRowswap(strTable, Line1, Line2)	{
	/* 入替え対象ＲＯＷを特定 */
	var table = document.getElementById(strTable);
	var row1 = table.rows[Line1];
	var row2 = table.rows[Line2];
	/* FireFoxの場合に、innerHTMLが拾えないので、実体データを取得する */
	var objname  = new Array();
	var objvalue = new Array();
	var objcheck = new Array();
	var objindex = new Array();
	var cnt = 0;
	var i, j;
	for (i=0; i<row1.cells.length; i++)	{
		var obj = row1.cells[i].getElementsByTagName('input');
		for (j=0; j<obj.length; j++)	{
			if (obj[j].name != '')	{
				cnt++;
				objname[cnt]	= obj[j].id;
				objvalue[cnt]	= obj[j].value;
				objcheck[cnt]	= obj[j].checked;
				objindex[cnt]	= obj[j].selectedIndex;
			}
		}
		var obj = row1.cells[i].getElementsByTagName('select');
		for (j=0; j<obj.length; j++)	{
			if (obj[j].name != '')	{
				cnt++;
				objname[cnt]	= obj[j].id;
				objvalue[cnt]	= obj[j].value;
				objcheck[cnt]	= obj[j].checked;
				objindex[cnt]	= obj[j].selectedIndex;
			}
		}
	}
	for (i=0; i<row2.cells.length; i++)	{
		var obj = row2.cells[i].getElementsByTagName('input');
		for (j=0; j<obj.length; j++)	{
			if (obj[j].name != '')	{
				cnt++;
				objname[cnt]	= obj[j].id;
				objvalue[cnt]	= obj[j].value;
				objcheck[cnt]	= obj[j].checked;
				objindex[cnt]	= obj[j].selectedIndex;
			}
		}
		var obj = row2.cells[i].getElementsByTagName('select');
		for (j=0; j<obj.length; j++)	{
			if (obj[j].name != '')	{
				cnt++;
				objname[cnt]	= obj[j].id;
				objvalue[cnt]	= obj[j].value;
				objcheck[cnt]	= obj[j].checked;
				objindex[cnt]	= obj[j].selectedIndex;
			}
		}
	}
	/* ＲＯＷを入替える */
	var work = row1.innerHTML;
	fncreplaceInnerHtml (row1, row2.innerHTML);
	fncreplaceInnerHtml (row2, work);
	/* 実体を設定しなおす */
	for (i=1; i<=cnt; i++)	{
		var obj = document.getElementById(objname[i]);
		if (obj)	{
			obj.value = objvalue[i];
			obj.checked = objcheck[i];
			obj.selectedIndex = objindex[i];
		}
	}
}

/* テーブルの行NOを正しく表示する */
function fncTableSeq(strTable,optOrder)	{
	var i;
	var table = document.getElementById(strTable);
	for (i=1; i<=table.getAttribute('apmax'); i++)	{
		var cell = table.rows[i].cells[0];
		var no = cell.getElementsByTagName('input');
		if (no.length > 0) {	no[0].value = i;	}
		if (optOrder)	{
			/* ＵＰ／ＤＯＷＮボタンの制御を行う */
			var cell = table.rows[i].cells[1];
			var no = cell.getElementsByTagName('input');
			if (i == 1)	{
				if (no.length > 0) {	no[0].style.display = 'none';	}
			} else {
				if (no.length > 0) {	no[0].style.display = '';	}
			}
			var cell = table.rows[i].cells[2];
			var no = cell.getElementsByTagName('input');
			if (i == table.getAttribute('apmax'))	{
				if (no.length > 0) {	no[0].style.display = 'none';	}
			} else {
				if (no.length > 0) {	no[0].style.display = '';	}
			}
		}
	}
}
/* テーブルの項目名を順番通りに変更する */
function fncTableNameReset(strTable)	{
	var i;
	var j;
	var k;
	var table = document.getElementById(strTable);
	var reccnt = table.getAttribute('apmax');
	var stcnt = 1;
	/* ヘッダーの無いテーブルに対応する */
	if (fncTableNameReset.arguments.length >= 2)	{
		if (fncTableNameReset.arguments[1])	{
			stcnt = 0;
			reccnt--;
		}
	}
	for (i=stcnt; i<=reccnt; i++)	{
		for (j=0; j<table.rows[i].cells.length; j++)	{
			var cell = table.rows[i].cells[j];
			var data = cell.getElementsByTagName('input');
			for (k=0; k<data.length; k++)	{
				var namae = data[k].getAttribute('aptype');
				if (namae)	{
					data[k].setAttribute('name', namae + '_' + i);
					data[k].setAttribute('id', namae + '_' + i);
					data[k].setAttribute('apnum', i);
				}
			}
			var data = cell.getElementsByTagName('select');
			for (k=0; k<data.length; k++)	{
				var namae = data[k].getAttribute('aptype');
				if (namae)	{
					data[k].setAttribute('name', namae + '_' + i);
					data[k].setAttribute('id', namae + '_' + i);
					data[k].setAttribute('apnum', i);
				}
			}
		}
	}
}

/* クラス名を取得する */
function fncGetClass(obj)	{
	var clsname = obj.getAttribute('class');
	if (!clsname)	{
		var clsname = obj.getAttribute('className');
	}
	return clsname
}
/* クラス名を設定する */
function fncSetClass(obj, cls)	{
	obj.setAttribute('class', cls);
	obj.setAttribute('className', cls);
	return true
}

/* メッセージ変換 */
function fncMessage(data)	{
	/* // タグテキストをそのまま表示 させる為の文字変換を行う */
	var strold = new String (data);
	var strnew = new String ("");
	var idx;

	for(idx=0; idx<strold.length; idx++) {
		if (strold.charAt(idx) == '\\') {
			if (strold.length >= idx + 1)	{
				if (strold.charAt(idx + 1) == 'n')	{
					strnew += "\n";
					idx++;
				}
			}
		} else {
			strnew = strnew + strold.charAt(idx);
		}
	}
	return strnew;
}

/* 置換処理（全部置換） */
function fncReplaceAll( str, p1, p2 ) {
	return str.split(p1).join(p2);
}

/* 前後の空白除去 */
function fncTrim(value){
	return String(value).replace(/^[ 　]*/gim, "").replace(/[ 　]*$/gim, "");
}

/* 前後の空白除去（全角は残すバージョン） */
function fncTrim2(value){
	return String(value).replace(/^[ ]*/gim, "").replace(/[ ]*$/gim, "");
}

/*
//フレームの名前からindexを取得する
*/
function func_Get_FrameNameToIndex(frame_obj,frame_name){
	for (var i = 0; i < frame_obj.length; i++){
		if (frame_obj[i].name == frame_name){
			break;
		}
	}
	return i;
}


/* 局・部・グループから局を切り出す */
function fncSplitKyoku(str)	{

	var atai = String(str + '       ');
	if (str == '')	{
		return '';
	}else{
		return atai.substring(0,3);
	}
}

/* 局・部・グループから部を切り出す */
function fncSplitBu(str)	{

	var atai = String(str + '       ');
	if (str == '')	{
		return '';
	}else{
		return atai.substring(3,5);
	}
}

/* 局・部・グループからグループを切り出す */
function fncSplitGroup(str)	{

	var atai = String(str + '       ');
	if (str == '')	{
		return '';
	}else{
		return atai.substring(5,7);
	}
}


/* 部署・社員コンボの作成（連動可能） */
/* 注意：部署及び社員の選択可能データとして、
　　　cmbrendoubusho.cfm/cmbrendoushain.cfmにより展開された部署、社員データが必要です。
例：
<cfmodule template="/customtag/cmbrendoubusho.cfm" attributecollection="#mst#">
<cfmodule template="/customtag/cmbrendoushain.cfm" attributecollection="#mst#">
*/
function fncCmbBushoShain(strId)	{

	if (fncCmbBushoShain.arguments.length == 2)	{
		var nonselbusho = fncCmbBushoShain.arguments[1];
		var nonselshain = nonselbusho;
	}else{
		var nonselbusho = '(すべての部署)';
		var nonselshain = '(すべての社員)';
	}

	/* 連動部署・社員コンボを設定 */
	var form = document.getElementById(strId);
	var combo = form.getElementsByTagName('select');
	for (var i=0; i<combo.length; i++)	{
		if (combo[i].getAttribute('aptype') == 'rendou_busho')	{
			var bushocmb = combo[i];
			var shaincmb = document.getElementById(bushocmb.getAttribute('appair'));
			var bushoval = bushocmb.getAttribute('apvalue');
			var shainval = shaincmb.getAttribute('apvalue');
			/* 部署コンボを作る */
			with(bushocmb.options[0] = new Option()) {
				text = nonselbusho; value = 'busho';
			}
			for (var j=0; j<qbushocmb['bumon'].length; j++)	{
				with(bushocmb.options[j+1] = new Option()) {
					text = qbushocmb['busho_abbrev'][j];
					value = qbushocmb['bumon'][j];
					if (qbushocmb['bumon'][j] == bushoval)	{ selected = true; }
				}
			}
			/* 部署コンボ選択時の社員コンボ入替え処理 */
			bushocmb.onchange = function() {
				var shaincmb = document.getElementById(this.getAttribute('appair'));
				var bushoval = this.value;
				if (bushoval == 'busho') { bushoval = ''; }
				while (shaincmb.options.length > 0) { shaincmb.options[0] = null; }
				var idx = 0;
				with(shaincmb.options[0] = new Option()) {
					text = nonselshain; value = 'shain'; selected = true;
				}
				for (var j=0; j<qshaincmb['shain_cd'].length; j++)	{
					if (bushoval == '' || bushoval == String(qshaincmb['cmbindex'][j]).substring(5,13))	{
						idx++;
						with(shaincmb.options[idx] = new Option()) {
							text = qshaincmb['shain_name'][j];
							value = qshaincmb['shain_cd'][j];
						}
					}
				}
			}
			/* 社員コンボを作る */
			var idx = 0;
			with(shaincmb.options[0] = new Option()) {
				text = nonselshain; value = 'shain';
			}
			for (var j=0; j<qshaincmb['shain_cd'].length; j++)	{
				if (bushoval == '' || bushoval == String(qshaincmb['cmbindex'][j]).substring(5,13))	{
					idx++;
					with(shaincmb.options[idx] = new Option()) {
						text = qshaincmb['shain_name'][j];
						value = qshaincmb['shain_cd'][j];
						if (qshaincmb['shain_cd'][j] == shainval) { selected = true; }
					}
				}
			}
		}
		if (combo[i].getAttribute('aptype') == 'cmbbusho')	{
			var bushocmb = combo[i];
			var bushoval = bushocmb.getAttribute('apvalue');
			/* 部署コンボを作る */
			with(bushocmb.options[0] = new Option()) {
				text = nonselbusho; value = 'busho';
			}
			for (var j=0; j<qbushocmb['bumon'].length; j++)	{
				with(bushocmb.options[j+1] = new Option()) {
					text = qbushocmb['busho_abbrev'][j];
					value = qbushocmb['bumon'][j];
					if (qbushocmb['bumon'][j] == bushoval)	{ selected = true; }
				}
			}
		}
	}
}


/* innerHTMLでテーブル要素を入れ替える魔法(for IE) */
function fncreplaceInnerHtml(tgtElm, innerHTML) {
    for (;;) {
        if (typeof innerHTML!='string'||typeof tgtElm!='object'||tgtElm.nodeType!=1/*ELEMENT_NODE*/) break;
        try {
            tgtElm.innerHTML=innerHTML;
        }
        catch (e) {
            var chld;
            while (chld=tgtElm.firstChild) tgtElm.removeChild(chld);    //  remove all child elements
            if (innerHTML.match(/^\s*$/) ) break;   //  clear only

            var tagName=tgtElm.tagName.toLowerCase(), tmp, html='<'+tagName+'>'+innerHTML+'</'+tagName+'>';
            switch (tagName) {
                case    'thead' :
                case    'tbody' :
                case    'tfoot' :
                    tmp=document.createElement('table');
                    fncreplaceInnerHtml(tmp, html);
                    break;
                case    'tr'    :
                    tmp=document.createElement('table');
                    fncreplaceInnerHtml(tmp, '<tbody>'+html+'</tbody>');
                    tmp=tmp.firstChild;
                    break;
                default         :
                    tmp=document.createElement('div');
                    tmp.innerHTML=html;
                    break;
            }
            var tmpElm=tmp.firstChild;
            while (chld=tmpElm.firstChild) tgtElm.appendChild(chld);
        }
        break;
    }
    return tgtElm;
}



/* ファイルアップロード */

(function(){
var d = document, w = window;
function addEvent(el, type, fn){
	if (w.addEventListener){
		el.addEventListener(type, fn, false);
	} else if (w.attachEvent){
		var f = function(){
		  fn.call(el, w.event);
		};
		el.attachEvent('on' + type, f)
	}
}
var toElement = function(){
	var div = d.createElement('div');
	return function(html){
		div.innerHTML = html;
		var el = div.childNodes[0];
		div.removeChild(el);
		return el;
	}
}();
function hasClass(ele,cls){ return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)')); }
function addClass(ele,cls) {if (!hasClass(ele,cls)) ele.className += " "+cls; }
function removeClass(ele,cls) {
	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
	ele.className=ele.className.replace(reg,' ');
}
if (document.documentElement["getBoundingClientRect"]){
	var getOffset = function(el){
		var box = el.getBoundingClientRect(),
		doc = el.ownerDocument,
		body = doc.body,
		docElem = doc.documentElement,
		// IE用
		clientTop = docElem.clientTop || body.clientTop || 0,
		clientLeft = docElem.clientLeft || body.clientLeft || 0,
		zoom = 1;
		if (body.getBoundingClientRect) {
			var bound = body.getBoundingClientRect();
			zoom = (bound.right - bound.left)/body.clientWidth;
		}
		if (zoom > 1){ clientTop = 0; clientLeft = 0; }
		var top = box.top/zoom + (window.pageYOffset || docElem && docElem.scrollTop/zoom || body.scrollTop/zoom) - clientTop,
		left = box.left/zoom + (window.pageXOffset|| docElem && docElem.scrollLeft/zoom || body.scrollLeft/zoom) - clientLeft;
		return { top: top,left: left };
	}
} else {
	var getOffset = function(el){
		var top = 0, left = 0;
		do {
			top += el.offsetTop || 0;
			left += el.offsetLeft || 0;
		}
		while (el = el.offsetParent);
		return {left: left, top: top };
	}
}
function getBox(el){
	var left, right, top, bottom;
	var offset = getOffset(el);
	left = offset.left;
	top = offset.top;
	right = left + el.offsetWidth;
	bottom = top + el.offsetHeight;
	return {
		left: left,
		right: right,
		top: top,
		bottom: bottom
	};
}
function getMouseCoords(e){
	if (!e.pageX && e.clientX){
		var zoom = 1;
		var body = document.body;
		if (body.getBoundingClientRect) {
			var bound = body.getBoundingClientRect();
			zoom = (bound.right - bound.left)/body.clientWidth;
		}
		return {
			x: e.clientX / zoom + d.body.scrollLeft + d.documentElement.scrollLeft,
			y: e.clientY / zoom + d.body.scrollTop + d.documentElement.scrollTop
		};
	}
	return { x: e.pageX, y: e.pageY };
}
function fileFromPath(file){ return file.replace(/.*(\/|\\)/, ""); }
function getExt(file){ return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : ''; }
var getXhr = function(){
	var xhr;
	return function(){
		if (xhr) return xhr;
		if (typeof XMLHttpRequest !== 'undefined') {
			xhr = new XMLHttpRequest();
		} else {
			var v = [
				"Microsoft.XmlHttp",
				"MSXML2.XmlHttp.5.0",
				"MSXML2.XmlHttp.4.0",
				"MSXML2.XmlHttp.3.0",
				"MSXML2.XmlHttp.2.0"
			];
			for (var i=0; i < v.length; i++){
				try {
					xhr = new ActiveXObject(v[i]);
					break;
				} catch (e){}
			}
		}
		return xhr;
	}
}();

Ajax_upload = ajaxuplod = function(options){
	this._input = null;
	this._disabled = false;
	this._submitting = false;
	this._justClicked = false;
	this._parentDialog = d.body;
	this._settings = {
		button		: '',
		action		: '',
		onclick		: function(){ return true; },
		postdata	: '',
		target		: '',
		onsuccess	: '',
		name		: 'uploadfile',
		data		: {},
		responseType	: false,
		closeConnection	: '',
		hoverClass	: 'hover',
		extension	: '',
		onChange	: function(file, extension){},
		onSubmit	: function(file, extension) {
					/* アップロード確認 */
					if (this._settings.extension)	{
						var idx;
						var ext = this._settings.extension.split(',');
						for(idx=0; idx<ext.length; idx++) {
							if (ext[idx] == extension) { idx=9999; break; }
						}
						if (idx<=ext.length) {
							alert('このファイルは取り込みできません。\n取り込み可能なファイルの拡張子は ' + this._settings.extension + ' です。');
							return false;
						}
					}
					if (confirm(file + ' を取り込みます。よろしいですか？'))	{
						gfncWait(true);
						this._button.value='Sending...';
					}else{
						return false;
					}
				  },
		onComplete	: function(file, response) {
					/* アップロード完了後処理 */
					this._button.value=this._settings.buttonvalue;
					gfncWait(false);
					var result = MAP01.gfncgetdata('RESULT', response);
					var message = MAP01.gfncgetdata('MESSAGE', response);
					var action = MAP01.gfncgetdata('ACTION', response);
					if (message != '') { alert(fncMessage(message)); }
					if (result == 'OK') {
						if (action) { var exec = eval(action); }
						if (this._settings.onsuccess)	{
							gfncWait(true);
							document.form1.action=this._settings.onsuccess;
							document.form1.target=this._settings.target;
							document.form1.submit();
						}
					}
				  }
	};
	for (var i in options) { this._settings[i] = options[i]; }
	this._button = d.getElementById(this._settings.button);
	this._settings.buttonvalue = this._button.value;
	this._createInput();
	this._rerouteClicks();
}

ajaxuplod.prototype = {
	start	: function()	{
	},
	_createInput : function(){
		var self = this;
		var input = d.createElement("input");
		input.setAttribute('type', 'file');
		input.setAttribute('name', this._settings.name);
		input.onclick = this._settings.onclick;
		var styles = {'position' : 'absolute','margin': '-5px 0 0 -175px','padding': 0,'width': '220px','height': '10px','fontSize': '14px','opacity': 0,'cursor': 'pointer','display' : 'none','zIndex' :  99999999};
		for (var i in styles){ input.style[i] = styles[i]; }
		if ( ! (input.style.opacity === "0")){
			input.style.filter = "alpha(opacity=0)";
		}
		this._parentDialog.appendChild(input);
		addEvent(input, 'change', function(){
			var file = fileFromPath(this.value);
			if(self._settings.onChange.call(self, file, getExt(file)) == false ){
				return;
			}
			self.submit();
		});
		addEvent(input, 'click', function(){
			self._justClicked = true;
			setTimeout(function(){
				self._justClicked = false;
			}, 2500);
		});
		input.style.display = 'none';
		this._input = input;
	},
	_rerouteClicks : function (){
		var self = this;
		var box, dialogOffset = {top:0, left:0}, over = false;
		addEvent(self._button, 'mouseover', function(e){
			if (!self._input || over) return;
			over = true;
			box = getBox(self._button);
			if (self._parentDialog != d.body){
				dialogOffset = getOffset(self._parentDialog);
			}
		});
		addEvent(document, 'mousemove', function(e){
			var input = self._input;
			if (!input || !over) return;
			if (self._disabled){
				removeClass(self._button, self._settings.hoverClass);
				input.style.display = 'none';
				return;
			}
			var c = getMouseCoords(e);
			if ((c.x >= box.left) && (c.x <= box.right) &&
			(c.y >= box.top) && (c.y <= box.bottom)){
				input.style.top = c.y - dialogOffset.top + 'px';
				input.style.left = c.x - dialogOffset.left + 'px';
				input.style.display = 'block';
				addClass(self._button, self._settings.hoverClass);
			} else {
				// mouse left the button
				over = false;
				var check = setInterval(function(){
					if (self._justClicked){
						return;
					}
					if ( !over ){
						input.style.display = 'none';
					}
					clearInterval(check);
				}, 25);
				removeClass(self._button, self._settings.hoverClass);
			}
		});
	},
	_createIframe : function(){
		var id = fncGetIdString();
		var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
		iframe.id = id;
		iframe.style.display = 'none';
		d.body.appendChild(iframe);
		return iframe;
	},
	submit : function(){
		var self = this, settings = this._settings;
		if (this._input.value === ''){
			return;
		}
		var file = fileFromPath(this._input.value);
		if (! (settings.onSubmit.call(this, file, getExt(file)) == false)) {
			var iframe = this._createIframe();

			var form = this._createForm(iframe);
			form.appendChild(this._input);
			if (settings.closeConnection && /AppleWebKit|MSIE/.test(navigator.userAgent)){
				var xhr = getXhr();
				xhr.open('GET', settings.closeConnection, false);
				xhr.send('');
			}
			var org_charset = document.charset;
			document.charset = 'UTF-8';
			form.submit();
			document.charset = org_charset;
			d.body.removeChild(form);
			form = null;
			this._input = null;
			this._createInput();
			var toDeleteFlag = false;
			addEvent(iframe, 'load', function(e){
				if (iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" || iframe.src == "javascript:'<html></html>';"){
					if( toDeleteFlag ){
						// Fix busy state in FF3
						setTimeout( function() {
							d.body.removeChild(iframe);
						}, 0);
					}
					return;
				}
				var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;
				if (doc.readyState && doc.readyState != 'complete'){ return; }
				if (doc.body && doc.body.innerHTML == "false"){ return; }
				var response;
				if (doc.XMLDocument){
					response = doc.XMLDocument;
				} else if (doc.body){
					response = doc.body.innerHTML;
					if (settings.responseType && settings.responseType.toLowerCase() == 'json'){
						if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == 'PRE'){
							response = doc.body.firstChild.firstChild.nodeValue;
						}
						if (response) {
							response = window["eval"]("(" + response + ")");
						} else {
							response = {};
						}
					}
				} else {
					var response = doc;
				}
				settings.onComplete.call(self, file, response);
				toDeleteFlag = true;
				iframe.src = "javascript:'<html></html>';";
			});
		} else {
			d.body.removeChild(this._input);
			this._input = null;
			this._createInput();
		}
	},
	_createForm : function(iframe){
		var settings = this._settings;
		var form = toElement('<form method="post" enctype="multipart/form-data" Accept-charset="UTF-8"></form>');
		form.style.display = 'none';
		var url = '';
		var idx;
		if (settings.postdata['postname'])	{
			for (idx=0; idx<settings.postdata['postname'].length; idx++)	{
				var data = eval(settings.postdata['postdata'][idx]);
				url += '&' + settings.postdata['postname'][idx] + '=' + data;
			}
		}
		form.action = settings.action + url;
		form.target = iframe.name;
		d.body.appendChild(form);
		for (var prop in settings.data){
			var el = d.createElement("input");
			el.type = 'hidden';
			el.name = prop;
			el.value = settings.data[prop];
			form.appendChild(el);
		}
		return form;
	}
};
})();



/* 拡張ファンクション */
function eID(strId)	{
	/* getElementByIdの代わり */
	return document.getElementById(strId);
}

/*
’================================================================================
’空白トリム処理
’================================================================================
*/
function delSpace(p_val){
    var flg = 1;

    // 先頭のスペースを取る
    for(i=0; i<p_val.length; i++){
        if((p_val.substring(i, i+1) != ' ') && (p_val.substring(i, i+1) != '　')) {
            p_val = p_val.substring(i, p_val.length+1);
            flg = 0; break;
        }
    }

    // 末尾のスペースを取る
    for(i=p_val.length-1; i>=0; i--){
        if((p_val.substring(i, i+1) != ' ') && (p_val.substring(i, i+1) != '　')) {
            p_val = p_val.substring(0, i+1);
            flg = 0; break;
        }
    }

    // すべてスペースの場合はクリア
    if(flg){ p_val = ''; }

    return(p_val);
}

/* 改行数チェック */
function fncCheckCR(obj,cnt,tgtnm)	{
	var cntCR = 0;
	for (var idx=0; idx<obj.value.length; idx++)	{
		if (obj.value.charAt(idx) == '\n') { cntCR++; }
	}
	if (cntCR >= cnt)	{
		if (!confirm(tgtnm + 'に ' + (cnt + 1) + '#request.msg.overline#'))	{
			obj.focus();
			return false;
		}
	}
	return true;
}


