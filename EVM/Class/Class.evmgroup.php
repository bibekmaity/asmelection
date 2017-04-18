<body>
<?php
require_once '../class/class.config.php';
class Evmgroup
{
private $Grpno;
private $Lac;
private $Cu;
private $Bu;
private $Psno;
private $Rcode;
private $Reserve;
private $Box_cu;
private $Box_bu;
private $Cu_id;
private $Bu_id;
private $Rnumber;

//extra Old Variable to store Pre update Data
private $Old_Grpno;
private $Old_Lac;
private $Old_Cu;
private $Old_Bu;
private $Old_Psno;
private $Old_Rcode;
private $Old_Reserve;
private $Old_Box_cu;
private $Old_Box_bu;
private $Old_Cu_id;
private $Old_Bu_id;
private $Old_Rnumber;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Lac="0";
private $Def_Cu="0";
private $Def_Bu="0";
private $Def_Psno="0";
private $Def_Reserve="N";
//public function _construct($i) //for PHP6
public function Evmgroup()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from evmgroup";
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
$sql=" select count(*) from evmgroup where ".$condition;
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
$sql="select Grpno,Rcode from evmgroup where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Grpno']=$row['Grpno'];//Primary Key-1
$tRow[$i]['Rcode']=$row['Rcode'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getGrpno()
{
return($this->Grpno);
}

public function setGrpno($str)
{
$this->Grpno=$str;
}

public function getLac()
{
return($this->Lac);
}

public function setLac($str)
{
$this->Lac=$str;
}

public function getCu()
{
return($this->Cu);
}

public function setCu($str)
{
$this->Cu=$str;
}

public function getBu()
{
return($this->Bu);
}

public function setBu($str)
{
$this->Bu=$str;
}

public function getPsno()
{
return($this->Psno);
}

public function setPsno($str)
{
$this->Psno=$str;
}

public function getRcode()
{
return($this->Rcode);
}

public function setRcode($str)
{
$this->Rcode=$str;
}

public function getReserve()
{
return($this->Reserve);
}

public function setReserve($str)
{
$this->Reserve=$str;
}

public function getBox_cu()
{
return($this->Box_cu);
}

public function setBox_cu($str)
{
$this->Box_cu=$str;
}

public function getBox_bu()
{
return($this->Box_bu);
}

public function setBox_bu($str)
{
$this->Box_bu=$str;
}

public function getCu_id()
{
return($this->Cu_id);
}

public function setCu_id($str)
{
$this->Cu_id=$str;
}

public function getBu_id()
{
return($this->Bu_id);
}

public function setBu_id($str)
{
$this->Bu_id=$str;
}

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Grpno,Lac,Cu,Bu,Psno,Rcode,Reserve,Box_cu,Box_bu,Cu_id,Bu_id,Rnumber from evmgroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Cu'])>0)
$this->Old_Cu=$row['Cu'];
else
$this->Old_Cu="NULL";
if (strlen($row['Bu'])>0)
$this->Old_Bu=$row['Bu'];
else
$this->Old_Bu="NULL";
if (strlen($row['Psno'])>0)
$this->Old_Psno=$row['Psno'];
else
$this->Old_Psno="NULL";
if (strlen($row['Rcode'])>0)
$this->Old_Rcode=$row['Rcode'];
else
$this->Old_Rcode="NULL";
if (strlen($row['Reserve'])>0)
$this->Old_Reserve=$row['Reserve'];
else
$this->Old_Reserve="NULL";
if (strlen($row['Box_cu'])>0)
$this->Old_Box_cu=$row['Box_cu'];
else
$this->Old_Box_cu="NULL";
if (strlen($row['Box_bu'])>0)
$this->Old_Box_bu=$row['Box_bu'];
else
$this->Old_Box_bu="NULL";
if (strlen($row['Cu_id'])>0)
$this->Old_Cu_id=$row['Cu_id'];
else
$this->Old_Cu_id="NULL";
if (strlen($row['Bu_id'])>0)
$this->Old_Bu_id=$row['Bu_id'];
else
$this->Old_Bu_id="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Grpno,Lac,Cu,Bu,Psno,Rcode,Reserve,Box_cu,Box_bu,Cu_id,Bu_id,Rnumber from evmgroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Lac=$row['Lac'];
$this->Cu=$row['Cu'];
$this->Bu=$row['Bu'];
$this->Psno=$row['Psno'];
$this->Rcode=$row['Rcode'];
$this->Reserve=$row['Reserve'];
$this->Box_cu=$row['Box_cu'];
$this->Box_bu=$row['Box_bu'];
$this->Cu_id=$row['Cu_id'];
$this->Bu_id=$row['Bu_id'];
$this->Rnumber=$row['Rnumber'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from evmgroup where Grpno='".$this->Grpno."'";
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
$sql="update evmgroup set ";
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

if ($this->Old_Cu!=$this->Cu &&  strlen($this->Cu)>0)
{
if ($this->Cu=="NULL")
$sql=$sql."Cu=NULL";
else
$sql=$sql."Cu='".$this->Cu."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Cu=".$this->Cu.", ";
}

if ($this->Old_Bu!=$this->Bu &&  strlen($this->Bu)>0)
{
if ($this->Bu=="NULL")
$sql=$sql."Bu=NULL";
else
$sql=$sql."Bu='".$this->Bu."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Bu=".$this->Bu.", ";
}

if ($this->Old_Psno!=$this->Psno &&  strlen($this->Psno)>0)
{
if ($this->Psno=="NULL")
$sql=$sql."Psno=NULL";
else
$sql=$sql."Psno='".$this->Psno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Psno=".$this->Psno.", ";
}

if ($this->Old_Rcode!=$this->Rcode &&  strlen($this->Rcode)>0)
{
if ($this->Rcode=="NULL")
$sql=$sql."Rcode=NULL";
else
$sql=$sql."Rcode='".$this->Rcode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Rcode=".$this->Rcode.", ";
}

if ($this->Old_Reserve!=$this->Reserve &&  strlen($this->Reserve)>0)
{
if ($this->Reserve=="NULL")
$sql=$sql."Reserve=NULL";
else
$sql=$sql."Reserve='".$this->Reserve."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Reserve=".$this->Reserve.", ";
}

if ($this->Old_Box_cu!=$this->Box_cu &&  strlen($this->Box_cu)>0)
{
if ($this->Box_cu=="NULL")
$sql=$sql."Box_cu=NULL";
else
$sql=$sql."Box_cu='".$this->Box_cu."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Box_cu=".$this->Box_cu.", ";
}

if ($this->Old_Box_bu!=$this->Box_bu &&  strlen($this->Box_bu)>0)
{
if ($this->Box_bu=="NULL")
$sql=$sql."Box_bu=NULL";
else
$sql=$sql."Box_bu='".$this->Box_bu."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Box_bu=".$this->Box_bu.", ";
}

if ($this->Old_Cu_id!=$this->Cu_id &&  strlen($this->Cu_id)>0)
{
if ($this->Cu_id=="NULL")
$sql=$sql."Cu_id=NULL";
else
$sql=$sql."Cu_id='".$this->Cu_id."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Cu_id=".$this->Cu_id.", ";
}

if ($this->Old_Bu_id!=$this->Bu_id &&  strlen($this->Bu_id)>0)
{
if ($this->Bu_id=="NULL")
$sql=$sql."Bu_id=NULL";
else
$sql=$sql."Bu_id='".$this->Bu_id."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Bu_id=".$this->Bu_id.", ";
}

if ($this->Old_Rnumber!=$this->Rnumber &&  strlen($this->Rnumber)>0)
{
if ($this->Rnumber=="NULL")
$sql=$sql."Rnumber=NULL";
else
$sql=$sql."Rnumber='".$this->Rnumber."'";
$i++;
$this->updateList=$this->updateList."Rnumber=".$this->Rnumber.", ";
}
else
$sql=$sql."Rnumber=Rnumber";


$cond="  where Grpno='".$this->Grpno."'";
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
$sql1="insert into evmgroup(";
$sql=" values (";
$mcol=0;
if (strlen($this->Grpno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Grpno";
if ($this->Grpno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Grpno."'";
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
}

if (strlen($this->Cu)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu";
if ($this->Cu=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu."'";
}

if (strlen($this->Bu)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu";
if ($this->Bu=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu."'";
}

if (strlen($this->Psno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Psno";
if ($this->Psno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Psno."'";
}

if (strlen($this->Rcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rcode";
if ($this->Rcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rcode."'";
}

if (strlen($this->Reserve)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Reserve";
if ($this->Reserve=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Reserve."'";
}

if (strlen($this->Box_cu)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Box_cu";
if ($this->Box_cu=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Box_cu."'";
}

if (strlen($this->Box_bu)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Box_bu";
if ($this->Box_bu=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Box_bu."'";
}

if (strlen($this->Cu_id)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu_id";
if ($this->Cu_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu_id."'";
}

if (strlen($this->Bu_id)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_id";
if ($this->Bu_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_id."'";
}

if (strlen($this->Rnumber)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rnumber";
if ($this->Rnumber=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rnumber."'";
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


public function maxGrpno()
{
$sql="select max(Grpno) from evmgroup";
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
$sql="select Grpno,Lac,Cu,Bu,Psno,Rcode,Reserve,Box_cu,Box_bu,Cu_id,Bu_id,Rnumber from evmgroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Cu']=$row['Cu'];
$tRows[$i]['Bu']=$row['Bu'];
$tRows[$i]['Psno']=$row['Psno'];
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Box_cu']=$row['Box_cu'];
$tRows[$i]['Box_bu']=$row['Box_bu'];
$tRows[$i]['Cu_id']=$row['Cu_id'];
$tRows[$i]['Bu_id']=$row['Bu_id'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Grpno,Lac,Cu,Bu,Psno,Rcode,Reserve,Box_cu,Box_bu,Cu_id,Bu_id,Rnumber from evmgroup where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Cu']=$row['Cu'];
$tRows[$i]['Bu']=$row['Bu'];
$tRows[$i]['Psno']=$row['Psno'];
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Box_cu']=$row['Box_cu'];
$tRows[$i]['Box_bu']=$row['Box_bu'];
$tRows[$i]['Cu_id']=$row['Cu_id'];
$tRows[$i]['Bu_id']=$row['Bu_id'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function RandomiseEVM($lac,$pscount)
{
//First Step assign rnumber
$sql="Select Lac,Grpno from Evmgroup where Lac=".$lac;
$result=mysql_query($sql);

while ($row=mysql_fetch_array($result))
{ 
$str=rand(100,1000000);
$sql1="update Evmgroup set Psno=0,Reserve='Y',rnumber=".$str." where Grpno=".$row['Grpno'];
mysql_query($sql1);
}

//second step assign 4 digit RCODE
$sql="Select Lac,Grpno from Evmgroup where Lac=".$lac."  order by Lac,Rnumber limit ".$pscount;
$result=mysql_query($sql);

$j=1;
while ($row=mysql_fetch_array($result))
{ 
$sql1="update Evmgroup set psno=".$j.",Reserve='N' where Lac=".$row['Lac']." and Grpno=".$row['Grpno'];
mysql_query($sql1);
$j++;
//echo $objPs->returnSql;
}
}//Randomise

}//End Class
?>
