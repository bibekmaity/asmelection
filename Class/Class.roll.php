<?php
require_once 'class.config.php';
class Roll
{
private $Roll;
private $Description;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Roll()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from roll";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function getRow()
{
$i=0;
$tRow=array();
$sql="select Roll,Description from roll where ".$this->condString." order by roll";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
}


public function getRoll()
{
return($this->Roll);
}

public function setRoll($str)
{
$this->Roll=$str;
}

public function getDescription()
{
return($this->Description);
}

public function setDescription($str)
{
$this->Description=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Roll,Description from roll where Roll='".$this->Roll."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Description=$row['Description'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from roll where Roll='".$this->Roll."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update roll set ";
if (strlen($this->Description)>0)
{
if ($this->Description=="NULL")
$sql=$sql."Description=NULL";
else
$sql=$sql."Description='".$this->Description."'";
}
else
$sql=$sql."Description=Description";

$cond="  where Roll='".$this->Roll."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into roll(Roll,Description) values(";
if (strlen($this->Roll)>0)
{
if ($this->Roll=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Roll."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Description)>0)
{
if ($this->Description=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Description."'";
}
else
$sql=$sql."NULL";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function maxRoll()
{
$sql="select max(Roll) from roll";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function getAllRecord()
{
$tRows=array();
$sql="select Roll,Description from roll where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Roll']=$row['Roll'];
$tRows[$i]['Description']=$row['Description'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
