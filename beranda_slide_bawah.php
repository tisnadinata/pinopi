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
	<div class="col-md-8 col-xs-12 cd">
		<div id="slideshow">
		<iframe class="yusup" src="https://www.youtube.com/embed/NqRs3g6MJcc?autoplay=0&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
		<!--<?php
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
			?>-->
		</div>
	</div>
	