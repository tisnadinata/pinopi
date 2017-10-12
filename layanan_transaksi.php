<div class="information-blocks">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 panel panel-default panel-body">		
			<?php
					$_SESSION['nomor_invoice'] = '';
					$_SESSION['id_transaksi'] = '';
				$konfirmasi_style = "visibility:hidden;display:none;";						
				
				if(isset($_POST['cari_transaksi'])){
					if(cekNomorInvoice()){
						$konfirmasi_style = "visibility:visible;";
						$sql = "select * from tbl_transaksi,tbl_transaksi_pembayaran,tbl_transaksi_pengiriman
						WHERE tbl_transaksi.id_transaksi=".$_SESSION['id_transaksi']." AND tbl_transaksi_pembayaran.id_transaksi=".$_SESSION['id_transaksi']." 
						AND tbl_transaksi_pengiriman.id_transaksi=".$_SESSION['id_transaksi']."";
						$stmt = $mysqli->query($sql);
						//echo $sql;
						if($stmt->num_rows > 0){
							$data_transaksi = $stmt->fetch_object();
						}
					}else{
						echo'
							<div class="message-box message-danger">
								<div class="message-icon"><i class="fa fa-remove"></i></div>
								<div class="message-text"><b>Maaf!</b> Transaksi Dengan Nomor Invoice Tersebut Tidak Ditemukan.</div>
								<div class="message-close"><i class="fa fa-times"></i></div>
							</div>                    
						';						
					}
				}
				if(!isset($_SESSION['nomor_invoice'])){
					$_SESSION['nomor_invoice'] = '';
					$_SESSION['id_transaksi'] = '';
				}
				
			?>
			<h3 class="block-title main-heading">Cek Transaksi Anda</h3>
			<form action="" method="post">
				<div class="row">
					<div class="col-sm-8">
						<label>Nomor Transaksi/Invoice <span>*</span></label>
						<input class="simple-field" name="nomor_transaksi" type="text" placeholder="" required value="<?php echo $_SESSION['nomor_invoice']; ?>"/>
					</div>
					<div class="col-sm-4">
						<label>&nbsp <span>&nbsp</span></label>
						<input class="simple-field" type="submit" name="cari_transaksi" value="CARI TRANSAKSI" required value=""/>
						<div class="clear"></div>
					</div>
				</div>
			</form>
			<?php
				if(isset($_POST['cari_transaksi'])){
			?>
			<div style="<?php echo $konfirmasi_style;?>">
			<h3 class="block-title main-heading">Data Transaksi <?php echo $_SESSION['nomor_invoice']; ?></h3>
			<table class="table table-striped">
							<thead>
								<tr>
									<th width="30%">NOMOR INVOICE TRANSAKSI</th>
									<td>
										<?php 
											echo $_SESSION['nomor_invoice']." | <b>Status : </b>";
											$stmt_t = getDataByCondition("tbl_transaksi_status","id_transaksi = ".$_SESSION['id_transaksi'],"id_transaksi_status DESC");
											$status_t = $stmt_t->fetch_object();
											echo getTransaksiStatus($status_t->status_transaksi) ;
										?>
									</td>
								</tr>
								<tr>
									<th>PESANAN ATAS NAMA</th>
									<td><?php echo $data_transaksi->atas_nama; ?></td>
								</tr>								
								<tr>
									<th>EMAIL PEMESAN</th>
									<td><?php echo $data_transaksi->email; ?></td>
								</tr>								
								<tr>
									<th>KODE UNIK PEMBAYARAN</th>
									<td><?php echo $data_transaksi->kode_unik; ?></td>
								</tr>								
								<tr>
									<th>DISKON TRANSAKSI</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->diskon_transaksi); ?></td>
								</tr>								
								<tr>
									<th>TOTAL BIAYA TRANSAKSI</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->total_transaksi-$data_transaksi->diskon_transaksi+$data_transaksi->kode_unik+$data_transaksi->biaya_pengiriman); ?> <span style="color:red;font-size:0.8em;">(sudah termasuk diskon, ongkos kirim & kode unik)</span></td>
								</tr>								
								<tr>
									<th style="vertical-align:top;">TANGGAL TRANSAKSI</th>
									<td><?php echo date('d F Y / H:i:s',strtotime($data_transaksi->tanggal_transaksi)); ?></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
			<div class="accordeon">
				<div class="accordeon-title active">A. Detail Paket Produk Transaksi</div>
				<div class="accordeon-entry">
					<div class="article-container style-1">
						<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>NO</th>
									<th>NAMA PRODUK</th>
									<th>QTY</th>
									<th>HARGA SATUAN</th>
									<th>SUBTOTAL</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$detail_transaksi = getDataByCollumn("tbl_transaksi_detail","id_transaksi",$_SESSION['id_transaksi']);
									$i = 1;
									while($detail = $detail_transaksi->fetch_object()){
										echo"
											<tr>
												<td>$i</td>
												<td>".$detail->nama_produk."</td>
												<td>".$detail->qty." pcs</td>
												<td>Rp ".setHargaRupiah($detail->harga_produk/$detail->qty)."</td>
												<td>Rp ".setHargaRupiah($detail->harga_produk)."</td>
											</tr>
										";
										$i++;
									}
								?>
								<tr style="font-weight:bold">
									<td colspan="4" align="right">Total Biaya Transaksi<span style="color:red;font-size:0.8em;">(tanpa diskon & kode unik)</span></td>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->total_transaksi);?></td>
								</tr>
							</tbody>
						</table>
						</div>
                    </div>
				</div>
				<div class="accordeon-title active">B. Detail Pembayaran Transaksi</div>
				<div class="accordeon-entry">
					<div class="article-container style-1">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="35%">METODE PEMBAYARAN</th>
									<td><?php echo strtoupper($data_transaksi->metode_pembayaran); ?></td>
								</tr>
								<tr>
									<th>BANK TUJUAN(PINOPI.COM)</th>
									<td><?php echo strtoupper($data_transaksi->tujuan_pembayaran); ?></td>
								</tr>								
								<tr>
									<th>BANK CUSTOMER</th>
									<td><?php echo strtoupper($data_transaksi->nama_bank); ?></td>
								</tr>								
								<tr>
									<th>NOMOR REKENING</th>
									<td><?php echo strtoupper($data_transaksi->nomor_rekening); ?></td>
								</tr>								
								<tr>
									<th>PEMILIK REKENING</th>
									<td><?php echo strtoupper($data_transaksi->pemilik_rekening); ?></td>
								</tr>																
								<tr>
									<th>TOTAL DIBAYAR</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->jumlah_dibayar); ?></td>
								</tr>
								<tr>
									<th>TANGGAL PEMBAYARAN</th>
									<td>
									<?php 
										if($data_transaksi->waktu_transfer != NULL){
											$tanggal_pembayaran = date('d F Y',strtotime($data_transaksi->waktu_transfer));											
										}else{
											$tanggal_pembayaran = '';
										}
										echo $tanggal_pembayaran; 
									?>
									</td>
								</tr>
								<tr>
									<th>BUKTI PEMBAYARAN</th>
									<td><a href="<?php echo ($data_transaksi->bukti_pembayaran); ?>" target="_blank"><button class="button btn-info">LIHAT BUKTI PEMBAYARAN</button></a></td>
								</tr>
							</thead>
							<tbody>								
							</tbody>
						</table>
                    </div>
				</div>
				<div class="accordeon-title active">C. Detail Pengiriman Transaksi</div>
				<div class="accordeon-entry">
					<div class="article-container style-1">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="25%">PENGIRIMAN VIA</th>
									<td>JNE / PAKET <?php echo $data_transaksi->metode_pengiriman; ?>
								</tr><tr>
									<th>NOMOR RESI</th>
									<td> 
										<?php
											if($data_transaksi->nomor_resi != NULL){
												echo $data_transaksi->nomor_resi.' &nbsp&nbsp|&nbsp&nbsp ';
												$curl = curl_init();

												curl_setopt_array($curl, array(
												  CURLOPT_URL => "http://pro.rajaongkir.com/api/waybill",
												  CURLOPT_RETURNTRANSFER => true,
												  CURLOPT_ENCODING => "",
												  CURLOPT_MAXREDIRS => 10,
												  CURLOPT_TIMEOUT => 30,
												  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												  CURLOPT_CUSTOMREQUEST => "POST",
												  CURLOPT_POSTFIELDS => "waybill=".$data_transaksi->nomor_resi."&courier=jne",
												  CURLOPT_HTTPHEADER => array(
													"content-type: application/x-www-form-urlencoded",
													"key: 27c5b41cc910c78ca7b3445b897b56a0"
												  ),
												));

												$response = curl_exec($curl);
												$err = curl_error($curl);

												curl_close($curl);

												if ($err) {
												  $json = "cURL Error #:" . $err;
												  var_dump($json);
												} else {
												  $json = json_decode($response);
												}
												echo "<b>".($json->rajaongkir->result->summary->status)."</b>";
											}else{
												echo "Nomor resi belum di masukan";
											}
										?>										
									</td>
								</tr>
								<tr>
									<th>BIAYA PENGIRIMAN</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->biaya_pengiriman); ?></td>
								</tr>
								<tr>
									<th>NAMA PENERIMA</th>
									<td><?php echo $data_transaksi->atas_nama; ?></td>
								</tr>								
								<tr>
									<th style="vertical-align:top;">ALAMAT TUJUAN</th>
									<td><?php echo $data_transaksi->alamat_pengiriman.', '.$data_transaksi->kota_pengiriman.', '.$data_transaksi->provinsi_pengiriman.' '.$data_transaksi->kode_pos; ?></td>
								</tr>
								<tr>
									<th >TELEPON</th>
									<td><?php echo $data_transaksi->telepon_pengiriman; ?></td>
								</tr>
								<tr>
									<th style="vertical-align:top;">CATATAN</th>
									<td><?php echo $data_transaksi->catatan_pengiriman; ?></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                    </div>
				</div>
				<div class="accordeon-title active">D. Riwayat Status Transaksi</div>
				<div class="accordeon-entry">
					<div class="article-container style-1">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>TANGGAL</th>
									<th>KETERANGAN</th>
									<th>STATUS</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$stmt = getDataByCollumn("tbl_transaksi_status","id_transaksi",$_SESSION['id_transaksi']);
									while($status_transaksi = $stmt->fetch_object()){
										echo"
											<tr>
												<td>".date('d F Y, H:i:s',strtotime($status_transaksi->tanggal))."</td>
												<td>".$status_transaksi->keterangan."</td>
												<td>".getTransaksiStatus($status_transaksi->status_transaksi)."</td>
											</tr>								
										";
									}									
								?>
							</tbody>
						</table>
                    </div>
				</div>
			</div>
			</div>
			<?php
				}
			?>
		</div>
	</div>
</div>