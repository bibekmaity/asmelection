<html>
<head>
<title>Swap Code</title>
</head>
<script type="text/javascript" src="validation.js"></script>
<script language="javascript">
<!--
function LoadXML()
{
var data=ConstructDataString();
MyAjaxFunction("POST","./ServerRequest/XML_psname.php",data,'XML',"TEXT");
var name = confirm("Load XML Returned Data")
if (name == true)
{
var xmlString1=document.getElementById('XML').value;
var xmlString=FilterString(xmlString1);
var TagId = "";//Set XML TagName
var iBoxId = "";//Set ID of Input Box Where Parsed data will be loaded
var nodeId = 0;//Id of Node value i.e row number of returned XML
ParseXmlString(xmlString,TagId,nodeId,iBoxId);
//Thus Continue to Load Other Input Box
}//name=true
}//LoadXML

function FilterString(str)
{
var mylength=parseInt(str.length);
var ni=str.indexOf("<",0);// search from 3 
var mystr=str.substr(ni,(mylength-ni));// 0 to length 3
return(mystr);
}

function direct()
{

var c=document.getElementById('Rcode').value ;//Primary Key

if ( isNumber(c))
{
myform.action="Swap.php?tag=2&ptype=0";
myform.submit();
}
}



function setMe()
{
myform.Rcode.focus();
}

function redirect(i)
{
myform.action="Form_psname.php?tag=2&ptype=1&mtype="+i;
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
//StringValid('a',0,0) 'a'- Input Box Id, First(0- Allow Null,1- Not Null) Second(0- Simple Validation, 1- Strong Validation)
var d=myform.Psno.value ;// Primary Key
var h=myform.Male.value ;
var i=myform.Female.value ;

if(document.getElementById('Editme').selectedIndex==0)
alert('Select New PS Name');
else
if (StringValid('Rcode',0,0) && isNumber(d)==true )
{
//myform.setAttribute("target","_self");//Open in Self
//myform.setAttribute("target","_blank");//Open in New Window
myform.action="swap.php?tag=3";
myform.submit();
}
else
{
if (StringValid('Rcode',1,1)==false)//0-Simple Validation
{
alert('Check Rcode');
document.getElementById('Rcode').focus();
}
else if (NumericValid('Lac',1)==false)
{
alert('Select Lac');
document.getElementById('Lac').focus();
}
else if (NumericValid('Psno',1)==false)
{
alert('Non Numeric Value in Psno');
document.getElementById('Psno').focus();
}
else if (StringValid('Psname',1,0)==false)//0-Simple Validation
{
alert('Check Psname');
document.getElementById('Psname').focus();
}
else if (NumericValid('Male',1)==false)
{
alert('Non Numeric Value in Male');
document.getElementById('Male').focus();
}
else if (NumericValid('Female',1)==false)
{
alert('Non Numeric Value in Female');
document.getElementById('Female').focus();
}
else if (StringValid('Sensitivity',0,0)==false)//0-Simple Validation
{
alert('Check Sensitivity');
document.getElementById('Sensitivity').focus();
}
else if (SelectBoxIndex('Reporting_tag')==0)
{
alert('Select Reporting_tag');
document.getElementById('Reporting_tag').focus();
}
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
var i=document.getElementById('Editme').selectedIndex;
if(i>0)
document.getElementById('edit1').disabled=false;
else
document.getElementById('edit1').disabled=true;
//alert('Write Java Script as per requirement');
}

//Reset Form
function res()
{
window.location="Form_psname.php?tag=0";
}
//END JAVA
</script>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
//alert('Document Loaded');
$("#Rcode").change(function(event){
$("#DivMsg").hide();
});

//var mname = [" ","January","February","March","April","May","June","July","August","September","October","November","December"];
//$("#ChekBoxId").prop('checked', true); //Set heckbox Property
$("#Save").click(function(event){
//alert('You Clicked me');
});

//$("#id").blur(function(event){
//$("#Row1").show();
//$("#Row2").hide();
//$("#Female").animate({height:"-=5px"});
//$("#Female").animate({fontSize:"-=2px"});
//});

//Remove Select Box item Single
//$("#SelectBoxId option[value='11']").remove();

//Remove Select Box item Loop
//for(var i=7;i<=12;i++)
//$("#SelectBoxId option[value='"+i+"']").remove();

//Append Select Box item Single
//$("#SelectBoxId").append('<option value="9">September</option>');
//Append Select Box item Group
//var mid="#SelectBoxId";
//for(var i=1;i<=j;i++)
//{
//var opt="<option value="+i+">"+mname[i]+"</option>";
//$(mid).append(opt);
//}//for loop
//Unload Event through JQuery
$.ajaxSetup ({
cache: false
});
$(window).unload(function() {
//$.ajax({
//url:   'logout.php',async : false
//});
//return false;
}); //unload


//MyAjaxFunction("POST","LoadSelectBoxPsname.php?type=1",data,'TargetId',"HTML");



}); //Document Ready Function
</script>
<body>
<?php
//Start FORMPHPBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.psname.php';
require_once './class/class.lac.php';
require_once './class/class.party_calldate.php';

$objUtility=new Utility();
$allowedroll=0; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: mainmenu.php?unauth=1');

$objPsname=new Psname();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (isset($_SESSION['myArea']))
$Area=$_SESSION['myArea'];
else
$Area=0;

$dis=" disabled ";
//if ($objUtility->checkArea($_SESSION['myArea'], 12)==false) //e.g 12 for Eroll Certificate
//header( 'Location: Mainmenu.php?unauth=1');

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

$_SESSION['update']=0;//Initialise as Insert Mode
$present_date=date('d/m/Y');
$mvalue=array();

if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
$mvalue=InitArray();
$_SESSION['mvalue']=$mvalue;
//$mvalue[1]=$objPsname->MaxLac();
//$mvalue[2]=$objPsname->MaxPsno();
}//tag=0[Initial Loading]

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue=InitArray();
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
//$mvalue[1]=$objPsname->MaxLac();
//$mvalue[2]=$objPsname->MaxPsno();
}//tag=1 [Return from Action form]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;
//Post Back on Select Box Change,Hence reserve the value


if ($objPsname->EditCondition($_POST['Rcode'])) //i.e Data Available
{ 
    
if ($ptype==0) //Post Back on Edit Button Click
{
$mvalue[0]=$objPsname->getRcode();
$mvalue[1]=$objPsname->getLac();
//echo $objUtility->alert($mvalue[1]);
$mvalue[2]=$objPsname->getPsno();
$mvalue[3]=$objPsname->getPsname();
//echo $objUtility->alert($mvalue[3]);
$mvalue[4]=$objPsname->getMale();
$mvalue[5]=$objPsname->getFemale();
$mvalue[6]=$objPsname->getSensitivity();
$mvalue[7]=$objPsname->getReporting_tag();
$mvalue[8]=0;//last Select Box for Editing
$mvalue[9]=$objPsname->getForthpoling_required();
$dis=" ";
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
$dis=" disabled ";
echo $objUtility->alert("Group Code not Available");
} //EditRecord()
} //tag==2

if ($_tag==3)//Post Back 
{
$lac=$_POST['Lac'];
$psno1=$_POST['Psno'];
$rcode1=$_POST['Rcode'];
$psno2=$_POST['Editme'];
$objPsname->setLac($lac);
$objPsname->setPsno($psno2);
if($objPsname->EditRecord())
{
$rcode2= $objPsname->getRcode();
$sql1="update Psname set Rcode='".$rcode2."' where Lac=".$lac." and Psno=".$psno1;
$sql2="update Psname set Rcode='".$rcode1."' where Lac=".$lac." and Psno=".$psno2;
if($objPsname->ExecuteQuery($sql1) && $objPsname->ExecuteQuery($sql2) )
echo $objUtility->AlertNRedirect("Swaped Successfully","Swap.php?tag=0");
}//if
    

}//tag==3



if (isset($_SESSION['msg']))
$returnmessage=$_SESSION['msg'];
else
$returnmessage="";

$mvalue=VerifyArray($mvalue);

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_psname.php  method=POST >
<tr>
<td colspan=4 align=Center bgcolor=#66CC66>
<font face=arial size=3>Swap Code<br></font>
<font face=arial color=red size=2><div id="DivMsg"><?php echo  $returnmessage; ?></div></font>
</td>
</tr>
<?php $i=0; ?>
<?php //row1?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Rcode
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=4 name="Rcode" id="Rcode" value="<?php echo $mvalue[0]; ?>" style="<?php echo $mystyle;?>"  maxlength=4 onfocus="ChangeColor('Rcode',1)"  onblur="ChangeColor('Rcode',2)" onchange="direct()">
<div id="MsgRcode"></div>
</td>
<?php $i++; //Now i=1?>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Lac
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php 
$mystyle="font-family: Arial;background-color:white;color:black;font-size: 14px;width:160px";
?>
<input type="text" name="Lac" size="2" id="Lac" style="<?php echo $mystyle;?>" value="<?php echo $mvalue[1];?>" readonly>
</td>
</tr>
<?php $i++; //Now i=2?>
<?php //row2?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Psno
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=8 name="Psno" id="Psno" value="<?php echo $mvalue[2]; ?>" onfocus="ChangeColor('Psno',1)"  onblur="ChangeColor('Psno',2)" value="<?php echo $mvalue[2]; ?>" readonly>
<div id="MsgPsno"></div>
</td>
<?php $i++; //Now i=3?>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
PS Name
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text name="Psname" id="Psname" size=35 style="<?php echo $mystyle;?>" onfocus="ChangeColor('Psname',1)"  onblur="ChangeColor('Psname',2)" value="<?php echo $mvalue[3]; ?>" disabled>
<div id="MsgPsname"></div>
</td>
</tr>
<?php $i++; //Now i=4?>
<?php //row3?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Male
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=8 name="Male" id="Male" value="<?php echo $mvalue[4]; ?>" onfocus="ChangeColor('Male',1)"  onblur="ChangeColor('Male',2)" disabled>
<div id="MsgMale"></div>
</td>
<?php $i++; //Now i=5?>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Female
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=8 name="Female" id="Female" value="<?php echo $mvalue[5]; ?>" onfocus="ChangeColor('Female',1)"  onblur="ChangeColor('Female',2)" disabled>
<div id="MsgFemale"></div>
</td>
</tr>
<?php $i++; //Now i=6?>
<?php //row4?>
<tr>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Sensitivity
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<?php
$mystyle="font-family: Arial;font-weight:bold;background-color:white;color:black;font-size: 14px";
?>
<input type=text size=10 name="Sensitivity" id="Sensitivity" value="<?php echo $mvalue[6]; ?>" style="<?php echo $mystyle;?>"  maxlength=50 onfocus="ChangeColor('Sensitivity',1)"  onblur="ChangeColor('Sensitivity',2)" disabled>
<div id="MsgSensitivity"></div>
</td>
<?php $i++; //Now i=7?>
<td align=right bgcolor=#FFFFCC>
<font color=black size=2 face=arial>
Reporting Flag
</font>
</td>
<td align=left bgcolor=#FFFFCC>
<input type=text size=1  name="Reporting_tag"  id="Reporting_tag" value="<?php echo $mvalue[7]; ?>" readonly>
<input type=text size=1  name="Forthpoling"  id="Forthpoling" value="<?php echo $mvalue[9]; ?>" readonly>
</td>
</tr>
<?php $i++; //Now i=8?>
<tr>
<td align=right bgcolor=#FFFFCC>
<?php
if ($_SESSION['update']==1)
{
echo"<font size=1 face=arial color=#CC3333>Updation Mode";
$cap="Update Data";
}
else
{
echo"<font size=1 face=arial color=#6666FF>New Entry Mode";
$cap="Save Data";
}
?>
</td>
<td align=left bgcolor=#FFFFCC colspan="3">
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:100px";
?>
<input type=hidden size=8 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value="<?php echo $cap;?>"  name="Save" id="Save" onclick=validate() style="<?php echo $mystyle;?>" <?php echo $dis;?>>
<input type=hidden size=10 name=XML id="XML">
</td></tr>
<tr><td align=right bgcolor=#99CCCC rowspan=2><font color=red size=3 face=arial>
</td>
<td align=left bgcolor=#99CCCC colspan="3">
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:black;width:400px";
$cond="Lac=".$mvalue[1]." and Reporting_tag=".$mvalue[7]." and Psno<>".$mvalue[2]." and ForthPoling_required=".$mvalue[9]." order by Psname";
$objPsname->setCondString($cond); //Change the condition for where clause accordingly
$row=$objPsname->getAllRecord()

?>
<select name=Editme id=Editme  style="<?php echo $mystyle;?>" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
$mcode=$row[$ind]['Psno'];
$mdetail=$row[$ind]['Psname'];
if ($mvalue[8]==$mcode)
$sel=" Selected ";
else
$sel=" ";
?>
<option <?php echo $sel;?> value="<?php echo $mcode;?>"><?php echo $mdetail;?>
<?php 
} //for loop
?>
</select>
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Rcode");

if($mtype==3)//Postback from Lac
echo $objUtility->focus("Psno");

if($mtype==4)//Postback from Psno
echo $objUtility->focus("Psname");

if($mtype==12)//Postback from Reporting_tag
echo $objUtility->focus("Rcode");

if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);

//This function will Initialise Array
function InitArray()
{
$temp=array();
$temp[0]="";//Rcode
// Call $objPsname->MaxLac() Function Here if required and Load in $mvalue[1]
$temp[1]="0";//Lac
// Call $objPsname->MaxPsno() Function Here if required and Load in $mvalue[2]
$temp[2]="0";//Psno
$temp[3]="";//Psname
$temp[4]="0";//Male
$temp[5]="0";//Female
$temp[6]="";//Sensitivity
$temp[7]="0";//Reporting_tag
$temp[8]="0";//Micro_group
$temp[9]="0";//Micro_group
return($temp);
}//GenInitArray


//Verify If all Array Index are loaded
function VerifyArray($myvalue)
{
$temp=array();
for($i=0;$i<=8;$i++)
{
$temp[$i]="0";
}

if(isset($myvalue[0]))
$temp[0]=$myvalue[0];

if(isset($myvalue[1]))
$temp[1]=$myvalue[1];

if(isset($myvalue[2]))
$temp[2]=$myvalue[2];

if(isset($myvalue[3]))
$temp[3]=$myvalue[3];

if(isset($myvalue[4]))
$temp[4]=$myvalue[4];

if(isset($myvalue[5]))
$temp[5]=$myvalue[5];

if(isset($myvalue[6]))
$temp[6]=$myvalue[6];

if(isset($myvalue[7]))
$temp[7]=$myvalue[7];

if(isset($myvalue[8]))
$temp[8]=$myvalue[8];

if(isset($myvalue[9]))
$temp[9]=$myvalue[9];

return($temp);
}//VerifyArray

?>
</body>
</html>
