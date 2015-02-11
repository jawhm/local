
// メッセージボードを書き換える

var se_int = '';
var se_obj = '';

//$(function(){
//});
se_int = setInterval('fnc_se()',1000);

function fnc_se(){
	clearInterval(se_int);
	var se_obj = document.getElementById('showevents')
	if (se_obj)	{

		se_obj.innerHTML = '<iframe id="event_iframe" name="event_iframe" height="1200" width="560" src="http://www.jawhm.or.jp/event/getlist/event.php" frameborder="0" style="border:3px dotted greenyellow;"></iframe>';

/*

		var out = document.createElement('script');
		out.src='http://www.jawhm.or.jp/event/getlist/event.php';
		se_obj.appendChild(out);

		se_obj.innerHTML = '<iframe id="event_iframe" name="event_iframe" height="800" width="550" src="http://www.jawhm.or.jp/event/getlist/event.php" frameborder="0" style=""></iframe>';
		se_obj.innerHTML = '<iframe id="RenewalFrame" name="RenewalFrame" height="300" src="http://www.jawhm.or.jp/event/getlist/event.php" frameborder="0" style="width:100%;margin-top:16px;"></iframe>';

		var foo = new gfncAjaxReq({
				 url	: 'http://www.jawhm.or.jp/event/getlist/event.php'
				,data	: 'id=ameba'
				,onGetdata : function(res)	{
					se_obj.innerHTML = res;
				}
				,onError : function(e)	{
					se_obj.innerHTML = e;
			        }
			});
*/

		return true;
	}
	se_int = setInterval('fnc_se()',1000);
	return false;
}

<!--- オブジェクト型：非同期通信 --->
gfnc_AjaxReq = gfncAjaxReq = function(options){
	this._settings = {
		 url		: ''			// ＵＲＬ
		,data		: ''			// 送信データ
		,method		: 'POST'		// 送信方法
		,onGetdata	: function(res)	{	// データ受信時ファンクション
				  }
		,onError	: function(e)	{
				  }
	};
	for (var i in options) { this._settings[i] = options[i]; }
	this.status = this.start();	// 初期画面表示
}
gfncAjaxReq.prototype = {
	start	: function()	{
			// 通信開始
			var settings = this._settings;
			try {
				var httpoj = gcreateHttpRequest();
				var url = '' + this._settings['url'];
				httpoj.open( this._settings['method'] , url , true );
				httpoj.onreadystatechange = function()
				{
					if (httpoj.readyState==4) {
						if(httpoj.status==200) {
							<!--- エラーの確認 --->
							var res = httpoj.responseText;
							try{
								var res = httpoj.responseText;
								settings.onGetdata.call (this, res);
							} catch(e) {
								settings.onError.call(this, 'onGetdata呼び出しエラー : ' + e);
								return null;
							}
						} else {
							settings.onError.call(this, '通信エラー Status : ' + httpoj.status);
						}
					}
				}
				httpoj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				httpoj.send( this._settings['data'] );
			} catch(e) {
				settings.onError.call (this, e);
			}
		}
}

function gcreateHttpRequest(){
	<!--- // 通信OBJを生成する --->
	if(window.ActiveXObject){
		try {
			<!--- //MSXML2以降用 --->
			return new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				<!--- //旧MSXML用 --->
				return new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				return null;
			}
		}
	} else if(window.XMLHttpRequest){
		<!--- //Win ie以外のXMLHttpRequestオブジェクト実装ブラウザ用 --->
		return new XMLHttpRequest();
	} else {
		return null;
	}
}

