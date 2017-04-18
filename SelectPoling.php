<?php
//include("Menuhead.html");
?>
<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--

function preVerify()
{
var data="Lac="+document.getElementById('Lac').value;
data=data+"&Category="+document.getElementById('Category').value;
if(document.getElementById('Home_lac').checked==true)
data=data+"&Home_lac=1";
if(document.getElementById('R_lac').checked==true)
data=data+"&R_lac=1";
if(document.getElementById('Dep_lac').checked==true)
data=data+"&Dep_lac=1";
//alert(data);
MyAjaxFunction("POST","preVerifyGroup.php",data,"Pre","HTML");
}


function recheck(i)
{
var cbox="Trg"+i;
if(document.getElementById(cbox).checked==false)
{
document.getElementById('TrgAny').disabled=true  
document.getElementById('TrgAny').checked=false;
}
else
{
document.getElementById('TrgAny').disabled=false;      
}
} //End receck

function Disme(i)
{
var btn="but3"+i;
document.getElementById(btn).disabled=true;
var btn="but2"+i;
document.getElementById(btn).disabled=true;
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

function proceed(a,b,i)
{
if (a==1)
{
newform.setAttribute("target", "_blank");
newform.action="./PDFReport/ViewGroupinPDF.php?code="+b;    
newform.submit();
}

if (a==2)
{
newform.setAttribute("target", "_self"); 
var name = confirm("Clear This Group?")
if (name == true)
{
newform.action="ClearPolingGroup.php?code="+b;  
newform.submit();
}
}
if (a==3)
{
newform.setAttribute("target", "_self"); 
var name = confirm("Lock This Group?")
if (name == true)
{
//newform.action="Lockgroup.php?code="+b;  
//newform.submit();
Disme(i);
var status="Status"+b;
MyAjaxFunction("POST","Lockgroup.php?code="+b,"",status,"HTML");
} //name=true
} //a==3
} //end function


function redirect(i)
{
newform.setAttribute("target", "_self");       
myform.action="SelectPoling.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="mainmenu.php?tag=1";
var a=myform.Lac.value ;
var a_index=myform.Lac.selectedIndex;
var b=myform.Category.value ;
var b_index=myform.Category.selectedIndex;
var c=myform.Home_lac.value ;
var d=myform.Dep_lac.value ;
var e=myform.Sameoffice.value ;
if ( a_index>0  && b_index>0 )
{
myform.Save.disabled=true;
myform.hm.disabled=true;     
myform.action="ConstructGroup.php?tag=0";
myform.submit();
var ms=document.getElementById('Msg').value;
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br>Group Formation in Progress, Please Wait........"+ms;
}
else
alert('Invalid Selection');
}

function home()
{
window.location="Mainmenu.php?tag=1";
}

//change the focus to Box(a)
function ChangeFocus(a)
{
//document.getElementById(a).focus();
}
//END JAVA
</script>

<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
preVerify();
} //Document Ready End
);
</script>

<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.psname.php';
require_once './class/class.polinggroup.php';
require_once './class/class.poling.php';
require_once './class/class.training.php';
require_once './class/class.sentence.php';
require_once './class/class.status.php';
require_once './class/class.final.php';
require_once 'header.php';
$objLac=new Lac();
$objPs=new Psname();
$objPg=new Polinggroup();
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
$mvalue[1]="0";//Category
$mvalue[2]="0";//Lac
$mvalue[3]="0";//Category
$mvalue[4]="0";//Category

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[1]=$objPg->PresentCategory($mvalue[0]);
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

}//tag=1 [Return from Action form]


if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objTtt->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objTtt->MaxCategory() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";
$mvalue[2]=true;//Home_lac
$mvalue[3]=true;//Dep_lac
$mvalue[4]=true;//Sameoffice
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;

//Post Back on Select Box Change,Hence reserve the value
if ($ptype==1)
{
// CAll MaxNumber Function Here if require and Load in $mvalue
if (isset($_POST['Lac']))
$mvalue[0]=$_POST['Lac'];
else
$mvalue[0]=0;

if (!is_numeric($mvalue[0]))
$mvalue[0]=-1;
//if (isset($_POST['Category']))
//$mvalue[1]=$_POST['Category'];
//else
//$mvalue[1]=0;

$mvalue[1]=$objPg->PresentCategory($mvalue[0]);

if (!is_numeric($mvalue[1]))
$mvalue[1]=-1;
if (isset($_POST['Home_lac']))
$mvalue[2]=$_POST['Home_lac'];
else
$mvalue[2]=0;

if (isset($_POST['Dep_lac']))
$mvalue[3]=$_POST['Dep_lac'];
else
$mvalue[3]=0;

if (isset($_POST['Sameoffice']))
$mvalue[4]=$_POST['Sameoffice'];
else
$mvalue[4]=0;
} //ptype=1
} //tag==2
$msg="";
if($mvalue[1]>0)
{    
$msg=$objUtility->CategoryList[$mvalue[1]];
$msg=$msg." Available in Database ".$objPg->RemainUnselected($mvalue[1]);
}
//echo $objPg->returnSql;
//Start of FormDesign


$objLac->setCode($mvalue[0]);
$objCat->setCode($mvalue[1]);
$Msg="<br><font face=arial size=2 color=black>";
if($objCat->EditRecord())
$Msg=$Msg.$objCat->getName ();    
if ($objLac->EditRecord())
$Msg=$Msg." for ".$objLac->getName ()." LAC</font>";


?>
<table border=2 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_ttt.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3><b>PICK POLING PERSON FOR CONSTRUCTION OF POLING GROUP<br></font><font face=arial color=red size=2><?php //echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right ><font color=black size=2 face=arial>SELECT LAC</font></td><td align=left >
<?php 

$cond=" code>0 and  code in(select distinct lac from polinggroup) ";
$objLac->setCondString($cond); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Lac id="Lac" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($objPg->PresentCategory($row[$ind]['Code'])>0) //Display only Incomplete LAC
{        
if ($mvalue[$i]==$row[$ind]['Code'])
{
?>
<option selected value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];
} //$mvalue
} //Presentcategory 
} //for loop
?>
</select>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right ><font color=black size=2 face=arial>SELECT POLL CATEGORY</font></td><td align=left >
<?php 
$objCategory=new Category();
$objCategory->setCondString(" code>0 and code=".$mvalue[1]); //Change the condition for where clause accordingly
$row=$objCategory->getRow();
?>
<select name=Category id="Category" style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
{
?>
<option selected value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];
}
} //for loop
?>
</select>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td  align=right bgcolor=white><font  size=2 face=arial color="blue">Donot Place in Home LAC
<?php if ($mvalue[$i]==false){?>
<input type=checkbox name=Home_lac id="Home_lac"  value="Sel" onlick="preVerify()">
<?php } else{?>
<input type=checkbox name=Home_lac id="Home_lac"  value="Sel" checked="checked" onclick="preVerify()">
<?php } ?>
</td>
<td  align=left bgcolor=white><font  size=2 face=arial color="blue">
Donot Place in Residential LAC
<input type=checkbox name=R_lac id="R_lac"  value="Sel" checked="checked" onclick="preVerify()">
</td>
</tr>
<tr>
<td  align=right bgcolor=white><font  size=2 face=arial color="blue">
<?php $i++; //Now i=3?>
<font  size=2 face=arial color="blue">Donot Place in Working LAC</font>
<?php if ($mvalue[$i]==false){?>
<input type=checkbox name=Dep_lac id="Dep_lac"  value="Sel" onclick="preVerify()">
<?php } else{?>
<input type=checkbox name=Dep_lac id="Dep_lac" value="Sel" checked=checked  onclick="preVerify()">
<?php } ?>
<?php $i++; //Now i=4?>
</td>
<td  align=left bgcolor=white>
<font  size=2 face=arial color="blue">    
Donot Allow Persons from Same Office/Establishment in a Group</font>
<?php if ($mvalue[$i]==false){?>
<input type=checkbox name=Sameoffice id="Sameoffice"  value="Sel">
<?php } else{?>
<input type=checkbox name=Sameoffice id="Sameoffice" value="Sel" checked=checked>
<?php } ?>
</td>
</tr>
<tr><td colspan="2" align="center" bgcolor=white>
<?php
echo $objTrg->GenCheckBox($mvalue[1]);
?>
</td></tr>        
<?php $i++; //Now i=5?>
<tr><td align=right bgcolor=#ccffcc>
        <font face="arial" size="2">
<?php echo $msg;?> 
</td><td align=left bgcolor=#ccffcc>
<input type=hidden value="<?php echo $Msg;?>"  name=Msg id="Msg" size="2">
    
<input type=button value="Pick Person"  name=Save id=Save onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:blue;width:100px">

&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="Menu"  name="hm" id="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">

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

$Style="font-family:arial;font-size: 12px;font-weight:bold ; background-color:while;color:black";
?>
<br>  
<div align="center" id="Pre"></div><br>  
<b><font face="arial" size="2" color="orange" >
<div align="center" id="Result">       
<form name="newform"  method="post">      
<table border=1 cellpadding="2" align=center cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" >
    <tr>
      <td width="100%" align="center"  colspan="10" >
      <font color="BLACK" SIZE="2"><B>LAC WISE GROUP FORMATION DETAIL</td>
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
    <td width="24%" align="center" bgcolor="#FFFF33" colspan="3">
      <font face="Arial" size="2">Click below to View/Clear/Lock<br><input type="checkbox" name="mpdf" checked="checked">PDF<br>
      View from<input type="text" name="From" value="1" size="1" style="<?php echo $Style;?>">to
       <input type="text" name="To" size="1" value="25" style="<?php echo $Style;?>">
      </font></td>
    </TD>
    <td width="11%" align="center" bgcolor="#FFFF33" >
      <font face="Arial" size="2">Status</font></td>
  
     </tr>  
<?php
$objLac=new Lac();
$objS=new Sentence();
$objLac->setCondString(" code>0 and code in(select distinct lac from psname) order by code");
$row=$objLac->getRow();
$dis1="";
$dis2="";
$dis3="";

for ($i=0;$i<count($row);$i++)
{
$status="";    
$laccode=$row[$i]['Code'];
$condition=" Prno>0 and Lac=".$laccode;
$finallock=false;
$objStat=new Status();
//Check Final Lock
$objStat->setSerial(1);
if($objStat->EditRecord())
{
if ($objStat->getPoll_group()=="Y") //Final Lock   
$finallock=true;
}
    
$status=$objLac->groupStatusDetail($laccode);

if($objLac->groupStatus($laccode)<2)
{
$dis1=" disabled";
$dis2=" disabled";
$dis3=" disabled";      
}    
//echo $objLac->groupStatus($laccode); 
if($objLac->groupStatus($laccode)==2) //Process
{
$dis1=" disabled";
$dis2=" ";
$dis3=" disabled";
}

if($objLac->groupStatus($laccode)==3) //Completed
{
$dis1=" ";
$dis2=" ";
$dis3=" ";
}
$url="";
if($objLac->groupStatus($laccode)==4) //Locked
{
$dis1=" ";
$url="<image src=./image/lock.ico width=15 height=15>";
//if($roll==0 && $finallock==false ) //Only Root User can Clear if Final Lock is not Done
//$dis2=" ";
//else
$dis2=" disabled";    
$dis3=" disabled";
}

if($objLac->groupStatus($laccode)>=5) //PS Alloted
{
$dis1=" ";
$dis2=" disabled";    
$dis3=" disabled";
}


?>
<tr>
<td align="left"><font face="Arial" size="2"><b>
<?php echo $row[$i]['Code']."-".$objS->SentenceCase($row[$i]['Name']);?>        
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(1, $row[$i]['Code']);?>    
</td>
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(2, $row[$i]['Code']);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(3, $row[$i]['Code']);?>    
</td>  
<td align="center"><font face="Arial" size="2" color="blue">
<?php echo $objPg->mySelection(4, $row[$i]['Code']);?>   
</td>  
<td align="center">
<?php echo $objPg->mySelection(5, $row[$i]['Code']);?>
</td>  
<td align="center" width="8%">
<input type=button value="View"  name=but1 onclick=proceed(1,<?php echo $row[$i]['Code'];?>,0)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:60px" <?php echo $dis1;?>>
</td> 
<td align="center" width="8%">
<input type=button value="Clear"  name=but2<?php echo $i;?> id="but2<?php echo $i;?>" onclick=proceed(2,<?php echo $row[$i]['Code'];?>,0)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#669999;color:black;width:60px" <?php echo $dis2;?>>
</td>
<td align="center" width="8%">
<input type=button value="Lock"  name="but3<?php echo $i;?>" id="but3<?php echo $i;?>"  onclick="proceed(3,<?php echo $row[$i]['Code'];?>,<?php echo $i;?>)"  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:red;color:black;width:60px" <?php echo $dis3;?>>
</td> 
<td align="center" width="11%"><font face="Arial" size="1" color="blue">
<div align="center" id="Status<?php echo $laccode;?>">
<?php echo $url.$status?>   
</div>
</td>  
</tr>
<?php   
}//for loop

?>
</form>
</table>    
</div>
<?php

if($mtype==100)
{
echo $objUtility->alert ($_SESSION['msg']);
$_SESSION['msg']="";
}

if($objLac->groupStatus($mvalue[0])==3)
echo $objUtility->alert("Group Formation Completed for Selected LAC");
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);    
include("footer.htm");
?>   
</body>
</html>
