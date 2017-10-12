              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_produk where id_produk=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=produk-daftar">
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
                    <h2>Data Produk</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th >No</th>
                          <th style="width:20%">Nama</th>
                          <th>Harga </th>
                          <th>Harga Member</th>
                          <th>Harga Distributor</th>
                          <th>Berat</th>
                          <th style="width:20%">Deskripsi</th>
                          <th>Foto</th>
                          <th>Status</th>
                          <th style="width:10%"></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt = getDataTable("tbl_produk where id_produk !=0","nama_produk ASC");
							if($stmt->num_rows>0){
								$no=1;
								while($data_produk = $stmt->fetch_object()){									
									echo"
										<tr>
										  <td align='center'>".$no."</td>
										  <td>".$data_produk->nama_produk."</td>
										  <td>Rp".setHargaRupiah($data_produk->harga_nonmember)."</td>
										  <td>Rp".setHargaRupiah($data_produk->harga_produk)."</td>
										  <td>Rp".setHargaRupiah($data_produk->harga_distributor)."</td>
										  <td>".$data_produk->berat_produk." gram</td>
										  <td>".substr($data_produk->deskripsi_produk,0,100)."</td>
										  <td><a href='http://pinopi.com/".$data_produk->url_foto."' target='_blank'>LIHAT</a></td>
										  <td>".$data_produk->status_produk."</td>
										  <td>
											<a href='?page=produk-tambah&edit=".$data_produk->id_produk."' type='submit' class='btn btn-info btn-xs' title='Edit Data' />UBAH</i></a>
											<a href='?page=produk-daftar&delete=".$data_produk->id_produk."' type='submit' class='btn btn-danger btn-xs' title='Hapus Data' />HAPUS</i></a>
										  </td>
										</tr>
									";
									$no++;
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
