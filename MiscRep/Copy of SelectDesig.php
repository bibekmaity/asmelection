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
var b=myform.Desig_code.selectedIndex ;// Primary Key

if (a_index>0  && b>0)
{
//myform.setAttribute("target","_blank");   
myform.action="DesigWiseList.php";
myform.submit();
}
else
alert('Invalid Selection');
}



function isdate(dt,tag)
{
//var dt=myform.Est_On.value;
var ln=parseInt(dt.length);
var dd;
var mm;
var yyyy;
var leapday;
var tt=true;
var i=dt.indexOf("/");
dd=dt.substr(0,i);
var j=dt.indexOf("/",(i+1));
mm=dt.substr((i+1),(j-i-1));
yyyy=dt.substr((j+1),(ln-j-1));
if(isNaN(yyyy)==false)
{
var t=parseInt(yyyy%4);
if(t==0)
leapday=29;
else
leapday=28;
}
if((tag==0) && ln==0)  //for null field No check
tt=true;
else
{
if (isNaN(dd)==false && isNaN(mm)==false && isNaN(yyyy)==false)
{
dd=Number(dd);
mm=Number(mm);
yyyy=Number(yyyy);
if( (mm>0) && (mm<13) && (dd>0) && (dd<32))
{
if((mm==4)||(mm==6)||(mm==9)||(mm==11)) //30st day
{
if (dd>30)
{
alert('Invalid Date '+dt+'(DD Part out of range)');
tt=false;
}
} // mm==4
if (mm==2)
{
if (dd>leapday)
{
alert('Invalid Date '+dt+'(DD Part)');
tt=false;
}
} //mm==2
}
else //mm>0 && dd>0
{
alert('Invalid Date '+dt+'(Month out of range)');
tt=false;
}
}
else  // Non numeric figure appears
{
alert('Invalid date '+dt);
tt=false;
}
}// not null
return(tt);
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

function validateString(str)
{
var str_index=str.indexOf("'");
var str_select=str.indexOf("select");
var str_insert=str.indexOf("insert");
var str_delete=str.indexOf("delete");
var str_dash=str.indexOf("--");
var str_vbscript=str.indexOf("vbscript");
var str_javascript=str.indexOf("javascript");
var str_ampersond=str.indexOf("&");
var str_lessthan=str.indexOf("<");
var str_greaterthan=str.indexOf(">");
var str_semicolon=str.indexOf(";");

if(str_index==-1 && str_select==-1 && str_insert==-1 && str_delete==-1 && str_dash==-1 && str_vbscript==-1 && str_javascript==-1 && str_ampersond==-1 && str_lessthan==-1 && str_greaterthan==-1 && str_semicolon==-1)
return(true);
else
return(false);
} 

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

function isNumber(ad)
{
if (isNaN(ad)==false && notNull(ad))
return(true);
else
return(false);
}

function checkName(str)
{
//var  str=n.value;
var k=0;
var found=true;
var mylength=str.length;
var newstr="";
for (var i = 0; i < str.length; i++) 
{  
k=parseInt(str.charCodeAt(i)); 
//Allow Alphabet and Blank
if ( (k>=97 && k<=122)  || (k>=65 && k<=90) || (k==32)  )
{
newstr=newstr+str.substr(i,1);
}
else
{
alert('Invalid Character String ['+str+']');
found=false;
i=mylength+1;
}
}
return(found);
}

function LoadTextBox()
{
var i=myform.Editme.selectedIndex;
if(i>0)
{    
myform.edit1.disabled=false;
myform.delete1.disabled=false;
}
else
    {
myform.edit1.disabled=true;
myform.delete1.disabled=true;
    }
//alert('Write Java Script as per requirement');
}
function trimBlank(str,a)
{

var newstr="";
var prev=0;
for (var i = 0; i < str.length; i++)
{
k=parseInt(str.charCodeAt(i));
if (k==32 && prev==0)
{
newstr=newstr;
}
else
{
newstr=newstr+str.substr(i,1);
}
if (k==32)
prev=0;
else
prev=1;
}
document.getElementById(a).value=newstr;
}//trimBlank

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
$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: MasterEntry.php?unauth=1');
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
<td align=right ><font color=black size=3 face=arial>Select Office Category</font></td><td align=left >
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
<tr><td align="right"><font color=black size=3 face=arial>Select Designation</td><td align="left">
<?php 
$objDesignation->setCondString("Dep_type='".$mvalue[0]."' and Designation in(select distinct desig from poling) order by Designation"); //Change the condition for where clause accordingly
$row=$objDesignation->getRow();
?>
<select name=Desig_code style="font-family: Arial;background-color:white;color:black;font-size: 12px;width:200px" onchange=LoadTextBox()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Click to Edit-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[$i]==$row[$ind]['Designation'])
{
?>
<option selected value="<?php echo $row[$ind]['Designation'];?>"><?php echo $row[$ind]['Designation'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Designation'];?>"><?php echo $row[$ind]['Designation'];
}
} //for loop
?>
</select></td>
</tr>
<?php $i++; //Now i=3?>

<tr><td align=right bgcolor=white>

        
</td><td align=left bgcolor=white>
<input type=button value=List  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;width:100px">
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
