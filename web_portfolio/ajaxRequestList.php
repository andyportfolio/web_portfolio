<?php

require_once 'config.php';
session_start();

//encoding
mysqli_query($conn, "set names utf8");

$stype  = $_POST["stype"];
$v_type  = $_POST["v_type"]; //매물(type:아파트)

$v_direct_type  = $_POST["v_direct_type"]; //직접입력 여부 0109

$v_category  = $_POST["v_category"];//유형(category:매매)
$v_close  = $_POST["v_close"]; //종료포함여부값

$ccode= $_SESSION['cCode'];    //업소코드


//본업소 건
if ($stype == "MY"){
	//$sql = "select a.rnum,a.reg_date,a.region,a.category,a.type, (select count(*) from request x where x.refer_rnum = a.rnum  and x.req_type = '02') as rcnt ,a.area_from,a.area_to,a.floor_from,a.floor_to,a.sprice_from,a.sprice_to,a.dprice_from,a.dprice_to,a.rprice_from,a.rprice_to, a.title,a.content,a.status from request a where a.req_type = '01' and a.ccode= '$ccode' order by rnum desc;";

	$sql = "select a.rnum,a.reg_date,a.region,a.category,a.type, (select count(*) from request x where x.refer_rnum = a.rnum  and x.req_type = '02') as rcnt ,a.area_from,a.area_to,a.floor_from,a.floor_to,a.sprice_from,a.sprice_to,a.dprice_from,a.dprice_to,a.rprice_from,a.rprice_to, a.title,a.content,a.status 
	from request a where a.req_type = '01' and a.ccode= '$ccode' ";

	//검색 조건 추가
	//0109 전체- 조건 불필요, 조건+선택, 조건+직접입력
	if ($v_type <> "000" && $v_direct_type == "N"){
		$sql = $sql." and a.type = '$v_type' ";
	}else if ($v_type <> "000" && $v_direct_type == "Y"){ 
		//조건+직접입력 임으로 Like검색을 수행
		$sql = $sql." and a.type LIKE '%$v_type%' ";
	}

	if ($v_category <> "000"){
		$sql = $sql." and a.category = '$v_category' ";
	}

	if ($v_close == "Y"){
		// Y이면 종료건만 나온다
		//status = 0 정상, 1 종료
		$sql = $sql." and a.status = '1' ";
	}else{
		// N이면 정상인것만 나온다
		$sql = $sql." and a.status = '0' ";
	}

	$sql = $sql." order by rnum desc; ";


} else{ // 타 업소건 (OT)
   //$sql = "select rnum,reg_date,region,category,type,area_from,area_to,floor_from,floor_to,sprice_from,sprice_to,dprice_from,dprice_to,rprice_from,rprice_to, title,content,status,cname,reg_name from request where req_type = '01' and ccode <> '$ccode' order by rnum desc;"; 

  // $sql = "select rnum,reg_date,region,category,type,area_from,area_to,floor_from,floor_to,sprice_from,sprice_to,dprice_from,dprice_to,rprice_from,rprice_to, title,content,status,cname,reg_name from request where req_type = '01' and ccode <> '$ccode' "; 

	//답장건 추가	
	$sql = "select a.rnum,a.reg_date,a.region,a.category,a.type,(select count(*) from request x where x.req_type = '02' and x.refer_rnum = a.rnum and x.ccode = '$ccode'  ) as rcnt ,a.area_from,a.area_to,a.floor_from,a.floor_to,a.sprice_from,a.sprice_to,a.dprice_from,a.dprice_to,a.rprice_from,a.rprice_to, a.title,a.content,a.status,a.cname,a.reg_name from request a where a.req_type = '01' and a.ccode <> '$ccode' "; 

	//검색 조건 추가
	//if ($v_type <> "000"){
	//	$sql = $sql." and a.type = '$v_type' ";
	//}
	//0109 전체- 조건 불필요, 조건+선택, 조건+직접입력
	if ($v_type <> "000" && $v_direct_type == "N"){
		$sql = $sql." and a.type = '$v_type' ";
	}else if ($v_type <> "000" && $v_direct_type == "Y"){ 
		//조건+직접입력 임으로 Like검색을 수행
		$sql = $sql." and a.type LIKE '%$v_type%' ";
	}



	if ($v_category <> "000"){
		$sql = $sql." and a.category = '$v_category' ";
	}
	
	if ($v_close == "Y"){
		// Y이면 종료건만 나온다
		//status = 0 정상, 1 종료
		$sql = $sql." and a.status = '1' ";
	}else{
		// N이면 정상인것만 나온다
		$sql = $sql." and a.status = '0' ";
	}

	$sql = $sql." order by a.rnum desc; ";

}



$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
			$data[$i]['rnum'] = $row['rnum'];
			$data[$i]['reg_date'] = $row['reg_date'];
			$data[$i]['title'] = $row['title'];


			$data[$i]['rcnt'] = $row['rcnt'];
			$data[$i]['type'] = $row['type'];
			$data[$i]['category'] = $row['category'];

			$data[$i]['area_from'] = $row['area_from'];
			$data[$i]['area_to'] = $row['area_to'];
			$data[$i]['floor_from'] = $row['floor_from'];
			$data[$i]['floor_to'] = $row['floor_to'];
			$data[$i]['sprice_from'] = $row['sprice_from'];
			$data[$i]['sprice_to'] = $row['sprice_to'];
			$data[$i]['dprice_from'] = $row['dprice_from'];
			$data[$i]['dprice_to'] = $row['dprice_to'];
			$data[$i]['rprice_from'] = $row['rprice_from'];
			$data[$i]['rprice_to'] = $row['rprice_to'];

			$data[$i]['region'] = $row['region'];
			$data[$i]['status'] = $row['status'];

			$data[$i]['cname'] = $row['cname'];	//타업소건 용
			$data[$i]['reg_name'] = $row['reg_name']; //타업소건 용

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