/**
 * @author mjy
 *  good -- http://www.9lessons.info/2014/07/ajax-php-login-page.html
 */


$(document).ready(function(){


	//default로 표시
	$("#loginid").attr("value",localStorage.re_uid);
	$("#password").attr("value",localStorage.re_pwd);


	
	//validation check
	//submit으로 하면 오류발생함 (http://cricri4289.blogspot.kr/2013/10/jquery-ajax-error-code-0.html)
	//$(form).submit(function(){
	$("#login").click(function() {
		var lid,pwd;


		if(!$("#loginid").attr("value")){
			alert("사용자 ID를 입력하세요");
			$("#loginid").focus();
			return false;
		}else{
			lid = $("#loginid").val();
		}
		
		if(!$("#password").attr("value")){
			alert("암호를 입력하세요");
			$("#password").focus();
			return false;
		}else{
			pwd = $("#password").val();
		}
		
		$.ajax({
			url: "../ajaxLogin.php",
			type: "POST",
			data :{
				"userId"    : lid,
				"password"	: pwd,
				"machine"	: "Mobile"
			},
			cache: false,
			beforeSend:function(){
				$("#add_err").css('display', 'inline', 'important');
				$("#add_err").html("<img src='images/ajax-loader.gif' /> 로그인중입니다. 잠시기다려 주세요");
	   		},
			success: function(ret_val){

			console.log("login:"+ret_val);
			console.dir(ret_val);

   				if(ret_val == 2 ){

					//login성공시 localstorage에 id/pwd저장
					localStorage.re_uid = lid;
					localStorage.re_pwd = pwd;

					window.location="main_m.php";

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
				alert(msg);
				 
			}
		});
		
		return false;
	});
		

});
