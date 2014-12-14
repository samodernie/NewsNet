<?php
session_start();
 error_reporting(0);
include_once('db.php');
/*
 * Code By Abhishek R. Kaushik
 * Downloaded from http://devzone.co.in
 */
$upload_dir = "../uploads/";
$news_id=$_POST['news_id'];
$headline=$_POST['headline'];
$news_desc=$_POST['news_desc'];
$searchField=$_POST['searchField'];
$country=$_POST['country'];
$city=$_POST['city'];
$u_id=$_SESSION['u_id'];



print $country;

//$new_news_id=$news_id+1;
$news_image=$news_id."p";
$news_video=$news_id."v";


$file_name = array();
array_push($file_name,$news_image,$news_video);

$get_fine_detail=array();



if (isset($_FILES["myfile"])) {

    $no_files = count($_FILES["myfile"]['name']);
    for ($i = 0; $i < $no_files; $i++) {

				if ($_FILES["myfile"]["error"][$i] > 0) {
					print "Error: " . $_FILES["myfile"]["error"][$i] . "<br>";
				} else {
		
				 
					 move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $upload_dir .$file_name[$i].'.'.pathinfo($_FILES["myfile"]['name'][$i], PATHINFO_EXTENSION));
				 
				   array_push($get_fine_detail,$file_name[$i].'.'.pathinfo($_FILES["myfile"]['name'][$i], PATHINFO_EXTENSION));
				
				//move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $upload_dir);
				}//ELSE
		
	}//end of FOR
    //print_r($get_fine_detail);
	$news_image_name=$get_fine_detail[0];
	$news_video_name=$get_fine_detail[1];
	//print $news_image_name." ".$news_video_name;
	//$sql_save_news_media ="INSERT INTO `news`(`image`, `video`) VALUES ('$news_image_name','$news_video_name');";


$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
	$res = mysql_query($get_cat_id);
	
	if(mysql_num_rows($res)>0){
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
        
        //rating-----------------------------------------------------------------------------
    
        $sql_news_rating1 = "update news set rating = rating - 10;";

        print_r(mysql_query($sql_news_rating1));
        print "updated rating";

        //rating from reporter

        $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

        mysql_query($sql_vote_rating_reporter);
        print "updated rating";    

        //reporter rating

        $sql_reporter_rating = "update `user` set rating = rating + 7 WHERE u_id = (select u_id from news where n_id ='$n_id');";

        mysql_query($sql_reporter_rating);
        print "updated user rating";          
        
        //save news
        
		$sql_save_news_media ="INSERT INTO `news`
		(`n_id`, `headline`, `news_desc`, `n_post_time`, `image`, `video`, `city`, `country`, `n_status`, `u_id`, `cat_id`) VALUES 
		('$news_id','$headline','$news_desc',NULL,'$news_image_name','$news_video_name','$city','$country',1,$u_id,'$cat_id');";
		 print_r(mysql_query($sql_save_news_media));
		 
		// print "<br/>";
	}else{
		
		$sql_inset_new_category="INSERT INTO `category`(`cat_id`, `cat_name`, `cat_status`, `u_id`) VALUES (NULL,'$searchField',1,'$u_id')";
		mysql_query($sql_inset_new_category);
		
		//print "insert new category ".$cat_id." ".$searchField." ".$u_id;
		
		$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
		$res = mysql_query($get_cat_id);
		
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
		
        //rating------------------------------------------------------------------------------
    
        $sql_news_rating2 = "update news set rating = rating - 10;";

        print_r(mysql_query($sql_news_rating2));
        print "updated rating";

        //rating from reporter

        $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

        mysql_query($sql_vote_rating_reporter);
        print "updated rating";    

        //reporter rating

        $sql_reporter_rating = "update `user` set rating = rating + 7 WHERE u_id = (select u_id from news where n_id ='$n_id');";

        mysql_query($sql_reporter_rating);
        print "updated user rating";          
                
        //save news        
        
		$sql_save_news_media ="INSERT INTO `news`
		(`n_id`, `headline`, `news_desc`, `n_post_time`, `image`, `video`, `city`, `country`, `n_status`, `u_id`, `cat_id`) VALUES 
		('$news_id','$headline','$news_desc',NULL,'$news_image_name','$news_video_name','$city','$country',1,$u_id,'$cat_id');";
		print_r(mysql_query($sql_save_news_media));
	}
	
	
		
 	  
	
	//print "<br/>".$searchField;
	
	


	
	
}//isset($_FILES["myfile"])
else{

	$news_image_name="no_image_available.jpg";
	$news_video_name="no_image_available.jpg";




$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
	$res = mysql_query($get_cat_id);
	
	if(mysql_num_rows($res)>0){
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
        
        //rating---------------------------------------------------------------------------------------------
    
        $sql_news_rating1 = "update news set rating = rating - 10;";

        print_r(mysql_query($sql_news_rating1));
        print "updated rating";        

        //rating from reporter

        $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

        mysql_query($sql_vote_rating_reporter);
        print "updated rating";    

        //reporter rating

        $sql_reporter_rating = "update `user` set rating = rating + 7 WHERE u_id = (select u_id from news where n_id ='$n_id');";

        mysql_query($sql_reporter_rating);
        print "updated user rating";          
        
        
        //save news
        
		$sql_save_news_media ="INSERT INTO `news`
		(`n_id`, `headline`, `news_desc`, `n_post_time`, `image`, `video`, `city`, `country`, `n_status`, `u_id`, `cat_id`) VALUES 
		('$news_id','$headline','$news_desc',NULL,'$news_image_name','$news_video_name','$city','$country',1,$u_id,'$cat_id');";
		 print_r(mysql_query($sql_save_news_media));
		 
		// print "<br/>";
	}else{
		
		$sql_inset_new_category="INSERT INTO `category`(`cat_id`, `cat_name`, `cat_status`, `u_id`) VALUES (NULL,'$searchField',1,'$u_id')";
		mysql_query($sql_inset_new_category);
		
		//print "insert new category ".$cat_id." ".$searchField." ".$u_id;
		
		$get_cat_id="SELECT cat_id FROM category WHERE (cat_name='$searchField')";
		$res = mysql_query($get_cat_id);
		
		while($row = mysql_fetch_assoc($res)){
			$cat_id=$row['cat_id'];
		}
		
        //rating----------------------------------------------------------
    
        $sql_news_rating1 = "update news set rating = rating - 10;";

        print_r(mysql_query($sql_news_rating1));
        print "updated rating";        

        
        //rating from reporter

        $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

        mysql_query($sql_vote_rating_reporter);
        print "updated rating";    

        //reporter rating

        $sql_reporter_rating = "update `user` set rating = rating + 7 WHERE u_id = (select u_id from news where n_id ='$n_id');";

        mysql_query($sql_reporter_rating);
        print "updated user rating";          
        

        //save news        
        
        
		$sql_save_news_media ="INSERT INTO `news`
		(`n_id`, `headline`, `news_desc`, `n_post_time`, `image`, `video`, `city`, `country`, `n_status`, `u_id`, `cat_id`) VALUES 
		('$news_id','$headline','$news_desc',NULL,'$news_image_name','$news_video_name','$city','$country',1,$u_id,'$cat_id');";
		print_r(mysql_query($sql_save_news_media));
	}
	
	
}//only news




//EOF.