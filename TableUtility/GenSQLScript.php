<html>
<head><title>Script Generating</title></head>


<script type=text/javascript language=javascript>
function back()
{

//alert('ok');
window.location="form_backup.php?tag=0";
//myform.action="viewrecord.php?tag=0";
//myform.submit();

}

</script>


<body>


<?php
session_start();
require_once '../class/class.columns.php';
require_once '../class/utility.class.php';
require_once '../class/class.sentence.php';

$objUtility=new Utility();
//Start Verify
$allowedroll=1; //Change according to Business Logic
$roll=$objUtility->VerifyRoll();
if (($roll==-1) || ($roll>$allowedroll))
header( 'Location: ../Mainmenu.php?unauth=1');

$objCol=new Columns();
//$objCol->setTable_schema("egovernance"); set in class construct function
$fkstr="-- FOREIGN KEY\n\n";
$objSen=new Sentence();
//$objUtility=new Utility();
//start

$colArr=array();

$t2= date('H:i:s');

$keyrow=array();
if (isset($_POST['trow']))
$trow=$_POST['trow'];
else
$trow=0;

if (isset($_POST['fname']))
$fname="../log/".$_POST['fname'].".sql";
else
$fname="../log/Script.sql";

writesql($fname,"-- Database Name ".strtoupper($objCol->getTable_schema())."\n\n");
//Create Table
//echo $trow;

for($i=0;$i<$trow;$i++)
{
  
$Tabname="Table".($i+1);
$Sel="Sel".($i+1);    
$Data="Data".($i+1);
$Tabname=strtolower($_POST[$Tabname]);
//echo $i.".".$Tabname."<br>";
 
if (isset($_POST[$Sel]))
{
$colstr="-- (" ;  
$firststr="INSERT INTO ".$Tabname." values" ;  
$selectstr="select ";
savesql($fname,"\n");
savesql($fname,"-- \n");
savesql($fname,"-- Structure for Table [".strtoupper($Tabname)."]\n");   
savesql($fname,"-- \n\n");
$sqlstr="CREATE TABLE IF NOT EXISTS ".$Tabname."(\n";

$objCol->setTable_name($Tabname);
$colrow=$objCol->getColumnArray();
$index=0;
for($colind=0;$colind<count($colrow);$colind++)
{
    //Character_maximum_length
$colArr[$index]= $colrow[$colind]['Column_name'];   
$index++;
$colstr=$colstr.$colrow[$colind]['Column_name'];
$selectstr=$selectstr.$colrow[$colind]['Column_name'];
$sqlstr=$sqlstr.$colrow[$colind]['Column_name']." ".$colrow[$colind]['Data_type'] ;

if (preg_match('/CHAR/',strtoupper($colrow[$colind]['Data_type'])))
$sqlstr=$sqlstr."(".$colrow[$colind]['Character_maximum_length'].")";


if (strtoupper($colrow[$colind]['Data_type'])=="DECIMAL")
$sqlstr=$sqlstr."(".$colrow[$colind]['Numeric_precision'].",".$colrow[$colind]['Numeric_scale'].")";


//If rs2.Fields("data_type") = "numeric" Or rs2.Fields("data_type") = "decimal" Then
//ts.Write ("(" & rs2.Fields("numeric_precision") & "," & rs2.Fields("numeric_scale") & ") ")
//End If


//Character_set_name

if (preg_match('/UTF/',strtoupper($colrow[$colind]['Character_set_name'])))
$sqlstr=$sqlstr."  CHARACTER SET utf8 COLLATE utf8_unicode_ci ";
 
//Column_default Is_nullable
if (strlen($colrow[$colind]['Column_default'])>0)
$sqlstr=$sqlstr."  DEFAULT '".$colrow[$colind]['Column_default']."' ";

if (strtoupper($colrow[$colind]['Is_nullable'])=="NO")
$sqlstr=$sqlstr."  NOT NULL ";

if (strlen($colrow[$colind]['Column_comment'])>0)
$sqlstr=$sqlstr."  COMMENT '".$colrow[$colind]['Column_comment']."'";
//COMMENT 'Name in Unicode'


if ($index<count($colrow))
{
$sqlstr=$sqlstr.",\n";
$colstr=$colstr.",";
$selectstr=$selectstr.",";
}
else //check for Primary Key
{ 
$colstr=$colstr.")\n";
//$colstr=$colstr.") VALUES\n";
$keyrow=$objCol->KeyList();
$selectstr=$selectstr." from ".$objCol->getTable_schema().".".$Tabname;
//echo $objCol->returnSql;
//echo "<br>".$Tabname." ".count($keyrow)."<br>";

if (count($keyrow)>0) 
{
$sqlstr=$sqlstr.",\n PRIMARY KEY (";
for($keyind=0;$keyind<count($keyrow);$keyind++)
{
//echo $keyind.".".$keyrow[$keyind]." " ;   
$sqlstr=$sqlstr.$keyrow[$keyind];
if($keyind<count($keyrow)-1)
$sqlstr=$sqlstr.",";    
} //for loop key index
$sqlstr=$sqlstr.")";
//echo $sqlstr."<br>";
} //if count(key)>0
$sqlstr=$sqlstr."\n) ENGINE=InnoDB DEFAULT CHARSET=latin1;\n";
}

} //for loop for column array
savesql($fname,$sqlstr); 
savesql($fname,"\n\n"); 

//Dump  Data
if (isset($_POST[$Data])) //data is to be exported
{
savesql($fname,"\n");
savesql($fname,"-- \n");
savesql($fname,"-- Dumping Data for Table [".strtoupper($Tabname)."]\n");   
savesql($fname,"-- \n\n");
savesql($fname,$colstr);
savesql($fname,"\n");
//sql for Actual Data
//echo $selectstr;
//05062013
$result=$objCol->ExecuteQuery($selectstr);

$j1=$objCol->CountRecord($Tabname);
$j2=0;
while ($datarow=mysql_fetch_array($result))
{
$datastr=$firststr."(";
$j2++;
for ($k=0;$k<$index;$k++)  
{
if (strlen($datarow[$colArr[$k]])>0)
{
$mdtype=$objCol->DataType($Tabname, $colArr[$k]);
if(substr($mdtype,-4)!="BLOB" && substr($mdtype,-6)!="BINARY") //Image data is skipewd as NULL
{
$mdtype=substr($mdtype,-3);
if($mdtype=="BIT" || $mdtype=="INT")
{
$datastr=$datastr.$datarow[$colArr[$k]];
//echo "<br>".$datastr."<br>";
}
else
$datastr=$datastr."'".$datarow[$colArr[$k]]."'";
}
else
$datastr=$datastr."NULL";
}
else
$datastr=$datastr."NULL";

if ($k==($index-1))
$datastr=$datastr.");\n";
else
$datastr=$datastr.",";    
} //for loop for column

savesql($fname,$datastr);
//if($j2<$j1)
//savesql($fname,",\n");  
//else
//savesql($fname,";\n");      
}//while
} //isset(data)
//completed Data Dumping

//Foreign Key

$frow=$objCol->getConstarintName($Tabname);
//echo count($frow);
if (count($frow)>0)
{
$fkstr=$fkstr."\n-- \n-- Foreign Key for Table [".strtoupper($Tabname)."]\n--\n\n";    
//savesql($fname,"\n");
//savesql($fname,"-- \n");
//savesql($fname,"-- Foreign Key for Table ".$Tabname."\n");   
//savesql($fname,"-- \n\n");
for($find=0;$find<count($frow);$find++)
{
$constraint=$frow[$find];
$tr=$objCol->getRefColumnList($Tabname, $constraint);    
$PLIST=$objCol->pkList;
$FLIST=$objCol->fkList;
$fkstr=$fkstr."ALTER TABLE ".$Tabname. " ADD CONSTRAINT ".$constraint;
//savesql($fname,"ALTER TABLE ".$Tabname. " ADD CONSTRAINT ");
//savesql($fname,$constraint);
$fkstr=$fkstr." FOREIGN KEY ".$PLIST." REFERENCES ".$objCol->getRefTable($Tabname, $constraint).$FLIST.";\n";
//savesql($fname," FOREIGN KEY ".$PLIST." REFERENCES ".$objCol->getRefTable($Tabname, $constraint).$FLIST);
//savesql($fname,";\n");
} //for loop for foreign key constraint
}//count(frow()>0)
} //isset (if table is selected
} //for loop for table array
//
savesql($fname,$fkstr); //Write Foreign Key String
$t1= date('H:i:s');
$a=$objCol->elapsedTime($t1, $t2);
echo $objCol->alert($a);

//function starts here



function savesql($fname,$mline)
{
$ts = fopen($fname, 'a') or die("can't open file");
fwrite($ts, $mline);
//fclose($fname);
return(filesize($fname)); //file size in bytes
}


function writesql($fname,$mline)
{
$ts = fopen($fname, 'w') or die("can't open file");
fwrite($ts, $mline);
//fclose($fname);
//echo file_size($fname);
}

?>
<p align="center">    
<a href="<?php echo $fname;?>">File is Stored under Log Folder</a>
<br>
<input type=button id=but1 value=Back onclick=back()>
</p>
</body>
</html> 


