<?php
session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: error_m.html');
}
?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
	<!--<meta name="apple-mobile-web-app-capable" content="yes">-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<meta name="author" content="andy.mo">
	<title>당업소 매수 상세</title>

	<link rel="apple-touch-icon" href="images/app_icon.png" />
	<link rel="apple-touch-icon-precomposed" href="images/app_icon.png" />
	<link rel="apple-touch-startup-image" href="images/startup.png"/>
	 
	<link href="css/common.css" rel="stylesheet" type="text/css">

	<link href="css/sub_layout.css" rel="stylesheet" type="text/css">
	<link href="css/main_m.css" rel="stylesheet" type="text/css">
	<link href="css/Master.css" rel="stylesheet" type="text/css">


	 <script>
			window.addEventListener('load', function(){setTimeout(scrollTo, 0, 0, 1);}, false);
	 </script>

	 <script src="js/jquery-1.8.3.min.js"></script>
	 <script src="js/common.js"></script> <!--common-->
	   
	<!--[if lt IE 9]> 
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->


	 <script type="text/javascript">

		$(document).ready(function(){
	

			//close 클릭
			$("#close_popup").on("click",function(event){
				event.preventDefault();
				self.close();
			});

		
		});

	 
	 </script>


</head>
<body>
 <!--header s  -->
 <header>
  <div id="wrap_head">
  </div>
 </header>
 <!-- header e  -->
 <!-- article s  -->
 <article>
		<div id="main"><!-- 콘텐츠 삽입 부분 -->
			<h2>답장 리스트</h2>


<?php

	require_once '../config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//답장일 경우 - request내용만 select한다.

	 $sql = "SELECT ifnull(t1.rnum,'0') as lev1,ifnull(t2.rnum,'0') as lev2,ifnull(t3.rnum,'0') as lev3,t1.*,t1.status as item_status,b1.*,
	t2.ccode as ccode2,t2.cname as cname2, t2.reg_name as reg_name2,t2.reg_date as reg_date2, t2.content as content2,
	b2.tel1 as tel2_1, b2.tel2 as tel2_2,b2.tel3 as tel2_3,
	b2.mobile1 as mobile2_1, b2.mobile2 as mobile2_2,b2.mobile3 as mobile2_3,
	o1.caddress,
	t3.cname as cname3, t3.reg_name as reg_name3,t3.reg_date as reg_date3, t3.content as content3 
	FROM request AS t1 
	LEFT JOIN usermaster AS b1 ON b1.unum = t1.reg_id 
	LEFT JOIN request AS t2 ON t2.req_type = '02' and t2.refer_rnum = t1.rnum 
	LEFT JOIN usermaster AS b2 ON b2.unum = t2.reg_id 
	LEFT JOIN org AS o1 ON o1.ccode = t2.ccode 
	LEFT JOIN request AS t3 ON t3.req_type = '03' and t3.refer_rnum = t2.rnum 
	WHERE t1.rnum ='$num';";




	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 0;


	$old_request_rnum = 0; //초기화
	$old_reply_rnum   = 0;
	$old_confirm_rnum = 0;


	if( $result->num_rows > 0) {
			
	   while($row = $result->fetch_assoc()) {

		//level 1의 값이 존재하고, 이전값과 같지 않을 경우 찍는다.
		if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']){
			$old_request_rnum = $row['lev1'];

			
?>
		<div class="div_table">
			<table width="100%" border="2px solid" bordercolor="red" cellpadding="0" cellspacing="1">
				<tr style="text-align:center; padding:1 3 0 3;">
					<td><span style="font-size:16px;color:red"><?=$row['type']?>&nbsp;&nbsp;<?=$row['category']?></span></td>
				</tr>
			</table>

			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_my">번호</td><td class="lt_rowl"><?=$row['rnum']?></td>
				</tr>	
				
				<tr>
					<td class="lt_ttlc_my">등록일</td><td class="lt_rowl"><?=$row['reg_date']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">매물</td><td class="lt_rowl"><?=$row['type']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">유형</td><td class="lt_rowl"><?=$row['category']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">제목</td><td class="lt_rowl"><?=$row['title']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">내용</td><td class="lt_rowl"><?=$row['content']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">지역</td><td class="lt_rowl"><?=$row['region']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">평</td><td class="lt_rowl"><?=number_format($row['area_from'])?>~<?=number_format($row['area_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">층</td><td class="lt_rowl"><?=$row['floor_from']?>~<?=$row['floor_to']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">방</td><td class="lt_rowl"><?=$row['room_from']?>~<?=$row['room_to']?></td>
				</tr>		

				<tr>
					<td class="lt_ttlc_my">매매가</td><td class="lt_rowl"><?=number_format($row['sprice_from'])?>~<?=number_format($row['sprice_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">보증금</td><td class="lt_rowl"><?=number_format($row['dprice_from'])?>~<?=number_format($row['dprice_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">월세</td><td class="lt_rowl"><?=number_format($row['rprice_from'])?>~<?=number_format($row['rprice_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_my">담당자</td><td class="lt_rowl"><?=$row['reg_name']?></td>
				</tr>		
				
			 </table>
		</div>

				

<?      
		 $i = $i + 1;
		} //end -------->> if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']) 
		//답장이 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
            $old_reply_rnum = $row['lev2'];
			
?>		

		<div class="div_table">
			<table>
				<tr class="h_3"><td></td></tr>
			</table>

			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_ot">업소</td><td  class="lt_rowl"><?=$row['cname2']?>(<?=$row['caddress']?>)</td>
				</tr>	
				<tr>
					<td width="20%" class="lt_ttlc_ot">답장</td><td  class="lt_rowl"><?=$row['content2']?></td>
				</tr>		
				<tr>
					<td width="20%" class="lt_ttlc_ot">담당</td><td  class="lt_rowl"><?=$row['reg_name2']?>&nbsp;&nbsp;[<?=$row['reg_date2']?>]</td>
				</tr>		
				<tr>
					<td width="20%" class="lt_ttlc_ot">전화</td><td  class="lt_rowl"><?=$row['tel2_1']?>-<?=$row['tel2_2']?>-<?=$row['tel2_3']?>&nbsp;&nbsp;<a href="tel:<?=$row['tel2_1']?>-<?=$row['tel2_2']?>-<?=$row['tel2_3']?>"><img src='./images/tel.png'/></a></td>
				</tr>		
				<tr>
					<td width="20%" class="lt_ttlc_ot">핸드폰</td><td  class="lt_rowl"><?=$row['mobile2_1']?>-<?=$row['mobile2_2']?>-<?=$row['mobile2_3']?>&nbsp;&nbsp;<a href="tel:<?=$row['mobile2_1']?>-<?=$row['mobile2_2']?>-<?=$row['mobile2_3']?>"><img src='./images/mobile.png'/></a></td>
				</tr>		
			 </table>
		</div>


<?
		} //end ---------> if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
		//답장수신확인 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){
            $old_confirm_rnum = $row['lev3'];
?>	

		<div class="div_table">
			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td class="lt_replyconfirm_rowl">→<?=$row['content3']?>/<?=$row['reg_name3']?>&nbsp;[<?=$row['reg_date3']?>]</td>
				</tr>	
			 </table>
		</div>
<?      

		} //end ----> if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){

	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();


?>											

				<div>
				 <table>
					<tr class="h_10"><td></td></tr>
				 </table>
				 <table width="100%">
					<tr align="right"><td><input class="btn3" type="button" id="close_popup" name="close_popup" value="닫기" /></td></tr>
				 </table>

				
					
				</div>

				<div class="err" id="add_err"></div>
		</div>
 </article>
 <!-- article e  -->
 <!-- footer s  -->
 <footer>
  <div id="footer">
  </div>
  <div class="end_bar">
   <p class="copyrights helv"><span class="logo"></span></p>
   <a href="javascript:window.scrollTo(0,0);"><img src="images/btn_bot_top.png"></a>
  </div>
 </footer>
 <!-- footer e  -->
</body>
</html>
