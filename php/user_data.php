<?php
 error_reporting(0);
include_once('db.php');
date_default_timezone_set('Asia/Colombo');
if ( $_POST['ajax'] == 'save_user' )
{

	$f_name= $_POST['f_name'];
	$l_name= $_POST['l_name'];
	$picture= $_POST['picture'];
	$email= $_POST['email'];
	$username= $_POST['username'];
	$pwd= $_POST['pwd'];
	$login_method= "default";
	$social_id="";
	
	$sql ="SELECT * FROM user WHERE (email='$email')";
	$res = mysql_query($sql);
	
	$row_data = array();
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			$u_id= $row["u_id"];
			
		}
		$sql_update_user="UPDATE `user` SET `picture`='$picture',`username`='$username',`pwd`='$pwd' WHERE (u_id='$u_id')";
		mysql_query($sql_update_user);
		print "updated successfully";
	}
	else{	
		$sql_save_user = "INSERT INTO `user`(`u_id`, `f_name`, `l_name`, `picture`, `email`, `username`, `pwd`, `login_method`, `social_id`, `u_status`) VALUES (NULL,'$f_name','$l_name','$picture','$email','$username','$pwd','$login_method','$social_id',1);";
		
	mysql_query($sql_save_user);
	print "saved user successfully";
	
	}

}

if($_POST['ajax'] == 'save_fb_user'){
	
	$f_name= $_POST['user_fname'];
	$l_name= $_POST['user_lname'];
	$email= $_POST['user_email'];
	$fb_id= $_POST['user_fb_id'];
	
	$sql ="SELECT * FROM user WHERE (email='$email')";
	$res = mysql_query($sql);
	
	$row_data = array();
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			$u_id= $row["u_id"];
			//$row_data[]=$row;
			
		}
		$sql_update_user="UPDATE `user` SET `social_id`='$fb_id' WHERE (u_id='$u_id')";
		mysql_query($sql_update_user);
		//print $row_data[];
		//print json_encode($row_data);
		//print "already exist";
		print json_encode($u_id);
	}
	else{
$sql_save_fb_user ="INSERT INTO `user`(`u_id`, `f_name`, `l_name`, `picture`, `email`, `username`, `pwd`, `login_method`, `social_id`, `u_status`) VALUES (NULL,'$f_name','$l_name','','$email','','','facebook','$fb_id',1);";
 mysql_query($sql_save_fb_user);
 
 $sql2 ="SELECT * FROM user WHERE (email='$email')";
$res2 = mysql_query($sql2);

	if(mysql_num_rows($res2)>0){
		while( $row = mysql_fetch_assoc( $res2 ) )
		{
			$u_id= $row["u_id"];
			//$row_data[]=$row;
			
		}
		
		print json_encode($u_id);
	}
 
//print json_encode("new");
	}	
		
}

//EOF.	