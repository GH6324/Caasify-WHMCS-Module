<?php
// This file get neede data from config.php and latest $config params

// In case be installed whmcs in a subfolder, this file can get url from host data
require_once('./config.php');
header('Content-Type: application/json');
echo json_encode(['configs' => $configs]);
?>