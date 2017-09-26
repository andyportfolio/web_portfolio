<?php
session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: error.html');
}
?>
<!doctype html>
<html lang="ko">
<head>
 <meta charset="utf-8">
 <title>Check Reply</title>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->

 <link href="css/Master.css" rel="stylesheet" type="text/css">
 <!--<link href="css/common.css" rel="stylesheet" type="text/css">-->
 <link href="plugin/jquery-ui.min.css" rel="stylesheet" >

 <script src="js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="plugin/jquery-ui.min.js"></script>

 <script type="text/javascript" src="js/common.js"></script>

 <script type="text/javascript">

$(document).ready(function(){
  
	$("#dialog-confirm").hide();
	$("#dialog-Sucess").hide();


	//confirm dialog함수를 선언한다.
	function fnReplyConfirmDialog(num,msgtp) {
		$("#dialog-confirm").html("답장수신 확인을 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "답장수신 확인",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback(true,num,msgtp);
				},
					"No": function () {
					$(this).dialog('close');
					callback(false);
				}
			}
		});
	}


	//상태변경 함수를 선언한다.
	function fnStatusChangeDialog(num) {
		$("#dialog-confirm").html("상태를 변경 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "상태변경",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback2(true,num);
				},
					"No": function () {
					$(this).dialog('close');
					callback2(false);
				}
			}
		});
	}


	//alert창
	function customReplyConfirmAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}




 // //회신버튼 click시
 // function replyConfirm(num,msgtp){
  function callback(value,num,msgtp) {
	if (value) {

		//alert("넘어온값" + num);

		var v_content;

		if (msgtp == "OK")
		{
			v_content = "방문하겠습니다.";
		}else if(msgtp == "PD"){
			v_content = "문의후 연락 드리겠습니다.";
		}else if(msgtp == "CL"){
			v_content = "다른 물건을 보신다고 합니다";
		}else if(msgtp == "QT"){
			v_content = $.trim($("#question"+num).attr("value"));
		}	


		//수신자 회사코드,회사명
		var v_originvalue	= $.trim($("#param_origin_rnum").attr("value")); //origin_rnum

		var v_referrnum = $.trim($("#param_referrnum"+num).attr("value"));  //파라메터로 받은 num 과 동일
		var v_ccode	= $.trim($("#param_receive_ccode"+num).attr("value"));
		var v_cname	= $.trim($("#param_receive_cname"+num).attr("value"));


		//alert("v_originvalue" + v_originvalue);
		//alert("v_referrnum" + v_referrnum);
		//alert("v_ccode" + v_ccode);
		//alert("v_cname" + v_cname);
		var v_cCode,v_cName,v_uNum, v_uName;
		//session값 대체
		v_cCode = $.trim($("#session_ccode").attr("value"));
		v_cName = $.trim($("#session_cname").attr("value"));
		v_uNum = $.trim($("#session_unum").attr("value"));
		v_uName = $.trim($("#session_uname").attr("value"));

		$.ajax({
			url: "ajaxRequestInsert.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"req_type"	: "03", //01 request(매수요청),02 reply 03. reply에 대한 회신
					"refer_rnum"	: v_referrnum, 	//reference value
					"origin_rnum"	: v_originvalue, 	//최상위코드
					"content"	: v_content ,
					"receive_ccode"		: v_ccode, 	//수신업소
					"receive_cname"		: v_cname,	//수신업소명
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

				console.dir(ret_val);
				console.log(ret_val);
				
				if($.type(ret_val) === "object" && ret_val.status == "Success" ){
					//console.log("insert 성공");
					//alert("Sucess");
					customReplyConfirmAlert("답장확인 전송을 완료했습니다");
					window.location="replyconfirm_popup.php?num="+v_originvalue;
				}else {
						//alert("not equal");
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
				}
				
			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customReplyConfirmAlert(msg);
				 
			}
		});

	}
  } //-- callback end


  function callback2(value,num) {
	if (value) {

		//alert("넘어온값" + num);

		var v_chgvalue;

	
		//현재상태값
		if ($.trim($("#param_item_status").attr("value")) == "0"){
			v_chgvalue = "1";
		}else{
			v_chgvalue = "0";
		}


		$.ajax({
			url: "ajaxRequestStatusChg.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"rnum"	: num, // 변경대상 번호
					"status"	: v_chgvalue 	//reference value
						
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
	   		},
			success: function(ret_val){

				if($.type(ret_val) === "object" && ret_val.status == "Success" ){
					//console.log("insert 성공");
					//alert("Sucess");
					customReplyConfirmAlert("상태변경을 완료했습니다");
					window.location="replyconfirm_popup.php?num="+num;
				}else {
						//alert("not equal");
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
				}
				
			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customReplyConfirmAlert(msg);
				 
			}
		});

	}
  } //-- callback2 end


	//상태버튼 클릭
	 $(document).on("click", "#change_status", function(event){
		event.preventDefault();
		fnStatusChangeDialog($(this).attr("href")); //방문예정
	});




	//답장에 대한 회신 등록 버튼 클릭
	 $(document).on("click", "#r_tel_btn", function(event){
		event.preventDefault();
		//alert("#r_tel_btn;"+$(this).attr("href"));

		//replyConfirm($(this).attr("href"),"OK"); //방문예정
		fnReplyConfirmDialog($(this).attr("href"),"OK"); //방문예정
	});

	 $(document).on("click", "#r_pending_btn", function(event){
		event.preventDefault();
		//alert("#r_pending_btn;"+$(this).attr("href"));

		//replyConfirm($(this).attr("href"),"PD");//문의후 연락
		fnReplyConfirmDialog($(this).attr("href"),"PD");//문의후 연락
	});
	 $(document).on("click", "#r_cancel_btn", function(event){
		event.preventDefault();
		//alert("#r_cancel_btn;"+$(this).attr("href"));

		//replyConfirm($(this).attr("href"),"CL"); //취소
		fnReplyConfirmDialog($(this).attr("href"),"CL");//문의후 연락
	});

	//1208 추가 - 질문
	 $(document).on("click", "#r_question_btn", function(event){
		event.preventDefault();
		//alert("#r_cancel_btn;"+$(this).attr("href"));

		var tmp = $.trim($("#question"+$(this).attr("href")).attr("value"));

		if (tmp == ""){
			customReplyConfirmAlert("문의사항을 입력하세요");
		}else{
			fnReplyConfirmDialog($(this).attr("href"),"QT");//질문
		}

	});


	//삭제버튼 클릭 -- 화면에서 삭제
	 $(document).on("click", "#r_printdel_btn", function(event){
		event.preventDefault();
		//alert("#r_cancel_btn;"+$(this).attr("href"));

		$("#companyinfo"+$(this).attr("href")).remove();
		$("#btngrp"+$(this).attr("href")).remove();


		$("#print_line_S"+$(this).attr("href")).remove();
		$("#print_line_E"+$(this).attr("href")).remove();

		$(".replyconfirm"+$(this).attr("href")).remove(); //동일한 class삭제 삭제
		

	});

	//Print버튼 클릭 -- 화면의 답장확인 버튼 그룹
	 $(document).on("click", "#print", function(event){
		event.preventDefault();
		//alert("#r_cancel_btn;"+$(this).attr("href"));

		$(".confirm_btn_grp").remove(); //버튼그룹 삭제

		$(".delete_btn").hide(); //X 버튼 삭제

		$(".replyconfirm").hide(); //답장확인 내용

		window.print();
	});



});
 </script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3" class="pop_01"></td>
	</tr>
	<tr>
		<td colspan="3" class="pop_02"></td>
	</tr>
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_3"></td>
				</tr>
				<tr>
					<td>
						<!------- Title & Tab Table S --------->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="21" valign="bottom">
									<!------- Title Table S --------->
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td class="ttl_ico"></td>
											<td width="5"></td>
											<td class="ttl_text">Reply List</td>
											<td width="3"></td>
											<td class="ttl_sub"><!-- - 서브타이틀 --></td>
										</tr>
									</table>
									<!------- Title Table E --------->
								</td>
								<td height="21" valign="bottom" align="right"></td>
							</tr>
							<tr>
								<td colspan="2" class="ttl_line"></td>
							</tr>
						</table>
						<!------- Title & Tab Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Title Table E ------------------------------------------->
<!------------------------------------------ Content Table S ----------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10">
			<input type="hidden" id="session_ccode" name="session_ccode"   value="<?=$_SESSION['cCode']?>"  />
			<input type="hidden" id="session_cname" name="session_cname"   value="<?=$_SESSION['cName']?>"  />
			<input type="hidden" id="session_userid" name="session_userid" value="<?=$_SESSION['userId']?>" />
			<input type="hidden" id="session_unum" name="session_unumum"    value="<?=$_SESSION['uNum']?>"  />
			<input type="hidden" id="session_uname" name="session_uname"    value="<?=$_SESSION['uName']?>" />
			<input type="hidden" id="session_oauth" name="session_oauth"    value="<?=$_SESSION['oAuth']?>" />
		</td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
<?php

	require_once 'config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//답장일 경우 - request내용만 select한다.

	//$sql = "select a.*,b.* from request a left join usermaster b on  b.unum = a.reg_id where (a.rnum ='$num') or (a.req_type = '02' and a.refer_rnum = '$num') or (a.req_type = '03' and a.origin_rnum = '$num') order by rnum , refer_rnum ASC;";
    //$sql = "select a.*,b.* from request a left join usermaster b on  b.unum = a.reg_id where (a.rnum ='$num') or (a.req_type = '02' and a.refer_rnum = '$num') order by rnum , refer_rnum ASC;";

    
	//$sql = "select a.*,b.*,c.caddress from request a left join usermaster b on  b.unum = a.reg_id left join org c on  c.ccode = b.ccode where (a.rnum ='$num') or (a.req_type = '02' and a.refer_rnum = '$num') order by rnum , refer_rnum ASC;";

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
					</td>
				</tr>
				<!-- 매물 - 유형을 크게 표시 -->
				<tr>
					<td>
							<!------- Table S --------->
						<table width="100%" border="2px solid" bordercolor="red" cellpadding="0" cellspacing="1">
							<tr style="text-align:center; padding:1 3 0 3;">
								<td><span style="font-size:16px;color:red"><?=$row['type']?>&nbsp;&nbsp;<?=$row['category']?></span></td>
							</tr>
						</table>
							<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>

											<!------- Table S --------->
				<tr>
					<td>
						<input type="hidden" id="param_origin_rnum"+<?=$row['rnum']?> value="<?=$row['rnum']?>"  />
						<!-- 상태값 0->1 ,1->0 으로 바꿀때 사용 -->
						<input type="hidden" id="param_item_status" value="<?=$row['item_status']?>"  />

					<table id ="requestDetail" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
						<tr class="ct_ttlc">
							<td nowrap width="12%">No</td>
							<td class="ct_rowc" width="38%">
													<!------- Table S --------->
							<table width="100%" border="0" cellpadding="0" cellspacing="1">
								<tr>
									<td width="30%"><?=$row['rnum']?></td>
									<td width="70%">
										<!-------Button Table S--------->
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												
											<? if ($row['item_status'] == '0'){  //정상 ?>
												<td><img src="images/money.png"></td><td><span style="vertical-align:middle">Going</span></td> 
											<? }else{ ?>
												 <td><img src="images/delete.png"></td><td><span style="vertical-align:middle">Closed</span></td>
											<? }?>												
												
												<td class="w_10"></td>
												<td><img src="images/btn_main_l.gif"></td>
												<td background="images/btn_main_c.gif" class="btn" nowrap><a href=<?=$row['rnum']?> id="change_status">Change</a></td>
												<td><img src="images/btn_main_r.gif"></td>
											</tr>
										</table>
										<!-------Button Table E--------->
									</td>
								</tr>
							</table>
													<!------- Table E --------->
							
							
							</td>
							<td nowrap width="12%">Reg</td>
							<td class="ct_rowc" width="38%"><?=$row['reg_date']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap width="12%">Item</td>
							<td class="ct_rowc"  width="38%"><?=$row['type']?></td>
							<td nowrap width="12%">Type</td>
							<td class="ct_rowc"  width="38%"><?=$row['category']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap width="12%">Title</td>
							<td class="ct_rowc" width="38%"><?=$row['title']?></td>
							<td nowrap width="12%">Region</td>
							<td class="ct_rowc" width="38%"><?=$row['region']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td width="12%" nowrap>Content</td>
							<td width="88%" class="ct_rowl" colspan="3"><?=$row['content']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap>Other</td>
							<td width="38%" class="ct_rowc">
													<!------- Table S --------->
								<table width="100%" border="0" cellpadding="0" cellspacing="1">
									<tr>
										<td><?=number_format($row['area_from'])?>~<?=number_format($row['area_to'])?>(m)</td>
									</tr>
									<tr>
										<td><?=$row['floor_from']?>~<?=$row['floor_to']?>(f)</td>
									</tr>
									<tr>
										<td><?=$row['room_from']?>~<?=$row['room_to']?>(r)</td>
									</tr>

								</table>
													<!------- Table E --------->
							</td>
							<td nowrap>Amount</td>
							<td width="38%" class="ct_rowc">
													<!------- Table S --------->
								<table width="100%" border="0" cellpadding="0" cellspacing="1">
									<tr>
										<td>(sale)<?=number_format($row['sprice_from'])?>~<?=number_format($row['sprice_to'])?></td>
									</tr>
									<tr>
										<td>(depo)<?=number_format($row['dprice_from'])?>~<?=number_format($row['dprice_to'])?></td>
									</tr>
									<tr>
										<td>(rent)<?=number_format($row['rprice_from'])?>~<?=number_format($row['rprice_to'])?></td>
									</tr>

								</table>
													<!------- Table E --------->
							</td>

						</tr>

					</table>
											<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>

				<div id="add_err"></div>

<?      
		 $i = $i + 1;
		} //end -------->> if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']) 
		//답장이 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
            $old_reply_rnum = $row['lev2'];
			
?>		

				<tr>
					<td>
						<table  id="print_line_S<?=$row['lev2']?>" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="3" class="print_line"></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td>
												<!------- Table S --------->
						<table id="companyinfo<?=$row['lev2']?>" width="100%" border="0" cellpadding="0" cellspacing="0" class="rct_bg">
							<!-- 답장을 받을 대상자 정보 -->
							<input type="hidden" id="param_referrnum<?=$row['lev2']?>"	    value="<?=$row['lev2']?>"  />
							<input type="hidden" id="param_receive_ccode<?=$row['lev2']?>"  value="<?=$row['ccode2']?>"  />
							<input type="hidden" id="param_receive_cname<?=$row['lev2']?>"  value="<?=$row['cname2']?>"  />

							<tr class="ct_ttlc_my">
								<td width="20%" align="left"><?=$row['cname2']?></td>
								<td width="40%" align="left"><?=$row['content2']?></td>
								<td width="35%" align="right"><?=$row['reg_date2']?></td>
								<td width="5%" align="right">
									<a href=<?=$row['lev2']?> id="r_printdel_btn" class="delete_btn"><img src="images/delete.png"></a>
								</td>
							</tr>
							<tr class="ct_ttlc_my">
								<td width="20%" align="left"><?=$row['reg_name2']?></td>
								<td width="40%" align="left"><?=$row['tel2_1']?>-<?=$row['tel2_2']?>-<?=$row['tel2_3']?>&nbsp;/<?=$row['mobile2_1']?>-<?=$row['mobile2_2']?>-<?=$row['mobile2_3']?></td>
								<td width="40%" align="left" colspan="2"><?=$row['caddress']?></td>
							</tr>
							<tr class="ct_ttlc_reply">
								<td width="100%" colspan="4">
						<!-------Button Table S--------->
						<table id="btngrp<?=$row['lev2']?>" border="0" cellpadding="0" cellspacing="0"  class="confirm_btn_grp" width="100%" >
							<tr>
								<td width="20%" align="left">Reply</td>
								<td width="50%" colspan="2">
										<!------- Table S --------->
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td nowrap><input type="text" id="question<?=$row['lev2']?>" class="fm_reply_input" size="36" value=""></td>
											<td>
												<table  border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td><img src="images/btn_main_l.gif"></td>
														<td background="images/btn_main_c.gif" class="btn" nowrap><a href=<?=$row['lev2']?> id="r_question_btn">Que</a></td>
														<td><img src="images/btn_main_r.gif"></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
										<!------- Table E --------->								
								</td>

								<td width="30%" align="right" colspan="2">

									<table width="100%" border="0" cellpadding="0" cellspacing="0">
									  <tr>
										<td width="33%" align="right">
											<table  border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td><img src="images/btn_main_l.gif"></td>
													<td background="images/btn_main_c.gif" class="btn" nowrap><a href=<?=$row['lev2']?> id="r_tel_btn">Visit</a></td>
													<td><img src="images/btn_main_r.gif"></td>
												</tr>
											</table>
										</td>
										<td width="33%" align="right">
											<table  border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td><img src="images/btn_main_l.gif"></td>
													<td background="images/btn_main_c.gif" class="btn" nowrap><a href=<?=$row['lev2']?> id="r_pending_btn">Tel</a></td>
													<td><img src="images/btn_main_r.gif"></td>
												</tr>
											</table>
										</td>
										<td width="33%" align="right">
											<table  border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td><img src="images/btn_main_l.gif"></td>
													<td background="images/btn_main_c.gif" class="btn" nowrap><a href=<?=$row['lev2']?> id="r_cancel_btn">Wait</a></td>
													<td><img src="images/btn_main_r.gif"></td>
												</tr>
											</table>
										</td>
									  </tr>
									</table>
								</td>
							</tr>
						 </table>
									<!-------Button Table S--------->
								</td>
							</tr>
						</table>
					</td>

				</tr>

				<tr>
					<td>
						<table  id="print_line_E<?=$row['lev2']?>" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="3"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>



<?
		} //end ---------> if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
		//답장수신확인 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){
            $old_confirm_rnum = $row['lev3'];
?>	
				<tr>
					<td>
												<!------- Table S --------->
						<table  width="100%" border="0" cellpadding="0" cellspacing="1" class="replyconfirm<?=$row['lev2']?>">


							<tr>
								<td width="3%" style="bgcolor:white;">→</td>
								<td width="97%" style="color: #808080"><?=$row['content3']?>-<?=$row['reg_name3']?>-<?=$row['reg_date3']?></td>
							</tr>
						</table>
												<!------- Table E --------->					
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>

<?      

		} //end ----> if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){

	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();


?>											
				<tr>

					<td class="h_5"></td>
				</tr>

				<tr>
					<td>
						<!------- button Table S --------->
<table border="0" cellpadding="0" cellspacing="0" align="right">
	<tr>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="print">Print</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>
		<td class="w_3"></td>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="javascript:self.close();">Close</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>
	</tr>
</table>
						<!------- button Table S --------->
					
					</td>

				</tr>


			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
<div id="dialog-confirm"></div>
<div id="dialog-Sucess">
	<p>답장수신확인을 하였습니다.</p>
</div>
</body>
</html>
