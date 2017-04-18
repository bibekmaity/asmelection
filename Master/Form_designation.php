<?php
include("MasterMenuhead.html");
?>
<script type="text/javascript" src="../Validation.js"></script>

<script language=javascript>
<!--
function verify()
{
var data="Code="+document.getElementById('Designation').value;
data=data+"&Deptype="+document.getElementById('Dep_type').value;
var a=document.getElementById('Designation').value;
var mylength=parseInt(a.length);
if(mylength>2)
MyAjaxFunction("POST","VerifyDesignation.php?Param=1",data,"Result","HTML");
if(mylength>1)
MyAjaxFunction("POST","VerifyDesignation.php?Param=2",data,"DivBut","HTML");
}

function init()
{
myform.action="Form_Designation.php?tag=0";
myform.submit();
}

function direct(i)
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Desig_code.value=mvalue;

var b=myform.Desig_code.value ;//Primary Key
if ( isNaN(b)==false && b!="")
{
if (i==1)
myform.action="Form_designation.php?tag=2&ptype=0";
if (i==2)
{   
var name = confirm("Delete Record?")
if (name == true)    
myform.action="Form_designation.php?tag=3"; 
}
myform.submit();
}
}

function direct1()
{
var i;
i=0;
}

function setMe()
{
myform.Dep_type.focus();
}

function redirect(i)
{
myform.action="Form_designation.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{
//var j1=myform.rollno.selectedIndex;//Returns Numeric Index from 0
//var j2=myform.box1.checked;//Return true if check box is checked
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="../Mainmenu.php?tag=1";
var a=myform.Dep_type.value ;
var a_index=myform.Dep_type.selectedIndex;
var b=myform.Desig_code.value ;// Primary Key
var c=myform.Designation.value ;
var c_length=parseInt(c.length);
if ( a_index>0 &&  validateString(c) &&  c_length>1 && c_length<=50 && notNull(c))
{
myform.action="Insert_designation.php";
myform.submit();
}
else
alert('Invalid Data');
}


function home()
{
window.location="../Mainmenu.php?tag=1";
}


function LoadTextBox()
{
var i=myform.Editme.selectedIndex;
if(i>0)
{    
myform.edit1.disabled=false;
myform.delete1.disabled=false;
}
else
{
myform.edit1.disabled=true;
myform.delete1.disabled=true;
}
//alert('Write Java Script as per requirement');
}

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.designation.php';
require_once '../class/class.deptype.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$old="-";

$objDesignation=new Designation();

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

$mvalue=array();
$pkarray=array();

if ($_tag==3)//Delete Record
{
if (isset($_POST['Desig_code']))
$objDesignation->setDesig_code($_POST['Desig_code']) ;
if ($objDesignation->DeleteRecord())
$objUtility->alert("Record Deleted");
$mvalue[0]=$_POST['Dep_type'];
$mvalue[1]=$objDesignation->maxDesig_code();
$mvalue[2]="";
$mvalue[3]="0";
}



if ($_tag==1)//Return from Action Form
{
$mtype=2;
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[3]=0;
$mvalue[1]=$objDesignation->maxDesig_code();
}
else
{
$mvalue[0]="";//Dep_type
$mvalue[1]="0";//Desig_code
$mvalue[2]="";//Designation
$mvalue[3]=0;
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
$mvalue[0]="";//Dep_type
// Call $objDesignation->MaxDesig_code() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Desig_code
$mvalue[2]="";//Designation
$mvalue[3]=0;//last Select Box for Editing
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
if (isset($_POST['Dep_type']))
$mvalue[0]=$_POST['Dep_type'];
else
$mvalue[0]=0;

if (isset($_POST['Desig_code']))
$mvalue[1]=$_POST['Desig_code'];
else
$mvalue[1]=0;

$mvalue[1]=$objDesignation->maxDesig_code();

if (isset($_POST['Designation']))
$mvalue[2]=$_POST['Designation'];
else
$mvalue[2]=0;

if (isset($_POST['Editme']))
$mvalue[3]=$_POST['Editme'];
else
$mvalue[3]=0;

} //ptype=1

if (isset($_POST['Desig_code']))
$pkarray[0]=$_POST['Desig_code'];
else
$pkarray[0]=0;
$objDesignation->setDesig_code($pkarray[0]);
if ($objDesignation->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objDesignation->getDep_type();
$mvalue[1]=$objDesignation->getDesig_code();
$mvalue[2]=$objDesignation->getDesignation();
$mvalue[3]=0;//last Select Box for Editing
$old=$mvalue[2];
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=-1;
$mvalue[1]=$pkarray[0];
$mvalue[2]="";
$mvalue[3]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=65%>
<form name=myform action=insert_designation.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Designation<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Department Category</font></td><td align=left bgcolor=white>
<?php 
$objDeptype=new Deptype();
$objDeptype->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type id=Dep_type style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
{
?>
<option selected value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];
}
} //for loop
?>
</select>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Designation Code</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Desig_code" id="Desig_code" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Desig_code',1)"  onblur="ChangeColor('Desig_code',2)" onchange=direct1() readonly>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Designation Name</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Designation" id="Designation" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Designation',1)"  onblur="ChangeColor('Designation',2)" onkeyup="verify()">
<input type=hidden size=5 name="OldDesignation" id="OldDesignation" value="<?php echo $old; ?>" >
</td>
</tr>
<tr>
<td align=center bgcolor=white colspan=2><font size=1 face=arial color=red>
<div id="Result">
</div>
</td>
</tr>

<?php $i++; //Now i=3?>
<tr><td align=right bgcolor=white>
<?php

if ($_SESSION['update']==1)
{
echo"<font size=2 face=arial color=#CC3333>Update Mode";
$cap="UPDATE";
}
else
{
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
$cap="SAVE";
}
 ?>       
</td><td align=left bgcolor=white><font face=arial size=1 color=red>
<div id="DivBut">
<?php
if ($_SESSION['update']==1)
{
?>
<input type=button value=<?php echo $cap;?>  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:100px">
<?php
}
?>
</div>
</td></tr>
<tr><td align=right>
<?php 
$objDesignation->setCondString("Dep_type='".$mvalue[0]."' order by Designation"); //Change the condition for where clause accordingly
$row=$objDesignation->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Desig_code'])
{
?>
<option selected value="<?php echo $row[$ind]['Desig_code'];?>"><?php echo $row[$ind]['Designation'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Desig_code'];?>"><?php echo $row[$ind]['Designation'];
}
} //for loop
?>
</select>
</td>
<td align=left><font face="arial" size="2" color="red">
<?php
if($objUtility->FirstLevelCompleted()==false)
{    
?>
<input type=button value=Edit  name=edit1 onclick=direct(1)  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
<input type=button value=Delete  name=delete1 onclick=direct(2)  style="font-family:arial; font-size: 14px ; background-color:white;color:red;width:100px" disabled>
<input type=button value="RESET"  name=res onclick=init()  style="font-family:arial; font-size: 12px ; background-color:green;color:blue;width:80px">
<?php
}
else
echo "No edit,Since First Level Selection is Completed";    
?>
</td>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Dep_type");


if($mtype==1)//Postback from Desig_code
echo $objUtility->focus("Designation");

if($mtype==3)//Postback from Designation
echo $objUtility->focus("Dep_type");

?>
<?php
include("footer.htm");
?>
</body>
</html>
