<?php
require_once 'class.config.php';
class Trg_venue
{
private $Venue_code;
private $Venue_name;

//extra Old Variable to store Pre update Data
private $Old_Venue_code;
private $Old_Venue_name;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Trg_venue()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from trg_venue";
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
$sql=" select count(*) from trg_venue where ".$condition;
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
$sql="select Venue_Code,Venue_Name from trg_venue where ".$this->condString." order by Venue_Name";
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

public function getVenue_name()
{
return($this->Venue_name);
}

public function setVenue_name($str)
{
$this->Venue_name=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Venue_code,Venue_name from trg_venue where Venue_code='".$this->Venue_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Venue_name'])>0)
$this->Old_Venue_name=$row['Venue_name'];
else
$this->Old_Venue_name="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Venue_code,Venue_name from trg_venue where Venue_code='".$this->Venue_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Venue_name=$row['Venue_name'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from trg_venue where Venue_code='".$this->Venue_code."'";
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
$sql="update trg_venue set ";
if ($this->Old_Venue_name!=$this->Venue_name &&  strlen($this->Venue_name)>0)
{
if ($this->Venue_name=="NULL")
$sql=$sql."Venue_name=NULL";
else
$sql=$sql."Venue_name='".$this->Venue_name."'";
$i++;
$this->updateList=$this->updateList."Venue_name=".$this->Venue_name.", ";
}
else
$sql=$sql."Venue_name=Venue_name";


$cond="  where Venue_code='".$this->Venue_code."'";
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
$sql="insert into trg_venue(Venue_code,Venue_name) values(";
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

if (strlen($this->Venue_name)>0)
{
if ($this->Venue_name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Venue_name."'";
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
$sql="select max(Venue_code) from trg_venue";
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
$sql="select Venue_code,Venue_name from trg_venue where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Venue_code']=$row['Venue_code'];
$tRows[$i]['Venue_name']=$row['Venue_name'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
