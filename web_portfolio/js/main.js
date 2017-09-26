 $(document).ready(function() {

	//화면 tr의 색깔 바꾸기
	  $('#requestlist_MY').on("mouseover", "tr", function(e){
		  idx = $(e.currentTarget).index();

			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
				$(this).css("background","#ffff82");
			}
       }).on("mouseout", "tr", function(e){
			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
			   $(this).css("background","");
			}
       });


	  $('#requestlist_OT').on("mouseover", "tr", function(e){
		  idx = $(e.currentTarget).index();

			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
				$(this).css("background","#ffff82");
			}
       }).on("mouseout", "tr", function(e){
			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
			   $(this).css("background","");
			}
       });

	  $('#receive_notify').on("mouseover", "tr", function(e){
		  idx = $(e.currentTarget).index();

			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
				$(this).css("background","#ffff82");
			}
       }).on("mouseout", "tr", function(e){
			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
			   $(this).css("background","");
			}
       });

	  $('#request_notify').on("mouseover", "tr", function(e){
		  idx = $(e.currentTarget).index();

			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
				$(this).css("background","#ffff82");
			}
       }).on("mouseout", "tr", function(e){
			if (idx >0) //title외에 실제 data영역을 click했을경우
			{
			   $(this).css("background","");
			}
       });

	//----------------------

	$("#dialog-confirm").hide();
	$("#dialog-Sucess").hide();

	clear_data(); //화면값 초기화

	//confirm dialog함수를 선언한다.
	function fnOpenNormalDialog(param_type) {
		var title_name;

		if (param_type == "급매"){
			title_name = "급매알림"
		}else{
			title_name = "매물구함"
		}

		$("#dialog-confirm").html("발송 하시겠습니까?");

		// Define the Dialog and its properties.
		$("#dialog-confirm").dialog({
			resizable: false,
			modal: true,
			title: title_name,
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
	function customAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}


	

    $(".tab_content").hide();
	$(".tab_content:first").show();

	//자동으로 생성된 요소에는 아래와 같이 써야 evnet가 동작한다.
	$(document).on("click","#x",function(){

		if ($("#x").text() =="Send") 
		{
			//송신tab을 눌렀을 경우
			//1. 수신 tab의 class를 tab_nw -> tab_s 
			//2. 수신 tab뒤에 <a id="x" href="#"> 를 추가
			//3. 수신 $(".tab_content:first").hide();
			//3. 송신 tab의 class를  tab_s -> tab_nw 
			//4. 송신 tab의 <a id="x" href="#"> 를 제거
			//5. 송신 tab에 송신 이란 글씨를 넣는다
			//5. 송신 $(".tab_content:last").show();
			$("#tabA").removeClass("tab_nw").addClass("tab_s");
			$("#tabA").attr("background","images/btn_tabs_c.gif");
			$("#tabA_img1").attr("src","images/btn_tabs_l.gif");
			$("#tabA_img2").attr("src","images/btn_tabs_r.gif");

			$("#tabA").empty();
			$("<a id='x' href='#'>Rec</a>").appendTo($("#tabA"));
			$(".tab_content:first").hide();

			$("#tabB").removeClass("tab_s").addClass("tab_nw");
  			$("#tabB").empty(); //tabB의 하위요소 제거
			$("#tabB").attr("background","images/btn_tab_c.gif");
			$("#tabB_img1").attr("src","images/btn_tab_l.gif");
			$("#tabB_img2").attr("src","images/btn_tab_r.gif");

			$("<span>Send</span>").appendTo($("#tabB"));
		
			$(".tab_content:last").show();

			$("#ico_notifylist").attr("class",'ttl_ico_my'); //제목옆의 bar

		}else{

			$("#tabB").removeClass("tab_nw").addClass("tab_s");
			$("#tabB").attr("background","images/btn_tabs_c.gif");
			$("#tabB_img1").attr("src","images/btn_tabs_l.gif");
			$("#tabB_img2").attr("src","images/btn_tabs_r.gif");

			$("#tabB").empty();
			$("<a id='x' href='#'>Send</a>").appendTo($("#tabB"));
			$(".tab_content:last").hide();

			$("#tabA").removeClass("tab_s").addClass("tab_nw");
  			$("#tabA").empty(); //tabB의 하위요소 제거
			$("#tabA").attr("background","images/btn_tab_c.gif");
			$("#tabA_img1").attr("src","images/btn_tab_l.gif");
			$("#tabA_img2").attr("src","images/btn_tab_r.gif");

			$("<span>Rec</span>").appendTo($("#tabA"));
		
			$(".tab_content:first").show();

			$("#ico_notifylist").attr("class",'ttl_ico_ot'); //제목옆의 bar

		}


	});



	//------------- 당업소, 타업소 필드 처리 Start
 	$("#div_requestlist_OT").hide(); //타업소 요청리스트 안보이게 하기
 	$("input:radio[name='chk_info']:radio[value='MY']").attr("checked",true); //default 첫번째 checkbox활성화
 	$("input:radio[name='chk_info']:radio[value='OT']").attr("checked",false);

	 $("input:radio[name='chk_info']").change(function() {
        if (this.value == 'MY') {

		 $("#div_requestlist_MY").show();	//당업소 요청리스트 보이게 하기
		 $("#div_requestlist_OT").hide();	//타업소 요청리스트 안보이게 하기
		 
		 $("#search_table").attr("class",'ct_ttlc_my'); //table column 색
		 $("#ico_requestlist").attr("class",'ttl_ico_my'); //제목옆의 bar
        }
        else if (this.value == 'OT') {

		 $("#div_requestlist_MY").hide();	//당업소 요청리스트 안보이게 하기
		 $("#div_requestlist_OT").show();	//타업소 요청리스트 보이게 하기

		 $("#search_table").attr("class",'ct_ttlc_ot'); ////table column 색
		 $("#ico_requestlist").attr("class",'ttl_ico_ot'); ////제목옆의 bar

		}
    });
 
	//1222 추가
	//급매 선택시 "1일 2회라는것을 메세지를 보여준다"
	$( "#type_choice" ).change(function() {
		if ($("#type_choice option:selected").val() == "급매"){
			customAlert("급매는 업소당 1日2회 까지 가능합니다.");
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
	//2. 직접입력을 선택하면 region_text 를 text로 바꾼다.
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


	//제목 자동생성 기능1
	//$("#type_choice").change(function() {
	//	var tmp_title = $("#category_choice option:selected").text() + "-" + $("#type_choice option:selected").text() + " 찾습니다.";
	//	$("#title").val(tmp_title);
	//});


	//제목 자동생성 기능2
	//$("#category_choice").change(function() {
	//	var tmp_title = $("#category_choice option:selected").text() + "-" + $("#type_choice option:selected").text() + " 찾습니다.";
	//  $("#title").val(tmp_title);
	//});


	//request 클릭
	$("#send_ok").on("click",function(event){
		event.preventDefault();
		
		//필수 체크
		//if($("#type_choice").attr("value") == "000"){
		if($("#type_choice").attr("value") == "000" || !$("#type_text").attr("value") ){
			customAlert("매물타입을 선택해주세요.");
			$("#type_choice").focus();
			return false;
		}

		//필수 체크
		if($("#category_choice").attr("value") == "000"){
			customAlert("거래유형을 선택해주세요.");
			$("#category_choice").focus();
			return false;
		}

		
		//필수 체크
		if(!$("#title").attr("value")){
			customAlert("제목을 입력하세요");
			$("#title").focus();
			return false;
		}

		//필수 체크
		if(!$("#details").attr("value")){
			customAlert("내용을 입력하세요");
			$("#details").focus();
			return false;
		}

		
				//필수 체크
		if($("#type_choice").attr("value") == "급매"){
		   fnOpenNormalDialog("급매"); 
		}else{
		   fnOpenNormalDialog("매물"); 
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
	var v_cCode,v_cName,v_uNum, v_uName;

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
	v_content	= $.trim($("#details").attr("value")); 

	//session값 대체
	v_cCode = $.trim($("#session_ccode").attr("value"));
	v_cName = $.trim($("#session_cname").attr("value"));
	v_uNum = $.trim($("#session_unum").attr("value"));
	v_uName = $.trim($("#session_uname").attr("value"));


	if (v_type == "급매"){
		v_url = "ajaxRequestUrgentInsert.php";
	}else{
		v_url = "ajaxRequestInsert.php";
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
						"floor_from": v_floor_from,	
						"floor_to"	: v_floor_to, 	
						"room_from"	: v_room_from,	
						"room_to"	: v_room_to, 	
						"sprice_from": v_sprice_from, 	
						"sprice_to"	: v_sprice_to,	
						"dprice_from": v_dprice_from,  
						"dprice_to"	: v_dprice_to,	
						"rprice_from": v_rprice_from, 	
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
						customAlert("요청을 완료했습니다");

						$("#insert_msg_div").hide();

					}else if (ret_val.status == "Exceed"){

						customAlert("1日2회 한도를 초과하였습니다.");
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
					customAlert(msg);
					 
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
