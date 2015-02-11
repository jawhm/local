<?php @session_start();
	/**
	 * Define MyClass
	 */
	class Header
	{
		//set variable - parameters	
		
		public $title_page;	// title of the page
		public $description_page; // description meta
		public $keywords_page = 'ワーキングホリデー,ワーホリ,日本ワーキングホリデー協会,ワーホリ協会,留学,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';	// keywords meta by default
		
		public $no_cache=false;	//output no-cache meta
		public $add_js_files;	//add more javascript files or script
		public $add_css_files;	//add more css files
		public $add_style;		//add written css styles into the page
		
		public $size_content_page; 			// set to 'big' to use bigger format such as seminar page
		public $no_standard_template=false;	// page without standard template, for example : use for video such as semi/index.php page (set false by default)
		
		public $fncMenuHead_imghtml;	// Top image of the page
		public $fncMenuHead_h1text = '';// text to display on the top of the logo	
		public $fncMenuHead_link = '';	// use link or not for the top of the page (set parameter to 'nolink' if needed)
		
		public $fncMenubar_function = true; 	// display left bar on the page, set True by default
		public $fncMenubar_msg = ''; 			// display message on the bottom of the bar

//		public $fncMenubar_advertisement = array(122,123,124,125,30,31); 	// advertisement to display
		// 【注意】
		// １件目：メンバー登録ページ、２件目以降：左サイドバー（TOPページはindex.html内で再定義）
		public $fncMenubar_advertisement = array(122,123,124,125,31); 	// advertisement to display
		
		public $fncFacebookMeta_function = true; 	// use facebookMeta function or not, set True by default
		
		public $frontpage = false;   //are we displaying the frontpage ?
		public $footer_type;		 //footer type to display
		
		public $mobilepage = false;	  //display mobile format
		public $mobileredirect = '';  //Redirection to special mobilepage if needed
		public $pcredirect = '';	  //Redirection to some pc page;
		public $pcmobile_type = false;//Page displaying the same way either on pc or mobile device
		
		public $tablet_type = false;  //is using tablet
		
		public $debug_mobile_page = false;  //To be able to see mobile page on pc device
		
		public $onload; //body onload
		public $iscrollEvent; //Event for mobile device
		public $js_settings_beforeIscroll; //javascript settings before Iscroll settings

		public function __construct(){}
	
		public function __destruct(){}

		public function display_header()
		{
			require_once($this->path());
			require_once (PATH.'include/menubar.php');				
			require_once(PATH.'include/Mobile_Detect.php');
			
			$detect = new Mobile_Detect();
			
			//switch view pc/mobile
			if(isset($_POST['pc']))
				$_SESSION['pc'] = $_POST['pc'];

			
			//if the page allow different display
			//check device to display right page
			if (($this->computer_use() === false && $_SESSION['pc'] != 'on' && $this->pcmobile_type === false)|| $this->debug_mobile_page)
			{
					$this->mobilepage=true;
					if($this->footer_type == 'nolink')
						$this->footer_type = 'nolinkmobile';
					else
						$this->footer_type = 'mobile';
									
					if ($this->mobileredirect != '')
					{
						header('location:'.$this->mobileredirect);
						exit;
					}
						
					if($detect->isTablet())
						$this->tablet_type=true;

			}
			elseif($this->pcredirect != '' && !$this->debug_mobile_page )
			{
				header('location:'.$this->pcredirect);
				exit;
			}
	
			echo '<!DOCTYPE html>
<head>';
			
			if($this->mobilepage && $_SESSION['pc'] != 'on') //allow to see the fullpage while navigating in PCview on mobile device
				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
			
			echo '
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
';
			
			if ($this->no_cache)	{
echo '<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
';
}
			if($this->fncFacebookMeta_function !== false && $this->mobilepage === false)
fncFacebookMeta();
							
			echo'<title>'.$this->complete_page_title($this->title_page).'</title>
<meta name="keywords" content="'.$this->keywords_page.'" />
<meta name="description" content="'.$this->description_page.'" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="dcterms.rightsHolder" content="Japan Association for Working Holiday Makers" />
<link href="mailto:info@jawhm.or.jp" rel="help" title="Information contact"  />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />
<link rel="index" href="/index.html"  type="text/html" title="日本ワーキングホリデー協会" />';
			
			//display css files
			echo $this->add_css_files;
			
			/*** Use different css/js files  for mobile display and pc display ***/
			if($this->mobilepage === false)
			{
				echo '
<link href="/css/base.css" rel="stylesheet" type="text/css" />
<link href="/css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="/css/contents.css" rel="stylesheet" type="text/css" />';
				
				if($this->size_content_page == 'big')
				{
					echo '
<link href="/css/seminar-contents.css" rel="stylesheet" type="text/css" />
<link href="/css/seminar-headhootg-nav.css" rel="stylesheet" type="text/css" />';
				}
			
				echo'	
<link href="/css/menu.css" rel="stylesheet" type="text/css" />
<link href="/js/feedback/contactable.css" rel="stylesheet" type="text/css" />';

//				echo'
//<script type="text/javascript" src="https://www.taglog.jp/taglog-aio.js"></script>
//<script type="text/javascript">
//	taglog.init("https://www.jawhm.or.jp/");
//	taglog.loadingTimeMonitor.start();
//</script>';
			
				//check if another jquery.js file has been added, If yes, we don't use the one by default.
				$check_js_file = strpos($this->add_js_files, 'jquery.js');
				if ($check_js_file === false)
				{
					echo'
<script src="/js/jquery.js" type="text/javascript"></script>';
				}
							
				echo'
<script src="/js/jquery-easing.js" type="text/javascript"></script>
<script src="/js/scroll.js" type="text/javascript"></script>
<script src="/js/img-rollover.js" type="text/javascript"></script>';
			
			}
			else
			{
				echo '
				<link href="/css/menu_mobile.css" rel="stylesheet" type="text/css" />
				<link href="/css/base_mobile.css" rel="stylesheet" type="text/css" />
				<script src="/js/jquery.js" type="text/javascript"></script>
				<script src="/js/iscroll.js" type="text/javascript"></script>
				<script type="text/javascript">
				var myScroll;
				
				'.$this->js_settings_beforeIscroll.'

				function loaded() {
					myScroll = new iScroll("contentsbox", { 
					
															useTransition:true, 
															zoom:true,';
												//if($this->frontpage) //allow refreshing scroll for the homepage because of the rss feed
												//REFRESH FOR ALL PAGE TO GET FULL CONTENT, BUG WITH FLOAT
													  echo 'checkDOMChanges: true,';
												
												if(!empty($this->iscrollEvent)) //Add event to Iscroll
													  echo $this->iscrollEvent.',';
													  
													  echo 'onBeforeScrollStart: function (e) {

																		var target = e.target;
																		while (target.nodeType != 1) target = target.parentNode;
																		
																		if (target.tagName != "SELECT" && target.tagName != "INPUT" && target.tagName != "TEXTAREA")
																		e.preventDefault();
																								}
															});
				}
						
				document.addEventListener("touchmove", function (e) {e.preventDefault();}, false);
				
				/* * * * * * * *
				 *
				 * Use this for high compatibility (iDevice + Android)
				 *
				 */
				document.addEventListener("DOMContentLoaded", function () { setTimeout(loaded(), 200); }, false);
				/*
				 * * * * * * * */
						
				</script>
				<script type="text/javascript">
					
					
					/**** scroll to hyperlink ****/
				
					/** while accessing new page with hash (#)
					*
					***/
										
						
					$(document).ready(function() {
						
						var url = window.location.href;
														

						if(url.indexOf(\'#\') != -1) {
							var num = url.indexOf(\'#\');
							var str = url.substring(num);

							document.location.hash = "page";
						
							window.onhashchange = function(e) {
								//alert("str"+str);
								myScroll.scrollToElement(str, "1s");
							};
						}
					}); 
													
					/** while clicking on anchor link
					*
					***/
					
					$(function() {
						$(\'a[href*=#]\').click(function(){

						　　if (location.pathname.replace(/^\//,\'\') ==　this.pathname.replace(/^\//,\'\') && location.hostname == this.hostname) 
							{
								var hyperlink = $(this).attr("href");
								myScroll.scrollToElement(hyperlink, "1s");
							　　return false;
						　　}
						});
					});
					
					function fnc_logout()	
					{
						if (confirm("ログアウトしますか？"))	
						{
							location.href = "/member/logout.php";
						}
					}
				</script>
				';
			}
			
			echo '<script src="/js/google-analytics.js" type="text/javascript"></script>';

			
			//display js files
			echo $this->add_js_files;
			
			//Module calendar css
			echo '
<link rel="stylesheet" href="/calendar_module/css/cal_module.css" />

<!--[if lte IE 8 ]>
	<link rel="stylesheet" href="/calendar_module/css/cal_module_ie.css" />
<![endif]-->
				';
			if($this->mobilepage !== false) //mobile css width for calendar module
				echo '
<link rel="stylesheet" href="/calendar_module/css/cal_module_mobile.css" />';

			//style into page	
			echo $this->add_style;
			
			if(!empty($this->onload)){
				$body_onload = ' onload="'.$this->onload.'"';
			}else{
				$body_onload = '';
			}
			echo'
</head>
<body'.$body_onload.'>
			';
			
			//use standard template
			if($this->no_standard_template === false)
			{
				if($this->mobilepage  === false)
				{
					fncMenuHead($this->fncMenuHead_imghtml,$this->fncMenuHead_h1text,$this->fncMenuHead_link);
				
					echo'
					<div id="contentsbox">
						<div id="contentsbox-top">
							<div id="contentsbox-top-left">
								<div id="contentsbox-top-right"> </div>
							</div>
							
						</div>
					';
					
					if($this->fncMenubar_function !== false)  				
					{
						echo'
						<div id="contents">';
						fncMenubar($this->fncMenubar_msg,$this->fncMenubar_advertisement);
					}
					else
						echo'
						<div id="contentswide">';
					
				}
				else
				{
					echo'
						<div id="contentsbox">
						<div id="wrap-box">
							<div id="contents">
								<div id="switch-btn">';
					
					//display logout button			
					if($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1)
					echo'				<div id="btn-logout"><input type="button" value="ログアウト" onClick="fnc_logout();"></div>';
					
					echo'				<form name="change_view" method="POST" action="">
										<input type="hidden" name="pc" value="on" />
										<div id="btn-for-pc"><input type="submit" value="PC view" /></div>
									</form>
								</div>
								<div id="header-box">
									<a href="/"><h1 id="header">'.$this->fncMenuHead_h1text.'</h1></a>
								</div>
						';
							
					if($this->frontpage)
						fncMenubar($this->fncMenubar_msg,$this->fncMenubar_advertisement);

				}
				
			}

		}

		public function display_header_forblog()
		{
			require_once($this->path());
			require_once (PATH.'include/menubar.php');				
			require_once(PATH.'include/Mobile_Detect.php');
			
			$detect = new Mobile_Detect();
			
			//switch view pc/mobile
			if(isset($_POST['pc']))
				$_SESSION['pc'] = $_POST['pc'];

			//if the page allow different display
			//check device to display right page
			if (($this->computer_use() === false && $_SESSION['pc'] != 'on' && $this->pcmobile_type === false)|| $this->debug_mobile_page)
			{
					$this->mobilepage=true;
					if($this->footer_type == 'nolink')
						$this->footer_type = 'nolinkmobile';
					else
						$this->footer_type = 'mobile';
									
					if ($this->mobileredirect != '')
					{
						header('location:'.$this->mobileredirect);
						exit;
					}
						
					if($detect->isTablet())
						$this->tablet_type=true;

			}
			elseif($this->pcredirect != '' && !$this->debug_mobile_page )
			{
				header('location:'.$this->pcredirect);
				exit;
			}
	
			echo '<!DOCTYPE html>
<head>';
			
			if($this->mobilepage && $_SESSION['pc'] != 'on') //allow to see the fullpage while navigating in PCview on mobile device
//				echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
//				echo '<meta name="viewport" content="width=320, initial-scale=1, maximum-scale=3">';
				echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0" />';
			
			echo '
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
';
			
			if ($this->no_cache)	{
echo '<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT"> 
';
}
			if($this->fncFacebookMeta_function !== false && $this->mobilepage === false)
fncFacebookMeta();
							
			echo'<title>'.$this->complete_page_title($this->title_page).'</title>
<meta name="keywords" content="'.$this->keywords_page.'" />
<meta name="description" content="'.$this->description_page.'" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="dcterms.rightsHolder" content="Japan Association for Working Holiday Makers" />
<link href="mailto:info@jawhm.or.jp" rel="help" title="Information contact"  />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />
<link rel="index" href="/index.html"  type="text/html" title="日本ワーキングホリデー協会" />';
			
			//display css files
			echo $this->add_css_files;
			
			/*** Use different css/js files  for mobile display and pc display ***/
			if($this->mobilepage === false)
			{
				echo '
<link href="/blog/css/base.css" rel="stylesheet" type="text/css" />
<link href="/css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="/blog/css/contents.css" rel="stylesheet" type="text/css" />
				';
				
				if($this->size_content_page == 'big')
				{
					echo '
<link href="/css/seminar-contents.css" rel="stylesheet" type="text/css" />
<link href="/css/seminar-headhootg-nav.css" rel="stylesheet" type="text/css" />';
				}
			
				echo'	
<link href="/css/menu.css" rel="stylesheet" type="text/css" />
<link href="/js/feedback/contactable.css" rel="stylesheet" type="text/css" />';

//				echo'
//<script type="text/javascript" src="https://www.taglog.jp/taglog-aio.js"></script>
//<script type="text/javascript">
//	taglog.init("https://www.jawhm.or.jp/");
//	taglog.loadingTimeMonitor.start();
//</script>';
			
				//check if another jquery.js file has been added, If yes, we don't use the one by default.
				$check_js_file = strpos($this->add_js_files, 'jquery.js');
				if ($check_js_file === false)
				{
					echo'
<script src="/js/jquery.js" type="text/javascript"></script>';
				}
							
				echo'
<script src="/js/jquery-easing.js" type="text/javascript"></script>
<script src="/js/scroll.js" type="text/javascript"></script>
<script src="/js/img-rollover.js" type="text/javascript"></script>';
			
			}
			else
			{
				echo '
				<link href="/css/menu_mobile.css" rel="stylesheet" type="text/css" />
				<link href="/css/base_mobile.css" rel="stylesheet" type="text/css" />
				<script src="/js/jquery.js" type="text/javascript"></script>
				<script src="/js/iscroll.js" type="text/javascript"></script>
				'.$this->js_settings_beforeIscroll.'';
			}
			
			echo '<script src="/js/google-analytics.js" type="text/javascript"></script>';

			
			//display js files
			echo $this->add_js_files;
			
			//style into page	
			echo $this->add_style;
			
			if(!empty($this->onload)){
				$body_onload = ' onload="'.$this->onload.'"';
			}else{
				$body_onload = '';
			}
			echo'
</head>
<body'.$body_onload.'>
			';
			
			//use standard template
			if($this->no_standard_template === false)
			{
				if($this->mobilepage  === false)
				{
				echo '
			            <div id="header">
			            	<div id="header_left">
			                	<h1 id="logotext" style="color:#666666;">'.$this->fncMenuHead_h1text.'</h1>
			                    <div id="topimg" style="height:30px;">
			                        <a href="/" title="一般社団法人日本ワーキング・ホリデー協会">
			                            <img src="/blog/images/titile.gif" alt="日本ワーキングホリデー協会" />
			                        </a>
			                    </div>
			                </div>
				';
				}else{

				echo '
			            <div id="header">
			            	<div id="header_left">
			                	<h1 id="logotext" style="color:#666666;">'.$this->fncMenuHead_h1text.'</h1>
			                    <div id="topimg" style="height:30px;">
			                        <a rel="external" href="/" title="一般社団法人日本ワーキング・ホリデー協会">
			                            <img src="/blog/images/titile.gif" alt="日本ワーキングホリデー協会" width="300px;" />
			                        </a>
			                    </div>
			                </div>
				';

//					fncMenuHead($this->fncMenuHead_imghtml,$this->fncMenuHead_h1text,$this->fncMenuHead_link);
				}
			}

		}
		
		//is using computer
		//--------------------------
		public function computer_use()
		{
			require_once($this->path());
			require_once(PATH.'include/Mobile_Detect.php');
			
			$detect = new Mobile_Detect();
			
			//which device?
			if ($detect->isMobile() || $detect->isTablet())	
				return false;
			else
				return true;
		}

		
		//Set the entire page title
		//-------------------------
		public function complete_page_title($title)
		{
			//if frontpage or no title has been set
			if($this->frontpage || $title == '')
			{
				$full_title = '日本ワーキング・ホリデー協会';
			}
			else
			{
				$full_title = $title.' | 日本ワーキング・ホリデー協会';
			}
			
			return $full_title;
		}
		
		//set breadcrumbs
		//----------------
		public function breadcrumbs($parent='',$parents_children='')
		{
			
			//first parent list
			$list_parent = array( 	'qa' 		=> '<a href="qa.html" title="">よくある質問</a>',
						'../qa' 	=> '<a href="../qa.html" title="">よくある質問</a>',
						'start' 	=> '<a href="start.html" title="">はじめてのワーキング・ホリデー</a>',
						'about' 	=> '<a href="../about.html" title="">一般社団法人 日本ワーキング・ホリデー協会について</a>',
						'event' 	=> '<a href="../event.html" title="">イベントカレンダー</a>',
						'member-top'=> '<a href="./top.php" title="">メンバー専用ページトップ</a>',
						'recruit'	=> '<a href="index.html" title="">求人・求職情報サイト</a>',
						'return'	=> '帰国者の方へ',
						'ryugaku'	=> '<a href="/ryugaku/" title="">語学留学</a>',
						'visa'		=> '<a href="visa_top.html" title="">ワーキングホリデー協定国ビザ情報</a>',
						'school' 	=> '<a href="/school.html" title="">語学学校（海外・国内）</a>',
						'country'	=> '<a href="/country" title="">ワーキングホリデーで行ける国</a>',
						'access'	=> '<a href="/office/">ワーホリ協会の各オフィス</a>',
			);
			//second parent list or 'parent's children'					
			$list_second_parent = array(
						'school-aus'	=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="../aus.html">オーストラリアの学校</a>',
						'school-can'	=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="../can.html">カナダの学校</a>',
						'school-nz'	=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="../nz.html">ニュージーランドの学校</a>',
						'school-ww' 	=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="../worldwide.html">ワールドワイドの学校</a>',
						'school-voice' 	=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="../">留学経験者からの声</a>',
						'v-aus'		=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="v-aus.html">オーストラリアビザ情報</a>',
						'v-can'		=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="v-can.html">カナダビザ情報</a>',
						'v-nz'		=> $list_parent[$parent].'&nbsp;&gt;&nbsp;<a href="v-nz.html">ニュージーランドビザ情報</a>',
			);
			
			//if frontpage
			if($this->frontpage)
			{
				$breadcrumbs_path ='<p id="topicpath">ワーキング・ホリデー（ワーホリ）協会</p>';
			}
			else
			{
				$breadcrumbs_path ='<p id="topicpath"><a href="/">ワーキング・ホリデー（ワーホリ）協会</a>';
				
				if($parent != '')
				{
					if($parent2 != '')
						$breadcrumbs_path .= '&nbsp;&gt;&nbsp;'.$list_second_parent[$parents_children].'&nbsp;&gt;&nbsp;'.$this->title_page.'</p>';
					else
						$breadcrumbs_path .= '&nbsp;&gt;&nbsp;'.$list_parent[$parent].'&nbsp;&gt;&nbsp;'.$this->title_page.'</p>';
				}
				else
					$breadcrumbs_path .= '&nbsp;&gt;&nbsp;'.$this->title_page.'</p>';
			}
			
			return $breadcrumbs_path;
		}

		
		//get the right path for all the links
		//------------------------------------
		private function path()
		{
			$path = 'path.php';
							
			//search file location
			//while files still not exit go parent folder by adding '../'
			while(!file_exists($path))
			{
				$path='../'.$path;
			}
			
			return $path;
		}
		
	}
?>