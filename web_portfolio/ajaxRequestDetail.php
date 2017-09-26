<?php
require_once 'config.php';

session_start();
$num = $_GET['num'];
$type = $_GET['type'];

//encoding
mysqli_query($conn, "set names utf8");

if ($type == "reply"){
	//답장일 경우 - request내용만 select한다.
	$sql = "select a.*,ifnull(b.mname,'') as region_name,ifnull(c.mname,'') as category_name,ifnull(d.mname,'') as type_name,e.* from request a left join codemaster b on  b.bcode = '30'  and b.mcode = a.region left join codemaster c on  c.bcode = '10'  and c.mcode = a.category left join codemaster d on  d.bcode = '20'  and d.mcode = a.type left join usermaster e on  e.unum = a.reg_id where a.rnum ='$num'";
}

$result = $conn->query($sql);
$num_row = $result->num_rows;
$i = 0;
	
if( $result->num_rows > 0) {
		
   while($row = $result->fetch_assoc()) {
			$data[$i]['rnum'] = $row['rnum'];
			$data[$i]['reg_date'] = $row['reg_date'];
			$data[$i]['reg_time'] = $row['reg_time'];
			$data[$i]['category'] = $row['category'];
			$data[$i]['category_name'] = $row['category_name'];
			$data[$i]['type'] = $row['type'];
			$data[$i]['type_name'] = $row['type_name'];
			$data[$i]['region_name1'] = $row['region_name'];
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
			$data[$i]['title'] = $row['title'];
			$data[$i]['content'] = $row['content'];
			$data[$i]['status'] = $row['status'];
			
			$data[$i]['ccode'] = $row['ccode'];	//등록업소
			$data[$i]['cname'] = $row['cname'];//등록업소명
			$data[$i]['reg_id'] = $row['reg_id'];		//등록자
			$data[$i]['reg_name'] = $row['reg_name'];//등록자명

			$data[$i]['tel1'] = $row['tel1'];		
			$data[$i]['tel2'] = $row['tel2'];		
			$data[$i]['tel3'] = $row['tel3'];		

			$data[$i]['mobile1'] = $row['mobile1'];		
			$data[$i]['mobile2'] = $row['mobile2'];		
			$data[$i]['mobile3'] = $row['mobile3'];		

			$data[$i]['fax1'] = $row['fax1'];		
			$data[$i]['fax2'] = $row['fax2'];		
			$data[$i]['fax3'] = $row['fax3'];		


			$data[$i]['email'] = $row['email'];		
		

			$i++;
   		 }

		$data2 = array(
    	    'data'=>$data,
    		'cnt'=>$result->num_rows
		);
		
	echo json_encode($data2,JSON_UNESCAPED_UNICODE);

}

$conn->close();

?>