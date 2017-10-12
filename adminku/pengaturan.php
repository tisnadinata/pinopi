			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				if(isset($_POST['simpan_data'])){
					$nama_pengaturan = $_POST['nama_pengaturan'];
					$value_pengaturan = $_POST['value_pengaturan'];
					$sql = "UPDATE tbl_pengaturan set nama_pengaturan='$nama_pengaturan',value_pengaturan='$value_pengaturan' where nama_pengaturan='".$nama_pengaturan."' ";
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
                    <h2>Kelola Pengaturan</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk mengubah data pengaturan silahkan pilih nama pengaturan lalu isi data yang baru.
                    </p>
					<form id="demo-form" action="" method="post" data-parsley-validate>
						<div class="col-md-3">
						  <label for="fullname">Nama Pengaturan:</label>
							<select name="nama_pengaturan" class="form-control">
								<?php
									$stmt = getDataTable("tbl_pengaturan","id_pengaturan ASC");
									if($stmt->num_rows>0){
										while($data_pengaturan = $stmt->fetch_object()){
											echo"<option value='".$data_pengaturan->nama_pengaturan."'>".$data_pengaturan->nama_pengaturan."</option>";
										}
									}else{
										echo"<option>Belum ada data tersedia</option>";
									}
								?>
							</select>
						  </div>
						<div class="col-md-7">
						  <label for="fullname">Value Baru:</label>
						  <textarea class="form-control" name="value_pengaturan" required></textarea>
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
                          <th style="width:25%">NAMA PENGATURAN</th>
                          <th>VALUE PENGATURAN</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_pengaturan","id_pengaturan ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_pengaturan = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_pengaturan->nama_pengaturan.'</td>
										  <td>'.$data_pengaturan->value_pengaturan.'</td>
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
