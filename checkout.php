<script>
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
	$_SESSION['kode_unik'] = generate_trans_code();
	
?>
                <div class="information-blocks">
                    <div class="row">
                        <div class="col-sm-8 col-md-offset-2 information-entry">
                            <div class="accordeon size-1">
								<?php
									if(isset($_POST['simpan_pengiriman'])){
										if(setCheckoutPengiriman()){
											echo'
												<div class="message-box message-success">
													<div class="message-icon"><i class="fa fa-check"></i></div>
													<div class="message-text"><b>Selamat!</b> Alamat & Metode Pengiriman telah disimpan, silahkan lanjutkan ke metode pembayaran.</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}else{
											echo'
												<div class="message-box message-danger">
													<div class="message-icon"><i class="fa fa-remove"></i></div>
													<div class="message-text"><b>Maaf!</b> GAGAL MENYIMPAN ALAMAT PENGIRIMAN. :(</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
										}
									}
									if(!isset($_SESSION['status_pengiriman'])){
										$_SESSION['nama_penerima'] = '';
										$_SESSION['email_penerima'] = '';
										$_SESSION['telepon_penerima'] = '';
										$_SESSION['alamat_penerima'] = '';
										$_SESSION['pengiriman_catatan'] = '';
										$_SESSION['ongkir_pos'] = '';
										$active[0] = "active";
										$active[1] = "";
										$display[0] = "style='display: block;'";
										$display[1] = "";
									}else{
										$active[1] = "active";
										$active[0] = "";
										$display[1] = "style='display: block;'";
										$display[0] = "";		
									}
									if(isset($_POST['btn_finish'])){										
										if(isset($_POST['metode_pembayaran'])){
											$status = explode('/',setCheckoutFinish());
											if($status[0] == 'sukses'){
												echo'
												<div class="message-box message-success">
													<div class="message-icon"><i class="fa fa-check"></i></div>
													<div class="message-text"><b>Selamat!</b> Pesanan anda sudah kami proses dan dalam status menunggu pembayaran, nomor invoice anda adalah <b>'.$status[1].'</b> </div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
												<div class="message-box message-info">
													<div class="message-icon"><i class="fa fa-exclamation"></i></div>
													<div class="message-text"><b>INFO TRANSAKSI!</b> detail pesanan dan pembayaran sudah dikirim melalui EMAIL atau anda bisa cek di <a href="cek-transaksi">HALAMAN CEK TRANSAKSI</a>.</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											'	;
											}else{
												echo'
													<div class="message-box message-danger">
														<div class="message-icon"><i class="fa fa-remove"></i></div>
														<div class="message-text"><b>Maaf!</b> PESANAN ANDA GAGAL DI PROSES OLEH SISTEM, SILAHKAN COBA BEBERAPA SAAT LAGI. <b>KODE ERROR : '.$status[1].'</b></div>
														<div class="message-close"><i class="fa fa-times"></i></div>
													</div>                    
												';
											}
											$checkout_layout = "visibility: hidden;";
										}else{
											echo'
												<div class="message-box message-warning">
													<div class="message-icon"><i class="fa fa-exclamation"></i></div>
													<div class="message-text"><b>Maaf!</b> SILAHKAN PILIH SALAH SATU METODE PEMBAYARAN. :(</div>
													<div class="message-close"><i class="fa fa-times"></i></div>
												</div>                    
											';
											$checkout_layout = "visibility: visible;";
										}
									}else{
										$checkout_layout = "visibility: visible;";
									}
									if(isset($_SESSION['user_login']) AND !isset($_SESSION['status_pengiriman'])){
										$alamat = $mysqli->query("select * from tbl_users_alamat where id_users = ".$_SESSION['user_login'])->fetch_object();
										$_SESSION['nama_penerima'] = $_SESSION['user_display_name'];
										$_SESSION['email_penerima'] = $_SESSION['user_email'];
										$_SESSION['telepon_penerima'] = $_SESSION['user_telepon'];
										$_SESSION['alamat_penerima'] = $alamat->alamat;
									}
									if($checkout_layout != "visibility: hidden;"){
								?>								
								<div class="row panel panel-default panel-body" style="<?php echo $checkout_layout; ?>">
									<div class="block-header" style="padding-top: 10px;">
										<h3 style="font-weight:bold;">IKUTI LANGKAH-LANGKAH DIBAWAH UNTUK MELAKUKAN PEMESANAN</h3>
									</DIV>
									<div class="accordeon-title <?php echo $active[0];?>"><span class="number">1</span>Alamat & Metode Pengiriman</div>
									<div class="accordeon-entry" <?php echo $display[0];?>>
										<form action="" method="post">									
										<div class="row ">
											<div class="col-md-12">
											<label style="font-weight:bold;">A. ALAMAT PENGIRIMAN</label>
												<label>Nama Penerima/Atas Nama</label>
												<input type="text" value="<?php echo $_SESSION['nama_penerima'];?>" placeholder="Nama Lengkap" id="nama_penerima" name="nama_penerima" class="simple-field size-1" required/>
												<br>
											</div>
											<div class="col-md-6">
												<label>Alamat Email</label>
												<input type="email" value="<?php echo $_SESSION['email_penerima'];?>" placeholder="Email Aktif" id="email_penerima" name="email_penerima" class="simple-field size-1" required/>
												<br>
											</div>
											<div class="col-md-6">
												<label>Telepon/Handphone</label>
												<input type="text" value="<?php echo $_SESSION['telepon_penerima'];?>" placeholder="Nomor Aktif" id="telepon_penerima" name="telepon_penerima" class="simple-field size-1" required/>
												<br>
											</div>
											<div class="col-md-12">
												<label>Alamat Lengkap Penerima</label>
												<textarea id="alamat_penerima" name="alamat_penerima" class="simple-field size-1" required/><?php echo $_SESSION['alamat_penerima'];?></textarea>
												<br>
											</div>
											<div class="col-md-4">
												<label>Nama Provinsi</label>
												<div class="simple-drop-down simple-field size-1">
													<select id="ongkir_provinsi" name="alamat_provinsi" onchange="set_ongkir_provinsi(this.value)" required/>
													<?php
														if(isset($_SESSION['ongkir_provinsi'])){
															echo'<option>'.$_SESSION['ongkir_provinsi'].'</option>';
															echo'<option><hr></option>';
														}else{
															echo'<option>Pilih Provinsi Dulu</option>';
														}
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
											</div>
											<div class="col-md-4">
												<label>Nama Kota/Kabupaten</label>
												<div class="simple-drop-down simple-field size-1">
													<select id="ongkir_kota" name="alamat_kota" onchange="set_ongkir_kota(this.value)" required/>
													<?php
														if(isset($_SESSION['ongkir_kota'])){
															echo'<option>'.$_SESSION['ongkir_kota'].'</option>';
															echo'<option><hr></option>';
														}else{
															echo'<option>Pilih Provinsi Dulu</option>';
														}
													?>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<label>Kode Pos(Ubah jika tidak sesuai)</label>
												<input type="number" placeholder="Zip Code" id="ongkir_pos" name="ongkir_pos" value="<?php echo $_SESSION['ongkir_pos']; ?>" class="simple-field size-1" required/>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12">
											<label style="font-weight:bold;">B. METODE PENGIRIMAN</label>
												<label>Jenis Layanan</label>
												<div class="simple-drop-down simple-field size-1">
													<select id="ongkir_layanan" name="ongkir_layanan" required>
													<?php
														if(isset($_SESSION['layanan_kirim'])){
															echo'<option value="'.$_SESSION['layanan_kirim'].'-'.$_SESSION['ongkos_layanan'].'">'.$_SESSION['layanan_kirim'].' - Rp'.setHargaRupiah($_SESSION['ongkos_layanan']).' per 1kg</option>';
															echo'<option><hr></option>';
														}else{
															echo'<option>Pilih Kota Dulu</option>';
														}
													?>
													</select>
												</div>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-12">
											<label style="font-weight:bold;">C. CATATAN PENGIRIMAN</label>
												<textarea id="pengiriman_catatan" name="pengiriman_catatan" class="simple-field size-1"><?php echo $_SESSION['pengiriman_catatan'];?></textarea>
												<br>
											</div>
											<div class="col-md-12">
												<div class="button style-16 pull-right" style="margin-top: 10px;">SIMPAN ALAMAT PENGIRIMAN<input type="submit" name="simpan_pengiriman"/></div>								
											</div>
										</div>
										</form>
									</div>
									<div class="accordeon-title <?php echo $active[1];?>"><span class="number">2</span>Pembayaran & Detail Pesanan </div>
									<div class="accordeon-entry" <?php echo $display[1];?>>
										<div class="article-container style-1">
											<form action="" method="post">
												<div class="row ">
													<div class="col-md-12">
													<label style="font-weight:bold;">A. METODE PEMBAYARAN</label>
														<label>Pilih Metode Pembayaran dibawah :</label>
														<div class="col-md-4">
															<label class="checkbox-entry radio panel panel-body panel-default">
																<input type="radio" name="metode_pembayaran" value="bank transfer"/> <span class="check"></span> 
																<b>BANK TRANSFER</b>
															</label>															
														</div>
														<div class="col-md-4">
															<label class="checkbox-entry radio panel panel-body panel-default">
																<input type="radio" name="custom-name" disabled/> <span class="check"></span> 
																<b>COMING SOON</b>
															</label>															
														</div>
														<div class="col-md-4">
															<label class="checkbox-entry radio panel panel-body panel-default">
																<input type="radio" name="custom-name" disabled/> <span class="check"></span> 
																<b>COMING SOON</b>
															</label>															
														</div>
													</div>
													<div class="col-md-12">
													<br>
													<label style="font-weight:bold;">B. DETAIL PESANAN</label>
														<label>Periksa kemhali keranjang belanja anda, jika ada yang tidak sesuia silahkan ubah di <a href="cart">HALAMAN KERANJANG</a></label>
														<div class="table-responsive">
															<table class="cart-table">
																<tr>
																	<th class="column-1">Nama Produk</th>
																	<th class="column-3">Harga Satuan</th>
																	<th class="column-2">Qty</th>
																	<th class="column-4">Subtotal</th>
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
																	?> 
																			<tr>
																				<td style="padding:0px 30px;">
																					<a target="_blank" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$data_produk->nama_produk));?>" class="title"><?php echo $data_produk->nama_produk; ?></a>
																					<input type="hidden" name="id_keranjang[<?php echo $i ?>]" value="<?php echo $data_keranjang->id_keranjang; ?>"/>
																						<div class="inline-description"><?php echo "Berat produk : ".getprodukBerat($data_produk->id_produk)."gram"; ?></div>
																					
																				</td>
																				<td style="padding:0px 30px;">
																				Rp<?php echo setHargaRupiah($harga); ?></td>
																				<td style="padding:0px 30px;">
																						<?php echo $data_keranjang->qty; ?> pcs
																				</td>
																				<td style="padding:0px 30px;">
																					<div class="subtotal">Rp<?php echo setHargaRupiah($harga_produk); ?></div></td>
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
														<div class="cart-summary-box" style="border:0px solid;padding-right:0px">
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
															<div class="grand-total">Grand Total Rp<span id="grand_total"><?php echo setHargaRupiah(getKeranjangGrandtotal()); ?></span>
															</div>
														<input type="submit" class="button style-10 pull-right" name="btn_finish" value="SELESAI DAN BAYAR SEKARANG"></input>
														</div>
															
													</div>
												</div>									
											</form>
										</div>
									</div>
								</div>
								<?php																		
									}
								?>
                            </div>
                        </div>                       
                    </div>    
                </div>
