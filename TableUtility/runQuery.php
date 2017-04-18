

<body>
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");

require_once '../class/utility.class.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=0; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: ../Mainmenu.php?unauth=1');

if(isset($_POST['sql']))
$mstr=$_POST['sql'];
else
$mstr="";

$mstr=trimBlank($mstr);

$j=strtoupper(ltrim($mstr));
$res=false;

$j1=(ltrim($mstr));


if (instr($j,"SELECT")>=0)
{
$sql=$j;
$select=true;   
}
else
{
$res=mysql_query($j1);
$select=false;
$sql="";
$numRows = mysql_affected_rows();
}



$pp=instr($j,"SELECT");

if ($pp >=0) 
{
$td=-(strlen($j)-$pp+1);
$j=substr($j, $td);

$jj=process($j);

$k=instr($j,"WHERE");

$i=0;
$result=mysql_query($sql);
if ($result)  //Success Query
{
while($row = mysql_fetch_array($result))
{
$i++;
echo "<tr>";
echo "<td align=center bgcolor=#FFFF66>".$i."</td>";

for ($kk=0;$kk<$jj;$kk++)
{
if(isset($row[$kk]))
$tt=$row[$kk];
else
$tt="";
echo "<td align=center bgcolor=#CCFF66>".$tt."</td>"; //populate Filed Value
}  //for
echo "</tr>";
} //while
} //if $result
else
echo "<tr><td align=center colspan=".($jj+1)."><font color=red face=arial size=2>Error in Statement</font><br><font color=blue face=arial size=1>".$sql."<br>(".mysql_error().")</td></tr>";
 

} //if $pp>=0 
else
{
?>
<p align="center">   
<?php
if ($res)
echo "<font color=blue face=arial size=2>Statement Executed  Successfully[Total Rows effected ".$numRows."]" ;
else
echo "<font color=black face=arial size=2>Failed to execute<br>[".$j1."<br><font color=red> (".mysql_error().")";
}
?>
</p>   
    
<?php


function process($aa)
{
$fldList=array();
$fld=array();
$jj=0;


if (instr($aa,",")>=0) //More than One Field
{
$row=explode(",",$aa);
for($i=0;$i<count($row);$i++)
{
$fld[$i]=processField($row[$i],$i);    
} //for LOOP
} //if
else
{    
$table=findTable($aa);
$fld=processSingleField($aa,$table) ;   
}
echo "<table border=1 width=100% align=center>";
echo "<tr><td align=center bgcolor=#FFFF66 >Running Serial</td>";
for ($kk=0;$kk<count($fld);$kk++)
echo  "<td align=center bgcolor=#FFFF66>".$fld[$kk]."</td>";
echo "</tr>";

return(count($fld));
} //end function



function instr($str,$find)
{
$temp=strlen($find);
$mindex=0;
$found=-1;
$lnth=strlen($str)-$temp;

while (($mindex<=$lnth) && ($found==-1))
{
if (substr($str,$mindex,$temp)==$find)
{
$found=$mindex;
}
$mindex++;
} //end while
return($found);
}  //end function

function processField($ff,$ind)
{
$ff=rtrim(ltrim($ff));    
$mrow=explode(" ",$ff);    
$tt=count($mrow);

if($ind==0) //First Field
return($mrow[$tt-1]);
else
return($mrow[0]);    
}

function processSingleField($ff,$table)
{
$ff=rtrim(ltrim($ff));    
$mrow=explode(" ",$ff); 
$trow=array();
$tt=count($mrow);
$val="";
if(isset($mrow[1]))
{
if($mrow[1]=="DISTINCT")
{
if(isset($mrow[2]))    
$trow[0]=$mrow[2]; 
}  
else 
{
if($mrow[1]!="*")
$trow[0]=$mrow[1]; 
else //* for All Field
{
$trow=ColumnList($table);    
} //$mrow[1]!="*"   
}//$mrow[1]=="DISTIN
}//isset($mrow[1])
return($trow);
} //function

function ColumnList($table)
{
require_once '../class/class.columns.php';
$objCol=new Columns();
$frow=array();
$objCol->setTable_name($table);
$myrow=$objCol->getColumnArray();
for($k=0;$k<count($myrow);$k++)
{
$frow[$k]=$myrow[$k]['Column_name'];    
}//for loop
$objC=new Config();
return($frow);
}


function trimBlank($str)
{

$newstr="";
$prev=0;
for ($i = 0; $i < strlen($str); $i++)
{
$k=ord(substr($str,$i,1));
if ($k==32 && $prev==0)
{
$newstr=$newstr;
}
else
{
$newstr=$newstr.substr($str,$i,1);
}
if ($k==32)
$prev=0;
else
$prev=1;
}
return($newstr);
}//trimBlank

function findTable($aa)
{
$tab="";
$aa=strtoupper($aa);    
$mrow=explode(" ",$aa);  
for($i=0;$i<count($mrow);$i++)
{
if($mrow[$i]=="FROM")
{
if(isset($mrow[$i+1])) 
$tab= $mrow[$i+1];   
}    
}//for LOOP
return($tab);
} //function
?>
</body>


