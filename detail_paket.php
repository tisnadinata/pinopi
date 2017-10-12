<?php
	$nama_paket = ucfirst(str_replace("-"," ",$_GET['paket']));
	$stmt = getDataByCollumn("tbl_produk_paket","nama_paket",$nama_paket);
	if($stmt->num_rows > 0){
		$data_paket = $stmt->fetch_object();
		
		$harga_awal = getPaketHarga($data_paket->id_produk_paket);
		$harga_akhir = getPaketHargaDiskon($data_paket->id_produk_paket);
		$isi_paket = explode(",",$data_paket->isi_paket);
		for($i=1;$i<(count($isi_paket)-1);$i++){
			$stmt2 = getDataByCollumn("tbl_produk","id_produk",$isi_paket[$i]);
			if($stmt2->num_rows > 0){
				$data_produk = $stmt2->fetch_object();
				$foto_produk[$i] = $data_produk->url_foto;
			}
		}
?> 
<script>
function tambah_keranjang(){
	var banyak_paket = document.getElementById("banyak_paket").innerHTML;
	var id_paket = document.getElementById("id_paket").value;
	var dataString = 'tambah_keranjang='+id_paket+'/'+banyak_paket;
	$.ajax({
        type: "POST",
        url: "<?php echo $url_web;?>/ajax.php",
        data: dataString,
        cache: false,
		success: function(html) {
			if(html == 'success'){
				alert("Paket berhasil ditambahkan ke keranjang anda :)")
				window.location.reload()
			}else{
				alert("Maaf, paket gagal ditambahkan ke keranjang anda :(")
			}
		}
    });
}
</script>
               <div class="information-blocks">
                    <div class="row">
                        <div class="col-sm-4 col-md-offset-1 information-entry">
                            <div class="product-preview-box">
                                <div class="swiper-container product-preview-swiper" data-autoplay="0" data-loop="1" data-speed="500" data-center="0" data-slides-per-view="1">
                                    <div class="swiper-wrapper">
										<?php
											for($i=1;$i<=count($foto_produk);$i++){
												echo'
													<div class="swiper-slide">
														<div class="product-zoom-image">
															<img src="'.$url_web.'/'.$foto_produk[$i].'" alt="" data-zoom="'.$url_web.'/'.$foto_produk[$i].'" />
														</div>
													</div>
												';
											}
										?>
                                    </div>
                                    <div class="pagination"></div>                                   
                                </div>
                                <div class="swiper-hidden-edges">
                                    <div class="swiper-container product-thumbnails-swiper" data-autoplay="0" data-loop="0" data-speed="500" data-center="0" data-slides-per-view="responsive" data-xs-slides="3" data-int-slides="3" data-sm-slides="3" data-md-slides="4" data-lg-slides="4" data-add-slides="4">
                                        <div class="swiper-wrapper">
											<?php
													echo'
														<div class="swiper-slide selected">
															<div class="paddings-container">
																<img src="'.$url_web.'/'.$foto_produk[1].'" alt="" />
															</div>
														</div>
													';
												for($i=2;$i<=count($foto_produk);$i++){
													echo'
														<div class="swiper-slide">
															<div class="paddings-container">
																<img src="'.$url_web.'/'.$foto_produk[$i].'" alt="" data-zoom="'.$url_web.'/'.$foto_produk[$i].'" />
															</div>
														</div>
													';
												}
											?>
                                        </div>
                                        <div class="pagination"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7 information-entry">
                            <div class="product-detail-box">
                                <h1 class="product-title"><?php echo $data_paket->nama_paket;?></h1>
                                <input type="hidden" id="id_paket" value="<?php echo $data_paket->id_produk_paket;?>"></input>
                                <div class="price detail-info-entry">
                                    <?php
									if($harga_awal != $harga_akhir){
										echo '
											<div class="prev">Rp'.setHargaRupiah($harga_awal).'</div>
											<div class="current">Rp'.setHargaRupiah($harga_akhir).'</div>
										';
									}else{
										echo '
											<div class="current">Rp'.setHargaRupiah($harga_akhir).'</div>
										';
									}
									?>
                                </div>
                                <div class="product-description detail-info-entry"><?php echo $data_paket->deskripsi_paket;?></div>
								<div class="accordeon-title active">paket dalam paket ini :</div>
                                <div class="accordeon-entry" style="display: block;">
                                    <div class="article-container style-1">
                                        <ul>
											<?php
												for($i=1;$i<(count($isi_paket)-1);$i++){
													$stmt2 = getDataByCollumn("tbl_produk","id_produk",$isi_paket[$i]);
													if($stmt2->num_rows > 0){
														$data_produk = $stmt2->fetch_object();
														echo'<li class="col-md-6"><a href="'.$url_web.'/produk/'.strtolower(str_replace(" ","-",$data_produk->nama_produk)).'" target="_blank">'.$data_produk->nama_produk.'</a></li>';
													}
												}
											?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="quantity-selector detail-info-entry col-md-12">
								<hr>
                                    <div class="detail-info-entry-title">Banyak item yang dipesan :</div>
                                    <div class="entry number-minus">&nbsp;</div>
                                    <div class="entry number" id="banyak_paket">1</div>
                                    <div class="entry number-plus">&nbsp;</div>
                                </div>
                                <div class="detail-info-entry">
                                    <a class="button style-10" onClick="tambah_keranjang()" >Tambah ke keranjang</a>
                                    <div class="clear"></div>
                                </div>
                                <div class="share-box detail-info-entry">
                                    <div class="title"><b>Share social:</b></div>
                                    <div class="socials-box">
										<?php
											$title = $data_paket->nama_paket;
											$summary = $data_paket->deskripsi_paket;
											$image = $url_web.'/'.$data_paket->url_foto;;
											$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
										?>
										<a id="button" onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title; ?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;&p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0)"><i class="fa fa-facebook"></i></a>
										<a target="_blank" href="http://twitter.com/share?source=sharethiscom&text=<?php echo $title;?>&url=<?php echo $url; ?>"><i class="fa fa-twitter"></i></a>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
	}else{
		include '404.php';		
	}
?>               