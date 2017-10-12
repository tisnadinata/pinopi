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
							<meta http-equiv="Refresh" content="1; URL=?page=user-testimoni">
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
			if(isset($_GET['edit'])){
				$user = getDataByCollumn("tbl_users_testimoni","id_users_testimoni",$_GET['edit']);
				if($user->num_rows != 0){
					$data_user = $user->fetch_object();
			  ?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit Testimoni</small></h2>
                    <div class="clearfix"></div>
                  </div>
				  <?php
					if(isset($_POST['btnSimpanData'])){
						$stmt = $mysqli->query("update tbl_users_testimoni set nama='".$_POST['nama']."',jabatan='".$_POST['jabatan']."',isi='".$_POST['isi']."' where id_users_testimoni=".$_GET['edit']."");
						if($stmt){
							echo'
								<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data berhasil diubah!</strong> .
								</div>
								<meta http-equiv="Refresh" content="1; URL=?page=user-testimoni">
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
					<div class="x_content">
						<table class="table">
							<tr>
								<th >NAMA LENGKAP</th>
								<th>JABATAN</th>
								<th width="50%">ISI TESTIMONI</th>
								<td>AKSI</td>
							</tr>
							<form action="" method="post">
							<tr>
								<td><input type="text" name="nama" value="<?php echo $data_user->nama;?>"  class="form-control"></td>
								<td><input type="text" name="jabatan" value="<?php echo $data_user->jabatan;?>"  class="form-control"></td>
								<td><textarea name="isi" rows="4" class="form-control"><?php echo $data_user->isi;?></textarea></td>
								<td><input type="submit" class="btn btn-primary" value="SIMPAN" name="btnSimpanData"></td>
							</tr>
							</form>
						</table>
					</div>
				</div>
				  <?php
						}
					}else{
				?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Form Tambah Testimoni</small></h2>
                    <div class="clearfix"></div>
                  </div>
				  <?php
					if(isset($_POST['btnTambahData'])){
						$user = explode("|",$_POST['user']);
						$nama = $user[0];
						$foto = $user[1];
						$jabatan = $_POST['jabatan'];
						$isi = $_POST['isi'];
						$stmt = $mysqli->query("insert into tbl_users_testimoni(nama,jabatan,isi,foto) values('$nama','$jabatan','$isi','$foto'	)");
						if($stmt){
							echo'
								<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data berhasil disimpan!</strong> .
								</div>
								<meta http-equiv="Refresh" content="1; URL=?page=user-testimoni">
							';						
						}else{
							echo'
								<div class="alert alert-danger alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data gagal disimpan!</strong> .
								</div>
							';
							}
					}
				  ?>
					<div class="x_content">
						<table class="table">
							<tr>
								<th >NAMA LENGKAP</th>
								<th>JABATAN</th>
								<th width="50%">ISI TESTIMONI</th>
								<td>AKSI</td>
							</tr>
							<form action="" method="post">
							<tr>
								<td>
									<select name="user" class="form-control">
										<?php
											$data = getDataTable("tbl_users","display_name ASC");
											while($data_user = $data->fetch_object()){
												echo "<option value='".$data_user->display_name."|'".$data_user->url_foto."'>".$data_user->display_name."</option>";
											}
										?>										
									</select>
								</td>
								<td><input type="text" name="jabatan" value=""  class="form-control"></td>
								<td><textarea name="isi" rows="4" class="form-control"></textarea></td>
								<td><input type="submit" class="btn btn-primary" value="SIMPAN" name="btnTambahData"></td>
							</tr>
							</form>
						</table>
					</div>
				</div>
				<?php
					}
				  ?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Data Testimoni</small></h2>
                    <div class="clearfix"></div>
                  </div>                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th>NAMA LENGKAP</th>
                          <th>JABATAN</th>
                          <th>ISI TESTIMONI</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_users_testimoni","created ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_user = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_user->nama.'</td>
										  <td>'.$data_user->jabatan.'</td>
										  <td>'.$data_user->isi.'</td>
										  <td>
											<a href="?page=user-testimoni&edit='.$data_user->id_users_testimoni.'" type="submit" class="btn btn-info" title="Edit Data" /><i class="fa fa-edit"></i></a>
											<a href="?page=user-testimoni&delete='.$data_user->id_users_testimoni.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i></a>
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
