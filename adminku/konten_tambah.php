              <div class="col-md-10 col-md-offset-1 col-xs-12">
			<?php				
				if(isset($_POST['simpan_data'])){
					$isi_konten = $_POST['isi_konten'];
					$url_konten = $_POST['url_konten'];
					$sosmed = $_POST['sosmed'];
					$tipe_konten = $_POST['tipe_konten'];
					if(!isset($_GET['edit'])){
						$sql = "INSERT into tbl_konten_promo(isi_konten,url_konten,tipe_konten,sosmed) 
						VALUES('$isi_konten','$url_konten','$tipe_konten','$sosmed')";
					}else{
						$sql = "UPDATE tbl_konten_promo set isi_konten='$isi_konten',url_konten='$url_konten',
						tipe_konten='$tipe_konten',sosmed='$sosmed' where id_konten=".$_GET['edit'];
					}
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=konten-daftar">
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
                    <h2>Form Tambah Konten Promo</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Isi Konten Promo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" rows="6" name="isi_konten" required></textarea>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
							<b>Keterangan :</b>
							<ul>
								<li>[link_affiliate] = menampilkan link affilaite/subdomain user</li>
								<li>[name] = menampilkan nama user</li>
								<li>[telepon] = menampilkan nomor telepon user</li>
								<li>[email] = menampilkan email user</li>
							</ul>						  
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">URL Foto/Video Konten</label>
                        <div class="col-md-4 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="url_konten" required>
                        </div>
                      </div>
                      <div class="form-group">                       
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Sosial Media</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="facebook" id="optionsRadios1" name="sosmed"> Facebook
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="twitter" id="optionsRadios2" name="sosmed"> Twitter
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="instagram" id="optionsRadios2" name="sosmed"> Instagram
                            </label>
                          </div>
                        </div>
						 <label class="control-label col-md-2 col-sm-2 col-xs-12">Tipe Konten</label>
                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <div class="radio">
                            <label>
                             <input type="radio" checked="" value="fptp" id="optionsRadios1" name="tipe_konten"> Foto
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="video" id="optionsRadios2" name="tipe_konten"> Video
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Konten</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}else{
					$isi_konten = '';
					$url_konten = 1;
					$tipe_konten = '';
					$tipe_konten = '';
					
					$stmt = getDataByCollumn("tbl_konten_promo","id_konten",$_GET['edit']);
					if($stmt->num_rows>0){
						$data_konten = $stmt->fetch_object();
						$isi_konten = $data_konten->isi_konten;
						$url_konten = $data_konten->url_konten;
					}else{
						echo'
							<div class="alert alert-warning alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data konten tidak ditemukan!</strong> .
							</div>
						';
					}
			?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Edit Konten Promo</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                     <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" class="form-control" name="url_foto" value="<?php echo $url_foto;?>">
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Isi Konten Promo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" name="isi_konten" ><?php echo $isi_konten?></textarea>
                        </div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<b>Keterangan :</b>
							<ul>
								<li>[link_affiliate] = menampilkan link affilaite/subdomain user</li>
								<li>[name] = menampilkan nama user</li>
								<li>[telepon] = menampilkan nomor telepon user</li>
								<li>[email] = menampilkan email user</li>
							</ul>						  
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">URL Foto/Video</label>
                        <div class="col-md-4 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" name="url_konten" value='<?php echo $url_konten?>' required>
                        </div>
                      </div>
                      <div class="form-group">
                        
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Sosial Media</label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="facebook" id="optionsRadios1" name="sosmed"> Facebook
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="twitter" id="optionsRadios2" name="sosmed"> Twitter
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="instagram" id="optionsRadios2" name="sosmed"> Instagram
                            </label>
                          </div>
                        </div>
						 <label class="control-label col-md-2 col-sm-2 col-xs-12">Tipe Konten</label>
                        <div class="col-md-2 col-sm-3 col-xs-12">
                          <div class="radio">
                            <label>
                             <input type="radio" checked="" value="fptp" id="optionsRadios1" name="tipe_konten"> Foto
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="video" id="optionsRadios2" name="tipe_konten"> Video
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">Simpan Data Konten</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>
			<?php
				}
			?>
