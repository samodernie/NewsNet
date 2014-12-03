<?php
include_once('db.php');
if ( $_POST['ajax'] == 'get_last_image_id' )
{
	//$sql = "SELECT * FROM comment";
	
	$sql ="SELECT u_id FROM user ORDER BY u_id DESC LIMIT 1";
	$res = mysql_query($sql);
	
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			//print $row["u_id"];
			print json_encode($row["u_id"]);
		}
		
		
	}
	else{
		$u_id=1;
		//print $u_id;
		print json_encode($u_id);
	}

}

//EOF.	