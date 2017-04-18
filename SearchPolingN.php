<body>
<?php
//Start FORMBODY
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';
require_once './class/class.category.php';
require_once './class/class.sentence.php';
require_once './class/class.training.php';
require_once './class/class.cell.php';

$objUtility=new Utility();
$objTrg=new Training();
$cond="1=2";
$roll=$objUtility->VerifyRoll();
$param="";

//Start Verify

$objPoling=new Poling();
$objCat=new Category();
$objC=new Sentence();

$mvalue=array();
$pkarray=array();

$_tag=1;

if (isset($_POST['Mid']))
$mvalue[0]=$_POST['Mid'];//Slno
else 
$mvalue[0]="";    
if (isset($_POST['Name']))
$mvalue[1]=$_POST['Name'];//Name
else 
$mvalue[1]="";  

if (isset($_POST['Dtype']))
$dtype=$_POST['Dtype'];
else 
$dtype="0";  


//Start of FormDesign

if ($mvalue[0]==1)
{
$cond=" slno=".$mvalue[1];
$param=" for Poling ID-<b>".$mvalue[1]."</b>";
}

if ($mvalue[0]==2)
{
$cond=" name like '%".$mvalue[1]."%'";
$param=" for Poling Person Name like <b>".$mvalue[1]."</b>";
}
if ($mvalue[0]==3)
{
$cond=" phone='".$mvalue[1]."'";  
$param=" for Phone Number-<b>".$mvalue[1]."</b>";
}

if ($roll>1) //Only First User can View Deleted employee
$cond=$cond." and deleted='N'";
    
if($dtype!=="0")
$cond=$cond." and Depcode in(Select Depcode from Department where Dep_type='".$dtype."')";

$objPoling->setCondString($cond." order by Name");       
$row=$objPoling->getAllRecord()  ;     

?>
<table border=1 align=left style="border-collapse:collapse" width=100%>
<tr><td align=center colspan=8 bgcolor=#99CCFF><font color=black face=arial size=2>Search Result <?php echo $param;?></td></tr>
<td align=center bgcolor=#99CCFF width="5%"><font color=#000080 face=arial size=2>Sl No</td>
<td align=center bgcolor=#99CCFF width="8%"><font color=#000080 face=arial size=2>Poling ID</td>
<td align=center bgcolor=#99CCFF width="33%"><font color=#000080 face=arial size=2>Name and 
Designation</td>
<td align=center bgcolor=#99CCFF width="10%"><font color="#000080" face=arial size=2>Election 
Duty</font></td>
<td align=center bgcolor=#99CCFF width="12%"><font color="#000080" face=arial size=2>Contact No</font></td>
<td align=center bgcolor=#99CCFF width="22%"><font color="#000080" face=arial size=2>Training Status</font></td>
<td align=center bgcolor=#99CCFF width="10%"><font color="#000080" face=arial size=2>Final Grouping</font></td>
</tr>       
<?php       
for($i=0;$i<count($row);$i++)
{
if ($row[$i]['Deleted']=='Y')    
$col="red";
else
$col="black";
    
$objCat->setCode($row[$i]['Pollcategory']) ;
if ($objCat->EditRecord())
{
$cat=$objCat->getName();
if($row[$i]['Pollcategory']==6) //cell Duty
{
$objCell=new Cell();
$objCell->setCode($row[$i]['Cellname']);
if($objCell->EditRecord())
$cat=$objCell->getName();    
}//$cat==6
}//$objCat->EditReco
else
$cat="Not Available";
$BEEO="";
$BEEO=$objPoling->BEEO($row[$i]['Slno']);
if(strlen($BEEO)>2)
$BEEO="<br>C/o ".$BEEO;
?>
<tr>
<td align=center valign=center ><font  face=arial size=2><?php echo $i+1?></td>
<td align=center valign=center ><font  face=arial size=2><?php echo $row[$i]['Slno']?></td>
<td align=left valign=center ><font  face=arial size=2 color="<?php echo $col?>">
    <b>
    <?php 
echo $objC->SentenceCase($row[$i]['Name'])?><br></b><?php echo $row[$i]['Desig']?><br>
<?php echo $objC->SentenceCase($row[$i]['Department']);
echo $BEEO;
?>
<br>Address:&nbsp;<?php echo $row[$i]['Placeofresidence']?>
<br>Basic Pay:&nbsp;Rs.<?php echo $row[$i]['Basic']?>
</td>
<td align=center valign=center ><font  face=arial size=2>
<?php echo $cat?> 
 &nbsp;</td>
<td align=center valign=center ><font  face=arial size=2><?php echo $row[$i]['Phone']?>
</td>
<td align=left valign=center ><font  face=arial size=2>
<br></font><font  face=arial size=1>
<?php $m=$objTrg->TrainingStatus($row[$i]['Slno']);
if(strlen($m)>0)  
{
echo $m."&nbsp;<a href=./PDFReport/TrainingFirst.php?id=".$row[$i]['Slno']." target=_blank>Print Letter</a>";    
}    
?>
</td>
<td width="76"><font  face=arial size=1>
<?php
if ($row[$i]['Grpno']>0 && $row[$i]['Selected']=="Y")
echo "Selected in Group-".$row[$i]['Grpno'];
if ($row[$i]['Grpno']>0 && $row[$i]['Selected']=="R")
echo "Selected in Reserve Group";
if($row[$i]['Grpno']>0)  
{
if($row[$i]['Pollcategory']<6)
echo $m."&nbsp;<a href=./PDFReport/Appletter.php?id=".$row[$i]['Slno']." target=_blank>Print Letter</a>";    
if($row[$i]['Pollcategory']==7)
echo $m."&nbsp;<a href=./PDFReport/AppletterMicro.php?id=".$row[$i]['Slno']." target=_blank>Print Letter</a>";    
} 
if($col=="red")
echo "Exempted from Duty";
?>
</td>
</tr>
<?php
} //for loop
?>    
    </table>
<?php
include("footer.htm");
?>         
       
</body>
</html>
