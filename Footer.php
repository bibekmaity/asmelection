<script src="jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() //Onload event of Form
{
    
 $.ajaxSetup ({   
 cache: false  
 });   
 
$(window).unload(function() {
  $.ajax({
  url: 'unloaded.php?id=M',async : false
  });
return false;
}); //unload
}); //Ready Function
</script>    
    
<body >
<?php
session_start();
require_once './class/class.Frame.php';


//$objF=new Frame();
//if($objF->FrameExist("M")==false)
//header('Refresh: 5;url=Footer.php');

//require_once './class/class.copy.php';

//$objCp=new CopyF();


//if($firstlogin=="N")

$objF=new Frame();
$sid=$objF->getSession_id();
$sql="update Userlog set Middle_frame=1 where Session_id=".$sid;
$objF->ExecuteQuery($sql);

//$objUt=new Utility();
//$objUt->saveSqlLog("Frame", $sql);

?>
<table width="95%" border="0" cellspacing="1" cellpadding="2" align=center>
  <tr>
  <td align="center" width="100%%" >
  <image src="./image/nic.png" width="260" height="25">
  </td>
     </tr>
</table>
 </html>