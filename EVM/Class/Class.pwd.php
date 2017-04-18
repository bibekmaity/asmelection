<body>
<?php
require_once 'class.config.php';
class Pwd
{
private $Uid;
private $Pwd;
private $Roll;
private $Active;
private $Fullname;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

private $Def_Active="Y";
//public function _construct($i) //for PHP6
public function Pwd()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
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


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Uid,Pwd,Roll,Active,Fullname from pwd where Uid='".$this->Uid."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Pwd=$row['Pwd'];
$this->Roll=$row['Roll'];
$this->Active=$row['Active'];
$this->Fullname=$row['Fullname'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from pwd where Uid='".$this->Uid."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update pwd set ";
if (strlen($this->Pwd)>0)
{
if ($this->Pwd=="NULL")
$sql=$sql."Pwd=NULL";
else
$sql=$sql."Pwd='".$this->Pwd."'";
$sql=$sql.",";
}

if (strlen($this->Roll)>0)
{
if ($this->Roll=="NULL")
$sql=$sql."Roll=NULL";
else
$sql=$sql."Roll='".$this->Roll."'";
$sql=$sql.",";
}

if (strlen($this->Active)>0)
{
if ($this->Active=="NULL")
$sql=$sql."Active=NULL";
else
$sql=$sql."Active='".$this->Active."'";
$sql=$sql.",";
}

if (strlen($this->Fullname)>0)
{
if ($this->Fullname=="NULL")
$sql=$sql."Fullname=NULL";
else
$sql=$sql."Fullname='".$this->Fullname."'";
}
else
$sql=$sql."Fullname=Fullname";

$cond="  where Uid='".$this->Uid."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into pwd(Uid,Pwd,Roll,Active,Fullname) values(";
if (strlen($this->Uid)>0)
{
if ($this->Uid=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Uid."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Pwd)>0)
{
if ($this->Pwd=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pwd."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Roll)>0)
{
if ($this->Roll=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Roll."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Active)>0)
{
if ($this->Active=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Active."'";
}
else
$sql=$sql."'Y'";

$sql=$sql.",";

if (strlen($this->Fullname)>0)
{
if ($this->Fullname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Fullname."'";
}
else
$sql=$sql."NULL";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function getAllRecord()
{
$tRows=array();
$sql="select Uid,Pwd,Roll,Active,Fullname from pwd where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Uid']=$row['Uid'];
$tRows[$i]['Pwd']=$row['Pwd'];
$tRows[$i]['Roll']=$row['Roll'];
$tRows[$i]['Active']=$row['Active'];
$tRows[$i]['Fullname']=$row['Fullname'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
