              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_produk_paket where id_produk_paket=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=paket-daftar">
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
                    <h2>Data paket</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Potongan Harga</th>
                          <th style="width:30%">Isi Paket</th>
                          <th>Foto</th>
                          <th>Status</th>
                          <th style="width:11.2%"></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt = getDataTable("tbl_produk_paket","nama_paket ASC");
							if($stmt->num_rows>0){
								while($data_paket = $stmt->fetch_object()){
									echo"
										<tr>
										  <th>".$data_paket->nama_paket."</th>
										  <th>Rp".setHargaRupiah($data_paket->potongan_harga)."</th>
										  <th>";
											$isi_paket = explode(",",$data_paket->isi_paket);
											for($i=1;$i<(count($isi_paket)-1);$i++){
												$stmt2 = getDataByCollumn("tbl_produk","id_produk",$isi_paket[$i]);
												if($stmt2->num_rows > 0){
													$data_produk = $stmt2->fetch_object();
													echo'<small>'.$data_produk->nama_produk.'</small>,';
												}
											}
									echo "</th>
										  <th><a href='http://pinopi.com/".$data_paket->url_foto."' target='_blank'>LIHAT</a></th>
										  <th>".$data_paket->status_paket."</th>
										  <td>
											<a href='?page=paket-tambah&edit=".$data_paket->id_produk_paket."' type='submit' class='btn btn-info' title='Edit Data' /><i class='fa fa-edit'></i></a>
											<a href='?page=paket-daftar&delete=".$data_paket->id_produk_paket."' type='submit' class='btn btn-danger' title='Hapus Data' /><i class='fa fa-trash'></i></a>
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
