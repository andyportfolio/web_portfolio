<?php
session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: error.html');
}else{

  //echo	$_SESSION['oAuth'];

	//관리자 or System 관리자 가 아닐경우 사용 불가
	if ($_SESSION['oAuth'] == "M" or $_SESSION['oAuth'] == "S"){
	}else{
		header('Location: error.html');
	}
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>회원관리</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
<link href="css/Master.css" rel="stylesheet" type="text/css">
<link href="plugin/jquery-ui.min.css" rel="stylesheet" >


<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

 <script type="text/javascript">

$(document).ready(function(){

	$("#dialog-confirm").hide();
	$("#dialog-Sucess").hide();

	//alert창
	function customAlert_user(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}



	//confirm dialog함수를 선언한다.
	function fnUserManageDialog(type,v_value) {
		$("#dialog-confirm").html("처리를 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "사용자관리",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback(true,type,v_value);
				},
					"No": function () {
					$(this).dialog('close');
					callback(false,type,v_value);
				}
			}
		});
	}


	//confirm dialog함수를 선언한다. -단건처리용 (0110)
	function fnUserManageDialog2(type,v_value) {
		$("#dialog-confirm").html("처리를 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: "사용자관리",
			height: 200,
			width: 400,
			buttons: {
				"Yes": function () {
					$(this).dialog('close');
					callback2(true,type,v_value);
				},
					"No": function () {
					$(this).dialog('close');
					callback2(false,type,v_value);
				}
			}
		});
	}


 //사용자 리스트 보기
 function userListService(){
  
	var oauth_name,use_name,v_class;

	//전체선택 해제
	$("#allCheck").prop("checked",false);

	$.ajax({
		url: "ajaxUserList.php",
		dataType: "json",  
		type: "POST",
		data :{
			"stype"    : "s"
		},
		cache: false,
		beforeSend:function(){
			$("#userlist_msg_div").css('display', 'inline', 'important');
			$("#userlist_msg_div").html("<img src='images/ajax-loader.gif' /> Loading...");
		},
		success: function(ret_val){
			//console.dir(ret_val);
			
			//console.log("requestlist값type은---"+$.type(ret_val));
	    	//console.log("requestlist값cnt--"+$.type(ret_val.cnt));

			$("#userlist_msg_div").hide();

			if(ret_val.cnt > 0 ){
			   console.dir(ret_val);
			   data = ret_val.data;
	
				if (data.length > 0) {

						$("#userlist tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제

					for(i=0; i<data.length; i++){

						if (data[i]['oauth'] == "U")
						{
							oauth_name = "사용자";
						}else if (data[i]['oauth'] == "M")
						{
							oauth_name = "관리자";
						}else{
							oauth_name = "오류";
						}

						v_class = "lt_row";

						//사용불가면 붉은색
						if (data[i]['status'] == "Y")
						{
							use_name = "사용";
							v_class = "lt_row";

						}else if (data[i]['status'] == "N")
						{
							use_name = "불가";
							v_class = "lt_row_None";

						}else{
							use_name = "오류";
							v_class = "lt_row_None";
						}

						//관리자고 사용가능이면 파란색
						if (data[i]['oauth'] == "M" && data[i]['status'] == "Y")
						{
							oauth_name = "관리자";
							v_class = "lt_row_Manager";

						}


						//tmp_html = "<tr class='"+ v_class + "'><td class=''lt_center'' width='2%'>"+"<input type='checkbox' class='cb' rel="+ data[i]['unum']+"></td><td class='lt_center' width='5%'>"+oauth_name+"</td><td class='lt_center' width='5%'>" + use_name +"</td><td class='lt_center' width='8%'>" +data[i]['ccode']+"</td><td class='lt_left' width='20%'>" +data[i]['cname']+"</td><td class='lt_center' width='10%'>" +data[i]['userid']+"</td><td class='lt_left' width='20%'>" +data[i]['username']+"</td><td class='lt_center' width='13%'>" +data[i]['tel1']+"-"+ data[i]['tel2']+"-"+data[i]['tel3']+"</td><td class='lt_center' width='14%'>" +data[i]['mobile1']+"-"+ data[i]['mobile2']+"-"+data[i]['mobile3']+"</td></tr>" ;

						//불가인 경우에만 승인 버튼, 삭제 버튼을 옆에 붙여준다
						if(use_name == "불가"){
							tmp_html = "<tr class='"+ v_class + "'><td class='lt_center'>"+"<input type='checkbox' class='cb' rel="+ data[i]['unum']+"></td><td class='lt_center'>"+oauth_name+"</td><td class='lt_center'>" + use_name +"</td><td class='lt_center'>" +data[i]['ccode']+"</td><td class='lt_center'>" +data[i]['cname']+"</td><td class='lt_left'>" +data[i]['caddress']+"</td><td class='lt_center'>" +data[i]['userid']+"</td><td class='lt_left'>" +data[i]['username']+"</td><td class='lt_center'>" +"<input type='button' value ='승인' id='approve_btn2' name="+ data[i]['unum']+">&nbsp;&nbsp;<input type='button' value ='삭제' id='del_btn' name="+ data[i]['unum']+"></td><td class='lt_center'>" +data[i]['tel1']+"-"+ data[i]['tel2']+"-"+data[i]['tel3']+"</td><td class='lt_center'>" +data[i]['mobile1']+"-"+ data[i]['mobile2']+"-"+data[i]['mobile3']+"</td></tr>" ;
						}else{
							//2017-03-05 수정 : 암호 초기화 기능 추가
							//tmp_html = "<tr class='"+ v_class + "'><td class='lt_center'>"+"<input type='checkbox' class='cb' rel="+ data[i]['unum']+"></td><td class='lt_center'>"+oauth_name+"</td><td class='lt_center'>" + use_name +"</td><td class='lt_center'>" +data[i]['ccode']+"</td><td class='lt_center'>" +data[i]['cname']+"</td><td class='lt_left'>" +data[i]['caddress']+"</td><td class='lt_center'>" +data[i]['userid']+"</td><td class='lt_left'>" +data[i]['username']+"</td><td class='lt_center'></td><td class='lt_center'>" +data[i]['tel1']+"-"+ data[i]['tel2']+"-"+data[i]['tel3']+"</td><td class='lt_center'>" +data[i]['mobile1']+"-"+ data[i]['mobile2']+"-"+data[i]['mobile3']+"</td></tr>" ;

							tmp_html = "<tr class='"+ v_class + "'><td class='lt_center'>"+"<input type='checkbox' class='cb' rel="+ data[i]['unum']+"></td><td class='lt_center'>"+oauth_name+"</td><td class='lt_center'>" + use_name +"</td><td class='lt_center'>" +data[i]['ccode']+"</td><td class='lt_center'>" +data[i]['cname']+"</td><td class='lt_left'>" +data[i]['caddress']+"</td><td class='lt_center'>" +data[i]['userid']+"</td><td class='lt_left'>" +data[i]['username']+"</td><td class='lt_center'>" +"<input type='button' value ='암호초기화' id='initpwd_btn' name="+ data[i]['unum']+"></td><td class='lt_center'>" +data[i]['tel1']+"-"+ data[i]['tel2']+"-"+data[i]['tel3']+"</td><td class='lt_center'>" +data[i]['mobile1']+"-"+ data[i]['mobile2']+"-"+data[i]['mobile3']+"</td></tr>" ;

						}

						$("#userlist").append( tmp_html ); // 테이블 끝에 삽입

					}
					
						$("#searchCnt").text(getDateTime() + " 회원 " +data.length + "명" );  

		        }else{

						$("#searchCnt").text(getDateTime() + " 회원 0명" );  
			    }
			}
	    },
		error: function(xhr, message, errorThrown){
			var msg = xhr.status + " / " + message + " / " + errorThrown;
			console.dir(xhr); 
			customAlert_user(msg);
			 
		}
	 });
  }
  
	userListService(); //page loading 시 사용자 를 불러온다.
 
	$("#search_user").on("click",function(event){
		event.preventDefault();
		userListService();

	});



	//checkbox check
	$("#allCheck").click(function(){
		//만약 전체 선택 체크박스가 체크된상태일경우
		if($("#allCheck").prop("checked")) {
			//해당화면에 전체 checkbox들을 체크해준다
			$("input[type=checkbox]").prop("checked",true);
		// 전체선택 체크박스가 해제된 경우
		} else {
			//해당화면에 모든 checkbox들의 체크를해제시킨다.
			$("input[type=checkbox]").prop("checked",false);
		}
	})




  // 버튼 click시
  //function userService(type,v_value){
  function callback(value,type,v_value) {
	if (value) {
	

		var p=[];
		var v_member="";
		var v_upd_user = $("#session_unum").attr("value"); //사용자 serial no

		//id는 동일하면 식별을 못함으로, class='cb'로 된것을 찾는다
		$("input[type=checkbox].cb").each( function() {
			if($(this).attr('checked')) {
					//p.push($(this).attr('rel'));
					v_member = v_member + $(this).attr('rel') + ","
			}
		} );

		v_member = v_member.slice(0,-1); //제일 마지막 문자열을 자른다
										//11,12,13 형태로 값을 만든다. (SQL에서 where a in () 구문을 사용하기 위해서)


		if (v_member.length == 0)
		{
			customAlert_user("선택된 값이 없습니다.");
			return false;
		}

		$.ajax({
			url: "ajaxUserManage.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"type"	: type,				//02,03
					"v_upd_user"	: v_upd_user, //수정자의 번호
					"v_value"	: v_value,		// Y/N(가능/불가) , M/U(관리자,사용자)
					"v_member" : v_member
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
	   		},
			success: function(ret_val){
				$("#add_err").hide();

				console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					
					if(type == "02"){
						customAlert_user("사용 가능/불가 처리를 완료 하였습니다.");
					}else{
						customAlert_user("관리자 권한관련 처리를 완료 하였습니다.");
					}

					window.location="userMgmt.php";
				}else {
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
				}
				
			},
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_user(msg);
				 
			}
		});

	}
  } //callback(value,type,v_value)


  //단건처리 (승인, 삭제) - 0110
  //암호초기화 추가 - 20170305
  function callback2(value,type,v_value) {
	if (value) {
	

		var v_upd_user = $("#session_unum").attr("value"); //사용자 serial no


		$.ajax({
			url: "ajaxUserManage.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"type"	: type,				//APPROVE_ONE_PERSON , DEL
					"v_upd_user"	: v_upd_user, //수정자의 번호
					"v_value"	: v_value		// 대상자 번호 unum
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
	   		},
			success: function(ret_val){
				$("#add_err").hide();

				console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					
					if(type == "APPROVE_ONE_PERSON"){
						customAlert_user("사용 가능 처리를 완료 하였습니다.");
					}else if(type == "DEL"){
						customAlert_user("삭제 처리를 완료 하였습니다.");
					}else if(type == "INITPWD"){
						customAlert_user("암호를 초기화 하였습니다.");	//암호초기화 추가 - 20170305
					}

					window.location="userMgmt.php";
				}else {
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 처리시 오류가 발생하였습니다.");
				}
				
			},
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_user(msg);
				 
			}
		});

	}
  } //callback2(value,type,v_value)

	//사용승인 클릭시
	 $(document).on("click", "#approve_btn", function(event){
		event.preventDefault();

		fnUserManageDialog("02","Y");
		//userService("02","Y"); //사용승인 (status : Y)

	});


	//사용자 강퇴 클릭시
	 $(document).on("click", "#out_btn", function(event){
		event.preventDefault();

		fnUserManageDialog("02","N");
		//userService("02","N"); //사용불가 (status : N)
	});

	//관리자 권한주기 클릭시
	 $(document).on("click", "#manager_btn", function(event){
		event.preventDefault();

		fnUserManageDialog("03","M");
		//userService("03","M"); //관리자 (oauth : M)
	});

	//관리자 권한뺏기 클릭시
	 $(document).on("click", "#user_btn", function(event){
		event.preventDefault();

		fnUserManageDialog("03","U");
		//userService("03","U"); //사용자만들기 (oauth : U)
	});


	//승인 버튼 클릭시
	 $(document).on("click", "#approve_btn2", function(event){
		event.preventDefault();
		fnUserManageDialog2("APPROVE_ONE_PERSON",$(this).attr("name"));
		
	});


	//삭제 버튼 클릭시
	 $(document).on("click", "#del_btn", function(event){
		event.preventDefault();
		fnUserManageDialog2("DEL",$(this).attr("name"));
		
	});


	//2017-03-05
	//암호 초기화 버튼 클릭시
	 $(document).on("click", "#initpwd_btn", function(event){
		event.preventDefault();
		fnUserManageDialog2("INITPWD",$(this).attr("name"));
		
	});


});
 </script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_10"></td>
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
											<td class="ttl_text">사용자 관리--</td>
											<td width="3"></td>
											<td class="ttl_sub"><span id="searchCnt"></span></td>
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
<input type="hidden" id="session_unum" name="session_unumum"    value="<?=$_SESSION['uNum']?>" 
<div id="add_err"></div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<!------- Search Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr class="ct_ttlc">
		<td class="ct_rowl">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="20%" align="right">
						<!-------Button Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_main_l.gif"></td>
								<td background="images/btn_main_c.gif" class="btn" nowrap><a id="approve_btn" href="#">[승인]사용불가→사용가능</a></td>
								<td><img src="images/btn_main_r.gif"></td>
							</tr>
						</table>
						<!-------Button Table E--------->
				  </td>
					<td  width="20%" align="right">
						<!-------Button Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_main_l.gif"></td>
								<td background="images/btn_main_c.gif" class="btn" nowrap><a id="out_btn" href="#">[강퇴]사용가능→사용불가)</a></td>
								<td><img src="images/btn_main_r.gif"></td>
							</tr>
						</table>
						<!-------Button Table E--------->
				</td>
					<td  width="20%" align="right">
						<!-------Button Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_main_l.gif"></td>
								<td background="images/btn_main_c.gif" class="btn" nowrap><a id="manager_btn" href="#">[권한부여]사용자→관리자</a></td>
								<td><img src="images/btn_main_r.gif"></td>
							</tr>
						</table>
						<!-------Button Table E--------->
				  </td>
					<td  width="20%" align="right">
						<!-------Button Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_main_l.gif"></td>
								<td background="images/btn_main_c.gif" class="btn" nowrap><a id="user_btn" href="#">[권한회수]관리자→사용자</a></td>
								<td><img src="images/btn_main_r.gif"></td>
							</tr>
						</table>
						<!-------Button Table E--------->
				</td>

					<td  width="20%" align="right">
					<div id="userlist_msg_div"></div>
						<!-------Button Search Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_seac_l.gif"></td>
								<td background="images/btn_seac_c.gif" class="btn" nowrap><a id="search_user" href="#">조회</a></td>
								<td><img src="images/btn_seac_r.gif"></td>
							</tr>
						</table>
						<!-------Button Search Table E--------->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
						<!------- Search Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_5"></td>
				</tr>
				<tr>
					<td>
						<!------- Table S --------->
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="50%" style="background-color:#9f9fff" align="center" >관리자 색상</td>
							<td width="50%" style="background-color:#ff9f9f" align="center">사용불가 색상</td>
 						</tr>
					</table>
											<!------- Table E --------->					
					
					</td>
				</tr>

				<tr>
					<td class="h_5"></td>
				</tr>
				<tr>
					<td class="lt_line">
						<!------- List Table S --------->
<table id = "userlist" width="100%" border="0" cellpadding="0" cellspacing="1" class="lt_bg">
	<tr class="lt_ttlc">
		<td width="5%"><input type="checkbox" id="allCheck" value=""></td>
		<td width="5%">권한</td>
		<td width="5%">사용</td>
		<td width="8%">업소코드</td>
		<td width="10%">업소명</td>
		<td width="10%">업소주소</td>
		<td width="10%">사용자ID</td>
		<td width="10%">사용자명</td>
		<td width="10%">기능버튼</td>
		<td width="13%">전화번호</td>
		<td width="14%">핸드폰번호</td>
	</tr>

</table>
						<!------- List Table E --------->
						<!------- List Page Table S --------->

						<!------- List Page Table E --------->
					</td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
</body>
<div id="dialog-confirm"></div>
<div id="dialog-Sucess"><p>처리를 완료했습니다.</p></div>

</html>
