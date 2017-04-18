<?php 
require_once 'MiscMenuHead.html';
?>
<script language=javascript>
<!--


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
myform.action="SelectDesig.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}

function validate()
{

var a_index=myform.Dep_type.selectedIndex;
var b=myform.Desig_code.value ;// Primary Key

if (a_index>0  && notNull(b))
{
//myform.setAttribute("target","_blank");   
myform.action="DesigWiseList.php";
myform.submit();
}
else
alert('Invalid Selection');
}



function load(a)
{
var b=document.getElementById(a).value;
myform.Desig_code.value=b;
}



function home()
{
window.location="Miscmenu.php?tag=1";
}



//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}

//change color on focus to Box(a)
function ChangeColor(el,i)
{
if (i==1) // on focus
document.getElementById(el).style.backgroundColor = '#99CC33';
if (i==2) //on lostfocus
{
document.getElementById(el).style.backgroundColor = 'white';
var temp=document.getElementById(el).value;
trimBlank(temp,el);
}
}//changeColor on Focus


function notNull(str)
{
var k=0;
var found=false;
var mylength=str.length;
for (var i = 0; i < str.length; i++) 
{  
k=parseInt(str.charCodeAt(i)); 
if (k!=32)
found=true;
}
return(found);
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
//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify



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
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
}
else
{
$mvalue[0]="";//Dep_type
$mvalue[1]="0";//Desig_code
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
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=55%>
<form name=myform action=insert_designation.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>PRINT DESIGNATION WISE LIST<br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=#6699FF><font color=black size=3 face=arial>Select Office Category</font></td><td align=left bgcolor=#6699FF>
<?php 
$objDeptype=new Deptype();
$objDeptype->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type style="font-family: Arial;background-color:white;color:black; font-size: 12px;width:160px" onchange=redirect(1)>
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
<tr><td align="center" valign=top bgcolor=#6699FF><font color=black size=3 face=arial>Designation Detail</td>
<td align="center" bgcolor=#6699FF>
<font color=black size=3 face=arial>Total Person Available</td></tr>


<?php 
$objDesignation->setCondString("Dep_type='".$mvalue[0]."' and Designation in(select distinct desig from poling) order by Designation"); //Change the condition for where clause accordingly
$row=$objDesignation->getRow();
$ind=0;
for($i=0;$i<count($row);$i++)
{
$des=$row[$i]['Designation'];
$tot=$objDesignation->PersonCount($mvalue[0],$des);
if($tot>0)
{
$ind++;
$mdesig="mdesig".$ind;
?>
<tr><td align="right">
<font color=black size=3 face=arial>
<?php
echo $des;
?>
<input type=radio name=Desig onclick=load('<?php echo $mdesig;?>')>
</td>
<td align="center"><font color=black size=3 face=arial>
<?php
echo $tot;
?>
<input type=hidden name=<?php echo $mdesig;?> id=<?php echo $mdesig;?> value="<?php echo $des;?>" size=20>
</td></tr>
<?php
}//if $tot>0
}//for loop
?>

<?php $i++; //Now i=3?>

<tr><td align=right bgcolor=#CCFF99>
<input type=hidden name=Desig_code size=20>
        
</td><td align=left bgcolor=#CCFF99>
<input type=button value=List  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; font-weight:bold;background-color:white;color:#CC66FF;width:100px">
</td></tr>
<tr><td align=right>

</td><td align=left>

</tr>
</table>
</form>
<?php
include("footer.htm");
?>  
</body>
</html>
