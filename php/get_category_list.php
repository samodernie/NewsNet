<?php
include_once('db.php');
error_reporting(0);


	$sql3 ="SELECT DISTINCT cat_name FROM category WHERE cat_name!='false' AND cat_name!=''" ;
	
	$res3 = mysql_query($sql3);
	$cities=array();
	if(mysql_num_rows($res3)>0){
		while( $row3 = mysql_fetch_assoc( $res3 ) )
		{
			$cities[] = $row3;
		}
		print json_encode($cities);	
	}


//EOF.	