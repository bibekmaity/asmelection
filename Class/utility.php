
<?php
require_once 'class.config.php';
class  myutility
{

private $u00=0;

private $u=array(0=>'',1=>'One',2=> 'Two',3 => 'Three',4 => 'Four',5 => 'Five',6=> 'Six',7 => 'Seven',8 => 'Eight',9 => 'Nine',10 => 'Ten',11 => 'Eleven',
12 => 'Twelve',13 => 'Thirteen',14 => 'Fourteen',15 => 'Fifteen',16 => 'Sixteen',17 => 'Seventeen',18 => 'Eighteen',
19=>'Nineteen',20 => 'Twenty',30 => 'Thirty',40 => 'Forty',50 => 'Fifty',60 => 'Sixty',70 => 'Seventy',80 => 'Eighty',90 => 'Ninty');

public $crore;
public $lacs;
public $thousand;
public $hundreds;
public $tens;
public $units;

public function myutility() //Constructor
{
$objCon=new Config();
}


public function toLet($str)
{
  $code=strlen($str);
  $this->crore="&nbsp;";
  $this->lacs="&nbsp;";
  $this->thousand="&nbsp;";
  $this->hundreds="&nbsp;";
  $this->tens="&nbsp;";
  $this->units="&nbsp;";
  
  switch ($code)
 {
   case 3:
      $this->units=$this->letdah(substr($str,2,1));
      $this->tens=$this->letdah(substr($str,1,1));
      $this->hundreds=$this->letdah(substr($str,0,1));
      break;  
   case 4:
      $this->units=$this->letdah(substr($str,3,1));
      $this->tens=$this->letdah(substr($str,2,1));
      $this->hundreds=$this->letdah(substr($str,1,1));
      $this->thousand=$this->letdah(substr($str,0,1));
      break;  
   case 5:
      $this->units=$this->letdah(substr($str,4,1));
      $this->tens=$this->letdah(substr($str,3,1));
      $this->hundreds=$this->letdah(substr($str,2,1));
      $this->thousand=$this->letdah(substr($str,0,2));
      break; 
    case 6:
      $this->units=$this->letdah(substr($str,5,1));
      $this->tens=$this->letdah(substr($str,4,1));
      $this->hundreds=$this->letdah(substr($str,3,1));
      $this->thousand=$this->letdah(substr($str,1,2));
      $this->lacs=$this->letdah(substr($str,0,1));
      break; 
 }
}
        
       

public function getMonthName($code)
{
 switch ($code)
 {
  case 1:
      return("January");
      break;
  case 2:
      return("February");
      break;
  case 3:
      return("March");
      break;
  case 4:
      return("April");
      break;
  case 5:
      return("May");
      break;
  case 6:
      return("June");
      break;
  case 7:
      return("July");
      break;
  case 8:
      return("August");
      break;
  case 9:
      return("September");
      break;
  case 10:
      return("October");
      break;
  case 11:
      return("November");
      break;
  case 12:
      return("December");
      break;
      
 }
    
   
}



function decimal2($amt)
{

$l= $amt;

$k=$this->instr(1,$l,".");

If ($k== 0)
{
$m = strlen($l);
$paisa = ".00";
}
else
{
$paisa = substr($l,$k-1,3);
$l =substr($l,0,$k-1);
$m =strlen($l);
}


If (strlen($paisa) < 3)
$paisa = $paisa."0";


$temp =$l .$paisa;

return($temp);

}


function convert2standard($amt)
{

$l= $amt;

$k=$this->instr(1,$l,".");  //call instr function

If ($k== 0)
{
$m = strlen($l);
$paisa = ".00";
}
else
{
$paisa = substr($l,$k-1,3);
$l =substr($l,0,$k-1);
$m =strlen($l);
}

//echo "paisa-".$paisa."<br>";
//echo "string-".$l."<br>";
//echo "stringlebgth-".$m."<br>";

if($m>9)
{
$leftstr=substr($l,0,($m-9));
$m=9;
$l=substr($l,-9);
}
else
$leftstr="";


If (strlen($paisa) < 3)
$paisa = $paisa."0";


switch($m)
{
case 1:
case 2:
case 3:
     {
     $st =$l;
     break;
     }
}


If ($m==4)
$st =substr($l,0,1).",".substr($l,-3);


If ($m==5)
$st =substr($l,0,2).",".substr($l,-3);


If ($m==6)
$st =substr($l,0,1).",". substr($l,1,2).",". substr($l,-3);


If ($m==7)
$st =substr($l,0,2).",". substr($l,2,2).",". substr($l,-3);


If ($m==8)
$st =substr($l,0,1).",". substr($l,1,2).",". substr($l,3,2).",".substr($l,-3);


If ($m==9)
$st =substr($l,0,2).",". substr($l,2,2).",". substr($l,4,2).",".substr($l,-3);


$temp =$leftstr.$st.$paisa;

return($temp);
}



function instr($mindex,$mstr,$src)
{
$temp=0;
for($mindex=0;$mindex<strlen($mstr);$mindex++)
{
if (substr($mstr,$mindex,1)==".")
{
$temp=$mindex+1;
$mindex=strlen($mstr);
}
} //end for
return($temp);
}  //end function


public function letter($amt)
{
$temp="";
$k = $this->Instr(1, $amt, ".");
If ($k== 0)
{
$l= strlen($amt);
$paisa = "0";
}
else
{
$paisa =substr($amt, $k, 2);
$amt = substr($amt,0, $k - 1);
$l = strlen($amt);
If (strlen($paisa) == 1 )
$paisa = $paisa . "0";
}

$pp = $this->num2let($paisa);
$pp = $pp . " Paisa";
If  ($l < 8 )
$temp =$this-> num2let($amt).") Only";
else
{
$f1 = substr($amt,0, $l - 7);
$f2 = substr($amt, -7);
$temp =$this-> num2let($f1) . " Crore ".$this-> num2let($f2) . " )Only";
}
$temp="(Rupees ".$temp;
return($temp);
}


public function letterPaisa($amt)
{
$temp="";
$k =$this->instr(1, $amt, ".");

If ($k== 0)
{
$l= strlen($amt);
$paisa = "0";
}
else
{
$paisa =substr($amt, $k, 2);
$amt = substr($amt,0, $k - 1);
$l = strlen($amt);
If (strlen($paisa) == 1 )
$paisa = $paisa . "0";
}

if ($paisa>0)
{
$pp = $this->num2let($paisa);
$pp = $pp . " Paisa";
}
else
$pp=" Zero Paisa";

If  ($l < 8 )
$temp =$this-> num2let($amt) . " and " . $pp . " )Only";
else
{
$f1 = substr($amt,0, $l - 7);
$f2 = substr($amt, -7);
$temp =$this-> num2let($f1) . " Crore " .$this-> num2let($f2)." and ". $pp." )Only";
}
return($temp);
}



function num2let($amount)
{

If (strlen($amount) ==0)
$amount = 0;


$mlength = strlen($amount);

If  ($mlength == 1 )
$letter = $this->u[$amount];

If  ($mlength ==2 )
{
$dahak=$this->letdah($amount);
$letter = $dahak;
}

If  ($mlength== 3 )
{
$satak =substr($amount, 0, 1);

$tt = substr($amount, 1, 1);
If ($tt!= "0" )
$amount= substr($amount, 1, 2);
else
{
$amount = substr($amount, 2, 1);
}
$dahak=$this->letdah($amount);
$letter = $this->u[$satak] . " " . "Hundred" . " " . $dahak;
}



If  ($mlength ==4 || $mlength ==5)
{
If  ($mlength == 4 )
$Tag = substr($amount, 0, 1);
else
$Tag = substr($amount, 0, 2);

$hajar=$this->letdah($Tag);

If  ($mlength == 4 )
$satak =substr($amount, 1, 1);
else
$satak =substr($amount, 2, 1);


If  ($mlength == 4 )
$amount = substr($amount, 2, 2);
else
$amount = substr($amount, 3, 2);


$tt =substr($amount, 0, 1);

If ( $tt!="0" )
$amount =  substr($amount, 0, 2);
else
$amount =  substr($amount,1, 2);


$dahak=$this->letdah($amount);


If ($satak!="0" )
$stag = "Hundred";
else
$stag = "";


$letter = $hajar . " ". "Thousand" . " " . $this->u[$satak]." ". $stag." ".$dahak;

}  //end lenght=4 or 5

If  ($mlength ==6 || $mlength ==7)
{

If  ($mlength ==6)
{
$tag1 = substr($amount, 0, 1);
$amount = substr($amount, 1, 5);
}
else
{
$tag1 = substr($amount, 0, 2);
$amount =substr($amount, 2, 5);
}
$lakh=$this->letdah($tag1);

$tag2 = substr($amount, 0, 1);

If ($amount== 0 )
$htag = " ";
else
$htag = "Thousand";



If  ($tag2!="0" )
$Tag = substr($amount, 0, 2);
else
$Tag = substr($amount, 1, 1);

$hajar=$this->letdah($Tag);

$satak =substr($amount, 2, 1);;

$amount = substr($amount, 3, 2);

$tt =substr($amount, 0, 1);
If ($tt!="0" )
$amount = substr($amount, 0, 2);
else
$amount = substr($amount, 1, 2);

$dahak=$this->letdah($amount);

If ($satak!="0" )
$stag = "Hundred";
else
$stag = "";

$letter = $lakh . " " . "Lakh" . " " . $hajar . " " . $htag . " " . $this->u[$satak] . " " . $stag ." " . $dahak;


}

return($letter);

}  //end function



function letdah($amount)
{
$temp3="";
if (substr($amount,0,1)=="0") //New Line
$amount=substr($amount,1,1);

If  ($amount < 21 )
$temp3 = $this->u[$amount];
else
{
$dah = substr($amount, 0, 1)."0";
$dah = (int)$dah;
$ak = substr($amount, 1, 1);
$ak = (int)$ak;
$temp3 = $this->u[$dah] . " " .$this->u[$ak];
}
return("$temp3");
}


function gpftextpart($gpfstr)
{
$tt="";
for($i=0;$i<strlen($gpfstr);$i++)
{
if  (!is_numeric(substr($gpfstr,$i,1)))
$tt=$tt.substr($gpfstr,$i,1);
}
return($tt);
}

function gpfnumpart($gpfstr)
{
$tt="";
for($i=0;$i<strlen($gpfstr);$i++)
{
if  (is_numeric(substr($gpfstr,$i,1)))
$tt=$tt.substr($gpfstr,$i,1);
}
return($tt);
}

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

}   //end of class

?>
</body></html>


