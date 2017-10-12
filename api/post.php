<?php
	require_once 'config.php';
	$json = file_get_contents('php://input');
	$call = explode("-",$_GET['call']);
	$result = "";
	$obj = json_decode($json);
	if($call[1] == "konfirmasi2"){
		$result = posttransaksiConfirm2();
	}else{
		switch($call[0]){
			case "login":	$result = login($obj);	break;
			case "register":	$result = register($obj);	break;
			case "user":	$result = postuser($_GET['call'],$obj);	break;
			case "transaksi":	$result = posttransaksi($_GET['call'],$obj);	break;
			case "cart":	$result = postkeranjang($_GET['call'],$obj);	break;
			default : $result = array("success"=>false,"message"=>"API endpoint unlisted ");	break;
		}
	}
	header('Content-type: application/json');
	echo json_encode($result);
?>