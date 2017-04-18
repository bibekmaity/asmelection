<?php
require_once 'class.config.php';
require_once 'class.Lac.php';
require_once 'class.Sentence.php';
require_once 'class.BEEO.php';
require_once 'class.category.php';
class Poling
{
private $Slno;
private $R_lac;
private $Beeo_code;
private $Depcode;
private $Department;
private $Name;
private $Desig;
private $Homeconst;
private $Basic;
private $Sex;
private $Age;
private $Placeofresidence;
private $Psno_Vsl;
private $Gradepay;
private $Tag;
private $Depconst;
private $Pollcategory;
private $Cellname;
private $Grpno;
private $Selected;
private $Rnumber;
private $Gazeted;
private $Phone;
private $Remarks;
private $Deleted;
private $Countcategory;
private $Countgrpno;
private $Countselected;
private $Dor;
private $Entry_date;
private $Entry_time;
private $Username;
private $Exempt_history;

//extra Old Variable to store Pre update Data
private $Old_Slno;
private $Old_R_lac;
private $Old_Beeo_code;
private $Old_Depcode;
private $Old_Department;
private $Old_Name;
private $Old_Desig;
private $Old_Homeconst;
private $Old_Basic;
private $Old_Sex;
private $Old_Age;
private $Old_Placeofresidence;
private $Old_Psno_Vsl;
private $Old_Gradepay;
private $Old_Tag;
private $Old_Depconst;
private $Old_Pollcategory;
private $Old_Cellname;
private $Old_Grpno;
private $Old_Selected;
private $Old_Rnumber;
private $Old_Gazeted;
private $Old_Phone;
private $Old_Remarks;
private $Old_Deleted;
private $Old_Countcategory;
private $Old_Countgrpno;
private $Old_Countselected;
private $Old_Dor;


public $updateList;
public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $FieldUpdated;
public $colUpdated;
private $Def_Beeo_code="0";
private $Def_Tag="1";
private $Def_Cellname="-";
private $Def_Grpno="0";
private $Def_Deleted="N";
private $Def_Countcategory="0";
private $Def_Countgrpno="0";
private $Def_Exempt_history="-";


//public function _construct($i) //for PHP6
public function Poling()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$colUpdated=0;
$sql=" select count(*) from poling";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
}//End constructor

public function rowCount($condition)
{
$sql=" select count(*) from poling where ".$condition;
$result=mysql_query($sql);
//echo $sql;
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //rowCount

private function copyVariable()
{
$sql="select Slno,R_lac,Beeo_code,Depcode,Department,Name,Desig,Homeconst,Basic,Sex,Age,Placeofresidence,Psno_Vsl,Gradepay,Tag,Depconst,Pollcategory,Cellname,Grpno,Selected,Rnumber,Gazeted,Phone,Remarks,Deleted,Countcategory,Countgrpno,Countselected,Dor from poling where Slno='".$this->Slno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['R_lac'])>0)
$this->Old_R_lac=$row['R_lac'];
else
$this->Old_R_lac="NULL";
if (strlen($row['Beeo_code'])>0)
$this->Old_Beeo_code=$row['Beeo_code'];
else
$this->Old_Beeo_code="NULL";
if (strlen($row['Depcode'])>0)
$this->Old_Depcode=$row['Depcode'];
else
$this->Old_Depcode="NULL";
if (strlen($row['Department'])>0)
$this->Old_Department=$row['Department'];
else
$this->Old_Department="NULL";
if (strlen($row['Name'])>0)
$this->Old_Name=$row['Name'];
else
$this->Old_Name="NULL";
if (strlen($row['Desig'])>0)
$this->Old_Desig=$row['Desig'];
else
$this->Old_Desig="NULL";
if (strlen($row['Homeconst'])>0)
$this->Old_Homeconst=$row['Homeconst'];
else
$this->Old_Homeconst="NULL";
if (strlen($row['Basic'])>0)
$this->Old_Basic=$row['Basic'];
else
$this->Old_Basic="NULL";
if (strlen($row['Sex'])>0)
$this->Old_Sex=$row['Sex'];
else
$this->Old_Sex="NULL";
if (strlen($row['Age'])>0)
$this->Old_Age=$row['Age'];
else
$this->Old_Age="NULL";
if (strlen($row['Placeofresidence'])>0)
$this->Old_Placeofresidence=$row['Placeofresidence'];
else
$this->Old_Placeofresidence="NULL";
if (strlen($row['Psno_Vsl'])>0)
$this->Old_Psno_Vsl=$row['Psno_Vsl'];
else
$this->Old_Psno_Vsl="NULL";
if (strlen($row['Gradepay'])>0)
$this->Old_Gradepay=$row['Gradepay'];
else
$this->Old_Gradepay="NULL";
if (strlen($row['Tag'])>0)
$this->Old_Tag=$row['Tag'];
else
$this->Old_Tag="NULL";
if (strlen($row['Depconst'])>0)
$this->Old_Depconst=$row['Depconst'];
else
$this->Old_Depconst="NULL";
if (strlen($row['Pollcategory'])>0)
$this->Old_Pollcategory=$row['Pollcategory'];
else
$this->Old_Pollcategory="NULL";
if (strlen($row['Cellname'])>0)
$this->Old_Cellname=$row['Cellname'];
else
$this->Old_Cellname="NULL";
if (strlen($row['Grpno'])>0)
$this->Old_Grpno=$row['Grpno'];
else
$this->Old_Grpno="NULL";
if (strlen($row['Selected'])>0)
$this->Old_Selected=$row['Selected'];
else
$this->Old_Selected="NULL";
if (strlen($row['Rnumber'])>0)
$this->Old_Rnumber=$row['Rnumber'];
else
$this->Old_Rnumber="NULL";
if (strlen($row['Gazeted'])>0)
$this->Old_Gazeted=$row['Gazeted'];
else
$this->Old_Gazeted="NULL";
if (strlen($row['Phone'])>0)
$this->Old_Phone=$row['Phone'];
else
$this->Old_Phone="NULL";
if (strlen($row['Remarks'])>0)
$this->Old_Remarks=$row['Remarks'];
else
$this->Old_Remarks="NULL";
if (strlen($row['Deleted'])>0)
$this->Old_Deleted=$row['Deleted'];
else
$this->Old_Deleted="NULL";
if (strlen($row['Countcategory'])>0)
$this->Old_Countcategory=$row['Countcategory'];
else
$this->Old_Countcategory="NULL";
if (strlen($row['Countgrpno'])>0)
$this->Old_Countgrpno=$row['Countgrpno'];
else
$this->Old_Countgrpno="NULL";
if (strlen($row['Countselected'])>0)
$this->Old_Countselected=$row['Countselected'];
else
$this->Old_Countselected="NULL";
if (strlen($row['Dor'])>0)
$this->Old_Dor=substr($row['Dor'],0,10);
else
$this->Old_Dor="NULL";
return(true);
}
else
return(false);
} //end copy variable





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
$sql="select SlNo,Name from poling where ".$this->condString;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i][0]=$row[0];
$tRow[$i][1]=$row[1];
$i++;
}
return($tRow);
}




public function CountRow($depcode)
{
$sql="select count(*) from poling where depcode=".$depcode;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
return($row[0]);
}


public function getSlno()
{
return($this->Slno);
}

public function setSlno($str)
{
$this->Slno=$str;
}

public function getR_lac()
{
return($this->R_lac);
}

public function setR_lac($str)
{
$this->R_lac=$str;
}

public function getBeeo_code()
{
return($this->Beeo_code);
}

public function setBeeo_code($str)
{
$this->Beeo_code=$str;
}

public function getDepcode()
{
return($this->Depcode);
}

public function setDepcode($str)
{
$this->Depcode=$str;
}

public function getDepartment()
{
return($this->Department);
}

public function setDepartment($str)
{
$this->Department=$str;
}

public function getName()
{
return($this->Name);
}

public function setName($str)
{
$this->Name=$str;
}

public function getDesig()
{
return($this->Desig);
}

public function setDesig($str)
{
$this->Desig=$str;
}

public function getHomeconst()
{
return($this->Homeconst);
}

public function setHomeconst($str)
{
$this->Homeconst=$str;
}

public function getBasic()
{
return($this->Basic);
}

public function setBasic($str)
{
$this->Basic=$str;
}

public function getSex()
{
return($this->Sex);
}

public function setSex($str)
{
$this->Sex=$str;
}

public function getAge()
{
return($this->Age);
}

public function setAge($str)
{
$this->Age=$str;
}

public function getPlaceofresidence()
{
return($this->Placeofresidence);
}

public function setPlaceofresidence($str)
{
$this->Placeofresidence=$str;
}

public function getPsno_Vsl()
{
return($this->Psno_Vsl);
}

public function setPsno_Vsl($str)
{
$this->Psno_Vsl=$str;
}

public function getGradepay()
{
return($this->Gradepay);
}

public function setGradepay($str)
{
$this->Gradepay=$str;
}

public function getTag()
{
return($this->Tag);
}

public function setTag($str)
{
$this->Tag=$str;
}

public function getDepconst()
{
return($this->Depconst);
}

public function setDepconst($str)
{
$this->Depconst=$str;
}

public function getPollcategory()
{
return($this->Pollcategory);
}

public function setPollcategory($str)
{
$this->Pollcategory=$str;
}

public function getCellname()
{
return($this->Cellname);
}

public function setCellname($str)
{
$this->Cellname=$str;
}

public function getGrpno()
{
return($this->Grpno);
}

public function setGrpno($str)
{
$this->Grpno=$str;
}

public function getSelected()
{
return($this->Selected);
}

public function setSelected($str)
{
$this->Selected=$str;
}

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
}

public function getGazeted()
{
return($this->Gazeted);
}

public function setGazeted($str)
{
$this->Gazeted=$str;
}

public function getPhone()
{
return($this->Phone);
}

public function setPhone($str)
{
$this->Phone=$str;
}

public function getRemarks()
{
return($this->Remarks);
}

public function setRemarks($str)
{
$this->Remarks=$str;
}

public function getDeleted()
{
return($this->Deleted);
}

public function setDeleted($str)
{
$this->Deleted=$str;
}

public function getCountcategory()
{
return($this->Countcategory);
}

public function setCountcategory($str)
{
$this->Countcategory=$str;
}

public function getCountgrpno()
{
return($this->Countgrpno);
}

public function setCountgrpno($str)
{
$this->Countgrpno=$str;
}

public function getCountselected()
{
return($this->Countselected);
}

public function setCountselected($str)
{
$this->Countselected=$str;
}

public function getDor()
{
return($this->Dor);
}

public function setDor($str)
{
$this->Dor=$str;
}

public function getEntry_date()
{
return($this->Entry_date);
}

public function setEntry_date($str)
{
$this->Entry_date=$str;
}

public function getEntry_time()
{
return($this->Entry_time);
}

public function setEntry_time($str)
{
$this->Entry_time=$str;
}

public function getUsername()
{
return($this->Username);
}

public function setUsername($str)
{
$this->Username=$str;
}

public function getExempt_history()
{
return($this->Exempt_history);
}

public function setExempt_history($str)
{
$this->Exempt_history=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}


public function EditRecord()
{
$sql="select Slno,R_lac,Beeo_code,Depcode,Department,Name,Desig,Homeconst,Basic,Sex,Age,Placeofresidence,Psno_Vsl,Gradepay,Tag,Depconst,Pollcategory,Cellname,Grpno,Selected,Rnumber,Gazeted,Phone,Remarks,Deleted,Countcategory,Countgrpno,Countselected,Dor from poling where Slno='".$this->Slno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->R_lac=$row['R_lac'];
$this->Beeo_code=$row['Beeo_code'];
$this->Depcode=$row['Depcode'];
$this->Department=$row['Department'];
$this->Name=$row['Name'];
$this->Desig=$row['Desig'];
$this->Homeconst=$row['Homeconst'];
$this->Basic=$row['Basic'];
$this->Sex=$row['Sex'];
$this->Age=$row['Age'];
$this->Placeofresidence=$row['Placeofresidence'];
$this->Psno_Vsl=$row['Psno_Vsl'];
$this->Gradepay=$row['Gradepay'];
$this->Tag=$row['Tag'];
$this->Depconst=$row['Depconst'];
$this->Pollcategory=$row['Pollcategory'];
$this->Cellname=$row['Cellname'];
$this->Grpno=$row['Grpno'];
$this->Selected=$row['Selected'];
$this->Rnumber=$row['Rnumber'];
$this->Gazeted=$row['Gazeted'];
$this->Phone=$row['Phone'];
$this->Remarks=$row['Remarks'];
$this->Deleted=$row['Deleted'];
$this->Countcategory=$row['Countcategory'];
$this->Countgrpno=$row['Countgrpno'];
$this->Countselected=$row['Countselected'];
$this->Dor=$row['Dor'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from poling where Slno='".$this->Slno."'";
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
$sql="update poling set ";
$sqlP="update poling_training set ";
if ($this->Old_R_lac!=$this->R_lac &&  strlen($this->R_lac)>0)
{
if ($this->R_lac=="NULL")
$sql=$sql."R_lac=NULL";
else
$sql=$sql."R_lac='".$this->R_lac."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."R_lac=".$this->R_lac.", ";
}

if ($this->Old_Beeo_code!=$this->Beeo_code &&  strlen($this->Beeo_code)>0)
{
if ($this->Beeo_code=="NULL")
$sql=$sql."Beeo_code=NULL";
else
$sql=$sql."Beeo_code='".$this->Beeo_code."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Beeo_code=".$this->Beeo_code.", ";
}

if ($this->Old_Depcode!=$this->Depcode &&  strlen($this->Depcode)>0)
{
if ($this->Depcode=="NULL")
$sql=$sql."Depcode=NULL";
else
$sql=$sql."Depcode='".$this->Depcode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Depcode=".$this->Depcode.", ";
}

if ($this->Old_Department!=$this->Department &&  strlen($this->Department)>0)
{
if ($this->Department=="NULL")
$sql=$sql."Department=NULL";
else
$sql=$sql."Department='".$this->Department."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Department=".$this->Department.", ";
}

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

if ($this->Old_Desig!=$this->Desig &&  strlen($this->Desig)>0)
{
if ($this->Desig=="NULL")
$sql=$sql."Desig=NULL";
else
$sql=$sql."Desig='".$this->Desig."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Desig=".$this->Desig.", ";
}

if ($this->Old_Homeconst!=$this->Homeconst &&  strlen($this->Homeconst)>0)
{
if ($this->Homeconst=="NULL")
$sql=$sql."Homeconst=NULL";
else
$sql=$sql."Homeconst='".$this->Homeconst."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Homeconst=".$this->Homeconst.", ";
}

if ($this->Old_Basic!=$this->Basic &&  strlen($this->Basic)>0)
{
if ($this->Basic=="NULL")
$sql=$sql."Basic=NULL";
else
$sql=$sql."Basic='".$this->Basic."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Basic=".$this->Basic.", ";
}

if ($this->Old_Sex!=$this->Sex &&  strlen($this->Sex)>0)
{
if ($this->Sex=="NULL")
$sql=$sql."Sex=NULL";
else
$sql=$sql."Sex='".$this->Sex."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Sex=".$this->Sex.", ";
}

if ($this->Old_Age!=$this->Age &&  strlen($this->Age)>0)
{
if ($this->Age=="NULL")
$sql=$sql."Age=NULL";
else
$sql=$sql."Age='".$this->Age."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Age=".$this->Age.", ";
}

if ($this->Old_Placeofresidence!=$this->Placeofresidence &&  strlen($this->Placeofresidence)>0)
{
if ($this->Placeofresidence=="NULL")
$sql=$sql."Placeofresidence=NULL";
else
$sql=$sql."Placeofresidence='".$this->Placeofresidence."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Placeofresidence=".$this->Placeofresidence.", ";
}

if ($this->Old_Psno_Vsl!=$this->Psno_Vsl &&  strlen($this->Psno_Vsl)>0)
{
if ($this->Psno_Vsl=="NULL")
$sql=$sql."Psno_Vsl=NULL";
else
$sql=$sql."Psno_Vsl='".$this->Psno_Vsl."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Psno_Vsl=".$this->Psno_Vsl.", ";
}

if ($this->Old_Gradepay!=$this->Gradepay &&  strlen($this->Gradepay)>0)
{
if ($this->Gradepay=="NULL")
$sql=$sql."Gradepay=NULL";
else
$sql=$sql."Gradepay='".$this->Gradepay."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Gradepay=".$this->Gradepay.", ";
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

if ($this->Old_Depconst!=$this->Depconst &&  strlen($this->Depconst)>0)
{
if ($this->Depconst=="NULL")
$sql=$sql."Depconst=NULL";
else
$sql=$sql."Depconst='".$this->Depconst."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Depconst=".$this->Depconst.", ";
}

if ($this->Old_Pollcategory!=$this->Pollcategory &&  strlen($this->Pollcategory)>0)
{
if ($this->Pollcategory=="NULL")
$sql=$sql."Pollcategory=NULL";
else
{    
$sql=$sql."Pollcategory='".$this->Pollcategory."'";
$sqlP=$sqlP." Pcategory='".$this->Pollcategory."'";
}
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Pollcategory=".$this->Pollcategory.", ";
}

if ($this->Old_Cellname!=$this->Cellname &&  strlen($this->Cellname)>0)
{
if ($this->Cellname=="NULL")
$sql=$sql."Cellname=NULL";
else
$sql=$sql."Cellname='".$this->Cellname."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Cellname=".$this->Cellname.", ";
}

if ($this->Old_Grpno!=$this->Grpno &&  strlen($this->Grpno)>0)
{
if ($this->Grpno=="NULL")
$sql=$sql."Grpno=NULL";
else
$sql=$sql."Grpno='".$this->Grpno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Grpno=".$this->Grpno.", ";
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


$sql=$sql."RNumber='".rand(1,25000)."'";
$sql=$sql.",";


if ($this->Old_Gazeted!=$this->Gazeted &&  strlen($this->Gazeted)>0)
{
if ($this->Gazeted=="NULL")
$sql=$sql."Gazeted=NULL";
else
$sql=$sql."Gazeted='".$this->Gazeted."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Gazeted=".$this->Gazeted.", ";
}

if ($this->Old_Phone!=$this->Phone &&  strlen($this->Phone)>0)
{
if ($this->Phone=="NULL")
$sql=$sql."Phone=NULL";
else
$sql=$sql."Phone='".$this->Phone."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Phone=".$this->Phone.", ";
}

if ($this->Old_Remarks!=$this->Remarks &&  strlen($this->Remarks)>0)
{
if ($this->Remarks=="NULL")
$sql=$sql."Remarks=NULL";
else
$sql=$sql."Remarks='".$this->Remarks."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Remarks=".$this->Remarks.", ";
}

if ($this->Old_Deleted!=$this->Deleted &&  strlen($this->Deleted)>0)
{
if ($this->Deleted=="NULL")
$sql=$sql."Deleted=NULL";
else
$sql=$sql."Deleted='".$this->Deleted."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Deleted=".$this->Deleted.", ";
}

if ($this->Old_Countcategory!=$this->Countcategory &&  strlen($this->Countcategory)>0)
{
if ($this->Countcategory=="NULL")
$sql=$sql."Countcategory=NULL";
else
$sql=$sql."Countcategory='".$this->Countcategory."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Countcategory=".$this->Countcategory.", ";
}

if ($this->Old_Countgrpno!=$this->Countgrpno &&  strlen($this->Countgrpno)>0)
{
if ($this->Countgrpno=="NULL")
$sql=$sql."Countgrpno=NULL";
else
$sql=$sql."Countgrpno='".$this->Countgrpno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Countgrpno=".$this->Countgrpno.", ";
}

if ($this->Old_Countselected!=$this->Countselected &&  strlen($this->Countselected)>0)
{
if ($this->Countselected=="NULL")
$sql=$sql."Countselected=NULL";
else
$sql=$sql."Countselected='".$this->Countselected."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Countselected=".$this->Countselected.", ";
}

if ($this->Old_Dor!=$this->Dor &&  strlen($this->Dor)>0)
{
if ($this->Dor=="NULL")
$sql=$sql."Dor=NULL";
else
$sql=$sql."Dor='".$this->Dor."'";
$i++;
$this->updateList=$this->updateList."Dor=".$this->Dor.", ";
}
else
$sql=$sql."Dor=Dor";


$cond="  where Slno=".$this->Slno;
$sqlP=$sqlP."  where poling_id=".$this->Slno;
mysql_query($sqlP);
//echo $sqlP;
$this->returnSql=$sql.$cond;
//echo "<br>";
///echo $sql.$cond;
$this->rowCommitted= mysql_affected_rows();
$this->colUpdated=$i;

if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record

public function SaveRecord()
{
    
$this->FieldUpdated="";    
$sql1="insert into poling(";
$sql=" values (";
$mcol=0;
if (strlen($this->Slno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Slno";
if ($this->Slno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Slno."'";
}

if (strlen($this->R_lac)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."R_lac";
if ($this->R_lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->R_lac."'";
}

if (strlen($this->Beeo_code)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Beeo_code";
if ($this->Beeo_code=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Beeo_code."'";
}

if (strlen($this->Depcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Depcode";
if ($this->Depcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Depcode."'";
}
$this->FieldUpdated=$this->Depcode."-";

if (strlen($this->Department)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Department";
if ($this->Department=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Department."'";
}
$this->FieldUpdated=$this->FieldUpdated.$this->Department.",";


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
$this->FieldUpdated=$this->FieldUpdated.$this->Name.",";


if (strlen($this->Desig)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Desig";
if ($this->Desig=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Desig."'";
}
$this->FieldUpdated=$this->FieldUpdated.$this->Desig.",";


if (strlen($this->Homeconst)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Homeconst";
if ($this->Homeconst=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Homeconst."'";
}
$this->FieldUpdated=$this->FieldUpdated."Lac-".$this->Homeconst.",";


if (strlen($this->Basic)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Basic";
if ($this->Basic=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Basic."'";
}
$this->FieldUpdated=$this->FieldUpdated."Basic-".$this->Basic.",";

if (strlen($this->Sex)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Sex";
if ($this->Sex=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Sex."'";
}

$this->FieldUpdated=$this->FieldUpdated."Sex-".$this->Sex.",";

if (strlen($this->Age)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Age";
if ($this->Age=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Age."'";
}

if (strlen($this->Placeofresidence)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Placeofresidence";
if ($this->Placeofresidence=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Placeofresidence."'";
}
$this->FieldUpdated=$this->FieldUpdated."Adress-".$this->Placeofresidence.",";

if (strlen($this->Psno_Vsl)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Psno_Vsl";
if ($this->Psno_Vsl=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Psno_Vsl."'";
}

if (strlen($this->Gradepay)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Gradepay";
if ($this->Gradepay=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Gradepay."'";
}

if (strlen($this->Tag)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Tag";
if ($this->Tag=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Tag."'";
}

if (strlen($this->Depconst)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Depconst";
if ($this->Depconst=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Depconst."'";
}

if (strlen($this->Pollcategory)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Pollcategory";
if ($this->Pollcategory=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Pollcategory."'";
}

$this->FieldUpdated=$this->FieldUpdated."Category-".$this->Pollcategory.",";

if (strlen($this->Cellname)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Cellname";
if ($this->Cellname=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Cellname."'";
}

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
}

//if (strlen($this->Rnumber)>0)
//{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rnumber";
$sql=$sql."'".rand(1,25000)."'";
//}


if (strlen($this->Gazeted)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Gazeted";
if ($this->Gazeted=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Gazeted."'";
}
$this->FieldUpdated=$this->FieldUpdated."Gazeted-".$this->Gazeted.",";


if (strlen($this->Phone)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Phone";
if ($this->Phone=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Phone."'";
}
$this->FieldUpdated=$this->FieldUpdated."Phone-".$this->Phone.",";

if (strlen($this->Remarks)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Remarks";
if ($this->Remarks=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Remarks."'";
}

if (strlen($this->Deleted)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Deleted";
if ($this->Deleted=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Deleted."'";
}

if (strlen($this->Countcategory)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Countcategory";
if ($this->Countcategory=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Countcategory."'";
}

if (strlen($this->Countgrpno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Countgrpno";
if ($this->Countgrpno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Countgrpno."'";
}

if (strlen($this->Countselected)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Countselected";
if ($this->Countselected=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Countselected."'";
}

if (strlen($this->Dor)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dor";
if ($this->Dor=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dor."'";
}
$this->FieldUpdated=$this->FieldUpdated."Retire Date-".$this->DOR.",";

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



public function maxSlno()
{
$sql="select max(Slno) from poling";
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
$sql="select Slno,R_lac,Beeo_code,Depcode,Department,Name,Desig,Homeconst,Basic,Sex,Age,Placeofresidence,Psno_Vsl,Gradepay,Tag,Depconst,Pollcategory,Cellname,Grpno,Selected,Rnumber,Gazeted,Phone,Remarks,Deleted,Countcategory,Countgrpno,Countselected,Dor from poling where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['R_lac']=$row['R_lac'];
$tRows[$i]['Beeo_code']=$row['Beeo_code'];
$tRows[$i]['Depcode']=$row['Depcode'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Desig']=$row['Desig'];
$tRows[$i]['Homeconst']=$row['Homeconst'];
$tRows[$i]['Basic']=$row['Basic'];
$tRows[$i]['Sex']=$row['Sex'];
$tRows[$i]['Age']=$row['Age'];
$tRows[$i]['Placeofresidence']=$row['Placeofresidence'];
$tRows[$i]['Psno_Vsl']=$row['Psno_Vsl'];
$tRows[$i]['Gradepay']=$row['Gradepay'];
$tRows[$i]['Tag']=$row['Tag'];
$tRows[$i]['Depconst']=$row['Depconst'];
$tRows[$i]['Pollcategory']=$row['Pollcategory'];
$tRows[$i]['Cellname']=$row['Cellname'];
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Selected']=$row['Selected'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Gazeted']=$row['Gazeted'];
$tRows[$i]['Phone']=$row['Phone'];
$tRows[$i]['Remarks']=$row['Remarks'];
$tRows[$i]['Deleted']=$row['Deleted'];
$tRows[$i]['Countcategory']=$row['Countcategory'];
$tRows[$i]['Countgrpno']=$row['Countgrpno'];
$tRows[$i]['Countselected']=$row['Countselected'];
$tRows[$i]['Dor']=$row['Dor'];

$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getAllRecord


public function getList($dcode)
{
$tRows=array();
$sql="select Slno,R_lac,Beeo_code,Depcode,Department,Name,Desig,Homeconst,Basic,Sex,Age,Placeofresidence,Psno_Vsl,Gradepay,Tag,Depconst,Pollcategory,Cellname,Grpno,Selected,Rnumber,Gazeted,Phone,Remarks,Deleted,Countcategory,Countgrpno,Countselected,Dor from poling where  depcode=".$dcode." order by name";
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['R_lac']=$row['R_lac'];
$tRows[$i]['Beeo_code']=$row['Beeo_code'];
$tRows[$i]['Depcode']=$row['Depcode'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Desig']=$row['Desig'];
$tRows[$i]['Homeconst']=$row['Homeconst'];
$tRows[$i]['Basic']=$row['Basic'];
$tRows[$i]['Sex']=$row['Sex'];
$tRows[$i]['Age']=$row['Age'];
$tRows[$i]['Placeofresidence']=$row['Placeofresidence'];
$tRows[$i]['Psno_Vsl']=$row['Psno_Vsl'];
$tRows[$i]['Gradepay']=$row['Gradepay'];
$tRows[$i]['Tag']=$row['Tag'];
$tRows[$i]['Depconst']=$row['Depconst'];
$tRows[$i]['Pollcategory']=$row['Pollcategory'];
$tRows[$i]['Cellname']=$row['Cellname'];
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Selected']=$row['Selected'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
$tRows[$i]['Gazeted']=$row['Gazeted'];
$tRows[$i]['Phone']=$row['Phone'];
$tRows[$i]['Remarks']=$row['Remarks'];
$tRows[$i]['Deleted']=$row['Deleted'];
$tRows[$i]['Countcategory']=$row['Countcategory'];
$tRows[$i]['Countgrpno']=$row['Countgrpno'];
$tRows[$i]['Countselected']=$row['Countselected'];
$tRows[$i]['Dor']=$row['Dor'];
$i++;
} //End While
return($tRows);
} //End getList

public function getCountingList($cond)
{
$tRows=array();
$sql="select Slno,Department,Name,Desig,Countcategory,Countgrpno,Phone from Poling  where ".$cond;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Desig']=$row['Desig'];
$tRows[$i]['Countcategory']=$row['Countcategory'];
$tRows[$i]['Countgrpno']=$row['Countgrpno'];
$tRows[$i]['Phone']=$row['Phone'];
$i++;
} //End While
return($tRows);
} //End getMicroList



public function getMicroList($cond)
{
$tRows=array();
$sql="select Slno,Department,Name,Desig,Pollcategory,Grpno,Phone from Poling  where ".$cond;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Desig']=$row['Desig'];
$tRows[$i]['Pollcategory']=$row['Pollcategory'];
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Phone']=$row['Phone'];
$i++;
} //End While
return($tRows);
} //End getMicroList

public function getTopRow()
{
$tRows=array();
$sql="select Slno,Depcode,Pollcategory from poling where ".$this->condString." LIMIT 1";
$i=0;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$tRows['Slno']=$row['Slno'];
$tRows['Depcode']=$row['Depcode'];
$tRows['Pollcategory']=$row['Pollcategory'];
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getList

public function getSelectedRow($tot)
{
$tRows=array();
$sql="select Slno,Depcode,Pollcategory,Department,Name,Desig,Phone,Grpno from poling where ".$this->condString." LIMIT ".$tot;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Slno']=$row['Slno'];
$tRows[$i]['Depcode']=$row['Depcode'];
$tRows[$i]['Pollcategory']=$row['Pollcategory'];
$tRows[$i]['Department']=$row['Department'];
$tRows[$i]['Name']=$row['Name'];
$tRows[$i]['Desig']=$row['Desig'];
$tRows[$i]['Phone']=$row['Phone'];
$tRows[$i]['Grpno']=$row['Grpno'];
$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getList

public function getAllSerial($cond)
{
$tRows=array();
$sql="select Slno from poling where ".$cond;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Slno'];
$i++;
} //End While
return($tRows);
} //End getList

public function getTopSerial($cond,$tot)
{
$tRows=array();
$sql="select Slno from poling where ".$cond." LIMIT ".$tot;
$i=0;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Slno'];
$i++;
} //End While
return($tRows);
} //End getList


function PolingDetail($slno)
{
$this->setSlno($slno);
$objLac=new Lac();
$objS=new Sentence();
if ($this->EditRecord())
{    
$temp="<b>".$this->getName()."</b><br>".$this->getDesig();
$temp=$temp."<br>Poling ID-<b>".$slno."</b>";
$temp=$temp."<br>".$objS->SentenceCase($this->getDepartment());
$objLac->setCode($this->getHomeconst());
if ($objLac->EditRecord())
$temp=$temp."<br>Home LAC-".$objS->SentenceCase ($objLac->getName ());    
$objLac->setCode($this->getR_lac());
if ($objLac->EditRecord())
$temp=$temp."<br>Residential LAC-".$objS->SentenceCase ($objLac->getName ());    
$objLac->setCode($this->getDepconst());
if ($objLac->EditRecord())
$temp=$temp."<br>Working LAC-".$objS->SentenceCase ($objLac->getName ());    
if (strlen($this->getPhone())>=10)
$temp=$temp."<br>Phone-".$this->getPhone();

}
else
$temp="";
return($temp) ;   
}


function PolingDetail4APP($slno,$id)
{
$this->setSlno($slno);
$objBeeo=new Beeo();
$objS=new Sentence();
$objCat=new Category();
$cat="";
if ($this->EditRecord() && $slno>0)
{    
//if($this->getSelected()=="R")    
//{
//$objCat->setCode($this->getPollcategory()) ;   
//$objCat->EditRecord();
//$cat=$objCat->getName();
//} 
//$temp="<u>".$cat."</u><br>";

$temp="";

if ($slno==$id)
$temp=$temp."<b>";


$temp=$temp.$this->getName();

if ($slno==$id)
$temp=$temp."</b>";


$temp=$temp."<br>".$this->getDesig();
$temp=$temp."<br>Address-".$this->getPlaceofresidence();
$temp=$temp."<br>".$objS->SentenceCase($this->getDepartment());
$objBeeo->setCode($this->Beeo_code);
if($this->Beeo_code>0 && $objBeeo->EditRecord())
$temp=$temp."<br>C/o-".$objBeeo->getName ();
$temp=$temp."<br>Poling ID-<b>".$slno."</b>";
if (strlen($this->getPhone())>=10)
$temp=$temp."<br>Phone-".$this->getPhone();
}
else
$temp="";
return($temp) ;   
}


function PolingDetail4APRBook($slno)
{
$this->setSlno($slno);
$objBeeo=new Beeo();
$objS=new Sentence();
$objCat=new Category();
$cat="";
if ($this->EditRecord() && $slno>0)
{    
$objCat->setCode($this->getPollcategory()) ;   
$objCat->EditRecord();
$cat=$objCat->getName();
$cat="";
$temp=$cat."<br><b>";
$temp=$temp.$this->getName();
$temp=$temp."</b><br>".$this->getDesig();
$temp=$temp."<br>".$objS->SentenceCase($this->getDepartment());
$temp=$temp."<br>Poling ID-<b>".$slno."</b>";
if (strlen($this->getPhone())>=10)
$temp=$temp."<br>Phone-".$this->getPhone();
}
else
$temp="";
return($temp) ;   
}


public function getTotTrainee($dcode,$phase)
{
$sql="select count(*) from poling where depcode=".$dcode."  and slno in(select poling_id from poling_training where  phaseno=".$phase.")";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return($row[0]);
else
return(0);
} //End getList

public function getTotPolingSelected($dcode)
{
$sql="select count(*) from poling where depcode=".$dcode."  and pollcategory in(1,2,3,4,5) and grpno>0 and (selected='Y' or selected='R')";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return($row[0]);
else
return(0);
} //End getList

public function getTotMicroSelected($dcode)
{
$sql="select count(*) from poling where depcode=".$dcode."  and pollcategory=7 and grpno>0 and (selected='Y' or selected='R')";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return($row[0]);
else
return(0);
} //End getList


public function isSelected4Trainee($Slno,$phase)
{
$sql="select Groupno from poling_training where   phaseno=".$phase." and poling_id=".$Slno;
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);
} //End getList

public function isPresentinTraining($Slno,$phase)
{
$sql="select count(*) from poling_training where (Attended1='Y' or Attended2='Y' or Attended3='Y') and phaseno=".$phase." and poling_id=".$Slno;
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row[0]>0)
return(true);
else
return(false);    
}

public function isSelectedinGroup($Slno)
{
$sql="select Grpno from poling where Selected='Y' and Grpno>0 and Slno=".$Slno;
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return(true);
else
return(false);
} //isSelectedinGroup


public function RandomisePoling($cond,$tot)
{
//First Step assign rnumber
$sql="Select Slno from Poling where ".$cond." LIMIT ".$tot;
$result=mysql_query($sql);
$i=0;
while ($row=mysql_fetch_array($result))
{ 
$str=rand(1,1000000);
$sql1="update poling set rnumber=".$str." where Slno=".$row['Slno'];
mysql_query($sql1);
$i++;
}
return($i);
}//end Randomise Poling

public function FirstLevelCompleted()
{
$objC=new Category();
$objLac=new Lac();
$stat=false;
if($objC->Randomised(1) && $objC->Randomised(2) && $objC->Randomised(3) && $objC->Randomised(4) )
{
if ($objLac->ForthPoling(0)==0) //Forth Poling Exist in All LAC
$stat=true;
else
{
if($objC->Randomised(5)) 
$stat=true;    
}  //  $this->ForthPoling($Lac)==0
} //$objC->Randomised(1)
return($stat);
}

public function Randomised($cat)
{
$objC=new Category();    
$objC->setCode($cat) ;
if ($objC->EditRecord())
{
if ($objC->getFirstrandom()=="Y" && $objC->getSelected()>0)
return(true);
else
return(false);
} //editrecord
else
return(false); 
} //Randomised

public function countDepcatWise($deptype,$cat)
{
$mcond=" and Depcode in(Select Depcode from department where Dep_type in(";
if($deptype=="G")
$mcond=$mcond."'G',";    
if($deptype=="B")
$mcond=$mcond."'B',";    
//B C G H M O P  Dep Type
if($deptype=="S")
$mcond=$mcond."'C','H','M','P','O',"; 
$mcond=$mcond."'-'))";
if($cat>0)
$sql="Select count(*) from Poling where pollcategory=".$cat.$mcond;

if($cat==0)
$sql="Select count(*) from Poling where pollcategory in(1,2,3,4,5,7)".$mcond;

$result=mysql_query($sql);
$i=0;
$row=mysql_fetch_array($result);

return($row[0]) ;   
    
}

public function countDepcatWiseDetail($deptype)
{
$tmp="";
$cat=array();
$cat[1]="Pr";
$cat[2]="Pl";
$cat[3]="P2";
$cat[4]="P3";
$cat[5]="P4";
$cat[6]="";
$cat[7]="Micro";

for($i=1;$i<8;$i++)
{
if($i!=6)
$tmp=$tmp." ".$cat[$i].":<b>".$this->countDepcatWise ($deptype, $i)."</b>";
}
return($tmp);
}//countdepcatwise

public function countingAvailable()
{

$a=$this->rowCount("Countcategory=1 and countselected='N' and countgrpno=0");
$b=$this->rowCount("Countcategory=2 and countselected='N' and countgrpno=0");
$c=$this->rowCount("Countcategory=3 and countselected='N' and countgrpno=0");

$temp="Super-".$a." Ast-".($b);
if($c>0)
$temp=$temp."  Static Obs-".$c;  

return($temp);
}//countdepcatwise

public function DutyLAC($grpno)
{
$sql="select Lac from polinggroup where Grpno=".$grpno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return($row[0]);
else
return("0");
}//end DutyLAC

public function TrgGroup($grpno)
{
$sql="select Trggroup from polinggroup where Grpno=".$grpno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
return($row[0]);
else
return("0");
}//end DutyLAC

public function BEEO($slno)
{
$sql="select BEEO.name from Poling,BEEO where poling.Beeo_code>0 and poling.Beeo_code=BEEO.code and Poling.slno=".$slno;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return("");
}//end BEEO


}//End Class
?>
