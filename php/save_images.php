<?php // You need to add server side validation and better error handling here
 error_reporting(0);
 include_once('db.php');
$data = array();
$ext="";
if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

	$uploaddir = '../uploads/';
	$file_name="";
	
	$sql ="SELECT u_id FROM user ORDER BY u_id DESC LIMIT 1";
	$res = mysql_query($sql);
	
	if(mysql_num_rows($res)>0){
		while( $row = mysql_fetch_assoc( $res ) )
		{
			//print $row["u_id"];
			 $file_name=$row["u_id"];
			 
		}
		$file_name=$file_name+1;
	}
	else{
		//print $u_id;
		 $file_name=1;
	}
	

	foreach($_FILES as $file)
	{

		if(move_uploaded_file($file['tmp_name'], $uploaddir .$file_name.'.'.pathinfo($file['name'], PATHINFO_EXTENSION) ))
		{
			//$files[] = $uploaddir .$file['name'];
			$ext=pathinfo($file['name'], PATHINFO_EXTENSION);
		}
		else
		{
		    $error = true;
		}
		
		
	}
	$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
}
else
{
	$data = array('success' => 'Form was submitted', 'formData' => $_POST);
}
$data=$file_name.'.'.$ext;
echo json_encode($data);



//EOF.	