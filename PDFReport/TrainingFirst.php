<body>
<?php
session_start();
//This Program uses Text File as Database Field
date_default_timezone_set("Asia/kolkata");

require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/utility.class.php';
require_once '../class/class.poling.php';
require_once '../class/class.department.php';
require_once '../class/class.Poling_training.php';
require_once '../class/class.training.php';
require_once '../class/class.trg_hall.php';
require_once '../class/class.training_phase.php';
require_once '../class/class.category.php';
require_once '../class/class.signimage.php';
require_once '../class/class.party_calldate.php';

if (isset($_SERVER['REMOTE_ADDR']))
$ClientIP=" From IP- ".$_SERVER['REMOTE_ADDR'];
else
$ClientIP="";


if (isset($_SESSION['uid']))
$uid="By ".$_SESSION['uid'];
else
$uid="";

if (isset($_SESSION['sid']))
$sid="(Session ID-".$_SESSION['sid'].")";
else
$sid="";

$dt=date('d/m/Y h:i:s a');

//$objPc=new Party_calldate();
//$objPc->setCode(1);
//if($objPc->EditRecord())
//{
//$officer=$objPc->getMsignature();
//$district=$objPc->getEdistrict();
//}
//else
//{
//$officer="Signature of officer";
//$district="District Name";
//}


$objImg=new Signimage();
$objImg->LoadImage();
$path=$objImg->LoadImage();  //Copy Image from Database to Directory

if(file_exists($path."/Deoseal.jpg"))
$deoseal="./Deoseal.jpg";
else
$deoseal="";

if(file_exists($path."/Roundseal.jpg"))
$roundseal="./Roundseal.jpg";
else
$roundseal="";


$objUtility=new Utility();


if(isset($_POST['mpdf']))
$mpdf=true;
else
$mpdf=false;

$mpdf=true;

//if (isset($_GET['Lno']))
//$letterno   =$_GET['Lno'];  
//else
if(isset($_POST['catg']))
$phase=$_POST['catg'];
else
$phase=1;

//echo "phase".$phase;
$phase=1;

$objTphase=new Training_phase();
$objTphase->setPhase_no($phase);
if ($objTphase->EditRecord())
{
$letterno   =$objTphase->getLetterno();
$letterdate   =$objUtility->to_date($objTphase->getLetter_date());
$msignature=$objTphase->getSignature();
$uoffice=strtoupper($msignature);
$udistrict=strtoupper($objTphase->getElection_district ());
$district=$objTphase->getElection_district ();
}
else
{
$letterno   ="NEL.ELE/2013/";
$letterdate   ="12/11/2013";
$msignature="District Election Officer<br>Nalbari";  
$district="Nalbari";  
}    





if (isset($_POST['totdep']))
$tot=$_POST['totdep'];  
else
$tot=0;



$trow=array();
$mainrow=array();
$objTrg=new Training();
$objP=new Poling();

$index=0;
for($ind=1;$ind<=$tot;$ind++)
{
$Dep="Dep".$ind;
if (isset($_POST[$Dep]))
{
$dcode=$_POST[$Dep];
//echo $dcode."<br>";
$prow=$objP->getList($dcode);   
for($j=0;$j<count($prow);$j++)    
{
$objUtility->UserPresent();
if ($objP->isSelected4Trainee($prow[$j]['Slno'], $phase))    
{
$objCat=new Category();
$objCat->setCode($prow[$j]['Pollcategory']);
if ($objCat->EditRecord())
$catg=$objCat->getName ();
else 
$catg="";

$mainrow[$index]['Name']=$prow[$j]['Name']; 
$mainrow[$index]['Designation']=$prow[$j]['Desig'];  
$mainrow[$index]['Address']=$prow[$j]['Placeofresidence'];; 
$mainrow[$index]['Department']=$prow[$j]['Department']; 
$mainrow[$index]['Slno']=$prow[$j]['Slno']; 
$mainrow[$index]['Duty']=$catg; 
$mainrow[$index]['Phone']=$prow[$j]['Phone']; 

$trow=$objTrg->getTrainingDetail($prow[$j]['Slno'], $phase);
$mainrow[$index]['Place']=$trow['Trgplace'] ;
$mainrow[$index]['Hall']=$trow['Hallno'];
$mainrow[$index]['Time']=$trow['Trgtime']; 
$mainrow[$index]['tDate']=$trow['Trgdate']; 
$mainrow[$index]['Grp']=$trow['Groupno']; 
$index++;
//echo $prow[$j]['Slno']." Selected<br>";
}//if selected for terainee
//else
//echo $prow[$j]['Slno']." Not Selected<br>";
}//$j++
} //if
}//for loop



//For Individau APP by ID
if(isset($_GET['id']))
{
if(is_numeric($_GET['id']))    
$Slno=$_GET['id'];
else
$Slno=0;
$objP->setSlno($Slno);

if ($objP->EditRecord() && $objP->isSelected4Trainee($Slno, $phase))    
{
$objCat=new Category();
$objCat->setCode($objP->getPollcategory());
if ($objCat->EditRecord())
$catg=$objCat->getName();
else 
$catg="";

$mainrow[0]['Name']=$objP->getName(); 
$mainrow[0]['Designation']=$objP->getDesig(); 
$mainrow[0]['Address']=$objP->getPlaceofresidence(); 
$mainrow[0]['Department']=$objP->getDepartment(); 
$mainrow[0]['Slno']=$Slno; 
$mainrow[0]['Duty']=$catg; 
$mainrow[0]['Phone']=$objP->getPhone(); 

$trow=$objTrg->getTrainingDetail($Slno, $phase);
$mainrow[0]['Place']=$trow['Trgplace'] ;
$mainrow[0]['Hall']=$trow['Hallno'];
$mainrow[0]['Time']=$trow['Trgtime']; 
$mainrow[0]['tDate']=$trow['Trgdate']; 
$mainrow[0]['Grp']=$trow['Groupno']; 
$index++;
//echo $prow[$j]['Slno']." Selected<br>";
}//if selected for terainee
else
header('location:SelectDep4Trg.php') ;   
}//isset(id)


//End Individual ID



//$PageFormat="FANFOLD15X12";  //Large Page 15x12
//$PageFormat="LEGAL";  //8.5x14
$PageFormat="A4";  //8.5x11
$PageOrientation="P";  //Portrait

//$PageOrientation="L";  //Landscap


$rheight=18;

$cwidth=array();
$cwidth[0]="10%";
$cwidth[1]="50%";
$cwidth[2]="20%";
$cwidth[3]="20%";


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
$pdf->setPrintFooter(false);
//$pdf->SetFont('helvetica', 'B', 20);
$pdf->SetFont('helvetica', '', 10);

$break=<<<EOD
<p align="center">
&nbsp;
</p>
EOD;

$topr=<<<EOD
<p align="right">
<b><u>Election Urgent</u></b>
</p>
EOD;

$colvalue=array();
for ($i=0;$i<count($mainrow);$i++)
{
$colvalue[0]=$mainrow[$i]['Name'];
$colvalue[1]=$mainrow[$i]['Designation'] ;
$colvalue[2]=$mainrow[$i]['Address'];
$colvalue[3]=$mainrow[$i]['Department'];
$colvalue[4]=$mainrow[$i]['Slno'];
$colvalue[5]=$mainrow[$i]['Duty'];
$colvalue[6]=$mainrow[$i]['Place'];
$colvalue[7]=$mainrow[$i]['Hall'];
$colvalue[8]=$mainrow[$i]['Time'];
$colvalue[9]=$mainrow[$i]['tDate'];
$colvalue[10]=$mainrow[$i]['Phone'];
$grpno=$mainrow[$i]['Grp'];

$BEEO=$objP->BEEO($colvalue[4]);
if(strlen($BEEO)>2)
$BEEO="<br>C/o ".$BEEO;

$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;"  width="90%">
 <tr>
<td align="center"  width="100%">
<img src="../image/ashoka.jpg" width="60" height="80">
</td>
</tr>
<TR><td width="100%" align="center">GOVT. OF ASSAM</td></TR>    
 <TR><td width="100%" align="center">OFFICE OF THE $uoffice:::::::::$udistrict</td></TR>    
  <TR><td width="100%" align="center">(PERSONNEL CELL)</td></TR>    
 <TR><td width="100%" align="center">&nbsp;</td></TR> 
<TR><td width="70%" align="left">No.$letterno </td>
<td width="30%" align="center">Date:$letterdate</td> 
</TR>    
 <TR><td width="100%" align="center">&nbsp;</td></TR>    
 <TR><td width="100%" align="left">To,</td></TR>
<TR><td width="100%" align="left">$colvalue[0]</td></TR>
<TR><td width="100%" align="left">$colvalue[1]</td></TR>
 <TR><td width="100%" align="left">Address:&nbsp;&nbsp;$colvalue[2]</td></TR>    
 <TR><td width="100%" align="left">$colvalue[3]&nbsp;$BEEO</td></TR>
<TR><td width="100%" align="left">Poling ID:&nbsp;&nbsp;$colvalue[4]</td></TR>    
 <TR><td width="100%" align="left">Poling Duty:&nbsp;&nbsp;$colvalue[5]</td></TR>
 <TR><td width="100%" align="left">Phone: $colvalue[10]</td></TR>
 </table>
EOD;



$tblbody=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<TR><td width="100%" align="center">&nbsp;</td></TR>    
<tr>
<td align="left" width="100%" colspan=2>
Sub:- Training on EVM/briefing on ECI Guidelines
</td>
</tr>
<tr>
<td align="left" width="100%" colspan=2>
Sir
</td>
</tr>
<tr>
<td align="left" width="100%" colspan=2>
<div align="justify" style="line-height:2">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
With reference to the above, it is for your information 
that you are drafted as <b>$colvalue[5]</b>&nbsp; 
in the forthcoming General Election to the Parliamentary Election,2014.
You are therefore, requested to attend the training to be held on the date, time
and venue mentioned below without fail.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 Matter is election urgent.
</div>
</td>
</tr>
<tr>
<td align="left" width="25%" height="35">Date:</td>
<td align="left" width="50%"><b>$colvalue[9]</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30">Time:</td>
<td align="left" width="50%"><b>$colvalue[8]</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30">Venue:</td>
<td align="left" width="50%"><b>$colvalue[6]</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30">Hall/Room:</td>
<td align="left" width="50%"><b>$colvalue[7]</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30" rowspan="3"><img border="0" src="$roundseal" width="250" height="150"></td>
<td align="center" width="75%">&nbsp;</td>
</tr>
<tr>
<td align="center" width="75%"><img border="0" src="$deoseal" width="120" height="50"></td>
</tr>
<tr>
<td align="center" width="75%">
<b>
$msignature<br>$district
</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30">
$break
</td>
</tr>
</table>
EOD;

$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<tr>
<td align="left" colspan=2 width="100%">
<div align="justify">
<u>Training Batch No-<b>$grpno</b></u><br>
NB: All Poling Officers are requested to update their Mobile Number at the time of signing 
on Attendance Sheet.<br><br>
<font color="grey">Computer Generated Document $uid Dated $dt $ClientIP $sid</font>
</div>
</td>
</tr>
</table>
EOD;




$tblfdata=$topr.$title.$tblbody;

if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($tblfdata, true, false, false, false, '');
$pdf->SetFont('helvetica', '', 8);
$pdf->writeHTML($tblfoot, true, false, false, false, '');
}
else
{
echo $tblfdata;
echo $tblfoot;
}

}   //end for loop



if($mpdf==true)
{
ob_end_clean();
$pdf->Output('bankletter.pdf', 'I');
}


?>
