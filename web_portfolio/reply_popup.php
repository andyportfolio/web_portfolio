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
 <title>답장</title>
 <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
  <link href="css/Master.css" rel="stylesheet" type="text/css">
 
 <link href="plugin/jquery-ui.min.css" rel="stylesheet" >

 <script src="js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="plugin/jquery-ui.min.js"></script>

 <script type="text/javascript" src="js/common.js"></script>

 <script type="text/javascript">

$(document).ready(function(){
	$("#dialog-confirm").hide();
	$("#dialog-Sucess").hide();


	//confirm dialog함수를 선언한다.
	function fnReplyDialog() {
		$("#dialog-confirm").html("답장을 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "답장",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback(true);
				},
					"No": function () {
					$(this).dialog('close');
					callback(false);
				}
			}
		});
	}

	//alert창
	function customReplyAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}


	 //function reply(){
	  function callback(value) {
		if (value) {

			var v_value	= $.trim($("#param_rnum").attr("value"));
			var v_ccode	= $.trim($("#param_receive_ccode").attr("value"));
			var v_cname	= $.trim($("#param_receive_cname").attr("value"));

			var v_content = $.trim($("#reply_details").attr("value"));	

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
					
					if($.type(ret_val) === "object" && ret_val.status == "Success" ){
						console.log("insert 성공");
						//alert("Sucess");
						customReplyAlert("답장을 보냈습니다.");
						window.location="reply_popup.php?num="+ v_value;
					}else {
							//alert("not equal");
							$("#add_err").css('display', 'inline', 'important');
							$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
					}
					
				},
				
				error: function(xhr, message, errorThrown){
					var msg = xhr.status + " / " + message + " / " + errorThrown;
					console.dir(xhr); 
					customReplyAlert(msg);
					 
				}
			});

		}
	  } //callback(value,num) end


		//답장쓰기 버튼 클릭
		 $(document).on("click", "#reply_btn", function(event){
			event.preventDefault();

			//필수 체크
			if(!$.trim($("#reply_details").attr("value"))){
				customReplyAlert("답장내용을 입력하세요");
				$("#reply_details").focus();
				return false;
			}else{
				fnReplyDialog();
				//reply();
			}

			
	      });


		//Print버튼 클릭 -- 화면의 답장확인 버튼 그룹
		 $(document).on("click", "#print", function(event){
			event.preventDefault();
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
											<td class="ttl_text">Reply</td>
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
					<td class="h_5"></td>
				</tr>

<?php

	require_once 'config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//답장일 경우 - request내용만 select한다.
	//답장에 대한 회신을 확인한다
	//화면은 매수 - 답장  - 답장 회신으로 구성되며 , 재귀적 호출을 구현한다.
	//한줄에 모든 값이 넘어오기때문에 loop를 돌면서 같은 같은 다시 찍지 않아야 한다.
	//
	//
    /* $sql = "SELECT ifnull(t1.rnum,'0') as lev1,ifnull(t2.rnum,'0') as lev2,ifnull(t3.rnum,'0') as lev3,t1.*,t1.status as item_status,b1.*,
t2.cname as cname2, t2.reg_name as reg_name2,t2.reg_date as reg_date2, t2.content as content2,
t3.cname as cname3, t3.reg_name as reg_name3,t3.reg_date as reg_date3, t3.content as content3 
FROM request AS t1 
LEFT JOIN usermaster AS b1 ON b1.unum = t1.reg_id 
LEFT JOIN request AS t2 ON t2.req_type = '02' and t2.refer_rnum = t1.rnum and t2.ccode = '$ccode' 
LEFT JOIN request AS t3 ON t3.req_type = '03' and t3.refer_rnum = t2.rnum 
WHERE t1.rnum ='$num';";
*/
	//0109 추가(주소)-> o1.caddress 
    $sql = "SELECT ifnull(t1.rnum,'0') as lev1,ifnull(t2.rnum,'0') as lev2,ifnull(t3.rnum,'0') as lev3,t1.*,t1.status as item_status,b1.*,
t2.cname as cname2, t2.reg_name as reg_name2,t2.reg_date as reg_date2, t2.content as content2,
t3.cname as cname3, t3.reg_name as reg_name3,t3.reg_date as reg_date3, t3.content as content3,o1.caddress 
FROM request AS t1 
LEFT JOIN usermaster AS b1 ON b1.unum = t1.reg_id 
LEFT JOIN request AS t2 ON t2.req_type = '02' and t2.refer_rnum = t1.rnum and t2.ccode = '$ccode' 
LEFT JOIN org AS o1 ON o1.ccode = t1.ccode
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



				<tr>
					<td>
											<!------- Table S --------->

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
												<td>
											<? if ($row['item_status'] == '0'){  //정상 ?>
												<img src="images/money.png"><span>Going</span> 
											<? }else{ ?>
												  <img src="images/delete.png"><span>Closed</span>
											<? }?>												
												</td>
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
							<td nowrap>Others</td>
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
				<tr>
					<td>

						<!------- Table S --------->
						<table id="companyinfo" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
							<tr class="ct_ttlc">
								<td width="12%" nowrap>Agent</td>
								<td class="ct_rowc" width="38%"><?=$row['cname']?>(<?=$row['caddress']?>)</td>
								<td width="12%" nowrap>Staff</td>
								<td class="ct_rowc"><?=$row['reg_name']?></td>
							</tr>
							<tr class="ct_ttlc">
								<td width="12%" nowrap>Tel</td>
								<td class="ct_rowc" width="38%"><?=$row['tel1']?>-<?=$row['tel2']?>-<?=$row['tel3']?></td>
								<td width="12%" nowrap>Mobile</td>
								<td class="ct_rowc"><?=$row['mobile1']?>-<?=$row['mobile2']?>-<?=$row['mobile3']?></td>
							</tr>
							<tr class="ct_ttlc">
								<td width="12%" nowrap>FAX</td>
								<td class="ct_rowc" width="38%"><?=$row['fax1']?>-<?=$row['fax2']?>-<?=$row['fax3']?></td>
								<td width="12%" nowrap>Email</td>
								<td class="ct_rowc"><?=$row['email']?></td>
							</tr>
							<!-- 답장을 받을 대상자 정보 -->
							<input type="hidden" id="param_rnum" name="param_rnum"    value="<?=$row['rnum']?>"  />
							<input type="hidden" id="param_receive_ccode" name="param_receive_ccode" value="<?=$row['ccode']?>"  />
							<input type="hidden" id="param_receive_cname" name="param_receive_cname" value="<?=$row['cname']?>"  />

						</table>	
						<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>

<?      
		} //end -------->> if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']) 

		//답장이 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
            $old_reply_rnum = $row['lev2'];
?>		

				<tr>
					<td>
											<!------- Table S --------->
						<table id="replyinfo<?=$row['lev2']?>" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr class="ct_ttlc_my">
								<td width="20%" align="left" ><?=$row['reg_name2']?></td>
								<td width="80%" align="right"><?=$row['reg_date2']?></td>
							</tr>
							<tr class="ct_ttlc_my">
								<td width="100%" align="left" colspan="2"><?=$row['content2']?></td>
							</tr>

						</table>
											<!------- Table E --------->					
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
						<!------- Table S --------->
					<table width="100%" border="0" cellpadding="0" cellspacing="1" class="rct_bg">
						<tr class="ct_ttlc_ot">
							<td nowrap width="12%">Reply</td>
							<td class="ct_rowl_ess">
							<textarea name="" style="width:100%; height:70px;" id="reply_details" name="reply_details" class="fm_area"></textarea>
							<p class="ps">* Character 1,000</p>
							</td>
						</tr>

					</table>
											<!------- Table E --------->					
					
					</td>
				</tr>

				<tr>
					<td class="h_5"></td>
				</tr>
				<div id="add_err"></div>


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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="reply_btn">Reply</a></td>
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
	<p>답장을 하였습니다.</p>
</div>
</body>
</html>
