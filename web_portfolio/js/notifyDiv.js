 $(document).ready(function() {

    $(".tab_content").hide();

		//
    //$("ul.tab li:first").addClass("active").show();
    //$("#tabA").addClass("tab_nw");

		$(".tab_content:first").show();

	 		//$("#x").click(function() {
			//http://roqkffhwk.tistory.com/45
			//자동으로 생성된 요소에는 아래와 같이 써야 evnet가 동작한다.
			$(document).on("click","#x",function(){
				//alert("click");
				//alert($("#x").text());

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

				}else{

					$("#tabB").removeClass("tab_nw").addClass("tab_s");
					$("#tabB").attr("background","images/btn_tabs_c.gif");
					$("#tabB_img1").attr("src","images/btn_tabs_l.gif");
					$("#tabB_img2").attr("src","images/btn_tabs_r.gif");

					$("#tabB").empty();
					$("<a id='x' href='#'>Rec</a>").appendTo($("#tabB"));
					$(".tab_content:last").hide();

					$("#tabA").removeClass("tab_s").addClass("tab_nw");
          $("#tabA").empty(); //tabB의 하위요소 제거
					$("#tabA").attr("background","images/btn_tab_c.gif");
					$("#tabA_img1").attr("src","images/btn_tab_l.gif");
					$("#tabA_img2").attr("src","images/btn_tab_r.gif");

					$("<span>Rec</span>").appendTo($("#tabA"));
				
					$(".tab_content:first").show();


/*
					$("#tabB").removeClass("tab_nw").addClass("tab_s");
					$("<a id='x' href='#'>").appendTo($("#tabB"));
					$(".tab_content:last").hide();

					$("#tabA").removeClass("tab_s").addClass("tab_nw");
          $("#tabA").empty(); //tabB의 하위요소 제거
					$("수신").appendTo($("#tabA"));

					$(".tab_content:first").show();
	*/
	
				}


			});



 
});
