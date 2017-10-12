wild card here 
<?php
ini_set('session.cookie_domain', '.pinopi.com' );
ini_set('session.cookie_domain', substr($_SERVER['SERVER_NAME'],strpos($_SERVER['SERVER_NAME'],"."),100));
session_start();
$_SESSION['subdomain'] = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
setcookie("subdomain",$_SESSION['subdomain'],time()+23600);
header("location:http://pinopi.com");
?>
