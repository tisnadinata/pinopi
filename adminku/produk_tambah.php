              <div class="col-md-10 col-md-offset-1 col-xs-12">
			<?php				
				if(isset($_POST['simpan_data'])){
					$kategori_produk = $_POST['kategori_produk'];
					$nama_produk = $_POST['nama_produk'];
					$harga_nonmember = $_POST['harga_nonmember'];
					$harga_produk = $_POST['harga_produk'];
					$harga_distributor = $_POST['harga_distributor'];
					$bonus_retail = $_POST['bonus_retail'];
					$bonus_distributor = $_POST['bonus_distributor'];
					$bonus_sponsor = $_POST['bonus_sponsor'];
					$bonus_jaringan = $_POST['bonus_jaringan'];
					$berat_produk = $_POST['berat_produk'];
					$deskripsi_produk = $_POST['deskripsi_produk'];
					$stok_produk = $_POST['stok_produk'];
					$warna_produk = $_POST['warna_produk'];
					$status_produk = $_POST['status_produk'];
					if(!isset($_GET['edit'])){
						$url_foto = upload_foto("../img/produk/",$_FILES['file_foto'],$nama_produk);
						$sql = "INSERT into tbl_produk(id_kategori,nama_produk,harga_nonmember,harga_produk,harga_distributor,bonus_retail,bonus_distributor,bonus_sponsor,bonus_jaringan,berat_produk,deskripsi_produk,stok_produk,warna_produk,url_foto,status_produk) 
						VALUES($kategori_produk,'$nama_produk',$harga_nonmember,$harga_produk,$harga_distributor,$bonus_retail,$bonus_distributor,$bonus_sponsor,$bonus_jaringan,$berat_produk,'$deskripsi_produk',$stok_produk,'$warna_produk','img/produk/$url_foto','$status_produk')";
					}else{
						if(empty($_FILES['file_foto']['name'])){
							$url_foto = $_POST['url_foto'];
						}else{
							unlink('../'.$_POST['url_foto']);
							$url_foto = 'img/produk/'.upload_foto("../img/produk/",$_FILES['file_foto'],$nama_produk);
						}
						$sql = "UPDATE tbl_produk set id_kategori='$kategori_produk',nama_produk='$nama_produk',deskripsi_produk='$deskripsi_produk',harga_produk='$harga_produk',harga_nonmember='$harga_nonmember',
						harga_distributor='$harga_distributor',bonus_retail='$bonus_retail',bonus_distributor='$bonus_distributor',bonus_sponsor='$bonus_sponsor',bonus_jaringan='$bonus_jaringan',berat_produk='$berat_produk',
						stok_produk='$stok_produk',warna_produk='$warna_produk',status_produk='$status_produk',url_foto='$url_foto' where id_produk=".$_GET['edit']." ";
					}
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=produk-daftar">
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
                    <h2>Form Tambah Produk</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Produk</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
							<select name="kategori_produk" class="form-control">
							<?php
								$stmt = getDataTable("tbl_kategori","nama_kategori ASC");
								if($stmt->num_rows>0){
									while($data_kategori = $stmt->fetch_object()){
										echo'<option value="'.$data_kategori->id_kategori.'">'.$data_kategori->nama_kategori.'</option>';																			
									}
								}else{
									echo'<option selected>Belum ada data tersedia</option>';
								}
							?>
							</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="nama_produk" placeholder="Nama Lengkap Produk" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Non Member(Rp)</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="harga_nonmember" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Produk(Rp)</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="harga_produk" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Distributor(Rp)</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="harga_distributor" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Retail(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_retail" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Distributor(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_distributor" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Sponsor(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_sponsor" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Jaringan(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_jaringan" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Berat Produk(gram)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="berat_produk" value='1' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi Produk</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control" rows="3" name="deskripsi_produk" placeholder='Deskripsi Lengkap Produk'></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Warna Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="warna_produk" placeholder="Warna paling dominan dari produk"required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Stok Produk</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="stok_produk" value='1' min='1'required>
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
                              <input type="radio" checked="" value="aktif" id="optionsRadios1" name="status_produk"> Aktif (di publish)
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="tidak aktif" id="optionsRadios2" name="status_produk"> Tidak Aktif (tidak di publish)
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Produk</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}else{
					$kategori_produk = '';
					$nama_produk = '';
					$harga_produk = '';
					$harga_nonmember = '';
					$harga_distributor = '';
					$bonus_retail= '';
					$bonus_distributor = '';
					$bonus_sponsor = '';
					$bonus_jaringan = '';
					$berat_produk = '';
					$deskripsi_produk = '';
					$stok_produk = '';
					$warna_produk = '';
					$status_produk = '';
					$stmt = getDataByCollumn("tbl_produk","id_produk",$_GET['edit']);
					if($stmt->num_rows>0){
						$data_produk = $stmt->fetch_object();
						$nama_produk = $data_produk->nama_produk;
						$harga_produk = $data_produk->harga_produk;
						$harga_nonmember = $data_produk->harga_nonmember;
						$harga_distributor = $data_produk->harga_distributor;
						$bonus_retail = $data_produk->bonus_retail;
						$bonus_distributor = $data_produk->bonus_distributor;
						$bonus_sponsor = $data_produk->bonus_sponsor;
						$bonus_jaringan = $data_produk->bonus_jaringan;
						$berat_produk = $data_produk->berat_produk;
						$deskripsi_produk = $data_produk->deskripsi_produk;
						$stok_produk = $data_produk->stok_produk;
						$warna_produk = $data_produk->warna_produk;
						$url_foto = $data_produk->url_foto;
						if($data_produk->status_produk == 'aktif'){
							$status_produk = 'checked';
							$status_produk2 = '';
						}else{
							$status_produk2 = 'checked';
							$status_produk = '';
						}
					}else{
						echo'
							<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data produk tidak ditemukan!</strong> .
							</div>
						';
					}
			?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit Produk</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="url_foto" value="<?php echo $url_foto;?>">
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori Produk</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
							<select name="kategori_produk" class="form-control">
							<?php
								$stmt = getDataTable("tbl_kategori","nama_kategori ASC");
								if($stmt->num_rows>0){
									while($data_kategori = $stmt->fetch_object()){
										if($data_kategori->id_kategori == $data_produk->id_kategori){
											echo'<option value="'.$data_kategori->id_kategori.'" selected>'.$data_kategori->nama_kategori.'</option>';																			
										}else{
											echo'<option value="'.$data_kategori->id_kategori.'">'.$data_kategori->nama_kategori.'</option>';																			
										}
									}
								}else{
									echo'<option selected>Belum ada data tersedia</option>';
								}
							?>
							</select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="nama_produk" value="<?php echo $nama_produk;?>" placeholder="Nama Lengkap Produk" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Non Member(Rp)</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="harga_nonmember"  value="<?php echo $harga_nonmember;?>" min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Produk(Rp)</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="harga_produk"  value="<?php echo $harga_produk;?>" min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Harga Distributor(Rp)</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="harga_distributor" value='<?php echo $harga_distributor;?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Retail(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_retail" value='<?php echo $bonus_jaringan;?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Distributor(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_distributor" value='<?php echo $bonus_jaringan;?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Sponsor(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_sponsor" value='<?php echo $bonus_jaringan;?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bonus Jaringan(Rp)</label>
                        <div class="col-md-3 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="bonus_jaringan" value='<?php echo $bonus_jaringan;?>' min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Berat Produk(gram)</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="berat_produk" value="<?php echo $berat_produk;?>" min='1'required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Deskripsi Produk</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea class="form-control" rows="3" name="deskripsi_produk" placeholder='Deskripsi Lengkap Produk'><?php echo $deskripsi_produk;?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Warna Produk</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="warna_produk" value="<?php echo $warna_produk;?>" placeholder="Warna paling dominan dari produk"required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Stok Produk</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="stok_produk" value="<?php echo $stok_produk;?>" min='1'required>
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
                              <input type="radio" <?php echo $status_produk;?> value="aktif" id="optionsRadios1" name="status_produk"> Aktif (di publish)
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" <?php echo $status_produk2;?> value="tidak aktif" id="optionsRadios2" name="status_produk"> Tidak Aktif (tidak di publish)
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Produk</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}
			?>
