<html>
<head><title>PHP Mail Sender</title></head>


<script type="text/javascript" language="javascript">


function back()
{
window.location="viewrecordback.php?tag=1";
}


 function del()
  {
//alert('ok');
   var name = confirm("Confirm Delete Record ");
   if (name == true)
     window.location="deleterecord.php";    
  }


 function ins()
  {
    window.location="insertrecord.php?tag=0";    
  }


function mark()
{
myform.but2.disabled=false;
myform.but3.disabled=true;
}



</script>

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
//$objCol=new Columns();
if($objUtility->CriticalAllowed()==false)
$dis=" disabled";
else
$dis="";
 ?>

<?php
header("Content-Type: text/html; charset=utf-8");


$_tag=$_GET['tag'];


if($_tag==0)  //first load
{
$sql=$_POST['sqlstring'];
$cond=$_POST['condstring'];
$_SESSION['cond']=$cond;
$_SESSION['sql']=$sql;
$_SESSION['rsl1']=$_POST['rsl'];
$_SESSION['sql']=$sql;
}

if($_tag==1)
{
$sql=$_SESSION['sql'];
$cond=$_SESSION['cond'];
}

echo "<p align=center><font size=1 face=arial>".$sql."</font></p>";

$index=1;

$colname=array();
$colkey=array();
$colname=$_SESSION['colname']; //Retrive Field List from Sesion Variable
$colselect=array();
$colselect=$_SESSION['colselect'];

$coldtype=array();
$coldtype=$_SESSION['coldtype'];

$colkey=$_SESSION['colkey'];

$totcol=count($colname);



//dynamic javascript
echo "<script type=text/javascript language=javascript>\n";
echo "function validate()\n";
echo "{\n";
//echo "alert('";

//isNaN(a)==false
$str="if(";


$mind=1;
$mcount=0;

for($k=0;$k<$totcol;$k++)
{ 
$mcount++;
if ($mcount>25)
{
$mcount=1;
$mind++;
}

if ($colselect[$k+1]=="Yes")  
{

if (preg_match('/INT/',$coldtype[$k+1]))
{
echo "var ".chr(97+$mcount).$mind."=myform.".$colname[$k+1].".value;\n";
$str=$str."isNaN(".chr(97+$mcount).$mind.")==false && ";
}
else
{
echo "var ".chr(97+$mcount).$mind."=myform.".$colname[$k+1].".value;\n";
echo "var index_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."'".chr(34).");\n";
echo "var semicolon_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34).";".chr(34).");\n";
echo "var dash_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."--".chr(34).");\n";
$str=$str."index_".chr(97+$mcount).$mind."==-1 && semicolon_".chr(97+$mcount).$mind."==-1 && dash_".chr(97+$mcount).$mind."==-1 && " ;

} //if pregamatch
} //if colselect
} //for

$str=$str." 1==1)\n";

echo $str;
echo "{\n";
echo "//alert('ok');\n";
echo "myform.action=".chr(34)."updaterecord.php".chr(34).";\n";
echo "myform.submit();\n";
echo "}\n";
echo "else\n";
echo "alert('Invalid Data');\n";
echo "}";


echo "</script>";


echo "<body>";

echo "<table border=1 width=80% align=center bgcolor=#FFFF99 >";

//Populate Field Name
echo "<form name=myform method=post>";

echo "<tr><td align=center  colspan=3 bgcolor=#9999CC><font face=arial size=2>Table Name-".$_SESSION['tblname']."</td></tr>";


$result=mysql_query($sql);

$row=mysql_fetch_array($result);

//echo $totcol;
$mindex=0;
$sl=0;
for($index=0;$index<$totcol;$index++)
{
if ($colselect[$index+1]=="Yes")
{
$sl++;

if (isUnicode($row[$mindex])==true)
$mystyle=" STYLE=".chr(34)."font-family: Arial; font-size: 18px".chr(34);
else
$mystyle=" STYLE=".chr(34)."font-family: Arial; font-size: 12px".chr(34);


echo "<tr><td align=center bgcolor=#99FFCC width=5%>".$sl."<td align=right bgcolor=#99FFCC width=30%>".$colname[$index+1]."</td>"; 
echo "<td align=left bgcolor=#99FFCC width=65%>";

if(preg_match('/DATE/',$coldtype[$index+1])) 
{
echo "<input type=text size=10 name=".$colname[$index+1]." value=".chr(34).formatmydate($row[$mindex]).chr(34);
$dformat="<font size=2 face=arial>DD/MM/YYYY</font>";
}
else
{
echo "<input type=text size=50 name=".$colname[$index+1]." value=".chr(34).$row[$mindex].chr(34);
$dformat="";
}

//$dformat=strlen($row[$mindex])."-".strlen(utf8_decode($row[$mindex]));
echo $mystyle;
if ($colkey[$index+1]=="YES")
echo " readonly ";
echo " onchange=mark()";
echo ">".$dformat."</td></tr>";
$mindex++;
}
}  //for loop
echo "<tr><td bgcolor=#99FF33>&nbsp</td><td align=right bgcolor=#99FF33 width=30%>";
echo "<input type=button name=but1 value=Back onclick=back()></td>";
echo "<td align=left bgcolor=#99FF33 width=70%>";
echo "<input type=button name=but2 value=Update onclick=validate() disabled>";
if ($roll==0) //Only Root User with Allowed Client IP can Delete Row
echo "<input type=button name=but3 value=Delete onclick=del() ".$dis.">";

echo "</tr>";
echo "</table>";
echo "</form>";

$_SESSION['totrecselect']=$mindex;
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


