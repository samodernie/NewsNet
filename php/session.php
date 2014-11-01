<?php
session_start();   
include_once('db.php');
if ( $_POST['ajax'] == 'session_check' ){	

	if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
		//print json_encode($_SESSION['username']);
		$user_session_data = array('full_name' => $_SESSION['full_name'], 'user_pic' =>$_SESSION['picture'], 'login_method' => $_SESSION['login_method'],'u_id'=>$_SESSION['u_id']);
		print json_encode($user_session_data);
		
	}
	else{
		print json_encode("not logged user");
	}
}



//EOF.