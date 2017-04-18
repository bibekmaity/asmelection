<title>Summary Page</title>
<script language=javascript>
<!--
function go()
{
window.location="../mainmenu.php?tag=1";
}
</script>
<body>

<?php
session_start();
require_once '../class/utility.php';
require_once '../class/utility.class.php';
require_once '../class/class.poling.php';
require_once '../class/class.lac.php';
require_once '../class/class.category.php';
require_once '../class/class.Sentence.php';
require_once '../class/class.Psname.php';
$objUtility=new Utility();
$objPoling=new Poling();
$Util=new myutility();

$objSen=new Sentence();

if (isset($_GET['id']))
$id=$_GET['id'];
else
$id=0;

header('location:../mainmenu.php');


$objCat=new Category();

  
?>
<div align="center">
  <center>
  <table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
    <tr>
      <td align="center">
<input type=button value="Back"  name=back onclick=go()  style="font-family:arial; font-size: 14px ; background-color:orchid;color:black;width:40px">
</td>    
        <td colspan="5" bgcolor="#33FFCC" align="center"><font size="3" FACE="ARIAL">LAC DETAIL</TD>
        
    </TR>
      <tr>
      <td width="16%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">LAC NO</font></td>
      <td width="17%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">LAC NAME</font></td>
      <td width="16%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">TOTAL STATION</font></td>
      <td width="17%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">FORTH POLING REQUIRED FOR</font></td>
      <td width="17%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">ADVANCE POSTING FOR</font></td>
      <td width="17%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">REMARKS</font></td>
    </tr>
 <?PHP
 $objPs=new Psname();
 $objLac=new Lac();
 $objLac->setCondString(" Code>0 order by Code");
 $row=$objLac->getAllRecord();
 for ($i=0;$i<count($row);$i++)
 {
 $code=$row[$i]['Code'];
 $tot=$objPs->rowCount("Lac=".$code);
 
 $tot1=$objPs->rowCount("Lac=".$code." and Forthpoling_required=true");
 //$objPs->getForthpoling_required()
 $tot2=$objPs->rowCount("Lac=".$code." and Reporting_tag=0");
 ?>
    <tr>
      <td width="16%" align="center"><font size="2" FACE="ARIAL"><?php echo $row[$i]['Code'];?></td>
      <td width="17%" align="left"><font size="2" FACE="ARIAL"><?php echo $row[$i]['Name'];?></td>
      <td width="16%" align="center"><font size="2" FACE="ARIAL"><?php echo $tot;?></td>
      <td width="17%" align="center"><font size="2" FACE="ARIAL"><?php echo $tot1;?></td>
      <td width="17%" align="center"><font size="2" FACE="ARIAL"><?php echo $tot2;?></td>
      <td width="17%" align="center">&nbsp;</td>
    </tr>
<?php
 }
 ?>
  </table>
  </center>
</div>
    <br>

<div align="center">
  <center>
  <table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
    <tr><td colspan="5" bgcolor="#33FFCC" align="center"><font size="3" FACE="ARIAL">POLL CATEGORY WISE DETAIL</TD></TR>
          <tr>
      <td width="20%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">Polling Category</td>
      <td width="20%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">Available in Database</td>
      <td width="20%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">Trained in First Phase</td>
      <td width="20%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">Selected in Main Group</td>
      <td width="20%" align="center" BGCOLOR="#FFFFCC"><font size="2" FACE="ARIAL">Selected in Reserve Group</td>
      
    </tr>
    <?PHP
 $objPoling=new Poling();
 $t1=$objPoling->rowCount("pollcategory=1 and deleted='N'");
 $t2=$objPoling->rowCount("pollcategory=2 and deleted='N'");
 $t3=$objPoling->rowCount("pollcategory=3 and deleted='N'");
 $t4=$objPoling->rowCount("pollcategory=4 and deleted='N'");
 $t5=$objPoling->rowCount("pollcategory=5 and deleted='N'");
 
 $trained1=$objPoling->rowCount("pollcategory=1 and Slno in(Select Poling_id from Poling_training where Phaseno=1)");
$trained2=$objPoling->rowCount("pollcategory=2 and Slno in(Select Poling_id from Poling_training where Phaseno=1)");
$trained3=$objPoling->rowCount("pollcategory=3 and Slno in(Select Poling_id from Poling_training where Phaseno=1)");
$trained4=$objPoling->rowCount("pollcategory=4 and Slno in(Select Poling_id from Poling_training where Phaseno=1)");
$trained5=$objPoling->rowCount("pollcategory=5 and Slno in(Select Poling_id from Poling_training where Phaseno=1)");
   
$group1=$objPoling->rowCount("pollcategory=1 and Grpno>0 and Selected='Y'");
$group2=$objPoling->rowCount("pollcategory=2 and Grpno>0 and Selected='Y'");
$group3=$objPoling->rowCount("pollcategory=3 and Grpno>0 and Selected='Y'");
$group4=$objPoling->rowCount("pollcategory=4 and Grpno>0 and Selected='Y'");
$group5=$objPoling->rowCount("pollcategory=5 and Grpno>0 and Selected='Y'");
 

$rgroup1=$objPoling->rowCount("pollcategory=1 and Grpno>0 and Selected='R'");
$rgroup2=$objPoling->rowCount("pollcategory=2 and Grpno>0 and Selected='R'");
$rgroup3=$objPoling->rowCount("pollcategory=3 and Grpno>0 and Selected='R'");
$rgroup4=$objPoling->rowCount("pollcategory=4 and Grpno>0 and Selected='R'");
$rgroup5=$objPoling->rowCount("pollcategory=5 and Grpno>0 and Selected='R'"); 
 
 ?>
    <tr>
      <td width="20%"><font size="2" FACE="ARIAL">Presiding</td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $t1;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $trained1;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $group1;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $rgroup1;?></td>
           
    </tr>
    <tr>
      <td width="20%"><font size="2" FACE="ARIAL">First Poling</td>
     <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $t2;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $trained2;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $group2;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $rgroup2;?></td>
      
      
      
    </tr>
    <tr>
      <td width="20%"><font size="2" FACE="ARIAL">Second Poling</td>
    <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $t3;?></td>
    <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $trained3;?></td>
   <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $group3;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $rgroup3;?></td>
      
    </tr>
    <tr>
      <td width="20%"><font size="2" FACE="ARIAL">Third Poling</td>
   <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $t4;?></td>
   <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $trained4;?></td>
   <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $group4;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $rgroup4;?></td>
          </tr>
    <tr>
      <td width="20%"><font size="2" FACE="ARIAL">Forth Poling</td>
<td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $t5;?></td>
<td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $trained5;?></td>
<td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $group5;?></td>
      <td width="20%" align="center"><font size="2" FACE="ARIAL"><?php echo $rgroup5;?></td>
      
    </tr>
  </table>
  </center>
</div>
</body>
</html>
