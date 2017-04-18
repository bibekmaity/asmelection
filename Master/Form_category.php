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
myform.Code.value=mvalue;

var a=myform.Code.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="Form_category.php?tag=2&ptype=0";
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
myform.Code.focus();
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
//window.location="mainmenu.php?tag=1";
var a=myform.Code.value ;// Primary Key
var b=myform.Name.value ;
var b_length=parseInt(b.length);
var c=myform.Trgamount.value ;
var d=myform.Amount1.value ;
var e=myform.Amount2.value ;
var f=myform.Amount3.value ;
var g=myform.Amount4.value ;
if ( isNumber(a)==true   && notNull(b) && validateString(b) && b_length<=50 && 1==1 && 1==1 && 1==1 && 1==1 && 1==1)
{
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="Insert_category.php";
myform.submit();
}
else
alert('Invalid Data');
}




function home()
{
window.location="masterentry.php?tag=1";
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
require_once '../class/class.category.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify


$objCategory=new Category();

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
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[7]=0;
}
else
{
$mvalue[0]="0";//Code
$mvalue[1]="";//Name
$mvalue[2]="0";//Trgamount
$mvalue[3]="0";//Amount1
$mvalue[4]="0";//Amount2
$mvalue[5]="0";//Amount3
$mvalue[6]="0";//Amount4
$mvalue[7]=0;
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
// Call $objCategory->MaxCode() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Code
$mvalue[1]="";//Name
$mvalue[2]="0";
$mvalue[3]="0";
$mvalue[4]="0";
$mvalue[5]="0";
$mvalue[6]="0";
$mvalue[7]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Code']))
$pkarray[0]=$_POST['Code'];
else
$pkarray[0]=0;
$objCategory->setCode($pkarray[0]);
if ($objCategory->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objCategory->getCode();
$mvalue[1]=$objCategory->getName();
$mvalue[2]=$objCategory->getTrgamount();
$mvalue[3]=$objCategory->getAmount1();
$mvalue[4]=$objCategory->getAmount2();
$mvalue[5]=$objCategory->getAmount3();
$mvalue[6]=$objCategory->getAmount4();
$mvalue[7]=0;//last Select Box for Editing
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]="";
$mvalue[2]="0";
$mvalue[3]="0";
$mvalue[4]="0";
$mvalue[5]="0";
$mvalue[6]="0";
$mvalue[7]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=75%>
<form name=myform action=insert_category.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Category<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Code</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Code" id="Code" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Code',1)"  onblur="ChangeColor('Code',2)" onchange=direct1()>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Detail Name</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Name" id="Name" value="<?php echo $mvalue[1]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)" disabled>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Training Amount Per Day</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Trgamount" id="Trgamount" value="<?php echo $mvalue[2]; ?>" onfocus="ChangeColor('Trgamount',1)"  onblur="ChangeColor('Trgamount',2)">
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Remuneration Per Day</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Amount1" id="Amount1" value="<?php echo $mvalue[3]; ?>" onfocus="ChangeColor('Amount1',1)"  onblur="ChangeColor('Amount1',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Refreshment Per Day</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Amount2" id="Amount2" value="<?php echo $mvalue[4]; ?>" onfocus="ChangeColor('Amount2',1)"  onblur="ChangeColor('Amount2',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Contigency</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Amount3" id="Amount3" value="<?php echo $mvalue[5]; ?>" onfocus="ChangeColor('Amount3',1)"  onblur="ChangeColor('Amount3',2)">
</td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Others</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Amount4" id="Amount4" value="<?php echo $mvalue[6]; ?>" onfocus="ChangeColor('Amount4',1)"  onblur="ChangeColor('Amount4',2)">
</td>
</tr>
<?php $i++; //Now i=7?>
<tr><td align=right bgcolor=white>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=white>
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
</td></tr>
<tr><td align=right>
<?php 
$objCategory->setCondString(" Code>0 and Code<=7" ); //Change the condition for where clause accordingly
$row=$objCategory->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[7]==$row[$ind]['Code'])
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
</td><td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
</tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Code");

?>
<?php
include("footer.htm");
?>
</body>
</html>
