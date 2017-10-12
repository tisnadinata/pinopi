<?php 
	$url = "../../assets/images/gallery/Q15PQH3-Cara-Sukses-Berbisnis-ala-Gaptek-ers.jpg";
		$file = file_get_contents($url);
		print_r($file);
		$w = stream_get_wrappers();
echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
echo 'wrappers: ', var_export($w);
phpinfo(); 
?>