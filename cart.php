<script>
	function hapus_keranjang(id_keranjang){
		var dataString = 'hapus_keranjang='+id_keranjang;
		$.ajax({
			type: "POST",
			url: "<?php echo $url_web;?>/ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				if(html == 'success'){
					alert("Produk berhasil dihapus dari keranjang anda :)")
					window.location.reload()
				}else{
					alert("Maaf, produk gagal dihapus dari keranjang anda :(")
					alert(html);
				}
			}
		});
	}
	function pakai_kupon(){		
		var dataString = 'pakai_kupon='+document.getElementById("kode_kupon").value;
		alert(dataString);
		$.ajax({
			type: "POST",
			url: "<?php echo $url_web;?>/ajax.php",
			data: dataString,
			cache: false,  
			success: function(html) {
				alert(html);
				if(html != '0'){
					document.getElementById('diskon_sukses').style.visibility='visible';
					document.getElementById('diskon_fail').style.visibility='hidden';
					document.getElementById('diskon_potongan').innerHTML = html;
				}else{
					document.getElementById('diskon_sukses').style.visibility='hidden';
					document.getElementById('diskon_fail').style.visibility='visible';
				}
				refresh_cart();					
			}
		});
	}
	function refresh_cart(){
		document.getElementById("ongkos_kirim").innerHTML = '<?php echo setHargaRupiah(getKeranjangOngkir());?>';
		alert('<?php echo setHargaRupiah(getKeranjangOngkir());?>');
		document.getElementById("diskon").innerHTML = '<?php echo setHargaRupiah(getKeranjangDiskon());?>';
		alert('<?php echo setHargaRupiah(getKeranjangDiskon());?>');
		document.getElementById("grand_total").innerHTML = '<?php echo setHargaRupiah(getKeranjangGrandtotal());?>';
		alert('<?php echo setHargaRupiah(getKeranjangGrandtotal());?>');
	}
	function set_ongkir_provinsi(provinsi){
		var dataString = 'ongkir_provinsi='+provinsi;
		$.ajax({
			type: "POST",
			url: "<?php echo $url_web;?>/ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				document.getElementById('ongkir_kota').innerHTML = html;
			}
		});
	}
	function set_ongkir_kota(kota){
		var dataString = 'ongkir_kota='+kota;
		$.ajax({
			type: "POST",
			url: "<?php echo $url_web;?>/ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				document.getElementById('ongkir_pos').value = html;
				set_ongkir_layanan(kota);
			}
		});
	}
	function set_ongkir_layanan(kota){
		var dataString = 'ongkir_layanan='+kota;
		$.ajax({
			type: "POST",
			url: "<?php echo $url_web;?>/ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {
				document.getElementById('ongkir_layanan').innerHTML = html;
			}
		});
	}
	
</script>
<?php
	if(!isset($_SESSION['ongkos_kirim'])){
		$_SESSION['ongkos_kirim'] = 0;
	}
	if(!isset($_SESSION['diskon'])){
		$_SESSION['diskon'] = 0;
	}
	$_SESSION['berat'] = 0;
	if(!isset($_SESSION['kode_unik'])){
		$_SESSION['kode_unik'] = generate_trans_code();
	}
	$_SESSION['subtotal'] = 0;
?>
                <div class="information-blocks">
					<?php
						if(isset($_POST['update_keranjang'])){
							$qty = $_POST['qty'];
							$sukses=0;
							$id_keranjang = $_POST['id_keranjang'];
							for($i=0;$i<$_POST['banyak_keranjang'];$i++){
								$stmt = $mysqli->query("UPDATE tbl_keranjang SET qty=".$qty[$i]." WHERE id_keranjang=".$id_keranjang[$i]."");								
								if($stmt){
									$sukses++;
								}
							}
							if($sukses == $_POST['banyak_keranjang']){
								echo'
									<div class="message-box message-success">
										<div class="message-icon"><i class="fa fa-check"></i></div>
										<div class="message-text"><b>Selamat!</b> Data paket keranjang anda berhasil diperbaharui.</div>
										<div class="message-close"><i class="fa fa-times"></i></div>
									</div>                    
								';
							}else{
								echo'
									<div class="message-box message-danger">
										<div class="message-icon"><i class="fa fa-remove"></i></div>
										<div class="message-text"><b>Maaf!</b> Data paket keranjang anda gagal diperbaharui. :(</div>
										<div class="message-close"><i class="fa fa-times"></i></div>
									</div>                    
								';
							}
						}
					?>
					<form action="" method="post">
                    <div class="table-responsive">
                        <table class="cart-table">
                            <tr>
                                <th class="column-1">Nama Paket</th>
                                <th class="column-3">Harga Satuan</th>
                                <th class="column-2">Qty</th>
                                <th class="column-4">Subtotal</th>
                                <th class="column-5"></th>
                            </tr>
							<?php 
								$keranjang = getDataByCollumn("tbl_keranjang","ip_customer",getIpCustomer());
								$grandtotal = 0;
								if($keranjang->num_rows > 0){
									$i = 0;
									echo '<input type="hidden" name="banyak_keranjang" value="'.$keranjang->num_rows.'"/>';
									while($data_keranjang = $keranjang->fetch_object()){
										$data_produk = getDataByCollumn("tbl_produk","id_produk",$data_keranjang->id_produk)->fetch_object();
										if(isset($_SESSION['user_login'])){
											if($_SESSION['user_status'] == "distributor" OR getCartQty(getIpCustomer())>=250){
												$harga = (getProdukHargaDistributor($data_keranjang->id_produk));											
											}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
												$harga = (getProdukHarga($data_keranjang->id_produk));
											}
										}else{
											$harga = (getProdukHargaNonmember($data_keranjang->id_produk));
										}
										$harga_produk = $harga*$data_keranjang->qty;
										$_SESSION['subtotal'] = $_SESSION['subtotal']+$harga_produk;
										$_SESSION['berat'] = $_SESSION['berat']+ceil(getProdukBerat($data_produk->id_produk)*$data_keranjang->qty)/1000;
								?> 
										<tr>
											<td>
												<input type="hidden" name="id_keranjang[<?php echo $i ?>]" value="<?php echo $data_keranjang->id_keranjang; ?>"/>
												<div class="traditional-cart-entry">
													<a target="_blank" style="width: 140px;margin-right: 10px;" href="<?php echo $url_web.'/paket/'.strtolower(str_replace(" ","-",$data_produk->nama_produk));?>"class="image"><img src="<?php echo $url_web.'/'.$data_produk->url_foto; ?>" alt=""></a>
													<div class="content">
														<div class="cell-view">
															<a target="_blank" href="<?php echo $url_web.'/paket/'.strtolower(str_replace(" ","-",$data_produk->nama_produk));?>" class="title"><?php echo $data_produk->nama_produk; ?></a>
															<div class="inline-description"><?php echo "Berat Paket : ".getProdukBerat($data_produk->id_produk)." gram"; ?></div>
														</div>
													</div>
												</div>
											</td>
											<td>Rp<?php echo setHargaRupiah($harga); ?></td>
											<td>
												<div class="quantity-selector detail-info-entry">
													<input type="number" min="1" style="width:50px;" class="entry number" name="qty[<?php echo $i ?>]" value="<?php echo $data_keranjang->qty; ?>"/>
												</div>
											</td>
											<td><div class="subtotal">Rp<?php echo setHargaRupiah($harga_produk); ?></div></td>
											<td><a onclick="hapus_keranjang(<?php echo $data_keranjang->id_keranjang; ?>)" class="button style-17">HAPUS</a></td>
										</tr>
								<?php 
										$i++;
									}
							?> 
							<?php 
								}else{
									echo "Belum ada produk yang anda inginkan :(";
								}
							?>       
                        </table>
                    </div>
                    <div class="cart-submit-buttons-box">
                        <a href="paket" class="button style-3">LANJUTKAN BELANJA</a>
                        <button type="submit" name="update_keranjang" class="button style-3">PERBAHARUI KERANJANG</button>
                    </div>
					</form>
                    <div class="row">
                        <div class="col-md-4 information-entry">
 							<form action=""  method="post">
                            <h3 class="cart-column-title">LIHAT ESTIMASI ONGKOS KIRIM</h3>
                                <label>Nama Provinsi</label>
                                <div class="simple-drop-down simple-field size-1">
                                    <select id="ongkir_provinsi" name="ongkir_provinsi" onchange="set_ongkir_provinsi(this.value)">
										<option>Pilih Provinsi</option>
									<?php
										$json = json_decode(file_get_contents("http://pro.rajaongkir.com/api/province?key=27c5b41cc910c78ca7b3445b897b56a0"));
										$json = ($json->rajaongkir);
										for($i = 0;$i<count($json->results);$i++){
											?>
												<option value="<?php echo $json->results[$i]->province_id.'-'.$json->results[$i]->province;?>"><?php echo $json->results[$i]->province;?></option>		
											<?php
										}
									?>                                        
                                    </select>
                                </div>
                                <label>Nama Kota/Kabupaten</label>
                                <div class="simple-drop-down simple-field size-1">
                                    <select id="ongkir_kota" name="ongkir_kota" onchange="set_ongkir_kota(this.value)">
										<option>Pilih Provinsi Dulu</option>
                                    </select>
                                </div>
                                <label>Kode Pos(Ubah jika tidak sesuai)</label>
                                <input type="text" value="" placeholder="Zip Code" id="ongkir_pos" name="ongkir_pos" class="simple-field size-1">
                                <label>Jenis Layanan</label>
                                <div class="simple-drop-down simple-field size-1">
                                    <select id="ongkir_layanan" name="ongkir_layanan">
										<option>Pilih Kota Dulu</option>
                                    </select>
                                </div>
								<div>
								<?php
									if(isset($_POST['hitung_ongkos'])){
										if(setKeranjangOngkir() > 0){
											echo'
												<div class="message-box message-success">
													<div class="message-icon"><i class="fa fa-check"></i></div>
													<div class="message-text"><b>Selamat!</b> ongkos kirim ke lokasi adalah <b>Rp<i id="diskon_potongan">'.setHargaRupiah($_SESSION['ongkos_kirim']).'</i></b>.</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}else{
											echo'
												<div class="message-box message-danger">
													<div class="message-icon"><i class="fa fa-remove"></i></div>
													<div class="message-text"><b>Maaf!</b> Perhitungan estimasi gagal, silahkan coba kembali. :(</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}
									}
								?>
								</div>
                                <div class="button style-16 pull-right" style="margin-top: 10px;">HITUNG ONGKOS KIRIM<input type="submit" name="hitung_ongkos"/></div>
							</form>
                        </div>
                        <div class="col-md-4 information-entry">
                            <h3 class="cart-column-title">KODE DISKON <span class="inline-label red">Promosi</span></h3>
 							<form action=""  method="post">
                                <label>Masukan kode kupon/voucher/diskon jika ada opening valentine.</label>
                                <input type="text" name="kode_kupon" id="kode_kupon" placeholder="" class="simple-field size-1">
								<div>
								<?php
									if(isset($_POST['pakai_kupon'])){
										if(setKeranjangDiskon() > 0){
											echo'
												<div class="message-box message-success">
													<div class="message-icon"><i class="fa fa-check"></i></div>
													<div class="message-text"><b>Selamat!</b> Anda mendapat potongan senilai <b>Rp<i id="diskon_potongan">'.setHargaRupiah($_SESSION['diskon']).'</i></b>.</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}else{
											echo'
												<div class="message-box message-danger">
													<div class="message-icon"><i class="fa fa-remove"></i></div>
													<div class="message-text"><b>Maaf!</b> KUPON ANDA SUDAH TIDAK BERLAKU. :(</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}
									}
								?>
								</div>
<!--                                <div class="button style-16 pull-right" style="margin-top: 10px;" onclick="pakai_kupon()">PAKAI KUPON</div>
-->                             <div class="button style-16 pull-right" style="margin-top: 10px;" >PAKAI KUPON<input type="submit" name="pakai_kupon" /></div>
							</form>
                        </div>
                        <div class="col-md-4 information-entry">
                            <div class="cart-summary-box">
                                <div class="sub-total">
									<div class="col-md-6 col-xs-6"> Subtotal:</div>
									<div class="col-md-6 col-xs-6"> Rp<span id="sub_total"><?php echo setHargaRupiah($_SESSION['subtotal']); ?></span></div>
								</div>
                                <div class="sub-total">
									<div class="col-md-6 col-xs-6"> Ongkos Kirim:</div>
									<div class="col-md-6 col-xs-6"> Rp<span id="ongkos_kirim"><?php echo setHargaRupiah($_SESSION['ongkos_kirim']); ?></span></div>
								</div>
                                <div class="sub-total">
									<div class="col-md-6 col-xs-6"> Diskon:</div>
									<div class="col-md-6 col-xs-6"> Rp<span id="diskon"><?php echo setHargaRupiah($_SESSION['diskon']); ?></span></div>
								</div>
                                <div class="sub-total">
									<div class="col-md-6 col-xs-6"> Kode Unik:</div>
									<div class="col-md-6 col-xs-6"> <span id="kode_unik"><?php echo $_SESSION['kode_unik']; ?></span></div>
								</div>
                                <div class="grand-total">Grand Total Rp<span id="grand_total"><?php echo setHargaRupiah(getKeranjangGrandtotal()); ?></span></div>
                                <a class="button style-10" href="checkout">BAYAR SEKARANG</a>
                            </div>
                        </div>
                    </div>
                </div>
