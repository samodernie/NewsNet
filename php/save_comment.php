<?php
include_once('db.php');
if ( $_POST['ajax'] == 'save_comment' )
{
	$comment_desc= $_POST['comment'];
	$u_id=$_POST['u_id'];
	$n_id=$_POST['n_id'];
	$sql_save_comment = "INSERT INTO `comment` (`c_id`,`cmt_desc`, `c_status`,`u_id`,`n_id`) VALUES (NULL, '$comment_desc',1,'$u_id','$n_id');";

	mysql_query($sql_save_comment);
	print "saved comment";
    
    //rating
    
    $sql_comment_rating = "update news set rating = rating+5 where n_id = '$n_id';";

	mysql_query($sql_comment_rating);
	print "updated rating";

    //rating from reporter

    $sql_vote_rating_reporter = "update news set rating = rating + (SELECT rating FROM `user` WHERE u_id = news.u_id)/10 where n_id = '$n_id';";

    mysql_query($sql_vote_rating_reporter);
    print "updated rating";    
    
    //reporter rating

    $sql_reporter_rating = "update `user` set rating = rating + 4 WHERE u_id = (select u_id from news where n_id ='$n_id');";

    mysql_query($sql_reporter_rating);
    print "updated user rating";    
    
}
//EOF.	