 $(document).ready(function() {

 	//-----------------------------notify----------------------------

	 //본업소,타업소 당일Notify 보기
	 function requestNotifyService(){
	  
		  //page 관련 변수
		  var r_pagegroup,s_pagegroup; //수신,송신 pagegroup
		  var tmp_page_html,tmp_li;

		  var b_r_pagegroup = 0; //이전 수신 pagegroup
		  var b_s_pagegroup = 0; //이전 송신 pagegroup

		  var listPerPage = 25; // 1page에 나오는 갯수 (20,30,50,등등)

		  var tmp_html;
		  var scnt=0,rcnt=0;
		  var popup;

		  var v_type_name,v_css_type; //매수, 급매 & color
		  
			$.ajax({
			url: "ajaxRequestNotifyList.php",
			dataType: "json",
			type: "POST",
			data :{
			"dummy"    : "dummy" //ajax호출시 data영역이 있어야 한다. (어떤 PC는 오류발생함)
			},
			cache: false,
			beforeSend:function(){
				$("#notify_msg_div").css('display', 'inline', 'important');
				$("#notify_msg_div").html("<img src='images/ajax-loader.gif' /> Notify Loading...");
			},
			success: function(ret_val){

				$("#notify_msg_div").hide();

				$("#requestNotiPagelist_MY li").remove(); //noti paging li삭제
				$("#requestNotiPagelist_OT li").remove(); //noti paging li삭제


				$("#notify_searchtime").val("time:" + getTime()); // 호출시간

				if(ret_val.cnt > 0 ){

				   data = ret_val.data;
		
					if (data.length > 0) {

						$("#receive_notify tr:not(:first)").remove(); //수신-첫번째 행을 빼고 모두 삭제
						$("#request_notify tr:not(:first)").remove(); //송신-첫번째 행을 빼고 모두 삭제

						r_cnt = 0; //수신 카운트 for paging
						s_cnt = 0; //송신 카운트 for paging

						for(i=0; i<data.length; i++){


							//request
							// - 수신 (receive_ccode)
							// - 송신 (ccode)
							if (data[i]['req_type'] == "01")
							{

								if(data[i]['ccode'] == $("#session_ccode").attr("value")){
								//송신: 송신처 = 현재업소

									s_pagegroup = Math.ceil((scnt+1)/listPerPage);  //송신 page group추가

									if (data[i]['type'] == "급매"){ 
										v_type_name = "급매";
										v_css_type = "s_red";
									}else{
										v_type_name = "Q"; //매수
										v_css_type = "s_black";
									}
									

									tmp_html = "<tr class='lt_row MYNoti MYNotipage"+ s_pagegroup + "'><td id="+data[i]['rnum']+">"+data[i]['rnum']+"</td><td><span class='" + v_css_type + "'>"+ v_type_name +"</span></td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['title'].substring(0, 9)+"..→agents</td></tr>";
 
									$("#request_notify").append( tmp_html ); // 테이블 끝에 삽입

									scnt = scnt + 1;

									//송신 page 만드는 시작 부분
									if (b_s_pagegroup != s_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + s_pagegroup + "' id='MyNotiPage'>" + s_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_MY").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_s_pagegroup = s_pagegroup;

									}
									//송신 page 만드는 부분 끝



								}else{
									//수신: request의 수신처는 없다 (모두 이다)

									r_pagegroup = Math.ceil((rcnt+1)/listPerPage);  //수신 page group추가

									if (data[i]['type'] == "급매"){ 
										v_type_name = "급매";
										v_css_type = "s_red";
									}else{
										v_type_name = "Q"; //매수
										v_css_type = "s_black";
									}

									tmp_html = "<tr class='lt_row OTNoti OTNotipage"+ r_pagegroup + "'><td id="+data[i]['rnum']+">"+data[i]['rnum']+"</td><td><span class='" + v_css_type + "'>"+ v_type_name +"</span></td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['title'].substring(0, 9)+"..←" + data[i]['cname']+"</td></tr>";

									$("#receive_notify").append( tmp_html ); // 테이블 끝에 삽입
									rcnt = rcnt + 1;

									//수신 page 만드는 시작 부분
									if (b_r_pagegroup != r_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + r_pagegroup + "' id='OtNotiPage'>" + r_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_OT").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_r_pagegroup = r_pagegroup;

									}
									//수신 page 만드는 부분 끝


								}

							}

							//reply
							// - 수신
							// - 송신

							if (data[i]['req_type'] == "02")
							{
								//수신: 수신처 = 현재업소
								//reply를 확인하기 위해서 key가 refer_rnum 을 활용한다.
								if(data[i]['receive_ccode'] == $("#session_ccode").attr("value")){


									r_pagegroup = Math.ceil((rcnt+1)/listPerPage);  //수신 page group추가

									tmp_html = "<tr class='lt_row OTNoti OTNotipage"+ r_pagegroup + "'><td id="+data[i]['refer_rnum']+" >"+data[i]['rnum']+"</td><td>Re</td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['content'].substring(0, 9)+"..←" + data[i]['cname']+"</td></tr>";

									$("#receive_notify").append( tmp_html ); // 테이블 끝에 삽입

									rcnt = rcnt + 1;

									//수신 page 만드는 시작 부분
									if (b_r_pagegroup != r_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + r_pagegroup + "' id='OtNotiPage'>" + r_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_OT").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_r_pagegroup = r_pagegroup;

									}
									//수신 page 만드는 부분 끝



								}else if(data[i]['ccode'] == $("#session_ccode").attr("value")){
								//송신: 송신처 = 현재업소
								//reply를 확인하기 위해서 key가 refer_rnum 을 활용한다.

									s_pagegroup = Math.ceil((scnt+1)/listPerPage);  //송신 page group추가

									tmp_html = "<tr class='lt_row MYNoti MYNotipage"+ s_pagegroup + "'><td id="+data[i]['refer_rnum']+" >"+data[i]['rnum']+"</td><td>Re</td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['content'].substring(0, 9)+"..→" + data[i]['receive_cname']+"</td></tr>";

									$("#request_notify").append( tmp_html ); // 테이블 끝에 삽입

									scnt = scnt + 1;

									//송신 page 만드는 시작 부분
									if (b_s_pagegroup != s_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + s_pagegroup + "' id='MyNotiPage'>" + s_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_MY").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_s_pagegroup = s_pagegroup;

									}
									//송신 page 만드는 부분 끝


								}

							}

							//reply회신
							// - 수신
							// - 송신
							if (data[i]['req_type'] == "03")
							{
								//수신: 수신처 = 현재업소
								if(data[i]['receive_ccode'] == $("#session_ccode").attr("value")){

									r_pagegroup = Math.ceil((rcnt+1)/listPerPage);  //수신 page group추가

									tmp_html = "<tr class='lt_row OTNoti OTNotipage"+ r_pagegroup + "'><td id="+data[i]['origin_rnum']+">"+data[i]['rnum']+"</td><td>Ck</td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['content'].substring(0, 9)+"..←" + data[i]['cname']+"</td></tr>";

									$("#receive_notify").append( tmp_html ); // 테이블 끝에 삽입
									rcnt = rcnt + 1;

									//수신 page 만드는 시작 부분
									if (b_r_pagegroup != r_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + r_pagegroup + "' id='OtNotiPage'>" + r_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_OT").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_r_pagegroup = r_pagegroup;

									}
									//수신 page 만드는 부분 끝


								}else if(data[i]['ccode'] == $("#session_ccode").attr("value")){
								//송신: 송신처 = 현재업소
								//key로 origin_rnum사용
									s_pagegroup = Math.ceil((scnt+1)/listPerPage);  //송신 page group추가

									tmp_html = "<tr class='lt_row MYNoti MYNotipage"+ s_pagegroup + "'><td id="+data[i]['origin_rnum']+" >"+data[i]['rnum']+"</td><td>Ck</td><td class='lt_left'>" +data[i]['reg_date'].substring(11, 19)+" " +data[i]['content'].substring(0, 9)+"..→" + data[i]['receive_cname']+"</td></tr>";

									$("#request_notify").append( tmp_html ); // 테이블 끝에 삽입

									scnt = scnt + 1;

									//송신 page 만드는 시작 부분
									if (b_s_pagegroup != s_pagegroup )
									{
									  tmp_li = $("<li style='display:inline;'>");
									  tmp_li_html = "<a href='" + s_pagegroup + "' id='MyNotiPage'>" + s_pagegroup + "</a></li>&nbsp;&nbsp;&nbsp;&nbsp;";
									  tmp_li.html(tmp_li_html);
										
									  $("#requestNotiPagelist_MY").append(tmp_li);
						
										tmp_li = null;
										tmp_li_html = null;

										b_s_pagegroup = s_pagegroup;

									}
									//송신 page 만드는 부분 끝


								}

							}
						}
						
						$("#notify_cnt").html("R:"+rcnt + "/S:"+scnt);

						//page 처리
						$(".OTNoti").hide(); //모두 안보이게 하고
						$(".OTNotipage1").show(); //첫번째 page만 보이게 한다
						$("#requestNotiPagelist_MY li a").first().css('color', 'red');	//1의 색 red

						//page 처리
						$(".MYNoti").hide(); //모두 안보이게 하고
						$(".MYNotipage1").show(); //첫번째 page만 보이게 한다
						$("#requestNotiPagelist_OT li a").first().css('color', 'red');	//1의 색 red

					 }
					 
				 }else{

					$("#receive_notify tr:not(:first)").remove(); //수신-첫번째 행을 빼고 모두 삭제
					$("#request_notify tr:not(:first)").remove(); //송신-첫번째 행을 빼고 모두 삭제

					$("#notify_cnt").html("R:0/S:0");


					
				 }    

			},
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert(msg);
				 
			}
		 });
	  }


   requestNotifyService();   //page loading 시 Notification을 불러온다


	$("#reload_notify").on("click",function(event){
		
		event.preventDefault();
		requestNotifyService();
	});


	//--------------------------------------
	//list click시 popup open
	var noti_idx;
	var noti_rnum,noti_refer_rnum,noti_origin_rnum;
	var noti_type;

	$("#receive_notify").on("click", "tr", function(e) {
		//수신 click한 row
		noti_idx = $(e.currentTarget).index();
		//alert(noti_idx);

		if (noti_idx >0) //title외에 실제 data영역을 click했을경우
		{
			noti_type = $("#receive_notify tr:eq("+noti_idx+") > td:eq(1)").text();

							//매수
			if (noti_type == "Q" || noti_type == "급매"){
				noti_rnum = $("#receive_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				reply_popup(noti_rnum);

			}else if (noti_type == "Re"){ //답장
				noti_refer_rnum = $("#receive_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				noti_rnum = $("#receive_notify tr:eq("+noti_idx+") > td:eq(0)").text();
				replyconfirmforNoti_popup(noti_refer_rnum,noti_rnum); //1221변경 - 부모 , 자식을 넘긴다

			}else if(noti_type == "Ck"){
				noti_origin_rnum = $("#receive_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				chk_replyconfirm_popup(noti_origin_rnum);
			}


		}

	});


	$("#request_notify").on("click", "tr", function(e) {
		//송신 click한 row
		noti_idx = $(e.currentTarget).index();
		//alert(noti_idx);

		if (noti_idx >0) //title외에 실제 data영역을 click했을경우
		{
			noti_type = $("#request_notify tr:eq("+noti_idx+") > td:eq(1)").text();

                         //매수
			if (noti_type == "Q" || noti_type == "급매"){
				noti_rnum = $("#request_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				replyconfirm_popup(noti_rnum);

			}else if (noti_type == "Re"){ //답
				noti_refer_rnum = $("#request_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				chk_replyconfirm_popup(noti_refer_rnum);

			}else if(noti_type == "Ck"){
				noti_origin_rnum = $("#request_notify tr:eq("+noti_idx+") > td:eq(0)").attr("id");
				replyconfirm_popup(noti_origin_rnum);
			}

		}

	});
	//--------------------------------------



	//MyNotiPage의 paging 을 click했을때
	$(document).on("click", "#MyNotiPage", function(event){
		event.preventDefault();
		$(".MYNoti").hide(); //모두 안보이게 하고
		$(".MYNotipage"+$(this).attr("href")).show(); //눌려진 page만 보이게 한다

		//on class를 모두 삭제후, 자신것만 on을 시킨다.
		$("#requestNotiPagelist_MY li a").css("color","black");
		$(this).css("color","red");

	});



	//OtNotiPage의 paging 을 click했을때
	$(document).on("click", "#OtNotiPage", function(event){
		event.preventDefault();
		$(".OTNoti").hide(); //모두 안보이게 하고
		$(".OTNotipage"+$(this).attr("href")).show(); //눌려진 page만 보이게 한다

		//on class를 모두 삭제후, 자신것만 on을 시킨다.
		$("#requestNotiPagelist_OT li a").css("color","black");
		$(this).css("color","red");

	});



});
