
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
myform.action="Form_lac.php?tag=2&ptype=0";
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
//window.location="../Mainmenu.php?tag=1";
var a=myform.Code.value ;// Primary Key
var b=myform.Name.value ;
var b_length=parseInt(b.length);
var c=myform.Ro_sign.value ;
var d=myform.Hpccode.value ;
var d_index=myform.Hpccode.selectedIndex;
var e=myform.Ro_detail.value ;
var e_length=parseInt(e.length);
if ( isNumber(a)==true && e_length<=150 && validateString(c) && validateString(e) && validateString(b) && b_length<=30 && 1==1 && d_index>0 )
{
if(a<=126)    
{
myform.action="Insert_lac.php";
myform.submit();
}
else
alert('Invalid LAC Number');
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
require_once '../class/class.lac.php';
require_once '../class/class.hpc.php';

$objUtility=new Utility();

if($objUtility->FirstLevelCompleted()==true)
$rdOnly=" readonly ";
else
$rdOnly="";    


//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objLac=new Lac();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;
$lock=" ";
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
$mvalue[4]=0;
}
else
{
$mvalue[0]="0";//Code
$mvalue[1]="";//Name
$mvalue[2]="";//Ro_sign
$mvalue[3]="0";//Hpccode
$mvalue[4]=0;
$mvalue[5]="";
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
// Call $objLac->MaxCode() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Code
$mvalue[1]="";//Name
// Call $objLac->MaxRo_sign() Function Here if required and Load in $mvalue[2]
$mvalue[2]="";//Ro_sign
// Call $objLac->MaxHpccode() Function Here if required and Load in $mvalue[3]
$mvalue[3]="0";//Hpccode
$mvalue[4]=0;//last Select Box for Editing
$mvalue[5]="";
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
$objLac->setCode($pkarray[0]);
if ($objLac->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objLac->getCode();
$mvalue[1]=$objLac->getName();
$mvalue[2]=$objLac->getRo_sign();
$mvalue[3]=$objLac->getHpccode();
$mvalue[4]=0;//last Select Box for Editing
$mvalue[5]=$objLac->getRo_detail();
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
$mvalue[2]="";
$mvalue[3]=-1;
$mvalue[4]=0;//last Select Box for Editing
$mvalue[5]="";
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=55%>
<form name=myform action=insert_lac.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for LA Constituency<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>LAC Number</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Code" id="Code" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Code',1)"  onblur="ChangeColor('Code',2)" onchange=direct1() <?php echo $lock;?>>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>LAC Name</font></td><td align=left bgcolor=white>
<input type=text size=30 name="Name" id="Name" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=30 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)" <?php echo $rdOnly;?>>
</td>
</tr>
<?php $i++; //Now i=2?>

<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select HPC</font></td><td align=left bgcolor=white>
<?php 
$objHpc=new Hpc();
if($_SESSION['update']==1 && strlen($rdOnly)>1 )
$objHpc->setCondString(" hpccode=".$mvalue[3]);
else        
$objHpc->setCondString(" hpccode>0" ); //Change the condition for where clause accordingly

$row=$objHpc->getRow();
?>
<select name=Hpccode style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px" onchange=redirect(4)>
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
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Detail Name,Designation of RO(Appear in Counting App. Letter)</font></td><td align=left bgcolor=white>
<textarea name="Ro_detail" id="Ro_detail" rows=3 cols="45"  onfocus="ChangeColor('Ro_detail',1)"  onblur="ChangeColor('Ro_detail',2)">
<?php echo $mvalue[5]; ?>
</textarea>
</td>
</tr>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Sign of RO<br>This is required if Appointment Letter is to be signed by RO for different Constituency, Use BR Tag if necessary</font></td><td align=left bgcolor=white>
<textarea name="Ro_sign" id="Ro_sign" rows=2 cols="40"  onfocus="ChangeColor('Ro_sign',1)"  onblur="ChangeColor('Ro_sign',2)">
<?php echo $mvalue[2]; ?>
</textarea>
</td>
</tr>
<?php $i++; //Now i=4?>
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
$objLac->setCondString(" code>0" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
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
<td align=left><font face="arial" size="2" color="red">
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px" disabled>
</td>

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
