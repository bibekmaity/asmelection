<html>
<head><title>PHP Mail Sender</title></head>


<script type="text/javascript" language="javascript">

function back()
{
window.location="viewrecordback.php?tag=1";
}

function back1()
{
window.location="editrecord.php?tag=1";
}

</script>



<body>
<?php 
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.Columns.php';
$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//$objCol=new Columns();

 ?>


<?php

if (isset($_SESSION['tblname']))
$sql="update ".$_SESSION['tblname']." set ";
else
$sql="";

if(isset($_SESSION['cond']))
$cond=$_SESSION['cond'];
else
$cond="1==2";


$index=1;

$colname=array();
$colname=$_SESSION['colname']; //Retrive Field List from Sesion Variable
$colselect=array();
$colselect=$_SESSION['colselect'];
$chartype=$_SESSION['chartype'];

$coldtype=array();
$coldtype=$_SESSION['coldtype'];

$ind=0;
$totcol=count($colname);


for($index=1;$index<=$totcol;$index++)
{

if($colselect[$index]=="Yes")
{
$sql=$sql.$colname[$index]."=".formatvalue($_POST[$colname[$index]],$coldtype[$index]);
$ind++;
if ($ind<$_SESSION['totrecselect'])
$sql=$sql.",";
}
}

$sql=$sql." WHERE ".$cond;

echo $sql."<br>";

$result=mysql_query($sql);



if(!$result)
{
echo "Failed to Update<br>";
echo "<input type=button name=but1 value=Back onclick=back1()>";
$_SESSION['rsl']=0;
header( 'Location: editrecord.php?tag=1' ) ;

}
else
{
echo "Updated record<br>";
echo "<input type=button name=but1 value=Back onclick=back()>";
$_SESSION['rsl']=$_SESSION['rsl1'];
header( 'Location: viewrecordback.php?tag=1' ) ;
}

mysql_close($con);


function formatvalue($mdate,$dtype)
{

if(preg_match('/DATE/',$dtype))
{
$mdate=$mdate."/";
$parray=array();
$tt="";
$j=0;
for($i=0;$i<strlen($mdate);$i++)
{
if (is_numeric($mdate[$i])) 
$tt=$tt.$mdate[$i];
else
{
if (strlen($tt)>0)
{
$parray[$j]=$tt;
if (strlen($parray[$j])==1)
$parray[$j]="0".$parray[$j];
$j++;
$tt="";
} 
}

}// for

echo "j=".$j;

if($j==3)
{
$dt="'".$parray[2]."-".$parray[1]."-".$parray[0]."'";
}
else
$dt="NULL";
}
else
{
if(strlen($mdate)>0)
$dt="'".$mdate."'";
else
$dt="NULL";
}

return($dt);
}



?>
</body>
</html> 







