<?php
require_once 'class.config.php';
class Microgroup
{
private $Grpno;
private $Lac;
private $Advance;
private $Micro_id;
private $Reserve;
private $Rnumber;
private $Micropsno;

//extra Old Variable to store Pre update Data
private $Old_Grpno;
private $Old_Lac;
private $Old_Advance;
private $Old_Micro_id;
private $Old_Reserve;
private $Old_Rnumber;
private $Old_Micropsno;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Advance="1";
private $Def_Micro_id="0";
private $Def_Reserve="N";
private $Def_Rnumber="0";
private $Def_Micropsno="0";
//public function _construct($i) //for PHP6
public function Microgroup()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from microgroup";
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
$sql=" select count(*) from microgroup where ".$condition;
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
$sql="select Grpno,Reserve from microgroup where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Grpno']=$row['Grpno'];//Primary Key-1
$tRow[$i]['Reserve']=$row['Reserve'];//Posible Unique Field
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

public function getAdvance()
{
return($this->Advance);
}

public function setAdvance($str)
{
$this->Advance=$str;
}

public function getMicro_id()
{
return($this->Micro_id);
}

public function setMicro_id($str)
{
$this->Micro_id=$str;
}

public function getReserve()
{
return($this->Reserve);
}

public function setReserve($str)
{
$this->Reserve=$str;
}

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
}

public function getMicropsno()
{
return($this->Micropsno);
}

public function setMicropsno($str)
{
$this->Micropsno=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Grpno,Lac,Advance,Micro_id,Reserve,Rnumber,Micropsno from microgroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Advance'])>0)
$this->Old_Advance=$row['Advance'];
else
$this->Old_Advance="NULL";
if (strlen($row['Micro_id'])>0)
$this->Old_Micro_id=$row['Micro_id'];
else
$this->Old_Micro_id="NULL";
if (strlen($row['Reserve'])>0)
$this->Old_Reserve=$row['Reserve'];
else
$this->Old_Reserve="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
if (strlen($row['Micropsno'])>0)
$this->Old_Micropsno=$row['Micropsno'];
else
$this->Old_Micropsno="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Grpno,Lac,Advance,Micro_id,Reserve,Rnumber,Micropsno from microgroup where Grpno='".$this->Grpno."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Lac=$row['Lac'];
$this->Advance=$row['Advance'];
$this->Micro_id=$row['Micro_id'];
$this->Reserve=$row['Reserve'];
$this->Rnumber=$row['Rnumber'];
$this->Micropsno=$row['Micropsno'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Grpno from microgroup where Grpno='".$this->Grpno."'";
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
$sql="delete from microgroup where Grpno='".$this->Grpno."'";
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
$sql="update microgroup set ";
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

if ($this->Old_Advance!=$this->Advance &&  strlen($this->Advance)>0)
{
if ($this->Advance=="NULL")
$sql=$sql."Advance=NULL";
else
$sql=$sql."Advance='".$this->Advance."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
}

if ($this->Old_Micro_id!=$this->Micro_id &&  strlen($this->Micro_id)>0)
{
if ($this->Micro_id=="NULL")
$sql=$sql."Micro_id=NULL";
else
$sql=$sql."Micro_id='".$this->Micro_id."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Micro_id=".$this->Micro_id.", ";
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

if ($this->Old_Rnumber!=$this->Rnumber &&  strlen($this->Rnumber)>0)
{
if ($this->Rnumber=="NULL")
$sql=$sql."Rnumber=NULL";
else
$sql=$sql."Rnumber='".$this->Rnumber."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Rnumber=".$this->Rnumber.", ";
}

if ($this->Old_Micropsno!=$this->Micropsno &&  strlen($this->Micropsno)>0)
{
if ($this->Micropsno=="NULL")
$sql=$sql."Micropsno=NULL";
else
$sql=$sql."Micropsno='".$this->Micropsno."'";
$i++;
$this->updateList=$this->updateList."Micropsno=".$this->Micropsno.", ";
}
else
$sql=$sql."Micropsno=Micropsno";


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
$this->updateList="";
$sql1="insert into microgroup(";
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
$this->updateList=$this->updateList."Grpno=".$this->Grpno.", ";
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

if (strlen($this->Advance)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Advance";
if ($this->Advance=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Advance."'";
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
}

if (strlen($this->Micro_id)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Micro_id";
if ($this->Micro_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micro_id."'";
$this->updateList=$this->updateList."Micro_id=".$this->Micro_id.", ";
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
$this->updateList=$this->updateList."Reserve=".$this->Reserve.", ";
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
$this->updateList=$this->updateList."Rnumber=".$this->Rnumber.", ";
}

if (strlen($this->Micropsno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Micropsno";
if ($this->Micropsno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micropsno."'";
$this->updateList=$this->updateList."Micropsno=".$this->Micropsno.", ";
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


public function maxGrpno()
{
$sql="select max(Grpno) from microgroup";
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
$sql="select Grpno,Lac,Advance,Micro_id,Reserve,Rnumber,Micropsno from microgroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Advance']=$row['Advance'];
$tRows[$i]['Micro_id']=$row['Micro_id'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Micropsno']=$row['Micropsno'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Grpno,Lac,Advance,Micro_id,Reserve,Rnumber,Micropsno from microgroup where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Advance']=$row['Advance'];
$tRows[$i]['Micro_id']=$row['Micro_id'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Micropsno']=$row['Micropsno'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function RandomiseGroup($lac,$cond,$pscond)
{
//First Step assign rnumber
$mArr=array();
$i=0;

$sql="update Microgroup set Reserve='Y',Micropsno=0 where ".$cond;
mysql_query($sql);


$sql="Select Grpno from Microgroup where ".$cond;
//echo $sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{ 
$str=rand(100,100000);
$sql="update Microgroup set rnumber=".$str." where Grpno=".$row['Grpno'];
mysql_query($sql);
//$i++;
//echo $objPs->returnSql;
}

//Load Grpno from MicroPs table in array;
$sql="Select Grpno from Microps where ".$pscond." order by Grpno";
$result=mysql_query($sql);
$i=0;
while ($row=mysql_fetch_array($result))
{ 
$mArr[$i]=$row[0];
$i++;
}
$pscount=$i;
//echo "pscount".$pscount;
//Second step assign grpno from MicroPs toPoling group as newgrp
$sql="Select Grpno  from Microgroup where ".$cond." order by rnumber limit ".$pscount;
$result=mysql_query($sql);
$j=0;
while ($mrow=mysql_fetch_array($result))
{ 
$sql="update Microgroup set reserve='N', Micropsno=".$mArr[$j]." where Lac=".$lac." and Grpno=".$mrow['Grpno'];
mysql_query($sql);
$j++;
//echo $objPs->returnSql;
}
}//RandomisePS
//


}//End Class
?>
