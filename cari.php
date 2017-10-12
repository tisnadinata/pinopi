<?php
	if(isset($_POST['cari_produk'])){
		
?>
<style>
	.product-beranda{
		height:300px;
	}
	@media (max-width: 767px) {
		.product-beranda{
			height:375px;
		}
	}
</style>

                <div class="information-blocks">
                    <div class="information-blocks">
                        <div class="tabs-container">
                            <div class="swiper-tabs tabs-switch">
                                <div class="title">Hasil Pencarian</div>
                                <div class="list">
                                    <a class="block-title tab-switcher active">HASIL PENCARIAN "<?php echo $_POST['cari_produk']?>"</a>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div>
                                <div class="tabs-entry">
									<div class="row shop-grid grid-view">
										<?php
											$data_produk = getDataByCondition("tbl_produk","id_produk != 0 AND nama_produk LIKE '%".$_POST['cari_produk']."%'","id_produk DESC");
											if($data_produk->num_rows > 0){
												while($getData = $data_produk->fetch_object()){
													$kategori_produk = getDataByCollumn("tbl_kategori","id_kategori",$getData->id_kategori)->fetch_object();
										?>
													<div class="col-md-2 ">
														<div class="product-slide-entry product-beranda">
															<div class="product-image">
																<img src="<?php echo $url_web.'/'.$getData->url_foto;?>" alt="" />
																<div class="bottom-line">
																	<a class="bottom-line-a" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><i class="fa fa-eye"></i> Lihat Produk</a>
																</div>
															</div>
															<a class="tag" href="<?php echo $url_web.'/kategori/'.strtolower(str_replace(" ","-",$kategori_produk->nama_kategori));?>"><?php echo $kategori_produk->nama_kategori;?></a>
															<a class="title" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$getData->nama_produk));?>"><?php echo $getData->nama_produk;?></a>
															<div class="price">
																<?php
																	if(getProdukHarga($getData->id_produk) != getProdukHargaDiskon($getData->id_produk)){
																		echo '
																			<div class="prev">Rp'.setHargaRupiah(getProdukHarga($getData->id_produk)).'</div>
																			<div class="current">Rp'.setHargaRupiah(getProdukHargaDiskon($getData->id_produk)).'</div>
																		';
																	}else{
																		echo '
																			<div class="current">Rp'.setHargaRupiah(getProdukHarga($getData->id_produk)).'</div>
																		';
																	}
																?>
															</div>
														</div>
														<div class="clear"></div>
													</div>
										<?php		
												}
											}else{
												echo "<label><center>Maaf, belum ada data tersedia.</center></label><br>";
											}
										?>
									</div>
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
