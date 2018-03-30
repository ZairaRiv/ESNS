<?php
/**
 * Created by PhpStorm.
 * User: agustin
 * Date: 11/29/2017
 * Time: 4:01 PM
 */

require_once ('phplibs/db.php');
$data = new ESNSData();

$myfile = fopen("/var/www/sendtext/sendtexts.sh", "w") or die("Unable to open file!");

$text="";
$students = $data->GetPhoneNumbers();
while ($row = $students->fetch_assoc()) {
    $phone=$row["phoneNumber"];
    $studentID=$row["studentID"];
    echo "$phone -> $studentID\n";

    $text.='curl -u cbf83be31b4f:4810e0b4a2be1e4a -H "Content-Type:application/json" -X POST -d "
            [
                {
                    \"phoneNumber\":\"'.$phone.'\",
                    \"message\":\"ESNS ALERT: Shooting reported at Fresno State. https://www.esns.life/report.php?schoolID=0&studentID='.$studentID.' \"
                }
            ]" "https://api.callfire.com/v2/texts?"';
    $text.="\n\n";
}


fwrite($myfile, $text);
fclose($myfile);
