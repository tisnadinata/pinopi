              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_users where id_users=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="1; URL=?page=daftar-user">
						';						
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data gagal dihapus!</strong> .
							</div>
						';
					}
				}
			  ?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Data Member</small></h2>
                    <div class="clearfix"></div>
                  </div>
				  <?php
					if(isset($_POST['btnSimpanData'])){
						$stmt = $mysqli->query("update tbl_users set display_name='".$_POST['display_name']."',upline='".$_POST['upline']."',telepon='".$_POST['telepon']."',status_akun='".$_POST['status_akun']."' where id_users=".$_GET['edit']."");
						if($stmt){
							echo'
								<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data berhasil diubah!</strong> .
								</div>
								<meta http-equiv="Refresh" content="1; URL=?page=daftar-user">
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
					if(isset($_GET['edit'])){
						$user = getDataByCollumn("tbl_users","id_users",$_GET['edit']);
						if($user->num_rows != 0){
							$data_user = $user->fetch_object();
				  ?>
					<div class="x_content">
						<table class="table">
							<tr>
								<td>NAMA LENGKAP</td>
								<td>UPLINE</td>
								<td>TELEPON</td>
								<td>STATUS AKUN</td>
								<td>AKSI</td>
							</tr>
							<form action="" method="post">
							<tr>
								<td><input type="text" name="display_name" value="<?php echo $data_user->display_name;?>"  class="form-control"></td>
								<td>
									<select name="upline" class="form-control">
										<option value="<?php echo $data_user->display_name;?>"><?php echo $data_user->upline;?></option>
										<?php
											$upline = getDataTable("tbl_users","link_affiliate ASC");
											while($data = $upline->fetch_object()){
												echo "<option value='".$data->link_affiliate."'>".$data->link_affiliate."</option>";
											}
										?>										
									</select>
								</td>
								<td><input type="text" name="telepon" value="<?php echo $data_user->telepon;?>"  class="form-control"></td>
								<td>
									<select name="status_akun" class="form-control">
										<option value="<?php echo $data_user->status_akun;?>"><?php echo $data_user->status_akun;?></option>
										<option value="reseller">RESELLER</option>
										<option value="agen">AGEN</option>
										<option value="distributor">DISTRIBUTOR</option>
									</select>
								</td>
								<td><input type="submit" class="btn btn-primary" value="SIMPAN" name="btnSimpanData"></td>
							</tr>
							</form>
						</table>
					</div>
				  <?php
						}
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
                          <th>LINK_AFFILIATE</th>
                          <th>UPLINE</th>
                          <th>TELEPON</th>
                          <th>EMAIL</th>
                          <th>STATUS</th>
                          <th>SALDO</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_users where id_users != 0 and status_akun!='nonmember'","display_name ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_user = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_user->display_name.'</td>
										  <td>'.$data_user->link_affiliate.'</td>
										  <td>'.$data_user->upline.'</td>
										  <td>'.$data_user->telepon.'</td>
										  <td>'.$data_user->email.'</td>
										  <td>'.$data_user->status_akun.'</td>
										  <td><font color="green">'.setHargaRupiah($data_user->saldo).'</font>/<font color="red">'.setHargaRupiah($data_user->saldo_pending).'</font></td>
										  <td>
											<a href="?page=daftar-user&edit='.$data_user->id_users.'" type="submit" class="btn btn-info" title="Edit Data" /><i class="fa fa-edit"></i></a>
											<a href="?page=daftar-user&delete='.$data_user->id_users.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i></a>
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
