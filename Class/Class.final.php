<?php
require_once 'class.config.php';
class LacFinal
{
private $Lac;
private $Locked;
private $Mtype;
private $Tag;

//extra Old Variable to store Pre update Data
private $Old_Lac;
private $Old_Locked;
private $Old_Mtype;
private $Old_Tag;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Lac="0";
private $Def_Mtype="0";
private $Def_Tag="1";
//public function _construct($i) //for PHP6
public function LacFinal()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from final";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
$this->Tag=1;
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function rowCount($condition)
{
$sql=" select count(*) from final where ".$condition;
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
$sql="select Lac,Locked,Tag,Locked from final where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Lac']=$row['Lac'];//Primary Key-1
$tRow[$i]['Locked']=$row['Locked'];//Primary Key-2
$tRow[$i]['Tag']=$row['Tag'];//Primary Key-3
$tRow[$i]['Locked']=$row['Locked'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getLac()
{
return($this->Lac);
}

public function setLac($str)
{
$this->Lac=$str;
}

public function getLocked()
{
return($this->Locked);
}

public function setLocked($str)
{
$this->Locked=$str;
}

public function getMtype()
{
return($this->Mtype);
}

public function setMtype($str)
{
$this->Mtype=$str;
}

public function getTag()
{
return($this->Tag);
}

public function setTag($str)
{
$this->Tag=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Lac,Locked,Mtype,Tag from final where Lac='".$this->Lac."' and Locked='".$this->Locked."' and Tag='".$this->Tag."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Mtype'])>0)
$this->Old_Mtype=$row['Mtype'];
else
$this->Old_Mtype="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Lac,Locked,Mtype,Tag from final where Lac='".$this->Lac."' and Mtype='".$this->Mtype."' and Tag='".$this->Tag."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Mtype=$row['Mtype'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Lac from final where Lac='".$this->Lac."' and Locked='".$this->Locked."' and Tag='".$this->Tag."'";
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
$sql="delete from final where Lac='".$this->Lac."' and Locked='".$this->Locked."' and Tag='".$this->Tag."'";
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
$sql="update final set ";
if ($this->Old_Mtype!=$this->Mtype &&  strlen($this->Mtype)>0)
{
if ($this->Mtype=="NULL")
$sql=$sql."Mtype=NULL";
else
$sql=$sql."Mtype='".$this->Mtype."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Mtype=".$this->Mtype.", ";
}


$cond="  where Lac='".$this->Lac."' and Locked='".$this->Locked."' and Tag='".$this->Tag."'";
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
$sql1="insert into final(";
$sql=" values (";
$mcol=0;
if (strlen($this->Lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Lac";
if ($this->Lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lac."'";
$this->updateList=$this->updateList."Lac=".$this->Lac.", ";
}

if (strlen($this->Locked)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Locked";
if ($this->Locked=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Locked."'";
$this->updateList=$this->updateList."Locked=".$this->Locked.", ";
}

if (strlen($this->Mtype)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Mtype";
if ($this->Mtype=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mtype."'";
$this->updateList=$this->updateList."Mtype=".$this->Mtype.", ";
}

if (strlen($this->Tag)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Tag";
if ($this->Tag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Tag."'";
$this->updateList=$this->updateList."Tag=".$this->Tag.", ";
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


public function maxLac()
{
$sql="select max(Lac) from final";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function maxTag()
{
$sql="select max(Tag) from final";
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
$sql="select Lac,Locked,Mtype,Tag from final where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Locked']=$row['Locked'];
$tRows[$i]['Mtype']=$row['Mtype'];
$tRows[$i]['Tag']=$row['Tag'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Lac,Locked,Mtype,Tag from final where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Locked']=$row['Locked'];
$tRows[$i]['Mtype']=$row['Mtype'];
$tRows[$i]['Tag']=$row['Tag'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
