<body>
<?php
require_once 'class.config.php';
class LacFinal
{
private $Lac;
private $Locked;
private $Mtype;

//extra Old Variable to store Pre update Data
private $Old_Lac;
private $Old_Locked;
private $Old_Mtype;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Lac="0";
private $Def_Mtype="0";
//public function _construct($i) //for PHP6
public function LacFinal()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from final";
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
$sql="select LAC,MTYPE,LOCKED from final where ".$this->condString." order by LOCKED";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
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


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Lac,Locked,Mtype from final where Lac='".$this->Lac."' and Mtype='".$this->Mtype."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Locked'])>0)
$this->Old_Locked=$row['Locked'];
else
$this->Old_Locked="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Lac,Locked,Mtype from final where Lac='".$this->Lac."' and Mtype='".$this->Mtype."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Locked=$row['Locked'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from final where Lac='".$this->Lac."' and Mtype='".$this->Mtype."'";
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
$sql="update final set ";
if ($this->Old_Locked!=$this->Locked &&  strlen($this->Locked)>0)
{
if ($this->Locked=="NULL")
$sql=$sql."Locked=NULL";
else
$sql=$sql."Locked='".$this->Locked."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Locked=".$this->Locked.", ";
}


$cond="  where Lac='".$this->Lac."' and Mtype='".$this->Mtype."'";
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
$sql="insert into final(Lac,Locked,Mtype) values(";
if (strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lac."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Locked)>0)
{
if ($this->Locked=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Locked."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Mtype)>0)
{
if ($this->Mtype=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mtype."'";
}
else
$sql=$sql."'0'";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
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
public function maxMtype()
{
$sql="select max(Mtype) from final";
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
$sql="select Lac,Locked,Mtype from final where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Locked']=$row['Locked'];
$tRows[$i]['Mtype']=$row['Mtype'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
