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
	function fnUserInfoDialog(type) {
		$("#dialog-confirm").html("수정 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "사용자정보 수정",
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
	function customUserInfoAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}


	 //function reply(){
	  function callback(value,type) {
		if (value) {

			//사용자 번호
			var v_unum	= $.trim($("#unum").attr("value"));
			
			//회사코드
			var v_ccode	= $.trim($("#ccode").attr("value"));

			var v_caddress	= $.trim($("#caddress").attr("value"));

			var v_username	= $.trim($("#username").attr("value"));

			var v_password	= $.trim($("#password").attr("value"));

			var v_tel1		= $.trim($("#tel1").attr("value"));
			var v_tel2		= $.trim($("#tel2").attr("value"));	
			var v_tel3		= $.trim($("#tel3").attr("value"));	
			var v_mobile1	= $.trim($("#mobile1").attr("value"));
			var v_mobile2	= $.trim($("#mobile2").attr("value"));	
			var v_mobile3	= $.trim($("#mobile3").attr("value"));	
			var v_fax1		= $.trim($("#fax1").attr("value"));
			var v_fax2		= $.trim($("#fax2").attr("value"));	
			var v_fax3		= $.trim($("#fax3").attr("value"));	
			var v_email		= $.trim($("#email").attr("value"));	
			
			$.ajax({
				url: "ajaxUserManage.php",
				type: "POST",
				dataType:"JSON",
				data :{
						"type"	: type, //ADDR,UNAME, PWD.USERINFO
						"caddress": v_caddress,	
						"username":	v_username, //12/31
						"password": v_password,		
						"tel1"	  : v_tel1,	
						"tel2"	  : v_tel2,	
						"tel3"	  : v_tel3,	
						"mobile1" : v_mobile1,		
						"mobile2" : v_mobile2,		
						"mobile3" : v_mobile3,		
						"fax1"	  : v_fax1,	
						"fax2"	  : v_fax2,	
						"fax3"	  : v_fax3,	
						"email"	  : v_email	,
						"ccode" : v_ccode,
						"upd_user" : v_unum
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
						//console.log("insert 성공");
						//alert("Sucess");
						customUserInfoAlert("변경처리를 완료했습니다.");
						window.location="userInfo.php";
					}else {
							//alert("not equal");
							$("#add_err").css('display', 'inline', 'important');
							$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
					}
					
				},
				
				error: function(xhr, message, errorThrown){
					var msg = xhr.status + " / " + message + " / " + errorThrown;
					console.dir(xhr); 
					customUserInfoAlert(msg);
					 
				}
			});

		}
	  } //callback(value,num) end



		//업소주소 변경 버튼 클릭
		 $(document).on("click", "#caddress_upd_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#caddress").attr("value"))){
					customUserInfoAlert("업소주소를 입력하세요");
					$("#caddress").focus();
					return false;
				}else{
					fnUserInfoDialog("ADDR");
				}

			
	      });


		//사용자명 변경 버튼 클릭 (2015/12/31)
		 $(document).on("click", "#username_upd_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#username").attr("value"))){
					customUserInfoAlert("사용자명을 입력하세요");
					$("#username").focus();
					return false;
				}else{
					fnUserInfoDialog("UNAME");
				}

			
	      });


		//암호 변경 버튼 클릭
		 $(document).on("click", "#pwd_upd_btn", function(event){
			event.preventDefault();

				//필수 체크
				if(!$.trim($("#password").attr("value"))){
					customUserInfoAlert("암호를 입력하세요");
					$("#password").focus();
					return false;
				}
				
				if(!$.trim($("#re_password").attr("value"))){
					customUserInfoAlert("암호 재입력에 암호를 입력하세요");
					$("#re_password").focus();
					return false;
				}

				if($.trim($("#password").attr("value")) != $.trim($("#re_password").attr("value"))){
					customUserInfoAlert("암호 와 암호 재입력의 값이 서로 다릅니다");
					$("#password").focus();
					return false;
				}else{
					fnUserInfoDialog("PWD");
				}

			
	      });

		//정보수정 변경 버튼 클릭
		 $(document).on("click", "#userinfo_upd_btn", function(event){
			event.preventDefault();

				//전화번호 필수 체크
				if(!$.trim($("#tel1").attr("value"))){
					customUserInfoAlert("전화번호 첫번째 자리를 입력 하세요");
					$("#tel1").focus();
					return false;
				}

				//필수 체크
				if(!$.trim($("#tel2").attr("value"))){
					customUserInfoAlert("전화번호 두번째 자리를 입력 하세요");
					$("#tel2").focus();
					return false;
				}
				//필수 체크
				if(!$.trim($("#tel3").attr("value"))){
					customUserInfoAlert("전화번호 세번째 자리를 입력 하세요");
					$("#tel3").focus();
					return false;
				}


				//핸드폰 번호 필수 체크
				if(!$.trim($("#mobile1").attr("value"))){
					customUserInfoAlert("핸드폰 첫번째 자리를 입력 하세요");
					$("#mobile1").focus();
					return false;
				}

				//필수 체크
				if(!$.trim($("#mobile2").attr("value"))){
					customUserInfoAlert("핸드폰 두번째 자리를 입력 하세요");
					$("#mobile2").focus();
					return false;
				}
				//필수 체크
				if(!$.trim($("#mobile3").attr("value"))){
					customUserInfoAlert("핸드폰 세번째 자리를 입력 하세요");
					$("#mobile3").focus();
					return false;
				}


				fnUserInfoDialog("USERINFO");

			
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
											<td class="ttl_text">사용자 정보 수정</td>
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
<?php

	require_once 'config.php';
	session_start();

	//encoding
	mysqli_query($conn, "set names utf8");

	$unum= $_SESSION['uNum'];    //사용자 번호
	
	$sql = "select a.*, b.* from usermaster a left join org b on  b.ccode = a.ccode where a.unum = '$unum';";

	
	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 0;
	


	if( $result->num_rows > 0) {
			
	   while($row = $result->fetch_assoc()) {

	   if ($row['oauth'] == "U"){ $oauth_name = "사용자";}
	   if ($row['oauth'] == "M"){ $oauth_name = "관리자";}
	   if ($row['oauth'] == "S"){ $oauth_name = "시스템관리자";}

	   if ($row['status'] == "Y"){ $status_name = "사용가능";}
	   if ($row['status'] == "N"){ $status_name = "사용불가";}


?>
	
						<!------- Table S --------->
<table id="companyinfo" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr class="ct_ttlc">
		<td width="20%" nowrap>업소코드</td>
		<td class="ct_rowl" width="80%"  colspan="3"><input type="text" readonly id="ccode" class="fm_input_trans" size="50" value="<?=$row['ccode']?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>업소명</td>
		<td class="ct_rowl" colspan="3"><input type="text" readonly id="cname" class="fm_input_trans" size="50" value="<?=$row['cname']?>"></td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td>업소주소</td>
		<td class="ct_rowl" colspan="3"><input type="text" id="caddress" class="fm_input" size="50" value="<?=$row['caddress']?>"></td>
	</tr>
	<tr>
		<td class="h_10"></td>
	</tr>

	<tr class="ct_ttlc">
		<td>사용자번호</td>
		<td class="ct_rowl" colspan="3"><input type="text" readonly  id="unum" class="fm_input_trans" size="10" value="<?=$row['unum']?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>사용자ID</td>
		<td class="ct_rowl" colspan="3"><input type="text" readonly class="fm_input_trans" size="20" value="<?=$row['userid']?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>사용자명</td>
		<td class="ct_rowl" colspan="3"><input type="text" class="fm_input" size="20" id="username" value="<?=$row['username']?>"> (예: 홍길동 또는 홍길동 실장)</td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td width="20%">암호</td>
		<td class="ct_rowl" width="30%"><input type="password" class="fm_input" id="password"  size="20" value=""></td>
		<td width="20%">암호 재입력</td>
		<td class="ct_rowl"  width="30%"><input type="password" class="fm_input" id="re_password" size="20" value=""></td>

	</tr>
	<tr class="ct_ttlc_ess">
		<td>전화번호</td>
		<td class="ct_rowl" colspan="3"><input type="text" class="fm_input" id="tel1" size="4" maxlength="4"  value="<?=$row['tel1']?>">-<input type="text" class="fm_input" id="tel2" maxlength="4"  size="4" value="<?=$row['tel2']?>">-<input type="text" class="fm_input" id="tel3"  size="4" maxlength="4"  value="<?=$row['tel3']?>"></td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td>핸드폰번호</td>
		<td class="ct_rowl" colspan="3"><input type="text" class="fm_input"  id="mobile1" maxlength="4"  size="4" value="<?=$row['mobile1']?>">-<input type="text" class="fm_input"  id="mobile2" maxlength="4"  size="4" value="<?=$row['mobile2']?>">-<input type="text" class="fm_input"  id="mobile3" size="4" maxlength="4"  value="<?=$row['mobile3']?>"></td>
		
	</tr>
	<tr class="ct_ttlc">
		<td>FAX번호</td>
		<td class="ct_rowl" colspan="3"><input type="text" class="fm_input"  id="fax1" maxlength="4"  size="4" value="<?=$row['fax1']?>">-<input type="text" class="fm_input"  id="fax2" maxlength="4"  size="4" value="<?=$row['fax2']?>">-<input type="text" class="fm_input"  id="fax3" maxlength="4"  size="4" value="<?=$row['fax3']?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>email</td>
		<td class="ct_rowl" colspan="3"><input type="text" class="fm_input" size="30" maxlength="30"   id="email" value="<?=$row['email']?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>권한</td>
		<td class="ct_rowl" colspan="3"><input type="text" readonly class="fm_input_trans" size="10" value="<?=$oauth_name?>"></td>
	</tr>
	<tr class="ct_ttlc">
		<td>상태</td>
		<td class="ct_rowl" colspan="3"><input type="text" readonly class="fm_input_trans" size="10" value="<?=$status_name?>"></td>
	</tr>
	
</table>
						<!------- Table E --------->
<?
	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();


?>
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
	<tr><td width="100%" align="right" colspan="9"><span style="color:red">[알림]사용자정보 변경후에는 반드시 로그아웃 하신후 다시 로그인 해주세요</span></td>
	</tr>

	<tr>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="caddress_upd_btn">업소주소 변경</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="username_upd_btn">사용자명 변경</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="pwd_upd_btn">암호번경</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="userinfo_upd_btn">전화/핸드폰/FAX/email 수정</a></td>
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
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
<div id="dialog-confirm"></div>
<div id="dialog-Sucess">
	<p>정보변경을 하였습니다.</p>
</div>
</body>
</html>
