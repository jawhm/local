<?php

class Lang extends DefaultLang
{
	var $js = array
	(
		'actionNote' => "メモ",
		'actionEdit' => "編集",
		'actionDelete' => "削除",
		'taskDate' => array("function(date) { return '作成 '+date; }"),
		'confirmDelete' => "本当に削除しますか？",
		'actionNoteSave' => "保存",
		'actionNoteCancel' => "キャンセル",
		'error' => "エラーが発生しました",
		'denied' => "アクセスが拒否されました",
		'invalidpass' => "パスワードが違います",
		'readonly' => "閲覧のみ",
	);

	var $inc = array
	(
		'tab_newtask' => "タスク追加",
		'tab_search' => "検索",
		'btn_add' => "追加",
		'btn_search' => "検索",
		'searching' => "検索:",
		'tasks' => "タスク",
		'show_completed' => "完了タスクを表示",
		'hide_completed' => "完了タスクを隠す",
		'return_view' => "タスク一覧へ戻る",
		'edit_task' => "タスク編集",
		'priority' => "優先度",
		'task' => "タスク",
		'note' => "メモ",
		'save' => "保存",
		'cancel' => "キャンセル",
		'password' => "パスワード",
		'btn_login' => "ログイン",
		'a_login' => "ログイン",
		'a_logout' => "ログアウト",
		'tags' => "タグ",
		'tagfilter' => "タグ:",
		'tagfilter_cancel' => "キャンセル",
	);
}

?>