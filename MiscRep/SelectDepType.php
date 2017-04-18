<?php 
require_once 'MiscMenuHead.html';
?>
<script language=javascript>
<!--
function direct()
{
var i;
i=0;
}

function load(i)
{
myform.id.value=i;
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
myform.action="DepAbstract.php?id="+i;
myform.submit();
}
else
alert('Invalid Selection');
}




function home()
{
window.location="MiscMenu.php?tag=1";
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
myform.edit1.disabled=false;
else
myform.edit1.disabled=true;
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
require_once '../class/class.DEPTYPE.php';

    
$objUtility=new Utility();
//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Miscmenu.php?unauth=1');
//End Verify

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=60%>
<tr>
<td align=center colspan="2" bgcolor=#99FF00><font color=black size=2 face=arial><b>OFFICE CATEGORYWISE SUMMARY REPORT</b><br></font></td></tr>

       <form name=myform action=""  method=POST >
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Office Category</font></td><td align=left bgcolor=white>
<?php 
$objCat=new Deptype();
$row=$objCat->getRow();
//echo $objLac->returnSql;
?>
<select name=Category style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:230px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
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
<?php $i++; //Now i=2?>
<tr>
<td>&nbsp;</td>    
<td align=left  bgcolor=white>
<input type=radio value="1"  name=opt onclick=load(1)>
CategoryWise Total Person
</td>
</tr>
<tr>
<td>&nbsp;</td>    
<td align=left  bgcolor=white>
<input type=radio value="2"  name=opt onclick=load(2)>
CategoryWise Person Selected in Group
</td>
</tr>
<tr><td align=right bgcolor=#99FFCC>
<input type="hidden" name="id" size="1">          
</td><td align=left bgcolor=#99FFCC>
<input type=button value="Display Result"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:#CCFFFF;color:#CC66FF;width:130px">
</td></tr>

</table>
</form>
<?php
include("footer.htm");
?>  
</body>
</html>
