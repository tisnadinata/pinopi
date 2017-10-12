<?php
	ini_set('session.cookie_domain', '.pinopi.com' );
	ini_set('session.cookie_domain', substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'],"."),100));
	require_once 'config/config_modul.php';
	$url_web = getPengaturan('url_web')->value_pengaturan;
	date_default_timezone_set("Asia/Jakarta");
	if(isset($_GET['link_affiliate'])){
		$_SESSION['link_affiliate'] = $_GET['link_affiliate'];
	}
	if(isset($_SESSION['subdomain']) OR isset($_COOKIE['subdomain'])){
		$_SESSION['link_affiliate'] = $_SESSION['subdomain'];
	}
	if(isset($_SESSION['user_login'])){
		if($_SESSION['user_telepon'] == "Tidak Ada" or $_SESSION['user_telepon'] == 0){
			if(isset($_GET['page'])){
				if($_GET['page'] != "edit-profile"){
					header("location:http://pinopi.com/edit-profile");
				}
			}
		}
	}
	
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui"/>
	<meta name="description" content="<?php echo getPengaturan('deskripsi_toko')->value_pengaturan;?>">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta property="og:url"           content="<?php echo $url_web.'/';?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="PINOPI - Toko Aksesoris" />
	<meta property="og:description"   content="<?php echo getPengaturan('deskripsi_toko')->value_pengaturan;?>" />
	<meta property="og:image"         content="<?php echo $url_web.'/'.getPengaturan('logo')->value_pengaturan;?>" />
    <link href="<?php echo $url_web.'/';?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url_web.'/';?>css/idangerous.swiper.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url_web.'/';?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700%7CDancing+Script%7CMontserrat:400,700%7CMerriweather:400,300italic%7CLato:400,700,900' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Cantata+One' rel='stylesheet' type='text/css' />
    <link href="<?php echo $url_web.'/';?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url_web.'/';?>css/slide.css" rel="stylesheet" type="text/css" />
    <!--[if IE 9]>
        <link href="css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo $url_web;?>/img/favicon.ico" />
  	<title><?php echo getPengaturan('judul_web')->value_pengaturan ?></title>
	
    <script src="<?php echo $url_web.'/';?>js/jquery-2.1.3.min.js"></script>
	<script>
		function updateToken(){
			alert("Token berhasil di perbaharui secara otomatis ketika anda login");
		}
	</script>	
</head>
<body class="style-16" style="background-image: url(<?php echo $url_web;?>/img/background.jpg); background-attachment: fixed;">

    <!-- LOADER     <div id="loader-wrapper">
        <div class="bubbles">
            <div class="title">loading</div>
            <span></span>
            <span id="bubble2"></span>
            <span id="bubble3"></span>
        </div>
    </div>
-->

    <div id="content-block">
		
		<?php
			$content_style = "margin-left:1%;";
			$keranjang_style = "width:auto;margin-left:10px;";
			if(isset($_GET['page'])){
				if($_GET['page'] != "beranda" AND $_GET['page'] != "home-member"){
					$content_style = "margin-left:1%;margin-right:1% !important;";
					$keranjang_style = "width:auto;margin-left:10px;margin-right: 12%;";
				}
			}
		?>	
        <div class="content-center fixed-header-margin" style="<?php echo $content_style; ?>">
            <!-- HEADER -->
            <div class="header-wrapper style-16">
                <header class="type-4" style="position: absolute;">
                    <div class="header-top">
                        <div class="header-top-entry">
                            <div class="title"><img src="<?php echo $url_web.'/';?>img/flag_id.png" alt="" />Indonesia<i class="fa fa-caret-down"></i></div>
                        </div>
                        <div class="header-top-entry" style="margin-right: 400px; float: right;">
                            <div class="title">
                            <i class="fa fa-phone"></i>
                            Cust Service : <?php echo getPengaturan('telepon')->value_pengaturan;?></div>
                       </div>
                        <div class="menu-button responsive-menu-toggle-class"><i class="fa fa-reorder"></i></div>
                        <div class="clear"></div>
                    </div>

                    <div class="header-middle">
                        <div class="logo-wrapper">
                            <a id="logo" href="<?php echo $url_web;?>/beranda"><img src="<?php echo $url_web.'/'.getPengaturan('logo')->value_pengaturan;?>" alt="" /></a>
                        </div>
						<?php
							if(isset($_SESSION['user_login'])){
						?>
                        <div class="middle-entry gb">
                            <div class="box" style="width: 40%">
								<a>
                                <div style="background-color: #9D5C05; width: 90%" class="long text-center" onclick="updateToken()">
                                    <p><strong>Pembaharuan Akses FB</strong></p>
                                    <p>(klik tombol ini bila promosi otomatis fb anda tidak jalan)</p>
                                </div>
								</a>
                            </div>
                            <div class="box">
                                <div class="tall">
                                    <a href="http://pinopi.com/income">Lihat detail</a>
                                </div>
                                <div class="long">
                                    <p style="margin-top:1%"><strong>Penghasilan Anda : Rp 
									<?php
										$data = getDataByCollumn("tbl_users","id_users",$_SESSION['user_login'])->fetch_object();
										$total_penghasilan = $data->saldo+$data->saldo_pending;
										echo setHargaRupiah($total_penghasilan);
									?>
									</strong></p>
                                    <p>(cair setiap senin min 100 ribu)</p>
                                </div>
                            </div>
                        </div>
						<?php
							}
						?>
                        <div class="right-entries" style="<?php echo $keranjang_style;?>">
                            <a class="header-functionality-entry open-cart-popup hidden-xs" href="#"><i class="fa fa-shopping-cart"></i><span style="color:white;">Keranjang</span> <strong>Rp<?php echo setHargaRupiah(getCartPrice(getIpCustomer())); ?></strong></a>
                            <a class="header-functionality-entry open-cart-popup visible-xs" href="<?php echo $url_web.'/';?>cart"><i class="fa fa-shopping-cart"></i><span>Keranjang</span> <strong>Rp<?php echo setHargaRupiah(getCartPrice(getIpCustomer())); ?></strong></a>
                        </div>
						
                    </div>

                    <div class="close-header-layer"></div>
                    <div class="navigation">
                        <div class="navigation-header responsive-menu-toggle-class">
                            <div class="title">Navigation</div>
                            <div class="close-menu"></div>
                        </div>
                        <div class="nav-overflow">
                            <nav>
                                <?php
									include "menu.php";
								?>
                                <div class="clear"></div>

                                <a class="fixed-header-visible additional-header-logo"><img src="<?php echo $url_web.'/'.getPengaturan('logo')->value_pengaturan;?>" alt=""/></a>
                            </nav>
                            <div class="navigation-footer responsive-menu-toggle-class">
                                <div class="socials-box">
                                    <a href="<?php echo getPengaturan('facebook')->value_pengaturan;?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a href="<?php echo getPengaturan('instagram')->value_pengaturan;?>" target="_blank"><i class="fa fa-instagram"></i></a>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="box-login">
                        <a href="http://pinopi.com/daftar"><p>LOGIN/DAFTAR</p>
                        <span>via facebook</span></a>
                    </div>

                </header>
                <div class="clear"></div>
            </div>

            <div class="content-push">

				<?php
					if(isset($_GET['page'])){
						$page = $_GET['page'];
						echo'
							<div class="breadcrumb-box">
								<a href="#">Beranda</a>
								<a href="#">'.ucfirst(str_replace("-"," ",$_GET['page'])).'</a>
							</div>
						';
					}else{
						$page = "beranda";						
					}
					
					if(isset($_SESSION['user_login']) AND $page=="beranda"){
						$page = 'home-member';
					}
				
					switch($page){
						case '404' : include_once '404.php'; break;
						case 'beranda' : include_once 'beranda.php'; break;
						case 'home-member' : include_once 'home-member.php'; break;
						case 'edit-profile' : include_once 'edit_profile.php'; break;
						case 'news' : include_once 'berita.php'; break;
						case 'news-detail' : include_once 'berita_detail.php'; break;
						case 'kategori' : include_once 'kategori.php'; break;
						case 'paket-produk' : include_once 'paket.php'; break;
						case 'cara-pemesanan' : include_once 'cara_pemesanan.php'; break;
						case 'tentang-kami' : include_once 'tentang_kami.php'; break;
                        case 'bisnis-offer' : include_once 'bisnis_offer.php'; break;
                        case 'promosi-otomatis' : include_once 'promosi_otomatis.php'; break;
                        case 'tim-bisnis' : include_once 'tim_bisnis.php'; break;
                        case 'testimoni' : include_once 'testimoni.php'; break;
                        case 'income' : include_once 'income.php'; break;
						case 'cart' : include_once 'cart.php'; break;
						case 'checkout' : include_once 'checkout.php'; break;
                        case 'daftar' : include_once 'daftar.php'; break;
						case 'syarat-ketentuan' : include_once 'syarat_ketentuan.php'; break;
						case 'kebijakan-pribadi' : include_once 'kebijakan_pribadi.php'; break;
						case 'faq' : include_once 'faq.php'; break;
						case 'konfirmasi-pembayaran' : include_once 'konfirmasi-pembayaran.php'; break;
						case 'cek-transaksi' : include_once 'layanan_transaksi.php'; break;
						case 'produk' : include_once 'produk.php'; break;
						case 'cari' : include_once 'cari.php'; break;
						default : include_once 'beranda.php'; break;
					}
				?>
				
                <!-- FOOTER -->
                <div class="footer-wrapper style-3">
                    <footer class="type-1">
                        <div class="footer-columns-entry" style="padding-bottom:0px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <img alt="" src="<?php echo $url_web.'/'.getPengaturan('logo')->value_pengaturan;?>" width="100%" class="footer-logo">
                                    <div class="footer-address"></div>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <h3 class="column-title">Layanan Kami</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo $url_web.'/';?>syarat-ketentuan">Syarat & Ketentuan</a></li>
                                        <li><a href="<?php echo $url_web.'/';?>kebijakan-pribadi">Kebijakan Pribadi</a></li>
                                        <li><a href="<?php echo $url_web.'/';?>faq">FAQ</a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <h3 class="column-title">Bantuan Transaksi</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo $url_web.'/';?>konfirmasi-pembayaran">Konfirmasi Pembayaran</a></li>
                                        <li><a href="<?php echo $url_web.'/';?>cek-transaksi">Cek Transaksi Saya</a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="column-title">Hubungi Kami</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo $url_web.'/';?>tentang-kami">About Us</a></li>
                                        <li><a href="#">Phone : <?php echo getPengaturan('telepon')->value_pengaturan;?></a></li>
                                        <li><a href="#">Email : <?php echo getPengaturan('email')->value_pengaturan;?></a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2">
                                    <h3 class="column-title">Ikuti Kami</h3>
                                    <ul class="column">
										<a href="<?php echo getPengaturan('facebook')->value_pengaturan;?>" target="_blank"><img alt="" src="<?php echo $url_web.'/';?>img/facebook.png" width="40px"></a>
										&nbsp
										<a href="<?php echo getPengaturan('instagram')->value_pengaturan;?>" target="_blank"><img alt="" src="<?php echo $url_web.'/';?>img/instagram.png" width="40px"></a>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                        <div class="footer-bottom-navigation">
                            <div class="cell-view">
                                <div class="footer-links">
                                    <a href="#" class="hidden-xs" style="font-size:30px;">Metode Pembayaran Yang di Dukung</a>
                                    <a href="#" class="visible-xs">Metode Pembayaran Yang di Dukung</a>
                                </div>
                            </div>
                            <div class="cell-view">
                                <div class="payment-methods">
                                    <a href="#"><img alt="" src="<?php echo $url_web.'/';?>img/payment-bank-transfer.png"></a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>

            </div>

        </div>
		<style>
        @media (min-width: 1200px) {
			.kotak-kanan{
				position:absolute;z-index: 5;top: 0px;right: 23px;width:15%;margin-right:-10px;
			}
        }
            .kotak-member{
                background:#4586c8;color:white;padding:1px 5px 10px 0px;max-height:1773px;overflow-y:scroll;width:110%;
            }
        
			.kotak-kanan .box{
				width:100%;height:100%;overflow:hidden;
				max-height:1917px;
			}

			.kotak-login{
				background:#c62127;height:55px;padding: 7.5% 25%;color:white;margin-right:10px;width:100%;
			}
            .kotak-info{
                height:95px;
                width:91.25%;padding:10px 10px 10px 10px;margin: 10px 0px 0px 10px;
                line-height: 1.25;
            }
            .kotak-reseller{
                background:#0b4881
            }
            .kotak-agen{
                background:#191919
            }
            .kotak-info .foto{              
                width:75px;
                height:75px;
                float: left;
            }
            .kotak-info .foto img{              
                width:100%;
				height: 100%;
            }
            .kotak-info .info{
                width: 50%;
                float: left;
                font-size: 13px;
                line-height: 17px;
                margin-left: 5px;
            }
            @media (max-width: 767px) {
             .kotak-info .info{
                margin: 0 0 0 10px;
                float: left;
             }
                .kotak-info .foto{
                    float: left;
                }
                .kotak-login {
                    display: none;
                    padding: 15px;
                    position: absolute;
                    top: 0;
                    top: 3.7%;
                }              
            }
		</style>
		<?php
			if($page == "beranda" OR $page == "home-member"){
				$showmember = true;
			}else{
				$showmember = false;
			?>
				.kotak-kanan{
					height:10% !important;
				}
		<?php
			}
		?>
		<div class="kotak-kanan">
			<div class="kotak-login">
				<?php
					if(isset($_SESSION['user_login'])){
						echo'
						<a href="http://pinopi.com/logout.php" style="color:white;"><div style="font-weight: bolder;color: white;font-size: x-large;">LOGOUT</div></a>
						';
					}else{
						echo'
						<a href="http://pinopi.com/daftar" style="color:white;"><div style="font-weight: bolder;color: white;">LOGIN/DAFTAR</div>
						via facebook</a>
						';
						
					}
				?>
			</div>
			<?php
				if($showmember){
			?>			
			<div class="box">
				<div class="kotak-member">
					<?php
						$stmt = $mysqli->query("select * from tbl_users where id_users != 0 and status_akun!='nonmember' order by RAND()");
						while($data = $stmt->fetch_object()){
							if($data->status_akun == "agen" OR $data->status_akun == "distributor"){
								echo '
									<div class="kotak-info kotak-agen">
										<div class="foto">
											<img src="'.$data->url_foto.'" width="100%"/>
										</div>
										<div class="info">
											'.$data->display_name.'<br>
											<u>'.$data->status_akun.'</u>
										</div>
									</div>
								';
							}else{
								echo '
									<div class="kotak-info kotak-reseller">
										<div class="foto">
											<img src="'.$data->url_foto.'" />
										</div>
										<div class="info">
											'.$data->display_name.'<br>
											<u>'.$data->status_akun.'</u>
										</div>
									</div>
								';
							}
						}
					?>
				</div>
			</div>					
			<?php
				}
			?>			
		</div>
        <div class="clear"></div>

    </div>

    <div class="cart-box popup">
        <div class="popup-container">
			<?php 
				$keranjang = getDataByCollumn("tbl_keranjang","ip_customer",getIpCustomer());
				$grandotal = 0;
				if($keranjang->num_rows > 0){
					while($data_keranjang = $keranjang->fetch_object()){
						$data_produk = getDataByCollumn("tbl_produk","id_produk",$data_keranjang->id_produk)->fetch_object();
						if(isset($_SESSION['user_login'])){
							if($_SESSION['user_status'] == "distributor" OR getCartQty(getIpCustomer())>=250){
								$harga_produk = (getProdukHargaDistributor($data_produk->id_produk));											
							}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
								$harga_produk = (getProdukHarga($data_produk->id_produk));											
							}
						}else{
							$harga_produk = (getProdukHargaNonmember($data_produk->id_produk));
						}
						$grandotal = $grandotal+$harga_produk;
			?> 
						<div class="cart-entry">
							<a class="image" style="width:75px;margin-right:10px;" target="_blank" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$data_produk->nama_produk));?>"><img src="<?php echo $url_web.'/'.$data_produk->url_foto;?>" alt="" /></a>
							<div class="content">
								<a class="title" target="_blank" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$data_produk->nama_produk));?>"><?php echo $data_produk->nama_produk; ?></a>
								<div class="quantity" style="line-height: 1.25;">
									Jumlah : <?php echo $data_keranjang->qty; ?> pcs <br>
									Harga : Rp<?php echo setHargaRupiah($harga_produk); ?> per pcs <br>
									Subtotal : Rp<?php echo setHargaRupiah($harga_produk*$data_keranjang->qty); ?>
								</div>
							</div>
						</div>
			<?php 
					}
			?> 
						<div class="summary">
							<div class="grandtotal">Total Biaya <span>Rp<?php echo setHargaRupiah(getCartPrice(getIpCustomer())); ?></span></div>
							(tanpa ongkos kirim)
						</div>
				<div class="cart-buttons">
					<div class="column pull-right">
						<a class="button style-4" href="<?php echo $url_web.'/';?>cart">LIHAT KERANJANG SAYA</a>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>					
			<?php 
				}else{
					echo "Belum ada produk yang anda inginkan :(";
				}
			?>       
        </div>
    </div>
    
    <script src="<?php echo $url_web.'/';?>js/idangerous.swiper.min.js"></script>
    <script src="<?php echo $url_web.'/';?>js/global.js"></script>
    <script src="<?php echo $url_web.'/';?>js/slide.js"></script>

    <!-- custom scrollbar -->
    <script src="<?php echo $url_web.'/';?>js/jquery.mousewheel.js"></script>
    <script src="<?php echo $url_web.'/';?>js/jquery.jscrollpane.min.js"></script>
	
	<!-- custom alert js 
    <script src="<?php //echo $url_web.'/';?>js/bootbox.min.js"></script>
-->
    
</body>
</html>
