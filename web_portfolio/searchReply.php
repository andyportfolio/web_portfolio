<?php
session_start();
if(empty($_SESSION['uNum']))
{
	header('Location: error.html');
}
?>
<!doctype html>
<html lang="ko">
<head>
 <meta charset="utf-8">
 <title>searchReply</title>
 <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'><!-- 나눔고딕 폰트 추가 -->
 <link href="css/Master.css" rel="stylesheet" type="text/css">
 <!--<link href="css/common.css" rel="stylesheet" type="text/css">-->
 <script src="js/jquery-1.8.3.min.js"></script>
 <script type="text/javascript" src="js/common.js"></script>

 <script type="text/javascript">
//조회용임
$(document).ready(function(){

	//Print버튼 클릭 -- 화면의 답장확인 버튼 그룹
	 $(document).on("click", "#print", function(event){
		event.preventDefault();
		window.print();
	});

});
 </script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!------------------------------------------ Title Table S ------------------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3" class="pop_01"></td>
	</tr>
	<tr>
		<td colspan="3" class="pop_02"></td>
	</tr>
	<tr>
		<td class="w_10"></td>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="h_3"></td>
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
											<td class="ttl_text">Reply List</td>
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

<?php

	require_once 'config.php';

	session_start();
	$num = $_GET['num'];
	$ccode= $_SESSION['cCode'];    //업소코드

	//encoding
	mysqli_query($conn, "set names utf8");

	//본업소에서 답신한 것
	//답장에 대한 회신을 확인한다
	//화면은 매수 - 답장  - 답장 회신으로 구성되며 , 재귀적 호출을 구현한다.
	//한줄에 모든 값이 넘어오기때문에 loop를 돌면서 같은 같은 다시 찍지 않아야 한다.
	//예 59-61-63
	//   59-61-106
	//   59-62-149
    $sql = "SELECT ifnull(t1.rnum,'0') as lev1,ifnull(t2.rnum,'0') as lev2,ifnull(t3.rnum,'0') as lev3,t1.*,t1.status as item_status,b1.*,
t2.cname as cname2, t2.reg_name as reg_name2,t2.reg_date as reg_date2, t2.content as content2,
t3.cname as cname3, t3.reg_name as reg_name3,t3.reg_date as reg_date3, t3.content as content3,o1.caddress  
FROM request AS t1 
LEFT JOIN usermaster AS b1 ON b1.unum = t1.reg_id 
LEFT JOIN request AS t2 ON t2.req_type = '02' and t2.refer_rnum = t1.rnum and t2.ccode = '$ccode' 
LEFT JOIN org AS o1 ON o1.ccode = t1.ccode
LEFT JOIN request AS t3 ON t3.req_type = '03' and t3.refer_rnum = t2.rnum 
WHERE t2.refer_rnum > 0 ;";

	$result = $conn->query($sql);
	$num_row = $result->num_rows;
	$i = 0;

	$old_request_rnum = 0; //초기화
	$old_reply_rnum   = 0;
	$old_confirm_rnum = 0;



	if( $result->num_rows > 0) {
			
	   while($row = $result->fetch_assoc()) {

		//level 1의 값이 존재하고, 이전값과 같지 않을 경우 찍는다.
		if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']){
			$old_request_rnum = $row['lev1'];

?>
				<tr>
					<td class="h_10"></td>
				</tr>
				<!-- 매물 - 유형을 크게 표시 -->
				<tr>
					<td>
							<!------- Table S --------->
						<table width="100%" border="2px solid" bordercolor="red" cellpadding="0" cellspacing="1">
							<tr style="text-align:center; padding:1 3 0 3;">
								<td><span style="font-size:16px;color:red"><?=$row['type']?>&nbsp;&nbsp;<?=$row['category']?></span></td>
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
											<!------- Table S --------->

					<table id ="requestDetail" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
						<tr class="ct_ttlc">
							<td nowrap width="12%">No</td>
							<td class="ct_rowc" width="38%">
													<!------- Table S --------->
							<table width="100%" border="0" cellpadding="0" cellspacing="1">
								<tr>
									<td width="30%"><?=$row['rnum']?></td>
									<td width="70%">
										<!-------Button Table S--------->
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td>
											<? if ($row['item_status'] == '0'){  //정상 ?>
												<td><img src="images/money.png"></td><td><span style="vertical-align:middle">Going</span></td> 
											<? }else{ ?>
												<td><img src="images/delete.png"></td><td><span style="vertical-align:middle">Closed</span></td>
											<? }?>												
												</td>
											</tr>
										</table>
										<!-------Button Table E--------->
									</td>
								</tr>
							</table>
													<!------- Table E --------->
							
							
							</td>
							<td nowrap width="12%">Reg</td>
							<td class="ct_rowc" width="38%"><?=$row['reg_date']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap width="12%">Item</td>
							<td class="ct_rowc"  width="38%"><?=$row['type']?></td>
							<td nowrap width="12%">Type</td>
							<td class="ct_rowc"  width="38%"><?=$row['category']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap width="12%">Title</td>
							<td class="ct_rowc" width="38%"><?=$row['title']?></td>
							<td nowrap width="12%">Region</td>
							<td class="ct_rowc" width="38%"><?=$row['region']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td width="12%" nowrap>Content</td>
							<td width="88%" class="ct_rowl" colspan="3"><?=$row['content']?></td>
						</tr>
						<tr class="ct_ttlc">
							<td nowrap>Ohter</td>
							<td width="38%" class="ct_rowc">
													<!------- Table S --------->
								<table width="100%" border="0" cellpadding="0" cellspacing="1">
									<tr>
										<td><?=number_format($row['area_from'])?>~<?=number_format($row['area_to'])?>(m)</td>
									</tr>
									<tr>
										<td><?=$row['floor_from']?>~<?=$row['floor_to']?>(f)</td>
									</tr>
									<tr>
										<td><?=$row['room_from']?>~<?=$row['room_to']?>(r)</td>
									</tr>
								</table>
													<!------- Table E --------->
							</td>
							<td nowrap>Amount</td>
							<td width="38%" class="ct_rowc">
													<!------- Table S --------->
								<table width="100%" border="0" cellpadding="0" cellspacing="1">
									<tr>
										<td>(sale)<?=number_format($row['sprice_from'])?>~<?=number_format($row['sprice_to'])?></td>
									</tr>
									<tr>
										<td>(depo)<?=number_format($row['dprice_from'])?>~<?=number_format($row['dprice_to'])?></td>
									</tr>
									<tr>
										<td>(rent)<?=number_format($row['rprice_from'])?>~<?=number_format($row['rprice_to'])?></td>
									</tr>

								</table>
													<!------- Table E --------->
							</td>
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

						<!------- Table S --------->
						<table id="companyinfo" width="100%" border="0" cellpadding="0" cellspacing="1" class="ct_bg">
							<tr class="ct_ttlc">
								<td width="12%" nowrap>업소명</td>
								<td class="ct_rowc" width="38%"><?=$row['cname']?>(<?=$row['caddress']?>)</td>
								<td width="12%" nowrap>담당자</td>
								<td class="ct_rowc"><?=$row['reg_name']?></td>
							</tr>
							<tr class="ct_ttlc">
								<td width="12%" nowrap>전화</td>
								<td class="ct_rowc" width="38%"><?=$row['tel1']?>-<?=$row['tel2']?>-<?=$row['tel3']?></td>
								<td width="12%" nowrap>핸드폰</td>
								<td class="ct_rowc"><?=$row['mobile1']?>-<?=$row['mobile2']?>-<?=$row['mobile3']?></td>
							</tr>
							<tr class="ct_ttlc">
								<td width="12%" nowrap>FAX</td>
								<td class="ct_rowc" width="38%"><?=$row['fax1']?>-<?=$row['fax2']?>-<?=$row['fax3']?></td>
								<td width="12%" nowrap>email</td>
								<td class="ct_rowc"><?=$row['email']?></td>
							</tr>
						</table>	
						<!------- Table E --------->
					</td>
				</tr>
				<tr>
					<td class="h_5"></td>
				</tr>

<?      
		} //end -------->> if ($row['lev1'] !=0 && $old_request_rnum != $row['lev1']) 

		//답장이 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){
            $old_reply_rnum = $row['lev2'];
?>		

				<tr>
					<td>
											<!------- Table S --------->
						<table id="replyinfo<?=$row['lev2']?>" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr class="ct_ttlc_my">
								<td width="20%" align="left"><?=$row['reg_name2']?></td>
								<td width="80%" align="right" ><?=$row['reg_date2']?></td>
							</tr>
							<tr class="ct_ttlc_my">
								<td width="100%" align="left" colspan="2"><?=$row['content2']?></td>
							</tr>

						</table>
											<!------- Table E --------->					
					</td>
				</tr>
				<tr>
					<td class="h_3"></td>
				</tr>


<?      
			
		} //end ---------> if ($row['lev2'] !=0 && $old_reply_rnum != $row['lev2']){

		//답장수신확인 있고 , 기존값과 현재값이 다를 경우만 찍는다
		if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){
            $old_confirm_rnum = $row['lev3'];
?>	
				<tr>
					<td>
											<!------- Table S --------->
						<table  width="100%" border="0" cellpadding="0" cellspacing="0" class="replyconfirm<?=$row['lev2']?>">


							<tr>
								<td width="3%" style="bgcolor:white;">→</td>
								<td width="97%" style="color: #808080"><?=$row['content3']?>-<?=$row['reg_name3']?>-<?=$row['reg_date3']?></td>
							</tr>
						</table>

											<!------- Table E --------->					
					</td>
				</tr>

<?      

		} //end ----> if ($row['lev3'] !=0 && $old_confirm_rnum != $row['lev3']){

	   } //while($row = $result->fetch_assoc()) { -- end
	} //if( $result->num_rows > 0) { -- end


	$conn->close();


?>											
				<tr>
					<td class="h_5"></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="#" id="print">print</a></td>
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
					<td background="images/btn_main_c.gif" class="btn" nowrap><a href="javascript:self.close();">close</a></td>
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

			</table>
		</td>
		<td class="w_10"></td>
	</tr>
</table>
<!------------------------------------------ Content Table E ----------------------------------------->
</body>
</html>
