<?php
	session_start();
	$mysqli = new mysqli("localhost","pinopi_pinopi","pinopi123","pinopi_pinopi");
	
	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	define('FIREBASE_API_KEY', 'AAAAUT53-8U:APA91bE1h-UM4ZO97UprfEd3JMBB40_K-dWL-twnvQvs6mXEsgfshEx2j-_kYng6BlzrqMrag0SKrHBXkv4PxIHLUOTlxsxcNP1OTTo-moDS7ai8c7pebXjrd899jV_K756smhDqiD_V');
	DEFINE("APP_ID","134542503820931");
	DEFINE("APP_SECRET","f6c6a77fd539cc0c3620623bf0623f9b");
	
   function getUpline($upline){
	   global $mysqli;
	   $result = "";
	   $backup = "";
	   $stmt = $mysqli->query("select * from tbl_users where link_affiliate='$upline'");
	   if($stmt->num_rows > 0){
		   $cek_downline = $mysqli->query("select * from tbl_users where upline='".$upline."' order by id_users ASC");
		   if($cek_downline->num_rows < 10){
			   $result = $upline;
		   }else{
			   while($downline = $cek_downline->fetch_object()){
					$cek_downline_downline = $mysqli->query("select * from tbl_users where upline='".$downline->link_affiliate."' order by id_users ASC");
					if($cek_downline_downline->num_rows < 10){
						$result = $downline->link_affiliate;
						break;
					}else if($backup == ""){
						$last_down = $cek_downline_downline->fetch_object();
						$last_cek = $mysqli->query("select * from tbl_users where upline='".$last_down->link_affiliate."' order by id_users ASC");
						if($last_cek->num_rows < 10){
							$last = $last_cek->fetch_object();
							$backup = $last->link_affiliate;
						}
					}
			   }
			   if($result == "" AND $backup != ""){
				   $result = $backup;
			   }
		   }
	   }else{
		   $result =  "Tidak Ada";
	   }
	   return $result;
   }

?>