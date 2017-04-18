
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

require_once '../class/utility.class.php';

$objUtility=new Utility();

if(isset($_GET['uid']))
$uid=$_GET['uid'];
else
$uid="";

if(mysql_query("update userlog set active='N' where Uid='".$uid."'"))
{
//echo "update userlog set active='N' where Uid='".$uid."'";
echo $objUtility->AlertNRedirect("Done","../mainmenu.php");
}

?>
</body></html>
