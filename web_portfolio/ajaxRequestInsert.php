<?php

require_once 'config.php';

require_once './app/curlRequestAsync.php'; //20161102 추가

session_start();

//encoding
mysqli_query($conn, "set names utf8");

//parameters
//time을 넣는다.

//01 request(매수요청),02 reply 03. reply에 대한 회신
$req_type	= $_POST["req_type"];

if ($req_type == "01") {
	//request
	$reg_time	= time(); //1447939125 
	
	
	$category	= $_POST["category"];     
	$type		= $_POST["type"];         
	$region		= $_POST["region"];      
	$area_from	= $_POST["area_from"];    
	$area_to	= $_POST["area_to"];      
	$floor_from	= $_POST["floor_from"];   
	$floor_to	= $_POST["floor_to"];     
	$room_from	= $_POST["room_from"];   
	$room_to	= $_POST["room_to"];     

	$sprice_from= $_POST["sprice_from"];  
	$sprice_to	= $_POST["sprice_to"];    
	$dprice_from= $_POST["dprice_from"];  
	$dprice_to	= $_POST["dprice_to"];    
	$rprice_from= $_POST["rprice_from"];  
	$rprice_to	= $_POST["rprice_to"];    
	$title		= $_POST["title"];        
	$content	= $_POST["content"];  
	    
	$ccode		= $_POST['cCode'];    //업소코드
	$cname		= $_POST['cName'];    //업소명
	$reg_id		= $_POST['uNum'];	//사용자번호
	$reg_name	= $_POST['uName'];	//사용자 이름


	$origin_rnum	= 0; //20161102 추가

	//$ccode		= $_SESSION['cCode'];    //업소코드
	//$cname		= $_SESSION['cName'];    //업소명
	//$reg_id		= $_SESSION['uNum'];	//사용자번호
	//$reg_name	= $_SESSION['uName'];	//사용자 이름

	 
	$sql = "insert into request(reg_date,reg_time,req_type,category,type,region,area_from,area_to,floor_from,floor_to,room_from,room_to,sprice_from,sprice_to,dprice_from,dprice_to,rprice_from,rprice_to,title,content,ccode,cname,reg_id,reg_name) values(now(),'$reg_time','$req_type','$category','$type','$region','$area_from','$area_to','$floor_from','$floor_to','$room_from','$room_to','$sprice_from','$sprice_to','$dprice_from','$dprice_to','$rprice_from','$rprice_to','$title','$content','$ccode','$cname','$reg_id','$reg_name')";
			
}else if($req_type == "02"){
	//답장

	$reg_time	= time(); //1447939125 
	
	$req_type		= $_POST["req_type"];     
	$refer_rnum		= $_POST["refer_rnum"];     //관련 refer 번호
	$origin_rnum	= $_POST["origin_rnum"];     //최상위 rnum번호
	$content		= $_POST["content"];  
	
	$receive_ccode	= $_POST["receive_ccode"];     //수신대상 업소
	$receive_cname	= $_POST["receive_cname"];  //수신대상 업소명

	$ccode			= $_POST['cCode'];    //업소코드
	$cname			= $_POST['cName'];    //업소명
	$reg_id			= $_POST['uNum'];	//사용자번호
	$reg_name		= $_POST['uName'];	//사용자 이름
		
	//$ccode		= $_SESSION['cCode'];    //업소코드
	//$cname		= $_SESSION['cName'];    //업소명
	//$reg_id		= $_SESSION['uNum'];		//사용자번호
	//$reg_name	= $_SESSION['uName']; //사용자 이름
	
	 
	$sql = "insert into request(reg_date,reg_time,req_type,refer_rnum,origin_rnum,content,ccode,cname,reg_id,reg_name,receive_ccode,receive_cname	) values(now(),'$reg_time','$req_type','$refer_rnum','$origin_rnum','$content','$ccode','$cname','$reg_id','$reg_name','$receive_ccode','$receive_cname')";
				
}else if($req_type == "03"){
	//답장에 대한 회신
	$reg_time		= time(); //1447939125 
	
	$req_type		= $_POST["req_type"];     
	$refer_rnum		= $_POST["refer_rnum"];     //관련 refer 번호
	$origin_rnum	= $_POST["origin_rnum"];     //최상위 rnum번호
	$content		= $_POST["content"];  
	
	$receive_ccode	= $_POST["receive_ccode"];     //수신대상 업소
	$receive_cname	= $_POST["receive_cname"];  //수신대상 업소명

	$ccode			= $_POST['cCode'];    //업소코드
	$cname			= $_POST['cName'];    //업소명
	$reg_id			= $_POST['uNum'];	//사용자번호
	$reg_name		= $_POST['uName'];	//사용자 이름
		
	//$ccode		= $_SESSION['cCode'];    //업소코드
	//$cname		= $_SESSION['cName'];    //업소명
	//$reg_id		= $_SESSION['uNum'];		//사용자번호
	//$reg_name	= $_SESSION['uName']; //사용자 이름
	
	 
	$sql = "insert into request(reg_date,reg_time,req_type,refer_rnum,origin_rnum,content,ccode,cname,reg_id,reg_name,receive_ccode,receive_cname	) values(now(),'$reg_time','$req_type','$refer_rnum','$origin_rnum','$content','$ccode','$cname','$reg_id','$reg_name','$receive_ccode','$receive_cname')";
					
}

//$sql= "insert into request(reg_date,category,type) values(now(),'001','001')";
//$sql = "insert into request(name,question_choice,subject,details,sms1,sms2,sms3,checksms,email,emailaccount,checkemail,orgfilename,regfilename,fileext,filesize,regdate) values('$name','$question_choice','$subject','$details','$sms1','$sms2','$sms3','$checksms','$email','$emailaccount','$checkemail','$orgfilename','$regfilename','$fileext','$filesize','$regdate')";
	
	$result = $conn->query($sql);

	//20161102 추가
   if($result)
    {
         //Record was successfully inserted, respond result back to index page
        $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL

		$data2 = array(
				'sql' => $sql, //sql  값
				'rnum' => $my_id, //insert 된 값
				'req_type' => $req_type,
    	    	'type'=>$type,
    	    	'category'=>$category,
    	    	'title'=>$title,
    	    	'content'=>$content,
    	    	'ccode'=>$ccode,
    	    	'cname'=>$cname,
    	    	'reg_name'=>$reg_name,
    	    	'reg_id'=>$reg_id,	//usermaster key = unum
    	    	'receive_ccode'=>$receive_ccode,
    	    	'receive_cname'=>$receive_cname,
    	    	'refer_rnum'=>$refer_rnum,
    	    	'origin_rnum'=>$origin_rnum,
    			'status'=>'Success'
		);

		//async call    
		curl_request_async($data2); 

    }else{
    	$data2 = array(
    	    	'rnum'=>mysql_error($conn),
    	    	'sql' => $sql, //sql  값
    			'status'=>'Fail'
    	);
    }

  //   if($result)
  //   {
  //        //Record was successfully inserted, respond result back to index page
  //       $my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		// $data2 = array(
  //   	    	'data'=>$my_id,
  //   			'status'=>'Success'
		// );
  //   }else{
  //   	$data2 = array(
  //   	    	'data'=>mysql_error($conn),
  //   			'status'=>'Fail'
  //   	);
  //   }

echo json_encode($data2,JSON_UNESCAPED_UNICODE);

$conn->close(); //close db connection

?>