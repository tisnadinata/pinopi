<?php
$deskripsi_toko_row=$deskripsi_toko->row();
$logo_row=$logo->row();
$judul_row=$judul->row();
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui"/>
	<meta name="description" content="<?php echo $deskripsi_toko_row->value_pengaturan;?>">
	<meta name="keywords" content="HTML,CSS,XML,JavaScript">
	<meta property="og:url"           content="<?php echo base_url();?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="PINOPI - Toko Aksesoris" />
	<meta property="og:description"   content="<?php echo $deskripsi_toko_row->value_pengaturan?>" />
	<meta property="og:image"         content="<?php echo base_url('assets/'.$logo_row->value_pengaturan);?>" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/idangerous.swiper.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/fontawesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700%7CDancing+Script%7CMontserrat:400,700%7CMerriweather:400,300italic%7CLato:400,700,900' rel='stylesheet' type='text/css' />
    <link href='http://fonts.googleapis.com/css?family=Cantata+One' rel='stylesheet' type='text/css' />
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/slide.css');?>" rel="stylesheet" type="text/css" />
    <!--[if IE 9]>
        <link href="css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>" />
  	<title><?php echo $judul_row->value_pengaturan ?></title>
	
    <script src="<?php echo base_url('assets/js/jquery-2.1.3.min.js');?>"></script>
	<script>
		function updateToken(){
			alert("Token berhasil di perbaharui secara otomatis ketika anda login");
		}
	</script>	
</head>