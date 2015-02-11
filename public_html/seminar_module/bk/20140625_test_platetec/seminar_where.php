<?php

function where_multiple($multiple_config, $checked_multiple, $where_multiple = '')
{
	// $checked_multiple には、「1」や「4,5,6」や「all」や「aus」などのデータが入る
	if (empty($checked_multiple)) return $where_multiple;

	$multiples = explode(',', $checked_multiple);
	foreach ($multiples as $c) {
		$one = @$multiple_config[$c];
		foreach ($multiple_config as $mc) {
			if ($mc['id'] == $c && empty($one)) {
				$one = $mc;
				break;
			}
		}

		if (empty($one)) {
			continue;
		}

		// 全てバージョン
		if ($one['id'] == 'all') {
			$where_multiple = '';
			break;
		}
		// その他バージョン
		if ($one['id'] == 'other') {
			$where_multiple = ' or (';
			$is_first = true;
			foreach ($multiple_config as $mc) {
				foreach ($mc['word1'] as $w1) {
					if ($is_first) {
						$is_first = false;
						$where_multiple .= ' k_title1 not like \'%'.$w1.'%\' ';
					} else {
						$where_multiple .= ' and k_title1 not like \'%'.$w1.'%\' ';
					}

					$where_multiple .= ' and k_desc1 not like \'%'.$w1.'%\' ';
					$where_multiple .= ' and k_desc2 not like \'%'.$w1.'%\' ';
				}
				foreach ($mc['word2'] as $w2) {
					if ($is_first) {
						$is_first = false;
						$where_multiple .= ' k_desc2 not like \'%'.$w2.'%\' ';
					} else {
						$where_multiple .= ' and not k_desc2 like \'%'.$w2.'%\' ';
					}
				}
			}
			$where_multiple .= ' ) ';
			break;
		}
		foreach ($one['word1'] as $w1) {
			$where_multiple .= ' or k_title1 like \'%'.$w1.'%\' ';
			$where_multiple .= ' or k_desc1 like \'%'.$w1.'%\' ';
			$where_multiple .= ' or k_desc2 like \'%'.$w1.'%\' ';
		}
		foreach ($one['word2'] as $w2) {
			$where_multiple .= ' or k_desc2 like \'%'.$w2.'%\' ';
		}
	}
	return $where_multiple;
}

	//--------------------------------------------------------------------
	// FUNCTION to get the right keywords in mysql
	//--------------------------------------------------------------------
	function where_country($checked_countryname, $where_country = '')
	{
		if (substr_count($checked_countryname, 1) == 1 || $checked_countryname == '0' ||  $checked_countryname == 'all' || $checked_countryname == '' )	//all
		{
			$where_country = '';
		}
		else
		{
			if(substr_count($checked_countryname, 7) == 1 || $checked_countryname == 'other' )	//others			
			{
				$where_country .= ' or ( k_title1 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_title1 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_title1 not like  \'%カナダ%\' ';
				$where_country .= '  and k_title1 not like  \'%イギリス%\' ';
				$where_country .= '  and k_title1 not like  \'%フランス%\' ';
				$where_country .= '  and k_title1 not like  \'%英語圏%\' ';
				
				$where_country .= '  and k_desc1 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_desc1 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_desc1 not like  \'%カナダ%\' ';
				$where_country .= '  and k_desc1 not like  \'%イギリス%\' ';
				$where_country .= '  and k_desc1 not like  \'%フランス%\' ';
				$where_country .= '  and k_desc1 not like  \'%英語圏%\' ';
				
				$where_country .= '  and k_desc2 not like  \'%オーストラリア%\' ';
				$where_country .= '  and k_desc2 not like  \'%ニュージーランド%\' ';
				$where_country .= '  and k_desc2 not like  \'%カナダ%\' ';
				$where_country .= '  and k_desc2 not like  \'%イギリス%\' ';
				$where_country .= '  and k_desc2 not like  \'%フランス%\' ';
				$where_country .= '  and k_desc2 not like  \'%英語圏%\' ) ';
				
				$where_country .= '  or k_title1 like  \'%ヨーロッパ%\' ';
				$where_country .= '  or k_title2 like  \'%ヨーロッパ%\' ';
			}
			else
			{
				if(substr_count($checked_countryname, 2) == 1 || $checked_countryname == 'オーストラリア' ||  $checked_countryname == 'aus' )
				{
					$val='オーストラリア';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
				
				if(substr_count($checked_countryname, 3) == 1 || $checked_countryname == 'ニュージーランド' ||  $checked_countryname == 'nz')
				{
					$val='ニュージーランド';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
				
				if(substr_count($checked_countryname, 4) == 1 || $checked_countryname == 'カナダ' ||  $checked_countryname == 'can')
				{
					$val='カナダ';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
				
				if(substr_count($checked_countryname, 5) == 1 || $checked_countryname == 'イギリス' ||  $checked_countryname == 'uk' )
				{
					$val='イギリス';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
				
				if(substr_count($checked_countryname, 6) == 1 || $checked_countryname == 'フランス' ||  $checked_countryname == 'fra' )
				{
					$val='フランス';
					$where_country .= ' or k_title1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc1 like \'%'.$val.'%\' ';
					$where_country .= ' or k_desc2 like \'%'.$val.'%\' ';
				}
				
			}
		}
		
		
		return $where_country;
	}
	
	//--------------------------------------------------------------------
	// FUNCTION to get the right keywords in mysql
	//--------------------------------------------------------------------
	function where_know($checked_know, $where_know = '')
	{
		if (substr_count($checked_know, 1) == 1 || $checked_know == '0' || $checked_know == 'all' ||  $checked_know == '' )	//all
		{
			$where_know = '';
		}
		else
		{
			if(substr_count($checked_know, 2) == 1 || $checked_know == '初心者向け' ||  $checked_know == 'first' )
			{
				$val='初心者';
				
				$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
//				$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}
			
			if(substr_count($checked_know, 3) == 1 || $checked_know == '懇談' || $checked_know == 'foot' )
			{
				$val='懇談';
				
				$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			
			}
			
			if(substr_count($checked_know, 4) == 1 || $checked_know == 'kuwashiku' || $checked_know == 'student' )
			{
				$data = '比較';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = '限定';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = '資格';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = '就職';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = 'セカンド';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = '有効的';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = 'ナース';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
			}

			if(substr_count($checked_know, 5) == 1 || $checked_know == '語学学校' || $checked_know == 'school' )
			{
				$val='語学学校';
				
				$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
//				$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}
			
			if(substr_count($checked_know, 6) == 1 || $checked_know == 'chumoku' || $checked_know == 'abili' )
			{
				$where_know .= ' or indicated_option <> 0 ';
				$data = '注目';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
				$data = '人気';
				$where_know .= ' or k_title1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$data.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$data.'%\' ';
				$where_know .= ' or seminar_name like \'%'.$data.'%\' ';
				$where_know .= ' or short_description like \'%'.$data.'%\' ';
			}
			
			if(substr_count($checked_know, 7) == 1 || $checked_know == '講演' || $checked_know == 'kouen' )
			{
				$val='講演';
				
				$where_know .= ' or k_title1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc1 like \'%'.$val.'%\' ';
				$where_know .= ' or k_desc2 like \'%'.$val.'%\' ';
			}

		}
		
		return $where_know;
	}

