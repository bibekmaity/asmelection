-- Database Name ELECTION


-- 
-- Structure for Table [BEEO]
-- 

CREATE TABLE IF NOT EXISTS beeo(
CODE int  NOT NULL ,
NAME varchar(50)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
 PRIMARY KEY (CODE)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [BU]
-- 

CREATE TABLE IF NOT EXISTS bu(
BU_Code int  NOT NULL ,
BU_Number varchar(30)  NOT NULL ,
Trunck_Number int,
RNUMBER bigint,
USED char(1)  DEFAULT 'N' ,
 PRIMARY KEY (BU_Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [CATEGORY]
-- 

CREATE TABLE IF NOT EXISTS category(
CODE int  NOT NULL ,
NAME varchar(50)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
TrgAmount int  DEFAULT '0'   COMMENT 'Remuneration for Training',
Amount1 int  DEFAULT '0'   COMMENT 'Remuneration per day on poll duty',
Amount2 int  DEFAULT '0'   COMMENT 'Refreshment Per day',
Amount3 int  DEFAULT '0'   COMMENT 'Contigency',
Amount4 int  DEFAULT '0'   COMMENT 'Other Allowance',
FirstRandom varchar(1)  DEFAULT 'N'   COMMENT 'Y if First Level Randomisation is completed',
Selected int  DEFAULT '0' ,
Allow_Dep_Lac bit  COMMENT 'Dep Lac Considered during First Leve',
Allow_Home_Lac bit  COMMENT 'Home Lac Considered during First Leve',
Allow_Res_Lac bit  COMMENT 'Res. Lac Considered during First Leve',
 PRIMARY KEY (CODE)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [CELL]
-- 

CREATE TABLE IF NOT EXISTS cell(
Code int  NOT NULL ,
Name varchar(50),
 PRIMARY KEY (Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [COUNTINGGROUP]
-- 

CREATE TABLE IF NOT EXISTS countinggroup(
Grpno int  NOT NULL ,
LAC int  NOT NULL ,
Hall_No int  DEFAULT '0'   NOT NULL ,
Table_No int  DEFAULT '0'   NOT NULL ,
Sr bigint  DEFAULT '0'   NOT NULL ,
Ast1 bigint  DEFAULT '0'   NOT NULL ,
Ast2 bigint  DEFAULT '0'   NOT NULL ,
Static_Observer bigint  DEFAULT '0'   NOT NULL ,
Reserve char(1)  DEFAULT 'N'   NOT NULL ,
Rnumber bigint  DEFAULT '0' ,
TrgGroup int  DEFAULT '0'   NOT NULL ,
 PRIMARY KEY (Grpno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [COUNTINGHALL]
-- 

CREATE TABLE IF NOT EXISTS countinghall(
LAC int,
HALL int  NOT NULL ,
Start_Table int,
No_of_Table int,
RO_Name varchar(40),
 PRIMARY KEY (HALL)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [CU]
-- 

CREATE TABLE IF NOT EXISTS cu(
CU_Code int  NOT NULL ,
CU_Number varchar(20)  NOT NULL ,
Trunck_Number int,
RNUMBER bigint,
PaperNo varchar(30),
Used varchar(1)  DEFAULT 'N'   NOT NULL ,
 PRIMARY KEY (CU_Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [DEPARTMENT]
-- 

CREATE TABLE IF NOT EXISTS department(
depcode int  NOT NULL ,
DEP_TYPE varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
GOVT varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   DEFAULT 'S' ,
DEP_CONST int  NOT NULL ,
Department varchar(150)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
Address varchar(50)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
BEEO_CODE int  NOT NULL ,
District varchar(50),
Head varchar(50),
phone varchar(50),
received char(1)  DEFAULT 'Y' ,
MDepCode int  DEFAULT '0' ,
 PRIMARY KEY (depcode)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [DEPTYPE]
-- 

CREATE TABLE IF NOT EXISTS deptype(
code varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
Name varchar(100)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
sl int,
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [DEP_MASTER]
-- 

CREATE TABLE IF NOT EXISTS dep_master(
code int  NOT NULL ,
name varchar(200),
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [DESIGNATION]
-- 

CREATE TABLE IF NOT EXISTS designation(
desig_code int  NOT NULL ,
designation varchar(50)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
dep_type varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
 PRIMARY KEY (desig_code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [EVMGROUP]
-- 

CREATE TABLE IF NOT EXISTS evmgroup(
grpno int  NOT NULL ,
LAC int  DEFAULT '0' ,
CU int  DEFAULT '0' ,
BU int  DEFAULT '0' ,
PSNO int  DEFAULT '0' ,
rcode varchar(4),
RESERVE varchar(1)  DEFAULT 'N' ,
box_cu int,
box_bu int,
cu_id varchar(50),
bu_id varchar(50),
RNumber varchar(100),
 PRIMARY KEY (grpno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [FINAL]
-- 

CREATE TABLE IF NOT EXISTS final(
LAC int  DEFAULT '0'   NOT NULL ,
LOCKED varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
MTYPE int  DEFAULT '0'   NOT NULL ,
TAG int  DEFAULT '1'   NOT NULL ,
 PRIMARY KEY (LAC,MTYPE,TAG)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [GROUPSTATUS]
-- 

CREATE TABLE IF NOT EXISTS groupstatus(
Code int  NOT NULL ,
Detail varchar(40),
 PRIMARY KEY (Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [HPC]
-- 

CREATE TABLE IF NOT EXISTS hpc(
hpccode smallint  DEFAULT '0'   NOT NULL ,
hpcname varchar(50)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
 PRIMARY KEY (hpccode)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [LAC]
-- 

CREATE TABLE IF NOT EXISTS lac(
CODE int  NOT NULL ,
NAME varchar(30)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
Ro_sign varchar(150),
HPCCODE smallint,
RO_DETAIL varchar(250)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
 PRIMARY KEY (CODE)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [LOCKTYPE]
-- 

CREATE TABLE IF NOT EXISTS locktype(
code int  NOT NULL ,
detail varchar(35),
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [MICROGROUP]
-- 

CREATE TABLE IF NOT EXISTS microgroup(
Grpno int  NOT NULL ,
LAC int  NOT NULL ,
Advance int  DEFAULT '1'   NOT NULL ,
Micro_Id bigint  DEFAULT '0'   NOT NULL ,
Reserve char(1)  DEFAULT 'N' ,
Rnumber bigint  DEFAULT '0' ,
MicroPsno int  DEFAULT '0'   NOT NULL ,
 PRIMARY KEY (Grpno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [MICROPS]
-- 

CREATE TABLE IF NOT EXISTS microps(
Grpno int  NOT NULL ,
Lac int  NOT NULL ,
Pslist varchar(25)  DEFAULT '0'   NOT NULL ,
No_of_Ps int  DEFAULT '0'   NOT NULL ,
Advance int  DEFAULT '1' ,
 PRIMARY KEY (Grpno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [PARTY_CALLDATE]
-- 

CREATE TABLE IF NOT EXISTS party_calldate(
code int  NOT NULL ,
mydate varchar(10),
polldate varchar(10),
mydate1 varchar(10),
repoldate varchar(10),
Assemble_Place varchar(100),
Poll_StartTime varchar(20),
Poll_EndTime varchar(20),
mPlace varchar(50),
mDate varchar(20),
mSignature varchar(150),
Edistrict varchar(30),
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [POLING]
-- 

CREATE TABLE IF NOT EXISTS poling(
SlNo bigint  NOT NULL   COMMENT 'Act as Poling ID',
DepCode int  NOT NULL ,
Department varchar(200),
Name varchar(100)  NOT NULL ,
Desig varchar(50)  NOT NULL ,
Sex varchar(1),
AGE int  NOT NULL ,
Pollcategory int,
SELECTED varchar(1)  DEFAULT 'N'   COMMENT 'T for Temorary Assign, Y for First Level Randomisation Complete  and R for Reserve',
GRPNO int  DEFAULT '0' ,
PHONE varchar(11),
PlaceOfResidence varchar(200),
HomeConst int  NOT NULL   COMMENT 'Home LAC',
R_lac int  NOT NULL   COMMENT 'Residential LAC',
DepConst int,
beeo_code int  DEFAULT '0' ,
Basic int,
Psno_Vsl varchar(50) COMMENT 'PS No and Voter Serial',
GRADEPAY int,
Tag int  DEFAULT '1'   COMMENT 'Priority of Selection on Descending',
CellName int  DEFAULT '0' ,
RNUMBER decimal(10,0)  DEFAULT '0' ,
Gazeted varchar(1)  NOT NULL ,
REMARKS varchar(255),
deleted char(1)  DEFAULT 'N'   COMMENT 'Y for Exempt Person',
countCategory int  DEFAULT '0' ,
CountGrpno int  DEFAULT '0' ,
CountSelected char(1)  DEFAULT 'N' ,
DOR datetime  COMMENT 'Date of Retirement',
 PRIMARY KEY (SlNo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [POLINGGROUP]
-- 

CREATE TABLE IF NOT EXISTS polinggroup(
GRPNO int  NOT NULL ,
LAC int,
Rnumber int  DEFAULT '0' ,
LARGE bit,
PRNO bigint  DEFAULT '0' ,
PO1NO bigint  DEFAULT '0' ,
PO2NO bigint  DEFAULT '0' ,
PO3NO bigint  DEFAULT '0' ,
PO4NO bigint  DEFAULT '0' ,
DCODE int  DEFAULT '0' ,
DCODE1 int  DEFAULT '0' ,
DCODE2 int  DEFAULT '0' ,
DCODE3 int  DEFAULT '0' ,
DCODE4 int  DEFAULT '0' ,
RCODE varchar(4),
reserve varchar(1)  DEFAULT 'N' ,
ADVANCE int,
TRGGroup int  DEFAULT '0' ,
 PRIMARY KEY (GRPNO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [POLING_HISTORY]
-- 

CREATE TABLE IF NOT EXISTS poling_history(
pid bigint  DEFAULT '0'   NOT NULL ,
rsl bigint  NOT NULL ,
History varchar(200),
e_date datetime,
e_time varchar(16),
User_name varchar(20),
Client_IP varchar(40),
 PRIMARY KEY (pid,rsl)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [POLING_TRAINING]
-- 

CREATE TABLE IF NOT EXISTS poling_training(
Poling_Id bigint  NOT NULL ,
PhaseNo int  NOT NULL ,
GroupNo int  NOT NULL ,
Attended1 varchar(1),
Attended2 varchar(1),
Attended3 varchar(1),
PCategory int  COMMENT 'Poll Category',
 PRIMARY KEY (Poling_Id,PhaseNo,GroupNo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [PRIORITY]
-- 

CREATE TABLE IF NOT EXISTS priority(
code int  NOT NULL ,
Detail varchar(20),
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [PSNAME]
-- 

CREATE TABLE IF NOT EXISTS psname(
HPC smallint  NOT NULL ,
LAC int  NOT NULL ,
PSNO int  NOT NULL ,
PART_NO varchar(50)  NOT NULL ,
PSNAME varchar(250)  NOT NULL ,
Address varchar(60),
MALE int  NOT NULL ,
FEMALE int  NOT NULL ,
RCODE varchar(4)  DEFAULT '0000' ,
Sensitivity varchar(50),
ForthPoling_Required bit,
Reporting_Tag int  DEFAULT '1' ,
Micro_group int  DEFAULT '0' ,
 PRIMARY KEY (LAC,PSNO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [PS_STATUS]
-- 

CREATE TABLE IF NOT EXISTS ps_status(
San_Status varchar(50)  NOT NULL ,
 PRIMARY KEY (San_Status)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [PWD]
-- 

CREATE TABLE IF NOT EXISTS pwd(
UID varchar(20)  NOT NULL ,
PWD varchar(20)  CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL ,
ROLL int  NOT NULL ,
Active bit,
FullName varchar(50),
First_login char(1)  DEFAULT 'Y' ,
Allowed_IP varchar(20) ,
 PRIMARY KEY (UID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [REPOLGROUP]
-- 

CREATE TABLE IF NOT EXISTS repolgroup(
GRPNO int  NOT NULL ,
LAC int,
LARGE varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
PRNO int  DEFAULT '0' ,
PO1NO int  DEFAULT '0' ,
PO2NO int  DEFAULT '0' ,
PO3NO int  DEFAULT '0' ,
PO4NO int  DEFAULT '0' ,
DCODE int  DEFAULT '0' ,
DCODE1 int  DEFAULT '0' ,
DCODE2 int  DEFAULT '0' ,
DCODE3 int  DEFAULT '0' ,
DCODE4 int  DEFAULT '0' ,
b0 int  DEFAULT '0' ,
b1 int  DEFAULT '0' ,
b2 int  DEFAULT '0' ,
b3 int  DEFAULT '0' ,
b4 int  DEFAULT '0' ,
RCODE varchar(4)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
reserve varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
ADVANCE varchar(1)  CHARACTER SET utf8 COLLATE utf8_unicode_ci ,
TRGGroup int  DEFAULT '0' ,
 PRIMARY KEY (GRPNO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [ROLL]
-- 

CREATE TABLE IF NOT EXISTS roll(
Roll int  NOT NULL ,
Description varchar(20),
 PRIMARY KEY (Roll)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 
-- Dumping Data for Table [ROLL]
-- 

-- (Roll,Description)

INSERT INTO roll values(0,'System User');
INSERT INTO roll values(1,'Administrator');
INSERT INTO roll values(2,'Super User');
INSERT INTO roll values(3,'General Operator');
INSERT INTO roll values(4,'Guest');
-- FOREIGN KEY


-- 
-- Structure for Table [SEX]
-- 

CREATE TABLE IF NOT EXISTS sex(
code varchar(1)  NOT NULL ,
detail varchar(12),
 PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [SIGNIMAGE]
-- 

CREATE TABLE IF NOT EXISTS signimage(
Code int  NOT NULL ,
Seal Mediumblob,
Detail varchar(20)  DEFAULT '-' ,
PRIMARY KEY (Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [STATUS]
-- 

CREATE TABLE IF NOT EXISTS status(
Serial int  NOT NULL ,
First_level char(1)  DEFAULT 'N' ,
evm_group char(1),
training_group char(1),
poll_group char(1),
Micro_Trg char(1)  DEFAULT 'N'   NOT NULL ,
Micro_Group char(1)  DEFAULT 'N'   NOT NULL ,
entry_stop char(1),
AllowEditAfterGrouping char(1),
Randomised smallint  DEFAULT '0' ,
Linkcode int  DEFAULT '0'   NOT NULL ,
 PRIMARY KEY (Serial)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TESTGROUP]
-- 

CREATE TABLE IF NOT EXISTS testgroup(
LACNO smallint  NOT NULL   COMMENT 'Assembly  No',
PR int  DEFAULT '0'   NOT NULL   COMMENT 'Total Presiding',
P1 int  DEFAULT '0'   NOT NULL   COMMENT 'Total First Poling',
P2 int  DEFAULT '0'   NOT NULL   COMMENT 'Total Second Poling',
P3 int  DEFAULT '0'   NOT NULL   COMMENT 'Total Third Poling',
P4 int  DEFAULT '0'   NOT NULL   COMMENT 'Total Forth Poling',
Micro tinyint  DEFAULT '0'   COMMENT 'Microobserver',
 PRIMARY KEY (LACNO)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TRAINING]
-- 

CREATE TABLE IF NOT EXISTS training(
PhaseNo int  NOT NULL ,
groupno int  NOT NULL ,
TrgDate1 varchar(10),
TrgDate3 varchar(10),
TrgDate2 varchar(10),
TrgTime int  NOT NULL ,
TrgPlace varchar(200),
Venue_code int,
Hall_Rsl smallint,
HallCapacity int,
tag int,
ATTENDANCE_LOCK char(1)  DEFAULT 'N'   NOT NULL ,
 PRIMARY KEY (PhaseNo,groupno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TRAINING_PHASE]
-- 

CREATE TABLE IF NOT EXISTS training_phase(
Phase_No int  NOT NULL ,
Phase_Name varchar(30),
LetterNo varchar(50),
Letter_date date,
Signature varchar(50),
Election_District varchar(30),
 PRIMARY KEY (Phase_No)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TRG_HALL]
-- 

CREATE TABLE IF NOT EXISTS trg_hall(
Venue_code int  NOT NULL ,
Rsl smallint  NOT NULL ,
Hall_Number varchar(15),
Hall_Capacity int,
 PRIMARY KEY (Venue_code,Rsl)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TRG_TIME]
-- 

CREATE TABLE IF NOT EXISTS trg_time(
Code int  NOT NULL ,
Timing varchar(50)  NOT NULL ,
 PRIMARY KEY (Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [TRG_VENUE]
-- 

CREATE TABLE IF NOT EXISTS trg_venue(
Venue_Code int  NOT NULL ,
Venue_Name varchar(150)  NOT NULL ,
 PRIMARY KEY (Venue_Code)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- 
-- Structure for Table [USERLOG]
-- 

CREATE TABLE IF NOT EXISTS userlog(
uid varchar(20)  NOT NULL ,
log_date datetime  NOT NULL ,
log_time_in varchar(15)  NOT NULL ,
log_time_out varchar(15)  NOT NULL ,
Client_Ip varchar(40)  NOT NULL ,
Session_id bigint  NOT NULL ,
Left_Frame int  DEFAULT '0'   NOT NULL ,
Middle_Frame int  DEFAULT '0'   NOT NULL ,
Right_Frame int  DEFAULT '0'   NOT NULL ,
`Active` char(1) NOT NULL DEFAULT 'N',
 PRIMARY KEY (Session_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- FOREIGN KEY


-- 
-- Foreign Key for Table [COUNTINGGROUP]
--

ALTER TABLE countinggroup ADD CONSTRAINT countinggroup_ibfk_1 FOREIGN KEY (LAC) REFERENCES lac(CODE);

-- 
-- Foreign Key for Table [COUNTINGHALL]
--

ALTER TABLE countinghall ADD CONSTRAINT countinghall_ibfk_1 FOREIGN KEY (LAC) REFERENCES lac(CODE);
ALTER TABLE countinghall ADD CONSTRAINT countinghall_ibfk_2 FOREIGN KEY (LAC) REFERENCES lac(CODE);

-- 
-- Foreign Key for Table [DEPARTMENT]
--

ALTER TABLE department ADD CONSTRAINT department_ibfk_1 FOREIGN KEY (DEP_CONST) REFERENCES lac(CODE);
ALTER TABLE department ADD CONSTRAINT department_ibfk_2 FOREIGN KEY (DEP_TYPE) REFERENCES deptype(code);
ALTER TABLE department ADD CONSTRAINT department_ibfk_3 FOREIGN KEY (BEEO_CODE) REFERENCES beeo(CODE);

-- 
-- Foreign Key for Table [DESIGNATION]
--

ALTER TABLE designation ADD CONSTRAINT designation_ibfk_1 FOREIGN KEY (dep_type) REFERENCES deptype(code);

-- 
-- Foreign Key for Table [EVMGROUP]
--

ALTER TABLE evmgroup ADD CONSTRAINT evmgroup_ibfk_1 FOREIGN KEY (LAC) REFERENCES lac(CODE);
ALTER TABLE evmgroup ADD CONSTRAINT evmgroup_ibfk_2 FOREIGN KEY (CU) REFERENCES cu(CU_Code);
ALTER TABLE evmgroup ADD CONSTRAINT evmgroup_ibfk_3 FOREIGN KEY (BU) REFERENCES bu(BU_Code);

-- 
-- Foreign Key for Table [FINAL]
--

ALTER TABLE final ADD CONSTRAINT final_ibfk_1 FOREIGN KEY (MTYPE) REFERENCES locktype(code);
ALTER TABLE final ADD CONSTRAINT final_ibfk_2 FOREIGN KEY (TAG) REFERENCES party_calldate(code);

-- 
-- Foreign Key for Table [POLING]
--

ALTER TABLE poling ADD CONSTRAINT poling_ibfk_1 FOREIGN KEY (DepCode) REFERENCES department(depcode);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_2 FOREIGN KEY (HomeConst) REFERENCES lac(CODE);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_3 FOREIGN KEY (DepConst) REFERENCES lac(CODE);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_4 FOREIGN KEY (beeo_code) REFERENCES beeo(CODE);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_5 FOREIGN KEY (Sex) REFERENCES sex(code);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_6 FOREIGN KEY (Pollcategory) REFERENCES category(CODE);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_7 FOREIGN KEY (CellName) REFERENCES cell(Code);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_8 FOREIGN KEY (Tag) REFERENCES priority(code);
ALTER TABLE poling ADD CONSTRAINT poling_ibfk_9 FOREIGN KEY (R_lac) REFERENCES lac(CODE);

-- 
-- Foreign Key for Table [POLING_HISTORY]
--

ALTER TABLE poling_history ADD CONSTRAINT poling_history_ibfk_1 FOREIGN KEY (pid) REFERENCES poling(SlNo);
ALTER TABLE poling_history ADD CONSTRAINT poling_history_ibfk_2 FOREIGN KEY (User_name) REFERENCES pwd(UID);

-- 
-- Foreign Key for Table [POLING_TRAINING]
--

ALTER TABLE poling_training ADD CONSTRAINT poling_training_ibfk_1 FOREIGN KEY (PhaseNo,GroupNo) REFERENCES training(PhaseNo,groupno);
ALTER TABLE poling_training ADD CONSTRAINT poling_training_ibfk_2 FOREIGN KEY (Poling_Id) REFERENCES poling(SlNo);

-- 
-- Foreign Key for Table [PSNAME]
--

ALTER TABLE psname ADD CONSTRAINT psname_ibfk_1 FOREIGN KEY (LAC) REFERENCES lac(CODE);
ALTER TABLE psname ADD CONSTRAINT psname_ibfk_2 FOREIGN KEY (HPC) REFERENCES hpc(hpccode);
ALTER TABLE psname ADD CONSTRAINT psname_ibfk_3 FOREIGN KEY (Reporting_Tag) REFERENCES party_calldate(code);

-- 
-- Foreign Key for Table [PWD]
--

ALTER TABLE pwd ADD CONSTRAINT pwd_ibfk_1 FOREIGN KEY (ROLL) REFERENCES roll(Roll);

-- 
-- Foreign Key for Table [STATUS]
--

ALTER TABLE status ADD CONSTRAINT status_ibfk_1 FOREIGN KEY (Linkcode) REFERENCES beeo(CODE);
ALTER TABLE status ADD CONSTRAINT status_ibfk_2 FOREIGN KEY (Linkcode) REFERENCES category(CODE);
ALTER TABLE status ADD CONSTRAINT status_ibfk_3 FOREIGN KEY (Linkcode) REFERENCES cell(Code);
ALTER TABLE status ADD CONSTRAINT status_ibfk_4 FOREIGN KEY (Linkcode) REFERENCES lac(CODE);

-- 
-- Foreign Key for Table [TRAINING]
--

ALTER TABLE training ADD CONSTRAINT training_ibfk_1 FOREIGN KEY (Venue_code) REFERENCES trg_venue(Venue_Code);
ALTER TABLE training ADD CONSTRAINT training_ibfk_2 FOREIGN KEY (TrgTime) REFERENCES trg_time(Code);
ALTER TABLE training ADD CONSTRAINT training_ibfk_3 FOREIGN KEY (Venue_code,Hall_Rsl) REFERENCES trg_hall(Venue_code,Rsl);
ALTER TABLE training ADD CONSTRAINT training_ibfk_4 FOREIGN KEY (PhaseNo) REFERENCES training_phase(Phase_No);

-- 
-- Foreign Key for Table [TRG_HALL]
--

ALTER TABLE trg_hall ADD CONSTRAINT trg_hall_ibfk_1 FOREIGN KEY (Venue_code) REFERENCES trg_venue(Venue_Code);

