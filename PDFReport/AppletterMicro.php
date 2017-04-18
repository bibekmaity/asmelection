<body>
<?php
session_start();
require_once('../../tcpdf/config/lang/eng.php');
require_once('../../tcpdf/tcpdf.php');
require_once '../class/class.poling.php';
//require_once '../class/class.department.php';
//require_once '../class/class.Poling_training.php';
//require_once '../class/class.training.php';
//require_once '../class/class.trg_hall.php';
require_once '../class/class.training_phase.php';
//require_once '../class/class.category.php';
require_once '../class/class.Party_calldate.php';
require_once '../class/class.Microgroup.php';
require_once '../class/class.Psname.php';
require_once '../class/utility.class.php';

//$PageFormat="FANFOLD15X12";  //Large Page 15x12
$PageFormat="LEGAL";  //8.5x14
//$PageFormat="A4";  //8.5x11

//$PageOrientation="L";  //Landscap
$PageOrientation="P";  //Portrait

$mrows=1;
$rheight=48;

$objUtility=new Utility();
$objPs=new Psname();
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
$assembleplace=$objPc->getAssemble_place();
$reportplace=$assembleplace;
$starttime=$objPc->getPoll_starttime();
$endtime=$objPc->getPoll_endtime();
$mplace=$objPc->getMplace();
$mdate=$objPc->getMdate();
$msignature=$objPc->getMsignature()."<br>".$objPc->getEdistrict();
}
else
{
$polldate="06/02/2013";
$assembleplace="Govt Gurdon HSS, Nalbari";
$reportplace="Govt Gurdon HSS, Nalbari";
$starttime="7 am";
$endtime="3 pm";
$mplace="Nalbari";
$mdate="/   /";
$msignature="";
}

$objTphase=new Training_phase();
$objTphase->setPhase_no(3);
if ($objTphase->EditRecord())
{
$letterno   =$objTphase->getLetterno();
$letterdate   =$objUtility->to_date($objTphase->getLetter_date());
$udistrict=strtoupper($objTphase->getElection_district ());
$district=$objTphase->getElection_district ();
}
else
{
$letterno   ="NEL.ELE/2013/";
$letterdate   ="12/11/2013";
$msignature="District Election Officer<br>Nalbari";  
$district="Nalbari";
$udistrict="NALBARI";
}    


//YOU MAY uncommenet following to HARD CODE data
//$polldate="06/02/2013";
//$assembleplace="Govt Gurdon HSS, Nalbari";
//$reportplace="Govt Gurdon HSS, Nalbari";
$reporttime="5 AM";
//$mplace="Nalbari";
//$mdate="20/4/2009";
//$msignature="DEO NALBARI";

//END HARD CODE







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

$objP=new Poling();
$objPg=new Microgroup();
$index=0;

//For Individau APP by ID
if( isset($_GET['id']))
{ 
if(is_numeric($_GET['id']))    
$Slno=$_GET['id'];
else
$Slno=0;
$cond="Pollcategory=7 and grpno>0 and Slno=".$Slno;
$mainrow=$objP->getMicroList($cond);
} //isset($_GET[id]
else
{
$dcode="(";
for($ind=1;$ind<=$tot;$ind++)
{
$Dep="Dep".$ind;
if (isset($_POST[$Dep]))
$dcode=$dcode.$_POST[$Dep].",";
} //for loop
$dcode=$dcode."0)";
$cond=" Pollcategory=7 and grpno>0 and Depcode in ".$dcode." order by Depcode,Slno";
$mainrow=$objP->getMicroList($cond);
}//isset($_GET['id']

//end Individual

$tblfdata="";


$ddosign=<<<EOD
<table border="0" width="100%">
<tr><td width="60%">&nbsp;
</td>
<td width="40%" align="center"><b>$msignature</b>
</td>
</tr>
</table>
EOD;

$blankrow=<<<EOD
<tr><td width="100%"><p align="center">&nbsp;</p>
</td>
</tr>
EOD;

$rowcount=0;
$colvalue=array();
//Initialise Total Variable

$tick="";

//Seting Page group

$pagecount=0;
    
$i=1;


$colvalue=array();
//start Actual Loop
$objLac=new Lac();
for($ind=0;$ind<count($mainrow);$ind++)
{
//START
$name=$mainrow[$ind]['Name'];
$slno=$mainrow[$ind]['Slno'];
$desig=$mainrow[$ind]['Desig'];
$depart=$mainrow[$ind]['Department'];
$phone=$mainrow[$ind]['Phone'];
if(strlen($phone)>=10)
$phone="Phone-".$phone;
 else 
$phone="";

$objPg->setGrpno($mainrow[$ind]['Grpno']);
if($objPg->EditRecord())
{
$laccode=$objPg->getLac();
$ps=$objPg->getMicropsno();
if($ps==0)
{
if($objLac->MicrogroupStatus($laccode)<5)  
$pslist="Group Code-".$mainrow[$ind]['Grpno'];
else
$pslist="Reserve" ;   
}



$objLac->setCode($laccode);
if($objLac->EditRecord())
$lac=$laccode."-".$objLac->getName();

$psrow=$objPs->getMicroPsList($ps);

$i=count($psrow);

if($ps>0)
{
$pslist="";
if($objLac->MicrogroupStatus($laccode)>4)
{
for($j=0;$j<count($psrow);$j++)
{
$pslist=$pslist.$psrow[$j]['Part_no'] ;
if($i>1)
$pslist=$pslist.",";
$i--;
}//for loop
}//($objLac->MicrogroupStatus
else
$pslist="Group Code-".$mainrow[$ind]['Grpno'];
}  // $ps>0  
}//objPg->editrecotd
 

//$lac="61 Dharmapur";
//$pslist="1,2,3";

$myarea=<<<EOD
<table border="0" width="100%">
<tr><td width="30%" align="left">
Name of LA Constituency
</td>
<td width="70%" align="left"><b>:$lac</b>
</td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td width="30%" align="left">
Poling Station Numbers
</td>
<td width="70%" align="left">
:<b>$pslist</b>
</td>
</tr>
</table>
EOD;

$tbl=<<<EOD
<table cellpadding="2" cellspacing="0" bordercolor="#000000" border="0"  style="vertical-align:middle;"  width="90%">
 <TR><td width="100%" align="center">GOVT. OF ASSAM</td></TR>    
 <TR><td width="100%" align="center">OFFICE OF THE DISTRICT ELECTION OFFICER:::::::::$udistrict</td></TR>    
  <TR><td width="100%" align="center">(PERSONNEL CELL)</td></TR>    
 <TR><td width="100%" align="center">&nbsp;</td></TR> 
<TR><td width="70%" align="left">No.$letterno </td>
<td width="30%" align="center">Date:$letterdate</td> 
</TR>    
 <TR><td width="100%" align="center">&nbsp;</td></TR>    
 <TR><td width="100%" align="left">To,</td></TR>
<TR><td width="100%" align="left">$name</td></TR>
<TR><td width="100%" align="left">$desig</td></TR>
  <TR><td width="100%" align="left">$depart</td></TR>
<TR><td width="100%" align="left">Poling ID:&nbsp;&nbsp;$slno</td></TR>    
 <TR><td width="100%" align="left">Poling Duty: Micro Observer</td></TR>
 <TR><td width="100%" align="left">Phone: $phone</td></TR>
 $blankrow
 <TR><td width="100%" align="left"><b>Sub: Appointment as Micro Observer</b></td></TR>
 <TR><td width="100%" align="left"><br><br>Sir,<br></td></TR>
 <TR><td width="100%" align="left">
 <div align="justify" style="line-height:1.5">
In view of the forthcoming General Election to the House of People,2014,
it is for your information that you are hereby appointed as
<b>Micro Observer</b> against the poling stations of the LA
segment forming part of HP Constituency as shown below.
</div>
</td></TR>
<TR><td width="100%" align="left">
$myarea
</td></TR>
<TR><td width="100%" align="left">
<div align="justify" style="line-height:1.5">
<br>
You are, therefore,requested to make available at 
<b>$assembleplace</b> on <b>$polldate</b> at $reporttime to assume
your duty as Micro Observer without fail.
<br><br>
It is also informed you that you are to report to your
concerned Central Observer at <b>$reportplace</b>
 and to submit report as per proforma, after you come back from the Polling Station.
</div>
<br>
Matter is Election urgent.
</td></TR>
<TR><td width="100%" align="center">$blankrow</td></TR> 
<TR><td width="100%" align="center">$blankrow</td></TR>    
<TR><td width="100%" align="center">$ddosign</td></TR>    
        

</table>
   
EOD;
 
    
    
//END    
    

if ($mpdf==true)
{
$pdf->AddPage($PageOrientation,$PageFormat);   //add page at each $mrows
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($tbl, true, false, false, false, '');
}
else
echo $tbl;
   
} //for loop


if ($mpdf==true)
{
ob_end_clean();
$pdf->Output('microreport.pdf', 'I');
}

?>
