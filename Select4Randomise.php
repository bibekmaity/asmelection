<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function direct1()
{
var i;
i=0;
}
function setMe()
{
myform.Lac.focus();
}

function redirect(i)
{
}

function PreTest()
{
    
//var data="Lac="+document.getElementById('Lac').value; 
//alert(data);
//var Box1="Day"+document.getElementById('Lac').value+"_0";
//var Box2="Day"+document.getElementById('Lac').value+"_1";

//data=data+"&"+Box1+"="+document.getElementById(Box1).value; 
//data=data+"&"+Box2+"="+document.getElementById(Box2).value; 
//alert(data);
//MyAjaxFunction("POST","PreRanCheck.php",data,'Mselect',"Text");
}


function validate()
{


var b_index=parseInt(myform.Lac.value);

if ( b_index>0)
{
myform.Save.disabled=true;
myform.action="RandomisePS.php";
myform.submit();
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br>Randomising Polling Group...Please Wait";
}
else
alert('Invalid Data');
}


function load(i,day)
{
    
//alert(i);
myform.Lac.value=i;
myform.Save.disabled=false;
var boxname="Day"+i+"_1";    
document.getElementById(boxname).disabled=false;

if (day==0)
{
boxname="Day"+i+"_0";       
document.getElementById(boxname).disabled=false;
}

}



function home()
{
window.location="mainmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}

function LoadTextBox()
{
var i=myform.Editme.selectedIndex;
if(i>0)
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;
//alert('Write Java Script as per requirement');
}

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.lac.php';
require_once './class/class.final.php';
require_once './class/class.polinggroup.php';
require_once './class/class.party_calldate.php';
require_once 'header.php';    
$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify
$objLac=new Lac();
if($objLac->CommongroupStatus()<4)
{
$_SESSION['catchmessage']="POLING GROUP SHOULD BE COMPLETED AND LOCKED BEFORE THIRD LEVEL RANDOMISATION";
header( 'Location: CatchMsg.php');
}

$objPsname=new Psname();
$objF=new LacFinal();
if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>2)
$_tag=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$present_date=date('d/m/Y');
$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if(isset($_SESSION['msg']))
echo $objUtility->alert ($_SESSION['msg']);   
    
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="0";//Lac
$mvalue[1]="0";//Psno
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
}//tag=1 [Return from Action form]

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objPsname->MaxPsno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Psno
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


//Start of FormDesign
?>
     <div align="center" id="Result"> 
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=95%>
<form name=myform action=""  method=POST >
<tr><td colspan="6" align="center">
<font face="arial" size="2"><B>SELECT LAC FOR THIRD LEVEL RANDOMISATION(PS ALLOCATION)</B>         
</td></tr>
<tr>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2" ><B>LAC Code
</td>
<td align=center bgcolor=#CCFFCC width="25%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>LAC Name
</td>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Total Group
</td>
<td align=center bgcolor=#CCFFCC width="10%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Click Select
</td>
<td align=center bgcolor=#CCFFCC width="15%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Reporting Date
</td>
<td align=center bgcolor=#CCFFCC width="30%"><font size=2 face=arial color=blue>
<font face="arial" size="2"><B>Status
<input type="hidden" name="Lac" id="Lac" size="1">
</td>
</tr>
<?php 
$objPg=new Polinggroup();

$objLac->setCondString(" code >0 and Code in(Select distinct Lac from PolingGroup) order by code" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
//echo $objLac->returnSql;
$dis="";
for($ind=0;$ind<count($row);$ind++)
{
$laccode=$row[$ind]['Code'];
$cond="Lac=".$laccode;    
$tgrp=$objPg->rowCount($cond);    
  
$msg=$objLac->groupStatusDetail($laccode);

if($objLac->groupStatus($laccode)==4 || $objLac->groupStatus($laccode)==5) //Group Locked
$dis="";    
else
$dis=" disabled";
if($objLac->AdvancePosting($laccode))
$nodays=0;
else
$nodays=1;
?>
<tr>
<td align=center ><font size=2 face=arial color=blue>
<font face="arial" size="2"><?php echo $row[$ind]['Code'];?>
</td>
<td align=left ><font size=2 face=arial color=blue>
<font face="arial" size="2"><?php echo $row[$ind]['Name'];?>
</td>
<td align=center ><font size=2 face=arial color=blue>
<font face="arial" size="2">
<?php 
echo $tgrp;?>
</td>
<td align=center ><font size=2 face=arial color=blue>
<input type="radio" name="Sel" value="<?php echo $laccode;?>" onclick="load(<?php echo $laccode;?>,<?php echo $nodays;?>)" <?php echo $dis;?> >
</td>
<td align=center ><font size=2 face=arial color=blue>
<?php
$objF=new LacFinal();
$objF->setLac($laccode);
$objF->setMtype("2");

$objParty_calldate=new Party_calldate();
$objParty_calldate->setCondString(" Code in(Select distinct Reporting_tag from psname where Lac=".$laccode.") order by Code" ); //Change the condition for where clause accordingly
$mrow=$objParty_calldate->getRow();
$Tr=0;
$mm="";
for($n=0;$n<count($mrow);$n++)
{
$objF->setTag($mrow[$n][0]);    
$boxname="Day".$laccode."_".$mrow[$n][0];    
if ($objF->EditRecord()==false) //Not Already Locked
{
$Tr=0;    
?>
<input type="checkbox" name="<?php echo $boxname;?>" id="<?php echo $boxname;?>" value="<?php echo $mrow[$n][1];?>"  onclick="PreTest()">
<?php
}
else
{
$Tr=1; 
$mm=$mrow[$n][0];
?>
&nbsp;&nbsp;&nbsp;&nbsp;<input type="hidden" size="1" name="<?php echo $boxname;?>" id="<?php echo $boxname;?>" value=""  onclick="PreTest()" disabled>
<image src="./image/printer.png" width="15" height="20" alt="Click Here to View Detail in PDF">
<a href="./PDFReport/ViewDecodeRegisterinPDF.php?Code=<?php echo $laccode;?>&rtag=<?php echo $mm;?>&mpdf=1" target="_blank" >
<?php
}
echo $mrow[$n][1];
if($Tr==1)
echo "</a><BR><BR>";
else
echo "<BR>";    
}//for LOOP
?>
   
</td>
<td align=center ><font size=2 face=arial color=blue>
<?php echo $msg;?>
</td>
<?php 
}//for loop for LAC
?>
<tr><td align=right bgcolor=white>
</td>
<td align=right bgcolor=white colspan="4">
<input type=button value="Menu"  name="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">
</td>
<td align=center bgcolor=white>
<input type=hidden size=2 name=Mselect id=Mselect value=0>
    
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Randomise  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:100px" disabled>
 
</td>
</tr>
</table>
        
</form>
</div>
<?php
if(isset($_SESSION['msg']))
unset($_SESSION['msg']);
include("footer.htm");
?>   
</body>
</html>
