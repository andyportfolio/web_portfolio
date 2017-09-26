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
	$("#login").click(function() {
		
				
		if(!$("#loginid").attr("value")){
			customAlert_login("사용자 ID를 입력하세요");
			$("#loginid").focus();
			return false;
		}
		
		if(!$("#password").attr("value")){
			customAlert_login("암호를 입력하세요");
			$("#password").focus();
			return false;
		}
		
		$.ajax({
			url: "ajaxLogin.php",
			type: "POST",
			data :{
				"userId"    	: $("#loginid").val(),
				"password"	: $("#password").val(),
				"machine"	: "PC"
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> 로그인중입니다. 잠시기다려 주세요");
	   		},
			success: function(ret_val){

			//console.log("login:"+ret_val);
			//console.dir(ret_val);

   				if(ret_val == 2 ){
					window.location="main.php";

				}else if (ret_val == 1)
				{
					$("#add_err").css('display', 'inline', 'important');
					$("#add_err").css('font-size','small');
					$("#add_err").html("<img src='images/alert.png' />승인 처리중인 아이디 입니다. 관리자 승인 완료후 로그인 가능합니다.");
					
				}else{
					$("#add_err").css('display', 'inline', 'important');
					$("#add_err").css('font-size','small');
					$("#add_err").html("<img src='images/alert.png' />등록되지 않은 아이디이거나, 아이디 또는 비밀번호를 잘못 입력하셨습니다");
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

	//사용자 등록
	$("#register").click(function() {

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
			customAlert_login("등록되지 않은 업소코드 입니다.관리자에게 업소코드를 받으세요");
			$("#reg_ccode").focus();
			return false;
		}

		//사용자
		if(!$("#reg_id").attr("value")){
			customAlert_login("사용하실 사용자 ID를 입력하세요");
			$("#reg_id").focus();
			return false;
		}

		if($("#chk_id_flag").attr("value") == "N/A"){
			customAlert_login("사용자ID중복체크 버튼을 클릭하여 주세요");
			$("#reg_id").focus();
			return false;
		}

		if(!$("#reg_username").attr("value")){
			customAlert_login("사용하실 사용자의 성명을 입력하세요");
			$("#reg_username").focus();
			return false;
		}
		

		if(!$("#reg_password").attr("value")){
			customAlert_login("암호를 입력하세요");
			$("#reg_password").focus();
			return false;
		}

		if(!$("#reg_re_password").attr("value")){
			customAlert_login("암호 재 입력란에 암호를 다시 입력하세요");
			$("#reg_re_password").focus();
			return false;
		}


		if(!($("#reg_password").attr("value") == $("#reg_re_password").attr("value"))){
			customAlert_login("암호와 재 입력하신 암호가 동일하지 않습니다. 다시 입력하세요");
			$("#reg_password").focus();
			return false;
		}


		if(!$("#reg_tel1").attr("value")){
			customAlert_login("전화번호 첫번째 자리를 입력하세요");
			$("#reg_tel1").focus();
			return false;
		}

		if(!$("#reg_tel2").attr("value")){
			customAlert_login("전화번호 두번째 자리를 입력하세요");
			$("#reg_tel2").focus();
			return false;
		}
		if(!$("#reg_tel3").attr("value")){
			customAlert_login("전화번호 세번째 자리를 입력하세요");
			$("#reg_tel3").focus();
			return false;
		}

		if(!$("#reg_mobile1").attr("value")){
			customAlert_login("핸드폰번호 첫번째 자리를 입력하세요");
			$("#reg_mobile1").focus();
			return false;
		}

		if(!$("#reg_mobile2").attr("value")){
			customAlert_login("핸드폰번호 두번째 자리를 입력하세요");
			$("#reg_mobile2").focus();
			return false;
		}
		if(!$("#reg_mobile3").attr("value")){
			customAlert_login("핸드폰번호 세번째 자리를 입력하세요");
			$("#reg_mobile3").focus();
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
			v_tel1 =	 $("#reg_tel1").attr("value");
			v_tel2 =	 $("#reg_tel2").attr("value");
			v_tel3 =	 $("#reg_tel3").attr("value");
			v_mobile1 =	 $("#reg_mobile1").attr("value");
			v_mobile2 =	 $("#reg_mobile2").attr("value");
			v_mobile3 =	 $("#reg_mobile3").attr("value");
			v_fax1 =	 $("#reg_fax1").attr("value");
			v_fax2 =	 $("#reg_fax2").attr("value");
			v_fax3 =	 $("#reg_fax3").attr("value");
			v_email =    $("#reg_email").attr("value");

		//사용자 등록
		$.ajax({
			url: "ajaxUserManage.php",
			type: "POST",
			dataType:"JSON",
			data :{
					"type"	: "01", //01 사용자등록 ,02 사용자승인, 03. 관리자 지정/해제 04. 본인정보수정
					"ccode":    v_ccode, 
					"userid":   v_userid,
					"password":	v_password,
					"username":	v_username,
					"tel1":	 	v_tel1,
					"tel2":	 	v_tel2,
					"tel3":	  	v_tel3,
					"mobile1":	v_mobile1, 
					"mobile2": 	v_mobile2,
					"mobile3": 	v_mobile3, 
					"fax1":	  	v_fax1,
					"fax2":	 	v_fax2,	
					"fax3":	  	v_fax3,
					"email":   	v_email, 
					"oauth":  "U", //default - user
					"status": "N"  //default - 사용불가	
			},
			cache: false,
			beforeSend:function(){
				$("#add_chk_image").css('display', 'inline', 'important');
				$("#add_chk_image").html("<img src='images/ajax-loader.gif' /> 사용자 등록요청 진행중입니다. 잠시기다려 주세요");

	   		},
			success: function(ret_val){

				//console.dir(ret_val);
				//console.log(ret_val);
				
				if(ret_val.status == "Success" ){
					//console.log("insert 성공");
					customAlert_login("사용자 등록요청을 완료했습니다. 관리자 승인 이후 로그인이 가능합니다.");

					$("#add_chk_image").hide();

				}else if(ret_val.status == "Duplicate" ){
					//alert("not equal");
					$("#add_chk_image").css('display', 'inline', 'important');
					$("#add_chk_image").html("<img src='images/alert.png' /> 동일한 사용자 ID가 등록되어 있습니다. 다른 사용자 ID를 사용해 주세요");
				}else{
					//alert("not equal");
					$("#add_chk_image").css('display', 'inline', 'important');
					$("#add_chk_image").html("<img src='images/alert.png' />사용자 등록요청중 오류가 발생하였습니다.");
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
				console.dir(ret_val);
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
					$("#add_chk_msg").html("<img src='images/alert.png' />등록되지 않은 업소코드 입니다.관리자에게 업소코드를 받으세요");

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

	//ID중복체크 
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
				$("#add_chk_image").html("<img src='images/ajax-loader.gif' /> 사용자ID중복 체크중입니다. 잠시기다려 주세요");
				$("#add_chk_msg").hide();

	   		},
			success: function(ret_val){
				console.dir(ret_val);
				$("#add_chk_image").hide();

				if($.type(ret_val) === "object" && ret_val.cnt > 0 ){
					$("#add_chk_msg").css('display', 'inline', 'important').css('font-size','small');
					$("#add_chk_msg").html("<img src='images/alert.png' />사용중인 ID 입니다.다른 사용자 ID를 입력하세요");

				    $("#chk_id_flag").attr("value","N/A"); //flag 값 사용불가 처리

				}else{

                   $("#chk_id_flag").attr("value",$("#reg_id").attr("value") + "사용가능");

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
		 



