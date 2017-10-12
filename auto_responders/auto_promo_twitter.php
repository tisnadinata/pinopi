<?php
#!/usr/local/bin/php -q
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('allow_url_fopen', true);
include 'connectDB.php';
require_once("twitter_sdk/autoload.php");
date_default_timezone_set('Asia/Jakarta');

use Abraham\TwitterOAuth\TwitterOAuth;
	
$stmt = $mysqli->query("select * from tbl_promo_tw where status_promo='aktif'");
$tgl_sekarang = date("Y-m-d");
$last_p = "";		
$selisih = 0;
while($data_post = $stmt->fetch_object()){
	$count_post = $mysqli->query("select * from tbl_auto_log where id_users=".$data_post->id_users." and status='berhasil' and sosmed='twitter' and DAY(waktu) = DAY(NOW())")->num_rows;
	if($count_post < $data_post->delay){	
		$data_user = $mysqli->query("select * from tbl_users where id_users=".$data_post->id_users)->fetch_object();
		$expired = (abs(($data_post->expired) - strtotime ($tgl_sekarang))/(60*60*24));
		$expired = ceil($expired);
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);
		$userkeyanda  = "inxa3r";
		$passkeyanda  = "gateway";
		$nohptujuan  = $data_user->telepon;
		$nama = explode(" ",$data_user->display_name);
		$nama = substr($nama[0],0,10); 

		if($expired <= 1){
			$isi_pesan = "INFO PINOPI : Halo $nama, token tw anda akan habis hari ini. Silahkan login ke PINOPI lalu klik 'Setting AutoPromo tw' untuk pembaharuan";
			$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
			$url = str_replace(" ","%20",$url);
			file_get_contents($url, false, stream_context_create($arrContextOptions));
			if($expired == 2){
				#twitter STATUS
				$mysqli->query("update tbl_promo_tw set
								  access_token=''
								  WHERE id_users=".$data_user->id."
							");
			}
		}
		
		$isi_post = getPost("twitter");
		$consumer_key = "wc0rQxVJVWM0Vm9ApYxqbEDko";
		$consumer_secret = "bPxCZEKGyvRE1CJ15qVf01Qri34ex2eQXVfGzDxNJcpE3ch75G";
		$oauth_token = $data_post->access_token;
		$oauth_token_secret = $data_post->access_secret;
		$nama = explode(" ",$data_user->display_name);
		$signature = " Hubungi :".$nama[0]." | ".$data_user->telepon." | "."http://".$data_user->link_affiliate.".pinopi.com";
		$status = $isi_post->isi_konten.$signature;
		$hashtag = $mysqli->query("select value_pengaturan from tbl_pengaturan where nama_pengaturan='hashtag_twitter'")->fetch_object();
		$status = $status." ".$hashtag->value_pengaturan;
		$tw = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
		$tw->setTimeouts(10, 30);

		$content = $tw->get("account/verify_credentials");

		if(strlen($status) > 140) {
			$status = substr($status,0,139);
		}

		try {
			// your code here
			if($isi_post->tipe_konten == "normal"){
				$respone = $tw->post('statuses/update', array(
					'status' => $status
				));
				$result = 'berhasil';
			}else if($isi_post->tipe_konten == "video"){
				$status = str_replace("Hubungi","CP",$status);
				if(strlen($status) > 100) {
					$status = substr($status,0,95);
				}
				$respone = $tw->post('statuses/update', array(
					'status' => $status." ".$isi_post->url_konten.""
				));
				$result = 'berhasil';
			}else if($isi_post->tipe_konten == "foto"){
				$foto = str_replace("https://pinopi.com/","http://pinopi.com/",$isi_post->url_konten);

				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$file = file_get_contents($foto, false, stream_context_create($arrContextOptions), -1, 40000);
				if($file === false){
					$result = 'gagal';
				}else{
					$base = base64_encode($file);
					
					$media1 = $tw->upload('media/upload', array('media' => "'".$base."'"));
					 
					$respone = $tw->post('statuses/update', array(
						'status' => $status,
							'media_ids' => implode(',', array($media1->media_id_string))
					));
					$result = 'berhasil';
				}
			}	
		} catch (OAuthException $e) {
			$result = 'gagal';
		}
		$tgl_skrg = date("Y-m-d H:i:s");
		$mysqli->query("INSERT into tbl_auto_log(id_users,id_konten_promo,waktu,sosmed,status) values(".$data_user->id_users.",".$isi_post->id_konten.",'$tgl_skrg','twitter','".$result."')") ;
		echo "Post : ".$data_user->display_name."-".$result."<br>";
	}
}
?>