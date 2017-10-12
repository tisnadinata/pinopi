              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['cair'])){
					$stmt = $mysqli->query("update tbl_users set saldo=0 where id_users=".$_GET['cair']."");
					if($stmt){
						$mysqli->query("delete from tbl_users_bonus where id_users".$_GET['cair']."");
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Saldo user sudah di jadikan 0!</strong> .
							</div>
							<meta http-equiv="Refresh" content="1; URL=?page=user-bonus">
						';						
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data gagal diubah!</strong> .
							</div>
						';
					}
				}
			  ?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Data Penghasilan Member</small></h2>
                    <div class="clearfix"></div>
                  </div>
				  <?php
					if(isset($_GET['detail'])){
						$user = getDataByCondition("tbl_users_bonus","id_users",$_GET['detail']);
				  ?>
					<div class="x_content" style="max-height:500px;overflow:auto;">
						<table class="table">
							<thead>
								<tr>
									<th>TANGGAL</th>
									<th>TIPE BONUS</th>
									<th>JUMLAH BONUS</th>
									<th>KETERANGNA</th>
								</tr>
							</thead>
							<tbody>
				  <?php
						$user = getDataByCondition("tbl_users_bonus","id_users",$_GET['detail']);
						while($data_user = $user->fetch_object()){
				  ?>
								<tr>
									<td><?php echo $data_user->tanggal;?></td>
									<td><?php echo $data_user->tipe_bonus;?></td>
									<td align="center">Rp<?php echo setHargaRupiah($data_user->jumlah_bonus);?></td>
									<td><?php echo $data_user->keterangan;?></td>
								</tr>
				  <?php
						}
				  ?>
							</tbody>
						</table>
					</div>
				  <?php
					}
				  ?>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th>NAMA LENGKAP</th>
                          <th>STATUS AKUN</th>
                          <th>SALDO DICAIRKAN</th>
                          <th>SALDO PENDING</th>
                          <th style="width:20%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataByCondition("tbl_users","saldo >= 100000 OR saldo_pending >= 6000000","display_name ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_user = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_user->display_name.'</td>
										  <td>'.$data_user->status_akun.'</td>
										  <td align="center"><font color="green">Rp'.setHargaRupiah($data_user->saldo).'</font></td>
										  <td align="center"><font color="red">Rp'.setHargaRupiah($data_user->saldo_pending).'</font></td>
										  <td>
											<a href="?page=user-bonus&cair='.$data_user->id_users.'" type="submit" class="btn btn-success" title="Cairkan" /><i class="fa fa-check"></i> CAIRKAN</a>
											<a href="?page=user-bonus&detail='.$data_user->id_users.'" type="submit" class="btn btn-info" title="Cairkan" /><i class="fa fa-search"></i> DETAIL</a>
										  </td>
										</tr>								
									';
									$i++;
								}
							}else{
								echo"<tr><td colspan='4'>Belum ada data yang tersedia</td></tr>";
							}
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
