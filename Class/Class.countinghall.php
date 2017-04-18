<body>
<?php
require_once 'class.config.php';
class Countinghall
{
private $Hall;
private $Lac;
private $Start_table;
private $No_of_table;
private $Ro_name;

//extra Old Variable to store Pre update Data
private $Old_Hall;
private $Old_Lac;
private $Old_Start_table;
private $Old_No_of_table;
private $Old_Ro_name;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Countinghall()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from countinghall";
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
$sql=" select count(*) from countinghall where ".$condition;
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
$sql="select Hall,Lac from countinghall where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Hall']=$row['Hall'];//Primary Key-1
$tRow[$i]['Ro_name']="Hall Number-".$row['Hall']."(Lac-".$row['Lac'].")";//Posible Unique Field
$i++;
}
return($tRow);
}


public function getHall()
{
return($this->Hall);
}

public function setHall($str)
{
$this->Hall=$str;
}

public function getLac()
{
return($this->Lac);
}

public function setLac($str)
{
$this->Lac=$str;
}

public function getStart_table()
{
return($this->Start_table);
}

public function setStart_table($str)
{
$this->Start_table=$str;
}

public function getNo_of_table()
{
return($this->No_of_table);
}

public function setNo_of_table($str)
{
$this->No_of_table=$str;
}

public function getRo_name()
{
return($this->Ro_name);
}

public function setRo_name($str)
{
$this->Ro_name=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Hall,Lac,Start_table,No_of_table,Ro_name from countinghall where Hall='".$this->Hall."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Start_table'])>0)
$this->Old_Start_table=$row['Start_table'];
else
$this->Old_Start_table="NULL";
if (strlen($row['No_of_table'])>0)
$this->Old_No_of_table=$row['No_of_table'];
else
$this->Old_No_of_table="NULL";
if (strlen($row['Ro_name'])>0)
$this->Old_Ro_name=$row['Ro_name'];
else
$this->Old_Ro_name="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Hall,Lac,Start_table,No_of_table,Ro_name from countinghall where Hall='".$this->Hall."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Lac=$row['Lac'];
$this->Start_table=$row['Start_table'];
$this->No_of_table=$row['No_of_table'];
$this->Ro_name=$row['Ro_name'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Hall from countinghall where Hall='".$this->Hall."'";
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
$sql="delete from countinghall where Hall='".$this->Hall."'";
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
$sql="update countinghall set ";
if ($this->Old_Lac!=$this->Lac &&  strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."Lac=NULL";
else
$sql=$sql."Lac='".$this->Lac."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Lac=".$this->Lac.", ";
}

if ($this->Old_Start_table!=$this->Start_table &&  strlen($this->Start_table)>0)
{
if ($this->Start_table=="NULL")
$sql=$sql."Start_table=NULL";
else
$sql=$sql."Start_table='".$this->Start_table."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Start_table=".$this->Start_table.", ";
}

if ($this->Old_No_of_table!=$this->No_of_table &&  strlen($this->No_of_table)>0)
{
if ($this->No_of_table=="NULL")
$sql=$sql."No_of_table=NULL";
else
$sql=$sql."No_of_table='".$this->No_of_table."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."No_of_table=".$this->No_of_table.", ";
}

if ($this->Old_Ro_name!=$this->Ro_name &&  strlen($this->Ro_name)>0)
{
if ($this->Ro_name=="NULL")
$sql=$sql."Ro_name=NULL";
else
$sql=$sql."Ro_name='".$this->Ro_name."'";
$i++;
$this->updateList=$this->updateList."Ro_name=".$this->Ro_name.", ";
}
else
$sql=$sql."Ro_name=Ro_name";


$cond="  where Hall='".$this->Hall."'";
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
$sql1="insert into countinghall(";
$sql=" values (";
$mcol=0;
if (strlen($this->Hall)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Hall";
if ($this->Hall=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hall."'";
$this->updateList=$this->updateList."Hall=".$this->Hall.", ";
}

if (strlen($this->Lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Lac";
if ($this->Lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lac."'";
$this->updateList=$this->updateList."Lac=".$this->Lac.", ";
}

if (strlen($this->Start_table)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Start_table";
if ($this->Start_table=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Start_table."'";
$this->updateList=$this->updateList."Start_table=".$this->Start_table.", ";
}

if (strlen($this->No_of_table)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."No_of_table";
if ($this->No_of_table=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->No_of_table."'";
$this->updateList=$this->updateList."No_of_table=".$this->No_of_table.", ";
}

if (strlen($this->Ro_name)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Ro_name";
if ($this->Ro_name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ro_name."'";
$this->updateList=$this->updateList."Ro_name=".$this->Ro_name.", ";
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


public function maxHall()
{
$sql="select max(Hall) from countinghall";
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
$sql="select Hall,Lac,Start_table,No_of_table,Ro_name from countinghall where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Hall']=$row['Hall'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Start_table']=$row['Start_table'];
$tRows[$i]['No_of_table']=$row['No_of_table'];
$tRows[$i]['Ro_name']=$row['Ro_name'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Hall,Lac,Start_table,No_of_table,Ro_name from countinghall where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Hall']=$row['Hall'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Start_table']=$row['Start_table'];
$tRows[$i]['No_of_table']=$row['No_of_table'];
$tRows[$i]['Ro_name']=$row['Ro_name'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function TotalGroup($lac)
{
$tRows=array();
$sql="select sum(No_of_table) from countinghall where Lac=".$lac;
$i=0;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return("0");    
}




}//End Class
?>
