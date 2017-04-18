

<?php
include("Menuhead.html");
session_start();

header("Content-Type: text/html; charset=utf-8");
mysql_query("SET NAMES UTF8");
if(isset($_SESSION['catchmessage']))
$msg=$_SESSION['catchmessage'];
else
$msg="";
?>
<body>
<H3><font color=red face=arial>
<P ALIGN=CENTER>
<?php echo $msg;

unset($_SESSION['catchmessage']);
?>
</P>
</font>
</H2>