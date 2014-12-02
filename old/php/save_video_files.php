<?php
 error_reporting(0);
include_once('db.php');
/*
 * Code By Abhishek R. Kaushik
 * Downloaded from http://devzone.co.in
 */
$upload_dir = "../uploads/";
$news_id=$_POST['news_id'];
$new_news_id=$news_id+1;
$news_image=$new_news_id."p";
$news_video=$new_news_id."v";


$file_name = array();
array_push($file_name,$news_image,$news_video);

$get_fine_detail=array();



if (isset($_FILES["myfile"])) {

    $no_files = count($_FILES["myfile"]['name']);
    for ($i = 0; $i < $no_files; $i++) {

				if ($_FILES["myfile"]["error"][$i] > 0) {
					print "Error: " . $_FILES["myfile"]["error"][$i] . "<br>";
				} else {
		
				   // move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $upload_dir . $_FILES["myfile"]["name"][$i]);
					 move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $upload_dir .$file_name[$i].'.'.pathinfo($_FILES["myfile"]['name'][$i], PATHINFO_EXTENSION));
				  // print $_FILES["myfile"]["name"][$i] . "<br>";
				   //print $new_news_id;
				   array_push($get_fine_detail,$file_name[$i].'.'.pathinfo($_FILES["myfile"]['name'][$i], PATHINFO_EXTENSION));
				}//ELSE
		
	}//end of FOR
    //print_r($get_fine_detail);
	$news_image_name=$get_fine_detail[0];
	$news_video_name=$get_fine_detail[1];
	print $news_image_name." ".$news_video_name;
	$sql_save_news_media ="INSERT INTO `news`(`image`, `video`) VALUES ('$news_image_name','$news_video_name');";
 	mysql_query($sql_save_news_media);


	
	
}//isset($_FILES["myfile"])



//EOF.