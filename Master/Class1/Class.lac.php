<body>
<?php
require_once 'class.config.php';
class Lac
{
private $Code;
private $Name;
private $Ro_sign;
private $Hpccode;
private $Rtag;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Name;
private $Old_Ro_sign;
private $Old_Hpccode;
private $Old_Rtag;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Lac()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from lac";
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
$sql=" select count(*) from lac where ".$condition;
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
$sql="select Code,Name from lac where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Code']=$row['Code'];//Primary Key-1
$tRow[$i]['Name']=$row['Name'];//Posible Unique Field
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

public function getName()
{
return($this->Name);
}

public function setName($str)
{
$this->Name=$str;
}

public function getRo_sign()
{
return($this->Ro_sign);
}

public function setRo_sign($str)
{
$this->Ro_sign=$str;
}

public function getHpccode()
{
return($this->Hpccode);
}

public function setHpccode($str)
{
$this->Hpccode=$str;
}

public function getRtag()
{
return($this->Rtag);
}

public function setRtag($str)
{
$this->Rtag=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Name,Ro_sign,Hpccode,Rtag from lac where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Name'])>0)
$this->Old_Name=$row['Name'];
else
$this->Old_Name="NULL";
if (strlen($row['Ro_sign'])>0)
$this->Old_Ro_sign=$row['Ro_sign'];
else
$this->Old_Ro_sign="NULL";
if (strlen($row['Hpccode'])>0)
$this->Old_Hpccode=$row['Hpccode'];
else
$this->Old_Hpccode="NULL";
if (strlen($row['Rtag'])>0)
$this->Old_Rtag=$row['Rtag'];
else
$this->Old_Rtag="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Name,Ro_sign,Hpccode,Rtag from lac where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Name=$row['Name'];
$this->Ro_sign=$row['Ro_sign'];
$this->Hpccode=$row['Hpccode'];
$this->Rtag=$row['Rtag'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from lac where Code='".$this->Code."'";
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
$sql="update lac set ";
if ($this->Old_Name!=$this->Name &&  strlen($this->Name)>0)
{
if ($this->Name=="NULL")
$sql=$sql."Name=NULL";
else
$sql=$sql."Name='".$this->Name."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Name=".$this->Name.", ";
}

if ($this->Old_Ro_sign!=$this->Ro_sign &&  strlen($this->Ro_sign)>0)
{
if ($this->Ro_sign=="NULL")
$sql=$sql."Ro_sign=NULL";
else
$sql=$sql."Ro_sign='".$this->Ro_sign."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Ro_sign=".$this->Ro_sign.", ";
}

if ($this->Old_Hpccode!=$this->Hpccode &&  strlen($this->Hpccode)>0)
{
if ($this->Hpccode=="NULL")
$sql=$sql."Hpccode=NULL";
else
$sql=$sql."Hpccode='".$this->Hpccode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hpccode=".$this->Hpccode.", ";
}

if ($this->Old_Rtag!=$this->Rtag &&  strlen($this->Rtag)>0)
{
if ($this->Rtag=="NULL")
$sql=$sql."Rtag=NULL";
else
$sql=$sql."Rtag='".$this->Rtag."'";
$i++;
$this->updateList=$this->updateList."Rtag=".$this->Rtag.", ";
}
else
$sql=$sql."Rtag=Rtag";


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
$sql1="insert into lac(";
$sql=" values (";
$mcol=0;
if (strlen($this->Code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Code";
if ($this->Code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Code."'";
}

if (strlen($this->Name)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Name";
if ($this->Name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Name."'";
}

if (strlen($this->Ro_sign)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Ro_sign";
if ($this->Ro_sign=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ro_sign."'";
}

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

if (strlen($this->Rtag)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rtag";
if ($this->Rtag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rtag."'";
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


public function maxCode()
{
$sql="select max(Code) from lac";
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
$sql="select Code,Name,Ro_sign,Hpccode,Rtag from lac where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Ro_sign']=$row['Ro_sign'];
$tRows[$i]['Hpccode']=$row['Hpccode'];
$tRows[$i]['Rtag']=$row['Rtag'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Code,Name,Ro_sign,Hpccode,Rtag from lac where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Ro_sign']=$row['Ro_sign'];
$tRows[$i]['Hpccode']=$row['Hpccode'];
$tRows[$i]['Rtag']=$row['Rtag'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
