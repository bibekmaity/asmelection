<?php
class iConfig
{
private $dbname;
private $dbuser;
private $dbpwd;

public function iConfig()
{
header("Content-Type: text/html; charset=utf-8");
$this->dbname="information_schema";
if(isset($_SESSION['dbuser']))
$this->dbuser=$_SESSION['dbuser'];
else
$this->dbuser="root";
if(isset($_SESSION['dbpwd']))
$this->dbpwd=$_SESSION['dbpwd'];
else
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
//mysql_select_db("information_schema") or die(mysql_error());
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
