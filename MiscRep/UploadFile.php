<html>
<head><title>Uploading File to Server</title></head>
<script type=text/javascript language=javascript>
function goback()
{
window.location="../Mainmenu.php?tag=1";
}
function dis()
{
myform.back1.disabled=true;
myform.save.disabled=true;
//myform.myfile.disabled=true;
myform.submit();
}
</script>

<BODY>
 <?php 
session_start();
require_once '../class/class.Polinggroup.php';

$objPg=new Polinggroup();
echo "<p align=center><font face=arial size=3 color=blue>";
echo "UPLOAD FILE TO SERVER";
echo "</p>";
echo "<hr>";
$mypath="";
if ( $_GET['tag']==1)
{
//$target = "upload/";    //Sub Directory Upload
$target = ""; 
$target1=$target . "Temp.jpg";  //Renamimg a file while uploading

//$target = "./image/".basename( $_FILES['myfile']['name']) ; 
$ok=1; 

$filename=basename( $_FILES['myfile']['name']) ; 
$ext=strtoupper(substr($filename,-4));

$con=mysqli_connect('localhost',"root","","election");

$picture= $_FILES['myfile']['name'];
var_dump($picture);


$_SESSION['filename']=$filename;
echo $ext;
if ($ext !=".JPG") 
{ 
echo "<p align=center>Invalid File Format<br>"; 
$ok=0; 
} 

if ($_FILES[ 'myfile']['size'] > 1024000) 
{ 
echo "<p align=center>Your file is too large.<br>"; 
$ok=0; 
} 

if ($ok==1) 
{ 
if(move_uploaded_file($_FILES['myfile']['tmp_name'], $target1)) 
{ 
echo "<p align=center><font color=black face=arial>The file <b>". basename( $_FILES['myfile']['name']). "</b> has been uploaded "; 
$query= "INSERT INTO SignImage(pic) VALUES ('".$picture."')";
if(mysqli_query($con,$query))
echo "FILE SAVED";
else
echo "FAILED TO SAVED";
} 
 else 
 { 
 echo "<p align=center>Sorry, there was a problem uploading your file."; 
 } 
 }   //ok=0
echo "</p>";
} //tag==1 redirection


 ?> 
<BODY>
<form name=myform enctype="multipart/form-data" action="uploadFile.php?tag=1" method="POST">
<table align=center border=0 width=90%>
<tr><td align=right bgcolor=#66FFCC><font face=arial size=3>&nbsp;</font>Select File</td>
<td align=left bgcolor=#66FFCC> <input name="myfile"  type="file" size=60 /></td></tr>
<tr><td align=right bgcolor=#66FFCC><font face=arial size=3>&nbsp;</font>Destination Path in Server(Eg. D:/Temp)</td>
<td align=left bgcolor=#66FFCC> <input type=text name="dpath" size=26  style="font-family:arial; font-size: 14px ; background-color:white;color:blue;font-size:bold;width:300px" value="<?php echo $mypath;?>"></td></tr>

<tr><td align=right bgcolor=#66FFCC><input type="button" value="Back"  onclick="goback()" name="back1" /> </td>
<td align=center bgcolor=#66FFCC><input type="button" value="Upload File" name="save" onclick="dis()" style="font-family:arial; font-size: 14px ; background-color:orange;color:blue;font-size:bold;width:100px"></td></tr>
</table>
 </form> 
</body>
</body></html>

