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

define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'esnsUser' );
define ( 'DB_PASSWORD', 'ProfAlexSoCool' );
define ( 'DB_DB', 'esnsDB' );


class db
{
    var $conn;
    /**
     * Connect to the ESNS Database
     */
    function __construct(){
        // Create connection
        $connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_DB);

        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        global $conn;
        $conn=$connect;
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    public function Get($sql) {
        global $conn;
        if (is_null($conn)) {
            echo "Database is not connected.";
        }
        $result = $conn->query($sql);
        return $result;
    }

    public function Insert($sql) {
    	    global $conn;
	    if ($conn->query($sql) === FALSE) {
		    echo "<!-- error " . $sql . "<br>" . $conn->error . "-->";
	    }
    }
}

class ESNSData
{
    /**
     * ESNSData constructor.
     */
    function __construct (){
    }

    /**
     * Pass in the user's Lat/Long and the radius distance to find a school,
     * and get back a list of schools
     * @param $latitude
     * @param $longitude
     * @param $dist
     * @return mixed
     */
    public function GetSchoolByDist($latitude,$longitude,$dist){
	    $esns=new db();
        return $esns->Get("CALL findschoolbydist('$latitude','$longitude','$dist')");
    }

    public function GetSchoolByID($id) {
	    $esns=new db();
        return $esns->Get("select * from schools where schoolID='$id'");
    }

    public function GetListOption() {
	$esns=new db();
	$query="select ID, opt from reportTypes";
	return $esns->Get($query);
	}

    public function GetBuildingList($id) {
	    $esns=new db();
    	    $query="select schoolID, buildingID, buildingName from buildings where schoolID='$id'";
    	    return $esns->Get($query);
    }

    /**
     * Pull a list of students based on the schoolID
     * @param $id School's ID
     * @param $type User Type (student=0, admin=1, 911=2)
     * @return query result
     */
    public function GetStudents($schoolID){
	    $esns=new db();
        return $esns->Get("select * from students where schoolID='$schoolID'");
    }

    /**
     * Pull a list of school administration based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetAdmin($schoolID){
	    $esns=new db();
        return $esns->Get("select * from admins where schoolID='$schoolID'");
    }


    /**
     * Pull a list of emergency personnel based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetPolice($schoolID){
	    $esns=new db();
        return $esns->Get("select * from emergencypersonel where schoolID='$schoolID'"); // Doesn't seem to exist a database for police yet. Just called it that for now
    }

    public function MakeReport($schoolID,$studentID,$buildingShooterID,$buildingStudentID) {
    	    $esns = new db();
    	    $query="insert into reports values($schoolID,$studentID,$buildingShooterID,$buildingStudentID,now())";
	    $query = str_replace(',,', ',NULL,', $query);
    	    echo $query;
    	    $esns->Insert($query);
    }



    /**
     * Pass in the MySQL results from the functions about to turn into JSON
     * @param $result
     */
    public function JSONifyResults($result){
        $output = array();
        $output  = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($output,JSON_PRETTY_PRINT);
    }
}
