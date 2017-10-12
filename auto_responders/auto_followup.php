<?php
#!/usr/local/bin/php -q
include 'connectDB.php';
date_default_timezone_set('Asia/Jakarta');

$stmt = $mysqli->query("select * from users where upgrade=0 AND followup=1");
while($data_user = $stmt->fetch_object()){
	$stmt2 = $mysqli->query("select * from tbl_auto_followup where id_user=".$data_user->id." AND status='berhasil'");	
	$post = false;			
	if($stmt2->num_rows<7){
		$stmt3 = $mysqli->query("select * from tbl_auto_promo where id_user=".$data_user->id."");	
		$data_post = $stmt3->fetch_object();
		echo $stmt2->num_rows." Follow up : ".$data_user->nama_lengkap."<br>";
		$post = true;
		if($stmt2->num_rows == 6){
			$mysqli->query("update users set followup=0 where id=".$data_user->id."");
		}
	}else{
		$mysqli->query("update users set followup=0 where id=".$data_user->id."");
		echo $stmt2->num_rows." Follow up : ".$data_user->nama_lengkap."<br>";
		$post = false;
	}
	if($post){		
		$stmt_isi = $mysqli->query("select * from tbl_auto_followup_setting where hari=".($stmt2->num_rows+1)." ORDER BY RAND() LIMIT 1");
		$isi_post = $stmt_isi->fetch_object();
		$app_id = $data_post->id_app;
		$secret_key = $data_post->id_secret;
		$id_fb = $data_user->hybridauth_provider_uid;
		$access_token = $data_post->access_token;
		$isi_posting = str_replace("[nama]",$data_user->nama_lengkap,$isi_post->isi_post);
		$isi_posting = str_replace("[handphone]",$data_user->handphone,$isi_posting);
		$isi_posting = str_replace("[link_affiliate]","http://".$data_user->link_affiliate.".yesnumber1.com ",$isi_posting);
			$isi_posting = str_replace("<p>","",$isi_posting);
			$isi_posting = str_replace("</p>","",$isi_posting);
			$isi_posting = str_replace("<br>","",$isi_posting);
			$isi_posting = str_replace("<br/>","",$isi_posting);
			$isi_posting = str_replace("<br />","",$isi_posting);
			$isi_posting = str_replace("</br>","",$isi_posting);
			$isi_posting = str_replace("&nbsp;","",$isi_posting);
			$isi_posting = str_replace("&quot;","",$isi_posting);
			$isi_posting = str_replace("&ndash;","",$isi_posting);
		if($isi_post->tipe_post == "normal"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting,
				"link" => "http://".$data_user->link_affiliate.".yesnumber1.com",
				"picture" => $isi_post->url_post,
				"name" => "World Class Auto System yesnumber1.com",
				"caption" => "Bekerja 24 jam Non Stop untuk Anda, GARANSI!",
				"description" => "Sistem Kerja DAHSYAT membuat anda yang GAPTEK sekalipun bisa punya bisnis dengan pasar di berbagai negara seperti Indonesia, Malaysia, Hongkong, Taiwan, Singapore dan Lainnya"
			);
		}else if($isi_post->tipe_post == "video"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting,
				"link" => $isi_post->url_post
			);
		}else if($isi_post->tipe_post == "foto"){
				$attachment =  array(
				"access_token" => $access_token,
				"message" => $isi_posting,
				"link" => $isi_post->url_post
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
			$status = 'gagal';
		}else{
			$status = 'berhasil';
		}
		$tgl_skrg = date("Y-m-d H:i:s");
		$mysqli->query("INSERT into tbl_auto_followup(id_user,waktu,status) values(".$data_user->id.",'$tgl_skrg','$status')");
		echo $result;
	}else{
		echo $result;
	}
	echo "<br>";
}
?>