<?php
	require '../config/config_modul.php';
	if(!isset($_SESSION['login'])){
		echo'<meta http-equiv="Refresh" content="0; URL=login.php">';
	}
?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PINOPI Admin Dashboard </title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
	<style>
	.page_konten{
		margin-left:230px;
		padding:10px 20px 0;
		background:white;
		min-height:600px;
		height:100%;
	}
	@media(max-width: 767px) {
		.page_konten{
			margin-left:0px;
			padding:10px 20px 0;
			background:white;
			min-height:600px;
			height:100%;
		}
	}
	</style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Admin Panel</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="?page=beranda"><i class="fa fa-home"></i> Dashboard</a></li>
                  <li><a href="?page=kategori"><i class="fa fa-tags"></i> Kelola Kategori</a></li>
                  <li><a><i class="fa fa-users"></i> Kelola User/member <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=daftar-user">Daftar User/Member</a></li>
                      <li><a href="?page=user-bonus">Penghasilan Dicarikan</a></li>
                      <li><a href="?page=user-testimoni">User/Member Testimoni</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-th-large"></i> Kelola Produk <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=produk-tambah">Tambah Produk</a></li>
                      <li><a href="?page=produk-daftar">Daftar Produk</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-volume-up"></i> Kelola Konten Promo <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=konten-tambah">Tambah Konten Promo</a></li>
                      <li><a href="?page=konten-daftar&sosmed=facebook">Konten Promo Facebook</a></li>
                      <li><a href="?page=konten-daftar&sosmed=twitter">Konten Promo Twitter</a></li>
                      <li><a href="?page=konten-daftar&sosmed=instagram">Konten Promo Instagram</a></li>
                    </ul>
                  </li>
                  <li><a href="?page=banner"><i class="fa fa-image"></i> Kelola Banner Beranda </a></li>
                  <li><a><i class="fa fa-money"></i> Kelola Diskon <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=diskon-semua">Diskon Kupon</a></li>
                      <li><a href="?page=diskon-produk">Diskon Per Produk</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-shopping-cart"></i> Kelola Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?page=transaksi&status=pending">Menunggu Pembayaran</a></li>
                      <li><a href="?page=transaksi&status=baru">Transaksi Baru</a></li>
                      <li><a href="?page=transaksi&status=proses">Transaksi Dalam Proses</a></li>
                      <li><a href="?page=transaksi&status=dikirim">Transaksi Dikirim</a></li>
                      <li><a href="?page=transaksi&status=selesai">Transaksi Selesai</a></li>
                      <li><a href="?page=transaksi&status=dibatalkan">Transaksi Dibatalkan</a></li>
                    </ul>
                  </li>
				  <li><a href="?page=berita"><i class="fa fa-bullhorn"></i> Kelola Berita</a></li>                  
				  <li><a href="?page=message"><i class="fa fa-envelope-o"></i> Kelola Pesan</a></li>                  
				  <li><a href="?page=upload-foto"><i class="fa fa-file-image-o"></i> Upload Foto</a></li>                  
				  <li><a href="?page=pengaturan"><i class="fa fa-gears"></i> Pengaturan Toko</a></li>                  
				  <li><a href="logout.php"><i class="fa fa-sign-out"></i> Keluar Sebagai Admin</a></li>                  
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->
            
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars" style="margin-bottom: 15px;"></i></a>
              </div>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="page_konten">
          <div class="">
			<div class="row">
				<?php
					$page = 'beranda';
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					switch($page){
						case 'beranda' : include 'beranda.php';break;
						case 'kategori' : include 'kategori.php';break;
						case 'daftar-user' : include 'user_daftar.php';break;
						case 'user-bonus' : include 'user_bonus.php';break;
						case 'user-pending' : include 'user_pending.php';break;
						case 'user-testimoni' : include 'user_testimoni.php';break;
						case 'produk-tambah' : include 'produk_tambah.php';break;
						case 'produk-daftar' : include 'produk_daftar.php';break;
						case 'konten-tambah' : include 'konten_tambah.php';break;
						case 'konten-daftar' : include 'konten_daftar.php';break;
						case 'banner' : include 'banner.php';break;
						case 'diskon-produk' : include 'diskon.php';break;
						case 'diskon-semua' : include 'diskon_kupon.php';break;
						case 'pengaturan' : include 'pengaturan.php';break;
						case 'berita' : include 'berita.php';break;
						case 'upload-foto' : include 'upload_foto.php';break;
						case 'transaksi' : include 'transaksi.php';break;
						case 'message' : include 'message.php';break;
						case 'detail-transaksi' : include 'detail_transaksi.php';break;
						default : include 'beranda.php';break;
					}
				?>
			</div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- jQuery Sparklines -->
    <script src="vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
     <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
	<!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
  </body>
</html>