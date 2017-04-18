<?php
require_once 'class.config.php';
class Department
{
private $Depcode;
private $Dep_type;
private $Department;
private $Govt;
private $Address;
private $Beeo_code;
private $Dep_const;
private $District;
private $Head;
private $Phone;
private $Received;
private $Mdepcode;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

private $Def_Govt="S";
private $Def_Received="Y";
private $Def_Mdepcode="0";
//public function _construct($i) //for PHP6
public function Department()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from department";
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
$sql="select depcode,Department,Address,Beeo_code from department where ".$this->condString." order by Beeo_code,Department";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$tRow[$i][2]=$row[2];
$tRow[$i][3]=$row[3];


$i++;
}
return($tRow);
}


public function getDepcode()
{
return($this->Depcode);
}

public function setDepcode($str)
{
$this->Depcode=$str;
}

public function getDep_type()
{
return($this->Dep_type);
}

public function setDep_type($str)
{
$this->Dep_type=$str;
}

public function getDepartment()
{
return($this->Department);
}

public function setDepartment($str)
{
$this->Department=$str;
}

public function getGovt()
{
return($this->Govt);
}

public function setGovt($str)
{
$this->Govt=$str;
}

public function getAddress()
{
return($this->Address);
}

public function setAddress($str)
{
$this->Address=$str;
}

public function getBeeo_code()
{
return($this->Beeo_code);
}

public function setBeeo_code($str)
{
$this->Beeo_code=$str;
}

public function getDep_const()
{
return($this->Dep_const);
}

public function setDep_const($str)
{
$this->Dep_const=$str;
}

public function getDistrict()
{
return($this->District);
}

public function setDistrict($str)
{
$this->District=$str;
}

public function getHead()
{
return($this->Head);
}

public function setHead($str)
{
$this->Head=$str;
}

public function getPhone()
{
return($this->Phone);
}

public function setPhone($str)
{
$this->Phone=$str;
}

public function getReceived()
{
return($this->Received);
}

public function setReceived($str)
{
$this->Received=$str;
}

public function getMdepcode()
{
return($this->Mdepcode);
}

public function setMdepcode($str)
{
$this->Mdepcode=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}




public function EditRecord()
{
$sql="select Depcode,Dep_type,Department,Govt,Address,Beeo_code,Dep_const,District,Head,Phone,Received,Mdepcode from department where Depcode='".$this->Depcode."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Dep_type=$row['Dep_type'];
$this->Department=$row['Department'];
$this->Govt=$row['Govt'];
$this->Address=$row['Address'];
$this->Beeo_code=$row['Beeo_code'];
$this->Dep_const=$row['Dep_const'];
$this->District=$row['District'];
$this->Head=$row['Head'];
$this->Phone=$row['Phone'];
$this->Received=$row['Received'];
$this->Mdepcode=$row['Mdepcode'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from department where Depcode='".$this->Depcode."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update department set ";
$sqlP="update poling set ";
if (strlen($this->Dep_type)>0)
{
if ($this->Dep_type=="NULL")
$sql=$sql."Dep_type=NULL";
else
$sql=$sql."Dep_type='".$this->Dep_type."'";
$sql=$sql.",";
}

if (strlen($this->Department)>0)
{
if ($this->Department=="NULL")
$sql=$sql."Department=NULL";
else
{
$sql=$sql."Department='".$this->Department."'";
$sqlP=$sqlP." Department='".$this->Department.",".$this->Address."',";
}
$sql=$sql.",";
}

if (strlen($this->Govt)>0)
{
if ($this->Govt=="NULL")
$sql=$sql."Govt=NULL";
else
$sql=$sql."Govt='".$this->Govt."'";
$sql=$sql.",";
}

if (strlen($this->Address)>0)
{
if ($this->Address=="NULL")
$sql=$sql."Address=NULL";
else
$sql=$sql."Address='".$this->Address."'";
$sql=$sql.",";
}

if (strlen($this->Beeo_code)>0)
{
if ($this->Beeo_code=="NULL")
$sql=$sql."Beeo_code=NULL";
else
$sql=$sql."Beeo_code='".$this->Beeo_code."'";
$sql=$sql.",";
}

if (strlen($this->Dep_const)>0)
{
if ($this->Dep_const=="NULL")
$sql=$sql."Dep_const=NULL";
else
{
$sql=$sql."Dep_const='".$this->Dep_const."'";
$sqlP=$sqlP."Depconst='".$this->Dep_const."'";
}
$sql=$sql.",";
}

if (strlen($this->District)>0)
{
if ($this->District=="NULL")
$sql=$sql."District=NULL";
else
$sql=$sql."District='".$this->District."'";
$sql=$sql.",";
}

if (strlen($this->Head)>0)
{
if ($this->Head=="NULL")
$sql=$sql."Head=NULL";
else
$sql=$sql."Head='".$this->Head."'";
$sql=$sql.",";
}

if (strlen($this->Phone)>0)
{
if ($this->Phone=="NULL")
$sql=$sql."Phone=NULL";
else
$sql=$sql."Phone='".$this->Phone."'";
$sql=$sql.",";
}

if (strlen($this->Received)>0)
{
if ($this->Received=="NULL")
$sql=$sql."Received=NULL";
else
$sql=$sql."Received='".$this->Received."'";
$sql=$sql.",";
}

if (strlen($this->Mdepcode)>0)
{
if ($this->Mdepcode=="NULL")
$sql=$sql."Mdepcode=NULL";
else
$sql=$sql."Mdepcode='".$this->Mdepcode."'";
}
else
$sql=$sql."Mdepcode=Mdepcode";

$cond="  where Depcode=".$this->Depcode;
$sqlP=$sqlP."  where Depcode=".$this->Depcode;

$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();

mysql_query($sqlP);
echo $sqlP;
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record



public function SaveRecord()
{
$sql="insert into department(Depcode,Dep_type,Department,Govt,Address,Beeo_code,Dep_const,District,Head,Phone,Received,Mdepcode) values(";
if (strlen($this->Depcode)>0)
{
if ($this->Depcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Depcode."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Dep_type)>0)
{
if ($this->Dep_type=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dep_type."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Department)>0)
{
if ($this->Department=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Department."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Govt)>0)
{
if ($this->Govt=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Govt."'";
}
else
$sql=$sql."'S'";

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

if (strlen($this->Beeo_code)>0)
{
if ($this->Beeo_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Beeo_code."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Dep_const)>0)
{
if ($this->Dep_const=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dep_const."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->District)>0)
{
if ($this->District=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->District."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Head)>0)
{
if ($this->Head=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Head."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Phone)>0)
{
if ($this->Phone=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phone."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Received)>0)
{
if ($this->Received=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Received."'";
}
else
$sql=$sql."'Y'";

$sql=$sql.",";

if (strlen($this->Mdepcode)>0)
{
if ($this->Mdepcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Mdepcode."'";
}
else
$sql=$sql."'0'";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function maxDepcode()
{
$sql="select max(Depcode) from department";
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
$sql="select Depcode,Dep_type,Department,Govt,Address,Beeo_code,Dep_const,District,Head,Phone,Received,Mdepcode from department where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Depcode']=$row['Depcode'];
$tRows[$i]['Dep_type']=$row['Dep_type'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Govt']=$row['Govt'];
$tRows[$i]['Address']=$row['Address'];
$tRows[$i]['Beeo_code']=$row['Beeo_code'];
$tRows[$i]['Dep_const']=$row['Dep_const'];
$tRows[$i]['District']=$row['District'];
$tRows[$i]['Head']=$row['Head'];
$tRows[$i]['Phone']=$row['Phone'];
$tRows[$i]['Received']=$row['Received'];
$tRows[$i]['Mdepcode']=$row['Mdepcode'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
