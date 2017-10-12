                <div class="information-blocks">
                    <div class="map-box type-2">
						<img alt="" src="<?php echo $url_web.'/'.getPengaturan('logo')->value_pengaturan;?>" style="width:100%;height:100%">
                    </div>
                    <div class="map-overlay-info">
                        <div class="article-container style-1">
                            <div class="cell-view">
                                <h5>Alamat Toko</h5>
                                <p><?php echo getPengaturan('alamat')->value_pengaturan;?></p>
                                <h5>Contact Informations</h5>
                                <p>Email: <?php echo getPengaturan('email')->value_pengaturan;?><br>
                                Telepon: <?php echo getPengaturan('telepon')->value_pengaturan;?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="row">
                        <div class="col-md-12 information-entry">
                            <h3 class="block-title main-heading">Siapa kami?</h3>
                            <div class="article-container style-1">
                                <p><?php echo getPengaturan('deskripsi_toko')->value_pengaturan;?></p>
                            </div>
                           
                        </div>
                    </div>
                </div>
