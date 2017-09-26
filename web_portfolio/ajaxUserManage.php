<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

//parameters
//time을 넣는다.

//01 사용자등록 ,02 사용자 승인/불가 03.관리자 지정 및 해제 ,ADDR (업체주소변경),PWD(암호변경).USERINFO(사용자정보 변경
$type	= $_POST["type"];

$v_value	= $_POST["v_value"];
$v_member	= $_POST["v_member"];

$v_upd_user	= $_POST["v_upd_user"];  //수정한 사용자 번호


if ($type == "01") {
	
	$ccode    = $_POST["ccode"];   
	$userid   = $_POST["userid"];   
	$password = $_POST["password"];	
	$username = $_POST["username"];	
	$tel1     = $_POST["tel1"];    
	$tel2     = $_POST["tel2"];    
	$tel3     = $_POST["tel3"];    
	$mobile1 =  $_POST["mobile1"]; 	
	$mobile2 =  $_POST["mobile2"]; 	
	$mobile3 =  $_POST["mobile3"]; 	
	$fax1    =  $_POST["fax1"];    
	$fax2    =  $_POST["fax2"];    
	$fax3    =  $_POST["fax3"];    
	$email   =  $_POST["email"];     
	$oauth   =  $_POST["oauth"];        
	$status  =  $_POST["status"];        

	$dump = 0;

	//회원가입 요청시 한번도 해당 회원이 존재하는지 체크해야 함
	$sql = "select count(*) from usermaster where userid = '$userid'";
	$result = $conn->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);

	if( $row[0] > 0) { //insert하려는데 값이 존재한다

		$data2 = array(
				'data'=>$dump,
				'sql'=>$sql,
				'status'=>'Duplicate');

	}else{

		$sql = "insert into usermaster(ccode,userid,password,username,tel1,tel2,tel3,mobile1,mobile2,mobile3,fax1,fax2,fax3,email,oauth,status,regdate) values('$ccode','$userid','$password','$username','$tel1','$tel2','$tel3','$mobile1','$mobile2','$mobile3','$fax1','$fax2','$fax3','$email','$oauth','$status',now())";

		$result = $conn->query($sql);

		if($result)
		{
			 //Record was successfully inserted, respond result back to index page
			$my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
			$data2 = array(
					'data'=>$my_id,
					'status'=>'Success'
			);
		}else{
			$data2 = array(
					'data'=>mysql_error($conn),
					'status'=>'Fail'
			);
		}

	}
	
}else if($type == "02"){
	//사용자 승인/불가


	$sql = "update usermaster set status =  '$v_value' ,upd_user = '$v_upd_user' , regdate = now() where unum in ($v_member)";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }

}
else if($type == "03"){
	//관리자 지정 및 해제

	$sql = "update usermaster set  oauth =  '$v_value' ,upd_user = '$v_upd_user' , regdate = now() where unum in ($v_member)";
				
	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
    			'status'=>'Fail'
    	);
    }
		
}else if($type == "ADDR"){
	//업체주소 변경
	

	$upd_user	= $_POST["upd_user"];  //수정자 번호
	$caddress	= $_POST["caddress"];  //업소주소
	$ccode		= $_POST["ccode"];  //업소주소


	$sql = "update org set caddress = '$caddress', upd_user ='$upd_user', regdate = now() where ccode = '$ccode'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
    			'status'=>'Fail'
    	);
    }
					
}else if($type == "PWD"){
	//암호 변경
	
	$password = $_POST["password"];
	$upd_user	= $_POST["upd_user"];  //수정자 번호
	

	$sql = "update usermaster set password = '$password', upd_user ='$upd_user', regdate = now() where unum = '$upd_user'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
    			'status'=>'Fail'
    	);
    }
					
}else if($type == "USERINFO"){
	//본인 정보 수정 - 전화,핸드폰, 팩스, email
	

	$tel1     = $_POST["tel1"];    
	$tel2     = $_POST["tel2"];    
	$tel3     = $_POST["tel3"];    
	$mobile1 =  $_POST["mobile1"]; 	
	$mobile2 =  $_POST["mobile2"]; 	
	$mobile3 =  $_POST["mobile3"]; 	
	$fax1    =  $_POST["fax1"];    
	$fax2    =  $_POST["fax2"];    
	$fax3    =  $_POST["fax3"];    
	$email   =  $_POST["email"];     
	$upd_user	= $_POST["upd_user"];  //수정자 번호

	$sql = "update usermaster set tel1= '$tel1',tel2= '$tel2',tel3= '$tel3',mobile1 ='$mobile1',mobile2 =  '$mobile2', mobile3 =  '$mobile3',fax1 =  '$fax1',fax2 =  '$fax2',fax3    =  '$fax3', email   =  '$email' , upd_user ='$upd_user', regdate = now() where unum = '$upd_user'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }
					
}else if($type == "UNAME"){
	//사용자명 수정 - 
	

	$username     = $_POST["username"];    
	$upd_user	= $_POST["upd_user"];  //수정자 번호

	$sql = "update usermaster set username= '$username',upd_user ='$upd_user', regdate = now() where unum = '$upd_user'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }
					
}else if($type == "APPROVE_ONE_PERSON"){
	//사용자 승인(단건)


	$sql = "update usermaster set status = 'Y' ,upd_user = '$v_upd_user' , regdate = now() where unum = '$v_value'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }

}else if($type == "DEL"){
	//삭제


	$sql = "update usermaster set status = 'D' ,upd_user = '$v_upd_user' , regdate = now() where unum = '$v_value'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }

}else if($type == "INITPWD"){
	//2017-03-05 암호 초기화 버튼 클릭시


	$sql = "update usermaster set password = '12345' ,upd_user = '$v_upd_user' , regdate = now() where unum = '$v_value'";

	$result = $conn->query($sql);

    if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
    	    	'data'=>$my_id,
				'sql'=>$sql,
    			'status'=>'Success'
		);
    }else{
    	$data2 = array(
    	    	'data'=>mysql_error($conn),
				'sql'=>$sql,
				'status'=>'Fail'
    	);
    }

}

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>