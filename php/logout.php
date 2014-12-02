<?php
	
if ( $_POST['ajax'] == 'logout_session' ){
	session_start();	
	unset($_SESSION["username"]);
	unset($_SESSION['full_name']);
	unset($_SESSION['picture']);
	unset($_SESSION['social_id']);	
	unset($_SESSION['login_method']);
	unset($_SESSION['u_id']);					
	session_unset();
	session_destroy();
	print "You have been logged out";
	
}
    
?>
