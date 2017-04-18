<?php
session_start();

require_once './class/class.pwd.php';
if (isset($_POST['Uid']))
$a_Uid=$_POST['Uid'];
else
$a_Uid="";    
$objPwd=new Pwd();
$objPwd->setUid($a_Uid);
//paste here


if($objPwd->EditRecord()) //User Available
echo "<font face=arial size=1 color=red><b>User ID Already Exist</b></font>";
else
{
$mystyle="font-family:arial; font-size: 14px ;font-weight:bold; background-color:orange;color:black;width:160px";
$mystyle1="font-family:arial; font-size: 14px ;font-weight:bold; background-color:green;color:black;width:160px";

?>
<input type=button value="Create/Update User"  name=Save onclick=validate() style="<?php echo $mystyle;?>">
<input type=button value="Reset Form"  name=RES onclick=res() style="<?php echo $mystyle1;?>">
<?php
}
?>
