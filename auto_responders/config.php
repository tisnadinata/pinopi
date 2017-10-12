<?php
ini_set("include_path", '/home/yoga/php:' . ini_get("include_path") );


require_once "Mail/Queue.php";

// options for storing the messages
// type is the container used, currently there are 'creole', 'db', 'mdb' and 'mdb2' available
$db_options['type']       = 'db';
// the others are the options for the used container
// here are some for db
$db_options['dsn']        = 'mysql://yoga_renungan:ecEk#ZE(b}JB@localhost/yoga_yesnumber1';
$db_options['mail_table'] = 'mail_queue';

// here are the options for sending the messages themselves
// these are the options needed for the Mail-Class, especially used for Mail::factory()
$mail_options['driver']    = 'smtp';
$mail_options['host']      = 'smtp.gmail.com';
$mail_options['port']      = 587;
//$mail_options['localhost'] = 'localhost'; //optional Mail_smtp parameter
$mail_options['auth']      = false;
$mail_options['username']  = 'bandungcamp@gmail.com';
$mail_options['password']  = 'Rahasiahehe123xyz';

