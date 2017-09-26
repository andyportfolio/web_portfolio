<?php

require_once 'config.php';

session_start();

//encoding
mysqli_query($conn, "set names utf8");

//parameters
//time을 넣는다.

//CLOSE (상태변경),DELETE(삭제)
$type	= $_POST["type"];

$v_closedate	= $_POST["closedate"];
$v_deletedate	= $_POST["deletedate"];
$v_login_deletedate	= $_POST["login_deletedate"];

$upd_user	= $_POST["upd_user"];  //수정자 번호


if($type == "CLOSE"){
	//상태 변경 (status = '0' -> 1)
	
// update request set status = '1'
// where req_type = '01'
//  and status = '0'
//  and reg_date < '2016-11-31'

	$sql = "update request set status = 1 where req_type = '01' and status = 0 and date_format(reg_date , '%Y-%m-%d') <= '$v_closedate'";

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
					

					
}else if($type == "DELETE"){
	//삭제 -캐스케이딩으로 삭제되어야 한다.
	// req_type = 01 and status = 1 (close)
	// req_type = 02, 
	// req_type=03 


// select rnum from request where rnum in (select t2.rnum from request as t1 left join  request as t2 on t2.origin_rnum = t1.rnum and t1.req_type = '01' and t1.status = 1 and date_format(t1.reg_date , '%Y-%m-%d') <= '2015-12-10')or rnum in (select t1.rnum from request as t1 where t1.req_type = '01' and t1.status = 1 and date_format(t1.reg_date , '%Y-%m-%d') <= '2015-12-10')


	$sql = "delete from request where rnum in (select * from  (select t2.rnum from request as t1 left join  request as t2 on t2.origin_rnum = t1.rnum and t1.req_type = '01' and t1.status = 1 and date_format(t1.reg_date , '%Y-%m-%d') <= '$v_deletedate')as t3) or rnum in (select * from  (select t1.rnum from request as t1 where t1.req_type = '01' and t1.status = 1 and date_format(t1.reg_date , '%Y-%m-%d') <= '$v_deletedate')as t4 )";

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

}else if($type == "LOGIN_DELETE"){
	//삭제 -login 정보

	$sql = "delete from loginHistory where date_format(logdate , '%Y-%m-%d') <= '$v_login_deletedate'";


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