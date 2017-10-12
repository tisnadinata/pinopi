<div class="information-blocks">
	<div class="row">
		<div class="col-md-7 col-xs-10 panel panel-primary" style="margin-left:20px;">
			<div class="panel panel-heading">		
				<center>POSTING FACEBOOK WITH PINOPI
			</div>
			<div class="panel panel-body">		
<?php
	if(isset($_POST['go'])){
		$attachment =  array(
			"access_token" => $_SESSION['fb_access_token'],
			"message" => $_POST['isi'],			
			"link" => "http://pinopi.com",
			"picture" => "",
			"name" => "PINOPI | Opportunity For Everyone",
			"caption" => "PINOPI | Opportunity For Everyone",
			"description" => "PINOPI | Opportunity For Everyone"
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/'.$_SESSION['user_facebook_id'].'/feed');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //to suppress the curl output 
		$result = curl_exec($ch);
		curl_close($ch);
		if(strpos($result,"error")){
			echo'
				<div class="message-box message-danger">
					<div class="message-icon"><i class="fa fa-check"></i></div>
					<div class="message-text"><b>Maaf, gagal melakukan post</b></div>
					<div class="message-close"><i class="fa fa-times"></i></div>
				</div>                    
			';
		}else{
			echo'
				<div class="message-box message-success">
					<div class="message-text"><b>Postingan berhasil di publikasikan, silahkan cek di beranda anda</b></div>
					<div class="message-close"><i class="fa fa-times"></i></div>
				</div>                    
			';
		}
	}
?>
				<div style="text-align:center;font-size:20px;font-weight:bold;">Promosikan website kami dengan langsung membuat status mengenai kami, isi form dibawah untuk melakukannya :</div>
				<form action="" method="post">
					<table width="100%" border="0" class="table table-consended">
						<tr>
							<td>
							<textarea name="isi" class="form-control" rows="10" style="width:100%"></textarea>
							</td>
						</tr>
						<tr>
							<td>
							<input type="submit" style="text-align:right;float:right;" class="btn btn-primary" name="go" value="POST TO FACEBOOK" >
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="col-md-4 col-xs-12 panel panel-primary" style="margin-left:20px;">
			<div class="panel panel-heading">	
				CONTOH STATUS YANG AKAN DI PUBLISH
			</div>
			<div class="panel panel-body">	
			<div style="text-align:center;font-size:20px;font-weight:bold;">Konten yang ditampilkan akan seperti dibawah :</div>
				<img src="contoh.png" width="100%">
			</div>
		</div>
	</div>
</div>