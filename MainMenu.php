   
<?php
header('Refresh: 300;url=IndexPage.php?tag=1');
session_start();
require_once "Menuhead.html";
require_once './class/utility.class.php';
require_once './class/class.Poling.php';
require_once './class/class.Psname.php';
require_once './class/class.Poling.php';
require_once './class/class.Party_calldate.php';
require_once './class/class.training_phase.php';
require_once './class/class.MicroPs.php';
require_once './class/class.Poling_training.php';
require_once './class/class.copy.php';
require_once './class/class.Frame.php';
require_once './class/class.userlog.php';

$objCp=new CopyF();
$objUtility=new Utility();


//$allowedroll=4; //Change according to Business Logic
if (isset($_SESSION['uid']))
$user=$_SESSION['uid'];
else 
$user="";

$objUL=new Userlog();
$objUL->MakeActive();
//echo $objUL->returnSql;

$roll=$objUtility->VerifyRoll();

if (($roll==-1) || ($objCp->AllFrameExist()==false)) //Not Authorised
{
$_SESSION['returnmsg']="You are not authosied " ; 
echo $objUtility->AlertNRedirect("Not Authorised", "indexPage.php?tag=2");
}
 
   
if (isset($_GET['unauth']))  //Check area of authority
echo $objUtility->alert ("Unauthorised Area");


$objPwd=new Pwd();
if ($objPwd->FirstLogin($_SESSION['uid']))
{
//header( 'Location: indexPage.php?tag=0');
echo $objUtility->AlertNRedirect("Change Password", "changePwd.php?tag=0");
}
?>

<div align="center">
  <center><br>
  <table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%">
 <TR><TD WIDTH="100%" ALIGN="CENTER" bgcolor="#CCFF66">
  
 <font color="black"><B>DATABASE SUMMARY</font></b>     
 </TD></TR>
      
  <TR><TD WIDTH="100%">   
  <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="95%">
    <tr>
      <td width="67%" align="right"><font face="Arial" color="#0000FF" size="2">Name of Election 
      District</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left"><font face="Arial" color="#0000FF" size="2">
      <?php
      $objT=new Training_phase();
      $objT->setPhase_no(1);
      if($objT->EditRecord())
      {
	  if(strlen($objT->getElection_district())>1)
	  $_SESSION['district']= $objT->getElection_district();    
      echo $objT->getElection_district();
	  }
	  
	  
      
	  ?>
          
          </font></td>
    </tr>
    
    <tr>
      <td width="67%" align="right"><font face="Arial" color="#0000FF" size="2">
      Total LAC</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left"><font face="Arial" color="#0000FF" size="2">
     <?php
      $objT=new Lac();
      echo $objT->rowCount("code>0");    
      ?>     
          
      </td>
    </tr>
    
    <tr>
      <td width="67%" align="right"><font face="Arial" color="#0000FF" size="2">
      Total Poling Station</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left">
          
     <font face="Arial" color="#0000FF" size="2">
     <?php
      $objT=new Psname();
      echo $objT->rowCount("1=1");
      ?>     
               
      </td>
    </tr>
    
    <tr>
      <td width="67%" align="right"><font face="Arial" color="#0000FF" size="2">
      Poling Station with more than 1200 Voter</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left">
           
     <font face="Arial" color="#0000FF" size="2">
     <?php
      $objT=new Psname();
      echo $objT->rowCount(" male+female>=1200");
      ?>     
              
          
      </td>
    </tr>
    
    <tr>
      <td width="67%" align="right"><font face="Arial" color="#0000FF" size="2">
      Poling Station where advance Posting required</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left">
     <font face="Arial" color="#0000FF" size="2">
     <?php
      $objT=new Psname();
      echo $objT->rowCount(" reporting_tag=0");
      ?>     
    
          
      </td>
    </tr>
    
    <tr>
      <td width="67%" align="right"><font face="Arial" size="2" color="#0000FF">
      Date of Poll</font></td>
      <td width="2%">&nbsp;</td>
      <td width="64%" align="left"><font face="Arial" size="2" color="#0000FF">
    <?php
      $objT=new Party_calldate();
      echo $objT->setCode("1");
      if($objT->EditRecord())
      echo $objT->getPolldate();
      ?>     
</td>
    </tr>
<tr>
      <td width="67%" align="right" valign="top"><font face="Arial" size="2" color="#0000FF">
     Reporting Date for Party</font></td>
    <td width="2%">&nbsp;</td>
    <td width="64%" align="left" valign="top"><font face="Arial" size="2" color="#0000FF">
    <?php
    $row=$objT->getRepDate();
    $objT=new Psname();
    for($ii=0;$ii<count($row);$ii++)
    {
    echo $row[$ii]['Mydate']." For ".$objT->rowCount("Reporting_tag=".$row[$ii]['Code'])." PS" ;
    echo "<br>";
    }
	$catp="";
    $objT=new Poling();
    $catp=$catp."State Govt: <b>". $objT->rowCount(" deleted='N' and sex='M' and depcode in(select depcode from department where dep_type in('C','H','M','O','P'))");	
     $catp=$catp."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>Central Govt:<b> ". $objT->rowCount(" deleted='N' and sex='M' and depcode in(select depcode from department where dep_type='G')");	
     $catp=$catp."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>PSU:<b> ". $objT->rowCount(" deleted='N' and sex='M' and depcode in(select depcode from department where dep_type='B')");	
     $catp=$catp."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>Total in Database:<b> ". $objT->rowCount(" deleted='N' and sex='M'")."</b>";	
     
      ?>     
</td>
    </tr>    
    </table>
  </center>
</div>

<div align="center">
  <center>
  <table border="1" cellpadding="3" cellspacing="0" style="border-collapse: collapse; border-width: 0" bordercolor="#111111" width="100%">
    <tr>
      <td width="100%" style="border-style: none; border-width: medium" colspan="7" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" style="border-style: none; border-width: medium" colspan="7" align="center">
      <font color="black" FACE="ARIAL" SIZE="2">
<span style="background-color: yellow">
	  AVAILABILITY OF PERSONS FROM DIFFERENT CATEGORY</span></b></font></td>
    </tr>
	 <tr>
      <td width="100%" style="border-style: none; border-width: medium" colspan="7" align="center">
      <font color="#0000FF" FACE="ARIAL" SIZE="2"><?php echo $catp;?></td>
    </tr>
    <tr>
      <td width="18%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2"></font></b></td>
     
      <td width="13%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">Presiding</font></b></td>
      <td width="13%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">First Poling</font></b></td>
      <td width="13%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">Second Poling</font></b></td>
      <td width="13%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">Third Poling</font></b></td>
      <td width="14%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">Forth Poling</font></b></td>
      <td width="14%" style="border-style: none; border-width: medium" align="center" bgcolor="#99FFCC">
      <b><font face="Arial" size="2">Micro Observer</font></b></td>
    </tr>
    <?php //database  ROW1?>
    <tr>
    <td width="14%" style="border-style: none; border-width: medium" align="right" bgcolor="#FFFFCC">
      <b><font face="Arial" size="2">
      As On Database</font></b></td>
         
      <td style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=1 and deleted='N' and sex='M'")
      ?>              
          
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=2 and deleted='N' and sex='M'")
      ?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=3 and deleted='N' and sex='M'")
      ?> 
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
    <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=4 and deleted='N' and sex='M'")
      ?> 
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=5 and deleted='N' and sex='M'")
      ?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $objT=new Poling();
      echo $objT->rowCount(" pollcategory=7 and deleted='N' and sex='M'")
      ?>           
      </td>
    </tr>
    <?php //Requirement  ROW2
    $objPs=new Psname();
    $a=$objPs->rowCount("Lac>0");
    $b=$objPs->rowCount("Lac>0 and Forthpoling_required=1");
    $objPs=new Microps();
    $c=$objPs->rowcount("1=1");
    ?>
    <tr>
    <td width="14%" style="border-style: none; border-width: medium" align="right">
      <b><font face="Arial" size="2">
      Requirement+20%</font></b></td>
         
      <td style="border-style: none; border-width: medium" align="center">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php

      echo round($a*1.2);
      ?>              
          
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
            echo round($a*1.2);?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
        echo round($a*1.2);?> 
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
    <font face="Arial" size="2" color="#0000FF"><b>
    <?php
       echo round($a*1.2);  ?> 
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
         echo round($b*1.2);  ?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
       echo round($c*1.2);            
        ?>           
      </td>
    </tr>
    <?php //First level  ROW3
     ?>
    <tr>
    <td width="14%" style="border-style: none; border-width: medium" align="right" bgcolor="#FFFFCC">
      <b><font face="Arial" size="2">
First Level Selection</font></b></td>
       <? $objT=new Poling();  ?>
      <td style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $a=$objT->rowCount("pollcategory=1 and (Selected='Y' or Selected='R') and deleted='N'");
      echo $a;
      ?>              
          
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
       $a=$objT->rowCount("pollcategory=2 and (Selected='Y' or Selected='R') and deleted='N'");
      echo $a;?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objT->rowCount("pollcategory=3 and (Selected='Y' or Selected='R') and deleted='N'");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
    <font face="Arial" size="2" color="#0000FF"><b>
   <?php
       $a=$objT->rowCount("pollcategory=4 and (Selected='Y' or Selected='R') and deleted='N'");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objT->rowCount("pollcategory=5  and (Selected='Y' or Selected='R')");
      echo $a;?>         
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
       $a=$objT->rowCount("pollcategory=7 and Selected='Y' and deleted='N'");
      echo $a;?>
      </td>
    </tr>
  <?php //Training  ROW4
  $objTP=new Poling_training();
     ?>
    <tr>
    <td width="14%" style="border-style: none; border-width: medium" align="right">
      <b><font face="Arial" size="2">
Training Selection</font></b></td>
          <td style="border-style: none; border-width: medium" align="center">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $a=$objTP->rowCount("pcategory=1 and phaseno=1");
      //echo $objTP->returnSql;
      echo $a;
      ?>              
          
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $a=$objTP->rowCount("pcategory=2 and phaseno=1");
      echo $a;?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
 <font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objTP->rowCount("pcategory=3 and phaseno=1");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
    <font face="Arial" size="2" color="#0000FF"><b>
   <?php
      $a=$objTP->rowCount("pcategory=4 and phaseno=1");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objTP->rowCount("pcategory=5 and phaseno=1");
      echo $a;?>         
      </td>
      <td  style="border-style: none; border-width: medium" align="center">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
     $a=$objTP->rowCount("pcategory=7 and phaseno=3");
      echo $a;?>
      </td>
    </tr>  
    <?php //First level  ROW5
     ?>
    <tr>
    <td width="14%" style="border-style: none; border-width: medium" align="right" bgcolor="#FFFFCC">
      <b><font face="Arial" size="2">
Group Selection</font></b></td>
       <? $objT=new Poling();  ?>
      <td style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
    <?php
      $a=$objT->rowCount("pollcategory=1 and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;
      ?>              
          
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
       $a=$objT->rowCount("pollcategory=2 and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;?>           
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
 <font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objT->rowCount("pollcategory=3 and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
    <font face="Arial" size="2" color="#0000FF"><b>
   <?php
       $a=$objT->rowCount("pollcategory=4 and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;?>
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
      <?php
       $a=$objT->rowCount("pollcategory=5  and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;?>         
      </td>
      <td  style="border-style: none; border-width: medium" align="center" bgcolor="#FFFFCC">
<font face="Arial" size="2" color="#0000FF"><b>
    <?php
       $a=$objT->rowCount("pollcategory=7 and (Selected='Y' or Selected='R') and grpno>0");
      echo $a;?>
      </td>
    </tr>
  </table>
  </TD></TR></TABLE>    
  </center>
</div>
<?php
include("footer.htm");

?>

</body>
</html>
