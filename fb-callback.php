<?php
	include 'config/config_db.php';
	define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/facebook-sdk-v5/');
	require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
	ini_set('display_errors',1);
	$app_id = "1926824507587769";
	$app_secret = "8f200d54e9f3e5a9c2aeb5e91d5aee28";
  $fb = new Facebook\Facebook([
	'app_id' => $app_id,
	'app_secret' => $app_secret,
	'default_graph_version' => 'v2.10',
  ]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
// echo '<h3>Access Token</h3>';
// var_dump($accessToken->getValue());
$expired_token = ($accessToken->getExpiresat()->format('Y-m-d H:i:s'));


// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// echo '<h3>Metadata</h3>';
// var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($app_id); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
//    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

//  echo '<h3>Long-lived</h3>';
//  var_dump($accessToken);
}

$_SESSION['fb_access_token'] = (string) $accessToken;
$fb->setDefaultAccessToken($_SESSION['fb_access_token']);

try {
  $response = $fb->get('/me?fields=id,name,email,picture.width(300)');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
//  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
//  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$stmt = $mysqli->query("select * from tbl_users where facebook_id = '".$userNode->getField('id')."'");
if($stmt->num_rows == 0 ){
	if($userNode->getField('email') != ''){
		$affiliate = explode("@",$userNode->getField('email'));
		$affiliate = $affiliate[0];
		$user_email= $userNode->getField('email');
	}else{
		$affiliate = str_replace(" ","",$userNode->getName());
		$affiliate = substr($affiliate,0,10);
		$user_email= "Tidak Ada";
	}
	$affiliate = str_replace('_', '', $affiliate); // Replaces all spaces with hyphens.
	$affiliate = str_replace('.', '', $affiliate); // Replaces all spaces with hyphens.
	$affiliate = preg_replace('/[^A-Za-z0-9\-]/', '', $affiliate); // Removes special chars.

	$upline = "Tidak Ada";
	if(isset($_SESSION['link_affiliate'])){
		$stmt = $mysqli->query("select * from tbl_users where link_affiliate='".$_SESSION['link_affiliate']."'");
		if($stmt->num_rows > 0){			
			$upline = getUpline($stmt->fetch_object()->link_affiliate);
		}else{
			$upline = "Tidak Ada";
		}
		$register_by = $_SESSION['link_affiliate'];
	}else{
		$upline = "Tidak Ada";
		$register_by = "Tidak Ada";
	}
		$display_name = $userNode->getName();
		$link_affiliate= strtolower($affiliate);
		$upline= $upline;
		$telepon= 0;
		$email= $user_email;
		$facebook_id= $userNode->getField('id');
		$url_foto= $userNode->getField('picture')['url'];
		$status_akun= "reseller";
		$saldo= 0;
		$created_at= date("Y-m-d H:i:s");
		$last_update= date("Y-m-d H:i:s");		
		if($upline != "Tidak Ada"){
			$sql = "insert into tbl_users(display_name,link_affiliate,upline,register_by,telepon,email,facebook_id,url_foto,status_akun,saldo,saldo_pending,created_at,last_update) values('$display_name','$link_affiliate','$upline','$register_by','$telepon','$email','$facebook_id','$url_foto','$status_akun',$saldo,$saldo,'$created_at','$last_update')";
			$stmt = $mysqli->query($sql);
			if($stmt){
				$stmt = $mysqli->query("select * from tbl_users where facebook_id = '".$facebook_id."'")->fetch_object();
				$sql = "insert into tbl_promo_fb values('','".$stmt->id_users."',1,'".$accessToken->getValue()."','aktif','".$expired_token."')";
				$sql_tw = "insert into tbl_promo_tw values('','".$stmt->id_users."',1,'','','tidak aktif','')";
				$sql_alamat = "insert into tbl_users_alamat(id_users,alamat) values('".$stmt->id_users."','Tidak Ada')";
				$sql_bank	 = "insert into tbl_users_bank(id_users,nama_bank,pemilik_bank,nomor_rekening,status_bank) values('".$stmt->id_users."','','','','aktif')";
				$mysqli->query($sql);
				$mysqli->query($sql_tw);
				$mysqli->query($sql_alamat);
				$mysqli->query($sql_bank);
				$_SESSION['user_login'] = $stmt->id_users;
				$_SESSION['user_facebook_id'] = $stmt->facebook_id;
				$_SESSION['user_display_name'] = $stmt->display_name;
				$_SESSION['user_status'] = $stmt->status_akun;
				$_SESSION['user_link_affiliate'] = $stmt->link_affiliate;
				$_SESSION['user_upline'] = $stmt->upline;
				$_SESSION['user_email'] = $stmt->email;
				$_SESSION['user_telepon'] = $stmt->telepon;
				$_SESSION['user_foto'] = $stmt->url_foto;
				header('Location: http://pinopi.com/beranda');
			}
		}else{
			echo "<font size='20'><center>MAAF, ANDA TIDAK DAPAT MENDAFTAR TANPA LINK AFFILIATE YANG VALID, SILAHKAN GUNAKAN LINK AFFILIATE YANG VALID</center></font>";
			echo'<meta http-equiv="refresh" content="5; url=http://pinopi.com/daftar" />';
		}
}else{
	$stmt = $stmt->fetch_object();
	$cek_promo = $mysqli->query("select * from tbl_promo_fb where id_users = ".$stmt->id_users);
	if($cek_promo->num_rows > 0){
		$sql = "update tbl_promo_fb set access_token='".$accessToken->getValue()."',expired='".$expired_token."' where id_users=".$stmt->id_users."";			
	}else{
		$sql = "insert into tbl_promo_fb values('','".$stmt->id_users."',1,'".$accessToken->getValue()."','aktif','".$expired_token."')";
	}
	$mysqli->query($sql);
	$_SESSION['user_login'] = $stmt->id_users;
	$_SESSION['user_facebook_id'] = $stmt->facebook_id;
	$_SESSION['user_display_name'] = $stmt->display_name;
	$_SESSION['user_status'] = $stmt->status_akun;
	$_SESSION['user_link_affiliate'] = $stmt->link_affiliate;
	$_SESSION['user_upline'] = $stmt->upline;
	$_SESSION['user_email'] = $stmt->email;
	$_SESSION['user_telepon'] = $stmt->telepon;
	$_SESSION['user_foto'] = $stmt->url_foto;
	
	header('Location: http://pinopi.com/beranda');
}

?>