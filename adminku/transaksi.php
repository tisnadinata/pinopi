              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php
				if(isset($_GET['set'])){
					date_default_timezone_set('Asia/Jakarta');
					$set = explode('-',$_GET['set']);
					$id_transaksi=$set[1];
					$tanggal= date("Y-m-d H:i:s");
					$status_transaksi=$set[0];
					$keterangan=getTransaksiKeterangan($set[0]);
					$stmt = $mysqli->query("insert into tbl_transaksi_status(id_transaksi,tanggal,status_transaksi,keterangan) 
							VALUES($id_transaksi,'$tanggal','$status_transaksi','$keterangan')");
					if($set[0] == 'PROCESSING'){
						$page = '?page=transaksi&status=proses';
					}else if($set[0] == 'SHIPPED'){
						$page = '?page=transaksi&status=dikirim';
						setBonusTransaksi($id_transaksi);
					}else if($set[0] == 'CANCELED'){
						$page = '?page=transaksi&status=dibatalkan';
					}else if($set[0] == 'DONE'){
						$page = '?page=transaksi&status=selesai';
					}
					
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Status Transaksi Berhasil di Ubah!</strong> .
							</div>							
							<meta http-equiv="Refresh" content="2; URL='.$page.'">
						';
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Status Transaksi Gagal di Ubah!</strong> .
							</div>
						';
					}
				}
				$status_dicari = "CONFIRMED,PROCESSING,SHIPPED,DONE,CANCELED";
				if(isset($_GET['status'])){
					if($_GET['status'] == 'pending'){
						$status_dicari = "PENDING";
					}else if($_GET['status'] == 'baru'){
						$status_dicari = "CONFIRMED";
					}else if($_GET['status'] == 'proses'){
						$status_dicari = "PROCESSING";
					}else if($_GET['status'] == 'dikirim'){
						$status_dicari = "SHIPPED";
					}else if($_GET['status'] == 'selesai'){
						$status_dicari = "DONE";
					}else if($_GET['status'] == 'dibatalkan'){
						$status_dicari = "CANCELED";
					}
				}
				if(!isset($_GET['set'])){
			  ?>
				<div class="x_panel">
                  <div class="x_title">
                    <h2>Data Transaksi </small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
						Gunakan tombol disebelah kanan pada setiap data untuk mengubah atau menghapus data.
                    </p>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>Nomo Invoice</th>
                          <th>Atas Nama</th>
                          <th>Waktu Transaksi</th>
                          <th>Kode Unik</th>
                          <th>Subtotal Transaksi</th>
                          <th>Status</th>
                          <th style="width:14.5%"></th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt = getDataTable("tbl_transaksi","id_transaksi DESC");
							if($stmt->num_rows>0){
								while($data_transaksi = $stmt->fetch_object()){
									if($status_dicari == getStatusTransaksi($data_transaksi->id_transaksi)->status_transaksi){
										if(getStatusTransaksi($data_transaksi->id_transaksi)->status_transaksi == "CONFIRMED"){
											$stat = "<small>Menunggu Verifikasi Admin</small>";
										}else{
											$stat = getStatusTransaksi($data_transaksi->id_transaksi)->status_transaksi;
										}
										echo"
											<tr>
											  <th>".$data_transaksi->invoice_transaksi."</th>
											  <th>".$data_transaksi->atas_nama."</th>
											  <th>".$data_transaksi->tanggal_transaksi."</th>
											  <th>".$data_transaksi->kode_unik."</th>
											  <th>Rp".setHargaRupiah($data_transaksi->total_transaksi)."</th>
											  <th>".$stat."</th>
											  <td>";
												if($_GET['status'] == 'baru'){
													echo"
														<a href='?page=transaksi&set=PROCESSING-".$data_transaksi->id_transaksi."' class='btn btn-info btn-sm' title='Proses Transaksi' /><i class='fa fa-check'></i></a>
													";
												}else if($_GET['status'] == 'proses'){
													?>
														<a onclick="alert('Silahkan masukan nomor resi di bagian detail pesanan...')" href='?page=transaksi&set=SHIPPED-<?php echo $data_transaksi->id_transaksi;?>' class='btn btn-primary btn-sm' title='Kirim Transaksi' /><i class='fa fa-truck'></i></a>
													<?php
												}
												echo"
												<a target='_blank' href='?page=detail-transaksi&transaksi=".$data_transaksi->id_transaksi."' class='btn btn-default btn-sm' title='Detail Transaksi' /><i class='fa fa-eye'></i></a>
												<a href='?page=transaksi&set=CANCELED-".$data_transaksi->id_transaksi."' class='btn btn-danger btn-sm' title='Tolak Transaksi' /><i class='fa fa-remove'></i></a>
											  </td>
											</tr>
										";
									}
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
				<?php } ?>