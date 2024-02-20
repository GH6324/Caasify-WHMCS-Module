<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;

$path = dirname(__FILE__);
require_once $path . '/ClientCaasifyController.php';
require_once $path . '/AdminCaasifyController.php';
require_once $path . '/basics.php';

// Create Table user and order
function caasify_activate(){    
    $hasTable = Capsule::schema()->hasTable('tblcaasify_user');
    if (empty($hasTable)) {
        Capsule::schema()->create('tblcaasify_user', function ($table) {
            $table->increments('id');
            $table->string('client_id');
            $table->string('caasify_user_id');
            $table->string('email');
            $table->string('token');
            $table->string('password');
        });
    }


    $hasTable = Capsule::schema()->hasTable('tblcaasify_order');
    if (empty($hasTable)) {
        Capsule::schema()->create('tblcaasify_order', function ($table) {
            $table->increments('id');
            $table->string('order_id');
            $table->string('machine_id');
        });
    }
}

// Module Config
function caasify_config(){
    // Variables
    $CurrencyOptions = caasify_create_currency_options();
    $LanguageOptions = array (
        'English' => 'English',
        'Farsi' => 'Farsi',
        'Turkish' => 'Turkish',
    );

    
    // Labels
    $BackendUrl = 'Default is https://test.caasify.com/api';
    $ResellerTokenLabel = 'Insert your Reseller Token here, as an Example "de8fs953k49ho3ellg9x"';
    $DefLangLabel = '';
    $CaasifyCurrency = '';

    $configarray = array(
        "name" => "Caasify",
        "description" => "This addon utility allows you to easily connect to Caasify Marketpalce to sell almost everything",
        "version" => "1.0.1",
        "author" => "Caasify",
        "fields" => array(
            "BackendUrl" => array ("FriendlyName" => "Backend URL", "Type" => "text", "Size" => "31", "Description" => $BackendUrl, "Default" => "https://test.caasify.com/api"),
            "ResellerToken" => array ("FriendlyName" => "Reseller Token", "Type" => "text", "Size" => "31", "Description" => $ResellerTokenLabel, "Default" => ""),
            "DefLang" => array ("FriendlyName" => "Panel Language", "Type" => "dropdown", "Options" => $LanguageOptions, "Description" => $DefLangLabel, "Default" => "English"),
            "CaasifyCurrency" => array ("FriendlyName" => "Caasify Currency", "Type" => "dropdown", "Options" => $CurrencyOptions, "Description" => $CaasifyCurrency, "Default" => 'USD'),
        ));
    return $configarray;
}

// Show in admin panel in addon menu page
function caasify_output($vars) {

    if(!empty($vars['version'])){
        $version = $vars['version'];
        $text = '<h2> Version : ' . $version . '</h2>';
        echo($text);
    }

    $text = '
            <p style="padding: 50px 0px 0px 0px; !important">
                <span style="font-weight: 800 !important;">Caasify</span> is an unique solution for Data Centers and Hosting companies.
            </p>
        ';
    echo($text);
    
    $text = '
            <p>You can always get the latest version from the <a href="https://github.com/" style="font-weight: 800 !important;" target="_blank">Caasify git repository</a></p>
            <p>To learn how to use Caasify modules, please check out the <a href="https://caasify.com/docs/" style="font-weight: 800 !important;" target="_blank"> Caasify documentation page</a></p>
            ';
    echo($text);

    
    // show error if config is empty or there is any error
    $ModuleConfigArray = caasify_get_config();
    if($ModuleConfigArray['errorMessage']){
        $text = '<pre><p style="color:red" class="h5">' . $ModuleConfigArray['errorMessage'] . '</p></pre>';
        echo($text);
    }

}

// Create Client Panel Controller
function caasify_clientarea($vars){   

    $action = caasify_get_query('action');
    $clientId = caasify_get_session('uid');
    
    if(empty($clientId)){
        echo 'can not find clientID to construct controller';
        return false;
    }

    
    $ResellerToken = caasify_get_reseller_token();
    if(empty($ResellerToken)){
        echo 'can not find ResellerToken to construct controller';
        return false;
    }
    

    $configs = caasify_get_config();
    $BackendUrl = $configs['BackendUrl'];
    if(empty($BackendUrl)){
        echo 'can not find BackendUrl to construct controller';
        return false;
    }   

    if(!empty($action) && !empty($clientId) && !empty($ResellerToken) && !empty($BackendUrl)){
        try {
            $controller = new ClientCaasifyController($BackendUrl, $ResellerToken, $clientId);
            return $controller->handle($action);
        } catch (Exception $e) {
            return "Error";
        }
    }
}