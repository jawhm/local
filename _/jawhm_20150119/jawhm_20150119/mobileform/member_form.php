<?php

	// If access without SSL(443) , Redirect SSL page.
	if( $_SERVER["SERVER_PORT"] != 443 ) {
		header( "location:" . "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] );
		exit;
	}

mb_language("Ja");
mb_internal_encoding("utf8");

	require_once('./include/mem_function.php');
	require_once('./include/set_param.php');

	
	$list_fields = array('email', 'password', 'password2', 'name','firstname', 'phonetic_name', 'phonetic_firstname', 'gender', 'select-choice-year', 'select-choice-month', 'select-choice-day', 'postcode', 'province', 'municipality', 'address', 'phonenumber', 'occupation', 'country', 'language-skill', 'travel-purpose', 'know-how', 'guide', 'agree', 'same_pswd', 'pswd', 'phonecheck', 'mailcheck','email_exist');
	$list_mandatory_fields = array('email', 'password', 'password2', 'name', 'firstname', 'phonetic_name', 'phonetic_firstname', 'gender','select-choice-year','select-choice-month','select-choice-day', 'postcode', 'province', 'municipality', 'address', 'phonenumber', 'agree');


	if(isset($_GET['return']) && $_GET['return'] != 'step4' && $_GET['return'] != 'step5' )
	{	
		foreach($list_fields as $field)
		{
			if (isset($_GET[$field]))
			{
				$$field = secure($_GET[$field]);
				
			}else
				$$field = '';
			
			
			//===================================
			//gather all information in an array
			//==================================
			$final_array[$field] = html_entity_decode($$field);

			//verification d'erreur pour champ obligatoire
			if ((in_array($field, $list_mandatory_fields) && empty($$field)))
			{
				$field_type[$field] = '_field_error';
			}
			
			$field_value[$field] = $$field;
		}
		
		//check if password are the same
		if($same_pswd == 'no' && !empty($field_value['password2']))
		{
				$field_type['password2'] = '_field_error';
				$different_password = 1;
		}
		
		//check if password are the same
		if($pswd == 'short' && !empty($field_value['password']))
		{
				$field_type['password'] = '_field_error';
				$different_password = 2;
		}
		
		//check phonenumber is correct
		if($phonecheck == 'wrong' && !empty($field_value['phonecheck']))
		{
				$field_type['phonenumber'] = '_field_error';
				$wrong_phone_format = true;
		}
		
		//check if password are the same
		if($mailcheck == 'wrong' && !empty($field_value['mailcheck']))
		{
				$field_type['email'] = '_field_error';
				$wrong_email_format = true;
		}
	}	

	//HEADER
	require_once('include/header.php');
	
	
			
	if ($_GET['return'] == 'step2')
	{
		//form step2
		include('step/step2.php');
	}
	elseif ($_GET['return'] == 'step3')
	{
		//form step3
		include('step/step3.php');
	}
	elseif ($_GET['return'] == 'step4')
	{		
		//form step4
		include('step/step4.php');

	}
	elseif ($_GET['return'] == 'step5')
	{		
		//step5
		include('step/step5.php');

	}
	else
	{
		//form step1
		include('step/step1.php');
	}
	
	
	//FOOTER
	require_once('include/footer.php');
	?>