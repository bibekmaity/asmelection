
<body>

<?php
session_start();
//header('Refresh: 1;url=Inter.php');
date_default_timezone_set("Asia/kolkata");

require_once './class/class.copy.php';

$objCp=new CopyF();

//$objCp->AllFrameExist()
//echo $objCp->Left." ".$objCp->Middle." ".$objCp->Right."<br>";


if(isset($_SESSION['sec']))
$tmp=$_SESSION['sec']+1;
else
$tmp=0;

if($objCp->AllFrameExist())
header( 'Location: Mainmenu.php?tag=0');
else
{
$_SESSION['sec']=$tmp;

//echo $objCp->Left." ".$objCp->Middle." ".$objCp->Right."<br>";
?>
<p align=center>
<span style="background-color: #66CCCC">
<font face=arial size=3 color=black>
<b>
Problem in Loading Menu.</font>
</span>
<br>
(Please Close window, refresh and Restart)
</p>
</font>
<?php
}
?>
   

</html>