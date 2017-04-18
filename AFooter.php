
<body >
<?php
header('Refresh: 5;url=Footer.php');
session_start();
require_once './class/class.Frame.php';


$objF=new Frame();
$objF->setMiddle_frame("1");
$objF->UpdateRecord();

?>
<table width="95%" border="0" cellspacing="1" cellpadding="2" align=center>
  <tr>
  <td align="center" width="100%%" >
  <image src="./image/nicnal.jpg" width="250" height="35">
  </td>
     </tr>
</table>
 </html>