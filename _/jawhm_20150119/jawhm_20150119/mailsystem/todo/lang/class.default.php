<?php

/*
	myTinyTodo default language class
*/

class DefaultLang
{
	protected static $instance;
	protected $rtl = 0;

	private $default_js = array
	(
		'confirmDelete' => "Are you sure you want to delete the task?",
		'confirmLeave' => "There can be unsaved data. Do you really want to leave?",
		'actionNoteSave' => "save",
		'actionNoteCancel' => "cancel",
		'error' => "Some error occurred (click for details)",
		'denied' => "Access denied",
		'invalidpass' => "Wrong password",
		'tagfilter' => "　　タグ :",
		'addList' => "新しいリストを作る",
		'addListDefault' => "Todo",
		'renameList' => "名前を変更",
		'deleteList' => "選択中のリストを削除します。\\nよろしいですか？",
		'clearCompleted' => "全ての完了タスクを削除します。\\nよろしいですか？",
		'settingsSaved' => "Settings saved. Reloading...",
	);

	private $default_inc = array
	(
		'My Tiny Todolist' => "My Tiny Todolist",
		'htab_newtask' => "新しいタスク",
		'htab_search' => "Search",
		'btn_add' => "Add",
		'btn_search' => "Search",
		'advanced_add' => "Advanced",
		'searching' => "Searching for",
		'tasks' => "Tasks",
		'taskdate_inline_created' => "作成日 :  %s",
		'taskdate_inline_completed' => "完了日 : %s",
		'taskdate_inline_duedate' => "期限 : %s",
		'taskdate_created' => "作成しました",
		'taskdate_completed' => "",
		'go_back' => "&lt;&lt; 一覧に戻る",
		'edit_task' => "Edit Task",
		'add_task' => "新しいタスク",
		'priority' => "Priority",
		'task' => "Task",
		'note' => "Note",
		'tags' => "タグ",
		'save' => "Save",
		'cancel' => "Cancel",
		'password' => "Password",
		'btn_login' => "Login",
		'a_login' => "Login",
		'a_logout' => "Logout",
		'public_tasks' => "Public Tasks",
		'tagcloud' => "タグ",
		'tagfilter_cancel' => "cancel filter",
		'sortByHand' => "Sort by hand",
		'sortByPriority' => "並べ替え（優先度）",
		'sortByDueDate' => "並べ替え（期限）",
		'sortByDateCreated' => "並べ替え（作成日）",
		'sortByDateModified' => "並べ替え（更新日）",
		'due' => "期限",
		'daysago' => "%d 日前に終わってなきゃいけないはず...",
		'indays' => "期限まで あと %d 日",
		'months_short' => array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"),
		'months_long' => array("January","February","March","April","May","June","July","August","September","October","November","December"),
		'days_min' => array("Su","Mo","Tu","We","Th","Fr","Sa"),
		'days_long' => array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"),
		'today' => "今日が期限！！がんばれ！！",
		'yesterday' => "昨日が期限... 本当はもう終わってるよね！？",
		'tomorrow' => "明日が期限！！準備はＯＫ？",
		'f_past' => "期限が過ぎているタスク",
		'f_today' => "今日・明日が期限のタスク",
		'f_soon' => "期限が近いタスク",
		'action_edit' => "タスクを修正",
		'action_note' => "メモを修正",
		'action_delete' => "このタスクを削除",
		'action_priority' => "優先度",
		'action_move' => "別リストに移動",
		'notes' => "　　メモ :",
		'notes_show' => "表示",
		'notes_hide' => "隠す",
		'list_new' => "New list",
		'list_rename' => "リストの名前を変更",
		'list_delete' => "リストを削除（だめだめ！！絶対やっちゃだめ！！）",
		'list_publish' => "Publish list",
		'list_showcompleted' => "完了タスクを表示する",
		'list_clearcompleted' => "完了タスクを削除する",
		'list_select' => "Select list",
		'list_export' => "Export",
		'list_export_csv' => "CSV",
		'list_export_ical' => "iCalendar",		
		'list_rssfeed' => "RSS Feed",
		'alltags' => "全てのタグ:",
		'alltags_show' => "全てのタグを表示",
		'alltags_hide' => "全てのタグを隠す",
		'a_settings' => "Settings",
		'rss_feed' => "RSS Feed",
		'feed_title' => "%s",
		'feed_completed_tasks' => "Completed tasks",
		'feed_modified_tasks' => "Modified tasks",
		'feed_new_tasks' => "New tasks",
		'alltasks' => "全てのタスク",

		/* Settings */
		'set_header' => "Settings",
		'set_title' => "Title",
		'set_title_descr' => "(specify if you want to change default title)",
		'set_language' => "Language",
		'set_protection' => "Password protection",
		'set_enabled' => "Enabled",
		'set_disabled' => "Disabled",
		'set_newpass' => "New password",
		'set_newpass_descr' => "(leave blank if won't change current password)",
		'set_smartsyntax' => "Smart syntax",
		'set_smartsyntax_descr' => "(/priority/ task /tags/)",
		'set_timezone' => "Time zone",
		'set_autotag' => "Autotagging",
		'set_autotag_descr' => "(automatically adds tag of current tag filter to newly created task)",
		'set_sessions' => "Session handling mechanism",
		'set_sessions_php' => "PHP",
		'set_sessions_files' => "Files",
		'set_firstdayofweek' => "First day of week",
		'set_custom' => "Custom",
		'set_date' => "Date format",
		'set_date2' => "Short Date format",
		'set_shortdate' => "Short Date (current year)",
		'set_clock' => "Clock format",
		'set_12hour' => "12-hour",
		'set_24hour' => "24-hour",
		'set_submit' => "Submit changes",
		'set_cancel' => "Cancel",
		'set_showdate' => "Show task date in list",
	);

	var $js = array();
	var $inc = array();

	function makeJS()
	{
		$a = array();
		foreach($this->default_js as $k=>$v)
		{
			if(isset($this->js[$k])) $v = $this->js[$k];

			if(is_array($v)) {
				$a[] = "$k: ". $v[0];
			} else {
				$a[] = "$k: \"". str_replace('"','\\"',$v). "\"";
			}
		}
		$t = array();
		foreach($this->get('days_min') as $v) { $t[] = '"'.str_replace('"','\\"',$v).'"'; }
		$a[] = "daysMin: [". implode(',', $t). "]";
		$t = array();
		foreach($this->get('days_long') as $v) { $t[] = '"'.str_replace('"','\\"',$v).'"'; }
		$a[] = "daysLong: [". implode(',', $t). "]";
		$t = array();
		foreach($this->get('months_long') as $v) { $t[] = '"'.str_replace('"','\\"',$v).'"'; }
		$a[] = "monthsLong: [". implode(',', $t). "]";
		$a[] = $this->_2js('tags');
		$a[] = $this->_2js('tasks');
		$a[] = $this->_2js('f_past');
		$a[] = $this->_2js('f_today');
		$a[] = $this->_2js('f_soon');
		return "{\n". implode(",\n", $a). "\n}";
	}

	function _2js($v)
	{
		return "$v: \"". str_replace('"','\\"',$this->get($v)). "\"";
	}

	function get($key)
	{
		if(isset($this->inc[$key])) return $this->inc[$key];
		if(isset($this->default_inc[$key])) return $this->default_inc[$key];
		return $key;
	}

	function rtl()
	{
		return $this->rtl ? 1 : 0;
	}

	public static function instance()
	{
        if (!isset(self::$instance)) {
			//$c = __CLASS__;
			$c = 'Lang';
			self::$instance = new $c;
        }
		return self::$instance;	
	}
}

?>