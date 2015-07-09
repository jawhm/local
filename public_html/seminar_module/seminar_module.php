<?php
@session_start();
header('Access-Control-Allow-Origin:http://'.$_GET['acao']);
header('Access-Control-Allow-Credentials:true');
date_default_timezone_set('Asia/Tokyo');

require_once "seminar_db.php";
require_once "seminar_assets.php";
require_once "seminar_assets_list.php";
require_once "seminar_where.php";
require_once "seminar_event_list.php";
require_once "functions.php";
require_once "jp-holiday.php";
require_once "seminar_db_stub.php";

function require_once_func($name) {
	for ($r_o = 0; $r_o < 10; $r_o++) {
		$dots = str_repeat('../', $r_o);
		$path = $dots . $name;
		if (is_file($path)) {
			require_once $path;
			break;
		}
	}
}

require_once_func('./calendar_module/ip2locationlite.class.php');
require_once_func('./mailsystem/calender_off.php');
require_once_func('./include/header.php');

class SeminarModule
{
	/*
	private $_countries = array(
		'1' => array('id' => 'all',   'name' => '全て',				'value' => 'all'),
		'2' => array('id' => 'aus',   'name' => 'オーストラリア',		'value' => 'aus'),
		'3' => array('id' => 'nz',    'name' => 'ニュージーランド',	'value' => 'nz'),
		'4' => array('id' => 'can',   'name' => 'カナダ',				'value' => 'can'),
		'5' => array('id' => 'uk',    'name' => 'イギリス',			'value' => 'uk'),
		'6' => array('id' => 'fra',   'name' => 'フランス',			'value' => 'fra'),
		'7' => array('id' => 'other', 'name' => 'その他の国',			'value' => 'other'),
	);
	private $_knows = array(
		'1' => array('id' => 'all',   'name' => '全て',					'value' => 'all'),
		'2' => array('id' => 'first', 'name' => '初心者向け',				'value' => 'first'),
		'3' => array('id' => 'sanpo', 'name' => '人数限定！懇談セミナー',	'value' => 'foot'),
		'4' => array('id' => 'sc',    'name' => 'もっと詳しく情報収集',		'value' => 'kuwashiku'),
		'5' => array('id' => 'ga',    'name' => '語学学校セミナー',		'value' => 'school'),
		'6' => array('id' => 'si',    'name' => '注目！！人気のセミナー',	'value' => 'chumoku'),
		'7' => array('id' => 'kouen', 'name' => '講演セミナー',			'value' => 'kouen'),
	);
	*/

	private $_config = array(
                'use_mode' => '',
                'dummy_mode' => 'off',
		'view_mode' => 'calendar',
		'seminar_id' => array(), // array('6938')
		'start_date' => '',
		'end_date' => '',
		'calendar' => array(

			'title' => '',		// text or array (and)
			'title2' => '',		// text or array (or)

			'keyword' => '',	// text or array (and)
			'keyword2' => '',	// text or array (or)

			'use_area' => '', // 地方セミナー対応
			'place_active' => 'active',
			'place_list' => array('tokyo', 'osaka', 'nagoya', 'fukuoka', 'okinawa', 'kyoto', 'omiya'),
			'place_default' => '',

			'country_active' => 'active',
			// 'country_list' => array(1, 2, 3, 4, 5, 6, 7),
			'country_list' => array(
				array(
					'id' => 'all',
					'name' => '全て', // button name
					'word1' => array(), // k_title1, k_title2, k_desc2
					'word2' => array(), // k_desc2
					'option' => 'single', // single or multiple
					'active' => 'on', // on or off
					'default' => 'on', // on or off
				),
				array(
					'id' => 'aus',
					'name' => 'オーストラリア',
					'word1' => array('オーストラリア'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'nz',
					'name' => 'ニュージーランド',
					'word1' => array('ニュージーランド'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'can',
					'name' => 'カナダ',
					'word1' => array('カナダ'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'uk',
					'name' => 'イギリス',
					'word1' => array('イギリス'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'fra',
					'name' => 'フランス',
					'word1' => array('フランス'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'other',
					'name' => 'その他の国',
					'word1' => array(),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
			),

			//'country_default' => array(1),

			'know_active' => 'active',
			//'know_list' => array(1, 2, 3, 4, 5, 6, 7),
			'know_list' => array(
				array(
					'id' => 'all',
					'name' => '全て',
					'word1' => array(),
					'word2' => array(),
					'option' => 'single',
					'active' => 'on',
					'default' => 'on',
				),
				array(
					'id' => 'first',
					'name' => '初心者向け',
					'word1' => array('初心者'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'sanpo',
					'name' => '人数限定！懇談セミナー',
					'word1' => array('懇談'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'sc',
					'name' => 'もっと詳しく情報収集',
					'word1' => array('比較', '限定', '資格', '就職', 'セカンド', '有効的', 'ナース'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'ga',
					'name' => '語学学校セミナー',
					'word1' => array('語学学校'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'si',
					'name' => '注目！！人気のセミナー',
					'word1' => array('注目', '人気'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
				array(
					'id' => 'kouen',
					'name' => '講演セミナー',
					'word1' => array('講演'),
					'word2' => array(),
					'option' => 'multiple',
					'active' => 'on',
					'default' => 'off',
				),
			),
			//'know_default' => array(1),

			'calendar_icon_active' => 'active',
			'count_field_active' => 'active',
			'calendar_title_active' => 'active',
			'calendar_desc_active' => 'active',
			'footer_desc_active' => 'active',
		),
		'list' => array(
			'past_view' => '',

			'use_area' => '', // 地方セミナー対応
			'place_default' => 'tokyo',
			'member_only' => 'false',

			'title' => '',		// text or array (and)
			'title2' => '',		// text or array (and)

			'keyword' => '',	// text or array (and)
			'keyword2' => '',	// text or array (and)

			'count_field_active' => 'active',

			'window_width' => '',
			'forecolor' => '',
			'backcolor' => '',
			'detail_open' => 'off',

			'multi_use' => 'off',
		),
	);

	private $_mobileredirect = "";
	private $_num = "";
	private $_navigation = "";
	private $_db;
	private $_mem_info;
	private $_selected_event_info;
	private $_place_name;
	private $_add_popup_js = "";
	private $_add_js = "";
	private $_add_css = "";
	private $_add_style = "";
	private $_year;
	private $_month;
	private $_cookies;
	private $_selected_day = 0;
	private $_calendar = array();
	private $_calendar_msgs = array();
	private $_keyword;
	private $_checked_countryname = 0;
	private $_checked_know = 0;
	private $_event_count = 0;
	private $_douji_info = array();
	private $_header_obj;
	private $_is_list_view = true;
        
        //js css style yoyaku_formの記述がページでユニークであることを保証するための静的変数。中身はURL
        private static $_last_js_view;
        private static $_last_css_view;
        private static $_last_style_view;
        private static $_last_form_view;

	/**
	 * コンストラクタ
	 * @param $config
	 */
	function __construct($config = array())
	{
		if (is_array($config)) {
			foreach ($this->_config as $t1_key => $t1_val) {
				if ($t1_key == 'seminar_id') {
					if (isset($config['seminar_id']) && !is_array($config['seminar_id']) && strlen($config['seminar_id']) > 0) {
						$this->_config[$t1_key] = array($config['seminar_id']);
					} elseif (isset($config['seminar_id']) && is_array($config['seminar_id']) && count($config['seminar_id']) > 0) {
						$this->_config[$t1_key] = $config['seminar_id'];
					}
				} elseif (is_array($t1_val)) {
					foreach ($t1_val as $t2_key => $t2_val) {
						if ($t1_key == 'calendar' && ($t2_key == 'country_list' || $t2_key == 'know_list')) {
							$this->_config[$t1_key][$t2_key] = $this->_set_multiple_list($this->_config[$t1_key][$t2_key], $config[$t1_key][$t2_key]);
						} else {
							if (isset($config[$t1_key][$t2_key])) {
								$this->_config[$t1_key][$t2_key] = $config[$t1_key][$t2_key];
							}
						}
					}
				} else {
					if (isset($config[$t1_key])) {
						$this->_config[$t1_key] = $config[$t1_key];
					}
				}
			}
		}

		$tmp_config = array();
		if ($_SESSION['seminar_config']) {
			$tmp_config = unserialize(base64_decode($_SESSION['seminar_config']));
		} elseif (isset($_COOKIE['seminar_config'])) {
			$tmp_config = unserialize(base64_decode($_COOKIE['seminar_config']));
		}
		$tmp_config[$_SERVER['SCRIPT_NAME']] = $this->_config;
		$data_cookie = base64_encode(serialize($tmp_config));
		setcookie("seminar_config", $data_cookie, time()+3600*24*30, "/");
		$_SESSION['seminar_config'] = $data_cookie;
		$this->_init();
	}

	/**
	 * 興味のある国とセミナー内容をマージする
	 * @param $module_config
	 * @param $user_config
	 * @return array
	 */
	private function _set_multiple_list($module_config, $user_config)
	{
		if (empty($user_config)) return $module_config;
		$ret_list = array();
		$tmp_keys = array();
		$is_user_default = false;
		foreach ($user_config as $one) {
			if (empty($one['id'])) continue;
			$tmp_keys[] = $one['id'];
			if (@$one['active'] == 'off') continue;
			foreach ($module_config as $mc) {
				if ($mc['id'] == $one['id']) {
					foreach ($mc as $mc_key => $mc_val) {
						if (empty($one[$mc_key])) {
							$one[$mc_key] = $mc_val;
						}
					}
					break;
				}
			}
			if (empty($one['name']))    $one['name']    = $one['id'];
			if (empty($one['word1']))   $one['word1']   = array();
			if (empty($one['word2']))   $one['word2']   = array();
			if (empty($one['default'])) $one['default'] = 'off';
			if (empty($one['option']))  $one['option']  = 'multiple';
			if (empty($one['active']))  $one['active']  = 'on';
			if ($one['default'] == 'on') $is_user_default = true;
			$ret_list[] = $one;
		}
		foreach ($module_config as $one) {
			if (in_array($one['id'], $tmp_keys)) continue;
			if ($is_user_default) $one['default'] = 'off';
			$ret_list[] = $one;
		}
		return $ret_list;
	}

	/**
	 * 初期化処理
	 */
	private function _init()
	{
		$this->_header_obj = new Header();
		$this->_parameter_escape();
		$this->_num = @$_GET['num'];
		if (empty($this->_num) && !empty($this->_config['seminar_id']) && !empty($this->_config['seminar_id'][0])) {
			$this->_num = $this->_config['seminar_id'][0];
		}
		$this->_navigation = @$_GET['navigation'];
                
                //ダミーモード切り替え：データベースへのアクセスを禁止
                if($this->_config['dummy_mode'] == 'on'){
                    $this->_db = new StubSeminarDb();
                }else{
                    $this->_db = new SeminarDb();
                }
                
		$this->_mem_info = $this->_db->get_member_info(@$_SESSION['mem_id']);

		// 同時開催チェック
		$this->_douji_info = $this->_checkdouji();

		// イベントかどうかをチェックして、イベントの場合、リダイレクト
		$this->_check_event();
		if ($this->_config['view_mode'] == 'calendar') {

			$this->_add_js    = get_seminar_js($this->_add_popup_js);

			// 同時開催チェックの時は、popupを表示する
			if (!empty($this->_douji_info)) {
				$this->_add_js .= get_douji_popup_js();
			}

			$this->_add_css   = get_seminar_css();
			$this->_add_style = get_seminar_style();

			if (isset($_GET['navigation'])) {
				$this->_year  = @$_GET['year'];
				$this->_month = @$_GET['month'];
			} elseif (empty($_GET['num'])) {
				$this->_year  = date('Y');
				$this->_month = date('n');
				if (!empty($this->_config['start_date'])) {
					$date_list = explode('-', $this->_config['start_date']);
					if (count($date_list) == 3) {
						$this->_year  = $date_list[0];
						$this->_month = $date_list[1];
					}
				}
			}

			if (isset($_COOKIE['seminar_choice']) && empty($_GET['num'])) {
				$this->_cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
			}
			// place_nameの設定
			$this->_set_place_name();
			// パラメータに応じたセミナーリストを取得
			$this->_get_seminar_list();

		} elseif ($this->_config['view_mode'] == 'list') {

			if ($this->_config['list']['multi_use'] == 'on')	{
				$this->_add_js    = '';
			}else{
				$this->_add_js    = list_get_seminar_js();
			}

			$this->_add_css   = list_get_seminar_css();
			$this->_add_style = list_get_seminar_style();

			// 同時開催チェックの時は、popupを表示する
			if (!empty($this->_douji_info)) {
				$this->_add_js .= get_douji_popup_js();
			}

			// イベントリストを取得
			$this->_get_event_list();

		} // view_mode list end

	}

	/**
	 * パラメータに応じたセミナーリストを取得
	 */
	private function _get_seminar_list()
	{
		//$where_place = '(place = \'tokyo\' or k_desc2 like \'%tokyo%\') ';
		$where_place = $this->_get_where_place('tokyo');
		if (!empty($this->_place_name)) {
			$where_place = $this->_get_where_place($this->_place_name);
			//$where_place = '(place = \'' . $this->_place_name . '\' or k_desc2 like \'%' . $this->_place_name .'%\') ';
		}
		/*
		if (!empty($this->_config['calendar']['country_default']) && is_array($this->_config['calendar']['country_default'])) {
			$this->_checked_countryname = implode(',', $this->_config['calendar']['country_default']);
		}
		if (!empty($this->_config['calendar']['know_default']) && is_array($this->_config['calendar']['know_default'])) {
			$this->_checked_know = implode(',', $this->_config['calendar']['know_default']);
		}
		*/
		$index = 0;
		$country_defaults = array();
		foreach ($this->_config['calendar']['country_list'] as $one) {
			if ($one['default'] == 'on') {
				$country_defaults[] = $index;
			}
			$index++;
		}
		$this->_checked_countryname = implode(',', $country_defaults);

		$index = 0;
		$know_defaults = array();
		foreach ($this->_config['calendar']['know_list'] as $one) {
			if ($one['default'] == 'on') {
				$know_defaults[] = $index;
			}
			$index++;
		}
		$this->_checked_know = implode(',', $know_defaults);

		//$yy = date('Y');
		//$mm = date('n');

		if (isset($_GET['checked_countryname']))
		{
			$this->_checked_countryname = secure($_GET['checked_countryname']);
			$this->_checked_know = secure($_GET['checked_know']);
		}

		if (isset($this->_cookies) && $this->_cookies['place_name'] == $this->_place_name) {
			$where_place = $this->_get_where_place($this->_cookies['place_name']);
		}

		// USE ID/NUM DATE when we come from calendar module or banner id
		if (!empty($this->_num)) {
			$where_place = $this->_get_where_place($this->_selected_event_info['place']);
		}

		$where_country = ' ( 1=0';
		$where_know = ' ( 1=0';

		if (isset($_POST['place-name'])) {
			$this->_selected_day = $_POST['selected_day'];
			$this->_checked_countryname = $this->_checked_know = "";

			$num = 0;
			foreach ($_POST as $key => $val) {
				if (isset($_POST['country-' . $num])) {
					$this->_checked_countryname .= ',' . $num;
				}

				if (!empty($_POST['know-' . $num])) {
					$this->_checked_know .= ',' . $num;
				}
				$num++;

				if (mb_substr($key, 0, 5) == 'place') {
					$where_place = $this->_get_where_place($val);
				}

				if (mb_substr($key, 0, 7) == 'country') {
					//$where_country .= where_country($val);
					$where_country .= where_multiple($this->_config['calendar']['country_list'], $val);
				}

				if (mb_substr($key, 0, 4) == 'know') {
					//$where_know .= where_know($val);
					$where_know .= where_multiple($this->_config['calendar']['know_list'], $val);
				}
			}
			//$yy = $_POST['year_date'];
			//$mm = $_POST['month_date'];
		} else {
			//$where_country .= where_country($this->_checked_countryname);
			//$where_know    .= where_know($this->_checked_know);
			$where_country .= where_multiple($this->_config['calendar']['country_list'], $this->_checked_countryname);
			$where_know    .= where_multiple($this->_config['calendar']['know_list'], $this->_checked_know);
		}

		if (isset($this->_cookies)) {
			$number_of_days_forward = 30;
			$cookie_date_days_added = date('Y-n-j', mktime(0, 0, 0, date('n'), (date('j')+$number_of_days_forward), date('Y')));
			//if use cookie at first
			if(empty($_POST['place-name']) && empty($_GET['navigation']))
			{
				//keep the same data for cookie when use cookie to display
				$array_cookie = array (
					'place_name' 			=>  $this->_cookies['place_name'],
					'checked_countryname' 	=>  $this->_cookies['checked_countryname'],
					'checked_know'			=>  $this->_cookies['checked_know'],
					'date'					=>  $cookie_date_days_added
				);
				//$this->_place_name = $this->_cookies['place_name'];
			} else {
				//set new data for cookie
				$array_cookie = array (
					'place_name' 			=> $this->_place_name,
					'checked_countryname' 	=> $this->_checked_countryname,
					'checked_know'			=> $this->_checked_know,
					'date'					=> $cookie_date_days_added
				);
			}
			$data_cookie = base64_encode(serialize($array_cookie));
			setcookie("seminar_choice", $data_cookie, time()+3600*24*30, "/"); //set cookie for 30 hours
		} else {
			$array_cookie = array (
				'place_name' 			=> $this->_place_name,
				'checked_countryname' 	=> $this->_checked_countryname,
				'checked_know'			=> $this->_checked_know,
				'date'					=> date('Y-n-j')
			);
			$data_cookie = base64_encode(serialize($array_cookie));
			setcookie("seminar_choice", $data_cookie, time()+60*60*24*30, "/"); //set cookie for 30 jours
			$this->_cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
		}

		if (isset($_GET['navigation'])) {
			$this->_selected_day = secure($_GET['day']);
			$where_place = $this->_get_where_place($this->_place_name);
		}
		$where_know .= ' ) ';
		$where_country .= ' ) ';

		$this->_keyword = "";

		if ($where_place != '') {
			$this->_keyword .= ' and ' . $where_place;
		}
		if ($where_country != ' ( 1=0 ) ') {
			$this->_keyword .= ' and ' . $where_country;
		}
		if ($where_know != ' ( 1=0 ) ') {
			$this->_keyword .= ' and ' . $where_know;
		}

		if (!empty($this->_config['calendar']['title'])) {
			if (is_array($this->_config['calendar']['title']))	{
				foreach($this->_config['calendar']['title'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' and (k_title1 like \'%' . $val . '%\' or k_title2 like \'%' . $val . '%\' or k_desc1 like \'%' . $val . '%\' or k_desc2 like \'%' . $val . '%\')';
					}
				}
			}else{
				$this->_keyword .= ' and (k_title1 like \'%' . $this->_config['calendar']['title'] . '%\' or k_title2 like \'%' . $this->_config['calendar']['title'] . '%\' or k_desc1 like \'%' . $this->_config['calendar']['title'] . '%\' or k_desc2 like \'%' . $this->_config['calendar']['title'] . '%\')';
			}
		}
		if (!empty($this->_config['calendar']['title2'])) {
			if (is_array($this->_config['calendar']['title2']))	{
				$this->_keyword .= ' and ( 1 = 0 ';
				foreach($this->_config['calendar']['title2'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' or (k_title1 like \'%' . $val . '%\' or k_title2 like \'%' . $val . '%\' or k_desc1 like \'%' . $val . '%\' or k_desc2 like \'%' . $val . '%\')';
					}
				}
				$this->_keyword .= ' ) ';
			}else{
				$this->_keyword .= ' and (k_title1 like \'%' . $this->_config['calendar']['title2'] . '%\' or k_title2 like \'%' . $this->_config['calendar']['title2'] . '%\' or k_desc1 like \'%' . $this->_config['calendar']['title2'] . '%\' or k_desc2 like \'%' . $this->_config['calendar']['title2'] . '%\')';
			}
		}
		if (!empty($this->_config['calendar']['keyword'])) {
			if (is_array($this->_config['calendar']['keyword']))	{
				foreach($this->_config['calendar']['keyword'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' and (k_desc2 like \'%' . $val . '%\')';
					}
				}
			}else{
				$this->_keyword .= ' and (k_desc2 like \'%' . $this->_config['calendar']['keyword'] . '%\')';
			}
		}
		if (!empty($this->_config['calendar']['keyword2'])) {
			if (is_array($this->_config['calendar']['keyword2']))	{
				$this->_keyword .= 'and ( 1 = 0 ';
				foreach($this->_config['calendar']['keyword2'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' or (k_desc2 like \'%' . $val . '%\')';
					}
				}
				$this->_keyword .= ' ) ';
			}else{
				$this->_keyword .= ' and (k_desc2 like \'%' . $this->_config['calendar']['keyword'] . '%\')';
			}
		}

		if (!empty($this->_config['start_date'])) {
			$this->_keyword .= ' and \'' . $this->_config['start_date'] . '\' <= hiduke ';
		}
		if (!empty($this->_config['end_date'])) {
			$this->_keyword .= ' and hiduke <= \'' . $this->_config['end_date'] . '\' ';
		}

		$list = $this->_db->get_event_list($this->_keyword);

		$cnt = 0;
		foreach ($list as $row) {
			$cnt++;

			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$flag = '';
			if (!empty($row['country_code'])) {
				$flag = '<span class="flag_information flag_' . strtolower($row['country_code']) . '" ></span>';
			}
			$color = 'grey';
			if (!empty($row['group_color'])) {
				$color = strtolower($row['group_color']);
			}
			$icon_live = '_broadcast';
			if ($row['broadcasting'] == 0) {
				$icon_live = '_no_broadcast';
			}
			$indication = '';
			if ($row['indicated_option'] == 1) {
				$indication = '_osusume';
			} elseif ($row['indicated_option'] == 2) {
				$indication = '_shinchyaku';
			}

			if ($row['k_stat'] == 2 || $row['booking'] >= $row['pax'] || $row['hiduke'] < date('Y-m-d')) {
				$indication = '_full';
				$bdcolor = ' border-left: 2px dashed red;';
				$color = '';
			} else {
				$bdcolor = ' border-left: 0px;';
			}

			$option_information = '<span class="icon_info'.$icon_live.'"></span><span class="icon_info'.$indication.'"></span>';
			$title_line = '<div class="title_line">'.$flag.'<span class="title_style">'.$row['k_title1'].'</span>'.$option_information.'</div>';

			$c_title = '';
			if ($row['free'] == 1)	{
				if (@$_SESSION['mem_id'] == '')	{
					$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、ログインするとご予約が可能となります。</div>';
				}
			}
			$c_desc = $row['k_desc1'];
			$c_img = '';
			if($row['hiduke'] >= date('Y-m-d') )
			{
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img = '[満席です]';
					}else{
						$c_img = '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img = '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img = '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img = '[残席わずかです。ご予約はお早めに]';
						}
					}
				}
			}

			$c_btn = '';
			$click_js = 'fnc_yoyaku(this);';
			if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
				$click_js = 'fnc_login(this);';
			} else {
				if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
				} else {
					if ($row['place'] == 'event' && !empty($this->_place_name) && !empty($row['k_desc2']) && strpos($this->_place_name, $row['k_desc2']) === false) {
						$click_js = 'fnc_area(this);';
					} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
						$click_js = 'fnc_area(this);';
					}
				}
			}
                        //SPの時の予約ボタンの記述
			if ($this->_header_obj->computer_use() === false) {
				// spの時は、強制的にser以下に飛ばす
				$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "'";
				if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
					$click_js = "location.href='/seminar/ser/login/" . $row['id'] . "'";
				} else {
					if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
					} else {
						if ($row['place'] == 'event' && strpos($this->_place_name, $row['k_desc2']) === false) {
							$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "/area'";
						} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
							$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "/area'";
						}
					}
				}
			}
                        //SPの時＆ウィジェットモード時の予約ボタンの記述
			if ($this->_header_obj->computer_use() === false && $this->_config['use_mode'] == 'widget') {
				// spの時は、強制的にser以下に飛ばす
				$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "')";
				if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
					$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/login/" . $row['id'] . "')";
				} else {
					if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
					} else {
						if ($row['place'] == 'event' && strpos($this->_place_name, $row['k_desc2']) === false) {
							$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "/area')";
						} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
							$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "/area')";
						}
					}
				}
			}

			$popup_title = '['.$this->_translate_city($row['place']).'C]';
			if ($row['place'] == 'event') {
				$popup_title = '[イベントE]';
			}

			$alert_place = "";
			if ($row['place'] == 'event') {
				$place_info = $this->_db->get_place_info($row['k_desc2']);
				if (!empty($place_info['name'])) {
					$alert_place = $place_info['name'];
				}
			}

			//Check first if we display the button or not, if the date is older then Today.
			$attention_login = "";
			if($row['hiduke'] >= date('Y-m-d') )
			{
				//Remove images tag
				$noimage_title = preg_replace("/<img[^>]+\>/i", "", $row['start'].'～&nbsp;' . $row['k_title1']);

				if ($row['free'] == 1)
				{
					if (@$_SESSION['mem_id'] == '') {
						//$c_btn	= '[メンバー限定]';
						$c_btn	= '<input class="button_yoyaku" type="button" value="ログイン" onclick="' . $click_js . '" name="'.$popup_title.$noimage_title.'" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
						$attention_login = "<span style='font-size: 9pt; color: deepskyblue;'>[メンバー限定セミナーの為、ログインが必要です。]</span><br>";
					} else
					{
						if ($row['k_stat'] == 2)
							$c_btn	= '[満席]';
						else
						{
							if ($row['booking'] >= $row['pax'])
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="' . $click_js . '" name="'.$popup_title.$noimage_title.'" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
							else
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="' . $click_js . '" name="'.$popup_title.$noimage_title.'" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
						}
					}
				}
				else
				{
					if ($row['k_stat'] == 2) // check booking, display button
						$c_btn	= '[満席]';
					else
					{
						if ($row['booking'] >= $row['pax'])
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="' . $click_js . '" name="'.$popup_title.$noimage_title.'" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
						else
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="' . $click_js . '" name="'.$popup_title.$noimage_title.'" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
					}
				}
			}

			$c_open = '<div class="open open_only">セミナー詳細はココをClick!!</div>';
			if ($c_img <> '') {
				$c_img = '<div class="c_img">' . $attention_login . $c_img . '</div>';
				$c_open = '<div class="open">セミナー詳細はココをClick!!</div>';
			} elseif ($attention_login <> '') {
				$c_img = '<div class="c_img">' . $attention_login . '</div>';
				$c_open = '<div class="open">セミナー詳細はココをClick!!</div>';
			}

			//add class for selected day in the list
			$selected_day_in_list ='';
			if ($row['id'] == $this->_num) {
				$selected_day_in_list = 'selected_day_in_list';
			}

			if (empty($this->_calendar[$year.'-'.$month.'-'.$day])) $this->_calendar[$year.'-'.$month.'-'.$day] = "";
			$this->_calendar[$year.'-'.$month.'-'.$day] .= '<img src="http://'.$_SERVER['SERVER_NAME'].'/images/sa05.jpg">';
			$c_msg  = '<tr class="'.$selected_day_in_list.'"><td nowrap style="vertical-align:top;" colspan="3"><div class="square_color" style="background-color:'.$color.'; '.$bdcolor.'">&nbsp;</div><span class="starttime">'.$row['starttime'].'～ </span>';


			if($row['place'] == 'event') {
				$event_place = $this->_translate_city($row['k_desc2']);
				if (empty($event_place)) {
					$event_place = $this->_translate_city($row['place']);
				} else {
					$event_place .= "会場";
				}
				$c_msg  .= $event_place;
			}else
				$c_msg  .= '<a target="_blank" href="http://'.$_SERVER['SERVER_NAME'].'/event/map/?p='.$row['place'].'">'.$this->_translate_city($row['place']).'会場</a>';

			$c_msg .= $title_line.'</td></tr><tr class="'.$selected_day_in_list.'"><td colspan="4">';
			$c_msg .= '<div class="c_btn" style="vertical-align:top;">'.$c_btn.'</div>'.$c_img.$c_open;
			$c_msg .= '<div class="det" style="border-color:'.$color.';">'.$c_title.nl2br($c_desc).'</div></td></tr>';
			if (empty($this->_calendar_msgs[$year.'-'.$month.'-'.$day])) $this->_calendar_msgs[$year.'-'.$month.'-'.$day] = "";
			$this->_calendar_msgs[$year.'-'.$month.'-'.$day] .= $c_msg;
		}
	}

	/**
	 * where_placeの取得
	 * @param $place
	 * @return string
	 */
	private function _get_where_place($place)
	{
		if (empty($this->_config['view_mode']) or ($this->_config['view_mode'] != 'calendar' and $this->_config['view_mode'] != 'list')) {
			return '';
		}
		$place_list = $this->_db->get_place_info_for_use_area($place);
		if (empty($place_list) or empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
			$place_info = $this->_db->get_place_info($place);
			$searchplus = "";
			if (!empty($place_info['searchplus'])) {
				$searchplus = ' or  k_title1 like \'%'.$place_info['name'].'%\'';
			}
			$where_place = '(place = \''.$place.'\' or k_desc2 like \'%'.$place.'%\' ' . $searchplus . ' ) ';
		} else {
			$wheres = array();
			foreach ($place_list as $info) {
				$searchplus = "";
				if (!empty($info['searchplus'])) {
					$searchplus = ' or  k_title1 like \'%'.$info['name'].'%\'';
				}
				$wheres[] = '(place = \''.$info['place'].'\' or k_desc2 like \'%'.$info['place'].'%\' ' . $searchplus . ' ) ';
			}
			$where_place = '( ' . implode(" or ", $wheres) . ' )';
		}
		return $where_place;
	}

	/**
	 * イベントリストを取得
	 */
	private function _get_event_list()
	{
		// パラメータ確認
		$where_place = ' ( 1=0';
		$where_country = ' ( 1=0';
		$where_know = ' ( 1=0';
		$nohit = true;

		foreach($_POST as $key => $val) {
			if (mb_substr($key, 0, 5) == 'place')	{
				if ($val == 'all')	{
					$where_place = '';
				}else{
					$this->_place_name = $val;
					$where_place .= ' or place = \''.$val.'\' ';
				}
				$nohit = false;
			}

			if (mb_substr($key, 0, 7) == 'country')	{
				if ($val == 'all')	{
					$where_country = '';
				}else{
					if ($val == 'other')	{
						$where_country .= ' or ( k_title1 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_title1 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_title1 not like  \'%カナダ%\' ';
						$where_country .= '  and k_title1 not like  \'%イギリス%\' ';
						//			$where_country .= '  and k_title1 not like  \'%フランス%\' ';
						$where_country .= '  and k_title1 not like  \'%英語圏%\' ';
						$where_country .= '  and k_desc1 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_desc1 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_desc1 not like  \'%カナダ%\' ';
						$where_country .= '  and k_desc1 not like  \'%イギリス%\' ';
						//			$where_country .= '  and k_desc1 not like  \'%フランス%\' ';
						$where_country .= '  and k_desc1 not like  \'%英語圏%\' ';
						$where_country .= '  and k_desc2 not like  \'%オーストラリア%\' ';
						$where_country .= '  and k_desc2 not like  \'%ニュージーランド%\' ';
						$where_country .= '  and k_desc2 not like  \'%カナダ%\' ';
						$where_country .= '  and k_desc2 not like  \'%イギリス%\' ';
						//			$where_country .= '  and k_desc2 not like  \'%フランス%\' ';
						$where_country .= '  and k_desc2 not like  \'%英語圏%\' ) ';
						$where_country .= '  or k_title1 like  \'%ヨーロッパ%\' ';
						$where_country .= '  or k_title2 like  \'%ヨーロッパ%\' ';
					}else{
						$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
						$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
						$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
					}
				}
			}
			if (mb_substr($key, 0, 4) == 'know')	{
				if ($val == 'all')	{
					$where_know = '';
				}else{
					$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
					if ($val == '現地生活ガイド')	{
						$where_know .= ' or k_title1 like \'%歩き方%\' ';
						$where_know .= ' or k_desc1 like \'%歩き方%\' ';
						$where_know .= ' or k_desc2 like \'%歩き方%\' ';
						$where_know .= ' or k_title1 like \'%安心生活%\' ';
						$where_know .= ' or k_desc1 like \'%安心生活%\' ';
						$where_know .= ' or k_desc2 like \'%安心生活%\' ';
					}
				}
			}
		}

		if ($nohit)	{
			$where_place = '';
			$where_country = '';
			$where_know = '';
		}

		$where_place .= ' ) ';
		$where_country .= ' ) ';
		$where_know .= ' ) ';

		$this->_keyword  = '';
		if ($where_place <> ' ) ')	{
			$this->_keyword .= ' and '.$where_place;
		} else {
			$this->_place_name = $this->_config['list']['place_default'];
			$this->_keyword .= ' and ' . $this->_get_where_place($this->_place_name);
		}
		if ($where_country <> ' ) ')	{
			$this->_keyword .= ' and '.$where_country;
		}
		if ($where_know <> ' ) ')	{
			$this->_keyword .= ' and '.$where_know;
		}

		$is_advanced_search = false;


//		if (!empty($this->_config['list']['title'])) {
//			//$is_advanced_search = true;
//			$this->_keyword .= ' and (k_title1 like \'%' . $this->_config['list']['title'] . '%\' or k_title2 like \'%' . $this->_config['list']['title'] . '%\' or k_desc1 like \'%' . $this->_config['list']['title'] . '%\' or k_desc2 like \'%' . $this->_config['list']['title'] . '%\')';
//		}
//		if (!empty($this->_config['list']['keyword'])) {
//			//$is_advanced_search = true;
//			$this->_keyword .= ' and (k_desc2 like \'%' . $this->_config['list']['keyword'] . '%\')';
//		}
		if (!empty($this->_config['list']['title'])) {
			if (is_array($this->_config['list']['title']))	{
				foreach($this->_config['list']['title'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' and (k_title1 like \'%' . $val . '%\' or k_title2 like \'%' . $val . '%\' or k_desc1 like \'%' . $val . '%\' or k_desc2 like \'%' . $val . '%\')';
					}
				}
			}else{
				$this->_keyword .= ' and (k_title1 like \'%' . $this->_config['list']['title'] . '%\' or k_title2 like \'%' . $this->_config['list']['title'] . '%\' or k_desc1 like \'%' . $this->_config['list']['title'] . '%\' or k_desc2 like \'%' . $this->_config['list']['title'] . '%\')';
			}
		}
		if (!empty($this->_config['list']['title2'])) {
			if (is_array($this->_config['list']['title2']))	{
				$this->_keyword .= ' and ( 1 = 0 ';
				foreach($this->_config['list']['title2'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' or (k_title1 like \'%' . $val . '%\' or k_title2 like \'%' . $val . '%\' or k_desc1 like \'%' . $val . '%\' or k_desc2 like \'%' . $val . '%\')';
					}
				}
				$this->_keyword .= ' ) ';
			}else{
				$this->_keyword .= ' and (k_title1 like \'%' . $this->_config['list']['title2'] . '%\' or k_title2 like \'%' . $this->_config['list']['title2'] . '%\' or k_desc1 like \'%' . $this->_config['list']['title2'] . '%\' or k_desc2 like \'%' . $this->_config['list']['title2'] . '%\')';
			}
		}
		if (!empty($this->_config['list']['keyword'])) {
			if (is_array($this->_config['list']['keyword']))	{
				foreach($this->_config['list']['keyword'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' and (k_desc2 like \'%' . $val . '%\')';
					}
				}
			}else{
				$this->_keyword .= ' and (k_desc2 like \'%' . $this->_config['list']['keyword'] . '%\')';
			}
		}
		if (!empty($this->_config['list']['keyword2'])) {
			if (is_array($this->_config['list']['keyword2']))	{
				$this->_keyword .= ' and ( 1 = 0 ';
				foreach($this->_config['list']['keyword2'] as $val)	{
					if ($val <> '')	{
						$this->_keyword .= ' or (k_desc2 like \'%' . $val . '%\')';
					}
				}
				$this->_keyword .= ' ) ';
			}else{
				$this->_keyword .= ' and (k_desc2 like \'%' . $this->_config['list']['keyword'] . '%\')';
			}
		}


		if (!empty($this->_config['start_date'])) {
			$is_advanced_search = true;
			$this->_keyword .= ' and \'' . $this->_config['start_date'] . '\' <= hiduke ';
		}
		if (!empty($this->_config['end_date'])) {
			$is_advanced_search = true;
			$this->_keyword .= ' and hiduke <= \'' . $this->_config['end_date'] . '\' ';
		}
		if (!empty($this->_config['list']['member_only']) && ($this->_config['list']['member_only'] == 'true' || $this->_config['list']['member_only'] == 'yes' || $this->_config['list']['member_only'] == 'on' || $this->_config['list']['member_only'] == '1')) {
			$this->_keyword .= ' and free = 1 ';
		}
		if ($is_advanced_search === false) {
			if (empty($this->_config['list']['past_view']) || ($this->_config['list']['past_view'] !== 'true' && $this->_config['list']['past_view'] !== 'yes' && $this->_config['list']['past_view'] !== 'on' && $this->_config['list']['past_view'] !== '1')) {
				$this->_keyword .= ' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)  ';
			}
		}

		//if ($is_advanced_search && !empty($this->_config['list']['past_view']) && ($this->_config['list']['past_view'] == 'true' || $this->_config['list']['past_view'] == 'yes' || $this->_config['list']['past_view'] == 'on' || $this->_config['list']['past_view'] == '1')) {

		//}

		// セミナーIDが指定されてれば、他の条件に関係なく強制的にその一つだけ表示
		if (!empty($this->_config['seminar_id'])) {
			$this->_keyword = ' and id in (' . implode(',', $this->_config['seminar_id']) . ')';
			if (empty($this->_config['list']['past_view']) || ($this->_config['list']['past_view'] !== 'true' && $this->_config['list']['past_view'] !== 'yes' && $this->_config['list']['past_view'] !== 'on' && $this->_config['list']['past_view'] !== '1')) {
				$this->_keyword .= ' AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY)  ';
			}
		}

		$list = $this->_db->get_target_event_list_for_list($this->_keyword);

		foreach ($list as $row) {

			$year	= $row['yy'];
			$month	= $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			/*
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);
			*/

			$title	= $start.' '.$row['k_title1'];

			//if ($row['place'] != 'event' && $row['place'] != 'sendai' && $row['place'] != 'toyama') {
			//	continue;
			//}

			// イベント
			if ($row['free'] == 1)	{
				if (@$_SESSION['mem_id'] == '')	{
					$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="/mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
				}else{
					$c_title = '';
				}
			}else{
				$c_title = '';
			}
			$c_desc = $row['k_desc1'];
			$c_img = '';
			if($row['hiduke'] >= date('Y-m-d') )
			{
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}
				}elseif ($row['k_stat'] == 2)	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_img   	= '[満席です]';
					}else{
						if ($row['booking'] >= $row['pax'] / 3)	{
							$c_img   	= '[残席わずかです。ご予約はお早めに]';
						}else{
							$c_img	= '';
						}
					}
				}
			}

			if($row['hiduke'] >= date('Y-m-d') )
			{
				$click_js = 'fnc_yoyaku(this);';
				if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
					$click_js = 'fnc_login(this);';
				} elseif (empty($this->_config['seminar_id'])) {
					if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
					} else {
						if ($row['place'] == 'event' && strpos($this->_place_name, $row['k_desc2']) === false) {
							$click_js = 'fnc_area(this);';
						} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
							$click_js = 'fnc_area(this);';
						}
					}
				}
                                //SPの時の予約ボタンの記述
				if ($this->_header_obj->computer_use() === false) {
					// spの時は、強制的にser以下に飛ばす
					$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "'";
					if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
						$click_js = "location.href='/seminar/ser/login/" . $row['id'] . "'";
					} elseif (empty($this->_config['seminar_id'])) {
						if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
						} else {
							if ($row['place'] == 'event' && strpos($this->_place_name, $row['k_desc2']) === false) {
								$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "/area'";
							} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
								$click_js = "location.href='/seminar/ser/id/" . $row['id'] . "/area'";
							}
						}
					}
				}
                                //SPの時＆ウィジェットモード時の予約ボタンの記述
				if ($this->_header_obj->computer_use() === false && $this->_config['use_mode'] == 'widget') {
					// spの時は、強制的にser以下に飛ばす
					$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "')";
					if ($row['free'] == 1 && @$_SESSION['mem_id'] == '') {
						$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/login/" . $row['id'] . "')";
					} elseif (empty($this->_config['seminar_id'])) {
						if (empty($this->_config[$this->_config['view_mode']]['use_area']) || $this->_config[$this->_config['view_mode']]['use_area'] == 'off' || $this->_config[$this->_config['view_mode']]['use_area'] == 'no' || $this->_config[$this->_config['view_mode']]['use_area'] == 'false' || $this->_config[$this->_config['view_mode']]['use_area'] == '0') {
						} else {
							if ($row['place'] == 'event' && strpos($this->_place_name, $row['k_desc2']) === false) {
                                                                $click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "/area')";
							} elseif ($row['place'] !== 'event' && $row['place'] !== $this->_place_name) {
								$click_js = "yoyaku_jump('".$_SERVER['SERVER_NAME']."/seminar/ser/id/" . $row['id'] . "/area')";
							}
						}
					}
				}

				$popup_title = '['.$this->_translate_city($row['place']).'C]';
				if ($row['place'] == 'event') {
					$popup_title = '[イベントE]';
				}

				$alert_place = "";
				if ($row['place'] == 'event') {
					$place_info = $this->_db->get_place_info($row['k_desc2']);
					if (!empty($place_info['name'])) {
						$alert_place = $place_info['name'];
					}
				}

				if ($row['free'] == 1)	{
					if (@$_SESSION['mem_id'] == '')	{
						// $c_btn	= '[メンバー限定]';
						$c_btn	= '<input class="button_yoyaku" type="button" value="ログイン" onclick="' . $click_js . '" name="' . $popup_title . $title . '" uid="'.$row['id'].'">';
					}else{
						if ($row['k_stat'] == 2)	{
							$c_btn	= '[満席]';
						}else{
							if ($row['booking'] >= $row['pax'])	{
								$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="' . $click_js . '" title="' . $popup_title . $title . '" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
							}else{
								$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="' . $click_js . '" title="' . $popup_title . $title . '" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
							}
						}
					}
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="' . $click_js . '" title="' . $popup_title . $title . '" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="' . $click_js . '" title="' . $popup_title . $title . '" uid="'.$row['id'].'" area="' . $row['k_title1'] . '" alertplace="' . $alert_place . '">';
						}
					}
				}
			}

			$add_margin_left = "margin-left:150px;";
			$add_detail_margin = "margin:5px 0 10px 50px;";
                        if($this->_config['use_mode']){
                            $add_detail_margin = "margin:5px 0 10px;";
                        }
			$add_text_align = "";
			$add_colspan = '<td class="seminar_title">'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
			if ($this->_header_obj->computer_use() === false && $_SESSION['pc'] != 'on') {
				// spの時
				$add_margin_left = "";
				$add_detail_margin = "";
				$add_colspan = '</tr><tr><td colspan="2" class="seminar_title">'.$row['k_title1'].'</td></tr><tr><td colspan="2">';
				//$add_colspan = '<td colspan="2">'.$row['k_title1'].'</td></tr><tr><td colspan="2">';
				$this->_config['list']['window_width'] = '100%';
			}

			if ($c_img <> '')	{
				$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; ' . $add_margin_left . '" class="seminar_status">'.$c_img.'</div>';
			}

			if (empty($this->_calendar[$year.'-'.$month.'-'.$day])) $this->_calendar[$year.'-'.$month.'-'.$day] = "";
			$this->_calendar[$year.'-'.$month.'-'.$day] .= '<img src="http://'.$_SERVER['SERVER_NAME'].'/images/sa05.jpg">';
                        if($this->_config['use_mode'] == 'widget'){
                            $c_msg  = '<tr><td nowrap class="seminar_timeandplace" style="vertical-align:middle; width:20%; text-align:center">'.$row['starttime'].'～ <img src="http://'.$_SERVER['SERVER_NAME'].'/images/sa05.jpg">' . $this->_translate_city($row['place']) . '</td><td nowrap class="seminar_button" style="vertical-align:top; width:10%; text-align:center' . $add_text_align . '">'.$c_btn.'</td>';
                        }else{
                            $c_msg  = '<tr><td nowrap class="seminar_timeandplace" style="vertical-align:top; width:20%;">'.$row['starttime'].'～ <img src="http://'.$_SERVER['SERVER_NAME'].'/images/sa05.jpg">' . $this->_translate_city($row['place']) . '</td><td nowrap class="seminar_button" style="vertical-align:top; width:10%;' . $add_text_align . '">'.$c_btn.'</td>';
                        }
			$c_msg .= $add_colspan;
			$c_msg .= $c_img;
			$detail_open = 'none';
			if (!empty($this->_config['list']['detail_open']) && ($this->_config['list']['detail_open'] == 'on' || $this->_config['list']['detail_open'] == '1' || $this->_config['list']['detail_open'] == 'yes' || $this->_config['list']['detail_open'] == 'true')) {
				$detail_open = 'block';
			} else {
                            if($this->_config['use_mode'] == 'widget'){
                                $c_msg .= '<div class="open" uid="' . $row['id'] . '">セミナー詳細はココをClick!!</div>';
                            }else{
				$c_msg .= '<div class="open" style="' . $add_margin_left . '" uid="' . $row['id'] . '">セミナー詳細はココをClick!!</div>';
                            }
			}
                        if($this->_config['use_mode'] == 'widget'){
                            $c_msg .= '<div class="det" style="' . $add_detail_margin . ' padding: 5px 0 13px 12px; display:' . $detail_open . '; border-left:1px dotted navy; border-bottom: 1px dotted navy; width:auto;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
                        }else{
                            $c_msg .= '<div class="det" style="' . $add_detail_margin . ' padding: 5px 0 13px 12px; display:' . $detail_open . '; border-left:1px dotted navy; border-bottom: 1px dotted navy; width:80%;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
                        }
			if (empty($this->_calendar_msgs[$year.'-'.$month.'-'.$day])) $this->_calendar_msgs[$year.'-'.$month.'-'.$day] = "";
			$this->_calendar_msgs[$year.'-'.$month.'-'.$day] .= $c_msg;

			$this->_event_count++;
		}
	}

	/**
	 * HTMLを出力する
	 */
	public function show($target_seminar_id = "")
	{
		$isView = true;
		if ($this->_config['view_mode'] == 'calendar') {
			$this->_show_calendar();
			if (empty($this->_event_count)) $isView = false;
		} elseif ($this->_config['view_mode'] == 'list') {
			$isView = $this->_show_list($target_seminar_id);
		}
		return $isView;
	}

	/**
	 * カレンダーの表示
	 */
	private function _show_calendar()
	{
		echo '<script type="text/javascript" src="/js/wz_tooltip.js"></script><div class="shibori" id="shiborikomi"><form id="kensakuform">';
		// 会場の表示
		echo $this->_get_calendar_place();
		// 興味のある国の表示
		echo $this->_get_calendar_country();
		// セミナー内容の表示
		echo $this->_get_calendar_know();

		echo '<input type="hidden" name="month_date" value="' . $this->_month . '" />
                    <input type="hidden" name="year_date" value="' . $this->_year . '" />
                    <input type="hidden" name="navigation_used" value="' . $this->_get_navigation_used() . '" />
                    <input type="hidden" name="selected_day" value="' . $this->_selected_day . '" />
                    <input type="hidden" name="script_name" value="' . $_SERVER['SCRIPT_NAME'] . '" />
            </form></div>';

		if ($this->_config['calendar']['calendar_icon_active'] == 'active' || $this->_config['calendar']['calendar_icon_active'] == 'yes' || $this->_config['calendar']['calendar_icon_active'] == 'on' || $this->_config['calendar']['calendar_icon_active'] == 'true') {
			echo '
<div class="orange-solid">
	<p>【カレンダー上のアイコンの意味】<br/><br/></p>
	<span style="margin-left:50px;"><img src="/css/images/au.png" alt="Australian Flag" />&nbsp;<img src="/css/images/ca.png" alt="Canadian Flag" />&nbsp;<img src="../css/images/uk.png" alt="Union Jack" />&nbsp;&nbsp;各国向けのセミナーです</span>
	<span style="margin-left:100px;"><img src="/css/images/wd.png" alt="World" />&nbsp;&nbsp;英語圏の国セミナーです</span>
	<span style="margin-left:100px;"><img src="/css/images/full.png" alt="fullybooked" />&nbsp;&nbsp;予約が満席のセミナーです</span><br/><br/>
	<span style="margin-left:50px;"><img src="/css/images/camera.png" alt="camera" />&nbsp;&nbsp;中継対象セミナー（メンバー登録された方がオンラインでご覧いただけます）</span>
	<span style="margin-left:180px;"><img src="/css/images/hoshi.png" alt="osusume" />&nbsp;&nbsp;おススメのセミナーです</span><br/><br/>
</div>';
		}

		echo '<div style="margin:20px 0 0 0 ;" id="semi_show" >' . $this->get_seminar_show() . '</div>';

		if ($this->_config['calendar']['footer_desc_active'] == 'active' || $this->_config['calendar']['footer_desc_active'] == 'yes' || $this->_config['calendar']['footer_desc_active'] == 'on' || $this->_config['calendar']['footer_desc_active'] == 'true') {
			/*echo '
<div class="navy-dotted">
【ご注意：スマートフォンをご利用の方へ】<br/>
スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>
この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
　・　参加希望のセミナー日程<br/>
　・　お名前<br/>
　・　当日連絡の付く電話番号<br/>
　・　興味のある国<br/>
　・　出発予定時期<br/>
</div>

<div class="navy-dotted">
【参加したいセミナーが無い場合】<br/>
　　常設会場（東京・大阪）まで来られない<br/>
　　希望の日程でセミナーが開催されていない<br/>
　　セミナーの時間が合わない<br/>
　など、参加したいセミナーが無い場合は、ご希望を教えてください。<br/>
　セミナーの内容などについてもリクエストもお待ちしております。<br/>
<div style="margin:10px 0 10px 0; text-align:center;"><img src="../images/seminarrequest_off.gif" class="feedshow"></div>
</div>

<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
    <img src="../images/flag01.gif">
    <img src="../images/flag03.gif">
    <img src="../images/flag09.gif">
    <img src="../images/flag05.gif">
    <img src="../images/flag06.gif">
    <img src="../images/mflag11.gif" width="40" height="26">
    <img src="../images/flag08.gif">
    <img src="../images/flag04.gif">
    <img src="../images/flag02.gif">
    <img src="../images/flag10.gif">
    <img src="../images/flag07.gif">
</div>

<div style="height:50px;">&nbsp;</div>
';*/
		}
		echo $this->yoyakuform();

		echo $this->checkdouji();
	}

	/**
	 * リストの表示
	 */
	private function _show_list($target_seminar_id = "")
	{
		$output = "";
		$event_count = "";
		if ($this->_event_count == 0)	{
			// $event_count .= '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
		}else{
			if (!empty($this->_config['list']['count_field_active']) && ($this->_config['list']['count_field_active'] == 'active' || $this->_config['list']['count_field_active'] == 'true' || $this->_config['list']['count_field_active'] == 'yes' || $this->_config['list']['count_field_active'] == 'on')) {
				$event_count .= '<div style="font-size:12pt; margin-left:40px;">'.$this->_event_count.'件のセミナーがあります。</div>';
			}
		}
		if ($this->_is_list_view) $output .= $event_count;

		$isPc = true;
		if ($this->_header_obj->computer_use() === false && $_SESSION['pc'] != 'on') $isPc = false;
		list($ret, $isView) = event_calender_list($this->_calendar, $this->_calendar_msgs, $this->_config, $target_seminar_id, $isPc);
		$output .= '<div style="width:620; float:clear;">' . $ret . '</div>';

		//if ($this->_is_list_view && $this->_config['list']['multi_use'] == 'off') $output .= $this->yoyakuform();
                if(empty(self::$_last_form_view)){
                    if ($this->_is_list_view && $this->_config['list']['multi_use'] == 'off') $output .= $this->yoyakuform();
                    self::$_last_form_view = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                }else{
                    if(self::$_last_form_view != $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) $output .= $this->yoyakuform();
                }

		if ($this->_is_list_view) $output .= $this->checkdouji();

		echo $output;

		if ($this->_is_list_view) $this->_is_list_view = false;

		return $isView;
	}

	/**
	 * 同時開催チェック
	 * @param $places
	 * @return string
	 */
	private function checkdouji()
	{
		if (empty($this->_douji_info)) return '';

		$output = '';
		$output .= '
<div id="checkdoujiform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div><div class="btn_close_info"><input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();" /></div>
		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>
		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			このセミナーは複数の会場で開催されます。<br>どこの会場で予約しますか？
		</div>
		<table style="width:560px; background-color: lightblue;">
			<tr style="">
				<td nowrap style="text-align:right;">開催日時&nbsp;</td>
				<td style="text-align:left;font-weight: bold;">' . $this->_douji_info[0]['start'] . '〜</td>
			</tr>
			<tr style="">
				<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
				<td style="text-align:left;font-weight: bold;">' . $this->_douji_info[0]['k_title1'] . '</td>
			</tr>
		</table>

<div class="det" style="border-color: rgb(255, 99, 71); display: block;width:460px;margin-left:0px;">' . nl2br($this->_douji_info[0]['k_desc1']) . '</div>

		<div style="margin-top:10px;">
		';
		mb_internal_encoding('UTF-8');
		$place_list = array();
		$max_length = 0;
		foreach ($this->_douji_info as $one) {
			$place_name =  $this->_translate_city($one['place']) . '会場で予約する ';
			$place_list[$one['id']] = $place_name;
			$length = mb_strlen($place_name);
			if ($length > $max_length) $max_length = $length;
		}
		foreach ($place_list as $k => $p) {
			$length = mb_strlen($p);
			$diff = $max_length - $length;
			for ($i = 0; $i < $diff; $i++) $p .= '　';
			$output .= '<input type="button" style="margin-bottom:10px;" class="button_submit" id="" value=" ' . $p . '" onClick="location.href=\'/seminar/seminar?num=' . $k . '&view=1#calendar_start\'"><br>';
		}
		$output .= '</div>

<br>
	</div>
</div>
';
		return $output;
	}

	/**
	 * ポップアップの予約フォームを出力
	 * @return string
	 */
	private function yoyakuform()
	{
		$output = "";
		$output .= '
<div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
	<div id="form_area" style="">
		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>
		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			セミナーのご予約に際し、以下の内容をご確認ください。
		</div>
		<div style="font-size:9pt; font-weight:; text-align:left; margin:10px 0 10px 20px;">
			<br>
			【ご注意】
			<br><br>
			このセミナーは、<span id="area_name" style="text-decoration: underline;"></span>です。<br><br>
			<p id="alert_place" style="font-size: 9pt;"></p>
			会場にお間違いは無いでしょうか？<br><br>
			よろしければ「次へ」を押して下さい。<br><br><br><br>
		</div>
		<div style="margin-top:10px;">
			<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" value="次へ" onClick="fnc_yoyaku2();">
		</div>
	</div>
	<div id="form0" style="">
		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>
		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			セミナーのご予約に際し、ログインして下さい。
		</div>
		<div style="font-size:9pt; margin:10px 0 10px 0;">
			<br><br>メンバー様専用セミナーの予約の為にログインします。<br><br>
			ご登録いただいた、メールアドレスとパスワードを入力してください。<br><br><br>
		</div>
		<div>
			<form name="yoyaku_login" id="yoyaku_login">
				<table style="width:560px;margin-bottom: 30px;">
					<tr>
						<th style="text-align: right;">メールアドレス　:　</th>
						<td style="text-align: left;"><input type="text" size="30" name="email" id="login_email" value=""></td>
					</tr>
					<tr>
						<th style="text-align: right;">パスワード　:　</th>
						<td style="text-align: left;"><input type="password" size="20" name="pwd" id="login_pwd" value=""></td>
					</tr>
				</table>
			</form>
		</div>
		<div id="div_wait_login" style="display:none;">
			<img src="http://'.$_SERVER['SERVER_NAME'].'/images/ajaxwait.gif">
			&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
			<img src="http://'.$_SERVER['SERVER_NAME'].'/images/ajaxwait.gif">
		</div>
		<div style="margin-top:10px;">
			<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" id="btn_login" value="ログイン" onClick="fnc_do_login();">
		</div>
	</div>
	<div id="form1" style="">
		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>
		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			セミナーのご予約に際し、以下の内容をご確認ください。
		</div>
		<div style="font-size:9pt; font-weight:; text-align:left; margin:10px 0 10px 20px;">
			１．　このフォームでは、仮予約の受付を行います。<br/>
			　　　予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>
			　　　ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされ<br/>
			　　　セミナーにご参加頂けません。ご注意ください。<br/>
			&nbsp;<br/>
			２．　携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が<br/>
			　　　受信できるできる状態にしておいてください。<br/>
			&nbsp;<br/>
			３．　Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて<br/>
			　　　到着する場合があります。時間をおいてから受信確認を行うようにしてください。<br/>
			&nbsp;<br/>
			４．　予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>
			　　　なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。<br/>
			&nbsp;<br/>
			最近、会場を間違えてご予約される方が増えております。<br/>
			セミナー内容・会場・日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。<br/>
		</div>
		<div style="margin-top:10px;">
			<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" value="次へ" onClick="fnc_next();">
		</div>
	</div>
	<div id="form2" style="display:none;">
	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>
';
		$output .= '<form name="form_yoyaku" id="form_yoyaku">
	<table style="width:560px;">
		<tr style="background-color:lightblue;">
			<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
			<td id="form_title" style="text-align:left;"></td>
			<input type="hidden" name="セミナー名" id="txt_title" value="">
			<input type="hidden" name="セミナー番号" id="txt_id" value="">
		</tr>
	</table>
		</form>';
		//if (@$_SESSION['mem_id'] != '') {} else {}
		$output .= '
	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
		このフォームでは仮予約を行います。<br/>
		予約確認のメールをお送りしますので、メールの指示に従って予約を確定させてください。<br/>
	</div>
	<div id="msg_hajimete" style="display:none; font-size:10pt; font-weight:bold; margin:10px 0 10px 0; background-color:LightPink; color:red;">
		***&nbsp;&nbsp;ご注意&nbsp;&nbsp;***<br/>
		初めてセミナーご参加される場合は、<a href="http://'.$_SERVER['SERVER_NAME'].'/seminar/seminar_01" target="_blank">初心者向けセミナー</a>へのご予約をお願いします。<br/>
	</div>
	<div id="div_wait" style="display:none;">
		<img src="http://'.$_SERVER['SERVER_NAME'].'/images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="http://'.$_SERVER['SERVER_NAME'].'/images/ajaxwait.gif">
	</div>
	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">
	</div>
</div>
';
		return $output;
	}

	/**
	 * セミナー切り替え部分の取得
	 * @return string
	 */
	public function get_seminar_show()
	{

		$open_jquery = '
<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
	});
});
</script>';

		return $open_jquery . $this->_get_count_number_of_seminar() . $this->_generate_calendar();
	}

	/**
	 * セミナーのカウント表示
	 */
	private function _get_count_number_of_seminar()
	{
		if ($this->_config['calendar']['count_field_active'] == 'active' || $this->_config['calendar']['count_field_active'] == 'on' || $this->_config['calendar']['count_field_active'] == 'true' || $this->_config['calendar']['count_field_active'] == 'yes') {

		} else {
			return "";
		}
		$this->_event_count = count_number_of_seminar($this->_year, $this->_month, $this->_keyword, $this->_get_navigation_used());

		$str = "";
		if (empty($this->_calendar_msgs) || $this->_event_count == 0)	{
			$str = '<div style="margin:40px 0 40px 0; padding: 10px 0 10px 50px; border:3px red dotted; color:red; font-size:14pt; font-weight:bold;">該当するセミナーがありません。検索条件を変更してください。</div>';
		}else{
			$str = '<div style="font-size:12pt; margin-left:40px;">'.$this->_event_count.'件のセミナーがあります。</div>';
		}
		return $str;
	}

	/**
	 * カレンダーの表示
	 */
	private function _generate_calendar()
	{
		$ret = "";
		//Display calendar
		if (!empty($this->_config['start_date']) && !empty($this->_config['end_date'])) {
			$ret .= calender_show_limit($this->_config['start_date'], $this->_config['end_date'], $this->_calendar, $this->_year, $this->_month, $this->_translate_city($this->_place_name), $this->_place_name, $this->_keyword, $this->_checked_countryname, $this->_checked_know, $this->_get_navigation_used(), $this->_selected_day, $this->_config['calendar']['calendar_title_active'], $this->_config['start_date'], $this->_config['end_date']);
		}else{
			$ret .= calender_show($this->_calendar, $this->_year, $this->_month, $this->_translate_city($this->_place_name), $this->_place_name, $this->_keyword, $this->_checked_countryname, $this->_checked_know, $this->_get_navigation_used(), $this->_selected_day, $this->_config['calendar']['calendar_title_active'], $this->_config['start_date'], $this->_config['end_date']);
		}

		if ($this->_config['calendar']['calendar_desc_active'] == 'active' || $this->_config['calendar']['calendar_desc_active'] == 'on' || $this->_config['calendar']['calendar_desc_active'] == 'true' || $this->_config['calendar']['calendar_desc_active'] == 'yes') {
			$ret .= '&nbsp;<br/><span style="font-size:11pt;">
	<a href="/event.html">その他のイベントはこちらからどうぞ</a>
</span>
';
		}
		$ret .= '<div id="list_calendar_display">';
		$ret .= calender_list($this->_calendar, $this->_calendar_msgs, $this->_year, $this->_month, $this->_place_name);
		$ret .= '</div>';
		return $ret;
	}

	/**
	 * 会場のHTMLを取得
	 */
	private function _get_calendar_place()
	{
		$active = @$this->_config['calendar']['place_active'];
		if ($active != 'active' && $active != 'true' && $active != 'yes' && $active != 'on') {
			return '';
		}

		$str = '<div class="orange-solid"><font style="font-weight:bold; font-size:11pt;">会場を選択する</font><br/>';
		foreach ($this->_config['calendar']['place_list'] as $one) {
			$checked = "";
			if ($this->_place_name == $one) $checked = 'checked="checked"';
			$str .= '<label for="place-' . $one . '"  >' . $this->_translate_city($one) . '</label><input id="place-' . $one . '"   type="radio" name="place-name" onClick="fncplacesel(this);" value="' . $one . '" ' . $checked . ' />';
		}
		$str .= '</div><p style="text-align:right;padding-right:20px;margin-bottom:10px;font-size:12px;">その他の都市でのセミナー開催日程は、<a href="/event.html" title="イベントカレンダー">イベントカレンダー</a>にてご案内いたします</p>';

		return $str;
	}

	/**
	 * 興味ある国のHTMLを取得
	 */
	private function _get_calendar_country()
	{
		$active = @$this->_config['calendar']['country_active'];
		if ($active != 'active' && $active != 'true' && $active != 'yes' && $active != 'on') {
			return '';
		}
		$str = '<div class="orange-solid"><font style="font-weight:bold; font-size:11pt;">興味のある国を選択する（複数選択可能）</font><br/>';

		$index = 0;
		foreach ($this->_config['calendar']['country_list'] as $one) {
			/*
			$checked = "";
			if (in_array($one, @$this->_config['calendar']['country_default']) || substr_count(@$_GET['checked_countryname'], $one) == 1) {
				$checked = 'checked="checked"';
			}
			if (empty($this->_config['calendar']['country_default']) && $one == 1 && (!empty($this->_num) || $_GET['checked_countryname'] == '0' || empty($_GET['checked_countryname']))) {
				$checked = 'checked="checked"';
			}
			$jsmethod = 'fnccountryall();';
			if ($one != 1) {
				$jsmethod = 'fnccountrysel();';
			}
			$str .= '<label for="country-' . $this->_countries[$one]['id'] . '">' . $this->_countries[$one]['name'] . '</label><input id="country-' . $this->_countries[$one]['id'] . '" type="checkbox" name="country-' . $one . '" onClick="' . $jsmethod . '" value="' . $this->_countries[$one]['value'] . '" ' . $checked . ' />';
			*/
			$checked = "";
			if (isset($_GET['checked_countryname'])) {
				if (substr_count(@$_GET['checked_countryname'], $index) == 1) {
					$checked = 'checked="checked"';
				}
			} else {
				if ($one['default'] == 'on') {
					$checked = 'checked="checked"';
				}
			}
			/*
			if ($one['default'] == 'on' || substr_count(@$_GET['checked_countryname'], $index) == 1) {
				$checked = 'checked="checked"';
			}
			*/
			$jsmethod = 'fnccountryall();';
			if ($one['id'] != 'all') {
				$jsmethod = 'fnccountrysel();';
			}
			$str .= '<label for="country-' . $one['id'] . '">' . $one['name'] . '</label><input id="country-' . $one['id'] . '" type="checkbox" name="country-' . $index . '" onClick="' . $jsmethod . '" value="' . $one['id'] . '" ' . $checked . ' />';
			$index++;
		}
		$str .= '</div>';
		return $str;
	}

	/**
	 * セミナーの内容のHTMLの取得
	 */
	private function _get_calendar_know()
	{
		$active = @$this->_config['calendar']['know_active'];
		if ($active != 'active' && $active != 'true' && $active != 'yes' && $active != 'on') {
			return '';
		}
		$str = '<div class="orange-solid"><font style="font-weight:bold; font-size:11pt;">セミナーの内容を選択する（複数選択可能）</font><br/>';

		$index = 0;
		foreach ($this->_config['calendar']['know_list'] as $one) {
			/*
			$checked = "";
			if (in_array($one, @$this->_config['calendar']['know_default']) || substr_count(@$_GET['checked_know'], $one) == 1) {
				$checked = 'checked="checked"';
			}
			if (empty($this->_config['calendar']['know_default']) && $one == 1 && (!empty($this->_num) || $_GET['checked_know'] == '0' || empty($_GET['checked_know']))) {
				$checked = 'checked="checked"';
			}
			$jsmethod = 'fncknowall();';
			if ($one != 1) {
				$jsmethod = 'fncknowsel();';
			}
			$str .= '<label for="know-' . $this->_knows[$one]['id'] . '">' . $this->_knows[$one]['name'] . '</label><input id="know-' . $this->_knows[$one]['id'] . '" type="checkbox" name="know-' . $one . '" onClick="' . $jsmethod . '" value="' . $this->_knows[$one]['value'] . '" ' . $checked . ' />';
			*/
			$checked = "";
			if (isset($_GET['checked_know'])) {
				if (substr_count(@$_GET['checked_know'], $index) == 1) {
					$checked = 'checked="checked"';
				}
			} else {
				if ($one['default'] == 'on') {
					$checked = 'checked="checked"';
				}
			}
			$jsmethod = 'fncknowall();';
			if ($one['id'] != 'all') {
				$jsmethod = 'fncknowsel();';
			}
			$str .= '<label for="know-' . $one['id'] . '">' . $one['name'] . '</label><input id="know-' . $one['id'] . '" type="checkbox" name="know-' . $index . '" onClick="' . $jsmethod . '" value="' . $one['id'] . '" ' . $checked . ' />';
			$index++;
		}
		$str .= '</div>';
		return $str;
	}

	/**
	 * コンフィグを返す
	 * @return array
	 */
	public function get_config()
	{
		return $this->_config;
	}

	/**
	 * モバイル用リダイレクト先を返す
	 * @return string
	 */
	public function get_mobileredirect()
	{
		return $this->_mobileredirect;
	}

	/**
	 * jsを返す
	 * @return string
	 */
	public function get_add_js()
	{
            if(empty(self::$_last_js_view)){
                self::$_last_js_view = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                return $this->_add_js;
            }else{
                if(self::$_last_js_view != $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) return $this->_add_js;
            }
	}

	/**
	 * cssを返す
	 * @return string
	 */
	public function get_add_css()
	{
            if(empty(self::$_last_css_view)){
                self::$_last_css_view = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                return $this->_add_css;
            }else{
                if(self::$_last_css_view != $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) return $this->_add_css;
            }
	}

	/**
	 * styleを返す
	 * @return string
	 */
	public function get_add_style()
	{
            if(empty(self::$_last_style_view)){
                self::$_last_style_view = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                return $this->_add_style;
            }else{
                if(self::$_last_style_view != $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) return $this->_add_style;
            }
	}

	/**
	 * GETやPOSTデータにパラメータをエスケープ
	 */
	private function _parameter_escape()
	{
		foreach ($_GET as $key => $value) {
			$_GET[$key] = $this->_secure($value);
		}
		foreach ($_POST as $key => $value) {
			$_POST[$key] = $this->_secure($value);
		}
	}

	/**
	 * イベントかどうかをチェックして、イベントの場合、リダイレクト
	 */
	private function _check_event()
	{
		if (!empty($this->_num))
		{
			$this->_selected_event_info = $this->_db->get_event_info_for_hiduke($this->_num);
			$this->_year  = $this->_selected_event_info['yyy'];
			$this->_month = $this->_selected_event_info['mmm'];
			$this->_day   = $this->_selected_event_info['ddd'];
			$m = sprintf("%02d", $this->_selected_event_info['mmm']);
			$d = sprintf("%02d", $this->_selected_event_info['ddd']);
			if ($this->_selected_event_info['place'] == 'event' && $_GET['go'] == '1' && $this->_header_obj->computer_use() !== false) {
				header('Location:/event.html#' . $this->_year . $m . $d) ;
				exit;
			}
			$id = $this->_selected_event_info['place'] . $this->_year . $m . $d;
			$this->_add_popup_js = get_popup_js($id, $this->_num);

			if (empty($_GET['douji'])) {
				$this->_mobileredirect = '/seminar/ser/place/' . $this->_selected_event_info['place'] . '/' . $this->_year . '/' . $this->_month . '/' . $this->_day . '/' . $this->_num;
			} else {
				$this->_mobileredirect = '/seminar/ser/douji/' . $this->_num;
			}

		} else {
			if (!empty($_POST['place-name'])) {
				$this->_mobileredirect = '/seminar/ser/place/' . @$_POST['place-name'];
			} elseif (!empty($_GET['navigation'])) {
				$this->_mobileredirect = '/seminar/ser/place/' . @$_GET['place_name'];
			} else {
				$this->_mobileredirect = '/seminar/ser/';
			}
		}
	}

	/**
	 * place_nameの設定
	 */
	private function _set_place_name()
	{
		if (!empty($_POST['place-name'])) {
			$this->_place_name = @$_POST['place-name'];
		} elseif (!empty($_GET['navigation'])) {
			$this->_place_name = @$_GET['place_name'];
		} elseif (!empty($this->_num)) {
			$this->_place_name = $this->_selected_event_info['place'];
		} elseif (!empty($this->_config['calendar']['place_default'])) {
			$this->_place_name = $this->_config['calendar']['place_default'];
		} elseif (!empty($this->_cookies['place_name'])) {
			$this->_place_name = $this->_cookies['place_name'];
		} else {
			$this->_place_name = $this->_get_geolocation();
			if (empty($this->_place_name)) $this->_place_name = 'tokyo';
		}
		if (!empty($this->_config['calendar']['place_list']) && is_array($this->_config['calendar']['place_list']) && !in_array($this->_place_name, $this->_config['calendar']['place_list'])) {
			if (!empty($this->_config['calendar']['place_default'])) {
				$this->_place_name = $this->_config['calendar']['place_default'];
			} else {
				$this->_place_name = $this->_config['calendar']['place_list'][0];
			}
		}
	}

	/**
	 *
	 * @return string
	 */
	private function _get_geolocation()
	{
		$region = "";
		//Set geolocation cookie
		if(!$_COOKIE["geolocation"])
		{
			//Load the class
			$ipLite = new ip2location_lite;
			$ipLite->setKey('04ba8ecc1a53f099cdbb3859d8290d9a9dced56a68f4db46e3231397d1dfa5e6');

			$visitorGeolocation = $ipLite->getCity($_SERVER['REMOTE_ADDR']); // test for osaka 125.2.111.125 or $_SERVER['REMOTE_ADDR'] (SENDAI 202.211.5.240 TOYAMA 202.95.177.129)

			// if no error
			if ($visitorGeolocation['statusCode'] == 'OK')
			{
				//if value exist
				if($visitorGeolocation['regionName'] != '-')
				{
					$region = $visitorGeolocation['regionName'];
				}
				else
					$region = 'TOKYO';
			}
			else
				$region = 'TOKYO';
			setcookie("geolocation", base64_encode($region), time()+60*30); //set cookie for 30minutes
		}
		else
		{
			$region = base64_decode($_COOKIE["geolocation"]);
		}

		return $this->_get_place($region);
	}

	/**
	 * navigationused確認
	 * @return int
	 */
	private function _get_navigation_used()
	{
		$navigation_used = 0;
		if (@$_GET['navigation']) {
			$navigation_used = 1;
		}
		if (isset($_POST['place-name']) && $_POST['navigation_used']) {
			$navigation_used = 1;
		}
		return $navigation_used;
	}

	/**
	 * 同時開催チェック
	 * @return mixed
	 */
	private function _checkdouji()
	{
		if (empty($_GET['douji']) || empty($_GET['num'])) return array();
		$doujiInfo = $this->_db->get_douji_info($this->_num);

		if (count($doujiInfo) >= 2) {
			return $doujiInfo;
		}
		return array();
	}

	/**
	 * エスケープ
	 * @param $variable
	 * @return string
	 */
	private function _secure($variable)
	{
		$variable = htmlentities(trim($variable), ENT_QUOTES, mb_internal_encoding());
		$variable = stripslashes(stripslashes($variable));
		return $variable;
	}

	/**
	 * 地域名を翻訳
	 * @param string $cityname
	 * @return mixed
	 */
	private function _translate_city($cityname = 'tokyo')
	{
		$info = $this->_db->get_place_info($cityname);
		return $info['name'];
	}

	/**
	 * get place
	 * @param $area
	 * @return string
	 */
	private function _get_place($area)
	{
		switch($area)
		{
			case 'FUKUSHIA':
				return 'tokyo';
				break;
			case 'TOCHIGI':
				return 'tokyo';
				break;
			case 'GUNMA':
				return 'tokyo';
				break;
			case 'SAITAMA':
				return 'tokyo';
				break;
			case 'IBATAKI':
				return 'tokyo';
				break;
			case 'YAMANASHI':
				return 'tokyo';
				break;
			case 'TOKYO':
				return 'tokyo';
				break;
			case 'CHIBA':
				return 'tokyo';
				break;
			case 'KANAGAWA':
				return 'tokyo';
				break;
			case 'NAGANO':
				return 'tokyo';
				break;
			case 'SHIZUOKA':
				return 'tokyo';
				break;
			case 'SHIGA':
				return 'osaka';
				break;
			case 'KYOTO':
				return 'osaka';
				break;
			case 'OSAKA':
				return 'osaka';
				break;
			case 'NARA':
				return 'osaka';
				break;
			case 'WAKAYAMA':
				return 'osaka';
				break;
			case 'HYOGO':
				return 'osaka';
				break;
			case 'OKAYAMA':
				return 'osaka';
				break;
			case 'TOTTORI':
				return 'osaka';
				break;
			case 'FUKUOKA':
				return 'fukuoka';
				break;
			case 'OITA':
				return 'fukuoka';
				break;
			case 'SAGA':
				return 'fukuoka';
				break;
			case 'NAGASAKI':
				return 'fukuoka';
				break;
			case 'KUMAMOTO':
				return 'fukuoka';
				break;
			case 'MIYAZAKI':
				return 'fukuoka';
				break;
			case 'KAGOSHIMA':
				return 'fukuoka';
				break;
			case 'OKINAWA':
				return 'okinawa';
				break;
			case 'MIYAGI':
				return 'sendai';
				break;
			case 'NAGOYA':
				return 'nagoya';
				break;
			case 'TOYAMA':
				return 'nagoya';
				break;
			case 'ISHIKAWA':
				return 'nagoya';
				break;
			case 'AICHI':
				return 'nagoya';
				break;
			case 'GIFU':
				return 'nagoya';
				break;
			case 'MIE':
				return 'nagoya';
				break;
			case 'FUKUI':
				return 'nagoya';
				break;
			default:
				return 'tokyo';
		}
	}
        public function getDate(){
            $date = $this->_db->get_event_info_for_hiduke($this->_num);
            $date = $date['place'].$date['yyy'].$date['mmm'].$date['ddd'];
            return $date;
        }
}

