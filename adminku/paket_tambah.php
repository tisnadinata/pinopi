              <div class="col-md-10 col-md-offset-1 col-xs-12">
			<?php				
				if(isset($_POST['simpan_data'])){
					$nama_paket = $_POST['nama_paket'];
					$potongan_harga = $_POST['potongan_harga'];
					$produk_paket = $_POST['isi_paket'];
					$isi_paket = ',';
					for($i = 0;$i<$_POST['byk_produk'];$i++){
						if(isset($produk_paket[$i])){
							$isi_paket = $isi_paket.$produk_paket[$i].',';							
						}
					}
					$deskripsi_paket = $_POST['deskripsi_paket'];
					$status_paket = $_POST['status_paket'];
					if(!isset($_GET['edit'])){
						$url_foto = upload_foto("../img/paket/",$_FILES['file_foto'],$nama_paket);
						$sql = "INSERT into tbl_produk_paket(nama_paket,potongan_harga,isi_paket,deskripsi_paket,status_paket,url_foto) 
						VALUES('$nama_paket',$potongan_harga,'$isi_paket','$deskripsi_paket','$status_paket','img/paket/$url_foto')";
					}else{
						if(empty($_FILES['file_foto']['name'])){
							$url_foto = $_POST['url_foto'];
						}else{
							unlink('../'.$_POST['url_foto']);
							$url_foto = 'img/paket/'.upload_foto("../img/paket/",$_FILES['file_foto'],$nama_paket);
						}
						$produk_paket = $_POST['isi_paket'];
						$isi_paket = ',';
						for($i = 0;$i<$_POST['byk_produk'];$i++){
							if(isset($produk_paket[$i])){
								$isi_paket = $isi_paket.$produk_paket[$i].',';							
							}
						}
						$sql = "UPDATE tbl_produk_paket set nama_paket='$nama_paket',potongan_harga='$potongan_harga',isi_paket='$isi_paket',deskripsi_paket='$deskripsi_paket',
						status_paket='$status_paket',url_foto='$url_foto' where id_produk_paket=".$_GET['edit']." ";
					}
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=paket-daftar">
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
				if(!isset($_GET['edit'])){
					
			?>
				 <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Tambah Paket Produk</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Paket Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="nama_paket" placeholder="Nama Lengkap Paket Produk" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Potongan Harga (Rp)</label>
                        <div class="col-md-4 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="potongan_harga" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Isi Paket</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<div style="max-height:200px;height:250px;padding-top:6px;border: 1px solid #cccccc;overflow-y:scroll;">
							<?php
								$stmt = getDataTable("tbl_produk where id_produk != 0","nama_produk ASC");
								if($stmt->num_rows > 0){
									$byk_produk = 0;
									while($data_produk = $stmt->fetch_object()){
										echo"											
											<div class='col-md-4'>
												<input type='checkbox' name='isi_paket[$byk_produk]' value='".$data_produk->id_produk."'>".$data_produk->nama_produk."
											</div>
										";
										$byk_produk++;
									}
									echo"<input type='hidden' name='byk_produk' value='$byk_produk'>";
								}else{
									echo "Belum ada data tersedia";
								}
							?>
							</div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi Produk</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control" rows="3" name="deskripsi_paket" placeholder='Deskripsi Lengkap Paket'></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">URL Foto Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" class="form-control" name="file_foto" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="aktif" id="optionsRadios1" name="status_paket"> Aktif (di publish)
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="tidak aktif" id="optionsRadios2" name="status_paket"> Tidak Aktif (tidak di publish)
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Paket</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}else{
					$nama_paket = '';
					$potongan_harga = 1;
					$produk_paket = '';
					$isi_paket = ',';					
					$deskripsi_paket = '';
					$status_paket = '';
					
					$stmt = getDataByCollumn("tbl_produk_paket","id_produk_paket",$_GET['edit']);
					if($stmt->num_rows>0){
						$data_paket = $stmt->fetch_object();
						$nama_paket = $data_paket->nama_paket;
						$potongan_harga = $data_paket->potongan_harga;
						$isi_paket = $data_paket->isi_paket;
						$deskripsi_paket = $data_paket->deskripsi_paket;
						$url_foto = $data_paket->url_foto;
						if($data_paket->status_paket == 'aktif'){
							$status_paket = 'checked';
							$status_paket2 = '';
						}else{
							$status_paket2 = 'checked';
							$status_paket = '';
						}
					}else{
						echo'
							<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data paket tidak ditemukan!</strong> .
							</div>
						';
					}
			?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit Paket Produk</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                     <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control" name="url_foto" value="<?php echo $url_foto;?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Paket Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="nama_paket" placeholder="Nama Lengkap Paket Produk" value='<?php echo $nama_paket?>' required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Potongan Harga (Rp)</label>
                        <div class="col-md-4 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="potongan_harga" value='<?php echo $potongan_harga?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Isi Paket</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<div style="max-height:200px;height:250px;padding-top:6px;border: 1px solid #cccccc;overflow-y:scroll;">
							<?php
								$stmt = getDataTable("tbl_produk where id_produk != 0","nama_produk ASC");
								if($stmt->num_rows > 0){
									$byk_produk = 0;
									while($data_produk = $stmt->fetch_object()){
										if(strpos($isi_paket,','.$data_produk->id_produk.',') === false){
											$checked = '';
										}else{
											$checked = 'checked';
										}
										echo"
											<div class='col-md-4'>
												<input type='checkbox' $checked name='isi_paket[$byk_produk]' value='".$data_produk->id_produk."'>".$data_produk->nama_produk."
											</div>
										";
										$byk_produk++;
									}
									echo"<input type='hidden' name='byk_produk' value='$byk_produk'>";
								}else{
									echo "Belum ada data tersedia";
								}
							?>
							</div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi Produk</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control" rows="3" name="deskripsi_paket" placeholder='Deskripsi Lengkap Paket'><?php echo $deskripsi_paket?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">URL Foto Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" class="form-control" name="file_foto">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" <?php echo $status_paket;?> value="aktif" id="optionsRadios1" name="status_paket"> Aktif (di publish)
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" <?php echo $status_paket2;?> value="tidak aktif" id="optionsRadios2" name="status_paket"> Tidak Aktif (tidak di publish)
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Paket</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}
			?>
