<body>
<?php
require_once 'class.config.php';
class Category
{
private $Code;
private $Name;
private $Trgamount;
private $Amount1;
private $Amount2;
private $Amount3;
private $Amount4;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Name;
private $Old_Trgamount;
private $Old_Amount1;
private $Old_Amount2;
private $Old_Amount3;
private $Old_Amount4;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Trgamount="0";
private $Def_Amount1="0";
private $Def_Amount2="0";
private $Def_Amount3="0";
private $Def_Amount4="0";
//public function _construct($i) //for PHP6
public function Category()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from category";
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
$sql=" select count(*) from category where ".$condition;
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
$sql="select Code,Name from category where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Code']=$row['Code'];//Primary Key-1
$tRow[$i]['Name']=$row['Name'];//Posible Unique Field
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

public function getName()
{
return($this->Name);
}

public function setName($str)
{
$this->Name=$str;
}

public function getTrgamount()
{
return($this->Trgamount);
}

public function setTrgamount($str)
{
$this->Trgamount=$str;
}

public function getAmount1()
{
return($this->Amount1);
}

public function setAmount1($str)
{
$this->Amount1=$str;
}

public function getAmount2()
{
return($this->Amount2);
}

public function setAmount2($str)
{
$this->Amount2=$str;
}

public function getAmount3()
{
return($this->Amount3);
}

public function setAmount3($str)
{
$this->Amount3=$str;
}

public function getAmount4()
{
return($this->Amount4);
}

public function setAmount4($str)
{
$this->Amount4=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4 from category where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Name'])>0)
$this->Old_Name=$row['Name'];
else
$this->Old_Name="NULL";
if (strlen($row['Trgamount'])>0)
$this->Old_Trgamount=$row['Trgamount'];
else
$this->Old_Trgamount="NULL";
if (strlen($row['Amount1'])>0)
$this->Old_Amount1=$row['Amount1'];
else
$this->Old_Amount1="NULL";
if (strlen($row['Amount2'])>0)
$this->Old_Amount2=$row['Amount2'];
else
$this->Old_Amount2="NULL";
if (strlen($row['Amount3'])>0)
$this->Old_Amount3=$row['Amount3'];
else
$this->Old_Amount3="NULL";
if (strlen($row['Amount4'])>0)
$this->Old_Amount4=$row['Amount4'];
else
$this->Old_Amount4="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4 from category where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Name=$row['Name'];
$this->Trgamount=$row['Trgamount'];
$this->Amount1=$row['Amount1'];
$this->Amount2=$row['Amount2'];
$this->Amount3=$row['Amount3'];
$this->Amount4=$row['Amount4'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from category where Code='".$this->Code."'";
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
$sql="update category set ";
if ($this->Old_Name!=$this->Name &&  strlen($this->Name)>0)
{
if ($this->Name=="NULL")
$sql=$sql."Name=NULL";
else
$sql=$sql."Name='".$this->Name."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Name=".$this->Name.", ";
}

if ($this->Old_Trgamount!=$this->Trgamount &&  strlen($this->Trgamount)>0)
{
if ($this->Trgamount=="NULL")
$sql=$sql."Trgamount=NULL";
else
$sql=$sql."Trgamount='".$this->Trgamount."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgamount=".$this->Trgamount.", ";
}

if ($this->Old_Amount1!=$this->Amount1 &&  strlen($this->Amount1)>0)
{
if ($this->Amount1=="NULL")
$sql=$sql."Amount1=NULL";
else
$sql=$sql."Amount1='".$this->Amount1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Amount1=".$this->Amount1.", ";
}

if ($this->Old_Amount2!=$this->Amount2 &&  strlen($this->Amount2)>0)
{
if ($this->Amount2=="NULL")
$sql=$sql."Amount2=NULL";
else
$sql=$sql."Amount2='".$this->Amount2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Amount2=".$this->Amount2.", ";
}

if ($this->Old_Amount3!=$this->Amount3 &&  strlen($this->Amount3)>0)
{
if ($this->Amount3=="NULL")
$sql=$sql."Amount3=NULL";
else
$sql=$sql."Amount3='".$this->Amount3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Amount3=".$this->Amount3.", ";
}

if ($this->Old_Amount4!=$this->Amount4 &&  strlen($this->Amount4)>0)
{
if ($this->Amount4=="NULL")
$sql=$sql."Amount4=NULL";
else
$sql=$sql."Amount4='".$this->Amount4."'";
$i++;
$this->updateList=$this->updateList."Amount4=".$this->Amount4.", ";
}
else
$sql=$sql."Amount4=Amount4";


$cond="  where Code='".$this->Code."'";
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
$sql1="insert into category(";
$sql=" values (";
$mcol=0;
if (strlen($this->Code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Code";
if ($this->Code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Code."'";
}

if (strlen($this->Name)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Name";
if ($this->Name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Name."'";
}

if (strlen($this->Trgamount)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trgamount";
if ($this->Trgamount=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgamount."'";
}

if (strlen($this->Amount1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Amount1";
if ($this->Amount1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Amount1."'";
}

if (strlen($this->Amount2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Amount2";
if ($this->Amount2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Amount2."'";
}

if (strlen($this->Amount3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Amount3";
if ($this->Amount3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Amount3."'";
}

if (strlen($this->Amount4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Amount4";
if ($this->Amount4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Amount4."'";
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


public function maxCode()
{
$sql="select max(Code) from category";
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
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4 from category where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Trgamount']=$row['Trgamount'];
$tRows[$i]['Amount1']=$row['Amount1'];
$tRows[$i]['Amount2']=$row['Amount2'];
$tRows[$i]['Amount3']=$row['Amount3'];
$tRows[$i]['Amount4']=$row['Amount4'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4 from category where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Trgamount']=$row['Trgamount'];
$tRows[$i]['Amount1']=$row['Amount1'];
$tRows[$i]['Amount2']=$row['Amount2'];
$tRows[$i]['Amount3']=$row['Amount3'];
$tRows[$i]['Amount4']=$row['Amount4'];
$i++;
} //End While
return($tRows);
} //End getAllRecord
}//End Class
?>
