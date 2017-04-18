<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="../validation.js"></script>>
<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function disp(message)
{
//enable allow script to update status bar in tools unde IE  
window.status = message;
return(true);
}

function status(i)
{
window.setTimeOut(disp(i),1000);   
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

function proceed(a,b)
{
if (a==1)
{
newform.setAttribute("target", "_blank");
newform.action="../PDFReport/ViewCountingGroupinPDF.php?code="+b;    
//newform.action="ViewMicroinPDF.php?code="+b;
newform.submit();
}

if (a==2)
{
newform.setAttribute("target", "_self"); 
var name = confirm("Clear This Group?")
if (name == true)
{
newform.action="ClearCountingGroup.php?code="+b;  
newform.submit();
}
}
if (a==3)
{
newform.setAttribute("target", "_self"); 
var name = confirm("Lock This Group?")
if (name == true)
{
newform.action="LockCountinggroup.php?code="+b;  
newform.submit();
}
}
}


function redirect(i)
{
newform.setAttribute("target", "_self");       
myform.action="MicroSelect.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{

//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="mainmenu.php?tag=1";

var a_index=myform.Lac.selectedIndex;
var b=myform.Res.value ;

if (a_index>0  && isNumber(b) )
{
myform.Save.disabled=true;    
myform.action="ConstructCountGroup.php?tag=0";
myform.submit();
document.getElementById('Result').innerHTML="<image src=../image/Star.gif width=70 height=100><br><b><font size=4 face=arial>Creating Counting Group...Please Wait </font></b>";

}
else
alert('Invalid Selection');
}


function home()
{
window.location="../Mainmenu.php?tag=1";
}

//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
//require_once '../class/class.psname.php';
//require_once '../class/class.polinggroup.php';
require_once '../class/class.poling.php';
require_once '../class/class.training.php';
require_once '../class/class.sentence.php';
require_once '../class/class.status.php';
//require_once '../class/class.final.php';
require_once '../class/class.countinghall.php';
require_once '../class/class.countinggroup.php';


//$objTrg=new Training();
//$objPs=new Microps();
$objPoling=new Poling();
$objCh=new Countinghall();
$objMg=new Countinggroup();
$objLac=new Lac();
$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

//if($objPoling->Randomised(7)==false)
//{
//$_SESSION['catchmessage']="FIRST LEVEL RANDOMISTION IS NOT COMPLETED FOR MICRO OBSERVER";
//header( 'Location: ../CatchMsg.php');
//}

//if($objLac->CommonMicrogroupStatus()==0)
//{
//$_SESSION['catchmessage']="POLING STATIONS ARE NOT ORGANISED AS PER MICRO OBSERVER REQUIREMENT";
//header( 'Location: ../CatchMsg.php');
//}



if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>3)
$_tag=0;

if (isset($_GET['mtype']))
$mtype=$_GET['mtype'];
else
$mtype=0;

if (!is_numeric($mtype))
$mtype=0;

$msg="";

echo $objUtility->statusbar($mtype);

$mvalue=array();
$pkarray=array();

$mvalue[0]="0";//Lac
$mvalue[1]="25";//Reserve Percentage
$mvalue[2]="0";//Lac
$mvalue[3]="0";//Category
$mvalue[4]="0";//Category

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array

$mvalue[2]=true;//Home_lac
$mvalue[3]=true;//Dep_lac
$mvalue[4]=true;//same office
}
else
{
$mvalue[0]="0";//Lac
$mvalue[1]="0";//Category
$mvalue[2]="";//Home_lac
$mvalue[3]="";//Dep_lac
$mvalue[4]="";//Sameoffice
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
//echo "Lac".$mvalue[0];
}//tag=1 [Return from Action form]

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objTtt->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objTtt->MaxCategory() Function Here if required and Load in $mvalue[1]
$mvalue[1]="25";
$mvalue[2]=true;//Home_lac
$mvalue[3]=true;//Dep_lac
$mvalue[4]=true;//Sameoffice
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]



$msg=$msg." Available for Selection ".$objPoling->countingAvailable();  
//echo $objMg->returnSql;
//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width="100%">
<form name=myform action=""  method=POST >
<tr><td colspan=2 align=Center bgcolor=#6699CC><font face=arial size=3><b>PICK SUPERVISOR/ASSISTANT/STATIC OBSERVER FOR COUNTING<br></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right ><font color=blue size=2 face=arial>SELECT LAC</font></td><td align=left bgcolor=#FFFFCC>
<?php 
$objLac=new Lac();
$cond=" code>0 and  code in(select distinct lac from countinghall) ";
$objLac->setCondString($cond); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Lac style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
//echo $row[$ind]['Code'].".".$objLac->MicrogroupStatus($row[$ind]['Code']).";";    
if($objLac->CountinggroupStatus($row[$ind]['Code'])<3)  //Unless Locked
{    
if($mvalue[0]==$row[$ind]['Code'])
{
?>
<option  Selected value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php
}
}
} //for loop
?>
</select>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td  align=right bgcolor=white><font  size=2 face=arial color="blue">PERCENTAG OF RESERVE</td>
<td  align=left bgcolor=white>
<input type=text name="Res" id="Res" size=4 value="<?php echo $mvalue[1];?>">
</td>
</tr>
<tr>
<td  align=right bgcolor=white><font  size=2 face=arial color="blue">No of Counting Assistant(1 or 2)</td>
<td  align=left bgcolor=white>
<input type=text name="Ast" id="Ast" size=4 value="<?php echo $mvalue[2];?>">
</td>
</tr>
<tr>
<td  align=right bgcolor=white><font  size=2 face=arial color="blue">Select Static Observer </td>
<td  align=left bgcolor=white>
<input type=checkbox name="So" id="So" checked="checked">
</td>
</tr>

<tr><td align=right bgcolor=#FFFFCC>
 <font face="arial" size="2">
<?php echo $msg;?> 
</td><td align=left bgcolor=#FFFFCC>
<input type=button value="Pick"  name="Save" onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:blue;width:100px">
&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="Menu"  name="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">

</td></tr>
</table>
 
</form>
       
<?php
//TEST
//if ($_tag==2)
//{

if($mtype==0)
echo $objUtility->focus("Lac");

if($mtype==1)//Postback from Lac
echo $objUtility->focus("Category");

if($mtype==2)//Postback from Category
echo $objUtility->focus("Home_lac");

if($mtype==3)//Postback from Home_lac
echo $objUtility->focus("Dep_lac");

if($mtype==4)//Postback from Dep_lac
echo $objUtility->focus("Sameoffice");

if($mtype==5)//Postback from Sameoffice
echo $objUtility->focus("Lac");
//} //tag=2


?>
       <div align="center" id="Result">       
<form name="newform"  method="post">      
<table border=1 cellpadding="2" align=center cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
    <tr>
      <td width="100%" align="center"  colspan="6" >
      <font color="BLACK" SIZE="2"><B>LAC WISE DETAILMENT OF COUNTING SUPERVISOR/ASISTANT</td>
    </tr>
    <tr>
    <td width="22%" align="center" bgcolor="#FFFF33">
    <font face="Arial" size="2">LAC NAME</font></td>
    <td width="8%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">TOTAL GROUP</font></td>
      
    <td width="10%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">SELECTED</font></td>
       <td width="40%" align="center" bgcolor="#FFFF33" colspan="3">
      <font face="Arial" size="2">Click to View/Clear/Lock</font>
      
<input type="checkbox" name="mpdf" ><b>PDF</b>
       </td>
   
       <td width="20%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">Status</font></td>
  
     </tr>  
<?php

$objS=new Sentence();
$objLac->setCondString(" code>0 and code in(select distinct lac from countinghall) order by code");
$row=$objLac->getRow();
$dis1="";
$dis2="";
$dis3="";
//echo "To Lac".count($row);
for ($i=0;$i<count($row);$i++)
{
$status="";    
$laccode=$row[$i]['Code'];
//$condition=" Poling_id>0 and Lac=".$laccode;
$finallock=false;
$objStat=new Status();
//Check Final Lock
//$objStat->setSerial(1);
if($objStat->EditRecord())
{
if ($objStat->getMicro_group()=="Y") //Final Lock   
$finallock=true;
}
//$status=$objLac->MicrogroupStatus($laccode);  
$status="";

//echo $status."<br>1";
if($objLac->CountinggroupStatus($laccode)<2)
{
$dis1=" disabled";
$dis2=" disabled";
$dis3=" disabled";  
}    
//echo $status."<br>2";
//echo $objLac->groupStatus($laccode); 
if($objLac->CountinggroupStatus($laccode)==2) //Process
{
$dis1=" disabled";
$dis2=" ";
$dis3=" disabled";
}
//echo $status."<br>3";
if($objLac->CountinggroupStatus($laccode)==3) //Completed
{
$dis1=" ";
$dis2=" ";
$dis3=" ";
$status="Group Completed";
}
//echo $status."<br>4";
if($objLac->CountinggroupStatus($laccode)>=4) //Locked
{
$dis1=" ";
$dis2=" disabled";    
$dis3=" disabled";
$status="Group Locked";
}
//echo $status."<br>5";
//echo "To Lac".count($row);
//$tot=$objPs->rowCount("Lac=".$laccode);
?>
<tr>
<td align="left"><font face="Arial" size="2"><b>
<?php echo $row[$i]['Code']."-".$objS->SentenceCase($row[$i]['Name']);?>        
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objCh->TotalGroup($laccode);?>    
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objMg->mySelection($laccode);?>    
</td>
<td align="center" width="8%">
<input type=button value="View"  name=but1 onclick=proceed(1,<?php echo $laccode;?>)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:60px" <?php echo $dis1;?>>
</td> 
<td align="center" width="8%">
<input type=button value="Clear"  name=but2 onclick=proceed(2,<?php echo $laccode;?>)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#669999;color:black;width:60px" <?php echo $dis2;?>>
</td>
<td align="center" width="8%">
<input type=button value="Lock"  name=but3 onclick=proceed(3,<?php echo $laccode;?>)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:red;color:black;width:60px" <?php echo $dis3;?>>
</td> 
<td align="center" width="11%"><font face="Arial" size="2" color="blue">
<?php echo $status;?>   
</td>  
</tr>
<?php    
}//for loop

if($mtype==100)
{
echo $objUtility->alert ($_SESSION['msg']);
$_SESSION['msg']="";
}
?>
</form>
</table>
<?php
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);    
include("footer.htm");
?>   
    </div>
</body>
</html>
