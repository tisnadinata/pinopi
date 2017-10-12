			  <div class="col-md-12 col-sm-12 col-xs-12">
              <?php
				if(isset($_POST['send'])){
					$untuk = $_POST['untuk'];
					$pesan = $_POST['pesan'];
					$sql = "INSERT into tbl_users_message(dari,untuk,pesan) VALUES(0,$untuk,'$pesan')";
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Pesan berhasil dikirim!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=message">
						';						
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Gagal mengirim pesan!</strong> .
							</div>
						';
					}
				}
				if(isset($_GET['delete'])){
					$stmt = $mysqli->query("delete from tbl_users_message where id_users_message=".$_GET['delete']."");
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Pesan berhasil dihapus!</strong> .
							</div>
							<meta http-equiv="Refresh" content="2; URL=?page=message">
						';						
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Pesan gagal dihapus!</strong> .
							</div>
						';
					}
				}
			  ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Kelola Pesan</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Untuk mengirim pesan anda hanya perlu mengisi pesan apa yang ingin dikirim lalupilih tujuan pengiriman
                    </p>
					<form id="demo-form" action="" method="post" data-parsley-validate>
						<div class="col-md-4">
						  <label for="fullname">Tujuang pengiriman pesan ::</label>
							<select name="untuk" class="form-control">
						  <?php
							$stmt = $mysqli->query("select * from tbl_users where id_users != 0 order by display_name ASC");
							while($tujuan = $stmt->fetch_object()){
								echo'
									<option value="'.$tujuan->id_users.'">'.$tujuan->display_name.'</option>
								';
							}
						  ?>
							</select>
						</div>
						<div class="col-md-6">
						  <label for="fullname">Isi Pesan:</label>
						  <input type="text" id="fullname" class="form-control" name="pesan" required />
						</div>
						<div class="col-md-2">
						  <label for="fullname"><hr></label>
						  <input type="submit" class="btn btn-success" name="send" value="KIRIM PESAN" />
						</div>
					</form>
					<hr>
                    <table id="datatable" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th style="width:5%">NO</th>
                          <th>PENGIRIM</th>
                          <th>PENERIMA</th>
                          <th>PESAN</th>
                          <th>TANGGAL</th>
                          <th>STATUS</th>
                          <th style="width:12%">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php
							$stmt=getDataTable("tbl_users_message","created DESC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_pesan = $stmt->fetch_object()){
									$dari = getDataByCollumn("tbl_users","id_users",$data_pesan->dari)->fetch_object();
									$untuk = getDataByCollumn("tbl_users","id_users",$data_pesan->untuk)->fetch_object();
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$dari->display_name.'</td>
										  <td>'.$untuk->display_name.'</td>
										  <td>'.$data_pesan->pesan.'</td>
										  <td>'.$data_pesan->created.'</td>
										  <td>'.$data_pesan->status.'</td>
										  <td>
											<a href="?page=message&delete='.$data_pesan->id_users_message.'" type="submit" class="btn btn-danger" title="Hapus Data" /><i class="fa fa-trash"></i></a>
										  </td>
										</tr>								
									';
									$i++;
								}
							}else{
								echo"<tr><td colspan='4'>Belum ada data yang tersedia</td></tr>";
							}
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
