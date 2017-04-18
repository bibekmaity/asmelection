<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--
function direct()
{
var mvalue=myform.Editme.value;
//load mvalue in Proper Primary Key Input Box
myform.Venue_code.value=mvalue;
var a=myform.Venue_code.value ;
if ( isNaN(a)==false && a!="")
{
myform.action="Form_trg_venue.php?tag=2&ptype=0";
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
myform.Venue_code.focus();
}

function redirect(i)
{
}

function validate()
{
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="TrgMenu.php?tag=1";
var a=myform.Venue_code.value ;
var b=myform.Venue_name.value ;
var b_length=parseInt(b.length);
if ( isNumber(a)==true   && notNull(b) && validateString(b) && b_length<=150)
{
myform.action="Insert_trg_venue.php";
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
require_once './class/class.trg_venue.php';

$objUtility=new Utility();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify


$objTrg_venue=new Trg_venue();

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
$mvalue[0]=$objTrg_venue->maxVenue_code();
$mvalue[2]=0;//last Select Box for Editing
}
else
{
$mvalue[0]="0";//Venue_code
$mvalue[1]="";//Venue_name
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
// Call $objTrg_venue->MaxVenue_code() Function Here if required and Load in $mvalue[0]
$mvalue[0]=$objTrg_venue->maxVenue_code();
$mvalue[1]="";//Venue_name
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


if (isset($_POST['Venue_code']))
$pkarray[0]=$_POST['Venue_code'];
else
$pkarray[0]=0;
$objTrg_venue->setVenue_code($pkarray[0]);
if ($objTrg_venue->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objTrg_venue->getVenue_code();
$mvalue[1]=$objTrg_venue->getVenue_name();
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
$mvalue[1]="";
$mvalue[2]=0;//last Select Box for Editing
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=85%>
<form name=myform action=insert_trg_venue.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Training Place<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white width=30%><font color=black size=2 face=arial>Venue Serial No</font></td><td align=left bgcolor=white  width=70%>
<input type=text size=8 name="Venue_code" id="Venue_code" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Venue_code',1)"  onblur="ChangeColor('Venue_code',2)"  readonly>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Venue Name</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Venue_name" id="Venue_name" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=150 onfocus="ChangeColor('Venue_name',1)"  onblur="ChangeColor('Venue_name',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr><td align=right bgcolor=#ccffcc>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Update Mode";
else
echo"<font size=2 face=arial color=#6666FF>Insert Mode";
?>
</td><td align=left bgcolor=#ccffcc>
<input type=button value=Save/Update  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:blue;width:130px">
</td></tr>
<tr><td align=right valign=center rowspan="2"><font size=2 face=arial color=black>
Select to Edit Venue</td>
<td align=left>    
<?php 
$objTrg_venue->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objTrg_venue->getRow();
?>
<select name=Editme style="font-family: Arial;background-color:white;color:black;font-size: 12px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>
        
</td>
</tr>
<tr>
<td align=left>
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:70px" disabled>
</tr>

</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Venue_name");

?>
<?php
include("footer.htm");
?>
</body>
</html>
