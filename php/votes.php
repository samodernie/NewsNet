<?php
include_once('db.php');
error_reporting(0);

if ( $_POST['ajax'] == 'get_votes' )
{
	
	$n_id= $_POST['n_id'];
	$sql2="SELECT * FROM vote WHERE `n_id`='$n_id' AND `status`=1 " ;
	$res2 = mysql_query($sql2);
	
	if(mysql_num_rows($res2)>0){
		$totalrecords=mysql_num_rows($res2);
	}else{
		$totalrecords=0;
	}
	
	$votes['total_votes'] =$totalrecords;
	print json_encode($votes);
	
	
}



if ( $_POST['ajax'] == 'get_votes_with_user' )
{
	$n_id= $_POST['n_id'];
	$u_id= $_POST['u_id'];
	
	
	//$sql = "SELECT * FROM comment";
	
		$sql ="SELECT * from vote WHERE `n_id`='$n_id' AND `u_id`='$u_id' ";
		$res = mysql_query($sql);
		$user_votes="";
		$votes=array();
		if(mysql_num_rows($res)>0){
			$user_votes=1;
			
			//print json_encode($user_votes);
			
		}else{
			$user_votes=0;
			
			//print json_encode($user_votes);
		}
		$votes['user_votes_status'] =$user_votes;
		
	
		
		$sql2="SELECT * FROM vote WHERE `n_id`='$n_id' AND `status`=1 " ;
		$res2 = mysql_query($sql2);
		
		if(mysql_num_rows($res2)>0){
			$totalrecords=mysql_num_rows($res2);
		}else{
			$totalrecords=0;
		}
		
		$votes['total_votes'] =$totalrecords;
		print json_encode($votes);
	
	
}

if ($_POST['ajax'] == 'set_vote_status'){

	$n_id= $_POST['n_id'];
	$u_id= $_POST['u_id'];
	$vote_status= $_POST['vote_status'];
	
	
	if($vote_status==0){
		$sql_update_votes_status="UPDATE `vote` SET `status`='$vote_status' WHERE (n_id='$n_id') AND (u_id='$u_id')";
		mysql_query($sql_update_votes_status);
		print json_encode("vote updated");
	}else{
		$select_available="SELECT * from `vote` WHERE (n_id='$n_id') AND (u_id='$u_id') ";
		$res_select_available = mysql_query($select_available);
		if(mysql_num_rows($res_select_available)>0){
			$sql_update_votes_status2="UPDATE `vote` SET `status`='$vote_status' WHERE (n_id='$n_id') AND (u_id='$u_id')";
			mysql_query($sql_update_votes_status2);
			print json_encode("vote updated already available vote row");
		}else{
			$sql_inset_votes_status="INSERT INTO `vote` (`n_id`, `u_id`, `status`) VALUES ('$n_id','$u_id','$vote_status')";
			mysql_query($sql_inset_votes_status);
			print json_encode("vote inserted");
            
            //rating
    
            $sql_vote_rating = "update news set rating = rating+2 where n_id = '$n_id';";

            mysql_query($sql_vote_rating);
            print "updated rating";
            
            //rating from reporter
    
            $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

            mysql_query($sql_vote_rating_reporter);
            print "updated rating";
                        
            //reporter rating
    
            $sql_reporter_rating = "update `user` set rating = rating + 2 WHERE u_id = (select u_id from news where n_id ='$n_id');";

            mysql_query($sql_reporter_rating);
            print "updated user rating";
            
		}
		
	}
	
	
	
}
//EOF.	