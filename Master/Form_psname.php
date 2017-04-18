<?php
include("MasterMenuhead.html");
?>
<script type=text/javascript src="../validation.js"></script>
<script language=javascript>
<!--
function direct()
{
myform.Psno.value=myform.Pslist.value;    
var b=myform.Lac.value ;
var c=myform.Psno.value ;
if ( isNaN(b)==false && b!="" && isNaN(c)==false && c!="")
{
myform.action="Form_psname.php?tag=2&ptype=0";
myform.submit();
}
}

function init()
{
myform.action="Form_psname.php?tag=0";
myform.submit();
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

function redirect(i)
{
myform.action="Form_psname.php?tag=2&ptype=1&mtype="+i;
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
//window.location="../Mainmenu.php?tag=1";
var b=myform.Lac.value ;
var b_index=myform.Lac.selectedIndex;
var c=myform.Psno.value ;
var d=myform.Part_no.value ;
var d_length=parseInt(d.length);
var e=myform.Psname.value ;
var e_length=parseInt(e.length);
var f=myform.Address.value ;
var f_length=parseInt(f.length);
var g=myform.Male.value ;
var h=myform.Female.value ;
//var l=myform.Forthpoling_required.value ;
var m=myform.Reporting_tag.value ;
var m_index=myform.Reporting_tag.selectedIndex;
var n=myform.Sensitivity.selectedIndex;
if ( n>0 && b_index>0  && isNumber(c)==true   && notNull(d) && validateString(d) && d_length<=50 && notNull(e) && validateString(e) && e_length<=250 && 1==1 && validateString(f) && f_length<=60 && isNumber(g)==true   && isNumber(h)==true   && m_index>0 )
{
myform.action="Insert_psname.php";
myform.submit();
}
else
alert('Invalid Data');
}


function home()
{
window.location="./../Mainmenu.php?tag=1";
}

function LoadTextBox()
{
//alert('pk');  
var i=myform.Pslist.selectedIndex;
if(i>0)
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;
//alert('Write Java Script as per requirement');
}

</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once '../class/utility.class.php';
require_once '../class/class.psname.php';
require_once '../class/class.lac.php';
require_once '../class/class.party_calldate.php';
require_once '../class/class.ps_status.php';
require_once '../class/class.poling.php';


$objUtility=new Utility();
$objPStatus=new Ps_status();
//Start Verify
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify

$objPsname=new Psname();
$rd="";
$objP=new Poling();


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
$mvalue[9]="0";
}
else
{
$mvalue[0]="0";//Lac
$mvalue[1]="0";//Psno
$mvalue[2]="";//Part_no
$mvalue[3]="";//Psname
$mvalue[4]="";//Address
$mvalue[5]="0";//Male
$mvalue[6]="0";//Female
$mvalue[7]="";//Forthpoling_required
$mvalue[8]="1";//Reporting_tag
$mvalue[9]="0";
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
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Lac
// Call $objPsname->MaxPsno() Function Here if required and Load in $mvalue[1]
$mvalue[1]="0";//Psno
$mvalue[2]="";//Part_no
$mvalue[3]="";//Psname
$mvalue[4]="";//Address
// Call $objPsname->MaxMale() Function Here if required and Load in $mvalue[5]
$mvalue[5]="0";//Male
// Call $objPsname->MaxFemale() Function Here if required and Load in $mvalue[6]
$mvalue[6]="0";//Female
$mvalue[7]="";//Forthpoling_required
$mvalue[8]="1";
$mvalue[9]="0";
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

//if (!is_numeric($mvalue[0]))
//$mvalue[0]=-1;
//if (isset($_POST['Psno']))
//$mvalue[1]=$_POST['Psno'];
//else
$objPsname->setLac($mvalue[0]);
$mvalue[1]=$objPsname->maxPsno();

if (isset($_POST['Part_no']))
$mvalue[2]=$_POST['Part_no'];
else
$mvalue[2]=0;

if (isset($_POST['Psname']))
$mvalue[3]=$_POST['Psname'];
else
$mvalue[3]=0;

if (isset($_POST['Address']))
$mvalue[4]=$_POST['Address'];
else
$mvalue[4]=0;

if (isset($_POST['Male']))
$mvalue[5]=$_POST['Male'];
else
$mvalue[5]=0;

if (isset($_POST['Female']))
$mvalue[6]=$_POST['Female'];
else
$mvalue[6]=0;

if (isset($_POST['Sensitivity']))
$mvalue[7]=$_POST['Sensitivity'];
else
$mvalue[7]="";

if (isset($_POST['Reporting_tag']))
$mvalue[8]=$_POST['Reporting_tag'];
else
$mvalue[8]=0;

if (isset($_POST['Pslist']))
$mvalue[9]=$_POST['Pslist'];
else
$mvalue[9]=0;

if (!is_numeric($mvalue[8]))
$mvalue[8]=-1;
} //ptype=1

if (isset($_POST['Lac']))
$pkarray[0]=$_POST['Lac'];
else
$pkarray[0]=0;
$objPsname->setLac($pkarray[0]);
if (isset($_POST['Psno']))
$pkarray[1]=$_POST['Psno'];
else
$pkarray[1]=0;
$objPsname->setPsno($pkarray[1]);
if ($objPsname->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
if($objP->FirstLevelCompleted())
{
$rd=" readonly";
echo $objUtility->alert("You cannot change Voter Figure as First Level randomisation is Completed");
}    
    
    
$mvalue[0]=$objPsname->getLac();
$mvalue[1]=$objPsname->getPsno();
$mvalue[2]=$objPsname->getPart_no();
$mvalue[3]=$objPsname->getPsname();
$mvalue[4]=$objPsname->getAddress();
$mvalue[5]=$objPsname->getMale();
$mvalue[6]=$objPsname->getFemale();
$mvalue[7]=$objPsname->getSensitivity();
$mvalue[8]=$objPsname->getReporting_tag();
$mvalue[9]=$mvalue[1];
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
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]="";
$mvalue[5]="";
$mvalue[6]="";
$mvalue[7]="";
$mvalue[8]="1";
}//ptype=0
} //EditRecord()
} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=80%>
<form name=myform action=insert_psname.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Poling Station Name<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select LAC Name</font></td><td align=left bgcolor=white>
<?php 
$objLac=new Lac();
$objLac->setCondString(" code>0" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Lac style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:200px" onchange=redirect(2)>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Code'])
echo "<option selected value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
else
echo "<option  value=".chr(34).$row[$ind]['Code'].chr(34).">".$row[$ind]['Name'];
}
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=#CCCCCC><font color=black size=2 face=arial>Existing Poling Station</font></td><td align=left bgcolor=#CCCCCC>
<input type=hidden size=4 name="Psno" id="Psno" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Psno',1)"  onblur="ChangeColor('Psno',2)" onchange=direct1() readonly>
<select name=Pslist style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:300px"  onchange="LoadTextBox()">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-You May Edit Existing PS Here(Click Edit)-
<?php 
$objPsname->setCondString(" lac=".$mvalue[0]." order by psno");
$row=$objPsname->getAllRecord();
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[9]==$row[$ind]['Psno'])
echo "<option selected value=".chr(34).$row[$ind]['Psno'].chr(34).">".$row[$ind]['Part_no']." ".$row[$ind]['Psname'];
else
echo "<option  value=".chr(34).$row[$ind]['Psno'].chr(34).">".$row[$ind]['Part_no']." ".$row[$ind]['Psname'];
}
?>
</select>
&nbsp;
<input type=button value=Edit  name=edit1 onclick=direct()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:80px" disabled>

</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poling Station No</font></td><td align=left bgcolor=white>
<input type=text size=8 name="Part_no" id="Part_no" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Part_no',1)"  onblur="ChangeColor('Part_no',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Poling Station Name</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Psname" id="Psname" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=250 onfocus="ChangeColor('Psname',1)"  onblur="ChangeColor('Psname',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=4?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Address</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Address" id="Address" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=60 onfocus="ChangeColor('Address',1)"  onblur="ChangeColor('Address',2)">
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Male Voter</font></td><td align=left bgcolor=white>
<input type=text size=8 maxlength="4" name="Male" id="Male" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Male',1)"  onblur="ChangeColor('Male',2)" <?php echo $rd;?>>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Female Voter</font></td><td align=left bgcolor=white>
<input type=text size=8 maxlength="4" name="Female" id="Female" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Female',1)"  onblur="ChangeColor('Female',2)" <?php echo $rd;?>>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=7?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Sensitivity</font></td><td align=left bgcolor=white>
<?php 
$row=$objPStatus->getRow();
?>
<select name=Sensitivity style="font-family: Arial;background-color:white;color:black; font-size: 12px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][0];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][0];
}
?>
</select>
</td>
</tr>
<?php $i++; //Now i=8?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Reporting Date for Party</font></td><td align=left bgcolor=white>
<?php 
$objParty_calldate=new Party_calldate();
$objParty_calldate->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objParty_calldate->getRow();
?>
<select name=Reporting_tag style="font-family: Arial;background-color:white;color:black; font-size: 12px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
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
<?php $i++; //Now i=9?>
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
        
</td><td align=left bgcolor=white>
<input type=button value=<?php echo $cap;?>  name=Save onclick=validate()  style="font-family:arial; font-size: 12px ; background-color:orange;color:blue;width:80px">
<input type=button value="RESET"  name=res onclick=init()  style="font-family:arial; font-size: 12px ; background-color:green;color:blue;width:80px">
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Part_no");

if($mtype==2)//Postback from Lac
{
echo $objUtility->focus("Psno");
echo $objUtility->SelectedIndex("Pslist", 0);
}
if($mtype==3)//Postback from Psno
echo $objUtility->focus("Part_no");

if($mtype==4)//Postback from Part_no
echo $objUtility->focus("Psname");

if($mtype==5)//Postback from Psname
echo $objUtility->focus("Address");

if($mtype==6)//Postback from Address
echo $objUtility->focus("Male");

if($mtype==7)//Postback from Male
echo $objUtility->focus("Female");

if($mtype==8)//Postback from Female
echo $objUtility->focus("Forthpoling_required");

if($mtype==12)//Postback from Forthpoling_required
echo $objUtility->focus("Reporting_tag");

if($mtype==13)//Postback from Reporting_tag
echo $objUtility->focus("Lac");

?>
<?php
include("footer.htm");
?>
</body>
</html>
