<?php
require_once 'class.config.php';
class Trg_hall
{
private $Venue_code;
private $Rsl;
private $Hall_number;
private $Hall_capacity;

//extra Old Variable to store Pre update Data
private $Old_Venue_code;
private $Old_Rsl;
private $Old_Hall_number;
private $Old_Hall_capacity;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Trg_hall()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from trg_hall";
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
$sql=" select count(*) from trg_hall where ".$condition;
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
$sql="select Rsl,Hall_Number from trg_hall where ".$this->condString." order by Hall_Number";
//echo $sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
}


public function getVenue_code()
{
return($this->Venue_code);
}

public function setVenue_code($str)
{
$this->Venue_code=$str;
}

public function getRsl()
{
return($this->Rsl);
}

public function setRsl($str)
{
$this->Rsl=$str;
}

public function getHall_number()
{
return($this->Hall_number);
}

public function setHall_number($str)
{
$this->Hall_number=$str;
}

public function getHall_capacity()
{
return($this->Hall_capacity);
}

public function setHall_capacity($str)
{
$this->Hall_capacity=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Venue_code,Rsl,Hall_number,Hall_capacity from trg_hall where Venue_code='".$this->Venue_code."' and Rsl='".$this->Rsl."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Hall_number'])>0)
$this->Old_Hall_number=$row['Hall_number'];
else
$this->Old_Hall_number="NULL";
if (strlen($row['Hall_capacity'])>0)
$this->Old_Hall_capacity=$row['Hall_capacity'];
else
$this->Old_Hall_capacity="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Venue_code,Rsl,Hall_number,Hall_capacity from trg_hall where Venue_code='".$this->Venue_code."' and Rsl='".$this->Rsl."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Hall_number=$row['Hall_number'];
$this->Hall_capacity=$row['Hall_capacity'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from trg_hall where Venue_code='".$this->Venue_code."' and Rsl='".$this->Rsl."'";
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
$sql="update trg_hall set ";
if ($this->Old_Hall_number!=$this->Hall_number &&  strlen($this->Hall_number)>0)
{
if ($this->Hall_number=="NULL")
$sql=$sql."Hall_number=NULL";
else
$sql=$sql."Hall_number='".$this->Hall_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hall_number=".$this->Hall_number.", ";
}

if ($this->Old_Hall_capacity!=$this->Hall_capacity &&  strlen($this->Hall_capacity)>0)
{
if ($this->Hall_capacity=="NULL")
$sql=$sql."Hall_capacity=NULL";
else
$sql=$sql."Hall_capacity='".$this->Hall_capacity."'";
$i++;
$this->updateList=$this->updateList."Hall_capacity=".$this->Hall_capacity.", ";
}
else
$sql=$sql."Hall_capacity=Hall_capacity";


$cond="  where Venue_code='".$this->Venue_code."' and Rsl='".$this->Rsl."'";
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
$sql="insert into trg_hall(Venue_code,Rsl,Hall_number,Hall_capacity) values(";
if (strlen($this->Venue_code)>0)
{
if ($this->Venue_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Venue_code."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Rsl)>0)
{
if ($this->Rsl=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rsl."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Hall_number)>0)
{
if ($this->Hall_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hall_number."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Hall_capacity)>0)
{
if ($this->Hall_capacity=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hall_capacity."'";
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

public function maxVenue_code()
{
$sql="select max(Venue_code) from trg_hall";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function maxRsl($venue)
{
$sql="select max(Rsl) from trg_hall where venue_code=".$venue;
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
$sql="select Venue_code,Rsl,Hall_number,Hall_capacity from trg_hall where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Venue_code']=$row['Venue_code'];
$tRows[$i]['Rsl']=$row['Rsl'];
$tRows[$i]['Hall_number']=$row['Hall_number'];
$tRows[$i]['Hall_capacity']=$row['Hall_capacity'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
