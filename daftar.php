<script>
	function setSyarat(obj){
		var login = document.getElementById("login");
		var login_img = document.getElementById("login_img");
		if(obj.checked){
			login.style.pointerEvents = 'auto'; 
			login_img.style.opacity = '1'; 
		}else{
			login.style.pointerEvents = 'none';
			login_img.style.opacity = '0.5';
		}
	}
</script>
<div class="information-blocks daftar">
	<div class="row">
		<div class="col-md-12 text-center" style="">
			<p>Pastikan Facebook Anda Sudah <strong>ONLINE</strong> Sebelum Melakukan Login/Daftar<br>Link Website Agen/Reseller Sponsor Anda (Untuk Mendaftar di Aplikasi PINOPI)</p>
			<p style="color: red">
			<?php
				if(isset($_SESSION['link_affiliate'])){
					$cek_aff = $mysqli->query("select * from tbl_users where link_affiliate='".$_SESSION['link_affiliate']."'");
					if($cek_aff->num_rows> 0){
						echo "http://".$_SESSION['link_affiliate'].".pinopi.com";
					}else{
						echo "LINK AFFILIATE YANG ANDA PAKAI TIDAK VALID<br>".$_SESSION['link_affiliate']." TIDAK TERDAFTAR SEBAGAI AFFILIATE";
					}
				}else{
					echo "UNTUK DAFTAR ANDA PERLU MEMASUKAN LINK AFFILIATE";
				}
			?>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box-red">
				<p><u>Segera Download APLIKASI ANDROID PINOPI di HP Anda</u></p>
				<p>Tips 1 : Caranya buka PLAYSTORE (android) di Smartphone anda lalu search "pinopi" kemudian download dan install</p>
				<p>Tips 2 : Pastikan Facebook Anda sudah Online sebelum Mendaftar atau LOgin melalui Aplikasi</p>
			</div>
		</div>
		<div class="col-md-1 hidden-xs" style="background-color: #000; width: 1px !important; padding: 0; height: 140px;"></div>
		<div class="col-md-5 col-xs-12 text-center">
			<?php
				define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/facebook-sdk-v5/');
				require_once __DIR__ . '/facebook-sdk-v5/autoload.php';
				$fb = new Facebook\Facebook([
				  'app_id' => "1926824507587769",
					'app_secret' => "8f200d54e9f3e5a9c2aeb5e91d5aee28",
				  'default_graph_version' => 'v2.10',
				  ]);

				$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email',' publish_actions','user_posts']; // Optional permissions
				$_SESSION['loginUrl'] = $helper->getLoginUrl('http://pinopi.com/fb-callback.php', $permissions);

				echo '<a href="'.$_SESSION['loginUrl'].'" id="login" style="pointer-events:none;" ><img style="opacity:0.5" id="login_img" src="img/facebook-btn.png" class="btn-fb img-responsive"></a>';
				echo'
				<div style="display: inline-block;position: relative;">
					<input type="checkbox" style="width: 22px;height: 22px" id="syarat" onclick="setSyarat(this)">
				<a href="#" style="font-size: 17px;">Saya Menyetujui Syarat & Ketentuan PINOPI</a>
				</div>
				';					
					
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<p><u><strong>PENTING!! UNTUK PENDAFTARAN</strong></u></p>
			<p>Sebelum Anda mendaftar dengan mengklik "Sign in With Facebook" , mohon untuk perhatikan 2 gambar dibawah karena saat anda klik tombol biru diatas , akan terhubung ke Akun Facebook anada dan anada diharuskan untuk melewati 2 langkah di facebook.Ikuti panduan 2 langkah tersebut seperti pada gambar dibawah ini:</p>
		</div>
		<div class="col-md-12 text-center">
			<p style="color: red"><i>Langkah Pertama : Klik Nama Anda</i></p>
			<div class="kotak-biru">
				<img src="img/fb 1.png" height="100%">
			</div>
		</div>
		<div class="col-md-12 text-center">
			<p style="color: red"><i>Langkah Kedua : Pilih Public dan Klik "OK"</i></p>
			<div class="kotak-biru">
				<img src="img/fb 2.png" height="100%">
			</div>
		</div>
	</div>
</div>