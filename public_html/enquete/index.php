<?php
require_once '../include/header.php';

$header_obj = new Header();

if ($header_obj->computer_use() === false) {
	header('Location: https://docs.google.com/forms/d/1en4qmWkTN8qFdv831LwJLlemMlIx9KwAftvdTqOO8Kk/viewform?usp=send_form');
	exit;
}

$header_obj->title_page='ワーキングホリデー 体験談アンケート';
$header_obj->description_page='ワーキングホリデー（ワーホリ）　体験談アンケート';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/visa-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ワーキングホリデー（ワーホリ）　体験談アンケート';

//add javascript for country info
$header_obj->add_js_files='
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--[if IE]><script type="text/javascript" src="/country/country_info/js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="/country/country_info/js/coolclock.js"></script>
<script type="text/javascript" src="/country/country_info/js/moreskins.js"></script>
<script type="text/javascript" src="/country/country_info/js/map.js"></script>';

$header_obj->add_css_files='<link rel="stylesheet" href="/country/country_info/style.css" type="text/css" />';
$header_obj->add_style='
<style type="text/css">

.messagepop {
  position:absolute;
  float:left;
  bottom:5px;
  left:5px;
  display:none;

  padding:10px;

  background-color:#FFFFFF;
  border:1px solid #999999;
  cursor:default;
  text-align:left;
  width:auto;
  z-index:50;
}
#interactive-map{
  position:relative;
  margin-bottom:30px;
}
</style>';

$header_obj->display_header();
include('../calendar_module/mod_event_horizontal.php');
?>

	<div id="maincontent">
       <?php echo $header_obj->breadcrumbs(); ?>
	  
	  <h2 class="sec-title">ワーキングホリデー 体験談アンケート</h2>

        <iframe src="https://docs.google.com/forms/d/1en4qmWkTN8qFdv831LwJLlemMlIx9KwAftvdTqOO8Kk/viewform?embedded=true" width="680" height="3500" frameborder="0" marginheight="0" marginwidth="0">読み込み中...</iframe>

	  <div class="top-move">
	    <p><a href="#header">▲ページのＴＯＰへ</a></p>
	  </div>

  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>