<?php
require_once 'class.config.php';
class Userlog
{
private $Uid;
private $Log_date;
private $Log_time_in;
private $Log_time_out;
private $Client_ip;
private $Session_id;
private $Active;
//extra Old Variable to store Pre update Data
private $Old_Uid;
private $Old_Log_date;
private $Old_Log_time_in;
private $Old_Log_time_out;
private $Old_Client_ip;
private $Old_Session_id;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Userlog()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from userlog";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
$this->Log_date=date('Y-m-d');
if (isset($_SERVER['REMOTE_ADDR']))
$this->Client_ip= $_SERVER['REMOTE_ADDR'];  
else
$this->Client_ip="NA";
//$this->Log_time_in=date('H:i:s');
//$this->Log_time_out=date('H:i:s');

if(isset($_SESSION['sid']))
$this->Session_id=$_SESSION['sid'];
else
$this->Session_id=0;
//echo $this->Log_time_in;
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function rowCount($condition)
{
$sql=" select count(*) from userlog where ".$condition;
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
$sql="select Pwd,Session_id,Uid from userlog where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Uid']=$row['Uid'];//Primary Key-1
$tRow[$i]['Pwd']=$row['Pwd'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getUid()
{
return($this->Uid);
}

public function setUid($str)
{
$this->Uid=$str;
}

public function getLog_date()
{
return($this->Log_date);
}

public function setLog_date($str)
{
$this->Log_date=$str;
}

public function getLog_time_in()
{
return($this->Log_time_in);
}

public function setLog_time_in($str)
{
$this->Log_time_in=$str;
}

public function getLog_time_out()
{
return($this->Log_time_out);
}

public function setLog_time_out($str)
{
$this->Log_time_out=$str;
}

public function getClient_ip()
{
return($this->Client_ip);
}

public function setClient_ip($str)
{
$this->Client_ip=$str;
}

public function getSession_id()
{
return($this->Session_id);
}

public function setSession_id($str)
{
$this->Session_id=$str;
}

public function setActive($str)
{
$this->Active=$str;
}

public function getActive()
{
return($this->Active);
}

public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Uid,Log_date,Log_time_in,Log_time_out,Client_ip,Session_id from userlog where Session_id='".$this->Session_id."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Uid'])>0)
$this->Old_Uid=$row['Uid'];
else
$this->Old_Uid="NULL";
if (strlen($row['Log_date'])>0)
$this->Old_Log_date=substr($row['Log_date'],0,10);
else
$this->Old_Log_date="NULL";
if (strlen($row['Log_time_in'])>0)
$this->Old_Log_time_in=$row['Log_time_in'];
else
$this->Old_Log_time_in="NULL";
if (strlen($row['Log_time_out'])>0)
$this->Old_Log_time_out=$row['Log_time_out'];
else
$this->Old_Log_time_out="NULL";
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
$sql="select Active,Uid,Log_date,Log_time_in,Log_time_out,Client_ip,Session_id from userlog where Session_id='".$this->Session_id."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Active=$row['Active'];
$this->Uid=$row['Uid'];
$this->Log_date=$row['Log_date'];
$this->Log_time_in=$row['Log_time_in'];
$this->Log_time_out=$row['Log_time_out'];
$this->Client_ip=$row['Client_ip'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Uid from userlog where Session_id='".$this->Session_id."'";
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
$sql="delete from userlog where Session_id='".$this->Session_id."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
$this->returnSql=$sql;
return($result);
} //end deleterecord


public function UpdateRecord()
{
if (isset($_SERVER['REMOTE_ADDR']))
$this->Client_ip= $_SERVER['REMOTE_ADDR'];  
else
$this->Client_ip="NA";
    
//$this->Log_time_in=date('h:i:s A');
//$this->Log_time_out=date('H:i:s');

$i=$this->copyVariable();
$i=0;
$this->updateList="";
$sql="update userlog set ";
if ($this->Old_Uid!=$this->Uid &&  strlen($this->Uid)>0)
{
if ($this->Uid=="NULL")
$sql=$sql."Uid=NULL";
else
$sql=$sql."Uid='".$this->Uid."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Uid=".$this->Uid.", ";
}

if ($this->Old_Log_date!=$this->Log_date &&  strlen($this->Log_date)>0)
{
if ($this->Log_date=="NULL")
$sql=$sql."Log_date=NULL";
else
$sql=$sql."Log_date='".$this->Log_date."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Log_date=".$this->Log_date.", ";
}

if ($this->Old_Log_time_in!=$this->Log_time_in &&  strlen($this->Log_time_in)>0)
{
if ($this->Log_time_in=="NULL")
$sql=$sql."Log_time_in=NULL";
else
$sql=$sql."Log_time_in='".$this->Log_time_in."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Log_time_in=".$this->Log_time_in.", ";
}

if ($this->Old_Log_time_out!=$this->Log_time_out &&  strlen($this->Log_time_out)>0)
{
if ($this->Log_time_out=="NULL")
$sql=$sql."Log_time_out=NULL";
else
$sql=$sql."Log_time_out='".$this->Log_time_out."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Log_time_out=".$this->Log_time_out.", ";
}


if ($this->Old_Client_ip!=$this->Client_ip &&  strlen($this->Client_ip)>0)
{
if ($this->Client_ip=="NULL")
$sql=$sql."Client_ip=NULL";
else
$sql=$sql."Client_ip='".$this->Client_ip."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Client_ip=".$this->Client_ip.", ";
}

if (strlen($this->Active)>0)
{
if ($this->Active=="NULL")
$sql=$sql."Active=NULL";
else
$sql=$sql."Active='".$this->Active."'";
$i++;
$this->updateList=$this->updateList."Active=".$this->Active.", ";
}
else
$sql=$sql."Active=Active";


$cond="  where Session_id='".$this->Session_id."'";
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
if (isset($_SERVER['REMOTE_ADDR']))
$this->Client_ip= $_SERVER['REMOTE_ADDR'];  
else
$this->Client_ip="NA";    

//$this->Log_time_in=date('H:i:s');
//$this->Log_time_out=date('H:i:s');

$this->updateList="";
$sql1="insert into userlog(";
$sql=" values (";
$mcol=0;
if (strlen($this->Uid)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Uid";
if ($this->Uid=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Uid."'";
$this->updateList=$this->updateList."Uid=".$this->Uid.", ";
}

if (strlen($this->Log_date)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Log_date";
if ($this->Log_date=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Log_date."'";
$this->updateList=$this->updateList."Log_date=".$this->Log_date.", ";
}

if (strlen($this->Log_time_in)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Log_time_in";
if ($this->Log_time_in=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Log_time_in."'";
$this->updateList=$this->updateList."Log_time_in=".$this->Log_time_in.", ";
}

if (strlen($this->Log_time_out)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Log_time_out";
if ($this->Log_time_out=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Log_time_out."'";
$this->updateList=$this->updateList."Log_time_out=".$this->Log_time_out.", ";
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

if (strlen($this->Active)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Active";
if ($this->Active=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Active."'";
$this->updateList=$this->updateList."Active=".$this->Active.", ";
}



if (strlen($this->Session_id)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Session_id";
if ($this->Session_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Session_id."'";
$this->updateList=$this->updateList."Session_id=".$this->Session_id.", ";
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


public function maxSession_id()
{
$sql="select max(Session_id) from userlog";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}


public function LastSession_id($Uid)
{
$sql="select max(Session_id) from userlog where Log_date='".date('Y-m-d')."' and Uid='".$Uid."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}


public function getAllRecord()
{
$tRows=array();
$sql="select Uid,Log_date,Log_time_in,Log_time_out,Client_ip,Session_id from userlog where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Uid']=$row['Uid'];
$tRows[$i]['Log_date']=$row['Log_date'];
$tRows[$i]['Log_time_in']=$row['Log_time_in'];
$tRows[$i]['Log_time_out']=$row['Log_time_out'];
$tRows[$i]['Client_ip']=$row['Client_ip'];
$tRows[$i]['Session_id']=$row['Session_id'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Uid,Log_date,Log_time_in,Log_time_out,Client_ip,Session_id from userlog where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Uid']=$row['Uid'];
$tRows[$i]['Log_date']=$row['Log_date'];
$tRows[$i]['Log_time_in']=$row['Log_time_in'];
$tRows[$i]['Log_time_out']=$row['Log_time_out'];
$tRows[$i]['Client_ip']=$row['Client_ip'];
$tRows[$i]['Session_id']=$row['Session_id'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function elapsedTimeinSec($t1,$t2)
{
$row=array();
$h1=substr($t1,0,2) ;
$m1=substr($t1,3,2) ;
$s1=substr($t1,6,2) ;    
 
$h2=substr($t2,0,2) ;
$m2=substr($t2,3,2) ;
$s2=substr($t2,6,2) ;  

if ($s2<=$s1)
$s=$s1-$s2;
else
{
$s1=$s1+60;
$m1=$m1-1;
$s=$s1-$s2;
}
//echo "Seconddiff".$s." ";

if ($m2<=$m1)
$m=$m1-$m2;
else
{
$m1=$m1+60;
$h1=$h1-1;
$m=$m1-$m2;
}  
//echo "Minutediff".$m." ";

if ($h2<=$h1)
$h=$h1-$h2;
else 
$h=0;  
//echo "Hourdiff".$h." <br>";
//echo $h.":".$m.":".$s."<br>";
return($h*60*60+$m*60+$s);   
}


public function isActiveUser($Uid,$sec)
{

$sid=$this->LastSession_id($Uid);
$this->setSession_id($sid);
$result=false;
if($this->EditRecord())
{
$t2=$this->getLog_time_out();

$t1=date('H:i:s'); //Present time

//echo "t1".$t1."<br>";
$s=$this->elapsedTimeinSec($t1, $t2);
//echo "Second".$s."<br>";
if($s<$sec)
$result=true; 
}  //$this->Editrec  
//$this->returnSql="id".$sid.":".$t1." -".$t2."=".$s;
return($result);
} //public userstatus


public function isActive($Uid)
{
$sid=$this->LastSession_id($Uid);
$this->setSession_id($sid);
$result=false;
if($this->EditRecord())
{
if($this->getActive()=="Y")
$result=true;
else
$result=false;    
}  //$this->Editrec  
return($result);
} //isActive

public function SessionActive()
{
$result=false;    
if($this->EditRecord())
{
if($this->getActive()=="Y")
$result=true;
else
$result=false;    
}  //$this->Editrec  
return($result);
} //isActive

public function MakeActive()
{
if(isset($_SESSION['uid']))
$uid=$_SESSION['uid'];
else
$uid="-";
$newstr="delete from userlog where uid='unknown' and Client_ip='".$this->Client_ip."'";
$this->ExecuteQuery($newstr);
$newstr="update userlog set Active='Y' where Uid='".$uid."' and Session_id=".$this->LastSession_id($uid);
if($this->ExecuteQuery($newstr))
$_SESSION['sid']=$this->LastSession_id($uid);
$this->returnSql=$newstr;
}//end makeactive

}//End Class
?>
