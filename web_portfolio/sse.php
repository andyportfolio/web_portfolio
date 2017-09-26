<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

require_once 'sseconfig.php';

session_start();
$gcode = $_SESSION['gCode'];

$dbc = mysqli_connect($host, $user, $password, $database);

//encoding
mysqli_query($dbc, "set names utf8");


//5초 간격을 만든다
$from_time	= strtotime("-5 second"); //1447939120 
$to_time	= time(); //1447939125 
	
	
$query = "select rnum,req_type,refer_rnum,type,origin_rnum,title,content,reg_date,reg_time,cname,ccode,receive_ccode from request where reg_time >= '$from_time'  and reg_time <= '$to_time' ";	

$result = mysqli_query($dbc, $query);
$result_array = array(); 

if( $result->num_rows > 0) {

	while( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ){
		$result_array[] = $row;
	};

	// 결과값을 JSON 형식으로 변환한다. 한글처리포함
	$result_array = json_encode( $result_array ,JSON_UNESCAPED_UNICODE);

	echo "retry: 5000".PHP_EOL; //5초간격으로 client로 송신한다
	echo 'data: ' .$result_array.PHP_EOL;	
	echo PHP_EOL;
	ob_flush();
	flush();
}else{
	echo "retry: 5000".PHP_EOL; //5초간격으로 client로 송신한다
	echo PHP_EOL;
	ob_flush();
	flush();
}
//데이터 사용을 종료
mysqli_free_result($result);
mysqli_close($dbc);

?>
