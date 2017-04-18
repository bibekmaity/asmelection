<html>
<head><title>Uploading Image File to Server</title></head>


<BODY>
 <?php 
//session_start();
require_once './class/class.signimage.php';
$objImg=new Signimage();

$result = mysql_query("select pic from table where code = 1");  
if ($result) 
{  
if ($row = mysql_fetch_array($result)) 
$img = $row["pic"];  
}  

header("Content-type: image/jpeg");  
echo $img; 



 ?> 

</body>
</html>

