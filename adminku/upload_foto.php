			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				if(isset($_POST['simpan_data'])){
					$nama_foto= $_POST['nama_foto'];
					
					$nama_file = generate().$_FILES['file_foto']['name'];
					$ukuran_file = $_FILES['file_foto']['size'];
					$tipe_file = $_FILES['file_foto']['type'];
					$tmp_file = $_FILES['file_foto']['tmp_name'];
					$path = "../img/foto/".$nama_file;
					if($tipe_file == "image/jpg" || $tipe_file == "image/jpeg" || $tipe_file == "image/png"){ // Cek apakah tipe file yang diupload adalah JPG / JPEG / PNG
							move_uploaded_file($tmp_file, $path);
							$file_foto = str_replace("..","http://pinopi.com",$path);
							$sql = "INSERT into tbl_foto(nama_foto,url_foto) VALUES('$nama_foto','$file_foto')";
							$stmt = $mysqli->query($sql);
							if($stmt){
								echo'
									<div class="alert alert-success alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Data berhasil disimpan!</strong> .
									</div>
									<meta http-equiv="Refresh" content="1; URL=?page=upload-foto">
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
					}else{
						echo'
							<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Format foto salah ( '.$tipe_file.' ), format yang diizinkan jpg/jpeg/png!</strong> .
							</div>
						';
					}					
				}
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_foto where id_foto=".$_GET['delete']."");					
					if($stmt){
						$file_foto = str_replace("http://pinopi.com","..",$_GET['url']);
						unlink($file_foto);
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="1; URL=?page=upload-foto">
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
                    <h2>Kelola Foto</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk menambahkan data silahkan isi form dibawah. Dan untuk mengubah atau menghapus gunakan tombol dipaling kanan pada setiap data.
                    </p>
					<form id="demo-form" action="" method="post" enctype="multipart/form-data">
						<div class="col-md-4">
						  <label for="fullname">Nama Foto</label>
						  <input type="text" id="fullname" class="form-control" name="nama_foto" required />
						</div>
						<div class="col-md-6">
						  <label for="fullname">File Foto:</label>
						  <input type="file" id="fullname" class="form-control" name="file_foto" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname"><hr></label>
						  <input type="submit" class="btn btn-success" name="simpan_data" value="UPLOAD FOTO" />
						</div>
					</form>
					<hr>
					<?php
						$stmt = $mysqli->query("select * from tbl_foto order by created_at DESC");
						while($data = $stmt->fetch_object()){
							echo '
								<div class="col-md-2">
									<div class="x_panel col-md-12">									
										<div class="col-md-12" style="text-align:center;font-weight:bold;">
											'.strtoupper($data->nama_foto).'
										</div>
										<img  src="'.$data->url_foto.'" width="100%">
										<input type="text"  class="col-md-12" value="'.$data->url_foto.'" readonly>
										<a href="?page=upload-foto&delete='.$data->id_foto.'&url='.$data->url_foto.'" class="btn btn-danger btn-xs col-md-12">HAPUS FOTO</a>
									</div>
								</div>
							';
						}
					?>
                </div>
              </div>
