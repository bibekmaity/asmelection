<?php
require_once 'class.config.php';
class Currentphase
{
private $Phase;
private $Name;
private $Letterno;
private $Letterdate;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Currentphase()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from currentphase";
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



public function getPhase()
{
return($this->Phase);
}

public function setPhase($str)
{
$this->Phase=$str;
}

public function getName()
{
return($this->Name);
}

public function setName($str)
{
$this->Name=$str;
}

public function getLetterno()
{
return($this->Letterno);
}

public function setLetterno($str)
{
$this->Letterno=$str;
}

public function getLetterdate()
{
return($this->Letterdate);
}

public function setLetterdate($str)
{
$this->Letterdate=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}




public function SaveRecord()
{
$sql="insert into currentphase(Phase,Name,Letterno,Letterdate) values(";
if (strlen($this->Phase)>0)
{
if ($this->Phase=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phase."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Name)>0)
{
if ($this->Name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Name."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Letterno)>0)
{
if ($this->Letterno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Letterno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Letterdate)>0)
{
if ($this->Letterdate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Letterdate."'";
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

public function getAllRecord()
{
$tRows=array();
$sql="select Phase,Name,Letterno,Letterdate from currentphase where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Phase']=$row['Phase'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Letterno']=$row['Letterno'];
$tRows[$i]['Letterdate']=$row['Letterdate'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
