<?php

include_once 'config.php';
include_once 'BulkUpload.php';

$bulkUpload = new BulkUpload($con);
$csvFilePath = 'users.csv';

$bulkUpload->insertUsersFromCSV($csvFilePath);

echo "Data inserted successfully!";
?>