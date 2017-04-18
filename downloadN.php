<html>
<head>
<title>User Login Form</title>
</head>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
   
 $.ajaxSetup ({   
        cache: false  
 });   
 
$(window).unload(function() {
  $.ajax({
  url: 'logout.php',async : false
  });
return false;
}); //unload

}); //Ready Function
</script> 



<body>


<?php
session_start();
require_once './class/class.userlog.php';
require_once './class/utility.class.php';
$objUtility=new Utility();

$objUl=new Userlog();
$objUl->setUid($_POST['Uid']);
$objUl->setActive("F");
$objUl->setLog_time_in(date('H:i:s'));
$_SESSION['sid']=$objUl->maxSession_id();
$objUl->setSession_id($_SESSION['sid']);
$objUl->SaveRecord();

if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];
else
$ip="-";
$objUtility->saveTextLog("UserLog","Accessed Download  ".date('H:i:s')." From ".$ip);

?>
<p align="left"<>
<a href="./Database/BlankDatabase.Zip">Download Blank Database<br><br>
<a href="./Database/ExampleNalbari.zip">Download Dummy Database for testing(Nalbari)<br><br>
<a href="./Database/Election.Zip">
Download Software in ZIP File(Last Modified 5 Feb,2014 at 2:00 PM)</a> <br><br>
<a href="./Database/TCPDF.Zip">
Download TCPDF Library(For PDF Generation)</a><br><br>
<a href="./database/SimpleGuide.doc">
Download Installation Guide</a><br>  <br> 
<a href="./database/Format2Import.xls">
Download Excel Format File to Import in MySQL</a><br>  <br> 
<a href="./database/WampServer2.1e-x32.exe">
Download Wamp Server 2.1</a><br>  <br> 
</p>
   </body>
</html>
