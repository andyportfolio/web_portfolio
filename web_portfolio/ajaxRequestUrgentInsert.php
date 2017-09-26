<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");


$req_type	= "01"; //매수
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

//$ccode		= $_SESSION['cCode'];    //업소코드
//$cname		= $_SESSION['cName'];    //업소명
//$reg_id		= $_SESSION['uNum'];	//사용자번호
//$reg_name	= $_SESSION['uName'];	//사용자 이름



$dump = 0;
//업소당 1일 2회 한정
//당일, 매수 요청 and type ="급매" and 동일업소

$sql = "select count(*) from request where date(reg_date) = date(now()) and req_type='01' and type ='급매' and ccode = '$ccode'";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);

if($row[0] > 1) { //2개를 초과할경우
		$data2 = array(
				'data'=>$dump,
				'sql'=>$sql,
				'status'=>'Exceed');
}else{

	//parameters
	//time을 넣는다.
	$reg_time	= time(); //1447939125 


	$sql = "insert into request(reg_date,reg_time,req_type,category,type,region,area_from,area_to,floor_from,floor_to,room_from,room_to,sprice_from,sprice_to,dprice_from,dprice_to,rprice_from,rprice_to,title,content,ccode,cname,reg_id,reg_name) values(now(),'$reg_time','$req_type','$category','$type','$region','$area_from','$area_to','$floor_from','$floor_to','$room_from','$room_to','$sprice_from','$sprice_to','$dprice_from','$dprice_to','$rprice_from','$rprice_to','$title','$content','$ccode','$cname','$reg_id','$reg_name')";
		
	$result = $conn->query($sql);

	if($result)
	{
		 //Record was successfully inserted, respond result back to index page
		$my_id = $conn->insert_id; //Get ID of last inserted row from MySQL
		$data2 = array(
				'data'=>$my_id,
				//'sql'=>$sql,
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