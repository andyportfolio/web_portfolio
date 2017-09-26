<?php

require_once '../config.php';

session_start();

if(!empty($_SESSION['uNum']))
{

	//encoding
	mysqli_query($conn, "set names utf8");
	
	$user_id = $_SESSION['userId'];
	$machine = $_SESSION['machine']; //PC 또는 Mobile접속여부
	$unum	 = $_SESSION['uNum'];

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	//login history write
	$sql2 = "insert into loginHistory(unum,logdate,remote_addr,machine,logtype) values('$unum',now(),'$ip','$machine','1')";
	$result2 = $conn->query($sql2);


	//session clear
	$_SESSION['status'] = ''; //status

	$_SESSION['cCode'] = ''; //compay code
	$_SESSION['cName'] = ''; //compay Name
	
	$_SESSION['userId'] = ''; //userid
	
	$_SESSION['uNum'] = ''; //serial number
	$_SESSION['uName'] = '';	//user name
	$_SESSION['oAuth'] = '';	//authorization

	$_SESSION['tel'] = ''; //tel
	$_SESSION['mobile'] = '';	//mobile
	$_SESSION['loginTime'] = '';	//loginTime

	$_SESSION['machine'] = '';	//machine (PC, Mobile)


	session_destroy();
}
header("Location:index_m.php");
?>