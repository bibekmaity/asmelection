<?php
require_once 'class.config.php';
class Psname
{
private $Hpc;
private $Lac;
private $Psno;
private $Part_no;
private $Psname;
private $Address;
private $Male;
private $Female;
private $Micro_group;
private $Rcode;
private $Sensitivity;
private $Forthpoling_required;
private $Reporting_tag;

//extra Old Variable to store Pre update Data
private $Old_Hpc;
private $Old_Lac;
private $Old_Psno;
private $Old_Part_no;
private $Old_Psname;
private $Old_Address;
private $Old_Male;
private $Old_Female;
private $Old_Micro_group;
private $Old_Rcode;
private $Old_Sensitivity;
private $Old_Forthpoling_required;
private $Old_Reporting_tag;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Reporting_tag="1";
//public function _construct($i) //for PHP6
public function Psname()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from psname";
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
$sql=" select count(*) from psname where ".$condition;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$this->returnSql=$sql;
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //rowCount



public function getHpc()
{
return($this->Hpc);
}

public function setHpc($str)
{
$this->Hpc=$str;
}

public function getLac()
{
return($this->Lac);
}

public function setLac($str)
{
$this->Lac=$str;
}

public function getPsno()
{
return($this->Psno);
}

public function setPsno($str)
{
$this->Psno=$str;
}

public function getPart_no()
{
return($this->Part_no);
}

public function setPart_no($str)
{
$this->Part_no=$str;
}

public function getPsname()
{
return($this->Psname);
}

public function setPsname($str)
{
$this->Psname=$str;
}

public function getAddress()
{
return($this->Address);
}

public function setAddress($str)
{
$this->Address=$str;
}

public function getMale()
{
return($this->Male);
}

public function setMale($str)
{
$this->Male=$str;
}

public function getFemale()
{
return($this->Female);
}

public function setFemale($str)
{
$this->Female=$str;
}

public function getMicro_group()
{
return($this->Micro_group);
}

public function setMicro_group($str)
{
$this->Micro_group=$str;
}

public function getRcode()
{
return($this->Rcode);
}

public function setRcode($str)
{
$this->Rcode=$str;
}

public function getSensitivity()
{
return($this->Sensitivity);
}

public function setSensitivity($str)
{
$this->Sensitivity=$str;
}

public function getForthpoling_required()
{
return($this->Forthpoling_required);
}

public function setForthpoling_required($str)
{
$this->Forthpoling_required=$str;
}

public function getReporting_tag()
{
return($this->Reporting_tag);
}

public function setReporting_tag($str)
{
$this->Reporting_tag=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Hpc,Lac,Psno,Part_no,Psname,Address,Male,Female,Micro_group,Rcode,Sensitivity,Forthpoling_required,Reporting_tag from psname where Lac='".$this->Lac."' and Psno='".$this->Psno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Hpc'])>0)
$this->Old_Hpc=$row['Hpc'];
else
$this->Old_Hpc="NULL";
if (strlen($row['Part_no'])>0)
$this->Old_Part_no=$row['Part_no'];
else
$this->Old_Part_no="NULL";
if (strlen($row['Psname'])>0)
$this->Old_Psname=$row['Psname'];
else
$this->Old_Psname="NULL";
if (strlen($row['Address'])>0)
$this->Old_Address=$row['Address'];
else
$this->Old_Address="NULL";
if (strlen($row['Male'])>0)
$this->Old_Male=$row['Male'];
else
$this->Old_Male="NULL";
if (strlen($row['Female'])>0)
$this->Old_Female=$row['Female'];
else
$this->Old_Female="NULL";
if (strlen($row['Micro_group'])>0)
$this->Old_Micro_group=$row['Micro_group'];
else
$this->Old_Micro_group="NULL";
if (strlen($row['Rcode'])>0)
$this->Old_Rcode=$row['Rcode'];
else
$this->Old_Rcode="NULL";
if (strlen($row['Sensitivity'])>0)
$this->Old_Sensitivity=$row['Sensitivity'];
else
$this->Old_Sensitivity="NULL";
if (strlen($row['Forthpoling_required'])>0)
$this->Old_Forthpoling_required=$row['Forthpoling_required'];
else
$this->Old_Forthpoling_required="NULL";
if (strlen($row['Reporting_tag'])>0)
$this->Old_Reporting_tag=$row['Reporting_tag'];
else
$this->Old_Reporting_tag="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Hpc,Lac,Psno,Part_no,Psname,Address,Male,Female,Micro_group,Rcode,Sensitivity,Forthpoling_required,Reporting_tag from psname where Lac='".$this->Lac."' and Psno='".$this->Psno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Hpc=$row['Hpc'];
$this->Part_no=$row['Part_no'];
$this->Psname=$row['Psname'];
$this->Address=$row['Address'];
$this->Male=$row['Male'];
$this->Female=$row['Female'];
$this->Micro_group=$row['Micro_group'];
$this->Rcode=$row['Rcode'];
$this->Sensitivity=$row['Sensitivity'];
$this->Forthpoling_required=$row['Forthpoling_required'];
$this->Reporting_tag=$row['Reporting_tag'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from psname where Lac='".$this->Lac."' and Psno='".$this->Psno."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$i=$this->copyVariable();
$i=0;
$this->updateList="";
$sql="update psname set ";
if ($this->Old_Hpc!=$this->Hpc &&  strlen($this->Hpc)>0)
{
if ($this->Hpc=="NULL")
$sql=$sql."Hpc=NULL";
else
$sql=$sql."Hpc='".$this->Hpc."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hpc=".$this->Hpc.", ";
}

if ($this->Old_Part_no!=$this->Part_no &&  strlen($this->Part_no)>0)
{
if ($this->Part_no=="NULL")
$sql=$sql."Part_no=NULL";
else
$sql=$sql."Part_no='".$this->Part_no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Part_no=".$this->Part_no.", ";
}

if ($this->Old_Psname!=$this->Psname &&  strlen($this->Psname)>0)
{
if ($this->Psname=="NULL")
$sql=$sql."Psname=NULL";
else
$sql=$sql."Psname='".$this->Psname."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Psname=".$this->Psname.", ";
}

if ($this->Old_Address!=$this->Address &&  strlen($this->Address)>0)
{
if ($this->Address=="NULL")
$sql=$sql."Address=NULL";
else
$sql=$sql."Address='".$this->Address."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Address=".$this->Address.", ";
}

if ($this->Old_Male!=$this->Male &&  strlen($this->Male)>0)
{
if ($this->Male=="NULL")
$sql=$sql."Male=NULL";
else
$sql=$sql."Male='".$this->Male."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Male=".$this->Male.", ";
}

if ($this->Old_Female!=$this->Female &&  strlen($this->Female)>0)
{
if ($this->Female=="NULL")
$sql=$sql."Female=NULL";
else
$sql=$sql."Female='".$this->Female."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Female=".$this->Female.", ";
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

if ($this->Old_Sensitivity!=$this->Sensitivity &&  strlen($this->Sensitivity)>0)
{
if ($this->Sensitivity=="NULL")
$sql=$sql."Sensitivity=NULL";
else
$sql=$sql."Sensitivity='".$this->Sensitivity."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Sensitivity=".$this->Sensitivity.", ";
}

if ($this->Old_Forthpoling_required!=$this->Forthpoling_required &&  strlen($this->Forthpoling_required)>0)
{
if ($this->Forthpoling_required==0)
$sql=$sql."Forthpoling_required=0";
else
$sql=$sql."Forthpoling_required=1";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Forthpoling_required=".$this->Forthpoling_required.", ";
}

if ($this->Old_Reporting_tag!=$this->Reporting_tag &&  strlen($this->Reporting_tag)>0)
{
if ($this->Reporting_tag=="NULL")
$sql=$sql."Reporting_tag=NULL";
else
$sql=$sql."Reporting_tag='".$this->Reporting_tag."'";
$i++;
$this->updateList=$this->updateList."Reporting_tag=".$this->Reporting_tag.", ";
}
else
$sql=$sql."Reporting_tag=Reporting_tag";


$cond="  where Lac=".$this->Lac." and Psno=".$this->Psno;
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
$sql1="insert into psname(";
$sql=" values (";
$mcol=0;
if (strlen($this->Hpc)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Hpc";
if ($this->Hpc=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hpc."'";
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

if (strlen($this->Part_no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Part_no";
if ($this->Part_no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Part_no."'";
}

if (strlen($this->Psname)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Psname";
if ($this->Psname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Psname."'";
}

if (strlen($this->Address)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Address";
if ($this->Address=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Address."'";
}

if (strlen($this->Male)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Male";
if ($this->Male=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Male."'";
}

if (strlen($this->Female)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Female";
if ($this->Female=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Female."'";
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

if (strlen($this->Sensitivity)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Sensitivity";
if ($this->Sensitivity=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Sensitivity."'";
}

if (strlen($this->Forthpoling_required)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Forthpoling_required";
if ($this->Forthpoling_required==0)
$sql=$sql."0";
else
$sql=$sql."1";
}

if (strlen($this->Reporting_tag)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Reporting_tag";
if ($this->Reporting_tag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Reporting_tag."'";
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


public function SaveRecord_Old()
{
$sql="insert into psname(Hpc,Lac,Psno,Part_no,Psname,Address,Male,Female,Micro_group,Rcode,Sensitivity,Forthpoling_required,Reporting_tag) values(";
if (strlen($this->Hpc)>0)
{
if ($this->Hpc=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hpc."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lac."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Psno)>0)
{
if ($this->Psno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Psno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Part_no)>0)
{
if ($this->Part_no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Part_no."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Psname)>0)
{
if ($this->Psname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Psname."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Address)>0)
{
if ($this->Address=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Address."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Male)>0)
{
if ($this->Male=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Male."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Female)>0)
{
if ($this->Female=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Female."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Micro_group)>0)
{
if ($this->Micro_group=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Micro_group."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Rcode)>0)
{
if ($this->Rcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rcode."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Sensitivity)>0)
{
if ($this->Sensitivity=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Sensitivity."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Forthpoling_required)>0)
{
if ($this->Forthpoling_required==0)
$sql=$sql."0";
else
$sql=$sql."1";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Reporting_tag)>0)
{
if ($this->Reporting_tag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Reporting_tag."'";
}
else
$sql=$sql."'1'";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function maxLac()
{
$sql="select max(Lac) from psname";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function maxPsno()
{
$sql="select max(Psno) from psname where lac=".$this->Lac;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function minRcode($lac)
{
$sql="select min(Rcode) from psname where lac=".$lac;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(1);
}

public function getAllRecord()
{
$tRows=array();
$sql="select Hpc,Lac,Psno,Part_no,Psname,Address,Male,Female,Micro_group,Rcode,Sensitivity,Forthpoling_required,Reporting_tag from psname where ".$this->condString;
$i=0;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Hpc']=$row['Hpc'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Psno']=$row['Psno'];
$tRows[$i]['Part_no']=$row['Part_no'];
$tRows[$i]['Psname']=$row['Psname'];
$tRows[$i]['Address']=$row['Address'];
$tRows[$i]['Male']=$row['Male'];
$tRows[$i]['Female']=$row['Female'];
$tRows[$i]['Micro_group']=$row['Micro_group'];
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Sensitivity']=$row['Sensitivity'];
$tRows[$i]['Forthpoling_required']=$row['Forthpoling_required'];
$tRows[$i]['Reporting_tag']=$row['Reporting_tag'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getMicroPsList($grpno)
{
$tRows=array();
$sql="select Part_no,Psname,Male,Female,Sensitivity from psname where Micro_group=".$grpno;
$i=0;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Part_no']=$row['Part_no'];
$tRows[$i]['Psname']=$row['Psname'];
$tRows[$i]['Male']=$row['Male'];
$tRows[$i]['Female']=$row['Female'];
$tRows[$i]['Sensitivity']=$row['Sensitivity'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function getRcodeString($Lac)
{

$sql="select Rcode from psname where Lac=".$Lac." order by Rcode";
$i="(";

$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$i=$i.$row['Rcode'].",";
} //End While
$i=$i."'0000')";
return($i);
} //E


public function EditCondition($rcode)
{
$sql="select Sensitivity,Hpc,Lac,Psno,Part_no,Psname,Address,Male,Female,Micro_group,Rcode,Sensitivity,Forthpoling_required,Reporting_tag from psname where Rcode='".$rcode."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Sensitivity=$row['Sensitivity'] ;   
$this->Available=true;
$this->Hpc=$row['Hpc'];
$this->Lac=$row['Lac'];
$this->Psno=$row['Psno'];
$this->Part_no=$row['Part_no'];
$this->Psname=$row['Psname'];
$this->Address=$row['Address'];
$this->Male=$row['Male'];
$this->Female=$row['Female'];
$this->Micro_group=$row['Micro_group'];
$this->Rcode=$row['Rcode'];
$this->Sensitivity=$row['Sensitivity'];
$this->Forthpoling_required=$row['Forthpoling_required'];
$this->Reporting_tag=$row['Reporting_tag'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord



}//End Class
?>
