
<?php
session_start();

ini_set("SMTP","mail.nic.in");
ini_set("smtp_port","465");
ini_set('sendmail_from', 'nalbari@nic.in');


$to = "deka.jk@nic.in";
$subject = "Software News";

$message =" Common Group Status ";
$res=mail($to,$subject,$message);
if($res)
echo "Sent";
else
echo "fails";


?>

    
