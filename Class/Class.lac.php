<?php
require_once 'class.config.php';
require_once 'class.Groupstatus.php';
require_once 'class.Category.php';
class Lac
{
private $Code;
private $Name;
private $Ro_sign;
private $Hpccode;
private $Ro_detail;

//extra Old Variable to store Pre update Data
private $Old_Code;
private $Old_Name;
private $Old_Ro_sign;
private $Old_Hpccode;
private $Old_Ro_detail;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Lac()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from lac";
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
$sql=" select count(*) from lac where ".$condition;
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
$sql="select Code,Name from lac where ".$this->condString;
$this->returnSql=$sql;
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

public function getRo_sign()
{
return($this->Ro_sign);
}

public function setRo_sign($str)
{
$this->Ro_sign=$str;
echo "set as ".$str;
}

public function getHpccode()
{
return($this->Hpccode);
}

public function setHpccode($str)
{
$this->Hpccode=$str;
}

public function getRo_detail()
{
return($this->Ro_detail);
}

public function setRo_detail($str)
{
$this->Ro_detail=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Code,Name,Ro_sign,Hpccode,Ro_detail from lac where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Name'])>0)
$this->Old_Name=$row['Name'];
else
$this->Old_Name="NULL";

if (strlen($row['Ro_sign'])>0)
$this->Old_Ro_sign=$row['Ro_sign'];
else
$this->Old_Ro_sign="NULL";
echo "class-".$this->Old_Ro_sign;
if (strlen($row['Hpccode'])>0)
$this->Old_Hpccode=$row['Hpccode'];
else
$this->Old_Hpccode="NULL";
if (strlen($row['Ro_detail'])>0)
$this->Old_Ro_detail=$row['Ro_detail'];
else
$this->Old_Ro_detail="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Code,Name,Ro_sign,Hpccode,Ro_detail from lac where Code='".$this->Code."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Name=$row['Name'];
$this->Ro_sign=$row['Ro_sign'];
$this->Hpccode=$row['Hpccode'];
$this->Ro_detail=$row['Ro_detail'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from lac where Code='".$this->Code."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
    
//echo "class-updatefirst".$this->Ro_sign ;  
$i=$this->copyVariable();
$i=0;
$this->updateList="";
$sql="update lac set ";
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

//if ($this->Old_Ro_sign!=$this->Ro_sign &&  strlen($this->Ro_sign)>0)
//{
echo "class-".$this->Ro_sign;
if ($this->Ro_sign=="NULL")
$sql=$sql."Ro_sign=NULL";
else
$sql=$sql."Ro_sign='".$this->Ro_sign."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Ro_sign=".$this->Ro_sign.", ";
//}

if ($this->Old_Hpccode!=$this->Hpccode &&  strlen($this->Hpccode)>0)
{
if ($this->Hpccode=="NULL")
$sql=$sql."Hpccode=NULL";
else
$sql=$sql."Hpccode='".$this->Hpccode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hpccode=".$this->Hpccode.", ";
}

if ($this->Old_Ro_detail!=$this->Ro_detail &&  strlen($this->Ro_detail)>0)
{
if ($this->Ro_detail=="NULL")
$sql=$sql."Ro_detail=NULL";
else
$sql=$sql."Ro_detail='".$this->Ro_detail."'";
$i++;
$this->updateList=$this->updateList."Ro_detail=".$this->Ro_detail.", ";
}
else
$sql=$sql."Ro_detail=Ro_detail";


$cond="  where Code=".$this->Code;
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
$sql="insert into lac(Code,Name,Ro_sign,Hpccode,Ro_detail) values(";
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

if (strlen($this->Name)>0)
{
if ($this->Name=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Name."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Ro_sign)>0)
{
if ($this->Ro_sign=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ro_sign."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Hpccode)>0)
{
if ($this->Hpccode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hpccode."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Ro_detail)>0)
{
if ($this->Ro_detail=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ro_detail."'";
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
$sql="select max(Code) from lac";
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
$sql="select Code,Name,Ro_sign,Hpccode,Ro_detail from lac where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Code']=$row['Code'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Ro_sign']=$row['Ro_sign'];
$tRows[$i]['Hpccode']=$row['Hpccode'];
$tRows[$i]['Ro_detail']=$row['Ro_detail'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function AdvancePosting($Lac)
{
if($Lac==0) //For All LAC
$cond="";
else
$cond=" and Lac=".$Lac; //For Particular LAC    
$sql="select count(*) from Psname where Reporting_tag=0 ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (($row[0])>0)
return(true);
else
return(false);
}

public function ForthPoling($Lac)
{
if($Lac==0) //For All LAC
$cond="";
else
$cond=" and Lac=".$Lac; //For Particular LAC
$sql="select count(*) from Psname where male+female>1199 and forthpoling_required=1 ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
return($row[0]);
}


public function groupStatus($Lacno)
{
$sql="select count(*) from polinggroup where Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]==0)
$status=0;    //Not Done
else
$status=1; //Ready    
  
    
$sql="select count(*) from polinggroup where Prno>0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]>0)
$status=2; //Partially Done 

//Check if group Completed
$sql="select count(*) from polinggroup where Large=0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Req1=$row[0];
$sql="select count(*) from polinggroup where Prno>0 and Po1no>0 and Po2no>0 and Po3no>0 and Large=0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Avl1=$row[0];

$sql="select count(*) from polinggroup where Large=1 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Req2=$row[0];
$sql="select count(*) from polinggroup where Po4no>0 and Large=1 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Avl2=$row[0];

if($Req1==$Avl1 && $Req2==$Avl2 && $Avl1>0 )
$status=3; //Group Completed 
 
$sql="select Lac, Mtype from final where mtype=1 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
$status=4;  //Locked   
 

$sql="select count(*) from final where mtype=2 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cc=$row[0];
if($this->AdvancePosting($Lacno))
{
if($cc==1)
$status=5; //Partial PS Allocation for Advance day
if($cc==2)
$status=6;
}
else
{
if($cc==1)    
$status=6; //Full Allocation
}    


return($status);
} //GroupStatus

public function groupStatusDetail($Lacno)
{
$objStat=new Groupstatus();
$code=$this->groupStatus($Lacno);
$objStat->setCode($code);
if($objStat->EditRecord())
return($objStat->getDetail());
else
return("");
}//groupStatusDetail



public function MicrogroupStatus($Lacno)
{
$sql="select count(*) from Microps where Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]==0)
$status=0;    //Not Done
else
$status=1; //Ready    
  
    
$sql="select count(*) from Microgroup where Micro_id>0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$c1=$row[0];

$sql="select count(*) from Microgroup where Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$c2=$row[0];

if($c1<$c2 && $c1>0)
$status=2; //Partially Done 
else
{    
if($c1>0 && $c1>=$c2)
$status=3; //Fuly Done 
}

$sql="select Lac, Mtype from final where mtype=5 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
$status=4;  //LAC wise Locked   
 
//$sql="select Lac, Mtype from final where mtype=6 and Lac=".$Lacno;
//$result=mysql_query($sql);
//$row=mysql_fetch_array($result);
//if($row)  
//$status=6; //Full Allocation

//start
$sql="select count(*) from final where mtype=6 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cc=$row[0];
if($this->AdvancePosting($Lacno))
{
if($cc==1)
$status=5; //Partial PS Allocation for Advance day
if($cc==2)
$status=6;
}
else
{
if($cc==1)    
$status=6; //Full Allocation
}
return($status);
 
}//Micro Group Status

public function MicrogroupStatusDetail($Lacno)
{
$objStat=new Groupstatus();
$code=$this->MicrogroupStatus($Lacno);
$objStat->setCode($code);
if($objStat->EditRecord())
return($objStat->getDetail());
else
return("");
}//groupStatusDetail

public function CommonMicrogroupStatus()
{
$status=0;    
$this->setCondString("Code>0 and Code in(Select distinct Lac from Psname)");

$row=$this->getRow();

for($i=0;$i<count($row);$i++)
{
$tmp=$this->MicrogroupStatus($row[$i]['Code']) ;
if($tmp>$status)
$status=$tmp;    
}
return($status);
} //commonmicrosttus

public function CommongroupStatus()
{
$status=0;    
$this->setCondString("Code>0 and Code in(Select distinct Lac from Psname)");

$row=$this->getRow();

for($i=0;$i<count($row);$i++)
{
$tmp=$this->groupStatus($row[$i]['Code']) ;
if($tmp>$status)
$status=$tmp;    
}
return($status);
} //commonmicrosttus


public function CommonCountgroupStatus()
{
$status=0;    
$this->setCondString("Code>0 and Code in(Select distinct Lac from CountingHall)");

$row=$this->getRow();

for($i=0;$i<count($row);$i++)
{
$tmp=$this->CountinggroupStatus($row[$i]['Code']) ;
if($tmp>$status)
$status=$tmp;    
}
return($status);
} //commonmicrosttus


public function TrainingGroupExist($phase)
{
$sql="select count(*) from Poling_training where phaseno=".$phase;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]>0)
return(true);
else
return(false); //Ready    
}



public function CountinggroupStatus($Lacno)
{
$sql="select count(*) from countinggroup where Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]==0)
$status=0;    //Not Done
else
$status=1; //Ready    
  
    
$sql="select count(*) from countinggroup where Sr>0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]>0)
$status=2; //Partially Done 

//Check if group Completed
$sql="select count(*) from countinggroup where  Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Req1=$row[0];

$sql="select count(*) from countinggroup where Sr>0 and Ast1>0 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Avl1=$row[0];

if($Req1==$Avl1 && $Avl1>0 )
$status=3; //Group Completed 
 
$sql="select Lac, Mtype from final where mtype=7 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
$status=4;  //Locked   
 

$sql="select count(*) from final where mtype=8 and Lac=".$Lacno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$cc=$row[0];
if($cc>0)    
$status=6; //Full Allocation


return($status);
} //countinggroupStatus


}//End Class
?>
