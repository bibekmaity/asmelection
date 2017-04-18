<?php
require_once 'class.config.php';
class Signimage
{
public $recordCount;
//public function _construct($i) //for PHP6
public function Signimage()
{
$objConfig=new Config();//Connects database
$sql=" select count(*) from Signimage";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}


public function maxCode()
{
$sql="select max(Code) from signimage";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function LoadImage()  //Load image into file from Database
{
$path=getcwd();
$fpath="";
$mpath=str_replace("\\","/",$path);  //Replace Back Slash with Front Slash
$fpath=$mpath;
$mpath=$mpath."/RoundSeal.JPG";

if(file_exists($mpath))
unlink($mpath);

if($this->Available(2))
{
$sql="SELECT seal INTO DUMPFILE '".$mpath."' FROM signimage WHERE code=2";
$this->ExecuteQuery($sql);
}

$path=$path."\DEOSeal.JPG";
$mpath=str_replace("\\","/",$path);  //Replace Back Slash with Front Slash

if(file_exists($mpath))
unlink($mpath);   //Delete a File

if($this->Available(1))
{
$sql="SELECT seal INTO DUMPFILE '".$mpath."' FROM signimage WHERE code=1";
$this->ExecuteQuery($sql);
}

return($fpath);
}  //End Load Image



public function Available($code)
{
$sql="select Code from signimage where Code=".$code;
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);
} //end Available


}//End Class
?>
