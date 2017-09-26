<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

$rnum	= $_POST["rnum"];
$status		= $_POST["status"];     
$dump = 0;

$sql = "update request set status = '$status' where rnum ='$rnum'";

$result = $conn->query($sql);

if($result)
{
	 //Record was successfully inserted, respond result back to index page
	$my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
	$data2 = array(
			'data'=>$my_id,
			'sql'=>$sql,
			'status'=>'Success');
}else{
	$data2 = array(
			'data'=>mysql_error($conn),
			'sql'=>$sql,
			'status'=>'Fail');
}

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>