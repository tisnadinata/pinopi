<?php
	
	if(isset($_POST['sort_page'])){
		$_SESSION['sort_page'] = str_replace("-","_",$_POST['sort_page']);
	}else if(isset($_SESSION['sort_page'])){
		$_SESSION['sort_page'] = $_SESSION['sort_page'];
	}else{
		$_SESSION['sort_page'] = 'id_produk DESC';
	}
	if($_SESSION['sort_page'] == 'id_produk DESC'){
		$selected[0] = "selected";
		$selected[1] = "";
		$selected[2] = "";
	}else if($_SESSION['sort_page'] == 'nama_produk ASC'){
		$selected[0] = "";
		$selected[1] = "selected";
		$selected[2] = "";
	}else if($_SESSION['sort_page'] == 'harga_produk ASC'){
		$selected[0] = "";
		$selected[1] = "";
		$selected[2] = "selected";
	}else{
		$selected[0] = "selected";
		$selected[1] = "";
		$selected[2] = "";
	}
	
	if(isset($_POST['limit_page'])){
		$_SESSION['limit_page'] = $_POST['limit_page'];
	}else if(isset($_SESSION['limit_page'])){
		$_SESSION['limit_page'] = $_SESSION['limit_page'];
	}else{
		$_SESSION['limit_page'] = 20;
	}
	if($_SESSION['limit_page'] == 20){
		$selected[3] = "selected";
		$selected[4] = "";
		$selected[5] = "";
		$selected[6] = "";
	}else if($_SESSION['limit_page'] == 40){
		$selected[3] = "";
		$selected[4] = "selected";
		$selected[5] = "";
		$selected[6] = "";
	}else if($_SESSION['limit_page'] == 60){
		$selected[3] = "";
		$selected[4] = "";
		$selected[5] = "selected";
		$selected[6] = "";
	}else{
		$selected[3] = "selected";
		$selected[4] = "";
		$selected[5] = "";
	}

	if(isset($_GET['halaman'])){
		$halaman = ($_GET['halaman']-1)*$_SESSION['limit_page'];
	}else{
		$halaman = 0;
	}
	$_SESSION['kategori_page'] = $_GET['kategori'];
?>
<style>
	.form-kategori{
		width:125%;		
	}
	.entry-kategori{
		float:right !important;
	}
	@media (max-width: 767px) {
		.form-kategori{
			width:105%;
		}    
		.entry-kategori{
			float:none !important;
		}
	}
</style>
                <div class="information-blocks">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="information-blocks categories-border-wrapper">
                                <div class="block-title size-3">Daftar Kategori</div>
                                <div class="accordeon">
                                    <div class="accordeon-title">Kategori</div>
                                    <div class="accordeon-entry">
                                        <div class="article-container style-1">
											<ul>
												<?php
													echo'<li><a href="'.$url_web.'/kategori"></i>Semua Kategori</a></li>';
													$stmt = getDataByCondition("tbl_kategori",'id_kategori != 0',"nama_kategori ASC");
													if($stmt->num_rows > 0){
														while($data_kategori = $stmt->fetch_object()){
															if($_SESSION['kategori_page'] == $data_kategori->nama_kategori){
																$id_kategori = $data_kategori->id_kategori;
															}
															echo'<li><a href="'.$url_web.'/kategori/'.$data_kategori->nama_kategori.'"></i>'.ucfirst($data_kategori->nama_kategori).'</a></li>';
														}
													}else{
														echo'<li><a href="#"></i>Belum ada kategori</a></li>';
													}
												?>
											</ul>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="page-selector">                                
                                <div class="shop-grid-controls">
									<form action="" method="post" class="form-kategori" >
										<div class="entry">
											<div class="inline-text">Urut berdasarkan</div>
											<div class="simple-drop-down" style="width:auto;">
												<select name="sort_page">
													<option value='id-produk DESC' <?php echo $selected[0];?>>Produk Terbaru</option>
													<option value='nama-produk ASC' <?php echo $selected[1];?>>Nama Produk</option>
													<option value='harga-produk ASC' <?php echo $selected[2];?>>Harga Produk</option>
												</select>
											</div>
										</div>
										<div class="entry">
											<div class="inline-text">Tampilkan</div>
											<div class="simple-drop-down" style="width: 75px;">
												<select name="limit_page">
													<option value="20" <?php echo $selected[3];?>>20</option>
													<option value="40" <?php echo $selected[4];?>>40</option>
													<option value="60" <?php echo $selected[5];?>>60</option>
												</select>
											</div>
											<div class="inline-text">per halaman</div>
										</div>
										<div class="entry entry-kategori">
											<input type="submit" name="set_filter" class="button btn-default " value="TAMPILKAN"/>
										</div>
									</form>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="row shop-grid grid-view">
                                <?php
									if($_SESSION['kategori_page'] == 'semua'){
										$data_produk = getDataByCondition("tbl_produk","id_produk != 0",$_SESSION['sort_page']." LIMIT $halaman,".$_SESSION['limit_page']);
										$jum_page = ceil(getDataByCondition("tbl_produk","id_produk != 0",$_SESSION['sort_page'])->num_rows/$_SESSION['limit_page']);
										$sub_kategori = "";
									}else if($_SESSION['kategori_page'] != 'semua'){
										$data_produk = getDataByCondition("tbl_produk","id_produk != 0 AND id_kategori=$id_kategori",$_SESSION['sort_page']." LIMIT $halaman,".$_SESSION['limit_page']);
										$jum_page = ceil(getDataByCondition("tbl_produk","id_produk != 0 AND id_kategori=$id_kategori",$_SESSION['sort_page'])->num_rows/$_SESSION['limit_page']);
										$sub_kategori = $_SESSION['kategori_page']."/";
									}else{
										$data_produk = getDataByCondition("tbl_produk","id_produk != 0",$_SESSION['sort_page']." LIMIT $halaman,".$_SESSION['limit_page']);
										$jum_page = ceil(getDataByCondition("tbl_produk","id_produk != 0",$_SESSION['sort_page'])->num_rows/$_SESSION['limit_page']);
										$sub_kategori = "";
									}
									if($data_produk->num_rows > 0){
										while($getData = $data_produk->fetch_object()){
											$kategori_produk = getDataByCollumn("tbl_kategori","id_kategori",$getData->id_kategori)->fetch_object();
								?>
											<div class="col-md-3 col-sm-4 shop-grid-item">
												<div class="product-slide-entry">
													<div class="product-image">
														<img src="<?php echo $url_web.'/'.$getData->url_foto;?>" alt="" />
														<div class="bottom-line">
															<a class="bottom-line-a" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><i class="fa fa-eye"></i> Lihat Produk</a>
														</div>
													</div>
													<a class="tag" href="<?php echo $url_web.'/kategori/'.strtolower(str_replace(" ","-",$kategori_produk->nama_kategori));?>"><?php echo $kategori_produk->nama_kategori;?></a>
													<a class="title" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><?php echo $getData->nama_produk;?></a>
													<div class="price">
														<?php
															if(getProdukHarga($getData->id_produk) != getProdukHargaDiskon($getData->id_produk)){
																echo '
																	<div class="prev">Rp'.setHargaRupiah(getProdukHarga($getData->id_produk)).'</div>
																	<div class="current">Rp'.setHargaRupiah(getProdukHargaDiskon($getData->id_produk)).'</div>
																';
															}else{
																echo '
																	<div class="current">Rp'.setHargaRupiah(getProdukHarga($getData->id_produk)).'</div>
																';
															}
														?>
													</div>
												</div>
												<div class="clear"></div>
											</div>
									<?php		
										}
									}else{
										echo "<label><center>Maaf, belum ada data tersedia.</center></label><br>";
									}
								?>
                            </div>
                            <div class="page-selector">
								<div class="pages-box">
							<?php
								for($p=1;$p<=$jum_page;$p++){
									if($_GET['halaman'] == $p){
										echo'
											<a href="'.$url_web."/kategori/$sub_kategori".$p.'" class="square-button active">'.$p.'</a>                                   
										';
									}else{
										echo'
											<a href="'.$url_web."/kategori/$sub_kategori".$p.'" class="square-button">'.$p.'</a>                                   
										';
									}
								}
								if($halaman == $jum_page){
									echo '
										<li class="disabled">
										  <a href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										  </a>
										</li>
									';
								}else{
									echo '
										<li>
										  <a href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										  </a>
										</li>
									';
								}
							?>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
 