<?php
require_once 'class.config.php';
class Deptype
{
private $Code;
private $Name;
private $Sl;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Deptype()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from deptype";
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
$sql="select code,Name from deptype where ".$this->condString." order by Name";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
$this->returnSql=$sql;
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

public function getName()
{
return($this->Name);
}

public function setName($str)
{
$this->Name=$str;
}

public function getSl()
{
return($this->Sl);
}

public function setSl($str)
{
$this->Sl=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Code,Name,Sl from deptype where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Name=$row['Name'];
$this->Sl=$row['Sl'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from deptype where Code='".$this->Code."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update deptype set ";
if (strlen($this->Name)>0)
{
if ($this->Name=="NULL")
$sql=$sql."Name=NULL";
else
$sql=$sql."Name='".$this->Name."'";
$sql=$sql.",";
}

if (strlen($this->Sl)>0)
{
if ($this->Sl=="NULL")
$sql=$sql."Sl=NULL";
else
$sql=$sql."Sl='".$this->Sl."'";
}
else
$sql=$sql."Sl=Sl";

$cond="  where Code='".$this->Code."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record

public function maxSl()
{
$sql="select max(Sl) from Deptype";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function SaveRecord()
{
$sql="insert into deptype(Code,Name,Sl) values(";
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

if (strlen($this->Sl)>0)
{
if ($this->Sl=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Sl."'";
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
$sql="select Code,Name,Sl from deptype where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Sl']=$row['Sl'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
