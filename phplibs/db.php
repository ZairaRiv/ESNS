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
}

class ESNSData
{
    var $esns;

    /**
     * ESNSData constructor.
     */
    function __construct (){
        global $esns;
        $esns=new db();

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
        global $esns;
        $result = $esns->Get("CALL findschool('$latitude','$longitude','$dist')");
        return $result;
    }

    public function GetSchoolByID($id) {

    }

    /**
     * Pull a list of students based on the schoolID
     * @param $id School's ID
     * @param $type User Type (student=0, admin=1, 911=2)
     * @return query result
     */
    public function GetStudents($schoolID){
        global $esns;
        return $esns->Get("select * from users where u_type='0' and u_schoolID='$schoolID'");
    }

    /**
     * Pull a list of school administration based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetAdmin($schoolID){
        global $esns;
        return $esns->Get("select * from users where u_type='1' and u_schoolID='$schoolID'");
    }


    /**
     * Pull a list of emergency personal based on schoolID
     * @param $schoolID
     * @return mixed
     */
    public function GetPolice($schoolID){
        global $esns;
        return $esns->Get("select * from users where u_type='2' and u_schoolID='$schoolID'");
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