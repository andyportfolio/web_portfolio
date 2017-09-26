<?php
//http://www.ondeweb.in/ajax-login-form-with-jquery-and-php/

	require_once 'config.php';
		 
	session_start();
	
	//encoding
	mysqli_query($conn, "set names utf8");
	
	$user_id = $_POST['userId'];
	$user_pw = $_POST['password'];

	$machine = $_POST['machine']; //PC 또는 Mobile접속여부
	
	$num_row = 0; //init
	
	$sql = "SELECT a.ccode, b.cname,a.unum, a.userid, a.username, a.oauth, a.tel1,a.tel2,a.tel3,a.mobile1,a.mobile2,a.mobile3,a.status FROM usermaster a left join org b on  b.ccode = a.ccode WHERE a.userid='".$user_id."' AND a.password='".$user_pw."'";

	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	
	if( $result->num_rows > 0) {
		
	   while($row = $result->fetch_assoc()) {

			if ($row['status'] == 'Y'){

				$data[$i]['status'] = $row['status'];

				$_SESSION['cCode'] = $row['ccode']; //compay code
				$_SESSION['cName'] = $row['cname']; //compay name
					
				$_SESSION['userId'] = $row['userid']; //userid
				$_SESSION['uNum'] = $row['unum']; //serial number
				$_SESSION['uName'] = $row['username'];	//user name
				$_SESSION['oAuth'] = $row['oauth'];	//authorization
		
				$_SESSION['tel'] = $row['tel1']."-".$row['tel2']."-".$row['tel3'];	//tel
				$_SESSION['mobile'] = $row['mobile1']."-".$row['mobile2']."-".$row['mobile3'];		//mobile

				$_SESSION['loginTime'] = date("Y-m-d H:i:s");    	//login time

				$_SESSION['machine'] = $machine;    	//login machine
							
				$num_row = 2;

					//login history write
					$unum=	$row['unum'];
					
					if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
						$ip = $_SERVER['HTTP_CLIENT_IP'];
					} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
						$ip = $_SERVER['REMOTE_ADDR'];
					}

					//login history write
					$sql2 = "insert into loginHistory(unum,logdate,remote_addr,machine,logtype) values('$unum',now(),'$ip','$machine','0')";
					$result2 = $conn->query($sql2);


			 }else{
				$data[$i]['status'] = $row['status'];
				$num_row = 1;
			 }
	   }
		$data2 = array(
			'data'=>$data,
			'sql' =>$sql,
			'cnt'=>$result->num_rows
		);
		//$num_row = 1;
		//echo "Sucess";
	}
		//echo $num_row; // 문자로 넘기니 받는쪽에서 string인데도 처리가 안됨. 변수로 넘김
	
	else {
		$num_row = 0;
		$data2 = array(
			'data'=>$num_row,
			'sql' =>$sql,
			'cnt'=>$num_row
		);
	}

  echo $num_row; // ajax에서 dataType: "json" 을 주지 않으면 string 으로 넘어간다.

  //echo json_encode($data2,JSON_UNESCAPED_UNICODE);

  $conn->close();
  
?>
