<?php
	//会員顔写真表示
	//max width=320 height=320
	//引数： $zs_kaiin_img_kaiin_no （会員番号）
	
	$zs_kaiin_img = './' . $dir_kaiin_img . '/' . $zs_kaiin_img_kaiin_no . '.jpeg';	//会員顔写真
	if( file_exists($zs_kaiin_img) ) {
		//写真が見つかった
		$imglist = getimagesize( $zs_kaiin_img );
		$img_width = $imglist[0];
		$img_height = $imglist[1];
		$img_type = $imglist[2];
		$edit_size = $imglist[3];
		if( $img_width > 320 && $img_height > 320 ){
			if( $img_width > $img_height ){
				$edit_size = 'width="320"';
			}else{
				$edit_size = 'height="320"';
			}
		}else if( $img_width > 320 && $img_height <= 320 ){
			$edit_size = 'width="320"';
		}else if( $img_width <= 320 && $img_height > 320 ){
			$edit_size = 'height="320"';
		}
		$zs_kaiin_img .= '?' . $now_time;	//キャッシュ画像を表示させないため
		print('<img src=' . $zs_kaiin_img . ' ' . $edit_size . '>');
	}else{
		//写真が見つからない
		print('<img src="./img_' . $lang_cd . '/kaiin_img_nothing_320x240.png" border="0">');
	}

?>