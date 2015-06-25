<?php 
/*
 * Template name: seminar
 */
get_header();
$place = $_GET["place"];
$title = $_GET["title"];
if(strlen($place) == 0){
    $place = "tokyo";
}

function queryGen($place, $title){
    echo "?place=".$place."&title=".$title;
}
function getPref($place){
    if(!isset($place)){
        return '東京';
    }
    $pref = array(
        'tokyo' => '東京',
        'osaka' => '大阪',
        'nagoya' => '名古屋',
        'fukuoka' => '福岡',
        'okinawa' => '沖縄',
        'kyoto' => '京都',
        'omiya' => '大宮',
    );
    return $pref[$place];
}
function activePlace($compare, $place){
    if($compare != $place) echo "off";
}
function activeTitle($compare, $title){
    if($compare != $title || $compare == "") echo "off";
}

if(wp_is_mobile()){
    $config = array(
        'view_mode' => 'list',
        'start_date' => get_start_date(),
        'end_date' => get_end_date(),
        'list' => array(
            'place_default' => $place,
            'title' => $title,
            'count_field_active' => 'deactive',
        ),
    );
}else{
    $config = array(
        'start_date' => get_start_date(),
        'end_date' => get_end_date(),
        'view_mode' => 'calendar',
        'calendar' => array(
            'place_default' => $place,
            'title' => $title,
            'place_active' => 'deactive',
            'country_active' => 'deactive',
            'know_active' => 'deactive',
            'calendar_icon_active' => 'deactive',
            'count_field_active' => 'deactive',
            'calendar_title_active' => 'deactive',
            'calendar_desc_active' => 'deactive',
            'footer_desc_active' => 'deactive',
        )
    );
}
$sm = new SeminarModule($config);
?>

      <div class="underSec seminar">
      
        <div class="keyvisual seminar">
          <p>ワーキングホリデー＆留学フェアのセミナー一覧</p>
          <!--img src="images/icon_plane.png" alt="飛行機"-->
        </div><!-- /.keyvisual -->      
        
        <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
        <section class="normalBox">
          <h2 class="hukidashi">セミナースケジュール<span>SEMINAR SCHEDULE</span></h2> 
                             
          <div class="contentBox noPad">        
            <p class="planeText mgb20">
              <?php the_seminar_description() ?>
            </p><!-- /.planeText -->
            
            <div class="btnArea">
            	<p class="mgb10">お近くの会場をクリックしてください。</p>
              <ul>
                  <li><a class="tokyo <?php activePlace("tokyo", $place) ?>" href="<?php queryGen("tokyo", $title) ?>">東京会場</a></li>
                <li><a class="osaka <?php activePlace("osaka", $place) ?>" href="<?php queryGen("osaka", $title) ?>">大阪会場</a></li>
              </ul><!-- /.areaList -->
              <ul>
                <li><a class="nagoya <?php activePlace("nagoya", $place) ?>" href="<?php queryGen("nagoya", $title) ?>">名古屋会場</a></li>
                <li><a class="fukuoka <?php activePlace("fukuoka", $place) ?>" href="<?php queryGen("fukuoka", $title) ?>">福岡会場</a></li>
              </ul><!-- /.areaList -->
            </div><!-- /.btnArea -->
            <?php if(is_seminar_category_open()): ?>
            <div class="btnArea2">
            	<p class="mgb10">お好みのセミナーをクリックしてください。</p>
              <ul>
                  <li><a class="first <?php activeTitle("初心者", $title) ?>" href="<?php queryGen($place, "初心者") ?>">初心者セミナー</a></li>
                <li><a class="taiken <?php activeTitle("体験談", $title) ?>" href="<?php queryGen($place, "体験談") ?>">体験談セミナー</a></li>
              </ul><!-- /.areaList -->
              <ul>
                <li><a class="gogaku <?php activeTitle("語学学校", $title) ?>" href="<?php queryGen($place, "語学学校") ?>">語学学校セミナー</a></li>
                <li><a class="all <?php if(strlen($title) > 0) echo "off" ?>" href="<?php queryGen($place, "") ?>">全てのセミナー</a></li>
              </ul><!-- /.areaList -->
            </div><!-- /.btnArea -->
            <?php endif; ?>
            
            <section class="semListArea">            	
                <h3 class="spview"><?php echo getPref($place) ?>会場<span>の</span><?php echo $title ?>セミナー</h3>
              <div class="pcview clearfix">
              	<p class="left"><?php echo getPref($place) ?>会場</p>
                <p class="right"><?php echo (strlen($title) > 0)? $title : "全て" ?>のセミナー<span>を表示しています</span></p>
              </div>
              <?php $sm->show() ?> 
              <div class="btnShadow2 mgt30 spview"><a class="btn moreView" href=""><span>もっと見る</span></a></div>
            </section><!-- /.semListArea -->         
          </div><!-- /.contentBox -->         
        </section><!-- /.normalBpx -->
      </div><!-- /.underSec -->
      
      <section class="normalBox footSec">      	
	<?php get_footer() ?>