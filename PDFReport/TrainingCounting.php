<body>
<?php
//session_start();
//This Program uses Text File as Database Field
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
$objUtility=new Utility();

//if (isset($_GET['Lno']))
//$letterno   =$_GET['Lno'];  
//else
if(isset($_POST['catg']))
$phase=$_POST['catg'];
else
$phase=4;

//echo "phase".$phase;
$phase=4;
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

$mpdf=true;
//$mpdf=false;


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
if ($objP->isSelected4Trainee($prow[$j]['Slno'], $phase))    
{
$catg=$objUtility->CountCategory[$prow[$j]['Countcategory']];
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

$catg=$objUtility->CountCategory[$objP->getCountcategory];


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
$PageOrientation="P";  //Landscap

//$PageOrientation="L";  //Portrait


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
$pdf->SetFont('helvetica', '', 11);

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
$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;"  width="90%">
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
 <TR><td width="100%" align="left">$colvalue[3]</td></TR>
<TR><td width="100%" align="left">ID:&nbsp;&nbsp;$colvalue[4]</td></TR>    
 <TR><td width="100%" align="left">Poling Duty:&nbsp;&nbsp;$colvalue[5]</td></TR>
 <TR><td width="100%" align="left">Phone: $colvalue[10]</td></TR>
 </table>
EOD;



$tblbody=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;">
<TR><td width="100%" align="center">&nbsp;</td></TR>    
<tr>
<td align="left" width="100%" colspan=2>
Sub:- Training on  Counting of Votes
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
that you are drafted as <b>$colvalue[5]</b>&nbsp;for Counting of votes 
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
<td align="left" width="25%" height="35">&nbsp;</td>
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
<td align="left" width="25%" height="30"></td>
<td align="center" width="75%">&nbsp;</td>
</tr>
<tr>
<td align="left" width="25%" height="30"></td>
<td align="center" width="75%">&nbsp;</td>
</tr>
<tr>
<td align="left" width="25%" height="30"></td>
<td align="center" width="75%">
<b>
$msignature<br>$district
</b></td>
</tr>
<tr>
<td align="left" width="25%" height="30">
$break$break
</td>
</tr>
<tr>
<td align="left" colspan=2 width="100%">
<div align="justify">
<u>Training Batch No-<b>$grpno</b></u><br>
NB: Any change of date will be intimated at due time. Date of next Phase Training 
will be intimated later on. You are also requested to update Phone no at the time of signing 
on Attendance Sheet
</div>
</td>
</tr>
</table>
EOD;


$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td align="left" width="100%">
<div align="justify">
NB: Any change of date will be intimated at due time. Date of next Phase Training 
will be intimated later on. You are also requested to update Phone no at the time of signing 
on Attendance Sheet
</div>
</td>
</tr>
EOD;


$tblfdata=$topr.$title.$tblbody;

if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->writeHTML($tblfdata, true, false, false, false, '');
}
else
echo $tblfdata;


}   //end for loop



if($mpdf==true)
{
ob_end_clean();
$pdf->Output('bankletter.pdf', 'I');
}


?>
