<?php


session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><span class="logo"></span></title>

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
<link href="css/Master.css" rel="stylesheet" type="text/css">

<!--<link href="css/common.css" rel="stylesheet" type="text/css">-->
<link href="css/div.css" rel="stylesheet" type="text/css">
<link href="plugin/jquery-ui.min.css" rel="stylesheet" >


<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="plugin/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<script type="text/javascript" src="js/requestList.js"></script>
<script type="text/javascript" src="js/notifyList.js"></script>
<script type="text/javascript" src="js/sse.js"></script>

<script>

</script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="total_div"> 
<div class="header_div">
	<div class="top1_div">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td class="h_10"></td>
					</tr>
					<tr>
						<td class="h_5"></td>
					</tr>
					<tr>
						<td></td>
						<td class="w_3"><img src="images/logo.png"></td>
						<td></td>
					</tr>
				</table>
	</div><!--top1  -->

	
	<div class="top2_div">
		<div class="t2_menu_div">
		
<table width="100%" border="0" cellspacing="0" cellpadding="5px">
						<tr>
							<td width="33%"></td>
							<td width="33%"></td>
							<td width="33%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="h_1"></td>
													</tr>

														<tr>
<?  
	//관리자, 시스템 관리자 권한에서의 메뉴
	if (($_SESSION['oAuth'] == "M") or ($_SESSION['oAuth'] == "S")) { 
?>
															<td width="16%" align="center"><a href="#" id="notify_mgmt"><img src="images/notify.png" title="Notice"></a></td>
															<td width="16%" align="center"><a href="#" id="org_mgmt"><img src="images/manage.png" title="Member Mgmt"></a></td>
															<td width="16%" align="center"><a href="#" id="user_mgmt"><img src="images/usermgmt.png" title="User Mgmt"></a></td>
															<td width="16%" align="center"><a href="#" id="data_mgmt"><img src="images/deletedata.png" title="Data Mgmt"></a></td>
<? }?>
															<td width="16%" align="center"><a href="#" id="search_mgmt"><img src="images/search.png" title="Search reply"></a></td>
															<td width="16%" align="center"><a href="#" id="userinfo_mgmt"><img src="images/userinfo.png" title="userinfomation"></a></td>
															<td width="16%" align="center"><a href="logout.php"><img src="images/logout.png" title="Logout"></a></td>
														</tr>
								</table>		
							</td>
						</tr>
</table>		
	
		</div><!-- t2_menu -->

		<div class="t2_userinfo_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<input type="hidden" id="session_ccode" name="session_ccode"   value="<?=$_SESSION['cCode']?>"  />
			<input type="hidden" id="session_cname" name="session_cname"   value="<?=$_SESSION['cName']?>"  />
			<input type="hidden" id="session_userid" name="session_userid" value="<?=$_SESSION['userId']?>" />
			<input type="hidden" id="session_unum" name="session_unumum"    value="<?=$_SESSION['uNum']?>"  />
			<input type="hidden" id="session_uname" name="session_uname"    value="<?=$_SESSION['uName']?>" />
			<input type="hidden" id="session_oauth" name="session_oauth"    value="<?=$_SESSION['oAuth']?>" />
		</td>
		<td> <!-- bgcolor="#1486BA" -->
			<!------- Util Menu S --------->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="right" valign="bottom">
						<!------- User Menu S --------->
						<table border="0" cellpadding="0" cellspacing="0" align="right">
							<tr class="ctutlmenu">
								<td nowrap><span  style="color:white;" >[&nbsp;<?=$_SESSION['cName']?>&nbsp;&nbsp;<?=$_SESSION['userId']?>&nbsp;&nbsp;<?=$_SESSION['uName']?>&nbsp;&nbsp;Tel:&nbsp;<?=$_SESSION['tel']?>&nbsp;&nbsp;mobile:&nbsp;<?=$_SESSION['mobile']?>&nbsp;&nbsp;time:<?=$_SESSION['loginTime']?>&nbsp;]</td>
								<td width="5"></span></td>
							</tr>
						</tr>
					</table>
					<!------- User Menu E --------->
					</td>
				</tr>
			</table>
			<!------- Util Menu E --------->
		</td>
	</tr>

</table>		
		</div><!-- t2_userinfo -->

	
	</div><!--top2__div  -->
</div><!-- header_div -->

<div class="cbody_div">
	<div class="request_div">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>
						<!------- Title & Tab Table S --------->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="21" valign="bottom">
									<!------- Title Table S --------->
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td class="ttl_ico"></td>
											<td width="5"></td>
											<td class="ttl_text">Inquiry</td>
											<td width="3"></td>
											<td class="ttl_sub"><!-- - 서브타이틀 --></td>
										</tr>
									</table>
									<!------- Title Table E --------->
								</td>
								<td height="21" valign="bottom" align="right"></td>
							</tr>
							<tr>
								<td colspan="2" class="ttl_line"></td>
							</tr>
						</table>
						<!------- Title & Tab Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Title Table E ------------------------------------------->
<!------------------------------------------ Content Table S ----------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<!------- 소타이틀 Table S --------->
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
								 <table border="0" cellpadding="0" cellspacing="0"><tr><td class="ttl_sub_ico"></td></tr></table>
								 </td>
								<td class="w_5"></td>
								<td class="ttl_sub_text">Required information</td>
							</tr>
						</table>
						<!------- 소타이틀 Table E --------->
					</td>
				</tr>
				<tr>
					<td>
						<!------- Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr class="ct_ttlc_ess">
		<td width="25%">Item</td>
		<td width="75%" class="ct_rowl_ess" >
				<select class="fm_select" id="type_choice" name="type_choice" tabindex="2">
					<option value="000">type of item</option>
					<option value="직접입력">direct input</option>
					<option value="아파트">Condo</option>
					<option value="아파트분양권">Apartment sale</option>
					<option value="주상복합">Residential complex</option>
					<option value="오피스텔">Officetels</option>
					<option value="단독/다가구">Single / Multi</option>
					<option value="연립/다세대">Coalition / multi-generation</option>
					<option value="원룸">one room</option>
					<option value="상가주택">shopping mall</option>
					<option value="올상가">store</option>
					<option value="공장">factory</option>
					<option value="창고">warehouse</option>
					<option value="사무실">office</option>
					<option value="빌딩">Building</option>
					<option value="토지">land</option>
					<option value="기타">ohters</option>
					<option value="급매">urgent(2/a day)</option>
				</select>
				<!-- 직접입력을 선택할 경우에만 display된다 -->
				<input type="hidden" id="type_text" name="type_text" value="" size="20" maxlength="20" class="fm_input"/>
		</td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td>Type</td>
		<td class="ct_rowl_ess">
				<select class="fm_select" id="category_choice" name="category_choice" tabindex="1">
					<option value="000">Transaction type</option>
					<option value="매매">Sale</option>
					<option value="전세">rent</option>
					<option value="월세">lease</option>
					<option value="반전세">special rent</option>
					<option value="임대">lease</option>
					<option value="기타">others</option>
				</select>
		</td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td>title</td>
		<td class="ct_rowl_ess">
 			<input type="text" class="fm_input" id="title" name="title" size="24" maxlength="26" tabindex="3"/>
		</td>
	</tr>
	<tr class="ct_ttlc_ess">
		<td>cont</td>
		<td class="ct_rowl_ess">
				<textarea id="details" name="details" rows="5" cols="22" tabindex="4" class="fm_area"></textarea>
				<p class="ps">* 1,000 characters</p>

		</td>
	</tr>

</table>
						<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>
						<!------- 소타이틀 Table S --------->
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><table border="0" cellpadding="0" cellspacing="0"><tr><td class="ttl_sub_ico"></td></tr></table></td>
								<td class="w_5"></td>
								<td class="ttl_sub_text">information(optional)</td>
							</tr>
						</table>
						<!------- 소타이틀 Table E --------->
					</td>
				</tr>
				<tr>
					<td>
						<!------- Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr class="ct_ttlc">
		<td width="25%" nowrap>Area</td>
		<td width="75%" class="ct_rowl">
				<select class="fm_select" id="region_choice" name="region_choice" tabindex="5">
					<option value="000">Area</option>
					<option value="중량구전체">All area</option>
					<option value="직접입력">direct input</option>
					<option value="면목본동">A area</option>
					<option value="면목2동">B area</option>
					<option value="면목3.8동">C area</option>
					<option value="면목4동">D area</option>
					<option value="면목5동">E area</option>
					<option value="면목7동">F area</option>
					<option value="상봉1동">G area</option>
					<option value="상봉2동">H area</option>
					<option value="중화1동">I area</option>
					<option value="중화2동">J area</option>
					<option value="묵1동">K area</option>
					<option value="묵2동">L area</option>
					<option value="망우본동">M area</option>
					<option value="망우3동">N area</option>
					<option value="신내1동">O area</option>
					<option value="신내2동">P area</option>
				</select>
				<!-- 직접입력을 선택할 경우에만 display된다 -->
				<input type="hidden" id="region_text" name="region_text" value="" size="20" maxlength="20" class="fm_input"/>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>space</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="text" pattern="[0-9]*"  id="area_from" name="area_from" size="8" tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<input type="text" pattern="[0-9]*"  id="area_to" name="area_from" size="8"   tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3">(m)</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>story</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<select class="fm_select" id="floor_from_choice" name="floor_from_choice" tabindex="6">
							<option value="0">floor</option>
							<option value="B3이하">B3▽</option>
							<option value="B2">B2</option>
							<option value="B1">B1</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21이상">21△</option>
						</select>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<select class="fm_select" id="floor_to_choice" name="floor_to_choice" tabindex="6">
							<option value="0">floor</option>
							<option value="B3이하">B3▽</option>
							<option value="B2">B2</option>
							<option value="B1">B1</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21이상">21△</option>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>room</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="text" pattern="[0-9]*"  id="room_from" name="room_from" size="5" tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<input type="text" pattern="[0-9]*"  id="room_to" name="room_to" size="5"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>sale</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="text" pattern="[0-9]*"  id="sprice_from" name="sprice_from" size="12"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<input type="text" pattern="[0-9]*"  id="sprice_to" name="sprice_to" size="12"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>dep</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="text" pattern="[0-9]*"  id="dprice_from" name="dprice_from" size="12"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<input type="text" pattern="[0-9]*"  id="dprice_to" name="dprice_to" size="12"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="ct_ttlc">
		<td width="6%" nowrap>rent</td>
		<td class="ct_rowl">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<input type="text" pattern="[0-9]*"  id="rprice_from" name="rprice_from" size="12"  tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>
					</td>
					<td class="w_3"></td>
					<td>-</td>
					<td class="w_3"></td>
					<td>
						<input type="text" pattern="[0-9]*"  id="rprice_to" name="rprice_to" size="12"   tabindex="8" class="fm_input num01" onKeyPress="currency(this);" onKeyup="com(this);"/>

					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>
						<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>
						<!------- button Table S --------->
<table border="0" cellpadding="0" cellspacing="0" align="right">
	<tr>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="send_ok">submit</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>
		<td class="w_3"></td>
		<td>
			<!-------Button Table S--------->
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="images/btn_main_l.gif"></td>
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="reset" >clear</a></td>
					<td><img src="images/btn_main_r.gif"></td>
				</tr>
			</table>
			<!-------Button Table E--------->
		</td>
	</tr>
</table>
						<!------- button Table S --------->
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>
				<tr>
					<td>
							<!------- 광고 Table S --------->
						<table width="100%" border="0" cellpadding="0" cellspacing="1">
							<tr>
							<!--	<td width="100%"><img src="images/ad1.jpg" height="100px" width="305px"></td> -->
							</tr>
						</table>
							<!------- Table E --------->					
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>
				<tr>
					<td>
							<!------- 광고 Table S --------->
						<table width="100%" border="0" cellpadding="0" cellspacing="1">
							<tr>
							<!--	<td width="100%"><img src="images/ad1.jpg" height="100px" width="305px"></td> -->
							</tr>
						</table>
							<!------- Table E --------->					
					
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>
				<tr>
					<td>
							<!------- 광고 Table S --------->
						<table width="100%" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<!--<td width="100%"><img src="images/ad1.jpg" height="100px" width="305px"></td>-->
							</tr>
						</table>
							<!------- Table E --------->					

					</td>
				</tr>

			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
	</div><!-- request_div -->

	
	<div class="content_div">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>

						<!------- Title & Tab Table S --------->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="21" valign="bottom">

									<!------- Title Table S --------->
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td id="ico_requestlist" class="ttl_ico_my"></td>
											<td width="5"></td>
											<td class="ttl_text">Inquery&nbsp;--</td>
											<td width="3"></td>
											<td class="ttl_sub" id="searchCnt">&nbsp;--</td>
										</tr>
									</table>
									<!------- Title Table E --------->
								</td>
								<td height="21" valign="bottom" align="right"></td>
							</tr>
							<tr>
								<td colspan="2" class="ttl_line"></td>
							</tr>
						</table>
						<!------- Title & Tab Table E --------->

					</td>
				</tr>
				<tr>
					<td class="h_10"></td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<div id="insert_msg_div"></div> <!-- Insert ajax message -->
<!------------------------------------------ Title Table E ------------------------------------------->
<!------------------------------------------ Content Table S ----------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>

						<!------- Search Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
	<tr id="search_table" class="ct_ttlc_my">
		<td width="5%" nowrap class="list_title" >Type</td>
		<td width="8%" class="ct_rowl">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><input type="radio" name="chk_info" value="MY"></td>
								<td nowrap>MY</td>
								<td class="w_5"></td>
								<td><input type="radio" name="chk_info" value="OT"></td>
								<td nowrap>OT</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td width="5%" nowrap class="list_title">Item</td>
		<td width="7%" class="ct_rowl">
			<select class="fm_select" id="search_type_choice" >
					<option value="000">type of item</option>
					<option value="직접입력">direct input</option>
					<option value="아파트">Apartment</option>
					<option value="아파트분양권">Apartment sale</option>
					<option value="주상복합">Residential complex</option>
					<option value="오피스텔">Officetels</option>
					<option value="단독/다가구">Single / Multi</option>
					<option value="연립/다세대">Coalition / multi-generation</option>
					<option value="원룸">one room</option>
					<option value="상가주택">shopping mall</option>
					<option value="올상가">store</option>
					<option value="공장">factory</option>
					<option value="창고">warehouse</option>
					<option value="사무실">office</option>
					<option value="빌딩">Building</option>
					<option value="토지">land</option>
					<option value="기타">ohters</option>
					<option value="급매">urgent(2/a day)</option>
			</select>
				<!-- 직접입력을 선택할 경우에만 display된다 -->
				<input type="hidden" id="type_search_text" name="type_search_text" value="" size="20" maxlength="20" class="fm_input"/>
		</td>

		<td width="5%" nowrap class="list_title">type</td>
		<td width="15%" class="ct_rowl">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="30%" class="ct_rowl">
						<select class="fm_select" id="search_category_choice" >
							<option value="000">Transaction type</option>
							<option value="매매">Trading</option>
							<option value="전세">long rent</option>
							<option value="월세">rent</option>
							<option value="반전세">special rent</option>
							<option value="임대">lease</option>
							<option value="기타">others</option>
						</select>
						</td>
					<td class="w_3"></td>
					<td width="40%"class="ct_rowl"><input type="checkbox" name="close_YN" name="">cls</td>
					<td class="w_5"></td>

					<td width="30%" align="right">
						<!-------Button Search Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_seac_l.gif"></td>
								<td background="images/btn_seac_c.gif" class="btn" nowrap><a href="#" id="search_ok">Inquery</a></td>
								<td><img src="images/btn_seac_r.gif"></td>
							</tr>
						</table>
						<!-------Button Search Table E--------->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
						<!------- Search Table E --------->

					</td>
				</tr>
			<tr>
				<div id="requestlist_msg_div"></div> <!-- select ajax message -->

				<td class="h_10"></td>
			</tr>
				<tr>
					<td class="lt_line">
						<!------- List Table S --------->
<div id = "div_requestlist_MY">
<table id ="requestlist_MY" width="100%" border="0" cellpadding="0" cellspacing="1" class="lt_bg">
	<tr class="lt_ttlc_my">
		<td width="4%" class="list_title">St</td>
		<td width="4%" class="list_title">No</td>
		<td width="16%" class="list_title">Date</td>
		<td width="24%" class="list_title">Title</td> 
		<td width="4%" class="list_title">reply</td>
		<td width="8%" class="list_title">Item</td> 
		<td width="8%" class="list_title">Type</td> 
		<td width="10%" class="list_title">Area</td>
		<td width="25%" class="list_title">Amount</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td><div style="text-align:center;"><ul id="requestPagelist_MY"></ul></div></td>
	</tr>
</table>

</div>

						<!------- List Table S --------->
<div id = "div_requestlist_OT">
<table id ="requestlist_OT" width="100%" border="0" cellpadding="0" cellspacing="1" class="lt_bg">
	<tr class="lt_ttlc_ot">
		<td width="4%" class="list_title">St</td>
		<td width="6%" class="list_title">No</td>
		<td width="14%" class="list_title">Date</td>
		<td width="18%" class="list_title">Title</td>
		<td width="4%" class="list_title">reply</td>
		<td width="8%" class="list_title">Item</td>
		<td width="8%" class="list_title">Type</td>
		<td width="8%" class="list_title">Area</td>
		<td width="18%" class="list_title">Amount</td>
		<td width="10%" class="list_title">Agency</td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td><div style="text-align:center;"><ul id="requestPagelist_OT"></ul></div></td>
	</tr>
</table>

</div>

<div id="nodata"></div>

					</td>
				</tr>
			<tr>
				<td class="h_5"></td>
			</tr>
				<tr>
					<td class="h_1"></td>
				</tr>
			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
	</div><!-- content_div -->
	
	<div class="notify_div">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_10"></td>
				</tr>
				<tr>
					<td>
						<!------- Title & Tab Table S --------->
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="21" valign="bottom">
									<!------- Title Table S --------->
									<table border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td id="ico_notifylist" class="ttl_ico_ot"></td>
											<td width="5"></td>
											<td>
						<!-------Button Table S--------->
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td><img src="images/btn_sub_l.gif"></td>
								<td background="images/btn_sub_c.gif" class="btn" nowrap><a href="#" id="reload_notify">Notification</a></td>
								<td><img src="images/btn_sub_r.gif"></td>
							</tr>
						</table>
						<!-------Button Table E--------->
											</td>
											<td width="3"></td>
											<td class="ttl_sub"><!-- - 서브타이틀 --></td>
										</tr>
									</table>
									<!------- Title Table E --------->
								</td>
								<td height="21" valign="bottom">
									<!------- Tab Table  S--------->
									<table border="0" cellpadding="0" cellspacing="0" align="right">
										<tr>
											<td>
												<!------- Tab01 Table S--------->
												<table border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td><img id="tabA_img1" src="images/btn_tab_l.gif"></td>
														<td id="tabA" background="images/btn_tab_c.gif" class="tab_nw" nowrap>Rec</td>
														<td><img id="tabA_img2"src="images/btn_tab_r.gif"></td>
													</tr>
												</table>
												<!------- Tab01 Table E--------->
											</td>
											<td class="w_1"></td>
											<td>
												<!------- Tab02 Table S--------->
												<table border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td><img id="tabB_img1" src="images/btn_tabs_l.gif"></td>
														<td id="tabB" background="images/btn_tabs_c.gif" class="tab_s" nowrap><a id="x" href="#">Send</a></td>
														<td><img id="tabB_img2" src="images/btn_tabs_r.gif"></td>
													</tr>
												</table>
												<!------- Tab02 Table E--------->
											</td>
										</tr>
									</table>
									<!------- Tab Table  E--------->
								</td>
							</tr>
							<tr>
								<td colspan="2" class="ttl_line"></td>
							</tr>
						</table>
						<!------- Title & Tab Table E --------->
					</td>
				</tr>
				<tr>
					<td>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="50%"><input type="text" readonly class="fm_input_trans" size=17 id = "notify_searchtime" value=""></td>

								<td width="50%" id="notify_cnt" align="right"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<div id="notify_msg_div"></div> <!-- select ajax message -->

					<td class="h_1"></td>
				</tr>
				<tr>
					<td class="lt_line">

				<div class="tab_container">
					<div id="tab1" class="tab_content" style="display: block;">
						<!--Content1-->
						<div class="notifyCSS"><!--수신(request, reply, reply회신 3종류 존재-->

						<!------- List Table S --------->
<table id ="receive_notify" width="100%" border="0" cellpadding="0" cellspacing="1" class="nlt_bg">
	<tr class="lt_ttlc_ot">
		<td width="10%" class="list_title">No</td>
		<td width="10%" class="list_title">Tp</td>
		<td width="80%" class="list_title" colspan="2">Receive Information</td>
	</tr>

</table>
<div style="text-align:center;"><ul id="requestNotiPagelist_OT"></ul></div>

						<!------- List Table E --------->
						</div><!--notifyCSS-->

					</div> <!--Content2-->
					<div id="tab2" class="tab_content" style="display: none;">
					   <!--Content2-->
						<div class="notifyCSS"><!--송신(request, reply, reply회신 3종류 존재-->

						<!------- List Table S --------->
<table id ="request_notify" width="100%" border="0" cellpadding="0" cellspacing="1" class="nlt_bg">
	<tr class="lt_ttlc_my">
		<td width="10%" class="list_title">No</td>
		<td width="10%" class="list_title">Tp</td>
		<td width="80%" class="list_title" colspan="2">Send Information</td>
	</tr>
	

</table>
<div style="text-align:center;"><ul id="requestNotiPagelist_MY"></ul></div>

						<!------- List Table E --------->
						</div><!--notifyCSS-->
			
					</div><!--Content2-->

				</div><!--tab_container-->

					</td>
				</tr>

			</table>
		</td>
		<td class="w_10"></td>
	</tr>
<div id="notify_nodata"></div>
</table>
	</div><!--notify_div  -->


</div><!--cbody_div  -->
<div class="footer_div">
						<!------- Table S --------->
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
	  <td class="h_5"></td>
	</tr>
	<tr align="center">
		<td style="color:#f8f8ff !important"><span class="logo"></span></td>
	</tr>
</table>
						<!------- Table E --------->
</div><!-- footer_div -->
</div><!--total_div  -->

<div id="dialog-confirm"></div>
<div id="dialog-Sucess">
	<p>sucess!.</p>
</div>
<audio id="play_notify" preload="auto" src="music/notify.mp3" />
<audio id="play_reply" preload="auto" src="music/reply.mp3" />

</body>
</html>