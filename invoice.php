<?php

	function kirim_email($email,$nomor_invoice,$tanggal_pemesanan,$total_pembayaran,$status_pesanan,$logo_web,$email_keranjang_nama,$email_keranjang_qty)
	$nomor_invoice = "di isi nomor invoice";
	$tanggal_pemesanan = "di isi tanggal_pemesanan";
	$total_pembayaran = "di isi total_pembayaran";
	$status_pesanan = "di isi status_pesanan";
	$logo_web = "http://pinopi.com/";
	$email_keranjang_nama[0] = "asdasd";
	$email_keranjang_qty[0] = "2";
	$email_keranjang_nama[1] = "asdasd";
	$email_keranjang_qty[1] = "2";

	$isi_email = '
		<table style="max-width:100%;border-collapse:collapse;border-spacing:0;width:100%;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
		<tbody>
		<tr style="margin:0;padding:0">
			<td style="margin:0;padding:0"></td>
			<td bgcolor="#FFFFFF" style="display:block!important;max-width:600px!important;clear:both!important;margin:0 auto;padding:0">
				<div style="max-width:600px;display:block;border-collapse:collapse;margin:0 auto;padding:30px 15px;border:1px solid #e7e7e7">
					<table style="max-width:100%;border-collapse:collapse;border-spacing:0;width:100%;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
					<tbody>
					<tr style="margin:0;padding:0">
						<td style="margin:0;padding:0">
							<center><img src="'.$logo_web.'" width="50%" /></center>
							<br>
							<h5 style="line-height:24px;color:#000;font-weight:900;font-size:17px;margin:0 0 20px;padding:0">Terima kasih sudah melakukan pemesanan di PINOPI.COM.</h5>
							<p style="font-weight:normal;font-size:14px;line-height:1.6;margin:0 0 20px;padding:0">
							 Berikut informasi pesanan anda :
							</p>
							<div style="margin:0 0 20px;padding:0">
								<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
								<tbody style="margin:0;padding:0">
								<tr style="margin:0;padding:0">
									<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Nomor Invoice:</td>
									<td style="margin:0;padding:0">'.$nomor_invoice.'</td>
								</tr>
								</tbody>
								</table>
								<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
								<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
								<tbody style="margin:0;padding:0">
								<tr style="margin:0;padding:0">
									<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Tanggal Pemesanan:</td>
									<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">'.$tanggal_pemesanan.'</td>
								</tr>
								</tbody>
								</table>
								<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
								<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
								<tbody style="margin:0;padding:0">
								<tr style="margin:0;padding:0">
									<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Total Pembayaran:</td>
									<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Rp '.$total_tagihan.'</td>
								</tr>
								</tbody>
								</table>
								<div style="border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;margin:0;padding:0"></div>
								<table style="width:100%;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:5px 0;padding:0" bgcolor="transparent">
								<tbody style="margin:0;padding:0">
								<tr style="margin:0;padding:0">
									<td style="width:25%;font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">Status Pesanan:</td>
									<td style="font-size:13px;vertical-align:top;line-height:18px;margin:0;padding:0 10px 0 0" valign="top">
										<div style="margin:0 0 4px;padding:0">
										'.$subtotal_tagihan.'
										</div>
									</td>
								</tr>
								</tbody>
								</table>
							</div>
							<hr style="border-top-color:#d0d0d0;border-top-style:solid;border-bottom-color:#ffffff;border-bottom-style:solid;margin:20px 0;padding:0;border-width:3px 0 1px">
							<h5 style="line-height:1.1;color:#000;font-weight:900;font-size:17px;margin:0 0 20px;padding:0">Rincian Pesanan:</h5>
							<div style="margin:0;padding:0">
								<table style="width:100%;font-size:13px;max-width:100%;border-collapse:collapse;border-spacing:0;background-color:transparent;margin:0;padding:0" bgcolor="transparent">
								<thead style="color:white;text-align:left;background-color:#70663f;margin:0;padding:0">
								<tr style="margin:0;padding:0">
									<th width="" style="margin:0;padding:5px">Nama Paket Yang di Pesan</th>
									<th width="" style="margin:0;padding:5px;text-align:right">Jumlah Paket Yang di Pesan</th>
								</tr>
								</thead>
								<tbody style="margin:0;padding:0">
									';
									$isi_email2 = '';
									for($i=0;$i<count($email_keranjang_nama);$i++){
										$isi_email2 = $isi_email2.'
										<tr style="margin:0;padding:0">
											<td style="line-height:20px;vertical-align:top;border-bottom-color:#eee;border-bottom-width:1px;border-bottom-style:solid;margin:0;padding:5px" valign="top">
												<div>
													'.$email_keranjang_nama[$i].'
												</div>
											</td>
											<td style="line-height:20px;vertical-align:top;border-bottom-width:1px;border-bottom-color:#eee;border-bottom-style:solid;text-align:right;margin:0;padding:5px" align="right" valign="top">
												'.$email_keranjang_qty[$i].' paket
											</td>
										</tr>
										';
									}
								$isi_email3 = '
								</tbody>
								</table>
							</div>
							<p style="font-weight:normal;font-size:14px;line-height:1.6;border-top-style:solid;border-top-color:#d0d0d0;border-top-width:3px;margin:40px 0 0;padding:10px 0 0">
								<small style="color:#999;margin:0;padding:0">Untuk informasi selengkapnya dilahkan cek transaksi anda pada halaman <a href="http://pinopi.com/cek-transaksi" style="color:#70663f;text-decoration:none;margin:0;padding:0" target="_blank" >STATUS PEMESANAN</a>.<br style="margin:0;padding:0">
								<br style="margin:0;padding:0">
								Email ini dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</small>
							</p>
						</td>
					</tr>
					</tbody>
					</table>
				</div>
			</td>
			<td style="margin:0;padding:0"></td>
		</tr>
		</tbody>
		</table>
		<table align="center">
		<tbody>
		<tr style="margin:0;padding:0 0 0 0">
			<td style="display:block!important;width:600px!important;clear:both!important;margin:0 auto;padding:0">
				<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-collapse:collapse;background-color:#f7f7f7;font-size:13px;color:#999999;border-top:1px solid #dddddd">
				<tbody>
				<tr>
					<td width="600" align="center" style="padding:30px 20px 0">
						Jika butuh bantuan, gunakan halaman <a href="http://pinopi.com/tentang-kami" style="color:#70663f" target="_blank" >Kontak Kami</a>
					</td>
				</tr>
				<tr>
					<td width="600" align="center" style="padding:10px 20px 30px">
						© 2017, <span class="il">PINOPI.COM</span>
					</td>
				</tr>
				</tbody>
				</table>
			</td>
		</tr>
		</tbody>
		</table>';
		return $isi_email.$isi_email2.$isi_email3;
	}
?>