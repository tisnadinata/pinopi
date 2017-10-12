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
			<div id="slideshow2" style="background-color: white;background-image:url('<?php echo $url_web."/img/informasi-agen.png"; ?>');background-repeat: no-repeat; background-size: contain; height: 164px">
				<div class="divsatu" >
					<?php
						if(isset($_SESSION['link_affiliate'])){
							$stmt = $mysqli->query("select * from tbl_users where link_affiliate='".$_SESSION['link_affiliate']."'");
							if($stmt->num_rows == 0){
								echo "<center>Affiliate tersebut tidak terdaftar</center>";
								unset($_SESSION['link_affiliate']);
							}else{
								$data = $stmt->fetch_object();
					?>					
						<img src="<?php echo $data->url_foto; ?>" class="divimg" style="width:25%;height:70%;">						
						<div class="divdua">
							<?php echo strtoupper($data->display_name);?><br>
							Paket : <?php echo ucfirst($data->status_akun);?><br>
							<?php echo ($data->telepon);?>
							<br><br>
							<p style="color:#dde848">
							Website Agen / Reseller :<br>
							<?php echo strtolower($data->link_affiliate);?>.pinopi.com
							</p>
						</div>
					<?php
							}
						}else{
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
				$data_banner = getDataByCollumn("tbl_banner","tipe_banner","panjang");
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
