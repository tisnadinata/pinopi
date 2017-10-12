<?php
#!/usr/local/bin/php -q
include 'connectDB.php';
date_default_timezone_set('Asia/Jakarta');
	
$stmt = $mysqli->query("select * from tbl_promo_fb where status_promo='aktif'");
$tgl_sekarang = date("Y-m-d");
$last_p = "";		
$selisih = 0;
while($data_post = $stmt->fetch_object()){
	$count_post = $mysqli->query("select * from tbl_auto_log where id_users=".$data_post->id_users." and status='berhasil' and sosmed='twitter' and DAY(waktu) = DAY(NOW())")->num_rows;
	if($count_post < $data_post->delay){	
		$data_user = $mysqli->query("select * from tbl_users where id_users=".$data_post->id_users)->fetch_object();
		$expired = (abs(strtotime($data_post->expired) - strtotime ($tgl_sekarang))/(60*60*24));
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
			$isi_pesan = "INFO PINOPI : Halo $nama, token FB anda akan habis hari ini. Silahkan login ke PINOPI lalu klik 'Setting AutoPromo FB' untuk pembaharuan";
			$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
			$url = str_replace(" ","%20",$url);
//			file_get_contents($url, false, stream_context_create($arrContextOptions));
			if($expired == 1){
				#FACEBOOK STATUS
				$mysqli->query("update tbl_promo_fb set
								  access_token=''
								  WHERE id_user=".$data_user->id."
							");
			}
		}
		
		$isi_post = getPost("facebook");
		$app_id = "134542503820931";
		$secret_key = "f6c6a77fd539cc0c3620623bf0623f9b";
		$id_fb = $data_user->facebook_id;
		$access_token = $data_post->access_token;
		$isi_posting = str_replace("[nama]",$data_user->display_name,$isi_post->isi_konten);
		$isi_posting = str_replace("[telepon]",$data_user->telepon,$isi_posting);
		$isi_posting = str_replace("[email]",$data_user->email,$isi_posting);
		$isi_posting = str_replace("[link_affiliate]","http://".$data_user->link_affiliate.".pinopi.com ",$isi_posting);
		$isi_posting = str_replace("<p>","",$isi_posting);
		$isi_posting = str_replace("</p>","",$isi_posting);
		$isi_posting = str_replace("<br>","\n",$isi_posting);
		$isi_posting = str_replace("<br/>","\n",$isi_posting);
		$isi_posting = str_replace("<br />","\n",$isi_posting);
		$isi_posting = str_replace("</br>","\n",$isi_posting);
		$isi_posting = str_replace("&nbsp;","",$isi_posting);
		$isi_posting = str_replace("&quot;","",$isi_posting);
		$isi_posting = str_replace("&ndash;","",$isi_posting);
		$hashtag = $mysqli->query("select value_pengaturan from tbl_pengaturan where nama_pengaturan='hashtag_facebook'")->fetch_object();
		$isi_posting = $isi_posting."\n".$hashtag->value_pengaturan;
			
		$attachment  = "";
		if($isi_post->tipe_konten == "normal"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting." (Atau Klik Tautan Dibawah) ",
				"link" => "http://".$data_user->link_affiliate.".pinopi.com",
				"picture" => $isi_post->url_konten,
				"name" => getPengaturan("judul_web")->value_pengaturan,
				"caption" => getPengaturan("judul_web")->value_pengaturan,
				"description" => getPengaturan("deskripsi_toko")->value_pengaturan
			);
		}else if($isi_post->tipe_konten == "video"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting,
				"link" => $isi_post->url_konten
			);
		}else if($isi_post->tipe_konten == "foto"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting,
				"link" => $isi_post->url_konten
			);
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/'.$id_fb.'/feed');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
		$result = curl_exec($ch);
		curl_close($ch);
		if(strpos($result,"error")){
			if(strpos($result,"ermission")){
				$isi_pesan = "INFO PINOPI, Halo $nama, kami tidak bisa melakukan auto promosi dikarenakan akun FB anda tidak mengizinkan PINOPI untuk melakukan post. Silahkan hubungi CS kami, terima kasih";
			}else{
				$isi_pesan = "INFO PINOPI, Halo $nama, saat ini akses facebook anda telah expired. Segera update akses dgn klik tombol pembaharuan melalui login ke web / ke aplikasi, terima kasih";
			}
			$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
			$url = str_replace(" ","%20",$url);
			//file_get_contents($url, false, stream_context_create($arrContextOptions));
			$status = 'gagal';
		}else{
			$status = 'berhasil';
		}
		$tgl_skrg = date("Y-m-d H:i:s");
		$mysqli->query("INSERT into tbl_auto_log(id_users,id_konten_promo,waktu,sosmed,status) values(".$data_user->id_users.",".$isi_post->id_konten.",'$tgl_skrg','facebook','".$status."')");
		echo "Post : ".$data_user->display_name."-".$status."<br>";
	}
}
?>