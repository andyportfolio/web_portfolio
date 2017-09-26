 $(document).ready(function() {


 //본업소 요청건, 타업소 요청건보기
 function requestListService(stype){
  
	  var id,pagegroup;
	  var b_pagegroup = 0; //이전 pagegroup
	  var listPerPage = 15; // 1page에 나오는 갯수 (20,30,50,등등)
	  var tmp_html,temp_sub_html,img_src,tmp_page_html,tmp_li;
	  var popup;
	  var region_name,area,sprice,dprice,rprice;

	  var v_type,v_direct_type,v_category,v_close;
	  var v_css_type;
	  
	//매물(type:아파트)
		//0109
		//매물직접입력 선택시 조회값 체크
		if ($("#search_type_choice").attr("value") == "직접입력"){
			//직접입력을 선택하고 값이 없으면 , 전체조회와 동일하다
			if(!$("#type_search_text").attr("value")){
				  v_direct_type = "N";	//직접입력 아님
			  	  v_type = "000";		//전체조회

			}else{
				  v_direct_type = "Y";	//직접입력
			  	  v_type = $("#type_search_text").attr("value");//입력값으로 조회
			
			}

		}else{
		//직접입력 아니고, 선택한 값으로 조회
		  v_direct_type = "N";
		  v_type = $("#search_type_choice").attr("value");

		}
		
		//console.log("v_direct_type" + v_direct_type);
		//console.log("v_type"+ v_type);


	//유형(category:매매)
	  v_category = $("#search_category_choice").attr("value");

	//종료포함여부값
	 if( $(":checkbox[name='close_YN']:checked").length == 0 ){
		 v_close = "N";
	 }else{
		 v_close = "Y";
	 }
	
		//alert(v_type + "/" + v_category + "/" + v_close);

		$.ajax({
		url: "ajaxRequestList.php",
		dataType: "json",  
		type: "POST",
		data :{
			"stype"    : stype,
			"v_type"    : v_type,
			"v_direct_type" : v_direct_type,
			"v_category" : v_category,
			"v_close"    : v_close

		},
		cache: false,
		beforeSend:function(){
			$("#requestlist_msg_div").css('display', 'inline', 'important');
			$("#requestlist_msg_div").html("<img src='images/ajax-loader.gif' /> Loading...");
		},
		success: function(ret_val){
			//console.dir(ret_val);
			//console.log(ret_val);
			//console.log("requestlist값type은---"+$.type(ret_val));
	    	//console.log("requestlist값cnt--"+$.type(ret_val.cnt));

			$("#requestlist_msg_div").hide();

			//요청건의 paging 만 삭제
			if (stype == "MY"){
				$("#requestPagelist_MY li").remove(); //MY paging li삭제

			}else{
				$("#requestPagelist_OT li").remove(); //OT paging li삭제
			}

			if(ret_val.cnt > 0 ){
			   //console.log("requestlist값 있음");
			   data = ret_val.data;
	
				if (data.length > 0) {


					if(stype == "MY"){
						$("#requestlist_MY tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제

					}else if(stype == "OT"){
						$("#requestlist_OT tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제
					}

					for(i=0; i<data.length; i++){

						if(stype == "MY"){

							if (data[i]['status'] == '0'){  //정상
							  img_src = "images/money.png";
							 }else{
							 	img_src = "images/delete.png";
							 }

							area = Comma(data[i]['area_from']) + "~"+ Comma(data[i]['area_to']);  

							sprice = Comma(data[i]['sprice_from']) + "~"+ Comma(data[i]['sprice_to']);  
							dprice = Comma(data[i]['dprice_from']) + "~"+ Comma(data[i]['dprice_to']);  
							rprice = Comma(data[i]['rprice_from']) + "~"+ Comma(data[i]['rprice_to']);  


							//temp_sub_html = "<table id='subtable' width= '100%' border='0' cellpadding='0' cellspacing='0'><tr><td class='lt_left'>매:</td><td class='lt_right'>"+ sprice+"</td></tr><tr><td class='lt_left'>보:</td><td class='lt_right'>"+ dprice+"</td></tr><tr><td class='lt_left'>월:</td><td class='lt_right'>"+ rprice+"</td></tr></table>";


							temp_sub_html = "<div width='100%'>sale:" + sprice + "</div><div width='100%'>depo:" + dprice + "</div><div width='100%'>rent:" + rprice + "</div>";

							pagegroup = Math.ceil((i+1)/listPerPage);  //page group추가


							if(data[i]['type'] == "급매"){
								v_css_type = "s_red";
							}else{
								v_css_type = "s_black";
							}

							tmp_html = "<tr class='lt_row MY Mpage"+ pagegroup + "'><td><img src="+ img_src +"></td><td>"+data[i]['rnum']+"</td><td class='lt_center' >" +data[i]['reg_date']+"</td><td class='lt_left'>" +data[i]['title']+"</td><td>" + data[i]['rcnt']+"</td><td><span class='" + v_css_type + "'>" +data[i]['type']+"</span></td><td>" +data[i]['category']+"</td><td class='lt_center'>" +data[i]['region']+"</td><td>" +temp_sub_html + "</td></tr>" ;

							$("#requestlist_MY").append( tmp_html ); // 테이블 끝에 삽입


							//page 만드는 부분
							if (b_pagegroup != pagegroup )
							{
							  tmp_li = $("<li style='display:inline;'>");
							  tmp_li_html = "<a href='" + pagegroup + "' id='MyPage'>" + pagegroup + "</a></li>&nbsp;&nbsp;";
							  tmp_li.html(tmp_li_html);
								
							  $("#requestPagelist_MY").append(tmp_li);
				
								tmp_li = null;
								tmp_li_html = null;

								b_pagegroup = pagegroup;

							}


						}else if(stype == "OT"){

							if (data[i]['status'] == '0'){  //정상
							  img_src = "images/money.png";
							 }else{
							 	img_src = "images/delete.png";
							 }

							area = Comma(data[i]['area_from']) + "~"+ Comma(data[i]['area_to']);  

							sprice = Comma(data[i]['sprice_from']) + "~"+ Comma(data[i]['sprice_to']);  
							dprice = Comma(data[i]['dprice_from']) + "~"+ Comma(data[i]['dprice_to']);  
							rprice = Comma(data[i]['rprice_from']) + "~"+ Comma(data[i]['rprice_to']);  


							//temp_sub_html = "<table width= '100%' border='0' cellpadding='0' cellspacing='0'><tr><td class='lt_left'>매:</td><td class='lt_right'>"+ sprice+"</td></tr><tr><td class='lt_left'>보:</td><td class='lt_right'>"+ dprice+"</td></tr><tr><td class='lt_left'>월:</td><td class='lt_right'>"+ rprice+"</td></tr></table>";

							temp_sub_html = "<div width='100%'>sale:" + sprice + "</div><div width='100%'>depo:" + dprice + "</div><div width='100%'>rent:" + rprice + "</div>";

							pagegroup = Math.ceil((i+1)/listPerPage); //page group추가

							if(data[i]['type'] == "급매"){
								v_css_type = "s_red";
							}else{
								v_css_type = "s_black";
							}

							//tmp_html = "<tr class='lt_row OT Opage"+ pagegroup + "'><td width='4%'><img src="+ img_src +"></td><td  width='4%'>"+data[i]['rnum']+"</td><td class='lt_center'  width='16%'>" +data[i]['reg_date']+"</td><td class='lt_left'  width='18%'>" +data[i]['title']+"</td><td width='4%'>" + data[i]['rcnt']+"</td><td  width='8%'><span class='" + v_css_type + "'>" +data[i]['type']+"</span></td><td  width='8%'>" +data[i]['category']+"</td><td class='lt_center' width='8%'>" +data[i]['region']+"</td><td width='18%'>" + temp_sub_html +"</td><td class='lt_center' width='10%'>" + data[i]['cname']+"</td></tr>" ;

							tmp_html = "<tr class='lt_row OT Opage"+ pagegroup + "'><td><img src="+ img_src +"></td><td  >"+data[i]['rnum']+"</td><td class='lt_center'>" +data[i]['reg_date']+"</td><td class='lt_left'>" +data[i]['title']+"</td><td>" + data[i]['rcnt']+"</td><td><span class='" + v_css_type + "'>" +data[i]['type']+"</span></td><td>" +data[i]['category']+"</td><td class='lt_center'>" +data[i]['region']+"</td><td >" + temp_sub_html +"</td><td class='lt_center'>" + data[i]['cname']+"</td></tr>" ;


							$("#requestlist_OT").append( tmp_html ); // 테이블 끝에 삽입


							//page 만드는 부분
							if (b_pagegroup != pagegroup )
							{
							  tmp_li = $("<li style='display:inline;'>");
							  tmp_li_html = "<a href='" + pagegroup + "' id='OtPage'>" + pagegroup + "</a></li>&nbsp;&nbsp;";
							  tmp_li.html(tmp_li_html);
								
							  $("#requestPagelist_OT").append(tmp_li);
				
								tmp_li = null;
								tmp_li_html = null;

								b_pagegroup = pagegroup;

							}


						}


					}
					
					if(stype == "MY"){
						$("#searchCnt").text(getDateTime() + " My " +data.length + "count" );  

						//page 처리
						$(".MY").hide(); //모두 안보이게 하고
						$(".Mpage1").show(); //첫번째 page만 보이게 한다

						$("#requestPagelist_MY li a").first().css('color', 'red');	//1의 색 red

					}else if(stype == "OT"){
						$("#searchCnt").text(getDateTime() + " Other " +data.length + "count" );  

						//page 처리
						$(".OT").hide(); //모두 안보이게 하고
						$(".Opage1").show(); //첫번째 page만 보이게 한다

						$("#requestPagelist_OT li a").first().css('color', 'red'); //1의 색 red


					}

		         }
		         
		     }else{

					if(stype == "MY"){
						$("#requestlist_MY tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제
						$("#searchCnt").text(getDateTime() + " My 0" );  

					}else if(stype == "OT"){
						$("#requestlist_OT tr:not(:first)").remove(); //첫번째 행을 빼고 모두 삭제
						$("#searchCnt").text(getDateTime() + " Other 0" );  

					}

				//console.log(tmp_html);
		     	//tmp_html = "조건에 맞는 데이터가 존재하지 않습니다.";
		     	
		     	//$("#nodata").append( tmp_html ); // 테이블 끝에 삽입
		     }    
	    },
		error: function(xhr, message, errorThrown){
			var msg = xhr.status + " / " + message + " / " + errorThrown;
			console.dir(xhr); 
			customAlert(msg);
			 
		}
	 });
  }
  
  requestListService("MY"); //page loading 시 본업소 요청건을 불러온다
 
	$("#search_ok").on("click",function(event){
		//alert("조회버튼 클릭됨" + $("input:radio[name='chk_info']:checked").val());
		event.preventDefault();
		requestListService($("input:radio[name='chk_info']:checked").val());

	});


	//--------------------------------------
	//list click시 popup open
	var idx;
	$("#requestlist_MY").on("click", "tr", function(e) {
		//click한 row
		idx = $(e.currentTarget).index();

		if (idx >0) //title외에 실제 data영역을 click했을경우
		{
			param = $("#requestlist_MY tr:eq("+idx+") > td:eq(1)").text();
			replyconfirm_popup(param,"list");

		}

	});


	$("#requestlist_OT").on("click", "tr", function(e) {
		//click한 row
		idx = $(e.currentTarget).index();

		if (idx >0) //title외에 실제 data영역을 click했을경우
		{
			param = $("#requestlist_OT tr:eq("+idx+") > td:eq(1)").text();
			reply_popup(param);

		}

	});
	//--------------------------------------


/*
	//본업소 요청건에서 popup 호출시 - 답장확인창
	$(document).on("click", "#detail_MY_btn", function(){
		//alert("detail_MY_btn");

		param = $(this).attr("value");
		replyconfirm_popup(param);

	});

	//타업소 요청건에서 popup 호출시 - 답장
	$(document).on("click", "#detail_OT_btn", function(){
		//alert("detail_OT_btn");
	
		param = $(this).attr("value");
		reply_popup(param);

	});

*/

	//MyPage의 paging 을 click했을때
	$(document).on("click", "#MyPage", function(event){
		event.preventDefault();
		$(".MY").hide(); //모두 안보이게 하고
		$(".Mpage"+$(this).attr("href")).show(); //눌려진 page만 보이게 한다

		//on class를 모두 삭제후, 자신것만 on을 시킨다.
		$("#requestPagelist_MY li a").css("color","black");
		$(this).css("color","red");

	});



	//OtPage의 paging 을 click했을때
	$(document).on("click", "#OtPage", function(event){
		event.preventDefault();
		$(".OT").hide(); //모두 안보이게 하고
		$(".Opage"+$(this).attr("href")).show(); //눌려진 page만 보이게 한다

		//on class를 모두 삭제후, 자신것만 on을 시킨다.
		$("#requestPagelist_OT li a").css("color","black");
		$(this).css("color","red");

	});


	//매물선택체크 0109
	//1. 직접입력 이외의 것을 체크시 type_search_text 를 hidden으로 하고 값을 넣는다
	//2. 직접입력을 선택하면 type_search_text 를 text로 바꾼다.
	//3. 조회 할때 type_search_text 값을 사용한다.
	$( "#search_type_choice" ).change(function() {
	  
	  switch($("#search_type_choice option:selected").val()) {
	  	case "000":
	  		$("#type_search_text").val(""); // 000은 선택을 하지 않은것임
			$("#type_search_text").prop("type","hidden");
	  		break;
	  	case "직접입력":
	  		$("#type_search_text").val(""); // 000은 선택을 하지 않은것임
			$("#type_search_text").prop("type","text");
	  		break;
		default:
			$("#type_search_text").prop("type","hidden");
			$("#type_search_text").val($("#search_type_choice option:selected").val());
			break;
	  }
	});


});
