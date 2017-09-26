<?php

require_once 'config.php';
session_start();

//encoding
mysqli_query($conn, "set names utf8");

$stype  = $_POST["stype"];

$sql = "select nnum,title,content,DATE_FORMAT(from_date, '%Y-%m-%d') as f_date ,DATE_FORMAT(to_date, '%Y-%m-%d') as t_date,reg_name,regdate from notify where status = '0' order by nnum desc;"; //삭제되지 않은 정보만 표시

$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
		$data[$i]['nnum'] = $row['nnum'];
		$data[$i]['title'] = $row['title'];
		$data[$i]['content'] = $row['content'];
		$data[$i]['from_date'] = $row['f_date'];
		$data[$i]['to_date'] = $row['t_date'];
		$data[$i]['reg_name'] = $row['reg_name'];
		$data[$i]['regdate'] = $row['regdate'];

			$i++;
   		 }

		$data2 = array(
    	    'data'=>$data,
    	    'sql' =>$sql,
    		'cnt'=>$result->num_rows
		);
		
	

}else{
	
 	 $data2 = array(
	 
		    'data'=>$data[$i]['nnum'] = $i,
    	    'sql' =>$sql,
    		'cnt'=>$i
		);
		
	
}
	echo json_encode($data2,JSON_UNESCAPED_UNICODE);

	$conn->close();

?>