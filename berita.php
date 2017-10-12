<div class="information-blocks">
	<div class="row">
	<?php
		$stmt = $mysqli->query("select * from tbl_berita order by created_at DESC");
		while($data = $stmt->fetch_object()){
			echo'
			<div class="col-md-4 col-xs-12">
				<div class="panel panel-default  panel-body">
					<div class="col-md-12" style="padding:0px;">
						<img src="'.$data->foto_berita.'" style="margin: 0 auto; display: block;" class="img-responsive">
					</div>
					<div class="col-md-12" style="margin-top: 10px;font-size:2em;font-weight:bold;">
						'.$data->judul_berita.'						
					</div>
					<div class="col-md-12" style="font-size:small;margin-bottom:10px;">
						Diposting tanggal '.date("d M Y",strtotime($data->created_at)).'
					</div>
					<div class="col-md-12" style="line-height: 20px;">
						'.substr($data->isi_berita,0,500).'... <a href="http://pinopi.com/news/'.str_replace(" ","-",$data->judul_berita).'" target="_blank" >selengkapnya</a>
					</div>
				</div>
			<br>
			</div>
			';
		}
	?>
	</div>
</div>
