<?php

require_once 'config.php';
session_start();

//encoding
mysqli_query($conn, "set names utf8");

$sql = "select rnum,req_type,reg_date,refer_rnum,type,origin_rnum,title,content,ccode,cname,ifnull(receive_ccode,'') as receive_ccode,ifnull(receive_cname,'') as receive_cname from request where date( reg_date ) = date( now( ) ) 
order by rnum desc;";

$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
			$data[$i]['rnum'] = $row['rnum'];

			$data[$i]['req_type'] = $row['req_type']; //01request, 02reply, 03reply회신
	   
			$data[$i]['reg_date'] = $row['reg_date'];
			$data[$i]['title'] = $row['title'];

			$data[$i]['refer_rnum'] = $row['refer_rnum'];
			$data[$i]['origin_rnum'] = $row['origin_rnum'];

			$data[$i]['type'] = $row['type'];	//1222 매수,급매 구분


			$data[$i]['content'] = $row['content']; //reply, reply회신의 경우 여기에 내용이 들어간다.
			$data[$i]['ccode'] = $row['ccode'];
			$data[$i]['cname'] = $row['cname'];

			$data[$i]['receive_ccode'] = $row['receive_ccode']; //수신처
			$data[$i]['receive_cname'] = $row['receive_cname']; //수신처명
			
			$i++;
   		 }

		$data2 = array(
    	    'data'=>$data,
    		'cnt'=>$result->num_rows
		);
	

}else{
	
	 $data2 = array(
    	    'data'=>$data[$i]['rnum'] = $i,
    		'cnt'=>$i
		);
		
}
	echo json_encode($data2,JSON_UNESCAPED_UNICODE);

	$conn->close();

?>