<?php
#!/usr/local/bin/php -q
include 'connectDB.php';
date_default_timezone_set('Asia/Jakarta');
	
$stmt = $mysqli->query("select * from tbl_auto_promo where status_auto_promo='aktif'");
while($data_post = $stmt->fetch_object()){
	$stmt3 = $mysqli->query("select * from users where id=".$data_post->id_user."");
	$data_user = $stmt3->fetch_object();
	$userkeyanda  = "inxa3r";
	$passkeyanda  = "gateway";
	$nohptujuan  = $data_user->handphone;
	$nama = explode(" ",$data_user->nama_lengkap);
	$nama = substr($nama[0],0,10); 
	$isi_pesan = "INFO YN1, Halo $nama, segera lakukan pembaharuan auto promo FB. Caranya login ke YN1, klik tombol 'Setting AutoPromo FB' untuk perpanjang akses token FB, terima kasih";
	$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
	$url = str_replace(" ","%20",$url);
	file_get_contents($url, false, stream_context_create($arrContextOptions));
	echo "<br>Reminder : ".$data_user->nama_lengkap;
}
?>