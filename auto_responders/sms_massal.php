<?php
include 'connectDB.php';

$kirim = false;
$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);
$userkeyanda  = "inxa3r";
$passkeyanda  = "gateway";
$no = 1;
$stmt = $mysqli->query("select * from users where handphone != '' order by display_name");
if($stmt->num_rows > 0){
	while($data_user = $stmt->fetch_object()){
		$nohptujuan  = $data_user->handphone;
		$isi_pesan = "Info YN1 : Utk mencegah promosi berhenti di FB, kami himbau Wajib Download Aplikasi YN1 utk pengguna hp Android, dan utk hp IOS dapat melalui website YN1. Thx";
		$url = "https://reguler.zenziva.net/apps/smsapi.php?userkey=$userkeyanda&passkey=$passkeyanda&nohp=$nohptujuan&pesan=$isi_pesan";
		$url = str_replace(" ","%20",$url);
		if($kirim){
			file_get_contents($url, false, stream_context_create($arrContextOptions));
		}
		echo "$no. Mengirim ke : ".$data_user->display_name." - ".$data_user->handphone."<br>";
		$no++;
	}
}else{
	echo "Tidak ada user terpilih";
}
?>