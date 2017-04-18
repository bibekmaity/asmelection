<body>
<?php
session_start();
date_default_timezone_set("Asia/kolkata");

require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/class.poling.php';
require_once '../class/class.department.php';
require_once '../class/class.Poling_training.php';
require_once '../class/class.training.php';
require_once '../class/class.trg_hall.php';
require_once '../class/class.training_phase.php';
require_once '../class/class.category.php';
require_once '../class/class.Party_calldate.php';
require_once '../class/class.Repolgroup.php';
require_once '../class/utility.class.php';
require_once '../class/class.signimage.php';
$objImg=new Signimage();
$path=$objImg->LoadImage();  //Copy Image from Database to Directory

//$path="e:/wamp/www/election/pdfreport";

if(file_exists($path."/Deoseal.jpg"))
$deoseal="./Deoseal.jpg";
else
$deoseal="";

if(file_exists($path."/Roundseal.jpg"))
$roundseal="./Roundseal.jpg";
else
$roundseal="";


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


$objUtility=new Utility();

//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=1;
$rheight=48;


$cwidth=array();
$cwidth[0]="13%";
$cwidth[1]="29%";
$cwidth[2]="29%";
$cwidth[3]="29%";

$mpdf=true;
//$mpdf=false;


$pdf = new TCPDF($PageOrientation, PDF_UNIT, $PageFormat, true, 'UTF-8', false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);
//$pdf->SetFont('helvetica', 'B', 20);

$tblfdata="";
$calldate="";
$objPc=new Party_calldate();
$objPc->setCode(1);
if($objPc->EditRecord())
{    
$polldate=$objPc->getRepoldate();
$calldate=$objPc->getMydate1();
$station=$objPc->getAssemble_place();
$starttime=$objPc->getPoll_starttime();
$endtime=$objPc->getPoll_endtime();
$mplace=$objPc->getMplace();
$mdate=$objPc->getMdate();
$msignature=$objPc->getMsignature()."<br>".$objPc->getEdistrict();
}
else
{
$polldate="06/02/2013";
$station="Govt Gurdon HSS, Nalbari";
$starttime="7 am";
$endtime="3 pm";
$mplace="Nalbari";
$mdate="/   /";
$msignature="";
}

$cspan=4;

$dt=date('d-M-Y h:i A');

$trow=array();
$mainrow=array();
$objTrg=new Training();
$objP=new Poling();
$objPg=new Repolgroup();
$index=0;

//for Group APP

if(isset($_POST['Code']))
$laccode=$_POST['Code'];
else
$laccode=0;



$cond=("1=1");
$objPg->setCondString($cond);
$prow=$objPg->getAllRecord();
$index=0;
$page=0;
for($mind=0;$mind<count($prow);$mind++)
{
$objUtility->UserPresent();
$pr=$prow[$mind]['Prno'];
$p1=$prow[$mind]['Po1no'];
$p2=$prow[$mind]['Po2no'];
$p3=$prow[$mind]['Po3no'];
$p4=$prow[$mind]['Po4no'];

$rcode="Repol";


$trgrp=0;   
$page++;
$mainrow[$index]['Page']=$page;
//$mainrow[$index]['Slno']=$Slno;
$mainrow[$index]['Slno']=0;
//$mainrow[$index]['Grp']=$grp;
$mainrow[$index]['Grp']=0;
$mainrow[$index]['Calldate']=$calldate;
//$mainrow[$index]['Catg']=$catg;
$mainrow[$index]['Catg']=0;
$mainrow[$index]['Code']=$rcode; 

$Slno=0;

$mainrow[$index]['PR']=$objP->PolingDetail4APP($pr,$Slno);
$mainrow[$index]['P1']=$objP->PolingDetail4APP($p1,$Slno);
$mainrow[$index]['P2']=$objP->PolingDetail4APP($p2,$Slno);
$mainrow[$index]['P3']=$objP->PolingDetail4APP($p3,$Slno);
$mainrow[$index]['P4']=$objP->PolingDetail4APP($p4,$Slno);

$mainrow[$index]['pr']=-1;
$mainrow[$index]['p1']=-1;
$mainrow[$index]['p2']=-1;
$mainrow[$index]['p3']=-1;
$mainrow[$index]['p4']=-1;

$mainrow[$index]['Department']="";
$mainrow[$index]['tGrp']=0;    
$index++;
}//for loop $objPg

//End Group APP


$topr=<<<EOD
<p align="right">
<b><u>Election Urgent</u></b>
</p>
EOD;


$tblfdata="";

$title=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;" width="100%">
<tr>
<td colspan=$cspan  align="center" width="100%">
    ANNEXURE-XI<br>
    (CHAPTER III, PARA 10.1)<br>
ORDER OF APPOINTMENT FOR PRESIDING AND POLING OFFICER
</td>
</tr>
<tr>
<td colspan=$cspan   align="left" width="100%">
(To be made in duplicate at General Election)
</td>
</tr>
<td colspan="$cspan"   align="left" width="100%">
General Election  2014 to the House of the people...
</td>
</tr>
<td colspan="$cspan"   align="left" width="100%">
Legislative Assembly of  
</td>
</tr>
<tr>
<td colspan="$cspan"   align="left" width="100%">
<div align="justify">
<br>
In pursuance of sub-section(1) and sub-section(3) of section 26 
of the Representation of the People-Act,1963(43 of 1951),
I hereby appoint the officers specified in column 2 and 3 of 
the table below as Presiding Officer and Polling Officers 
respectively for the Polling station specified in the 
corresponding entry in column1 of the table provided by me
for Assembly Constituency/forming part of Parliamentary 
Constituency. 
</div>
</td>
</tr>
<tr>
<td colspan="$cspan"   align="left" width="100%">
<br>
<div align="justify">
I also authorize the Polling Officer specified in column 4 of 
the Table against that entry to perform the functions of the Presiding 
Officer during the unavoidable 
absence, if any of the Presiding Officer.
</div>
</td>
</tr>
</table>
EOD;
$tblhead=<<<EOD
<table cellpadding="3" cellspacing="0" bordercolor="#000000" border="1"  style="vertical-align:middle;">
<tr>
<td colspan=$cspan  align="center">
<br>TABLE
</td>
</tr>
<tr>
<td align="center" width="$cwidth[0]">
 Polling Station Number and Name with complete 
 particular of its location 
</td>
<td align="center" width="$cwidth[1]">
 Name of the Presiding Officer</td>
<td align="center" width="$cwidth[2]">
 Name of Polling Officers
</td>
<td align="center" width="$cwidth[3]">
Polling officer authorized to 
perform the function of the presiding officer in the latter's 
absence    
</td>
</tr>
EOD;

$tblbottom=<<<EOD
</table>
EOD;

$ddosign=<<<EOD
<p align="center">
<img border="0" src="$deoseal" width="120" height="30">
<br>
<b>$msignature</b>
</p>
EOD;



$rowcount=0;
$colvalue=array();
//Initialise Total Variable

$tick="";

//Seting Page group

$pagecount=0;
    
$i=1;

$rowmain=array();
$rowmain=$mainrow;
   









$colvalue=array();
//start Actual Loop
for($ind=0;$ind<count($mainrow);$ind++)
{
// Tick mark for Presiding
if($mainrow[$ind]['Slno']==$mainrow[$ind]['pr'])
{
$img1=<<<EOD
<img border=0 src="../image/tick.jpg" width="20" height="20">
EOD;
}
else
$img1="&nbsp;";

// Tick mark for First Poling
if($mainrow[$ind]['Slno']==$mainrow[$ind]['p1'])
{
$img2=<<<EOD
<img border=0 src="../image/tick.jpg" width="20" height="20">
EOD;
}
else
$img2="&nbsp;";

// Tick mark for Second Poling
if($mainrow[$ind]['Slno']==$mainrow[$ind]['p2'])
{
$img3=<<<EOD
<img border=0 src="../image/tick.jpg" width="20" height="20">
EOD;
}
else
$img3="&nbsp;";

// Tick mark for Third Poling
if($mainrow[$ind]['Slno']==$mainrow[$ind]['p3'])
{
$img4=<<<EOD
<img border=0 src="../image/tick.jpg" width="20" height="20">
EOD;
}
else
$img4="&nbsp;";

// Tick mark for Forth Poling
if($mainrow[$ind]['Slno']==$mainrow[$ind]['p4'])
{
$img5=<<<EOD
<img border=0 src="../image/tick.jpg" width="20" height="20">
EOD;
}
else
$img5="&nbsp;";

//End Tick Mark Image


$colvalue[0]=$mainrow[$ind]['Code'];
$colvalue[1]=$mainrow[$ind]['PR'];
if ($mainrow[$ind]['Catg']=="Y")
$colvalue[3]=$mainrow[$ind]['P1'];
else
$colvalue[3]="";

$colvalue[2]=$img2."<br>".$mainrow[$ind]['P1'];
$colvalue[2]=$colvalue[2]."<br>$img3<br>".$mainrow[$ind]['P2'];
$colvalue[2]=$colvalue[2]."<br>$img4<br>".$mainrow[$ind]['P3'];
$colvalue[2]=$colvalue[2]."<br>$img5<br>".$mainrow[$ind]['P4'];

$tbldata=<<<EOD
<tr>
<td align="center"><br><br><br><b>$colvalue[0]</b></td>
<td align="left">$img1<br>$colvalue[1]</td>
<td align="left">$colvalue[2]</td>
<td align="left">$colvalue[3]</td>
</tr>
</table>
EOD;

$calldate=$mainrow[$ind]['Calldate'];
$tblfoot=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;" width="100%">
<tr>
<td colspan="2"  align="center" width="100%">
<br>
<div align="justify">
The repoll will be taken on $polldate during 
the hours $starttime to $endtime  The Presiding Officer should
arrange to collect the Polling materials from 
<b>$station</b> on <b>$calldate</b> before $starttime 
 and after the poll,these should be returned to collecting 
 center at <b>$station</b> on the same day.</div>   
</td>
</tr>
<tr>
<td  align="left" width="60%">
<br><br>
Place: $mplace
<br>
Date: $mdate<br>
<img border="0" src="$roundseal" width="100" height="100">
</td>
<td  align="right" width="40%">
$ddosign
</td>
</tr>
</table>
EOD;

$trgrp=$mainrow[$ind]['tGrp'];
if ($trgrp>0)
{
$Date=$mainrow[$ind]['tDate'];
$Time=$mainrow[$ind]['Time'];
$Place=$mainrow[$ind]['Place'];
$Hall=$mainrow[$ind]['Hall'];
$training=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  align="center" style="vertical-align:middle;" width="100%">
<tr>
<td align="left" width="100%" colspan="2"><u><b>Training</b></u></td>
</tr>
<tr>
<td align="left" colspan="2">
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="1"  align="center" style="vertical-align:middle;" width="100%">
<tr>
<td align="center" width="20%">Date</td>
<td align="center" width="20%">Time</td>
<td align="center" width="35%">Place</td>
<td align="center" width="25%">Hall/Room</td>
</tr>
<tr>
<td align="center"  width="20%"><b>$Date</b></td>
<td align="center"  width="20%"><b>$Time</b></td>
<td align="center" width="35%"><b>$Place</b></td>
<td align="center" width="25%"><b>$Hall</b></td>
</tr>
</table>
</td>
</tr>
<tr>
<td  width="60%">
&nbsp;
</td>
<td  width="40%"> 
<br>
$ddosign
</td>
</tr>
</table>
EOD;
}
else
$training="&nbsp;";

$department=$mainrow[$ind]['Department'];
$Slno=$mainrow[$ind]['Slno'];
$BEEO=$objP->BEEO($Slno);
if(strlen($BEEO)>1)
$BEEO="(".$BEEO.")";
$page=$mainrow[$ind]['Page'];
$dept=<<<EOD
<table border=0 width="100%">
<tr><td width="100%" colspan=2 align="center">
<hr>
</td></tr>
<tr><td width="85%" align="left">
<b>$department$BEEO</b>(Poling Id-$Slno)<br>Computer Generated Document $uid Dated $dt $ClientIP$sid
</td>
<td width="15%" align="right">Page-$page</td>
</tr>
</table>
EOD;


if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML($topr.$title, true, false, false, false, '');
$pdf->SetFont('helvetica', '', 8);
$pdf->writeHTML($tblhead.$tbldata, true, false, false, false, '');

//$pdf->writeHTML($tbldata, true, false, false, false, '');

$pdf->writeHTML($tblfoot, true, false, false, false, '');

$pdf->writeHTML($training, true, false, false, false, '');

$pdf->writeHTML($dept, true, false, false, false, '');

$pdf->SetFont('helvetica', '', 9);
//$pdf->SetFont('helvetica', '', 9);
}
else
echo $title.$tblhead.$tbldata.$tblfoot.$training.$dept;
   
}

if ($mpdf==true)
{
ob_end_clean();
$pdf->Output('report.pdf', 'I');
}

?>
