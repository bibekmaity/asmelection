<?php
include("Menuhead.html");
?>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="Validator.js"></script>

<script language=javascript>
<!--

function direct()
{
var mvalue=document.getElementById('Editme').value;
//load mvalue in Proper Primary Key Input Box (Preferably on Last Key)
myform.Depcode.value=mvalue;
//alert(mvalue);
var a=myform.Depcode.value ;
if ( isNumber(a)==true)
{
myform.action="Form_department.php?tag=2&ptype=0";
myform.submit();
}
}

function LoadDep()
{
var data="Deptype="+document.getElementById('Dep_type').value;
data=data+"&Dname="+document.getElementById('dname').value;
var iBoxId="Depcode";///Set hidden input Box ID Accordingly
var DivId="DivDep";//Set DIV ID Accordingly
var SelectBoxId="0";//Change Accordingly
MyAjaxFunction("POST","Load_Department.php?mtype="+SelectBoxId+"&mval="+document.getElementById(iBoxId).value  ,data,DivId,"HTML");
}    



function direct1()
{
var a=myform.Depcode.value ;
var b=myform.Dep_type.selectedIndex;
//alert(b);
if ( b>0 && StringValid('dname',0,0))
{
myform.action="Form_department.php?tag=2&ptype=1";
myform.submit();
}
}

function find()
{
if (StringValid('Department',1,0)==true)
{
myform.action="Form_department.php?tag=2&ptype=3";
myform.submit();
}
else
{
alert('Enter Text');
myform.Department.focus();
}
}


function setMe()
{
myform.Depcode.focus();
}

function swift2(i)
{
window.location="selectdepartment.php?dcode="+i;    
}

function redirect(i)
{
if (i==10)
window.location="form_department.php?tag=0";

var j=myform.Dep_type.value;
if (j=="M" || j=="P")
myform.Beeo_code.disabled=false;
else
{
myform.Beeo_code.value=0;
myform.Beeo_code.SelectedIndex=1;
myform.Beeo_code.disabled=true;
load();
}

}


function load()
{
myform.Beeo.value=myform.Beeo_code.value;
}

function validate()
{
//var j=myform.rollno.value;
//var mylength=parseInt(j.length);
//var mystr=j.substr(0, 3);// 0 to length 3
//var ni=j.indexOf(",",3);// search from 3
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="mainmenu.php?tag=1";
var a=myform.Depcode.value ;
var b=myform.Dep_type.value ;
//var b_index=myform.Dep_type.selectedIndex;
//var c=myform.Department.value ;
//var c_length=parseInt(c.length);
//var e=myform.Address.value ;
//var e_length=parseInt(e.length);
//var f=myform.Beeo_code.value ;

//var g=myform.Dep_const.value ;
//var g_index=myform.Dep_const.selectedIndex;
//var h=myform.District.value ;
//v//ar h_length=parseInt(h.length);
if (b=="M" || b=="P")
var f_index=myform.Beeo_code.selectedIndex;
else
f_index=1;    

var ok;
ok=((b=="M" || b=="P")&& f_index>1) || (b!="M" && b!="P" && f_index==1);
if (isNumber(a)==true   && SelectBoxIndex('Dep_type')>0  && SelectBoxIndex('Dep_const')>0  && StringValid('Department',1,0) && StringValid('Address',1,0) && ok==true  && StringValid('District',0,0))
{
document.getElementById('Save1').disabled=true;
myform.action="Insert_department.php";
myform.submit();
}
else
{
if (NumericValid('Depcode',1)==false)
{
alert('Non Numeric Value in Depcode');
document.getElementById('Depcode').focus();
}
else if (SelectBoxIndex('Dep_type')==0)
{
alert('Select Dep_type');
document.getElementById('Dep_type').focus();
}
else if (StringValid('Department',1,0)==false)//0-Simple Validation
{
alert('Check Office Name');
document.getElementById('Department').focus();
}
else if (StringValid('Address',1,0)==false)//0-Simple Validation
{
alert('Check Address');
document.getElementById('Address').focus();
}
else if (SelectBoxIndex('Dep_const')==0)
{
alert('Select Office LAC');
document.getElementById('Dep_const').focus();
}

else if (ok==false)
{
alert('Select Beeo_code');
document.getElementById('Beeo_code').focus();
}
else if (StringValid('District',0,0)==false)//0-Simple Validation
{
alert('Check District');
document.getElementById('District').focus();
}
else 
alert('Enter Correct Data');
}
}

function home()
{
window.location="mainmenu.php?tag=1";
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

function res()
{
window.location="Form_department.php?tag=0";
}
</script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
  
var data="Deptype="+document.getElementById('Dep_type').value;
data=data+"&Dname="+document.getElementById('dname').value;
MyAjaxFunction("POST","Load_Department.php?mtype=0&mval=0",data,'DivDep',"HTML");

$("#Department").change(function(event){
$("#msg").hide();
});


var dp=document.getElementById('Dep_type').value;
if(dp=="M" || dp=="P")
$("#DivBEEO").show();
else
$("#DivBEEO").hide();   

$("#Dep_type").change(function(event){
var dp=document.getElementById('Dep_type').value;
if(dp=="M" || dp=="P")
$("#DivBEEO").show();
else
$("#DivBEEO").hide();    
});

} //document ready
);
</script>

<body>
<?php
header('Refresh: 120;url=IndexPage.php?tag=1');
session_start();
require_once './class/utility.class.php';
require_once './class/class.department.php';
require_once './class/class.deptype.php';
require_once './class/class.beeo.php';
require_once './class/class.lac.php';
require_once './class/class.Poling.php';

$objUtility=new Utility();
$objDepartment=new Department();

$cap="Save";
//Start Verify
$allowedroll=3; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify

$objLac=new Lac();

$GroupStatus=$objLac->CommongroupStatus();

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

if(isset($_SESSION['district']))
$district=$_SESSION['district'];
else 
$district="";    
if ($_tag==1)//Return from Action Form
{
//if(isset($_SESSION['dtype']))
//echo "dtype".$_SESSION['dtype'];

if (!isset($_SESSION['lastcode']))    
$_SESSION['lastcode']=0;

if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$district=$mvalue[6];
}
else
{
//$mvalue[0]="0";//Depcode
$mvalue[1]="";//Deptype
$mvalue[2]="";//department
$mvalue[3]="0";//Dep_const
$mvalue[4]="0";//BEEO
$mvalue[5]="0";//Dep_const
$mvalue[6]="";//District
}//end isset mvalue

if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
   
$mvalue[0]=$objDepartment->MaxDepcode();//Depcode
if(isset($_SESSION['dtype']))
$mvalue[1]=$_SESSION['dtype'];

//echo $mvalue[4];
}//tag=1

$dname="";
if ($_tag==0) //Initial Page Loading
{
$_SESSION['lastcode']=0;
$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objDepartment->MaxDepcode() Function Here if required and Load in $mvalue[0]
$mvalue[0]=$objDepartment->MaxDepcode();//Depcode
$mvalue[1]="";//Dep_type
$mvalue[2]="";//Department
$mvalue[3]="";//Address
// Call $objDepartment->MaxBeeo_code() Function Here if required and Load in $mvalue[4]
$mvalue[4]="0";//Beeo_code
// Call $objDepartment->MaxDep_const() Function Here if required and Load in $mvalue[5]
$mvalue[5]="0";//Dep_const
$mvalue[6]="";//District
$_SESSION['mvalue']=$mvalue;
}
if ($_tag==2)//Post Back 
{
if (!isset($_SESSION['lastcode']))    
$_SESSION['lastcode']=0;
$_SESSION['msg']="";
if (isset($_GET['ptype']))
$ptype=$_GET['ptype'];
else
$ptype=0;
//Post Back on Select Box Change,Hence reserve the value
if ($ptype==1 || $ptype==3 || $ptype==2)
{
// CAll MaxNumber Function Here if require and Load in $mvalue
if (isset($_POST['Depcode']))
$mvalue[0]=$_POST['Depcode'];
else
$mvalue[0]=0;

if (isset($_POST['dname']))
$dname=$_POST['dname'];
else
$dname="";


if (isset($_POST['Dep_type']))
$mvalue[1]=$_POST['Dep_type'];
else
$mvalue[1]="X";

if (isset($_POST['Department']))
$mvalue[2]=$_POST['Department'];
else
$mvalue[2]="";

if (isset($_POST['Address']))
$mvalue[3]=$_POST['Address'];
else 
$mvalue[3]="";    
    
if ($ptype==1)
{  
if (isset($_POST['Beeo_code']))
$mvalue[4]=$_POST['Beeo_code'];
else
$mvalue[4]=0;
}
else
{
if (isset($_POST['Beeo']))   
$mvalue[4]=$_POST['Beeo'];
else
$mvalue[4]=0;
}

if (!is_numeric($mvalue[4]))
$mvalue[4]=-1;

if (isset($_POST['Dep_const']))  
$mvalue[5]=$_POST['Dep_const'];
else
$mvalue[5]=0;

if (!is_numeric($mvalue[5]))
$mvalue[5]=-1;
if (isset($_POST['District']))  
$mvalue[6]=$_POST['District'];
else
$mvalue[6]="Nalbari";
} //ptype=1
if (isset($_POST['Depcode']))
$pkarray[0]=$_POST['Depcode'];
else 
$pkarray[0]=0;

$objDepartment->setDepcode($pkarray[0]);
if ($objDepartment->EditRecord()) //i.e Data Available
{ 
if ($ptype==0) //Post Back on Edit Button Click
{
if (isset($_POST['dname']))
$dname=$_POST['dname'];
else
$dname="";

$mvalue[0]=$objDepartment->getDepcode();
$mvalue[1]=$objDepartment->getDep_type();
$mvalue[2]=$objDepartment->getDepartment();
$mvalue[3]=$objDepartment->getAddress();
$mvalue[4]=$objDepartment->getBeeo_code();
$mvalue[5]=$objDepartment->getDep_const();
$mvalue[6]=$objDepartment->getDistrict();
$_SESSION['lastcode']=$mvalue[0];
} //ptype=0
$_SESSION['update']=1;
} 
else //data not available for edit
{
$_SESSION['update']=0;
if ($ptype==0)
{
$mvalue[0]=$pkarray[0];
$mvalue[1]=-1;
$mvalue[2]="";
$mvalue[3]="";
$mvalue[4]=-1;
$mvalue[5]=-1;
$mvalue[6]="";
}
}
} //tag==2
if($mvalue[1]=="P" || $mvalue[1]=="M")
$disB="";
else
$disB=" disabled";

//Start of Form Design
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=95%>
<form name=myform action=insert_department.php  method=POST >
<tr><td colspan=2 align=Center bgcolor=#ccffcc><font face=arial size=3>Entry/Edit Form for Department/Office/Institution<br></font><font face=arial color=red size=2>
    <div id="msg">
    <?php echo  $_SESSION['msg'] ?>
    </div>
        </font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Serial Code</font></td><td align=left bgcolor=white>
<input type=hidden size=8 name="Depcode" id="Depcode" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeColor('Depcode',1)"  onblur="ChangeColor('Depcode',2)" onchange=direct1()>
<?php echo $mvalue[$i]; ?>
</td>
</tr>
<?php $i++; //Now i=1?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Category</font></td><td align=left bgcolor=white>
<?php 
$objDeptype=new Deptype();
$objDeptype->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objDeptype->getRow();
?>
<select name=Dep_type id=Dep_type style="font-family: Arial;background-color:white;color:black;font-size: 14px" onchange=LoadDep()>
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
<font color=green size=2 face=arial>

<input type="checkbox" name="sentcase" value="sel" checked="checked" >
Convert Office Name as SentenceCase*</font>
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Name of Establishment<br>(Office/Institution/School)</font></td><td align=left bgcolor=white>
<textarea rows=2 cols=75 maxlength=148 name="Department" id="Department" style="font-family: Arial;background-color:white;color:black; font-size: 14px" maxlength=150 onfocus="ChangeColor('Department',1)"  onblur="ChangeColor('Department',2)">
<?php echo $mvalue[$i]; ?>
</textarea>
</td>
</tr>
<?php $i++; //Now i=3?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Address</font></td><td align=left bgcolor=white>
<input type=text size=50 name="Address" id="Address" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=50 onfocus="ChangeColor('Address',1)"  onblur="ChangeColor('Address',2)">
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=4?>
<tr id="DivBEEO">
<td align=right bgcolor=white><font color=black size=2 face=arial>Select BEEO</font></td><td align=left bgcolor=white>
<?php 
$objBeeo=new Beeo();
$objBeeo->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objBeeo->getRow();
?>
<select name=Beeo_code id=Beeo_code style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:200px" onchange="load()" >
<?php $dval="-1";?>
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
<input type=hidden size=1 name="Beeo" readonly value="<?php echo $mvalue[4]?>" onfocus=ChangeFocus('Dep_const')>
<font color=red size=1 face=arial>(Required for ME/MV and LP School)</font>
</td>
</tr>
</div>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Constituency</font></td><td align=left bgcolor=white>
<?php 

$objLac->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objLac->getRow();
?>
<select name=Dep_const id=Dep_const style="font-family: Arial;background-color:white;color:black; font-size: 14px;width:200px" >
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
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>District</font></td><td align=left bgcolor=white>
<input type=text size=15 name="District" id="District" value="<?php echo $district; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 14px" maxlength=50 onfocus="ChangeColor('District',1)"  onblur="ChangeColor('District',2)">
</td>
</tr>
<?php $i++; //Now i=7?>
<tr><td align=right bgcolor=#ccffcc height="40">
<?php
if ($_SESSION['update']==1)
{
echo"<font size=1 face=arial color=#CC3333>Updation Mode";
$mmode="U";
$cap="Update";
}
else
{
$mmode="I";
echo"<font size=1 face=arial color=#6666FF>New Entry Mode";
$cap="Save";
}
?>
<input type=hidden size=1 name=mode value="<?php echo $mmode?>">
</td><td align=left bgcolor=#ccffcc>
<input type=button value=<?php echo $cap;?>  name=Save id="Save1" onclick=validate()  style="font-family:arial; font-size: 14px;font-weight:bold ; background-color:#FFCC00;color:black;width:100px">
<?php if ($_SESSION['lastcode']>0){?>
<input type=button value="Proceed to Poling Entry"  name=entry1 onclick="swift2(<?php echo $_SESSION['lastcode']?>)"  style="font-family:arial; font-size: 14px ; background-color:#FF99CC;color:black;width:200px">
<?php }?>
</td></tr>
<tr><td align=center bgcolor=#99CCCC rowspan=2><font color=blue size=2 face=arial>
Search text<br>
<input type=text name=dname id=dname value="<?php echo $dname;?>" size=10 maxlength=10 onchange="LoadDep()">
</td>
<td align=left bgcolor=#99CCCC>
    <div id="DivDep">
        
    </div>        
</td></tr>
<tr>
<td align=left bgcolor=#99CCCC><font face="arial" size="2" color="red">
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:yellow;color:black;width:100px";
if($GroupStatus<=1)
{    
?>
<input type=button value=Edit  name="edit1" id="edit1" onclick=direct() style="<?php echo $mystyle;?>" disabled>
<?php 
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:green;color:black;width:100px";
?>
<input type=button value=Reset  name=res1 onclick=res() style="<?php echo $mystyle;?>"
<?php
}
else
echo "Editing Locked"; 
?>
</td>
</tr>


</table>
</form>
<?php
if($mtype==0)
echo $objUtility->focus("Dep_type");

if(isset($_SESSION['dtype']) && $_tag==1)
echo $objUtility->focus("Department");

?>
</table>
<?php
if (isset($_SESSION['mvalue']))
unset($_SESSION['mvalue']);
if (isset($_SESSION['msg']))
unset($_SESSION['msg']);

include("footer.htm");
?>
</body>
</html>
