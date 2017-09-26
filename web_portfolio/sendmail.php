<?
function sendMail($EMAIL, $NAME, $mailto, $SUBJECT, $CONTENT){
  //$EMAIL : 답장받을 메일주소
  //$NAME : 보낸이
  //$mailto : 보낼 메일주소
  //$SUBJECT : 메일 제목
  //$CONTENT : 메일 내용
  $admin_email = $EMAIL;
  $admin_name = $NAME;

  $header = "Return-Path: ".$admin_email."\n";
  $header .= "From: =?EUC-KR?B?".base64_encode($admin_name)."?= <".$admin_email.">\n";
  $header .= "MIME-Version: 1.0\n";
  $header .= "X-Priority: 3\n";
  $header .= "X-MSMail-Priority: Normal\n";
  $header .= "X-Mailer: FormMailer\n";
  $header .= "Content-Transfer-Encoding: base64\n";
  $header .= "Content-Type: text/html;\n \tcharset=euc-kr\n";

  $subject = "=?EUC-KR?B?".base64_encode($SUBJECT)."?=\n";
  $contents = $CONTENT;

  $message = base64_encode($contents);
  flush();
  return mail($mailto, $subject, $message, $header);
}

 sendMail("mjywill@naver.com", "mjywill@naver.com", "mjywill@naver.com", "test title", "test content"); 

?>