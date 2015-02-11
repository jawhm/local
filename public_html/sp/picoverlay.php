<?php

	$img_path = "http://www.jawhm.or.jp".urldecode(@$_GET['base']);
	$over_path = "http://www.jawhm.or.jp".urldecode(@$_GET['over']);

	// JPEG?
	$img = @ImageCreateFromJPEG($img_path);
	if (!$img)	{
		// GIF?
		$img = @ImageCreateFromGIF($img_path);
	}
	if (!$img)	{
		// PNG?
		$img = @ImageCreateFromPNG($img_path);
	}
	if (!$img)	{
		$img_path = 'http://www.jawhm.or.jp/blog/images/tokyoblog_default.png';
		$img = @ImageCreateFromPNG($img_path);
		if (!$img)	{
			echo $img_path.'<br/>';
			echo "Can't read the picture.";
			exit;
		}
	}

	// オーバーレイ
	if (@$_GET['over'])	{
		// JPEG?
		$over = @ImageCreateFromJPEG($over_path);
		if (!$over)	{
			// GIF?
			$over = @ImageCreateFromGIF($over_path);
		}
		if (!$over)	{
			// PNG?
			$over = @ImageCreateFromPNG($over_path);
		}
		if (!$over)	{
			$over_path = 'http://www.jawhm.or.jp/blog/images/tokyoblog.png';
			$over = @ImageCreateFromPNG($over_path);
			if (!$over)	{
				echo $over_path.'<br/>';
				echo "Can't read the overlay picture.";
				exit;
			}
		}
	}

	$ix = ImageSX($img);    // 読み込んだ画像の横サイズを取得
	$iy = ImageSY($img);    // 読み込んだ画像の縦サイズを取得
	$ox = 193;
	$oy = 95;
	if (@$_GET['w'])	$ox = @$_GET['w'];
	if (@$_GET['h'])	$oy = @$_GET['h'];

	// 切り取り範囲計算
	if ($ix >= $ox)	{
		// 幅から合わせる
		$w = intval($ix / $ox * $ox);
		$h = intval($ix / $ox * $oy);
		$left = intval(($ix - $w) / 2);
		$top = intval(($iy - $h) / 2);
	}else{
		if ($iy >= $oy)	{
			// 高さから合わせる
			$w = intval($iy / $oy * $ox);
			$h = intval($iy / $oy * $oy);
			$left = intval(($ix - $w) / 2);
			$top = intval(($iy - $h) / 2);
		}else{
			// そのまま使う
			$w = $iy;
			$h = $ix;
			$top = 0;
			$left = 0;
		}
	}

	// サイズ変更後の画像データを生成
	$out = ImageCreateTrueColor($ox, $oy);
	ImageCopyResized($out, $img, 0, 0, $left, $top, $ox, $oy, $w, $h);
	if ($over)	{
		$ix = ImageSX($over);    // 読み込んだ画像の横サイズを取得
		$iy = ImageSY($over);    // 読み込んだ画像の縦サイズを取得
		ImageCopy($out, $over, 0, 0, 0, 0, $ix, $iy);
	}

	// 画像の表示
	header("Content-type: image/jpeg");
	header("Cache-control: no-cache");
	ImageJPEG($out);

	// メモリーの解放
	ImageDestroy($img);
	ImageDestroy($out);
	if ($over)	{
		ImageDestroy($over);
	}
	exit;

?>