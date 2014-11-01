<?php
 error_reporting(0);
include_once('db.php');
date_default_timezone_set('Asia/Colombo');

if($_POST['ajax'] == 'save_news_data'){
	
	$headline= $_POST['headline'];
	$news_desc= $_POST['news_desc'];
	$searchField= $_POST['searchField'];
	$news_id=$_POST['news_id'];
	$u_id=$_POST['u_id'];
	$city=$_POST['city'];
	$country=$_POST['country'];
	
	
$new_news_id=$news_id+1;
//$news_image=$new_news_id."p";
//$news_video=$new_news_id."v";
	
	$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
	$res = mysql_query($get_cat_id);
	
	if(mysql_num_rows($res)>0){
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
			$sql_update_news_desc="UPDATE `news` SET `headline`='$headline',`news_desc`='$news_desc',`n_status`=1,`u_id`='$u_id',`cat_id`='$cat_id',`city`='$city',`country`='$country' WHERE (n_id='$new_news_id')";
	mysql_query($sql_update_news_desc);
	print "sql updated news".$cat_id." ".$searchField." ".$u_id;
	
	}else{
		$sql_inset_new_category="INSERT INTO `category`(`cat_id`, `cat_name`, `cat_status`, `u_id`) VALUES (NULL,'$searchField',1,'$u_id')";
		mysql_query($sql_inset_new_category);
		
		print "insert new category ".$cat_id." ".$searchField." ".$u_id;
		
		$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
		$res = mysql_query($get_cat_id);
		
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
			$sql_update_news_desc2="UPDATE `news` SET `headline`='$headline',`news_desc`='$news_desc',`n_status`=1,`u_id`='$u_id',`cat_id`='$cat_id',`city`='$city',`country`='$country' WHERE (n_id='$new_news_id')";
	mysql_query($sql_update_news_desc2);
	
		
		
	}
	
	
/*
	$sql_save_news ="INSERT INTO `news`(`n_id`, `headline`, `news_desc`, `image`, `video`, `n_status`, `u_id`, `cat_id`) VALUES (NULL,'$headline','$news_desc','$news_image','$news_video',1,1,$cat_id);";
	 mysql_query($sql_save_news);
	
	print json_encode($news_id);
	*/	

		
}


if($_POST['ajax'] == 'get_last_news'){
	$get_last_news_id="SELECT * FROM news ORDER BY n_id DESC LIMIT 1";
	$res2 = mysql_query($get_last_news_id);
	
	while($row2 = mysql_fetch_assoc($res2)){
		$last_news_id=$row2['n_id'];
	}
	print json_encode($last_news_id);
}



if($_POST['ajax'] == 'get_news'){
	$news=array();
	$get_news="SELECT news.*,user.* FROM news,user WHERE news.u_id=user.u_id ORDER BY n_id DESC";
	$res3 = mysql_query($get_news);
	
	if(mysql_num_rows($res3)>0){
		while($row3 = mysql_fetch_assoc($res3)){
			$news[]=$row3;
		}
		print json_encode($news);
	}else{
		print json_encode("no news");
	}
}

//EOF.	