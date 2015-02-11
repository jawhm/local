
// ＦａｃｅＢｏｏｋウォール読み込み
$(function(){
	$('#facebookwall').fbWall({ id:'257122891001724',accessToken:'158074594262625|uB3Xinq5YJPu2UurVFfo9dT28vw',showGuestEntries:false});
});
google.load("feeds", "1");


// ＷｏｒｄＰｒｅｓｓからＲＳＳ読み込み
function loadFeed() {
    // 初期化
    var feed = new google.feeds.Feed("http://www.jawhm.or.jp/ja/?feed=rss2&cat=5");
    // 記事を最大10件読み込む
    feed.setNumEntries(5);
    var cnt = 0;
    // 記事を読み込む
    feed.load(function(result) {
        var html;
        // 読み込みに成功したときの処理
        if (!result.error) {
            // サイトのタイトルを出力
            html = '';
            // 各記事の情報を順に出力
            if (result.feed.entries.length) {
                for (var i = 0; i < result.feed.entries.length; i++) {
                    // 各記事のタイトルと概要を出力
		    var randnum = 2 + Math.floor( Math.random() * 8 ); 
                    var entry = result.feed.entries[i];
		    if (i == 0)	{
			    html += '<div class="top-pickup" style="margin-top:0px;">';
		    }else{
			    html += '<div class="top-pickup">';
		    }
		    var value = entry.contentSnippet;
		    value = value.replace(/&#160;/g,"");
		    value = value.replace(/^\s+/, "");
		    html += '<p><img src="images/arrow030' + randnum + '.gif" alt="PickUp">　<a href="' + entry.link + '">' + entry.title + '</a></p>';
                    html += '<p>' + value + '</p>';
		    html += '</div>';
                }
           }
       }
       // 読み込みエラー時の処理
       else {
           html = '<p>お知らせの読み込みに失敗しました。</p>';
       }
       // 読み込み結果を、idが「feed」の要素に流し込む
       var container = document.getElementById("feed");
       container.innerHTML = html;
    });
}
google.setOnLoadCallback(loadFeed);


