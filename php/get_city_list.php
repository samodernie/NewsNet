<?php
include_once('db.php');
error_reporting(0);


	$sql2 ="SELECT DISTINCT city FROM news WHERE city!='false' AND city!=''  ORDER BY city ASC ";
	
	$res2 = mysql_query($sql2);
	$cities=array();
	if(mysql_num_rows($res2)>0){
		while( $row2 = mysql_fetch_assoc( $res2 ) )
		{
			$cities[] = $row2;
		}
		print json_encode($cities);	
	}
	


//EOF.	