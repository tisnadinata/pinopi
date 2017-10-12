                <div class="information-blocks">
                    <div class="row">
					<?php
						$stmt = getDataTable("tbl_produk where id_produk !=0","nama_produk ASC");
						if($stmt->num_rows > 0){
							while($data_produk = $stmt->fetch_object()){
								?>
								<div class="col-sm-6 col-md-3 col-xs-6 information-entry">
									<div class="product-column-entry" style="height:auto;text-align:center !important;">
										<div class="image"><img alt="" src="<?php echo $url_web.'/'.$data_produk->url_foto; ?>"></div>
										<h3 class="title"><?php echo $data_produk->nama_produk; ?></h3>
										<div class="price">
											
										<?php
											if(isset($_SESSION['user_login'])){
												if($_SESSION['user_status'] == "distributor"){
													echo "<div class='prev'>Rp".setHargaRupiah(getProdukHargaNonmember($data_produk->id_produk))."</div>";
													echo "<div class='current'>Rp".setHargaRupiah(getProdukHargaDistributor($data_produk->id_produk))."</div>";											
												}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
													echo "<div class='prev'>Rp".setHargaRupiah(getProdukHargaNonmember($data_produk->id_produk))."</div>";
													echo "<div class='current'>Rp".setHargaRupiah(getProdukHarga($data_produk->id_produk))."</div>";											
												}
											}else{
												echo "<div class='current'>Rp".setHargaRupiah(getProdukHargaNonmember($data_produk->id_produk))."</div>";
											}
										?>
											
										</div>
										<div class="description">
											<br>
											<a class="button btn-default col-md-12" href="<?php echo $url_web.'/produk/'.strtolower(str_replace(" ","-",$data_produk->nama_produk)); ?>">LIHAT DETAIL PRODUK</a>
										</div>
										<div class="hot-mark">hot</div>
									</div>
								</div>
								<?php
							}
						}else{	
							echo "<label><center>Maaf, belum ada data tersedia.</center></label><br>";
						}
					?>
                       
                    </div>
                </div>
