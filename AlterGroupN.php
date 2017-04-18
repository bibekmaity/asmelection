<body>

<?php
session_start();
require_once './class/utility.class.php';
require_once './class/class.poling.php';

$mvalue=array();
$myTag=0;
$myNull=false;
$mvalue=array();

$objPoling=new Poling();

$objUtility=new Utility();
$allowedroll=0; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
//if (($roll==-1) || ($roll>$allowedroll))
//header( 'Location: index.php');

if (isset($_POST['Slno'])) //If HTML Field is Availbale
$_Slno=$_POST['Slno'];
else //Post Data Not Available
$_Slno="0";

if (isset($_POST['Slno1'])) //If HTML Field is Availbale
$_Slno1=$_POST['Slno1'];
else //Post Data Not Available
$_Slno1="0";


if (isset($_POST['Dcode'])) //If HTML Field is Availbale
$_Dcode=$_POST['Dcode'];
else //Post Data Not Available
$_Dcode="0";

if (isset($_POST['Dcode1'])) //If HTML Field is Availbale
$_Dcode1=$_POST['Dcode1'];
else //Post Data Not Available
$_Dcode1="0";


if (isset($_POST['Grpno'])) //If HTML Field is Availbale
$_Grpno=$_POST['Grpno'];
else //Post Data Not Available
$_Grpno="0";

if (isset($_POST['Grpno1'])) //If HTML Field is Availbale
$_Grpno1=$_POST['Grpno1'];
else //Post Data Not Available
$_Grpno1="0";

if (isset($_POST['Pollcategory'])) //If HTML Field is Availbale
$_Pollcategory=$_POST['Pollcategory'];
else //Post Data Not Available
$_Pollcategory="0";


if (isset($_POST['Pollcategory1'])) //If HTML Field is Availbale
$_Pollcategory1=$_POST['Pollcategory1'];
else //Post Data Not Available
$_Pollcategory1="0";

if ($_Pollcategory==1)
{
$sql="Update Polinggroup set Prno=".$_Slno.",Dcode=".$_Dcode." where Grpno=".$_Grpno1;
$sql1="Update Polinggroup set Prno=".$_Slno1.",Dcode=".$_Dcode1." where Grpno=".$_Grpno;
}

if ($_Pollcategory==2)
{
$sql="Update Polinggroup set Po1no=".$_Slno.",Dcode1=".$_Dcode." where Grpno=".$_Grpno1;
$sql1="Update Polinggroup set Po1no=".$_Slno1.",Dcode1=".$_Dcode1." where Grpno=".$_Grpno;
}

if ($_Pollcategory==3)
{
$sql="Update Polinggroup set Po2no=".$_Slno.",Dcode2=".$_Dcode." where Grpno=".$_Grpno1;
$sql1="Update Polinggroup set Po2no=".$_Slno1.",Dcode2=".$_Dcode1." where Grpno=".$_Grpno;
}

if ($_Pollcategory==4)
{
$sql="Update Polinggroup set Po3no=".$_Slno.",Dcode3=".$_Dcode." where Grpno=".$_Grpno1;
$sql1="Update Polinggroup set Po3no=".$_Slno1.",Dcode3=".$_Dcode1." where Grpno=".$_Grpno;
}

if ($_Pollcategory==5)
{
$sql="Update Polinggroup set Po4no=".$_Slno.",Dcode4=".$_Dcode." where Grpno=".$_Grpno1;
$sql1="Update Polinggroup set Po4no=".$_Slno1.",Dcode4=".$_Dcode1." where Grpno=".$_Grpno;
}
$sql2="Update Poling set Grpno=".$_Grpno." where Slno=".$_Slno1;
$sql3="Update Poling set Grpno=".$_Grpno1." where Slno=".$_Slno;

$Trg=$objPoling->TrgGroup($_Grpno);
$Trg1=$objPoling->TrgGroup($_Grpno1);

$sql4="Update Poling_Training set Groupno=".$Trg." where Phaseno=2 and Poling_id=".$_Slno1;
$sql5="Update Poling_Training set Groupno=".$Trg1." where Phaseno=2 and Poling_id=".$_Slno;
$cnt=0;
if($objPoling->ExecuteQuery($sql))
$cnt++;
if($objPoling->ExecuteQuery($sql1))
$cnt++;
if($objPoling->ExecuteQuery($sql2))
$cnt++;
if($objPoling->ExecuteQuery($sql3))
$cnt++;
if($objPoling->ExecuteQuery($sql4))
$cnt++;
if($objPoling->ExecuteQuery($sql5))
$cnt++;

$msg="Updated ".$cnt." Query";
echo $objUtility->AlertNRedirect($msg, "AlterGroup.php?tag=1");
?>

</body>
</html>
