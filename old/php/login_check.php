<?php
session_start();   
include_once('db.php'); 

    $username=$_POST['username'];
    $password=$_POST['password'];

    
if ( $_POST['ajax'] == 'login_data' ){	
    if($username&&$password)
    {
        
         $query=mysql_query("SELECT * FROM user WHERE username='$username'");
         $numrows=mysql_num_rows($query);
         $row_data = array();
		            
		if($numrows!=0){
		
			while($row=mysql_fetch_assoc($query)){
				$row_data[]=$row;
				$dbusername=$row['username'];
                $dbpassword=$row['pwd'];
				$f_name=$row['f_name'];
				$l_name=$row['l_name'];
				$picture=$row['picture'];
				$social_id=$row['social_id'];
				$login_method=$row['login_method'];
				$u_id=$row['u_id'];
				
			}	
			//check to see if they match!  
			if($username==$dbusername && $password==$dbpassword){
				//echo json_encode("ok");
				
				$full_name=$f_name.' '.$l_name;
				$_SESSION['username']=$username;
				$_SESSION['full_name']=$full_name;
				$_SESSION['picture']=$picture;
				$_SESSION['social_id']=$social_id;
				$_SESSION['login_method']=$login_method;
				$_SESSION['u_id']=$u_id;
				echo json_encode($row_data);
				
			} else{
				//echo json_encode("Incorrect username or password!") ;
				echo json_encode("wrong") ;
			}
		}else {
			//echo json_encode("That user does not exsit!") ;
			echo json_encode("wrong") ;
		
		}  
                            
    }else {
      //json_encode("plese enter an username and a password") ;  
	  echo json_encode("wrong") ;
	}
}

if ( $_POST['ajax'] == 'login_check_fb' ){
	
	if(isset($_POST['user_email'])){
		
		/*$user_email=$_POST['user_email'];
		$query=mysql_query("SELECT * FROM user WHERE email='$user_email'");
		$numrows=mysql_num_rows($query);
		$row_data = array();
			*/		
		if($numrows!=0){
		/*
			while($row=mysql_fetch_assoc($query)){
				$row_data[]=$row;
				$f_name=$row['f_name'];
				$l_name=$row['l_name'];
				$picture=$row['picture'];
				$social_id=$row['social_id'];
				$login_method=$row['login_method'];
			}
			$full_name=$f_name.' '.$l_name;
			$_SESSION['full_name']=$full_name;
			$_SESSION['picture']=$picture;
			$_SESSION['social_id']=$social_id;
			$_SESSION['login_method']=$login_method;
			print json_encode($row_data);	
			*/
		}
		else{
			print json_encode("fb not logged");
		}
		
	}else{
		print json_encode("fb not logged2");
	}
		
}


//EOF.	
