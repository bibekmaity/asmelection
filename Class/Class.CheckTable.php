<?php
require_once 'class.config.php';
require_once 'class.columns.php';
require_once 'class.pwd.php';

class Checktable
{
private $TableArr=array();
public $Result;

//public function _construct($i) //for PHP6
public function Checktable()
{
date_default_timezone_set("Asia/kolkata");    
$objConfig=new Config();//Connects database
$tcount=0;
$objCol=new Columns();

$ts = fopen("MissingTable.txt", 'w') or die("can't open file");

$this->loadArray();
for($i=1;$i<=count($this->TableArr);$i++)
{
if($objCol->isTableExist($this->TableArr[$i])==false)
{    
fwrite($ts, $this->TableArr[$i]."\n");
$tcount++;
}
}
$this->Result=$tcount;

//Insert following if not available
if($tcount>0)
$j=$i;
else
{
$objPwd=new Pwd(); 
//UPDATE FIELD
$sql="alter table poling change `scale` `PSNO_VSL` varchar(50) NULL";
if($objPwd->ExecuteQuery($sql))
$this->saveTextLog("HellowManager","Field 'Scale' renamed as PSNO_VSL");
$sql="alter table CU add category int default 1";
$objPwd->ExecuteQuery($sql);
$sql="alter table BU add category int default 1";
$objPwd->ExecuteQuery($sql);
    

$sql="insert into beeo (CODE,NAME) values('0','-')";
$objPwd->ExecuteQuery($sql);
$sql="insert into hpc (HPCCODE,HPCNAME ) values('0','-')";
$objPwd->ExecuteQuery($sql);
$sql="insert into lac values('0','Outside','0','0','a')";
$objPwd->ExecuteQuery($sql);
$sql="insert into cell (CODE,NAME) values('0','-')";
$objPwd->ExecuteQuery($sql);


$sql="INSERT INTO roll(Roll,Description) VALUES('0','System Manager'),";
$sql=$sql." ('1','Administrator'),('2','Super User'),('3','General Operator'),('4','Guest')";
$objPwd->ExecuteQuery($sql);

//Handle Root Password
$objPwd->setUid("root");
if($objPwd->EditRecord()==false) //Add an Entry as 'root' with password 'Election2014'
{
//Password is Same as User ID    
$sql="insert into pwd(UID,PWD,ROLL,Active,FullName,FIRST_LOGIN) VALUES";
$sql=$sql."('root','Asqrxh','0',1,'Root User','Y')";
if($objPwd->ExecuteQuery($sql)) //Message to System Mnager
$this->saveTextLog("HellowManager","Due to technical Failure ,Your Password is Reset as root on ".date('d/m/Y H:i:s'));
}
$sql="update pwd set roll=2 where roll=0 and UID<>'root'";
$objPwd->ExecuteQuery($sql);
//start new
//Dumping Data for Table [ROLL]
// Structure for Table [SEX]
$sql="INSERT INTO sex(code,detail) VALUES('F','Female')";
$objPwd->ExecuteQuery($sql);
$sql="INSERT INTO sex(code,detail) VALUES('M','Male')";
$objPwd->ExecuteQuery($sql);

//deptype
$sql="INSERT INTO deptype(code,Name,sl) VALUES";

$sql1=$sql."('B','Bank and Public Sector',1)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('C','College',2)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('G','Central Govt Office',3)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('H','High School/HSS',4)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('M','ME/MV School',6)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('O','State Govt Office',8)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('P','Primary School',7)";
$objPwd->ExecuteQuery($sql1);
//Locktype

$sql="INSERT INTO locktype(code,detail) VALUES";
$sql1=$sql."(1,'Group Formation Completed')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(2,'Polling Station Allocated to group')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(3,'EVM (CU and BU Grouped) ')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(4,'EVM Pair Allocated to Poling Statio')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(5,'Micro Observer Alloted to LAC')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(6,'Micro Observer Alloted to PS')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(7,'Counting Group Formed')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(8,'Hall Allocation Done')";
$objPwd->ExecuteQuery($sql1);

$sql="INSERT INTO ps_status(San_Status) VALUES";
$sql1=$sql."('Normal')";
$objPwd->ExecuteQuery($sql1);


$sql1=$sql."('Sensitive')";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."('Very Sensitive')";
$objPwd->ExecuteQuery($sql1);

//Training phase       
$sql="INSERT INTO training_phase(Phase_No,Phase_Name,LetterNo,Letter_date,Signature,Election_District) VALUES";
$sql1=$sql."(1,'Pre Grouping Training',NULL,NULL,NULL,NULL)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(2,'Combine Training(Post Group)',NULL,NULL,NULL,NULL)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(3,'Micro Observer Training',NULL,NULL,NULL,NULL)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(4,'Counting Pre group',NULL,NULL,NULL,NULL)";
$objPwd->ExecuteQuery($sql1);

$sql1=$sql."(5,'Counting Post Group',NULL,NULL,NULL,NULL)";
$objPwd->ExecuteQuery($sql1);


//party Call date
$sql="insert into party_calldate values('0','19/2/2014','21/2/2014','13/04/2011','14/04/2011','Govt. Gurdon HSS, Nalbari','8 A.M.','4 P.M','Nalbari Govt School','27/01/2013','District Election Officer, Nalbari','Bongaigaon')";
$objPwd->ExecuteQuery($sql);
$sql="insert into party_calldate values('1','20/2/2014','21/2/2014','13/04/2011','14/04/2011','Govt. Gurdon HSS, Nalbari','8 A.M.','4 P.M','Nalbari Govt School','27/01/2013','District Election Officer, Nalbari','Bongaigaon')";
$objPwd->ExecuteQuery($sql);

//Priority Table
$sql="insert into priority values('1','Normal')";
$objPwd->ExecuteQuery($sql);
$sql="insert into priority values('2','High')";
$objPwd->ExecuteQuery($sql);

//Group Status Table
$sql="insert into groupstatus values('0','Group Formation Not  Yet Done')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('1','Ready For Group Formation')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('2','Group Formation in Process')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('3','Group Formation Completed')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('4','Group Locked')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('5','PS Allocation Done(Partial)')";
$objPwd->ExecuteQuery($sql);
$sql="insert into groupstatus values('6','PS Allocation Completed')";
$objPwd->ExecuteQuery($sql);
//Category table
$sql="insert into category (Code,Name)values('0','Unrecognised')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('1','Presiding Officer')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('2','First Poling Officer')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('3','Second Poling Officer')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('4','Third Poling Officer')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('5','Forth Poling Officer')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('6','Cell Duty')";
$objPwd->ExecuteQuery($sql);
$sql="insert into category (Code,Name) values('7','Micro Observer')";
$objPwd->ExecuteQuery($sql);

//Status Table
$sql="insert into status(Serial,First_level,evm_group,training_group,poll_group,Micro_Trg,Micro_Group,entry_stop,AllowEditAfterGrouping,Randomised,Linkcode)";
$sql=$sql." VALUES ('1','N','N','N','N','N','N','N','Y','0','0')";
$objPwd->ExecuteQuery($sql);

}//$tcount==0

}//End constructor



public function ExecuteQuery($sql)
{
$result=mysql_query($sql);
$this->rowCommitted= mysql_affected_rows();
return($result);
}

public function loadArray()
{
$this->TableArr[1]="Beeo";
$this->TableArr[2]="Bu";
$this->TableArr[3]="Category";
$this->TableArr[4]="Cell";
$this->TableArr[5]="Countinggroup";
$this->TableArr[6]="Countinghall";
$this->TableArr[7]="Cu";
$this->TableArr[8]="Department";
$this->TableArr[9]="Deptype";
$this->TableArr[10]="Dep_master";
$this->TableArr[11]="Designation";
$this->TableArr[12]="Evmgroup";
$this->TableArr[13]="Final";
$this->TableArr[14]="Groupstatus";
$this->TableArr[15]="Hpc";
$this->TableArr[16]="Lac";
$this->TableArr[17]="Locktype";
$this->TableArr[18]="Microgroup";
$this->TableArr[19]="Microps";
$this->TableArr[20]="Party_calldate";
$this->TableArr[21]="Poling";
$this->TableArr[22]="Polinggroup";
$this->TableArr[23]="Poling_history";
$this->TableArr[24]="Poling_training";
$this->TableArr[25]="Priority";
$this->TableArr[26]="Psname";
$this->TableArr[27]="Ps_status";
$this->TableArr[28]="Pwd";
$this->TableArr[29]="Repolgroup";
$this->TableArr[30]="Roll";
$this->TableArr[31]="Sex";
$this->TableArr[32]="Status";
$this->TableArr[33]="Testgroup";
$this->TableArr[34]="Training";
$this->TableArr[35]="Training_phase";
$this->TableArr[36]="Trg_hall";
$this->TableArr[37]="Trg_time";
$this->TableArr[38]="Trg_venue";
$this->TableArr[39]="Userlog";
}

public function saveTextLog($tbl,$line)
{
$dd="./log/".$tbl;
$fname = $dd.".txt";
$ts = fopen($fname, 'w') or die("can't open file");
$line=$line."\n";
fwrite($ts, $line);
}


}//End Class
?>
