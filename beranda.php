<style>
	.product-beranda{
		height:300px;
	}
	.hargae{
		margin-top:25px;
		text-align: center;
	}
	.namae{
		color:white;
		text-align:left;
		margin-left: 5px;
		font-size: 17px;
	}
	.tombol{
		margin-top:15px;
	}
	.product-beranda{
		height:325px !important;
	}
	.testi-user{
		background-color: #4586C8;padding: 10px;width:73% !important;
	}
	@media (max-width: 767px) {
		.testi-user{
			background-color: #4586C8;padding: 10px;width:100% !important;
		}
		.product-beranda{
			height:275px !important;
		}
		.tombol{
			margin-top:5px;
			width:90% !important;
			text-align:center;
		}
		.information-blocks .df {
			padding: 0;
			margin-top: 25px;
		}
		.hargae{
			height:auto;
			margin-top:10px;
			text-align: center;
		}

		.product-beranda{
			height:210px;
		}

		.merahh{
			visibility: hidden; display: none;
		}
	}
</style>
                <div class="information-blocks vb" style="margin-bottom: 30px;font-family:arial !important;">
                    <div class="row">
                        <div class="col-md-12">
							<?php
								include 'beranda_slide_atas.php';
							?>
                        </div>
                    </div>
                </div>

                <div class="information-blocks" style="border-top:1px solid #dfdfdf;padding:30px 0px 0px 0px;margin-bottom: 0px;font-family:arial !important;">
					<div class="tabs-container">
						<div>
							<div class="tabs-entry">
								<div class="row shop-grid grid-view">
									<?php
										$data_produk = getDataByCondition("tbl_produk","id_produk != 0","rand() DESC LIMIT 0,4");
										if($data_produk->num_rows > 0){
											while($getData = $data_produk->fetch_object()){
												$kategori_produk = getDataByCollumn("tbl_kategori","id_kategori",$getData->id_kategori)->fetch_object();
									?>
												<div class="col-md-3 col-xs-6">
													<div class="product-slide-entry product-beranda">
														<div class="product-image">
															<img src="<?php echo $url_web.'/'.$getData->url_foto;?>" alt="" />
															<div class="bottom-line">
																<a class="bottom-line-a" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><i class="fa fa-eye"></i> Lihat Produk</a>
															</div>
														</div>
														<div class="col-md-12" style="padding:0px;">
															<a class="title namae" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><?php echo $getData->nama_produk;?></a>
														</div>
														<div class="col-md-8 hargae" style="padding:0px;">
															<div class="price" style="color:white;text-align:left;margin-left: 5px;" >
																<?php
																	echo '
																		<div class="current" style="color:white !important;text-align:left;font-size:15px;">Rp'.setHargaRupiah(getProdukHargaNonmember($getData->id_produk)).'</div>
																	';
																?>

															</div>
														</div>
														<div class="col-md-4 tombol">
															<a class="btn btn-primary" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>">BELI</a>
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
							</div>
						</div>
					</div>
                </div>
                <div class="information-blocks" style="border-bottom:1px solid #dfdfdf;padding:0px 0px 0px 0px;margin-bottom: 20px;">
					<div class="tabs-container">
						<div class="swiper-tabs tabs-switch">
							<div class="title">TESTIMONI KAMI</div>
							<div class="list">
								<a class="block-title tab-switcher active">TESTIMONI KAMI</a>
								<div class="clear"></div>
							</div>
                        </div>
						<div class="row" style="margin-bottom: 20px; font-family: Arial; margin-left:5px;">
							<div class="col-md-9 testi-user">
								<?php
									$stmt = $mysqli->query("select * from tbl_users_testimoni LIMIT 1");
									while($data = $stmt->fetch_object()){
										echo'
										<div class="row">
											<div class="col-md-2" style="padding-right:0px;">
												<img src="'.$data->foto.'" style="margin: 4px 2px; display: block;" class="img-responsive">
											</div>
											<div class="col-md-10" style="color: #fff; line-height: 20px;text-align:justify;">
												'.$data->isi.'
												<div style="margin: 10px 0">
													<p>'.$data->nama.'</p>
													<p>'.$data->jabatan.'</p>
												</div>
											</div>
										</div>
										';
									}
								?>
							</div>
							<!--<div class="col-md-2 merahh" style="height: 180px; width: 258px; background-color: #C52227; margin-left:10px;"></div>-->
							<div class="col-md-2 merahh" style="height: 180px; width: 240px; background-color: #C52227; margin-left:2.87%;"></div>
						</div>
					</div>
                </div>
               <div class="information-blocks">
                    <div class="row">

                        <div class="col-md-12">
							<?php
								include 'beranda_slide_bawah.php';
							?>
                        </div>

                    </div>
                </div>
