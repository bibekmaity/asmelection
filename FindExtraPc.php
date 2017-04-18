<?php
session_start();
require_once './class/class.poling.php';
require_once './class/class.psname.php';
require_once './class/class.MicroPs.php';

$objPoling=new Poling();
if(isset($_GET['id']))
$level=$_GET['id'];
else
$level=0;

if(isset($_POST['Cat']))
$cat=$_POST['Cat'];
else
$cat=-1;

$objMps=new MicroPs();
$objPs=new Psname();

if($cat<5)
$req=$objPs->rowCount("Lac>0");

if($cat==5)
$req=$objPs->rowCount("Lac>0 and Forthpoling_required=1");
 
if($cat==7)
$req=$objMps->rowCount("Lac>0"); 
 
if($level==1) //First Level
$condition="Deleted='N' and Sex='M' and Pollcategory=".$cat;
if($level==2) //Second Level
$condition="Selected='Y' and Deleted='N' and Sex='M' and Pollcategory=".$cat;

$avl=$objPoling->rowCount($condition);

$extra=$avl-$req;
if($extra>0 && $req>0)
$pc=round(($extra/$req)*100); 
else
$pc=0;

?>
<font color="red" face="arial" size="1">
<?php
echo "Extra Percentage Available ".$pc."%";    
?>
<input type="hidden" name="ExtraPc" id="ExtraPc" size="2" value="<?php echo $pc;?>">
</font>