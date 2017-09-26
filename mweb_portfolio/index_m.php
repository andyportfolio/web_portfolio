<?php
	session_start();
	if(!empty($_SESSION['uNum']))
	{
		header('Location: main_m.php');  //sub1_1.php
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
	<!--<meta name="apple-mobile-web-app-capable" content="yes">-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<meta name="author" content="andy.mo">
	<title>로그인</title>

	<link rel="apple-touch-icon" href="images/app_icon.png" />
	<link rel="apple-touch-icon-precomposed" href="images/app_icon.png" />
	<link rel="apple-touch-startup-image" href="images/startup.png"/>
	 
	<link rel="stylesheet" href="css/style.css">
	<!--<link rel="stylesheet" href="css/new_style.css">-->

	 <script>
			window.addEventListener('load', function(){setTimeout(scrollTo, 0, 0, 1);}, false);
	 </script>

	
	 <script src="js/jquery-1.8.3.min.js"></script>
	 <script src="js/common.js"></script> <!--request-->
	 <script src="js/login.js"></script> <!--request-->
	   
	<!--[if lt IE 9]> 
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->


	</head>

	<body>
 

 <form action="index.html" class="login">
	<div id="add_err"></div>
    <h1><span class="loginlogo"></span></h1>
    <input type="text" id="loginid" name="loginid" class="login-input" placeholder="User ID" autofocus>
    <input type="password" id="password" name="password" class="login-input" placeholder="Password">
    <input type="submit" value="Login" class="login-submit" id="login">
  </form>

	<!--  
	  <section class="container">
	   <div class="err" id="add_err"></div>

		<div class="login">
		  <h1>다우리</h1>
		  <form name="form" method="post">
			<p><input type="text" id="loginid" name="loginid" value="" placeholder="사용자ID" maxlength="20"></p>
			<p><input type="password" id="password" name="password" value="" placeholder="암호" maxlength="20"></p>
			<p class="submit"><input type="button" class="login_btn" id="login" name="sumitbn" value="로그인"></p>
		  </form>
		</div>

	  </section>

   -->


		

	  </body>
	</html>
