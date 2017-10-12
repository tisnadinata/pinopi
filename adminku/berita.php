			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				$_SESSION['judul_berita'] = '';
				$_SESSION['isi_berita'] = '';
				$_SESSION['foto_berita'] = '';
				if(isset($_POST['simpan_data'])){
					$judul_berita = $_POST['judul_berita'];
					$isi_berita = $_POST['isi_berita'];
					$foto_berita = $_POST['foto_berita'];
					if(!isset($_GET['edit'])){
						$sql = "INSERT into tbl_berita(judul_berita,isi_berita,foto_berita) VALUES('$judul_berita','$isi_berita','$foto_berita')";
					}else{
						$sql = "UPDATE tbl_berita set judul_berita='$judul_berita',isi_berita='$isi_berita',foto_berita='$foto_berita' where id_berita=".$_GET['edit']." ";
					}
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=berita">
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
					$stmt = getDataByCollumn("tbl_berita","id_berita",$_GET['edit']);
					if($stmt->num_rows>0){
						$data_berita = $stmt->fetch_object();
						$_SESSION['judul_berita'] = $data_berita->judul_berita;
						$_SESSION['isi_berita'] = $data_berita->isi_berita;
						$_SESSION['foto_berita'] = $data_berita->foto_berita;
					}
				}
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_berita where id_berita=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=berita">
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
                    <h2>Kelola Berita</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk menambahkan data silahkan isi form dibawah. Dan untuk mengubah atau menghapus gunakan tombol dipaling kanan pada setiap data.
                    </p>
					<form id="demo-form" action="" method="post" data-parsley-validate>
						<div class="col-md-5">
						  <label for="fullname">Judul Berita:</label>
						  <input type="text" id="fullname" class="form-control" name="judul_berita" value="<?php echo $_SESSION['judul_berita']?>" required />
						</div>
						<div class="col-md-5">
						  <label for="fullname">Foto Berita:</label>
						  <input type="text" id="fullname" class="form-control" name="foto_berita" value="<?php echo $_SESSION['foto_berita']?>" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname"><hr></label>
						  <input type="submit" class="btn btn-success" name="simpan_data" value="SIMPAN DATA BERITA" />
						</div>
						<div class="col-md-12">
						  <label for="fullname">Isi Berita:</label>
						  <textarea id="fullname" class="form-control" rows="4" name="isi_berita" required><?php echo $_SESSION['isi_berita']?></textarea>
						</div>
					</form>
					<hr>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th width="20%">JUDUL BERITA</th>
                          <th>ISI BERITA</th>
                          <th>FOTO BERITA</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_berita","judul_berita ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_berita = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_berita->judul_berita.'</td>
										  <td>'.substr($data_berita->isi_berita,0,200).'... <a href="http://pinopi.com/news/'.str_replace(" ","-",$data_berita->judul_berita).'" target="_blank">SELENGKAPNYA</a></td>
										  <td><a href="'.$data_berita->foto_berita.'" target="_blank">LIHAT</a></td>
										  <td>
											<a href="?page=berita&edit='.$data_berita->id_berita.'" type="submit" class="btn btn-info" title="Edit Data" /><i class="fa fa-edit"></i></a>
											<a href="?page=berita&delete='.$data_berita->id_berita.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i></a>
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
