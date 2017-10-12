<?php 
@session_start();
$mysqli = new mysqli("localhost","pinopi_pinopi","pinopi123","pinopi_pinopi");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();exit;
}
function getPengaturan($name){
    global $mysqli; 
    $stmt = $mysqli->query("select * from tbl_pengaturan where nama_pengaturan = '$name'");
//    echo $mysqli->error;
    $data = $stmt->fetch_object();
    return $data;
}
function url_web(){
    $url_web = "https://pinopi.com/";
    return $url_web;
}
function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];
            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = url_web();
        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }
        return $base_url;
}

function imageBase64FromURL($url){
 $urlParts = pathinfo($url);
 $extension = $urlParts['extension'];
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 curl_setopt($ch, CURLOPT_HEADER, 0);
 $response = curl_exec($ch);
 curl_close($ch);
 $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($response);
 return $base64;
}

function setHarga($harga){
    return number_format($harga,0,",",".");
}

function youtube($string){
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "www.youtube.com/embed/$2",$string
    );
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

function getGeoIP($ip = null, $jsonArray = false) {
    try {
        // If no IP is provided use the current users IP
        if($ip == null) {
            $ip   = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        }
        // If the IP is equal to 127.0.0.1 (IPv4) or ::1 (IPv6) then cancel, won't work on localhost
        if($ip == "127.0.0.1" || $ip == "::1") {
            throw new Exception('You are on a local sever, this script won\'t work right.');
        }
        // Make sure IP provided is valid
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new Exception('Invalid IP address "' . $ip . '".');
        }
        if(!is_bool($jsonArray)) {
            throw new Exception('The second parameter must be a boolean - true (return array) or false (return JSON object); default is false.');
        }
        // Fetch JSON data with the IP provided
        $url  = "http://freegeoip.net/json/" . $ip;
        // Return the contents, supress errors because we will check in a bit
        $json = @file_get_contents($url);
        // Did we manage to get data?
        if($json === false) {
            return false;
        }
        // Decode JSON
        $json = json_decode($json, $jsonArray);
        // If an error happens we can assume the JSON is bad or invalid IP
        if($json === null) {
            // Return false
            return false;
        } else {
            // Otherwise return JSON data
            return $json;
        }
    } catch(Exception $e) {
        return $e->getMessage();
    }
}
	function getPost($sosmed){
		global $mysqli; 
		error_reporting(E_ALL);
		ini_set('display_errors', 1); 
		$jum_konten = $mysqli->query("select * from tbl_konten_promo where sosmed='$sosmed'")->num_rows;
		$start = rand(0,$jum_konten-1);
		$stmt = $mysqli->query("select * from tbl_konten_promo where sosmed='$sosmed' ORDER BY RAND() LIMIT $start,1");
		$data = $stmt->fetch_object();		
		return $data;
	}
	function getIsiPost($id_users,$sosmed){
		global $mysqli; 
		error_reporting(E_ALL);
		ini_set('display_errors', 1); 
		$tgl_sekarang = date("Y-m-d H:i:s");
		$stmt_isi = $mysqli->query("select * from tbl_konten_promo where sosmed='$sosmed' ORDER BY RAND()");
		$jum = $stmt_isi->num_rows;
		$jum_dif = ceil($jum/2);
		$jum_dif = $jum_dif+ceil($jum_dif/4);
		while($isi_post = $stmt_isi->fetch_object()){			
			$available = false;
			$found = false;
			$stmt = $mysqli->query("select * from tbl_auto_log where id_users=$id_users AND sosmed='$sosmed' order by waktu desc LIMIT 0,$jum_dif");
			if($stmt->num_rows > 0){
				while($data = $stmt->fetch_object()){
					if($isi_post->id_auto_setting == $data->id_auto_promo_setting){
						$found = true;
						break;
					}
				}
				if(!$found){
					$available = true;
				}
			}else{
				$available = true;
			}
			if($available){
				return $isi_post;
				break;
			}
		}
	}
	function getIsiPost1($id_auto_promo,$sosmed){
		global $mysqli;
		$tgl_sekarang = date("Y-m-d");
		$stmt_isi = $mysqli->query("select * from tbl_konten_promo where sosmed='$sosmed' ORDER BY RAND()");
		$jum = $stmt_isi->num_rows;
		while($isi_post = $stmt_isi->fetch_object()){
			$last_post = $mysqli->query("select * from tbl_auto_log where id_auto_promo=$id_auto_promo AND id_auto_promo_setting=".$isi_post->id_auto_setting." order by id_auto_promo_setting DESC limit 1");
			if($last_post->num_rows > 0){
				$last_p = $last_post->fetch_object();
				$selisih = ((abs(strtotime ($tgl_sekarang) - strtotime ($last_p)))/(60*60*24));		
				if($selisih >= ceil($jum/2)){
					return $isi_post;
					break;
				}
			}else{
				return $isi_post;
				break;
			}
		}
		
	}
	function getIsiPostKhusus($id_auto_promo,$sosmed,$keyword){
		global $mysqli; 
		error_reporting(E_ALL);
		ini_set('display_errors', 1); 
		$tgl_sekarang = date("Y-m-d H:i:s");
		$stmt_isi = $mysqli->query("select * from tbl_konten_promo where sosmed='$sosmed' AND isi_post LIKE '%".$keyword."%' ORDER BY RAND()");
		$jum = $stmt_isi->num_rows;
		$jum_dif = ceil($jum/2);
		$jum_dif = $jum_dif+ceil($jum_dif/4);
		while($isi_post = $stmt_isi->fetch_object()){			
			$available = false;
			$found = false;
			$stmt = $mysqli->query("select * from tbl_auto_log where id_auto_promo=$id_auto_promo AND sosmed='$sosmed' order by waktu desc LIMIT 0,$jum_dif");
//			echo "select * from tbl_auto_log where id_auto_promo=$id_auto_promo AND sosmed='$sosmed' order by waktu desc LIMIT 0,$jum_dif <br>";
			if($stmt->num_rows > 0){
				while($data = $stmt->fetch_object()){
	//				echo $isi_post->id_auto_setting.' == '.$data->id_auto_promo_setting.'<br>';
					if($isi_post->id_auto_setting == $data->id_auto_promo_setting){
						$found = true;
						break;
					}
				}
				if(!$found){
					$available = true;
				}
			}else{
				$available = true;
			}
			if($available){
				return $isi_post;
				break;
			}
		}
	}
