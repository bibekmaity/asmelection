﻿<body>
<?php
session_start();
require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');
require_once './class/class.poling.php';
require_once './class/class.department.php';
require_once './class/class.Poling_training.php';
require_once './class/class.training.php';
require_once './class/class.trg_hall.php';
require_once './class/class.training_phase.php';
require_once './class/class.category.php';
require_once './class/class.Party_calldate.php';
require_once './class/class.Polinggroup.php';

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

$objPc=new Party_calldate();
$objPc->setCode(1);
if($objPc->EditRecord())
{    
$polldate=$objPc->getPolldate();  
$station=$objPc->getAssemble_place();
$starttime=$objPc->getPoll_starttime();
$endtime=$objPc->getPoll_endtime();
$mplace=$objPc->getMplace();
$mdate=$objPc->getMdate();
$msignature=$objPc->getMsignature();
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

$dt=date('d-M-Y');

//retrive Perong data from text File
if (isset($_POST['totdep']))
$tot=$_POST['totdep'];  
else
$tot=0;


$phase=2;

$trow=array();
$mainrow=array();
$objTrg=new Training();
$objP=new Poling();
$objPg=new Polinggroup();
$index=0;

for($ind=1;$ind<=$tot;$ind++)
{
$Dep="Dep".$ind;

if (isset($_POST[$Dep]))
{
$page=0;    
$dcode=$_POST[$Dep];
//echo $dcode."<br>";
$prow=$objP->getList($dcode);   
for($j=0;$j<count($prow);$j++)    
{
if ($prow[$j]['Grpno']>0)  //selected for group   
{
$page++;    
$Slno=$prow[$j]['Slno'];
$catg=$prow[$j]['Selected'];
$grp=$prow[$j]['Grpno'];

$objPg->setGrpno($grp);
if ($objPg->EditRecord())
{
$pr=$objPg->getPrno();
$p1=$objPg->getPo1no();
$p2=$objPg->getPo2no();
$p3=$objPg->getPo3no();
$p4=$objPg->getPo4no();

if ($objPg->getReserve()=="N")
$rcode=$objPg->getRcode();
else
$rcode="Reserve";

$calldate=$objPg->getAdvance();
$objPc->setCode($calldate);
if ($objPc->EditRecord())
$calldate=$objPc->getMydate();
else 
$calldate="";

if ($objP->isSelected4Trainee($Slno, 2))
$trgrp= $objPg->getTrggroup (); 
else
$trgrp=0;   
}
else
header('Location:Selectdep4app.php');
$mainrow[$index]['Page']=$page;
$mainrow[$index]['Slno']=$Slno;
$mainrow[$index]['Grp']=$grp;
$mainrow[$index]['Calldate']=$calldate;
$mainrow[$index]['Catg']=$catg;
$mainrow[$index]['Code']=$rcode; 

$mainrow[$index]['PR']=$objP->PolingDetail4APP($pr,$Slno);
$mainrow[$index]['P1']=$objP->PolingDetail4APP($p1,$Slno);
$mainrow[$index]['P2']=$objP->PolingDetail4APP($p2,$Slno);
$mainrow[$index]['P3']=$objP->PolingDetail4APP($p3,$Slno);
$mainrow[$index]['P4']=$objP->PolingDetail4APP($p4,$Slno);
$mainrow[$index]['Department']=$prow[$j]['Department'];
if ($trgrp>0)
{
$trow=$objTrg->getTrainingDetail($Slno, $phase);
$mainrow[$index]['Place']=$trow['Trgplace'];
$mainrow[$index]['Hall']=$trow['Hallno'];
$mainrow[$index]['Time']=$trow['Trgtime']; 
$mainrow[$index]['tDate']=$trow['Trgdate']; 
$mainrow[$index]['tGrp']=$trow['Groupno']; 
}
else
$mainrow[$index]['tGrp']=0;    
$index++;
}//if selected for Group
}//$j++
} //if
}//for loop


//For Individau APP by ID
if( isset($_GET['id']))
{ 
if(is_numeric($_GET['id']))    
$Slno=$_GET['id'];
else
$Slno=0;
$objP->setSlno($Slno);

if($objP->EditRecord() && $objP->getGrpno()>0)
{
$catg=$objP->getSelected();
$grp=$objP->getGrpno();

$objPg->setGrpno($grp);
if ($objPg->EditRecord())
{
$pr=$objPg->getPrno();
$p1=$objPg->getPo1no();
$p2=$objPg->getPo2no();
$p3=$objPg->getPo3no();
$p4=$objPg->getPo4no();

if ($objPg->getReserve()=="N")
$rcode=$objPg->getRcode();
else
$rcode="Reserve";

$calldate=$objPg->getAdvance();
$objPc->setCode($calldate);
if ($objPc->EditRecord())
$calldate=$objPc->getMydate();
else 
$calldate="";

if ($objP->isSelected4Trainee($Slno, 2))
$trgrp= $objPg->getTrggroup (); 
else
$trgrp=0;   
}
else
header('Location:Selectdep4app.php');

$mainrow[0]['Page']=1;
$mainrow[0]['Slno']=$Slno;
$mainrow[0]['Grp']=$grp;
$mainrow[0]['Calldate']=$calldate;
$mainrow[0]['Catg']=$catg;
$mainrow[0]['Code']=$rcode; 

$mainrow[0]['PR']=$objP->PolingDetail4APP($pr,$Slno);
$mainrow[0]['P1']=$objP->PolingDetail4APP($p1,$Slno);
$mainrow[0]['P2']=$objP->PolingDetail4APP($p2,$Slno);
$mainrow[0]['P3']=$objP->PolingDetail4APP($p3,$Slno);
$mainrow[0]['P4']=$objP->PolingDetail4APP($p4,$Slno);
$mainrow[0]['Department']=$objP->getDepartment();
if ($trgrp>0)
{
$trow=$objTrg->getTrainingDetail($Slno, $phase);
$mainrow[0]['Place']=$trow['Trgplace'];
$mainrow[0]['Hall']=$trow['Hallno'];
$mainrow[0]['Time']=$trow['Trgtime']; 
$mainrow[0]['tDate']=$trow['Trgdate']; 
$mainrow[0]['tGrp']=$trow['Groupno']; 
}
else
$mainrow[0]['tGrp']=0;    
}//$objP->EditRecord()
else
header('Location:Selectdep4app.php');
} //isset($_GET[id]


//end Individual


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
General Bye-election  2014 to the House of the people...
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
<p align="center"><br>
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
$colvalue[0]=$mainrow[$ind]['Code'];
$colvalue[1]=$mainrow[$ind]['PR'];
if ($mainrow[$ind]['Catg']=="Y")
$colvalue[3]=$mainrow[$ind]['P1'];
else
$colvalue[3]="";

$colvalue[2]=$mainrow[$ind]['P1'];
$colvalue[2]=$colvalue[2]."<br><br>".$mainrow[$ind]['P2'];
$colvalue[2]=$colvalue[2]."<br><br>".$mainrow[$ind]['P3'];
$colvalue[2]=$colvalue[2]."<br><br>".$mainrow[$ind]['P4'];

$tbldata=<<<EOD
<tr>
<td align="center"><br><br><br><b>$colvalue[0]</b></td>
<td align="left">$colvalue[1]</td>
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
The poll will be taken on $polldate during 
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
Date: $mdate
</td>
<td  align="right" width="40%">
<br>
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
<br><br>
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
$page=$mainrow[$ind]['Page'];
$dept=<<<EOD
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<table border=0 width="100%">
<tr><td width="100%" colspan=2 align="center">
<hr>
</td></tr>
<tr><td width="85%" align="left">
<b>$department</b>(Poling Id-$Slno)<br>Computer generated document dated $dt
</td>
<td width="15%" align="right">Page-$page</td>
</tr>
</table>
EOD;


if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->SetFont('helvetica', '', 9);
$pdf->writeHTML($title, true, false, false, false, '');
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
