<?php
#!/usr/local/bin/php -q
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connectDB.php';
	date_default_timezone_set('Asia/Jakarta');


	//-----perintah upload foto----//

	require_once 'instagram_sdk/functions.php';
	require_once 'instagram_sdk/instaW.php';

	function cekBerlangganan($id_user){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_auto_promo_order where id_user=$id_user AND status_order='success' ORDER BY idorder_autopromo DESC");
		if($stmt->num_rows > 0){
			$data= $stmt->fetch_object();
			$tgl_berlangganan = date("d-m-Y",strtotime ($data->start_at));
			$tgl_sekarang = date("d-m-Y");
			$selisih = ((abs(strtotime ($tgl_berlangganan) - strtotime ($tgl_sekarang)))/(60*60*24));
			if($selisih<=$data->jenispaket){
				return true;
			}else{
				if($data->jenispaket == 7){
					$mysqli->query("delete from tbl_auto_promo_order where idorder_autopromo=".$data->idorder_autopromo."");
				}
				return false;
			}
		}else{
			return false;
		}
	}
	//----ambil akun---//
$selisih = 0;

//	$query = $mysqli->query("select * from tbl_auto_promo_instagram where status_auto_promo='aktif' and id_user='119' order by id_auto_promo DESC");
	$query = $mysqli->query("select * from tbl_auto_promo_instagram where status_auto_promo='aktif' order by id_auto_promo DESC");
	//----random gambar---//
	while ($get = $query->fetch_array()) {
		$cari = $mysqli->query("select * from tbl_auto_promo_setting where medsos ='instagram' order by rand() limit 1");
		$ambil = $cari->fetch_array();
		
		$tgl_sekarang = date("Y-m-d");
		$jam = date("H:i:s");
		$stmt2 = $mysqli->query("select * from tbl_auto_log where id_auto_promo=".$get['id_auto_promo']." AND status='berhasil' AND medsos='instagram' ORDER BY id_auto_log DESC LIMIT 2");	
		$stmt3 = $mysqli->query("select * from users where id=".$get['id_user']."");
		$data_user = $stmt3->fetch_object();
		
		$post = false;			
		$result = "skip";
		if($stmt2->num_rows>0){
			$last_post = $stmt2->fetch_object();		
			$last_p = date('Y-m-d',strtotime($last_post->waktu));

			$last_post = $stmt2->fetch_object();		
			$last_p2 = date('Y-m-d',strtotime($last_post->waktu));

			$seilisih = ((abs(strtotime ($tgl_sekarang) - strtotime ($last_p)))/(60*60*24));
			if(($seilisih >= $get['auto_promo'] OR $last_p != $last_p2) AND cekBerlangganan($data_user->id)){		
				$post = true;
			}else{
				$post = false;			
			}
			if(!cekBerlangganan($data_user->id)){
				$mysqli->query("update tbl_auto_promo_instagram set status_auto_promo='tidak aktif' where id_user=".$data_user->id."");
			}
		}else{
			$last_p = $tgl_sekarang;	
			$post = true;
		}
		if($post){
						$tgl_skrg = date("Y-m-d H:i:s");
			$capt = $ambil['isi_post'];
			$capt = str_replace("[nama]",$data_user->nama_lengkap,$capt);
			$capt = str_replace("[handphone]",$data_user->handphone,$capt);
			$capt = str_replace("[link_affiliate]","http://".$data_user->link_affiliate.".yesnumber1.com  ",$capt);
			$capt = str_replace("<p>","",$capt);
			$capt = str_replace("</p>","",$capt);
			$capt = str_replace("&nbsp;","",$capt);

			$gambar_path = str_replace("http://yesnumber1.com/","../",$ambil['url_post']);
			$gambar_path = str_replace("https://yesnumber1.com/","../",$gambar_path);
			$gambar = $ambil['url_post'];

			$username = $get['username'];
			$password = $get['password'];

			$client = new instaW();
			$login = $client->login($username,$password);
			if($login){
				$media_id = $client->upload_image($gambar_path);
				if($media_id){
					$manipulate = $client->configure_image($media_id,$capt);
					if($manipulate){
						$mysqli->query("INSERT into tbl_auto_log(id_auto_promo,waktu,medsos,status) values(".$get['id_auto_promo'].",'$tgl_skrg','instagram','berhasil')");
						echo 'Upload Berhasil. Image id: '.$manipulate->id." - ".$data_user->nama_lengkap;
						echo "<br>";
					}else{
						echo "Upload gagal"." - ".$data_user->nama_lengkap."<br>";
					$mysqli->query("INSERT into tbl_auto_log(id_auto_promo,waktu,medsos,status) values(".$get['id_auto_promo'].",'$tgl_skrg','instagram','gagal 3')");
					}
				}else{
					echo "Upload gambar gagal"." - ".$data_user->nama_lengkap."<br>";
					$mysqli->query("INSERT into tbl_auto_log(id_auto_promo,waktu,medsos,status) values(".$get['id_auto_promo'].",'$tgl_skrg','instagram','gagal 2')");
				}
			}else{
				echo "Gagal login"." - ".$data_user->nama_lengkap."<br>";
				$mysqli->query("INSERT into tbl_auto_log(id_auto_promo,waktu,medsos,status) values(".$get['id_auto_promo'].",'$tgl_skrg','instagram','gagal 1')");
			}
		}else{
			echo "skip"." - ".$data_user->nama_lengkap;
			echo "<br>";
		}
	}


?>