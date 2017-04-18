<?php
require_once 'class.config.php';
class Locktable
{
private $Evm1;
private $Evm2;
private $Pgroup;
private $Decode;

//extra Old Variable to store Pre update Data
private $Old_Evm1;
private $Old_Evm2;
private $Old_Pgroup;
private $Old_Decode;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Locktable()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from locktable";
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

public function rowCount($condition)
{
$sql=" select count(*) from locktable where ".$condition;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //rowCount

public function getRow()
{
$i=0;
$tRow=array();
$sql="select ,1 from locktable where ".$this->condString." order by 1";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
}


public function getEvm1()
{
return($this->Evm1);
}

public function setEvm1($str)
{
$this->Evm1=$str;
}

public function getEvm2()
{
return($this->Evm2);
}

public function setEvm2($str)
{
$this->Evm2=$str;
}

public function getPgroup()
{
return($this->Pgroup);
}

public function setPgroup($str)
{
$this->Pgroup=$str;
}

public function getDecode()
{
return($this->Decode);
}

public function setDecode($str)
{
$this->Decode=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}





public function SaveRecord()
{
$sql="insert into locktable(Evm1,Evm2,Pgroup,Decode) values(";
if (strlen($this->Evm1)>0)
{
if ($this->Evm1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Evm1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Evm2)>0)
{
if ($this->Evm2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Evm2."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Pgroup)>0)
{
if ($this->Pgroup=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pgroup."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Decode)>0)
{
if ($this->Decode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Decode."'";
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
$sql="select Evm1,Evm2,Pgroup,Decode from locktable where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Evm1']=$row['Evm1'];
$tRows[$i]['Evm2']=$row['Evm2'];
$tRows[$i]['Pgroup']=$row['Pgroup'];
$tRows[$i]['Decode']=$row['Decode'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
