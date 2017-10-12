<?php
	require 'config_db.php';
	function getIpCustomer(){
		$ipaddress = '';
		if(isset($_SESSION['user_login'])){
			$ipaddress = $_SESSION['user_login'];
		}else{
			if (getenv('HTTP_CLIENT_IP')){
				$ipaddress = getenv('HTTP_CLIENT_IP');
			}else if(getenv('HTTP_X_FORWARDED_FOR')){
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			}else if(getenv('HTTP_X_FORWARDED')){
				$ipaddress = getenv('HTTP_X_FORWARDED');
			}else if(getenv('HTTP_FORWARDED_FOR')){
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			}else if(getenv('HTTP_FORWARDED')){
				$ipaddress = getenv('HTTP_FORWARDED');
			}else if(getenv('REMOTE_ADDR')){
				$ipaddress = getenv('REMOTE_ADDR');
			}else{
				$ipaddress = 'IP Tidak Dikenali';
			}				
		}
		return $ipaddress;
	}
	function enkripPassword($value){
		return sha1(md5($value));	
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
	function getPengaturan($nama_pengaturan){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_pengaturan","nama_pengaturan",$nama_pengaturan);
		if($stmt->num_rows > 0){
			return $stmt->fetch_object();
		}else{
			return 0;
		}
	}
	function getDataByCollumn($table_name,$field_name,$value){
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $field_name='$value'");
		return $stmt;		
	}
	function getDataByCondition($table_name,$condition,$order_by){		
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $condition order by $order_by");
		return $stmt;
	}
	function getDataTable($table_name,$order_by){		
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name order by $order_by");
		return $stmt;
	}
	function setHargaRupiah($harga){
		return number_format($harga,0,",",".");
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
	function getProdukHargaDiskon($id_produk){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_produk","id_produk",$id_produk);
		if($stmt->num_rows > 0){
			$data_produk = $stmt->fetch_object();
			$stmt2 = getDataByCondition("tbl_diskon","id_produk=$id_produk AND tipe_diskon ='produk' ","id_diskon");
			if($stmt2->num_rows > 0){
				$data_diskon = $stmt2->fetch_object();
				if($data_diskon->jenis_diskon == '%'){
					$harga_diskon = $data_produk->harga_produk-($data_produk->harga_produk * $data_diskon->jumlah_diskon / 100);
				}else if($data_diskon->jenis_diskon == 'rp'){
					$harga_diskon = $data_produk->harga_produk-$data_diskon->jumlah_diskon;
				}
				return $harga_diskon;
			}else{
				return $data_produk->harga_produk;
			}
		}else{
			return 0;
		}
	}
	function generate(){
	   $karakter = 'ABCDEFGHIJKLMNOPQRSTU1234567890abcdefghijklmnopqrstuvwxyz';
	   $string = '';
	   for($i = 0; $i < 10; $i++) {
	   $pos = rand(0, strlen($karakter)-1);
	   $string .= $karakter{$pos};
	   }
		return $string;
	}
	function getCartQty($ip_customer){
		global $mysqli;
		$jum_qty = $mysqli->query("select sum(qty) as jum_qty from tbl_keranjang where ip_customer='$ip_customer'")->fetch_object();
		return $jum_qty->jum_qty;
	}
	function getCartPrice($ip_customer){
		global $mysqli;
		$keranjang = getDataByCollumn("tbl_keranjang","ip_customer",$ip_customer);
		$grandotal = 0;
		if($keranjang->num_rows > 0){
			$jum_qty = $mysqli->query("select sum(qty) as jum_qty from tbl_keranjang where ip_customer='$ip_customer'")->fetch_object();
			while($data_keranjang = $keranjang->fetch_object()){
				if(isset($_SESSION['user_login'])){
					if($_SESSION['user_status'] == "distributor" OR getCartQty($ip_customer)>=250){
						$harga_produk = (getProdukHargaDistributor($data_keranjang->id_produk))*$data_keranjang->qty;											
					}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
						$harga_produk = (getProdukHarga($data_keranjang->id_produk))*$data_keranjang->qty;											
					}
				}else{
					$harga_produk = (getProdukHargaNonmember($data_keranjang->id_produk))*$data_keranjang->qty;
				}
				$grandotal = $grandotal+$harga_produk;
			}
			return $grandotal;
		}else{
			return 0;
		}
	}
	function getProdukBerat($id_produk){
		$stmt = getDataByCollumn("tbl_produk","id_produk",$id_produk);
		if($stmt->num_rows > 0){
			$data_produk = $stmt->fetch_object();
			return $data_produk->berat_produk;
		}else{
			return 0;
		}
	}
	function addKeranjang($id_produk,$qty,$ip_customer){
		global $mysqli;
		$stmt = getDataByCondition("tbl_keranjang","ip_customer='$ip_customer' AND id_produk=$id_produk","id_produk ASC");
		if($stmt->num_rows>0){
			$stmt = $mysqli->query("UPDATE tbl_keranjang SET qty=(qty+$qty) WHERE ip_customer='$ip_customer' AND id_produk=$id_produk");
			if($stmt){
				return true;
			}else{
				return false;
			}
		}else{
			$stmt = $mysqli->query("INSERT into tbl_keranjang(ip_customer,id_produk,qty) VALUES('$ip_customer',$id_produk,$qty)");
			if($stmt){
				return true;
			}else{
				return false;
			}
		}
	}
	function getKeranjangGrandtotal(){
		if(isset($_SESSION['subtotal'])){
			$subtotal = $_SESSION['subtotal'];			
		}else{
			$subtotal = 0;			
		}
		if(isset($_SESSION['ongkos_kirim']) AND isset($_SESSION['diskon']) AND isset($_SESSION['kode_unik'])){
			$grand = $subtotal+$_SESSION['ongkos_kirim']-$_SESSION['diskon']+$_SESSION['kode_unik'];			
		}else{
			$grand = $subtotal;
		}
		return $grand;
	}
	function setKeranjangDiskon(){
		if(isset($_POST['pakai_kupon'])){
			$stmt = getDataByCondition("tbl_kupon","kode_kupon='".$_POST['kode_kupon']."' AND status_kupon='aktif'","id_kupon ASC");
			$diskon = 0;
			$new_grandtotal = getKeranjangSubtotal();
			if($stmt->num_rows > 0){
				$data_kupon = $stmt->fetch_object();
				$current_grandtotal = getKeranjangSubtotal();
				if($current_grandtotal >= $data_kupon->minimal_belanja){
					if($data_kupon->tipe_potongan == 'rp'){
						$diskon = $data_kupon->jumlah_potongan;
					}else{
						$diskon = ceil($current_grandtotal*$data_kupon->jumlah_potongan/100);
					}
					if($diskon > $data_kupon->maksimal_potongan){
						$diskon = $data_kupon->maksimal_potongan;
					}
					$_SESSION['kode_kupon'] = $_POST['kode_kupon'];
				}else{
					$diskon = 0;
				}
			}else{
				$diskon = 0;
			}			
			unset($_SESSION['diskon']);
			$_SESSION['diskon'] = $diskon;
			return $_SESSION['diskon'];
		}
	}
	function getKeranjangDiskon(){
		if(isset($_SESSION['diskon'])){
			return $_SESSION['diskon'];			
		}else{
			return 0;			
		}
	}
	function getKeranjangKodeUnik(){
		if(isset($_SESSION['kode_unik'])){
			return $_SESSION['kode_unik'];			
		}else{
			return 0;			
		}
	}
	function setKeranjangOngkir(){
		$ongkos_kirim = explode("-",$_POST['ongkir_layanan']);
		unset($_SESSION['ongkos_kirim']);
		$_SESSION['layanan_kirim']= $ongkos_kirim[0];
		$_SESSION['ongkos_layanan']= $ongkos_kirim[1];
		$_SESSION['ongkos_kirim']= $ongkos_kirim[1]*ceil($_SESSION['berat']);
		return $_SESSION['ongkos_kirim'];
	}
	function getKeranjangOngkir(){
		if(isset($_SESSION['ongkos_kirim'])){
			return $_SESSION['ongkos_kirim'];			
		}else{
			return 0;			
		}
	}
	function getKeranjangSubtotal(){
		return $_SESSION['subtotal'];
	}
	function setCheckoutPengiriman(){
		if(isset($_POST['simpan_pengiriman'])){
			$_SESSION['nama_penerima'] = $_POST['nama_penerima'];
			$_SESSION['email_penerima'] = $_POST['email_penerima'];
			$_SESSION['telepon_penerima'] = $_POST['telepon_penerima'];
			$_SESSION['alamat_penerima'] = $_POST['alamat_penerima'];
			$_SESSION['pengiriman_catatan'] = $_POST['pengiriman_catatan'];									
			$_SESSION['ongkir_pos'] = $_POST['ongkir_pos'];									
			$_SESSION['status_pengiriman'] = true;
			setKeranjangOngkir();
		}
		return true;
	}
	function getTransaksiKeterangan($status){
		$keterangan = 'Tidak diketahui';
		switch($status){
			case 'PENDING' : $keterangan = 'Pesanan kami terima, menunggu konfirmasi pembayaran';break;
			case 'CONFIRMED' : $keterangan = 'Customer telah melakukan konfirmasi pembayaran';break;
			case 'PROCESSING' : $keterangan = 'Pembayaran telah kami verifikasi, pesanan akan di proses';break;
			case 'SHIPPED' : $keterangan = 'Pesanan anda sudah kami kirim dan sedang dalam perjalanan';break;
			case 'DONE' : $keterangan = 'Pesanan sudah diterima dan transaksi selesai';break;
			case 'CANCELED' : $keterangan = 'Pesanan dibatalkan';break;
			default : $keterangan = 'Tidak diketahui';break;
		}
		return $keterangan;
	}
	function getTransaksiStatus($status){
		$keterangan = 'Tidak diketahui';
		switch($status){
			case 'PENDING' : $keterangan = '<label class="label label-default">PENDING PAYMENT</label>';break;
			case 'CONFIRMED' : $keterangan = '<label class="label label-warning">CONFIRMED BY ADMIN</label>';break;
			case 'PROCESSING' : $keterangan = '<label class="label label-info">ON PROCESSING</label>';break;
			case 'SHIPPED' : $keterangan = '<label class="label label-primary">SHIPPED BY COURIER</label>';break;
			case 'DONE' : $keterangan = '<label class="label label-success">TRANSACTION DONE</label>';break;
			case 'CANCELED' : $keterangan = '<label class="label label-danger">CANCELED</label>';break;
			default : $keterangan = 'Tidak diketahui';break;
		}
		return $keterangan;
	}
	function setCheckoutFinish(){
		global $mysqli;
		//UNTUK TRANSAKSI
		$_SESSION['invoice_transaksi'] = generate_trans_invoice();
		$invoice_transaksi = $_SESSION['invoice_transaksi'];
		$nama_penerima = $_SESSION['nama_penerima'];
		$tanggal_transaksi = date("Y-m-d H:i:s");
		$kode_unik = getKeranjangKodeUnik();
		$diskon_transaksi = getKeranjangDiskon();
		$total_transaksi = getKeranjangSubtotal();
		$email = $_SESSION['email_penerima'];
		//UNTUK TRANSAKSI PENGIRIMAN
		$nama_penerima = $_SESSION['nama_penerima'];
		$metode_pengiriman = $_SESSION['layanan_kirim'];
		$biaya_pengiriman = $_SESSION['ongkos_kirim'];
		$alamat_pengiriman = $_SESSION['alamat_penerima'];
		$provinsi_pengiriman = $_SESSION['ongkir_provinsi'];
		$kota_pengiriman = $_SESSION['ongkir_kota'];
		$kode_pos = $_SESSION['ongkir_pos'];
		$telepon_pengiriman = $_SESSION['telepon_penerima'];
		$catatan_pengiriman = $_SESSION['pengiriman_catatan'];
		//UNTUK TRANSAKSI PEMBAYARAN
		$metode_pembayaran = $_POST['metode_pembayaran'];
		$status_pembayaran = 'menunggu pembayaran';
		//UNTUK TRANSAKSI STATUS
		$tanggal_transaksi = date("Y-m-d H:i:s");
		$status_transaksi = 'pending';
		if(isset($_SESSION['user_login'])){
			$id_users = $_SESSION['user_login'];
		}else{
			if(isset($_SESSION['link_affiliate'])){
				$non_aff = $_SESSION['link_affiliate'];
			}else{
				$non_aff = "Tidak Ada";
			}
			$sql_nonmember = "insert into tbl_users(display_name,upline,telepon,email,status_akun,link_affiliate) 
			VALUES('$nama_penerima','".$non_aff."','$telepon_pengiriman','$email','nonmember','".$_SESSION['invoice_transaksi']."')";
			$stmt_non = $mysqli->query($sql_nonmember);
			if($stmt_non){
				$get_non = $mysqli->query("select * from tbl_users where link_affiliate='".$_SESSION['invoice_transaksi']."'")->fetch_object();
				$id_users = $get_non->id_users;
			}else{
				$id_users = 0;
			}
		}
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
						VALUES($id_transaksi,'$tanggal_transaksi','PENDING','".getTransaksiKeterangan('PENDING')."')");						
						if($stmt_pembayaran){
							$stmt_keranjang = getDataByCollumn('tbl_keranjang','ip_customer',getIpCustomer());
							if($stmt_keranjang){
								while($data_transaksi = $stmt_keranjang->fetch_object()){
									$data_produk = getDataByCollumn('tbl_produk','id_produk',$data_transaksi->id_produk)->fetch_object();
									$nama_produk = $data_produk->nama_produk;
									$isi_produk = $data_produk->id_produk;
									$qty = $data_transaksi->qty;
									
									if(isset($_SESSION['user_login'])){
										if($_SESSION['user_status'] == "distributor" OR getCartQty(getIpCustomer())>=250){
											$harga = (getProdukHargaDistributor($data_transaksi->id_produk));											
										}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
											$harga = (getProdukHarga($data_transaksi->id_produk));
										}
									}else{
										$harga = (getProdukHargaNonmember($data_transaksi->id_produk));
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
								$status_checkout = 'sukses/'.$invoice_transaksi;								
								
								if(isset($_SESSION['user_login'])){
									$relog[0] = $_SESSION['user_login'];
									$relog[1] = $_SESSION['user_facebook_id'];
									$relog[2] = $_SESSION['user_display_name'];
									$relog[3] = $_SESSION['user_status'];
									$relog[4] = $_SESSION['user_link_affiliate'];
									$relog[5] = $_SESSION['user_upline'];
									$relog[6] = $_SESSION['user_telepon'];
									$relog[7] = $_SESSION['user_foto'];
									session_destroy();
									session_start();
									$_SESSION['user_login'] = $relog[0];
									$_SESSION['user_facebook_id'] = $relog[1];
									$_SESSION['user_display_name'] = $relog[2];
									$_SESSION['user_status'] = $relog[3];
									$_SESSION['user_link_affiliate'] = $relog[4];
									$_SESSION['user_upline'] = $relog[5];
									$_SESSION['user_telepon'] = $relog[6];
									$_SESSION['user_foto'] = $relog[7];
								}else{
									session_destroy();
									session_start();
								}
								
							}else{
								$status_checkout = 'fail/SCF06';
							}
						}else{
							$status_checkout = 'fail/SCF05';
						}
					}else{
						$status_checkout = 'fail/SCF04';
					}
				}else{
					$status_checkout = 'fail/SCF03';
				}
			}else{
				$status_checkout = 'fail/SCF02';
			}
		}else{
			$status_checkout = 'fail/SCF01';
		}
		return $status_checkout;
	}
	function cekNomorInvoice(){
		global $mysqli;
		$stmt = getDataByCollumn("tbl_transaksi",'invoice_transaksi',$_POST['nomor_transaksi']);
		if($stmt->num_rows == 1){
			$data_transaksi = $stmt->fetch_object();			
			$_SESSION['id_transaksi'] = $data_transaksi->id_transaksi;
			$_SESSION['nomor_invoice'] = $data_transaksi->invoice_transaksi;
			return true;
		}else{
			return false;
		}
	}
	function setKonfirmasiPembayaran(){
		global $mysqli;
		$id_transaksi = $_SESSION['id_transaksi'];
		$tujuan_pembayaran = $_POST['tujuan_pembayaran'];
		$atas_nama = $_POST['atas_nama'];
		$nomor_rekening = $_POST['nomor_rekening'];
		$nama_bank = $_POST['nama_bank'];
		$jumlah_dibayar = $_POST['jumlah_dibayar'];
		$waktu_transfer = $_POST['waktu_transfer'];
		$status_pembayaran = "sudah dibayar";
		
		
			$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
			$destination = 'bukti_pembayaran/'; // where our files will be stored
			$file = $_FILES['file_foto'];
			$filename = explode(".", $file["name"]); 
			$file_name = $file['name']; // file original name
			$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
			$file_extension = $filename[count($filename)-1];
			$file_weight = $file['size'];
			$file_type = $file['type'];
			// If there is no error
			if( $file['error'] == 0 ){
				// check if the extension is accepted
				if( in_array(strtolower($file_extension), $ok_ext)){
					// check if the size is not beyond expected size
					// rename the file
					$fileNewName = str_replace(" ","_",strtolower($_SESSION['nomor_invoice'])).'.'.$file_extension ;
					// and move it to the destination folder
					if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
						$foto_path = $destination.$fileNewName;
						$stmt = $mysqli->query("UPDATE tbl_transaksi_pembayaran SET tujuan_pembayaran='$tujuan_pembayaran',pemilik_rekening='$atas_nama',waktu_transfer='$waktu_transfer',nomor_rekening='$nomor_rekening',
						nama_bank='$nama_bank',jumlah_dibayar='$jumlah_dibayar',bukti_pembayaran='$foto_path',status_pembayaran='$status_pembayaran' WHERE id_transaksi=$id_transaksi ");
						if($stmt){
							$stmt_status = $mysqli->query("insert into tbl_transaksi_status(id_transaksi,tanggal,status_transaksi,keterangan)
							VALUES($id_transaksi,now(),'CONFIRMED','".getTransaksiKeterangan('CONFIRMED')."')");			
							kirim_email('CONFIRMED','Konfirmasi pembayaran telah kami terima',$id_transaksi);
							return 'sukses';
						}else{
							return "fail-gagal saat menyimpan data, silahkan hubungi admin kami";												
						}
					}else{
						return "fail-gagal menyimpan file yang anda upload, maksimal upload 2MB";					
					}
				}else{
					return "fail-eksentsi file yang anda pakai tidak didukung, silahkan upload dengan ekstensi jpg,png,jpeg";
				}
			}else{
				return "fail-ada kesalahan pada foto yang anda upload";
			}
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
		
		switch($status){
			case 'PENDING' : $status_pesanan = '<label style="background-color: #777;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			case 'CONFIRMED' : $status_pesanan = '<label style="background-color: #f0ad4e;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			case 'PROCESSING' : $status_pesanan = '<label style="background-color: #5bc0de;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			case 'SHIPPED' : $status_pesanan = '<label style="background-color: #337ab7;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			case 'DONE' : $status_pesanan = '<label style="background-color: #5cb85c;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			case 'CANCELED' : $status_pesanan = '<label style="background-color: #d9534f;color: white;padding: 5px;">'.$status.' - '.getTransaksiKeterangan($status).'</label>';break;
			default : $status_pesanan = 'Tidak diketahui';break;
		}
		
		$logo_web = 'http://pinopi.com/'.getPengaturan('logo')->value_pengaturan;
		$email_keranjang_nama[0] = "asdasd";
		$email_keranjang_qty[0] = "2";
		$email_keranjang_nama[1] = "asdasd";
		$email_keranjang_qty[1] = "2";

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
			
			require_once('library/email/function.php');
		
			$to       = $data_transaksi->email;
			$subject  = $judul_email;
			$message  = $isi_email.$isi_email2.$isi_email3;
			smtp_mail($to, $subject, $message, '', '', 0, 0, true);

	}
	function upload_foto($destination_foto,$file_foto,$nama_foto){
		
			$ok_ext = array('jpg','png','jpeg'); // allow only these types of files
			$destination = $destination_foto; // where our files will be stored
			$file = $file_foto;
			$filename = explode(".", $file["name"]); 
			$file_name = $file['name']; // file original name
			$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
			$file_extension = $filename[count($filename)-1];
			$file_weight = $file['size'];
			$file_type = $file['type'];
			// If there is no error
			if( $file['error'] == 0 ){
				// check if the extension is accepted
				if( in_array(strtolower($file_extension), $ok_ext)){
					// check if the size is not beyond expected size
					// rename the file
					$fileNewName = str_replace(" ","_",strtolower($nama_foto)).'.'.$file_extension ;
					// and move it to the destination folder
					if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
//						$foto_path = $destination.$fileNewName;
						return $fileNewName;
					}else{
						return "gagal menyimpan file yang anda upload, maksimal upload 2MB";					
					}
				}else{
					return "eksentsi file yang anda pakai tidak didukung, silahkan upload dengan ekstensi jpg,png,jpeg";
				}
			}else{
				return "ada kesalahan pada foto yang anda upload";
			}

	}
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	function getStatusTransaksi($id_transaksi){
		global $mysqli;
		$stmt = getDataByCondition("tbl_transaksi_status","id_transaksi=$id_transaksi","tanggal DESC")->fetch_object();
		return $stmt;
	}
	
	function setBonusTransaksi($id_transaksi){
		global $mysqli;
		$data = getDataByCollumn("tbl_transaksi","id_transaksi",$id_transaksi)->fetch_object();
		//AWAL SETTING NILAI BONUS YANG DIBERIKAN
		$max_upline = 10;
		$bonus_sponsor = 2000;
		$bonus_retail_distributor = 2000;
		$bonus_retail = 3000;
		$bonus_jaringan = 300;
		$min_distributor = 250;
		//AKHIR SETTING NILAI BONUS YANG DIBERIKAN
		
		$sql_users = "select * from tbl_users where id_users=".$data->id_users;
		$sql_transaksi = "select * from tbl_transaksi_detail where id_transaksi=".$id_transaksi;
		$sql_jum_item = "select sum(qty) as jum from tbl_transaksi_detail where id_transaksi=".$id_transaksi;
		$pembeli = $mysqli->query($sql_users)->fetch_object();
		$stmt_jum_transaksi = $mysqli->query($sql_jum_item)->fetch_object();

		$penjual = "";
		$upline = getDataByCollumn("tbl_users","link_affiliate",$pembeli->upline);			
		if($upline->num_rows > 0){
			$penjual = $upline->fetch_object();
		}
		//MENGAMBIL YANG MENDAFTARKAN PEMBELI
		$didaftarkan = "";
		$pendaftar = getDataByCollumn("tbl_users","link_affiliate",$pembeli->register_by);			
		if($pendaftar->num_rows > 0){
			$didaftarkan = $pendaftar->fetch_object();
		}

		$id_upline = $pembeli->upline;
		//BONUS JARINGAN
		for($i=0;$i<$max_upline;$i++){			
			$s = "select * from tbl_users where link_affiliate = '$id_upline'";
			$upline = $mysqli->query($s);			
			if($upline->num_rows > 0){
				$data_upline = $upline->fetch_object();
				//JIKA AUTO PROMO USER AKTIF, MAKA DAPAT BONUS
				$promo = getDataByCollumn("tbl_promo_fb","id_users",$data_upline->id_users)->fetch_object();				
				if($promo->status_promo == "aktif" ){
					$stmt_transaksi = $mysqli->query($sql_transaksi);
					while($data_transaksi = $stmt_transaksi->fetch_object()){
						$produk = getDataByCollumn("tbl_produk","id_produk",$data_transaksi->isi_produk)->fetch_object();

						if($data_upline->status_akun == "reseller"){
							$jumlah_bonus = ($produk->bonus_jaringan*$data_transaksi->qty)/2;						
							$jumlah_bonus_pending = ($produk->bonus_jaringan*$data_transaksi->qty)/2;
						}else{
							$jumlah_bonus = $produk->bonus_jaringan*$data_transaksi->qty;						
							$jumlah_bonus_pending = 0;
						}						
						$keterangan = $penjual->display_name." menjual ".$data_transaksi->qty." produk ".$produk->nama_produk." ke ".$pembeli->display_name;
						$sql_in_bonus = "update tbl_users set saldo=(saldo+".$jumlah_bonus."),saldo_pending=(saldo_pending+".$jumlah_bonus_pending.") where id_users=".$data_upline->id_users."";
						$insert_bonus = $mysqli->query($sql_in_bonus);
						if($insert_bonus){
							$mysqli->query("insert into tbl_users_bonus(id_users,tanggal,tipe_bonus,jumlah_bonus,keterangan) VALUES(".$data_upline->id_users.",'".date("Y-m-d H:i:s")."','jaringan',".($jumlah_bonus+$jumlah_bonus_pending).",'$keterangan')");
						}
					}	
				}
				$id_upline = $data_upline->upline;
			}else{
				$i=10;
			}
		}
		//BONUS PENJUALAN
		if($didaftarkan->status_akun == "distributor" AND $pembeli->status_akun != "distributor" AND $pembeli->status_akun != "agen" AND $stmt_jum_transaksi->jum >= $min_distributor){
			
			//JIKA AUTO PROMO USER AKTIF, MAKA DAPAT BONUS
			$promo = getDataByCollumn("tbl_promo_fb","id_users",$didaftarkan->id_users)->fetch_object();				
			if($promo->status_promo == "aktif" ){
				$jumlah_bonus = $bonus_sponsor*$stmt_jum_transaksi->jum;
				$keterangan = $didaftarkan->display_name." menjual paket distributor ke ".$pembeli->display_name;
				$sql_in_bonus = "update tbl_users set saldo=(saldo+".$jumlah_bonus.") where id_users=".$didaftarkan->id_users."";
				$insert_bonus = $mysqli->query($sql_in_bonus);
				if($insert_bonus){
					$mysqli->query("insert into tbl_users_bonus(id_users,tanggal,tipe_bonus,jumlah_bonus,keterangan) VALUES(".$didaftarkan->id_users.",'".date("Y-m-d H:i:s")."','penjualan',$jumlah_bonus,'$keterangan')");
				}				
			}
		}
		//BONUS RETAIL
		if($penjual->status_akun != "nonmember" AND $pembeli->status_akun == "nonmember"){
			//JIKA AUTO PROMO USER AKTIF, MAKA DAPAT BONUS
			$promo = getDataByCollumn("tbl_promo_fb","id_users",$penjual->id_users)->fetch_object();				
			if($promo->status_promo == "aktif" ){
				$bonus_retail_final = 0;
				$stmt_transaksi = $mysqli->query($sql_transaksi);
				while($data_transaksi = $stmt_transaksi->fetch_object()){
					$produk = getDataByCollumn("tbl_produk","id_produk",$data_transaksi->isi_produk)->fetch_object();

					if($penjual->status_akun == "distributor"){
						$bonus_retail_final = $bonus_retail_final+(($produk->bonus_retail+$produk->bonus_distributor)*$data_transaksi->qty);						
					}else if($penjual->status_akun == "reseller" or $penjual->status_akun == "agen"){
						$bonus_retail_final = $bonus_retail_final+$produk->bonus_retail*$data_transaksi->qty;						
					}
				}
				$jumlah_bonus = $bonus_retail_final;
				$jumlah_bonus_pending = 0;
				$keterangan = $penjual->display_name." menjual ".$stmt_jum_transaksi->jum." produk ke ".$pembeli->display_name;
				if($penjual->status_akun == "reseller"){
					$jumlah_bonus = $jumlah_bonus/2;					
					$jumlah_bonus_pending = $jumlah_bonus;
				}else{
					$jumlah_bonus = $jumlah_bonus;						
					$jumlah_bonus_pending = 0;
				}
				$sql_in_bonus = "update tbl_users set saldo=(saldo+".$jumlah_bonus."),saldo_pending=(saldo_pending+".$jumlah_bonus_pending.") where id_users=".$penjual->id_users."";
				$insert_bonus = $mysqli->query($sql_in_bonus);
				$sql_his_bonus = "insert into tbl_users_bonus(id_users,tanggal,tipe_bonus,jumlah_bonus,keterangan) VALUES(".$penjual->id_users.",'".date("Y-m-d H:i:s")."','retail',".($jumlah_bonus+$jumlah_bonus_pending).",'$keterangan')";
				if($insert_bonus){
					$mysqli->query($sql_his_bonus);
				}
			}
		}
		//CEK JIKA USER MASIH RESELLER MAKA UBAH KE AGEN/DISTRIBUTOR JIKA BELI LEBIH DARI 250
		if($pembeli->status_akun == "reseller" and $stmt_jum_transaksi->jum >= $min_distributor){
			$start_date = new DateTime(date("Y-m-d H:i:s"));
			$end_date = new DateTime($pembeli->created_at);
			$interval = $start_date->diff($end_date);
			if($interval->days <= 7){
				$mysqli->query("update tbl_users set status_akun='distributor' where id_users=".$pembeli->id_users);
			}else{
				$mysqli->query("update tbl_users set status_akun='distributor' where id_users=".$pembeli->id_users);
			}
		}
	}
	function cRes($user){
		global $mysqli;
		//die ($query);	
		$stmt = $mysqli->query("select count(*) 
									as referral_count from tbl_users where upline = '".$user."' and status_akun='reseller'");
		echo $mysqli->error;
		return $stmt->fetch_row()[0];
	}
	function cAg($user){
		global $mysqli;
		//die ($query);	
		$stmt = $mysqli->query("select count(*) 
									as referral_count from tbl_users where upline = '".$user."' and status_akun='agen'");
		echo $mysqli->error;
		return $stmt->fetch_row()[0];
	}
	function cDis($user){
		global $mysqli;
		//die ($query);	
		$stmt = $mysqli->query("select count(*) 
									as referral_count from tbl_users where upline = '".$user."' and status_akun='distributor'");
		echo $mysqli->error;
		return $stmt->fetch_row()[0];
	}

	function displayTree(){
		global $mysqli;
		if (cRes($_SESSION['user_link_affiliate']) == 0 && cAg($_SESSION['user_link_affiliate']) == 0 && cDis($_SESSION['user_link_affiliate']) == 0) {
			echo '
			  <tr>      
			  <td colspan="3" style="color:red;">Anda Belum Memiliki Jaringan</td>
			  </tr>';
		} else {
			$generasi = 1;
			$max_gen = 10;
			$cur_gen = 10;
			$link_aff = $_SESSION['user_link_affiliate'];
			echo '<tr>      
			  <td style="color:green;">Tim bisnis ke - '.$generasi.'</td>
			  <td style="text-align:center">'.cRes($link_aff).' orang</td>
			  <td style="text-align:center">'.cAg($link_aff).' orang</td>
			  <td style="text-align:center">'.cDis($link_aff).' orang</td>
			</tr>';
			$generasi++;
			while ($generasi!=0){
				$stmt = $mysqli->query("select link_affiliate FROM tbl_users WHERE upline='".$link_aff."'");
				if ($stmt->num_rows>0) {
					$user = 0;
					$enterpreneur = 0;
					$distributor = 0;
					while ($data = $stmt->fetch_object()){
						  $link_aff = $data->link_affiliate;
						  echo $mysqli->error;
							$user = $user+cRes($link_aff);
							$enterpreneur = $enterpreneur+cAg($link_aff);
							$distributor = $distributor+cDis($link_aff);
					}
					if($user != 0 OR $enterpreneur != 0 OR $distributor != 0){
						echo '<tr>      
							  <td style="color:green;">Tim bisnis ke - '.$generasi.'</td>
							  <td style="text-align:center">'.$user.' orang</td>
							  <td style="text-align:center">'.$enterpreneur.' orang</td>
							  <td style="text-align:center">'.$distributor.' orang</td>
						  </tr>';				        
					}
					$generasi++;
				} else {
					$cur_gen = $generasi;
					$generasi=0;
				}		
			}
			for($i=($cur_gen-1);$i<=$max_gen;$i++){
				echo '<tr>      
				  <td style="color:red;">Tim bisnis ke - '.$i.'</td>
				  <td style="text-align:center">0 orang</td>
				  <td style="text-align:center">0 orang</td>
				  <td style="text-align:center">0 orang</td>
			  </tr>';
			}
		}
	}	
	
	
	
	
	
	
	
	
	
?>