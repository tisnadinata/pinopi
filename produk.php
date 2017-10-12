<?php
	$nama_produk = ucfirst(str_replace("-"," ",$_GET['produk']));
	$stmt = getDataByCollumn("tbl_produk","nama_produk",$nama_produk);
	if($stmt->num_rows > 0){
		$data_produk = $stmt->fetch_object();
?>
<script>
function tambah_keranjang(){
	var banyak_produk = document.getElementById("banyak_produk").innerHTML;
	var id_produk = document.getElementById("id_produk").value;
	var dataString = 'tambah_keranjang='+id_produk+'/'+banyak_produk;
	$.ajax({
        type: "POST",
        url: "<?php echo $url_web;?>/ajax.php",
        data: dataString,
        cache: false,
		success: function(html) {
			if(html == 'success'){
				alert("Produk berhasil ditambahkan ke keranjang anda :)")
				window.location.reload()
			}else{
				alert("Maaf, produk gagal ditambahkan ke keranjang anda :(")
				alert(html);
			}
		}
    });
}
</script>
		<div class="information-blocks">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1 information-entry">
                            <img class="project-thumbnail" src="<?php echo $url_web.'/'.$data_produk->url_foto;?>" alt="" />
                        </div>
                        <div class="col-md-6 information-entry">
                            <h3 class="block-title main-heading"><?php echo $data_produk->nama_produk;?></h3>
							<input type="hidden" id="id_produk" value="<?php echo $data_produk->id_produk;?>"></input>
                            <div class="article-container style-1">
                                <h4>HARGA PRODUK : 								
								</h4>
								<div class="price">
									<div class="current">Rp
								<?php
									if(isset($_SESSION['user_login'])){
										if($_SESSION['user_status'] == "distributor"){
											echo setHargaRupiah(getProdukHargaDistributor($data_produk->id_produk));											
										}else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen"){
											echo setHargaRupiah(getProdukHarga($data_produk->id_produk));											
										}
									}else{
										echo setHargaRupiah(getProdukHargaNonmember($data_produk->id_produk));
									}
								?>
									</div>
								</div>
                            </div>
                            <div class="article-container style-1">
                                <h4>DESKRIPSI PRODUK</h4>
                                <p><?php echo $data_produk->deskripsi_produk;?></p>
                            </div>
                            <div class="detail-info-lines">
                                <div class="share-box">
                                     <div class="quantity-selector detail-info-entry col-md-12">
										<div class="detail-info-entry-title">Banyak item yang dipesan :</div>
										<div class="entry number-minus">&nbsp;</div>
										<div class="entry number" id="banyak_produk">1</div>
										<div class="entry number-plus">&nbsp;</div>
									</div>
									<div class="detail-info-entry">
										<a class="button style-10" onClick="tambah_keranjang()" >Tambah ke keranjang</a>
										<div class="clear"></div>
									</div>
                                </div>		
                                <div class="share-box">
                                    <div class="title"><b>Share social:</b></div>
                                    <div class="socials-box">
										<?php
											$title = $data_produk->nama_produk;
											$summary = $data_produk->deskripsi_produk;
											$image = $url_web.'/'.$data_produk->url_foto;;
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