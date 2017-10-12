<?php
include 'connectDB.php';
include 'emailLibrary/function.php';

date_default_timezone_set('Asia/Jakarta');
//   CHANGE THE BELOW VARIABLES TO YOUR NEEDS


    $now = date('Ymd');
    $stmt = $mysqli->query("select * from z_crm_email_sent where count<=8 and last_sent<$now");
      
      while($data = $stmt->fetch_object()){
		$stmt2 = $mysqli->query("select * from users where email='".$data->to_email."'");
		$data_user= $stmt2->fetch_object();
		if($data_user->upgrade == 0){
			$emails = $mysqli->query("select * from z_email_settings where id='$data->count'");		
			$get = $emails->fetch_object();
			$footer = '<br><p><strong>Yuk Segera UPGRADE diri anda menjadi seorang ENTREPRENEUR agar Sistem ini mulai melakukan PROMOSI OTOMATIS dan mulai menghasilkan UANG ke rekening anda.</strong></p><br>
					<p>Panduan Setting PROMOSI Otomatis sudah ada di Video Download Area, Klik Disini <a href="http://'.$data_user->link_affiliate.'.yesnumber1.com">http://'.$data_user->link_affiliate.'.yesnumber1.com</a> untuk berkunjung ke Success Area YESNumber1.com</p><br>
					<p>Apabila anda ada kendala, silahkan menghubungi nomor HOTLINE Whatsapp : +62821.2349.9205 (Indonesia) atau email ke <a href="mailto:Yesnumber1@gmail.com">cs.yesnumber1@gmail.com</a>. Saya dan TEAM Customer Service akan membalas semua pertanyaan anda.</p>';
			$isi_email = $get->value.$footer;
			$isi_email = str_replace("[nama]",$data_user->nama_lengkap,$isi_email);
			$isi_email = str_replace("[handphone]",$data_user->handphone,$isi_email);
			$isi_email = str_replace("[link_affiliate]","http://'.".$data_user->link_affiliate.".'.yesnumber1.com",$isi_email);
			smtp_mail($data->to_email, $get->subject, $isi_email, '', '', 0, 0, false);
			$mysqli->query("update z_crm_email_sent set count=count+1,last_sent='$now' WHERE id='$data->id'");
			if($data->count == 8){
				$emails = $mysqli->query("select * from z_email_settings where nama='berlangganan'");		
				$get = $emails->fetch_object();
				$footer = '<br><p><strong>Yuk Segera UPGRADE diri anda menjadi seorang ENTREPRENEUR agar Sistem ini mulai melakukan PROMOSI OTOMATIS dan mulai menghasilkan UANG ke rekening anda.</strong></p><br>
						<p>Panduan Setting PROMOSI Otomatis sudah ada di Video Download Area, Klik Disini <a href="http://'.$data_user->link_affiliate.'.yesnumber1.com">http://'.$data_user->link_affiliate.'.yesnumber1.com</a> untuk berkunjung ke Success Area YESNumber1.com</p><br>
						<p>Apabila anda ada kendala, silahkan menghubungi nomor HOTLINE Whatsapp : +62821.2349.9205 (Indonesia) atau email ke <a href="mailto:Yesnumber1@gmail.com">cs.yesnumber1@gmail.com</a>. Saya dan TEAM Customer Service akan membalas semua pertanyaan anda.</p>';
				$isi_email = $get->value.$footer;
				$isi_email = str_replace("[nama]",$data_user->nama_lengkap,$isi_email);
				$isi_email = str_replace("[handphone]",$data_user->handphone,$isi_email);
				$isi_email = str_replace("[link_affiliate]","http://'.".$data_user->link_affiliate.".'.yesnumber1.com",$isi_email);
				smtp_mail($data->to_email, $get->subject, $isi_email, '', '', 0, 0, false);
					
			}
		}else{
			$mysqli->query("update z_crm_email_sent set count=9,last_sent='$now' WHERE id='$data->id'");
		}
      }
    
