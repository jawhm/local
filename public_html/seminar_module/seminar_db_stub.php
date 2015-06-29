<?php
/*
 * DBへのアクセスを禁止する場合に用いるスタブモジュール
 * すべてのメソッドは何もしない。
 */
class StubSeminarDb
{

	/**
	 * コンストラクタ
	 */
	function __construct()
	{
		//
	}

	/**
	 * メンバー情報の取得
	 * @param $mem_id
	 * @return array
	 */
	public function get_member_info($mem_id)
	{
            return array();
	}

	/**
	 * イベント情報1件を取得（日付特化バージョン）
	 * @param $id
	 * @return array
	 */
	public function get_event_info_for_hiduke($id)
	{
            return array();
	}

	/**
	 * イベント情報1件を取得
	 * @param $id
	 * @return array
	 */
	public function get_event_info($id)
	{
            return array();
	}

	/**
	 * イベントリストを取得
	 * @param $keyword
	 * @return array
	 */
	public function get_event_list($keyword)
	{
            return array();
	}

	/**
	 * リスト用イベントリストを取得
	 * @return array
	 */
	public function get_event_list_for_list()
	{
            return array();
	}

	/**
	 * 対象のイベントリストを取得
	 * @param $keyword
	 * @return array
	 */
	public function get_target_event_list_for_list($keyword)
	{
            return array();
	}

	/**
	 * 地域情報の取得
	 * @param $place
	 * @return mixed
	 */
	public function get_place_info($place)
	{
            return null;
	}

	/**
	 * 地域情報の取得（地方セミナー対応version）
	 * @param $place
	 * @return array
	 */
	public function get_place_info_for_use_area($place)
	{
            return array();
	}

	/**
	 * 同時開催チェック
	 * @param $id
	 * @return array
	 */
	public function get_douji_info($id)
	{
            return array();
	}

	/**
	 * connection
	 */
	private function _connection()
	{
            //
	}
}

