<?php
include_once('db.php');
error_reporting(0);
if ( $_POST['ajax'] == 'get_comments' )
{
	//$sql = "SELECT * FROM comment";
	$n_id= $_POST['news_id'];
$sql ="SELECT comment.*,user.* FROM comment,user WHERE (comment.n_id ='$n_id') AND comment.u_id=user.u_id ORDER BY comment.c_post_time DESC";
	$res = mysql_query($sql);
	
	$comments=array();
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			$comments[] = $row;
		}
		//print json_encode($rows[]);
		print json_encode($comments);
	}else{
		$comments="empty";
		//$comments="news id for loading comments=".$n_id;
		print json_encode($comments);
	}
	
	

}

//EOF.	