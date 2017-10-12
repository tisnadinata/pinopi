<?php
$deskripsi_toko_row=$deskripsi_toko->row();
$logo_row=$logo->row();
$judul_row=$judul->row();
$telepon_row=$telepon->row();
$facebook_row=$facebook->row();
$instagram_row=$instagram->row();
$email_row=$email->row();
?>
<!-- FOOTER -->
                <div class="footer-wrapper style-3">
                    <footer class="type-1">
                        <div class="footer-columns-entry" style="padding-bottom:0px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <img alt="" src="<?php echo base_url('assets/'.$logo_row->value_pengaturan);?>" width="100%" class="footer-logo">
                                    <div class="footer-address"></div>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <h3 class="column-title">Layanan Kami</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo base_url('/syarat-ketentuan');?>">Syarat & Ketentuan</a></li>
                                        <li><a href="<?php echo base_url('/kebijakan-pribadi');?>">Kebijakan Pribadi</a></li>
                                        <li><a href="<?php echo base_url('/faq');?>">FAQ</a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2 col-sm-4">
                                    <h3 class="column-title">Bantuan Transaksi</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo base_url('/konfirmasi-pembayaran');?>">Konfirmasi Pembayaran</a></li>
                                        <li><a href="<?php echo base_url('/cek-transaksi');?>">Cek Transaksi Saya</a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-3">
                                    <h3 class="column-title">Hubungi Kami</h3>
                                    <ul class="column">
                                        <li><a href="<?php echo base_url('/tentang-kami');?>">About Us</a></li>
                                        <li><a href="#">Phone : <?php echo $telepon_row->value_pengaturan;?></a></li>
                                        <li><a href="#">Email : <?php echo $email_row->value_pengaturan;?></a></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                                <div class="col-md-2">
                                    <h3 class="column-title">Ikuti Kami</h3>
                                    <ul class="column">
										<a href="<?php echo $facebook_row->value_pengaturan;?>" target="_blank"><img alt="" src="<?php echo base_url('assets/img/facebook.png');?>" width="40px"></a>
										&nbsp
										<a href="<?php echo $instagram_row->value_pengaturan;?>" target="_blank"><img alt="" src="<?php echo base_url('assets/img/instagram.png');?>" width="40px"></a>
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
                                    <a href="#"><img alt="" src="<?php echo base_url('/assets/img/payment-bank-transfer.png');?>"></a>
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
		<div class="kotak-kanan">
			<div class="kotak-login">
				<?php
					if(isset($_SESSION['user_login'])){
						echo'
						<a href="'.base_url('logout').'" style="color:white;"><div style="font-weight: bolder;color: white;font-size: x-large;">LOGOUT</div></a>
						';
					}else{
						echo'
						<a href="'.base_url('daftar').'" style="color:white;"><div style="font-weight: bolder;color: white;">LOGIN/DAFTAR</div>
						via facebook</a>
						';
						
					}
				?>
			</div>	
			<div class="box">
				<div class="kotak-member">
					<?php 
					foreach($member->result() as $row){
						$type="";
						if($row->status_akun=="agen" || $row->status_akun=="distributor") $type="kotak_agen";
						else $type="kotak_reseller";
						echo '
									<div class="kotak-info '.$type.'">
										<div class="foto">
											<img src="'.$row->url_foto.'" />
										</div>
										<div class="info">
											'.$row->display_name.'<br>
											<u>'.$row->status_akun.'</u>
										</div>
									</div>
								';
					}
					?>
				</div>
			</div>						
		</div>
        <div class="clear"></div>

    </div>

    <div class="cart-box popup">
        <div class="popup-container">
						<div class="cart-entry">
              <?php
              if($keranjang->num_rows()!=0){
              foreach($keranjang->result() as $data_produk){
               if($data_produk->url_foto!=""){
              echo '
							<a class="image" style="width:75px;margin-right:10px;" target="_blank" href="'.base_url('/produk/'.$data_produk->id_produk).'"><img src="'.base_url('/assets/'.$data_produk->url_foto).'" alt="" /></a>
							<div class="content">
								<a class="title" target="_blank" href="'.base_url('/produk/'.$data_produk->id_produk).'">'.$data_produk->nama_produk.'</a>
								<div class="quantity" style="line-height: 1.25;">
									Jumlah : '.$data_produk->qty.' pcs <br>
									Harga : Rp.'.number_format($harga_produk,2,',','.').' per pcs <br>
									Subtotal : Rp'.number_format($harga_produk*$data_produk->qty,2,',','.').'>
								</div>
							</div>
						</div>
								 <div class="summary">
							<div class="grandtotal">Total Biaya <span>Rp'.number_format($grand_total,2,',','.').'</span></div>
							(tanpa ongkos kirim)
						</div>
				<div class="cart-buttons">
					<div class="column pull-right">
						<a class="button style-4" href="'.base_url('/cart').'">LIHAT KERANJANG SAYA</a>
						<div class="clear"></div>
					</div>
					'; 
                 
                 echo "Belum ada produk yang anda inginkan :(";
								 break;
               } else echo "Belum ada produk yang anda inginkan :(";

					}
			?> 
						<div class="clear"></div>
				</div>					
			<?php 
				}else{
					echo "Belum ada produk yang anda inginkan :(";
				}
			?>       
        </div>
    </div>
    
    <script src="<?php echo base_url('/assets/js/idangerous.swiper.min.js');?>"></script>
    <script src="<?php echo base_url('/assets/js/global.js');?>"></script>
    <script src="<?php echo base_url('/assets/js/slide.js');?>"></script>
      <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
      <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>

    <!-- custom scrollbar -->
    <script src="<?php echo base_url('/assets/js/jquery.mousewheel.js');?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.jscrollpane.min.js');?>"></script>
	
	<!-- custom alert js 
    <script src="<?php //echo $url_web.'/';?>js/bootbox.min.js"></script>
-->
    
</body>
</html>
