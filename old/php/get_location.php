<?php
include_once('db.php');
error_reporting(0);
if ( $_POST['ajax'] == 'get_country' )
{

	//$sql ="SELECT DISTINCT country,city FROM news WHERE city!='false' AND city!='' ";
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
	

}
if ( $_POST['ajax'] == 'get_city' )
{
	
	$sql2 ="SELECT DISTINCT city FROM news WHERE city!='false' AND city!=''" ;
	
	$res2 = mysql_query($sql2);
	$cities=array();
	if(mysql_num_rows($res2)>0){
		while( $row2 = mysql_fetch_assoc( $res2 ) )
		{
			$cities[] = $row2;
		}
		print json_encode($cities);	
	}
	

}
//EOF.	