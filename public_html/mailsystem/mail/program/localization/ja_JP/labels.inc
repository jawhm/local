<?php

/*

+-----------------------------------------------------------------------+
| language/ja_JP/labels.inc                                             |
|                                                                       |
| Language file of the Roundcube Webmail client                         |
| Copyright (C) 2005-2010, Roundcube Dev. - Switzerland                 |
| Licensed under the GNU GPL                                            |
|                                                                       |
+-----------------------------------------------------------------------+
| Author: Tadashi Jokagi <elf2000@users.sourceforge.net>                |
|         Takashi Takamatsu <taka717@gmail.com>                         |
+-----------------------------------------------------------------------+

@version $Id: labels.inc 5291 2011-09-28 17:10:45Z thomasb $

EN-Revision: 5210

*/

// login page
$labels = array();
$labels['welcome'] = 'ようこそ $product へ';
$labels['username'] = 'ユーザー名';
$labels['password'] = 'パスワード';
$labels['server'] = 'サーバー';
$labels['login'] = 'ログイン';

// taskbar
$labels['logout'] = 'ログアウト';
$labels['mail'] = 'メール';
$labels['settings'] = '個人設定';
$labels['addressbook'] = 'アドレス帳';

// mailbox names
$labels['inbox'] = '受信トレイ';
$labels['drafts'] = '下書き';
$labels['sent'] = '送信済みアイテム';
$labels['trash'] = 'ごみ箱';
$labels['junk'] = '迷惑メール';

// message listing
$labels['subject'] = '件名';
$labels['from'] = '差出人';
$labels['to'] = '宛先';
$labels['cc'] = 'コピー';
$labels['bcc'] = 'Bcc';
$labels['replyto'] = '返信先の指定';
$labels['followupto'] = 'Followup-To';
$labels['date'] = '日付';
$labels['size'] = '容量';
$labels['priority'] = '優先度';
$labels['organization'] = '企業名';
$labels['readstatus'] = '閲覧の状態';

$labels['mailboxlist'] = 'フォルダー一覧';
$labels['messagesfromto'] = '表示中のメール: $from ～ $to (全: $count 件)';
$labels['threadsfromto'] = '表示中のスレッド: $from ～ $to (全: $count 件)';
$labels['messagenrof'] = '現在のメール: $nr (全: $count 件)';

$labels['copy'] = 'コピー';
$labels['move'] = '移動';
$labels['moveto'] = 'フォルダーの移動';
$labels['download'] = 'ダウンロード';

$labels['filename'] = 'ファイル名';
$labels['filesize'] = 'ファイル サイズ';

$labels['addtoaddressbook'] = 'アドレス帳に追加';

// weekdays short
$labels['sun'] = '日';
$labels['mon'] = '月';
$labels['tue'] = '火';
$labels['wed'] = '水';
$labels['thu'] = '木';
$labels['fri'] = '金';
$labels['sat'] = '土';

// weekdays long
$labels['sunday'] = '日曜日';
$labels['monday'] = '月曜日';
$labels['tuesday'] = '火曜日';
$labels['wednesday'] = '水曜日';
$labels['thursday'] = '木曜日';
$labels['friday'] = '金曜日';
$labels['saturday'] = '土曜日';

// months short
$labels['jan'] = '1 月';
$labels['feb'] = '2 月';
$labels['mar'] = '3 月';
$labels['apr'] = '4 月';
$labels['may'] = '5 月';
$labels['jun'] = '6 月';
$labels['jul'] = '7 月';
$labels['aug'] = '8 月';
$labels['sep'] = '9 月';
$labels['oct'] = '10 月';
$labels['nov'] = '11 月';
$labels['dec'] = '12 月';

// months long
$labels['longjan'] = '1 月';
$labels['longfeb'] = '2 月';
$labels['longmar'] = '3 月';
$labels['longapr'] = '4 月';
$labels['longmay'] = '5 月';
$labels['longjun'] = '6 月';
$labels['longjul'] = '7 月';
$labels['longaug'] = '8 月';
$labels['longsep'] = '9 月';
$labels['longoct'] = '10 月';
$labels['longnov'] = '11 月';
$labels['longdec'] = '12 月';

$labels['today'] = '今日';

// toolbar buttons
$labels['checkmail'] = '新着の確認';
$labels['writenewmessage'] = '新規メールの作成';
$labels['replytomessage'] = '返信';
$labels['replytoallmessage'] = '差出人とすべての宛先に返信';
$labels['replyall'] = '全員に返信';
$labels['replylist'] = 'ML に返信';
$labels['forwardinline']    = '本文に挿入して転送';
$labels['forwardattachment'] = '添付形式で転送';
$labels['forwardmessage'] = '転送';
$labels['deletemessage'] = '削除';
$labels['movemessagetotrash'] = 'ごみ箱に移動';
$labels['printmessage'] = '印刷';
$labels['previousmessage'] = '前のメールへ';
$labels['firstmessage'] = '最初のメールへ';
$labels['nextmessage'] = '次のメールへ';
$labels['lastmessage'] = '最後のメールへ';
$labels['backtolist'] = '一覧に戻る';
$labels['viewsource'] = 'ソースの表示';
$labels['markmessages'] = 'マークを付ける';
$labels['markread'] = '既読にする';
$labels['markunread'] = '未読にする';
$labels['markflagged'] = 'フラグを付ける';
$labels['markunflagged'] = 'フラグを外す';
$labels['moreactions'] = 'その他の操作...';

$labels['select'] = '選択';
$labels['all'] = 'すべて';
$labels['none'] = 'なし';
$labels['currpage'] = '現在のページ';
$labels['unread'] = '未読';
$labels['flagged'] = 'フラグあり';
$labels['unanswered'] = '未返信';
$labels['deleted'] = '削除済み';
$labels['invert'] = '反転';
$labels['filter'] = 'フィルター';

$labels['list'] = '一覧';
$labels['threads'] = 'スレッド';
$labels['expand-all'] = 'すべて展開';
$labels['expand-unread'] = '未開封のメールを展開';
$labels['collapse-all'] = 'すべて折りたたむ';
$labels['threaded'] = 'スレッドにする';

$labels['autoexpand_threads'] = 'スレッドの展開';
$labels['do_expand'] = 'すべてのスレッド';
$labels['expand_only_unread'] = '未開封のメールのみ';
$labels['fromto'] = '送信者 / 宛先';
$labels['flag'] = 'フラグ';
$labels['attachment'] = '添付ファイル';
$labels['nonesort'] = 'なし';
$labels['sentdate'] = '送信日';
$labels['arrival'] = '受信日';
$labels['asc'] = '昇順';
$labels['desc'] = '降順';
$labels['listcolumns'] = '列の一覧';
$labels['listsorting'] = '整列基準';
$labels['listorder'] = '整列順';
$labels['listmode'] = '一覧表示モード';

$labels['folderactions'] = 'フォルダーの操作...';
$labels['compact'] = 'コンパクト';
$labels['empty'] = '空';

$labels['quota'] = 'ディスク使用量';
$labels['unknown'] = '不明';
$labels['unlimited'] = '無制限';

$labels['quicksearch'] = '検索';
$labels['resetsearch'] = '検索解除';
$labels['searchmod'] = '検索条件';
$labels['msgtext'] = 'すべてのメール';

$labels['openinextwin'] = '新しいウィンドウで開く';
$labels['emlsave'] = 'eml 形式で保存する';

// message compose
$labels['compose'] = 'メールの作成';
$labels['editasnew'] = '新規として編集';
$labels['savemessage'] = '下書きに保存';
$labels['sendmessage'] = '今すぐ送信';
$labels['addattachment'] = 'ファイルの添付';
$labels['charset'] = '文字エンコード';
$labels['editortype'] = 'エディターの種類';
$labels['returnreceipt'] = '開封確認';
$labels['dsn'] = '配送状況の通知';
$labels['mailreplyintro'] = '$date に $sender が書きました:';
$labels['originalmessage'] = '元のメッセージ';

$labels['editidents'] = '個人情報の編集';
$labels['checkspelling'] = 'スペル チェック';
$labels['resumeediting'] = 'メール作成に戻る';
$labels['revertto'] = '元に戻す';

$labels['attachments'] = '添付ファイル';
$labels['upload'] = 'アップロード';
$labels['uploadprogress'] = '$percent ($current / $total)';
$labels['close'] = '閉じる';
$labels['messageoptions'] = 'メッセージのオプション...';

$labels['low'] = '低い';
$labels['lowest'] = '最低';
$labels['normal'] = '通常';
$labels['high'] = '高い';
$labels['highest'] = '最高';

$labels['nosubject'] = '(件名なし)';
$labels['showimages'] = '画像の表示';
$labels['alwaysshow'] = '$sender から届いた画像は常に表示';

$labels['htmltoggle'] = 'HTML';
$labels['plaintoggle'] = 'テキスト';
$labels['savesentmessagein'] = '送信済みメールの保存先';
$labels['dontsave'] = '保存しない';
$labels['maxuploadsize'] = '添付可能なファイルのサイズは最大 $size です。';

$labels['addcc'] = 'Cc 追加';
$labels['addbcc'] = 'Bcc 追加';
$labels['addreplyto'] = 'Reply-To 追加';
$labels['addfollowupto'] = 'Followup-To 追加';

// mdn
$labels['mdnrequest'] = 'メールの差出人は開封確認の送付を求めています。開封確認のメールを送付しますか?';
$labels['receiptread'] = '開封確認 (表示済み)';
$labels['yourmessage'] = 'これはあなたが送信したメールに対する開封確認です。';
$labels['receiptnote'] = '注意: この開封確認はメールが受信者に表示されたことの通知です。受信者がメールを読んだこと、内容を理解したことを保証するものではありません。';

// address boook
$labels['name']         = '表示名';
$labels['firstname']    = '名 (ファーストネーム)';
$labels['surname']      = '姓 (ラストネーム)';
$labels['middlename']   = 'ミドルネーム';
$labels['nameprefix']   = '敬称 (名前の前)';
$labels['namesuffix']   = '敬称 (名前の後)';
$labels['nickname']     = 'ニックネーム';
$labels['jobtitle']     = '肩書き';
$labels['organization'] = '企業名';
$labels['department']   = '部署名';
$labels['gender']       = '性別';
$labels['maidenname']   = '旧姓';
$labels['email']        = 'メールアドレス';
$labels['phone']        = '電話番号';
$labels['address']      = '住所';
$labels['street']       = '通り';
$labels['locality']     = '都市';
$labels['zipcode']      = '郵便番号';
$labels['region']       = '州';
$labels['country']      = '国';
$labels['birthday']     = '誕生日';
$labels['anniversary']  = '記念日';
$labels['website']      = 'ウェブサイト';
$labels['instantmessenger'] = 'IM';
$labels['notes'] = 'メモ';
$labels['male']   = '男性';
$labels['female'] = '女性';
$labels['manager'] = '管理者';
$labels['assistant'] = 'アシスタント';
$labels['spouse'] = '配偶者';
$labels['allfields'] = '全項目';
$labels['search'] = '検索';
$labels['advsearch'] = '高度な検索';
$labels['other'] = 'その他';

$labels['typehome']   = '自宅';
$labels['typework']   = '職場';
$labels['typeother']  = '他';
$labels['typemobile']  = 'モバイル';
$labels['typemain']  = '主要回線';
$labels['typehomefax']  = '自宅 Fax';
$labels['typeworkfax']  = '職場 Fax';
$labels['typecar']  = '車';
$labels['typepager']  = 'ポケベル(ページャー)';
$labels['typevideo']  = 'ビデオ';
$labels['typeassistant']  = 'アシスタント';
$labels['typehomepage']  = 'ホームページ';
$labels['typeblog'] = 'ブログ';
$labels['typeprofile'] = 'プロフィール';

$labels['addfield'] = '項目の追加...';
$labels['addcontact'] = '連絡先の新規追加';
$labels['editcontact'] = '連絡先の編集';
$labels['contacts'] = '連絡先';
$labels['contactproperties'] = '連絡先のプロパティ';
$labels['personalinfo'] = '個人情報';

$labels['edit']   = '編集';
$labels['cancel'] = 'キャンセル';
$labels['save']   = '保存';
$labels['delete'] = '削除';
$labels['rename'] = '名前の変更';
$labels['addphoto'] = '追加';
$labels['replacephoto'] = '置換';

$labels['newcontact']     = '連絡先の新規作成';
$labels['deletecontact']  = '連絡先の削除';
$labels['composeto']      = 'この連絡先へメールの送信';
$labels['contactsfromto'] = '連絡先: $from ～ $to (全: $count 件)';
$labels['print']          = '印刷';
$labels['export']         = 'エクスポート';
$labels['exportvcards']   = 'vCard 形式でエクスポート';
$labels['newcontactgroup'] = '連絡先グループの新規作成';
$labels['grouprename']    = 'グループ名の変更';
$labels['groupdelete']    = 'グループの削除';

$labels['previouspage']   = '前のページへ';
$labels['firstpage']      = '最初のページへ';
$labels['nextpage']       = '次のページへ';
$labels['lastpage']       = '最後のページへ';

$labels['group'] = 'グループ';
$labels['groups'] = 'グループ';
$labels['personaladrbook'] = '個人アドレス';

$labels['searchsave'] = '検索情報の保存';
$labels['searchdelete'] = '検索情報の削除';

$labels['import'] = 'インポート';
$labels['importcontacts'] = '連絡先のインポート';
$labels['importfromfile'] = 'インポートするファイル:';
$labels['importtarget'] = 'アドレス帳へ新規連絡先の追加:';
$labels['importreplace'] = '現在のアドレス帳と置き換える';
$labels['importtext'] = '既存のアドレス帳の連絡先をアップロードできます。現在、<a href="http://ja.wikipedia.org/wiki/VCard">vCard</a> 形式からのインポートに対応しています。';
$labels['done'] = '完了';

// settings
$labels['settingsfor']  = '次の設定:';

$labels['preferences']  = '設定';
$labels['userpreferences']  = 'ユーザー設定';
$labels['editpreferences']  = 'ユーザー設定の変更';

$labels['identities']  = '個人情報';
$labels['manageidentities']  = 'アカウントの個人情報管理';
$labels['newidentity']  = '個人情報の新規作成';

$labels['newitem']  = '新しい項目';
$labels['edititem']  = '項目の編集';

$labels['preferhtml'] = 'HTML を表示する';
$labels['defaultcharset'] = '標準の文字セット';
$labels['htmlmessage'] = 'HTML メール';
$labels['dateformat'] = '日付の書式';
$labels['timeformat'] = '時間の書式';
$labels['prettydate'] = '短い日付で表示';
$labels['setdefault'] = '標準の設定';
$labels['autodetect'] = '自動識別';
$labels['language'] = '言語';
$labels['timezone'] = 'タイムゾーン';
$labels['pagesize'] = '1 ページの表示件数';
$labels['signature'] = '署名';
$labels['dstactive'] = 'サマータイムを適用する';
$labels['htmleditor'] = '新規メールでは HTML を標準にする';
$labels['htmlonreply'] = 'メールの返信時は常に HTML を使用する';
$labels['htmlsignature'] = '署名に HTML タグを使用する';
$labels['previewpane'] = 'プレビュー ペインを表示する';
$labels['skin'] = 'スキン';
$labels['logoutclear'] = 'ログアウト時にごみ箱を空にする';
$labels['logoutcompact'] = 'ログアウト時にフォルダーを整理する';
$labels['uisettings'] = 'ユーザー インターフェース';
$labels['serversettings'] = 'サーバーの設定';
$labels['mailboxview'] = '受信箱';
$labels['mdnrequests'] = '開封確認の送信要求時';
$labels['askuser'] = '開封確認メールの送信を確認する';
$labels['autosend'] = '開封確認メールを送信する';
$labels['autosendknown'] = '差出人が連絡先に登録されていれば開封確認を送信し、それ以外は問い合わせる';
$labels['autosendknownignore'] = '差出人が連絡先に登録されていれば開封確認を送信し、それ以外は無視する';
$labels['ignore'] = '無視';
$labels['readwhendeleted'] = '削除したメールを既読にする';
$labels['flagfordeletion'] = '実際に削除せずに削除済みフラグを付ける';
$labels['skipdeleted'] = '削除済みメールを表示しない';
$labels['deletealways'] = 'ごみ箱への移動に失敗したメールはすぐに削除';
$labels['showremoteimages'] = '外部 URL の画像をインライン表示する';
$labels['fromknownsenders'] = '送信者が知人の場合';
$labels['always'] = '常に';
$labels['showinlineimages'] = 'メールに添付された画像を表示する';
$labels['autosavedraft'] = '自動的に下書きを保存する';
$labels['everynminutes'] = '$n 分毎';
$labels['keepalive'] = '新着メールの確認間隔';
$labels['never'] = 'しない';
$labels['immediately'] = 'すぐに';
$labels['messagesdisplaying'] = 'メールの表示';
$labels['messagescomposition'] = 'メールの作成';
$labels['mimeparamfolding'] = '添付ファイル名';
$labels['2231folding'] = 'RFC 2231 準拠 (Thunderbird)';
$labels['miscfolding'] = 'RFC 2047/2231 (MS Outlook)';
$labels['2047folding'] = 'RFC 2047 準拠 (他のメーラー)';
$labels['force7bit'] = 'マルチバイト文字列を MIME エンコードする';
$labels['advancedoptions'] = '高度な設定';
$labels['focusonnewmessage'] = '新着メールが届いたらブラウザーをアクティブにする';
$labels['checkallfolders'] = '全フォルダーで新着メールを表示する';
$labels['displaynext'] = 'メールの削除や移動後に次のメールを表示する';
$labels['mainoptions'] = '基本設定';
$labels['section'] = '設定項目';
$labels['maintenance'] = 'メンテナンス設定';
$labels['newmessage'] = '新着メール設定';
$labels['listoptions'] = '一覧設定';
$labels['signatureoptions'] = '署名の設定';
$labels['whenreplying'] = '返信時の本文';
$labels['replytopposting'] = '元のメッセージ引用部の前に本文を作成する';
$labels['replybottomposting'] = '元のメッセージ引用部の後に本文を作成する';
$labels['replyremovesignature'] = '返信時にメッセージからオリジナルの署名を除去する';
$labels['autoaddsignature'] = '自動的に署名を付加する';
$labels['newmessageonly'] = '新規作成時のみ';
$labels['replyandforwardonly'] = '返信・転送時のみ';
$labels['replysignaturepos'] = '返信・転送時に署名を挿入する位置';
$labels['belowquote'] = '引用部の後';
$labels['abovequote'] = '引用部の前';
$labels['insertsignature'] = '署名の挿入';
$labels['previewpanemarkread'] = '開封済みにする';
$labels['afternseconds'] = '$n 秒後';
$labels['reqmdn'] = '常に開封確認通知を要求する';
$labels['reqdsn'] = '常に配送状況の通知を要求する';
$labels['replysamefolder'] = '返信されたメールを返信元メールと同じフォルダに保存';
$labels['defaultaddressbook'] = '次のアドレス帳に新規連絡先を追加する';
$labels['spellcheckbeforesend'] = 'メールの送信前にスペル チェック';
$labels['spellcheckoptions'] = 'スペルチェックのオプション';
$labels['spellcheckignoresyms'] = '記号の単語を無視する';
$labels['spellcheckignorenums'] = '数字の単語を無視する';
$labels['spellcheckignorecaps'] = 'すべて大文字の単語を無視する';
$labels['addtodict'] = '辞書に追加';

$labels['folder']  = 'フォルダー';
$labels['folders']  = 'フォルダー一覧';
$labels['foldername']  = 'フォルダー名';
$labels['subscribed']  = '購読済み';
$labels['messagecount'] = 'メール';
$labels['create']  = '作成';
$labels['createfolder']  = 'フォルダーの新規作成';
$labels['managefolders']  = 'フォルダーの管理';
$labels['specialfolders'] = '特殊なフォルダー';
$labels['properties'] = 'プロパティ';
$labels['folderproperties'] = 'フォルダーのプロパティ';
$labels['parentfolder'] = '親フォルダー';
$labels['location'] = '場所';
$labels['info'] = '情報';
$labels['getfoldersize'] = 'クリックでフォルダー サイズの取得';
$labels['changesubscription'] = 'クリックで購読の変更';
$labels['foldertype'] = 'フォルダーの種類';
$labels['personalfolder']  = '個人フォルダー';
$labels['otherfolder']  = '他のユーザーのフォルダー';
$labels['sharedfolder']  = '公開フォルダー';     

$labels['sortby'] = '並び替えの基準';
$labels['sortasc']  = '昇順で並び替え';
$labels['sortdesc'] = '降順で並び替え';
$labels['undo'] = '取り消し';

// units
$labels['B'] = 'バイト';
$labels['KB'] = 'KB';
$labels['MB'] = 'MB';
$labels['GB'] = 'GB';

// character sets
$labels['unicode'] = 'Unicode';
$labels['english'] = '英語';
$labels['westerneuropean'] = '西ヨーロッパ言語';
$labels['easterneuropean'] = '東ヨーロッパ言語';
$labels['southeasterneuropean'] = '南東ヨーロッパ言語';
$labels['baltic'] = 'バルト言語';
$labels['cyrillic'] = 'キリル言語';
$labels['arabic'] = 'アラビア語';
$labels['greek'] = 'ギリシャ語';
$labels['hebrew'] = 'ヘブライ語';
$labels['turkish'] = 'トルコ語';
$labels['nordic'] = '北欧言語';
$labels['thai'] = 'タイ語';
$labels['celtic'] = 'ケルト語';
$labels['vietnamese'] = 'ベトナム語';
$labels['japanese'] = '日本語';
$labels['korean'] = '韓国語';
$labels['chinese'] = '中国語';

?>
