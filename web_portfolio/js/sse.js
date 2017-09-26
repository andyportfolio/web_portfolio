/**
 * @author mjy
 *  good -- http://www.9lessons.info/2014/07/ajax-php-login-page.html
 * https://developer.mozilla.org/en-US/docs/Web/API/Notifications_API/Using_the_Notifications_API
 * 주제: web notification
 */


$(document).ready(function(){
	var pre_param_rnum = 0; //1월16일 수정사항 - 동일번호의 Noti가 뜨는 오류방지
	var notify_audio;

	
	/*
	 * window popup
	 */
	function custom_openwin01(url,winname){
 		var width = 595;
		var height = 500; //842; -- size를 줄임
	
      var sst = window.open(url,winname,'top='+((screen.availHeight - height)/2 - 40) +', left='+(screen.availWidth - width)/2+', width='+width+', height='+height+', fullscreen=yes , toolbar=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0');
 	 if(sst){
    	sst.focus();
  		}
	}
	
	/*
	 * notification
	 */
   function re_notification(param_rnum,param_req_type,param_refer_rnum,param_type,param_origin_rnum,param_title,param_content,param_reg_date,param_cname,param_ccode,param_receive_ccode) {
   	//https://developer.mozilla.org/ko/docs/Web/API/Notification
   	//https://notifications.spec.whatwg.org/#dom-notification-onclick
   	var mbody,mtitle,mdir,micon,session_ccode,music_file,music_flag;

	

	session_ccode =$("#session_ccode").attr("value"); //현재 Login한 


	if (param_req_type == "01" && param_ccode != session_ccode ){ //남이 한 매수

		if (param_type == "급매"){
		    mtitle = "급매등록입니다.";
		}else{
		    mtitle = "Finding For Sale.";
		}

		mbody = "[No] " + param_rnum + "\n" + "[Reg] " + param_reg_date + "\n" + "[Title] " + param_title + "\n" + "[Agent] " + param_cname + "\n" ;

	    mdir = "rtl";
	    micon= "images/notify.jpg";

		music_file = "music/notify.mp3";
		music_flag = "notify";


	}else if(param_req_type == "02" && param_receive_ccode == session_ccode){ //수신처가 나로 지정된 답장
		mbody = "[No] " + param_rnum + "\n" + "[Reg] " + param_reg_date + "\n" + "[Title] " + param_content + "\n" + "[Agent] " + param_cname + "\n" ;
	    mtitle = "I have a reply.";
	    mdir = "rtl";
	    micon= "images/reply.png";

		music_file = "music/reply.mp3";
		music_flag = "reply";

	}else if(param_req_type == "03" && param_receive_ccode == session_ccode){ //수신처가 나로 지정된 답장회신
		mbody = "[No] " + param_rnum + "\n" + "[Reg] " + param_reg_date + "\n" + "[Title] " + param_content + "\n" + "[Agent] " + param_cname + "\n" ;
	    mtitle = "Reply-To.";
	    mdir = "rtl";
	    micon= "images/reflyconfirm.png";
		music_file = "music/reply.mp3";
		music_flag = "reply";


	}else{
		//나머지는 return
		//내가 보낸 매수, 내가보낸 답장, 내가보낸 답장회신 은 알림을 받지 않는다
		return false;
	}

   	//console.log(Notification);
   	//console.dir(Notification);
   	
	//1월16일 수정사항=동일한 번호가 2개 뜨는경우가 존재한다
	//이전에 띄운 노티 번호와 같으면 무시
	if (pre_param_rnum == param_rnum){
		return false;
	}else{
		pre_param_rnum = param_rnum;

		//notify_audio = new Audio(music_file); // buffers automatically when created
		console.log("new audio play start: " + new Date($.now()*1000));

		if (music_flag == "notify"){
			document.getElementById("play_notify").play();
		}else{
			document.getElementById("play_reply").play();
		}

		//notify_audio.play();
		console.log("new audio play end: " + new Date($.now()*1000));

	}

  	

  	// Let's check if the browser support notifications
	  if (!"Notification" in window) {
	    alert("This browser does not support desktop notification");
	  }
	//Let's check if the user is okay to get some notification
	  else if (Notification.permission === "granted") {
	    // If it's okay let's create a notification
	    
	    /*
	    	dir : The direction of the notification, it can be auto, ltr or rtl
			lang: Specifiy the lang used within the notification. This string must be a valide BCP 47 language tag.
			body: A string representing an extra content to display within the notification
			tag: An ID for a given notification that allow to retrieve, replace remove it if necessary
			icon: The URL of an image to be used as an icon by the notification
	    */
		//사용자 action까지 notify가 남아있음
		//https://developers.google.com/web/updates/2015/10/notification-requireInteraction
	    	var noti = new Notification(mtitle,{
	    		body: mbody,
	    		dir : mdir,
	    		tag: param_rnum,
				requireInteraction: true, 
				icon: micon
    		});

			 
	 		console.log("Notification: " + new Date($.now()*1000));
			console.dir(noti);
			//var notify_audio;

			noti.onshow = function() { 
				//var notify_audio = new Audio("file:///C:/Kalimba.mp3"); // 여기서는 사용불가-local resource 접근 불가임
				
				//notify_audio = new Audio(music_file); // buffers automatically when created
				//notify_audio.play();

			};



			noti.onclick = function() { 
				
				//notify_audio.pause();

				//alert("click"+param_rnum);
				noti.close();

				
				if (param_req_type == "01" && param_ccode != session_ccode ){ //남이 한 매수
					var url = "reply_popup.php?num=" +param_rnum;	
			
				}else if(param_req_type == "02" && param_receive_ccode == session_ccode){ //수신처가 나로 지정된 답장
					//var url = "replyconfirm_popup.php?num=" +param_refer_rnum;	
					var url = "replyconfirmforNoti_popup.php?num1=" +param_refer_rnum + "&num2=" + param_rnum;;	
				}else if(param_req_type == "03" && param_receive_ccode == session_ccode){ //수신처가 나로 지정된 답장회신
					var url = "chk_replyconfirm_popup.php?num=" +param_origin_rnum;	
				}

				var windowName = "NotifypopUp"+param_rnum;  //창을 여러개 띠우기 위해서 windowName을 다르게 지정
				custom_openwin01(url,windowName);
					
				
	 			
    		};   
  
       		noti.onclose = function() { 

				//notify_audio.pause();

    			//console.log("close");
    			//noti.close();
    		};   
  	  }
  		// Otherwise, we need to ask the user for it's permission
  		// Note, Chrome does not implement the permission static property
  		// So we have to check for NOT 'denied' instead of 'default'
  	else if (Notification.permission !== 'denied') {
    		Notification.requestPermission(function (permission) {

	      		// Whatever the user answers, we make sure Chrome store the information
		      if(!('permission' in Notification)) {
		        Notification.permission = permission;
		      }
	
		      // If the user is okay, let's create a notification
		      if (permission === "granted") {
		        var notification = new Notification("알림설정을 하였습니다.");
		      }
    	});
    
	}
	
  } //-- end of re_notification

  // At last, if the user already denied any notification, and you 
  // want to be respectful there is no need to bother him any more.
  
	
	/*
	 * server sent event 
	 */
	if(typeof(EventSource) !== "undefined") {
		
	    var source = new EventSource("sse.php");
	    var mdata= null;
		source.addEventListener("message", function(e) {
			//console.dir("addEventListener-message" + e.data);
			
		    var list = $.parseJSON(e.data);
		    var listLen = list.length;
		    var contentStr = "";
		    for(var i=0; i<listLen; i++){
		    	

				contentStr = list[i].rnum + "/"+ list[i].req_type + "/"+ list[i].refer_rnum + "/"+ list[i].origin_rnum + "/"+ list[i].title + "/"+ list[i].content + "/"+ list[i].reg_date + "/"+ list[i].cname + "/"+ list[i].ccode + "/"+ list[i].receive_ccode;
				//console.log(contentStr);

		        if (list[i].rnum >0){
				//console.log("call popup");
				re_notification(list[i].rnum,list[i].req_type,list[i].refer_rnum,list[i].type,list[i].origin_rnum,list[i].title,list[i].content,list[i].reg_date,list[i].cname,list[i].ccode,list[i].receive_ccode);
				//console.log("end popup");
				}else{
					//console.log("list[i].num >0 이 아니라서 안불름");
				}
			}
			
			//자동 refresh는 제공하지 않는다.
			//if (listLen>0)	{ //화면에 reload해라 // sub1_1.js에만 해야된다. 
			//	//http://devkorea.co.kr/bbs/board.php?bo_table=m03_qna&wr_id=24810
			//	requestListService('1');
			//}
	
	   
		}, false);
	
		source.addEventListener("open", function(e) {
			//document.getElementById("result").innerHTML += "Connection was opened." + "<br>";
		    //console.log("Connection was opened.");
		}, false);
	
		source.addEventListener("error", function(e) {
			//document.getElementById("result").innerHTML += "Error - connection was lost" + "<br>";
		    //console.dir("Connection was lost." + e);
			//console.dir(e);
		}, false);
	
	   
	} else {
	    document.getElementById("dialog-confirm").innerHTML = "Sorry, your browser does not support server-sent events...";
	}	

});
		
		
	  



