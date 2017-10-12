<?php
$deskripsi_toko_row=$deskripsi_toko->row();
$logo_row=$logo->row();
$judul_row=$judul->row();
$telepon_row=$telepon->row();
$facebook_row=$facebook->row();
$instagram_row=$instagram->row();
$email_row=$email->row();
$data['instagram']=$instagram_row;
$angka=0;
?>


<body class="style-16" style="background-image: url(<?php echo base_url('assets/img/background.jpg');?>); background-attachment: fixed;">
	    
    <!-- LOADER     <div id="loader-wrapper">
        <div class="bubbles">
            <div class="title">loading</div>
            <span></span>
            <span id="bubble2"></span>
            <span id="bubble3"></span>
        </div>
    </div>
-->

    <div id="content-block">
        <div class="content-center fixed-header-margin" style="margin-left:1%;">
            <!-- HEADER -->
            <div class="header-wrapper style-16">
                <header class="type-4" style="position: absolute;">
                    <div class="header-top">
                        <div class="header-top-entry">
                            <div class="title"><img src="<?php echo base_url('assets/img/flag_id.png');?>" alt="" />Indonesia<i class="fa fa-caret-down"></i></div>
                        </div>
                        <div class="header-top-entry" style="margin-right: 400px; float: right;">
                            <div class="title">
                            <i class="fa fa-phone"></i>
                            Cust Service : <?php echo $telepon_row->value_pengaturan;?></div>
                       </div>
                        <div class="menu-button responsive-menu-toggle-class"><i class="fa fa-reorder"></i></div>
                        <div class="clear"></div>
                    </div>
									<div class="header-middle">
                        <div class="logo-wrapper">
                            <a id="logo" href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/'.$logo_row->value_pengaturan);?>" alt="" /></a>
                        </div>
										<div class="right-entries" style="width:auto;margin-left:10px;">
<!--                             <a class="header-functionality-entry open-cart-popup hidden-xs" href="#"><i class="fa fa-shopping-cart"></i><span style="color:white;">Keranjang</span> <strong>Rp<?php //echo number_format($angka,2,',','.'); ?></strong></a> -->
                            <a class="header-functionality-entry open-cart-popup visible-xs" href="<?php echo base_url('/cart');?>"><i class="fa fa-shopping-cart"></i><span>Keranjang</span> <strong>Rp<?php echo  number_format($angka,2,',','.'); ?></strong></a>
                         </div>
						
                    </div>
									 <div class="close-header-layer"></div>
                    <div class="navigation">
                        <div class="navigation-header responsive-menu-toggle-class">
                            <div class="title">Navigation</div>
                            <div class="close-menu"></div>
                        </div>
                        <div class="nav-overflow">
                            <nav>
															<?php
															$this->load->view('header_menu',$data);
															?>
															<div class="clear"></div>

                                <a class="fixed-header-visible additional-header-logo"><img src="<?php echo base_url('assets/'.$logo_row->value_pengaturan);?>" alt=""/></a>
													</nav>
													<div class="navigation-footer responsive-menu-toggle-class">
                                <div class="socials-box">
                                    <a href="<?php echo $facebook_row->value_pengaturan;?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="<?php echo $instagram_row->value_pengaturan;?>" target="_blank"><i class="fa fa-instagram"></i></a>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
									<div class="box-login">
                        <a href="<?php echo base_url('daftar');?>"><p>LOGIN/DAFTAR</p>
                        <span>via facebook</span></a>
                    </div>
									</header>
							<div class="clear"></div>
							</div>

            <div class="content-push">
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
													<style>
	.divsatu{
		z-index:3;
		width:100%;
		height:100%;
		padding:45px 0px 0px 35px;
	}
	.divimg{
/*		width:120px;
		height:120px;*/
		float:left;
		margin-top:0;
	}
	.divdua{
		float:left;
		padding: 0 8px;
		font-size: 14px;
		font-weight: bold;
		color:white;
	}

	.divimg_normal{
		width:120px;height:120px;float:left;
	}
	.divdua_normal{
		float:left;padding:10px 0px 0px 20px;font-size: 15px;font-weight: bold;color:white;
	}
	@media (max-width: 767px) {
		.information-blocks .df {
			padding: 0;
			margin-top: 25px;
		}
		.divsatu{padding:45px 0px 0px 35px;}
	}
	@media (max-width: 1200px)	{
		.divdua{font-size: 12px; padding: 0px 0px 0px 3px;}
		/*.divsatu{padding: 25px 0px 0px 10px;}*/
		.divsatu{padding: 35px 0px 0px 35px;}
	}
	.information-blocks .df {
			padding: 0 !important;
	}	
</style>
	<div class="col-md-4" >
		<div class="col-md-12" style="padding:2px">
			<div id="slideshow2" style="background-color: white;background-image:url('<?php echo base_url('assets/img/informasi-agen.png');?>');background-repeat: no-repeat; background-size: contain; height: 164px">
				<div class="divsatu" >
					<?php
						if(!(empty($_SESSION['link_affiliate']))){
							if($affiliate->num_rows() == 0)
								echo "<center>Affiliate tersebut tidak terdaftar</center>";
						else
								$data = $affiliate->row();
							echo '<img src="'.$data->url_foto.'" class="divimg" style="width:25%;height:70%;">						
						<div class="divdua">
							'.strtoupper($data->display_name).'<br>
							Paket : '.($data->status_akun).'<br>
							'.($data->telepon).'
							<br><br>
							<p style="color:#dde848">
							Website Agen / Reseller :<br>
							'.strtolower($data->link_affiliate).'.pinopi.com
							</p>
						</div>';
						} else {
							echo "<center><b>Tidak Ada Affiliate</b></center>";
						}
					?>	
					</div>
			</div>
		</div>
		<div class="col-md-12" style="padding:2px;padding-top:0px;">
		<div>
			<div id="slideshow3">
			   <div>
				 <img src="<?php echo base_url('assets/img/banner/member-kiri.jpg');?>" style="width:330px;">
			   </div>
			</div>
		</div>
		</div>
		</div>
													<div class="col-md-8 col-xs-12 df">
		<div class="col-md-12" style="padding:2px">
			<div id="slideshow4">
				<?php
				$data_banner = $banner;
				if($data_banner->num_rows() > 1){
					while($getData = $data_banner->row()){
						?>
						   <div>
							 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url('assets/'.$getData->url_foto); ?>" style="width:695px;">
						   </div>
						<?php
					}
				}else{
					$getData = $data_banner->row();
					?>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url('assets/'.$getData->url_foto); ?>" style="width:695px;">
					   </div>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url('assets/'.$getData->url_foto); ?>" style="width:695px;">
					   </div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
 </div>
                    </div>
                </div>
							<div class="information-blocks" style="border-top:1px solid #dfdfdf;padding:30px 0px 0px 0px;margin-bottom: 0px;font-family:arial !important;min-height:550px;">
					<div class="tabs-container">
						<div>
							<div class="tabs-entry">
								<div class="row shop-grid grid-view">
									<?php

										if($produk->num_rows() > 0){
												foreach($produk->result() as $getData){
												$kategori_produk = $getData->id_kategori;
													$link_produk=strtolower(str_replace(" ","-",$getData->nama_produk));
													echo '<div class="col-md-3 col-xs-6">
													<div class="product-slide-entry product-beranda">
														<div class="product-image">
															<img src="'.base_url('/assets/'.$getData->url_foto).'" alt="" />
															<div class="bottom-line">
																<a class="bottom-line-a" href="'.base_url('/produk/'.$getData->id_produk).'"><i class="fa fa-eye"></i> Lihat Produk</a>
															</div>
														</div>
														<div class="col-md-12" style="padding:0px;">
															<a class="title namae" href="'.base_url('/produk/'.$getData->id_produk).'">'.$getData->nama_produk.'</a>
														</div>
														<div class="col-md-8 hargae" style="padding:0px;">
															<div class="price" style="color:white;text-align:left;margin-left: 5px;" >
																		<div class="current" style="color:white !important;text-align:left;font-size:15px;">Rp'.number_format($getData->harga_nonmember,2,',','.').'</div>
																	';
echo '
															</div>
														</div>
														<div class="col-md-4 tombol">
															<a class="btn btn-primary" href="'.base_url('/produk/'.$getData->id_produk).'">BELI</a>
														</div>
													</div>
													<div class="clear"></div>
												</div>';
												} 
										}else echo "<label><center>Maaf, belum ada data tersedia.</center></label><br>";
									?>
									</div>
							</div>
						</div>
					</div>
                </div>
							
							<div class="information-blocks" style="border-bottom:1px solid #dfdfdf;padding:0px 0px 0px 0px;margin-bottom: 20px;">
					<div class="tabs-container">
						<div class="swiper-tabs tabs-switch">
							<br><br>
							<div class="title">TESTIMONI KAMI</div>
							<div class="list">
								<a class="block-title tab-switcher active">TESTIMONI KAMI</a>
								<div class="clear"></div>
							</div>
                        </div>
						<div class="row" style="margin-bottom: 20px; font-family: Arial; margin-left:5px;">
							<div class="col-md-9 testi-user">
								<?php
									foreach($testimoni->result() as $data){
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
							<div class="row">
							<div class="information-blocks">
                    <div class="row">

                        <div class="col-md-12">
					
                        </div>

                    </div>
                </div>
								<div class="col-md-4 col-xs-12" >
				<div id="slideshow5">
					  <?php
				if($banner_persegi->num_rows() > 1){
					foreach($banner_persegi->result() as $getData){
						?>
						   <div>
							 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url("/assets/".$getData->url_foto); ?>">
						   </div>
						<?php
					}
				}else{
					$getData = $banner_persegi->row();
					?>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url("/assets/".$getData->url_foto); ?>">
					   </div>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo base_url("/assets/".$getData->url_foto); ?>">
					   </div>
					<?php
				}
			?>
				</div>
	</div>
								<style type="text/css">
		.yusup{
			width:690px;
			height:100%;
		}
	@media(max-width: 767px) {
		.cd {
			margin-top: 25px;
			padding: 0;
		}
		.yusup{
			/*width:300px;*/
			width:100%;
		}

	}
	</style>
							<div class="col-md-8 col-xs-12">
		<div id="slideshow">
		<iframe class="yusup" src="https://www.youtube.com/embed/NqRs3g6MJcc?autoplay=0&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>

		</div>
								<br>
								</div>
	</div>