<?php
require_once '../class/class.config.php';
require_once 'class.bu.php';
class Cu
{
private $Cu_code;
private $Cu_number;
private $Trunck_number;
private $Rnumber;
private $Paperno;
private $Used;
private $Category;

//extra Old Variable to store Pre update Data
private $Old_Cu_code;
private $Old_Cu_number;
private $Old_Trunck_number;
private $Old_Rnumber;
private $Old_Paperno;
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
public function Cu()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from cu";
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
$sql=" select count(*) from cu where ".$condition;
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
$sql="select Cu_code,Cu_number,Trunck_number,Category from cu where ".$this->condString;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Cu_code']=$row['Cu_code'];//Primary Key-1
$tRow[$i]['Cu_number']=$row['Cu_number'];//Posible Unique Field
$tRow[$i]['Trunck_number']=$row['Trunck_number'];//Posible Unique Field
$tRow[$i]['Category']=$row['Category'];

$i++;
}
return($tRow);
}


public function getCu_code()
{
return($this->Cu_code);
}

public function setCu_code($str)
{
$this->Cu_code=$str;
}

public function getCu_number()
{
return($this->Cu_number);
}

public function setCu_number($str)
{
$this->Cu_number=$str;
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

public function getPaperno()
{
return($this->Paperno);
}

public function setPaperno($str)
{
$this->Paperno=$str;
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
$sql="select Cu_code,Cu_number,Trunck_number,Rnumber,Paperno,Used,Category from cu where Cu_code='".$this->Cu_code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Cu_number'])>0)
$this->Old_Cu_number=$row['Cu_number'];
else
$this->Old_Cu_number="NULL";
if (strlen($row['Trunck_number'])>0)
$this->Old_Trunck_number=$row['Trunck_number'];
else
$this->Old_Trunck_number="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
if (strlen($row['Paperno'])>0)
$this->Old_Paperno=$row['Paperno'];
else
$this->Old_Paperno="NULL";
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
$sql="select Cu_code,Cu_number,Trunck_number,Rnumber,Paperno,Used,Category from cu where Cu_code='".$this->Cu_code."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Cu_number=$row['Cu_number'];
$this->Trunck_number=$row['Trunck_number'];
$this->Rnumber=$row['Rnumber'];
$this->Paperno=$row['Paperno'];
$this->Used=$row['Used'];
$this->Category=$row['Category'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Cu_code from cu where Cu_code='".$this->Cu_code."'";
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
$sql="delete from cu where Cu_code='".$this->Cu_code."'";
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
$sql="update cu set ";
if ($this->Old_Cu_number!=$this->Cu_number &&  strlen($this->Cu_number)>0)
{
if ($this->Cu_number=="NULL")
$sql=$sql."Cu_number=NULL";
else
$sql=$sql."Cu_number='".$this->Cu_number."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Cu_number=".$this->Cu_number.", ";
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

if ($this->Old_Paperno!=$this->Paperno &&  strlen($this->Paperno)>0)
{
if ($this->Paperno=="NULL")
$sql=$sql."Paperno=NULL";
else
$sql=$sql."Paperno='".$this->Paperno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Paperno=".$this->Paperno.", ";
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


$cond="  where Cu_code=".$this->Cu_code;
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
$sql="update cu set ";
if ($this->Cu_number=="NULL")
$sql=$sql."Cu_number=NULL";
else
$sql=$sql."Cu_number='".$this->Cu_number."'";
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

if ($this->Paperno=="NULL")
$sql=$sql."Paperno=NULL";
else
$sql=$sql."Paperno='".$this->Paperno."'";
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


$cond="  where Cu_code=".$this->Cu_code;
return($sql.$cond);
}//End genUpdateString


public function SaveRecord()
{
$this->updateList="";
$sql1="insert into cu(";
$sql=" values (";
$mcol=0;
if (strlen($this->Cu_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu_code";
if ($this->Cu_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu_code."'";
$this->updateList=$this->updateList."Cu_code=".$this->Cu_code.", ";
}

if (strlen($this->Cu_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu_number";
if ($this->Cu_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu_number."'";
$this->updateList=$this->updateList."Cu_number=".$this->Cu_number.", ";
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

if (strlen($this->Paperno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Paperno";
if ($this->Paperno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Paperno."'";
$this->updateList=$this->updateList."Paperno=".$this->Paperno.", ";
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
$sql1="insert into cu(";
$sql=" values (";
$mcol=0;
if (strlen($this->Cu_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu_code";
if ($this->Cu_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu_code."'";
}

if (strlen($this->Cu_number)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cu_number";
if ($this->Cu_number=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cu_number."'";
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

if (strlen($this->Paperno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Paperno";
if ($this->Paperno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Paperno."'";
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

public function maxCu_code()
{
$sql="select max(Cu_code) from cu";
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
$sql="select Cu_code,Cu_number,Trunck_number,Rnumber,Paperno,Used,Category from cu where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Cu_code']=$row['Cu_code'];
$tRows[$i]['Cu_number']=$row['Cu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Paperno']=$row['Paperno'];
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
$sql="select Cu_code,Cu_number,Trunck_number,Rnumber,Paperno,Used,Category from cu where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Cu_code']=$row['Cu_code'];
$tRows[$i]['Cu_number']=$row['Cu_number'];
$tRows[$i]['Trunck_number']=$row['Trunck_number'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Paperno']=$row['Paperno'];
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
$sql="select max(".$fld.") from cu where ".$cond;
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
$sql="select sum(".$fld.") from cu where ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}


public function getTopIdOld($totrec)
{
$tRows=array();
$sql="select Cu_code  from cu where used='N' order by rnumber LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Cu_code'];
$i++;
} //End While
return($tRows);
} //End getTopId


public function getTopId($totrec)
{
$tRows=array();
$cat1C=$this->rowCount("Used='N' and Category=1");
$cat2C=$this->rowCount("Used='N' and Category=2");

$objBU=new BU();
$cat1B=$objBU->rowCount("Used='N' and Category=1");
$cat2B=$objBU->rowCount("Used='N' and Category=2");

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
$sql="select Cu_code  from Cu where used='N' and Category=1 order by rnumber LIMIT ".$cat1;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Cu_code'];
$i++;
} //End While

//Category-2
$sql="select Cu_code  from Cu where used='N' and Category=2 order by rnumber LIMIT ".$cat2;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Cu_code'];
$i++;
} //End While

return($tRows);
} //End getTopId


}//End Class
?>
