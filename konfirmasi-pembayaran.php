<div class="information-blocks">
	<div class="row ">
		<div class="col-md-8 col-md-offset-2 panel panel-default panel-body">		
			<?php
				$konfirmasi_style = "visibility:hidden;display:none;";						
				if(isset($_POST['konfirmasi_pembayaran'])){
					$status = explode('-',setKonfirmasiPembayaran());
					if($status[0] == 'sukses'){
						echo'
							<div class="message-box message-success">
								<div class="message-icon"><i class="fa fa-check"></i></div>
								<div class="message-text"><b>Selamat!</b> Konfirmasi pembayaran berhasil dilakukan, kami akan segera memproses pesanan anda. Untuk memeriksa status transaksi anda silahkan membuka <a href="cek-transaksi">HALAMAN CEK TRANSAKSI</a></div>
								<div class="message-close"><i class="fa fa-times"></i></div>
							</div>                    
						';
						session_destroy();
					}else{
						echo'
							<div class="message-box message-danger">
								<div class="message-icon"><i class="fa fa-remove"></i></div>
								<div class="message-text"><b>Maaf!</b> GAGAL MELAKUKAN KONFIRMASI PEMBAYARAN. :(<br>'.$status[1].'</div>
								<div class="message-close"><i class="fa fa-times"></i></div>
							</div>                    
						';						
					}
				}
				if(isset($_POST['cari_transaksi'])){
					if(cekNomorInvoice()){
						$konfirmasi_style = "visibility:visible;";
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
				}
				
			?>
			<h3 class="block-title main-heading">Konfirmasi Pembayaran</h3>
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
			</form>
			<form action="" method="post" style="<?php echo $konfirmasi_style;?>" enctype="multipart/form-data">
					<div class="col-sm-12">
						<label>Metode Pembayaran</label>
						<div class="simple-drop-down simple-field">
							<select>
								<option>Bank Transfer</option>
							</select>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-sm-12">
						<label>Bank Transfer(Bank Kami)</label>
						<div class="simple-drop-down simple-field">
							<select name="tujuan_pembayaran" required>
								<?php
									$stmt = getDataByCollumn("tbl_bank",'status_bank','aktif');
									if($stmt->num_rows > 0){
										while($data_bank = $stmt->fetch_object()){
											echo"<option value='".strtoupper($data_bank->nama_bank)."'>".strtoupper($data_bank->nama_bank)." - ".$data_bank->nomor_rekening." - ".strtoupper($data_bank->atas_nama)."</option>";											
										}
									}else{
										echo"<option>TIDAK ADA DATA TERSEDIA</option>";
									}
								?>
							</select>
						</div>
						<div class="clear"></div>
					</div>
					<div class="col-sm-6">
						<label>Nama Bank (Bank Anda) <span>*</span></label>
						<input class="simple-field" type="text" name="nama_bank" placeholder="" required value=""/>
						<div class="clear"></div>
					</div>
					<div class="col-sm-6">
						<label>Nomor Rekening (Bank Anda) <span>*</span></label>
						<input class="simple-field" type="number" name="nomor_rekening" placeholder="" required value=""/>
						<div class="clear"></div>
					</div>
					<div class="col-sm-6">
						<label>Atas Nama (Bank Anda) <span>*</span></label>
						<input class="simple-field" type="text" name="atas_nama" placeholder="" required value=""/>
						<div class="clear"></div>
					</div>
					<div class="col-md-6">
						<label>Total Yang Dibayar (Rp)<span>*</span></label>
						<input class="simple-field" type="number" name="jumlah_dibayar" placeholder="" required value=""/>
						<div class="clear"></div>
					</div>
					<div class="col-md-6">
						<label>Tanggal Dibayar<span>*</span></label>
						<input class="form-control" type="date" name="waktu_transfer" placeholder="" required value=""/>
						<div class="clear"></div>
					</div>
					<div class="col-sm-6">
						<label>Bukti Pembayaran <span>*</span></label>
						<input class="form-control" type="file"  name="file_foto"placeholder="" required value=""/>
							<br>
							<br>
						<div class="button style-10 pull-right">
							KONFIRMASI PEMBAYARAN<input type="submit" name="konfirmasi_pembayaran" value=""/>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>