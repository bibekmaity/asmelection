<?php
require_once 'class.config.php';
class Test
{
private $Date1;
private $Offset;
private $Date2;

//extra Old Variable to store Pre update Data
private $Old_Date1;
private $Old_Offset;
private $Old_Date2;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Test()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from test";
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
$sql=" select count(*) from test where ".$condition;
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
$sql="select Date1 as Expr,Date1 from test where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Date1 as Expr']=$row['Date1 as Expr'];//Primary Key-1
$tRow[$i]['Date1']=$row['Date1'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getDate1()
{
return($this->Date1);
}

public function setDate1($str)
{
$this->Date1=$str;
}

public function getOffset()
{
return($this->Offset);
}

public function setOffset($str)
{
$this->Offset=$str;
}

public function getDate2()
{
return($this->Date2);
}

public function setDate2($str)
{
$this->Date2=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Date1,Offset,Date2 from test where Date1='".$this->Date1."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Offset'])>0)
$this->Old_Offset=$row['Offset'];
else
$this->Old_Offset="NULL";
if (strlen($row['Date2'])>0)
$this->Old_Date2=substr($row['Date2'],0,10);
else
$this->Old_Date2="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Date1,Offset,Date2 from test where Date1='".$this->Date1."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Offset=$row['Offset'];
$this->Date2=$row['Date2'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Date1 from test where Date1='".$this->Date1."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);
} //end Available


public function DeleteRecord()
{
$sql="delete from test where Date1='".$this->Date1."'";
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
$sql="update test set ";
if ($this->Old_Offset!=$this->Offset &&  strlen($this->Offset)>0)
{
if ($this->Offset=="NULL")
$sql=$sql."Offset=NULL";
else
$sql=$sql."Offset='".$this->Offset."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Offset=".$this->Offset.", ";
}

if ($this->Old_Date2!=$this->Date2 &&  strlen($this->Date2)>0)
{
if ($this->Date2=="NULL")
$sql=$sql."Date2=NULL";
else
$sql=$sql."Date2='".$this->Date2."'";
$i++;
$this->updateList=$this->updateList."Date2=".$this->Date2.", ";
}
else
$sql=$sql."Date2=Date2";


$cond="  where Date1='".$this->Date1."'";
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
$this->updateList="";
$sql1="insert into test(";
$sql=" values (";
$mcol=0;
if (strlen($this->Date1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Date1";
if ($this->Date1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Date1."'";
$this->updateList=$this->updateList."Date1=".$this->Date1.", ";
}

if (strlen($this->Offset)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Offset";
if ($this->Offset=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Offset."'";
$this->updateList=$this->updateList."Offset=".$this->Offset.", ";
}

if (strlen($this->Date2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Date2";
if ($this->Date2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Date2."'";
$this->updateList=$this->updateList."Date2=".$this->Date2.", ";
}

$sql1=$sql1.")";
$sql=$sql.")";
$sqlstring=$sql1.$sql;
$this->returnSql=$sqlstring;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sqlstring))
{
$this->colUpdated=1;
return(true);
}
else
{
$this->colUpdated=0;
return(false);
}
}//End Save Record


public function getAllRecord()
{
$tRows=array();
$sql="select Date1,Offset,Date2 from test where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Date1']=$row['Date1'];
$tRows[$i]['Offset']=$row['Offset'];
$tRows[$i]['Date2']=$row['Date2'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Date1,Offset,Date2 from test where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Date1']=$row['Date1'];
$tRows[$i]['Offset']=$row['Offset'];
$tRows[$i]['Date2']=$row['Date2'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
