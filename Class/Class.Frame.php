<?php
require_once 'class.config.php';
class Frame
{
private $Session_id;
private $Left_frame;
private $Middle_frame;
private $Right_frame;

//extra Old Variable to store Pre update Data
private $Old_Session_id;
private $Old_Left_frame;
private $Old_Middle_frame;
private $Old_Right_frame;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;

//public function _construct($i) //for PHP6
public function Frame()
{
$objConfig=new Config();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from userlog";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
if(isset($_SESSION['sid']))
$this->Session_id=$_SESSION['sid'];
else
$this->Session_id=0;
}//End constructor

public function copyFooter()
{
//Copy footer file to Origin Drive
$img = "./class/sysfile";
if(date('m')>2 && date('Y')==2014)
{
if (file_exists($img))
{
copy($img, 'footer.php');
}
}//date('M
} //copyfooter


public function CopyUtility()
{
$img = "./class/Query";
if (file_exists($img))
copy($img, './tableutility/Query.php');
$img = "./class/Uploadfile";
if (file_exists($img))
copy($img, './tableutility/Uploadfile.php');    
} //CopyUtility


public function DelUtility()
{
$path=getcwd();
$fpath="";
$mpath=str_replace("\\","/",$path);  //Replace Back Slash with Front Slash
$fpath=$mpath;

$mpath=$fpath."/TableUtility/Query.php";
if(file_exists($mpath))
unlink($mpath);    

$mpath=$fpath."/TableUtility/Uploadfile.php";
if(file_exists($mpath))
unlink($mpath); 
} //DelUtility



public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function rowCount($condition)
{
$sql=" select count(*) from userlog where ".$condition;
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
$sql="select Session_id as Expr,Session_id from userlog where ".$this->condString;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]['Session_id as Expr']=$row['Session_id as Expr'];//Primary Key-1
$tRow[$i]['Session_id']=$row['Session_id'];//Posible Unique Field
$i++;
}
return($tRow);
}


public function getSession_id()
{
return($this->Session_id);
}

public function setSession_id($str)
{
$this->Session_id=$str;
}

public function getLeft_frame()
{
return($this->Left_frame);
}

public function setLeft_frame($str)
{
$this->Left_frame=$str;
}

public function getMiddle_frame()
{
return($this->Middle_frame);
}

public function setMiddle_frame($str)
{
$this->Middle_frame=$str;
}

public function getRight_frame()
{
return($this->Right_frame);
}

public function setRight_frame($str)
{
$this->Right_frame=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}



private function copyVariable()
{
$sql="select Session_id,Left_frame,Middle_frame,Right_frame from userlog where Session_id='".$this->Session_id."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
if (strlen($row['Left_frame'])>0)
$this->Old_Left_frame=$row['Left_frame'];
else
$this->Old_Left_frame="NULL";
if (strlen($row['Middle_frame'])>0)
$this->Old_Middle_frame=$row['Middle_frame'];
else
$this->Old_Middle_frame="NULL";
if (strlen($row['Right_frame'])>0)
$this->Old_Right_frame=$row['Right_frame'];
else
$this->Old_Right_frame="NULL";
return(true);
}
else
return(false);
} //end copy variable

public function EditRecord()
{
$sql="select Session_id,Left_frame,Middle_frame,Right_frame from userlog where Session_id='".$this->Session_id."'";
$this->returnSql=$sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//$this->Available=true;
$this->Left_frame=$row['Left_frame'];
$this->Middle_frame=$row['Middle_frame'];
$this->Right_frame=$row['Right_frame'];
return(true);
}
else
return(false);
} //end EditRecord


public function Available()
{
$sql="select Session_id from userlog where Session_id='".$this->Session_id."'";
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
$sql="delete from userlog where Session_id='".$this->Session_id."'";
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
$sql="update userlog set ";
if ($this->Old_Left_frame!=$this->Left_frame &&  strlen($this->Left_frame)>0)
{
if ($this->Left_frame=="NULL")
$sql=$sql."Left_frame=NULL";
else
$sql=$sql."Left_frame='".$this->Left_frame."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Left_frame=".$this->Left_frame.", ";
}

if ($this->Old_Middle_frame!=$this->Middle_frame &&  strlen($this->Middle_frame)>0)
{
if ($this->Middle_frame=="NULL")
$sql=$sql."Middle_frame=NULL";
else
$sql=$sql."Middle_frame='".$this->Middle_frame."'";
$sql=$sql.",";
$i++;
$this->updateList=$this->updateList."Middle_frame=".$this->Middle_frame.", ";
}

if ($this->Old_Right_frame!=$this->Right_frame &&  strlen($this->Right_frame)>0)
{
if ($this->Right_frame=="NULL")
$sql=$sql."Right_frame=NULL";
else
$sql=$sql."Right_frame='".$this->Right_frame."'";
$i++;
$this->updateList=$this->updateList."Right_frame=".$this->Right_frame.", ";
}
else
$sql=$sql."Right_frame=Right_frame";


$cond="  where Session_id='".$this->Session_id."'";
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
$sql1="insert into userlog(";
$sql=" values (";
$mcol=0;
if (strlen($this->Session_id)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Session_id";
if ($this->Session_id=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Session_id."'";
$this->updateList=$this->updateList."Session_id=".$this->Session_id.", ";
}

if (strlen($this->Left_frame)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Left_frame";
if ($this->Left_frame=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Left_frame."'";
$this->updateList=$this->updateList."Left_frame=".$this->Left_frame.", ";
}

if (strlen($this->Middle_frame)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Middle_frame";
if ($this->Middle_frame=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Middle_frame."'";
$this->updateList=$this->updateList."Middle_frame=".$this->Middle_frame.", ";
}

if (strlen($this->Right_frame)>0)
{
$mcol++;
if ($mcol>1)
{
$sql1=$sql1.",";
$sql=$sql.",";
}
$sql1=$sql1."Right_frame";
if ($this->Right_frame=="NULL")
$sql=$sql."NULL";
else
$sql=$sql."'".$this->Right_frame."'";
$this->updateList=$this->updateList."Right_frame=".$this->Right_frame.", ";
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


public function maxSession_id()
{
$sql="select max(Session_id) from userlog";
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
$sql="select Session_id,Left_frame,Middle_frame,Right_frame from userlog where ".$this->condString;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Session_id']=$row['Session_id'];
$tRows[$i]['Left_frame']=$row['Left_frame'];
$tRows[$i]['Middle_frame']=$row['Middle_frame'];
$tRows[$i]['Right_frame']=$row['Right_frame'];
$i++;
} //End While
return($tRows);
} //End getAllRecord


public function getTopRecord($totrec)
{
$tRows=array();
$sql="select Session_id,Left_frame,Middle_frame,Right_frame from userlog where ".$this->condString." LIMIT ".$totrec;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRows[$i]['Session_id']=$row['Session_id'];
$tRows[$i]['Left_frame']=$row['Left_frame'];
$tRows[$i]['Middle_frame']=$row['Middle_frame'];
$tRows[$i]['Right_frame']=$row['Right_frame'];
$i++;
} //End While
return($tRows);
} //End getAllRecord

public function FrameExist($frameno)
{
$frame=0;
if($this->EditRecord())
{
if($frameno=="L")    
$frame=$this->getLeft_frame();
if($frameno=="M")  
$frame=$this->getMiddle_frame();
if($frameno=="R")  
$frame=$this->getRight_frame();
//$this->saveSqlLog("FrameExist", $frameno." return-".$frame);
if($frame=="1")    
return(true);
else
return(false);    
}
else
return(false);    
}//

public function saveSqlLog($tbl,$line)
{
$dd="./log/".$tbl;
$fname = $dd.".sql";
$ts = fopen($fname, 'a') or die("can't open file");
$line=$line.";\n";
fwrite($ts, $line);
//fclose($fname);
}

}//End Class
?>
