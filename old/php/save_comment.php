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

}
//EOF.	