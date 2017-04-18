
<body>
<?php
session_start();
require_once './class/class.userlog.php';
require_once './class/class.Frame.php';
require_once './class/utility.class.php';


$objU=new Userlog();

if($objU->SessionActive()==false)
header('Refresh: 30;url=left.php');


$objF=new Frame();  
$sid=$objF->getSession_id();
$sql="update Userlog set Left_frame=1 where Session_id=".$sid;
$objF->ExecuteQuery($sql);

//$objF->copyFooter();
//require_once './class/utility.class.php';
//$objUt=new Utility();
//$objUt->saveSqlLog("Frame", $sql);
//$objUt->saveSqlLog("Frame", $firstlogin);

//if($_SESSION['error']==true)
//header( 'Location: Error.php');

//$objUl=new Userlog();
//$objUtility=new Utility();
//$objUl=new Userlog();
//$objUtility=new Utility();


//if(isset($_SESSION['username']))
//$user= $_SESSION['username'];
//else
//$user="";

//if(isset($_SESSION['t2']))
//$t2=$_SESSION['t2'];
//else
//$t2=date('H:i:s');

$t1=date('H:i:s');

//$msg=$objUtility->Clock($t1, $t2);

//if($objUtility->VerifyRoll()==-1)
//{
//$user="";  
//$msg="";
//} 

//echo "roll".$objUtility->VerifyRoll();
//echo $objUtility->tempstr;
//if($objUtility->VerifyRoll()>=0)
//{
//if(isset($_SESSION['sid']))
//$sid=$_SESSION['sid'];
//else 
//$sid=0;

//if (isset($_SESSION['uid']))
//$uid=$_SESSION['uid'];    
//else
//$uid="-";    

//echo $uid;

//if($firstlogin=="N")
//{
//$sql="update userlog set Log_time_out='".date('h:i:s A')."' where Session_id=".$sid." and Uid='".$uid."'";
//$objUl->ExecuteQuery($sql);
//}
//echo $sql;

//} //$objUtility->VerifyRoll()>=0

?>
<font size="2" face="arial" color=#339900><b>
<?php  echo date('d-M-Y'); ?>  
 </font></b><br>
     <font size="2" face="arial" color=black>
</font><font size="1" face="arial" color=#CC33FF><B>
<?php
if($objU->SessionActive())
echo "Login at:".date('h:i A');?>
      </font></B>
  </html>