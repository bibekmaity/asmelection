<?php
include("Menuhead.html");
?>
<script type="text/javascript" src="validation.js"></script>
<script language=javascript>
<!--

function dis()
{
myform.Save.disabled=true; 
var data="Cat="+document.getElementById('Category').value;
MyAjaxFunction("POST","FindExtraPc.php?id=1",data,'Extra',"HTML");
if(document.getElementById('Category').selectedIndex>0 && document.getElementById('Mixed').value=="Y") 
myform.Tc.disabled=false;
else
{
myform.Tc.disabled=true;
alert('Prepare Database First');
}
}

function redirect()
{
var a=myform.Res.value;
var b=myform.Category.selectedIndex;
if (nonZero(a) && b>0)   
{
myform.action="FirstLevel.php?tag=3&red=1";
//myform.submit();
}
}

function init()
{
    
var a=myform.Res.value;
if (nonZero(a))
{
//alert('This Action will take some time depending on volume of Poling Person in Database,Please be Patient')    
myform.start.disabled=true;
//myform.action="InitFirstRandom.php";    
//myform.submit();
document.getElementById('Category').selectedIndex=0;
var data="Res="+document.getElementById('Res').value;
if (document.getElementById('first').checked==true)
data=data+"&first=1";
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br><b>Mixing Polling Person...Please Wait";
MyAjaxFunction("POST","InitFirstRandom.php",data,"Result","MSGHTML");
document.getElementById('Res').disabled=true;
}    
else
alert('Select Reserve Person')
}


function test()
{
var a=myform.Res.value;
var b=myform.Category.selectedIndex;
var c=parseInt(document.getElementById('ExtraPc').value);
if (nonZero(a) && b>0)
{
if(c>=parseInt(a))
{    
myform.Tc.disabled=true;  
myform.Save.disabled=false;   
//myform.action="TestCondition.php";    
//myform.submit();
//alert('ok');
var data="Res="+document.getElementById('Res').value;
data=data+"&Category="+document.getElementById('Category').value;
if(document.getElementById('Home_lac').checked==true)
data=data+"&Home_lac=1";
if(document.getElementById('R_lac').checked==true)
data=data+"&R_lac=1";
if(document.getElementById('Dep_lac').checked==true)
data=data+"&Dep_lac=1";
if(document.getElementById('cg').checked==true)
data=data+"&cg=1";
if(document.getElementById('sg').checked==true)
data=data+"&sg=1";
if(document.getElementById('bp').checked==true)
data=data+"&bp=1";
//alert(data);
document.getElementById('Result').innerHTML="<image src=./image/Star.gif width=50 height=50><br><b>Polling Person Selection in progress,Please Wait..";
MyAjaxFunction("POST","TestCondition.php",data,"Result","MSGHTML");
}
else
alert('Maximum Reserve may be '+c+'%');
}
else
alert('Invalid Selection or Data');
}


function validate()
{
var a=myform.Res.value;
var b=myform.Category.selectedIndex;
var data="Res="+document.getElementById('Res').value;
data=data+"&Category="+document.getElementById('Category').value;
if (nonZero(a) && b>0)
{
//myform.action="FirstLevelFinal.php";    
//myform.submit();
if(document.getElementById('Tested').value=="Y") //Test Success
{
MyAjaxFunction("POST","FirstLevelFinal.php",data,"Result","MSGHTML");
}
else
{
alert('Test Condition First');
document.getElementById('Save').disabled=true;
document.getElementById('Tc').disabled=false;
}
}
else
alert('Invalid Selection or Data');
}


function home()
{
window.location="Mainmenu.php?tag=1";
}

//change the focus to Box(a)
function ChangeFocus(a)
{
document.getElementById(a).focus();
}

//END JAVA
</script>
<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
$("#Save").click(function(event){
var cat=document.getElementById('Category').value;
if(document.getElementById('Tested').value=="Y")
$("#Category option[value='"+cat+"']").remove();
});
} //Document ready End
);
</script>

<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.lac.php';
require_once './class/class.category.php';
require_once './class/class.psname.php';
require_once './class/class.polinggroup.php';
require_once './class/class.poling.php';
require_once './class/class.training.php';
require_once './class/class.sentence.php';
require_once './class/class.status.php';
require_once './class/class.final.php';


$objPs=new Psname();
$objPg=new Polinggroup();
$objPoling=new Poling();
$objTrg=new Training();
$objS=new Status();
$objCat=new Category();

$testresult="Result of Test Condition will be Displayed here";
$chk=" ";
$objS->setSerial("1");
if($objS->EditRecord())
{
if($objS->getRandomised()>0)  
$chk=" disabled";
}
  
$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');
//End Verify
$mvalue=array();

$des=0;
if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

if (!is_numeric($_tag))
$_tag=0;

if ($_tag>3)
$_tag=0;

$chk1=" checked=checked";
$chk2=" checked=checked";
$chk3=" checked=checked";
$chk4=" checked=checked";
$chk5=" checked=checked";
$chk6=" checked=checked";

$cap="Select and Finalise";

$firstlevel=0;


$dis1=" disabled";//test Condition
$dis2=" disabled"; //Final Selection
$dis3=""; //Initialise
if ($_tag==0) //Initial Page Loading
{
$mvalue[0]="25";
$mvalue[1]=0;
$objTrg->ExecuteQuery("delete from testgroup");

$objCat->setCondString(" Selected>0 and FirstRandom='Y' order by Code");
$row=$objCat->getAllRecord();
$n=count($row);
if ($n>0)
{
$testresult="<table border=1 width=100% align=center>";
$testresult=$testresult."<tr><td colspan=2 align=center width=100% bgcolor=#66FF99>First Level Randomisation Detail</td></tr>";

$testresult=$testresult."<tr><td align=center bgcolor=#66FF99><font face=arial size=2>Category</td>";
$testresult=$testresult."<td align=center bgcolor=#66FF99><font face=arial size=2>Selected</td></tr>";

for($j=0;$j<$n;$j++)
{
$name=$row[$j]['Name'];
$tot=$row[$j]['Selected'];
$testresult=$testresult."<tr><td align=center><font face=arial size=2>".$name."</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>".$tot."</td></tr>";
} //$j==0
$testresult=$testresult."</table>";

} //$n>0

if($objPoling->FirstLevelCompleted())
{    
$str="First Level Randomisation for Poling person ";
if($objCat->Randomised(7)) //MicroObserver also completed
{
$str=$str." and Micro Observer ";
$dis3=" disabled";
$firstlevel=1;
}
$str=$str." Completed";
echo $objUtility->alert ($str);
}

} //$_Tag==0


    
	
if($_tag==3) //Return from FirstLevelFinal.php  or Post Back on Category
{
$dis1=" ";
$dis2=" disabled";    
$dis3=" disabled";    
if (isset($_SESSION['mvalue']))
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
else
{
$mvalue[0]="25";
$mvalue[1]=0;
}
if(isset($_POST['Res']))
$mvalue[0]=$_POST['Res'];

if (isset($_POST['Category']))
$mvalue[1]=$_POST['Category'];

unset($_SESSION['mvalue']);


//Display The results
$objCat->setCondString(" Selected>0 and FirstRandom='Y' order by Code");
$row=$objCat->getAllRecord();
$n=count($row);
if ($n>0)
{
$testresult="<table border=1 width=100% align=center>";
$testresult=$testresult."<tr><td colspan=2 align=center width=100% bgcolor=#66FF99>First Level Randomisation Detail</td></tr>";

$testresult=$testresult."<tr><td align=center bgcolor=#66FF99><font face=arial size=2>Category</td>";
$testresult=$testresult."<td align=center bgcolor=#66FF99><font face=arial size=2>Selected</td></tr>";

for($j=0;$j<$n;$j++)
{
$name=$row[$j]['Name'];
$tot=$row[$j]['Selected'];
$testresult=$testresult."<tr><td align=center><font face=arial size=2>".$name."</td>";
$testresult=$testresult."<td align=center><font face=arial size=2>".$tot."</td></tr>";
} //$j==0
$testresult=$testresult."</table>";
} //$n>0

} //$_TAG==3



    
if(isset($mvalue[2]))
{
if($mvalue[2]==1)
$chk4=" checked=checked";
else
$chk4="";
}
else
$chk4=" checked=checked";

if(isset($mvalue[3]))
{
if($mvalue[3]==1)
$chk5=" checked=checked";
else
$chk5="";
}
else
$chk5=" checked=checked";

if(isset($mvalue[4]))
{
if($mvalue[4]==1)
$chk6=" checked=checked";
else
$chk6="";
}
else
$chk6=" checked=checked";

if(isset($mvalue[5]))
{
if($mvalue[5]==1)
$chk1=" checked=checked";
else
$chk1="";
}
else
$chk1=" checked=checked";

if(isset($mvalue[6]))
{
if($mvalue[6]==1)
$chk2=" checked=checked";
else
$chk2="";
}
else
$chk2=" checked=checked";

if(isset($mvalue[7]))
{
if($mvalue[7]==1)
$chk3=" checked=checked";
else
$chk3="";
}
else
$chk3=" checked=checked";

if($firstlevel==0) //Show the form if First level not completed
{
?>
<form name="myform" method="post">    
<table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse; border-bottom-width:0" bordercolor="#111111" width="95%" align="center">
  <tr>
    <td width="100%" colspan="3" style="border-left-color: #111111; border-left-width: 1; border-right-color: #111111; border-right-width: 1; border-top-color: #111111; border-top-width: 1">
    <p align="center"><font face="Arial">RANDOMLY SELECT&nbsp; POLING PERSON FROM
    </font></td>
  </tr>
  <tr>
    <td width="40%" align="center" style="border-style: solid; border-width: 1; " bgcolor="#CCCCFF">
    <font face="Arial">Central Govt
    <input type="checkbox" name="cg" id="cg" value="G" <?php echo $chk1;?>>
    </font>
       &nbsp;(Total-
    <font face="Arial" size="2"><?php echo $objPoling->countDepcatWise("G",0);?>)
    </td>
    <td width="30%" align="center" style="border-style: solid; border-width: 1; " bgcolor="#CCCCFF">
    <font face="Arial">PSU
    <input type="checkbox" name="bp" id="bp" value="B" <?php echo $chk2;?>>
   &nbsp;(Total-
    <font face="Arial" size="2"><?php echo $objPoling->countDepcatWise("B",0);?>)
    </font></td>
    <td width="30%" align="center" style="border-style: solid; border-width: 1; " bgcolor="#CCCCFF">
    <font face="Arial">State Govt
    <input type="checkbox" name="sg" id="sg" value="S" <?php echo $chk3;?>>
    </font>
       &nbsp;(Total-
    <font face="Arial" size="2"><?php echo $objPoling->countDepcatWise("S",0);?>)
    </td>
  </tr>
    <tr>
    <td width="32%" align="center" style="border-style: solid; border-width: 1; " >
        <font face="Arial" size="2"><?php echo $objPoling->countDepcatWiseDetail("G");?>
    </font></td>
    <td width="18%" align="center" style="border-style: solid; border-width: 1; " >
    <font face="Arial" size="2"><?php echo $objPoling->countDepcatWiseDetail("B");?>
   </font></td>
    <td width="25%" align="center" style="border-style: solid; border-width: 1; " >
    <font face="Arial" size="2"><?php echo $objPoling->countDepcatWiseDetail("S");?>
    </font></td>
  </tr>
  
  <tr>
    <td width="75%"  colspan="3">
    <p align="center"><b>Test Following Condition for First Level Randomisation</b></td>
  </tr>
  <tr>
    <td width="32%" style="border-bottom-style: solid; border-bottom-width: 1">
    <p align="right">
    <font face="Arial" size="2">
    Donot Place in Home LAC
    <input type=checkbox name=Home_lac id=Home_lac value=Sel <?php echo $chk4;?>>
    </font></td>
    <td width="43%" bgcolor="#CCFFCC" style="border-bottom-style: solid; border-bottom-width: 1" colspan="2" rowspan="4" valign="top" align="center">
     <font face=arial size=2 color=blue>
	    <div id="Result" align="center">
        <?php echo $testresult?>   
		<input type=hidden name="Mixed" id="Mixed" value="N" size=1 disabled>
      <input type=hidden name="Tested" id="Tested" value="N" size=1 disabled>        
	    </div>  
	</font>
    </td>
  </tr>
  <tr>
    <td width="32%" style="border-style: solid; border-width: 1; ">
    <p align="right"><font face="Arial" size="2">Donot Place in Residential LAC
    <input type=checkbox name=R_lac id=R_lac  value=Sel <?php echo $chk5;?>>
        </font></td>
  </tr>
  <tr>
    <td width="32%" style="border-style: solid; border-width: 1; ">
    <p align="right"><font face="Arial" size="2">Donot Place in Working LAC
    <input type=checkbox name=Dep_lac id=Dep_lac  value=Sel <?php echo $chk6;?>>
    </font></td>
  </tr>
  <tr>
    <td width="32%" style="border-style:solid; border-width:1; ">
    <p align="right"><font face="Arial" size="2">Add Reserve</font>
    <input type="textbox" name="Res" id="Res" value="<?php echo $mvalue[0];?>" size="2" style="font-family: Arial;background-color:white;color:black;font-weight:bold; font-size:14px">       
    %
    <div id="Extra" align="right">
    <input type="hidden" name="ExtraPc" id="ExtraPc" size="2" value="30">
    </div>
    </td>
  </tr>
  <tr>
    <td width="32%" style="border-left: 1px solid #111111; border-right-style: solid; border-right-width: 1; border-bottom-color:#111111; border-bottom-width:1">
    <p align="right"><font face="Arial" size="2">Select Category</font></td>
    <td width="43%" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-color:#111111; border-bottom-width:1" colspan="2">
<?php 
$objCategory=new Category();
$objCategory->setCondString(" Firstrandom='N' and code in(1,2,3,4,5,7) order by code"); //C
$row=$objCategory->getRow();
?>
<select name=Category id="Category" style="font-family: Arial;background-color:white;color:black;font-weight:bold; font-size: 14px;width:250px" onchange="dis();redirect()">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[1]==$row[$ind]['Code'])
{
?>
<option selected value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];?>
<?php 
}
else
{
?>
<option  value="<?php echo $row[$ind]['Code'];?>"><?php echo $row[$ind]['Name'];
}
} //for loop
?>
</select>
      
    </td>
  </tr>
  <tr>
    <td width="32%" align="right" bgcolor="#CCCCFF" style="border-left: 1px solid #111111; border-right-style: solid; border-right-width: 1; border-bottom-color:#111111; border-bottom-width:1">
<input type="checkbox" name="first" id="first" checked="checked" <?php echo $chk;?>>
<input type=button value="Prepare Database"  name="start" id="start" onclick="init()"  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:#6699FF;color:back;width:200px" <?php echo $dis3;?>>
  </td>
    <td width="18%" align="center" bgcolor="#CCCCFF" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-color:#111111; border-bottom-width:1">
<input type=button value="Test Condition"  name="Tc" id="Tc" onclick="test()"  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:#339966;color:back;width:150px" <?php echo $dis1;?>>
</td>
<td width="25%" align="center" bgcolor="#CCCCFF" style="border-left-style: solid; border-left-width: 1; border-right: 1px solid #111111; border-bottom-color:#111111; border-bottom-width:1">
<input type=button value="<?php echo $cap;?>"  name="Save" id="Save" onclick=validate()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:orange;color:black;width:270px" <?php echo $dis2;?>>
</td>
  </tr>
</table>
   
 
</td></tr>
</table>

</form>
 
<?php 
}//if($firstlevel=0)
if($firstlevel==1) //Show the Report
{
?>
<table width="75%" border="1" cellspacing="1" cellpadding="2" align="center">
  <tr><td align=center colspan=5><font face=arial size=3><b>RESULT OF FIRST LEVEL RANDOMISATION</td></tr>
  <tr>
    <td align=center WIDTH="24%"><font face=arial size=2><b>Category</td>
    <td align=center WIDTH="10%"><font face=arial size=2><b>Selected</td>
    <td align=center WIDTH="12%"><font face=arial size=2><b>Considered Home LAC</td>
    <td align=center WIDTH="12%"><font face=arial size=2><b>Considered Residential LAC</td>
    <td align=center WIDTH="12%"><font face=arial size=2><b>Considered Working LAC</td>
  </tr>
   <?php
 $objCat->setCondstring("Firstrandom='Y' and selected>0");  
 $row=$objCat->getAllRecord(); 
 for($i=0;$i<count($row);$i++) 
 {
 if($row[$i]['Allow_dep_lac']==0)
 $dep="Yes";
 else
 $dep="No";  
 
 if($row[$i]['Allow_home_lac']==0)
 $home="Yes";
 else
 $home="No"; 

 if($row[$i]['Allow_res_lac']==0)
 $res="Yes";
 else
 $res="No"; 
 ?> 
  <tr>
    <td align=left><font face=arial size=2><?php echo $row[$i]['Name'];?></td>
    <td align=center><font face=arial size=2><?php echo $row[$i]['Selected'];?></td>
    <td align=center><font face=arial size=2><?php echo $home;?></td>
    <td align=center><font face=arial size=2><?php echo $res;?></td>
    <td align=center><font face=arial size=2><?php echo $dep;?></td>
  </tr>
 <?php
 }
 ?> 
  
</table>
   
<?php
}
include("footer.htm");
?>   
</body>
</html>
