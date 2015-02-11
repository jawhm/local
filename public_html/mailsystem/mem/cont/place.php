<?php

// 一般メニュー読み込み
require 'php/fnc_menu.php';

set_time_limit(0);

if (count($param) > 2) {
	$data_param = $param[2];
} else {
	$data_param = 'main';
}

switch ($data_param) {
	case "main":
		$msg = "";
		$msg .= "ここは地域管理ページです。";
		$msg .= "<br>";
		$msg .= '<a href="' . $url_base . 'main/place/new">新規登録</a>';

		$msg .= '<table class="listdata">';
		$msg .= '<tr>';
		$msg .= '<th>ID</th>';
		$msg .= '<th>開催地ID</th>';
		$msg .= '<th>開催地名</th>';
		$msg .= '<th>所属エリア</th>';
		$msg .= '<th>メイン／サブ</th>';
		$msg .= '<th>タイトル検索</th>';
		$msg .= '<th>有効／無効</th>';
		$msg .= '<th>編集</th>';
		$msg .= '</tr>';
		try {
			$statement = $db->prepare('select * from place order by `order`');
			$statement->execute();
			while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				$id = $row['id'];
				$place = $row['place'];
				$name = $row['name'];
				$area = $row['area'];
				$inmain = $row['inmain'];
				$searchplus = $row['searchplus'];
				$searchplusstr = (empty($searchplus)) ? '-' : 'オン';
				$inuse = $row['inuse'];
				$inmainstr = (empty($inmain)) ? 'サブ' : 'メイン';
				$inusestr = (empty($inuse)) ? '無効' : '有効';
				$msg .= '<tr>';
				$msg .= '<td>' . $id . '</td>';
				$msg .= '<td>' . $place . '</td>';
				$msg .= '<td>' . $name . '</td>';
				$msg .= '<td>' . $area . '</td>';
				$msg .= '<td>' . $inmainstr . '</td>';
				$msg .= '<td>' . $searchplusstr . '</td>';
				$msg .= '<td>' . $inusestr . '</td>';
				$msg .= '<td><a href="' . $url_base . 'main/place/edit/' . $id . '"><input type="button" class="button_save" value=" 編集" /></a></td>';
				$msg .= '</tr>';

			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$msg .= '</table>';

		$body_title[] = '地域管理';
		$body[] = $msg;
		break;
	case 'new':
	case 'edit':
		$msg = $subtitle = $id = $place = $name = $area = $searchplus = $inmain = $inuse = $order = "";

		$type   = fnc_getpost('type');
		$id     = fnc_getpost('id');
		$place  = fnc_getpost('place');
		$name   = fnc_getpost('name');
		$area   = fnc_getpost('area');
		$inmain = fnc_getpost('inmain');
		$searchplus = fnc_getpost('searchplus');
		$inuse  = fnc_getpost('inuse');
		$order  = fnc_getpost('order');

		$pid = (empty($param[3])) ? '' : $param[3];
		$statement = $db->prepare('select * from place where id = :id');
		$statement->bindValue(':id', $pid);
		$statement->execute();
		if ($statement->rowCount() == 0) {
			$subtitle = '新規登録';
			$type = 'new';
		} else {
			$subtitle = '編集';
			$type = 'edit';
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				$id     = (empty($id)) ? $row['id'] : $id;
				$place  = (empty($place)) ? $row['place'] : $place;
				$name   = (empty($name)) ? $row['name'] : $name;
				$area   = (empty($area)) ? $row['area'] : $area;
				$inmain = (empty($inmain)) ? $row['inmain'] : $inmain;
				$searchplus = (empty($searchplus)) ? $row['searchplus'] : $searchplus;
				$searchplusstr = (empty($searchplus)) ? '-' : 'オン';
				$inuse  = (empty($inuse)) ? $row['inuse'] : $inuse;
				$order  = (empty($order)) ? $row['order'] : $order;
				$inmainstr = (empty($inmain)) ? 'サブ' : 'メイン';
				$inusestr  = (empty($inuse)) ? '無効' : '有効';
			}
		}
		$msg .= $subtitle . 'します。<br>';
		$msg .= '<a href="' . $url_base . 'main/place">戻る</a>';

		$msg .= '<form action="' . $url_base . 'main/place/confirm" method="POST">';
		$msg .= get_place_table($id, $place, $name, $area, $inmain, $searchplus, $inuse, $order);
		$msg .= '<input type="hidden" name="type" value="' . $type . '" />';
		$msg .= '<input type="hidden" name="id" value="' . $id . '" />';
		$msg .= '<input type="submit" class="button_submit" value="確認" id="placesubmit" />';
		$msg .= '</form>';

		$body_title[] = '地域管理 - ' . $subtitle;
		$body[] = $msg;
		break;

	case 'confirm':

		$msg = "";
		$type   = fnc_getpost('type');
		$id     = fnc_getpost('id');
		$place  = fnc_getpost('place');
		$name   = fnc_getpost('name');
		$area   = fnc_getpost('area');
		$inmain = fnc_getpost('inmain');
		$searchplus = fnc_getpost('searchplus');
		$inuse  = fnc_getpost('inuse');
		$order  = fnc_getpost('order');

		$errors = array();
		if ($type !== 'new' && $type !== 'edit') {
			$errors['type'] = '予期せぬエラーが発生しました。もう一度最初からお試し下さい。';
		}
		$subtitle = '新規登録';
		if ($type == 'edit') {
			$subtitle = '編集';
			$statement = $db->prepare('select * from place where id = :id');
			$statement->bindValue(':id', $id);
			$statement->execute();
			if ($statement->rowCount() == 0) {
				$errors['id'] = 'IDが正しくありません。もう一度最初からお試し下さい。';
			}
		}

		if (empty($place)) {
			$errors['place'] = '「開催地ID」を入力して下さい。';
		}
		if (empty($name)) {
			$errors['name'] = '「開催地名」を入力して下さい。';
		}
		if (empty($area)) {
			$errors['area'] = '「所属エリア名」を入力して下さい。';
		}

		$maxlen = 100;
		if (mb_strlen($place) > $maxlen) {
			$errors['place'] = '「開催地ID」が長過ぎます。';
		}
		if (mb_strlen($name) > $maxlen) {
			$errors['name'] = '「開催地名」が長過ぎます。';
		}
		if (mb_strlen($area) > $maxlen) {
			$errors['area'] = '「所属エリア名」が長過ぎます。';
		}

		if (empty($searchplus)) $searchplus = '0';
		if (empty($inmain)) $inmain = '0';
		if (empty($inuse))  $inuse  = '0';
		if (empty($order))  $order  = '999';

		if ($inmain !== '0' && $inmain !== '1' && $inmain !== 0 && $inmain !== 1) {
			$errors['inmain'] = '「メイン／サブ」には、0か1を入力して下さい。';
		}
		if ($inuse !== '0' && $inuse !== '1' && $inuse !== 0 && $inuse !== 1) {
			$errors['inuse'] = '「有効／無効」には、0か1を入力して下さい。';
		}
		if (!preg_match("/^[0-9]+$/",$order)) {
			$errors['order'] = '「表示順」には、数字を入力して下さい。';
		}

		if (!empty($errors)) {
			$msg .= $subtitle . 'します。<br>';
			$msg .= '<a href="' . $url_base . 'main/place">戻る</a>';
			foreach ($errors as $e) {
				$msg .= '<p style="color: red;">' . $e . '</p>';
			}
			$msg .= '<form action="' . $url_base . 'main/place/confirm" method="POST">';
			$msg .= get_place_table($id, $place, $name, $area, $inmain, $searchplus, $inuse, $order);
			$msg .= '<input type="hidden" name="type" value="' . $type . '" />';
			$msg .= '<input type="hidden" name="id" value="' . $id . '" />';
			$msg .= '<input type="submit" class="button_submit" value="確認" id="placesubmit" />';
			$msg .= '</form>';
			$body_title[] = '地域管理 - ' . $subtitle;
			$body[] = $msg;
		} else {
			$msg .= '以下の内容で登録します。<br>よろしいですか？';
			$msg .= '<form action="' . $url_base . 'main/place/complete" method="POST" name="confirm_form">';
			$msg .= '<table class="listdata">';
			$msg .= '<tr><th>ID</th><td>' . $id . '</td></tr>';
			$msg .= '<tr><th>開催地ID</th><td>' . $place . '</td></tr>';
			$msg .= '<tr><th>開催地名</th><td>' . $name . '</td></tr>';
			$msg .= '<tr><th>所属エリア</th><td>' . $area . '</td></tr>';
			$msg .= '<tr><th>メイン／サブ</th><td>' . $inmain . '</td></tr>';
			$msg .= '<tr><th>タイトル検索</th><td>' . $searchplus . '</td></tr>';
			$msg .= '<tr><th>有効／無効</th><td>' . $inuse . '</td></tr>';
			$msg .= '<tr><th>表示順</th><td>' . $order . '</td></tr>';
			$msg .= '</table>';
			$msg .= '<input type="hidden" name="type" value="' . $type . '" />';
			$msg .= '<input type="hidden" name="id" value="' . $id . '" />';
			$msg .= '<input type="hidden" name="place" value="' . $place . '" />';
			$msg .= '<input type="hidden" name="name" value="' . $name . '" />';
			$msg .= '<input type="hidden" name="area" value="' . $area . '" />';
			$msg .= '<input type="hidden" name="inmain" value="' . $inmain . '" />';
			$msg .= '<input type="hidden" name="searchplus" value="' . $searchplus . '" />';
			$msg .= '<input type="hidden" name="inuse" value="' . $inuse . '" />';
			$msg .= '<input type="hidden" name="order" value="' . $order . '" />';
			$msg .= '<input type="button" class="button_cancel" value="戻る" onclick="document.confirm_form.action=\'' . $url_base . 'main/place/edit/' . $id . '\';document.confirm_form.submit();">';
			$msg .= '<input type="submit" class="button_submit" value="送信" onclick="document.confirm_form.action=\'' . $url_base . 'main/place/complete\';document.confirm_form.submit();" />';
			$msg .= '</form>';
			$body_title[] = '地域管理 - ' . $subtitle;
			$body[] = $msg;
		}

		break;
	case 'complete':

		$msg = "";
		$type   = fnc_getpost('type');
		$id     = fnc_getpost('id');
		$place  = fnc_getpost('place');
		$name   = fnc_getpost('name');
		$area   = fnc_getpost('area');
		$inmain = fnc_getpost('inmain');
		$searchplus = fnc_getpost('searchplus');
		$inuse  = fnc_getpost('inuse');
		$order  = fnc_getpost('order');

		$subtitle = "";
		try {
			if ($type == 'new') {
				$subtitle = '新規登録';
				$sql  = 'insert into place (`place`, `name`, `area`, `inmain`, `searchplus`, `inuse`, `order`, `insdate`) ';
				$sql .= 'values ';
				$sql .= '(:place, :name, :area, :inmain, :searchplus, :inuse, :order, :insdate);';
				$statement = $db->prepare($sql);
				$statement->bindValue(':place',  $place);
				$statement->bindValue(':name',   $name);
				$statement->bindValue(':area',   $area);
				$statement->bindValue(':inmain', $inmain);
				$statement->bindValue(':searchplus', $searchplus);
				$statement->bindValue(':inuse',  $inuse);
				$statement->bindValue(':order',  $order);
				$statement->bindValue(':insdate', date('Y-m-d H:i:s'));
				$statement->execute();
			} elseif ($type == 'edit') {
				$subtitle = '編集';
				$sql  = 'update place set ';
				$sql .= '`place`  = :place, ';
				$sql .= '`name`   = :name, ';
				$sql .= '`area`   = :area, ';
				$sql .= '`inmain` = :inmain, ';
				$sql .= '`searchplus` = :searchplus, ';
				$sql .= '`inuse`  = :inuse, ';
				$sql .= '`order`  = :order, ';
				$sql .= '`upddate`  = :upddate ';
				$sql .= ' where `id` = :id';
				$statement = $db->prepare($sql);
				$statement->bindValue(':place',  $place);
				$statement->bindValue(':name',   $name);
				$statement->bindValue(':area',   $area);
				$statement->bindValue(':inmain', $inmain);
				$statement->bindValue(':searchplus', $searchplus);
				$statement->bindValue(':inuse',  $inuse);
				$statement->bindValue(':order',  $order);
				$statement->bindValue(':upddate', date('Y-m-d H:i:s'));
				$statement->bindValue(':id',     $id);
				$statement->execute();
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg = $subtitle. '完了しました。<br>地域管理へ<a href="' . $url_base . 'main/place">戻る</a>';
		$body_title[] = '地域管理 - ' . $subtitle . '完了しました。';
		$body[] = $msg;
		break;
	default :
}

function get_place_table ($id, $place, $name, $area, $inmain, $searchplus, $inuse, $order)
{
	$msg = "";
	$msg .= '<table class="listdata">';

	$msg .= '<tr>';
	$msg .= '<th>ID</th>';
	$msg .= '<td>' . $id . '</td>';
	$msg .= '<td style="font-size: 11px;">自動採番されます。</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>開催地ID</th>';
	$msg .= '<td><input type="text" name="place" value="' . $place . '" /></td>';
	$msg .= '<td style="font-size: 11px;">ユニークなIDを指定してください。（例：tokyo）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>開催地名</th>';
	$msg .= '<td><input type="text" name="name" value="' . $name . '" /></td>';
	$msg .= '<td style="font-size: 11px;">日本語で入力してください。（例：東京）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>所属エリア</th>';
	$msg .= '<td><input type="text" name="area" value="' . $area . '" /></td>';
	$msg .= '<td style="font-size: 11px;">所属するエリアがある場合は、開催地IDを入力してください。（例：tokyo）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>メイン／サブ</th>';
	$msg .= '<td><input type="text" name="inmain" value="' . $inmain . '" /></td>';
	$msg .= '<td style="font-size: 11px;">「0」か「1」を指定してください。（0：サブ　1：メイン）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>タイトル検索</th>';
	$msg .= '<td><input type="text" name="searchplus" value="' . $searchplus . '" /></td>';
	$msg .= '<td style="font-size: 11px;">「0」か「1」を指定してください。（0：無効　1：有効）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>有効／無効</th>';
	$msg .= '<td><input type="text" name="inuse" value="' . $inuse . '" /></td>';
	$msg .= '<td style="font-size: 11px;">「0」か「1」を指定してください。（0：無効　1：有効）</td>';
	$msg .= '</tr>';

	$msg .= '<tr>';
	$msg .= '<th>表示順</th>';
	$msg .= '<td><input type="text" name="order" value="' . $order . '" /></td>';
	$msg .= '<td style="font-size: 11px;">数字を入力してください、昇順に並びます。</td>';
	$msg .= '</tr>';

	$msg .= '</table>';

	return $msg;
}