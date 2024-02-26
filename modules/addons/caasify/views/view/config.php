<?php
// This file aims to get configs from WHMCS and use it inside module

// INCLUDE NEEDED FILES
$position = strpos($_SERVER['PHP_SELF'], "modules");
$directoryPath = substr($_SERVER['PHP_SELF'], 0, $position);
$DomainAddress = $_SERVER['HTTP_HOST'];
$Protocol = $_SERVER['REQUEST_SCHEME'];
$SiteAddress = $Protocol . '://' . $DomainAddress . $directoryPath;


// Read init and caasify in this config file to use methods and props
$root = $_SERVER['DOCUMENT_ROOT'];
$initAdress = $root . $directoryPath . "init.php";
$caasifyAddress = $root . $directoryPath . 'modules/addons/caasify/caasify.php';
require_once($initAdress);
require_once ($caasifyAddress);

// READY TO READ DATA
// --------------------------------------- //



// Get and Set Language
$templatelang = caasify_GetDefaulLanguage();
if(empty($templatelang)){
    $templatelang = 'English';
}

// Get Config to send to ConfigApi.php
$configs = caasify_get_config();

$systemUrl = $configs['systemUrl'];
$BackendUrl = $configs['BackendUrl'];


















// Settign: should move to to module config
$ChargeModuleEnable = true;
$ChargeModuleDetailsViews = true;
$CloudTopupLink = '/clientarea.php?action=addfunds';
if(empty($BackendUrl)){
    $BackendUrl = 'https://test.caasify.com';
}


?>