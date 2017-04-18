<?php
require_once 'class.config.php';
class Repolgroup
{
private $Grpno;
private $Lac;
private $Large;
private $Prno;
private $Po1no;
private $Po2no;
private $Po3no;
private $Po4no;
private $Dcode;
private $Dcode1;
private $Dcode2;
private $Dcode3;
private $Dcode4;
private $B0;
private $B1;
private $B2;
private $B3;
private $B4;
private $Rcode;
private $Reserve;
private $Advance;
private $Trggroup;

//extra Old Variable to store Pre update Data
private $Old_Grpno;
private $Old_Lac;
private $Old_Large;
private $Old_Prno;
private $Old_Po1no;
private $Old_Po2no;
private $Old_Po3no;
private $Old_Po4no;
private $Old_Dcode;
private $Old_Dcode1;
private $Old_Dcode2;
private $Old_Dcode3;
private $Old_Dcode4;
private $Old_B0;
private $Old_B1;
private $Old_B2;
private $Old_B3;
private $Old_B4;
private $Old_Rcode;
private $Old_Reserve;
private $Old_Advance;
private $Old_Trggroup;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

private $Def_Prno="0";
private $Def_Po1no="0";
private $Def_Po2no="0";
private $Def_Po3no="0";
private $Def_Po4no="0";
private $Def_Dcode="0";
private $Def_Dcode1="0";
private $Def_Dcode2="0";
private $Def_Dcode3="0";
private $Def_Dcode4="0";
private $Def_B0="0";
private $Def_B1="0";
private $Def_B2="0";
private $Def_B3="0";
private $Def_B4="0";
private $Def_Trggroup="0";
//public function _construct($i) //for PHP6
public function Repolgroup()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from repolgroup";
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
$sql=" select count(*) from repolgroup where ".$condition;
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
$sql="select Grpno,Large from repolgroup where ".$this->condString;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Grpno']=$row['Grpno'];//Primary Key-1
$tRow[$i]['Large']=$row['Large'];//Posible Unique Field
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

public function getLarge()
{
return($this->Large);
}

public function setLarge($str)
{
$this->Large=$str;
}

public function getPrno()
{
return($this->Prno);
}

public function setPrno($str)
{
$this->Prno=$str;
}

public function getPo1no()
{
return($this->Po1no);
}

public function setPo1no($str)
{
$this->Po1no=$str;
}

public function getPo2no()
{
return($this->Po2no);
}

public function setPo2no($str)
{
$this->Po2no=$str;
}

public function getPo3no()
{
return($this->Po3no);
}

public function setPo3no($str)
{
$this->Po3no=$str;
}

public function getPo4no()
{
return($this->Po4no);
}

public function setPo4no($str)
{
$this->Po4no=$str;
}

public function getDcode()
{
return($this->Dcode);
}

public function setDcode($str)
{
$this->Dcode=$str;
}

public function getDcode1()
{
return($this->Dcode1);
}

public function setDcode1($str)
{
$this->Dcode1=$str;
}

public function getDcode2()
{
return($this->Dcode2);
}

public function setDcode2($str)
{
$this->Dcode2=$str;
}

public function getDcode3()
{
return($this->Dcode3);
}

public function setDcode3($str)
{
$this->Dcode3=$str;
}

public function getDcode4()
{
return($this->Dcode4);
}

public function setDcode4($str)
{
$this->Dcode4=$str;
}

public function getB0()
{
return($this->B0);
}

public function setB0($str)
{
$this->B0=$str;
}

public function getB1()
{
return($this->B1);
}

public function setB1($str)
{
$this->B1=$str;
}

public function getB2()
{
return($this->B2);
}

public function setB2($str)
{
$this->B2=$str;
}

public function getB3()
{
return($this->B3);
}

public function setB3($str)
{
$this->B3=$str;
}

public function getB4()
{
return($this->B4);
}

public function setB4($str)
{
$this->B4=$str;
}

public function getRcode()
{
return($this->Rcode);
}

public function setRcode($str)
{
$this->Rcode=$str;
}

public function getReserve()
{
return($this->Reserve);
}

public function setReserve($str)
{
$this->Reserve=$str;
}

public function getAdvance()
{
return($this->Advance);
}

public function setAdvance($str)
{
$this->Advance=$str;
}

public function getTrggroup()
{
return($this->Trggroup);
}

public function setTrggroup($str)
{
$this->Trggroup=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Grpno,Lac,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,B0,B1,B2,B3,B4,Rcode,Reserve,Advance,Trggroup from repolgroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Lac'])>0)
$this->Old_Lac=$row['Lac'];
else
$this->Old_Lac="NULL";
if (strlen($row['Large'])>0)
$this->Old_Large=$row['Large'];
else
$this->Old_Large="NULL";
if (strlen($row['Prno'])>0)
$this->Old_Prno=$row['Prno'];
else
$this->Old_Prno="NULL";
if (strlen($row['Po1no'])>0)
$this->Old_Po1no=$row['Po1no'];
else
$this->Old_Po1no="NULL";
if (strlen($row['Po2no'])>0)
$this->Old_Po2no=$row['Po2no'];
else
$this->Old_Po2no="NULL";
if (strlen($row['Po3no'])>0)
$this->Old_Po3no=$row['Po3no'];
else
$this->Old_Po3no="NULL";
if (strlen($row['Po4no'])>0)
$this->Old_Po4no=$row['Po4no'];
else
$this->Old_Po4no="NULL";
if (strlen($row['Dcode'])>0)
$this->Old_Dcode=$row['Dcode'];
else
$this->Old_Dcode="NULL";
if (strlen($row['Dcode1'])>0)
$this->Old_Dcode1=$row['Dcode1'];
else
$this->Old_Dcode1="NULL";
if (strlen($row['Dcode2'])>0)
$this->Old_Dcode2=$row['Dcode2'];
else
$this->Old_Dcode2="NULL";
if (strlen($row['Dcode3'])>0)
$this->Old_Dcode3=$row['Dcode3'];
else
$this->Old_Dcode3="NULL";
if (strlen($row['Dcode4'])>0)
$this->Old_Dcode4=$row['Dcode4'];
else
$this->Old_Dcode4="NULL";
if (strlen($row['B0'])>0)
$this->Old_B0=$row['B0'];
else
$this->Old_B0="NULL";
if (strlen($row['B1'])>0)
$this->Old_B1=$row['B1'];
else
$this->Old_B1="NULL";
if (strlen($row['B2'])>0)
$this->Old_B2=$row['B2'];
else
$this->Old_B2="NULL";
if (strlen($row['B3'])>0)
$this->Old_B3=$row['B3'];
else
$this->Old_B3="NULL";
if (strlen($row['B4'])>0)
$this->Old_B4=$row['B4'];
else
$this->Old_B4="NULL";
if (strlen($row['Rcode'])>0)
$this->Old_Rcode=$row['Rcode'];
else
$this->Old_Rcode="NULL";
if (strlen($row['Reserve'])>0)
$this->Old_Reserve=$row['Reserve'];
else
$this->Old_Reserve="NULL";
if (strlen($row['Advance'])>0)
$this->Old_Advance=$row['Advance'];
else
$this->Old_Advance="NULL";
if (strlen($row['Trggroup'])>0)
$this->Old_Trggroup=$row['Trggroup'];
else
$this->Old_Trggroup="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Grpno,Lac,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,B0,B1,B2,B3,B4,Rcode,Reserve,Advance,Trggroup from repolgroup where Grpno='".$this->Grpno."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Lac=$row['Lac'];
$this->Large=$row['Large'];
$this->Prno=$row['Prno'];
$this->Po1no=$row['Po1no'];
$this->Po2no=$row['Po2no'];
$this->Po3no=$row['Po3no'];
$this->Po4no=$row['Po4no'];
$this->Dcode=$row['Dcode'];
$this->Dcode1=$row['Dcode1'];
$this->Dcode2=$row['Dcode2'];
$this->Dcode3=$row['Dcode3'];
$this->Dcode4=$row['Dcode4'];
$this->B0=$row['B0'];
$this->B1=$row['B1'];
$this->B2=$row['B2'];
$this->B3=$row['B3'];
$this->B4=$row['B4'];
$this->Rcode=$row['Rcode'];
$this->Reserve=$row['Reserve'];
$this->Advance=$row['Advance'];
$this->Trggroup=$row['Trggroup'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Grpno from repolgroup where Grpno='".$this->Grpno."'";
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
$sql="delete from repolgroup where Grpno='".$this->Grpno."'";
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
$sql="update repolgroup set ";
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

if ($this->Old_Large!=$this->Large &&  strlen($this->Large)>0)
{
if ($this->Large=="NULL")
$sql=$sql."Large=NULL";
else
$sql=$sql."Large='".$this->Large."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Large=".$this->Large.", ";
}

if ($this->Old_Prno!=$this->Prno &&  strlen($this->Prno)>0)
{
if ($this->Prno=="NULL")
$sql=$sql."Prno=NULL";
else
$sql=$sql."Prno='".$this->Prno."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Prno=".$this->Prno.", ";
}

if ($this->Old_Po1no!=$this->Po1no &&  strlen($this->Po1no)>0)
{
if ($this->Po1no=="NULL")
$sql=$sql."Po1no=NULL";
else
$sql=$sql."Po1no='".$this->Po1no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Po1no=".$this->Po1no.", ";
}

if ($this->Old_Po2no!=$this->Po2no &&  strlen($this->Po2no)>0)
{
if ($this->Po2no=="NULL")
$sql=$sql."Po2no=NULL";
else
$sql=$sql."Po2no='".$this->Po2no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Po2no=".$this->Po2no.", ";
}

if ($this->Old_Po3no!=$this->Po3no &&  strlen($this->Po3no)>0)
{
if ($this->Po3no=="NULL")
$sql=$sql."Po3no=NULL";
else
$sql=$sql."Po3no='".$this->Po3no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Po3no=".$this->Po3no.", ";
}

if ($this->Old_Po4no!=$this->Po4no &&  strlen($this->Po4no)>0)
{
if ($this->Po4no=="NULL")
$sql=$sql."Po4no=NULL";
else
$sql=$sql."Po4no='".$this->Po4no."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Po4no=".$this->Po4no.", ";
}

if ($this->Old_Dcode!=$this->Dcode &&  strlen($this->Dcode)>0)
{
if ($this->Dcode=="NULL")
$sql=$sql."Dcode=NULL";
else
$sql=$sql."Dcode='".$this->Dcode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dcode=".$this->Dcode.", ";
}

if ($this->Old_Dcode1!=$this->Dcode1 &&  strlen($this->Dcode1)>0)
{
if ($this->Dcode1=="NULL")
$sql=$sql."Dcode1=NULL";
else
$sql=$sql."Dcode1='".$this->Dcode1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dcode1=".$this->Dcode1.", ";
}

if ($this->Old_Dcode2!=$this->Dcode2 &&  strlen($this->Dcode2)>0)
{
if ($this->Dcode2=="NULL")
$sql=$sql."Dcode2=NULL";
else
$sql=$sql."Dcode2='".$this->Dcode2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dcode2=".$this->Dcode2.", ";
}

if ($this->Old_Dcode3!=$this->Dcode3 &&  strlen($this->Dcode3)>0)
{
if ($this->Dcode3=="NULL")
$sql=$sql."Dcode3=NULL";
else
$sql=$sql."Dcode3='".$this->Dcode3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dcode3=".$this->Dcode3.", ";
}

if ($this->Old_Dcode4!=$this->Dcode4 &&  strlen($this->Dcode4)>0)
{
if ($this->Dcode4=="NULL")
$sql=$sql."Dcode4=NULL";
else
$sql=$sql."Dcode4='".$this->Dcode4."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Dcode4=".$this->Dcode4.", ";
}

if ($this->Old_B0!=$this->B0 &&  strlen($this->B0)>0)
{
if ($this->B0=="NULL")
$sql=$sql."B0=NULL";
else
$sql=$sql."B0='".$this->B0."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."B0=".$this->B0.", ";
}

if ($this->Old_B1!=$this->B1 &&  strlen($this->B1)>0)
{
if ($this->B1=="NULL")
$sql=$sql."B1=NULL";
else
$sql=$sql."B1='".$this->B1."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."B1=".$this->B1.", ";
}

if ($this->Old_B2!=$this->B2 &&  strlen($this->B2)>0)
{
if ($this->B2=="NULL")
$sql=$sql."B2=NULL";
else
$sql=$sql."B2='".$this->B2."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."B2=".$this->B2.", ";
}

if ($this->Old_B3!=$this->B3 &&  strlen($this->B3)>0)
{
if ($this->B3=="NULL")
$sql=$sql."B3=NULL";
else
$sql=$sql."B3='".$this->B3."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."B3=".$this->B3.", ";
}

if ($this->Old_B4!=$this->B4 &&  strlen($this->B4)>0)
{
if ($this->B4=="NULL")
$sql=$sql."B4=NULL";
else
$sql=$sql."B4='".$this->B4."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."B4=".$this->B4.", ";
}

if ($this->Old_Rcode!=$this->Rcode &&  strlen($this->Rcode)>0)
{
if ($this->Rcode=="NULL")
$sql=$sql."Rcode=NULL";
else
$sql=$sql."Rcode='".$this->Rcode."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Rcode=".$this->Rcode.", ";
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

if ($this->Old_Advance!=$this->Advance &&  strlen($this->Advance)>0)
{
if ($this->Advance=="NULL")
$sql=$sql."Advance=NULL";
else
$sql=$sql."Advance='".$this->Advance."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
}

if ($this->Old_Trggroup!=$this->Trggroup &&  strlen($this->Trggroup)>0)
{
if ($this->Trggroup=="NULL")
$sql=$sql."Trggroup=NULL";
else
$sql=$sql."Trggroup='".$this->Trggroup."'";
$i++;
$this->updateList=$this->updateList."Trggroup=".$this->Trggroup.", ";
}
else
$sql=$sql."Trggroup=Trggroup";


$cond="  where Grpno=".$this->Grpno;
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
$sql="update repolgroup set ";
if ($this->Lac=="NULL")
$sql=$sql."Lac=NULL";
else
$sql=$sql."Lac='".$this->Lac."'";
$sql=$sql.",";

if ($this->Large=="NULL")
$sql=$sql."Large=NULL";
else
$sql=$sql."Large='".$this->Large."'";
$sql=$sql.",";

if ($this->Prno=="NULL")
$sql=$sql."Prno=NULL";
else
$sql=$sql."Prno='".$this->Prno."'";
$sql=$sql.",";

if ($this->Po1no=="NULL")
$sql=$sql."Po1no=NULL";
else
$sql=$sql."Po1no='".$this->Po1no."'";
$sql=$sql.",";

if ($this->Po2no=="NULL")
$sql=$sql."Po2no=NULL";
else
$sql=$sql."Po2no='".$this->Po2no."'";
$sql=$sql.",";

if ($this->Po3no=="NULL")
$sql=$sql."Po3no=NULL";
else
$sql=$sql."Po3no='".$this->Po3no."'";
$sql=$sql.",";

if ($this->Po4no=="NULL")
$sql=$sql."Po4no=NULL";
else
$sql=$sql."Po4no='".$this->Po4no."'";
$sql=$sql.",";

if ($this->Dcode=="NULL")
$sql=$sql."Dcode=NULL";
else
$sql=$sql."Dcode='".$this->Dcode."'";
$sql=$sql.",";

if ($this->Dcode1=="NULL")
$sql=$sql."Dcode1=NULL";
else
$sql=$sql."Dcode1='".$this->Dcode1."'";
$sql=$sql.",";

if ($this->Dcode2=="NULL")
$sql=$sql."Dcode2=NULL";
else
$sql=$sql."Dcode2='".$this->Dcode2."'";
$sql=$sql.",";

if ($this->Dcode3=="NULL")
$sql=$sql."Dcode3=NULL";
else
$sql=$sql."Dcode3='".$this->Dcode3."'";
$sql=$sql.",";

if ($this->Dcode4=="NULL")
$sql=$sql."Dcode4=NULL";
else
$sql=$sql."Dcode4='".$this->Dcode4."'";
$sql=$sql.",";

if ($this->B0=="NULL")
$sql=$sql."B0=NULL";
else
$sql=$sql."B0='".$this->B0."'";
$sql=$sql.",";

if ($this->B1=="NULL")
$sql=$sql."B1=NULL";
else
$sql=$sql."B1='".$this->B1."'";
$sql=$sql.",";

if ($this->B2=="NULL")
$sql=$sql."B2=NULL";
else
$sql=$sql."B2='".$this->B2."'";
$sql=$sql.",";

if ($this->B3=="NULL")
$sql=$sql."B3=NULL";
else
$sql=$sql."B3='".$this->B3."'";
$sql=$sql.",";

if ($this->B4=="NULL")
$sql=$sql."B4=NULL";
else
$sql=$sql."B4='".$this->B4."'";
$sql=$sql.",";

if ($this->Rcode=="NULL")
$sql=$sql."Rcode=NULL";
else
$sql=$sql."Rcode='".$this->Rcode."'";
$sql=$sql.",";

if ($this->Reserve=="NULL")
$sql=$sql."Reserve=NULL";
else
$sql=$sql."Reserve='".$this->Reserve."'";
$sql=$sql.",";

if ($this->Advance=="NULL")
$sql=$sql."Advance=NULL";
else
$sql=$sql."Advance='".$this->Advance."'";
$sql=$sql.",";

if ($this->Trggroup=="NULL")
$sql=$sql."Trggroup=NULL";
else
$sql=$sql."Trggroup='".$this->Trggroup."'";


$cond="  where Grpno=".$this->Grpno;
return($sql.$cond);
}//End genUpdateString


public function SaveRecord()
{
$this->updateList="";
$sql1="insert into repolgroup(";
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

if (strlen($this->Large)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Large";
if ($this->Large=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Large."'";
$this->updateList=$this->updateList."Large=".$this->Large.", ";
}

if (strlen($this->Prno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Prno";
if ($this->Prno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Prno."'";
$this->updateList=$this->updateList."Prno=".$this->Prno.", ";
}

if (strlen($this->Po1no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po1no";
if ($this->Po1no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po1no."'";
$this->updateList=$this->updateList."Po1no=".$this->Po1no.", ";
}

if (strlen($this->Po2no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po2no";
if ($this->Po2no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po2no."'";
$this->updateList=$this->updateList."Po2no=".$this->Po2no.", ";
}

if (strlen($this->Po3no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po3no";
if ($this->Po3no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po3no."'";
$this->updateList=$this->updateList."Po3no=".$this->Po3no.", ";
}

if (strlen($this->Po4no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po4no";
if ($this->Po4no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po4no."'";
$this->updateList=$this->updateList."Po4no=".$this->Po4no.", ";
}

if (strlen($this->Dcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode";
if ($this->Dcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode."'";
$this->updateList=$this->updateList."Dcode=".$this->Dcode.", ";
}

if (strlen($this->Dcode1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode1";
if ($this->Dcode1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode1."'";
$this->updateList=$this->updateList."Dcode1=".$this->Dcode1.", ";
}

if (strlen($this->Dcode2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode2";
if ($this->Dcode2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode2."'";
$this->updateList=$this->updateList."Dcode2=".$this->Dcode2.", ";
}

if (strlen($this->Dcode3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode3";
if ($this->Dcode3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode3."'";
$this->updateList=$this->updateList."Dcode3=".$this->Dcode3.", ";
}

if (strlen($this->Dcode4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode4";
if ($this->Dcode4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode4."'";
$this->updateList=$this->updateList."Dcode4=".$this->Dcode4.", ";
}

if (strlen($this->B0)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B0";
if ($this->B0=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B0."'";
$this->updateList=$this->updateList."B0=".$this->B0.", ";
}

if (strlen($this->B1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B1";
if ($this->B1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B1."'";
$this->updateList=$this->updateList."B1=".$this->B1.", ";
}

if (strlen($this->B2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B2";
if ($this->B2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B2."'";
$this->updateList=$this->updateList."B2=".$this->B2.", ";
}

if (strlen($this->B3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B3";
if ($this->B3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B3."'";
$this->updateList=$this->updateList."B3=".$this->B3.", ";
}

if (strlen($this->B4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B4";
if ($this->B4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B4."'";
$this->updateList=$this->updateList."B4=".$this->B4.", ";
}

if (strlen($this->Rcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rcode";
if ($this->Rcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rcode."'";
$this->updateList=$this->updateList."Rcode=".$this->Rcode.", ";
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

if (strlen($this->Advance)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Advance";
if ($this->Advance=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Advance."'";
$this->updateList=$this->updateList."Advance=".$this->Advance.", ";
}

if (strlen($this->Trggroup)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trggroup";
if ($this->Trggroup=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trggroup."'";
$this->updateList=$this->updateList."Trggroup=".$this->Trggroup.", ";
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
$sql1="insert into repolgroup(";
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
}

if (strlen($this->Large)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Large";
if ($this->Large=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Large."'";
}

if (strlen($this->Prno)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Prno";
if ($this->Prno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Prno."'";
}

if (strlen($this->Po1no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po1no";
if ($this->Po1no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po1no."'";
}

if (strlen($this->Po2no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po2no";
if ($this->Po2no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po2no."'";
}

if (strlen($this->Po3no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po3no";
if ($this->Po3no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po3no."'";
}

if (strlen($this->Po4no)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Po4no";
if ($this->Po4no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po4no."'";
}

if (strlen($this->Dcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode";
if ($this->Dcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode."'";
}

if (strlen($this->Dcode1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode1";
if ($this->Dcode1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode1."'";
}

if (strlen($this->Dcode2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode2";
if ($this->Dcode2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode2."'";
}

if (strlen($this->Dcode3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode3";
if ($this->Dcode3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode3."'";
}

if (strlen($this->Dcode4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Dcode4";
if ($this->Dcode4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode4."'";
}

if (strlen($this->B0)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B0";
if ($this->B0=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B0."'";
}

if (strlen($this->B1)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B1";
if ($this->B1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B1."'";
}

if (strlen($this->B2)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B2";
if ($this->B2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B2."'";
}

if (strlen($this->B3)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B3";
if ($this->B3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B3."'";
}

if (strlen($this->B4)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."B4";
if ($this->B4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->B4."'";
}

if (strlen($this->Rcode)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Rcode";
if ($this->Rcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rcode."'";
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
}

if (strlen($this->Advance)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Advance";
if ($this->Advance=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Advance."'";
}

if (strlen($this->Trggroup)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Trggroup";
if ($this->Trggroup=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trggroup."'";
}

$sql1=$sql1.")";
$sql=$sql.")";
$sqlstring=$sql1.$sql;
return($sqlstring);
}//End genSaveString

public function maxGrpno()
{
$sql="select max(Grpno) from repolgroup";
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
$sql="select Grpno,Lac,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,B0,B1,B2,B3,B4,Rcode,Reserve,Advance,Trggroup from repolgroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Large']=$row['Large'];
$tRows[$i]['Prno']=$row['Prno'];
$tRows[$i]['Po1no']=$row['Po1no'];
$tRows[$i]['Po2no']=$row['Po2no'];
$tRows[$i]['Po3no']=$row['Po3no'];
$tRows[$i]['Po4no']=$row['Po4no'];
$tRows[$i]['Dcode']=$row['Dcode'];
$tRows[$i]['Dcode1']=$row['Dcode1'];
$tRows[$i]['Dcode2']=$row['Dcode2'];
$tRows[$i]['Dcode3']=$row['Dcode3'];
$tRows[$i]['Dcode4']=$row['Dcode4'];
$tRows[$i]['B0']=$row['B0'];
$tRows[$i]['B1']=$row['B1'];
$tRows[$i]['B2']=$row['B2'];
$tRows[$i]['B3']=$row['B3'];
$tRows[$i]['B4']=$row['B4'];
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Advance']=$row['Advance'];
$tRows[$i]['Trggroup']=$row['Trggroup'];
$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Grpno,Lac,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,B0,B1,B2,B3,B4,Rcode,Reserve,Advance,Trggroup from repolgroup where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Large']=$row['Large'];
$tRows[$i]['Prno']=$row['Prno'];
$tRows[$i]['Po1no']=$row['Po1no'];
$tRows[$i]['Po2no']=$row['Po2no'];
$tRows[$i]['Po3no']=$row['Po3no'];
$tRows[$i]['Po4no']=$row['Po4no'];
$tRows[$i]['Dcode']=$row['Dcode'];
$tRows[$i]['Dcode1']=$row['Dcode1'];
$tRows[$i]['Dcode2']=$row['Dcode2'];
$tRows[$i]['Dcode3']=$row['Dcode3'];
$tRows[$i]['Dcode4']=$row['Dcode4'];
$tRows[$i]['B0']=$row['B0'];
$tRows[$i]['B1']=$row['B1'];
$tRows[$i]['B2']=$row['B2'];
$tRows[$i]['B3']=$row['B3'];
$tRows[$i]['B4']=$row['B4'];
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Advance']=$row['Advance'];
$tRows[$i]['Trggroup']=$row['Trggroup'];
$i++;
} //End While
$this->returnSql=$sql;
return($tRows);
} //End getAllRecord

public function Max($fld,$cond)
{
if(strlen($cond)<3)
$cond=true;
$sql="select max(".$fld.") from repolgroup where ".$cond;
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
$sql="select sum(".$fld.") from repolgroup where ".$cond;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
}

public function mySelection($cat)
{
$condition=array();
$st="<font face=Arial size=2 color=blue>";
$condition[1]=" Prno>0 and lac=0";
$condition[2]=" Po1no>0 and lac=0";
$condition[3]=" Po2no>0 and lac=0";
$condition[4]=" Po3no>0 and lac=0";
$condition[5]=" Po4no>0 and lac=0";
$tg=$this->rowCount($condition[$cat]);
$st=$st.$tg;

$condition[1]=" 1=1";
$condition[2]=" 1=1";
$condition[3]=" 1=1";
$condition[4]=" 1=1";
$condition[5]=" 1=1";

$st=$st."<font face=Arial size=1 color=black> out of <font face=Arial size=2 color=red>";
$tg=$this->rowCount($condition[$cat]);
$st=$st.$tg;
if ($tg>0)
return($st);
else 
return("");   
}

public function getmyGrpNo()
{
$tRows=array();
$sql="select Grpno from polinggroup where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]=$row['Grpno'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

}//End Class
?>
