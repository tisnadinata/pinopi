<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$this->load->model('pengaturan_model');
		$this->load->model('banner_model');
		$this->load->model('produk_model');
		$this->load->model('users_testimoni_model');
		$this->load->model('keranjang_model');
		$where=array('nama_pengaturan'=>'deskripsi_toko');
		$data['deskripsi_toko']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'logo');
		$data['logo']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'judul_Web');
		$data['judul']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'telepon');
		$data['telepon']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'email');
		$data['email']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'instagram');
		$data['instagram']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'facebook');
		$data['facebook']=$this->pengaturan_model->read_pengaturan($where);
		$where="id_users != 0 and status_akun!='nonmember'";
		$order_by="RAND()";
		$this->load->model('users_model');
		$data['member']=$this->users_model->read_users($where,$order_by);
		$where="tipe_banner = 'panjang'";
		$order_by="";
		$data['banner']=$this->banner_model->read_banner($where,$order_by);
		$select="p.*, k.id_kategori id_kategori";
		$join="tbl_kategori as k on k.id_kategori=p.id_kategori";
		$where="id_produk != 0";
		$order_by="rand() DESC ";
		$limit="0,4";
		$data['produk']=$this->produk_model->read_produk($select,$join, $where, $order_by,$limit);
		$data['testimoni']=$this->users_testimoni_model->read_users_testimoni('');
		$where="tipe_banner = 'persegi'";
		$order_by="rand()";
		$data['banner_persegi']=$this->banner_model->read_banner($where,$order_by);
		$ip_customer=$this->getIpCustomer();
		$where="ip_customer = '$ip_customer'";
		$this->keranjang_model->read_keranjang($where);
		if(!empty($_SESSION['link_affiliate'])){
			$where="link_affiliate='".$_SESSION['link_affiliate']."'";
			$order_by="";
			$data['affiliate']=$this->users_model->read_users($where,$order_by);
		}
		$grandotal = 0;
		$harga_produk=0;
		$sql="SELECT k.ip_customer ip_customer,sum(k.qty) qty_total, k.qty qty, p.* FROM `tbl_keranjang` as k join tbl_produk as p on p.id_produk=k.id_produk where k.ip_customer='$ip_customer'";
		$data['keranjang']=$this->keranjang_model->custom_sql($sql);
		if($data['keranjang']->num_rows!=0){
		$row=$data['keranjang']->row();
		if(!empty($_SESSION['user_status'])){
			if($_SESSION['user_status'] == "distributor" OR $row->qty_total>=250)$harga_produk=$row->harga_distributor;
			else if($_SESSION['user_status'] == "reseller" OR $_SESSION['user_status'] == "agen")  $harga_produk=$row->harga_produk;
		} else $harga_produk=$row->harga_nonmember;
		}
		$grandotal=$grandotal+$harga_produk;
		$data['grand_total']=$grandotal;
		$data['harga_produk']=$harga_produk;
		$this->load->view('header',$data);
		$this->load->view('body',$data);
		$this->load->view('footer',$data);
	
	}
	function getIpCustomer(){
	$ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP Tidak Dikenali';
 
    return $ipaddress;
}
	function news(){
		$this->load->model('pengaturan_model');
		$this->load->model('berita_model');
		$where=array('nama_pengaturan'=>'deskripsi_toko');
		$data['deskripsi_toko']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'logo');
		$data['logo']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'judul_Web');
		$data['judul']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'telepon');
		$data['telepon']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'email');
		$data['email']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'instagram');
		$data['instagram']=$this->pengaturan_model->read_pengaturan($where);
		$where=array('nama_pengaturan'=>'facebook');
		$data['facebook']=$this->pengaturan_model->read_pengaturan($where);
		$where="";
		$data['berita']=$this->berita_model->read_berita($where);
		$this->load->view("header",$data);
		$this->load->view("berita",$data);
		$this->load->view("footer");
	}
}
