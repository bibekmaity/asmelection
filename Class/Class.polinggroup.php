<?php
require_once 'class.config.php';
class Polinggroup
{
private $Grpno;
private $Lac;
private $Rnumber;
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

public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;

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
public function Polinggroup()
{
$objConfig=new Config();//Connects database
$Available=false;
$rowCommitted=0;
$sql=" select count(*) from polinggroup";
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
$sql=" select count(*) from polinggroup where ".$condition;
//echo $sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //rowCount


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

public function getRnumber()
{
return($this->Rnumber);
}

public function setRnumber($str)
{
$this->Rnumber=$str;
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


public function EditRecord()
{
$sql="select Grpno,Lac,Rnumber,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,Rcode,Reserve,Advance,Trggroup from polinggroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
$this->Available=true;
$this->Lac=$row['Lac'];
$this->Rnumber=$row['Rnumber'];
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
$this->Rcode=$row['Rcode'];
$this->Reserve=$row['Reserve'];
$this->Advance=$row['Advance'];
$this->Trggroup=$row['Trggroup'];
}
else
$this->Available=false;
$this->returnSql=$sql;
return($this->Available);
} //end editrecord


public function DeleteRecord()
{
$sql="delete from polinggroup where Grpno='".$this->Grpno."'";
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
$this->returnSql=$sql;
} //end deleterecord


public function UpdateRecord()
{
$sql="update polinggroup set ";
if (strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."Lac=NULL";
else
$sql=$sql."Lac='".$this->Lac."'";
$sql=$sql.",";
}

if (strlen($this->Rnumber)>0)
{
if ($this->Rnumber=="NULL")
$sql=$sql."Rnumber=NULL";
else
$sql=$sql."Rnumber='".$this->Rnumber."'";
$sql=$sql.",";
}

if (strlen($this->Large)>0)
{
if ($this->Large=="NULL")
$sql=$sql."Large=NULL";
else
$sql=$sql."Large='".$this->Large."'";
$sql=$sql.",";
}

if (strlen($this->Prno)>0)
{
if ($this->Prno=="NULL")
$sql=$sql."Prno=NULL";
else
$sql=$sql."Prno='".$this->Prno."'";
$sql=$sql.",";
}

if (strlen($this->Po1no)>0)
{
if ($this->Po1no=="NULL")
$sql=$sql."Po1no=NULL";
else
$sql=$sql."Po1no='".$this->Po1no."'";
$sql=$sql.",";
}

if (strlen($this->Po2no)>0)
{
if ($this->Po2no=="NULL")
$sql=$sql."Po2no=NULL";
else
$sql=$sql."Po2no='".$this->Po2no."'";
$sql=$sql.",";
}

if (strlen($this->Po3no)>0)
{
if ($this->Po3no=="NULL")
$sql=$sql."Po3no=NULL";
else
$sql=$sql."Po3no='".$this->Po3no."'";
$sql=$sql.",";
}

if (strlen($this->Po4no)>0)
{
if ($this->Po4no=="NULL")
$sql=$sql."Po4no=NULL";
else
$sql=$sql."Po4no='".$this->Po4no."'";
$sql=$sql.",";
}

if (strlen($this->Dcode)>0)
{
if ($this->Dcode=="NULL")
$sql=$sql."Dcode=NULL";
else
$sql=$sql."Dcode='".$this->Dcode."'";
$sql=$sql.",";
}

if (strlen($this->Dcode1)>0)
{
if ($this->Dcode1=="NULL")
$sql=$sql."Dcode1=NULL";
else
$sql=$sql."Dcode1='".$this->Dcode1."'";
$sql=$sql.",";
}

if (strlen($this->Dcode2)>0)
{
if ($this->Dcode2=="NULL")
$sql=$sql."Dcode2=NULL";
else
$sql=$sql."Dcode2='".$this->Dcode2."'";
$sql=$sql.",";
}

if (strlen($this->Dcode3)>0)
{
if ($this->Dcode3=="NULL")
$sql=$sql."Dcode3=NULL";
else
$sql=$sql."Dcode3='".$this->Dcode3."'";
$sql=$sql.",";
}

if (strlen($this->Dcode4)>0)
{
if ($this->Dcode4=="NULL")
$sql=$sql."Dcode4=NULL";
else
$sql=$sql."Dcode4='".$this->Dcode4."'";
$sql=$sql.",";
}

if (strlen($this->Rcode)>0)
{
if ($this->Rcode=="NULL")
$sql=$sql."Rcode=NULL";
else
$sql=$sql."Rcode='".$this->Rcode."'";
$sql=$sql.",";
}

if (strlen($this->Reserve)>0)
{
if ($this->Reserve=="NULL")
$sql=$sql."Reserve=NULL";
else
$sql=$sql."Reserve='".$this->Reserve."'";
$sql=$sql.",";
}

if (strlen($this->Advance)>0)
{
if ($this->Advance=="NULL")
$sql=$sql."Advance=NULL";
else
$sql=$sql."Advance='".$this->Advance."'";
$sql=$sql.",";
}

if (strlen($this->Trggroup)>0)
{
if ($this->Trggroup=="NULL")
$sql=$sql."Trggroup=NULL";
else
$sql=$sql."Trggroup='".$this->Trggroup."'";
}
else
$sql=$sql."Trggroup=Trggroup";

$cond="  where Grpno='".$this->Grpno."'";
$this->returnSql=$sql.$cond;
$this->rowCommitted= mysql_affected_rows();
if (mysql_query($sql.$cond))
return(true);
else
return(false);
}//End Update Record

public function SaveRecord()
{
$sql1="insert into polinggroup(";
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

if (strlen($this->Large)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Large";
if ($this->Large==0)
$sql=$sql."0";
else
$sql=$sql."1";
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
$this->returnSql=$sqlstring;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sqlstring))
return(true);
else
return(false);
}//End Save Record


public function SaveRecord_old()
{
$sql="insert into polinggroup(Grpno,Lac,Rnumber,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,Rcode,Reserve,Advance,Trggroup) values(";
if (strlen($this->Grpno)>0)
{
if ($this->Grpno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Grpno."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Lac)>0)
{
if ($this->Lac=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Lac."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Rnumber)>0)
{
if ($this->Rnumber=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rnumber."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Large)>0)
{
if ($this->Large=="NULL")
$sql=$sql."NULL";
else
$sql=$sql.$this->Large;
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Prno)>0)
{
if ($this->Prno=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Prno."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Po1no)>0)
{
if ($this->Po1no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po1no."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Po2no)>0)
{
if ($this->Po2no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po2no."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Po3no)>0)
{
if ($this->Po3no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po3no."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Po4no)>0)
{
if ($this->Po4no=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Po4no."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Dcode)>0)
{
if ($this->Dcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Dcode1)>0)
{
if ($this->Dcode1=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode1."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Dcode2)>0)
{
if ($this->Dcode2=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode2."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Dcode3)>0)
{
if ($this->Dcode3=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode3."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Dcode4)>0)
{
if ($this->Dcode4=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Dcode4."'";
}
else
$sql=$sql."'0'";

$sql=$sql.",";

if (strlen($this->Rcode)>0)
{
if ($this->Rcode=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Rcode."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Reserve)>0)
{
if ($this->Reserve=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Reserve."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Advance)>0)
{
if ($this->Advance=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Advance."'";
}
else
$sql=$sql."NULL";

$sql=$sql.",";

if (strlen($this->Trggroup)>0)
{
if ($this->Trggroup=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Trggroup."'";
}
else
$sql=$sql."'0'";


$sql=$sql.")";
$this->returnSql=$sql;
$this->rowCommitted= mysql_affected_rows();

if (mysql_query($sql))
return(true);
else
return(false);
}//End Save Record

public function maxGrpno()
{
$sql="select max(Grpno) from polinggroup";
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
$sql="select Grpno,Lac,Rnumber,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,Rcode,Reserve,Advance,Trggroup from polinggroup where ".$this->condString;
$i=0;
$this->returnSql=$sql;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Grpno']=$row['Grpno'];
$tRows[$i]['Lac']=$row['Lac'];
$tRows[$i]['Rnumber']=$row['Rnumber'];
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
$tRows[$i]['Rcode']=$row['Rcode'];
$tRows[$i]['Reserve']=$row['Reserve'];
$tRows[$i]['Advance']=$row['Advance'];
$tRows[$i]['Trggroup']=$row['Trggroup'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

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


public function getGroup($lac,$from,$to)
{
$temp="";
   
$sql="select Grpno from polinggroup where Lac=".$lac." limit ".($to);
$i=0;
$j=0;
$Skip=$from-1;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
if($j==$Skip)
$temp=$temp.$row['Grpno'].",";
else
$j++;    
} //End While
$temp=$temp."-1";
return($temp);
} //End getAllRecord


public function PresentCategory($lac)
{
$i=0;   
//$sql="select Grpno,Lac,Rnumber,Large,Prno,Po1no,Po2no,Po3no,Po4no,Dcode,Dcode1,Dcode2,Dcode3,Dcode4,B0,B1,B2,B3,B4,Rcode,Reserve,Advance,Trggroup from polinggroup where Grpno='".$this->Grpno."'";
$sql="select Po4no from polinggroup where large=true and lac=".$lac." order by grpno desc limit 1";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if ($row['Po4no']==0) 
$i=5;
else
$i=0;
}

$sql="select Prno,Po1no,Po2no,Po3no from polinggroup where  lac=".$lac." order by grpno desc limit 1";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if ($row['Po3no']==0) 
$i=4;
if ($row['Po2no']==0) 
$i=3;
if ($row['Po1no']==0) 
$i=2;
if ($row['Prno']==0) 
$i=1;
}
return($i);
}

public function mySelection($cat,$lac)
{
$condition=array();
$st="<font face=Arial size=2 color=blue>";
$condition[1]=" Prno>0 and lac=".$lac;
$condition[2]=" Po1no>0 and lac=".$lac;
$condition[3]=" Po2no>0 and lac=".$lac;
$condition[4]=" Po3no>0 and lac=".$lac;
$condition[5]=" Po4no>0 and lac=".$lac;
$tg=$this->rowCount($condition[$cat]);
$st=$st.$tg;

$condition[1]=" lac=".$lac;
$condition[2]=" lac=".$lac;
$condition[3]=" lac=".$lac;
$condition[4]=" lac=".$lac;
$condition[5]=" large=true and lac=".$lac;

$st=$st."<font face=Arial size=1 color=black> out of <font face=Arial size=2 color=red>";
$tg=$this->rowCount($condition[$cat]);
$st=$st.$tg;
if ($tg>0)
return($st);
else 
return("");   
}

public function Picked($cat)
{
$sql="select count(*) from poling where deleted='N' and pollcategory=".$cat." and selected='Y' and grpno>0";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
return($row[0]);
}

public function RemainUnselected($cat)
{
$sql="select count(*) from poling where deleted='N' and pollcategory=".$cat." and selected='Y' and grpno=0";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
return($row[0]);
}

public function PsCount($lac)
{
$sql="select count(*) from psname where Lac=".$lac;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
return($row[0]);
}


public function RandomiseGroup($lac,$cond,$pscond)
{
//First Step assign rnumber
$mArr=array();
$i=0;

$sql="Select Grpno,Rcode from Polinggroup where ".$cond;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{ 
$str=rand(100,100000);
$sql="update PolingGroup set rnumber=".$str." where Grpno=".$row['Grpno'];
mysql_query($sql);
//$i++;
//echo $objPs->returnSql;
}

//Load Psnumber in array;
$sql="Select Psno from Psname where ".$pscond." order by Psno";
$result=mysql_query($sql);
$i=0;
while ($row=mysql_fetch_array($result))
{ 
$mArr[$i]=$row[0];
$i++;
}
$pscount=$i;

//First Clear All RCODE from psname Table
$sql="update psname set rcode='0000' where ".$pscond;
mysql_query($sql);
//Second step assign 4 digit RCODE from Polinggroup to PSNAME table
$sql="Select Grpno,Rcode  from Polinggroup where ".$cond." order by rnumber limit ".$pscount;
$result=mysql_query($sql);
$j=0;
while ($mrow=mysql_fetch_array($result))
{ 
$sql="update psname set rcode='".$mrow['Rcode']."' where Lac=".$lac." and Psno=".$mArr[$j];
mysql_query($sql);
$j++;
//echo $objPs->returnSql;
}
}//RandomisePS
//
//update 4 digit RCODE number in PSname table

public function minRcode($lac,$tag)
{
if($tag==-1)
$sql="select min(Rcode) from polinggroup where lac=".$lac;
else
$sql="select min(Rcode) from polinggroup where lac=".$lac." and Advance=".$tag;
    
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(1);
}

public function maxRcode($lac,$tag)
{
if($tag==-1)
$sql="select max(Rcode) from polinggroup where lac=".$lac;
else
$sql="select max(Rcode) from polinggroup where lac=".$lac." and Advance=".$tag;
  $result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(1);
}
}//End Class
?>
