<?php
include_once('db.php');
error_reporting(0);


	$sql ="SELECT DISTINCT country FROM news WHERE country!='' " ;
	
	
	$res = mysql_query($sql);
	
	
	$countries=array();
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			$countries[] = $row;
		}
		print json_encode($countries);
		
	}


//EOF.	