<?php
require_once 'class.config.php';
require_once 'class.trg_time.php';
require_once 'class.trg_hall.php';
class Training
{
private $Phaseno;
private $Groupno;
private $Trgdate1;
private $Trgdate2;
private $Trgdate3;
private $Venue_code;
private $Hall_rsl;
private $Trgtime;
private $Trgplace;
private $Hallcapacity;
private $Tag;
private $Attendance_lock;
private $Pr;
private $P1;
private $P2;
private $P3;
private $P4;

//extra Old Variable to store Pre update Data
private $Old_Phaseno;
private $Old_Groupno;
private $Old_Trgdate1;
private $Old_Trgdate2;
private $Old_Trgdate3;
private $Old_Venue_code;
private $Old_Hall_rsl;
private $Old_Trgtime;
private $Old_Trgplace;
private $Old_Hallcapacity;
private $Old_Tag;
private $Old_Attendance_lock;
private $Old_Pr;
private $Old_P1;
private $Old_P2;
private $Old_P3;
private $Old_P4;

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Attendance_lock="N";
private $Def_Pr="0";
private $Def_P1="0";
private $Def_P2="0";
private $Def_P3="0";
private $Def_P4="0";
//public function _construct($i) //for PHP6
public function Training()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$updateList="";
$sql=" select count(*) from training";
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
$sql=" select count(*) from training where ".$condition;
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
$sql="select groupno,TrgPlace from training where ".$this->condString." order by TrgPlace";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
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

public function getTrgdate1()
{
return($this->Trgdate1);
}

public function setTrgdate1($str)
{
$this->Trgdate1=$str;
}

public function getTrgdate2()
{
return($this->Trgdate2);
}

public function setTrgdate2($str)
{
$this->Trgdate2=$str;
}

public function getTrgdate3()
{
return($this->Trgdate3);
}

public function setTrgdate3($str)
{
$this->Trgdate3=$str;
}

public function getVenue_code()
{
return($this->Venue_code);
}

public function setVenue_code($str)
{
$this->Venue_code=$str;
}

public function getHall_rsl()
{
return($this->Hall_rsl);
}

public function setHall_rsl($str)
{
$this->Hall_rsl=$str;
}

public function getTrgtime()
{
return($this->Trgtime);
}

public function setTrgtime($str)
{
$this->Trgtime=$str;
}

public function getTrgplace()
{
return($this->Trgplace);
}

public function setTrgplace($str)
{
$this->Trgplace=$str;
}

public function getHallcapacity()
{
return($this->Hallcapacity);
}

public function setHallcapacity($str)
{
$this->Hallcapacity=$str;
}

public function getTag()
{
return($this->Tag);
}

public function setTag($str)
{
$this->Tag=$str;
}

public function getAttendance_lock()
{
return($this->Attendance_lock);
}

public function setAttendance_lock($str)
{
$this->Attendance_lock=$str;
}

public function getPr()
{
return($this->Pr);
}

public function setPr($str)
{
$this->Pr=$str;
}

public function getP1()
{
return($this->P1);
}

public function setP1($str)
{
$this->P1=$str;
}

public function getP2()
{
return($this->P2);
}

public function setP2($str)
{
$this->P2=$str;
}

public function getP3()
{
return($this->P3);
}

public function setP3($str)
{
$this->P3=$str;
}

public function getP4()
{
return($this->P4);
}

public function setP4($str)
{
$this->P4=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Phaseno,Groupno,Trgdate1,Trgdate2,Trgdate3,Venue_code,Hall_rsl,Trgtime,Trgplace,Hallcapacity,Tag,Attendance_lock,Pr,P1,P2,P3,P4 from training where Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Trgdate1'])>0)
$this->Old_Trgdate1=$row['Trgdate1'];
else
$this->Old_Trgdate1="NULL";
if (strlen($row['Trgdate2'])>0)
$this->Old_Trgdate2=$row['Trgdate2'];
else
$this->Old_Trgdate2="NULL";
if (strlen($row['Trgdate3'])>0)
$this->Old_Trgdate3=$row['Trgdate3'];
else
$this->Old_Trgdate3="NULL";
if (strlen($row['Venue_code'])>0)
$this->Old_Venue_code=$row['Venue_code'];
else
$this->Old_Venue_code="NULL";
if (strlen($row['Hall_rsl'])>0)
$this->Old_Hall_rsl=$row['Hall_rsl'];
else
$this->Old_Hall_rsl="NULL";
if (strlen($row['Trgtime'])>0)
$this->Old_Trgtime=$row['Trgtime'];
else
$this->Old_Trgtime="NULL";
if (strlen($row['Trgplace'])>0)
$this->Old_Trgplace=$row['Trgplace'];
else
$this->Old_Trgplace="NULL";
if (strlen($row['Hallcapacity'])>0)
$this->Old_Hallcapacity=$row['Hallcapacity'];
else
$this->Old_Hallcapacity="NULL";
if (strlen($row['Tag'])>0)
$this->Old_Tag=$row['Tag'];
else
$this->Old_Tag="NULL";
if (strlen($row['Attendance_lock'])>0)
$this->Old_Attendance_lock=$row['Attendance_lock'];
else
$this->Old_Attendance_lock="NULL";

return(true);
}
else
return(false);
} //end copy variable

public function DuplicateExist()
{
$sql="select Groupno from training where Phaseno='".$this->Phaseno."' and ";
$sql=$sql." Trgdate1='".$this->Trgdate1."' and Venue_code=".$this->Venue_code." and Hall_rsl=".$this->Hall_rsl." and Trgtime=".$this->Trgtime;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);    
}


public function EditRecord()
{
$sql="select Phaseno,Groupno,Trgdate1,Trgdate2,Trgdate3,Venue_code,Hall_rsl,Trgtime,Trgplace,Hallcapacity,Tag,Attendance_lock from training where Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Trgdate1=$row['Trgdate1'];
$this->Trgdate2=$row['Trgdate2'];
$this->Trgdate3=$row['Trgdate3'];
$this->Venue_code=$row['Venue_code'];
$this->Hall_rsl=$row['Hall_rsl'];
$this->Trgtime=$row['Trgtime'];
$this->Trgplace=$row['Trgplace'];
$this->Hallcapacity=$row['Hallcapacity'];
$this->Tag=$row['Tag'];
$this->Attendance_lock=$row['Attendance_lock'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from training where Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
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
$sql="update training set ";
if ($this->Old_Trgdate1!=$this->Trgdate1 &&  strlen($this->Trgdate1)>0)
{
if ($this->Trgdate1=="NULL")
$sql=$sql."Trgdate1=NULL";
else
$sql=$sql."Trgdate1='".$this->Trgdate1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgdate1=".$this->Trgdate1.", ";
}

if ($this->Old_Trgdate2!=$this->Trgdate2 &&  strlen($this->Trgdate2)>0)
{
if ($this->Trgdate2=="NULL")
$sql=$sql."Trgdate2=NULL";
else
$sql=$sql."Trgdate2='".$this->Trgdate2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgdate2=".$this->Trgdate2.", ";
}

if ($this->Old_Trgdate3!=$this->Trgdate3 &&  strlen($this->Trgdate3)>0)
{
if ($this->Trgdate3=="NULL")
$sql=$sql."Trgdate3=NULL";
else
$sql=$sql."Trgdate3='".$this->Trgdate3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgdate3=".$this->Trgdate3.", ";
}

if ($this->Old_Venue_code!=$this->Venue_code &&  strlen($this->Venue_code)>0)
{
if ($this->Venue_code=="NULL")
$sql=$sql."Venue_code=NULL";
else
$sql=$sql."Venue_code='".$this->Venue_code."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Venue_code=".$this->Venue_code.", ";
}

if ($this->Old_Hall_rsl!=$this->Hall_rsl &&  strlen($this->Hall_rsl)>0)
{
if ($this->Hall_rsl=="NULL")
$sql=$sql."Hall_rsl=NULL";
else
$sql=$sql."Hall_rsl='".$this->Hall_rsl."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hall_rsl=".$this->Hall_rsl.", ";
}

if ($this->Old_Trgtime!=$this->Trgtime &&  strlen($this->Trgtime)>0)
{
if ($this->Trgtime=="NULL")
$sql=$sql."Trgtime=NULL";
else
$sql=$sql."Trgtime='".$this->Trgtime."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgtime=".$this->Trgtime.", ";
}

if ($this->Old_Trgplace!=$this->Trgplace &&  strlen($this->Trgplace)>0)
{
if ($this->Trgplace=="NULL")
$sql=$sql."Trgplace=NULL";
else
$sql=$sql."Trgplace='".$this->Trgplace."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Trgplace=".$this->Trgplace.", ";
}

if ($this->Old_Hallcapacity!=$this->Hallcapacity &&  strlen($this->Hallcapacity)>0)
{
if ($this->Hallcapacity=="NULL")
$sql=$sql."Hallcapacity=NULL";
else
$sql=$sql."Hallcapacity='".$this->Hallcapacity."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Hallcapacity=".$this->Hallcapacity.", ";
}

if ($this->Old_Tag!=$this->Tag &&  strlen($this->Tag)>0)
{
if ($this->Tag=="NULL")
$sql=$sql."Tag=NULL";
else
$sql=$sql."Tag='".$this->Tag."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Tag=".$this->Tag.", ";
}

if ($this->Old_Attendance_lock!=$this->Attendance_lock &&  strlen($this->Attendance_lock)>0)
{
if ($this->Attendance_lock=="NULL")
$sql=$sql."Attendance_lock=NULL";
else
$sql=$sql."Attendance_lock='".$this->Attendance_lock."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Attendance_lock=".$this->Attendance_lock.", ";
}
$sql=$sql."Attendance_lock=Attendance_lock";



$cond="  where Phaseno='".$this->Phaseno."' and Groupno='".$this->Groupno."'";
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
$sql="insert into training(Phaseno,Groupno,Trgdate1,Trgdate2,Trgdate3,Venue_code,Hall_rsl,Trgtime,Trgplace,Hallcapacity,Tag,Attendance_lock) values(";
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

if (strlen($this->Trgdate1)>0)
{
if ($this->Trgdate1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgdate1."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Trgdate2)>0)
{
if ($this->Trgdate2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgdate2."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Trgdate3)>0)
{
if ($this->Trgdate3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgdate3."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Venue_code)>0)
{
if ($this->Venue_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Venue_code."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Hall_rsl)>0)
{
if ($this->Hall_rsl=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hall_rsl."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Trgtime)>0)
{
if ($this->Trgtime=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgtime."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Trgplace)>0)
{
if ($this->Trgplace=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trgplace."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Hallcapacity)>0)
{
if ($this->Hallcapacity=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Hallcapacity."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Tag)>0)
{
if ($this->Tag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Tag."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Attendance_lock)>0)
{
if ($this->Attendance_lock=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Attendance_lock."'";
}
else
$sql=$sql."'N'";



$sql=$sql.")";

$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function maxPhaseno()
{
$sql="select max(Phaseno) from training";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}
public function maxGroupno($ph)
{
$sql="select max(Groupno) from training where Phaseno=".$ph;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]+1);
else
return(1);
}

public function getTrainingDetail($Slno,$phase)
{
$tRows=array();
$sql="select Phaseno,Groupno  from Poling_training where Poling_id=".$Slno." and phaseno=".$phase;
$i=0;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
$grp=$row['Groupno'];    
else
$grp=0;
//echo $sql;
//echo "group-".$grp;
$sql="select Trgdate1,Trgdate2,Trgdate3,Venue_code,Hall_rsl,Trgtime,Trgplace from training where Phaseno=".$phase." and Groupno=".$grp;
$this->returnsql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$tRows['Groupno']=$grp;
$tRows['Trgdate']=$row['Trgdate1'];
if (strlen($row['Trgdate2'])>0)
$tRows['Trgdate']=$tRows['Trgdate'].",".$row['Trgdate2'];
if (strlen($row['Trgdate3'])>0)
$tRows['Trgdate']=$tRows['Trgdate'].",".$row['Trgdate3'];
$tRows['Trgplace']=$row['Trgplace'];

$objTt=new Trg_time();
$objTt->setCode($row['Trgtime']);
if ($objTt->EditRecord())
$tRows['Trgtime']=$objTt->getTiming ();
else
$tRows['Trgtime']="";

$objTH=new Trg_hall();
$objTH->setVenue_code($row['Venue_code']);
$objTH->setRsl($row['Hall_rsl']);
if ($objTH->EditRecord())
$tRows['Hallno']=$objTH->getHall_number ();
else
$tRows['Hallno']="";    
}
return($tRows);
}



public function getAllRecord()
{
$tRows=array();
$sql="select Phaseno,Groupno,Trgdate1,Trgdate2,Trgdate3,Venue_code,Hall_rsl,Trgtime,Trgplace,Hallcapacity,Tag,Attendance_lock from training where ".$this->condString;
$i=0;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Phaseno']=$row['Phaseno'];
$tRows[$i]['Groupno']=$row['Groupno'];
$tRows[$i]['Trgdate1']=$row['Trgdate1'];
$tRows[$i]['Trgdate2']=$row['Trgdate2'];
$tRows[$i]['Trgdate3']=$row['Trgdate3'];
$tRows[$i]['Venue_code']=$row['Venue_code'];
$tRows[$i]['Hall_rsl']=$row['Hall_rsl'];
$tRows[$i]['Trgtime']=$row['Trgtime'];
$tRows[$i]['Trgplace']=$row['Trgplace'];
$tRows[$i]['Hallcapacity']=$row['Hallcapacity'];
$tRows[$i]['Tag']=$row['Tag'];
$tRows[$i]['Attendance_lock']=$row['Attendance_lock'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function GenCheckBox($cat)
{
$totTrg=0;
$str="<font face=arial size=2 color=blue>Prefer Training Attendance on ";
$j=0;
$mcond=" and poling_training.phaseno=1 and poling_training.phaseno=training.phaseno and poling_training.groupno=training.groupno";
$sql="select distinct TrgDate1 from training,poling_training where Attended1='Y' and pcategory=".$cat.$mcond;
//echo $sql;
$result=mysql_query($sql);
$i=0;
while($row=mysql_fetch_array($result))
{
$str=$str." <font face=arial size=1 color=black>[".$row[0]."]";
$i++;
$j++;
}
if ($i>0)
{
$str=$str."<input type=checkbox name=Trg1 id=Trg1 checked=checked onclick=recheck(1)>";    
$totTrg++;
}

$sql="select distinct TrgDate2 from training,poling_training where Attended2='Y' and pcategory=".$cat.$mcond;
$result=mysql_query($sql);
$i=0;
while($row=mysql_fetch_array($result))
{
$str=$str." <font face=arial size=1 color=black>[".$row[0]."]";
$i++;
$j++;
}
if ($i>0)
{
$str=$str."<input type=checkbox name=Trg2 id=Trg2 checked=checked onclick=recheck(2)>";    
$totTrg++;
}

$sql="select distinct TrgDate3 from training,poling_training where Attended3='Y' and pcategory=".$cat.$mcond;
$result=mysql_query($sql);
$i=0;
while($row=mysql_fetch_array($result))
{
$str=$str." <font face=arial size=1 color=black>[".$row[0]."]";
$i++;
$j++;
}

if ($i>0)
{
$str=$str."<input type=checkbox name=Trg3 id=Trg3 checked=checked onclick=recheck(3)>";    
$totTrg++;
}

if($totTrg>1)
$str=$str."<font face=arial size=2 color=red>OR&nbsp;<font face=arial size=2 color=blue>Consider any one day<input type=checkbox name=TrgAny id=TrgAny>"; 
else
$str=$str."<input type=hidden name=TrgAny id=TrgAny>"; 
    
if ($j>0)
return($str);
else
return("");
} //gencheckbox


public function TrainingStatus($pid)
{
$str="";
$mcond=" and poling_training.phaseno=1 and poling_training.phaseno=training.phaseno and poling_training.groupno=training.groupno";
$sql="select TrgDate1,TrgDate2,TrgDate3,Attended1,Attended2,Attended3,Attendance_lock from training,poling_training where POLING_ID=".$pid.$mcond;
//echo $sql;
//echo $sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$str=$str."<font face=arial size=1>Training on ".$row[0]." :".$row[1]." :".$row[2];    
if ($row['Attendance_lock']=="N")
$str=$str." Called<br>";
else
$str=$str."<br>Status-[".$row['Attended1'].":".$row['Attended2'].":".$row['Attended3']."]";
}
return($str);
} //gencheckbox


}//End Class
?>
