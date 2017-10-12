<div class="information-blocks">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 panel panel-default panel-body">		
		<?php
			if(isset($_POST['btnSimpanProfile'])){
				$user = $mysqli->query("update tbl_users set display_name='".$_POST['display_name']."',telepon='".$_POST['telepon']."',email='".$_POST['email']."' where id_users=".$_SESSION['user_login']."");
				if($user){
					$alamat = $mysqli->query("update tbl_users_alamat set alamat='".$_POST['alamat']."' where id_users=".$_SESSION['user_login']."");
					if($alamat){
						$bank = $mysqli->query("update tbl_users_bank set nama_bank='".$_POST['nama_bank']."',pemilik_bank='".$_POST['pemilik_bank']."',nomor_rekening='".$_POST['nomor_rekening']."' where id_users=".$_SESSION['user_login']."");
						if($bank){
							$_SESSION['user_display_name'] = $_POST['display_name'];
							$_SESSION['user_email'] = $_POST['email'];
							$_SESSION['user_telepon'] = $_POST['telepon'];
							echo'
								<div class="message-box message-success">
									<div class="message-icon"><i class="fa fa-check"></i></div>
									<div class="message-text"><b>Selamat!</b> Data berhasil disimpan.</div>
									<div class="message-close"><i class="fa fa-times"></i></div>
								</div>                    
							';
						}else{
							echo'
								<div class="message-box message-danger">
									<div class="message-icon"><i class="fa fa-remove"></i></div>
									<div class="message-text"><b>Maaf!</b> Gagal menyimpan data BANK. :(</div>
									<div class="message-close"><i class="fa fa-times"></i></div>
								</div>  
							';
						}
					}else{
						echo'
							<div class="message-box message-danger">
								<div class="message-icon"><i class="fa fa-remove"></i></div>
								<div class="message-text"><b>Maaf!</b> Gagal menyimpan data ALAMAT. :(</div>
								<div class="message-close"><i class="fa fa-times"></i></div>
							</div>  
						';
					}
				}else{
					echo'
						<div class="message-box message-danger">
							<div class="message-icon"><i class="fa fa-remove"></i></div>
							<div class="message-text"><b>Maaf!</b> Gagal menyimpan data USER. :(</div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>  
					';	
				}
			}
			if($_SESSION['user_telepon'] == "Tidak Ada" or $_SESSION['user_telepon'] == 0){
				echo'
					<div class="message-box message-danger">
						<div class="message-icon"><i class="fa fa-remove"></i></div>
						<div class="message-text"><b>UNTUK DAPAT MEMBUKA HALAMAN LAIN ANDA HARUS MELENGKAPI DATA DIBAWAH TERLEBIH DAHULU</b><br>Isi dengan "BELUM ADA" jika data BANK yang diminta belum ada</div>
						<div class="message-close"><i class="fa fa-times"></i></div>
					</div>  
				';
			}
		?>
		<form action="" method="post">
			<h3 class="block-title main-heading">Data Diri dan Akun Pribadi</h3>
			<div class="col-md-6 col-xs-12">	
				<div class="table-responsive">
					<?php
						$data_user = getDataByCollumn("tbl_users","id_users",$_SESSION['user_login'])->fetch_object();
						$data_alamat = getDataByCollumn("tbl_users_alamat","id_users",$_SESSION['user_login'])->fetch_object();
					?>
					<table class="table table-bordered">
						<tr><th colspan="2" style="background-color: #333333;color:white;text-align:center !important;"><b>DATA PROFILE</b></th></tr>
						<tr>
							<th width="25%" style="font-weight:bold;">NAMA LENGKAP</th>
							<td><input type="text" name="display_name" class="form-control" value="<?php echo $data_user->display_name; ?>" required></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">ALAMAT LENGKAP</th>
							<td><textarea name="alamat" class="form-control" required><?php echo $data_alamat->alamat; ?></textarea></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">LINK AFFILIATE</th>
							<td>http://<?php echo $data_user->link_affiliate; ?>.pinopi.com</td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">TELEPON</th>
							<td><input type="text" name="telepon" class="form-control" value="<?php echo $data_user->telepon; ?>" required></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">EMAIL</th>
							<td><input type="email" name="email" class="form-control" value="<?php echo $data_user->email; ?>" required></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">STATUS AKUN</th>
							<td><?php echo strtoupper($data_user->status_akun); ?></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">SALDO</th>
							<td>Rp <?php echo setHargaRupiah($data_user->saldo+$data_user->saldo_pending); ?> (<a href="<?php echo $url_web;?>/income">LIHAT DETAIL</a>)</td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">BERGABUNG SEJAK</th>
							<td><?php echo $data_user->created_at; ?></td>
						</tr>
					</table>					
					<br>	
				</div>
			</div>
			<div class="col-md-6 col-xs-12">				
				<div class="table-responsive">
					<?php
						$data_bank = getDataByCollumn("tbl_users_bank","id_users",$_SESSION['user_login'])->fetch_object();
					?>
					<table class="table table-bordered">
						<tr><th colspan="2" style="background-color: #333333;color:white;text-align:center !important;"><b>DATA BANK</b></th></tr>
						<tr>
							<th width="25%" style="font-weight:bold;">NAMA BANK</th>
							<td><input type="text" name="nama_bank" class="form-control" value="<?php echo $data_bank->nama_bank; ?>" required></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">PEMILIK REKENING</th>
							<td><input type="text" name="pemilik_bank" class="form-control" value="<?php echo $data_bank->pemilik_bank; ?>" required></td>
						</tr>
						<tr>
							<th width="25%" style="font-weight:bold;">NOMOR REKENING</th>
							<td><input type="text" name="nomor_rekening" class="form-control" value="<?php echo $data_bank->nomor_rekening; ?>" required></td>
						</tr>
					</table>					
					<br>	
				</div>
				<input type="submit" class="btn btn-primary pull-right" name="btnSimpanProfile" value="SIMPAN DATA"/>
			</div>
		</form>
		</div>
	</div>
</div>
