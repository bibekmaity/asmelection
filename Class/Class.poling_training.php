<?php
require_once 'class.config.php';
require_once 'class.poling.php';
require_once 'utility.class.php';
class Poling_training
{
private $Poling_id;
private $Phaseno;
private $Groupno;
private $Attended1;
private $Attended2;
private $Attended3;
private $Pcategory;

//extra Old Variable to store Pre update Data
private $Old_Poling_id;
private $Old_Phaseno;
private $Old_Groupno;
private $Old_Attended1;
private $Old_Attended2;
private $Old_Attended3;
private $Old_Pcategory;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Poling_training()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from poling_training";
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
$sql=" select count(*) from poling_training where ".$condition;
//echo $sql;
$this->returnSql=$sql;
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
$sql="select Poling_id,Phaseno,Groupno,Attended1 from poling_training where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Poling_id']=$row['Poling_id'];//Primary Key-1
$tRow[$i]['Phaseno']=$row['Phaseno'];//Primary Key-2
$tRow[$i]['Groupno']=$row['Groupno'];//Primary Key-3
$tRow[$i]['Attended1']=$row['Attended1'];//Posible Unique Field
$i++;
}
return($tRow);
}




public function getPoling_id()
{
return($this->Poling_id);
}

public function setPoling_id($str)
{
$this->Poling_id=$str;
}

public function getPhaseno()
{
return($this->Phaseno);
}

public function setPhaseno($str)
{
$this->Phaseno=$str;
}

public function getGroupno()
{
return($this->Groupno);
}

public function setGroupno($str)
{
$this->Groupno=$str;
}

public function getAttended1()
{
return($this->Attended1);
}

public function setAttended1($str)
{
$this->Attended1=$str;
}

public function getAttended2()
{
return($this->Attended2);
}

public function setAttended2($str)
{
$this->Attended2=$str;
}

public function getAttended3()
{
return($this->Attended3);
}

public function setAttended3($str)
{
$this->Attended3=$str;
}

public function getPcategory()
{
return($this->Pcategory);
}

public function setPcategory($str)
{
$this->Pcategory=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Poling_id,Phaseno,Groupno,Attended1,Attended2,Attended3,Pcategory from poling_training where Poling_id='".$this->Poling_id."' and Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Attended1'])>0)
$this->Old_Attended1=$row['Attended1'];
else
$this->Old_Attended1="NULL";
if (strlen($row['Attended2'])>0)
$this->Old_Attended2=$row['Attended2'];
else
$this->Old_Attended2="NULL";
if (strlen($row['Attended3'])>0)
$this->Old_Attended3=$row['Attended3'];
else
$this->Old_Attended3="NULL";
if (strlen($row['Pcategory'])>0)
$this->Old_Pcategory=$row['Pcategory'];
else
$this->Old_Pcategory="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Poling_id,Phaseno,Groupno,Attended1,Attended2,Attended3,Pcategory from poling_training where Poling_id='".$this->Poling_id."' and Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Attended1=$row['Attended1'];
$this->Attended2=$row['Attended2'];
$this->Attended3=$row['Attended3'];
$this->Pcategory=$row['Pcategory'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from poling_training where Poling_id='".$this->Poling_id."' and Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
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
$sql="update poling_training set ";
if ($this->Old_Attended1!=$this->Attended1 &&  strlen($this->Attended1)>0)
{
if ($this->Attended1=="NULL")
$sql=$sql."Attended1=NULL";
else
$sql=$sql."Attended1='".$this->Attended1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Attended1=".$this->Attended1.", ";
}

if ($this->Old_Attended2!=$this->Attended2 &&  strlen($this->Attended2)>0)
{
if ($this->Attended2=="NULL")
$sql=$sql."Attended2=NULL";
else
$sql=$sql."Attended2='".$this->Attended2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Attended2=".$this->Attended2.", ";
}

if ($this->Old_Attended3!=$this->Attended3 &&  strlen($this->Attended3)>0)
{
if ($this->Attended3=="NULL")
$sql=$sql."Attended3=NULL";
else
$sql=$sql."Attended3='".$this->Attended3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Attended3=".$this->Attended3.", ";
}

if ($this->Old_Pcategory!=$this->Pcategory &&  strlen($this->Pcategory)>0)
{
if ($this->Pcategory=="NULL")
$sql=$sql."Pcategory=NULL";
else
$sql=$sql."Pcategory='".$this->Pcategory."'";
$i++;
$this->updateList=$this->updateList."Pcategory=".$this->Pcategory.", ";
}
else
$sql=$sql."Pcategory=Pcategory";


$cond="  where Poling_id='".$this->Poling_id."' and Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
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
$sql="insert into poling_training(Poling_id,Phaseno,Groupno,Attended1,Attended2,Attended3,Pcategory) values(";
if (strlen($this->Poling_id)>0)
{
if ($this->Poling_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Poling_id."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Phaseno)>0)
{
if ($this->Phaseno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phaseno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Groupno)>0)
{
if ($this->Groupno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Groupno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Attended1)>0)
{
if ($this->Attended1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Attended1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Attended2)>0)
{
if ($this->Attended2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Attended2."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Attended3)>0)
{
if ($this->Attended3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Attended3."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Pcategory)>0)
{
if ($this->Pcategory=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pcategory."'";
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

public function maxPoling_id()
{
$sql="select max(Poling_id) from poling_training";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function maxPhaseno()
{
$sql="select max(Phaseno) from poling_training";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function maxGroupno()
{
$sql="select max(Groupno) from poling_training";
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
$sql="select Poling_id,Phaseno,Groupno,Attended1,Attended2,Attended3,Pcategory from poling_training where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Poling_id']=$row['Poling_id'];
$tRows[$i]['Phaseno']=$row['Phaseno'];
$tRows[$i]['Groupno']=$row['Groupno'];
$tRows[$i]['Attended1']=$row['Attended1'];
$tRows[$i]['Attended2']=$row['Attended2'];
$tRows[$i]['Attended3']=$row['Attended3'];
$tRows[$i]['Pcategory']=$row['Pcategory'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function SelectTrainee($phaseno,$groupno,$pr,$p1,$p2,$p3,$p4,$atn1,$atn2,$atn3)
{
$objPoling=new Poling();
$objU=new Utility();

$str="";
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$sl=0;
$catg=0;
$iter=0;
$row=array();
//Process Presiding
$cond=" (pollcategory between 1 and 5) and Selected='Y' and Grpno=0 and deleted='N' and sex='M' and slno not in";
$cond=$cond."(select poling_id from poling_training where phaseno=".$phaseno.") order by tag desc,rnumber";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
for ($i=0;$i<count($row);$i++)
{
$sl=$row[$i]['Slno'];
$catg=$row[$i]['Pollcategory'];

$this->setPhaseno($phaseno);
$this->setGroupno($groupno);
$this->setPoling_id($sl);
$this->setPcategory($catg);
$this->setAttended1($atn1);
$this->setAttended2($atn2);
$this->setAttended3($atn3);

$res=false;

if ($catg==1 && $pr>0)
{
$res=$this->SaveRecord();    
if ($res) //save is successfull    
{
$a++;
$pr--;
//$objU->saveSqlLog("Training",$this->returnSql);
} //saverecord()
} //catg=1

if ($catg==2 && $p1>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$b++;
$p1--;
//$objU->saveSqlLog("Training",$this->returnSql);
} //saverecord()
} //catg=2

if ($catg==3 && $p2>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$c++;
$p2--;
//$objU->saveSqlLog("Training",$this->returnSql);
} //saverecord()
} //catg=3
    
if ($catg==4 && $p3>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$d++;
$p3--;
//$objU->saveSqlLog("Training",$this->returnSql);
} //saverecord()
} //catg=4

if ($catg==5 && $p4>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$e++;
$p4--;
//$objU->saveSqlLog("Training",$this->returnSql);
} //saverecord()
} //catg=4


if($pr==0 && $p1==0 && $p2==0 && $p3==0 && $p4==0)
{ 
$iter=$i;    
$i=count($row);
}

if($res)
{
$msql="update poling set rnumber=".rand(50001,100000)." where slno=".$sl;
$objPoling->ExecuteQuery($msql);
}

} //for loop
$str="Selected ";
if ($a>0)
$str=$str.$a." Presiding! ";
if ($b>0)
$str=$str.$b." First Poling! ";
if ($c>0)
$str=$str.$c." Second Poling! ";
if ($d>0)
$str=$str.$d." Third Poling! ";
if ($e>0)
$str=$str.$e." Forth Poling! ";

if(($a+$b+$c+$d+$e)==0)
$str="";
return($str);   
}//selecttrainee



public function SelectGroupTrainee($phaseno,$groupno,$pr,$p1,$p2,$p3,$p4,$atn1,$atn2,$atn3,$tot)
{
$objPoling=new Poling();
$objU=new Utility();
$str="";
$objU=new Utility();
$sumt=array();
$sumt[1]=0;
$sumt[2]=0;
$sumt[3]=0;
$sumt[4]=0;
$sumt[5]=0;

$sl=0;
$catg=0;
$iter=0;
$row=array();
//Process Presiding


$cond=" (pollcategory between 1 and 5) and (selected='Y' or selected='R') and grpno>0 and slno not in";
$cond=$cond."(select poling_id from poling_training where phaseno=".$phaseno.") order by grpno, pollcategory ";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();

//echo $pr."-".$p1."-".$p2."-".$p3."-".$p4."=".$tot."<br>";
//$objU->saveSqlLog("TAB", $objPoling->returnSql);
//$objU->saveSqlLog("TAB", count($row));

for ($i=0;$i<count($row);$i++)
{
$sl=$row[$i]['Slno'];
$catg=$row[$i]['Pollcategory'];
$mygrp=$row[$i]['Grpno'];

$this->setPhaseno($phaseno);
$this->setGroupno($groupno);
$this->setPoling_id($sl);
$this->setPcategory($catg);
$this->setAttended1($atn1);
$this->setAttended2($atn2);
$this->setAttended3($atn3);
if ($catg==1 && $pr>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$//objU->saveSqlLog("TAB", $i.".".$this->returnSql);
//$objU->saveSqlLog("GroupTraining",$this->returnSql);
} //saverecord()
} //catg=1
//$objU->saveSqlLog("Test", $mygrp."-".$catg."-".$sl);

if ($catg==2 && $p1>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);
//$objU->saveSqlLog("GroupTraining",$this->returnSql);
} //saverecord()
} //catg=2


if ($catg==3 && $p2>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);
//$objU->saveSqlLog("GroupTraining",$this->returnSql);
} //saverecord()
} //catg=3
    
if ($catg==4 && $p3>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);
//$objU->saveSqlLog("GroupTraining",$this->returnSql);
} //saverecord()
} //catg=4

if ($catg==5 && $p4>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);
//$objU->saveSqlLog("GroupTraining",$this->returnSql);
} //saverecord()
} //catg=4
//Trggroup
//$objU->saveSqlLog("Test", $this->returnSql);
if(($sumt[1]+$sumt[2]+$sumt[3]+$sumt[4]+$sumt[5])>$tot)
{    
$i=count($row)+1;  //break the loop and Delete Incomplete Group
$tsql="delete from Poling_Training where phaseno=2 and Poling_id in(select Slno from Poling where grpno=".$mygrp.")";
mysql_query($tsql);
//$objU->saveSqlLog("GroupTraining",$tsql);
}
else 
{
$tsql="update polinggroup set trggroup=".$groupno." where grpno=".$mygrp;    
mysql_query($tsql);
//$objU->saveSqlLog("GroupTraining",$tsql);
}
} //for loop
//Delete unnecessary row
for($m=1;$m<=$catg;$m++)
{
$sumt[$m]--;
}

$str="Selected ";
if ($sumt[1]>0)
$str=$str.$sumt[1]." Presiding! ";
if ($sumt[2]>0)
$str=$str.$sumt[2]." First Poling! ";
if ($sumt[3]>0)
$str=$str.$sumt[3]." Second Poling! ";
if ($sumt[4]>0)
$str=$str.$sumt[4]." Third Poling! ";
if ($sumt[5]>0)
$str=$str.$sumt[5]." Forth Poling! ";

if(($sumt[1]+$sumt[2]+$sumt[3]+$sumt[4]+$sumt[5])==0)
$str="";
return($str);   
}//selectgrouptrainee


public function countCategory($ph,$grp)
{
$catg=array();
$catg[1]="Pr";
$catg[2]="P1";
$catg[3]="P2";
$catg[4]="P3";
$catg[5]="P4";
$catg[6]="-";
$catg[7]="Micro";

$tRows="";
$sql="select pcategory,count(*) from poling_training where phaseno=".$ph." and groupno=".$grp." group by pcategory order by pcategory";
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
//echo $row[0]."-".$row[1];    
$tRows=$tRows.$catg[$row[0]]."-".$row[1]." ";
} //End While
return($tRows);
}//countcategory

public function mySelection($cat,$phase)
{
$condition=array();
$st="<font face=Arial size=2 color=blue>";
$condition[1]=" pcategory=1 and phaseno=".$phase;
$condition[2]=" pcategory=2 and phaseno=".$phase;
$condition[3]=" pcategory=3 and phaseno=".$phase;
$condition[4]=" pcategory=4 and phaseno=".$phase;
$condition[5]=" pcategory=5 and phaseno=".$phase;
$tg=$this->rowCount($condition[$cat]);
$st=$st.$tg;

$objP=new Poling();
if($phase>3)
{
$condition[1]=" CountCategory=1 and sex='M' and deleted='N'";
$condition[2]=" CountCategory=2 and sex='M' and deleted='N'";
$condition[3]=" CountCategory=3 and sex='M' and deleted='N'";
}
else
{
$condition[1]=" selected='Y' and pollCategory=1 and sex='M' and deleted='N'";
$condition[2]=" selected='Y' and pollCategory=2 and sex='M' and deleted='N'";
$condition[3]=" selected='Y' and pollCategory=3 and sex='M' and deleted='N'";
$condition[4]=" selected='Y' and pollCategory=4 and sex='M' and deleted='N'";
$condition[5]=" selected='Y' and pollCategory=5 and sex='M' and deleted='N'";
}

$mcond=$condition[$cat];
if ($phase==2)
$mcond=$mcond." and (selected='Y' or selected='R') and grpno>0";

if ($phase==5)
$mcond=$mcond." and (countselected='Y' or countselected='R') and countgrpno>0";


$st=$st."<font face=Arial size=1 color=black>/<font face=Arial size=2 color=red>";
$tg=$objP->rowCount($mcond);
$st=$st.$tg;
if ($tg>0)
return($st);
else 
return("");   
}


public function SelectMicro($phaseno,$groupno,$pr,$atn1,$atn2,$atn3)
{
$objPoling=new Poling();
$str="";
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$sl=0;
$catg=0;
$iter=0;
$row=array();
//Process Micro Observer
$cond=" pollcategory =7 and Selected='Y' and Grpno=0 and deleted='N' and sex='M' and slno not in";
$cond=$cond."(select poling_id from poling_training where phaseno=".$phaseno.") order by tag desc,rnumber";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
for ($i=0;$i<count($row);$i++)
{
$sl=$row[$i]['Slno'];
$catg=$row[$i]['Pollcategory'];

$this->setPhaseno($phaseno);
$this->setGroupno($groupno);
$this->setPoling_id($sl);
$this->setPcategory($catg);
$this->setAttended1($atn1);
$this->setAttended2($atn2);
$this->setAttended3($atn3);
if ($catg==7 && $pr>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$a++;
$pr--;
} //saverecord()
} //catg=7

if($pr==0)
{ 
$iter=$i;    
$i=count($row);
}

//echo $a."-".$b."-".$c."-".$d."-".$e.":Iteration ".$iter;
} //for loop

$str="Selected ";
if ($a>0)
$str=$str.$a." Micro Observer! ";

if($a==0)
$str="";
return($str);   
}//select Micro Trainee

public function SelectCountTrainee($phaseno,$groupno,$pr,$p1,$p2,$atn1,$atn2,$atn3)
{
$objPoling=new Poling();
$str="";
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$sl=0;
$catg=0;
$iter=0;
$row=array();
//Process Presiding
$cond=" (countcategory between 1 and 3) and countSelected='N' and countGrpno=0 and deleted='N' and sex='M' and slno not in";
$cond=$cond."(select poling_id from poling_training where phaseno=".$phaseno.") order by tag desc,rnumber";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();
for ($i=0;$i<count($row);$i++)
{
$sl=$row[$i]['Slno'];
$catg=$row[$i]['Countcategory'];

$this->setPhaseno($phaseno);
$this->setGroupno($groupno);
$this->setPoling_id($sl);
$this->setPcategory($catg);
$this->setAttended1($atn1);
$this->setAttended2($atn2);
$this->setAttended3($atn3);

$res=false;

if ($catg==1 && $pr>0)
{
$res=$this->SaveRecord();    
if ($res) //save is successfull    
{
$a++;
$pr--;
} //saverecord()
} //catg=1

if ($catg==2 && $p1>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$b++;
$p1--;
} //saverecord()
} //catg=2

if ($catg==3 && $p2>0)
{
$res=$this->SaveRecord();      
if ($res) //save is successfull    
{
$c++;
$p2--;
} //saverecord()
} //catg=3
 
if($pr==0 && $p1==0 && $p2==0)
{ 
$iter=$i;    
$i=count($row);
}

if($res)
{
$msql="update poling set rnumber=".rand(50001,100000)." where slno=".$sl;
$objPoling->ExecuteQuery($msql);
}
} //for loop
$str="Selected ";
if ($a>0)
$str=$str.$a." Supervisor! ";
if ($b>0)
$str=$str.$b." Assistant! ";
if ($c>0)
$str=$str.$c." Static Observer! ";


if(($a+$b+$c)==0)
$str="";
return($str);   
}//selecttrainee


public function SelectCountGroupTrainee($phaseno,$groupno,$pr,$p1,$p2,$atn1,$atn2,$atn3,$tot)
{
$objPoling=new Poling();
$objU=new Utility();
$str="";

$sumt=array();
$sumt[1]=0;
$sumt[2]=0;
$sumt[3]=0;

$sl=0;
$catg=0;
$iter=0;
$row=array();
//Process Presiding


$cond=" (countcategory between 1 and 3) and (countselected='Y' or countselected='R') and countgrpno>0 and slno not in";
$cond=$cond."(select poling_id from poling_training where phaseno=".$phaseno.") order by countgrpno, countcategory ";
$objPoling->setCondString($cond);
$row=$objPoling->getAllRecord();

echo $pr."-".$p1."-".$p2."=".$tot."<br>";
//$objU->saveSqlLog("TAB", $objPoling->returnSql);
//$objU->saveSqlLog("TAB", count($row));

for ($i=0;$i<count($row);$i++)
{
$sl=$row[$i]['Slno'];
$catg=$row[$i]['Countcategory'];
$mygrp=$row[$i]['Countgrpno'];

//$objU->saveSqlLog("Mylog", "Total-".$tot);
//$objU->saveSqlLog("Mylog", $mygrp);

$this->setPhaseno($phaseno);
$this->setGroupno($groupno);
$this->setPoling_id($sl);
$this->setPcategory($catg);
$this->setAttended1($atn1);
$this->setAttended2($atn2);
$this->setAttended3($atn3);
if ($catg==1 && $pr>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$//objU->saveSqlLog("TAB", $i.".".$this->returnSql);
} //saverecord()
} //catg=1
//$objU->saveSqlLog("Test", $mygrp."-".$catg."-".$sl);

if ($catg==2 && $p1>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);
} //saverecord()
} //catg=2


if ($catg==3 && $p2>0)
{
if ($this->SaveRecord()) //save is successfull    
{
$sumt[$catg]++;
//$objU->saveSqlLog("TAB", $i.".".$this->returnSql);

} //saverecord()
} //catg=3
    
//Trggroup
//$objU->saveSqlLog("Test", $this->returnSql);
if(($sumt[1]+$sumt[2]+$sumt[3])>$tot)
{    
$i=count($row)+1;  //break the loop and Delete Incomplete Group
mysql_query("delete from Poling_Training where phaseno=5 and Poling_id in(select Slno from Poling where countgrpno=".$mygrp.")");
}
else 
{
$sql="update countinggroup set trggroup=".$groupno." where grpno=".$mygrp;
mysql_query($sql);
//$objU->saveSqlLog("Mylog", $sql);
}
} //for loop
//Delete unnecessary row
for($m=1;$m<=$catg;$m++)
{
$sumt[$m]--;
}

$str="Selected ";
if ($sumt[1]>0)
$str=$str.$sumt[1]." Supervisor! ";
if ($sumt[2]>0)
$str=$str.$sumt[2]." Assistant! ";
if ($sumt[3]>0)
$str=$str.$sumt[3]." Static Observer! ";


if(($sumt[1]+$sumt[2]+$sumt[3])==0)
$str="";
return($str);   
}//selectgrouptrainee


}//End Class
?>
