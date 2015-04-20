<?php	//--------------------------------------------------------------------	// FUNCTION to get the right keywords in mysql	//--------------------------------------------------------------------	function where_country($checked_countryname)	{		if (substr_count($checked_countryname, 1) == 1 || $checked_countryname == '0' ||  $checked_countryname == 'all' || $checked_countryname == '' )	//all		{			$where_country = '';		}		else		{			if(substr_count($checked_countryname, 7) == 1 || $checked_countryname == 'other' )	//others						{				$where_country .= ' or ( k_title1 not like  \'%オーストラリア%\' ';				$where_country .= '  and k_title1 not like  \'%ニュージーランド%\' ';				$where_country .= '  and k_title1 not like  \'%カナダ%\' ';				$where_country .= '  and k_title1 not like  \'%イギリス%\' ';				$where_country .= '  and k_title1 not like  \'%フランス%\' ';				$where_country .= '  and k_title1 not like  \'%アメリカ%\' ';
				$where_country .= '  and k_title1 not like  \'%英語圏%\' ';								$where_country .= '  and k_desc1 not like  \'%オーストラリア%\' ';				$where_country .= '  and k_desc1 not like  \'%ニュージーランド%\' ';				$where_country .= '  and k_desc1 not like  \'%カナダ%\' ';				$where_country .= '  and k_desc1 not like  \'%イギリス%\' ';				$where_country .= '  and k_desc1 not like  \'%フランス%\' ';				$where_country .= '  and k_desc1 not like  \'%アメリカ%\' ';
				$where_country .= '  and k_desc1 not like  \'%英語圏%\' ';								$where_country .= '  and k_desc2 not like  \'%オーストラリア%\' ';				$where_country .= '  and k_desc2 not like  \'%ニュージーランド%\' ';				$where_country .= '  and k_desc2 not like  \'%カナダ%\' ';				$where_country .= '  and k_desc2 not like  \'%イギリス%\' ';				$where_country .= '  and k_desc2 not like  \'%フランス%\' ';				$where_country .= '  and k_desc2 not like  \'%アメリカ%\' ';
				$where_country .= '  and k_desc2 not like  \'%英語圏%\' ) ';								$where_country .= '  or k_title1 like  \'%ヨーロッパ%\' ';				$where_country .= '  or k_title2 like  \'%ヨーロッパ%\' ';			}			else			{				if(substr_count($checked_countryname, 2) == 1 || $checked_countryname == 'オーストラリア' ||  $checked_countryname == 'aus' )				{					$val='オーストラリア';					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';				}								if(substr_count($checked_countryname, 3) == 1 || $checked_countryname == 'ニュージーランド' ||  $checked_countryname == 'nz')				{					$val='ニュージーランド';					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';				}								if(substr_count($checked_countryname, 4) == 1 || $checked_countryname == 'カナダ' ||  $checked_countryname == 'can')				{					$val='カナダ';					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';				}								if(substr_count($checked_countryname, 5) == 1 || $checked_countryname == 'イギリス' ||  $checked_countryname == 'uk' )				{					$val='イギリス';					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';				}								if(substr_count($checked_countryname, 6) == 1 || $checked_countryname == 'フランス' ||  $checked_countryname == 'fra' )				{					$val='フランス';					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';				}
				if(substr_count($checked_countryname, 6) == 1 || $checked_countryname == 'アメリカ' ||  $checked_countryname == 'usa' )
				{
					$val='アメリカ';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
							}		}						return $where_country;	}		//--------------------------------------------------------------------	// FUNCTION to get the right keywords in mysql	//--------------------------------------------------------------------	function where_know($checked_know)	{		if (substr_count($checked_know, 1) == 1 || $checked_know == '0' || $checked_know == 'all' ||  $checked_know == '' )	//all		{			$where_know = '';		}		else		{			if(substr_count($checked_know, 2) == 1 || $checked_know == '初心者向け' ||  $checked_know == 'first' )			{				$val='初心者';				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';			}
			if(substr_count($checked_know, 3) == 1 || $checked_know == 'プランニング' || $checked_know == 'plan' )			{				$val='プランニング';				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';			}
			if(substr_count($checked_know, 4) == 1 || $checked_know == '情報収集' || $checked_know == 'student' )
			{
				$data = '学校比較';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '看護師';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '休学';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '住まい仕事';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '学習法';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = 'トラブル';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '資格';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = 'セカンド';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '学生限定';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '都市比較';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
			}

			if(substr_count($checked_know, 3) == 1 || $checked_know == '懇談' || $checked_know == 'foot' )
			{
				$val='渡航相談会';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
				$val='女性限定';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
				$val='休職';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}

			if(substr_count($checked_know, 7) == 1 || $checked_know == '体験談' || $checked_know == 'kouen' )
			{
				$val='体験談';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}

			if(substr_count($checked_know, 5) == 1 || $checked_know == '語学学校' || $checked_know == 'school' )			{				$val='学校セミナー';				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';				$val='学校懇談';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}
			if(substr_count($checked_know, 6) == 1 || $checked_know == 'chumoku' || $checked_know == 'abili' )			{				$where_know .= ' or indicated_option <> 0 ';				$data = '注目';				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';				$data = '学校セミナー';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '学校懇談';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = 'パーティー';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$data = '国比較';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
			}		}				return $where_know;	}?>