			<?php
				$konfirmasi_style = "visibility:visible;";
				$sql = "select * from tbl_transaksi,tbl_transaksi_pembayaran,tbl_transaksi_pengiriman
				WHERE tbl_transaksi.id_transaksi=".$_GET['transaksi']." AND tbl_transaksi_pembayaran.id_transaksi=".$_GET['transaksi']." 
				AND tbl_transaksi_pengiriman.id_transaksi=".$_GET['transaksi']."";
				$stmt = $mysqli->query($sql);
				//echo $sql;
				if($stmt->num_rows > 0){
					$data_transaksi = $stmt->fetch_object();
				}				
			?>

            <div class="row col-md-6">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-database"></i>&nbsp Detail Transaksi <?php echo $data_transaksi->invoice_transaksi; ?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<table class="table table-striped">
							<thead>
								<tr>
									<th width="40%">NOMOR INVOICE</th>
									<td><?php echo $data_transaksi->invoice_transaksi; ?></td>
								</tr>
								<tr>
									<th>ATAS NAMA</th>
									<td><?php echo $data_transaksi->atas_nama; ?></td>
								</tr>								
								<tr>
									<th>EMAIL PEMESAN</th>
									<td><?php echo $data_transaksi->email; ?></td>
								</tr>								
								<tr>
									<th>KODE UNIK</th>
									<td><?php echo $data_transaksi->kode_unik; ?></td>
								</tr>								
								<tr>
									<th>DISKON</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->diskon_transaksi); ?></td>
								</tr>								
								<tr>
									<th style="vertical-align:top;">TOTAL BIAYA TRANSAKSI</th>
									<td>Rp <?php echo setHargaRupiah($data_transaksi->total_transaksi-$data_transaksi->diskon_transaksi+$data_transaksi->kode_unik+$data_transaksi->biaya_pengiriman); ?><br> <span style="color:red;font-size:0.8em;">(sudah termasuk diskon, ongkos kirim & kode unik)</span></td>
								</tr>								
								<tr>
									<th style="vertical-align:top;">TANGGAL</th>
									<td><?php echo date('d F Y / H:i:s',strtotime($data_transaksi->tanggal_transaksi)); ?></td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-bank"></i>&nbsp Detail Metode Pembayaran</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="45%">METODE PEMBAYARAN</th>
									<td><?php echo strtoupper($data_transaksi->metode_pembayaran); ?></td>
								</tr>
								<tr>
									<th>BANK TUJUAN (PINOPI.COM)</th>
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
									<td><a href="../<?php echo ($data_transaksi->bukti_pembayaran); ?>" target="_blank"><button class="btn btn-info">LIHAT BUKTI PEMBAYARAN</button></a></td>
								</tr>
							</thead>
							<tbody>								
							</tbody>
						</table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row col-md-6">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-star"></i>&nbsp Detail Paket Produk</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>NAMA PRODUK</th>
									<th>QTY</th>
									<th>SATUAN</th>
									<th>SUBTOTAL</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$detail_transaksi = getDataByCollumn("tbl_transaksi_detail","id_transaksi",$_GET['transaksi']);
									while($detail = $detail_transaksi->fetch_object()){
										echo"
											<tr>
												<td>".$detail->nama_produk."</td>
												<td>".$detail->qty." pcs</td>
												<td>Rp ".setHargaRupiah($detail->harga_produk/$detail->qty)."</td>
												<td align='right'>Rp ".setHargaRupiah($detail->harga_produk)."</td>
											</tr>
										";
									}
								?>
								<tr style="font-weight:bold">
									<td colspan="2" align="right">Total Biaya Transaksi<span style="color:red;font-size:0.8em;"><br>(tanpa diskon & kode unik)</span></td>
									<td  colspan="2" align='right'>Rp <?php echo setHargaRupiah($data_transaksi->total_transaksi);?></td>
								</tr>
							</tbody>
						</table>
						</div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<?php
						if(isset($_POST['btnResi'])){
							$sql = "update tbl_transaksi_pengiriman set nomor_resi='".$_POST['nomor_resi']."' where id_transaksi=".$_GET['transaksi'];
							$stmt = $mysqli->query($sql);
							if($stmt){
								echo'
									<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
										<b>Selamat!</b> Nomor resi sudah berhasil disimpan
									</div> 
								';
							}else{
								echo'
									<div class="alert alert-danger alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
										<b>Maaf!</b> GAGAL MENYIMPAN NOMOR RESI. :(
									</div>                    
								';
							}
						}
					?>
                  <div class="x_title">
                    <h2><i class="fa fa-truck"></i>&nbsp Detail Informasi Pengiriman</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="35%">PENGIRIMAN VIA</th>
									<td>JNE <?php echo $data_transaksi->metode_pengiriman; ?></td>
								</tr>
								<tr>
									<th>BIAYA KIRIM</th>
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
								<tr>
									<th >NOMOR RESI</th>
									<td>
										<form action="" method="post" style="margin-bottom: -20px;">
										<div class="input-group">
										  <input type="text" class="form-control" name="nomor_resi" value="<?php echo $data_transaksi->nomor_resi; ?>" placeholder="Nomor Resi Pengiriman" aria-label="Nomor Resi Pengiriman">
										  <span class="input-group-btn">
											<button class="btn btn-secondary" type="submit" name="btnResi">SIMPAN</button>
										  </span>
										</div>											
										</form>
									</td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                  </div>
                </div>
              </div>
            </div>
			
			 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-file-text"></i>&nbsp Riwayat Status Transaksi</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
									$stmt = getDataByCollumn("tbl_transaksi_status","id_transaksi",$_GET['transaksi']);
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
