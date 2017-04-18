<html>
<head>
<title>Exempt from Duty after Grouping</title>
</head>
<script type="text/javascript" src="validation.js"></script>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
//$("div").hide();  //Hide All div item

//$("#Slno").blur(function(event){
//if(isNumber($("#Slno").val()))
//$("div").show(); 
//}
//);
});//End document ready
</script>





<script language=javascript>
<!--
function direct()
{

var a=myform.Slno.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="ExemptfromTrg.php?tag=2&ptype=0";
myform.submit();
}
}


function place(i)
{
myform.Newslno.value=i;
if(parseInt(i)>0)
myform.Save.disabled=false;    
}

function direct1()
{
var i;
i=0;
}

function setMe()
{
myform.Slno.focus();
}

function redirect(i)
{
}

function validate()
{

var a=myform.Slno.value ;// Primary Key
var b=myform.Newslno.value ;// Primary Key
var c=myform.Res.value ;// Primary Key


if ( isNumber(a)==true   && isNumber(b)==true && notNull(c) && validateString(c))
{
if(parseInt(a)>0 && parseInt(b)>0)    
{
var name = confirm("Replace Poling person?");
if (name == true)    
{
myform.action="ReplaceTrg.php";
myform.submit();
}
}
else
alert('Invalid ID');
}
else
{    
alert('Enter Reason for Exemption');
myform.Res.focus();
}
}


function home()
{
window.location="mainmenu.php?tag=1";
}

function go()
{
var a=myform.Slno.value ;//Primary Key
if ( isNaN(a)==false && a!="")
{
myform.action="ExemptfromTrg.php?tag=2&ptype=0";
myform.submit();
}
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

//END JAVA
</script>
<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.category.php';
require_once './class/class.Training.php';
require_once 'header.php';

$objTrg=new Training();


$objUtility=new Utility();
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

$objPoling=new Poling();

if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

$url="";

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
$mvalue[0]="";
$mvalue[1]="";//Name
$mvalue[2]="";//Desig
$mvalue[3]="";//Department
// Call $objPoling->MaxPollcategory() Function Here if required and Load in $mvalue[4]
$mvalue[4]="-1";//Pollcategory

if(isset($_SESSION['newid']))
{    
$mid=" with New ID ".$_SESSION['newid']."(Note down ID for prining Training Letter) "  ;  
$url="<a href=./PDFReport/TrainingFirst.php?id=".$_SESSION['newid']." target=_blank>Print Training Letter</a>";    
}
else
{    
$mid="";    
$url="";
}
if (isset($_GET['res']))
{ 
if ($_GET['res']==1)
echo $objUtility->alert("Succesfully Replaced Person".$mid);
else 
echo $objUtility->alert("Failed to Replaced Person");
   
}
$_SESSION['update']=0;
}//tag=1 [Return from Action form]


if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objPoling->MaxSlno() Function Here if required and Load in $mvalue[0]
$mvalue[0]="0";//Slno
$mvalue[1]="";//Name
$mvalue[2]="";//Desig
$mvalue[3]="";//Department
// Call $objPoling->MaxPollcategory() Function Here if required and Load in $mvalue[4]
$mvalue[4]="-1";//Pollcategory
$mvalue[5]="";//Phone
$mvalue[6]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

if ($_tag==2)//Post Back 
{
$_SESSION['msg']="";


if (isset($_POST['Slno']))
$pkarray[0]=$_POST['Slno'];
else
$pkarray[0]=0;
$objPoling->setSlno($pkarray[0]);
if ($objPoling->EditRecord()) //i.e Data Available
{ 
$mvalue[0]=$objPoling->getSlno();
$mvalue[1]=$objPoling->getName();
$mvalue[2]=$objPoling->getDesig();
$mvalue[3]=$objPoling->getDepartment();
$mvalue[4]=$objPoling->getPollcategory();
$mvalue[5]=$objPoling->getPhone();
$mvalue[6]=0;//last Select Box for Editing

//if($objPoling->getSelected()=="Y" && $objPoling->getGrpno()>0)
if($objPoling->isSelected4Trainee($mvalue[0], 1))
{
$_SESSION['update']=1;
}
else
{
$_SESSION['update']=0;  
echo $objUtility->alert("Person Selected is not in a Training Batch");
}
} 
else //data not available for edit
{
$_SESSION['update']=0;

$mvalue[0]=$pkarray[0];
$mvalue[1]="";
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]="";
$mvalue[5]="";

} //EditRecord()
} //tag==2
//
//
//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_poling.php  method=POST >
<tr><td colspan=3 align=Center bgcolor=#ccffcc><font face=arial size=3>ALTER AND EXEMPT EVM TRAINEE<br></font><font face=arial color=red size=2>&nbsp;</font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right valign="top" bgcolor=#FFFFCC width="35%"><font color=black size=3 face=arial>Poling ID</font></td><td align=left bgcolor=#FFFFCC colspan="2" width="65%">
<input type=text size=4 name="Slno" id="Slno" value="<?php echo $mvalue[0]; ?>" onfocus="ChangeColor('Slno',1)"  onblur="ChangeColor('Slno',2)"  style="font-family:arial; font-size: 14px ; background-color:white;color:black">
<font color=black size=3 face=arial>
Replace by ID
<input type=text size=4 name="Newslno" readonly style="font-family:arial; font-size: 14px ; background-color:#CCCCCC;color:black;">
</td>
</tr>
<font color=black size=2 face=arial>
<?php 
$objCategory=new Category();
$objCategory->setCode($mvalue[4]); //Change the condition for where clause accordingly
if($objCategory->EditRecord())
$cat=$objCategory->getName();
else
$cat="";

?>
<tr><td align="center" bgcolor="#3399CC">
        <font size="2" face=arial align="center">
    Detail of Person to be Exempted
    </td>
<td align="center" bgcolor="#3399CC">
        <font size="2" face=arial align="center">
    Select unused <b><?php echo $cat;?> Officer</b> from following list to replace
    </td>
</tr>    
<tr><td valign="top" align="left">
<div id=msg1>
<font color=black size=2 face=arial>
<?php
echo "Name-<b>".$mvalue[1]."</b><br>";
echo "Designation-<b>".$mvalue[2]."</b><br>";
echo $mvalue[3]."<br>";
echo "Duty Category- <b>".$cat." Officer</b><br>";
?>
<hr><b>
Enter Reason for exemption</b>
<textarea name="Res" rows="5" cols="30" onfocus="ChangeColor('Res',1)"  onblur="ChangeColor('Res',2)"></textarea>
<br>
</div>
<font color="blue" size=2 face=arial>
<div align="justify" id=msg2>
Training at&nbsp; <b>
<?php
if($_SESSION['update']==1)
{
$trow=$objTrg->getTrainingDetail($mvalue[0], 1);
echo $trow['Trgplace']." </b>(Hall-";
echo $trow['Hallno'].") on <b>";
echo $trow['Trgdate']."</b> from <b>";
echo $trow['Trgtime'].".</b>";
}
?>
</div>    
</td>        
        
    <?php $i++; //Now i=1?>
<td align=right >
<table border="1" width="100%" align="center" style=border-collapse: collapse; width=95%>
<tr><td align="center" bgcolor="#FFCC66" width="7%"><font size="2" face=arial align="center">SlNo</td>
<td align="center" bgcolor="#FFCC66" width="10%"><font size="2" face=arial >Poling ID</td>    
<td align="center" bgcolor="#FFCC66" width="65%"><font size="2" face=arial >Name and Address</td>
<td align="center" bgcolor="#FFCC66" width="15%"><font size="2" face=arial>Training</td>
<td align="center" bgcolor="#FFCC66" width="10%"><font size="2" face=arial>Select</td>
</tr>   
<?php 
if($_SESSION['update']==1)
{
$mycond=" and Slno not in(Select Poling_id from Poling_training where Phaseno=1)" ;   
$objPoling->setCondstring(" (Selected='Y' )and Grpno=0 and Pollcategory=".$mvalue[4].$mycond." order by rnumber");
$row=$objPoling->getSelectedRow(10);
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr><td align=center><font size="2" face=arial>
<?php echo $ii+1;?>
</td>
<td align=center><font size="2" face=arial>
<?php echo $row[$ii]['Slno'];?>
</td>
<td align=left><font size="2" face=arial>
<?php echo $row[$ii]['Name'].",".$row[$ii]['Desig'];?>
<br>
<font size="1" face=arial>
<?php echo $row[$ii]['Department'];?>    
</td>
<td align="center"><font size="2" face=arial>
<?php 
if($objPoling->isPresentinTraining($row[$ii]['Slno'],1))
echo "Done";
else
echo "Not Done";    
?>

</td>
<td align="center">
<input type=radio Name="Idno" value="<?php echo $row[$ii]['Slno'];?>" onclick="place(<?php echo $row[$ii]['Slno'];?>)">
</td>
</tr>
<?php 
$rno=rand(1,100000);
$sql="update poling set rnumber=".$rno." where Slno=".$row[$ii]['Slno'];
$objPoling->ExecuteQuery($sql);
}//for Loop
}//$_session['update']

?>
</table>
</td>
</tr>
<tr><td align=right bgcolor=#FFFFCC>
<?php
if ($_SESSION['update']==1)
echo"<font size=2 face=arial color=#CC3333>Replacable";
else
echo"<font size=2 face=arial color=#6666FF>Not Replacable";
?>
</td><td align=left bgcolor=#FFFFCC>
<input type=hidden size=11 name=Pdate id=Pdate value="<?php echo $present_date; ?>">
<input type=button value=Replace  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;width:100px" disabled>
<input type=button value=Menu  name=back1 onclick=home()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">

<input type=button value="Refresh List"  name=Ref onclick=go()  style="font-family:arial; font-size: 14px ; background-color:green;color:blue;width:120px">
<font size="2" face="arial" color="blue">
<?php
echo $url;
?></font>
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Slno");

?>
</body>
</html>
