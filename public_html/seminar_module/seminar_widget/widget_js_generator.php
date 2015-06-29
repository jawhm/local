<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Access-Control-Allow-Origin:*');//全ドメイン許可する場合 
header("Content-type: application/x-javascript");
require_once 'simple_html_dom.php';

error_reporting(E_ALL & ~E_NOTICE);
include '../seminar_module.php';

//スマホ画面で予約ボタンをおした時のjavascript関数
echo '
    function yoyaku_jump(addr){
        if(window.confirm("ワーホリのサイトに飛びます。\nよろしいですか？")){
           document.location = "http://"+addr;
        }
    }
    widget_config["use_mode"] = "widget";
';

$config = array(
    'view_mode' => $_GET['viewmode'],
    'seminar_id' => $_GET['id']
    //'seminar_id' => '9675' //この時点でIDを渡さないと機能しないようだ
);

$sm = new SeminarModule($config);

echo 'var node = document.getElementById("widget");';

if($config['view_mode'] === 'calendar'){
    echo '
        jQuery(document).ready(function() {
            jQuery(".open").live("click", function(){
                jQuery(this).next(".det").slideToggle("slow");
            });
        });
';
}
$html = str_get_html($sm->get_add_js());
foreach ($html->find('script') as $script_tag) {
    echo $script_tag->innertext;
}
echo '
function show(){
    if(window.innerWidth < parseInt(widget_config["minimum_width"], 10)) widget_config["view_mode"] = "list";
    var config_jsonstr = JSON.stringify(widget_config);
    $.ajax({
        async: false,
        type:"POST",
        url:"http://'.$_SERVER['SERVER_NAME'].'/seminar_module/seminar_widget/seminar_widget.php"+window.location.search,
        data:{config_json:config_jsonstr},
        success:function(msg){
            var node = document.getElementById("widget");
            node.innerHTML = node.innerHTML + msg;
        }
    });
}
show();
';

echo '
    if(widget_config["seminar_id"] != null){
        if(widget_config["seminar_id"].length > 0){
            jQuery(function(){
                $("#'.$sm->getDate().'", ".blockUI.blockMsg.blockPage").css("display", "block");
            });
        }
    }
';


