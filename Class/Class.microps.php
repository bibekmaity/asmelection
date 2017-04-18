<?php
require_once 'class.config.php';
class Microps
{
private $Grpno;
private $Lac;
private $Pslist;
private $No_of_ps;
private $Advance;

//extra Old Variable to store Pre update Data
private $Old_Grpno;
private $Old_Lac;
private $Old_Pslist;
private $Old_No_of_ps;
private $Old_Advance;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Pslist="0";
private $Def_No_of_ps="0";
private $Def_Advance="1";
//public function _construct($i) //for PHP6
public function Microps()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from microps";
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
$sql=" select count(*) from microps where ".$condition;
$result=mysql_query($sql);
$this->returnSql=$sql;
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
$sql="select Grpno,Pslist from microps where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Grpno']=$row['Grpno'];//Primary Key-1
$tRow[$i]['Pslist']=$row['Pslist'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getGrpno()
{
return($this->Grpno);
}

public function setGrpno($str)
{
$this->Grpno=$str;
}

public function getLac()
{
return($this->Lac);
}

public function setLac($str)
{
$this->Lac=$str;
}

public function getPslist()
{
return($this->Pslist);
}

public function setPslist($str)
{
$this->Pslist=$str;
}

public function getNo_of_ps()
{
return($this->No_of_ps);
}

public function setNo_of_ps($str)
{
$this->No_of_ps=$str;
}

public function getAdvance()
{
return($this->Advance);
}

public function setAdvance($str)
{
$this->Advance=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Grpno,Lac,Pslist,No_of_ps,Advance from microps where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Pslist'])>0)
$this->Old_Pslist=$row['Pslist'];
else
$this->Old_Pslist="NULL";
if (strlen($row['No_of_ps'])>0)
$this->Old_No_of_ps=$row['No_of_ps'];
else
$this->Old_No_of_ps="NULL";
if (strlen($row['Advance'])>0)
$this->Old_Advance=$row['Advance'];
else
$this->Old_Advance="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Grpno,Lac,Pslist,No_of_ps,Advance from microps where Grpno='".$this->Grpno."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Lac=$row['Lac'];
$this->Pslist=$row['Pslist'];
$this->No_of_ps=$row['No_of_ps'];
$this->Advance=$row['Advance'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Grpno from microps where Grpno='".$this->Grpno."'";
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
$sql="delete from microps where Grpno='".$this->Grpno."'";
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
$sql="update microps set ";
if ($this->Old_Lac!=$this->Lac &&  strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."Lac=NULL";
else
$sql=$sql."Lac='".$this->Lac."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Lac=".$this->Lac.", ";
}

if ($this->Old_Pslist!=$this->Pslist &&  strlen($this->Pslist)>0)
{
if ($this->Pslist=="NULL")
$sql=$sql."Pslist=NULL";
else
$sql=$sql."Pslist='".$this->Pslist."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Pslist=".$this->Pslist.", ";
}

if ($this->Old_No_of_ps!=$this->No_of_ps &&  strlen($this->No_of_ps)>0)
{
if ($this->No_of_ps=="NULL")
$sql=$sql."No_of_ps=NULL";
else
$sql=$sql."No_of_ps='".$this->No_of_ps."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."No_of_ps=".$this->No_of_ps.", ";
}

if ($this->Old_Advance!=$this->Advance &&  strlen($this->Advance)>0)
{
if ($this->Advance=="NULL")
$sql=$sql."Advance=NULL";
else
$sql=$sql."Advance='".$this->Advance."'";
$i++;
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
}
else
$sql=$sql."Advance=Advance";


$cond="  where Grpno='".$this->Grpno."'";
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
$sql1="insert into microps(";
$sql=" values (";
$mcol=0;
if (strlen($this->Grpno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Grpno";
if ($this->Grpno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Grpno."'";
$this->updateList=$this->updateList."Grpno=".$this->Grpno.", ";
}

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

if (strlen($this->Pslist)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Pslist";
if ($this->Pslist=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pslist."'";
$this->updateList=$this->updateList."Pslist=".$this->Pslist.", ";
}

if (strlen($this->No_of_ps)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."No_of_ps";
if ($this->No_of_ps=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->No_of_ps."'";
$this->updateList=$this->updateList."No_of_ps=".$this->No_of_ps.", ";
}

if (strlen($this->Advance)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Advance";
if ($this->Advance=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Advance."'";
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
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


public function maxGrpno()
{
$sql="select max(Grpno) from microps";
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
$sql="select Grpno,Lac,Pslist,No_of_ps,Advance from microps where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Pslist']=$row['Pslist'];
$tRows[$i]['No_of_ps']=$row['No_of_ps'];
$tRows[$i]['Advance']=$row['Advance'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Grpno,Lac,Pslist,No_of_ps,Advance from microps where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Pslist']=$row['Pslist'];
$tRows[$i]['No_of_ps']=$row['No_of_ps'];
$tRows[$i]['Advance']=$row['Advance'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
