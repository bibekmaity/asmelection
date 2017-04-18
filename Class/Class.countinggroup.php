<?php
require_once 'class.config.php';
class Countinggroup
{
private $Grpno;
private $Lac;
private $Hall_no;
private $Table_no;
private $Sr;
private $Ast1;
private $Ast2;
private $Static_observer;
private $Reserve;
private $Rnumber;
private $Trggroup;
//extra Old Variable to store Pre update Data
private $Old_Grpno;
private $Old_Lac;
private $Old_Hall_no;
private $Old_Table_no;
private $Old_Sr;
private $Old_Ast1;
private $Old_Ast2;
private $Old_Static_observer;
private $Old_Reserve;
private $Old_Rnumber;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Hall_no="0";
private $Def_Table_no="0";
private $Def_Sr="0";
private $Def_Ast1="0";
private $Def_Ast2="0";
private $Def_Static_observer="0";
private $Def_Reserve="N";
private $Def_Rnumber="0";
//public function _construct($i) //for PHP6
public function Countinggroup()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from countinggroup";
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
$sql=" select count(*) from countinggroup where ".$condition;
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
$sql="select Grpno,Reserve from countinggroup where ".$this->condString;
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

public function getTrggroup()
{
return($this->Trggroup);
}

public function setTrggroup($str)
{
$this->Trggroup=$str;
}


public function getHall_no()
{
return($this->Hall_no);
}

public function setHall_no($str)
{
$this->Hall_no=$str;
}

public function getTable_no()
{
return($this->Table_no);
}

public function setTable_no($str)
{
$this->Table_no=$str;
}

public function getSr()
{
return($this->Sr);
}

public function setSr($str)
{
$this->Sr=$str;
}

public function getAst1()
{
return($this->Ast1);
}

public function setAst1($str)
{
$this->Ast1=$str;
}

public function getAst2()
{
return($this->Ast2);
}

public function setAst2($str)
{
$this->Ast2=$str;
}

public function getStatic_observer()
{
return($this->Static_observer);
}

public function setStatic_observer($str)
{
$this->Static_observer=$str;
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


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Grpno,Lac,Hall_no,Table_no,Sr,Ast1,Ast2,Static_observer,Reserve,Rnumber from countinggroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Hall_no'])>0)
$this->Old_Hall_no=$row['Hall_no'];
else
$this->Old_Hall_no="NULL";
if (strlen($row['Table_no'])>0)
$this->Old_Table_no=$row['Table_no'];
else
$this->Old_Table_no="NULL";
if (strlen($row['Sr'])>0)
$this->Old_Sr=$row['Sr'];
else
$this->Old_Sr="NULL";
if (strlen($row['Ast1'])>0)
$this->Old_Ast1=$row['Ast1'];
else
$this->Old_Ast1="NULL";
if (strlen($row['Ast2'])>0)
$this->Old_Ast2=$row['Ast2'];
else
$this->Old_Ast2="NULL";
if (strlen($row['Static_observer'])>0)
$this->Old_Static_observer=$row['Static_observer'];
else
$this->Old_Static_observer="NULL";
if (strlen($row['Reserve'])>0)
$this->Old_Reserve=$row['Reserve'];
else
$this->Old_Reserve="NULL";
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
$sql="select Trggroup,Grpno,Lac,Hall_no,Table_no,Sr,Ast1,Ast2,Static_observer,Reserve,Rnumber from countinggroup where Grpno='".$this->Grpno."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Trggroup=$row['Trggroup'];    
$this->Lac=$row['Lac'];
$this->Hall_no=$row['Hall_no'];
$this->Table_no=$row['Table_no'];
$this->Sr=$row['Sr'];
$this->Ast1=$row['Ast1'];
$this->Ast2=$row['Ast2'];
$this->Static_observer=$row['Static_observer'];
$this->Reserve=$row['Reserve'];
$this->Rnumber=$row['Rnumber'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Grpno from countinggroup where Grpno='".$this->Grpno."'";
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
$sql="delete from countinggroup where Grpno='".$this->Grpno."'";
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
$sql="update countinggroup set ";
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

if ($this->Old_Hall_no!=$this->Hall_no &&  strlen($this->Hall_no)>0)
{
if ($this->Hall_no=="NULL")
$sql=$sql."Hall_no=NULL";
else
$sql=$sql."Hall_no='".$this->Hall_no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hall_no=".$this->Hall_no.", ";
}

if ($this->Old_Table_no!=$this->Table_no &&  strlen($this->Table_no)>0)
{
if ($this->Table_no=="NULL")
$sql=$sql."Table_no=NULL";
else
$sql=$sql."Table_no='".$this->Table_no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Table_no=".$this->Table_no.", ";
}

if ($this->Old_Sr!=$this->Sr &&  strlen($this->Sr)>0)
{
if ($this->Sr=="NULL")
$sql=$sql."Sr=NULL";
else
$sql=$sql."Sr='".$this->Sr."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Sr=".$this->Sr.", ";
}

if ($this->Old_Ast1!=$this->Ast1 &&  strlen($this->Ast1)>0)
{
if ($this->Ast1=="NULL")
$sql=$sql."Ast1=NULL";
else
$sql=$sql."Ast1='".$this->Ast1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Ast1=".$this->Ast1.", ";
}

if ($this->Old_Ast2!=$this->Ast2 &&  strlen($this->Ast2)>0)
{
if ($this->Ast2=="NULL")
$sql=$sql."Ast2=NULL";
else
$sql=$sql."Ast2='".$this->Ast2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Ast2=".$this->Ast2.", ";
}

if ($this->Old_Static_observer!=$this->Static_observer &&  strlen($this->Static_observer)>0)
{
if ($this->Static_observer=="NULL")
$sql=$sql."Static_observer=NULL";
else
$sql=$sql."Static_observer='".$this->Static_observer."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Static_observer=".$this->Static_observer.", ";
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
$this->updateList="";
$sql1="insert into countinggroup(";
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

if (strlen($this->Hall_no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Hall_no";
if ($this->Hall_no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hall_no."'";
$this->updateList=$this->updateList."Hall_no=".$this->Hall_no.", ";
}

if (strlen($this->Table_no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Table_no";
if ($this->Table_no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Table_no."'";
$this->updateList=$this->updateList."Table_no=".$this->Table_no.", ";
}

if (strlen($this->Sr)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Sr";
if ($this->Sr=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Sr."'";
$this->updateList=$this->updateList."Sr=".$this->Sr.", ";
}

if (strlen($this->Ast1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Ast1";
if ($this->Ast1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ast1."'";
$this->updateList=$this->updateList."Ast1=".$this->Ast1.", ";
}

if (strlen($this->Ast2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Ast2";
if ($this->Ast2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Ast2."'";
$this->updateList=$this->updateList."Ast2=".$this->Ast2.", ";
}

if (strlen($this->Static_observer)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Static_observer";
if ($this->Static_observer=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Static_observer."'";
$this->updateList=$this->updateList."Static_observer=".$this->Static_observer.", ";
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
$sql="select max(Grpno) from countinggroup";
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
$sql="select Grpno,Lac,Hall_no,Table_no,Sr,Ast1,Ast2,Static_observer,Reserve,Rnumber from countinggroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Hall_no']=$row['Hall_no'];
$tRows[$i]['Table_no']=$row['Table_no'];
$tRows[$i]['Sr']=$row['Sr'];
$tRows[$i]['Ast1']=$row['Ast1'];
$tRows[$i]['Ast2']=$row['Ast2'];
$tRows[$i]['Static_observer']=$row['Static_observer'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Grpno,Lac,Hall_no,Table_no,Sr,Ast1,Ast2,Static_observer,Reserve,Rnumber from countinggroup where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Hall_no']=$row['Hall_no'];
$tRows[$i]['Table_no']=$row['Table_no'];
$tRows[$i]['Sr']=$row['Sr'];
$tRows[$i]['Ast1']=$row['Ast1'];
$tRows[$i]['Ast2']=$row['Ast2'];
$tRows[$i]['Static_observer']=$row['Static_observer'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function mySelection($lac)
{
$a=$this->rowCount("Lac=".$lac." and Sr>0");
$b=$this->rowCount("Lac=".$lac." and Ast1>0");
$c=$this->rowCount("Lac=".$lac." and Ast2>0");
$d=$this->rowCount("Lac=".$lac." and Static_observer>0");
$temp="Super-".$a."<br>Ast-".($b+$c);
if($d>0)
$temp=$temp."<br>Static Obs-".$d;    
return($temp);
}

public function RandomiseGroup($lac)
{
//First Step assign rnumber
$mArr=array();
$i=0;

//Load Hall/Table from Counting Group in Array;
$sql="Select Hall_no,Table_no from countinggroup where Lac=".$lac." order by Hall_no,Table_no";
$result=mysql_query($sql);
$i=0;
while ($row=mysql_fetch_array($result))
{ 
$mArr[$i]['Hall']=$row[0];
$mArr[$i]['Table']=$row[1];
$i++;
}
$tblcount=$i;

//Now randomise Countinggroup table LAC wise
$sql="Select Grpno from Countinggroup where Lac=".$lac;
//echo $sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{ 
$str=rand(1,10000);
$sql="update Countinggroup set rnumber=".$str." where Grpno=".$row['Grpno'];
mysql_query($sql);
}

//Now Clear ALL Hall and Table of Countinggroup Table to 0 for Particular LAC
$sql="update Countinggroup set Hall_no=0,Table_no=0 where Lac=".$lac;
mysql_query($sql);

//Assign New Hall Table from Array
$sql="Select Grpno  from Countinggroup where Lac=".$lac." order by rnumber limit ".$tblcount;
$result=mysql_query($sql);
$j=0;
while ($mrow=mysql_fetch_array($result))
{ 
$sql="update Countinggroup set Hall_no=".$mArr[$j]['Hall'].",Table_no=".$mArr[$j]['Table']."  where Lac=".$lac." and Grpno=".$mrow['Grpno'];
mysql_query($sql);
$j++;
//echo $objPs->returnSql;
}
}//RandomiseHall
//

}//End Class
?>
