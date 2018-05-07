<?php

/**
 * Created by PhpStorm.
 * User: agust
 * Date: 9/30/2017
 * Time: 6:38 AM
 */

/**
 * Class db
 * Common database access methods
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'esnsUser');
define('DB_PASSWORD', 'ProfAlexSoCool');
define('DB_DB', 'esnsDB');


class db
{
    var $conn;
    private $returnType;

    /**
     * Connect to the ESNS Database
     */
    function __construct($_returnType)
    {
        // Create connection
        $connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        global $conn;
        $conn = $connect;
        $this->returnType = $_returnType;
    }

    public function Get($sql)
    {
        if ($this->returnType == "json") {
            return $this->GetJSON($sql);
        } else {
            return $this->GetLocal($sql);
        }
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    private function GetLocal($sql)
    {
        global $conn;
        if (is_null($conn)) {
            echo "Database is not connected.";
        }
        $result = $conn->query($sql);
        return $result;
    }

    private function GetJSON($sql)
    {
        global $conn;
        if (is_null($conn)) {
            echo "Database is not connected.";
        }
        $result = $conn->query($sql);
        $output = array();
        $output = $result->fetch_all(MYSQLI_ASSOC);

        return json_encode($output);
    }

    public function Insert($sql)
    {
        global $conn;
        if ($conn->query($sql) === false) {
            echo "<!-- error " . $sql . "<br>" . $conn->error . "-->";
        }
    }

    public function Update($sql)
     {
         global $conn;
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            error_log($conn->error,0);
            return false;
        }
     }
}

class ESNSData
{
    private $returnType;

    /**
     * ESNSData constructor.
     */
    function __construct()
    {
        $this->returnType = "standard";
    }

    public function SetReturnType($_returnType)
    {
        $this->returnType = $_returnType;
    }

    /**
     * Pass in the user's Lat/Long and the radius distance to find a school,
     * and get back a list of schools
     * @param $latitude
     * @param $longitude
     * @param $dist
     * @return mixed
     */

    public function GetPhoneNumbers()
    {
        $esns = new db($this->returnType);
        return $esns->Get("select phoneNumber, studentID from students");
    }

    public function GetSchoolByDist($latitude, $longitude, $dist)
    {
        $esns = new db($this->returnType);
        /* stored procedure, a work of art
        CREATE DEFINER=`esnsUser`@`localhost` PROCEDURE `findschoolbydist`(IN passedLat DECIMAL(10,7), passedLong DECIMAL(10,7), passedDist int)
        BEGIN
        SELECT schoolID, schoolName, schoolCity, schoolState,
            (3959 * acos(cos(radians(passedLat)) * cos(radians(schoolLat)) 
         * cos( radians(schoolLong) - radians(passedLong)) + sin(radians(passedLat)) 
         * sin(radians(schoolLat)))) AS distance 
            FROM schools 
            HAVING distance < passedDist
            ORDER BY distance 
            LIMIT 5;
        END
         */
        return $esns->Get("CALL findschoolbydist('$latitude','$longitude','$dist')");
    }

    public function GetSchoolByID($id)
    {
        $esns = new db($this->returnType);
        return $esns->Get("SELECT schoolID,schoolName FROM schools where schoolID='$id'");
    }

    public function GetListOption()
    {
        $esns = new db($this->returnType);
        $query = "select ID, opt from reportTypes order by ID";
        return $esns->Get($query);
    }

    public function GetBuildingList($id)
    {
        $esns = new db($this->returnType);
        $query = "select schoolID, buildingID, buildingName from buildings where schoolID='$id'";
        return $esns->Get($query);
    }

    /**
     * Pull a list of students based on the schoolID
     * @param $id School's ID
     * @return query result
     */
    public function GetStudents($schoolID)
    {
        $esns = new db($this->returnType);
        return $esns->Get("select * from students where schoolID=$schoolID");
    }

    public function GetSchools()
    {
        $esns = new db($this->returnType);
        return $esns->Get("select * from schools");
    }

    public function GetTotalStudentCount()
    {
        $esns = new db($this->returnType);
        return $esns->Get("select count(*) as total from students");
    }

    public function GetTotalSchoolCount()
    {
        $esns = new db($this->returnType);
        return $esns->Get("select count(*) as total from schools");
    }

    public function FindStudentByPhone($phone)
    {
        $esns = new db($this->returnType);
        // strip anything that is not a number
        $normalizedPhone = preg_replace("/[^0-9]/", "", $phone);
        if (strlen($normalizedPhone) == 10) {
            return $esns->Get("select * from students where phoneNumber='$normalizedPhone'");
        }
    }

    public function FindStudentByPartialName($partialName)
    {
        $esns = new db($this->returnType);
        // don't start searching until we have at least two chars
        if (strlen($partialName) < 2) {
            return "";
        }
        return $esns->Get("select * from students where firstName like '%$partialName%' or lastName like '%$partialName$'");
    }

    /**
     * Pull a list of school administration based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetAdmin($schoolID)
    {
        $esns = new db($this->returnType);
        return $esns->Get("select * from admins where schoolID='$schoolID'");
    }


    /**
     * Pull a list of emergency personnel based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetPolice($schoolID)
    {
        $esns = new db($this->returnType);
        return $esns->Get("select * from emergencypersonel where schoolID='$schoolID'"); // Doesn't seem to exist a database for police yet. Just called it that for now
    }

    public function MakeReport($schoolID, $studentID, $buildingShooterID, $buildingStudentID, $typeID)
    {
        $esns = new db($this->returnType);
        $query = "insert into reports values($schoolID,$studentID,$buildingShooterID,$buildingStudentID,now(),$typeID)";
        $query = str_replace(',,', ',NULL,', $query);
        $esns->Insert($query);
    }

    public function CreateBuilding($schoolID, $buildingID, $buildingName, $lat, $long, $point, $width, $height, $start, $end)
    {
        $this->DeleteBuilding($schoolID, $buildingID);
        $this->CreateStructure($schoolID, $buildingID, $buildingName);
        $this->CreateStructureLatLong($schoolID, $buildingID, $lat, $long);
        $this->CreateStructureDimensions($schoolID, $buildingID, $point, $width, $height, $start, $end);
    }

    public function DeleteStructure($schoolID, $buildingID)
    {
        $esns = new db($this->returnType);
        $query = "delete from structure where schoolID=$schoolID and buildingID=$buildingID";
        $esns->Insert($query);
    }

    public function CreateStructure($schoolID, $buildingID, $buildingName)
    {
        $esns = new db($this->returnType);
        $query = "insert into structures values($schoolID,$buildingID,'$buildingName')";
        $esns->Insert($query);
    }

    public function DeleteStructureLatLong($schoolID, $buildingID)
    {
        $esns = new db($this->returnType);
        $query = "delete from structureLatLong  where schoolID='$schoolID' and buildingID='$buildingID'";
        $esns->Insert($query);
    }


    public function CreateStructureLatLong($schoolID, $buildingID, $lat, $long)
    {
        $esns = new db($this->returnType);
        $query = "insert into structureLatLong values($schoolID,$buildingID,$lat,$long)";
        $esns->Insert($query);
    }

    public function DeleteStructureDimensions($schoolID, $buildingID)
    {
        $esns = new db($this->returnType);
        $query = "delete from structureDimensions where schoolID='$schoolID' and buildingID='$buildingID'";
        $esns->Insert($query);
    }

    public function CreateStructureDimensions($schoolID, $buildingID, $point, $width, $height, $start, $end)
    {
        $esns = new db($this->returnType);
        if ($start == '') {
            $start = 0;
        }
        if ($end == '') {
            $end = 0;
        }
        $query = "insert into structureDimensions values($schoolID,$buildingID,$point,$width,$height,$start,$end)";
        $esns->Insert($query);
    }

    public function CreateStructureFromScratch($schoolID, $buildingName, $lat, $long)
    {
        $esns = new db($this->returnType);
        /* stored procedure
        CREATE DEFINER=`esnsUser`@`localhost` PROCEDURE `createBrandNewStructure`(IN _buildingName varchar(256), _schoolID int, _lat decimal(10,7), _long decimal (10,7))
        BEGIN
            START TRANSACTION;

                SET @newID := (select max(buildingID)+1 from structures where schoolID='_schoolID');
                select @newID;
                insert into structures (schoolID, buildingID, buildingName) values ( _schoolID, (select @newID), _buildingName);
                insert into structuresLatLong values(_schoolID, (select @newID), _lat, _long);
                
            COMMIT;
            select schoolID, buildingID, buildingName from structures where buildingID=(select @newID);
        END
         */

        $query="CALL createBrandNewStructure('$buildingName', $schoolID, '$lat', '$long')";
        //error_log($query,0);
        return $esns->Insert($query);
    }

    public function DeleteBuilding($schoolID, $buildingID)
    {
        $esns = new db($this->returnType);
        $esns->Get("delete from structures where schoolID=$schoolID and buildingID=$buildingID");
        $esns->Get("delete from structureLatLong where schoolID=$schoolID and buildingID=$buildingID");
        $esns->Get("delete from structureDimensions where schoolID=$schoolID and buildingID=$buildingID");
    }

    public function LoadBuildings($schoolID)
    {
        $esns = new db($this->returnType);
        $query = "select s1.buildingID, s1.buildingName, s2.lat, s2.long 
            from 
                structures s1, structureLatLong s2 
            where
                s1.buildingID=s2.buildingID and s1.schoolID=s2.schoolID and
                s1.schoolID=$schoolID
            order by buildingName";

        return $esns->Get($query);
    }

    public function GetAllStructuresDimensions($schoolID)
    {
        $esns = new dB($this->returnType);
        /*
        Code for the view below

        select SD.buildingID as b, point as p, width as w, height as h, 
            start as s, end as e 
        from structureDimensions SD, 
        (
            select buildingID, count(start) as startCount from structureDimensions where schoolID=0 and start=true group by buildingID
        ) SC,
        (
            select buildingID, count(end) as endCount from structureDimensions where schoolID=0 and end=true group by buildingID
        ) EC
        where 
            SC.startCount=EC.endCount and 
            SD.buildingID=SC.buildingID and 
            SD.buildingID=EC.buildingID
            order by SD.buildingID, p asc;
        ";
        */
        // select from view
        $query = "SELECT * FROM ListBuiltStructures;";
        return $esns->Get($query);
    }

    public function GetStructureDimensions($schoolID, $buildingID)
    {
        $esns = new dB($this->returnType);
        $query = "select point as p,width as w,height as h,start as s,end as e from structureDimensions where schoolID=$schoolID and buildingID=$buildingID";
        return $esns->Get($query);
    }

    public function EnableEmergencyMode()
    {
        $esns = new db($this->returnType);
        $esns->Get("delete from EmergencyMode");
        $esns->Get("insert into EmergencyMode values(1)");
    }
    public function DisableEmergencyMode()
    {
        $esns = new db($this->returnType);
        $esns->Get("delete from EmergencyMode");
        $esns->Get("insert into EmergencyMode values(0)");
    }
    public function CheckEmergencyMode()
    {
        $esns = new db($this->returnType);
        $query = "select * from EmergencyMode";
        return $esns->Get($query);
    }

    public function FakeReports()
    {
        $esns = new db($this->returnType);
        $esns->Get("insert into reports select * from fakereports");
        return;
    }

    public function SafetyReport($studentID, $safety)
    {
        $esns = new db($this->returnType);
        $query="update students set safe = $safety where studentID = $studentID";
        $esns->Update($query);
        return;
    }

    public function GetSafetyReport($ph)
     {
        $esns = new db($this->returnType);
        $query="select safe from students where phoneNumber='$ph';";
        return $esns->Get($query);
    }

    public function GetReports()
    {
        $esns = new db($this->returnType);
        $query = "select buildingShooterID, count(buildingShooterID) from reports group by buildingShooterID;";
        return $esns->Get($query);
    }

    public function GetStudentLocations()
    {
        $esns = new db($this->returnType);
        $query = "select buildingStudentID, count(buildingStudentID) from reports group by buildingStudentID;";
        return $esns->Get($query);
    }

    public function GetReportTimes()
    {
        $esns = new db($this->returnType);
        $query = "select buildingShooterID from reports order by reportTime desc";
        return $esns->Get($query);
    }

    public function GetLatestReports($schoolID, $reportType, $reportTime) {
        $esns = new db($this->returnType);
        $query = "select studentID, buildingShooterID, structureLatLong.lat, structureLatLong.long, reportTime from reports, structureLatLong where reports.schoolID=$schoolID and reportType=$reportType and reportTime>'$reportTime' and buildingShooterID=buildingID and structureLatLong.schoolID=reports.schoolID;";

        error_log($query,0);
        return $esns->Get($query);
    }

    public function GetAllReports($schoolID, $reportType) {
        $esns = new db($this->returnType);
        $query = "select studentID, buildingShooterID, structureLatLong.lat, structureLatLong.long, reportTime from reports, structureLatLong where reports.schoolID=$schoolID and reportType=$reportType and buildingShooterID=buildingID and structureLatLong.schoolID=reports.schoolID;";
        error_log($query,0);
        return $esns->Get($query);
    }

    public function GetCompiledShootingReports($schoolID) {
        $esns = new db($this->returnType);
        $query = "select count(buildingShooterID) as c, buildingShooterID as b, wc as x, wh as y from reports, CSUFStructureCenters where buildingShooterID=b and schoolID=$schoolID group by buildingShooterID;";
        return $esns->Get($query);
    }
 
    public function GetStudentReportTimes()
    {
        $esns = new db($this->returnType);
        $query = "select buildingStudentID from reports order by reportTime desc";
        return $esns->Get($query);
    }

    public function GetWidthHeight($buildingID)
    {
        $esns = new db($this->returnType);
        $query = "SELECT buildingID,percentWidth,percentHeight FROM buildings where buildingID=$buildingID";
        return $esns->Get($query);
    }

    public function ClearReports()
    {
        $esns = new db($this->returnType);
        $query = "delete from reports";
        return $esns->Get($query);
    }

    public function UserLogin($username)
    {
        $esns = new db($this->returnType);
        $query = "select username,passhash,adminlevel from users where username='$username'";
        return $esns->Get($query);
    }

    public function HashLogin($username, $passhash)
    {
        $esns = new db($this->returnType);
        $query = "select username,passhash,adminlevel from users where username='$username' and passhash='$passhash'";
        return $esns->Get($query);
    }
    /**
     * Pass in the MySQL results from the functions about to turn into JSON
     * @param $result
     */
    public function JSONifyResults($result)
    {
        $output = array();
        $output = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($output, JSON_PRETTY_PRINT);
    }

    public function shooterBuildingWidthHeight()
    {
        $esns = new db($this->returnType);
        $query = "select buildingShooterID, percentWidth , percentHeight from reports, buildings where buildingID=buildingShooterID";
        return $esns->Get($query);
    }
}
