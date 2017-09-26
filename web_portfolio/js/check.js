//스마트폰 구분 방법
 var smartPhones = [
			'iphone', 'ipod',
			'windows ce',
			'android', 'blackberry',
			'nokia', 'webos',
			'opera mini', 'sonyerricsson',
			'opera mobi', 'iemobile'
	];

 var type = "PC";

	for (var i in smartPhones) {
			// 스마트폰 확인
			if (navigator.userAgent.toLowerCase().match(new RegExp(smartPhones[i]))) {
					//alert('This is Smart Phone..!');
					//document.location = 'mweb/index_mobile.html'; <-- 향후 나중에 자기의 site를 넣어주면 된다.
			
					type = "MOBILE";
			}
	}

	//PC site 및 크롬 브라우져 설정 요청
	if (type == "PC"){

			var agent = navigator.userAgent.toLowerCase();

			//Chrome Brower check
			if (agent.indexOf("chrome") != -1){

				//chrome으로 접속한 경우 notification을 받기 위해서 설정을 해야 한다

				
				  // Let's check if the browser support notifications
					if (!"Notification" in window) {
						alert("지금 사용하시는 웹브라우져는 알람기능을 지원하지 않습니다.관리자에게 문의하세요");
					}	
				  // Let's check if the user is okay to get some notification
				  else if (Notification.permission === "granted") {
				  // If it's okay let's create a notification
					
							//alert("index.php 로 이동합니다.");
							window.location.href = "index.php"; //PC버젼

					}
					// Otherwise, we need to ask the user for it's permission
					// Note, Chrome does not implement the permission static property
					// So we have to check for NOT 'denied' instead of 'default'

					else if (Notification.permission !== 'denied') {
						Notification.requestPermission(function (permission) {

							//alert("권한.:" + Notification.permission);
							
								// Whatever the user answers, we make sure Chrome store the information
								if(!('permission' in Notification)) {
									Notification.permission = permission;
								}
			
								// If the user is okay, let's create a notification
								if (permission === "granted") {
									var notification = new Notification("알림 기능이 활성화 되었습니다. Click하시면 로그인 페이지로 이동합니다.");

									var init_notify_audio = new Audio("music/welcome.mp3"); // buffers automatically when created
									init_notify_audio.play();


									notification.onclick = function() { 
										init_notify_audio.pause();
										window.location.href = "index.php"; //PC버젼
										notification.close();
									};   
								}else if (permission === "denied"){
									window.location.href = "introduce2.html"; //알림해제
								}else if (permission === "default"){
									window.location.href = "index.html"; //다시 지정
								}
						});

		
					}else{
						//alert("permission=="+Notification.permission);
						//permission이 denied 이면 알림해제를 하게 한다
						if (Notification.permission == 'denied') {
							window.location.href = "introduce2.html"; //알림해제
						}

						//permission이 default 이면 다시지정 하게 한다
						if (Notification.permission == 'default') {
							window.location.href = "index.html"; // 다시 지정하게 초기 page로 이동
						}

					}

			}else{
				window.location.href = "introduce1.html"; //크롬브라우져 설치
			}

	}else{
				window.location.href = "mweb/index_mobile.html"; //Mobile 버젼

	}