<?php

require_once ("../config.php");
require_once ("BulkUpload.php");

$bulkUpload = new BulkUpload($con);
$csvFilePath = 'users.csv';

$bulkUpload->insertUsersFromCSV($csvFilePath);

echo "Data inserted successfully!";
?>