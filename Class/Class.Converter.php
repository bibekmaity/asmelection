<?php

class Converter
{
private $prevRa;
private $Kaphala=array();
private $Akar=array();
private $EnglishIndex;

//public function _construct($i) //for PHP6
public function Converter()
{
header("Content-Type: text/html; charset=utf-8");
mysql_query("SET NAMES UTF8");
$this->Kaphala['A']="অ"; //1
$this->Kaphala['AA']="আ"; //2
$this->Kaphala['I']="ই"; //3
$this->Kaphala['EE']="ঈ";//4
$this->Kaphala['U']="উ";//5
$this->Kaphala['AU']="ঊ";//6
$this->Kaphala['AI ']="ঐ";//7
$this->Kaphala['E']="এ";//8
$this->Kaphala['OI']="ঐ";//9
$this->Kaphala['O']="ও";//10
$this->Kaphala['OU']="ঔ";//11
$this->Kaphala['K']="ক";//12
$this->Kaphala['KH']="খ";//13
$this->Kaphala['G']="গ";//14
$this->Kaphala['GH']="ঘ";//15
$this->Kaphala['UU ']="ঊ";//16
$this->Kaphala['CH']="চ";//17
$this->Kaphala['S.']="ছ";//18
$this->Kaphala['J']="জ";//19
$this->Kaphala['JH']="ঝ";//20
$this->Kaphala['NIY']="ঞ";//21
$this->Kaphala['T.']="ট";//22
$this->Kaphala['TH.']="ঠ";//23
$this->Kaphala['D.']="ড";//24
$this->Kaphala['DH.']="ঢ";//25
$this->Kaphala['N.']="ণ";//26
$this->Kaphala['T']="ত";//27
$this->Kaphala['TH']="থ";//28
$this->Kaphala['D']="দ";//29
$this->Kaphala['DH']="ধ";//30
$this->Kaphala['N']="ন";//31
$this->Kaphala['P']="প";//31
$this->Kaphala['PH']="ফ";//33
$this->Kaphala['B']="ব";//34
$this->Kaphala['BH']="ভ";//35
$this->Kaphala['M']="ম";//36
$this->Kaphala['Y']="য";//37
$this->Kaphala['R']="ৰ";//38
$this->Kaphala['L']="ল";//39
$this->Kaphala['|']="|";//40
$this->Kaphala['SH']="শ";//41
$this->Kaphala['SH.']="ষ";//42
$this->Kaphala['S']="স";//43
$this->Kaphala['H']="হ";//44
$this->Kaphala['KSH']="ক্ষ";//45
$this->Kaphala['D.R']="ড়";//46
$this->Kaphala['DH.R']="ঢ়";//47
$this->Kaphala['Y']="য়";//48
$this->Kaphala['TR']="ত্র";//49
$this->Kaphala['JN']="জ্ঞ";//50
$this->Kaphala['SHR']="শ্র";//51
$this->Kaphala['V']="ৱ";//52
$this->Kaphala['F']="ফ";//53
$this->Kaphala['Z']="জ";//54
$this->Kaphala['J.']="য"; //55
$this->Kaphala['RI.']="ঋ";//56
$this->Kaphala['NG']="ঙ";//57
$this->Kaphala['NCH']="ঞ্চ";//58
$this->Kaphala['NTH']="ণ্ঠ";//59
$this->Kaphala['W']="ৱ";//60
$this->Kaphala['X']="ক্স";//61
$this->Kaphala['SW']="স্ব";//62
$this->Kaphala['SHW']="শ্ব";//63
$this->Kaphala['SR']="শ্র";//64
$this->Kaphala['NJ']="ঞ্জ";//65
$this->Kaphala['SHN']="ষ্ণ";//66
$this->Kaphala['QUE']="ক";//67
$this->Kaphala['SRI']="শ্রী";//68
$this->Kaphala['NO']="নং";//69
$this->Kaphala['NO.']="নং";//70
$this->Kaphala['0']="০";//71
$this->Kaphala['1']="১";//72
$this->Kaphala['2']="২";//73
$this->Kaphala['3']="৩";//74
$this->Kaphala['4']="৪";//75
$this->Kaphala['5']="৫";//76
$this->Kaphala['6']="৬";//77
$this->Kaphala['7']="৭";//78
$this->Kaphala['8']="৮";//79
$this->Kaphala['9']="৯";//80
$this->Kaphala['-']="";//81
$this->Kaphala['/']="/";//82
$this->Kaphala['F']="ফ";//83
$this->Kaphala['DEKA']="ডেকা";//84
$this->Kaphala['DAS']="দাস";//85
$this->Kaphala['SARMA']="শৰ্মা";//86
$this->Kaphala['DEVI']="দেবী";//87
$this->Kaphala['BARO']="বড়ো";//88
$this->Kaphala['KALITA']="কলিতা";//89
$this->Kaphala['SHARMA']="শৰ্মা";//90
$this->Kaphala['BARUA']="বৰুৱা";//91
$this->Kaphala['BARUAH']="বৰুৱা";//92
$this->Kaphala['AHMED']="আহমেদ";//93
$this->Kaphala['DUTTA']="দত্ত";//94
$this->Kaphala['SCH']="স্ক";//95
$this->Kaphala['OO']="উ";//96
$this->Kaphala['+']="্";//96
$this->Kaphala['CHANDRABINDU']="ঁ";//97

$this->Akar[1]="";
$this->Akar[2]="া";
$this->Akar[3]="ি";
$this->Akar[4]="ী";
$this->Akar[5]="ু";
$this->Akar[6]="ৌ";
$this->Akar[7]="ৈ";
$this->Akar[8]="ে";
$this->Akar[9]="ৈ";
$this->Akar[10]="ো";
$this->Akar[11]="ৌ";
$this->Akar[12]="্";
$this->Akar[13]="ৃ";
$this->Akar[14]="ং";
$this->Akar[15]="ূ";
$this->Akar[16]="ু";

$this->EnglishIndex[1]="A";
$this->EnglishIndex[2]="AA";
$this->EnglishIndex[3]="I";
$this->EnglishIndex[4]="EE";
$this->EnglishIndex[5]="U";
$this->EnglishIndex[6]="AU";
$this->EnglishIndex[7]="AI";
$this->EnglishIndex[8]="E";
$this->EnglishIndex[9]="OI";
$this->EnglishIndex[10]="O";
$this->EnglishIndex[11]="OU";
$this->EnglishIndex[12]="K";
$this->EnglishIndex[13]="KH";
$this->EnglishIndex[14]="G";
$this->EnglishIndex[15]="GH";
$this->EnglishIndex[16]="UU";
$this->EnglishIndex[17]="CH";
$this->EnglishIndex[18]="S";
$this->EnglishIndex[19]="J";
$this->EnglishIndex[20]="JH";
$this->EnglishIndex[21]="NIY";
$this->EnglishIndex[22]="T.";
$this->EnglishIndex[23]="TH.";
$this->EnglishIndex[24]="D.";
$this->EnglishIndex[25]="DH.";
$this->EnglishIndex[26]="N.";
$this->EnglishIndex[27]="T";
$this->EnglishIndex[28]="TH";
$this->EnglishIndex[29]="D";
$this->EnglishIndex[30]="DH";
$this->EnglishIndex[31]="N";
$this->EnglishIndex[32]="P";
$this->EnglishIndex[33]="PH";
$this->EnglishIndex[34]="B";
$this->EnglishIndex[35]="BH";
$this->EnglishIndex[36]="M";
$this->EnglishIndex[37]="Y";
$this->EnglishIndex[38]="R";
$this->EnglishIndex[39]="L";
$this->EnglishIndex[40]="|";  //rIKAR
$this->EnglishIndex[41]="SH";
$this->EnglishIndex[42]="SH.";
$this->EnglishIndex[43]="S";
$this->EnglishIndex[44]="H";
$this->EnglishIndex[45]="KSH";
$this->EnglishIndex[46]="D.R";
$this->EnglishIndex[47]="DH.R";
$this->EnglishIndex[48]="Y";
$this->EnglishIndex[49]="TR";
$this->EnglishIndex[50]="JN";
$this->EnglishIndex[51]="SHR";
$this->EnglishIndex[52]="V";
$this->EnglishIndex[53]="F";
$this->EnglishIndex[54]="Z";
$this->EnglishIndex[55]="J.";
$this->EnglishIndex[56]="RI.";
$this->EnglishIndex[57]="NG";
$this->EnglishIndex[58]="NCH";
$this->EnglishIndex[59]="NTH";
$this->EnglishIndex[60]="W";
$this->EnglishIndex[61]="X";
$this->EnglishIndex[62]="SW";
$this->EnglishIndex[63]="SHW";
$this->EnglishIndex[64]="SR";
$this->EnglishIndex[65]="NJ";
$this->EnglishIndex[66]="SHN";
$this->EnglishIndex[67]="QU";
$this->EnglishIndex[68]="SR";
$this->EnglishIndex[69]="NO.";
$this->EnglishIndex[70]="NO.";
$this->EnglishIndex[71]="0";
$this->EnglishIndex[72]="1";
$this->EnglishIndex[73]="2";
$this->EnglishIndex[74]="3";
$this->EnglishIndex[75]="4";
$this->EnglishIndex[76]="5";
$this->EnglishIndex[77]="6";
$this->EnglishIndex[78]="7";
$this->EnglishIndex[79]="8";
$this->EnglishIndex[80]="9";
$this->EnglishIndex[81]="-";
$this->EnglishIndex[82]="/";
$this->EnglishIndex[83]="F";
$this->EnglishIndex[84]="DEKA";
$this->EnglishIndex[85]="DAS";
$this->EnglishIndex[86]="SARMA";
$this->EnglishIndex[87]="DEVI";
$this->EnglishIndex[88]="BARO";
$this->EnglishIndex[89]="KALITA";
$this->EnglishIndex[90]="SHARMA";
$this->EnglishIndex[91]="BARUA";
$this->EnglishIndex[92]="BARUAH";
$this->EnglishIndex[93]="AHMED";
$this->EnglishIndex[94]="DUTTA";
$this->EnglishIndex[95]="SCH";
$this->EnglishIndex[96]="OO";
$this->EnglishIndex[97]="+";
}

public function findEnglishIndex($a)
{
$ind=0;

for($ii=1;$ii<=count($this->EnglishIndex);$ii++)
{
$tmp=$this->EnglishIndex[$ii];
$res=strcmp($tmp,$a);
if ($res==0)
{
$ind=$ii;
$ii=count($this->EnglishIndex);
}
}
return($ind);
}



private function IsVowelChar($a)
{
//If ($a == "A" || $a == "AA" Or $a == "E" || $a == "I" || $a == "O" || $a == "OO" || $a == "U" || $a == "UU" || $a == "AI" || $a == "OU" || $a == "AU" || $a == "OI" || $a == "EE" || $a == "RI" )
If (strcmp($a,"A")==0 || strcmp($a,"AA")==0 || strcmp($a,"E")==0 || strcmp($a,"I")==0 || strcmp($a,"O")==0 || strcmp($a,"OO")==0 || strcmp($a,"U")==0 || strcmp($a,"UU")==0 || strcmp($a,"AI")==0 || strcmp($a,"OU")==0 || strcmp($a,"AU")==0 || strcmp($a,"OI")==0 || strcmp($a,"EE")==0 || strcmp($a,"RI")==0 )
return(True);
else
return(false);
} //isvowelchar


private function findMtype($pos, $prev, $mStr) 
{
$tt=0;
If ($this->IsVowelChar($mStr)==false)
$tt = 0;

If ($pos == 0 )
$tt = 0;

If ($prev==0 && $this->IsVowelChar($mStr)==true) 
$tt = 1;

//echo $prev.":".$mStr."=type=".$tt."<br>";
return($tt);
}  //findmtype



private function JuktaksharPossible($str1,$str2) 
{
$Found = False;

If (($str1 == "R" || $str2 == "R" || $str2 == "Y") && ($str1 != "-" && $str1!="A" && $str2!="-") )
$Found= True;
 

If ($str1 == "B" && ($str2 == "D" || $str2 == "B") )
$Found= True;
 

If ($str1 == "D" && ($str2 == "D" || $str2 == "G" || $str2 == "M" || $str2 == "B" || $str2 == "BH" || $str2 == "W" || $str2 == "DH") )
$Found= True;
 
//MadhinaDA
If ($str1 == "D." && ($str2 == "D.") )
$Found= True;
 

If ($str1 == "G" && ($str2 == "N" || $str2 == "L" || $str2 == "G" || $str2 == "DH") )
$Found= True;
 

If ($str1 == "GH" && ($str2 == "N") )
$Found= True;
 

If ($str1 == "H" && ($str2 == "N" || $str2 == "M" || $str2 == "L" || $str2 == "B") )
$Found= True;
 

If ($str1 == "J" && ($str2 == "J" || $str2 == "JH") )
$Found= True;
 

If ($str1 == "K" && ($str2 == "K" || $str2 == "L" || $str2 == "T" || $str2 == "T." || $str2 == "M" || $str2 == "S") )
$Found= True;
 

If ($str1 == "L" && ($str2 == "B" || $str2 == "T." || $str2 == "G" || $str2 == "L" || $str2 == "P" || $str2 == "M" || $str2 == "K" || $str2 == "F" || $str2 == "PH") )
$Found= True;
 

If ($str1 == "M" && ($str2 == "M" || $str2 == "P" || $str2 == "BH" || $str2 == "PH" || $str2 == "F" || $str2 == "N" || $str2 == "B") )
$Found= True;
 

If ($str1 == "N" && ($str2 == "M" || $str2 == "N" || $str2 == "K" || $str2 == "D" || $str2 == "T" || $str2 == "G" || $str2 == "TH" || $str2 == "DH") )
$Found= True;
 

//MadhinaNa
If ($str1 == "N." && ($str2 == "D." || $str2 == "T." || $str2 == "TH.") ) //MADHUNANA
$Found= True;
 

If ($str1 == "P" && ($str2 == "P" || $str2 == "T" || $str2 == "T." || $str2 == "L") )
$Found= True;
 

//DaintaSA
If ($str1 == "S" && ($str2 == "T" || $str2 == "N" || $str2 == "P" || $str2 == "M" || $str2 == "W" || $str2 == "K" || $str2 == "TH") )
$Found= True;
 

//MadhinaSA
If ($str1 == "SH." && ($str2 == "M" || $str2 == "K" || $str2 == "T." || $str2 == "TH." || $str2 == "P") )
$Found= True;
 

//TalubyaSA
If ($str1 == "SH" && ($str2 == "W" || $str2 == "CH" || $str2 == "S.") )
$Found= True;
 

//PrathamMSA
If ($str1 == "CH" && ($str2 == "CH" || $str2 == "S.") )
$Found= True;
 


If ($str1 == "T" && ($str2 == "T" || $str2 == "N" || $str2 == "P" || $str2 == "S" || $str2 == "K") )
$Found= True;
 
//MadhinaTa
If ($str1 == "T." && ($str2 == "T.") )
$Found= True;
 

//uNGA
If ($str1 == "NG" && ($str2 == "G") )
$Found= True;
 
return($Found);
} //juktakshar possible


private function KaValue($a , $tag , $prevC, $presentC, $nextC)
{
$tmp="";
If ($tag ==0 ) //aPHALA OR kAPHALA
{
If ($presentC == "N" && ($nextC == "G" || $nextC == "K")) 
$presentC="NG" ; //N become NG
//$a=57;
//If ($presentC == "Y" && $this->IsVowelChar($prevC)) 
//$presentC="Y" ; //'instead of 37 i.e JA become Ya
//$a=48;

If ($presentC == "Y" && $this->IsVowelChar($prevC)==false && ord($nextC)!=32) 
$presentC="J." ; //' Ya become untastaja
//$a=48;

//echo $presentC."-".ord($nextC)."<br>";
If ($presentC == "Y" && ord($nextC) == 32 && $this->IsVowelChar($prevC)==false)  //dIRGHAiKAR
{ //last Y become dirghaikar
$tag = 1;
$a = 4;
}


If ($presentC =="W" && $this->IsVowelChar($prevC)==false) 
$presentC="B" ;  //W act as Wwabba in first place && Yuktakshar BA for next

//$a=34;

//If ($presentC == "N" && $this->prevRa != "R" && $a == 26) 
//$a=31;

If ($presentC == "N" && $prevC=="O" && ord($nextC)==32) 
$presentC="CHANDRABINDU";

//echo $prevC." ".$presentC." ".$nextC."<br>";

If ($presentC == "N" && $this->prevRa == "R")
$presentC == "N.";

//If ($presentC == "RI" &&  $this->IsVowelChar($prevC)==false)
//{
 //$tag=1;
 //$a=13;/
//}
    
} //tag==0

//OO become HassaU
If ($presentC =="OO" && $this->IsVowelChar($prevC)==false) 
{
$a = 16;
$tag = 1;
}


If ($presentC == "UU" && $this->IsVowelChar($prevC)==false) 
{
$a = 15;
$tag = 1;
}


If ($tag == 0) //Kaphala
{
$tmp=$this->Kaphala[$presentC];
//echo "tag-".$tag." ".$a." is ".$presentC." =".$tmp."<br>";
}

If ($tag == 1) //Akar Ekar
{
$tmp=$this->Akar[$a];
//echo "tag-".$tag." ".$a." is ".$presentC." =".$tmp."<br>";
}

//If ($presentC == "NO" && $nextC!=" ")
//$tmp= 


return($tmp);

} //kavalue

public function filterEnglish($mystr)
{

$notComplete = True;

$sString =strtoupper($mystr)." ";
$lnth = strlen($sString);
$j = 1;
$index=0;

While ($notComplete==true)
{
$notComplete = False;

//find if DH.R exist DhaibinduRa
$sString=str_replace("DH.R","R",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if D.R exist DaibinduRa
$sString=str_replace("D.R","R",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if SH. exist MadhinaSA
$sString=str_replace("SH.","SH",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if S. exist DritiyaSHA
$sString=str_replace("S.","S",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if AA exist Akar
$sString=str_replace("AA","A",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if UU exist Akar
$sString=str_replace("UU","U",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if EE exist Akar
$sString=str_replace("EE","I",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if T. exist MadhinaTa
$sString=str_replace("T.","T",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if TH. exist MadhinaTHa
$sString=str_replace("TH.","TH",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if D. exist MadhinaDa
$sString=str_replace("D.","D",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if DH. exist MadhinaDHa
$sString=str_replace("DH.","DH",$sString,$index) ;
if ($index>0)
$notComplete = True;


//find if ri. exist MadhinaDHa
$sString=str_replace("RI.","RI",$sString,$index) ;
if ($index>0)
$notComplete = True;


//find if N. exist MadhinaNa
$sString=str_replace("N.","N",$sString,$index) ;
if ($index>0)
$notComplete = True;


//find if J. exist uNTASTAJA
$sString=str_replace("J.","J",$sString,$index) ;
if ($index>0)
$notComplete = True;


//find if NGG. exist MadhinaDHa
$sString=str_replace("NGG","NG",$sString,$index) ;
if ($index>0)
$notComplete = True;


//find if - exist MadhinaDHa
$sString=str_replace("-","",$sString,$index) ;
if ($index>0)
$notComplete = True;

//find if + exist MadhinaDHa
$sString=str_replace("+","",$sString,$index) ;
if ($index>0)
$notComplete = True;

}

return($sString);
}


public function English2Unicode($mystring)
{
$mystring = strtoupper($mystring)." ";
$lnth = strlen($mystring);
$j = 0;

$this->prevRa = "X";
$tmpstr = "";
$prevChar = "A";
$prevType = 1;  //Consonant
$mType=1;
$i=1;
//$prevChar = "x";
While ($j < $lnth)
{
$subLength = 0;
$i++;
if ( substr($mystring, $j, 1) == " " ) //H&&le Space
{
$tmpstr = $tmpstr . " ";
$j=$j+1;
$prevType = 1;
$prevChar = "A";
}


//FIND rikar
if ( $j > 0 ) //from 2nd character
{
if (substr($mystring, $j, 2) == "RI" )
if ($this->IsVowelChar($prevChar)==false )
{
$tmpstr = $tmpstr.$this->KaValue(13, 1, "-", "-", "-");
$j = $j + 2;
$prevChar = "RI";
$prevType = 1;
}
}

//find unashar
//if ( substr($mystring, $j, 3) == "NGS" )
if ( substr($mystring, $j, 2) == "NG" && $this->IsVowelChar(substr($mystring, $j+2, 1))==false )
{
$tmpstr = $tmpstr . $this->KaValue(14, 1, "-", "-", "-");
$j = $j + 2;
//$prevChar = "NG";
$prevChar=substr($mystring, $j+2, 1);
$prevType = 0;
}


//if ( 6 character is available
if ( $subLength == 0 )
{
$str = substr($mystring, $j, 6);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
//echo $presentChar." ".$index."<br>";
if ( $index > 0 )
{
$subLength = 6;
$nextChar = substr($mystring, $j + 6, 1);
$mType = $this->findMtype($j, $prevType, $str);
$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
}
} //6 CHARACTER



//if ( 5 character is available
if ( $subLength == 0 )
{
$str = substr($mystring, $j, 5);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
if ($index > 0)
{
$subLength = 5;
$nextChar = substr($mystring, $j + 5, 1);
$mType = $this->findMtype($j, $prevType, $str);
$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
}
}  //5 CHARACTER


//if ( 4 character is available
if ( $subLength == 0 )
{
$str = substr($mystring, $j, 4);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
if ($index > 0)
{
$subLength = 4;
$nextChar = substr($mystring, $j + 4, 1);
$mType = $this->findMtype($j, $prevType, $str);
$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
}
} 


//if ( 3 character is available
if ( $subLength == 0 )
{
$str = substr($mystring, $j, 3);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
if ( $index > 0 )
{
$subLength = 3;
$nextChar = substr($mystring, $j + 3, 1);
$mType = $this->findMtype($j, $prevType, $str);
$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
}
}  //3 chracter


if ( $subLength == 0 )
{
//if ( 2 character is available
$str = substr($mystring, $j, 2);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
if ( $index > 0 )
{
$subLength = 2;
$nextChar = substr($mystring, $j + 2, 1);
//Add $juktakhar
if ( $this->IsVowelChar($prevChar)==false && $this->IsVowelChar($presentChar) == False && $prevChar != " " && $presentChar != " " && $nextChar != " " )
{
if ( $this->juktaksharPossible($prevChar, $presentChar) )
$tmpstr = $tmpstr . $this->KaValue(12, 1, $prevChar, $presentChar, $nextChar); //ADD LINK
}


$mType = $this->findMtype($j, $prevType, $str);
$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
}
} //2 chratcer



if ( $subLength == 0 )
{

$str = substr($mystring, $j, 1);
$presentChar = $str;
$index = $this->findEnglishIndex($str);
//echo "last=".$str." ".$presentChar." ".$index."<br>";
if ( $index > 0 )
{
$nextChar = substr($mystring, $j + 1, 1);
$mType = $this->findMtype($j, $prevType, $str);
//Add $juktakhar
if ( $this->IsVowelChar($prevChar)==false && $this->IsVowelChar($presentChar) == False  && $prevChar!=" "  && $presentChar!=" " && $nextChar!=" " )
{
if ( $this->juktaksharPossible($prevChar, $presentChar))
$tmpstr = $tmpstr . $this->KaValue(12, 1, $prevChar, $presentChar, $nextChar); //ADD LINK
}

$tmpstr = $tmpstr . $this->KaValue($index, $mType, $prevChar, $presentChar, $nextChar);
$subLength = 1;
}
}


if ( $subLength == 0 )
$subLength = 1;


$j = $j + $subLength;

if ( $this->IsVowelChar($presentChar))
$this->prevRa = $prevChar;
else
$this->prevRa = $presentChar;

$prevChar = $presentChar;
$prevType = $mType;
} //while
       
return($tmpstr);
} //end engtounicode

public function Aconv($mstr)
{
$str="";
$mstr=$mstr." ";
$myrow=explode(" ",$mstr);

for ($k=0;$k<count($myrow);$k++)
{
$mstr=$myrow[$k];
//echo $mstr."] ";
$tmp="";
for ($i=0;$i<strlen($mstr);)
{
$st=substr($mstr,$i,3);
if ($st=="ি" || $st=="ে" || $st=="ো" || $st=="ৌ" || $st=="ৈ")
{
if ($st=="ে" || $st=="ৈ" || $st=="ি")
$tmp=substr($tmp,0,$i-3).$st.substr($tmp,$i-3,3);
if ($st=="ো")
$tmp=substr($tmp,0,$i-3)."ে".substr($tmp,$i-3,3)."া";
if ($st=="ৌ")
//$tmp=substr($tmp,0,$i-3)."ে".substr($tmp,$i-3,3)."ৈ";
$tmp=substr($tmp,0,$i-3)."ে".substr($tmp,$i-3,3).$this->utf8(2519);
}
else
$tmp=$tmp.$st;
$i=$i+3;
}//i=0
$str=$str." ".$tmp;
echo $tmp;
}// k=0
//echo "<br>";
return($str);
}

//


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

//Equivalent to chr() and ord() for ASCII Value
public function utf8($num)
{
    if($num<=0x7F)       return chr($num);
    if($num<=0x7FF)      return chr(($num>>6)+192).chr(($num&63)+128);
    if($num<=0xFFFF)     return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
    if($num<=0x1FFFFF)   return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128).chr(($num&63)+128);
    return '';
}

public function uniord($c)
{
    $ord0 = ord($c{0}); if ($ord0>=0   && $ord0<=127) return $ord0;
    $ord1 = ord($c{1}); if ($ord0>=192 && $ord0<=223) return ($ord0-192)*64 + ($ord1-128);
    $ord2 = ord($c{2}); if ($ord0>=224 && $ord0<=239) return ($ord0-224)*4096 + ($ord1-128)*64 + ($ord2-128);
    $ord3 = ord($c{3}); if ($ord0>=240 && $ord0<=247) return ($ord0-240)*262144 + ($ord1-128)*4096 + ($ord2-128)*64 + ($ord3-128);
    return false;
}

}//End Class
?>
