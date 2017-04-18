<html>
<head><title>Entry Form</title></head>
<BODY>
<?php
//session_start();
header("Content-Type: text/html; charset=utf-8");
$con=mysql_connect('localhost','root');
if (!$con)
{
die('Could not connect to MySQL: ' . mysql_error());
}
mysql_select_db("election") or die(mysql_error());
mysql_query("SET NAMES UTF8");
?>
</body></html>
