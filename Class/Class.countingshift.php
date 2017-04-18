<?php
require_once 'class.config.php';
class Countingshift
{
private $Code;
private $Date1;
private $Shiftno;
private $Time1;
private $Reptime;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Countingshift()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from countingshift";
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



public function getCode()
{
return($this->Code);
}

public function setCode($str)
{
$this->Code=$str;
}

public function getDate1()
{
return($this->Date1);
}

public function setDate1($str)
{
$this->Date1=$str;
}

public function getShiftno()
{
return($this->Shiftno);
}

public function setShiftno($str)
{
$this->Shiftno=$str;
}

public function getTime1()
{
return($this->Time1);
}

public function setTime1($str)
{
$this->Time1=$str;
}

public function getReptime()
{
return($this->Reptime);
}

public function setReptime($str)
{
$this->Reptime=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Code,Date1,Shiftno,Time1,Reptime from countingshift where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Date1=$row['Date1'];
$this->Shiftno=$row['Shiftno'];
$this->Time1=$row['Time1'];
$this->Reptime=$row['Reptime'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from countingshift where Code='".$this->Code."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update countingshift set ";
if (strlen($this->Date1)>0)
{
if ($this->Date1=="NULL")
$sql=$sql."Date1=NULL";
else
$sql=$sql."Date1='".$this->Date1."'";
$sql=$sql.",";
}

if (strlen($this->Shiftno)>0)
{
if ($this->Shiftno=="NULL")
$sql=$sql."Shiftno=NULL";
else
$sql=$sql."Shiftno='".$this->Shiftno."'";
$sql=$sql.",";
}

if (strlen($this->Time1)>0)
{
if ($this->Time1=="NULL")
$sql=$sql."Time1=NULL";
else
$sql=$sql."Time1='".$this->Time1."'";
$sql=$sql.",";
}

if (strlen($this->Reptime)>0)
{
if ($this->Reptime=="NULL")
$sql=$sql."Reptime=NULL";
else
$sql=$sql."Reptime='".$this->Reptime."'";
}
else
$sql=$sql."Reptime=Reptime";

$cond="  where Code='".$this->Code."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into countingshift(Code,Date1,Shiftno,Time1,Reptime) values(";
if (strlen($this->Code)>0)
{
if ($this->Code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Code."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Date1)>0)
{
if ($this->Date1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Date1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Shiftno)>0)
{
if ($this->Shiftno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Shiftno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Time1)>0)
{
if ($this->Time1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Time1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Reptime)>0)
{
if ($this->Reptime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Reptime."'";
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

public function maxCode()
{
$sql="select max(Code) from countingshift";
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
$sql="select Code,Date1,Shiftno,Time1,Reptime from countingshift where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Date1']=$row['Date1'];
$tRows[$i]['Shiftno']=$row['Shiftno'];
$tRows[$i]['Time1']=$row['Time1'];
$tRows[$i]['Reptime']=$row['Reptime'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
