<div class="information-blocks">
	<div class="row">
		<?php
		$judul_berita = str_replace("-"," ",$_GET['berita']);
		$stmt = $mysqli->query("select * from tbl_berita where judul_berita = '$judul_berita'");
		if($stmt->num_rows > 0){
		$data = $stmt->fetch_object();
			echo'
			<div class="col-md-10 col-md-offset-1 col-xs-12">
				<div class="panel panel-default  panel-body">
					<div class="col-md-12" style="padding:0px;">
						<img src="'.$data->foto_berita.'" style="margin: 0 auto; display: block;" class="img-responsive">
					</div>
					<div class="col-md-12" style="margin-top: 20px;font-size:2em;font-weight:bold;">
						'.$data->judul_berita.'						
					</div>
					<div class="col-md-12" style="font-size:small;margin-bottom:20px;">
						Diposting tanggal '.date("d M Y",strtotime($data->created_at)).'
					</div>
					<div class="col-md-12" style="line-height: 30px;">
						'.$data->isi_berita.'
					</div>
				</div>
			<br>
			</div>
			';
		}
	?>
	</div>
</div>