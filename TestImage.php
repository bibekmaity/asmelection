
<body>
<?php

session_start();
require_once './class/class.pwd.php';
$objP=new Pwd();
$sql="DELETE FROM SIGNIMAGE WHERE CODE=1";
$objP->ExecuteQuery($sql);
$sql="INSERT INTO signimage(code, pic) VALUES (1, LOAD_FILE('e:/wamp/www/election/image/ashoka.jpg'))";

if ($objP->ExecuteQuery($sql))
echo "saved";
else
echo "Failed";

$sql="SELECT pic INTO DUMPFILE 'e:/C.JPG' FROM signimage WHERE code= 1";
if ($objP->ExecuteQuery($sql))
echo "Retrived";
else
echo "Failed";

?>

</html>