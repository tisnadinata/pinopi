<ul>
                                    <li class="full-width">
                                        <a href="<?php echo base_url('');?>" class="active">Home</a>
                                    </li>
                                    <li class="simple-list">
                                        <a href="<?php echo base_url('news');?>">News</a>
                                    </li>
                                    <li class="simple-list">
                                        <a href="<?php echo base_url('paket');?>">Product</a>
                                    </li>
                                    <li class="simple-list">
                                        <a href="<?php echo base_url('cara-pemesanan');?>">How to Order</a>
                                    </li>
                                    <li class="simple-list">
                                        <a href="<?php echo base_url('testimoni');?>">Testimony</a>
                                    </li>
                                    <li class="simple-list">
                                        <a href="<?php echo "http://".$instagram->value_pengaturan;?>">Gallery</a>
                                    </li>
									<?php
										if(isset($_SESSION['user_login'])){
									?>
										<li class="simple-list">
											<a href="<?php echo base_url('tim-bisnis');?>" >Team Bisnis</a>
										</li>
										<li class="simple-list">
											<a href="<?php echo base_url('promosi-otomatis');?>" >Promosi otomatis</a>
										</li>
										<li class="simple-list">
											<a href="<?php echo base_url('income');?>" >YOUR INCOME</a>
										</li>
									<?php
										}else{
									?>
										<li class="fixed-header-visible" style="margin-top:22px;margin-right: -70px;">
											<a href="<?php echo base_url('bisnis-offer');?>" style="color:red;line-height: 1;text-align: left;text-decoration:none !important;"><b>PELUANG AGEN/RESELLER</b><br>Buyback Guarantee</a>
										</li>
									
<!-- 										<li class="simple-list visible-xs">
											<a href="<?php //echo base_url('bisnis-offer');?>" style="color:red;line-height: 1;text-align: left;text-decoration:none !important;"><b>PELUANG AGEN/RESELLER</b><br>Buyback Guarantee</a>
										</li>
										
										<li class="simple-list hidden-xs" style="position:absolute;margin-top:22px;right: 0;">
											<a href="<?php // echo base_url('bisnis-offe');?>" style="color:red;line-height: 1;text-align: left;text-decoration:none !important;"><b>PELUANG AGEN/RESELLER</b><br>Buyback Guarantee</a>
										</li> -->
									<?php
										}
									?>
                                </ul>