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
private $Edistrict;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

//public function _construct($i) //for PHP6
public function Party_calldate()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
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

public function getRow()
{
$i=0;
$tRow=array();
$sql="select Code,Mydate from party_calldate where ".$this->condString;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
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

public function getEdistrict()
{
return($this->Edistrict);
}

public function setEdistrict($str)
{
$this->Edistrict=$str;
}

public function setCondString($str)
{
$this->condString=$str;
}



public function RecordAvailable()
{
$sql="select Code from party_calldate where Code='".$this->Code."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);
} //end Available


public function EditRecord()
{
$sql="select Edistrict,Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature from party_calldate where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Edistrict=$row['Edistrict'];    
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
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update party_calldate set ";
if (strlen($this->Mydate)>0)
{
if ($this->Mydate=="NULL")
$sql=$sql."Mydate=NULL";
else
$sql=$sql."Mydate='".$this->Mydate."'";
$sql=$sql.",";
}

if (strlen($this->Polldate)>0)
{
if ($this->Polldate=="NULL")
$sql=$sql."Polldate=NULL";
else
$sql=$sql."Polldate='".$this->Polldate."'";
$sql=$sql.",";
}

if (strlen($this->Mydate1)>0)
{
if ($this->Mydate1=="NULL")
$sql=$sql."Mydate1=NULL";
else
$sql=$sql."Mydate1='".$this->Mydate1."'";
$sql=$sql.",";
}

if (strlen($this->Repoldate)>0)
{
if ($this->Repoldate=="NULL")
$sql=$sql."Repoldate=NULL";
else
$sql=$sql."Repoldate='".$this->Repoldate."'";
$sql=$sql.",";
}

if (strlen($this->Assemble_place)>0)
{
if ($this->Assemble_place=="NULL")
$sql=$sql."Assemble_place=NULL";
else
$sql=$sql."Assemble_place='".$this->Assemble_place."'";
$sql=$sql.",";
}

if (strlen($this->Poll_starttime)>0)
{
if ($this->Poll_starttime=="NULL")
$sql=$sql."Poll_starttime=NULL";
else
$sql=$sql."Poll_starttime='".$this->Poll_starttime."'";
$sql=$sql.",";
}

if (strlen($this->Poll_endtime)>0)
{
if ($this->Poll_endtime=="NULL")
$sql=$sql."Poll_endtime=NULL";
else
$sql=$sql."Poll_endtime='".$this->Poll_endtime."'";
$sql=$sql.",";
}

if (strlen($this->Mplace)>0)
{
if ($this->Mplace=="NULL")
$sql=$sql."Mplace=NULL";
else
$sql=$sql."Mplace='".$this->Mplace."'";
$sql=$sql.",";
}

if (strlen($this->Mdate)>0)
{
if ($this->Mdate=="NULL")
$sql=$sql."Mdate=NULL";
else
$sql=$sql."Mdate='".$this->Mdate."'";
$sql=$sql.",";
}

if (strlen($this->Msignature)>0)
{
if ($this->Msignature=="NULL")
$sql=$sql."Msignature=NULL";
else
$sql=$sql."Msignature='".$this->Msignature."'";
}
else
$sql=$sql."Msignature=Msignature";

$cond="  where Code=".$this->Code;
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into party_calldate(Code,Mydate,Polldate,Mydate1,Repoldate,Assemble_place,Poll_starttime,Poll_endtime,Mplace,Mdate,Msignature) values(";
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

if (strlen($this->Mydate)>0)
{
if ($this->Mydate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mydate."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Polldate)>0)
{
if ($this->Polldate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Polldate."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Mydate1)>0)
{
if ($this->Mydate1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mydate1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Repoldate)>0)
{
if ($this->Repoldate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Repoldate."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Assemble_place)>0)
{
if ($this->Assemble_place=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Assemble_place."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Poll_starttime)>0)
{
if ($this->Poll_starttime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poll_starttime."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Poll_endtime)>0)
{
if ($this->Poll_endtime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poll_endtime."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Mplace)>0)
{
if ($this->Mplace=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mplace."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Mdate)>0)
{
if ($this->Mdate=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mdate."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Msignature)>0)
{
if ($this->Msignature=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Msignature."'";
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

public function getRepDate()
{
$tRows=array();
$sql="select Code,Mydate from party_calldate where code in(select distinct Reporting_tag from psname)";
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Mydate']=$row['Mydate'];
$i++;
} //End While
return($tRows);
} //End getRepDate


}//End Class
?>
