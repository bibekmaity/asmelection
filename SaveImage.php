
<body>
<?php

session_start();
//require_once './class/utility.class.php';
$mysqli=mysqli_connect('localhost','root','','election');

	if (!$mysqli)
		die("Can't connect to MySQL: ".mysqli_connect_error());

	$stmt = $mysqli->prepare("INSERT INTO signimage (pic) VALUES(?)");
	$null = NULL;
	$stmt->bind_param("b", $null);

	$stmt->send_long_data(0, file_get_contents("./image/login.jpg"));

	$stmt->execute();

echo "saved";


?>

</html>