<?php
session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: index_m.php');
}
?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
	<!--<meta name="apple-mobile-web-app-capable" content="yes">-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<meta name="author" content="andy.mo">
	<title>구합니다</title>

	<link rel="apple-touch-icon" href="images/app_icon.png" />
	<link rel="apple-touch-icon-precomposed" href="images/app_icon.png" />
	<link rel="apple-touch-startup-image" href="images/startup.png"/>
	 
	<link href="css/common.css" rel="stylesheet" type="text/css">

	<link href="css/sub_layout.css" rel="stylesheet" type="text/css">
	<link href="css/main_m.css" rel="stylesheet" type="text/css">
	<link href="css/request_m.css" rel="stylesheet" type="text/css">


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
		
	clear_data(); //초기 데이터 clear

	//1222 추가
	//급매 선택시 "1일 2회라는것을 메세지를 보여준다"
	$( "#type_choice" ).change(function() {
		if ($("#type_choice option:selected").val() == "급매"){
			alert("급매는 업소당 1日2회 까지 가능합니다.");
			$("#type_choice").focus();
			return false;
		}
	});


	//매물선택체크 0109
	//1. 직접입력 이외의 것을 체크시 type_text 를 hidden으로 하고 값을 넣는다
	//2. 직접입력을 선택하면 type_text 를 text로 바꾼다.
	//3. DB에 값을 저장할때 type_text의 값으로 저장한다.
	$( "#type_choice" ).change(function() {
	  
	  switch($("#type_choice option:selected").val()) {
	  	case "000":
	  		$("#type_text").val(""); // 000은 선택을 하지 않은것임
			$("#type_text").prop("type","hidden");
	  		break;
	  	case "직접입력":
	  		$("#type_text").val(""); // 000은 선택을 하지 않은것임
			$("#type_text").prop("type","text");
	  		break;
		default:
			$("#type_text").prop("type","hidden");
			$("#type_text").val($("#type_choice option:selected").val());
			break;
	  }
	});


	//지역선택체크
	//1. 직접입력 이외의 것을 체크시 region_text 를 hidden으로 하고 값을 넣는다
	//2. 직접입력 선택하면 region_text 를 text로 바꾼다.
	//3. DB에 값을 저장할때 region_text의 값으로 저장한다.
	$( "#region_choice" ).change(function() {
	  //alert($("#emailselect option:selected").val()); val은 값이고, text는 naver, daum과 같은 display되는 문자열임
	  
	  switch($("#region_choice option:selected").val()) {
	  	case "000":
	  		$("#region_text").val(""); // 000은 선택을 하지 않은것임
			$("#region_text").prop("type","hidden");
	  		break;
	  	case "직접입력":
	  		$("#region_text").val(""); // 000은 선택을 하지 않은것임
			$("#region_text").prop("type","text");
	  		break;
		default:
			$("#region_text").prop("type","hidden");
			$("#region_text").val($("#region_choice option:selected").val());
			break;
	  }
	});


	//request 클릭
	$("#send_ok").on("click",function(event){
		event.preventDefault();
		
		//필수 체크
		//if($("#type_choice").attr("value") == "000"){
		if($("#type_choice").attr("value") == "000" || !$("#type_text").attr("value") ){
			alert("매물타입을 선택해주세요.");
			$("#type_choice").focus();
			return false;
		}

		//필수 체크
		if($("#category_choice").attr("value") == "000"){
			alert("거래유형을 선택해주세요.");
			$("#category_choice").focus();
			return false;
		}

		
		//필수 체크
		if(!$("#title").attr("value")){
			alert("제목을 입력하세요");
			$("#title").focus();
			return false;
		}

		//필수 체크
		if(!$("#details").attr("value")){
			alert("내용을 입력하세요");
			$("#details").focus();
			return false;
		}
		
		var result = confirm("발송 하시겠습니까?");
		
		if(result) {
           //yes
			callback(true); //저장
        }
	  
	return false;
	});


	//값 변환
	function replaceAll(str, searchStr, replaceStr) {
		return str.split(searchStr).join(replaceStr);
	}


   function callback(value) {
		if (value) {
			//alert("Confirmed");
	var v_category,v_type,v_region,v_area_from,v_area_to,v_floor_from,v_floor_to,v_room_from,v_room_to;
	var v_sprice_from,v_sprice_to,v_dprice_from,v_dprice_to,v_rprice_from,v_rprice_to,v_title,v_content;
	var v_url;

	v_category	= $.trim($("#category_choice").attr("value")); 	
	//v_type		= $.trim($("#type_choice").attr("value"));	
	v_type		= $.trim($("#type_text").attr("value"));	

	//v_region	= $.trim($("#region_choice").attr("value")); 
	v_region	= $.trim($("#region_text").attr("value")); 
	if (v_region == "000"){ v_region = "";}
	
	v_area_from	= $.trim(replaceAll($("#area_from").attr("value"),",","")); 	 	
	v_area_to	= $.trim(replaceAll($("#area_to").attr("value"),",","")); 		



	//v_floor_from	= $.trim(replaceAll($("#floor_from").attr("value"),",",""));
	//v_floor_to	= $.trim(replaceAll($("#floor_to").attr("value"),",","")); 	
	//0109
	v_floor_from	= $.trim($("#floor_from_choice").attr("value")); 	
	v_floor_to	=$.trim($("#floor_to_choice").attr("value")); 	

	v_room_from	= $.trim(replaceAll($("#room_from").attr("value"),",",""));
	v_room_to	= $.trim(replaceAll($("#room_to").attr("value"),",","")); 	



	v_sprice_from	= $.trim(replaceAll($("#sprice_from").attr("value"),",","")); 	 	
	v_sprice_to	= $.trim(replaceAll($("#sprice_to").attr("value"),",","")); 	



	v_dprice_from	= $.trim(replaceAll($("#dprice_from").attr("value"),",","")); 
	v_dprice_to	= $.trim(replaceAll($("#dprice_to").attr("value"),",","")); 	

	v_rprice_from	= $.trim(replaceAll($("#rprice_from").attr("value"),",","")); 		
	v_rprice_to	= $.trim(replaceAll($("#rprice_to").attr("value"),",","")); 	

	v_title		= $.trim($("#title").attr("value"));	
	v_content	= $.trim($("#details").attr("value")) + " --[from Mobile]"; 

	var v_cCode,v_cName,v_uNum, v_uName;
	//session값 대체
	v_cCode = $.trim($("#session_ccode").attr("value"));
	v_cName = $.trim($("#session_cname").attr("value"));
	v_uNum = $.trim($("#session_unum").attr("value"));
	v_uName = $.trim($("#session_uname").attr("value"));

	if (v_type == "급매"){
		v_url = "../ajaxRequestUrgentInsert.php";
	}else{
		v_url = "../ajaxRequestInsert.php";
	}

	//http://www.sanwebe.com/2012/04/ajax-add-delete-sql-records-jquery-php
		$.ajax({
			url: v_url,
			type: "POST",
			dataType:"JSON",
			data :{
					"req_type"	: "01", //01 request(매수요청),02 reply 03. reply에 대한 회신
					"category"	: v_category, 	
					"type"		: v_type,			
					"region"	: v_region, 	
					"area_from"	: v_area_from, 	
					"area_to"	: v_area_to,      
					"floor_from"	: v_floor_from,	
					"floor_to"	: v_floor_to, 	
					"room_from"	: v_room_from,	
					"room_to"	: v_room_to, 	
					"sprice_from"	: v_sprice_from, 	
					"sprice_to"	: v_sprice_to,	
					"dprice_from"	: v_dprice_from,  
					"dprice_to"	: v_dprice_to,	
					"rprice_from"	: v_rprice_from, 	
					"rprice_to"	: v_rprice_to,	
					"title"		: v_title,		
					"content"	: v_content,
					"cCode"		: v_cCode,
					"cName"		: v_cName,
					"uNum"		: v_uNum,
					"uName"		: v_uName
						
			},
			cache: false,
			beforeSend:function(){
				$("#insert_msg_div").css('display', 'inline', 'important');
				$("#insert_msg_div").html("<img src='images/ajax-loader.gif' /> Sending...");
	   		},
			success: function(ret_val){

				//console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					//console.log("insert 성공");
					alert("요청을 완료했습니다");

					$("#insert_msg_div").hide();

				}else if(ret_val.status == "Exceed"){
					alert("1日2회 한도를 초과하였습니다.");
					$("#insert_msg_div").hide();
				}else {
						//alert("not equal");
						$("#insert_msg_div").css('display', 'inline', 'important');
						$("#insert_msg_div").html("<img src='images/alert.png' />데이터 저장시 오류가 발생하였습니다.");
				}
				
			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				alert(msg);
				 
			}
		});

		} else {
			return false;
			//alert("Rejected");
		}
	} //---function callback(value) end
		

	//화면값 초기화
	function clear_data(){
		$("#category_choice").attr("value","000");
		$("#type_choice").attr("value","000");	

		$("#region_choice").attr("value","000"); 
		$("#region_text").attr("value",""); 
		
		
		$("#area_from").attr("value","0"); 	 	
		$("#area_to").attr("value","0"); 		


		$("#floor_from").attr("value","0");
		$("#floor_to").attr("value","0"); 	

		$("#room_from").attr("value","0");
		$("#room_to").attr("value","0"); 	


		$("#sprice_from").attr("value","0"); 	 	
		$("#sprice_to").attr("value","0"); 	

		$("#dprice_from").attr("value","0"); 
		$("#dprice_to").attr("value","0"); 	

		$("#rprice_from").attr("value","0"); 		
		$("#rprice_to").attr("value","0"); 	

		$("#title").attr("value","");	
		$("#details").attr("value",""); 

	}
		
	//request 클릭
	$("#reset").on("click",function(event){
		event.preventDefault();
		clear_data()
		return false;
	});
		
		});

	 
	 </script>


</head>
<body>
 <!--header s  -->
 <header>
  <div id="wrap_head">
   <h1 class="main_logo bold helv"><a href="#" id="logo"><span class="loginlogo"></span>-[<?=$_SESSION['cName']?>/<?=$_SESSION['uName']?>]</a></h1>
   <a href="logout_m.php" id="btn1"><span class="close_icon"></span></a>
  </div>
  <nav>
   <ul class="main_menu bold verd">
    <li><a href="main_m.php" title="item" class="tab_m">My Page</a></li>
    <li><a href="requestlistOT_m.php" title="retrieve" class="tab_m">Ot Agent</a></li>
    <li><a href="request_m.php" title="notice" class="tab_m on">Find</a></li>
   </ul>
  </nav>
 </header>
 <!-- header e  -->
 <!-- article s  -->
 <article>
		<div id="main"><!-- 콘텐츠 삽입 부분 -->
			<input type="hidden" id="session_ccode" name="session_ccode"   value="<?=$_SESSION['cCode']?>"  />
			<input type="hidden" id="session_cname" name="session_cname"   value="<?=$_SESSION['cName']?>"  />
			<input type="hidden" id="session_userid" name="session_userid" value="<?=$_SESSION['userId']?>" />
			<input type="hidden" id="session_unum" name="session_unumum"    value="<?=$_SESSION['uNum']?>"  />
			<input type="hidden" id="session_uname" name="session_uname"    value="<?=$_SESSION['uName']?>" />
			<input type="hidden" id="session_oauth" name="session_oauth"    value="<?=$_SESSION['oAuth']?>" />

				<div id="form2">
					<form name="form"  method="post">
						<table summary="매물요청">
							<caption>Request</caption>
								<tr>
									<th scope="row">
										<label for="category_choice"><span class="thBar">┃</span>Item</label></th>
										<td>
											<select id="type_choice" name="type_choice" tabindex="1">
												<option value="000">Item select</option>
												<option value="직접입력">직접입력</option>
												<option value="아파트">아파트</option>
												<option value="아파트분양권">아파트분양권</option>
												<option value="주상복합">주상복합</option>
												<option value="오피스텔">오피스텔</option>
												<option value="단독/다가구">단독/다가구</option>
												<option value="연립/다세대">연립/다세대</option>
												<option value="원룸">원룸</option>
												<option value="상가주택">상가주택</option>
												<option value="올상가">올상가</option>
												<option value="공장">공장</option>
												<option value="창고">창고</option>
												<option value="사무실">사무실</option>
												<option value="빌딩">빌딩</option>
												<option value="토지">토지</option>
												<option value="기타">기타</option>
												<option value="급매">급매(1日2회)</option>
											</select>
											<!-- 직접입력을 선택할 경우에만 display된다 -->
											<input type="hidden" id="type_text" name="type_text" value="" size="20" maxlength="20" class="fm_input"/>
											-
											<select id="category_choice" name="category_choice" tabindex="2">
												<option value="000">Type select</option>
												<option value="매매">매매</option>
												<option value="전세">전세</option>
												<option value="월세">월세</option>
												<option value="반전세">반전세</option>
												<option value="임대">임대</option>
												<option value="기타">기타</option>
											</select>
										</td>
								</tr>							
								<tr>
									<th scope="row">
										<label for="title"><span class="thBar">┃</span>Title</label></th>
									<td>
										<input type="text" id="title" name="title" size="100" maxlength="100" class="inputbox01" tabindex="3"/>
									</td>
								</tr>
								<tr>
									<th scope="row">
										<label for="details"><span class="thBar">┃</span>Content</label></th>
										<td>
											<textarea id="details" name="details" rows="5" cols="30" tabindex="4" class="inputbox01"></textarea>
											<p class="ps">* Limit 1,000 character</p>
										</td>
								</tr>

								<tr>
									<th scope="row">
										<label for="region_choice1"><span class="thBar">┃</span>Region</label></th>
										<td>
											<select id="region_choice" name="region_choice" tabindex="5">
												<option value="000">Region select</option>
												<option value="중량구전체">중량구전체</option>
												<option value="직접입력">직접입력</option>
												<option value="면목본동">면목본동</option>
												<option value="면목2동">면목2동</option>
												<option value="면목3.8동">면목3.8동</option>
												<option value="면목4동">면목4동</option>
												<option value="면목5동">면목5동</option>
												<option value="면목7동">면목7동</option>
												<option value="상봉1동">상봉1동</option>
												<option value="상봉2동">상봉2동</option>
												<option value="중화1동">중화1동</option>
												<option value="중화2동">중화2동</option>
												<option value="묵1동">묵1동</option>
												<option value="묵2동">묵2동</option>
												<option value="망우본동">망우본동</option>
												<option value="망우3동">망우3동</option>
												<option value="신내1동">신내1동</option>
												<option value="신내2동">신내2동</option>
											</select>
				<!-- 기타를 선택할 경우에만 display된다 -->
				<input type="hidden" id="region_text" name="region_text" value="" size="20" maxlength="20" class="fm_input"/>

										</td>
								</tr>
								<tr>
									<th scope="row">
									<label for="area"><span class="thBar">┃</span>space</label></th>
									<td>
										<input type="text" pattern="[0-9]*"  id="area_from" name="area_from" size="12" title="면적" maxlength="8" tabindex="8" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);"/>
										-
										<input type="text" pattern="[0-9]*"  id="area_to" name="area_to" size="12" title="면적" maxlength="8" tabindex="9" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);"/>평
									</td>
								</tr>
								<tr>
									<th scope="row">
									<label for="floor"><span class="thBar">┃</span>floor</label></th>
									<td>
										<select id="floor_from_choice" name="floor_from_choice" tabindex="10">
											<option value="0">select</option>
											<option value="B3이하">B3▽</option>
											<option value="B2">B2</option>
											<option value="B1">B1</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21이상">21△</option>
										</select>
										-
										<select id="floor_to_choice" name="floor_to_choice" tabindex="11">
											<option value="0">select</option>
											<option value="B3이하">B3▽</option>
											<option value="B2">B2</option>
											<option value="B1">B1</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21이상">21△</option>
										</select>
									</td>
								</tr>
								<tr>
									<th scope="row">
									<label for="floor"><span class="thBar">┃</span>room</label></th>
									<td>
										<input type="text" pattern="[0-9]*" id="room_from" name="room_from" size="5" title="방" maxlength="3" tabindex="10" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);"  />
										-
										<input type="text" pattern="[0-9]*" id="room_to" name="room_to" size="5" title="방" maxlength="3" tabindex="11" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
									</td>
								</tr>

								<tr>
									<th scope="row">
									<label for="sprice"><span class="thBar">┃</span>sale</label></th>
									<td>
										<input type="text" pattern="[0-9]*" id="sprice_from" name="sprice_from" size="20" title="매매가" maxlength="13" tabindex="12" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
										-
										<input type="text" pattern="[0-9]*" id="sprice_to" name="sprice_to" size="20" title="매매가" maxlength="13" tabindex="13" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
									</td>
								</tr>
								<tr>
									<th scope="row">
									<label for="dprice"><span class="thBar">┃</span>depo</label></th>
									<td>
										<input type="text" pattern="[0-9]*" id="dprice_from" name="dprice_from" size="20" title="보증금" maxlength="13" tabindex="14" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
										-
										<input type="text" pattern="[0-9]*" id="dprice_to" name="dprice_to" size="20" title="보증금" maxlength="13" tabindex="15" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
									</td>
								</tr>
								<tr>
									<th scope="row">
									<label for="rprice"><span class="thBar">┃</span>rent</label></th>
									<td>
										<input type="text" pattern="[0-9]*" id="rprice_from" name="rprice_from" size="20" title="월세" maxlength="13" tabindex="16" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);"  />
										-
										<input type="text" pattern="[0-9]*" id="rprice_to" name="rprice_to" size="20" title="월세" maxlength="13" tabindex="17" class="inputbox01 num01"  onKeyPress="currency(this);" onKeyup="com(this);" />
									</td>
								</tr>
								
					
								<tr>
										<td  colspan="2" class="btn">
											<input class="btn1" type="button" id="send_ok" name="send_ok" value="submmit" />
											<input class="btn2" type="button" id="reset" name="reset" value="clear" />
										</td>
								</tr>

						</table>
					</form>
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
