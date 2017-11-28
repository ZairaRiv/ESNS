<?php

require_once ('phplibs/db.php');


$data = new ESNSData();

$data->ClearReports();
echo "Reports Cleared<br>\n";

header("Location: /admin.php");



