<?php
require_once 'class.PWD.php';
require_once 'class.userlog.php';
require_once 'class.category.php';
require_once 'class.lac.php';
require_once 'class.Frame.php';
class Utility
{
public $conA;    
private $mDays=array();
public $CountCategory=array();
public $LacList=array();
public $CategoryList=array();
public $tempstr;
public function Utility()
{
$this->mDays[1] = 31;
$this->mDays[2] = 28;
$this->mDays[3] = 31;
$this->mDays[4] = 30;
$this->mDays[5] = 31;
$this->mDays[6] = 30;
$this->mDays[7] = 31;
$this->mDays[8] = 31;
$this->mDays[9] = 30;
$this->mDays[10] = 31;
$this->mDays[11] = 30;
$this->mDays[12] = 31;

$this->CountCategory[1]="Counting Supervisor";
$this->CountCategory[2]="Counting Assistant";
$this->CountCategory[3]="Static Observer";

$objC=new Category();
$objL=new Lac(); 
//Load Category in Array
$row=$objC->getRow();
for($i=0;$i<count($row);$i++)
$this->CategoryList[$row[$i]['Code']]=$row[$i]['Name'];
//Load LAC List in Array
$this->LacList[0]="";
$row=$objL->getRow();
for($i=0;$i<count($row);$i++)
$this->LacList[$row[$i]['Code']]=$row[$i]['Name'];

$this->UserPresent(); //Make Attendance
} //constructor

public function CriticalAllowed()
{
$ok=false;    
if(isset($_SESSION['uid']))
$uid=$_SESSION['uid'];
else 
$uid="-";

if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];  
else
$ip="NA";

$sql="select Allowed_ip from PWD where Uid='".$uid."'";
//echo $sql;
//echo "<br>clientip=".$ip;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if ($row)
{
//echo "allowed=".$row[0];    
if($ip==$row[0]) 
$ok=true;    
}//$row
return($ok);
}//CriticalAllowed


public function AllFrameExist()
{
$objF=new Frame();

if($objF->EditRecord())
{
if($objF->getLeft_frame()=="1" && $objF->getRight_frame()=="1" && $objF->getMiddle_frame()=="1" )    
return(true);
else
return(false);    
}
else
return(false);    
}//



public function UserPresent()
{
date_default_timezone_set("Asia/kolkata");
if(isset($_SESSION['sid']))
$sid=$_SESSION['sid'];
else 
$sid=0;

if (isset($_SESSION['uid']))
$uid=$_SESSION['uid'];    
else
$uid="-";  

$sql="update userlog set Log_time_out='".date('H:i:s')."' where Session_id=".$sid." and Uid='".$uid."'";
mysql_query($sql);

//echo "Present SID ".$sid."<br>";
}//User present


public function VerifyRoll()
{
//Use your Business Logic  to Verify Every page(Use/Password,Ip etc))
$t=-1;
if (!isset($_SESSION['roll']))
$_SESSION['roll']=100;

if (!isset($_SESSION['uid']))
$_SESSION['uid']="-";

if (!isset($_SESSION['pwd']))
$_SESSION['pwd']="-";

$objUl=new Userlog();
$objPwd=new Pwd();
$objPwd->setUid($_SESSION['uid']);
//echo $this->alert("Active-".$objUl->isActive($_SESSION['uid']));
//echo $this->alert("Frame-".$this->AllFrameExist());
if ($objPwd->EditRecord()  && $objUl->isActive($_SESSION['uid']) && $this->AllFrameExist())
{
if ($objPwd->getPwd()==trim($_SESSION['pwd']))    
$t=$objPwd->getRoll();
$this->UserPresent();
}    
$this->tempstr=$objUl->returnSql; 
return($t);
}



public function isdate($mdate)
{
$t=true;
$dtarray=explode("/",$mdate);
if (count($dtarray)==3)
{
if (substr($dtarray[1],0,1)=="0")
$dtarray[1]=substr($dtarray[1],-1);
if (($dtarray[2]%4)==0)
$this->mDays[2] = 29;
if(is_numeric($dtarray[2]) && is_numeric($dtarray[1]) && is_numeric($dtarray[0]))
$t=true;
else
$t=false;
if (($dtarray[1]<1) || ($dtarray[1]>12))
$t=false;
if (($dtarray[0]<1)  || ($dtarray[0]>31))
$t=false;
if ($dtarray[1]>0 && $dtarray[1]<13 )
{
if ($dtarray[0]>$this->mDays[$dtarray[1]])
$t=false;
}
}
else
$t=false;
return($t);
}

public function to_mysqldate($mydate)
{
$row=array();
$row=explode("/",$mydate);

if (isset($row[2]))
$yy1=$row[2];
else
$yy1=0;

if (isset($row[1]))
$mm1=round($row[1]);
else
$mm1=0;

if (isset($row[0]))
$dd1=round($row[0]);
else
$dd1=0;

//if($mm1<10)
//$mm1=substr(($mm1+100),1,2);    

//if($dd1<10)
//$mm1=substr(($dd1+100),1,2); 
if ($yy1>0 && $mm1>0 && $dd1>0)
$dt=$yy1."-".$mm1."-".$dd1;
else 
$dt="";    
return($dt);
}

public function Month($i)
{
$tt="";
switch($i)
{
case 1:$tt="January";
       break;
case 2:$tt="February";
       break;
case 3:$tt="March";
       break;
case 4:$tt="April";
       break;
case 5:$tt="May";
       break;
case 6:$tt="June";
       break;
case 7:$tt="July";
       break;
case 8:$tt="August";
       break;
case 9:$tt="September";
       break;
case 10:$tt="October";
       break;
case 11:$tt="November";
       break;
case 12:$tt="December";
       break;
}
 return($tt);   
}

public function to_date($mydate)
{
$row=array();
$ln=strlen($mydate);
if($ln>10)
$mydate=substr($mydate,0,10);    

$row=explode("-",$mydate);

if (isset($row[0]))
$yy1=$row[0];
else
$yy1=0;

if (isset($row[1]))
$mm1=round($row[1]);
else
$mm1=0;

if (isset($row[2]))
$dd1=round($row[2]);
else
$dd1=0;

//if($mm1<10)
//$mm1=substr(($mm1+100),1,2);    

//if($dd1<10)
//$mm1=substr(($dd1+100),1,2); 
if ($yy1>0 && $mm1>0 && $dd1>0)
$dt=$dd1."/".$mm1."/".$yy1;
else
$dt="";
return($dt);
}

public function isUnicodeCharExist($mystring)
{
$t=false;
if (strlen($mystring) != strlen(utf8_decode($mystring)))
$t=true;
else
$t=false;
return($t);
}


function inStr($str,$find)
{
$temp=strlen($find);
$mindex=0;
$found=-1;
$lnth=strlen($str)-$temp;
while (($mindex<=$lnth) && ($found==-1))
{
if (substr($str,$mindex,$temp)==$find)
{
$found=$mindex;
}
$mindex++;
} //end while
return($found);
}  //end function


public function isUnicode($mystring)
{
$t=true;
$token=array();
$j=0;
$start=0;
$mystring=$mystring." ";
for($i=0;$i<strlen($mystring);$i++)
{
if (substr($mystring,$i,1)==" ")
{
$length=$i-$start;
$token[$j]=substr($mystring,$start,$length);
$start=$i+1;
if (strlen($token[$j]) !=(3* strlen(utf8_decode($token[$j]))))
$t=false;
$j++;
}
}
return($t);
}

//Java Focus Functionafter postback

public function focus($a)
{
$temp="<Script language=javascript>\n";
$temp=$temp."document.getElementById('".$a."').focus();//set Focus on Rsl\n";
$temp=$temp."</script>";
return($temp);
}

public function alert($a)
{
$temp="";
if (strlen($a)>0)
{    
$temp="<Script language=javascript>\n";
$temp=$temp."alert('".$a."');//Make an alert\n";
$temp=$temp."</script>";
}
return($temp);
}


public function AlertNRedirect($a,$page)
{
$temp="";
$temp="<Script language=javascript>\n";
if (strlen($a)>0)
$temp=$temp."alert('".$a."');//Make an alert\n";
if (strlen($page)>0)
$temp=$temp."document.location.href=".chr(34).$page.chr(34).";//Redirect\n";
$temp=$temp."</script>";
return($temp);
}


public function assign($a,$b)
{
$temp="<Script language=javascript>\n";
$temp=$temp."document.getElementById('".$a."').value=".chr(34).$b.chr(34).";//set b to a\n";
$temp=$temp."</script>";
return($temp);
}


public function SelectedIndex($a,$b)
{
$temp="<Script language=javascript>\n";
$temp=$temp."document.getElementById('".$a."').selectedIndex=".$b.";//set Index\n";
$temp=$temp."</script>";
return($temp);
}

public function statusbar($a)
{
$temp="<Script language=javascript>\n";
$temp=$temp."window.setTimeOut(".chr(34);
$temp=$temp."window.status=".chr(34).$a.chr(34).";\n".chr(34).",2000)";
//sleep(500)

$temp=$temp."</script>";
return($temp);
}


public function validate($str)
{
$found=true;
if (preg_match("/'/",$str))
$found=false;

if (preg_match("/--/",$str))
$found=false;


if (preg_match("/</",$str))
$found=false;


if (preg_match("/>/",$str))
$found=false;

if (preg_match("/;/",$str))
$found=false;

//if (preg_match("/&/",$str))
//$found=false;

$str=strtoupper($str);
if (preg_match("/SELECT/",$str))
$found=false;

if (preg_match("/INSERT/",$str))
$found=false;

if (preg_match("/DELETE/",$str))
$found=false;

if (preg_match("/VBSCRIPT/",$str))
$found=false;

if (preg_match("/JAVASCRIPT/",$str))
$found=false;

return($found);
}

public function SimpleValidate($str)
{
$found=true;
if (preg_match("/'/",$str))
$found=false;

if (preg_match("/--/",$str))
$found=false;

if (preg_match("/;/",$str))
$found=false;

return($found);
}





public function saveSqlLog($tbl,$line)
{
$dd="./log/".date('dmY').$tbl;
$fname = $dd.".sql";
$ts = fopen($fname, 'a') or die("can't open file");
$line=$line.";\n";
fwrite($ts, $line);
//fclose($fname);
//$this->Backup2Access("Election.mdb",$line);
}


public function saveTextLog($tbl,$line)
{
$dd="./log/".date('dmY').$tbl;
$fname = $dd.".txt";
$ts = fopen($fname, 'a') or die("can't open file");
$line=$line."\n";
fwrite($ts, $line);

}


public function elapsedTime($t1,$t2)
{
$row=array();
$h1=substr($t1,0,2) ;
$m1=substr($t1,3,2) ;
$s1=substr($t1,6,2) ;    
 
$h2=substr($t2,0,2) ;
$m2=substr($t2,3,2) ;
$s2=substr($t2,6,2) ;  

if ($s2<=$s1)
$s=$s1-$s2;
else
{
$s1=$s1+60;
$m1=$m1-1;
$s=$s1-$s2;
}

if ($m2<=$m1)
$m=$m1-$m2;
else
{
$m1=$m1+60;
$h1=$h1-1;
$m=$m1-$m2;
}  

if ($h2<=$h1)
$h=$h1-$h2;
else 
$h=0;  
$row['h']=$h;
$row['m']=$m;
$row['s']=$s;
return($row);   
}

//
public function elapsedTimeMsg($t1,$t2)
{
$row=array();
$mrow=$this->elapsedTime($t1, $t2);
$tt=" ";
if ($mrow['h']>0)
$tt= $tt.$mrow['h']." Hours ";
if ($mrow['m']>0)
$tt= $tt.$mrow['m']." Min ";

if ($mrow['s']>0)
$tt= $tt.$mrow['s']." Sec";
//else
//$tt= $tt."Less than 1 Sec";  

$tt= $tt."";

return($tt);
}

public function Clock($t1,$t2)
{
$row=array();
$mrow=$this->elapsedTime($t1, $t2);
$tt=" ";
//if ($mrow['h']>0)
$tt= $tt.substr((100+$mrow['h']),1,2).":";
//if ($mrow['m']>0)
$tt= $tt.substr((100+$mrow['m']),1,2).":";

//if ($mrow['s']>0)
$tt= $tt.substr((100+$mrow['s']),1,2);
//else
//$tt= $tt."Less than 1 Sec";  

$tt= $tt."";

return($tt);
}



public function dateDiff($date1,$date2)
{
$date1=$date1."- " ;
$date2=$date2."- ";
$row=explode("-",$date1);
if (isset($row[0]))
$yy1=$row[0];
else
$yy1=0;

if (isset($row[1]))
$mm1=round($row[1]);
else
$mm1=0;

if (isset($row[2]))
$dd1=round($row[2]);
else
$dd1=0;
//echo $yy1.$mm1.$dd1."<br>";

$row=explode("-",$date2);
if (isset($row[0]))
$yy2=$row[0];
else
$yy2=0;
if (isset($row[1]))
$mm2=round($row[1]);
else 
$mm2=0;    
if (isset($row[2]))
$dd2=round($row[2]);
else
$dd2=0;
//echo $yy2.$mm2.$dd2."<br>";

if($yy2%4==0) //Leap Year
$this->mDays[2]=29;

if($dd1<$dd2)
{
$mtag=round($mm2);
$dd1=$dd1+$this->mDays[$mtag];
$mm1=$mm1-1;
}

if($mm1<$mm2)
{
$mm1=$mm1+12;
$yy1=$yy1-1;
}

$tmp=($dd1-$dd2)+30*($mm1-$mm2)+365*($yy1-$yy2);
return($tmp);
}

public function datePlusMinus($date1,$offset)
{
if($offset<0) 
$date=$this->dateMinus($date1, $offset);
else
$date=$this->datePlus($date1, $offset);    
return($date);
}



public function datePlus($date1,$offset)
{
  
$date1=$date1."- " ;
$date="";

if($offset<0)
$offset=0;

$row=explode("-",$date1);

if (isset($row[0]))
$yy1=$row[0];
else
$yy1=0;

if (isset($row[1]))
$mm1=round($row[1]);
else
$mm1=0;

if (isset($row[2]))
$dd1=round($row[2]);
else
$dd1=0;


if($yy1%4==0) //Leap Year
$this->mDays[2]=29;

$dd1=$dd1+$offset;

if($dd1<=$this->mDays[$mm1] && $dd1>0)
$date=$yy1."-".$mm1."-".$dd1;    
else
{
while ($dd1>$this->mDays[$mm1])
{
$dd1=$dd1-$this->mDays[$mm1];
$mm1=$mm1+1;
if($mm1>12)
{
$mm1=1;
$yy1=$yy1+1;
}    
}
$date=$yy1."-".$mm1."-".$dd1; 
}

return($date);
}


public function dateMinus($date1,$offset)
{
  
$date1=$date1."- " ;
$date="";

if($offset<0)
$offset=0-$offset;

$row=explode("-",$date1);

if (isset($row[0]))
$yy1=$row[0];
else
$yy1=0;

if (isset($row[1]))
$mm1=round($row[1]);
else
$mm1=0;

if (isset($row[2]))
$dd1=round($row[2]);
else
$dd1=0;


if($yy1%4==0) //Leap Year
$this->mDays[2]=29;

//echo "dd1offset".($dd1-$offset)."<br>";

$dd=1;
if($dd1-$offset>0)
$date=$yy1."-".$mm1."-".($dd1-$offset);    //

if($dd1-$offset<=0)
{
$mm1=$mm1-1;
if($mm1==0)
{
$mm1=1;
$yy1=$yy1-1;
}
//echo $mm1."-".$yy1."<br>";
$dd1=$this->mDays[$mm1]-($offset-$dd1);
//echo "<br>dd1=".$dd1."<br>";
if($dd1<=$this->mDays[$mm1] && $dd1>0)
$date=$yy1."-".$mm1."-".$dd1;  
else
$dd=$dd1;
} //$dd1-$offset


if ($dd<=0)
{    
$i=0;
while ($dd<=0)
{
$i++;
$mm1=$mm1-1;
if($mm1==0)
{
$yy1=$yy1-1;
$mm1=12;
}
$dd=$dd+$this->mDays[$mm1];
}//while
$date=$yy1."-".$mm1."-".$dd;
} //if $dd1<0

return($date);
}

function RemoveExtraSpace($str)
{
$newstr="";
$prev=0;
for ($i = 0; $i < strlen($str); $i++)
{
$k=ord(substr($str,$i,1));
if ($k==32 && $prev==0)
{
$newstr=$newstr;
}
else
{
$newstr=$newstr.substr($str,$i,1);
}
if ($k==32)
$prev=0;
else
$prev=1;
}
return($newstr);
}//trimBlank

function RemoveAllSpace($str)
{
$newstr="";
$prev=0;
for ($i = 0; $i < strlen($str); $i++)
{
$k=ord(substr($str,$i,1));
if ($k==32)
{
$newstr=$newstr;
}
else
{
$newstr=$newstr.substr($str,$i,1);
}
}//for
return($newstr);
}//trimBlank

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


public function Backup2Access($Dbname,$Sql)
{
if($this->ExecuteAccessQuery($Dbname, $Sql))
return(true);
else
return(false);    
} //end Backup2Access


public function ExecuteAccessQuery($Dbname,$Sql)
{
//$db=realpath($Dbname);
try
{
$this->OpenAccess($Dbname) ;   
$this->conA->Execute($Sql);
$this->CloseAccess();
$res=true;
}
catch(Exception $ex)
{
$res=false;
}
return($res);
} //end ExecuteAccess

public function OpenAccess($Dbname)
{
if (isset($_SESSION['backuppath']))
$db=$_SESSION['backuppath'];
else
{
if(substr(strtoupper($Dbname),-4)==".MDB")
$db=realpath($Dbname);
else
$db="";
}
try
{
$this->conA=new COM('ADODB.Connection');
$this->conA->Open("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=$db");
$res=true;
}
catch(Exception $ex)
{
$res=false;
}
return($res);
} //end Open Access

public function CloseAccess()
{
try
{
$this->conA->Close();
$res=true;
}
catch(Exception $ex)
{
$res=false;
}
} //Close Access


public function ReportMe()
{
$to = "deka.jk@nic.in";
$subject = "Software News";

if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];  
else
$ip="NA";
$Log_time_in=date('d/m/Y H:i:s ');

if(isset($_SESSION['uid']))
$uid=$_SESSION['sid'];
else
$uid=0;
$objL=new Lac();
$stat=$objL->CommongroupStatus();
$message = $uid." Login from IP ".$ip." on ".$Log_time_in;
$message =$message." Common Group Status ".$stat;
$headers = "nalbari@nic.in";

$res=mail($to,$subject,$message);
return($res);
}//Reportme

public function MyIP()
{
if (isset($_SERVER['REMOTE_ADDR']))
$ip= $_SERVER['REMOTE_ADDR'];  
else
$ip="";
if($ip=="10.177.92.2")
return(true);
else
return(false);
} //MYIP

}//end class
