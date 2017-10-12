              <div class="col-md-12">
				<?php
					$link_banner = '#';
					$url_foto = '';
					if(isset($_GET['edit'])){
						$stmt = getDataByCollumn("tbl_banner","id_banner",$_GET['edit']);
						if($stmt->num_rows>0){
							$data_banner = $stmt->fetch_object();
							$link_banner = $data_banner->url_banner;
							$url_foto = $data_banner->url_foto;
						}else{
							echo'
								<div class="alert alert-warning alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data banner tidak ditemukan!</strong> .
								</div>
							';
						}
					}
					if(isset($_GET['delete'])){
						$stmt = $mysqli->query("delete from tbl_banner where id_banner=".$_GET['delete']."");
						if($stmt){
							echo'
								<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data berhasil dihapus!</strong> .
								</div>
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
					if(isset($_POST['simpan_data'])){
						$link_banner = $_POST['link_banner'];
						$tipe_banner = $_POST['tipe_banner'];
						$status = $_POST['status'];
						if(!isset($_GET['edit'])){
							$url_foto = upload_foto("../img/banner/",$_FILES['file_foto'],generateRandomString(10));						
							$sql = ("INSERT into tbl_banner(url_foto,url_banner,tipe_banner,status) VALUES('img/banner/$url_foto','$link_banner','$tipe_banner','$status')");
						}else{
							if(empty($_FILES['file_foto']['name'])){
								$url_foto = $_POST['url_foto'];
							}else{
								unlink('../'.$_POST['url_foto']);
								$url_foto = upload_foto("../img/banner/",$_FILES['file_foto'],generateRandomString(10));
							}
							$sql = ("UPDATE tbl_banner SET url_foto='img/banner/$url_foto',url_banner='$link_banner',tipe_banner='$tipe_banner',status='$status' 
								WHERE id_banner=".$_GET['edit']."");
						}
						$stmt = $mysqli->query($sql);
						if($stmt){
							echo'
								<div class="alert alert-success alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Data berhasil disimpan!</strong> .
								</div>
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
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Kelola Banner Beranda</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="row">

                      <p>Untuk menambahkan banner gunakan form diabawah dan untuk mengubah atau menghapus banner sorot/arahkan mouse pada gambar dan klik tombol edit atau hapus</p>
						<form id="demo-form" action="" method="post" data-parsley-validate enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="url_foto" value="<?php echo $url_foto;?>">
							<div class="col-md-3">
							  <label for="fullname">Foto Banner:</label>
							  <input type="file" class="form-control" name="file_foto" required />
							</div>
							<div class="col-md-3">
							  <label for="fullname">Link Banner ( isi # jika tidak ada ) :</label>
							  <input type="text" id="fullname" class="form-control" name="link_banner" value="<?php echo $link_banner;?>" required />
							</div>
							<div class="col-md-2">
							  <label for="fullname">Tipe Banner:</label>
							  <select class="form-control" name="tipe_banner">
								<option value="panjang">Banner Panjang (atas)</option>
								<option value="persegi">Banner Persegi (bawah)</option>
							  </select>
							</div>
							<div class="col-md-2">
							  <label for="fullname">Status:</label>
							  <select class="form-control" name="status">
								<option value="aktif">Aktif</option>
								<option value="tidak aktif">Tidak Aktif</option>
							  </select>
							</div>
							<div class="col-md-2">
							  <label for="fullname"><hr></label>
							  <input type="submit" class="btn btn-success" name="simpan_data" value="SIMPAN DATA" />
							</div>
						</form>
						<hr>
						<?php
							$stmt = getDataTable('tbl_banner','id_banner DESC');
							while($data_banner = $stmt->fetch_object()){
								echo'
								  <div class="col-md-55">
									<div class="thumbnail">
									  <div class="image view view-first">
										<img style="width: 100%; display: block;" src="../'.$data_banner->url_foto.'" alt="image" />
										<div class="mask">
										  <div class="tools tools-bottom">
											<a href="../'.$data_banner->url_foto.'" target="_blank"><i class="fa fa-eye" title="Lihat Banner"></i></a>
											<a href="?page=banner&edit='.$data_banner->id_banner.'"><i class="fa fa-edit" title="Edit Banner"></i></a>
											<a href="?page=banner&delete='.$data_banner->id_banner.'"><i class="fa fa-trash" title="Hapus Banner"></i></a>
										  </div>
										</div>
									  </div>
									  <div class="caption" align="center">
										<p><b>Tipe Banner : '.$data_banner->tipe_banner.'<br>Status : '.$data_banner->status.'</b></p>
									  </div>
									</div>
								  </div>
								';
							}
						?>
                    </div>
                  </div>
                </div>
              </div>
