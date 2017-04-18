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


function makepdf()
{
window.location="viewRecordInPdf.php";
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
//echo "Database ".$_SESSION['databasename'];
if($roll>0)
$dis=" disabled";
else 
$dis="";    

if(isset($_POST['vonly']))
$edit=true;
else
$edit=false;    

 
header("Content-Type: text/html; charset=utf-8");   //FOR UNICODE

$_tag=$_GET['tag'];

$_SESSION['insertstring']="";
$colname=array();
$coldtype=array();
$colkey=array();
$condition=array();
$parameter=array();
$sorting=array();
$colselect=array();

$chartype=array();
$mchartype=array();

$maxlength=array();
$colmaxlength=array();

$colmaxlength=$_SESSION['colmaxlength'];
$chartype=$_SESSION['chartype'];


$i=1;
$j=0;

$maxpk=0;

if ($_tag==0)  //RETURN FROM vIEWTABLE pAGE
{

$_SESSION['first']=$_POST['first'];
$_SESSION['last']=$_POST['last'];

$condexist=0;
$sortexist=0;

while($i <=$_SESSION['totcol'])
{
$mvalue="selbox".$i;
if (isset($_POST[$mvalue]))   //Box is Selected
{
$colselect[$i]="Yes";
$j=$j+1;
}
else
$colselect[$i]="No";

$maxlength[$i]=$colmaxlength[$i-1]; 
$mchartype[$i]=$chartype[$i-1];

$mvalue="field".$i;
$colname[$i]=$_POST[$mvalue];

$mvalue="col".$i;
$coldtype[$i]=$_POST[$mvalue];

$mvalue="chartype".$i;
$chartype[$i]=$_POST[$mvalue];

$mvalue="ispk".$i;
$colkey[$i]=$_POST[$mvalue];
if ($colkey[$i]=="YES")
$maxpk++;

$mvalue="cond".$i;
$condition[$i]=strtoupper($_POST[$mvalue]);

$mvalue="param".$i;
$parameter[$i]=$_POST[$mvalue];

if ($parameter[$i]<>"-" && $parameter[$i]<>"")
$condexist++;

$mvalue="sort".$i;
$sorting[$i]=$_POST[$mvalue];

if ($sorting[$i]>0)
$sortexist++;

$i=$i+1;

}  //while

$_SESSION['colmaxlength']=$maxlength;
$_SESSION['chartype']=$mchartype;
} //$tag=0



if ($_tag==0)
{
$_SESSION['condition']=$condition;
$_SESSION['parameter']=$parameter;
$_SESSION['sorting']=$sorting;
$_SESSION['colselect']=$colselect;
$_SESSION['colname']=$colname;
$_SESSION['coldtype']=$coldtype;
$_SESSION['colkey']=$colkey;
$_SESSION['maxpk']=$maxpk;
$_SESSION['colkey']=$colkey;
$_SESSION['chartype']=$chartype;
}




if ($_tag==0)

$_SESSION['totcolselected']=$j;





if ($_tag==0)  //Construct SQL String
{
$sqlstr="SELECT ";
$sqlcount="SELECT count(*)";
$k=0;
for ($i=1;$i <=$_SESSION['totcol'];$i++)
{
if ($colselect[$i]=="Yes")
{
$sqlstr=$sqlstr.$colname[$i];
$k=$k+1;
if ($k<$j)
$sqlstr=$sqlstr.",";

} //if

} //for

$sqlstr=$sqlstr." FROM ".$_SESSION['tblname'];
$sqlcount=$sqlcount." FROM ".$_SESSION['tblname'];

$mysqlstring=$sqlstr;

if ($_tag==0)
$_SESSION['$mysqlstring']=$mysqlstring;



if ($condexist>0)
{
$sqlstr=$sqlstr." WHERE ";
$sqlcount=$sqlcount." WHERE ";
}
$k=0;
for ($i=1;$i <=$_SESSION['totcol'];$i++)
{
if ($parameter[$i]<>"-" && $parameter[$i]<>"")
{

$newparam=newcond($condition[$i],$parameter[$i],$coldtype[$i]);  //call a function to segregate and validata parameter
if ($newparam!="@")
{
$sqlstr=$sqlstr.$colname[$i]." ".$condition[$i].$newparam;
$sqlcount=$sqlcount.$colname[$i]." ".$condition[$i].$newparam;
}
else
{
$sqlstr=$sqlstr." 1=1 ";
$sqlcount=$sqlcount." 1=1 ";
}

$k=$k+1;
if ($k<$condexist)
{
$sqlstr=$sqlstr." and ";
$sqlcount=$sqlcount." and ";
}// if
} //if

}  //for loop


if ($sortexist>0)
$sqlstr=$sqlstr." ORDER BY ";

$k=0;
for ($i=1;$i <=$_SESSION['totcol'];$i++)
{
if ($sorting[$i]>0)
{
$sqlstr=$sqlstr.$colname[$i];
if($sorting[$i]==2)
$sqlstr=$sqlstr." DESC";
$k=$k+1;
if ($k<$sortexist)
$sqlstr=$sqlstr." , ";

} //if

}  //for loop




if ($_tag==0)   //store sql string in Session variable
{
$_SESSION['sqlstr']=$sqlstr;
$_SESSION['sqlcount']=$sqlcount;
}


if($edit==true)
echo "<p align=center><font size=2 face=arial>".$sqlstr."</font></p>";


mysql_query("SET character_set_database=utf8");

//echo $sqlcount;
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


echo "<table border=1 width=".$twidth."% align=center cellpadding=1>";

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
//while($row = mysql_fetch_array($result))
while($reccount<$tcount1)
{
$row = mysql_fetch_array($result);
$ii++;
$reccount++;
$mysqlstring=" ";
if ($row)
{
echo "<tr><td align=center bgcolor=#ccffcc >".$ii."</td>";
if($edit==true) 
echo "<form method=post action=editrecord.php?tag=0>";

$ind=0; //initialise field index
for($i=1;$i<=$_SESSION['totcol'];$i++)
{
if ($colselect[$i]=="Yes")
{
if(preg_match('/DATE/',$coldtype[$i]))
echo "<td align=left  bgcolor=white >".formatmydate($row[$ind]);
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


echo "<td align=center bgcolor=#ccffcc valign=center>";
if($edit==true)
{
echo "<input type=hidden name=rsl value=".$ii.">";
echo "<input type=hidden name=sqlstring value=".chr(34).$tempstr.$mysqlstring." 1=1".chr(34).">";
echo "<input type=hidden name=condstring value=".chr(34).$mysqlstring." 1=1".chr(34).">";
echo "<input type=submit value=Edit".$dis."></td>";
echo "</form>";
}
else
echo "&nbsp;</td>";    
echo "</tr>";
} //row<>null
}  //while loop
mysql_free_result($result);
}  
echo "</table>";


function newcond($cond,$param,$dtype)
{


$t="";
if($cond=="=" || $cond=="<" || $cond==">" || $cond=="<>")
{


if(preg_match('/DATE/',$dtype))
$param=formatsqldate($param);


if(preg_match('/INT/',$dtype))
{
if (is_numeric($param))
$t=$param;
else
$t="@";
}
else
$t=" '".$param."' ";
} //cond="=="


if($cond=="IN" || $cond=="NOT IN" || $cond=="BETWEEN")
{
$ok=1;
$param=$param." ";
$parray=array();
$tt="";
$j=0;
for($i=0;$i<strlen($param);$i++)
{

if (ctype_alpha($param[$i]) || is_numeric($param[$i]) || $param[$i]=="/" ) 
$tt=$tt.$param[$i];
else
{
if (strlen($tt)>0)
{
$parray[$j]=$tt;
if(preg_match('/INT/',$dtype) && is_numeric($parray[$j])==false)
$ok=0;
$j++;
$tt="";
} //strlen
} //ctype_alpha

} //for loop


if($cond=="IN" || $cond=="NOT IN")
{
$tt="(";
for($k=0;$k<$j;$k++)
{
if(preg_match('/INT/',$dtype))   //numeric 
$tt=$tt.$parray[$k];
else  //use quote as not numeric
{
if(preg_match('/DATE/',$dtype))   //DATE
$tt=$tt."'".formatsqldate($parray[$k])."'";
else
$tt=$tt."'".$parray[$k]."'";
}
if($k<$j-1)
$tt=$tt.",";
} //for loop
$tt=$tt.")";
$t=$tt;
} //if 

if($ok==0)
$t="@";

if($cond=="BETWEEN")
{
if (count($parray)>1)
{
if(is_numeric($parray[0]) && is_numeric($parray[1]))
$t=" ".$parray[0]." AND ".$parray[1]." ";
else
$t="@";
}
else
$t="@";

} //if between

} // $cond=="in" || $cond=="not in" || $cond=="between"


if($cond=="LIKE")
{
$t=" '%".$param."%' ";
}

//if(($cond=="=" || $cond=="LIKE") && isUnicode($param)==true)
//$t="N".$t;

return($t);
}


function formatmydate($mdate)
{
$mdate=substr($mdate,0,10);
$yy=substr($mdate,0,4);
$mm=substr($mdate,5,2);
$dd=substr($mdate,-2);   //2 character from right
$dt=$dd."/".$mm."/".$yy;
if(strlen($dt)==10)
return($dt);
else
return("&nbsp");
}


function formatsqldate($mdate)
{
$mdate=substr($mdate,0,10);
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


if($j==3)
{
$dt=$parray[2]."-".$parray[1]."-".$parray[0];
}
else
$dt="NULL";


return($dt);
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



//mysql_close($con);

?>
</body>
</html> 


