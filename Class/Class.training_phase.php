<?php
require_once 'class.config.php';
class Training_phase
{
private $Phase_no;
private $Phase_name;
private $Election_district;
private $Letterno;
private $Letter_date;
private $Signature;

//extra Old Variable to store Pre update Data
private $Old_Phase_no;
private $Old_Phase_name;
private $Old_Election_district;
private $Old_Letterno;
private $Old_Letter_date;
private $Old_Signature;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Training_phase()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from training_phase";
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
$sql=" select count(*) from training_phase where ".$condition;
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
$sql="select Phase_no,Phase_name from training_phase where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Phase_no']=$row['Phase_no'];//Primary Key-1
$tRow[$i]['Phase_name']=$row['Phase_name'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getPhase_no()
{
return($this->Phase_no);
}

public function setPhase_no($str)
{
$this->Phase_no=$str;
}

public function getPhase_name()
{
return($this->Phase_name);
}

public function setPhase_name($str)
{
$this->Phase_name=$str;
}

public function getElection_district()
{
return($this->Election_district);
}

public function setElection_district($str)
{
$this->Election_district=$str;
}

public function getLetterno()
{
return($this->Letterno);
}

public function setLetterno($str)
{
$this->Letterno=$str;
}

public function getLetter_date()
{
return($this->Letter_date);
}

public function setLetter_date($str)
{
$this->Letter_date=$str;
}

public function getSignature()
{
return($this->Signature);
}

public function setSignature($str)
{
$this->Signature=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Phase_no,Phase_name,Election_district,Letterno,Letter_date,Signature from training_phase where Phase_no='".$this->Phase_no."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Phase_name'])>0)
$this->Old_Phase_name=$row['Phase_name'];
else
$this->Old_Phase_name="NULL";
if (strlen($row['Election_district'])>0)
$this->Old_Election_district=$row['Election_district'];
else
$this->Old_Election_district="NULL";
if (strlen($row['Letterno'])>0)
$this->Old_Letterno=$row['Letterno'];
else
$this->Old_Letterno="NULL";
if (strlen($row['Letter_date'])>0)
$this->Old_Letter_date=substr($row['Letter_date'],0,10);
else
$this->Old_Letter_date="NULL";
if (strlen($row['Signature'])>0)
$this->Old_Signature=$row['Signature'];
else
$this->Old_Signature="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Phase_no,Phase_name,Election_district,Letterno,Letter_date,Signature from training_phase where Phase_no='".$this->Phase_no."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Phase_name=$row['Phase_name'];
$this->Election_district=$row['Election_district'];
$this->Letterno=$row['Letterno'];
$this->Letter_date=$row['Letter_date'];
$this->Signature=$row['Signature'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Phase_no from training_phase where Phase_no='".$this->Phase_no."'";
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
$sql="delete from training_phase where Phase_no='".$this->Phase_no."'";
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
$sql="update training_phase set ";
if ($this->Old_Phase_name!=$this->Phase_name &&  strlen($this->Phase_name)>0)
{
if ($this->Phase_name=="NULL")
$sql=$sql."Phase_name=NULL";
else
$sql=$sql."Phase_name='".$this->Phase_name."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Phase_name=".$this->Phase_name.", ";
}

if ($this->Old_Election_district!=$this->Election_district &&  strlen($this->Election_district)>0)
{
if ($this->Election_district=="NULL")
$sql=$sql."Election_district=NULL";
else
$sql=$sql."Election_district='".$this->Election_district."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Election_district=".$this->Election_district.", ";
}

if ($this->Old_Letterno!=$this->Letterno &&  strlen($this->Letterno)>0)
{
if ($this->Letterno=="NULL")
$sql=$sql."Letterno=NULL";
else
$sql=$sql."Letterno='".$this->Letterno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Letterno=".$this->Letterno.", ";
}

if ($this->Old_Letter_date!=$this->Letter_date &&  strlen($this->Letter_date)>0)
{
if ($this->Letter_date=="NULL")
$sql=$sql."Letter_date=NULL";
else
$sql=$sql."Letter_date='".$this->Letter_date."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Letter_date=".$this->Letter_date.", ";
}

if ($this->Old_Signature!=$this->Signature &&  strlen($this->Signature)>0)
{
if ($this->Signature=="NULL")
$sql=$sql."Signature=NULL";
else
$sql=$sql."Signature='".$this->Signature."'";
$i++;
$this->updateList=$this->updateList."Signature=".$this->Signature.", ";
}
else
$sql=$sql."Signature=Signature";


$cond="  where Phase_no=".$this->Phase_no;
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
$sql1="insert into training_phase(";
$sql=" values (";
$mcol=0;
if (strlen($this->Phase_no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Phase_no";
if ($this->Phase_no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phase_no."'";
$this->updateList=$this->updateList."Phase_no=".$this->Phase_no.", ";
}

if (strlen($this->Phase_name)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Phase_name";
if ($this->Phase_name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phase_name."'";
$this->updateList=$this->updateList."Phase_name=".$this->Phase_name.", ";
}

if (strlen($this->Election_district)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Election_district";
if ($this->Election_district=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Election_district."'";
$this->updateList=$this->updateList."Election_district=".$this->Election_district.", ";
}

if (strlen($this->Letterno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Letterno";
if ($this->Letterno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Letterno."'";
$this->updateList=$this->updateList."Letterno=".$this->Letterno.", ";
}

if (strlen($this->Letter_date)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Letter_date";
if ($this->Letter_date=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Letter_date."'";
$this->updateList=$this->updateList."Letter_date=".$this->Letter_date.", ";
}

if (strlen($this->Signature)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Signature";
if ($this->Signature=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Signature."'";
$this->updateList=$this->updateList."Signature=".$this->Signature.", ";
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


public function maxPhase_no()
{
$sql="select max(Phase_no) from training_phase";
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
$sql="select Phase_no,Phase_name,Election_district,Letterno,Letter_date,Signature from training_phase where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Phase_no']=$row['Phase_no'];
$tRows[$i]['Phase_name']=$row['Phase_name'];
$tRows[$i]['Election_district']=$row['Election_district'];
$tRows[$i]['Letterno']=$row['Letterno'];
$tRows[$i]['Letter_date']=$row['Letter_date'];
$tRows[$i]['Signature']=$row['Signature'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Phase_no,Phase_name,Election_district,Letterno,Letter_date,Signature from training_phase where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Phase_no']=$row['Phase_no'];
$tRows[$i]['Phase_name']=$row['Phase_name'];
$tRows[$i]['Election_district']=$row['Election_district'];
$tRows[$i]['Letterno']=$row['Letterno'];
$tRows[$i]['Letter_date']=$row['Letter_date'];
$tRows[$i]['Signature']=$row['Signature'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
