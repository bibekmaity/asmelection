<body>
<?php
require_once 'class.config.php';
class Hpc
{
private $Hpccode;
private $Hpcname;

//extra Old Variable to store Pre update Data
private $Old_Hpccode;
private $Old_Hpcname;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Hpccode="0";
//public function _construct($i) //for PHP6
public function Hpc()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from hpc";
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
$sql=" select count(*) from hpc where ".$condition;
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
$sql="select Hpccode,Hpcname from hpc where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Hpccode']=$row['Hpccode'];//Primary Key-1
$tRow[$i]['Hpcname']=$row['Hpcname'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getHpccode()
{
return($this->Hpccode);
}

public function setHpccode($str)
{
$this->Hpccode=$str;
}

public function getHpcname()
{
return($this->Hpcname);
}

public function setHpcname($str)
{
$this->Hpcname=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Hpccode,Hpcname from hpc where Hpccode='".$this->Hpccode."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Hpcname'])>0)
$this->Old_Hpcname=$row['Hpcname'];
else
$this->Old_Hpcname="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Hpccode,Hpcname from hpc where Hpccode='".$this->Hpccode."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Hpcname=$row['Hpcname'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from hpc where Hpccode='".$this->Hpccode."'";
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
$sql="update hpc set ";
if ($this->Old_Hpcname!=$this->Hpcname &&  strlen($this->Hpcname)>0)
{
if ($this->Hpcname=="NULL")
$sql=$sql."Hpcname=NULL";
else
$sql=$sql."Hpcname='".$this->Hpcname."'";
$i++;
$this->updateList=$this->updateList."Hpcname=".$this->Hpcname.", ";
}
else
$sql=$sql."Hpcname=Hpcname";


$cond="  where Hpccode='".$this->Hpccode."'";
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
$sql1="insert into hpc(";
$sql=" values (";
$mcol=0;
if (strlen($this->Hpccode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Hpccode";
if ($this->Hpccode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hpccode."'";
}

if (strlen($this->Hpcname)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Hpcname";
if ($this->Hpcname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hpcname."'";
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


public function maxHpccode()
{
$sql="select max(Hpccode) from hpc";
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
$sql="select Hpccode,Hpcname from hpc where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Hpccode']=$row['Hpccode'];
$tRows[$i]['Hpcname']=$row['Hpcname'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Hpccode,Hpcname from hpc where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Hpccode']=$row['Hpccode'];
$tRows[$i]['Hpcname']=$row['Hpcname'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
