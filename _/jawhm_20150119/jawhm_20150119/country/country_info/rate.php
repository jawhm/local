<?php
		$currency_of_thecountry = 'AUD';
		$url_data = "http://www.google.com.br/ig/calculator?hl=ja&q=1{$currency_of_thecountry}=?JPY";
		$array_from = array('lhs','rhs','error','icc');
		$array_to	= array('"lhs"','"rhs"','"error"','"icc"');
		
		//get result
		$result = file_get_contents($url_data);
		//echo $result;
		
		//make visible what's between each data -> %0D%0A
		$encode_result= utf8_encode($result);

		echo $encode_result;

		$json_format_data = str_replace($array_from,$array_to,file_get_contents($url_data, false, $context));

		echo file_get_contents($url_data);
		$json_data = json_decode($json_format_data);
		echo $json_data->lhs;
?>