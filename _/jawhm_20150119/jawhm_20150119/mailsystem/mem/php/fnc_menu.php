<?php

$menu_title = '';
$menu = '';
$menu_title[] = array();
$menu[] = array();


// メニュー定義 ----------------------------------------------------------

$menu_title[] .= 'イベント';
$menu[] .= '
	<a href="'.$url_base.'main/event">イベント検索</a><br/>
	<a href="'.$url_base.'main/yoyaku">予約検索</a><br/>
	<a href="'.$url_base.'main/event/list">予約状況リスト</a><br/>
';

$menu_title[] .= 'メンバー（有料会員）';
$menu[] .= '
	<a href="'.$url_base.'main/mem">メンバー管理</a><br/>
';

$menu_title[] .= 'メール配信';
$menu[] .= '
	<a href="'.$url_base.'main/mail">一斉配信</a><br/>
	<a href="'.$url_base.'main/mailtemp">テンプレート</a><br/>
	<a href="'.$url_base.'main/mail/haihaisend">メアド情報更新</a><br/>
';

$menu_title[] .= 'イベント一括登録';
$menu[] .= '
	<a href="'.$url_base.'main/event2">イベント一括登録</a><br/>
';

$menu_title[] .= '決済管理';
$menu[] .= '
	<a href="'.$url_base.'main/zeus">カード手動決済</a><br/>
	<a href="'.$url_base.'main/zeus/convmanu">コンビニ手動決済</a><br/>
';


$menu_title[] .= 'その他';
$menu[] .= '
	<a target="_blank" href="http://www.jawhm.or.jp/mailsystem/tools/upload/">画像アップロード</a><br/>
	<a href="'.$url_base.'main/place">地域編集</a><br/>
';

// ログイン種別別画面表示 ------------------------------------------------
if ($user_id == '')	{
	// 一般ユーザ
}else{
	// 許可ユーザ

	if ($_SESSION['user_level'] >= 5)	{
	}

	if ($_SESSION['user_level'] >= 9)	{
		$menu_title[] .= '管理メニュー';
		$menu[] .= '
			<a href="'.$url_base.'main/kanri">管理メニューへ</a><br/>
		';
	}
}


?>