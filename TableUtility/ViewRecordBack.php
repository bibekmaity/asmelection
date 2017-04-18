<html>
<head><title>PHP Mail Sender</title></head>
<script type=text/javascript language=javascript>
function direct()
{

//alert('ok');
window.location="viewtable.php?tag=2";
//myform.action="viewrecord.php?tag=0";
//myform.submit();

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


$_tag=$_GET['tag'];

header("Content-Type: text/html; charset=utf-8");

$colname=array();
$coldtype=array();
$colkey=array();
$condition=array();
$parameter=array();
$sorting=array();
$colselect=array();



if ($_tag==1)
{
$colname=$_SESSION['colname'];
$colkey=$_SESSION['colkey'];
$maxpk=$_SESSION['maxpk'];
$colselect=$_SESSION['colselect'];
$sqlstr=$_SESSION['sqlstr'];
$sqlcount=$_SESSION['sqlcount'];
$mysqlstring=$_SESSION['$mysqlstring'];
$coldtype=$_SESSION['coldtype'];
}



echo "<p align=center><font size=2 face=arial>".$sqlstr."</font></p>";

//echo "totcol-".$_SESSION['totcol'];

$result1=mysql_query($sqlcount);
$row1 = mysql_fetch_array($result1);
$rvalue=$row1[0];


//echo "result-".$rvalue;

$tcount1=$_SESSION['last']-$_SESSION['first']+1;


if ($tcount1>$rvalue) 
$tcount1=$rvalue;



$twidth=($_SESSION['totcolselected']+2)*15;
if ($twidth>100)
$twidth=100;


echo "<table border=1 width=".$twidth."% align=center  >";

//Populate Field Name


echo "<tr><td align=center bgcolor=#ccffcc colspan=".($_SESSION['totcolselected']+2)."><font face=arial size=2>Table Name-".$_SESSION['tblname']."<br>Result-".$tcount1."/".$rvalue."</td></tr>";

echo "<tr><td align=center bgcolor=#CC99FF><font face=arial size=2>SL</td>";

//table header
for($i=1;$i<=$_SESSION['totcol'];$i++)
{
if ($colselect[$i]=="Yes")
echo "<td align=center bgcolor=#CC99FF><font face=arial size=2>".$colname[$i];
if ($colkey[$i]=="YES")
echo "*.</td>";
}
echo "<td align=center bgcolor=#CC99FF><input type=button name=but1 value=Back onclick=direct()></td>";
echo "</tr>";


$result=mysql_query($sqlstr);

if ($_SESSION['first']>$rvalue)
$_SESSION['first']=1;

if ($_SESSION['first']>1)  //Skip record
{
for ($i=1;$i<$_SESSION['first'];$i++)
{
$row = mysql_fetch_array($result);
}
}



$tempstr=$mysqlstring." WHERE ";
$i=0;
$ii=0;
$reccount=0;
while($reccount<$tcount1)
{
$row = mysql_fetch_array($result);
$ii++;

$reccount++;
$mysqlstring=" ";
echo "<tr><td align=center bgcolor=#ccffcc>".$ii."</td>";
echo "<form method=post action=editrecord.php?tag=0>";

$ind=0; //initialise field index
for($i=1;$i<=$_SESSION['totcol'];$i++)
{
if ($colselect[$i]=="Yes")
{
echo "<td align=left";
if ($_SESSION['rsl']==$ii)
echo " bgcolor=#CC9933";

if(preg_match('/DATE/',$coldtype[$i]))
echo ">".formatmydate($row[$ind]);
else
if (strlen($row[$ind])>0)
{
echo "<td align=left  bgcolor=white>";
if (isUnicode($row[$ind]))
echo "<font size=4 face=arial>";
else
echo "<font size=2 face=arial>";
echo  $row[$ind];
}
else
echo "<td align=left  bgcolor=white>&nbsp";
echo "</font></td>";
echo "</td>";


if ($maxpk>0)
{
if ($colkey[$i]=="YES")
$mysqlstring=$mysqlstring.$colname[$i]."='".$row[$ind]."' and ";
}
else //no primary key, hence select all fileld except few type
{
if(strlen($row[$ind])>0 && (preg_match('/INT/',$coldtype[$i]) || preg_match('/CHAR/',$coldtype[$i])))
$mysqlstring=$mysqlstring.$colname[$i]."='".$row[$ind]."' and ";
}
$ind++;
}// if $colselect=yes
} //for loop



echo "<td align=center bgcolor=#ccffcc>";
echo "<input type=hidden name=rsl value=".$ii.">";

echo "<input type=hidden name=sqlstring value=".chr(34).$tempstr.$mysqlstring." 1=1".chr(34).">";
echo "<input type=hidden name=condstring value=".chr(34).$mysqlstring." 1=1".chr(34).">";

echo "<input type=submit value=Edit></td>";

echo "</form>";
echo "</tr>";

}
if (strlen($_SESSION['insertstring'])>2)
{
echo "<form method=post action=undelete.php>";
echo "<tr><td align=center bgcolor=#ccffcc colspan=".($_SESSION['totcolselected']+1).">";
echo "<input type=hidden name=mystr value=".chr(34).$_SESSION['insertstring'].chr(34).">";
echo "</td>";
echo "<td align=center bgcolor=#ccffcc>";
//echo "<input type=submit value=Undelete></td>";
echo "</form>";
echo "</tr>";
}

echo "</table>";
 
$_SESSION['rsl']=0;


//mysql_close($con);

function formatmydate($mdate)
{
$mdate=substr($mdate,0,10);
$yy=substr($mdate,0,4);
$mm=substr($mdate,5,2);
$dd=substr($mdate,-2);
$dt=$dd."/".$mm."/".$yy;

if(strlen($dt)==10)
return($dt);
else
return("&nbsp");

}


function isUnicode($mystring)
{
$t="";
if (strlen($mystring) != strlen(utf8_decode($mystring))) 
$t=true;
else
$t=false;
return($t);
}

?>
</body>
</html> 


