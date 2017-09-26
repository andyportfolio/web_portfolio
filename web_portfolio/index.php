<?php
	session_start();
	if(!empty($_SESSION['uNum']))
	{
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="css/login_normalize.css">
    <link rel="stylesheet" href="css/login_style.css">
	<link href="plugin/jquery-ui.min.css" rel="stylesheet" >

	<style type="text/css">
		.layer {display:none; position:fixed; _position:absolute; top:0; left:0; width:100%; height:100%; z-index:100;}
			.layer .bg {position:absolute; top:0; left:0; width:100%; height:100%; background:#000; opacity:.5; filter:alpha(opacity=50);}
			.layer .pop-layer {display:block;}

		.pop-layer {display:none; position: absolute; top: 50%; left: 50%; width: 410px; height:auto;  background-color:#fff; border: 5px solid #3571B5; z-index: 10;}	
		.pop-layer .pop-container {padding: 20px 25px;}
		.pop-layer p.ctxt {color: #666; line-height: 25px;}
		.pop-layer .btn-r {width: 100%; margin:10px 0 20px; padding-top: 10px; border-top: 1px solid #DDD; text-align:right;}

		a.cbtn {display:inline-block; height:25px; padding:0 14px 0; border:1px solid #304a8a; background-color:#3f5a9d; font-size:13px; color:#fff; line-height:25px;}	
		a.cbtn:hover {border: 1px solid #091940; background-color:#1f326a; color:#fff;}

		.noti_fm_area_read { font:bold 10pt/130% 굴림체, Arial; color:#333333; border:1px solid #CCCCCC;background-color:transparent;}

		/*.qrcode {position:fixed;top:40px;left:50px;z-index: 20} */
		.qrcode {position:fixed; top:40px; right:10%;z-index: 20}
		}

	</style>

 	<!--<script src="js/check.js"></script>-->

    <script src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>

	<script type="text/javascript" src="js/common.js"></script>
 	<script src="js/login_index.js"></script>
   	<script src="js/login.js"></script>

  
  </head>

  <body class="body">

 <div class="logmod">
  <div class="logmod__wrapper">
   
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-2"><a href="#">login</a></li>
        <li data-tabtar="lgm-1"><a href="#">registration</a></li>
      </ul>
     <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">1. Enter the business code and click the "Business Confirmation Button" </br> 2. Please input "User ID duplicate check button" after inputting user ID </br> 3. * Indicate required fields, please be sure to enter</span>
        </div>
        <div class="err" id="add_chk_image"></div> <!-- ajax check message -->
        <div class="err" id="add_chk_msg"></div> <!-- ajax check message -->

		<div class="logmod__form">
          <form accept-charset="utf-8" action="#" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">agncy code *</label>
                <input class="string optional logininput" maxlength="5" id="reg_ccode" name="reg_ccode" placeholder="agncy code" type="text" size="20" />
				<input type="button" class="chkbtn" id="check_ccode" name="check_ccode" type="sumbit" value="validation button" />
                <input class="string optional" id="reg_ccode_name" name="reg_ccode_name" type="text" size="30" readonly/>

			  </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">User ID *</label>
                <input class="string optiona logininput" maxlength="10" id="reg_id" name="reg_id" placeholder="User ID" type="text" size="20" />
				<input type="button" class="chkbtn" id="check_dup_id" name="check_dup_id" type="sumbit" value="User ID duplicate button" />
                <input type="text" id="chk_id_flag" name="chk_id_flag" size="20" readonly />

			  </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">Username * (Do not enter your real name, business name, or phone number)</label>
                <input class="string optional logininput" maxlength="20" id="reg_username" name="reg_username" placeholder="User name (Hong Kil Dong or Mr.kim)" type="text" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input string optional">
                <label class="string optional" for="user-pw">password *</label>
                <input class="string optional logininput" maxlength="10" id="reg_password" name="reg_password" placeholder="password" type="password" size="10" />
              </div>
              <div class="input string optional">
                <label class="string optional" for="user-pw-repeat">re-password *</label>
                <input class="string optional logininput" maxlength="10" id="reg_re_password" name="reg_re_password" placeholder="re-password" type="password" size="10" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input string optional">
                <label class="string optional" for="user-pw">Telephone *</label>
                <input class="string optional logininput" maxlength="4" id="reg_tel1" name="reg_tel1"  type="text" size="4" placeholder="02" />
                <input class="string optional logininput" maxlength="4" id="reg_tel2" name="reg_tel2"  type="text" size="4" placeholder="1234" />
                <input class="string optional logininput" maxlength="4" id="reg_tel3" name="reg_tel3"  type="text" size="4" placeholder="5678" />
			  </div>
              <div class="input string optional">
                <label class="string optional" for="user-pw">Cell Phone*</label>
                <input class="string optional logininput" maxlength="4" id="reg_mobile1" name="reg_mobile1"  type="text" size="3" placeholder="416" />
                <input class="string optional logininput" maxlength="4" id="reg_mobile2" name="reg_mobile2"  type="text" size="3" placeholder="617" />
                <input class="string optional logininput" maxlength="4" id="reg_mobile3" name="reg_mobile3"  type="text" size="4" placeholder="9395" />
			  </div>
              <div class="input string optional">
                <label class="string optional" for="user-pw">FAX</label>
                <input class="string optional logininput" maxlength="4" id="reg_fax1" name="reg_fax1"  type="text" size="4" placeholder="416"/>
                <input class="string optional logininput" maxlength="4" id="reg_fax2" name="reg_fax2"  type="text" size="4" placeholder="617"/>
                <input class="string optional logininput" maxlength="4" id="reg_fax3" name="reg_fax3"  type="text" size="4" placeholder="9395"/>
			  </div>
              <div class="input string optional">
                <label class="string optional" for="user-pw">email *</label>
                <input class="string optional logininput" maxlength="20" id="reg_email" name="reg_email"  type="text" size="20" placeholder="abc@abc.com"/>
			  </div>
			</div>

			<div class="simform__actions">
              <input class="sumbit" id="register" name="commit" type="sumbit" value="registration" readonly/>
              <span class="simform__actions-sidetext">The system is licensed according to the operating policy.</span>
            </div> 
          </form>
        </div> 
        <div class="logmod__alter">
          <div class="logmod__alter-container">
            <a href="#" class="connect facebook">
              <div class="connect__icon">
                
              </div>
              <div class="connect__context">
                <span><strong><span class="logo"></span></strong></span>
              </div>
            </a>
          </div>
		</div>

	  </div>  <!-- logmod__tab lgm-1  -->

      <div class="logmod__tab lgm-2">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle"><strong>Please enter your user ID and password</strong></span>
        </div> 
        <div class="logmod__form">
          <form accept-charset="utf-8" method="post" name="form" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">User ID *</label>
                <input class="string optional logininput" maxlength="20" id="loginid" name="loginid" placeholder="User ID" type="text" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-pw">Password *</label>
                <input class="string optional logininput" maxlength="20" id="password" name="password" placeholder="Password" type="password" size="50" />
              </div>
            </div>
            <div class="err" id="add_err"></div>
            <div class="simform__actions">
              <input class="sumbit" name="commit" id="login" type="sumbit" value="Login" readonly/>
              <span class="simform__actions-sidetext"><a class="special" role="link" href="passwordreset.php">Forgot your password? <br> Click here</a></span>
            </div> 
          </form>
        </div> 
        <div class="logmod__alter">
          <div class="logmod__alter-container">
            <a href="#" class="connect facebook">
              <div class="connect__icon">
                
              </div>
              <div class="connect__context">
                <span><strong><span class="logo"></span></strong></span>
              </div>
            </a>
          </div>
        </div>
      </div> <!-- logmod__tab lgm-2  -->

     </div> <!-- logmod__tab-wrapper  -->

   </div> <!-- logmod__container -->

 </div> <!-- logmod__wrapper -->

</div>	<!--logmod -->

<div class="qrcode"><img src="images/QRCode.jpg" alt="Mobile Site"></div> 
<div id="dialog-confirm"></div> 



<?php

	require_once 'config.php';

	//encoding
	mysqli_query($conn, "set names utf8");

	//오늘에 해당되는 공지사항 중 유효한것을 가져온다
$sql = "select * from notify where DATE_FORMAT(from_date, '%Y-%m-%d') <= DATE_FORMAT(now(), '%Y-%m-%d') and DATE_FORMAT(to_date, '%Y-%m-%d') >= DATE_FORMAT(now(), '%Y-%m-%d') and status ='0' order by nnum DESC;";

	//echo $sql;

	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 0;

	if( $result->num_rows > 0) {

		$i = $i + 1;	
?>
<!--http://mylko72.maru.net/jquerylab/study/layer-popup.html -->
<div class="layer">
	<div class="bg"></div>
	<div class="pop-layer" id="layer2">
		<div class="pop-container">
			<div class="pop-conts">
				<!--content //-->
<?
	   while($row = $result->fetch_assoc()) {

?>
				<p class="ctxt mb20">[<?=$row['nnum']?>]&nbsp;<?=$row['title']?><br>
					<textarea id="content" name="content" rows="10" cols="40" tabindex="4" class="noti_fm_area_read"><?=$row['content']?></textarea>
				</p>
				<p>
<?
		}

?>
				<div class="btn-r">
					<a class="cbtn" href="#">닫기</a>
				</div>
				<!--// content-->
			</div>
		</div>
	</div>
</div>

<?
	}

	$conn->close();
?>

<?
	if ($i > 0){
?>
<script type="text/javascript">
	function layer_open(el){

		var temp = $('#' + el);
		var bg = temp.prev().hasClass('bg');	//dimmed 레이어를 감지하기 위한 boolean 변수

		if(bg){
			$('.layer').fadeIn();	//'bg' 클래스가 존재하면 레이어가 나타나고 배경은 dimmed 된다. 
		}else{
			temp.fadeIn();
		}

		// 화면의 중앙에 레이어를 띄운다.
		if (temp.outerHeight() < $(document).height() ) temp.css('margin-top', '-'+temp.outerHeight()/2 +'px');
		else temp.css('top', '0px');
		if (temp.outerWidth() < $(document).width() ) temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
		else temp.css('left', '0px');

		temp.find('a.cbtn').click(function(e){
			if(bg){
				$('.layer').fadeOut(); //'bg' 클래스가 존재하면 레이어를 사라지게 한다. 
			}else{
				temp.fadeOut();
			}
			e.preventDefault();
		});

		$('.layer .bg').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
			$('.layer').fadeOut();
			e.preventDefault();
		});

	}	
	
	layer_open('layer2'); //화면에 display
</script>
<?
	}
?>

  </body>
</html>
