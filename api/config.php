<?php
	session_start();
	$mysqli = new mysqli("localhost","pinopi_pinopi","pinopi123","pinopi_pinopi");
	date_default_timezone_set('Asia/Jakarta');
	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}		
	function getDataByCollumn($table_name,$field_name,$value){
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $field_name='$value'");
		return $stmt;		
	}
	function getPengaturan($nama_pengaturan){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_pengaturan","nama_pengaturan",$nama_pengaturan);
		if($stmt->num_rows > 0){
			return $stmt->fetch_object();
		}else{
			return 0;
		}
	}
	function generate_trans_invoice(){
		global $mysqli;
		$tahun = date('y');
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		$invoice = "PNP-".$tahun.'-'.$bulan.'-';
		$stmt = $mysqli->query("select count(id_transaksi) as urut from tbl_transaksi");
		$row = $stmt->fetch_array();
		$urut = $row['urut']+1+100;
		$stmt->close();
		return $invoice.$urut;
	}
	function generate_trans_code(){
		global $mysqli;
		$invoice = 100;
		$stmt = $mysqli->query("select count(id_transaksi) as urut from tbl_transaksi where MONTH(tanggal_transaksi) = MONTH(NOW())");
		$row = $stmt->fetch_array();
		$urut = $row['urut']+1;
		$stmt->close();
		return $invoice+$urut;
	}
	function getProdukHarga($id_produk){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_produk","id_produk",$id_produk);
		return $stmt->fetch_object()->harga_produk;
	}
	function getProdukHargaDistributor($id_produk){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_produk","id_produk",$id_produk);
		return $stmt->fetch_object()->harga_distributor;
	}
	function getProdukHargaNonmember($id_produk){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_produk","id_produk",$id_produk);
		return $stmt->fetch_object()->harga_nonmember;
	}
	function setHargaRupiah($harga){
		return number_format($harga,0,",",".");
	}	
	function getCartQty($ip_customer){
		global $mysqli;
		$jum_qty = $mysqli->query("select sum(qty) as jum_qty from tbl_keranjang where ip_customer='$ip_customer'")->fetch_object();
		return $jum_qty->jum_qty;
	}
	function kirim_email($status,$judul_email,$nomor_invoice){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_transaksi","invoice_transaksi",$nomor_invoice);
		$data_transaksi = $stmt->fetch_object();
		$sql = "select * from tbl_transaksi,tbl_transaksi_pembayaran,tbl_transaksi_pengiriman
			WHERE tbl_transaksi.id_transaksi=".$data_transaksi->id_transaksi." AND tbl_transaksi_pembayaran.id_transaksi=".$data_transaksi->id_transaksi." 
			AND tbl_transaksi_pengiriman.id_transaksi=".$data_transaksi->id_transaksi."";
		$stmt = $mysqli->query($sql);
		//echo $sql;
		if($stmt->num_rows > 0){
			$data_transaksi = $stmt->fetch_object();
		}
							
		$tanggal_pemesanan = date('d F Y / H:i:s',strtotime($data_transaksi->tanggal_transaksi));
		$total_tagihan = setHargaRupiah($data_transaksi->total_transaksi-$data_transaksi->diskon_transaksi+$data_transaksi->kode_unik+$data_transaksi->biaya_pengiriman);
		
		$status_pesanan = '<label style="background-color: #777;color: white;padding: 5px;">'.$status.' - Pesanan kami terima, menunggu konfirmasi pembayaran</label>';
		
		$logo_web = 'http://pinopi.com/'.getPengaturan('logo')->value_pengaturan;

		$isi_email = '
			<table style="max-width:100%;border-collapse:collapse;border-spacing:0;width:100%;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
			<tbody>
			<tr style="margin:0;padding:0">
				<td style="margin:0;padding:0"></td>
				<td bgcolor="#FFFFFF" style="display:block!important;max-width:600px!important;clear:both!important;margin:0 auto;padding:0">
					<div style="max-width:600px;display:block;border-collapse:collapse;margin:0 auto;padding:30px 15px;border:1px solid #e7e7e7">
						<table style="max-width:100%;border-collapse:collapse;border-spacing:0;width:100%;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
						<tbody>
						<tr style="margin:0;padding:0">
							<td style="margin:0;padding:0">
								<cAger><img src="'.$logo_web.'" width="50%" /></cAger>
								<br>
								<h5 style="line-height:24px;color:#000;font-weight:900;font-size:17px;margin:0 0 20px;padding:0">Terima kasih sudah melakukan pemesanan di PINOPI.COM.</h5>
								<p style="font-weight:normal;font-size:14px;line-height:1.6;margin:0 0 20px;padding:0">
								 Berikut informasi pesanan anda :
								</p>
								<div style="margin:0 0 20px;padding:0">
									<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
									<tbody style="margin:0;padding:0">
									<tr style="margin:0;padding:0">
										<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Nomor Invoice:</td>
										<td style="margin:0;padding:0">'.$nomor_invoice.'</td>
									</tr>
									</tbody>
									</table>
									<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
									<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
									<tbody style="margin:0;padding:0">
									<tr style="margin:0;padding:0">
										<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Tanggal Pemesanan:</td>
										<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">'.$tanggal_pemesanan.'</td>
									</tr>
									</tbody>
									</table>
									<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
									<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
									<tbody style="margin:0;padding:0">
									<tr style="margin:0;padding:0">
										<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Total Pembayaran:</td>
										<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Rp '.$total_tagihan.'</td>
									</tr>
									</tbody>
									</table>
									<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
									<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
									<tbody style="margin:0;padding:0">
									<tr style="margin:0;padding:0">
										<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Status Pesanan:</td>
										<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">
											<div style="margin:0 0 4px;padding:0">
											'.$status_pesanan.'
											</div>
										</td>
									</tr>
									</tbody>
									</table>
								</div>
								<hr style="border-top-color:#d0d0d0;border-top-style:solid;border-bottom-color:#ffffff;border-bottom-style:solid;margin:20px 0;padding:0;border-width:3px 0 1px">
								<h5 style="line-height:1.1;color:#000;font-weight:900;font-size:17px;margin:0 0 20px;padding:0">Rincian Pesanan:</h5>
								<div style="margin:0;padding:0">
									<table style="width:100%;font-size:13px;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
									<thead style="color:white;text-align:left;background-color:#70663f;margin:0;padding:0">
									<tr style="margin:0;padding:0">
										<th style="padding:5px;">NO</th>
										<th style="padding:5px;">NAMA PRODUK</th>
										<th style="padding:5px;">QTY</th>
										<th style="padding:5px;">HARGA SATUAN</th>
										<th style="padding:5px;">SUBTOTAL</th>
									</tr>
									</thead>
									<tbody style="margin:0;padding:0">
										';
										$detail_transaksi = getDataByCollumn("tbl_transaksi_detail","id_transaksi",$data_transaksi->id_transaksi);
										$i = 1;
										$isi_email2 = '';
										while($detail = $detail_transaksi->fetch_object()){
											$isi_email2 = $isi_email2.'
												<tr>
													<td style="padding:5px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;">'.$i.'</td>
													<td style="padding:5px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;">'.$detail->nama_produk.'</td>
													<td style="padding:5px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;">'.$detail->qty.' pcs</td>
													<td style="padding:5px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;" align="right">Rp '.setHargaRupiah($detail->harga_produk/$detail->qty).'</td>
													<td style="padding:5px;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;" align="right">Rp '.setHargaRupiah($detail->harga_produk).'</td>
												</tr>
											';
											$i++;
										}
										
									$isi_email2 = $isi_email2.'
									<tr style="font-weight:bold">
										<td colspan="4" align="right">Total Biaya Transaksi<span style="color:red;font-size:0.8em;">(tanpa diskon & kode unik)</span></td>
										<td  align="right">Rp '.setHargaRupiah($data_transaksi->total_transaksi).'</td>
									</tr>';
									$isi_email3 = '
									</tbody>
									</table>
								</div>
								<p style="font-weight:normal;font-size:14px;line-height:1.6;border-top-style:solid;border-top-color:#d0d0d0;border-top-width:3px;margin:40px 0 0;padding:10px 0 0">
									<small style="color:#999;margin:0;padding:0">Untuk informasi pembayaran silahkan cek pada halaman <a href="http://pinopi.com/cara-pemesanan" style="color:#70663f;text-decoration:none;margin:0;padding:0" target="_blank" >CARA PEMESANAN</a>.<br style="margin:0;padding:0">
									<br style="margin:0;padding:0">
									<small style="color:#999;margin:0;padding:0">Untuk informasi selengkapnya silahkan cek transaksi anda pada halaman <a href="http://pinopi.com/cek-transaksi" style="color:#70663f;text-decoration:none;margin:0;padding:0" target="_blank" >STATUS PEMESANAN</a>.<br style="margin:0;padding:0">
									<br style="margin:0;padding:0">
									Email ini dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</small>
								</p>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
				</td>
				<td style="margin:0;padding:0"></td>
			</tr>
			</tbody>
			</table>
			<table align="cAger">
			<tbody>
			<tr style="margin:0;padding:0 0 0 0">
				<td style="display:block!important;width:600px!important;clear:both!important;margin:0 auto;padding:0">
					<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse:collapse;background-color:#f7f7f7;font-size:13px;color:#999999;border-top:1px solid #dddddd">
					<tbody>
					<tr>
						<td width="600" align="cAger" style="padding:30px 20px 0">
							Jika butuh bantuan, gunakan halaman <a href="http://pinopi.com/tentang-kami" style="color:#70663f" target="_blank" >Kontak Kami</a>
						</td>
					</tr>
					<tr>
						<td width="600" align="cAger" style="padding:10px 20px 30px">
							© 2017, <span class="il">PINOPI.COM</span>
						</td>
					</tr>
					</tbody>
					</table>
				</td>
			</tr>
			</tbody>
			</table>';
			
			require_once('../library/email/function.php');
		
			$to       = $data_transaksi->email;
			$subject  = $judul_email;
			$message  = $isi_email.$isi_email2.$isi_email3;
			smtp_mail($to, $subject, $message, '', '', 0, 0, true);
	}
	function login($obj){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where email='".$obj->email."'");
		$data = array();
		if($stmt->num_rows > 0){
			$get = $stmt->fetch_object();
			$result = getuserData($get->id_users);
			$mysqli->query("update tbl_promo_fb set access_token='".$obj->access_token."',expired='".$obj->expired."' where id_users=".$get->id_users);
			$mysqli->query("update tbl_users_device set device_token='".$obj->device_token."' where id_users=".$get->id_users);			
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	function register($obj){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where email='".$obj->email."'");
		$data = array();
		if($stmt->num_rows == 0){
			$stmt = $mysqli->query("select * from tbl_users where link_affiliate='".$obj->upline."'");
			if($stmt->num_rows > 0){
				$upline = $stmt->fetch_object()->link_affiliate;
				if($obj->email != ''){
					$link_affiliate = explode("@",$obj->email);
					$link_affiliate = $link_affiliate[0];
				}else{
					$link_affiliate = str_replace(" ","",$obj->display_name);
					$link_affiliate = substr($link_affiliate,2,10);
				}
				$created_at= date("Y-m-d H:i:s");
				$stmt = $mysqli->query("insert into tbl_users(display_name,link_affiliate,upline,email,facebook_id,url_foto,created_at) values('".$obj->display_name."','$link_affiliate','$upline','".$obj->email."','".$obj->facebook_id."','".$obj->picture."','$created_at')");
				if($stmt){
					$stmt = $mysqli->query("select * from tbl_users where email='".$obj->email."'")->fetch_object();
					$sql = "insert into tbl_promo_fb values('','".$stmt->id_users."',1,'".$obj->access_token."','aktif','".$obj->expired."')";
					$sql_tw = "insert into tbl_promo_tw values('','".$stmt->id_users."',1,'','','tidak aktif','')";
					$sql_alamat = "insert into tbl_users_alamat(id_users,alamat) values('".$stmt->id_users."','Tidak Ada')";
					$sql_bank	 = "insert into tbl_users_bank(id_users,nama_bank,pemilik_bank,nomor_rekening,status_bank) values('".$stmt->id_users."','','','','aktif')";
					$sql_device = "insert into tbl_users_device(id_users,device_token) values('".$stmt->id_users."','".$obj->device_token."')";
					$mysqli->query($sql);
					$mysqli->query($sql_tw);
					$mysqli->query($sql_alamat);
					$mysqli->query($sql_bank);
					$mysqli->query($sql_device);
					$result = getuserData($stmt->id_users);
				}else{
					$result = array(
						"success" => false,
						"message" => "Something wrong when creating user, try again later or visit our website http://pinopi.com"
					);
				}
			}else{
				$result = array(
					"success" => false,
					"message" => $obj->upline." is not registered,invalid link affiliate"
				);
			}
		}else{
			$result = array(
				"success" => false,
				"message" => "User already exist,please login"
			);
		}
		return $result;
	}
	function getuser($call){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "data";	$result = getuserData($call[2]);	break;
			case "bonus";	$result = getuserBonus($call[2]);	break;
			case "message";	$result = getuserMessage($call[2]);	break;
			case "promosi";	$result = getuserPromosi($call[2]);	break;
			case "transaksi";	$result = getuserTransaksi($call[2]);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted");break;
		}
		return $result;
	}
	function getuserData($id_users){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where id_users='$id_users'");
		$stmt_alamat = $mysqli->query("select alamat from tbl_users_alamat where id_users='$id_users'");
		$stmt_bank = $mysqli->query("select nama_bank,pemilik_bank,nomor_rekening from tbl_users_bank where id_users='$id_users'");
		$data = array();
		if($stmt->num_rows){
			$get = $stmt->fetch_object();
			$get_alamat = $stmt_alamat->fetch_object();
			$get_bank = $stmt_bank->fetch_object();
			$data[] = $get;
			$data[] = $get_alamat;
			$data[] = $get_bank;
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	function getuserBonus($id_users){
		global $mysqli;
		$stmt_jaringan = $mysqli->query("select * from tbl_users_bonus where tipe_bonus = 'jaringan' AND id_users=$id_users order by tanggal DESC");
		$stmt_penjualan = $mysqli->query("select * from tbl_users_bonus where tipe_bonus = 'penjualan' AND id_users=$id_users order by tanggal DESC");
		$stmt_retail = $mysqli->query("select * from tbl_users_bonus where tipe_bonus = 'retail' AND id_users=$id_users order by tanggal DESC");
		$data_jaringan = array();
		$data_penjualan = array();
		$data_retail = array();
		$total_jaringan =0;
		$total_penjualan =0;
		$total_retail = 0;
		while($get_jaringan = $stmt_jaringan->fetch_object()){
			$data_jaringan[] = $get_jaringan;
			$total_jaringan = $total_jaringan+$get_jaringan->jumlah_bonus;
		}
		while($get_penjualan = $stmt_penjualan->fetch_object()){
			$data_penjualan[] = $get_penjualan;			
			$total_penjualan = $total_penjualan+$get_penjualan->jumlah_bonus;
		}
		while($get_retail = $stmt_retail->fetch_object()){
			$data_retail[] = $get_retail;			
			$total_retail = $total_retail+$get_retail->jumlah_bonus;
		}
		$result = array(
			"success" => true,
			"result" => array(
				"bonus_jaringan" => array("riwayat" => $data_jaringan,"total" => $total_jaringan),
				"bonus_penjualan" => array("riwayat" => $data_penjualan,"total" => $total_penjualan),
				"bonus_retail" => array("riwayat" => $data_retail,"total" => $total_retail)
			)
		);
		return $result;
	}
	function getuserMessage($id_users){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users_message where dari='$id_users' or untuk='$id_users' order by created");
		$data = array();
		if($stmt->num_rows){
			$message=array();
			while($get = $stmt->fetch_object()){
				$dari = $mysqli->query("select * from tbl_users where id_users='".$get->dari."'")->fetch_object();
				$untuk = $mysqli->query("select * from tbl_users where id_users='".$get->untuk."'")->fetch_object();
				$message[] = array(
					"dari_id"=> $dari->id_users,
					"dari"=> $dari->display_name,
					"untuk_id"=> $untuk->id_users,
					"untuk"=> $untuk->display_name,
					"tanggal"=> $get->created,
					"pesan"=> $get->pesan
				);
			}
			$result = array(
				"success" => true,
				"result" => $message
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	function getuserPromosi($id_users){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where id_users='$id_users'");
		$stmt_fb = $mysqli->query("select * from tbl_promo_fb where id_users='$id_users'");
		$stmt_tw = $mysqli->query("select * from tbl_promo_tw where id_users='$id_users'");
		$stmt_ig = $mysqli->query("select * from tbl_promo_ig where id_users='$id_users'");
		$data = array();
		if($stmt->num_rows){
			$get = $stmt->fetch_object();
			$get_fb = $stmt_fb->fetch_object();
			$get_tw = $stmt_tw->fetch_object();
			$get_ig = $stmt_ig->fetch_object();
			$data[] = $get_fb;
			$data[] = $get_tw;
			$data[] = $get_ig;
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	
	function getuserTransaksi($id_users){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where id_users='$id_users'");
		$stmt_tr = $mysqli->query("select * from tbl_transaksi where id_users='$id_users' order by tanggal_transaksi DESC");
		$data = array();
		if($stmt->num_rows){
			$get = $stmt->fetch_object();
			while($get_tr = $stmt_tr->fetch_object()){
				$stmt_st = $mysqli->query("select * from tbl_transaksi_status where id_transaksi='".$get_tr->id_transaksi."' order by tanggal DESC limit 1");
				$stmt_pb = $mysqli->query("select * from tbl_transaksi_pembayaran where id_transaksi='".$get_tr->id_transaksi."'");
				$stmt_pg = $mysqli->query("select * from tbl_transaksi_pengiriman where id_transaksi='".$get_tr->id_transaksi."'");
				$get_st = $stmt_st->fetch_object();
				$get_pb = $stmt_pb->fetch_object();
				$get_pg = $stmt_pb->fetch_object();
				$total_transaksi = $get_tr->total_transaksi-$get_tr->diskon_transaksi+$get_tr->kode_unik+$get_pg->biaya_pengiriman;
				$data[] = array(
					"id_transaksi" => $get_tr->id_transaksi,
					"invoice_transaksi" => $get_tr->invoice_transaksi,
					"atas_nama" => $get_tr->atas_nama,
					"tanggal_transaksi" => $get_tr->tanggal_transaksi,
					"biaya_transaksi" => $total_transaksi,
					"status_transaksi" => $get_st->status_transaksi,
					"status_pembayaran" => $get_pb->status_pembayaran
				);
			}
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	function getproduk($call){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "list";	$result = getprodukList();	break;
			case "detail";	$result = getprodukDetail($call[2]);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted".$call[0]);break;
		}
		return $result;
	}
	function getprodukList(){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_produk where status_produk='aktif' order by rand()");
		$data = array();
		while($get = $stmt->fetch_object()){
			$data[] = $get;
		}
		$result = array(
			"success" => true,
			"result" => $data
		);
		return $result;
	}
	function getprodukDetail($id_produk){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_produk where id_produk=$id_produk AND status_produk='aktif'");
		$data = array();
		if($stmt->num_rows){
			$get = $stmt->fetch_object();
			$data[] = $get;
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "Product doesn't exist"
			);
		}
		return $result;
	}
	function gettransaksi($call){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "detail";	$result = gettransaksiDetail($call[2]);	break;
			case "keranjang";	$result = gettransaksiKeranjang($call[2]);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted".$call[0]);break;
		}
		return $result;
	}
	function gettransaksiDetail($id_transaksi){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_transaksi where id_transaksi=$id_transaksi");
		$stmt_detail = $mysqli->query("select * from tbl_transaksi_detail where id_transaksi=$id_transaksi");
		$stmt_pembayaran = $mysqli->query("select * from tbl_transaksi_pembayaran where id_transaksi=$id_transaksi");
		$stmt_pengiriman = $mysqli->query("select * from tbl_transaksi_pengiriman where id_transaksi=$id_transaksi");
		$stmt_status = $mysqli->query("select * from tbl_transaksi_status where id_transaksi=$id_transaksi order by tanggal DESC");
		$trx_detail = array();
		while($trx_dtl = $stmt_detail->fetch_object()){
			$get_produk = $mysqli->query("select * from tbl_produk where id_produk=".$trx_dtl->isi_produk)->fetch_object();
			$produk = new stdClass;
			$produk->berat_produk = $get_produk->berat_produk;
			$produk->url_foto = $get_produk->url_foto;
			$extended = (object) array_merge((array)$trx_dtl, (array)$produk);
			$trx_detail[] = $extended;
		}
		if($stmt->num_rows){
			$data = array(
				"transaksi_detail" => $stmt->fetch_object(),
				"transaksi_produk" => $trx_detail,
				"transaksi_pembayaran" => $stmt_pembayaran->fetch_object(),
				"transaksi_pengiriman" => $stmt_pengiriman->fetch_object(),
				"transaksi_status" => $stmt_status->fetch_object()
			);
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "Transaction doesn't exist"
			);
		}
		return $result;
	}
	function getkeranjang($call){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "detail";	$result = getkeranjangUser($call[2]);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted".$call[0]);break;
		}
		return $result;
	}
	function getkeranjangUser($id_users){
		global $mysqli;
		$data = array();
		$stmt = $mysqli->query("select tbl_keranjang.id_keranjang,tbl_keranjang.ip_customer,tbl_keranjang.id_produk,tbl_keranjang.qty,
		tbl_produk.nama_produk,tbl_produk.harga_produk,tbl_produk.harga_nonmember,tbl_produk.harga_distributor,tbl_produk.berat_produk,tbl_produk.url_foto 
		from tbl_keranjang,tbl_produk where tbl_keranjang.ip_customer='$id_users' and tbl_keranjang.id_produk = tbl_produk.id_produk");		
		if($stmt->num_rows){
			while($get = $stmt->fetch_object()){
				$data[] = $get;
			}
			$result = array(
				"success" => true,
				"result" => $data
			);
		}else{
			$result = array(
				"success" => false,
				"message" => "Transaction doesn't exist"
			);
		}
		return $result;
	}	function postuser($call,$obj){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "data";	$result = postuserData($obj);	break;
			case "message";	$result = postuserMessage($obj);	break;
			case "promosi";	$result = postuserPromosi($obj);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted");break;
		}
		return $result;
	}
	function postuserData($obj){
		global $mysqli;
		$stmt = $mysqli->query("select * from tbl_users where id_users='$id_users'");
		$data = array();
		if($stmt->num_rows){
			$stmt = $mysqli->query("update tbl_users set display_name='".$obj->display_name."',email='".$obj->email."',telepon='".$obj->telepon."' where id_users=".$obj->id_users);
			$stmt_bank = $mysqli->query("update tbl_users_bank set nama_bank='".$obj->nama_bank."',pemilik_bank='".$obj->pemilik_bank."',nomor_rekening='".$obj->nomor_rekening."' where id_users=".$obj->id_users);
			$stmt_alamat = $mysqli->query("update tbl_users_alamat set alamat='".$obj->alamat."' where id_users=".$obj->id_users);
			if($stmt){
				if($stmt_alamat){
					if($stmt_bank){
						$result = getuserData($obj->id_users);
					}else{
						$result = array(
							"success" => false,
							"message" => "Something wrong when updating user bank"
						);
					}
				}else{
					$result = array(
						"success" => false,
						"message" => "Something wrong when updating user address"
					);
				}
			}else{
				$result = array(
					"success" => false,
					"message" => "Something wrong when updating user data"
				);
			}
		}else{
			$result = array(
				"success" => false,
				"message" => "User doesn't exist"
			);
		}
		return $result;
	}
	function postuserMessage($obj){
		global $mysqli;
		$stmt = $mysqli->query("insert into tbl_users_message(dari,untuk,pesan) values('".$obj->id_users."','".$obj->untuk_id."','".$obj->pesan."')");
		$data = array();
		if($stmt){
			$result = getuserMessage($obj->id_users);
		}else{
			$result = array(
				"success" => false,
				"message" => "Something wrong when sending message"
			);
		}
		return $result;
	}
	function postuserPromosi($obj){
		global $mysqli;
		if($obj->setting == "facebook"){
			$stmt = $mysqli->query("update tbl_promo_fb set delay=".$obj->delay.",access_token='".$obj->access_token."',status_promo='".$obj->status_promo."',expired='".$obj->id_users."' where id_users=".$obj->id_users." ");
		}else if($obj->setting == "twitter"){
			$stmt = $mysqli->query("update tbl_promo_tw set delay=".$obj->delay.",access_token='".$obj->access_token."',access_secret='".$obj->access_secret."',status_promo='".$obj->status_promo."',expired='".$obj->id_users."' where id_users=".$obj->id_users." ");
		}else{
			$stmt = false;
		}
		$data = array();
		if($stmt){
			$result = getuserPromosi($obj->id_users);
		}else{
			$result = array(
				"success" => false,
				"message" => "Something wrong when updating data"
			);
		}
		return $result;
	}
	function postkeranjang($call,$obj){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "tambah"; $result = postkeranjangTambah($obj);	break;
			case "hapus"; $result = postkeranjangDelete($obj);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted");break;
		}
		return $result;
	}
	function postkeranjangTambah($obj){
		global $mysqli;
		
		$ip_customer = $obj->id_users;
		$id_produk = $obj->id_produk;
		$qty = $obj->qty;
		$stmt = $mysqli->query("select * from tbl_keranjang where ip_customer='$ip_customer' AND id_produk=$id_produk");
		if($stmt->num_rows>0){
			$stmt = $mysqli->query("UPDATE tbl_keranjang SET qty=(qty+$qty) WHERE ip_customer='$ip_customer' AND id_produk=$id_produk");
			if($stmt){
				$result = array(
					"success" => true,
					"message" => "Success updating your cart"
				);
			}else{
				$result = array(
					"success" => false,
					"message" => "Fail updating your cart"
				);
			}
		}else{
			$stmt = $mysqli->query("INSERT into tbl_keranjang(ip_customer,id_produk,qty) VALUES('$ip_customer',$id_produk,$qty)");
			if($stmt){
				$result = array(
					"success" => true,
					"message" => "Success add to your cart"
				);
			}else{
				$result = array(
					"success" => true,
					"message" => "Fail add to your cart"
				);
			}
		}		
		return $result;
	}
	function postkeranjangDelete($obj){
		global $mysqli;
		
		$ip_customer = $obj->id_users;
		$id_produk = $obj->id_produk;
		$qty = $obj->qty;
		$stmt = $mysqli->query("select * from tbl_keranjang where ip_customer='$ip_customer' AND id_produk=$id_produk");
		if($stmt->num_rows>0){
			$stmt = $mysqli->query("delete from tbl_keranjang WHERE ip_customer='$ip_customer' AND id_produk=$id_produk");
			if($stmt){
				$result = array(
					"success" => true,
					"message" => "Product deleted from your cart"
				);
			}else{
				$result = array(
					"success" => false,
					"message" => "Fail updating your cart"
				);
			}
		}else{
			$result = array(
				"success" => false,
				"message" => "Product does not exist"
			);
		}		
		return $result;
	}
	function posttransaksi($call,$obj){
		global $mysqli;
		$call = explode("-",$call);
		$result = "";
		switch($call[1]){
			case "konfirmasi";	$result = posttransaksiConfirm($obj);	break;
			case "checkout";	$result = posttransaksiCheckout($obj);	break;
			default : $result = array("success"=>false,"message"=>"request unlisted");break;
		}
		return $result;
	}
	function posttransaksiConfirm($obj){
		global $mysqli;
		
		if (isset($_FILES['bukti_pembayaran']['name'])) {
			$file_upload_url = 'img/produk/';
			$target_path = "../img/produk/";
			$target_path = $target_path . basename($_FILES['bukti_pembayaran']['name']);
		 
			// reading other post parameters
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$website = isset($_POST['website']) ? $_POST['website'] : '';
		 
			$response['file_name'] = basename($_FILES['bukti_pembayaran']['name']);
			try {
				// Throws exception incase file is not being moved
				if (!move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_path)) {
					// make error flag true
					$result = array(
						"success" => false,
						"message" => "Could not move the file!"
					);
				}else{
					$response['file_path'] = $file_upload_url . basename($_FILES['bukti_pembayaran']['name']);
					$bukti_pembayaran = $file_upload_url . basename($_FILES['bukti_pembayaran']['name']);
					$stmt = $mysqli->query("update tbl_transaksi_pembayaran set tujuan_pembayaran='".$obj->tujuan_pembayaran."',pemilik_rekening='".$obj->pemilik_rekening."',
					nomor_rekening='".$obj->nomor_rekening."',nama_bank='".$obj->nama_bank."',jumlah_dibayar='".$obj->jumlah_dibayar."',bukti_pembayaran='".$bukti_pembayaran."',
					waktu_transfer='".$obj->waktu_transfer."' where id_transaksi='".$obj->id_transaksi."' ");
					$data = array();
					if($stmt){
						$result = gettransaksiDetail($obj->id_transaksi);
					}else{
						$result = array(
							"success" => false,
							"message" => "Something wrong when updating data"
						);
					}
				}
			} catch (Exception $e) {
				// Exception occurred. Make error flag true
				$result = array(
					"success" => false,
					"message" => $e->getMessage()
				);
			}
		}else{
			$result = array(
					"success" => false,
					"message" => "No file detected, please upload photo"
				);
		}
		return $result;
	}
	function posttransaksiConfirm2(){
		global $mysqli;
		
		if (isset($_FILES['bukti_pembayaran']['name'])) {
			$file_upload_url = 'img/produk/';
			$target_path = "../img/produk/";
			$target_path = $target_path . basename($_FILES['bukti_pembayaran']['name']);
		 
			// reading other post parameters
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$website = isset($_POST['website']) ? $_POST['website'] : '';
		 
			$response['file_name'] = basename($_FILES['bukti_pembayaran']['name']);
			try {
				// Throws exception incase file is not being moved
				if (!move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_path)) {
					// make error flag true
					$result = array(
						"success" => false,
						"message" => "Could not move the file!"
					);
				}else{
					$response['file_path'] = $file_upload_url . basename($_FILES['bukti_pembayaran']['name']);
					$bukti_pembayaran = $file_upload_url . basename($_FILES['bukti_pembayaran']['name']);
					$stmt = $mysqli->query("update tbl_transaksi_pembayaran set tujuan_pembayaran='".$_POST['tujuan_pembayaran']."',pemilik_rekening='".$_POST['pemilik_rekening']."',
					nomor_rekening='".$_POST['nomor_rekening']."',nama_bank='".$_POST['nama_bank']."',jumlah_dibayar='".$_POST['jumlah_dibayar']."',bukti_pembayaran='".$bukti_pembayaran."',
					waktu_transfer='".$_POST['waktu_transfer']."' where id_transaksi='".$_POST['id_transaksi']."' ");
					$data = array();
					if($stmt){
						$result = gettransaksiDetail($_POST['id_transaksi']);
					}else{
						$result = array(
							"success" => false,
							"message" => "Something wrong when updating data"
						);
					}
				}
			} catch (Exception $e) {
				// Exception occurred. Make error flag true
				$result = array(
					"success" => false,
					"message" => $e->getMessage()
				);
			}
		}else{
			$result = array(
					"success" => false,
					"message" => "No file detected, please upload photo"
				);
		}
		return $result;
	}
	
	function posttransaksiCheckout($obj){
		global $mysqli;
		//UNTUK TRANSAKSI
		$invoice_transaksi = generate_trans_invoice();
		$nama_penerima = $obj->nama_penerima;
		$tanggal_transaksi = date("Y-m-d H:i:s");
		$kode_unik = generate_trans_code();
		$diskon_transaksi = 0;
		
		$total_transaksi = 0;		
		$user = getDataByCollumn("tbl_users","id_users",$obj->id_users)->fetch_object();
		$stmt_keranjang = getDataByCollumn('tbl_keranjang','ip_customer',$obj->id_users);
		if($stmt_keranjang){
			while($data_transaksi = $stmt_keranjang->fetch_object()){
				if($user->status_akun == "distributor" OR getCartQty($id_users)>=250){
					$harga = (getProdukHargaDistributor($data_transaksi->id_produk));											
				}else if($user->status_akun == "reseller" OR $user->status_akun == "agen"){
					$harga = (getProdukHarga($data_transaksi->id_produk));
				}		
				$total_transaksi = $total_transaksi+($harga*$data_transaksi->qty);
			}
		}
		
		$email = $obj->email_penerima;
		//UNTUK TRANSAKSI PENGIRIMAN
		$nama_penerima = $obj->nama_penerima;
		$metode_pengiriman = $obj->layanan_kirim;
		$biaya_pengiriman = $obj->ongkos_kirim;
		$alamat_pengiriman = $obj->alamat_penerima;
		$provinsi_pengiriman = $obj->alamat_provinsi;
		$kota_pengiriman = $obj->alamat_kota;
		$kode_pos = $obj->alamat_pos;
		$telepon_pengiriman = $obj->telepon_penerima;
		$catatan_pengiriman = $obj->pengiriman_catatan;
		//UNTUK TRANSAKSI PEMBAYARAN
		$metode_pembayaran = $obj->metode_pembayaran;
		$status_pembayaran = 'menunggu pembayaran';
		//UNTUK TRANSAKSI STATUS
		$tanggal_transaksi = date("Y-m-d H:i:s");
		$status_transaksi = 'pending';
		$id_users = $obj->id_users;
		
		$sql_transaksi = "INSERT INTO tbl_transaksi(id_users,invoice_transaksi,atas_nama,tanggal_transaksi,kode_unik,diskon_transaksi,total_transaksi,email)
		VALUES($id_users,'$invoice_transaksi','$nama_penerima','$tanggal_transaksi',$kode_unik,$diskon_transaksi,$total_transaksi,'$email')";
		$stmt_transaksi = $mysqli->query($sql_transaksi);
		if($stmt_transaksi){
			$stmt = getDataByCollumn('tbl_transaksi','invoice_transaksi',$invoice_transaksi);
			if($stmt->num_rows > 0){
				$data_transaksi = $stmt->fetch_object();
				$id_transaksi = $data_transaksi->id_transaksi;
				$stmt_pengiriman = $mysqli->query("INSERT INTO tbl_transaksi_pengiriman(id_transaksi,metode_pengiriman,biaya_pengiriman,nama_penerima,alamat_pengiriman,provinsi_pengiriman,kota_pengiriman,kode_pos,telepon_pengiriman,catatan_pengiriman)
				VALUES($id_transaksi,'$metode_pengiriman',$biaya_pengiriman,'$nama_penerima','$alamat_pengiriman','$provinsi_pengiriman','$kota_pengiriman','$kode_pos','$telepon_pengiriman','$catatan_pengiriman')");
				if($stmt_pengiriman){
					$stmt_pembayaran = $mysqli->query("insert into tbl_transaksi_pembayaran(id_transaksi,metode_pembayaran,status_pembayaran)
					VALUES($id_transaksi,'$metode_pembayaran','$status_pembayaran')");
					if($stmt_pembayaran){
						$stmt_status = $mysqli->query("insert into tbl_transaksi_status(id_transaksi,tanggal,status_transaksi,keterangan)
						VALUES($id_transaksi,'$tanggal_transaksi','PENDING','Pesanan kami terima, menunggu konfirmasi pembayaran')");						
						if($stmt_pembayaran){
							$stmt_keranjang = getDataByCollumn('tbl_keranjang','ip_customer',$id_users);
							if($stmt_keranjang){
								while($data_transaksi = $stmt_keranjang->fetch_object()){
									$data_produk = getDataByCollumn('tbl_produk','id_produk',$data_transaksi->id_produk)->fetch_object();
									$nama_produk = $data_produk->nama_produk;
									$isi_produk = $data_produk->id_produk;
									$qty = $data_transaksi->qty;
									
									if($user->status_akun == "distributor" OR getCartQty($id_users)>=250){
										$harga = (getProdukHargaDistributor($data_transaksi->id_produk));											
									}else if($user->status_akun == "reseller" OR $user->status_akun == "agen"){
										$harga = (getProdukHarga($data_transaksi->id_produk));
									}
									
									$harga_produk = $harga*$data_transaksi->qty;
									
									$sql = "insert into tbl_transaksi_detail(id_transaksi,nama_produk,isi_produk,qty,harga_produk)
									VALUES($id_transaksi,'$nama_produk','$isi_produk',$qty,$harga_produk)";
									$keranjang_to_transaksi = $mysqli->query($sql);
									
									if($keranjang_to_transaksi){
										$mysqli->query("DELETE FROM tbl_keranjang WHERE id_keranjang=".$data_transaksi->id_keranjang."");
									}
								}
								kirim_email('PENDING','Pesanan telah kami terima',$invoice_transaksi);
								$status_checkout = array(
									"success" => true,
									"invoice" => $invoice_transaksi,
									"message" => "Success checkout"
								);
							}else{
								$status_checkout = array(
									"success" => false,
									"code" => "checkout-01",
									"message" => "Something wrong when updating data"
								);
							}
						}else{
							$status_checkout = array(
								"success" => false,
								"code" => "checkout-02",
								"message" => "Something wrong when updating data"
							);
						}
					}else{
						$status_checkout = array(
							"success" => false,
							"code" => "checkout-03",
							"message" => "Something wrong when updating data"
						);
					}
				}else{
					$status_checkout = array(
						"success" => false,
						"code" => "checkout-04",
						"message" => "Something wrong when updating data"
					);
				}
			}else{
				$status_checkout = array(
					"success" => false,
					"code" => "checkout-05",
					"message" => "Something wrong when updating data"
				);
			}
		}else{
			$status_checkout = array(
				"success" => false,
				"code" => "checkout-06",
				"message" => "Something wrong when updating data"
			);
		}
		return $status_checkout;
	}
?>