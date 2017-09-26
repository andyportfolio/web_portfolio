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
<title>공지사항관리</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
<link href="css/Master.css" rel="stylesheet" type="text/css">
<link href="plugin/jquery-ui.min.css" rel="stylesheet" >

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	var idx;
	$("#notifylist").on("click", "tr", function(e) {
		//click한 row
		idx = $(e.currentTarget).index();

		if (idx >0) //title외에 실제 data영역을 click했을경우
		{
			$("#nnum").attr("value",$("#notifylist tr:eq("+idx+") > td:eq(0)").text());
			$("#title").attr("value",$("#notifylist tr:eq("+idx+") > td:eq(1)").text());
			$("#content").attr("value",$("#notifylist tr:eq("+idx+") > td:eq(2)").text());
			$("#from_date").attr("value",$("#notifylist tr:eq("+idx+") > td:eq(3)").text());
			$("#to_date").attr("value",$("#notifylist tr:eq("+idx+") > td:eq(4)").text());

		}

	});

	//http://www.mkyong.com/jquery/how-to-highlight-table-row-record-on-hover-with-jquery/
	  $('#notifylist').on("mouseover", "tr", function(e){
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

	

	//alert창
	function customAlert_notify(val) {

		$("#dialog-confirm").html(val);
		$("#dialog-confirm").dialog();
	}


 //
 function notifyListService(){
  
		$.ajax({
		url: "ajaxNotifyList.php",
		dataType: "json",  
		type: "POST",
		data :{
			"stype"    : "s"
		},
		cache: false,
		beforeSend:function(){
			$("#notifylist_msg_div").css('display', 'inline', 'important');
			$("#notifylist_msg_div").html("<img src='images/ajax-loader.gif' /> Loading...");
		},
		success: function(ret_val){
			console.dir(ret_val);
			
			//console.log("requestlist값type은---"+$.type(ret_val));
	    	//console.log("requestlist값cnt--"+$.type(ret_val.cnt));

			$("#notifylist_msg_div").hide();

			if(ret_val.cnt > 0 ){
			   //console.log("requestlist값 있음");
			   data = ret_val.data;
	
				if (data.length > 0) {

						$("#notifylist tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제

					for(i=0; i<data.length; i++){

						tmp_html = "<tr class='lt_row'><td class='lt_center'>"+ data[i]['nnum']+"</td><td class='lt_left'>" + data[i]['title']+"</td><td class='lt_left'>" +data[i]['content']+"</td><td class='lt_center'>" +data[i]['from_date']+"</td><td class='lt_center'>" +data[i]['to_date']+"</td><td class='lt_center'>" +data[i]['reg_name']+"</td><td class='lt_center'>" +data[i]['regdate']+"</td></tr>" ;

						$("#notifylist").append( tmp_html ); // 테이블 끝에 삽입

					}
					
						$("#searchCnt").text(getDateTime() + " 공지사항 " +data.length + "건" );  
				}

		    }else{
				$("#searchCnt").text(getDateTime() + " 공지사항 0건" );  
			}
			
	    },
		error: function(xhr, message, errorThrown){
			var msg = xhr.status + " / " + message + " / " + errorThrown;
			console.dir(xhr); 
			customAlert_notify(msg);
			 
		}
	 });
  }
  
	notifyListService(); //page loading 시 본업소 요청건을 불러온다
 
	$("#search_notify").on("click",function(event){
		event.preventDefault();
		notifyListService();

	});



  //등록,수정버튼 click시
  function notifyService(type){
	
		
		var v_nnum		= $.trim($("#nnum").attr("value"));
		var v_title		= $.trim($("#title").attr("value"));
		var v_content	= $.trim($("#content").attr("value"));
		var v_from_date	= $.trim($("#from_date").attr("value"));
		var v_to_date	= $.trim($("#to_date").attr("value"));


		$.ajax({
			url: "ajaxNotifyService.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"type"	: type,				//INSERT,UPDATE
					"nnum"	: v_nnum, 		
					"title"	: v_title, 	
					"content"	: v_content,
					"from_date"	: v_from_date, 		
					"to_date"	: v_to_date
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...");
	   		},
			success: function(ret_val){
				$("#add_err").hide();

				//console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					//console.log("insert 성공");

					if(type == "INSERT"){
						customAlert_notify("공지사항을 신규등록 하였습니다.");
					}else if(type == "UPDATE"){
						customAlert_notify("공지사항을 수정 하였습니다.");
					}else if(type == "DELETE"){
						customAlert_notify("공지사항을 삭제 하였습니다.");
					}

					window.location="notifyMgmt.php";

				}else {
						$("#add_err").css('display', 'inline', 'important');
						$("#add_err").html("<img src='images/alert.png' />데이터 저장시 오류가 발생하였습니다.");
				}
				
			},
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_notify(msg);
				 
			}
		});

	}

	//신규등록
	 $(document).on("click", "#insert_notify_btn", function(event){
		event.preventDefault();

		if(!$("#title").attr("value")){
			customAlert_notify("공지사항 제목을 입력하세요");
			$("#title").focus();
			return false;
		}

		if(!$("#content").attr("value")){
			customAlert_notify("공지사항 내용을 입력하세요");
			$("#content").focus();
			return false;
		}


		if(!$("#from_date").attr("value")){
			customAlert_notify("공지 시작일을 입력하세요");
			$("#from_date").focus();
			return false;
		}

		if(!$("#to_date").attr("value")){
			customAlert_notify("공지 종료일을 입력하세요");
			$("#to_date").focus();
			return false;
		}

		if($("#from_date").attr("value") > $("#to_date").attr("value") ){
			customAlert_notify("공지 시작일이 종료일 이전입니다. 다시 입력하세요");
			$("#from_date").focus();
			return false;
		}

		notifyService("INSERT"); //저장
	});

	//수정등록
	 $(document).on("click", "#update_notify_btn", function(event){
		event.preventDefault();

		if(!$("#nnum").attr("value")){
			customAlert_notify("수정할 공지사항을 선택하세요");
			$("#nnum").focus();
			return false;
		}
		

		if(!$("#title").attr("value")){
			customAlert_notify("공지사항 제목을 입력하세요");
			$("#title").focus();
			return false;
		}

		if(!$("#content").attr("value")){
			customAlert_notify("공지사항 내용을 입력하세요");
			$("#content").focus();
			return false;
		}


		if(!$("#from_date").attr("value")){
			customAlert_notify("공지 시작일을 입력하세요");
			$("#from_date").focus();
			return false;
		}

		if(!$("#to_date").attr("value")){
			customAlert_notify("공지 종료일을 입력하세요");
			$("#to_date").focus();
			return false;
		}

		if($("#from_date").attr("value") > $("#to_date").attr("value") ){
			customAlert_notify("공지 시작일이 종료일 이전입니다. 다시 입력하세요");
			$("#from_date").focus();
			return false;
		}

		notifyService("UPDATE"); //저장
	});

	//삭제등록
	 $(document).on("click", "#delete_notify_btn", function(event){
		event.preventDefault();
		
		if(!$("#nnum").attr("value")){
			customAlert_notify("삭제할 공지사항을 선택하세요");
			$("#nnum").focus();
			return false;
		}

		notifyService("DELETE"); //삭제 (status 를 0 -> 1 로 수정)
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
											<td class="ttl_text">공지사항관리</td>
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
														<td class="ttl_sub_text">공지사항 정보</td>
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
		<td width="12%" nowrap>공지번호</td>
		<td class="ct_rowl" width="38%"><input type="text" id="nnum" class="fm_input_read" size="5" maxlength="5" value=""></td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td width="12%" nowrap>공지제목</td>
		<td class="ct_rowl" width="38%"><input type="text" id="title" class="fm_input" size="30" maxlength="30" value=""></td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td width="12%" nowrap>공지내용</td>
		<td class="ct_rowl"><textarea id="content" name="content" rows="10" cols="40" tabindex="4" class="fm_area"></textarea>
				<p class="ps">* 1,000자 등록 가능</p></td>
	</tr>
	<tr class="ct_ttlc">
		<td width="12%" nowrap>시작일자</td>
		<td class="ct_rowl"><input type="date" class="fm_input" id="from_date"></td>
	</tr>
	<tr class="ct_ttlc">
		<td width="12%" nowrap>종료일자</td>
		<td class="ct_rowl"><input type="date" class="fm_input" id="to_date"></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a id="insert_notify_btn" href="#">신규등록</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a id="update_notify_btn" href="#">수정</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a id="delete_notify_btn" href="#">삭제</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>

	</tr>
	* 하루에 2개의 공지사항이 화면에 표시되기에 적당합니다.
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
														<td class="ttl_sub_text">공지사항 목록-<span id="searchCnt"></span></td>
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
														<td background="images/btn_seac_c.gif" class="btn" nowrap><a href="#" id="search_notify">조회</a></td>
														<td><img src="images/btn_seac_r.gif"></td>
													</tr>
												</table>
												<!-------Button Search Table E--------->
											</td>

										</tr>
										<div id="#notifylist_msg_div"></div>
										<tr>
											<td class="lt_line" colspan="2">
												<!------- List Table S --------->
												<table  id ="notifylist" width="100%" border="0" cellpadding="0" cellspacing="1" class="lt_bg display">
													<tr class="lt_ttlc">
														<td width="5%">번호</td>
														<td width="20%">공지제목</td>
														<td width="35%">공지내용</td>
														<td width="10%">시작일</td>
														<td width="10%">종료일</td>
														<td width="10%">등록자</td>
														<td width="10%">등록일</td>

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