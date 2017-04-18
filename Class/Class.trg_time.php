<?php
require_once 'class.config.php';
class Trg_time
{
private $Code;
private $Timing;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Timing;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Trg_time()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from trg_time";
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
$sql=" select count(*) from trg_time where ".$condition;
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
$sql="select Code,Timing from trg_time where ".$this->condString." order by Timing";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
}


public function getCode()
{
return($this->Code);
}

public function setCode($str)
{
$this->Code=$str;
}

public function getTiming()
{
return($this->Timing);
}

public function setTiming($str)
{
$this->Timing=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Timing from trg_time where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Timing'])>0)
$this->Old_Timing=$row['Timing'];
else
$this->Old_Timing="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Timing from trg_time where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Timing=$row['Timing'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from trg_time where Code='".$this->Code."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$i=$this->copyVariable();
$i=0;
$this->updateList="";
$sql="update trg_time set ";
if ($this->Old_Timing!=$this->Timing &&  strlen($this->Timing)>0)
{
if ($this->Timing=="NULL")
$sql=$sql."Timing=NULL";
else
$sql=$sql."Timing='".$this->Timing."'";
$i++;
$this->updateList=$this->updateList."Timing=".$this->Timing.", ";
}
else
$sql=$sql."Timing=Timing";


$cond="  where Code='".$this->Code."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
$this->colUpdated=$i;

if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into trg_time(Code,Timing) values(";
if (strlen($this->Code)>0)
{
if ($this->Code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Code."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Timing)>0)
{
if ($this->Timing=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Timing."'";
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

public function maxCode()
{
$sql="select max(Code) from trg_time";
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
$sql="select Code,Timing from trg_time where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Timing']=$row['Timing'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
