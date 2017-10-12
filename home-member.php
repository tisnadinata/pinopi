<style type="text/css">
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
	.testimoni_class{
		background-color: #4586C8;padding: 10px;width:74.25%
	}
	.yusup{
		width:690px;
		height:100%;
	}
	.sd2{
		background-size: contain; 
	}
	@media (max-width: 767px) {
		.sd2{
			background-size: cover;
			margin: 15px 0px;			
		}
		.testimoni_class{
			background-color: #4586C8;padding: 10px;width:100%
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
		body.style-16 .information-blocks	{margin-bottom: 2px;}
		.yusup{
			/*width:300px;*/
			width:100%;
		}
	}

</style>
<div class="information-entry" style="font-family:arial !important;">
	<div class="row">
		<div class="col-md-12 text-center">
			<p style="color: red; margin-bottom: 15px;font-weight:bold;"><b>Website Agen / Reseller Anda</b> : http://<?php echo ($_SESSION['user_link_affiliate']);?>.pinopi.com</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center visible-xs" style="padding: 0px 17.5px;">
			<div class="box">
				<div class="long" style="background-color:#4585C9;padding:10px;color:white !important">
					<p style="margin-top:1%"><strong>Penghasilan Anda : Rp 
					<?php
						$data = getDataByCollumn("tbl_users","id_users",$_SESSION['user_login'])->fetch_object();
						$total_penghasilan = $data->saldo+$data->saldo_pending;
						echo setHargaRupiah($total_penghasilan);
					?>
					</strong></p>
					<p>(cair setiap senin min 100 ribu)</p>
				</div>
				<div class="tall" style="background-color:#c62127;;padding:10px">
					<a style="color:white !important" href="http://pinopi.com/income">Lihat detail</a>
				</div>
			</div>
		</div>
	<div class="col-md-4">
		<div class="col-md-12" style="padding:2px">
			<div id="slideshow2" class="sd2" style="background-color: white;background-image:url('<?php echo $url_web."/img/info-agen-merah.png"; ?>');background-repeat: no-repeat; height: 164px">
				<div class="divsatu" >
					<img src="<?php echo ($_SESSION['user_foto']);?>" class="divimg" style="width:30%;height:70%;">
					<div class="divdua">
						<?php echo strtoupper($_SESSION['user_display_name']);?><br>
						Paket : <?php echo ucfirst($_SESSION['user_status']);?><br>
						<?php echo ($_SESSION['user_telepon']);?>
						<br><br>
						<a href="<?php echo $url_web;?>/edit-profile" style="color: yellow">Edit profile | </a>
						<a href="logout.php" style="color: yellow">Logout</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12" style="padding:2px;padding-top:0px;">
		<div>
			<div id="slideshow3">
				<div>
				 <img src="<?php echo $url_web."/";?>img/banner/member-kiri.jpg" style="width:330px;">
			</div>
			</div>
		</div>
		</div>
	</div>
	<div class="col-md-8 col-xs-12 df">
		<div class="col-md-12" style="padding:2px">
			<div id="slideshow4">
				<?php
				$data_banner = getDataByCondition("tbl_banner","tipe_banner = 'panjang'","rand()");
				if($data_banner->num_rows > 1){
					while($getData = $data_banner->fetch_object()){
						?>
						   <div>
							 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>" style="width:695px;">
						   </div>
						<?php
					}
				}else{
					$getData = $data_banner->fetch_object();
					?>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>" style="width:695px;">
					   </div>
					   <div>
						 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>" style="width:695px;">
					   </div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	</div>
	
	<div class="information-blocks" style="padding:30px 0px 0px 0px;margin-bottom: 0;">
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
												<a class="title" style="color:white;text-align:left;margin-left: 5px;font-size: 13px;" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><?php echo $getData->nama_produk;?></a>
											</div>
											<div class="col-md-8 hargae" style="padding:0px;">
												<div class="price" style="color:white;text-align:left;margin-left: 5px;" >
													<?php
														echo "<div class='prev' style='color:#989898 !important;text-align:left;font-size:15px;'>Rp".setHargaRupiah(getProdukHargaNonmember($getData->id_produk))."</div>";
														if($_SESSION['user_status'] == "distributor"){
															echo "<div class='current' style='color:white !important;text-align:left;font-size:15px;'>Rp".setHargaRupiah(getProdukHargaDistributor($getData->id_produk))."</div>";											
														}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
															echo "<div class='current' style='color:white !important;text-align:left;font-size:15px;'>Rp".setHargaRupiah(getProdukHarga($getData->id_produk))."</div>";											
														}
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
	<div class="information-blocks">
	<div class="col-md-12">
		<div class="row" style="margin-bottom: 20px; font-family: Arial">
			<div class="col-md-9 testimoni_class">
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
			<div class="col-md-2 merahh" style="height: 180px;width: 240px;background-color: #C52227;margin-left: 2.8%;"></div>
		</div>
	</div>
	</div>
	<hr>
	<div class="information-blocks">
		<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-12">
				<div class="col-md-4" style="padding:0px">
					<div id="slideshow5">
						  <?php
					$data_banner = getDataByCondition("tbl_banner","tipe_banner = 'persegi'","rand()");
					if($data_banner->num_rows > 1){
						while($getData = $data_banner->fetch_object()){
							?>
							   <div>
								 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>">
							   </div>
							<?php
						}
					}else{
						$getData = $data_banner->fetch_object();
						?>
						   <div>
							 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>">
						   </div>
						   <div>
							 <img onClick="window.open('<?php echo $getData->url_banner;?>')" src="<?php echo $url_web."/".$getData->url_foto; ?>">
						   </div>
						<?php
					}
				?>
					</div>
				</div>
		<style type="text/css">
		@media(max-width: 767px) {
			.cd {
				margin-top: 25px;
				padding: 0;
			}
		}
		</style>
		
		<div class="information-blocks">
			<div class="col-md-8 col-xs-12 cd">
				<div id="slideshow">
					<iframe class="yusup" src="https://www.youtube.com/embed/NqRs3g6MJcc?autoplay=0&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    	$(".kotak-login").html("<h3 style='font-size: 20px;text-align: center;'><strong><a href='logout.php' style='color:white;'>Logout</a></strong></h3>");
    	$(".box-login").html("<h3 style='color: #fff;text-align: center;'><strong><a href='logout.php' style='color:white;'>Logout</a></strong></h3>");
    });
</script>