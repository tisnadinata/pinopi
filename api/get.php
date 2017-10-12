<?php
	require_once 'config.php';
	$json = file_get_contents('php://input');
	$call = explode("-",$_GET['call']);
	$result = "";
	switch($call[0]){
		case "produk":	$result = getproduk($_GET['call']);	break;
		case "user":	$result = getuser($_GET['call']);	break;
		case "transaksi":	$result = gettransaksi($_GET['call']);	break;
		case "cart":	$result = getkeranjang($_GET['call']);	break;
		default : $result = array("success"=>false,"message"=>"API endpoint unlisted ");	break;
	}
	header('Content-type: application/json');
	echo json_encode($result);
?>