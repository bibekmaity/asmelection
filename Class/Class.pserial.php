<?php
require_once 'class.config.php';
class Pserial
{
private $Slno;
private $Depcode;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Pserial()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from pserial";
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



public function getSlno()
{
return($this->Slno);
}

public function setSlno($str)
{
$this->Slno=$str;
}

public function getDepcode()
{
return($this->Depcode);
}

public function setDepcode($str)
{
$this->Depcode=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Slno,Depcode from pserial where Slno='".$this->Slno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Depcode=$row['Depcode'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from pserial where Slno='".$this->Slno."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update pserial set ";
if (strlen($this->Depcode)>0)
{
if ($this->Depcode=="NULL")
$sql=$sql."Depcode=NULL";
else
$sql=$sql."Depcode='".$this->Depcode."'";
}
else
$sql=$sql."Depcode=Depcode";

$cond="  where Slno='".$this->Slno."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into pserial(Slno,Depcode) values(";
if (strlen($this->Slno)>0)
{
if ($this->Slno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Slno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Depcode)>0)
{
if ($this->Depcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Depcode."'";
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

public function maxSlno()
{
$sql="select max(Slno) from pserial";
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
$sql="select Slno,Depcode from pserial where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['Depcode']=$row['Depcode'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
