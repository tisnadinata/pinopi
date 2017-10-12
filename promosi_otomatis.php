<div class="information-blocks">
	<div class="row">
		<?php
			if(isset($_POST['btnSimpanFB'])){
				$stmt = $mysqli->query("update tbl_promo_fb set status_promo='".$_POST['status_promo_fb']."', delay=".$_POST['delay_fb']." where id_users=".$_SESSION['user_login']);
				if($stmt){
					echo'
						<div class="message-box message-success">
							<div class="message-icon"><i class="fa fa-check"></i></div>
							<div class="message-text"><b>Settingan facebook promosi berhasil diperbaharui</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}else{
					echo'
						<div class="message-box message-danger">
							<div class="message-text"><b>Gagal memperbaharui settingan facebook promosi</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}
			}
			if(isset($_POST['btnSimpanTw'])){
				$stmt = $mysqli->query("update tbl_promo_tw set status_promo='".$_POST['status_promo_tw']."', delay=".$_POST['delay_tw']." where id_users=".$_SESSION['user_login']);
				if($stmt){
					echo'
						<div class="message-box message-success">
							<div class="message-icon"><i class="fa fa-check"></i></div>
							<div class="message-text"><b>Settingan twitter promosi berhasil diperbaharui</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}else{
					echo'
						<div class="message-box message-danger">
							<div class="message-text"><b>Gagal memperbaharui settingan twitter promosi</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}
			}
			if(isset($_POST['btnSimpanIg'])){
				$stmt = $mysqli->query("update tbl_promo_ig set status_promo='".$_POST['status_promo_ig']."', delay=".$_POST['delay_ig']." where id_users=".$_SESSION['user_login']);
				if($stmt){
					echo'
						<div class="message-box message-success">
							<div class="message-icon"><i class="fa fa-check"></i></div>
							<div class="message-text"><b>Settingan instagram promosi berhasil diperbaharui</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}else{
					echo'
						<div class="message-box message-danger">
							<div class="message-text"><b>Gagal memperbaharui settingan instagram promosi</b></div>
							<div class="message-close"><i class="fa fa-times"></i></div>
						</div>                    
					';
				}
			}
		?>
		<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 panel panel-primary">
			<div class="panel panel-heading">		
				<h3 style="font-size:200%;text-align;center;">Setting Auto Promosi Facebook</h3>			
			</div>
			<form action="" method="post" class="table-responsive ">
			<table class="table table-bordered table-consended">
			<?php
				$stmt = $mysqli->query("select * from tbl_promo_fb where id_users=".$_SESSION['user_login'])->fetch_object();
				if($stmt->access_token != ""){	
					if($stmt->status_promo == "aktif"){
						$aktif = "selected";
						$tidak_aktif = "";							
					}else{
						$aktif = "";
						$tidak_aktif = "selected";							
					}
					$delay[0] = "";
					for($i=1;$i<5;$i++){
						if($stmt->delay == $i){
							$delay[$i] = "selected";
						}else{
							$delay[$i] = "";
						}
					}
				?>
				<thead>
					<tr>
						<th>Status Promosi</th>
						<th>Masa Aktif Token Sampai</th>
						<th>Promosi Setiap N Hari</th>
						<th width="15%">Setting</th>
					</tr/>
				</thead>
				<tbody>					
					<tr>
						<td align="center">
							<select name="status_promo_fb" class="form-control">
								<option value="aktif" <?php echo $aktif;?>>AKTIF</option>
								<option value="tidak aktif" <?php echo $tidak_aktif;?>>TIDAK AKTIF</option>
							</select>
						</td>
						<td><?php echo $stmt->expired;?></td>
						<td align="center">
							<select name="delay_fb" class="form-control">
								<option value="1" <?php echo $delay[1];?>> 1x sehari </option>
								<option value="2" <?php echo $delay[2];?>> 2x sehari </option>
								<option value="3" <?php echo $delay[3];?>> 3x sehari </option>
								<option value="4" <?php echo $delay[4];?>> 4x sehari </option>
							</select>
						</td>
						<td><input type="submit" class="button  btn-primary" value="UBAH & SIMPAN" name="btnSimpanFB"></td>
					</tr/>
				</tbody>
				<?php
				}else{
					echo '<a href="#"><button class="button  btn-primary col-md-12">SETTING FACEBOOK PROMOSI</button></a>';
				}
				?>
			</table>
			<br>
			</form>
		</div>
		<div class="col-md-10 col-md-offset-1 col-xs-10 panel panel-info">
			<div class="panel panel-heading">		
				<h3 style="font-size:200%;text-align;center;">Setting Auto Promosi Twitter</h3>			
			</div>
			<?php
				$stmt = $mysqli->query("select * from tbl_promo_tw where id_users=".$_SESSION['user_login'])->fetch_object();
				if($stmt->access_token != ""){						
					if($stmt->status_promo == "aktif"){
						$aktif = "selected";
						$tidak_aktif = "";							
					}else{
						$aktif = "";
						$tidak_aktif = "selected";							
					}
					$delay[0] = "";
					for($i=1;$i<5;$i++){
						if($stmt->delay == $i){
							$delay[$i] = "selected";
						}
					}
				?>
			<form action="" method="post" class="table-responsive ">
			<table class="table table-bordered table-consended">
				<thead>
					<tr>
						<th>Status Promosi</th>
						<th>Masa Aktif Token Sampai</th>
						<th>Promosi Setiap N Hari</th>
						<th width="15%">Setting</th>
					</tr/>
				</thead>
				<tbody>					
					<tr>
						<td align="center">
							<select name="status_promo_tw" class="form-control">
								<option value="aktif" <?php echo $aktif;?>>AKTIF</option>
								<option value="tidak aktif" <?php echo $tidak_aktif;?>>TIDAK AKTIF</option>
							</select>
						</td>
						<td><?php echo $stmt->expired;?></td>
						<td align="center">
							<select name="delay_tw" class="form-control">
								<option value="1" <?php echo $delay[1];?>> 1x sehari </option>
								<option value="2" <?php echo $delay[2];?>> 2x sehari </option>
								<option value="3" <?php echo $delay[3];?>> 3x sehari </option>
								<option value="4" <?php echo $delay[4];?>> 4x sehari </option>
							</select>
						</td>
						<td><input type="submit" class="button  btn-info" value="UBAH & SIMPAN" name="btnSimpanTw"></td>
					</tr/>
				</tbody>
			</form>
			</table>
			<br>
				<?php
				}else{
					echo '
					<div class="panel panel-body">
							<a href="twitter-post.php?id_user='.$_SESSION['user_login'].'&consumer_secret=bPxCZEKGyvRE1CJ15qVf01Qri34ex2eQXVfGzDxNJcpE3ch75G&consumer_key=wc0rQxVJVWM0Vm9ApYxqbEDko" target="_blank">
								<button class="button  btn-info col-md-12">SETTING TWITTER PROMOSI</button>
								</a>
					</div>
								';
				}
				?>
		</div>
		<div class="col-md-10 col-md-offset-1 col-xs-10 panel panel-warning">
			<div class="panel panel-heading">		
				<h3 style="font-size:200%;text-align;center;">Setting Auto Promosi Instagram</h3>			
			</div>
			<table class="table table-bordered table-consended">
				<?php
				$stmt = $mysqli->query("select * from tbl_promo_ig where id_users=".$_SESSION['user_login']);				
				if($stmt->num_rows > 0){
					$stmt = $stmt->fetch_object();
					if($stmt->username != ""){				
						if($stmt->status_promo == "aktif"){							
							$aktif = "selected";
							$tidak_aktif = "";							
						}else{
							$aktif = "";
							$tidak_aktif = "selected";							
						}
						$delay[0] = "";
						for($i=1;$i<5;$i++){
							if($stmt->delay == $i){
								$delay[$i] = "selected";
							}
						}
					?>
					<thead>
						<tr>
							<th>Status Promosi</th>
							<th>Masa Aktif Token Sampai</th>
							<th>Promosi Setiap N Hari</th>
							<th width="15%">Setting</th>
						</tr/>
					</thead>
					<tbody>
						<tr>
							<td align="center">
								<select name="status_promo_ig" class="form-control">
									<option value="aktif" <?php echo $aktif;?>>AKTIF</option>
									<option value="tidak aktif" <?php echo $tidak_aktif;?>>TIDAK AKTIF</option>
								</select>
							</td>
							<td><?php echo $stmt->expired;?></td>
							<td align="center">
								<select name="delay_ig" class="form-control">
									<option value="1" <?php echo $delay[1];?>> 1x sehari </option>
									<option value="2" <?php echo $delay[2];?>> 2x sehari </option>
									<option value="3" <?php echo $delay[3];?>> 3x sehari </option>
									<option value="4" <?php echo $delay[4];?>> 4x sehari </option>
								</select>
							</td>
							<td><input type="submit" class="button  btn-warning" value="UBAH & SIMPAN" name="btnSimpanIg"></td>
						</tr/>
					</tbody>
					<?php
					}else{
						echo '<a href="#"><button class="button  btn-warning col-md-12">SETTING INSTAGRAM PROMOSI</button></a>';
					}
				}else{
					echo '<a href="#"><button class="button  btn-warning col-md-12">SETTING INSTAGRAM PROMOSI</button></a>';
				}
				?>
			</table>
			<br>	
		</div>
	</div>
</div>