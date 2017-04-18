<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Phase_no.value=mvalue;
var b=myform.Editme.selectedIndex;//Primary Key

myform.action="Form_training_phase.php?tag=2&ptype=0";
myform.submit();

}

function direct1()
{
var i;
i=0;
}

function setMe()
{
myform.Phase_no.focus();
}

function redirect(i)
{
}

function validate()
{
var bi=myform.Editme.selectedIndex;
var a=myform.Phase_no.value ;// Primary Key
var c=myform.Letterno.value ;
var c_length=parseInt(c.length);
var d=myform.Letter_date.value ;
var e=myform.Signature.value ;
var e_length=parseInt(e.length);
var f=myform.Election_district.value ;
var f_length=parseInt(f.length);
if (bi>0 && isNumber(a)==true  && SimpleValidate(c) && c_length<=50 &&  isdate(d,0)  && SimpleValidate(e) && e_length<=50 && validateString(f) && f_length<=30)
{
myform.action="Insert_training_phase.php";
myform.submit();
}
else
{
if (NumericValid('Phase_no',1)==false)
alert('Non Numeric Value in Phase_no');
else if (StringValid('Letterno',0)==false)
alert('Check Letterno');
else if (DateValid('Letter_date',0)==false)
alert('Check Date Letter_date');
else if (StringValid('Signature',0)==false)
alert('Check Signature');
else if (StringValid('Election_district',0)==false)
alert('Check Election_district');
else 
alert('Enter Correct Data');
}
}//End Validate




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

//Reset Form
function res()
{
window.location="Form_training_phase.php?tag=0";
}
//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.training_phase.php';

$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

$objTraining_phase=new Training_phase();

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
$mvalue[5]=0;
}
else
{
$mvalue[0]="0";//Phase_no
$mvalue[1]="";//Letterno
$mvalue[2]="";//Letter_date
$mvalue[3]="";//Signature
$mvalue[4]="";//Election_district
$mvalue[5]=0;
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
// Call $objTraining_phase->MaxPhase_no() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Phase_no
$mvalue[1]="";//Letterno
$mvalue[2]="";//Letter_date
$mvalue[3]="";//Signature
$mvalue[4]="";//Election_district
$mvalue[5]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;


if (isset($_POST['Phase_no']))
$pkarray[0]=$_POST['Phase_no'];
else
$pkarray[0]=0;

$mvalue[0]=$pkarray[0];
$objTraining_phase->setPhase_no($pkarray[0]);
if ($objTraining_phase->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objTraining_phase->getPhase_no();
$mvalue[1]=$objTraining_phase->getLetterno();
$mvalue[2]=$objUtility->to_date($objTraining_phase->getLetter_date());
$mvalue[3]=$objTraining_phase->getSignature();
$mvalue[4]=$objTraining_phase->getElection_district();
$mvalue[5]=0;//last Select Box for Editing
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
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]="";
$mvalue[5]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<form name=myform action=insert_training_phase.php  method=POST >
<tr>
<td colspan=2 align=Center bgcolor=#ccffcc>
<font face=arial size=3>Enter Particulars Relating to Training Letter<br></font>
<font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font>
</td>
</tr>
<?php $i=0; ?>
<?php //row1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Select Training Category
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";

$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:black;width:300px";
$objTraining_phase->setCondString("Phase_no in(1,3,4)" ); //Change the condition for where clause accordingly
$row=$objTraining_phase->getRow();
?>
<select name=Editme style="<?php echo $mystyle;?>" onchange=direct()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind]['Phase_no'];
$mdetail=$row[$ind]['Phase_name'];
if ($mvalue[0]==$mcode)
{
?>
<option selected value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
else
{
?>
<option  value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
}
} //for loop
?>
</select>
    <input type=hidden size=8 name="Phase_no" id="Phase_no" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Phase_no',1)"  onblur="ChangeColor('Phase_no',2)" onchange=direct1()>

</td>
</tr>
<?php $i++; //Now i=1?>
<?php //row2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Letter No
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=50 name="Letterno" id="Letterno" value="<?php echo $mvalue[1]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Letterno',1)"  onblur="ChangeColor('Letterno',2)">
</td>
</tr>
<?php $i++; //Now i=2?>
<?php //row3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Letter Date
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=10 name="Letter_date" id="Letter_date" value="<?php echo $mvalue[2]; ?>" onfocus="ChangeColor('Letter_date',1)"  onblur="ChangeColor('Letter_date',2)">
<font size=1 face=arial color=blue>DD/MM/YYYY</font>
</td>
</tr>
<?php $i++; //Now i=3?>
<?php //row4?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Signed by
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=50 name="Signature" id="Signature" value="<?php echo $mvalue[3]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Signature',1)"  onblur="ChangeColor('Signature',2)">
</td>
</tr>
<?php $i++; //Now i=4?>
<?php //row5?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Name of Election District
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 12px";
?>
<input type=text size=30 name="Election_district" id="Election_district" value="<?php echo $mvalue[4]; ?>" style="<?php echo $mystyle;?>"  maxlength=30 onfocus="ChangeColor('Election_district',1)"  onblur="ChangeColor('Election_district',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=#ccffcc>
<?php
if ($_SESSION['update']==1)
{
echo"<font size=2 face=arial color=#CC3333>Update Mode";
$cap="Update Detail";
}
else
{
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
$cap="Save Data";
}
?>
</td>
<td align=left bgcolor=#ccffcc>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:120px";
?>
<input type=hidden size=30 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value="<?php echo $cap;?>"  name=Save onclick=validate() style="<?php echo $mystyle;?>">
</td></tr>

</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Phase_no");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);
?>
</body>
</html>
