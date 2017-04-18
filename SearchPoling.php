<?php
include("Menuhead.html");
?>

<script type="text/javascript" src="Validation.js"></script>
<script language=javascript>
<!--

function enu(a)
{
myform.Mid.value=a;
myform.Name.disabled=false;   
myform.Save.disabled=false;   
myform.Name.value="";
myform.Name.focus();
if(a==2)
document.getElementById('Dep_type').disabled=false;
else
document.getElementById('Dep_type').disabled=true;    
}

function direct()
{
var a=myform.Slno.value ;
if ( isNaN(a)==false && a!="")
{
myform.action="Searchpoling.php?tag=2&ptype=0";
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
myform.Slno.focus();
}

function redirect(i)
{
}

function validate()
{

var a=myform.Mid.value ;
var b=myform.Name.value ;
var data="Mid="+a+"&Name="+b;
data=data+"&Dtype="+document.getElementById('Dep_type').value;
if ((a==2 && validateString(b) && notNull(b)) || (a==1 && isNumber(b) && parseInt(b)>0)|| (a==3 && validateString(b) && notNull(b) && checkMobile()))
{
//myform.action="Searchpoling.php?tag=1";
//myform.submit();
MyAjaxFunction("POST","SearchpolingN.php",data,'Result',"HTML");
}
else
alert('Invalid Data');
}


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
alert('Write Java Script as per requirement');
}

function checkMobile()
{
//var  str=n.value;
var k;
var i;
var found;
found=false;
//alert('entering');
var str=myform.Name.value;
//alert(str);
var mylength=str.length;
//alert(str+':'+mylength);
if (mylength==10)
{    
str=str.substr(0,5)+'-'+str.substr(5,5);
myform.Name.value=str;
mylength=str.length;
}
//alert(str+':'+mylength);


if (mylength==11)
{
found=true;
k=str.substr(0,5);
if (isNumber(k)==false)
found=false;
//alert(found);
if (str.substr(5,1)!="-")
found=false;
//alert(found);
k=str.substr(6,5);
if (isNumber(k)==false)
found=false;
} //if mylength=11
else
found=false;
if(found==false)
alert('Invalid Number');
return(found);
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
require_once './class/class.sentence.php';
require_once './class/class.training.php';
require_once './class/class.deptype.php';

$objUtility=new Utility();
$objTrg=new Training();
$cond="1=2";

$param="";

//Start Verify
$allowedroll=4; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: mainmenu.php?unauth=1');
//End Verify

$objPoling=new Poling();
$objCat=new Category();
$objC=new Sentence();

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

 
if ($_tag==0) //Initial Page Loading
{
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objPoling->MaxSlno() Function Here if required and Load in $mvalue[0]
$mvalue[0]="";//Slno
$mvalue[1]="";//Name
$mvalue[2]="";//Phone
$mvalue[3]=0;//last Select Box for Editing
$_SESSION['mvalue']=$mvalue;
}//tag=0[Initial Loading]

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=75%>
<form name=myform action=insert_poling.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Search Database for Poling Officer <br></font><font face=arial color=red size=2><?php echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=center colspan="2" bgcolor=white><font color=black size=2 face=arial>
    <input type="radio" name="c1" id="c1" value="1" onclick="enu(1)">
    By Poling ID</font>
   <input type="radio" name="c1" id="c1" value="2" onclick="enu(2)">
    By Name</font>
   <input type="radio" name="c1" id="c1"  value="3" onclick="enu(3)">
    By Phone Number</font></td>
</tr>
<tr >
<td align=right bgcolor=white><font color=black size=2 face=arial>
Select Office Category</td>
<td align=left>
<?php 
$objDeptype=new Deptype();
$objDeptype->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type id=Dep_type style="font-family: Arial;background-color:white;color:black;font-size: 14px" onchange=LoadDep()>
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-All Category-
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

</select>
</td>
</tr>

<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>
Enter Search Text</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Name" id="Name" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black;font-weight:bold; font-size: 14px" maxlength=100 onfocus="ChangeColor('Name',1)"  onblur="ChangeColor('Name',2)" disabled>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php
//onchange="checkMobile()"
?>

<?php $i++; //Now i=3?>
<tr><td align=right bgcolor=#ccffcc>
<input type="hidden" size="1" name="Mid" id="Mid" readonly>        
</td><td align=left bgcolor=#ccffcc>
<input type=button value=Find  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:white;color:orange;width:100px" disabled>
</td></tr>
</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Slno");
?>

<div align="center" id="Result">
</div>
<?php
include("footer.htm");
?>         
       
</body>
</html>
