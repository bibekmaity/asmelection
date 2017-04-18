
<body>
<?php
 require_once './class/class.pwd.php';
$objP=new Pwd();

   $query = mysql_query("select pic from signimage where  code=2");
    $row = mysql_fetch_array($query,MYSQL_ASSOC);
    $content = $row['pic'];
echo strlen($content);
//header("Content-Length:". strlen($content));
//header('Content-Type:image/jpeg');
//echo "$content";

?>

</html>