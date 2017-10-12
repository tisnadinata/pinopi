<?php
	include_once 'config/config_modul.php';
	
	if(isset($_POST['tambah_keranjang'])){
		$data_paket = explode("/",$_POST['tambah_keranjang']);
		if(addKeranjang($data_paket[0],$data_paket[1],getIpCustomer())){
			echo "success";
		}else{
			echo "fail";
		}
	}
	if(isset($_POST['hapus_keranjang'])){
		$stmt = $mysqli->query("DELETE FROM tbl_keranjang WHERE id_keranjang=".$_POST['hapus_keranjang']."");
		if($stmt){
			echo "success";
		}else{
			echo "fail";
		}
	}
	if(isset($_POST['pakai_kupon'])){
		$stmt = getDataByCondition("tbl_kupon","kode_kupon='".$_POST['pakai_kupon']."' AND status_kupon='aktif'","id_kupon ASC");
		$diskon = 0;
		$new_grandtotal = getKeranjangGrandtotal();
		if($stmt->num_rows > 0){
			$data_kupon = $stmt->fetch_object();
			$current_grandtotal = getKeranjangGrandtotal();
			if($current_grandtotal >= $data_kupon->minimal_belanja){
				if($data_kupon->tipe_potongan == 'rp'){
					$diskon = $data_kupon->jumlah_potongan;
				}else{
					$diskon = ceil($current_grandtotal*$data_kupon->jumlah_potongan/100);
				}
			}else{
				$diskon = 0;
			}
		}else{
			$diskon = 0;
		}
		unset($_SESSION['diskon']);
		$_SESSION['diskon'] = $diskon;
		echo setHargaRupiah($_SESSION['diskon']);
	}
	if(isset($_POST['ongkir_provinsi'])){
		$province = explode("-",$_POST['ongkir_provinsi']);
		$_SESSION['ongkir_provinsi'] = $province[1];
		$json = json_decode(file_get_contents("http://pro.rajaongkir.com/api/city?key=27c5b41cc910c78ca7b3445b897b56a0&province=$province[0]"));
		$json = ($json->rajaongkir);
		echo "<option>Pilih Kota</option>";
		for($i = 0;$i<count($json->results);$i++){
			?>
				<option value="<?php echo $json->results[$i]->city_id.'-'.$json->results[$i]->type.' '.$json->results[$i]->city_name;?>"><?php echo $json->results[$i]->type.' '.$json->results[$i]->city_name;?></option>		
			<?php		
		}
	}
	if(isset($_POST['ongkir_kota'])){
		$kota = explode("-",$_POST['ongkir_kota']);
		$_SESSION['ongkir_kota'] = $kota[1];
		$json = json_decode(file_get_contents("http://pro.rajaongkir.com/api/city?key=27c5b41cc910c78ca7b3445b897b56a0&id=$kota[0]"));
		$json = ($json->rajaongkir);
		echo $json->results->postal_code;		
	}
	if(isset($_POST['ongkir_layanan'])){
		$kota = explode("-",$_POST['ongkir_layanan']);
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=152&originType=city&destination=".$kota[0]."&destinationType=city&weight=1000&courier=jne",
		  CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: 27c5b41cc910c78ca7b3445b897b56a0"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		$json = '';
		if ($err) {
		  $json = "cURL Error #:" . $err;
		} else {
		  $json = json_decode($response);
		}	
		echo "<option>Pilih Layanan JNE</option>";
		for($i=0;$i<count($json->rajaongkir->results[0]->costs);$i++){
			$result = $json->rajaongkir->results[0]->costs[$i];
			$cost = $result->cost[0];
			?>
				<option value="<?php echo$result->service.'-'.$cost->value;?>"><?php echo$result->service.' - Rp'.setHargaRupiah($cost->value).' per 1kg';?></option>		
			<?php		
		}
	}
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>