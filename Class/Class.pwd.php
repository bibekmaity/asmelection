<?php
require_once 'class.config.php';
class Pwd
{
private $Uid;
private $Pwd;
private $Roll;
private $Active;
private $Fullname;
private $First_login;

//extra Old Variable to store Pre update Data
private $Old_Uid;
private $Old_Pwd;
private $Old_Roll;
private $Old_Active;
private $Old_Fullname;
private $Old_First_login;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_First_login="Y";
//public function _construct($i) //for PHP6
public function Pwd()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from pwd";
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
$sql=" select count(*) from pwd where ".$condition;
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
$sql="select UID,Fullname from pwd where ".$this->condString." order by uid";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
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

public function getPwd()
{
return($this->Pwd);
}

public function setPwd($str)
{
$this->Pwd=$str;
}

public function getRoll()
{
return($this->Roll);
}

public function setRoll($str)
{
$this->Roll=$str;
}

public function getActive()
{
return($this->Active);
}

public function setActive($str)
{
$this->Active=$str;
}

public function getFullname()
{
return($this->Fullname);
}

public function setFullname($str)
{
$this->Fullname=$str;
}

public function getFirst_login()
{
return($this->First_login);
}

public function setFirst_login($str)
{
$this->First_login=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Uid,Pwd,Roll,Active,Fullname,First_login from pwd where Uid='".$this->Uid."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Pwd'])>0)
$this->Old_Pwd=$row['Pwd'];
else
$this->Old_Pwd="NULL";
if (strlen($row['Roll'])>0)
$this->Old_Roll=$row['Roll'];
else
$this->Old_Roll="NULL";
if (strlen($row['Active'])>0)
$this->Old_Active=$row['Active'];
else
$this->Old_Active="NULL";
if (strlen($row['Fullname'])>0)
$this->Old_Fullname=$row['Fullname'];
else
$this->Old_Fullname="NULL";
if (strlen($row['First_login'])>0)
$this->Old_First_login=$row['First_login'];
else
$this->Old_First_login="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Uid,Pwd,Roll,Active,Fullname,First_login from pwd where Uid='".$this->Uid."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Pwd=$row['Pwd'];
$this->Roll=$row['Roll'];
$this->Active=$row['Active'];
$this->Fullname=$row['Fullname'];
$this->First_login=$row['First_login'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Uid from pwd where Uid='".$this->Uid."'";
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
$sql="delete from pwd where Uid='".$this->Uid."'";
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
$sql="update pwd set ";
if ($this->Old_Pwd!=$this->Pwd &&  strlen($this->Pwd)>0)
{
if ($this->Pwd=="NULL")
$sql=$sql."Pwd=NULL";
else
$sql=$sql."Pwd='".$this->Pwd."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Pwd=".$this->Pwd.", ";
}

if ($this->Old_Roll!=$this->Roll &&  strlen($this->Roll)>0)
{
if ($this->Roll=="NULL")
$sql=$sql."Roll=NULL";
else
$sql=$sql."Roll='".$this->Roll."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Roll=".$this->Roll.", ";
}

//if ($this->Old_Active!=$this->Active &&  strlen($this->Active)>0)
//{
if ($this->Active==0)
$sql=$sql."Active=0";
else
$sql=$sql."Active=1";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Active=".$this->Active.", ";
//}

if ($this->Old_Fullname!=$this->Fullname &&  strlen($this->Fullname)>0)
{
if ($this->Fullname=="NULL")
$sql=$sql."Fullname=NULL";
else
$sql=$sql."Fullname='".$this->Fullname."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Fullname=".$this->Fullname.", ";
}

if ($this->Old_First_login!=$this->First_login &&  strlen($this->First_login)>0)
{
if ($this->First_login=="NULL")
$sql=$sql."First_login=NULL";
else
$sql=$sql."First_login='".$this->First_login."'";
$i++;
$this->updateList=$this->updateList."First_login=".$this->First_login.", ";
}
else
$sql=$sql."First_login=First_login";


$cond="  where Uid='".$this->Uid."'";
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
$sql1="insert into pwd(";
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

if (strlen($this->Pwd)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Pwd";
if ($this->Pwd=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pwd."'";
$this->updateList=$this->updateList."Pwd=".$this->Pwd.", ";
}

if (strlen($this->Roll)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Roll";
if ($this->Roll=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Roll."'";
$this->updateList=$this->updateList."Roll=".$this->Roll.", ";
}

//if (strlen($this->Active)>0)
//{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Active";
if ($this->Active==0)
$sql=$sql."0";
else
$sql=$sql."1";
$this->updateList=$this->updateList."Active=".$this->Active.", ";
//}

if (strlen($this->Fullname)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Fullname";
if ($this->Fullname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Fullname."'";
$this->updateList=$this->updateList."Fullname=".$this->Fullname.", ";
}

if (strlen($this->First_login)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."First_login";
if ($this->First_login=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->First_login."'";
$this->updateList=$this->updateList."First_login=".$this->First_login.", ";
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


public function getAllRecord()
{
$tRows=array();
$sql="select Uid,Pwd,Roll,Active,Fullname,First_login from pwd where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Uid']=$row['Uid'];
$tRows[$i]['Pwd']=$row['Pwd'];
$tRows[$i]['Roll']=$row['Roll'];
$tRows[$i]['Active']=$row['Active'];
$tRows[$i]['Fullname']=$row['Fullname'];
$tRows[$i]['First_login']=$row['First_login'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Uid,Pwd,Roll,Active,Fullname,First_login from pwd where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Uid']=$row['Uid'];
$tRows[$i]['Pwd']=$row['Pwd'];
$tRows[$i]['Roll']=$row['Roll'];
$tRows[$i]['Active']=$row['Active'];
$tRows[$i]['Fullname']=$row['Fullname'];
$tRows[$i]['First_login']=$row['First_login'];
$i++;
} //End While
return($tRows);
} //End getAllRecord\

public function FirstLogin($uid)
{
$sql="select First_login from pwd where Uid='".$uid."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if($row['First_login']=="Y")    
$res=true;
else 
$res=false;    
}
else
$res=false;
return($res);
}//First Login

}//End Class
?>
