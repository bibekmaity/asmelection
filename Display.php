
 <?php 
//session_start();
require_once './class/class.signimage.php';
$objImg=new Signimage();


$path=getcwd();
$mpath=str_replace("\\","/",$path);  //Replace Back Slash with Front Slash
//print $mpath;
$mpath=$mpath."/image/RoundSeal.JPG";

if(file_exists($mpath))
unlink($mpath);

$sql="SELECT Round_seal INTO DUMPFILE '".$mpath."' FROM signimage WHERE code=1";
if ($objImg->ExecuteQuery($sql))
echo "Retrived Round Seal";
else
echo "Failed";
echo "<br>";

$path=getcwd()."\image\DEOSeal.JPG";
$mpath=str_replace("\\","/",$path);  //Replace Back Slash with Front Slash

if(file_exists($mpath))
unlink($mpath);   //Delete a File

$sql="SELECT DEO_seal INTO DUMPFILE '".$mpath."' FROM signimage WHERE code=1";

if ($objImg->ExecuteQuery($sql))
echo "Retrived DEO Seal";
else
echo "Failed";
echo "<br>";


 ?> 


