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
<title>회원업소관리</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
<link href="css/Master.css" rel="stylesheet" type="text/css">
<link href="plugin/jquery-ui.min.css" rel="stylesheet" >

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	var idx;
	$("#orglist").on("click", "tr", function(e) {
		//click한 row
		idx = $(e.currentTarget).index();

		if (idx >0) //title외에 실제 data영역을 click했을경우
		{
			//alert($("#orglist tr:eq("+idx+") > td:eq(0)").text());
			//alert($("#orglist tr:eq("+idx+") > td:eq(1)").text());
			//alert($("#orglist tr:eq("+idx+") > td:eq(2)").text());

			$("#ccode").attr("value",$("#orglist tr:eq("+idx+") > td:eq(0)").text());
			$("#cname").attr("value",$("#orglist tr:eq("+idx+") > td:eq(1)").text());
			$("#caddress").attr("value",$("#orglist tr:eq("+idx+") > td:eq(2)").text());

		}

	});

	//http://www.mkyong.com/jquery/how-to-highlight-table-row-record-on-hover-with-jquery/
	  $('#orglist').on("mouseover", "tr", function(e){
		  idx = $(e.currentTarget).index();

			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
				//$(this).addClass("hover");
				$(this).css("background","#dfdf00");
			}
       }).on("mouseout", "tr", function(e){
			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
			  // $(this).removeClass("hover");
			   $(this).css("background","");
			}
       });

	
	/*
	$('#orglist tr').hover(function() {
		$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});
	*/

	//alert창
	function customAlert_org(val) {

		$("#dialog-confirm").html(val);
		$("#dialog-confirm").dialog();
	}


 //본업소 요청건, 타업소 요청건보기
 function orgListService(){
  
		$.ajax({
		url: "ajaxOrgList.php",
		dataType: "json",  
		type: "POST",
		data :{
			"stype"    : "s"
		},
		cache: false,
		beforeSend:function(){
			$("#orglist_msg_div").css('display', 'inline', 'important');
			$("#orglist_msg_div").html("<img src='images/ajax-loader.gif' /> Loading...");
		},
		success: function(ret_val){
			//console.dir(ret_val);
			
			//console.log("requestlist값type은---"+$.type(ret_val));
	    	//console.log("requestlist값cnt--"+$.type(ret_val.cnt));

			$("#orglist_msg_div").hide();

			if(ret_val.cnt > 0 ){
			   //console.log("requestlist값 있음");
			   data = ret_val.data;
	
				if (data.length > 0) {

						$("#orglist tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제

					for(i=0; i<data.length; i++){

						tmp_html = "<tr class='lt_row'><td class='lt_center' width='10%'>"+ data[i]['ccode']+"</td><td class='lt_left' width='20%'>" +data[i]['cname']+"</td><td class='lt_left' width='30%'>" + data[i]['caddress']+"</td><td class='lt_center' width='20%'>" +data[i]['regdate']+"</td></tr>" ;

						$("#orglist").append( tmp_html ); // 테이블 끝에 삽입

					}
					
						$("#searchCnt").text(getDateTime() + " 회원업소 " +data.length + "건" );  

		        }else{

						$("#searchCnt").text(getDateTime() + " 회원업소 0건" );  
			    }
			}
	    },
		error: function(xhr, message, errorThrown){
			var msg = xhr.status + " / " + message + " / " + errorThrown;
			console.dir(xhr); 
			customAlert_org(msg);
			 
		}
	 });
  }
  
	orgListService(); //page loading 시 본업소 요청건을 불러온다
 
	$("#search_org").on("click",function(event){
		event.preventDefault();
		orgListService();

	});



  //등록,수정버튼 click시
  function orgService(type){
	
		//수신자 회사코드,회사명
		var v_ccode		= $.trim($("#ccode").attr("value"));
		var v_cname		= $.trim($("#cname").attr("value"));
		var v_caddress	= $.trim($("#caddress").attr("value"));


		$.ajax({
			url: "ajaxOrgService.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"type"	: type,				//INSERT,UPDATE
					"ccode"	: v_ccode, 		
					"cname"	: v_cname, 	
					"caddress"	: v_caddress 
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
	   		},
			success: function(ret_val){
				$("#add_err").hide();

				console.dir(ret_val);
				console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					console.log("insert 성공");

					if(type == "INSERT"){
						customAlert_org("회원업소를 신규등록 하였습니다.");
					}else{
						customAlert_org("회원업소를 수정 하였습니다.");
					}
					window.location="orgMgmt.php";
				}else if(ret_val.status == "Dup" ){
					customAlert_org("동일한 업소코드를 가진 업소가 이미 존재합니다.");

				}else if(ret_val.status == "NODATA" ){
					customAlert_org("수정할 업소가 없습니다.");

				}else {
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 저장시 오류가 발생하였습니다.");
				}
				
			},
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_org(msg);
				 
			}
		});

	}

	//신규등록
	 $(document).on("click", "#insert_org_btn", function(event){
		event.preventDefault();

		if(!$("#ccode").attr("value")){
			customAlert_org("업소코드를 입력하세요");
			$("#ccode").focus();
			return false;
		}

		if(!$("#cname").attr("value")){
			customAlert_org("업소명를 입력하세요");
			$("#cname").focus();
			return false;
		}

		orgService("INSERT"); //저장
	});

	//수정등록
	 $(document).on("click", "#update_org_btn", function(event){
		event.preventDefault();
		
		if(!$("#ccode").attr("value")){
			customAlert_org("업소코드를 입력하세요");
			$("#ccode").focus();
			return false;
		}

		if(!$("#cname").attr("value")){
			customAlert_org("업소명를 입력하세요");
			$("#cname").focus();
			return false;
		}

		orgService("UPDATE"); //저장
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
											<td class="ttl_text">회원업소관리</td>
											<td width="3"></td>
											<td class="ttl_sub"><!-- - 서브타이틀 --></td>
										</tr>
									</table>
									<!------- Title Table E --------->
								</td>
								<td height="21" valign="bottom" align="right"></a></td>
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
					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>
						<!-- 외각 테이블 시작 -->
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="30%" valign="top">
									<!-- 좌측 테이블 시작 -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td>
												<!------- 소타이틀 Table S --------->
												<table border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td><table border="0" cellpadding="0" cellspacing="0"><tr><td class="ttl_sub_ico"></td></tr></table></td>
														<td class="w_5"></td>
														<td class="ttl_sub_text">회원업소 정보</td>
													</tr>
												</table>
												<!------- 소타이틀 Table E --------->
											</td>
										</tr>
										
										<tr>
											<td class="lt_line">

						<!------- Table S --------->
						<!------- Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr class="ct_ttlc_ess">
		<td width="12%" nowrap>업소코드</td>
		<td class="ct_rowl" width="38%"><input type="text" id="ccode" class="fm_input" size="5" maxlength="5" value="">(5자)</td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td width="12%" nowrap>업소명</td>
		<td class="ct_rowl"><input type="text" class="fm_input" id="cname" size="30" maxlength="30" value="">(30자)</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="12%" nowrap>주소</td>
		<td class="ct_rowl"><input type="text" class="fm_input" id="caddress" size="50" maxlength="50" value=""></td>
	</tr>

</table>
						<!------- Table E --------->


											</td>
										</tr>
										<tr>
											<td class="h_10"></td>
										</tr>

										<tr>
											<td>
						<!------- button Table S --------->
<div id="add_err"></div>
<table border="0" cellpadding="0" cellspacing="0" align="right">
	<tr>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a id="insert_org_btn" href="#">신규등록</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a id="update_org_btn" href="#">수정</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>
	</tr>
</table>

											</td>
										</tr>
									</table>
									<!-- 좌측 테이블 끝 -->
								</td>
								<td class="w_10"><img src="images/trans.gif" width="10" height="1"></td>
								<td width="70%" valign="top">
									<!-- 우측 테이블 시작 -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td>
												<!------- 소타이틀 Table S --------->
												<table border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td><table border="0" cellpadding="0" cellspacing="0"><tr><td class="ttl_sub_ico"></td></tr></table></td>
														<td class="w_5"></td>
														<td class="ttl_sub_text">회원업소 목록-<span id="searchCnt"></span></td>
							                            <td class="w_10"></td>
													</tr>
												</table>
												<!------- 소타이틀 Table E --------->
											</td>
											<td align="right">
												<!-------Button Search Table S--------->
												<table border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td><img src="images/btn_seac_l.gif"></td>
														<td background="images/btn_seac_c.gif" class="btn" nowrap><a href="#" id="search_org">조회</a></td>
														<td><img src="images/btn_seac_r.gif"></td>
													</tr>
												</table>
												<!-------Button Search Table E--------->
											</td>

										</tr>
										<div id="#orglist_msg_div"></div>
										<tr>
											<td class="lt_line" colspan="2">
												<!------- List Table S --------->
												<table  id ="orglist" width="100%" border="0" cellpadding="0" cellspacing="1" class="lt_bg display">
													<tr class="lt_ttlc">
														<td width="10%">업소코드</td>
														<td width="20%">업소명</td>
														<td width="50%">업소주소</td>
														<td width="20%">등록일시</td>
													</tr>

												</table>
												<!------- List Table E --------->
												<!------- List Page Table S --------->
												<!-- 이전,다음 을 넣고 싶으면 여기에 넣는다-->
												<!------- List Page Table E --------->
											</td>
										</tr>
									</table>
									<!-- 우측 테이블 끝 -->
								</td>
							</tr>
						</table>
						<!-- 외각 테이블 끝 -->

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
<!------------------------------------------ Content Table E ----------------------------------------->
<div id="dialog-confirm"></div>
</body>
</html>