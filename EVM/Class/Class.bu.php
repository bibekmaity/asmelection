<?php
require_once '../class/class.config.php';
require_once 'class.cu.php';
class Bu
{
private $Bu_code;
private $Bu_number;
private $Trunck_number;
private $Rnumber;
private $Used;
private $Category;

//extra Old Variable to store Pre update Data
private $Old_Bu_code;
private $Old_Bu_number;
private $Old_Trunck_number;
private $Old_Rnumber;
private $Old_Used;
private $Old_Category;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Used="N";
private $Def_Category="1";
//public function _construct($i) //for PHP6
public function Bu()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from bu";
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
$sql=" select count(*) from bu where ".$condition;
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
$sql="select Bu_code,Bu_number,Trunck_number,Category from bu where ".$this->condString;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Bu_code']=$row['Bu_code'];//Primary Key-1
$tRow[$i]['Bu_number']=$row['Bu_number'];//Posible Unique Field
$tRow[$i]['Trunck_number']=$row['Trunck_number'];//Posible Unique Field
$tRow[$i]['Category']=$row['Category'];
$i++;
}
return($tRow);
}


public function getBu_code()
{
return($this->Bu_code);
}

public function setBu_code($str)
{
$this->Bu_code=$str;
}

public function getBu_number()
{
return($this->Bu_number);
}

public function setBu_number($str)
{
$this->Bu_number=$str;
}

public function getTrunck_number()
{
return($this->Trunck_number);
}

public function setTrunck_number($str)
{
$this->Trunck_number=$str;
}

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
}

public function getUsed()
{
return($this->Used);
}

public function setUsed($str)
{
$this->Used=$str;
}

public function getCategory()
{
return($this->Category);
}

public function setCategory($str)
{
$this->Category=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used,Category from bu where Bu_code='".$this->Bu_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Bu_number'])>0)
$this->Old_Bu_number=$row['Bu_number'];
else
$this->Old_Bu_number="NULL";
if (strlen($row['Trunck_number'])>0)
$this->Old_Trunck_number=$row['Trunck_number'];
else
$this->Old_Trunck_number="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
if (strlen($row['Used'])>0)
$this->Old_Used=$row['Used'];
else
$this->Old_Used="NULL";
if (strlen($row['Category'])>0)
$this->Old_Category=$row['Category'];
else
$this->Old_Category="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used,Category from bu where Bu_code='".$this->Bu_code."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Bu_number=$row['Bu_number'];
$this->Trunck_number=$row['Trunck_number'];
$this->Rnumber=$row['Rnumber'];
$this->Used=$row['Used'];
$this->Category=$row['Category'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Bu_code from bu where Bu_code='".$this->Bu_code."'";
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
$sql="delete from bu where Bu_code='".$this->Bu_code."'";
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
$sql="update bu set ";
if ($this->Old_Bu_number!=$this->Bu_number &&  strlen($this->Bu_number)>0)
{
if ($this->Bu_number=="NULL")
$sql=$sql."Bu_number=NULL";
else
$sql=$sql."Bu_number='".$this->Bu_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Bu_number=".$this->Bu_number.", ";
}

if ($this->Old_Trunck_number!=$this->Trunck_number &&  strlen($this->Trunck_number)>0)
{
if ($this->Trunck_number=="NULL")
$sql=$sql."Trunck_number=NULL";
else
$sql=$sql."Trunck_number='".$this->Trunck_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trunck_number=".$this->Trunck_number.", ";
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

if ($this->Old_Used!=$this->Used &&  strlen($this->Used)>0)
{
if ($this->Used=="NULL")
$sql=$sql."Used=NULL";
else
$sql=$sql."Used='".$this->Used."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Used=".$this->Used.", ";
}

if ($this->Old_Category!=$this->Category &&  strlen($this->Category)>0)
{
if ($this->Category=="NULL")
$sql=$sql."Category=NULL";
else
$sql=$sql."Category='".$this->Category."'";
$i++;
$this->updateList=$this->updateList."Category=".$this->Category.", ";
}
else
$sql=$sql."Category=Category";


$cond="  where Bu_code=".$this->Bu_code;
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
$this->colUpdated=$i;

if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record


public function genUpdateString()
{
$i=0;
$sql="update bu set ";
if ($this->Bu_number=="NULL")
$sql=$sql."Bu_number=NULL";
else
$sql=$sql."Bu_number='".$this->Bu_number."'";
$sql=$sql.",";

if ($this->Trunck_number=="NULL")
$sql=$sql."Trunck_number=NULL";
else
$sql=$sql."Trunck_number='".$this->Trunck_number."'";
$sql=$sql.",";

if ($this->Rnumber=="NULL")
$sql=$sql."Rnumber=NULL";
else
$sql=$sql."Rnumber='".$this->Rnumber."'";
$sql=$sql.",";

if ($this->Used=="NULL")
$sql=$sql."Used=NULL";
else
$sql=$sql."Used='".$this->Used."'";
$sql=$sql.",";

if ($this->Category=="NULL")
$sql=$sql."Category=NULL";
else
$sql=$sql."Category='".$this->Category."'";


$cond="  where Bu_code=".$this->Bu_code;
return($sql.$cond);
}//End genUpdateString


public function SaveRecord()
{
$this->updateList="";
$sql1="insert into bu(";
$sql=" values (";
$mcol=0;
if (strlen($this->Bu_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_code";
if ($this->Bu_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_code."'";
$this->updateList=$this->updateList."Bu_code=".$this->Bu_code.", ";
}

if (strlen($this->Bu_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_number";
if ($this->Bu_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_number."'";
$this->updateList=$this->updateList."Bu_number=".$this->Bu_number.", ";
}

if (strlen($this->Trunck_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trunck_number";
if ($this->Trunck_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trunck_number."'";
$this->updateList=$this->updateList."Trunck_number=".$this->Trunck_number.", ";
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

if (strlen($this->Used)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Used";
if ($this->Used=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Used."'";
$this->updateList=$this->updateList."Used=".$this->Used.", ";
}

if (strlen($this->Category)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Category";
if ($this->Category=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Category."'";
$this->updateList=$this->updateList."Category=".$this->Category.", ";
}

$sql1=$sql1.")";
$sql=$sql.")";
$sqlstring=$sql1.$sql;
$this->returnSql=$sqlstring;

if (mysql_query($sqlstring))
{
$this->rowCommitted= mysql_affected_rows();
$this->colUpdated=$mcol;
return(true);
}
else
{
$this->colUpdated=0;
return(false);
}
}//End Save Record


public function genSaveString()
{
$sql1="insert into bu(";
$sql=" values (";
$mcol=0;
if (strlen($this->Bu_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_code";
if ($this->Bu_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_code."'";
}

if (strlen($this->Bu_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Bu_number";
if ($this->Bu_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Bu_number."'";
}

if (strlen($this->Trunck_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trunck_number";
if ($this->Trunck_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trunck_number."'";
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

if (strlen($this->Used)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Used";
if ($this->Used=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Used."'";
}

if (strlen($this->Category)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Category";
if ($this->Category=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Category."'";
}

$sql1=$sql1.")";
$sql=$sql.")";
$sqlstring=$sql1.$sql;
return($sqlstring);
}//End genSaveString

public function maxBu_code()
{
$sql="select max(Bu_code) from bu";
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
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used,Category from bu where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Bu_code']=$row['Bu_code'];
$tRows[$i]['Bu_number']=$row['Bu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Used']=$row['Used'];
$tRows[$i]['Category']=$row['Category'];
$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Bu_code,Bu_number,Trunck_number,Rnumber,Used,Category from bu where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Bu_code']=$row['Bu_code'];
$tRows[$i]['Bu_number']=$row['Bu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Used']=$row['Used'];
$tRows[$i]['Category']=$row['Category'];
$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getAllRecord

public function Max($fld,$cond)
{
if(strlen($cond)<3)
$cond=true;
$sql="select max(".$fld.") from bu where ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}

public function Sum($fld,$cond)
{
if(strlen($cond)<3)
$cond=true;
$sql="select sum(".$fld.") from bu where ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}


public function getTopId($totrec)
{
$tRows=array();
$cat1B=$this->rowCount("Used='N' and Category=1");
$cat2B=$this->rowCount("Used='N' and Category=2");

$objCU=new CU();
$cat1C=$objCU->rowCount("Used='N' and Category=1");
$cat2C=$objCU->rowCount("Used='N' and Category=2");

if($cat1B<$cat1C)
$cat1=$cat1B;
else
$cat1=$cat1C;    

if($cat2B<$cat2C)
$cat2=$cat2B;
else
$cat2=$cat2C; 

if($cat1<$totrec) //catwegory 1 cannot fullfill
{
$rest=$totrec-$cat1;
if($rest<$cat2) 
$cat2=$rest;    
}
else //category 1 fulfill
{    
$cat2=0;
$cat1=$totrec;
}
//Catagory-1
$sql="select Bu_code  from Bu where used='N' and Category=1 order by rnumber LIMIT ".$cat1;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Bu_code'];
$i++;
} //End While

//Category-2
$sql="select Bu_code  from Bu where used='N' and Category=2 order by rnumber LIMIT ".$cat2;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Bu_code'];
$i++;
} //End While

return($tRows);
} //End getTopId

}//End Class
?>
