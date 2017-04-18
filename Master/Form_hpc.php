
<?php
include("MasterMenuhead.html");
?>
<script type="text/javascript" src="../Validation.js"></script>

<script language=javascript>
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Hpccode.value=mvalue;

var a=myform.Hpccode.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="Form_hpc.php?tag=2&ptype=0";
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
myform.Hpccode.focus();
}

function redirect(i)
{
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
var a=myform.Hpccode.value ;// Primary Key
var b=myform.Hpcname.value ;
var b_length=parseInt(b.length);
if ( isNumber(a)==true   && validateString(b) && b_length<=50)
{
if(a<=14)
{
myform.action="Insert_hpc.php";
myform.submit();
}
else
alert('Invalid HPC Number');    
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
require_once '../class/utility.class.php';
require_once '../class/class.hpc.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objHpc=new Hpc();

$lock="";

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

$mvalue=array();
$pkarray=array();

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[2]=0;
}
else
{
$mvalue[0]="0";//Hpccode
$mvalue[1]="";//Hpcname
$mvalue[2]=0;
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
$mvalue[0]="0";
$mvalue[1]="";//Hpcname
$mvalue[2]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Hpccode']))
$pkarray[0]=$_POST['Hpccode'];
else
$pkarray[0]=0;
$objHpc->setHpccode($pkarray[0]);
if ($objHpc->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objHpc->getHpccode();
$mvalue[1]=$objHpc->getHpcname();
$mvalue[2]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
$lock=" readonly";
} 
else //data not available for edit
{
$_SESSION['update']=0;
$lock=" ";
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]="";
$mvalue[2]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=55%>
<form name=myform action=insert_hpc.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#99FFCC><font face=arial size=3>Entry/Edit Form for HP Constituency<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Hpc Number</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Hpccode" id="Hpccode" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Hpccode',1)"  onblur="ChangeColor('Hpccode',2)" onchange=direct1() <?php echo $lock;?>>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Hpc Name</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Hpcname" id="Hpcname" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Hpcname',1)"  onblur="ChangeColor('Hpcname',2)">
</td>
</tr>
<?php $i++; //Now i=2?>
<tr><td align=right bgcolor=white>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=white>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
</td></tr>
<tr><td align=right>
<?php 
$objHpc->setCondString(" hpccode>0" ); //Change the condition for where clause accordingly
$row=$objHpc->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
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
<td align=left><font face="arial" size="2" color="red">
<?php
if($objUtility->FirstLevelCompleted()==false)
{    
?>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
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
echo $objUtility->focus("Hpccode");

?>
<?php
include("footer.htm");
?>
</body>
</html>
