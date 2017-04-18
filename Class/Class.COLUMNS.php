<?php
require_once 'class.iconfig.php';
class Columns
{
private $Table_catalog;
private $Table_schema;
private $Table_name;
private $Column_name;
private $Ordinal_position;
private $Column_default;
private $Is_nullable;
private $Data_type;
private $Character_maximum_length;
private $Character_octet_length;
private $Numeric_precision;
private $Numeric_scale;
private $Character_set_name;
private $Collation_name;
private $Column_type;
private $Column_key;
private $Extra;
private $Privileges;
private $Column_comment;

//extra Old Variable to store Pre update Data
private $Old_Table_catalog;
private $Old_Table_schema;
private $Old_Table_name;
private $Old_Column_name;
private $Old_Ordinal_position;
private $Old_Column_default;
private $Old_Is_nullable;
private $Old_Data_type;
private $Old_Character_maximum_length;
private $Old_Character_octet_length;
private $Old_Numeric_precision;
private $Old_Numeric_scale;
private $Old_Character_set_name;
private $Old_Collation_name;
private $Old_Column_type;
private $Old_Column_key;
private $Old_Extra;
private $Old_Privileges;
private $Old_Column_comment;

//public $Available;
public $recordCount;
public $returnSql;
private $condString;
public $rowCommitted;
public $colUpdated;
public $updateList;
public $pkList;
public $fkList;
private $Def_Ordinal_position="0";
//public function _construct($i) //for PHP6
public function Columns()
{
$objConfig=new iConfig();//Connects database
//$this->Available=false;
$this->rowCommitted=0;
$this->colUpdated=0;
$this->updateList="";
$sql=" select count(*) from COLUMNS";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
$this->recordCount=$row[0];
else
$this->recordCount=0;
$this->condString="1=1";
if (isset($_SESSION['databasename']))
$this->Table_schema=$_SESSION['databasename'];
else
$this->Table_schema="test";
mysql_query("create database election");
}//End constructor

public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}


public function CountRecord($table)
{
$sql="SELECT  count(*) FROM ".$this->Table_schema.".".$table;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //countKey



public function getTableList()
{
$i=0;
$tRow=array();
$sql="select Table_name from TABLES where table_type='BASE TABLE' and table_schema='".$this->Table_schema."' order by table_name";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$tRow[$i]=$row['Table_name'];
$i++;
}
return($tRow);
}

public function isTableExist($mytable)
{
$sql="select count(*) from TABLES where table_type='BASE TABLE' and table_schema='".$this->Table_schema."' and table_name='".$mytable."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($row[0]==0)
return(false);
else
return(true);
}



public function getColumnArray()
{
$tRows=array();
$sql="select Column_name,Ordinal_position,Column_default,Is_nullable,Data_type,Character_maximum_length,Character_octet_length,Numeric_precision,Numeric_scale,Character_set_name,Collation_name,Column_type,Column_key,Extra,Privileges,Column_comment from COLUMNS where Table_schema='".$this->Table_schema."' and Table_name='".$this->Table_name."' order by Ordinal_position";
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
    
$tRows[$i]['Column_name']=$row['Column_name'];
$tRows[$i]['Ordinal_position']=$row['Ordinal_position'];
$tRows[$i]['Column_default']=$row['Column_default'];
$tRows[$i]['Is_nullable']=$row['Is_nullable'];
$tRows[$i]['Data_type']=$row['Data_type'];
$tRows[$i]['Character_maximum_length']=$row['Character_maximum_length'];
$tRows[$i]['Character_octet_length']=$row['Character_octet_length'];
$tRows[$i]['Numeric_precision']=$row['Numeric_precision'];
$tRows[$i]['Numeric_scale']=$row['Numeric_scale'];
$tRows[$i]['Character_set_name']=$row['Character_set_name'];
$tRows[$i]['Collation_name']=$row['Collation_name'];
$tRows[$i]['Column_type']=$row['Column_type'];
$tRows[$i]['Column_key']=$row['Column_key']; //MUL for foreign key PRI for Primary Key
$tRows[$i]['Extra']=$row['Extra'];
$tRows[$i]['Privileges']=$row['Privileges'];
$tRows[$i]['Column_comment']=$row['Column_comment'];
$i++;
} //End While
return($tRows);
} //End EditRecord

public function isPrimaryKey($table,$col)
{
$maxKey = $this->CountKey($table);
$i = 1;
$Found = False;
while ($i <= $maxKey && $Found ==False)
{
if ($this->findKey($table, $i) == $col)
$Found = True;
$i++;
}
return($Found);
} //isPrimaryKey


public function CountKey($table)
{
$sql="SELECT  count(column_name) FROM key_column_usage WHERE CONSTRAINT_Name='PRIMARY' and TABLE_NAME='".$table."' and table_schema='".$this->Table_schema."'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //countKey


public function KeyList()
{
$mrow=array();
$i=0;
$sql="SELECT  COLUMN_NAME FROM KEY_COLUMN_USAGE WHERE CONSTRAINT_NAME='PRIMARY' and TABLE_NAME='".$this->Table_name."' and TABLE_SCHEMA='".$this->Table_schema."' ORDER BY ORDINAL_POSITION";
$result=mysql_query($sql);
$this->returnSql=$sql;
//echo "<u>".$this->Table_name.":</u><br>";
while ($row=mysql_fetch_array($result))
{
$mrow[$i]=$row['COLUMN_NAME'];
//echo $i.$mrow[$i]." <br>";
$i++;
}
return($mrow);
} //KeyList


public function getConstarintName($table)
{
$sql="SELECT CONSTRAINT_NAME ,REFERENCED_TABLE_NAME FROM REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = '".$this->Table_schema."' and TABLE_NAME ='".$table."'";
$i=0;
$mrow=array();
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
$mrow[$i]=$row['CONSTRAINT_NAME'];
$i++;
}
return($mrow);
}

public function getRefTable($table,$constraint)
{
$sql="SELECT REFERENCED_TABLE_NAME FROM REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = '".$this->Table_schema."' and TABLE_NAME ='".$table."' and CONSTRAINT_NAME='".$constraint."'";
$i=0;
$mrow=array();
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return("");
}

public function getRefColumnList($table,$constraint)
{
$tRows=array();
$this->pkList="(";
$this->fkList="(";
$sql="SELECT COLUMN_NAME,REFERENCED_COLUMN_NAME FROM KEY_COLUMN_USAGE WHERE CONSTRAINT_NAME = '".$constraint."' and TABLE_SCHEMA = '".$this->Table_schema."' and TABLE_NAME = '".$table."' order by ordinal_position" ;
$i=0;
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result))
{
if($i>0)
{
$this->pkList=$this->pkList.",";
$this->fkList=$this->fkList.",";
}
$tRows[$i]['Column_name']=$row['COLUMN_NAME'];
$tRows[$i]['RefColumn_name']=$row['REFERENCED_COLUMN_NAME'];
$this->pkList=$this->pkList.$row['COLUMN_NAME'];
$this->fkList=$this->fkList.$row['REFERENCED_COLUMN_NAME'];
$i++;
} //End While
$this->pkList=$this->pkList.")";
$this->fkList=$this->fkList.")";
return($tRows);
} //End EditRecord




//This function is Incomplete
public function FindKey($table,$index)
{
$sql="SELECT  column_name FROM key_column_usage WHERE CONSTRAINT_Name='PRIMARY' and TABLE_NAME='".$table."' and table_schema='".$this->Table_schema."' order by ordinal_position";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
} //countKey





public function rowCount($condition)
{
$sql=" select count(*) from COLUMNS where ".$condition;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if (strlen($row[0])>0)
return($row[0]);
else
return(0);
} //rowCount




public function getTable_catalog()
{
return($this->Table_catalog);
}

public function setTable_catalog($str)
{
$this->Table_catalog=$str;
}

public function getTable_schema()
{
return($this->Table_schema);
}

public function setTable_schema($str)
{
$this->Table_schema=$str;
}

public function getTable_name()
{
return($this->Table_name);
}

public function setTable_name($str)
{
$this->Table_name=$str;
}

public function getColumn_name()
{
return($this->Column_name);
}

public function setColumn_name($str)
{
$this->Column_name=$str;
}

public function getOrdinal_position()
{
return($this->Ordinal_position);
}

public function setOrdinal_position($str)
{
$this->Ordinal_position=$str;
}

public function getColumn_default()
{
return($this->Column_default);
}

public function setColumn_default($str)
{
$this->Column_default=$str;
}

public function getIs_nullable()
{
return($this->Is_nullable);
}

public function setIs_nullable($str)
{
$this->Is_nullable=$str;
}

public function getData_type()
{
return($this->Data_type);
}

public function setData_type($str)
{
$this->Data_type=$str;
}

public function getCharacter_maximum_length()
{
return($this->Character_maximum_length);
}

public function setCharacter_maximum_length($str)
{
$this->Character_maximum_length=$str;
}

public function getCharacter_octet_length()
{
return($this->Character_octet_length);
}

public function setCharacter_octet_length($str)
{
$this->Character_octet_length=$str;
}

public function getNumeric_precision()
{
return($this->Numeric_precision);
}

public function setNumeric_precision($str)
{
$this->Numeric_precision=$str;
}

public function getNumeric_scale()
{
return($this->Numeric_scale);
}

public function setNumeric_scale($str)
{
$this->Numeric_scale=$str;
}

public function getCharacter_set_name()
{
return($this->Character_set_name);
}

public function setCharacter_set_name($str)
{
$this->Character_set_name=$str;
}

public function getCollation_name()
{
return($this->Collation_name);
}

public function setCollation_name($str)
{
$this->Collation_name=$str;
}

public function getColumn_type()
{
return($this->Column_type);
}

public function setColumn_type($str)
{
$this->Column_type=$str;
}

public function getColumn_key()
{
return($this->Column_key);
}

public function setColumn_key($str)
{
$this->Column_key=$str;
}

public function getExtra()
{
return($this->Extra);
}

public function setExtra($str)
{
$this->Extra=$str;
}

public function getPrivileges()
{
return($this->Privileges);
}

public function setPrivileges($str)
{
$this->Privileges=$str;
}

public function getColumn_comment()
{
return($this->Column_comment);
}

public function setColumn_comment($str)
{
$this->Column_comment=$str;
}


public function setCondString($str)
{
$this->condString=$str;
}

public function elapsedTime($t1,$t2)
{
//$t3=date("H:i:s");    
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

$temp="Query took ";
if ($h>0)
$temp=$temp.$h." hours ";
if ($m>0)
$temp=$temp.$m." Minutes ";
$temp=$temp.$s." Second ";

//$row['h']=$h;
//$row['m']=$m;
//$row['s']=$s;
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
public function DataType($table,$col)
{
$tRows=array();
$sql="select Data_type from COLUMNS where Table_schema='".$this->Table_schema."' and Table_name='".$table."' and Column_name='".$col."'";
$i=0;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($row)
return(strtoupper($row['Data_type']));
else
return("");
} //End EditRecord


}//End Class
?>
