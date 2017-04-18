<?php
require_once 'class.config.php';
class Poling_history
{
private $Pid;
private $Rsl;
private $History;
private $E_date;
private $E_time;
private $User_name;
private $Client_ip;

//extra Old Variable to store Pre update Data
private $Old_Pid;
private $Old_Rsl;
private $Old_History;
private $Old_E_date;
private $Old_E_time;
private $Old_User_name;
private $Old_Client_ip;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Pid="0";
//public function _construct($i) //for PHP6
public function Poling_history()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from poling_history";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";

$this->E_date=date('Y-m-d');
if (isset($_SERVER['REMOTE_ADDR']))
$this->Client_ip= $_SERVER['REMOTE_ADDR'];  
else
$this->Client_ip="NA";
$this->E_time=date('h:i:s A');
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function rowCount($condition)
{
$sql=" select count(*) from poling_history where ".$condition;
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
$sql="select Pid,Rsl,History from poling_history where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Pid']=$row['Pid'];//Primary Key-1
$tRow[$i]['Rsl']=$row['Rsl'];//Primary Key-2
$tRow[$i]['History']=$row['History'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getPid()
{
return($this->Pid);
}

public function setPid($str)
{
$this->Pid=$str;
}

public function getRsl()
{
return($this->Rsl);
}

public function setRsl($str)
{
$this->Rsl=$str;
}

public function getHistory()
{
return($this->History);
}

public function setHistory($str)
{
$this->History=$str;
}

public function getE_date()
{
return($this->E_date);
}

public function setE_date($str)
{
$this->E_date=$str;
}

public function getE_time()
{
return($this->E_time);
}

public function setE_time($str)
{
$this->E_time=$str;
}

public function getUser_name()
{
return($this->User_name);
}

public function setUser_name($str)
{
$this->User_name=$str;
}

public function getClient_ip()
{
return($this->Client_ip);
}

public function setClient_ip($str)
{
$this->Client_ip=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Pid,Rsl,History,E_date,E_time,User_name,Client_ip from poling_history where Pid='".$this->Pid."' and Rsl='".$this->Rsl."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['History'])>0)
$this->Old_History=$row['History'];
else
$this->Old_History="NULL";
if (strlen($row['E_date'])>0)
$this->Old_E_date=substr($row['E_date'],0,10);
else
$this->Old_E_date="NULL";
if (strlen($row['E_time'])>0)
$this->Old_E_time=$row['E_time'];
else
$this->Old_E_time="NULL";
if (strlen($row['User_name'])>0)
$this->Old_User_name=$row['User_name'];
else
$this->Old_User_name="NULL";
if (strlen($row['Client_ip'])>0)
$this->Old_Client_ip=$row['Client_ip'];
else
$this->Old_Client_ip="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Pid,Rsl,History,E_date,E_time,User_name,Client_ip from poling_history where Pid='".$this->Pid."' and Rsl='".$this->Rsl."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->History=$row['History'];
$this->E_date=$row['E_date'];
$this->E_time=$row['E_time'];
$this->User_name=$row['User_name'];
$this->Client_ip=$row['Client_ip'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Pid from poling_history where Pid='".$this->Pid."' and Rsl='".$this->Rsl."'";
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
$sql="delete from poling_history where Pid='".$this->Pid."' and Rsl='".$this->Rsl."'";
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
$sql="update poling_history set ";
if ($this->Old_History!=$this->History &&  strlen($this->History)>0)
{
if ($this->History=="NULL")
$sql=$sql."History=NULL";
else
$sql=$sql."History='".$this->History."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."History=".$this->History.", ";
}

if ($this->Old_E_date!=$this->E_date &&  strlen($this->E_date)>0)
{
if ($this->E_date=="NULL")
$sql=$sql."E_date=NULL";
else
$sql=$sql."E_date='".$this->E_date."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."E_date=".$this->E_date.", ";
}

if ($this->Old_E_time!=$this->E_time &&  strlen($this->E_time)>0)
{
if ($this->E_time=="NULL")
$sql=$sql."E_time=NULL";
else
$sql=$sql."E_time='".$this->E_time."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."E_time=".$this->E_time.", ";
}

if ($this->Old_User_name!=$this->User_name &&  strlen($this->User_name)>0)
{
if ($this->User_name=="NULL")
$sql=$sql."User_name=NULL";
else
$sql=$sql."User_name='".$this->User_name."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."User_name=".$this->User_name.", ";
}

if ($this->Old_Client_ip!=$this->Client_ip &&  strlen($this->Client_ip)>0)
{
if ($this->Client_ip=="NULL")
$sql=$sql."Client_ip=NULL";
else
$sql=$sql."Client_ip='".$this->Client_ip."'";
$i++;
$this->updateList=$this->updateList."Client_ip=".$this->Client_ip.", ";
}
else
$sql=$sql."Client_ip=Client_ip";


$cond="  where Pid='".$this->Pid."' and Rsl='".$this->Rsl."'";
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
$sql1="insert into poling_history(";
$sql=" values (";
$mcol=0;
if (strlen($this->Pid)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Pid";
if ($this->Pid=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pid."'";
$this->updateList=$this->updateList."Pid=".$this->Pid.", ";
}

if (strlen($this->Rsl)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rsl";
if ($this->Rsl=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rsl."'";
$this->updateList=$this->updateList."Rsl=".$this->Rsl.", ";
}

if (strlen($this->History)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."History";
if ($this->History=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->History."'";
$this->updateList=$this->updateList."History=".$this->History.", ";
}

if (strlen($this->E_date)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."E_date";
if ($this->E_date=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->E_date."'";
$this->updateList=$this->updateList."E_date=".$this->E_date.", ";
}

if (strlen($this->E_time)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."E_time";
if ($this->E_time=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->E_time."'";
$this->updateList=$this->updateList."E_time=".$this->E_time.", ";
}

if (strlen($this->User_name)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."User_name";
if ($this->User_name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->User_name."'";
$this->updateList=$this->updateList."User_name=".$this->User_name.", ";
}

if (strlen($this->Client_ip)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Client_ip";
if ($this->Client_ip=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Client_ip."'";
$this->updateList=$this->updateList."Client_ip=".$this->Client_ip.", ";
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


public function maxPid()
{
$sql="select max(Pid) from poling_history";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function maxRsl()
{
if(strlen($this->Pid)>0)
$cond="Pid=".$this->Pid;
else
$cond="1=1";
$sql="select max(Rsl) from poling_history where ".$cond;
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
$sql="select Pid,Rsl,History,E_date,E_time,User_name,Client_ip from poling_history where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Pid']=$row['Pid'];
$tRows[$i]['Rsl']=$row['Rsl'];
$tRows[$i]['History']=$row['History'];
$tRows[$i]['E_date']=$row['E_date'];
$tRows[$i]['E_time']=$row['E_time'];
$tRows[$i]['User_name']=$row['User_name'];
$tRows[$i]['Client_ip']=$row['Client_ip'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Pid,Rsl,History,E_date,E_time,User_name,Client_ip from poling_history where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Pid']=$row['Pid'];
$tRows[$i]['Rsl']=$row['Rsl'];
$tRows[$i]['History']=$row['History'];
$tRows[$i]['E_date']=$row['E_date'];
$tRows[$i]['E_time']=$row['E_time'];
$tRows[$i]['User_name']=$row['User_name'];
$tRows[$i]['Client_ip']=$row['Client_ip'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
