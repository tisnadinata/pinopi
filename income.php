<div class="information-blocks">
	<div class="row">
		<div class="col-md-12 panel panel-default panel-body">		
			<h3 class="block-title main-heading">Rekap dan Riwayat Bonus Penghasilan</h3>
			<div class="col-md-6 col-xs-12">	
				<div class="col-md-12">
					<p>
					<b style="font-weight:bold">Keterangan :</b>
					<br><br>
					<ul>
						<li>- Bonus/Penghasilan Penjualan didapat apabila anda menjual paket distributor/agen(pembelian minimal 250pcs)</li>
						<li>- Bonus/Penghasilan Jaringan didapat apabila tim bisnis anda melakukan pembelian. bonus/penghasilan ini berlaku untuk 10 tingkat tim bisnis</li>
						<li>- Bonus/Penghasilan yang dapat dicairkan akan kami proses SETIAP HARI SENIN</li>
					</ul>
					</p>
				</div>
			</div>			
			<div class="col-md-6 col-xs-12">				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="2" style="background-color: #333333;color:white;text-align:center !important;"><b>BONUS/PENGHASILAN ANDA SAAT INI</b></th></tr>
							<tr>
								<th width="50%" class="alert-success" style="text-align:center !important;">DAPAT DICAIRKAN</th>
								<th width="50%" class="alert-warning" style="text-align:center !important;">TIDAK DAPAT DICAIRKAN</th>
							</tr>
						<thead>
						<tbody>
						<?php
							$bon = $mysqli->query("select * from tbl_users where id_users=".$_SESSION['user_login']."");
							$get = $bon->fetch_object();
							echo"
								<tr>
									<td align='center'>Rp ".setHargaRupiah($get->saldo)."</td>
									<td align='center'>Rp ".setHargaRupiah($get->saldo_pending)."</td>
								</tr>
							";
						?>
						</tbody>
					</table>					
					<br>	
				</div>
			</div>
			<div class="col-md-6 col-xs-12">				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="5" style="background-color: #333333;color:white;"><b>Riwayat Bonus Penjualan</b></th></tr>
							<tr>
								<th width="5%">NO</th>
								<th width="15%">TANGGAL</th>
								<th width="20%">JUMLAH BONUS</th>
								<th width="60%">KETERANGAN SUMBER BONUS/PENGHASILAN</th>
							</tr>
						<thead>
						<tbody>
						<?php
							$bon_penjualan = $mysqli->query("select * from tbl_users_bonus where id_users=".$_SESSION['user_login']." and tipe_bonus='penjualan' AND MONTH(tanggal) = MONTH(NOW())");
							if($bon_penjualan->num_rows > 0){
								$no=1;
								while($get = $bon_penjualan->fetch_object()){
									echo"
										<tr>
											<td align='center'>$no</td>
											<td>".$get->tanggal."</td>
											<td align='center'>Rp ".setHargaRupiah($get->jumlah_bonus)."</td>
											<td>".$get->keterangan."</td>
										</tr>
									";
									$no++;
								}
							}else{
								echo"
									<tr>
										<td colspan='5'>Anda belum memiliki penghasilan disini</td>
									</tr>
								";
							}
						?>
						</tbody>
					</table>			
					<br>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="5" style="background-color: #333333;color:white;"><b>Riwayat Bonus Jaringan Bisnis</b></th></tr>
							<tr>
								<th width="5%">NO</th>
								<th width="15%">TANGGAL</th>
								<th width="20%">JUMLAH BONUS</th>
								<th width="60%">KETERANGAN SUMBER BONUS/PENGHASILAN</th>
							</tr>
						<thead>
						<tbody>
						<?php
							$bon_penjualan = $mysqli->query("select * from tbl_users_bonus where id_users=".$_SESSION['user_login']." and tipe_bonus='jaringan' AND MONTH(tanggal) = MONTH(NOW())");
							if($bon_penjualan->num_rows > 0){
								$no=1;
								while($get = $bon_penjualan->fetch_object()){
									echo"
										<tr>
											<td align='center'>$no</td>
											<td>".$get->tanggal."</td>
											<td align='center'>Rp".setHargaRupiah($get->jumlah_bonus)."</td>
											<td>".$get->keterangan."</td>
										</tr>
									";
									$no++;
								}
							}else{
								echo"
									<tr>
										<td colspan='5'>Anda belum memiliki penghasilan disini</td>
									</tr>
								";
							}
						?>
						</tbody>
					</table>				
					<br>		
				</div>
			</div>
			<div class="col-md-6 col-xs-12">				
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr><th colspan="5" style="background-color: #333333;color:white;"><b>Riwayat Bonus Retail</b></th></tr>
							<tr>
								<th width="5%">NO</th>
								<th width="15%">TANGGAL</th>
								<th width="20%">JUMLAH BONUS</th>
								<th width="60%">KETERANGAN SUMBER BONUS/PENGHASILAN</th>
							</tr>
						<thead>
						<tbody>
						<?php
							$bon_penjualan = $mysqli->query("select * from tbl_users_bonus where id_users=".$_SESSION['user_login']." and tipe_bonus='retail' AND MONTH(tanggal) = MONTH(NOW())");
							if($bon_penjualan->num_rows > 0){
								$no=1;
								while($get = $bon_penjualan->fetch_object()){
									echo"
										<tr>
											<td align='center'>$no</td>
											<td>".$get->tanggal."</td>
											<td align='center'>Rp".setHargaRupiah($get->jumlah_bonus)."</td>
											<td>".$get->keterangan."</td>
										</tr>
									";
									$no++;
								}
							}else{
								echo"
									<tr>
										<td colspan='5'>Anda belum memiliki penghasilan disini</td>
									</tr>
								";
							}
						?>
						</tbody>
					</table>				
					<br>		
				</div>
			</div>
		</div>
	</div>
</div>