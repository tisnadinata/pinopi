<div class="row top_tiles">
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
	  <div class="count">
		<?php
			$stmt = $mysqli->query("select *  from tbl_produk");
			echo $stmt->num_rows;
		?>
	  </div>
	  <h3>Produk Terdaftar</h3>
	</div>
  </div>  
  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
	  <div class="count">
		<?php
			$jum = 0;
			$stmt = $mysqli->query("select *  from tbl_transaksi,tbl_transaksi_status where tbl_transaksi.id_transaksi = tbl_transaksi_status.id_transaksi AND tbl_transaksi_status.status_transaksi = 'CONFIRMED'");
			while($data = $stmt->fetch_object()){
				$stmt2 = $mysqli->query("select status_transaksi from tbl_transaksi_status where id_transaksi=".$data->id_transaksi);
				if($stmt2->num_rows <= 2){
					$jum++;
				}
			}
			echo $jum;
		?>
	  </div>
	  <h3>Transaksi Menunggu </h3>
	</div>
  </div>  
</div>