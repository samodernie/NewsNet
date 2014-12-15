<?php
 error_reporting(0);
include_once('db.php');

if ( $_POST['ajax'] == 'get_category' ){
	$reply=array();
	//$reply["query"]=$_REQUEST["query"];
	
	$get_cat_query="SELECT * FROM category  WHERE cat_type='main' ";
	$res = mysql_query($get_cat_query);
	//print mysql_num_rows($res);
	
	if(mysql_num_rows($res)>0){
		//print "in the if condition";
		while ($row = mysql_fetch_assoc($res))
		{
			//print json_encode("got");
			//$reply['cat_name']=$row['cat_name'];
			//$reply['cat_id']=$row['cat_id'];
			$reply[]=$row;
		}
		
	}
	print json_encode($reply);
	//echo json_encode($reply);
	
}





//EOF.