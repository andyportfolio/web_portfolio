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
	<title>타업소 매수 목록</title>

	<link rel="apple-touch-icon" href="images/app_icon.png" />
	<link rel="apple-touch-icon-precomposed" href="images/app_icon.png" />
	<link rel="apple-touch-startup-image" href="images/startup.png"/>
	 
	<link href="css/common.css" rel="stylesheet" type="text/css">

	<link href="css/sub_layout.css" rel="stylesheet" type="text/css">
	<link href="css/main_m.css" rel="stylesheet" type="text/css">


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
		
		
			//상세 보기를 위해서 클릭
			 $(document).on("click", "#requestDetail_btn", function(event){
				event.preventDefault();
				//alert("#requestDetail_btn;"+$(this).attr("href"));

				var param = $(this).attr("href");
				var url = "reply_popup_m.php?num=" + param;
				var windowName = "reply_popup_m";
		

				var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    			sst.focus();

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
    <li><a href="requestlistOT_m.php" title="retrieve" class="tab_m  on">Ot Agent</a></li>
    <li><a href="request_m.php" title="notice" class="tab_m">Find</a></li>
   </ul>
  </nav>
 </header>
 <!-- header e  -->
 <!-- article s  -->
 <article>
	<div id="main"><!-- 콘텐츠 삽입 부분 -->
			

<?php

	require_once '../config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//당업소 목록(상태-정상) 표시된다.


	$sql = "select a.rnum,a.reg_date,a.region,a.category,a.type,(select count(*) from request x where x.req_type = '02' and x.refer_rnum = a.rnum and x.ccode = '$ccode'  ) as rcnt ,a.area_from,a.area_to,a.floor_from,a.floor_to,a.sprice_from,a.sprice_to,a.dprice_from,a.dprice_to,a.rprice_from,a.rprice_to, a.title,a.content,a.status,a.cname,a.reg_name from request a where a.req_type = '01' and a.status = '0' and a.ccode <> '$ccode' order by a.rnum desc;"; 


	//echo $sql;

	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 1;

	$dis_color = "black";

	//echo $result->num_rows; 
	$html_title = "조회: ".date("Y-m-d H:i:s")." ".$result->num_rows."건"; 

?>
	<div>
		<h2 align="center"><?=$html_title?></h2>
	</div>

		<div class="requestlist">
			<ul class="n_search_list" id="resultlist">

<?

	if( $result->num_rows > 0) {
			
	   while($row = $result->fetch_assoc()) {

?>

	 
	 <li>
<?
		if($i % 2 == 1){ //홀수
?>
			<div class='div_data'><a href=<?=$row['rnum']?> id="requestDetail_btn">
<?
		}else{	//짝수
?>
			<div class='div_data pink'><a href=<?=$row['rnum']?> id="requestDetail_btn">
<?
		}

		if ($row['type'] == "급매"){
			$dis_color = "red";
		}else{
			$dis_color = "black";
		}

?>
		   <div class='div_left'><h3><?=$row['title']?>(<?=$row['rcnt']?>)&nbsp;</h3><p>[<?=$row['rnum']?>]&nbsp;<span style="color:<?=$dis_color?>"><?=$row['type']?></span>-<?=$row['category']?>-<?=$row['region']?></div>
		   <div class='div_right'><?=$row['reg_date']?><br><?=$row['cname']?></div>
		</a></div>
	  </li>

<?
		$i = $i + 1;

	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();

?>
				</ul>
			</div> <!--requestlist end -->
		</div><!-- 콘텐츠 삽입 부분 end -->
			
    
    
	<div id="nodata"></div>
  
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
