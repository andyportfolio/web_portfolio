<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

//parameters
//time을 넣는다.

//사용자 정보가 있는지 확인후 있으면 암호를 초기화 하고 메일을 발송한다.

$ccode		= $_POST["ccode"];  //업소코드
$userid		= $_POST["userid"]; //사용자 id
$username	= $_POST["username"]; //사용자명
$email		= $_POST["email"];  //email 번호


$dump = 0;

//입력값에 맞는 회원이 존재하는제 체크
$sql = "select count(*) from usermaster where ccode = '$ccode' and userid = '$userid' and username = '$username' and email = '$email' ";

$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);

	if( $row[0] > 0) { // 값이 존재하면 reset을 수행후 email을 보낸다.

		$new_pwd	= time(); //1447939125 

		$sql = "update usermaster set password =  '$new_pwd' ,upd_user = '1' , regdate = now() where ccode = '$ccode' and userid = '$userid'";


		$result = $conn->query($sql);

		if($result)
		{
			 //Record was successfully inserted, respond result back to index page
			$my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
			$data2 = array(
					'data'=>$my_id,
					'status'=>'Success'
			);

			  //mail을 발송한다.
			  //$EMAIL : 답장받을 메일주소 (re_manager@naver.com , remanager001)
			  //$NAME : 보낸이             (daworri_manager)
			  //$mailto : 보낼 메일주소
			  //$SUBJECT : 메일 제목
			  //$CONTENT : 메일 내용
			 sendMail("re_manager@naver.com", "daworri_manager", $email , "암호가 초기화 되었습니다.", "초기화된 암호는 "+ $new_pwd +" 입니다." ); 
		}else{
			$data2 = array(
					'data'=>mysql_error($conn),
					'status'=>'Fail'
			);
		}



	}else{

		$data2 = array(
				'data'=>$dump,
				'sql'=>$sql,
				'status'=>'Nodata'); //값이 존재하지 않는다


	}
	
	function sendMail($EMAIL, $NAME, $mailto, $SUBJECT, $CONTENT){
	  //$EMAIL : 답장받을 메일주소
	  //$NAME : 보낸이
	  //$mailto : 보낼 메일주소
	  //$SUBJECT : 메일 제목
	  //$CONTENT : 메일 내용
	  $admin_email = $EMAIL;
	  $admin_name = $NAME;

	  $header = "Return-Path: ".$admin_email."\n";
	  $header .= "From: =?EUC-KR?B?".base64_encode($admin_name)."?= <".$admin_email.">\n";
	  $header .= "MIME-Version: 1.0\n";
	  $header .= "X-Priority: 3\n";
	  $header .= "X-MSMail-Priority: Normal\n";
	  $header .= "X-Mailer: FormMailer\n";
	  $header .= "Content-Transfer-Encoding: base64\n";
	  $header .= "Content-Type: text/html;\n \tcharset=euc-kr\n";

	  $subject = "=?EUC-KR?B?".base64_encode($SUBJECT)."?=\n";
	  $contents = $CONTENT;

	  $message = base64_encode($contents);
	  flush();
	  return mail($mailto, $subject, $message, $header);
	}	

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>