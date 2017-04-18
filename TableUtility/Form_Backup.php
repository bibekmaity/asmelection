<html>
<head>
<title>Backup Form</title>
</head>
<script language=javascript>
<!--


function validate()
{
myform.Save.disabled=true;
myform.back.disabled=true;
//disall();
myform.struct.disabled=true;
myform.data.disabled=true;
myform.action="GenSqlScript.php";
myform.submit();
}

function home()
{
myform.action="../mainmenu.php?tag=0";
myform.submit();
}

function enu1(s,d)
{
if(document.getElementById(s).checked==false)
document.getElementById(d).checked=false;    
}

function enu2(d,s)
{
if(document.getElementById(d).checked==true)
document.getElementById(s).checked=true;    
}


//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/class.columns.php';
require_once '../class/utility.class.php';
require_once '../class/class.sentence.php';



$objSen=new Sentence();


$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');



//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=80%>
<form name=myform action=""  method=POST >
<tr><td colspan=4 align=Center bgcolor=#FFCC66><font face=arial size=3>Select Tables for Backup<br></font><font face=arial color=red size=2>&nbsp;</font></td>
    <td align="center" bgcolor=#FFCC66>
        
    <input type=button value=Back  name=back onclick=home()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:blue;width:100px">

    </td>
</tr>
<tr>
<td align=center bgcolor=#66FF99><font color=black size=2 face=arial>Sl No</font></td>
<td align=center bgcolor=#66FF99><font color=black size=2 face=arial>Table Name</font></td>
<td align=center bgcolor=#66FF99><font color=black size=2 face=arial>
 All Structure<input type="checkbox" name="struct" onclick="Select1()" ></font></td>
<td align=center bgcolor=#66FF99><font color=black size=2 face=arial>No of Row</font></td>
<td align=center bgcolor=#66FF99><font color=black size=2 face=arial>All Data
<input type="checkbox" name="data" onclick="Select2()" >
</font></td>
</tr>
<?php
$objTab=new Columns();
//$objTab->setTable_schema("egovernance"); set in Class construct
$row=$objTab->getTableList();
$dis="";
$cnt=count($row);
//start Java Script
$temp="<Script language=javascript>\n";
$temp=$temp."function Select1()\n{";
echo $temp;
for($i=0;$i<$cnt;$i++)
{
$str1="if (myform.struct.checked==true)\n";
$str1=$str1."myform.Sel".($i+1).".checked=true;\n";   
$str1=$str1."else\n";
$str1=$str1."myform.Sel".($i+1).".checked=false;\n\n"; 
echo $str1;
}


echo "}\n\n";

$temp="function Select2()\n{";
echo $temp;
for($i=0;$i<$cnt;$i++)
{
$str1="if (myform.data.checked==true)\n";
$str1=$str1."myform.Data".($i+1).".checked=true;\n";   
$str1=$str1."else\n";
$str1=$str1."myform.Data".($i+1).".checked=false;\n\n"; 
echo $str1;
}
echo "}\n\n";

$temp="function disall()\n{";
echo $temp;
echo "myform.struct.disabled=true;\n";
echo "myform.data.disabled=true;\n";
for($i=0;$i<$cnt;$i++)
{
$str1="myform.Data".($i+1).".disabled=true;\n";   
echo $str1;
$str1="myform.Sel".($i+1).".disabled=true;\n";   
echo $str1;
}
echo "}\n\n";

echo "</script>";

//End Java Script

for ($i=0;$i<count($row);$i++)
{
$Tabname="Table".($i+1);
$Sel="Sel".($i+1);
$Data="Data".($i+1);
///echo $row[$i];
$sql=" select count(*) from ".$objTab->getTable_schema().".".$row[$i];
//echo $sql;
$result=mysql_query($sql);
$mrow=mysql_fetch_array($result);
$myrecord=$mrow[0];
if ($myrecord==0)
$dis=" disabled";
else
$dis="";
?>

<tr>
<td align=center bgcolor=#FFFFCC><font color=black size=2 face=arial><?php echo $i+1; ?></font></td>
<td align=left bgcolor=#FFFFCC>
<input type=hidden size=20 name="<?php echo $Tabname;?>"  value="<?php echo $row[$i]; ?>">
<?php echo $objSen->SentenceCase($row[$i]);?>
</td>
<td align=center bgcolor=#FFFFCC>
<input type=checkbox  name="<?php echo $Sel;?>" onclick="enu1('<?php echo $Sel;?>','<?php echo $Data;?>')">
</td>
<td align=center bgcolor=#FFFFCC><font color=black size=2 face=arial><?php echo $myrecord; ?></font></td>

<td align=left bgcolor=#FFFFCC>
<input type=checkbox  name="<?php echo $Data;?>" onclick="enu2('<?php echo $Data;?>','<?php echo $Sel;?>')" <?php echo $dis;?>>
</td>
</tr>
<?php
}
?>

<tr><td colspan="5" align="left">
<input type=hidden size=1 name="trow"  value="<?php echo ($i); ?>">
Enter File Name
<input type=text size=22 name="fname"  value="Backup">
<input type=button value="Export Selected Table"  name=Save   style="font-family:arial; font-weight:bold;font-size: 14px ; background-color:#999966;color:blue;width:180px" onclick=validate()>

    </td></tr>
</table>
</form>
<?php
//if($mtype==0)
//echo $objUtility->focus("Uid");

?>
</body>
</html>
