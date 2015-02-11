<?php

//ini_set( "display_errors", "On");

require_once('../seminar/jp-holiday.php');
include ('../seminar/include/function.php');


	session_start();

	mb_language("Ja");
	mb_internal_encoding("utf8");
	
	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];
	
	// 状態確認
	if ($mem_id <> '')	
	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
			$stt->bindValue(':id', $mem_id);
			$stt->execute();
			$mem_namae = '';
			$mem_furigana = '';
			$mem_tel = '';
			$mem_email = '';
			$mem_country = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$mem_email = $row['email'];
				$mem_namae = $row['namae'];
				$mem_furigana = $row['furigana'];
				$mem_tel = $row['tel'];
				$mem_country = $row['country'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

?>


<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
		//jQuery(this).slideToggle("hide");
	});
});

</script>
<?php

///////////////////////////////////
/// FUNCTION CALENDAR DISPLAY  ////
///////////////////////////////////
function calendar_display($place_name, $yy, $mm)
{
	// translate name in japanese
	$placename_in_japanese = translate_city($place_name);
	
	$where_place = ' and place=\''.$place_name.'\' '; 

	if ($place_name == 'fukuoka')	{
		$where_place = ' and ( place=\''.$place_name.'\' or ( place=\'event\' and k_title1 like \'%福岡%\' )) '; 
	}
	$keyword = $where_place.' and k_desc1 like \'%秋の留学・ワーキングホリデーフェア2012%\'';
	
	$navigation_used = 2; //this paremeter will make the page act same as using the navigation bar in the seminar page, BUT will not display the navigation bar.
	
	//get list of days
	get_days_list ($place_name,$keyword);

?>
<?php
	
	//Display calendar
	calender_show($yy,$mm,$placename_in_japanese, $place_name, $keyword, '', '', $navigation_used);
	

?>
<?php
	
	//Next calendar
	
	//calender_show($yy,$mm,$placename_in_japanese2, $place_name2, $keyword, $checked_countryname, $checked_know, $navigation_used, $selected_day);
	

?>
&nbsp;<br/>


<?php	
		echo '<div id="list_calendar_display">';
		
			calender_list($yy,$mm,$place_name);
			
		echo '</div>';
		
}//END FUNCTION
?>