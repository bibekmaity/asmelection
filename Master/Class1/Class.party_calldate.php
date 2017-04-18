<body>
<?php
require_once 'class.config.php';
class Party_calldate
{
private $Code;
private $Mydate;
private $Polldate;
private $Mydate1;
private $Repoldate;
private $Assemble_place;
private $Poll_starttime;
private $Poll_endtime;
private $Mplace;
private $Mdate;
private $Msignature;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Mydate;
private $Old_Polldate;
private $Old_Mydate1;
private $Old_Repoldate;
private $Old_Assemble_place;
private $Old_Poll_starttime;
private $Old_Poll_endtime;
private $Old_Mplace;
private $Old_Mdate;
private $Old_Msignature;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Party_calldate()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from party_calldate";
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
$sql=" select count(*) from party_calldate where ".$condition;
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
$sql="select Code,Mydate from party_calldate where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Code']=$row['Code'];//Primary Key-1
$tRow[$i]['Mydate']=$row['Mydate'];//Posible Unique Field
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

public function getMydate()
{
return($this->Mydate);
}

public function setMydate($str)
{
$this->Mydate=$str;
}

public function getPolldate()
{
return($this->Polldate);
}

public function setPolldate($str)
{
$this->Polldate=$str;
}

public function getMydate1()
{
return($this->Mydate1);
}

public function setMydate1($str)
{
$this->Mydate1=$str;
}

public function getRepoldate()
{
return($this->Repoldate);
}

public function setRepoldate($str)
{
$this->Repoldate=$str;
}

public function getAssemble_place()
{
return($this->Assemble_place);
}

public function setAssemble_place($str)
{
$this->Assemble_place=$str;
}

public function getPoll_starttime()
{
return($this->Poll_starttime);
}

public function setPoll_starttime($str)
{
$this->Poll_starttime=$str;
}

public function getPoll_endtime()
{
return($this->Poll_endtime);
}

public function setPoll_endtime($str)
{
$this->Poll_endtime=$str;
}

public function getMplace()
{
return($this->Mplace);
}

public function setMplace($str)
{
$this->Mplace=$str;
}

public function getMdate()
{
return($this->Mdate);
}

public function setMdate($str)
{
$this->Mdate=$str;
}

public function getMsignature()
{
return($this->Msignature);
}

public function setMsignature($str)
{
$this->Msignature=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature from party_calldate where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Mydate'])>0)
$this->Old_Mydate=$row['Mydate'];
else
$this->Old_Mydate="NULL";
if (strlen($row['Polldate'])>0)
$this->Old_Polldate=$row['Polldate'];
else
$this->Old_Polldate="NULL";
if (strlen($row['Mydate1'])>0)
$this->Old_Mydate1=$row['Mydate1'];
else
$this->Old_Mydate1="NULL";
if (strlen($row['Repoldate'])>0)
$this->Old_Repoldate=$row['Repoldate'];
else
$this->Old_Repoldate="NULL";
if (strlen($row['Assemble_place'])>0)
$this->Old_Assemble_place=$row['Assemble_place'];
else
$this->Old_Assemble_place="NULL";
if (strlen($row['Poll_starttime'])>0)
$this->Old_Poll_starttime=$row['Poll_starttime'];
else
$this->Old_Poll_starttime="NULL";
if (strlen($row['Poll_endtime'])>0)
$this->Old_Poll_endtime=$row['Poll_endtime'];
else
$this->Old_Poll_endtime="NULL";
if (strlen($row['Mplace'])>0)
$this->Old_Mplace=$row['Mplace'];
else
$this->Old_Mplace="NULL";
if (strlen($row['Mdate'])>0)
$this->Old_Mdate=$row['Mdate'];
else
$this->Old_Mdate="NULL";
if (strlen($row['Msignature'])>0)
$this->Old_Msignature=$row['Msignature'];
else
$this->Old_Msignature="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature from party_calldate where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Mydate=$row['Mydate'];
$this->Polldate=$row['Polldate'];
$this->Mydate1=$row['Mydate1'];
$this->Repoldate=$row['Repoldate'];
$this->Assemble_place=$row['Assemble_place'];
$this->Poll_starttime=$row['Poll_starttime'];
$this->Poll_endtime=$row['Poll_endtime'];
$this->Mplace=$row['Mplace'];
$this->Mdate=$row['Mdate'];
$this->Msignature=$row['Msignature'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from party_calldate where Code='".$this->Code."'";
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
$sql="update party_calldate set ";
if ($this->Old_Mydate!=$this->Mydate &&  strlen($this->Mydate)>0)
{
if ($this->Mydate=="NULL")
$sql=$sql."Mydate=NULL";
else
$sql=$sql."Mydate='".$this->Mydate."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Mydate=".$this->Mydate.", ";
}

if ($this->Old_Polldate!=$this->Polldate &&  strlen($this->Polldate)>0)
{
if ($this->Polldate=="NULL")
$sql=$sql."Polldate=NULL";
else
$sql=$sql."Polldate='".$this->Polldate."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Polldate=".$this->Polldate.", ";
}

if ($this->Old_Mydate1!=$this->Mydate1 &&  strlen($this->Mydate1)>0)
{
if ($this->Mydate1=="NULL")
$sql=$sql."Mydate1=NULL";
else
$sql=$sql."Mydate1='".$this->Mydate1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Mydate1=".$this->Mydate1.", ";
}

if ($this->Old_Repoldate!=$this->Repoldate &&  strlen($this->Repoldate)>0)
{
if ($this->Repoldate=="NULL")
$sql=$sql."Repoldate=NULL";
else
$sql=$sql."Repoldate='".$this->Repoldate."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Repoldate=".$this->Repoldate.", ";
}

if ($this->Old_Assemble_place!=$this->Assemble_place &&  strlen($this->Assemble_place)>0)
{
if ($this->Assemble_place=="NULL")
$sql=$sql."Assemble_place=NULL";
else
$sql=$sql."Assemble_place='".$this->Assemble_place."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Assemble_place=".$this->Assemble_place.", ";
}

if ($this->Old_Poll_starttime!=$this->Poll_starttime &&  strlen($this->Poll_starttime)>0)
{
if ($this->Poll_starttime=="NULL")
$sql=$sql."Poll_starttime=NULL";
else
$sql=$sql."Poll_starttime='".$this->Poll_starttime."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Poll_starttime=".$this->Poll_starttime.", ";
}

if ($this->Old_Poll_endtime!=$this->Poll_endtime &&  strlen($this->Poll_endtime)>0)
{
if ($this->Poll_endtime=="NULL")
$sql=$sql."Poll_endtime=NULL";
else
$sql=$sql."Poll_endtime='".$this->Poll_endtime."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Poll_endtime=".$this->Poll_endtime.", ";
}

if ($this->Old_Mplace!=$this->Mplace &&  strlen($this->Mplace)>0)
{
if ($this->Mplace=="NULL")
$sql=$sql."Mplace=NULL";
else
$sql=$sql."Mplace='".$this->Mplace."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Mplace=".$this->Mplace.", ";
}

if ($this->Old_Mdate!=$this->Mdate &&  strlen($this->Mdate)>0)
{
if ($this->Mdate=="NULL")
$sql=$sql."Mdate=NULL";
else
$sql=$sql."Mdate='".$this->Mdate."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Mdate=".$this->Mdate.", ";
}

if ($this->Old_Msignature!=$this->Msignature &&  strlen($this->Msignature)>0)
{
if ($this->Msignature=="NULL")
$sql=$sql."Msignature=NULL";
else
$sql=$sql."Msignature='".$this->Msignature."'";
$i++;
$this->updateList=$this->updateList."Msignature=".$this->Msignature.", ";
}
else
$sql=$sql."Msignature=Msignature";


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
$sql1="insert into party_calldate(";
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

if (strlen($this->Mydate)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Mydate";
if ($this->Mydate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mydate."'";
}

if (strlen($this->Polldate)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Polldate";
if ($this->Polldate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Polldate."'";
}

if (strlen($this->Mydate1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Mydate1";
if ($this->Mydate1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mydate1."'";
}

if (strlen($this->Repoldate)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Repoldate";
if ($this->Repoldate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Repoldate."'";
}

if (strlen($this->Assemble_place)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Assemble_place";
if ($this->Assemble_place=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Assemble_place."'";
}

if (strlen($this->Poll_starttime)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Poll_starttime";
if ($this->Poll_starttime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poll_starttime."'";
}

if (strlen($this->Poll_endtime)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Poll_endtime";
if ($this->Poll_endtime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poll_endtime."'";
}

if (strlen($this->Mplace)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Mplace";
if ($this->Mplace=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mplace."'";
}

if (strlen($this->Mdate)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Mdate";
if ($this->Mdate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mdate."'";
}

if (strlen($this->Msignature)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Msignature";
if ($this->Msignature=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Msignature."'";
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
$sql="select max(Code) from party_calldate";
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
$sql="select Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature from party_calldate where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Mydate']=$row['Mydate'];
$tRows[$i]['Polldate']=$row['Polldate'];
$tRows[$i]['Mydate1']=$row['Mydate1'];
$tRows[$i]['Repoldate']=$row['Repoldate'];
$tRows[$i]['Assemble_place']=$row['Assemble_place'];
$tRows[$i]['Poll_starttime']=$row['Poll_starttime'];
$tRows[$i]['Poll_endtime']=$row['Poll_endtime'];
$tRows[$i]['Mplace']=$row['Mplace'];
$tRows[$i]['Mdate']=$row['Mdate'];
$tRows[$i]['Msignature']=$row['Msignature'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature from party_calldate where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Mydate']=$row['Mydate'];
$tRows[$i]['Polldate']=$row['Polldate'];
$tRows[$i]['Mydate1']=$row['Mydate1'];
$tRows[$i]['Repoldate']=$row['Repoldate'];
$tRows[$i]['Assemble_place']=$row['Assemble_place'];
$tRows[$i]['Poll_starttime']=$row['Poll_starttime'];
$tRows[$i]['Poll_endtime']=$row['Poll_endtime'];
$tRows[$i]['Mplace']=$row['Mplace'];
$tRows[$i]['Mdate']=$row['Mdate'];
$tRows[$i]['Msignature']=$row['Msignature'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
