			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				if(isset($_POST['simpan_data'])){
					$tipe_diskon = 'produk';
					$id_produk = $_POST['id_produk'];
					$jenis_diskon = $_POST['jenis_diskon'];
					$jumlah_diskon = $_POST['jumlah_diskon'];
					$status_diskon = $_POST['status_diskon'];
					$sql = "INSERT into tbl_diskon(tipe_diskon,id_produk,jenis_diskon,jumlah_diskon,status_diskon) 
					VALUES('$tipe_diskon',$id_produk,'$jenis_diskon',$jumlah_diskon,'$status_diskon')";
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
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_diskon where id_diskon=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=diskon">
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
                    <h2>Kelola diskon</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk menambahkan data diskon silahkan isi form dibawah. Dan untuk mengubah atau menghapus diskon gunakan tombol dipaling kanan pada setiap data.
                    </p>
					<form id="demo-form" action="" method="post" data-parsley-validate>
						<div class="col-md-4">
						  <label for="fullname">Pilih Produk Diskon:</label>
						  <select name="id_produk" class="form-control">
							<?php
								$stmt = getDataTable("tbl_produk where id_produk !=0",'nama_produk ASC');
								if($stmt->num_rows > 0){
									while($data_produk = $stmt->fetch_object()){
										echo "<option value='".$data_produk->id_produk."'>".$data_produk->nama_produk."</option>";
									}
								}else{
									echo "<option>Belum ada data tersedia</option>";
								}
							?>							
						  </select>
						</div>
						<div class="col-md-2">
						  <label for="fullname">Jenis Diskon:</label>
						  <select name="jenis_diskon" class="form-control">
							<option value='rp'>Rupiah</option>
							<option value='%'>Persen</option>
						  </select>
						</div>
						<div class="col-md-2">
						  <label for="fullname">Jumlah Diskon:</label>
						  <input type="number" class="form-control" name="jumlah_diskon" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname">Status Diskon:</label>
							<select class="form-control" name="status_diskon">
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
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th>NAMA PRODUK</th>
                          <th style="width:5%">JENIS</th>
                          <th style="width:20%">JUMLAH DISKON</th>
                          <th style="width:15%">STATUS DISKON</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_diskon","id_diskon DESC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_diskon = $stmt->fetch_object()){
									$data_produk = getDataByCollumn("tbl_produk","id_produk",$data_diskon->id_produk)->fetch_object();
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_produk->nama_produk.'</td>
										  <td>'.$data_diskon->jenis_diskon.'</td>
										  <td>'.$data_diskon->jumlah_diskon.'</td>
										  <td>'.$data_diskon->status_diskon.'</td>
										  <td>
											<a href="?page=diskon&delete='.$data_diskon->id_diskon.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i> HAPUS</a>
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
