<html>
<head><title>PHP Mail Sender</title></head>


<script type="text/javascript" language="javascript">


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
$allowedroll=0; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');

$cond=$_SESSION['cond'];

$sqldelete="delete from ".$_SESSION['tblname']." where ".$cond;


$sql="select * from ".$_SESSION['tblname']." where ".$cond;

$result=mysql_query($sql);


//echo $sql."<br>";

$index=1;
$colname=array();
$colname=$_SESSION['colname']; //Retrive Field List from Sesion Variable


$coldtype=array();
$coldtype=$_SESSION['coldtype'];


$ind=0;
$totcol=count($colname);


$insertsql="insert into ".$_SESSION['tblname']."(";

for($index=1;$index<=$totcol;$index++)
{
$insertsql=$insertsql.$colname[$index];

if ($index<$totcol)
$insertsql=$insertsql.",";

}

$insertsql=$insertsql.") values(";


$row = mysql_fetch_array($result);

for($index=0;$index<$totcol;$index++)
{
if (strlen($row[$index])>0)
$insertsql=$insertsql."'".$row[$index]."'";
else
$insertsql=$insertsql."NULL";
if ($index<$totcol-1)
$insertsql=$insertsql.",";
}// for


$insertsql=$insertsql.")";
echo $insertsql."<br>";

$_SESSION['insertstring']=$insertsql;

$result=mysql_query($sqldelete);
if (!$result)
{
header( 'Location: editrecord.php?tag=1' ) ;
}
else
{
$_SESSION['last']--;
//savesql($insertsql);
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


function savesql($line)
{
$fname = $_SESSION['tblname'].".sql";
$ts = fopen($fname, 'a') or die("can't open file");

$line=$line.";\n";

fwrite($ts, $line);
fclose($fname);
}


?>
</body>
</html> 







