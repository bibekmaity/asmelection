<?php
require_once 'class.config.php';
class Bu
{
private $Bu_code;
private $Bu_number;
private $Trunck_number;
private $Rnumber;
private $Used;

//extra Old Variable to store Pre update Data
private $Old_Bu_code;
private $Old_Bu_number;
private $Old_Trunck_number;
private $Old_Rnumber;
private $Old_Used;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Used="N";
//public function _construct($i) //for PHP6
public function Bu()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from bu";
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
$sql=" select count(*) from bu where ".$condition;
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
$sql="select Bu_code,Bu_number,Trunck_number from bu where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Bu_code']=$row['Bu_code'];//Primary Key-1
$tRow[$i]['Bu_number']=$row['Bu_number'];//Posible Unique Field
$tRow[$i]['Trunck_number']=$row['Trunck_number'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getBu_code()
{
return($this->Bu_code);
}

public function setBu_code($str)
{
$this->Bu_code=$str;
}

public function getBu_number()
{
return($this->Bu_number);
}

public function setBu_number($str)
{
$this->Bu_number=$str;
}

public function getTrunck_number()
{
return($this->Trunck_number);
}

public function setTrunck_number($str)
{
$this->Trunck_number=$str;
}

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
}

public function getUsed()
{
return($this->Used);
}

public function setUsed($str)
{
$this->Used=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used from bu where Bu_code='".$this->Bu_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Bu_number'])>0)
$this->Old_Bu_number=$row['Bu_number'];
else
$this->Old_Bu_number="NULL";
if (strlen($row['Trunck_number'])>0)
$this->Old_Trunck_number=$row['Trunck_number'];
else
$this->Old_Trunck_number="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
if (strlen($row['Used'])>0)
$this->Old_Used=$row['Used'];
else
$this->Old_Used="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used from bu where Bu_code='".$this->Bu_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Bu_number=$row['Bu_number'];
$this->Trunck_number=$row['Trunck_number'];
$this->Rnumber=$row['Rnumber'];
$this->Used=$row['Used'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from bu where Bu_code='".$this->Bu_code."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
$this->returnSql=$sql;
return($result);
} //end deleterecord


public function UpdateRecord()
{
$i=$this->copyVariable();
$i=0;
$this->updateList="";
$sql="update bu set ";
if ($this->Old_Bu_number!=$this->Bu_number &&  strlen($this->Bu_number)>0)
{
if ($this->Bu_number=="NULL")
$sql=$sql."Bu_number=NULL";
else
$sql=$sql."Bu_number='".$this->Bu_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Bu_number=".$this->Bu_number.", ";
}

if ($this->Old_Trunck_number!=$this->Trunck_number &&  strlen($this->Trunck_number)>0)
{
if ($this->Trunck_number=="NULL")
$sql=$sql."Trunck_number=NULL";
else
$sql=$sql."Trunck_number='".$this->Trunck_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trunck_number=".$this->Trunck_number.", ";
}

if ($this->Old_Rnumber!=$this->Rnumber &&  strlen($this->Rnumber)>0)
{
if ($this->Rnumber=="NULL")
$sql=$sql."Rnumber=NULL";
else
$sql=$sql."Rnumber='".$this->Rnumber."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Rnumber=".$this->Rnumber.", ";
}

if ($this->Old_Used!=$this->Used &&  strlen($this->Used)>0)
{
if ($this->Used=="NULL")
$sql=$sql."Used=NULL";
else
$sql=$sql."Used='".$this->Used."'";
$i++;
$this->updateList=$this->updateList."Used=".$this->Used.", ";
}
else
$sql=$sql."Used=Used";


$cond="  where Bu_code='".$this->Bu_code."'";
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
$sql1="insert into bu(";
$sql=" values (";
$mcol=0;
if (strlen($this->Bu_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_code";
if ($this->Bu_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_code."'";
}

if (strlen($this->Bu_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_number";
if ($this->Bu_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_number."'";
}

if (strlen($this->Trunck_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trunck_number";
if ($this->Trunck_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trunck_number."'";
}

if (strlen($this->Rnumber)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rnumber";
if ($this->Rnumber=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rnumber."'";
}

if (strlen($this->Used)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Used";
if ($this->Used=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Used."'";
}

$sql1=$sql1.")";
$sql=$sql.")";
$sqlstring=$sql1.$sql;
$this->returnSql=$sqlstring;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sqlstring))
return(true);
else
return(false);
}//End Save Record


public function maxBu_code()
{
$sql="select max(Bu_code) from bu ";
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
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used from bu where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Bu_code']=$row['Bu_code'];
$tRows[$i]['Bu_number']=$row['Bu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Used']=$row['Used'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used from bu where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Bu_code']=$row['Bu_code'];
$tRows[$i]['Bu_number']=$row['Bu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Used']=$row['Used'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function getTopId($totrec)
{
$tRows=array();
$sql="select Bu_code  from Bu where used='N' order by rnumber LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Bu_code'];
$i++;
} //End While
return($tRows);
} //End getTopId
}//End Class
?>
