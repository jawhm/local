<?php	

	/**
	 * Define MyClass
	 */
	class HeaderFooter
	{
		//set variable / parameters	
		
		public $title_page;	// title of the page
		public $description_page = 'ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。'; // description meta
		public $keywords_page = 'オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';	// keywords meta by default
		
		public $add_js_files;	//add more javascript files or script
		public $add_css_files;	//add more css files
		public $add_style;		//add written css styles into the page
		public $add_footer_js_files; //add js files after the footer
		
		public $frontpage = false;   //are we displaying the frontpage ? 
		public $parentpage;			 //use for breadcrumbs path while the page is not a children of the index page 
		
		public function __construct(){}
	
		public function __destruct(){}
		
		public function display_header()
		{
			require_once($this->path());

			echo '<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja">';
				
            echo '
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="Content-Style-Type" content="text/css" />
			<meta http-equiv="Content-Script-Type" content="text/javascript" />
			<title>'.$this->complete_page_title($this->title_page).'</title>
			<meta name="keywords" content="'.$this->keywords_page.'" />
			<meta name="description" content="'.$this->description_page.'" />
			<meta name="author" content="Japan Association for Working Holiday Makers" />
			<meta name="copyright" content="Japan Association for Working Holiday Makers" />
			<link rev="made" href="mailto:info@jawhm.or.jp" />
			<link rel="Top" href="/index.html"  type="text/html" title="日本ワーキングホリデー協会" />
			<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />
			<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />';
			
			//display css files
			echo $this->add_css_files;
			
			echo '
			<link href="/eng/css/base.css" rel="stylesheet" type="text/css" />
			<link href="/eng/css/headhootg-nav.css" rel="stylesheet" type="text/css" />
			<link href="/eng//css/contents.css" rel="stylesheet" type="text/css" />';
				
			//display js files
			echo $this->add_js_files;

			//style into page	
			echo $this->add_style;

			echo'
			</head>
			<body>
			';
			
				echo'
				<div id="header">
					<h1><a href="/eng/"><img src="images/h1-logo.jpg" alt="日本ワーキングホリデー協会" width="475" height="33" /></a></h1>
					<div id="utility-nav">
						<ul>
						  <li class="u-nav01"><a href="/">日本語</a></li>
						  <li class="u-nav02"><a href="/eng/">英語</a></li>
						</ul>
					</div>
					<img id="top-mainimg" src="images/top-mainimg.jpg" alt="" width="970" height="170" />
				</div>
				<div id="contentsbox">
					<div id="contentsbox-top">
						<div id="contentsbox-top-left">
							<div id="contentsbox-top-right"> </div>
						</div>
						
					</div>
					<div id="contents">
			  
						<div id="global-nav">
				  
							<div class="g-n-sec02">
								<ul id="g-n-main01">
									<li class="gnm01"><a href="service.html">What services do we provide??</a></li>
									<li class="gnm02"><a href="visa_faq.html">Working Holiday Visa F.A.Q</a></li>
									<li class="gnm03"><a href="work_faq.html">Work F.A.Q</a></li>
									<li class="gnm04"><a href="life_faq.html">Life in Japan F.A.Q</a></li>
									<li class="gnm05"><a href="support_mem.html">How to becomea Supporting Member</a></li>
									<li class="gnm06"><a href="ads.html">How to place ads on our website</a></li>
									<li class="gnm07"><a href="links.html">Useful Links</a></li>
									<li class="gnm08"><a href="acc_tokyo.html">Access to our office</a></li>
									<li class="gnm09"><a href="../attention.html">日本の雇用主の方へ</a></li>
								</ul>
							</div>
						</div>
						<div id="maincontent">'.
							$this->breadcrumbs().'
							<div id="top-main">
	    						<div class="top-sec01">
				';
		}

		public function display_footer()
		{
			echo'
						 		</div>
							</div>
						 </div>
					</div>
				</div>
					
				<div id="footer">
					<div id="copyright">Copyright© JAPAN Association for Working Holiday Makers All right reserved.</div>
				</div>
				'.$this->add_footer_js_files.'			
			</body>
			</html>
			';
		}

		//Set the entire page title
		//--------------------------
		public function complete_page_title($title)
		{
			//if frontpage or no title has been set
			if($this->frontpage || $title == '')
			{
				$full_title = 'Japan Association for Working Holiday Makers | 日本ワーキングホリデー協会';
			}
			else
			{
				$full_title = $title.' | Japan Association for Working Holiday Makers';
			}
			
			return $full_title;
		}
		
		//set breadcrumbs
		//----------------
		private function breadcrumbs()
		{
			//if frontpage
			if($this->frontpage)
			{
				$breadcrumbs_path ='<p id="topicpath">TOP</p>';
			}
			else
			{
				$breadcrumbs_path ='<p id="topicpath"><a href="index.html">TOP</a>';
				
				if($this->parentpage != '')
					$breadcrumbs_path .= '&nbsp;&gt;&nbsp;'.$this->parentpage.'&nbsp;&gt;&nbsp;'.$this->title_page.'</p>';
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