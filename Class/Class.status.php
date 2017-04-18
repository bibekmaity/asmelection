<?php
require_once 'class.config.php';
class Status
{
private $Serial;
private $First_level;
private $Evm_group;
private $Training_group;
private $Poll_group;
private $Micro_trg;
private $Micro_group;
private $Entry_stop;
private $Alloweditaftergrouping;
private $Randomised;
private $Linkcode;

//extra Old Variable to store Pre update Data
private $Old_Serial;
private $Old_First_level;
private $Old_Evm_group;
private $Old_Training_group;
private $Old_Poll_group;
private $Old_Micro_trg;
private $Old_Micro_group;
private $Old_Entry_stop;
private $Old_Alloweditaftergrouping;
private $Old_Randomised;
private $Old_Linkcode;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_First_level="N";
private $Def_Micro_trg="N";
private $Def_Micro_group="N";
private $Def_Randomised="0";
private $Def_Linkcode="0";
//public function _construct($i) //for PHP6
public function Status()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from status";
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
$sql=" select count(*) from status where ".$condition;
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
$sql="select Serial,Micro_trg from status where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Serial']=$row['Serial'];//Primary Key-1
$tRow[$i]['Micro_trg']=$row['Micro_trg'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getSerial()
{
return($this->Serial);
}

public function setSerial($str)
{
$this->Serial=$str;
}

public function getFirst_level()
{
return($this->First_level);
}

public function setFirst_level($str)
{
$this->First_level=$str;
}

public function getEvm_group()
{
return($this->Evm_group);
}

public function setEvm_group($str)
{
$this->Evm_group=$str;
}

public function getTraining_group()
{
return($this->Training_group);
}

public function setTraining_group($str)
{
$this->Training_group=$str;
}

public function getPoll_group()
{
return($this->Poll_group);
}

public function setPoll_group($str)
{
$this->Poll_group=$str;
}

public function getMicro_trg()
{
return($this->Micro_trg);
}

public function setMicro_trg($str)
{
$this->Micro_trg=$str;
}

public function getMicro_group()
{
return($this->Micro_group);
}

public function setMicro_group($str)
{
$this->Micro_group=$str;
}

public function getEntry_stop()
{
return($this->Entry_stop);
}

public function setEntry_stop($str)
{
$this->Entry_stop=$str;
}

public function getAlloweditaftergrouping()
{
return($this->Alloweditaftergrouping);
}

public function setAlloweditaftergrouping($str)
{
$this->Alloweditaftergrouping=$str;
}

public function getRandomised()
{
return($this->Randomised);
}

public function setRandomised($str)
{
$this->Randomised=$str;
}

public function getLinkcode()
{
return($this->Linkcode);
}

public function setLinkcode($str)
{
$this->Linkcode=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Serial,First_level,Evm_group,Training_group,Poll_group,Micro_trg,Micro_group,Entry_stop,Alloweditaftergrouping,Randomised,Linkcode from status where Serial='".$this->Serial."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['First_level'])>0)
$this->Old_First_level=$row['First_level'];
else
$this->Old_First_level="NULL";
if (strlen($row['Evm_group'])>0)
$this->Old_Evm_group=$row['Evm_group'];
else
$this->Old_Evm_group="NULL";
if (strlen($row['Training_group'])>0)
$this->Old_Training_group=$row['Training_group'];
else
$this->Old_Training_group="NULL";
if (strlen($row['Poll_group'])>0)
$this->Old_Poll_group=$row['Poll_group'];
else
$this->Old_Poll_group="NULL";
if (strlen($row['Micro_trg'])>0)
$this->Old_Micro_trg=$row['Micro_trg'];
else
$this->Old_Micro_trg="NULL";
if (strlen($row['Micro_group'])>0)
$this->Old_Micro_group=$row['Micro_group'];
else
$this->Old_Micro_group="NULL";
if (strlen($row['Entry_stop'])>0)
$this->Old_Entry_stop=$row['Entry_stop'];
else
$this->Old_Entry_stop="NULL";
if (strlen($row['Alloweditaftergrouping'])>0)
$this->Old_Alloweditaftergrouping=$row['Alloweditaftergrouping'];
else
$this->Old_Alloweditaftergrouping="NULL";
if (strlen($row['Randomised'])>0)
$this->Old_Randomised=$row['Randomised'];
else
$this->Old_Randomised="NULL";
if (strlen($row['Linkcode'])>0)
$this->Old_Linkcode=$row['Linkcode'];
else
$this->Old_Linkcode="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Serial,First_level,Evm_group,Training_group,Poll_group,Micro_trg,Micro_group,Entry_stop,Alloweditaftergrouping,Randomised,Linkcode from status where Serial='".$this->Serial."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->First_level=$row['First_level'];
$this->Evm_group=$row['Evm_group'];
$this->Training_group=$row['Training_group'];
$this->Poll_group=$row['Poll_group'];
$this->Micro_trg=$row['Micro_trg'];
$this->Micro_group=$row['Micro_group'];
$this->Entry_stop=$row['Entry_stop'];
$this->Alloweditaftergrouping=$row['Alloweditaftergrouping'];
$this->Randomised=$row['Randomised'];
$this->Linkcode=$row['Linkcode'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Serial from status where Serial='".$this->Serial."'";
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
$sql="delete from status where Serial='".$this->Serial."'";
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
$sql="update status set ";
if ($this->Old_First_level!=$this->First_level &&  strlen($this->First_level)>0)
{
if ($this->First_level=="NULL")
$sql=$sql."First_level=NULL";
else
$sql=$sql."First_level='".$this->First_level."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."First_level=".$this->First_level.", ";
}

if ($this->Old_Evm_group!=$this->Evm_group &&  strlen($this->Evm_group)>0)
{
if ($this->Evm_group=="NULL")
$sql=$sql."Evm_group=NULL";
else
$sql=$sql."Evm_group='".$this->Evm_group."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Evm_group=".$this->Evm_group.", ";
}

if ($this->Old_Training_group!=$this->Training_group &&  strlen($this->Training_group)>0)
{
if ($this->Training_group=="NULL")
$sql=$sql."Training_group=NULL";
else
$sql=$sql."Training_group='".$this->Training_group."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Training_group=".$this->Training_group.", ";
}

if ($this->Old_Poll_group!=$this->Poll_group &&  strlen($this->Poll_group)>0)
{
if ($this->Poll_group=="NULL")
$sql=$sql."Poll_group=NULL";
else
$sql=$sql."Poll_group='".$this->Poll_group."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Poll_group=".$this->Poll_group.", ";
}

if ($this->Old_Micro_trg!=$this->Micro_trg &&  strlen($this->Micro_trg)>0)
{
if ($this->Micro_trg=="NULL")
$sql=$sql."Micro_trg=NULL";
else
$sql=$sql."Micro_trg='".$this->Micro_trg."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Micro_trg=".$this->Micro_trg.", ";
}

if ($this->Old_Micro_group!=$this->Micro_group &&  strlen($this->Micro_group)>0)
{
if ($this->Micro_group=="NULL")
$sql=$sql."Micro_group=NULL";
else
$sql=$sql."Micro_group='".$this->Micro_group."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Micro_group=".$this->Micro_group.", ";
}

if ($this->Old_Entry_stop!=$this->Entry_stop &&  strlen($this->Entry_stop)>0)
{
if ($this->Entry_stop=="NULL")
$sql=$sql."Entry_stop=NULL";
else
$sql=$sql."Entry_stop='".$this->Entry_stop."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Entry_stop=".$this->Entry_stop.", ";
}

if ($this->Old_Alloweditaftergrouping!=$this->Alloweditaftergrouping &&  strlen($this->Alloweditaftergrouping)>0)
{
if ($this->Alloweditaftergrouping=="NULL")
$sql=$sql."Alloweditaftergrouping=NULL";
else
$sql=$sql."Alloweditaftergrouping='".$this->Alloweditaftergrouping."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Alloweditaftergrouping=".$this->Alloweditaftergrouping.", ";
}

if ($this->Old_Randomised!=$this->Randomised &&  strlen($this->Randomised)>0)
{
if ($this->Randomised=="NULL")
$sql=$sql."Randomised=NULL";
else
$sql=$sql."Randomised='".$this->Randomised."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Randomised=".$this->Randomised.", ";
}

if ($this->Old_Linkcode!=$this->Linkcode &&  strlen($this->Linkcode)>0)
{
if ($this->Linkcode=="NULL")
$sql=$sql."Linkcode=NULL";
else
$sql=$sql."Linkcode='".$this->Linkcode."'";
$i++;
$this->updateList=$this->updateList."Linkcode=".$this->Linkcode.", ";
}
else
$sql=$sql."Linkcode=Linkcode";


$cond="  where Serial='".$this->Serial."'";
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
$sql1="insert into status(";
$sql=" values (";
$mcol=0;
if (strlen($this->Serial)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Serial";
if ($this->Serial=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Serial."'";
$this->updateList=$this->updateList."Serial=".$this->Serial.", ";
}

if (strlen($this->First_level)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."First_level";
if ($this->First_level=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->First_level."'";
$this->updateList=$this->updateList."First_level=".$this->First_level.", ";
}

if (strlen($this->Evm_group)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Evm_group";
if ($this->Evm_group=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Evm_group."'";
$this->updateList=$this->updateList."Evm_group=".$this->Evm_group.", ";
}

if (strlen($this->Training_group)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Training_group";
if ($this->Training_group=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Training_group."'";
$this->updateList=$this->updateList."Training_group=".$this->Training_group.", ";
}

if (strlen($this->Poll_group)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Poll_group";
if ($this->Poll_group=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poll_group."'";
$this->updateList=$this->updateList."Poll_group=".$this->Poll_group.", ";
}

if (strlen($this->Micro_trg)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Micro_trg";
if ($this->Micro_trg=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micro_trg."'";
$this->updateList=$this->updateList."Micro_trg=".$this->Micro_trg.", ";
}

if (strlen($this->Micro_group)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Micro_group";
if ($this->Micro_group=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micro_group."'";
$this->updateList=$this->updateList."Micro_group=".$this->Micro_group.", ";
}

if (strlen($this->Entry_stop)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Entry_stop";
if ($this->Entry_stop=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Entry_stop."'";
$this->updateList=$this->updateList."Entry_stop=".$this->Entry_stop.", ";
}

if (strlen($this->Alloweditaftergrouping)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Alloweditaftergrouping";
if ($this->Alloweditaftergrouping=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Alloweditaftergrouping."'";
$this->updateList=$this->updateList."Alloweditaftergrouping=".$this->Alloweditaftergrouping.", ";
}

if (strlen($this->Randomised)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Randomised";
if ($this->Randomised=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Randomised."'";
$this->updateList=$this->updateList."Randomised=".$this->Randomised.", ";
}

if (strlen($this->Linkcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Linkcode";
if ($this->Linkcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Linkcode."'";
$this->updateList=$this->updateList."Linkcode=".$this->Linkcode.", ";
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


public function maxSerial()
{
$sql="select max(Serial) from status";
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
$sql="select Serial,First_level,Evm_group,Training_group,Poll_group,Micro_trg,Micro_group,Entry_stop,Alloweditaftergrouping,Randomised,Linkcode from status where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Serial']=$row['Serial'];
$tRows[$i]['First_level']=$row['First_level'];
$tRows[$i]['Evm_group']=$row['Evm_group'];
$tRows[$i]['Training_group']=$row['Training_group'];
$tRows[$i]['Poll_group']=$row['Poll_group'];
$tRows[$i]['Micro_trg']=$row['Micro_trg'];
$tRows[$i]['Micro_group']=$row['Micro_group'];
$tRows[$i]['Entry_stop']=$row['Entry_stop'];
$tRows[$i]['Alloweditaftergrouping']=$row['Alloweditaftergrouping'];
$tRows[$i]['Randomised']=$row['Randomised'];
$tRows[$i]['Linkcode']=$row['Linkcode'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Serial,First_level,Evm_group,Training_group,Poll_group,Micro_trg,Micro_group,Entry_stop,Alloweditaftergrouping,Randomised,Linkcode from status where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Serial']=$row['Serial'];
$tRows[$i]['First_level']=$row['First_level'];
$tRows[$i]['Evm_group']=$row['Evm_group'];
$tRows[$i]['Training_group']=$row['Training_group'];
$tRows[$i]['Poll_group']=$row['Poll_group'];
$tRows[$i]['Micro_trg']=$row['Micro_trg'];
$tRows[$i]['Micro_group']=$row['Micro_group'];
$tRows[$i]['Entry_stop']=$row['Entry_stop'];
$tRows[$i]['Alloweditaftergrouping']=$row['Alloweditaftergrouping'];
$tRows[$i]['Randomised']=$row['Randomised'];
$tRows[$i]['Linkcode']=$row['Linkcode'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
