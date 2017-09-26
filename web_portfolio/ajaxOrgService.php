<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

$req_type	= $_POST["type"];
$ccode		= $_POST["ccode"];     
$cname		= $_POST["cname"];         
$caddress	= $_POST["caddress"];      

$upd_user	= $_SESSION['uNum'];		//사용자번호
$dump = 0;

if ($req_type == "INSERT") {

	$sql = "select count(*) from org where ccode = '$ccode'";
	$result = $conn->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);

	if( $row[0] > 0) { //insert하려는데 값이 존재한다

		$data2 = array(
				'data'=>$dump,
				'sql'=>$sql,
				'status'=>'Dup');

	}else{
		$sql = "insert into org(ccode,cname,caddress,upd_user,regdate) values('$ccode','$cname','$caddress','$upd_user',now())";

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


			
}else if($req_type == "UPDATE"){

	$sql = "select count(*) from org where ccode = '$ccode'";
	$result = $conn->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);

	if( $row[0] == 0) { //update하려는데 값이 없다.

		$data2 = array(
				'data'=>$dump,
				'sql'=>$sql,
				'status'=>'NODATA');

	}else{

		$sql = "update org set cname = '$cname', caddress = '$caddress', upd_user = '$upd_user' where ccode='$ccode'";

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
	 

}

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>