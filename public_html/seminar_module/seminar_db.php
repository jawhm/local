<?php

class SeminarDb
{
	// DB
	private $_db = "";

	/**
	 * コンストラクタ
	 */
	function __construct()
	{
		$this->_connection();
	}

	/**
	 * メンバー情報の取得
	 * @param $mem_id
	 * @return array
	 */
	public function get_member_info($mem_id)
	{
		try {
			$stt = $this->_db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
			$stt->bindValue(':id', $mem_id);
			$stt->execute();
			$member_info = $stt->fetch();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return $member_info;
	}

	/**
	 * イベント情報1件を取得（日付特化バージョン）
	 * @param $id
	 * @return array
	 */
	public function get_event_info_for_hiduke($id)
	{
		try {
			$stt = $this->_db->prepare('SELECT place, year(hiduke) as yyy, month(hiduke) as mmm, day(hiduke) as ddd FROM event_list WHERE id = :id ');
			$stt->bindValue(':id', $id);
			$stt->execute();
			$event_info = $stt->fetch();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return $event_info;
	}

	/**
	 * イベント情報1件を取得
	 * @param $id
	 * @return array
	 */
	public function get_event_info($id)
	{
		try {
			$stt = $this->_db->prepare('SELECT place, year(hiduke) as yyy, month(hiduke) as mmm, day(hiduke) as ddd FROM event_list WHERE id = :id ');
			$stt->bindValue(':id', $id);
			$stt->execute();
			$event_info = $stt->fetch();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return $event_info;
	}

	/**
	 * イベントリストを取得
	 * @param $keyword
	 * @return array
	 */
	public function get_event_list($keyword)
	{
		$event_list = array();
		$stt = $this->_db->query("SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, '%c月%e日 (%a) %k:%i') as start, date_format(starttime, '%k:%i') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking, group_color, broadcasting, indicated_option, country_code, short_description, seminar_name FROM event_list WHERE  k_use = 1 " . $keyword . " ORDER BY hiduke, starttime, id");
		$stt->execute();
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$event_list[] = $row;
		}
		return $event_list;
	}

	/**
	 * リスト用イベントリストを取得
	 * @return array
	 */
	public function get_event_list_for_list()
	{
		$event_list = array();
		$stt = $this->_db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) ORDER BY hiduke, starttime, id');
		$stt->execute();
		while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
			$event_list[] = $row;
		}
		return $event_list;
	}

	/**
	 * 対象のイベントリストを取得
	 * @param $keyword
	 * @return array
	 */
	public function get_target_event_list_for_list($keyword)
	{
		$event_list = array();
		$stt = $this->_db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking FROM event_list WHERE k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');
		$stt->execute();
		while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
			$event_list[] = $row;
		}
		return $event_list;
	}

	/**
	 * 地域情報の取得
	 * @param $place
	 * @return mixed
	 */
	public function get_place_info($place)
	{
		try {
			$stt = $this->_db->prepare('SELECT * FROM place WHERE place = :place ');
			$stt->bindValue(':place', $place);
			$stt->execute();
			$place_info = $stt->fetch();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return $place_info;
	}

	/**
	 * 地域情報の取得（地方セミナー対応version）
	 * @param $place
	 * @return array
	 */
	public function get_place_info_for_use_area($place)
	{
		try {
			$stt = $this->_db->prepare('SELECT * FROM place WHERE area = :place ');
			$stt->bindValue(':place', $place);
			$stt->execute();
			$place_list = array();
			while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
				$place_list[] = $row;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return $place_list;
	}

	/**
	 * 同時開催チェック
	 * @param $id
	 * @return array
	 */
	public function get_douji_info($id)
	{
		$stt = $this->_db->prepare('SELECT * FROM event_list WHERE id = :id');
		$stt->bindValue(':id', $id);
		$stt->execute();
		$seminar_info = $stt->fetch();

		$stt = $this->_db->prepare('select *,date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start from event_list where hiduke = :hiduke and starttime = :starttime and k_title1 = :k_title1 order by id');
		$stt->bindValue(':hiduke',    $seminar_info['hiduke']);
		$stt->bindValue(':starttime', $seminar_info['starttime']);
		$stt->bindValue(':k_title1',  $seminar_info['k_title1']);
		$stt->execute();
		$event_list = array();
		while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
			$event_list[] = $row;
		}
		return $event_list;
	}

	/**
	 * connection
	 */
	private function _connection()
	{
		try {
			$ini = array();
			$parse_file_path = './bin/pdo_mail_list.ini';
			if (is_file($parse_file_path)) {
				$ini = parse_ini_file($parse_file_path, FALSE);
			}
			if (empty($ini)) {
				$parse_file_path = '../' . $parse_file_path;
				if (is_file($parse_file_path)) {
					$ini = parse_ini_file($parse_file_path, FALSE);
				}
			}
			if (empty($ini)) {
				$parse_file_path = '../' . $parse_file_path;
				if (is_file($parse_file_path)) {
					$ini = parse_ini_file($parse_file_path, FALSE);
				}
			}
			if (empty($ini)) {
				$parse_file_path = '../' . $parse_file_path;
				if (is_file($parse_file_path)) {
					$ini = parse_ini_file($parse_file_path, FALSE);
				}
			}
			if (empty($ini)) {
				die('Cannot fild ini files.');
			}
			//$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$this->_db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->_db->query('SET CHARACTER SET utf8');
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

