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
 <title>reply</title>
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
	function fnExecDialog(type) {
		$("#dialog-confirm").html("실행 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "데이터관리 실행",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback(true,type);
				},
					"No": function () {
					$(this).dialog('close');
					callback(false,type);
				}
			}
		});
	}

	//alert창
	function customDataMgmtAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}


	 //function reply(){
	  function callback(value,type) {

		if (value) {

			//사용자 번호
			var v_unum	= $.trim($("#unum").attr("value"));
			
			//기준일자 
			var v_close_date	= $.trim($("#close_date").attr("value"));
			var v_delete_date	= $.trim($("#delete_date").attr("value"));
			var v_login_delete_date	= $.trim($("#login_delete_date").attr("value"));

			
			
			$.ajax({
				url: "ajaxDataManage.php",
				type: "POST",
				dataType:"JSON",
				data :{
						"type"	: type, //CLOSE, DELETE , LOGIN_DELETE
						"closedate": v_close_date,	
						"deletedate":v_delete_date, 
						"login_deletedate":v_login_delete_date, 
						"upd_user" : v_unum
				},
				cache: false,
				beforeSend:function(){
					//$("#add_err").css('display', 'inline', 'important');
					//$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
				},
				success: function(ret_val){

					console.dir(ret_val);
					//console.log(ret_val);
					
					if(ret_val.status == "Success" ){
						//console.log("insert 성공");
						//alert("Sucess");
						customDataMgmtAlert("처리를 완료했습니다.");
						//window.location="dataMgmt.php";
					}else {
							//alert("not equal");
							$("#add_err").css('display', 'inline', 'important');
							$("#add_err").html("<img src='images/alert.png' />처리시 오류가 발생하였습니다.");
					}
					
				},
				
				error: function(xhr, message, errorThrown){
					var msg = xhr.status + " / " + message + " / " + errorThrown;
					console.dir(xhr); 
					customDataMgmtAlert(msg);
					 
				}
			});

		}
	  } //callback(value,num) end



		//close 버튼 클릭
		 $(document).on("click", "#close_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#close_date").attr("value"))){
					customDataMgmtAlert("강제종료 기준일자를 입력하세요");
					$("#close_date").focus();
					return false;
				}


				if($.trim($("#close_date").attr("value")) >= getDate()){
					customDataMgmtAlert("기준일자는 과거일자 이어야 합니다.");
					$("#close_date").focus();
					return false;
				}else{
					fnExecDialog("CLOSE");
				}

			
	      });


		//delete 버튼 클릭 
		 $(document).on("click", "#delete_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#delete_date").attr("value"))){
					customDataMgmtAlert("데이터 삭제 기준일자를 입력하세요");
					$("#delete_date").focus();
					return false;
				}

				if($.trim($("#delete_date").attr("value")) >= getDate()){
					customDataMgmtAlert("기준일자는 과거일자 이어야 합니다.");
					$("#delete_date").focus();
					return false;
				}else{
					fnExecDialog("DELETE");
				}

			
	      });


		//delete 버튼 클릭 
		 $(document).on("click", "#login_delete_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#login_delete_date").attr("value"))){
					customDataMgmtAlert("로그인 정보 삭제기준일자를 입력하세요");
					$("#login_delete_date").focus();
					return false;
				}

				if($.trim($("#login_delete_date").attr("value")) >= getDate()){
					customDataMgmtAlert("기준일자는 과거일자 이어야 합니다.");
					$("#login_delete_date").focus();
					return false;
				}else{
					fnExecDialog("LOGIN_DELETE");
				}

			
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
											<td class="ttl_text">데이터 관리</td>
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
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
	
						<!------- Table S --------->
	<table id="companyinfo" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">

		<tr>
			<td class="h_10" colspan=4><span style="color:red">[가이드]현재로 부터 2개월 이전 데이터는 강제종료 수행요망</span> </td>
		</tr>
		
		<tr class="ct_ttlc_ess">
			<td>물건상태 강제종료 기준일자</td>
			<td class="ct_rowl"><input type="date" class="fm_input" id="close_date">이전 데이터의 상태를 강제종료</td>
			<td class="ct_rowl"><input type='button' value ='실행' id='close_btn'></td>
		</tr>

		<tr>
			<td class="h_10" colspan=4><span style="color:red">[가이드]현재로 부터 4개월 이전 데이터는 삭제 요망</span> </td>
		</tr>

		<tr class="ct_ttlc">
			<td>데이터 삭제 기준일자 </td>
			<td class="ct_rowl"><input type="date" class="fm_input" id="delete_date">이전 데이터를 삭제</td>
			<td class="ct_rowl"><input type='button' value ='실행' id='delete_btn'></td>
		</tr>
		
		<tr>
			<td class="h_10" colspan=4><span style="color:red">[가이드]2개월 로그인 데이터 삭제 요망</span> </td>
		</tr>

		<tr class="ct_ttlc">
			<td>로그인정보 삭제 기준일자 </td>
			<td class="ct_rowl"><input type="date" class="fm_input" id="login_delete_date">이전 데이터를 삭제</td>
			<td class="ct_rowl"><input type='button' value ='실행' id='login_delete_btn'></td>
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
	
		<td class="w_3"></td>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="javascript:self.close();">닫기</a></td>
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
				<tr>
					<td class="h_1"></td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table><!------------------------------------------ Content Table E ----------------------------------------->
<div id="dialog-confirm"></div>
<div id="dialog-Sucess">
	<p>실행 하였습니다.</p>
</div>
</body>
</html>
