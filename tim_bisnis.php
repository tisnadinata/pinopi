<div class="information-blocks">
	<div class="row">
		<div class="col-md-10 col-md-offset-1 panel panel-default panel-body">		
			<h3 class="block-title main-heading">Tim Bisnis Anda Saat ini</h3>
			<?php
				$upline = getDataByCollumn("tbl_users","link_affiliate",$_SESSION['user_upline'])->fetch_object();
			?>
			<div class="col-md-4 col-xs-12">
				<div style="text-align:center;">
					<b style="color:red;font-weight:bold;">
						LINK AFFILIATE/REFERAL ANDA <br>
						http://<?php echo $_SESSION['user_link_affiliate'];?>.pinopi.com
					</b>
					<br><br>
					Link referal/affiliate dapat anda gunakan untuk mendaftarkan orang lain yang nantinya anda akan dijadikan sebaga referal dari orang tersebut. 
					Keuntungan menjadi referal diantaranya :
					<ul>
						<li>1. Mendapatkan bonus penjualan </li>
						<li>2. Mendapatkan bonus jaringan tim bisnis </li>
					</ul>
					<br>
				</div>	
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr><th colspan="2" style="background-color: #333333;color:white;"><b>Data Referal Anda : (yang mendaftarkan anda)</b></th></tr>
						<tr>
							<td><b>Nama</b></td>
							<td><?php echo $upline->display_name?></td>
						</tr>
						<tr>
							<td><b>Telepon :</b></td>
							<td><?php echo $upline->telepon?></td>
						</tr>
						<tr>
							<td><b>Email :</b></td>
							<td><?php echo $upline->email?></td>
						</tr>
					</table>			
				</div>
			</div>
			<div class="col-md-8 col-xs-12 table-responsive">
				<table class="table table-bordered">
						<tr><th colspan="4" style="background-color: #333333;color:white;"><b>Jaringan Tim Bisnis Anda :</b></th></tr>
						<tr>
							<td align='center' style='font-weight:bold'>TIM BISNIS</td>
							<td align='center' style='font-weight:bold'>STATUS RESELLER</td>
							<td align='center' style='font-weight:bold'>STATUS AGEN</td>
							<td align='center' style='font-weight:bold'>STATUS DISTRIBUTOR</td>
						</tr>
					<?php
						displayTree();
					?>
				</table>			
			</div>
		</div>
	</div>
</div>