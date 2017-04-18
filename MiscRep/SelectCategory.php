<?php
require_once 'MiscMenuHead.html';
?>
<script src="../jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
$("#RowCell").hide();  
$("#Row2").show();
$("#Row3").show();
$("#Row4").show();
$("#Row5").show();

$("#Category").change(function(event){

var i=parseInt($("#Category").val());
if(i==6 || i>7)
{
if(i==6)
$("#RowCell").show(); 

$("#Row2").hide();
$("#Row3").hide();
$("#Row4").hide();
$("#Row5").hide();
$("#Row6").hide();
}
else
{    
$("#RowCell").hide();
$("#Row2").show();
$("#Row3").show();
$("#Row4").show();
$("#Row5").show();
$("#Row6").show();
}
}); //Noday change function

} //Document ready End
);


</script>

<script type="text/javascript" src="../Validation.js"></script>

<script language=javascript>
<!--

function verify()
{
var data="Cat="+document.getElementById('Category').value;
data=data+"&Id="+document.getElementById('id').value;
if(document.getElementById('Category').value==6) //Cell
data=data+"&Cell="+document.getElementById('Cell').value;
else
data=data+"&Cell=0";    
MyAjaxFunction("POST","CountCategory.php",data,"Result","HTML");
}


function load(i)
{
myform.id.value=i;
verify();
}


function direct()
{
var i;
i=0;
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
}

function validate(i)
{


var b_index=myform.Category.selectedIndex;

if ( b_index>0)
{
myform.setAttribute("target","_blank");//Open in New Window
myform.action="PolingList.php";
myform.submit();
}
else
alert('Invalid Selection');
}




function home()
{
window.location="MiscMenu.php?tag=1";
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
require_once '../class/class.cell.php';

    
$objUtility=new Utility();
//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Miscmenu.php?unauth=1');
//End Verify

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=70%>
<tr>
<td align=center colspan="2" bgcolor=#99FF66><font color=black size=2 face=arial>CATEGORYWISE MISCELLANEOUS REPORT</font></td></tr>

       <form name=myform action=""  method=POST >
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Poll Category</font></td><td align=left bgcolor=white>
<?php 
$objCat=new Category();
$objCat->setCondString(" code>0"); //Change the condition for where clause accordingly
$row=$objCat->getRow();
//echo $objLac->returnSql;
?>
<select name=Category id=Category style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:160px" onchange="verify()">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
} //for loop
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<tr id="RowCell">
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Cell Name</font></td><td align=left bgcolor=white>
<?php 
$objCell=new Cell();
//Change the condition for where clause accordingly
$row=$objCell->getRow();
//echo $objLac->returnSql;
?>
<select name=Cell id=Cell style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:160px" onchange="verify()">
<?php 
for($ind=0;$ind<count($row);$ind++)
{
?>
<option  value="<?php echo $row[$ind][0];?>"><?php echo $row[$ind][1];?>
<?php 
} //for loop
?>
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>

<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Sort Report on</font></td><td align=left bgcolor=white>
<select name=Sorton style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:160px" >
<option value="Slno">Poling ID
<option value="Name">Name of Poling Person
<option value="Department">Office Name
<option value="Basic">Basic Pay   
<option value="Age">Age
<option value="Homeconst">Home LAC No
<option value="Dor">Date of Retirement
</select>
<select name=Asc style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:160px" >
<option Selected value="Asc">Ascending
<option value="Desc">Descending
</select>
<font color=red size=4 face=arial><b>*</b></font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="0"  name=opt onclick=load(0) checked="checked">
As On Database
</td></tr>
<tr id="Row2">
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="1"  name=opt onclick=load(1)>
Main Selection List
</td>
</tr>
<tr id="Row3">
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="2"  name=opt onclick=load(2)>
Reserve Selection List
</td>
</tr>
<tr id="Row4">
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="3"  name=opt onclick=load(3)>
Not Selected for Final Group
</td>
</tr>
<tr id="Row5">
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="4"  name=opt onclick=load(4)>
Not Selected for First Training
</td>
</tr>
<tr id="Row6">
<td>&nbsp;</td>    
<td align=left  bgcolor=white><font color=black size=2 face=arial>
<input type=radio value="5"  name=opt onclick=load(5)>
Selected in First Training
</td></tr>

<tr><td align=center bgcolor=#99FFCC><font face=arial size=2 color=orange>
<div id="Result">
</div></font>
</td><td align=left bgcolor=#99FFCC>
<input type="hidden" name="id" id="id" size="1" value="0">    
<input type=button value="Display Result"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:#CCFFFF;color:#CC66FF;width:130px">
</td></tr>
</table>
</form>
<?php
include("footer.htm");
?>      
</body>
</html>
