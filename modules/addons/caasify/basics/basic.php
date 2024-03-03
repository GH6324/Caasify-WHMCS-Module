<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;
use PG\Request\Request;

$path = dirname(__FILE__);
require $path . '/vendor/autoload.php';

function caasify_has_array($name, $array){
    if (array_key_exists($name, $array)) {
        return true;
    }
    return false;
}

function caasify_get_array($name, $array){
    if (caasify_has_array($name, $array)) {
        return $array[$name];
    }
    return null;
}

function caasify_has_query($name){
    if (caasify_has_array($name, $_GET)) {
        return true;
    }
    return false;
}

function caasify_get_query($name){
    if (caasify_has_query($name)) {
        return $_GET[$name];
    }
    return null;
}

function caasify_has_post($name){
    if (caasify_has_array($name, $_POST)) {
        return true;
    }
    return false;
}

function caasify_get_post($name){
    if (caasify_has_post($name)) {
        return $_POST[$name];
    }
    return null;
}

function caasify_get_post_array($names)
{
    $params = [];
    foreach($names as $name) {
        $params[$name] = caasify_get_post($name);
    }
    return $params;
}

function caasify_has_session($name)
{
    if (array_key_exists($name, $_SESSION)) {
        return true;
    }
    return false;
}

function caasify_get_session($name)
{
    if (caasify_has_session($name)) {
        return $_SESSION[$name];
    }
    return null;
}

function caasify_generate_string($length = 10)
{
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $result = '';
    for ($i=0; $i<$length; $i++) {
        $result .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $result;
}

// Find the service identity
$serviceId = caasify_get_query('avmServiceId');

// Find action
$action = caasify_get_query('avmAction');

// Find the current logged in client
$client = caasify_get_session('uid');

if ($client) {
    $client = Client::find($client);
    if ($client) {
        $service = $client->services()->find($serviceId);
    }
}

// Find the current logged in admin
$admin = caasify_get_session('adminid');

if ($admin) {
    $service = Service::find($serviceId);
}

// Handle caasify requests
if ($service) {
    $controller = new AVMController($serviceId);
    $controller->handle($action);
} 

// Create an array to store config
function get_config_array_temp(){
    $ModuleConfigArray = [
        'BackendUrl' => null,
        'DefLang' => null,
        'CaasifyCurrency' => null,
        'errorMessage' => null,
        'DevelopeMode' => null,
        'ChargeModule' => null,
        'ViewExchanges' => null,
        'CloudTopupLink' => null,
    ];
    return $ModuleConfigArray;
}

// Get config array
function caasify_get_config(){
    try {
        $configTable = Capsule::table('tbladdonmodules')->where('module', 'caasify')->get();
    } catch (\Exception $e) {
        echo "Can not access caasify tables";
        return false;
    }

    $ModuleConfigArray = get_config_array_temp(); 
    if(!empty($configTable)){
        foreach($ModuleConfigArray as $key => $value){
            foreach($configTable as $items){
                if($items->setting == $key){
                    $ModuleConfigArray[$key] = $items->value;
                    if($items->value == ''){
                        $ModuleConfigArray['errorMessage'] = $key . ' is empty';
                    }
                }
            }
        }
    }

    $ModuleConfigArray['systemUrl'] = caasify_get_systemurl();
    return $ModuleConfigArray;
}

// Get Reseller Token form module addons
function caasify_get_reseller_token(){
    
    try {
        $configTable = Capsule::table('tbladdonmodules')->where('module', 'caasify')->get();
    } catch (\Exception $e) {
        echo "Can not access caasify tables";
        return false;
    }

    if(!empty($configTable)){
        foreach($configTable as $config){
            if($config->setting == 'ResellerToken'){
                $ResellerToken = $config->value;
                break;
            }
        }
    }

    if(empty($ResellerToken)){
        echo "token is emprty";
        return false;
    }

    return $ResellerToken;
}

// Get currency list
function caasify_get_currency_list(){
    $command = 'GetCurrencies';
    $postData = array(
    );
    $results = localAPI($command, $postData);
    
    if(!empty($results['currencies']['currency'])){
        $ResultArray = $results['currencies']['currency'];
    }
    
    $CurrencyArray = [];
    foreach($ResultArray as $arr){
        $CurrencyArray [$arr['code']] = $arr['prefix'];
    }
    return $CurrencyArray;
}

// Get SystemUrl
function caasify_get_systemurl(){
    $command = 'GetConfigurationValue';
    $postData = array(
        'setting' => 'SystemURL',
    );
    $results = localAPI($command, $postData);
    if(empty($results['value'])){
        $results['value'] = '/';
    }
    return $results['value'];
}

// Create Currency option
function caasify_create_currency_options(){
    $CurrencyArray = caasify_get_currency_list();
    $CurrencyOptions = [];
    if(!empty($CurrencyArray)){
        foreach($CurrencyArray as $key => $vale){
            $CurrencyOptions[$key] = $key;
        }
    }
    return $CurrencyOptions;
}

// Get Default Language
function caasify_GetDefaulLanguage(){
    $CaasifyConfig = caasify_get_config();
    $allowedLanguages = ['English', 'Farsi', 'Turkish', 'Russian', 'French', 'Deutsch', 'Brizilian', 'Italian'];
    
    // Find DefLang
    if(!empty($CaasifyConfig) && !empty($CaasifyConfig['DefLang']) && in_array($CaasifyConfig['DefLang'], $allowedLanguages)){    
        $DefLang = $CaasifyConfig['DefLang'];
    } else {
        $DefLang = 'English';
    }
    
  

    // Manage Cookies
    if(isset($_COOKIE['temlangcookie'])) {
        $langFromCookies = $_COOKIE['temlangcookie'];
    } else {
        $langFromCookies = $DefLang;
        setcookie('temlangcookie', $DefLang, time() + 365 * 24 * 60 * 60, '/');
    }
    

    // Get templatelang for Client panel
    if(in_array($langFromCookies, $allowedLanguages)){
        $templatelang = $langFromCookies;
    } else {
        $templatelang = $DefLang;
    }
    
    return $templatelang;
}

function caasify_get_user_token_from_db($userId){
    $params = ['userId' => $userId];    
    $user = Capsule::selectOne('SELECT token FROM tblcaasify_user WHERE client_id = :userId', $params);
    return current($user);
}

// create ENd user by Api and find token
function caasify_create_user($BackendUrl, $ResellerToken, $client, $password){
    
    $params = [
        'name' => $client->fullName, 'email' => $client->email, 'password' => $password
    ];

    $headers = [
        'Accept' =>  'application/json',
        'Authorization' => 'Bearer ' . $ResellerToken
    ];

    $address = [
        $BackendUrl, 'users', 'create'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
}

// Create password
function caasify_createPassword($client){       
    return $client->email;
}

function caasify_get_user_token_from_api($BackendUrl, $client, $password){
        
    $params = [
        'email' => $client->email, 'password' => $password
    ];

    $headers = ['Accept' =>  'application/json'];
    
    $address = [
        $BackendUrl, 'auth', 'login'
    ];
    
    return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
}


function caasify_get_whmcs_user($clientId)
{
    $command = 'GetClientsDetails';
    $postData = array(
        'clientid' => $clientId,
        'stats' => true,
    );
    $results = localAPI($command, $postData);

    if($results['result'] == "success"){
        $credit = $results['credit'];
        $currency = $results['currency_code'];
        $userCurrencyId = $results['currency'];
        $response = array(
            'credit' => $credit,
            'currency' => $currency,
            'userCurrencyId' => $userCurrencyId,
        );
        return $response; 
    } else {
        return null;
    } 
}


function caasify_get_Whmcs_Currencies()
{
    $command = 'GetCurrencies';
    $postData = array();
    $results = localAPI($command, $postData);
    return $results; 
}