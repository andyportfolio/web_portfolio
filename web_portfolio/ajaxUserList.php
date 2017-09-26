<?php

require_once 'config.php';
session_start();

//encoding
mysqli_query($conn, "set names utf8");

$stype  = $_POST["stype"];


//$sql = "select a.* ,b.* from usermaster a  LEFT JOIN org as b on b.ccode = a.ccode where a.oauth <> 'S' order by a.username;";

//삭제(status:D)가 된 사용자는 모여주지 않는다
$sql = "select a.* ,b.* from usermaster a  LEFT JOIN org as b on b.ccode = a.ccode where a.oauth <> 'S' and a.status <> 'D' order by a.username;";

$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
		$data[$i]['unum'] = $row['unum'];

		$data[$i]['ccode'] = $row['ccode'];
		$data[$i]['cname'] = $row['cname'];
		$data[$i]['userid'] = $row['userid'];
		$data[$i]['username'] = $row['username'];


		$data[$i]['tel1'] = $row['tel1'];
		$data[$i]['tel2'] = $row['tel2'];
		$data[$i]['tel3'] = $row['tel3'];

		$data[$i]['mobile1'] = $row['mobile1'];
		$data[$i]['mobile2'] = $row['mobile2'];
		$data[$i]['mobile3'] = $row['mobile3'];

		$data[$i]['oauth'] = $row['oauth'];
		$data[$i]['status'] = $row['status'];

		$data[$i]['caddress'] = $row['caddress']; //주소

		$i++;
   	  }

		$data2 = array(
    	    'data'=>$data,
    	    'sql' =>$sql,
    		'cnt'=>$result->num_rows
		);
		
	

}else{
	
 	 $data2 = array(
	 
		    'data'=>$data[$i]['rnum'] = $i,
    	    'sql' =>$sql,
    		'cnt'=>$i
		);
		
	
}
	echo json_encode($data2,JSON_UNESCAPED_UNICODE);

	$conn->close();

?>