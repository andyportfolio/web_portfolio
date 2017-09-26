<?php

require_once 'config.php';
session_start();

//encoding
mysqli_query($conn, "set names utf8");

$stype  = $_POST["stype"];
$ccode= $_SESSION['cCode'];    //업소코드


	$sql = "select ccode,cname,caddress,regdate from org where org_type = 'U' order by ccode desc;";

$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
		$data[$i]['ccode'] = $row['ccode'];
		$data[$i]['cname'] = $row['cname'];
		$data[$i]['caddress'] = $row['caddress'];
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
	 
		    'data'=>$data[$i]['rnum'] = $i,
    	    'sql' =>$sql,
    		'cnt'=>$i
		);
		
	
}
	echo json_encode($data2,JSON_UNESCAPED_UNICODE);

	$conn->close();

?>