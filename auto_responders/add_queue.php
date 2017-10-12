<?php
require_once 'config.php';
function auto_responders($mail_to,$name_to,$message){
$mail_queue =& new Mail_Queue($container_options, $mail_options);


$from             = 'bandungcamp@gmail.com';
$from_name        = 'YESNumber1';
$recipient        = 'aliffar24@gmail.com';
$recipient_name   = 'ALIF';
$message          = 'Hallo Cek Email Responders';
$from_params      = empty($from_name) ? '<'.$from.'>' : '"'.$from_name.'" <'.$from.'>';
$recipient_params = empty($recipient_name) ? '<'.$recipient.'>' : '"'.$recipient_name.'" <'.$recipient.'>';
$hdrs = array(
    'From'    => $from_params,
    'To'      => $recipient_params,
    'Subject' => 'YESNumber1',
);
$mime = new Mail_mime();
$mime->setTXTBody($message);
$body = $mime->get();
$hdrs = $mime->headers($hdrs);

// Put message to queue
$mail_queue->put($from, $recipient, $hdrs, $body);

// Also you could put this msg in more advanced mode
$seconds_to_send = 3600;
$delete_after_send = false;
$id_user = 7;
$mail_queue->put( $from, $recipient, $hdrs, $body, $seconds_to_send, $delete_after_send, $id_user );

// TO SEND EMAILS IN THE QUEUE

// How many mails could we send each time
$max_ammount_mails = 6;
$mail_queue =& new Mail_Queue($container_options, $mail_options);
$mail_queue->sendMailsInQueue($max_ammount_mails);
}

