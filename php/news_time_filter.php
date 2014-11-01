<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 error_reporting(0);
include_once('db.php');

$from_date =$_POST['from_date'];
$to_date=$_POST['to_date'];
$category=$_POST['category'];
$country=$_POST['country'];
$city=$_POST['city'];



 
 $news=array();
	$get_news="SELECT news.*,user.*,category.*,date(news.n_post_time) as news_date 
	FROM news,user,category 
	WHERE news.u_id=user.u_id 
	AND category.cat_id=news.cat_id
	AND category.cat_name LIKE  '%$category%' 
	AND news.country LIKE '%$country%' 
	AND news.city LIKE '%$city%' 
	AND (DATE( news.n_post_time ) 
	BETWEEN '$from_date'
	AND '$to_date' ) 
	ORDER BY n_id DESC";
	$res3 = mysql_query($get_news);
	
	if(mysql_num_rows($res3)>0){
		while($row3 = mysql_fetch_assoc($res3)){
			$news[]=$row3;
		}
		print json_encode($news);
	}else{
		print json_encode("no news");
	}
	
	
?>