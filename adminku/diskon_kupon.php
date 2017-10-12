			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				if(isset($_POST['simpan_data'])){
					$status_kupon = 'aktif';
					$kode_kupon = $_POST['kode_kupon'];
					$tipe_potongan = $_POST['jenis_diskon'];
					$jumlah_potongan = $_POST['jumlah_diskon'];
					$maksimal_potongan = $_POST['maksimal_potongan'];
					$minimal_belanja = $_POST['minimal_belanja'];
					$sql = "INSERT into tbl_kupon(kode_kupon,tipe_potongan,jumlah_potongan,maksimal_potongan,minimal_belanja,status_kupon) 
					VALUES('$kode_kupon','$tipe_potongan',$jumlah_potongan,$maksimal_potongan,$minimal_belanja,'$status_kupon')";
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
					$stmt = $mysqli->query("delete from tbl_kupon where id_kupon=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=diskon-semua">
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
						<div class="col-md-2">
						  <label for="fullname">Kode Diskon/Kupon:</label>
						  <input type="text" class="form-control" name="kode_kupon" required />
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
						  <label for="fullname">Max. Diskon(Rp):</label>
						  <input type="number" class="form-control" name="maksimal_potongan" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname">Min. Belanja(Rp):</label>
						  <input type="number" class="form-control" name="minimal_belanja" required />
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
                          <th>KODE KUPON</th>
                          <th style="width:5%">TIPE</th>
                          <th style="width:10%">JUMLAH</th>
                          <th style="width:20%">MAKSIMAL DISKON</th>
                          <th style="width:20%">MINIMAL PEMBELIAN</th>
                          <th style="width:15%">STATUS DISKON</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_kupon","id_kupon DESC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_diskon = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_diskon->kode_kupon.'</td>
										  <td>'.$data_diskon->tipe_potongan.'</td>
										  <td>'.$data_diskon->jumlah_potongan.'</td>
										  <td>Rp'.setHargaRupiah($data_diskon->maksimal_potongan).'</td>
										  <td>Rp'.setHargaRupiah($data_diskon->minimal_belanja).'</td>
										  <td>'.$data_diskon->status_kupon.'</td>
										  <td>
											<a href="?page=diskon-semua&delete='.$data_diskon->id_kupon.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i> HAPUS</a>
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
