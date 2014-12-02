<?php


/*
define ('DB_USER', 'root');
define ('DB_PASSWORD', '');
define ('DB_HOST', 'localhost');
define ('DB_NAME', 'news_net');
*/

define ('DB_USER', 'modernie_iz');
define ('DB_PASSWORD', 'iz1234');
define ('DB_HOST', 'localhost');
define ('DB_NAME', 'modernie_iz');

$con = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)
	or die('Could not connect to database');
mysql_select_db(DB_NAME)
	or die ('Could not select database');

//EOF.