              <div class="col-md-10 col-md-offset-1 col-xs-12">
			<?php	
				if(isset($_POST['simpan_data'])){
					$user = getDataByCollumn("tbl_users","id_users",$_GET['user'])->fetch_object();
					$user_alamat = getDataByCollumn("tbl_users_alamat","id_users",$_GET['user'])->fetch_object();
					$sql_transaksi = "insert into tbl_transaksi(id_users,invoice_transaksi,atas_nama,tanggal_transaksi,email) 
										values(".$user->id_users.",'PNP-SLD-PDG-".$user->id_users."','".$user->display_name."','".date("Y-m-d H:i:s")."','".$user->email."')";
					$stmt = $mysqli->query($sql_transaksi);
					if($stmt){
						$transaksi = getDataByCollumn("tbl_transaksi","invoice_transaksi",'PNP-SLD-PDG-'.$user->id_users)->fetch_object();
						$sql_detail_1 = "insert into tbl_transaksi_detail(id_transaksi,nama_produk,isi_produk,qty,harga_produk) 
											values(".$transaksi->id_transaksi.",'PNP-SLD-PDG-".$user->id_users."','".$_POST['11']."',".$_POST['1'].",0)";
						$sql_detail_2 = "insert into tbl_transaksi_detail(id_transaksi,nama_produk,isi_produk,qty,harga_produk) 
											values(".$transaksi->id_transaksi.",'PNP-SLD-PDG-".$user->id_users."','".$_POST['33']."',".$_POST['3'].",0)";
						$sql_detail_3 = "insert into tbl_transaksi_detail(id_transaksi,nama_produk,isi_produk,qty,harga_produk) 
											values(".$transaksi->id_transaksi.",'PNP-SLD-PDG-".$user->id_users."','".$_POST['44']."',".$_POST['4'].",0)";
						$sql_detail_4 = "insert into tbl_transaksi_detail(id_transaksi,nama_produk,isi_produk,qty,harga_produk) 
											values(".$transaksi->id_transaksi.",'PNP-SLD-PDG-".$user->id_users."','".$_POST['66']."',".$_POST['6'].",0)";
						$stmt = $mysqli->query($sql_detail_1);
						$stmt = $mysqli->query($sql_detail_2);
						$stmt = $mysqli->query($sql_detail_3);
						$stmt = $mysqli->query($sql_detail_4);
						if($stmt){
							$sql_pembayaran = "insert into tbl_transaksi_pembayaran(id_transaksi,metode_pembayaran,status_pembayaran) values(".$transaksi->id_transaksi.",'pencairan saldo pending','sudah dibayar')";
							$stmt = $mysqli->query($sql_pembayaran);
							if($stmt){
								$sql_pengiriman = "insert into tbl_transaksi_pengiriman(id_transaksi,metode_pengiriman,biaya_pengiriman,nama_penerima,alamat_pengiriman,telepon_pengiriman,catatan_pengiriman)
													values(".$transaksi->id_transaksi.",'KHUSUS',0,'".$user->display_name."','".$user_alamat->alamat."','".$user->telepon."','Transaksi dari pencairan saldo pending')";
								$stmt = $mysqli->query($sql_pengiriman);
								if($stmt){
									$sql_status = "insert into tbl_transaksi_status(id_transaksi,tanggal,status_transaksi,keterangan) 
													values(".$transaksi->id_transaksi.",'".date('Y-m-d H:i:s')."','PROCESSING','Transaksi langsung diproses dari pencairan saldo pending')";
									$stmt = $mysqli->query($sql_status);
									if($stmt){
										$mysqli->query("update tbl_users set saldo_pending=0 where id_users=".$_GET['user']."");
										echo'
												<div class="alert alert-success alert-dismissible fade in" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
													</button>
													<strong>Berhasil Melakukan pencairan - Pesanan otomatis akan diproses, anda dapat melihat di bagian transaksi diproses</strong> .
												</div>
													<meta http-equiv="Refresh" content="1; URL=?page=user-bonus">
											';											
									}else{
										echo'
											<div class="alert alert-danger alert-dismissible fade in" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
												</button>
												<strong>Gagal Melakukan pencairan - 5</strong> .
											</div>
										';
									}
								}else{
									echo'
										<div class="alert alert-danger alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
											</button>
											<strong>Gagal Melakukan pencairan - 4</strong> .
										</div>
									';
								}
							}else{
								echo'
									<div class="alert alert-danger alert-dismissible fade in" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
										</button>
										<strong>Gagal Melakukan pencairan - 3</strong> .
									</div>
								';
							}
						}else{
							echo'
								<div class="alert alert-danger alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
									</button>
									<strong>Gagal Melakukan pencairan - 2</strong> .
								</div>
							';
						}
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Gagal Melakukan pencairan - 1</strong> .
							</div>
						';
					}								
				}else{
					
				}
			?>
				 <div class="x_panel">
                  <div class="x_title">
                    <h2>Pencairan Dana Pending</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					Tentukan jumlah produk yang akan dikirim ke alamat user :
                    <br />
                    <form class="form-horizontal form-label-left" action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">For Night Use 28CM</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="1" value='1' min='1'required>
                          <input type="hidden" class="form-control" name="11" value='For Night Use 28CM'>
                        </div>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">For Extra Night Use 32CM</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="3" value='1' min='1'required>
                          <input type="hidden" class="form-control" name="33" value='For Extra Night Use 32CM'>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">For Pantyliner 15CM</label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input type="number" class="form-control" name="4" value='1' min='1'required>
                          <input type="hidden" class="form-control" name="44" value='For Pantyliner 15CM'>
                        </div>                      
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">For Day Use 24CM</label>
                        <div class="col-md-2 col-sm-8 col-xs-12">
                          <input type="number" class="form-control" name="6" value='1' min='1'required>
                          <input type="hidden" class="form-control" name="66" value='For Day Use 24CM'>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-7 col-sm-7 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success pull-right" name="simpan_data">PROSES PENCAIRAN</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              