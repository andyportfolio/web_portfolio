<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="UTF-8">
    <title>암호초기화 요청</title>
    <link rel="stylesheet" href="css/login_normalize.css">
    <link rel="stylesheet" href="css/login_style.css">
	<link href="plugin/jquery-ui.min.css" rel="stylesheet" >

 	<!--<script src="js/check.js"></script>-->

    <script src="js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>

	<script type="text/javascript" src="js/common.js"></script>
 	<script src="js/login_index.js"></script>
   	<script src="js/passwordreset.js"></script>
    
  </head>

  <body class="body">

 <div class="logmod">
  <div class="logmod__wrapper">
    
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-1"><a href="#">암호초기화 요청 화면</a></li>
      </ul>
      <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">1. 부여받으신 업소코드 입력후 "업소확인 버튼 클릭" </br>2. 사용자 ID 입력 후 "사용자 ID 체크 버튼" 클릭&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br> 3. * 표시는 필수입력 사항임으로 반드시 입력&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>4. 등록하셨던 email 로 암호가 재발송 됩니다.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
        <div class="err" id="add_chk_image"></div> <!-- ajax check message -->
        <div class="err" id="add_chk_msg"></div> <!-- ajax check message -->

		<div class="logmod__form">
          <form accept-charset="utf-8" action="#" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">업소코드 *</label>
                <input class="string optional logininput" maxlength="5" id="reg_ccode" name="reg_ccode" placeholder="업소코드" type="text" size="20" />
				<input type="button" class="chkbtn" id="check_ccode" name="check_ccode" type="sumbit" value="업소확인 버튼" />
                <input class="string optional" id="reg_ccode_name" name="reg_ccode_name" type="text" size="30" readonly/>

			  </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">사용자ID *</label>
                <input class="string optiona logininput" maxlength="10" id="reg_id" name="reg_id" placeholder="사용자ID" type="text" size="20" />
				<input type="button" class="chkbtn" id="check_dup_id" name="check_dup_id" type="sumbit" value="사용자ID 체크 버튼" />
                <input type="text" id="chk_id_flag" name="chk_id_flag" size="20" readonly />

			  </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">사용자명 *</label>
                <input class="string optional logininput" maxlength="20" id="reg_username" name="reg_username" placeholder="사용자명" type="text" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" for="user-name">email 주소* (회원가입 시 등록하셨던 email 주소)</label>
                <input class="string optional logininput" maxlength="20" id="reg_email" name="reg_email" placeholder="abc@abc.com" type="text" size="50" />
              </div>
            </div>

			<div class="simform__actions">
              <input class="sumbit" id="passwordreset" name="commit" type="sumbit" value="암호 초기화 요청" readonly/>
              <span class="simform__actions-sidetext"></span>
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
      </div>
      </div>
    </div>
  </div>
</div>
<div id="dialog-confirm"></div>    
    
  </body>
</html>
