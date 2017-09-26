<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

$req_type	= $_POST["type"];

$nnum		= $_POST["nnum"];     
$title		= $_POST["title"];         
$content	= $_POST["content"];      
$from_date	= $_POST["from_date"];     
$to_date	= $_POST["to_date"];         

$reg_name	= $_SESSION['uName']; //사용자 이름     


if ($req_type == "INSERT") {

	//$sql = "insert into notify(title,content,from_date,to_date,regdate,reg_name) values('$title','$content','$from_date','$to_date',now(),'$reg_name')";

	$sql = "insert into notify (title,content,from_date,to_date,regdate,reg_name) values('$title','$content',now(),now(),now(),'$reg_name')";

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

			
}else if($req_type == "UPDATE"){


	$sql = "update notify set title = '$title', content = '$content', from_date = '$from_date' , to_date = '$to_date' , reg_name = '$reg_name', regdate = now() where nnum='$nnum'";

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

	 

}else if($req_type == "DELETE"){

	//삭제 flag
	$sql = "update notify set status = '1',reg_name = '$reg_name', regdate = now() where nnum='$nnum'";

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

	 

}

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>