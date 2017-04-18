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
private $Firstrandom;
private $Selected;
private $Allow_dep_lac;
private $Allow_home_lac;
private $Allow_res_lac;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Name;
private $Old_Trgamount;
private $Old_Amount1;
private $Old_Amount2;
private $Old_Amount3;
private $Old_Amount4;
private $Old_Firstrandom;
private $Old_Selected;
private $Old_Allow_dep_lac;
private $Old_Allow_home_lac;
private $Old_Allow_res_lac;

//public $Available;
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
private $Def_Firstrandom="N";
private $Def_Selected="0";
//public function _construct($i) //for PHP6
public function Category()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
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

public function getFirstrandom()
{
return($this->Firstrandom);
}

public function setFirstrandom($str)
{
$this->Firstrandom=$str;
}

public function getSelected()
{
return($this->Selected);
}

public function setSelected($str)
{
$this->Selected=$str;
}

public function getAllow_dep_lac()
{
return($this->Allow_dep_lac);
}

public function setAllow_dep_lac($str)
{
$this->Allow_dep_lac=$str;
}

public function getAllow_home_lac()
{
return($this->Allow_home_lac);
}

public function setAllow_home_lac($str)
{
$this->Allow_home_lac=$str;
}

public function getAllow_res_lac()
{
return($this->Allow_res_lac);
}

public function setAllow_res_lac($str)
{
$this->Allow_res_lac=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4,Firstrandom,Selected,Allow_dep_lac,Allow_home_lac,Allow_res_lac from category where Code='".$this->Code."'";
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
if (strlen($row['Firstrandom'])>0)
$this->Old_Firstrandom=$row['Firstrandom'];
else
$this->Old_Firstrandom="NULL";
if (strlen($row['Selected'])>0)
$this->Old_Selected=$row['Selected'];
else
$this->Old_Selected="NULL";
if (strlen($row['Allow_dep_lac'])>0)
$this->Old_Allow_dep_lac=$row['Allow_dep_lac'];
else
$this->Old_Allow_dep_lac="NULL";
if (strlen($row['Allow_home_lac'])>0)
$this->Old_Allow_home_lac=$row['Allow_home_lac'];
else
$this->Old_Allow_home_lac="NULL";
if (strlen($row['Allow_res_lac'])>0)
$this->Old_Allow_res_lac=$row['Allow_res_lac'];
else
$this->Old_Allow_res_lac="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4,Firstrandom,Selected,Allow_dep_lac,Allow_home_lac,Allow_res_lac from category where Code='".$this->Code."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Name=$row['Name'];
$this->Trgamount=$row['Trgamount'];
$this->Amount1=$row['Amount1'];
$this->Amount2=$row['Amount2'];
$this->Amount3=$row['Amount3'];
$this->Amount4=$row['Amount4'];
$this->Firstrandom=$row['Firstrandom'];
$this->Selected=$row['Selected'];
$this->Allow_dep_lac=$row['Allow_dep_lac'];
$this->Allow_home_lac=$row['Allow_home_lac'];
$this->Allow_res_lac=$row['Allow_res_lac'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Code from category where Code='".$this->Code."'";
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
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Amount4=".$this->Amount4.", ";
}

if ($this->Old_Firstrandom!=$this->Firstrandom &&  strlen($this->Firstrandom)>0)
{
if ($this->Firstrandom=="NULL")
$sql=$sql."Firstrandom=NULL";
else
$sql=$sql."Firstrandom='".$this->Firstrandom."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Firstrandom=".$this->Firstrandom.", ";
}

if ($this->Old_Selected!=$this->Selected &&  strlen($this->Selected)>0)
{
if ($this->Selected=="NULL")
$sql=$sql."Selected=NULL";
else
$sql=$sql."Selected='".$this->Selected."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Selected=".$this->Selected.", ";
}

if ($this->Old_Allow_dep_lac!=$this->Allow_dep_lac &&  strlen($this->Allow_dep_lac)>0)
{
if ($this->Allow_dep_lac==0)
$sql=$sql."Allow_dep_lac=0";
else
$sql=$sql."Allow_dep_lac=1";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Allow_dep_lac=".$this->Allow_dep_lac.", ";
}

if ($this->Old_Allow_home_lac!=$this->Allow_home_lac &&  strlen($this->Allow_home_lac)>0)
{
if ($this->Allow_home_lac==0)
$sql=$sql."Allow_home_lac=0";
else
$sql=$sql."Allow_home_lac=1";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Allow_home_lac=".$this->Allow_home_lac.", ";
}

if ($this->Old_Allow_res_lac!=$this->Allow_res_lac &&  strlen($this->Allow_res_lac)>0)
{
if ($this->Allow_res_lac==0)
$sql=$sql."Allow_res_lac=0";
else
$sql=$sql."Allow_res_lac=1";
$i++;
$this->updateList=$this->updateList."Allow_res_lac=".$this->Allow_res_lac.", ";
}
else
$sql=$sql."Allow_res_lac=Allow_res_lac";


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
$this->updateList="";
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
$this->updateList=$this->updateList."Code=".$this->Code.", ";
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
$this->updateList=$this->updateList."Name=".$this->Name.", ";
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
$this->updateList=$this->updateList."Trgamount=".$this->Trgamount.", ";
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
$this->updateList=$this->updateList."Amount1=".$this->Amount1.", ";
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
$this->updateList=$this->updateList."Amount2=".$this->Amount2.", ";
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
$this->updateList=$this->updateList."Amount3=".$this->Amount3.", ";
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
$this->updateList=$this->updateList."Amount4=".$this->Amount4.", ";
}

if (strlen($this->Firstrandom)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Firstrandom";
if ($this->Firstrandom=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Firstrandom."'";
$this->updateList=$this->updateList."Firstrandom=".$this->Firstrandom.", ";
}

if (strlen($this->Selected)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Selected";
if ($this->Selected=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Selected."'";
$this->updateList=$this->updateList."Selected=".$this->Selected.", ";
}

if (strlen($this->Allow_dep_lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Allow_dep_lac";
if ($this->Allow_dep_lac==0)
$sql=$sql."0";
else
$sql=$sql."1";
$this->updateList=$this->updateList."Allow_dep_lac=".$this->Allow_dep_lac.", ";
}

if (strlen($this->Allow_home_lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Allow_home_lac";
if ($this->Allow_home_lac==0)
$sql=$sql."0";
else
$sql=$sql."1";
$this->updateList=$this->updateList."Allow_home_lac=".$this->Allow_home_lac.", ";
}

if (strlen($this->Allow_res_lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Allow_res_lac";
if ($this->Allow_res_lac==0)
$sql=$sql."0";
else
$sql=$sql."1";
$this->updateList=$this->updateList."Allow_res_lac=".$this->Allow_res_lac.", ";
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
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4,Firstrandom,Selected,Allow_dep_lac,Allow_home_lac,Allow_res_lac from category where ".$this->condString;
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
$tRows[$i]['Firstrandom']=$row['Firstrandom'];
$tRows[$i]['Selected']=$row['Selected'];
$tRows[$i]['Allow_dep_lac']=$row['Allow_dep_lac'];
$tRows[$i]['Allow_home_lac']=$row['Allow_home_lac'];
$tRows[$i]['Allow_res_lac']=$row['Allow_res_lac'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Code,Name,Trgamount,Amount1,Amount2,Amount3,Amount4,Firstrandom,Selected,Allow_dep_lac,Allow_home_lac,Allow_res_lac from category where ".$this->condString." LIMIT ".$totrec;
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
$tRows[$i]['Firstrandom']=$row['Firstrandom'];
$tRows[$i]['Selected']=$row['Selected'];
$tRows[$i]['Allow_dep_lac']=$row['Allow_dep_lac'];
$tRows[$i]['Allow_home_lac']=$row['Allow_home_lac'];
$tRows[$i]['Allow_res_lac']=$row['Allow_res_lac'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function Randomised($cat)
{
$this->setCode($cat) ;
if ($this->EditRecord())
{
if ($this->getFirstrandom()=="Y" && $this->getSelected()>0)
return(true);
else
return(false);
} //editrecord
else
return(false); 
} //Randomised

}//End Class
?>
