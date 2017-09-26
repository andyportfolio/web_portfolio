 	//getDateTime
	function getDateTime(){
		var d = new Date();
		var yy = d.getFullYear();
		var mm = d.getMonth()+1;
		var dd = d.getDate();
		var hh = d.getHours();
		var mi = d.getMinutes();
		var ss = d.getSeconds();
		var result = yy + "-" + setWordLenth(mm, 2) + "-" + setWordLenth(dd, 2) + " " + setWordLenth(hh, 2) + ":" + setWordLenth(mi, 2) + ":" + setWordLenth(ss, 2);
		return result;
	}	  


 	//getDate
	function getDate(){
		var d = new Date();
		var yy = d.getFullYear();
		var mm = d.getMonth()+1;
		var dd = d.getDate();
		var result = yy + "-" + setWordLenth(mm, 2) + "-" + setWordLenth(dd, 2);
		return result;
	}	  


	//getDateTime
	function getTime(){
		var d = new Date();
		var yy = d.getFullYear();
		var mm = d.getMonth()+1;
		var dd = d.getDate();
		var hh = d.getHours();
		var mi = d.getMinutes();
		var ss = d.getSeconds();
		var result =  setWordLenth(hh, 2) + ":" + setWordLenth(mi, 2) + ":" + setWordLenth(ss, 2);
		return result;
	}	  
	
	//setwordLenth
	function setWordLenth(n, len) {
		var str = new String(n);
		if (str.length < len) {
			for (var i=str.length; i<len; i++) {
				str = "0" + str;
			}
		}
	
		return str;
	} 		
	

// 왼쪽부터 숫자 들어가고, 숫자만 입력되는 코드
//http://ihelpers.x2soft.co.kr/programming/tipntech.php?CMD=view&TYPE=0&KEY=%C3%B5%B4%DC%C0%A7&SC=S&&CC=C&PAGE=1&IDX=145
function currency(obj)
{
	if (event.keyCode >= 48 && event.keyCode <= 57) {
		
	} else {
		event.returnValue = false;
	}
}
function com(obj)
{
	obj.value = unComma(obj.value);
	obj.value = Comma(obj.value);
}
function Comma(input) {

  var inputString = new String;
  var outputString = new String;
  var counter = 0;
  var decimalPoint = 0;
  var end = 0;
  var modval = 0;

  	//2016-10-18 추가 (null값 처리시 오류)
	if( input == "" || input == null || input == undefined ){
		inputString = "0";
	}else{
	    inputString = input.toString();
	}
  outputString = '';
  decimalPoint = inputString.indexOf('.', 1);

  if(decimalPoint == -1) {
     end = inputString.length - (inputString.charAt(0)=='0' ? 1:0);
     for (counter=1;counter <=inputString.length; counter++)
     {
        var modval =counter - Math.floor(counter/3)*3;
        outputString = (modval==0 && counter <end ? ',' : '') + inputString.charAt(inputString.length - counter) + outputString;
     }
  }
  else {
     end = decimalPoint - ( inputString.charAt(0)=='-' ? 1 :0);
     for (counter=1; counter <= decimalPoint ; counter++)
     {
        outputString = (counter==0  && counter <end ? ',' : '') +  inputString.charAt(decimalPoint - counter) + outputString;
     }
     for (counter=decimalPoint; counter < decimalPoint+3; counter++)
     {
        outputString += inputString.charAt(counter);
     }
 }
    return (outputString);
}

/* -------------------------------------------------------------------------- */
/* 기능 : 숫자에서 Comma 제거                                                 */
/* 파라메터 설명 :                                                            */
/*        -  input : 입력값                                                   */
/* -------------------------------------------------------------------------- */
function unComma(input) {
   var inputString = new String;
   var outputString = new String;
   var outputNumber = new Number;
   var counter = 0;
   if (input == '')
   {
	return 0;
   }
   inputString=input;
   outputString='';
   for (counter=0;counter <inputString.length; counter++)
   {
      outputString += (inputString.charAt(counter) != ',' ?inputString.charAt(counter) : '');
   }
   outputNumber = parseFloat(outputString);
   return (outputNumber);
}

/* -------------------------------------------------------------------------- */
/* 기능 : Poup                                                 */
/* 파라메터 설명 :                                                            */
/*        -  input : 입력값                                                   */
/* -------------------------------------------------------------------------- */
	function reply_popup(param){
		var windowWidth = 595;
		var windowHeight = 742; //842가 너무 길어서 742로 수정
		
		var url = "reply_popup.php?num=" + param;
		var windowName = "popUp"+param;  //창을 여러개 띠우기 위해서 windowName을 다르게 지정
		//alert("popup");
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');

    	sst.focus();

	}

	function replyconfirm_popup(param,v_src){

		var windowWidth = 595;
		var windowHeight; //842가 너무 길어서 742로 수정

		if (v_src =="list")
		{
			windowHeight = 742;
		}else{
			windowHeight = 500; //알람에서 호출시 size를 작게한다.

		}
		
		var url = "replyconfirm_popup.php?num=" + param;
		var windowName = "popUp"+param;  //창을 여러개 띠우기 위해서 windowName을 다르게 지정
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');

    	sst.focus();
	}

	//1221 변경
	function replyconfirmforNoti_popup(param1,param2){

		var windowWidth = 595;
		var windowHeight = 500; //부모-자식(1개) 만 표시됨으로 size는 작게나온다
		
		//param1: refer_rnum , param2:rnum
		var url = "replyconfirmforNoti_popup.php?num1=" + param1 + "&num2=" + param2;
		var windowName = "NotifypopUp"+param2;  //창을 여러개 띠우기 위해서 자식이름을 사용
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');

    	sst.focus();
	}


	function chk_replyconfirm_popup(param){

		var windowWidth = 595;
		var windowHeight = 500; 
		
		var url = "chk_replyconfirm_popup.php?num=" + param;
		var windowName = "popUp"+param;  //창을 여러개 띠우기 위해서 windowName을 다르게 지정
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');

    	sst.focus();
	}

	//alert창
	function customAlert(val) {

		$("#dialog-Sucess > p").html(val);
		$("#dialog-Sucess").dialog();
	}


	function notifyService_popup(){
		var windowWidth = 900;
		var windowHeight = 800;
		
		var url = "notifyMgmt.php?";
		var windowName = "notifypopUp";
		
		//var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}


	function orgService_popup(){
		var windowWidth = 900;
		var windowHeight = 800;
		
		var url = "orgMgmt.php?";
		var windowName = "orgpopUp";
		
		//var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}

	function userService_popup(){
		var windowWidth = 900;
		var windowHeight = 800;
		
		var url = "userMgmt.php?";
		var windowName = "userpopUp";
		
		//var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}


	function userInfo_popup(){
		var windowWidth = 600;
		var windowHeight = 500;
		
		var url = "userInfo.php?";
		var windowName = "userInfopopUp";
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		//var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}


	function searchService_popup(){
		var windowWidth = 595;
		var windowHeight = 742; //842가 너무 길어서 742로 수정
		
		var url = "searchReply.php?";
		var windowName = "searchReplypopUp";
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		//var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}


	//20170305 add
	function dataMgmt_popup(){
		var windowWidth = 600;
		var windowHeight = 500;
		
		var url = "dataMgmt.php?";
		var windowName = "dataMgmtpopUp";
		
		var sst = window.open(url,windowName,'top='+((screen.availHeight - windowHeight)/2 - 40) +', left='+(screen.availWidth - windowWidth)/2+', width='+windowWidth+', height='+windowHeight+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
		//var sst =  window.open(url, windowName, ',type=fullWindow,fullscreen,scrollbars=yes');
    	sst.focus();
	}

$(document).ready(function() {

   //title
   document.title = "InfoNetworks";
   $(".logo").text("© InfoNetworks.");


	//공지사항관리
	 $(document).on("click", "#notify_mgmt", function(event){
		event.preventDefault();
		notifyService_popup();

	});



	//업소관리
	 $(document).on("click", "#org_mgmt", function(event){
		event.preventDefault();
		orgService_popup();

	});

	//사용자 관리
	 $(document).on("click", "#user_mgmt", function(event){
		event.preventDefault();
		userService_popup();

	});

 
	//답장한 매수내역 찾기
	 $(document).on("click", "#search_mgmt", function(event){
		event.preventDefault();
		searchService_popup();

	});


	//사용자 정보 수정
	 $(document).on("click", "#userinfo_mgmt", function(event){
		event.preventDefault();
		userInfo_popup();
		

	});

	//20170305 add
	//데이터관리 
	 $(document).on("click", "#data_mgmt", function(event){
		event.preventDefault();
		dataMgmt_popup();
		

	});


});
