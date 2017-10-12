              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_konten_promo where id_konten=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=konten-daftar">
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
                    <h2>Data Konten</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th style="width:50%">Isi Konten</th>
                          <th style="width:11.2%">Url Konten</th>
                          <th style="width:11.2%">Tipe Konten</th>
                          <th style="width:11.2%"></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							if(isset($_GET['sosmed'])){
								$stmt = getDataByCondition("tbl_konten_promo","sosmed='$_GET[sosmed]'","id_konten DESC");
							}else{
								$stmt = getDataTable("tbl_konten_promo","id_konten DESC");
							}
							if($stmt->num_rows>0){
								while($data_konten = $stmt->fetch_object()){
									echo"
										<tr>
										  <td>".$data_konten->isi_konten."</td>
										  <td><a href='".$data_konten->url_konten."' target='_blank'>LIHAT</a></td>
										  <td>".$data_konten->tipe_konten."</td>
										  <td>
											<a href='?page=konten-tambah&edit=".$data_konten->id_konten."' type='submit' class='btn btn-info' title='Edit Data' /><i class='fa fa-edit'></i></a>
											<a href='?page=konten-daftar&delete=".$data_konten->id_konten."' type='submit' class='btn btn-danger' title='Hapus Data' /><i class='fa fa-trash'></i></a>
										  </td>
										</tr>
									";
								}
							}else{
								echo"<tr><td colspan='7'>Belum ada data tersedia.</td></tr>";
							}
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
