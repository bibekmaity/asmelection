<?php
require_once 'class.config.php';
class Testgroup
{
private $Lacno;
private $Pr;
private $P1;
private $P2;
private $P3;
private $P4;
private $Micro;

//extra Old Variable to store Pre update Data
private $Old_Lacno;
private $Old_Pr;
private $Old_P1;
private $Old_P2;
private $Old_P3;
private $Old_P4;
private $Old_Micro;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Pr="0";
private $Def_P1="0";
private $Def_P2="0";
private $Def_P3="0";
private $Def_P4="0";
private $Def_Micro="0";
//public function _construct($i) //for PHP6
public function Testgroup()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from testgroup";
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
$sql=" select count(*) from testgroup where ".$condition;
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
$sql="select Lacno as Expr,Lacno from testgroup where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Lacno as Expr']=$row['Lacno as Expr'];//Primary Key-1
$tRow[$i]['Lacno']=$row['Lacno'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getLacno()
{
return($this->Lacno);
}

public function setLacno($str)
{
$this->Lacno=$str;
}

public function getPr()
{
return($this->Pr);
}

public function setPr($str)
{
$this->Pr=$str;
}

public function getP1()
{
return($this->P1);
}

public function setP1($str)
{
$this->P1=$str;
}

public function getP2()
{
return($this->P2);
}

public function setP2($str)
{
$this->P2=$str;
}

public function getP3()
{
return($this->P3);
}

public function setP3($str)
{
$this->P3=$str;
}

public function getP4()
{
return($this->P4);
}

public function setP4($str)
{
$this->P4=$str;
}

public function getMicro()
{
return($this->Micro);
}

public function setMicro($str)
{
$this->Micro=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Lacno,Pr,P1,P2,P3,P4,Micro from testgroup where Lacno='".$this->Lacno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Pr'])>0)
$this->Old_Pr=$row['Pr'];
else
$this->Old_Pr="NULL";
if (strlen($row['P1'])>0)
$this->Old_P1=$row['P1'];
else
$this->Old_P1="NULL";
if (strlen($row['P2'])>0)
$this->Old_P2=$row['P2'];
else
$this->Old_P2="NULL";
if (strlen($row['P3'])>0)
$this->Old_P3=$row['P3'];
else
$this->Old_P3="NULL";
if (strlen($row['P4'])>0)
$this->Old_P4=$row['P4'];
else
$this->Old_P4="NULL";
if (strlen($row['Micro'])>0)
$this->Old_Micro=$row['Micro'];
else
$this->Old_Micro="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Lacno,Pr,P1,P2,P3,P4,Micro from testgroup where Lacno='".$this->Lacno."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Pr=$row['Pr'];
$this->P1=$row['P1'];
$this->P2=$row['P2'];
$this->P3=$row['P3'];
$this->P4=$row['P4'];
$this->Micro=$row['Micro'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Lacno from testgroup where Lacno='".$this->Lacno."'";
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
$sql="delete from testgroup where Lacno='".$this->Lacno."'";
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
$sql="update testgroup set ";
if ($this->Old_Pr!=$this->Pr &&  strlen($this->Pr)>0)
{
if ($this->Pr=="NULL")
$sql=$sql."Pr=NULL";
else
$sql=$sql."Pr='".$this->Pr."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Pr=".$this->Pr.", ";
}

if ($this->Old_P1!=$this->P1 &&  strlen($this->P1)>0)
{
if ($this->P1=="NULL")
$sql=$sql."P1=NULL";
else
$sql=$sql."P1='".$this->P1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."P1=".$this->P1.", ";
}

if ($this->Old_P2!=$this->P2 &&  strlen($this->P2)>0)
{
if ($this->P2=="NULL")
$sql=$sql."P2=NULL";
else
$sql=$sql."P2='".$this->P2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."P2=".$this->P2.", ";
}

if ($this->Old_P3!=$this->P3 &&  strlen($this->P3)>0)
{
if ($this->P3=="NULL")
$sql=$sql."P3=NULL";
else
$sql=$sql."P3='".$this->P3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."P3=".$this->P3.", ";
}

if ($this->Old_P4!=$this->P4 &&  strlen($this->P4)>0)
{
if ($this->P4=="NULL")
$sql=$sql."P4=NULL";
else
$sql=$sql."P4='".$this->P4."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."P4=".$this->P4.", ";
}

if ($this->Old_Micro!=$this->Micro &&  strlen($this->Micro)>0)
{
if ($this->Micro=="NULL")
$sql=$sql."Micro=NULL";
else
$sql=$sql."Micro='".$this->Micro."'";
$i++;
$this->updateList=$this->updateList."Micro=".$this->Micro.", ";
}
else
$sql=$sql."Micro=Micro";


$cond="  where Lacno='".$this->Lacno."'";
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
$sql1="insert into testgroup(";
$sql=" values (";
$mcol=0;
if (strlen($this->Lacno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Lacno";
if ($this->Lacno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lacno."'";
$this->updateList=$this->updateList."Lacno=".$this->Lacno.", ";
}

if (strlen($this->Pr)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Pr";
if ($this->Pr=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pr."'";
$this->updateList=$this->updateList."Pr=".$this->Pr.", ";
}

if (strlen($this->P1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."P1";
if ($this->P1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->P1."'";
$this->updateList=$this->updateList."P1=".$this->P1.", ";
}

if (strlen($this->P2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."P2";
if ($this->P2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->P2."'";
$this->updateList=$this->updateList."P2=".$this->P2.", ";
}

if (strlen($this->P3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."P3";
if ($this->P3=="NULL")
$sql=$sql."0";
else
$sql=$sql."'".$this->P3."'";
$this->updateList=$this->updateList."P3=".$this->P3.", ";
}

if (strlen($this->P4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."P4";
if ($this->P4=="NULL")
$sql=$sql."0";
else
$sql=$sql."'".$this->P4."'";
$this->updateList=$this->updateList."P4=".$this->P4.", ";
}

if (strlen($this->Micro)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Micro";
if ($this->Micro=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micro."'";
$this->updateList=$this->updateList."Micro=".$this->Micro.", ";
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

public function SumCategory($catg)
{
$cArr=array();
$cArr[1]="Pr";
$cArr[2]="P1";
$cArr[3]="P2";
$cArr[4]="P3";
$cArr[5]="P4";
$cArr[7]="Micro";
$sql="select sum(".$cArr[$catg].") from testgroup";

$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}


public function maxLacno()
{
$sql="select max(Lacno) from testgroup";
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
$sql="select Lacno,Pr,P1,P2,P3,P4,Micro from testgroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Lacno']=$row['Lacno'];
$tRows[$i]['Pr']=$row['Pr'];
$tRows[$i]['P1']=$row['P1'];
$tRows[$i]['P2']=$row['P2'];
$tRows[$i]['P3']=$row['P3'];
$tRows[$i]['P4']=$row['P4'];
$tRows[$i]['Micro']=$row['Micro'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Lacno,Pr,P1,P2,P3,P4,Micro from testgroup where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Lacno']=$row['Lacno'];
$tRows[$i]['Pr']=$row['Pr'];
$tRows[$i]['P1']=$row['P1'];
$tRows[$i]['P2']=$row['P2'];
$tRows[$i]['P3']=$row['P3'];
$tRows[$i]['P4']=$row['P4'];
$tRows[$i]['Micro']=$row['Micro'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
