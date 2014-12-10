<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 error_reporting(0);
include_once('db.php');


$news=array();
	$get_news="SELECT news.*,user.*,category.*,date(news.n_post_time) as news_date FROM news,user,category WHERE news.u_id=user.u_id AND category.cat_id=news.cat_id  ORDER BY news.rating DESC;";
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