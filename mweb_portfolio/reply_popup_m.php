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
	<title>타업소 매수 상세</title>

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
	


		//답장쓰기 버튼 클릭
		 $(document).on("click", "#reply_btn", function(event){
			event.preventDefault();

			//필수 체크
			if(!$.trim($("#reply_details").attr("value"))){
				alert("답장내용을 입력하세요");
				$("#reply_details").focus();
				return false;
			}else{

				var result = confirm("답장 하시겠습니까?");
				
				if(result) {
				   //yes
					callback(true); //저장
				}
			  
				return false;
			}

			
	      });


	 //function reply(){
	  function callback(value) {
		if (value) {

			var v_value	= $.trim($("#param_rnum").attr("value"));
			var v_ccode	= $.trim($("#param_receive_ccode").attr("value"));
			var v_cname	= $.trim($("#param_receive_cname").attr("value"));

			var v_content = $.trim($("#reply_details").attr("value"))+ " --[from Mobile]"; 

			var v_cCode,v_cName,v_uNum, v_uName;
			//session값 대체
			v_cCode = $.trim($("#session_ccode").attr("value"));
			v_cName = $.trim($("#session_cname").attr("value"));
			v_uNum = $.trim($("#session_unum").attr("value"));
			v_uName = $.trim($("#session_uname").attr("value"));

			$.ajax({
				url: "../ajaxRequestInsert.php",
				type: "POST",
				dataType:"JSON",
				data :{
						"req_type"	: "02", //01 request(매수요청),02 reply 03. reply에 대한 회신
						"refer_rnum"	: v_value, 	
						"origin_rnum"	: v_value, 	
						"content"	: v_content ,
						"receive_ccode"		: v_ccode, 	
						"receive_cname"		: v_cname,
						"cCode"		: v_cCode,
						"cName"		: v_cName,
						"uNum"		: v_uNum,
						"uName"		: v_uName

							
				},
				cache: false,
				beforeSend:function(){
					$("#add_err").css('display', 'inline', 'important');
					$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
				},
				success: function(ret_val){

					//console.dir(ret_val);
					//console.log(ret_val);
					
					if(ret_val.status == "Success" ){
						console.log("insert 성공");
						//alert("Sucess");
						alert("답장을 보냈습니다.");
						window.location="reply_popup_m.php?num="+ v_value;
					}else {
							//alert("not equal");
							$("#add_err").css('display', 'inline', 'important');
							$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
					}
					
				},
				
				error: function(xhr, message, errorThrown){
					var msg = xhr.status + " / " + message + " / " + errorThrown;
					console.dir(xhr); 
					alert(msg);
					 
				}
			});

		}
	  } //callback(value,num) end



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
	<input type="hidden" id="session_ccode" name="session_ccode"   value="<?=$_SESSION['cCode']?>"  />
	<input type="hidden" id="session_cname" name="session_cname"   value="<?=$_SESSION['cName']?>"  />
	<input type="hidden" id="session_userid" name="session_userid" value="<?=$_SESSION['userId']?>" />
	<input type="hidden" id="session_unum" name="session_unumum"    value="<?=$_SESSION['uNum']?>"  />
	<input type="hidden" id="session_uname" name="session_uname"    value="<?=$_SESSION['uName']?>" />
	<input type="hidden" id="session_oauth" name="session_oauth"    value="<?=$_SESSION['oAuth']?>" />
  </div>
 </header>
 <!-- header e  -->
 <!-- article s  -->
 <article>
		<div id="main"><!-- 콘텐츠 삽입 부분 -->
			<h2>답장 하기</h2>


<?php

	require_once '../config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//답장일 경우 - request내용만 select한다.

	//$sql = "select a.*,a.status as item_status,b.* from request a left join usermaster b on  b.unum = a.reg_id where a.rnum ='$num' or (a.req_type = '02' and a.refer_rnum = '$num' and  a.ccode = '$ccode') order by rnum ASC;";


	$sql = "select a.*,a.status as item_status,b.*,o1.caddress  from request a left join usermaster b on  b.unum = a.reg_id LEFT JOIN org AS o1 ON o1.ccode = b.ccode where a.rnum ='$num' or (a.req_type = '02' and a.refer_rnum = '$num' and  a.ccode = '$ccode') order by rnum ASC;";

	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 0;


	if( $result->num_rows > 0) {
			
	   while($row = $result->fetch_assoc()) {

		if ($i == 0){ //첫번째 만 내용이고, 두번째 부터는 기존에 했던 답장이다.

?>

		<div class="div_table">

			<table width="100%" border="2px solid" bordercolor="red" cellpadding="0" cellspacing="1">
				<tr style="text-align:center; padding:1 3 0 3;">
					<td><span style="font-size:16px;color:red"><?=$row['type']?>&nbsp;&nbsp;<?=$row['category']?></span></td>
				</tr>
			</table>


			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_ot">번호</td><td class="lt_rowl"><?=$row['rnum']?></td>
				</tr>	
				
				<tr>
					<td class="lt_ttlc_ot">등록일</td><td class="lt_rowl"><?=$row['reg_date']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">매물</td><td class="lt_rowl"><?=$row['type']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">유형</td><td class="lt_rowl"><?=$row['category']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">제목</td><td class="lt_rowl"><?=$row['title']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">내용</td><td class="lt_rowl"><?=$row['content']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">지역</td><td class="lt_rowl"><?=$row['region']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">평</td><td class="lt_rowl"><?=number_format($row['area_from'])?>~<?=number_format($row['area_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">층</td><td class="lt_rowl"><?=$row['floor_from']?>~<?=$row['floor_to']?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">방</td><td class="lt_rowl"><?=$row['room_from']?>~<?=$row['room_to']?></td>
				</tr>		

				<tr>
					<td class="lt_ttlc_ot">매매가</td><td class="lt_rowl"><?=number_format($row['sprice_from'])?>~<?=number_format($row['sprice_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">보증금</td><td class="lt_rowl"><?=number_format($row['dprice_from'])?>~<?=number_format($row['dprice_to'])?></td>
				</tr>		
				<tr>
					<td class="lt_ttlc_ot">월세</td><td class="lt_rowl"><?=number_format($row['rprice_from'])?>~<?=number_format($row['rprice_to'])?></td>
				</tr>		
				
			 </table>
		</div>

		 <table>
			<tr class="h_5"><td></td></tr>
		 </table>

		<div class="div_table">

			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_ot">업소</td><td class="lt_rowl"><?=$row['cname']?>(<?=$row['caddress']?>)</td>
				</tr>	
				<tr>
					<td width="20%" class="lt_ttlc_ot">담당</td><td  class="lt_rowl"><?=$row['reg_name']?></td>
				</tr>	

				<tr>
					<td width="20%" class="lt_ttlc_ot">전화</td><td  class="lt_rowl"><?=$row['tel1']?>-<?=$row['tel2']?>-<?=$row['tel3']?>&nbsp;&nbsp;<a href="tel:<?=$row['tel1']?>-<?=$row['tel2']?>-<?=$row['tel3']?>"><img src='./images/tel.png'/></a></td>
				</tr>		
				<tr>
					<td width="20%" class="lt_ttlc_ot">핸드폰</td><td  class="lt_rowl"><?=$row['mobile1']?>-<?=$row['mobile2']?>-<?=$row['mobile3']?>&nbsp;&nbsp;<a href="tel:<?=$row['mobile1']?>-<?=$row['mobile2']?>-<?=$row['mobile3']?>"><img src='./images/mobile.png'/></a></td>
				</tr>	
					<!-- 답장을 받을 대상자 정보 -->
					<input type="hidden" id="param_rnum" name="param_rnum"    value="<?=$row['rnum']?>"  />
					<input type="hidden" id="param_receive_ccode" name="param_receive_ccode" value="<?=$row['ccode']?>"  />
					<input type="hidden" id="param_receive_cname" name="param_receive_cname" value="<?=$row['cname']?>"  />

			 </table>
		</div>
		

<?      
		 $i = $i + 1;
		//if ($i == 0) -- end
		} else if ($i > 0) { 
?>		
		<div class="div_table">
			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_my">일시</td><td class="lt_rowl"><?=$row['reg_date']?>/<?=$row['reg_name']?></td>
				</tr>		
				<tr>
					<td width="20%" class="lt_ttlc_my">이력</td><td class="lt_rowl"><?=$row['content']?></td>
				<tr>
				</tr>	
			 </table>
		</div>




<?
		}
	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();

?>	

		<div class="div_table">
			 <table>
				<tr class="h_3"><td></td></tr>
			 </table>

			 <table id ="requestDetail" width="100%" border="0" cellspacing="1" cellpadding="0" class="ct_bg">
				<tr>
					<td width="20%" class="lt_ttlc_my">답장</td><td width="80%"><textarea name="" style="width:100%; height:70px; ime-mode:active;" id="reply_details" name="reply_details" class="fm_area_m"></textarea><p class="ps">*1,000자 등록 가능</p></td>
				</tr>
			 </table>
		</div>
											

		<div>
		 <table>
			<tr class="h_3"><td></td></tr>
		 </table>
		 <table width="100%">
			<tr align="right">
			<td width="75%"></td>

			<td  width="10%"><input class="btn4" type="button" id="reply_btn" name="reply_btn" value="답장하기" /></td>
			<td  width="5%"><td>
			<td  width="10%"><input class="btn3" type="button" id="close_popup" name="close_popup" value="닫기" /></td></tr>
		 </table>
			
		</div>

			<div class="err" id="add_err"></div>

	</div><!-- main  -->
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
