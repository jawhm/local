<?php	
	//from email
	if(isset($_GET['m']))
	{		
			//for mobile
			$mobile_u = $_GET['u'];
			$mobile_m = $_GET['m'];
			
			//redirection for mobile
			$redirection='../mobileform/member_form.php?return=step3&m='.$mobile_m.'&u='.$mobile_u;
			
			require 'memberscript.php';
	}
	else
	{
		require 'memberscript.php';
	}

?>
