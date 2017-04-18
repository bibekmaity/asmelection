<html>
<head><title>Uploading Image File to Server</title></head>
<script type=text/javascript language=javascript>
function goback()
{
window.location="Mainmenu.php?tag=2";
}

function reload()
{
window.location="uploadimage.php?tag=0";
}

function dis()
{
myform.back1.disabled=true;
myform.save.disabled=true;
myform.submit();
}

function clrimg()
{
var name = confirm("All Scan Image for Seal will be Cleared?")
if (name == true)
{
myform.action="uploadimage.php?tag=2";
myform.submit();
}
}

</script>

<BODY>
 <?php 
session_start();
require_once './class/class.signimage.php';
require_once './class/utility.class.php';
require_once './class/class.userlog.php';
require_once 'header.php';

$objUtility=new Utility();


//echo "Current Session ID".$_SESSION['sid']."<br>";
//echo "Current User ID".$_SESSION['uid']."<br>";

$objUl=new Userlog();

$objUl->MakeActive();


$allowedroll=2; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: Mainmenu.php?unauth=1');

//echo "1.".$objUl->maxSession_id()."<br>";

//$objUtility->saveSqlLog("UserLog","1-".$objUl->rowCount("1=1"));


$objImg=new Signimage();
$objUl->MakeActive();

$recordCount=$objImg->recordCount;
$mypath="";
//echo "2.".$objUl->maxSession_id()."<br>";


if(isset($_GET['tag']))
$tag= $_GET['tag'];
else
$tag=0;


$path=$objImg->LoadImage();  //Copy Image from Database to Directory
$objUl->MakeActive();

//echo "3.".$objUl->maxSession_id()."<br>";
if(file_exists($path."/Deoseal.jpg"))
$deoseal="./Deoseal.jpg";
else
$deoseal="";

if(file_exists($path."/Roundseal.jpg"))
$roundseal="./Roundseal.jpg";
else
$roundseal="";

//echo "4.".$objUl->maxSession_id()."<br>";
//echo "Current User ID".$_SESSION['uid']."<br>";




if ($tag==1) //Post Back Submit
{

if(isset($_POST['Stype']))
$code=$_POST['Stype'];
else
$code=0;

$objImg->ExecuteQuery("delete from signimage where code=".$code);
//$objUtility->saveSqlLog("UserLog","2-".$objUl->rowCount("1=1"));
$objUl->MakeActive();
//$objUtility->saveSqlLog("UserLog","3-".$objUl->rowCount("1=1"));
$ok=0;
$filename=basename( $_FILES['myfile']['name']) ; 
$ext=strtoupper(substr($filename,-4));

if ($_FILES['myfile']['size'] > 102400) 
{ 
echo "<p align=center>Your file is too large.<br>"; 
$ok++; 
} 
if($ext!=".JPG")
{ 
echo "<p align=center>Invalid File Type(Should be JPEG)<br>"; 
$ok++; 
} 

if($ok==0)
{
$fp = fopen($_FILES['myfile']['tmp_name'], "r"); 
 
if ($fp)
{  
$content = fread($fp, $_FILES['myfile']['size']); 
fclose($fp);  
$content = addslashes($content);  

$sql="Insert into signimage(Code,Seal) Values($code,'$content')"; 

if($objImg->ExecuteQuery($sql))
echo $objUtility->alert("Successfully Saved Image");
//echo $objUtility->AlertNRedirect("Successfully Saved Image","UploadImage.php?tag=0");
else
echo $objUtility->alert("Failed to Save");
//echo $objUtility->AlertNRedirect("Failed to Save","UploadImage.php?tag=0");
}
$objUl->MakeActive(); 
} //ok==0
 
} //tag==1 redirection


if ($tag==2) //Post Back Submit
{
//$objUtility->saveSqlLog("UserLog","4-".$objUl->rowCount("1=1"));
if($objImg->ExecuteQuery("delete from signimage "))
echo $objUtility->alert("Cleared All Image");
else
echo "Error in Deletion";
$objUl->MakeActive();
//$objUtility->saveSqlLog("UserLog","5-".$objUl->rowCount("1=1"));
}

 ?> 
<BODY>
<form name=myform enctype="multipart/form-data" action="uploadImage.php?tag=1" method="POST">
<table align=center border=1 width=60%>
<tr><td colspan=2 align=center><b>UPLOAD SCAN JPG IMAGE FOR SEAL</b></TD></TR>
<tr><td align=right bgcolor=#66FFCC><font face=arial size=3>&nbsp;</font>Select Seal Type</td>
<td align=left bgcolor=#66FFCC> 
<SELECT NAME=Stype style="font-family:arial; font-size: 14px ; background-color:white;color:blue;font-size:bold;width:150px">
<option value=1>DEO Seal
<option value=2>Round Seal
</select>
</td></tr>
<tr><td align=right bgcolor=#66FFCC><font face=arial size=3>&nbsp;</font>Select Image for Seal</td>
<td align=left bgcolor=#66FFCC> <input name="myfile"  type="file" size=40 /></td></tr>
<tr><td align=right bgcolor=#66FFCC><input type="button" value="Back"  onclick="goback()" name="back1"  /> </td>
<td align=center bgcolor=#66FFCC><input type="button" value="Upload File" name="save" onclick="dis()" style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;font-size:bold;width:100px">
<input type="button" value="Clear Image" name="clr" onclick="clrimg()" style="font-family:arial; font-size: 14px ; background-color:green;color:black;font-size:bold;width:100px"></td></tr>
<tr><td align=center colspan="2" bgcolor=#66FFCC>
        <font face="arial" size="3" color="red">
Existing Image of Seal        
    </td></tr>
<tr><td align=right ><font face=arial size=3>DEO Seal</td>
<td align=center > 
<image src="<?php echo $deoseal;?>" width="200" height="70">
</td></tr>
<tr><td align=right ><font face=arial size=3>Round Seal</td>
<td align=center > 
<image src="<?php echo $roundseal;?>" width="70" height="70">
</td></tr>
<tr><td align=right bgcolor=#66FFCC>&nbsp;</td>
<td align=center bgcolor=#66FFCC><input type="button" value="Refresh" name="ref" onclick="reload()" style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;font-size:bold;width:100px">
</td</tr>
</table>
 </form> 

</body>

</body></html>

