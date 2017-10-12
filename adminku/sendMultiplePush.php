<?php 
//importing required files 
require_once '../config/config_db.php';
require_once 'Firebase.php';
require_once 'Push.php'; 
  
$response = array(); 
 
if($_SERVER['REQUEST_METHOD']=='POST'){ 
	 //hecking the required params 
	 if(isset($_POST['title']) and isset($_POST['message'])) {
		 //creating a new push
		 $push = null; 
		 //first check if the push has an image with it
		 if(isset($_POST['image'])){
			 $push = new Push(
			 $_POST['title'],
			 $_POST['message'],
			 $_POST['image']
		 );
		 }else{
			 //if the push don't have an image give null in place of image
			$push = new Push(
				 $_POST['title'],
				 $_POST['message'],
				 null
			);
		 }
		 
		 //getting the push from push object
		 $mPushNotification = $push->getPush(); 
		 
		 //getting the token from database object 
		 $tokens = array(); 
		 $stmt = $mysqli->query("select device_token from tbl_users_device where device_token!=''");
		 while($user_token = $stmt->fetch_object()){
			array_push($tokens, $user_token->token);
		 }
		 $devicetoken = $tokens;
		 
		 //creating firebase class object 
		 $firebase = new Firebase(); 
		 
		 //sending push notification and displaying result 
		 //echo $firebase->send($devicetoken, $mPushNotification);
		 $firebase->send($devicetoken, $mPushNotification);
	 }else{
		 $response['error']=true;
		 $response['message']='Parameters missing';
	 }
}else{
	 $response['error']=true;
	 $response['message']='Invalid request';
}
 
//echo json_encode($response);
json_encode($response);