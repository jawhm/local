<?php @session_start();
	/**
	 * Define MyClass
	 */
	class Links
	{
		public $current_page = '';		// 表示中ページのＵＲＬ
		public $page_contents = '';		// 表示中ページのコンテンツ分類
		public $max_links = 5;			// 最大表示件数

		// ＵＲＬ，ページ名，コンテンツ分類  の順番で作成
		public $link_contents = array(
			array( "/ja/gapyear"				, "ギャップイヤーについて"				, "ギャップイヤー,ワーホリ"			),
			array( "/ja/gapyear/conjugation"                , "ギャップタームの活用方法"                            , "ギャップイヤー,ワーホリ"                     ),
			array( "/step1.html"                            , "ワーキングホリデーにいこう"                          , "ワーホリ,ステップ,ワーホリ"                  ),
			array( "/step2.html"                            , "ワーホリの目標を立てよう"                            , "ステップ"                                    ),
			array( "/step3.html"                            , "行き先は決まりましたか？"                            , "ステップ"                                    ),
			array( "/step4.html"                            , "渡航先が決まったら準備に入りましょう"                , "ステップ"                                    ),
			array( "/step5.html"                            , "まもなく出発。準備は大丈夫ですか？"                  , "ステップ"                                    ),
			array( "/step6.html"                            , "渡航中の留意点"                                      , "ステップ"                                    ),
			array( "/step7.html"                            , "帰国してからすること"                                , "ステップ"                                    ),
			array( "/qa_ire.html"                           , "アイルランドのＱ＆Ａ"                                , "アイルランド,ＱＡ"                           ),
			array( "/school/ire.html"                       , "アイルランドの学校"                                  , "アイルランド,学校"                           ),
			array( "/visa/v-ire.html"                       , "アイルランドビザ情報"                                , "アイルランド,ビザ"                           ),
			array( "/country/ireland/index.html"            , "アイルランドの国情報"                                , "アイルランド,国情報"                         ),
			array( "/wh/america/index.html"                 , "アメリカのワーキングホリデー（ワーホリ）"            , "アメリカ,ワーホリ"                           ),
			array( "/ryugaku/usa_lang.html"                 , "アメリカ語学留学"                                    , "アメリカ,語学学校"                           ),
			array( "/ryugaku/usa_visa.html"                 , "アメリカ語学留学ビザ"                                , "アメリカ,ビザ"                               ),
			array( "/ryugaku/usa_univ.html"                 , "アメリカ大学留学"                                    , "アメリカ,大学"                               ),
			array( "/qa_uk.html"                            , "イギリスのＱ＆Ａ"                                    , "イギリス,ＱＡ"                               ),
			array( "/wh/uk/index.html"                      , "イギリスのワーキングホリデー（ワーホリ）"            , "イギリス,ワーホリ"                           ),
			array( "/school/uk.html"                        , "イギリスの学校"                                      , "イギリス,語学学校"                           ),
			array( "/visa/v-uk.html"                        , "イギリスビザ情報"                                    , "イギリス,ビザ"                               ),
			array( "/ryugaku/eng_lang.html"                 , "イギリス語学留学"                                    , "イギリス,留学"                               ),
			array( "/ryugaku/eng_visa.html"                 , "イギリス語学留学ビザ情報"                            , "イギリス,ビザ"                               ),
			array( "/country/unitedkingdom/index.html"      , "イギリスの国情報"                                    , "イギリス,国情報"                             ),
			array( "/ryugaku/eng_univ.html"                 , "イギリス大学留学"                                    , "イギリス,大学,留学"                          ),
			array( "/qa_aus.html"                           , "オーストラリアのＱ＆Ａ"                              , "オーストラリア,ＱＡ"                         ),
			array( "/wh/australia/index.php"                , "オーストラリアでワーキングホリデー"                  , "オーストラリア,ワーホリ"                     ),
			array( "/school/aus.html"                       , "オーストラリアの学校"                                , "オーストラリア,語学学校"                     ),
			array( "/visa/v-aus.html"                       , "オーストラリアビザ情報"                              , "オーストラリア,ビザ"                         ),
			array( "/ryugaku/aus_lang.html"                 , "オーストラリア語学留学の特徴"                        , "オーストラリア,留学"                         ),
			array( "/ryugaku/aus_point.html"                , "オーストラリア語学留学の良い点"                      , "オーストラリア,留学"                         ),
			array( "/ryugaku/aus_visa.html"                 , "オーストラリア語学留学ビザ"                          , "オーストラリア,留学"                         ),
			array( "/country/australia/index.html"          , "オーストラリアの国情報"                              , "オーストラリア,国情報"                       ),
			array( "/ryugaku/aus_univ.html"                 , "オーストラリア大学留学"                              , "オーストラリア,大学,留学"                    ),
			array( "/qa_can.html"                           , "カナダのＱ＆Ａ"                                      , "カナダ,ＱＡ"                                 ),
			array( "/wh/canada/index.php"                   , "カナダでワーキングホリデー"                          , "カナダ,ワーホリ"                             ),
			array( "/school/can.html"                       , "カナダの学校"                                        , "カナダ,語学学校"                             ),
			array( "/visa/v-can.html"                       , "カナダビザ情報"                                      , "カナダ,ビザ"                                 ),
			array( "/ryugaku/can_lang.html"                 , "カナダ語学留学"                                      , "カナダ,留学"                                 ),
			array( "/country/canada/index.html"             , "カナダの国情報"                                      , "カナダ,国情報"                               ),
			array( "/qa_dnk.html"                           , "デンマークのＱ＆Ａ"                                  , "デンマーク"                                  ),
			array( "/school/dnk.html"                       , "デンマークの学校"                                    , "デンマーク"                                  ),
			array( "/visa/v-dnk.html"                       , "デンマークビザ情報"                                  , "デンマーク"                                  ),
			array( "/country/denmark/index.html"            , "デンマークの国情報"                                  , "デンマーク"                                  ),
			array( "/qa_deu.html"                           , "ドイツのＱ＆Ａ"                                      , "ドイツ"                                      ),
			array( "/school/deu.html"                       , "ドイツの学校"                                        , "ドイツ"                                      ),
			array( "/visa/v-deu.html"                       , "ドイツビザ情報"                                      , "ドイツ"                                      ),
			array( "/country/germany/index.html"            , "ドイツの国情報"                                      , "ドイツ"                                      ),
			array( "/qa_nz.html"                            , "ニュージーランドのＱ＆Ａ"                            , "ニュージーランド,ＱＡ"                       ),
			array( "/wh/newzealand/index.html"              , "ニュージーランドのワーキングホリデー（ワーホリ）"    , "ニュージーランド,ワーホリ"                   ),
			array( "/visa/v-nz.html"                        , "ニュージーランドビザ情報"                            , "ニュージーランド,ビザ"                       ),
			array( "/country/newzealand/index.html"         , "ニュージーランドの国情報"                            , "ニュージーランド,国情報"                     ),
			array( "/visa/v-nor.html"                       , "ノルウェービザ情報"                                  , "ノルウェー"                                  ),
			array( "/start.html"                            , "はじめてのワーキング・ホリデー"                      , "ワーホリ"                                    ),
			array( "/ryugaku/fiji_lang.html"                , "フィジー語学留学・フィリピン留学"                    , "フィジー,フィリピン,留学,語学留学"           ),
			array( "/qa_fra.html"                           , "フランスのＱ＆Ａ"                                    , "フランス,ＱＡ"                               ),
			array( "/school/fra.html"                       , "フランスの学校"                                      , "フランス,語学学校"                           ),
			array( "/visa/v-fra.html"                       , "フランスビザ情報"                                    , "フランス,ビザ"                               ),
			array( "/country/france/index.html"             , "フランスの国情報"                                    , "フランス,国情報"                             ),
			array( "/mem/"                                  , "メンバー登録について"                                , "協会,ワーホリ"                               ),
			array( "/qa.html"                               , "ワーホリのよくある質問"                              , "ワーホリ"                                    ),
			array( "/system.html"                           , "ワーキング・ホリデー制度について"                    , "ワーホリ,協会"                               ),
			array( "/country/"                              , "ワーキングホリデーで行ける国"                        , "ワーホリ,協会"                               ),
			array( "/wh/tame.php"                           , "ワーキングホリデーのタメになる話"                    , "ワーホリ"                                    ),
			array( "/katsuyou.html"                         , "ワーキングホリデー協会活用ガイド"                    , "協会,ワーホリ"                               ),
			array( "/visa/visa_top.html"                    , "ワーキングホリデー協定国（ビザ情報）"                , "ワーホリ"                                    ),
			array( "/blog/whstory/"                         , "ワーホリ・ストーリー"                                , "ワーホリ"                                    ),
			array( "/seminar/ser"                           , "ワーホリ・留学の無料セミナー（説明会）"              , "協会,ワーホリ"                               ),
			array( "/qa_kor.html"                           , "韓国のＱ＆Ａ"                                        , "韓国"                                        ),
			array( "/school/kor.html"                       , "韓国の学校"                                          , "韓国"                                        ),
			array( "/visa/v-kor.html"                       , "韓国ビザ情報"                                        , "韓国"                                        ),
			array( "/country/southkorea/index.html"         , "韓国の国情報"                                        , "韓国"                                        ),
			array( "/ryugaku/ryugaku_hiyou.html"            , "語学留学費用について"                                , "語学学校,費用,留学"                          ),
			array( "/ryugaku/ryugaku_jawhm.html"            , "留学に向けてワーホリ協会の活用方法"                  , "ワーホリ,協会,留学"                          ),
			array( "/qa_hkg.html"                           , "香港のＱ＆Ａ"                                        , "香港"                                        ),
			array( "/school/hkg.html"                       , "香港の学校"                                          , "香港"                                        ),
			array( "/visa/v-hkg.html"                       , "香港のビザ情報"                                      , "香港"                                        ),
			array( "/country/hongkong/index.html"           , "香港の国情報"                                        , "香港"                                        ),
			array( "/qa_ywn.html"                           , "台湾のＱ＆Ａ"                                        , "台湾"                                        ),
			array( "/school/ywn.html"                       , "台湾の学校"                                          , "台湾"                                        ),
			array( "/school/nz.html"                        , "ニュージーランドの学校"                              , "ニュージーランド,ワーホリ"                   ),
			array( "/visa/v-ywn.html"                       , "台湾ビザ情報"                                        , "台湾"                                        ),
			array( "/country/taiwan/index.html"             , "台湾の国情報"                                        , "台湾"                                        ),
			array( "/ryugaku/usa_sat.html"                  , "大学留学に必要な英語以外の試験"                      , "大学,留学"                                   ),
			array( "/ryugaku/ryugaku_eng.html"              , "大学留学に必要な英語力"                              , "大学,留学"                                   ),
			array( "/office/tokyo/index.html"               , "東京オフィスのご案内"                                , "協会,オフィス"                               ),
			array( "/blog/nagoyablog/"                      , "名古屋オフィスのブログ"                              , "協会,ブログ"                                 ),
			array( "/blog/okinawablog/"                     , "沖縄オフィスのブログ"                                , "協会,ブログ"                                 ),
			array( "/blog/osakablog/"                       , "大阪オフィスのブログ"                                , "協会,ブログ"                                 ),
			array( "/blog/tokyoblog/"                       , "東京オフィスのブログ"                                , "協会,ブログ"                                 ),
			array( "/blog/fukuokablog/"                     , "福岡オフィスのブログ"                                , "協会,ブログ"                                 ),
			array( "/office/fukuoka/map.php"                , "福岡オフィスのご案内"                                , "協会,オフィス"                               ),
			array( "/office/nagoya/index.html"              , "名古屋オフィスのご案内"                              , "協会,オフィス"                               ),
			array( "/office/osaka/index.html"               , "大阪オフィスのご案内"                                , "協会,オフィス"                               ),
			array( "/office/okinawa/index.html"             , "沖縄オフィスのご案内"                                , "協会,オフィス"                               ),
		);

		public function display_links($contents)
		{

			if ($this->current_page == '')	{
				// 表示中のページＵＲＬを取得
				$this->current_page = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $_SERVER['SCRIPT_FILENAME']);
			}
			if ($contents <> '')	{
				// コンテンツ分類取得
				$this->page_contents = $contents;
			}
			if ($this->page_contents == '')	{
				// コンテンツ分類が指定されていない場合は、リストから取得
				foreach($this->link_contents as $cont)	{
					if ($cont[0] == $this->current_page)	{
						$this->page_contents = $cont[2];
					}
				}
			}
			$pagecont = split(',', $this->page_contents);

			// リンクを表示
			$cnt = 0;
			$msg = '';
			$out[] = array();
			foreach($this->link_contents as $cont)	{
				$flg = false;
				if ($this->page_contents <> '')	{
					foreach($pagecont as $pc)	{
						if (mb_strpos($cont[2], $pc) !== false)	{
							$flg = true;
						}
					}
				}
				if ($cont[0] <> $this->current_page && $flg)	{
					$out[$cnt] = $cont;
					$cnt++;
				}
			}
			if ($cnt > 0)	{
				shuffle($out);	// ランダムに並べ替え
				$cnt = 0;
				foreach($out as $cont)	{
					$cnt++;
					$msg .= '　・&nbsp;<a href="'.$cont[0].'">'.$cont[1].'</a>';
					$msg .= '<br/>';
					if ($cnt >= $this->max_links)	break;
				}
?>
<style>
.linkbox	{
	margin : 15px 15px 15px 15px;
	padding	: 10px 20px 10px 20px;
	background-color : #FFE4B5;
	font-size:10pt;
}
</style>
<div class="linkbox">
	お探しの情報はありましたか？ 以下のページもよく見られていますよ<br/>
	<?php echo $msg; ?>
</div>
<?php
			}

		}

	}
?>