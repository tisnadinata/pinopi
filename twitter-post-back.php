<?php 
/**
 * users gets redirected here from twitter (if user allowed you app)
 * you can specify this url in https://dev.twitter.com/ and in the previous script
 */ 

//LOADING LIBRARY
require_once("twitter_sdk/autoload.php");
use Abraham\TwitterOAuth\TwitterOAuth;

if(!isset($_GET['denied'])){
//TWITTER APP KEYS
$consumer_key = 'yourkey';
$consumer_secret = 'yourkey';

//GETTING ALL THE TOKEN NEEDED
$oauth_verifier = $_GET['oauth_verifier'];
$token_secret = $_COOKIE['token_secret'];
$oauth_token = $_COOKIE['oauth_token'];

//EXCHANGING THE TOKENS FOR OAUTH TOKEN AND TOKEN SECRET
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $token_secret);
$connection->setTimeouts(10, 30);
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_verifier));

$accessToken=$access_token['oauth_token'];
$secretToken=$access_token['oauth_token_secret'];

//DISPLAY THE TOKENS
	$mysqli = new mysqli("localhost","pinopi_pinopi","pinopi123","pinopi_pinopi");
	$stmt = $mysqli->query("select * from tbl_promo_tw where id_users=".$_GET['id_user']."");
	if($stmt->num_rows > 0){
		$sql = "UPDATE tbl_promo_tw set access_token='".$accessToken."',access_secret='".$secretToken."',status_promo='aktif',expired='2020-12-20 00:00:00' WHERE id_users=".$_GET['id_user']."";
	}else{
		$sql = "insert into tbl_promo_tw(id_users,access_token,access_secret,status_promo,expired) values(".$_GET['id_user'].",'".$accessToken."','".$secretToken."','aktif','2020-12-20 00:00:00')";
	}
	$stmt = $mysqli->query($sql);
	if($stmt){
		echo "<h3 style='color:green;'><b>berhasil setting auto promo twitter</b><br>Silahkan tutup halaman ini dan muat ulang halaman <b>Promotion</b></h3>";
	}else{
		echo "<h3 style='color:red;'><b>gagal setting auto promo twitter</b><br>Silahkan hubungi customer service kami untuk info selanjutnya</h3>";
	}	
	echo'<meta http-equiv="Refresh" content="2; URL=http://pinopi.com/promosi-otomatis">';
}else{
	echo'<meta http-equiv="Refresh" content="0; URL=http://pinopi.com/promosi-otomatis">';
}
 ?>
