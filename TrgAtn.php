<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--
function direct()
{

var a=myform.Phaseno.value ;//Primary Key
var b=myform.Groupno.value ;//Primary Key
if ( isNaN(a)==false && a!="" && isNaN(b)==false && b!="")
{
myform.action="TrgAtnUpdate.php?tag=0";
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
myform.Phaseno.focus();
}

function redirect(i)
{
myform.action="TrgAtn.php?tag=2&ptype=1&mtype="+i;
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
//window.location="mainmenu.php?tag=1";
var a=myform.Phaseno.value ;// Primary Key
var a_index=myform.Phaseno.selectedIndex;
var b=myform.Groupno.value ;// Primary Key
if ( a_index>0  && isNumber(b)==true  )
{
myform.action="TrgAtnUpdate.php";
myform.submit();
}
else
alert('Invalid Data');
}


function home()
{
window.location="TrgMenu.php?tag=1";
}


function LoadTextBox()
{
var i=myform.Groupno.selectedIndex;
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
require_once './class/class.training.php';
require_once './class/class.training_phase.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify


$objTraining=new Training();

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
$mvalue[0]="0";//Phaseno
$mvalue[1]="0";//Groupno
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
// Call $objTraining->MaxPhaseno() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Phaseno
// Call $objTraining->MaxGroupno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Groupno
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

//Post Back on Select Box Change,Hence reserve the value
if ($ptype==1)
{
// CAll MaxNumber Func406
// tion Here if require and Load in $mvalue
if (isset($_POST['Phaseno']))
$mvalue[0]=$_POST['Phaseno'];
else
$mvalue[0]=0;

if (!is_numeric($mvalue[0]))
$mvalue[0]=-1;
if (isset($_POST['Groupno']))
$mvalue[1]=$_POST['Groupno'];
else
$mvalue[1]=0;

if (isset($_POST['Editme']))
$mvalue[2]=$_POST['Editme'];
else
$mvalue[2]=0;

} //ptype=1

if (isset($_POST['Phaseno']))
$pkarray[0]=$_POST['Phaseno'];
else
$pkarray[0]=0;
$objTraining->setPhaseno($pkarray[0]);
if (isset($_POST['Groupno']))
$pkarray[1]=$_POST['Groupno'];
else
$pkarray[1]=0;
$objTraining->setGroupno($pkarray[1]);
if ($objTraining->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objTraining->getPhaseno();
$mvalue[1]=$objTraining->getGroupno();
$mvalue[2]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]=$pkarray[1];
$mvalue[2]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=65%>
<form name=myform action=insert_training.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Select Group Number for Attendance Sheet<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Phaseno</font></td><td align=left bgcolor=white>
<?php 
$objTraining_phase=new Training_phase();
$objTraining_phase->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objTraining_phase->getRow();
?>
<select name=Phaseno style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:200px" onchange=redirect(1)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Phase_no'])
{
?>
<option selected value="<?php echo $row[$ind]['Phase_no'];?>"><?php echo $row[$ind]['Phase_name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Phase_no'];?>"><?php echo $row[$ind]['Phase_name'];
}
} //for loop
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Groupno</font></td><td align=left bgcolor=white>
<?php 
$objTraining->setCondString(" phaseno=".$mvalue[0]." order by groupno" ); //Change the condition for where clause accordingly
$row=$objTraining->getAllRecord()
?>
<select name=Groupno style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Groupno'])
{
?>
<option selected value="<?php echo $row[$ind]['Groupno'];?>">Group-<?php echo $row[$ind]['Groupno'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Groupno'];?>">Group-<?php echo $row[$ind]['Groupno'];
}
} //for loop
?>
</select>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr><td align=right bgcolor=#ccffcc>&nbsp;
</td><td align=left bgcolor=#ccffcc>
<input type=button value="Edit Sheet"  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:blue;width:100px" disabled>
</td></tr>

</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Phaseno");

if($mtype==1)//Postback from Phaseno
echo $objUtility->focus("Groupno");

if($mtype==2)//Postback from Groupno
echo $objUtility->focus("Phaseno");

if($mtype==100)//Postback from Groupno
echo $objUtility->alert($_SESSION['msg']);
?>
</body>
<?php
include("footer.htm");
?>
</html>
