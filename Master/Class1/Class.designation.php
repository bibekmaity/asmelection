<body>
<?php
require_once 'class.config.php';
class Designation
{
private $Dep_type;
private $Desig_code;
private $Designation;

//extra Old Variable to store Pre update Data
private $Old_Dep_type;
private $Old_Desig_code;
private $Old_Designation;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Designation()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from designation";
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
$sql=" select count(*) from designation where ".$condition;
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
$sql="select Desig_code,Designation from designation where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Desig_code']=$row['Desig_code'];//Primary Key-1
$tRow[$i]['Designation']=$row['Designation'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getDep_type()
{
return($this->Dep_type);
}

public function setDep_type($str)
{
$this->Dep_type=$str;
}

public function getDesig_code()
{
return($this->Desig_code);
}

public function setDesig_code($str)
{
$this->Desig_code=$str;
}

public function getDesignation()
{
return($this->Designation);
}

public function setDesignation($str)
{
$this->Designation=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Dep_type,Desig_code,Designation from designation where Desig_code='".$this->Desig_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Dep_type'])>0)
$this->Old_Dep_type=$row['Dep_type'];
else
$this->Old_Dep_type="NULL";
if (strlen($row['Designation'])>0)
$this->Old_Designation=$row['Designation'];
else
$this->Old_Designation="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Dep_type,Desig_code,Designation from designation where Desig_code='".$this->Desig_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Dep_type=$row['Dep_type'];
$this->Designation=$row['Designation'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from designation where Desig_code='".$this->Desig_code."'";
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
$sql="update designation set ";
if ($this->Old_Dep_type!=$this->Dep_type &&  strlen($this->Dep_type)>0)
{
if ($this->Dep_type=="NULL")
$sql=$sql."Dep_type=NULL";
else
$sql=$sql."Dep_type='".$this->Dep_type."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dep_type=".$this->Dep_type.", ";
}

if ($this->Old_Designation!=$this->Designation &&  strlen($this->Designation)>0)
{
if ($this->Designation=="NULL")
$sql=$sql."Designation=NULL";
else
$sql=$sql."Designation='".$this->Designation."'";
$i++;
$this->updateList=$this->updateList."Designation=".$this->Designation.", ";
}
else
$sql=$sql."Designation=Designation";


$cond="  where Desig_code='".$this->Desig_code."'";
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
$sql1="insert into designation(";
$sql=" values (";
$mcol=0;
if (strlen($this->Dep_type)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dep_type";
if ($this->Dep_type=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dep_type."'";
}

if (strlen($this->Desig_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Desig_code";
if ($this->Desig_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Desig_code."'";
}

if (strlen($this->Designation)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Designation";
if ($this->Designation=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Designation."'";
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


public function maxDesig_code()
{
$sql="select max(Desig_code) from designation";
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
$sql="select Dep_type,Desig_code,Designation from designation where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Dep_type']=$row['Dep_type'];
$tRows[$i]['Desig_code']=$row['Desig_code'];
$tRows[$i]['Designation']=$row['Designation'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Dep_type,Desig_code,Designation from designation where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Dep_type']=$row['Dep_type'];
$tRows[$i]['Desig_code']=$row['Desig_code'];
$tRows[$i]['Designation']=$row['Designation'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
