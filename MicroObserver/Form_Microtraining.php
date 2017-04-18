<?php
//include("menuhead.html");
?>  
<script type="text/javascript" src="../validation.js"></script>

<script language=javascript>
<!--

function enu()
{
var a=myform.Noday.selectedIndex;    
myform.Trgdate2.disabled=true;
myform.Trgdate3.disabled=true;
if(a==1)
{
myform.Trgdate2.disabled=false;
}
if(a==2)
{
myform.Trgdate2.disabled=false;
myform.Trgdate3.disabled=false;    
}
}

var ph=myform.Phaseno.value;
if (a==1)

function proceed(a,b)
{
    
var ph=myform.Phaseno.value;
if (a==1)
{
myform.setAttribute("target", "_blank");    
myform.action="../PDFReport/ViewMicroTrgBatchinPDF.php?phase="+ph+"&code="+b;    
//myform.action="ViewMicroTrgBatchinPDF.php?phase="+ph+"&code="+b;    
myform.submit();
}

if (a==2)
{
myform.setAttribute("target", "_self");
var name = confirm("Clear This Group?")

if (name == true)
{
myform.action="DeleteMicroTrg.php?phase="+ph+"&group="+b;    
myform.submit();
}
}
}


function setMe()
{
myform.Phaseno.focus();
}

function redirect(i)
{
myform.setAttribute("target", "_self");
myform.action="Form_Microtraining.php?tag=2&ptype=1&mtype="+i;
myform.submit();
}


function validate()
{
//var name = confirm("Return to Main Menu?")
//if (name == true)
//window.location="TrgMenu.php?tag=1";

var b=myform.Groupno.value ;
var c=myform.Trgdate1.value ;
var c_length=parseInt(c.length);
var d=myform.Trgdate2.value ;
var d_length=parseInt(d.length);
var e=myform.Trgdate3.value ;
var e_length=parseInt(e.length);
var f=myform.Venue_code.value ;
var f_index=myform.Venue_code.selectedIndex;
var g=myform.Hall_rsl.value ;
var g_index=myform.Hall_rsl.selectedIndex;
var h=myform.Trgtime.value ;
var h_index=myform.Trgtime.selectedIndex;
var j=myform.Hallcapacity.value ;

var mtot=myform.Micro.value;

//alert(mtot);

var cap=Number(j);
var nd=myform.Noday.value;

var mdate;
//alert(d);
var pdate=myform.Pdate.value;

mdate=false;

if(nd==1)
{
if(isdate(c,1)==true)
{
if (CompareDate(c,pdate)==1)  
mdate=true;  
else
alert('Enter Proper Date'+c);    
} //isdate(c,1)   
} //nd==1


if(nd==2)
{
if(isdate(c,1)==true && isdate(d,1)==true)
{
if (CompareDate(c,pdate)==1 && CompareDate(d,c)==1)  
mdate=true;  
else
alert('Enter Proper Date Sequence');    
} //isdate(c,1) &7 (d,1)
} //nd==2

if(nd==3)
{
if(isdate(c,1)==true && isdate(d,1)==true && isdate(e,1)==true)
{
if (CompareDate(c,pdate)==1 && CompareDate(d,c)==1 && CompareDate(e,d)==1)  
mdate=true;  
else
alert('Enter Proper Date Sequence');    
} //isdate(c,1) &7 (d,1)      
} //nd==3

if(mdate==true)
{
if (isNumber(mtot) && isNumber(b)==true && f_index>0  && g_index>0  && h_index>0 )
{
if (mtot>0 && mtot<=cap)
{
myform.Save.disabled=true;  
myform.hm.disabled=true; 
myform.action="Insert_Microtraining.php";
myform.submit();
}
else
alert('Enter Proper Value for  Batch Size(Maximum value-'+cap+')');
}
else
alert('Invalid Data');
}
}


function home()
{
window.location="../MainMenu.php?tag=1";
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
require_once '../class/utility.class.php';
require_once '../class/class.training.php';
require_once '../class/class.training_phase.php';
require_once '../class/class.trg_venue.php';
require_once '../class/class.trg_hall.php';
require_once '../class/class.trg_time.php';
require_once '../class/class.Poling_Training.php';
require_once '../class/class.status.php';
require_once '../class/class.Poling.php';

$objP=new Poling();
$objStatus=new Status();
$objUtility=new Utility();
$objStatus->setSerial("1");
$objStatus->EditRecord();
if($objStatus->getMicro_trg()=="Y" || $objP->Randomised(7)==false)
$lock=" disabled";
else
$lock="";

if($objP->Randomised(7)==false)
{
$_SESSION['catchmessage']="FIRST LEVEL RANDOMISATION IS NOT COMPLETED FOR MICRO OBSERVER";
header( 'Location: ../CatchMsg.php');
}


$objTrg_hall=new Trg_hall();

//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');
//End Verify



$objTraining=new Training();

//if (isset($_GET['phase']))
//$_phase=$_GET['phase'];
//else
//$_phase=1;



if (isset($_GET['tag']))
$_tag=$_GET['tag'];
else
$_tag=0;

$today=date('d/m/Y');


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

if (isset($_POST['Capacity']))
$cap=$_POST['Capacity'];
else
$cap="";

$tot=0;

$dis2=" disabled ";
$dis3=" disabled ";

if ($_tag==1)//Return from Action Form
{
if (isset($_SESSION['mcheck']))
$mcheck=$_SESSION['mcheck'];    
   
    
if (isset($_SESSION['mvalue']))
{
$mvalue=$_SESSION['mvalue']; //Load Session value Returned in Array
$mvalue[14]=0;
$mvalue[1]=$objTraining->maxGroupno(3);
}
else
{
if(isset($_SESSION['phase']))
$mvalue[0]=$_SESSION['phase'];
else
$mvalue[0]="0";//Phaseno
$mvalue[1]=$objTraining->maxGroupno(3);
$mvalue[2]="";//Trgdate1
$mvalue[3]="";//Trgdate2
$mvalue[4]="";//Trgdate3
$mvalue[5]="0";//Venue_code
$mvalue[6]="0";//Hall_rsl
$mvalue[7]="0";//Trgtime
$mvalue[8]="0";//Hallcapacity
$mvalue[9]="0";//Pr
$mvalue[10]="0";//P1
$mvalue[11]="0";//P2
$mvalue[12]="0";//P3
$mvalue[13]="0";//P4
$mvalue[14]=0;
$tot=0;
}//end isset mvalue
if (!isset($_SESSION['msg']))
$_SESSION['msg']="";
if (!isset($_SESSION['update']))
$_SESSION['update']=0;
if (isset($_SESSION['phase']))
$mvalue[0]=$_SESSION['phase']  ; 
}//tag=1 [Return from Action form]


if ($_tag==0) //Initial Page Loading
{
$tot=0; 

if($objStatus->getMicro_trg()=="Y")
echo $objUtility->alert("Training Allocation is Locked,Hence No more Training Batch is Allowed to Create;Ask Root User to unlock if required");
if($objP->Randomised(7)==false)    
echo $objUtility->alert("First Level Randomisation not Complete for Micro Observer");
 

$_SESSION['update']=0;
$_SESSION['msg']="";
// Call $objTraining->MaxPhaseno() Function Here if required and Load in $mvalue[0]
$mvalue[0]="1";//1 Noday
// Call $objTraining->MaxGroupno() Function Here if required and Load in $mvalue[1]
$mvalue[1]=$objTraining->maxGroupno (3);
$mvalue[2]="";//Trgdate1
$mvalue[3]="";//Trgdate2
$mvalue[4]="";//Trgdate3
// Call $objTraining->MaxVenue_code() Function Here if required and Load in $mvalue[5]
$mvalue[5]="0";//Venue_code
// Call $objTraining->MaxHall_rsl() Function Here if required and Load in $mvalue[6]
$mvalue[6]="0";//Hall_rsl
// Call $objTraining->MaxTrgtime() Function Here if required and Load in $mvalue[7]
$mvalue[7]="0";//Trgtime
// Call $objTraining->MaxHallcapacity() Function Here if required and Load in $mvalue[8]
$mvalue[8]="0";//Hallcapacity
$mvalue[9]="0";
$mvalue[10]="0";
$mvalue[11]="0";
$mvalue[12]="0";
$mvalue[13]="0";
$mvalue[14]=0;//last Select Box for Editing
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

// CAll MaxNumber Function Here if require and Load in $mvalue
if (isset($_POST['Noday']))
$mvalue[0]=$_POST['Noday'];
else
$mvalue[0]=1;


if (!is_numeric($mvalue[0]))
$mvalue[0]=-1;

if ($mtype==1) //Postback from Phaseno Box,Find Maximum Groupno
$mvalue[1]=$objTraining->maxGroupno ($mvalue[0]);
else //Postback from Hall
{
if (isset($_POST['Groupno']))
$mvalue[1]=$_POST['Groupno'];
else
$mvalue[1]=0;
}

if (isset($_POST['Trgdate1']))
$mvalue[2]=$_POST['Trgdate1'];
else
$mvalue[2]="";

if (isset($_POST['Trgdate2']))
$mvalue[3]=$_POST['Trgdate2'];
else
$mvalue[3]="";

if (isset($_POST['Trgdate3']))
$mvalue[4]=$_POST['Trgdate3'];
else
$mvalue[4]="";

if (isset($_POST['Venue_code']))
$mvalue[5]=$_POST['Venue_code'];
else
$mvalue[5]=0;

if (!is_numeric($mvalue[5]))
$mvalue[5]=-1;
if (isset($_POST['Hall_rsl']))
$mvalue[6]=$_POST['Hall_rsl'];
else
$mvalue[6]=0;

if (!is_numeric($mvalue[6]))
$mvalue[6]=-1;
if (isset($_POST['Trgtime']))
$mvalue[7]=$_POST['Trgtime'];
else
$mvalue[7]=0;

if (isset($_POST['Tot']))
$tot=$_POST['Tot'];

if ($mtype==7) //postback from hall, load capacity
{
$objTrg_hall->setVenue_code($mvalue[5]) ;   
$objTrg_hall->setRsl($mvalue[6])  ;  
if ($objTrg_hall->EditRecord())
$mvalue[8]=$objTrg_hall->getHall_capacity ();
else
$mvalue8="";
$tot=$mvalue[8];
}
else //post bacjk from other hence reserve the value for hall capacity
{
if (!is_numeric($mvalue[7]))
$mvalue[7]=-1;
if (isset($_POST['Hallcapacity']))
$mvalue[8]=$_POST['Hallcapacity'];
else
$mvalue[8]=0;
}


if (isset($_POST['Pr']))
$mvalue[9]=$_POST['Pr'];
else
$mvalue[9]=0;

if (isset($_POST['P1']))
$mvalue[10]=$_POST['P1'];
else
$mvalue[10]=0;

if (isset($_POST['P2']))
$mvalue[11]=$_POST['P2'];
else
$mvalue[11]=0;

if (isset($_POST['P3']))
$mvalue[12]=$_POST['P3'];
else
$mvalue[12]=0;

if (isset($_POST['P4']))
$mvalue[13]=$_POST['P4'];
else
$mvalue[13]=0;

if (isset($_POST['Editme']))
$mvalue[14]=$_POST['Editme'];
else
$mvalue[14]=0;

} //tag==2

//Start of FormDesign
?>
<table border=1 cellpadding=2 cellspacing=0 align=center style=border-collapse: collapse; width=100%>
<form name=myform action=insert_training.php  method=POST >
<tr><td colspan=4 align=Center bgcolor=#CC33FF><font face=arial size=3><B>CREATE TRAINING SLOT FOR MICRO OBSERVER BATCH NO <?php echo $mvalue[1]; ?></font><font face=arial color=red size=2><?php //echo  $_SESSION['msg'] ?></font></td></tr>
<?php $i=0; ?>
<tr>
<td align=right bgcolor=white WIDTH="25%"><font color=black size=2 face=arial>
<input type=hidden name=Phaseno value="3">
No of Training Days
<?php $i++; //Now i=1
$Sel1="";
$Sel2="";
$Sel3="";
if ($mvalue[0]==1)
$Sel1=" Selected ";
if ($mvalue[0]==2)
{    
$Sel2=" Selected ";
$dis2=" ";
}
if ($mvalue[0]==3)
{
$Sel3=" Selected ";
$dis2=" ";
$dis3="  ";
}
?>
<font color=black size=2 face=arial></font></td><td align=left bgcolor=white colspan=3 WIDTH="75%">
<input type=hidden size=8 name="Groupno" id="Groupno" value="<?php echo $mvalue[$i]; ?>" onfocus="ChangeFocus('Trgdate1')"  onblur="ChangeColor('Groupno',2)" readonly>
<font color=black size=3 face=arial><b>
    <SELECT name="Noday" onchange="enu()">
        <option <?php echo $Sel1;?> value="1">One
          <option <?php echo $Sel2;?> value="2">Two
           <option <?php echo $Sel3;?> value="3">Three  
   
    </select>
</b></font>
&nbsp;
</td>
</tr>
<?php $i++; //Now i=2?>
<tr>
<td align=right bgcolor=white WIDTH="25%"><font color=black size=2 face=arial>Training Date</font></td>
<td align=center bgcolor=white WIDTH="25%">
<font color=black size=2 face=arial>
DAY1&nbsp;<input type=text size=10 name="Trgdate1" id="Trgdate1" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Trgdate1',1)"  onblur="ChangeColor('Trgdate1',2)">
</td>
<td align=center bgcolor=white WIDTH="25%">
<font color=black size=2 face=arial>
<?php $i++; //Now i=3?>DAY2&nbsp;
<input type=text size=10 name="Trgdate2" id="Trgdate2" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Trgdate2',1)"  onblur="ChangeColor('Trgdate2',2)" <?php echo $dis2;?>
</td>
<td align=center bgcolor=white WIDTH="25%">
<font color=black size=2 face=arial>
DAY3&nbsp;
<?php $i++; //Now i=4?>
<input type=text size=10 name="Trgdate3" id="Trgdate3" value="<?php echo $mvalue[$i]; ?>" style="font-family: Arial;background-color:white;color:black; font-size: 12px" maxlength=10 onfocus="ChangeColor('Trgdate3',1)"  onblur="ChangeColor('Trgdate3',2)" <?php echo $dis3;?>>
</td>
</tr>
<?php $i++; //Now i=5?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Select Venue</font></td><td align=left bgcolor=white COLSPAN="3">
<?php 
$objTrg_venue=new Trg_venue();
$objTrg_venue->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objTrg_venue->getRow();
?>
<select name=Venue_code style="font-family: Arial;background-color:white;color:black; font-size: 12px" onchange=redirect(6)>
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
<?php $i++; //Now i=6?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Hall Number</font></td><td align=left bgcolor=white COLSPAN="3">
<?php 

$objTrg_hall->setCondString(" venue_code=".$mvalue[5] ); //Change the condition for where clause accordingly
$row=$objTrg_hall->getRow();
?>
<select name=Hall_rsl style="font-family: Arial;background-color:white;color:black; font-size: 12px" onchange="redirect(7)">
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[6]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>&nbsp;Hall Capacity
<input type=text size=8 name="Hallcapacity" id="Hallcapacity" value="<?php echo $mvalue[8]; ?>" onfocus="ChangeFocus('Pr')"  onblur="ChangeColor('Hallcapacity',2)" readonly>
</td>
</tr>
<?php $i++; //Now i=7?>
<tr>
<td align=right bgcolor=white><font color=black size=2 face=arial>Timing</font></td><td align=left bgcolor=white COLSPAN="3">
<?php 
$objTrg_time=new Trg_time();
$objTrg_time->setCondString("1=1" ); //Change the condition for where clause accordingly
$row=$objTrg_time->getRow();
?>
<select name=Trgtime style="font-family: Arial;background-color:white;color:black; font-size: 12px" >
<?php $dval="0";?>
<option value="<?php echo $dval ;?>">-Select-
<?php 
for($ind=0;$ind<count($row);$ind++)
{
if ($mvalue[7]==$row[$ind][0])
echo "<option selected value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
else
echo "<option  value=".chr(34).$row[$ind][0].chr(34).">".$row[$ind][1];
}
?>
</select>
<font color=red size=3 face=arial>*</font>
</td>
</tr>
<?php $i++; //Now i=8?>

<?php $i++; //Now i=9?>
<tr>
<td align=right bgcolor=white WIDTH="25%"><font face=arial size=2>Enter Batch Size</font></td>
<td align=left bgcolor=white COLSPAN="3" WIDTH="75%">
<input type=text size=8 name="Micro" id="Micro" value="<?php echo $mvalue[9]; ?>" onfocus="ChangeFocus('Micro')"  onblur="ChangeColor('Micro',2)">
</td>
</tr>

   
        
<?php $i++; //Now i=14?>
<tr><td align=right bgcolor=white>

</td><td align=left bgcolor=white COLSPAN="3" WIDTH="75%">
<input type="hidden" name="Pdate" value="<?php echo $today;?>">
    <input type=button value="Select Trainee for Micro Observer"  name=Save onclick=validate()  style="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:blue;width:260px" <?php echo $lock?>>
&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="Menu"  name="hm" onclick=home()  style="font-family:arial;font-weight:bold; font-size: 14px ; background-color:red;color:black;width:60px">
</td></tr>

</table>
<?php
if($mtype==0) //Initial
echo $objUtility->focus("Phaseno");

if($mtype==1)//Postback from Phase No
echo $objUtility->focus("Trgdate1");



if($mtype==6)//Postback from Venue_code
echo $objUtility->focus("Hall_rsl");

if($mtype==7)//Postback from Hall
echo $objUtility->focus("Trgtime");


//if ($mtype==100)
//echo $objUtility->alert($_SESSION['msg']);
$st="";
?>
    
 
<table border=1 align=center cellpadding=2 cellspacing=0 style=border-collapse: collapse; width=100%>
<Thead>
<tr><td colspan=8 align=Center ><font face=arial size=2 color="blue">
<?PHP
echo "Available After First level Randomisation ".$objP->rowCount("Pollcategory=7 and Selected='Y'");
$cond="Slno in(Select Poling_id from Poling_training where Pcategory=7)";
$ss=$objP->rowCount($cond);
echo "<font face=arial size=2 color=red> Selected for Training ".$ss;
?>
        
</font></td></tr>
<tr>        
<tr><td colspan=8 align=Center bgcolor=#ccffcc><font face=arial size=2>Training Slot</font></td></tr>
<tr>
<td align=center><font face="arial" size="2">
Batch No
</td>
<td align=center><font face="arial" size="2">
Date
</td>
<td align=center><font face="arial" size="2">
Time
</td>
<td align=center><font face="arial" size="2">
Place
</td>
<td align=center><font face="arial" size="2">
Hall
</td>
<td align=center>
Remark
</td>
<td align=center colspan="2">
Click to View/Clear Batch in PDF
<input type="checkbox" name="mpdf">
</td>
</tr>
<?php
$microcond=" phaseno=3 and Groupno in(Select Groupno from poling_training where Pcategory=7 and Phaseno=3)";
$objTraining->setCondString($microcond);
$row=$objTraining->getAllRecord();
//echo $objTraining->returnSql;

//echo $objTraining->returnSql;
for($ii=0;$ii<count($row);$ii++)
{
?>
<tr>
<td align=center><font face="arial" size="2">
<?php
$tvalue=$row[$ii]['Groupno'];
echo $tvalue;
?>
</td>
<td align=left><font face="arial" size="2">
<?php
$tvalue=$row[$ii]['Trgdate1'];
if (strlen($row[$ii]['Trgdate2'])>0)
$tvalue=$tvalue.",".$row[$ii]['Trgdate2'];
if (strlen($row[$ii]['Trgdate3'])>0)
$tvalue=$tvalue." and ".$row[$ii]['Trgdate3'];

echo $tvalue;
?>
</td>
<td align=left><font face="arial" size="2">
<?php
$objTrg_time=new Trg_time();
$objTrg_time->setCode($row[$ii]['Trgtime']);
$objTrg_time->editRecord();
$tvalue=$objTrg_time->getTiming();
echo $tvalue;
?>
</td>
<td align=left><font face="arial" size="2">
<?php
$objTrg_venue=new Trg_venue();
$objTrg_venue->setVenue_code($row[$ii]['Venue_code']);
$objTrg_venue->editRecord();
$tvalue=$objTrg_venue->getVenue_name();
echo $tvalue;
?>
</td>
<td align=center><font face="arial" size="2">
<?php
$objTrg_hall=new Trg_hall();
$objTrg_hall->setRsl($row[$ii]['Hall_rsl']);
$objTrg_hall->setVenue_code($row[$ii]['Venue_code']);
$objTrg_hall->editRecord();
$tvalue=$objTrg_hall->getHall_number();
echo $tvalue;
?>
</td>
<td align=center><font face="arial" size="1">
<?php
$objT=new Poling_training();
$tvalue=$objT->countCategory($row[$ii]['Phaseno'], $row[$ii]['Groupno']);
echo $tvalue;
//echo $row[$ii]['Phaseno'];
?>
</td>
<td align="center" width="8%">
<input type=button value="View"  name=but1 onclick=proceed(1,<?php echo $row[$ii]['Groupno'];?>)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#99CCFF;color:black;width:60px" >
</td> 
<td align="center" width="8%">
<input type=button value="Clear"  name=but2 onclick=proceed(2,<?php echo $row[$ii]['Groupno'];?>)  style="font-family:arial;font-weight:bold; font-size: 12px ;font-weight:bold; background-color:#669999;color:black;width:60px" <?php echo $lock?>>
</td>
</tr>
<?php
}
?>
</table>
</form>     
<?php       
if ($mtype==100)    
echo $objUtility->alert($_SESSION['msg']); 
?>
<?php
//include("footer.htm");
?>  
</body>
</html>
