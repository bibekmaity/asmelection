<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--

function startg()
{
var tot=Number(document.getElementById('Tot').value);    
if(tot>0)
{
var data="Tot="+tot;   

MyAjaxFunction("POST","InitRepol.php",data,'Result',"HTML");    
document.getElementById('Tot').disabled=true;
document.getElementById('Save1').disabled=false;
}
else
alert('Enter Total Group');    
}


function setMe()
{
myform.Lac.focus();
}

function proceed(a)
{
if (a==1)
{
//window.open("./PDFReport/ViewRepolGroupinPDF.php",'_blank');    
alert('Under Construction');
}
if (a==2)
{
window.open("./PDFReport/RepolApp.php",'_blank');    
}

} //end function


function validate()
{
var b_index=parseInt(document.getElementById('Category').value);
var data="Category="+b_index;   

if (b_index>0 )
{
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br>Repol Group Formation in Progress, Please Wait........";
MyAjaxFunction("POST","ConstructRepolGroup.php",data,'Result',"HTML");    
}
else
alert('Invalid Selection');
}


function home()
{
window.location="Mainmenu.php?tag=1";
}



//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.psname.php';
require_once './class/class.repolgroup.php';
require_once './class/class.poling.php';
require_once './class/class.training.php';
require_once './class/class.sentence.php';
require_once './class/class.status.php';
require_once './class/class.final.php';
require_once 'header.php';
$objLac=new Lac();
$objPs=new Psname();
$objPg=new Repolgroup();
$objPoling=new Poling();
$objTrg=new Training();
$objCat=new Category();

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify


if($objPoling->FirstLevelCompleted()==false)
{
$_SESSION['catchmessage']="FIRST LEVEL RANDOMISATION NOT COMPLETED";
header( 'Location: CatchMsg.php');
}

if($objLac->CommongroupStatus()==0)
{
$_SESSION['catchmessage']="PLEASE COMPLETE FIRST STEP FOR RANDOMISATION";
header( 'Location: CatchMsg.php');
}

$Msg="";
if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>3)
$_tag=0;


$msg="";

$mvalue=array();


$mvalue[0]="0";//Lac
$mvalue[1]="0";//Category



if ($_tag==0) //Initial Page Loading
{
$mvalue[0]="0";//Lac
$mvalue[1]="0";
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]


$dis1="";
$dis2="";
?>
   
<table border=2 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_ttt.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3><b>PICK POLING PERSON FOR CONSTRUCTION OF RE POLING GROUP<br></font><font face=arial color=red size=2><?php //echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right ><font color=black size=2 face=arial>No of Group</font></td><td align=left >
<input type="text"  size="2" maxlength="2" name=Tot id="Tot" style="font-family: Arial;background-color:white;color:black; font-size: 12px">
<input type=button value="Initialise"  name=Init1 id=Init1 onclick="startg()"  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:yellow;color:blue;width:100px">
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right ><font color=black size=2 face=arial>SELECT POLL CATEGORY</font></td><td align=left >
<?php 
$objCategory=new Category();
$objCategory->setCondString("Code in(1,2,3,4,5)"); //Change the condition for where clause accordingly
$row=$objCategory->getRow();
?>
<select name=Category id="Category" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];
} //for loop
?>
</select>
</td>
</tr>
<tr><td align=right bgcolor=#ccffcc>
        <font face="arial" size="2">
</td><td align=left bgcolor=#ccffcc>

<input type=button value="Pick Person"  name=Save1 id=Save1 onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:blue;width:100px" disabled>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="Menu"  name="hm" id="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">

</td></tr>
</table>
 
</form>
       
<?php
//TEST
//if ($_tag==2)
//{


$Style="font-family:arial;font-size: 12px;font-weight:bold ; background-color:while;color:black";
?>
<br><b><font face="arial" size="4" color="orange" >  
    
<div align="center" id="Result">       
<form name="newform"  method="post">      
<table border=1 cellpadding="2" align=center cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" >
    <tr>
      <td width="100%" align="center"  colspan="8" >
      <font color="BLACK" SIZE="2"><B>REPOL GROUP FORMATION DETAIL</td>
    </tr>
    <tr>
    <td width="15%" align="center" bgcolor="#FFFF33" >
    <font face="Arial" size="2">No & Name of Constituency</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Presiding</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">First <br> Officer</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Second Poling</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33">
      <font face="Arial" size="2">Third Poling</font></td>
      <td width="10%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Forth Poling</font></td>
    <td width="24%" align="center" bgcolor="#FFFF33" colspan="2">
      <font face="Arial" size="2">Click below to View
            </font></td>
    </TD>
     
     </tr>  
 <tr>
<td align="left"><font face="Arial" size="2"><b>
Repol Group        
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(1);
?>    
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(2);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(3);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(4);?>   
</td>  
<td align="center">
<?php echo $objPg->mySelection(5);?>
</td>  
<td align="center" width="8%">
<input type=button value="Group"  name=but1 onclick=proceed(1)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:100px" disabed>
</td> 
<td align="center" width="8%">
<input type=button value="Appointment"  name=but2 onclick=proceed(2)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:100px" >
</td> 
</tr>
<?php   
?>
</form>
</table>       

</div>
<?php

?>   
</body>
</html>
