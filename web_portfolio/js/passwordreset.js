/**
 * @author mjy
 *  good -- http://www.9lessons.info/2014/07/ajax-php-login-page.html
 */


$(document).ready(function(){

	//alert창
	function customAlert_login(val) {

		$("#dialog-confirm").html(val);
		$("#dialog-confirm").dialog();
	}

	
	//validation check
	//submit으로 하면 오류발생함 (http://cricri4289.blogspot.kr/2013/10/jquery-ajax-error-code-0.html)
	//$(form).submit(function(){
	//암호초기화 요청
	$("#passwordreset").click(function() {

		//업소
		if(!$("#reg_ccode").attr("value")){
			customAlert_login("업소코드를 입력하세요");
			$("#reg_ccode").focus();
			return false;
		}

		if(!$("#reg_ccode_name").attr("value")){
			customAlert_login("업소확인 버튼을 클릭하여 주세요");
			$("#reg_ccode").focus();
			return false;
		}

		if($("#reg_ccode_name").attr("value")== "N/A"){
			customAlert_login("등록되지 않은 업소코드 입니다.");
			$("#reg_ccode").focus();
			return false;
		}

		//사용자
		if(!$("#reg_id").attr("value")){
			customAlert_login("사용자 ID를 입력하세요");
			$("#reg_id").focus();
			return false;
		}

		if($("#chk_id_flag").attr("value") != "OK"){
			customAlert_login("사용자ID 존재여부 체크 버튼을 클릭하여 주세요");
			$("#reg_id").focus();
			return false;
		}

		if(!$("#reg_username").attr("value")){
			customAlert_login("사용자의 성명을 입력하세요");
			$("#reg_username").focus();
			return false;
		}
		

		if(!$("#reg_email").attr("value")){
			customAlert_login("email 주소를 입력하세요");
			$("#reg_email").focus();
			return false;

		}else{

			var tmp_email = $("#reg_email").attr("value");
			if (tmp_email.indexOf('@') == -1)
			{
				customAlert_login("email 주소에 '@' 가 없습니다.정확한 주소를 넣으세요 ");
			
				$("#reg_email").focus();
				return false;
			}
		}


			v_ccode =  	$("#reg_ccode").attr("value");
			v_userid =   $("#reg_id").attr("value");
			v_password = $("#reg_password").attr("value");
			v_username = $("#reg_username").attr("value");
			v_email =    $("#reg_email").attr("value");

		//사용자 등록
		$.ajax({
			//url: "ajaxUserManage.php",
			url: "ajaxPasswordReset.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"ccode":    v_ccode, 
					"userid":   v_userid,
					"username":	v_username,
					"email":   	v_email 
			},
			cache: false,
			beforeSend:function(){
				$("#add_chk_image").css('display', 'inline', 'important');
				$("#add_chk_image").html("<img src='images/ajax-loader.gif' /> 암호 초기화 요청중입니다. 잠시기다려 주세요");

	   		},
			success: function(ret_val){

				//console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					//console.log("insert 성공");
					customAlert_login("등록하신 email 주소로 초기화된 암호가 전송되었습니다.");

					$("#add_chk_image").hide();

				}else if(ret_val.status == "Nodata" ){
					//alert("not equal");
					$("#add_chk_image").css('display', 'inline', 'important');
					$("#add_chk_image").html("<img src='images/alert.png' /> 입력한 정보에 맞는 데이터가 없습니다. ");
				}else{
					//alert("not equal");
					$("#add_chk_image").css('display', 'inline', 'important');
					$("#add_chk_image").html("<img src='images/alert.png' />암호 초기화 요청중 오류가 발생하였습니다.");
				}
				
			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_login(msg);
				 
			}
		});
		
		return false;
	});



	//업소확인
	$("#check_ccode").click(function() {

		//업소
		if(!$("#reg_ccode").attr("value")){
			customAlert_login("업소코드를 입력하세요");
			$("#reg_ccode").focus();
			return false;
		}


		$.ajax({
			url: "ajaxUserRegisterChk.php",
			dataType: "json",
			type: "POST",
			data :{
				"flag"    	: "org",
				"ccode"	: $("#reg_ccode").attr("value")
			},
			cache: false,
			beforeSend:function(){
				$("#add_chk_image").css('display', 'inline', 'important');
				$("#add_chk_image").html("<img src='images/ajax-loader.gif' /> 업소코드 체크중입니다. 잠시기다려 주세요");
				$("#add_chk_msg").hide();

	   		},
			success: function(ret_val){
				//console.dir(ret_val);
				$("#add_chk_image").hide();

				if($.type(ret_val) === "object" && ret_val.cnt > 0 ){
				   //console.log("requestlist값 있음");
				   data = ret_val.data;
		
					if (data.length > 0) {
						$("#add_chk").hide();
						$("#reg_ccode_name").attr("value",data[0]['cname'])

					}else{
					}
				}else{
					$("#add_chk_msg").css('display', 'inline', 'important').css('font-size','small');
					$("#add_chk_msg").html("<img src='images/alert.png' />등록되지 않은 업소코드 입니다.");

					$("#reg_ccode_name").attr("value","N/A"); //허용불가값으로 지정
				}

			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_login(msg);
				 
			}
		});
		
		return false;
	});

	//ID중복체크 -> 여기서는 존재 체크로 활용한다.
	$("#check_dup_id").click(function() {

		//업소
		if(!$("#reg_id").attr("value")){
			customAlert_login("사용자 ID를 입력하세요");
			$("#reg_id").focus();
			return false;
		}


		$.ajax({
			url: "ajaxUserRegisterChk.php",
			dataType: "json",
			type: "POST",
			data :{
				"flag"    	: "id",
				"userid"	: $("#reg_id").attr("value")
			},
			cache: false,
			beforeSend:function(){
				$("#add_chk_image").css('display', 'inline', 'important');
				$("#add_chk_image").html("<img src='images/ajax-loader.gif' /> 사용자ID 존제 체크중입니다. 잠시기다려 주세요");
				$("#add_chk_msg").hide();

	   		},
			success: function(ret_val){
				//console.dir(ret_val);
				$("#add_chk_image").hide();

				if(ret_val.cnt > 0 ){
                   $("#chk_id_flag").attr("value",$("#reg_id").attr("value") + "사용자 ID 존재");
				   $("#chk_id_flag").attr("value","OK"); //flag 값 사용불가 처리

				}else{
					$("#add_chk_msg").css('display', 'inline', 'important').css('font-size','small');
					$("#add_chk_msg").html("<img src='images/alert.png' />사용자 ID가 존재하지 않습니다.");




				}

			},
			
			error: function(xhr, message, errorThrown){
				var msg = xhr.status + " / " + message + " / " + errorThrown;
				console.dir(xhr); 
				customAlert_login(msg);
				 
			}
		});
		
		return false;
	});






});
		 



