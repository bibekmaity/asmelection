

<?php

session_start();

header("Content-Type: text/html; charset=utf-8");
mysql_query("SET NAMES UTF8");
if(isset($_SESSION['catchmessage']))
$msg=$_SESSION['catchmessage'];
else
$msg="";
?>
<body>
<H3><font color=red face=arial size=2>
<P ALIGN=CENTER>
<?php echo  "<a href=left.php>".$msg."</a>";
unset($_SESSION['catchmessage']);
?>
</P>
</font>
</H2>