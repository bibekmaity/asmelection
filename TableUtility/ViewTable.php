<html>
<head><title>PHP Mail Sender</title></head>
<script type=text/javascript language=javascript>
function test()
{

//alert('ok');
//window.location="viewrecord.php";
myform.action="viewrecord.php?tag=0";
myform.submit();

}

function check(n)
{
var  str=n.value;
var k=0;
var mylength=str.length;
var newstr="";
for (var i = 0; i < str.length; i++) 
{   
k=parseInt(str.charCodeAt(i));
var j=str.substr(i,1);
if ((j=="-")|| (j=="/")|| (k==95 || k==44 || k==32 || (k>=48 && k<=57)  || (k>=97 && k<=122)  || (k>=65 && k<=90) )  )
{
newstr=newstr+str.substr(i,1);
}
else
{
alert('Invalid  Name');
}
}
n.value=newstr;
}

function goback()
{
window.location="../MainMenu.php?tag=1";
}

function genscript()
{
myform.action="genscript.php?tag=0";
myform.submit();
}

</script>


<body>




<?php 
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.Columns.php';
require_once 'header.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
if ($roll>0)
$dis=" disabled";
else 
$dis=" ";    
$_SESSION['rsl']=0;

header("Content-Type: text/html; charset=utf-8");   //FOR UNICODE


if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>3)
$_tag=0;



if(isset($_SESSION['databasename']))
$database=strtoupper($_SESSION['databasename']);
else
$database="";
    
if ($_tag==0)
{
echo "&nbsp;";
$objCol=new Columns(); //Instantiate Class for Information_Schema 

if(!isset($_SESSION['tblname']))
$_SESSION['tblname']="-";    
}

//$_SESSION['tblname']="";

if ($_tag==1)
{    
if(isset($_POST['tblname']))
$_SESSION['tblname']=$_POST['tblname'];
else
$_SESSION['tblname']="";  
}
$colmaxlen=array();
//echo $_tag;

echo "<p align=center><font face=arial size=3 color=green>DATABASE NAME-<font color=red>".$database."</font></p>";
echo "<hr>";

/* location.href="mypage.php"; */

if ($_SESSION['databasename']=='INFORMATION_SCHEMA' )
$sqlstr="select table_name from information_schema.tables where Table_Schema='".$_SESSION['databasename']."' order by table_name";
else
$sqlstr="select table_name from information_schema.tables where table_type='BASE TABLE' and Table_Schema='".$_SESSION['databasename']."' order by table_name";


//echo $sqlstr;
$result=mysql_query($sqlstr);

echo "<form action=viewtable.php?tag=1 method=POST>";
echo "<table border=0 width=60% align=center bgcolor=#CCFF99>";
echo "<tr><td align=right>Select Table</td><td align=left>";
echo "<select name=tblname>";
//echo "<option value=>";
while($row = mysql_fetch_array($result))
{
if (strtoupper($_SESSION['tblname'])==strtoupper($row['table_name']))
echo "<option selected value=".strtoupper($row['table_name']).">".strtoupper($row['table_name']);
else
echo "<option  value=".strtoupper($row['table_name']).">".strtoupper($row['table_name']);

}
echo "<input type=submit  value= GO>";
echo "<input type=button value=MAIN  onclick=goback()>";
echo "</td></tr></table></form>";

//Postback
if ($_tag==1 || $_tag==2 || $_tag==3)
{

if ($_tag==2)
{
$mcondition=array();
if(isset($_SESSION['condition']))
$mcondition=$_SESSION['condition'];

$parameter=array();
if (isset($_SESSION['parameter']))
$parameter=$_SESSION['parameter'];

$sorting=array();
if(isset($_SESSION['sorting']))
$sorting=$_SESSION['sorting'];

$colselect=array();
if (isset($_SESSION['colselect']))
$colselect=$_SESSION['colselect'];

$totcol=count($mcondition);


}  //$_tag==2


if ($_tag==3)
{
$colselect=array();
if(isset($_SESSION['colselect']))
$colselect=$_SESSION['colselect'];
}


$sqlstr1="select COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,COLUMN_DEFAULT,IS_NULLABLE,COLUMN_KEY,CHARACTER_SET_NAME  FROM information_schema.columns where  table_schema='".$_SESSION['databasename']."' and  table_name='".$_SESSION['tblname']."' order by ordinal_position";

//echo "string ok";
//echo $_tag." ".$_SESSION['databasename'];
$sqlcount="select count(*)  FROM ".$_SESSION['databasename'].".".$_SESSION['tblname'];
//$sqlcount="select count(*)  FROM ".$_SESSION['tblname'];

$resultcount=mysql_query($sqlcount);
//echo $sqlcount."<br>";
$colcount = mysql_fetch_array($resultcount);
//echo "result".$resultcount."<br>";
$totrec=$colcount[0];

if ($_tag==2)
{
$first=$_SESSION['first'];
$last=$_SESSION['last'];
$objCol=new Columns();
}
else
{
$first=1;
if ($totrec<200) 
$last=$totrec;
else
$last=200;
}




$result1=mysql_query($sqlstr1);
//echo "resultset ok";

//load resultset in array

$colname=array();
$coldtype=array();
$colmaxlength=array();
$coldefault=array();
$colnull=array();
$colkey=array();
$chartype=array();
$i=0;
while($row = mysql_fetch_array($result1))
{
$colname[$i]=strtoupper($row[0]);
$coldtype[$i]=strtoupper($row[1]);
$colmaxlength[$i]=$row[2];
$coldefault[$i]=$row[3];
$colnull[$i]=$row[4];
$colkey[$i]=$row[5];
$chartype[$i]=$row[6];
$i=$i+1;
}

$_SESSION['colmaxlength']=$colmaxlength;
$_SESSION['chartype']=$chartype;



//dynamic javascript
echo "<script type=text/javascript language=javascript>\n";
echo "function direct()\n";
echo "{\n";
//echo "alert('";

echo "var fn=myform.first.value;\n";
echo "var ln=myform.last.value;\n";


//isNaN(a)==false

$mind=1;
$mcount=0;
for($k=0;$k<$i;$k++)
{ 

$mcount++;
if ($mcount>25)
{
$mcount=1;
$mind++;
}
if ($colkey[$k]=="PRI")  //Check Primary Key Fiedl By default
echo "myform.selbox".($k+1).".checked=true;\n";

echo "var ".chr(97+$mcount).$mind."=myform.param".($k+1).".value;\n";
echo "var index_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."'".chr(34).");\n";
echo "var semicolon_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34).";".chr(34).");\n";
echo "var dash_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."--".chr(34).");\n";
echo "var amp_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."&".chr(34).");\n";
echo "var left_".chr(97+$mcount).$mind."=".chr(97+$mcount).$mind.".indexOf(".chr(34)."(".chr(34).");\n";


echo "var sel_".chr(97+$mcount).$mind."=myform.selbox".($k+1).".checked;\n";

}


echo "if (isNaN(fn)==false && isNaN(ln)==false && parseInt(ln)>=parseInt(fn) && ";

$mind=1;
$mcount=0;

for($k=0;$k<$i;$k++)
{
$mcount++;
if ($mcount>25)
{
$mcount=1;
$mind++;
}
echo "index_".chr(97+$mcount).$mind."==-1 && semicolon_".chr(97+$mcount).$mind."==-1 && dash_".chr(97+$mcount).$mind."==-1 && amp_".chr(97+$mcount).$mind."==-1 && left_".chr(97+$mcount).$mind."==-1" ;
if ($k<$i-1)
echo " && ";
}


echo " && (";
$mind=1;
$mcount=0;

for($k=0;$k<$i;$k++)
{
$mcount++;
if ($mcount>25)
{
$mcount=1;
$mind++;
}

echo "sel_".chr(97+$mcount).$mind."==true";
if ($k<$i-1)
echo " || ";
}


echo "))\n";
echo "{\n";
echo "//alert('OK');\n";
echo "myform.action=".chr(34)."viewrecord.php?tag=0".chr(34).";\n";
echo "myform.submit();\n";
echo "}\n";
echo "else\n";
echo "alert('Invalid Selection or Character');\n";
//echo "}\n";

//echo "')";


echo "}";
echo "\n";

echo "function selectall()\n";
echo "{\n";
echo "var tag=myform.selall.checked;\n";

for($k=0;$k<$i;$k++)
{
echo "if(tag==true)\n";
echo "myform.selbox".($k+1).".checked=true;\n";
echo "else\n";
echo "myform.selbox".($k+1).".checked=false;\n";
}
echo "}";

echo "\n";




echo "function ins()\n";
echo "{\n";


for($k=0;$k<$i;$k++)
{ 

if ($colnull[$k]=="NO")  //Check column NULL
echo "myform.selbox".($k+1).".checked=true;\n";
}

echo "alert('Proceding to Insert Form');\n";
echo "myform.action=".chr(34)."insertrecord.php?tag=0".chr(34).";\n";
echo "myform.submit();\n";
echo "}";



echo "</script>";




$_SESSION['totcol']=$i;

$twidth=($i-1)*15;

if ($twidth>100)
$twidth=100;

if($i<5)
$twidth=60;  //Minimum width 40%  

$cspan=$i;
   
if($cspan<1)
$cspan=1;

$conditionInt=array(1=>'<',2=>'>',3=>'<>',4=>'in',5=>'not in', 6=>'between');
$conditionChar=array(1=>'in',2=>'not in',3=>'like');
$conditionDate=array(1=>'<',2=>'>',3=>'<>');


$sorton=array(1=>'Asc',2=>'Desc') ;


echo "<form name=myform action=viewrecord.php?tag=0 method=POST>";

echo "<table border=1 width=".$twidth."% align=center bgcolor=#FFFF99 style='border-collapse: collapse';>";

//Populate Field Name

echo "<tr><td align=center bgcolor=#CCFFCC><font face=arial size=2>Field Type/Name</td>";

for($j=0;$j<$i;$j++)
{
$k=$j+1;
if ($colkey[$j]=="PRI")
$mkey="YES";
else
$mkey="NO";
echo "<td align=center bgcolor=#FFFFCC>";
echo "<font face=arial size=1>";
echo $coldtype[$j];
if ($coldtype[$j]=="char" || $coldtype[$j]=="varchar")
echo "(".$colmaxlength[$j].")";
echo "</font>";
echo "<hr>";
echo "<font face=arial size=2>";
echo $colname[$j];
echo "</font>";
//Hidden Field
echo "<input type=hidden name=field".$k." value=".chr(34).$colname[$j].chr(34).">";
echo "<input type=hidden name=col".$k." value=".chr(34).$coldtype[$j].chr(34).">";
echo "<input type=hidden name=chartype".$k." value=".chr(34).$chartype[$j].chr(34).">";
echo "<input type=hidden name=ispk".$k." value=".chr(34).$mkey.chr(34).">";
echo "</td>";
}
for($nn=0;$nn<3-$i;$nn++)
echo "<td align=center bgcolor=#FFFFCC>&nbsp</td>";

echo "</tr>";


//Populate Condition String(second Row)

echo "<tr><td align=center bgcolor=#CCFFCC><font face=arial size=2>Select Condition</td>";

for($j=1;$j<=$i;$j++)
{
echo "<td align=center bgcolor=#FFFFCC>";
echo "<select name=cond".$j.">";

if($_tag==2)
echo "<option selected value=".chr(34).$mcondition[$j].chr(34).">".$mcondition[$j];

$condition=array();

if(preg_match('/INT/',$coldtype[$j-1]))   //numeric 
$condition=$conditionInt;

if(preg_match('/CHAR/',$coldtype[$j-1]))   //numeric 
$condition=$conditionChar;

if(preg_match('/DATE/',$coldtype[$j-1]))   //numeric 
$condition=$conditionDate;

$condcount=count($condition);
echo "<option value=".chr(34)."=".chr(34).">"."=";
for($index=1;$index<=$condcount;$index++)
{
echo "<option value=".chr(34).$condition[$index].chr(34).">".$condition[$index];
}


echo "</select><br>";

if($_tag==2)
$mvalue=$parameter[$j];
else
$mvalue="-";

echo "<input type=text size=8 value=".chr(34).$mvalue.chr(34)."  name=param".$j;
$fldname="param".$j;
echo "  onchange=".chr(34)." check($fldname)".chr(34).">";

echo "</td>";
}
echo "</tr>";

//Populate Select Box (Third Row)

echo "<tr><td align=center bgcolor=#CCFFCC><font face=arial size=2>Select to View</td>";

for($j=0;$j<$i;$j++)
{
$k=$j+1;
if($colkey[$j]=="PRI")
$chkme=" Checked=checked";
else
{
if(($_tag==2 || $_tag==3) && $colselect[$k]=="Yes")
$chkme=" Checked=checked";
else
$chkme="";
}

echo "<td align=center bgcolor=#FFFFCC>";

echo "<input type=checkbox name=selbox".$k." value=".chr(34)."sel".chr(34).$chkme.">";

echo "</td>";
}
echo "</tr>";


//Populate Sorting Box (Forth Row)

echo "<tr><td align=center bgcolor=#CCFFCC><font face=arial size=2>Sort</td>";

for($j=1;$j<=$i;$j++)
{
echo "<td align=center bgcolor=#FFFFCC>";
echo "<select name=sort".$j.">";
if($_tag==2 && $sorting[$j]>0)
echo "<option value=".$sorting[$j].">".$sorton[$sorting[$j]];

echo "<option value=0>";
echo "<option value=1>ASC";
echo "<option value=2>DESC";

echo "</select><br>";

echo "</td>";
}
echo "</tr>";

echo "<tr><td align=center bgcolor=#CCFFCC colspan=1><font face=arial size=2>Total Record-".$totrec."</td>";
echo "<td align=center bgcolor=#FFFFCC colspan=".$cspan."><font face=arial size=2>From-";
echo "<input type=text size=2 value=".$first."  name=first>&nbspto";
echo "<input type=text size=3 value=".$last."  name=last></td></tr>";

echo "<tr><td align=right bgcolor=#CCFFCC colspan=1><input type=checkbox name=selall onclick=selectall()><font face=arial size=2>Select All</td>";
echo "<td align=left bgcolor=#CCFFCC colspan=".$cspan."><input type=button name=but1 value=Display onclick=direct()>";
?>    
<input type="checkbox" name="vonly" id="vonly" <?php echo $dis;?> checked="checked">
<font face="arial" size="1" color="red"><b>With Edit Option
</td></tr>
<?php
if (1==2)
{
echo "<tr><td align=right bgcolor=#CCFFCC colspan=2>Select Database type</td>";
echo "<td align=left bgcolor=#CCFFCC colspan=2></td></tr>";
echo "<tr><td align=right bgcolor=#CCFFCC colspan=2><select name=dbtype>";
echo "<option value=1>MySql";
echo "<option value=2>Sql Server";
echo "</select></td>";
}
echo "</table>";
echo "</form>";

}  //end if
?>

</body>
</html> 


