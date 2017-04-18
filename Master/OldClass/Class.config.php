<body>
<?php
class Config
{
private $dbname;
private $dbuser;
private $dbpwd;

public function Config()
{
header("Content-Type: text/html; charset=utf-8");
$this->dbname="election";
$this->dbuser="root";
$this->dbpwd="";
if (strlen(trim($this->dbpwd))>0)
$con=mysql_connect('localhost',trim($this->dbuser),trim($this->dbpwd));
//$con=mysql_connect('localhost','root','pwd');
else
$con=mysql_connect('localhost',trim($this->dbuser));
//$con=mysql_connect('localhost','root');
if (!$con)
{
die('Could not connect to MySQL: ' . mysql_error());
}
//mysql_select_db("election") or die(mysql_error());
mysql_select_db(trim($this->dbname)) or die(mysql_error());
mysql_query("SET NAMES UTF8");
}//end constructor

public function getDB()
{
return($this->dbname);
}

public function getUser()
{
return($this->dbuser);
}

public function getPWD()
{
return($this->dbpwd);
}

}//end class
