<?php
class Sentence
{
//public function _construct($i) //for PHP6
public function Sentence()
{

}

private function inStr($str,$find)
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

Public Function SentenceCase($t)
{

$t=$t." ";

$newtxt = "";
$myrow=array();

$myrow=explode(" ",$t); 

for($i=0;$i<count($myrow);$i++)
{
$newr=$this->Gcase($myrow[$i]);
//echo $i.".".$myrow[$i]." ".$newr."<br>";
$newtxt = $newtxt.$newr." ";
}

return($newtxt);
}  //end SentenceCase




private function Gcase($txt)
{

$j = strlen($txt);
$k = "";
for($i = 0;$i<$j;$i++)
{
if ($i == 0)
{
if (ord(substr($txt, $i, 1)) > 96 && ord(substr($txt, $i, 1)) < 123) 
$k = $k.chr(ord(substr($txt, $i, 1)) - 32);
else
$k =$k.substr($txt, $i, 1);
}
else //ok
{
if (ord(substr($txt, $i, 1)) > 64 && ord(substr($txt, $i, 1)) < 91) 
{
if (substr($txt, $i - 1, 1) == "." )
{

if(is_numeric(substr($txt, $i, 1))) 
$prev = substr($txt, $i, 1);
else
$prev = substr($txt, $i, 1);
}
else
$prev = chr(ord(substr($txt, $i, 1)) + 32);

$k = $k.$prev;
}
else
{
if (substr($txt, $i - 1, 1) == "." )
{
if (is_numeric(substr($txt, $i, 1))) 
$prev = substr($txt, $i, 1);
else
$prev = chr(ord(substr($txt, $i, 1)) - 32);
}
else
$prev = substr($txt, $i, 1);
$k = $k.$prev;
} //ok
} //ok
} //for loop
return($k);
}

public function Encrypt($a)
{
//St$art ch$ar$acter 33 to 255
$j = strlen($a);
$i = 0;
$k ="";
$ii=1;
while ($i < $j)
{
if (ord(substr($a, $i, 1)) > 31 && ord(substr($a, $i, 1)) < 124) // 31 to 131 is Keyboard Character
{
if ((ord(substr($a, $i, 1)) + $ii)<124) // {
{
if ((ord(substr($a, $i, 1)) + $ii)==39) // Single Quote    
$k = $k.substr($a, $i, 1); 
else
$k =$k.chr(ord(substr($a, $i, 1)) + $ii);
}
else
$k = $k.substr($a, $i, 1); 
}
else
$k = $k.substr($a, $i, 1);
$i = $i + 1;
$ii++;
//echo $k."<br>";
}
return(chr(61 + $j).$k.chr(100 + $j));
}


public function focus($a)
{
$temp="<Script language=javascript>\n";
$temp=$temp."myform.".$a.".focus();\n"   ; 
$temp=$temp."</script>" ;   
return($temp);

}

}//End Class
?>
