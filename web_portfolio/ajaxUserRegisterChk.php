<?php
//http://www.ondeweb.in/ajax-login-form-with-jquery-and-php/

	require_once 'config.php';
		 
	session_start();
	
	//encoding
	mysqli_query($conn, "set names utf8");
	
	$ccode = $_POST['ccode'];
	$userid = $_POST['userid'];
	$flag = $_POST['flag'];

	$num_row = 0; //init
	
	if ($flag == "org"){
		$sql = "SELECT cname FROM org WHERE ccode='".$ccode."'";
	}
	if ($flag == "id"){
		$sql = "SELECT userid FROM usermaster WHERE userid='".$userid."'";
	}

	$result = $conn->query($sql);
	$num_row = $result->num_rows;

	
	$i = 0;
	if( $result->num_rows > 0) {
		
	   while($row = $result->fetch_assoc()) {

			if ($flag == 'org'){
				$num_row = $row['cname'];
				$data[$i]['cname'] = $row['cname'];
			}else{
				$num_row = $row['userid'];
				$data[$i]['userid'] = $row['userid'];
			}
	   }

	   $data2 = array(
    	    'data'=>$data,
    	    'sql' =>$sql,
    		'cnt'=>$result->num_rows
		);
	}
	else {
	   $num_row = 0;

		if ($flag == 'org'){
		   $data2 = array(
				'data'=>$data[$i]['cname'] = $num_row,
				'sql' =>$sql,
				'cnt'=>$num_row 
			);
		}else{
		   $data2 = array(
				'data'=>$data[$i]['userid'] = $num_row,
				'sql' =>$sql,
				'cnt'=>$num_row 
			);

		}


	}

 // echo $num_row;
  echo json_encode($data2,JSON_UNESCAPED_UNICODE);
  $conn->close();
  
?>
