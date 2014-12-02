<?php
include_once('db.php');
error_reporting(0);


	$sql2 ="SELECT date(news.n_post_time) as news_date  FROM news WHERE news.n_post_time!='false' AND news.n_post_time!=''  ORDER BY news.n_post_time ASC ";
	
	$res2 = mysql_query($sql2);
	$cities=array();
	if(mysql_num_rows($res2)>0){
		while( $row2 = mysql_fetch_assoc( $res2 ) )
		{
			$cities[] = $row2;
		}
		print json_encode($cities);	
	}
	


//EOF.	