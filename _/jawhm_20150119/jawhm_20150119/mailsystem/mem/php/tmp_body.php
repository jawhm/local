<?php

	require_once 'php/tmp_header.php';

	if ($body_style == 'normal')	{
		// 通常ページ
?>
	<div id="window">
		<div id="windowTop">
			<div id="windowTopContent">顧客検索</div>
				<img src="'.$url_base.'images/window_min.jpg" id="windowMin" alt="" />
				<img src="'.$url_base.'images/window_max.jpg" id="windowMax" alt="" />
				<img src="'.$url_base.'images/window_close.jpg" id="windowClose" alt="" />
			</div>
			<div id="windowBottom">
			<div id="windowBottomContent"></div>
		</div>
		<div id="windowContent">
			<p>
				ここにポップアップウィンドウのコンテンツを記述します・・・
			</p>
		</div>
		<img src="'.$url_base.'images/window_resize.gif" id="windowResize" alt="" />
	</div>

	<center>
<!--
		<div class="div_topmenu">
		</div>
-->
<?php
		if ($notice <> '')	{
?>
		<div class="div_notice"><?php echo $notice; ?></div>
<?php
		}
?>

		<table>
			<tr style="vertical-align:top;">
<?php
			if ($menu_style == 'normal')	{
?>
				<td>
					<div class="div_sidemenu">
<?php
				for ($idx=1; $idx<count($menu); $idx++)	{
					print '<div class="menu_title">'.$menu_title[$idx].'</div>';
					print '<div class="menu_main">'.$menu[$idx].'</div>';
				}
?>
					</div>
				</td>
				<td>
					<div class="div_main">
<?php
				for ($idx=1; $idx<count($body); $idx++)	{
					print '<div class="cont_title">'.$body_title[$idx].'</div>';
					print '<div class="cont_main">'.$body[$idx].'</div>';
				}
?>
				</div>
			</td>
<?php
			}else{
?>
				<td>
					<div class="div_main_wide">
<?php
				for ($idx=1; $idx<count($body); $idx++)	{
					print '<div class="cont_title">'.$body_title[$idx].'</div>';
					print '<div class="cont_main">'.$body[$idx].'</div>';
				}
?>
				</div>
			</td>
<?php
			}
?>
			</tr>
		</table>
	</center>


<?php
	}
	if ($body_style == 'login')		{
		// ログインページ
		print '<center>';
		print $body[0];
		print '</center>';
	}

	require_once 'php/tmp_footer.php';

?>