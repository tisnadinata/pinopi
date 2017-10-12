			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				$_SESSION['nama_kategori'] = '';
				$_SESSION['deskripsi_kategori'] = '';
				if(isset($_POST['simpan_data'])){
					$nama_kategori = $_POST['nama_kategori'];
					$deskripsi_kategori = $_POST['deskripsi_kategori'];
					if(!isset($_GET['edit'])){
						$sql = "INSERT into tbl_kategori(nama_kategori,deskripsi_kategori) VALUES('$nama_kategori','$deskripsi_kategori')";
					}else{
						$sql = "UPDATE tbl_kategori set nama_kategori='$nama_kategori',deskripsi_kategori='$deskripsi_kategori' where id_kategori=".$_GET['edit']." ";
					}
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=kategori">
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
				if(isset($_GET['edit'])){
					$stmt = getDataByCollumn("tbl_kategori","id_kategori",$_GET['edit']);
					if($stmt->num_rows>0){
						$data_kategori = $stmt->fetch_object();
						$_SESSION['nama_kategori'] = $data_kategori->nama_kategori;
						$_SESSION['deskripsi_kategori'] = $data_kategori->deskripsi_kategori;
					}
				}
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_kategori where id_kategori=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=kategori">
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
                    <h2>Kelola Kategori</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk menambahkan data kategori silahkan isi form dibawah. Dan untuk mengubah atau menghapus kategori gunakan tombol dipaling kanan pada setiap data.
                    </p>
					<form id="demo-form" action="" method="post" data-parsley-validate>
						<div class="col-md-4">
						  <label for="fullname">Nama Kategori:</label>
						  <input type="text" id="fullname" class="form-control" name="nama_kategori" value="<?php echo $_SESSION['nama_kategori']?>" required />
						</div>
						<div class="col-md-6">
						  <label for="fullname">Deskripsi Kategori:</label>
						  <input type="text" id="fullname" class="form-control" name="deskripsi_kategori" value="<?php echo $_SESSION['deskripsi_kategori']?>" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname"><hr></label>
						  <input type="submit" class="btn btn-success" name="simpan_data" value="SIMPAN DATA" />
						</div>
					</form>
					<hr>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th>NAMA KATEGORI</th>
                          <th>DESKRIPSI KATEGORI</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_kategori","nama_kategori ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_kategori = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_kategori->nama_kategori.'</td>
										  <td>'.$data_kategori->deskripsi_kategori.'</td>
										  <td>
											<a href="?page=kategori&edit='.$data_kategori->id_kategori.'" type="submit" class="btn btn-info" title="Edit Data" /><i class="fa fa-edit"></i></a>
											<a href="?page=kategori&delete='.$data_kategori->id_kategori.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i></a>
										  </td>
										</tr>								
									';
									$i++;
								}
							}else{
								echo"<tr><td colspan='4'>Belum ada data yang tersedia</td></tr>";
							}
						?>
                    </table>
                  </div>
                </div>
              </div>
