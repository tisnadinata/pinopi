<div class="information-blocks">
	<div class="row">
	<?php
		$stmt = $mysqli->query("select * from tbl_users_testimoni order by created DESC");
		while($data = $stmt->fetch_object()){
			echo'
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default  panel-body">
					<div class="col-md-3">
						<img src="'.$data->foto.'" style="margin: 0 auto; display: block;" class="img-responsive">
					</div>
					<div class="col-md-9" style="line-height: 20px;">
						'.$data->isi.'
						<div style="margin: 10px 0;font-weight:bold;">
								<p>'.$data->nama.'</p>
								<p>'.$data->jabatan.'</p>
						</div>
					</div>
				</div>
			<br>
			</div>
			';
		}
	?>
	</div>
</div>
