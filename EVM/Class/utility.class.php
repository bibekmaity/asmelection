<body>
<?php
require_once './class/class.PWD.php';
class Utility
{
private $mDays=array();
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
} //constructor

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

$objPwd=new Pwd();
$objPwd->setUid($_SESSION['uid']);
if ($objPwd->EditRecord())
{
if ($objPwd->getPwd()==trim($_SESSION['pwd']))    
$t=$objPwd->getRoll();
}    
  
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

public function to_mysqldate($mdate)
{
$t="";
$t=substr($mdate,-4)."-".substr($mdate,3,2)."-".substr($mdate,0,2);
$dtarray=explode("/",$mdate);
if (count($dtarray)==3)
$t=$dtarray[2]."-".$dtarray[1]."-".$dtarray[0];
return($t);
}

public function to_date($mydate)
{
$dt=array();
$dt="";
if (strlen($mydate)>=10)
{
$mydate=substr($mydate,0,10);
$dt=explode("-",$mydate);
$dd=$dt[2];
$mm=$dt[1];
$yy=$dt[0];
$dt=$dd."/".$mm."/".$yy;
}
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
$temp=$temp."myform.".$a.".focus();//set Focus on Rsl\n";
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

public function assign($a,$b)
{
$temp="<Script language=javascript>\n";
$temp=$temp."myform.".$a.".value=".chr(34).$b.chr(34).";//set Focus on Rsl\n";
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

}//end class
