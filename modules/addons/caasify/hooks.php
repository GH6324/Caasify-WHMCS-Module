<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;

$path = dirname(__FILE__);
require_once $path . '/basics.php';


add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
    /** @var \WHMCS\View\Menu\Item $primaryNavbar */
    $newMenu = $primaryNavbar->addChild(
        'uniqueMenuItemName',
        array(
            'name' => 'Marketplace',
            'label' => 'Marketplace',
            'uri' => '/index.php?m=caasify&action=pageIndex',
            'order' => 99,
            'icon' => '',
        )
    );
});


// Create User Token in DataBase
add_hook('ClientAreaPage', 100, function($params) {

    $config = caasify_get_config();
    $ResellerToken = caasify_get_reseller_token();
    $BackendUrl = $config['BackendUrl'];

    if(empty($ResellerToken)){
        echo('Cant find ResellerToken in ClientAreaPage hook');
        return false;
    }
    

    if(empty($BackendUrl)){
        echo('Cant find BackendUrl in ClientAreaPage hook');
        return false;
    }

    // create token if cloud is active
    if(!empty($ResellerToken) && !empty($BackendUrl)){
        $clientId = caasify_get_session('uid');
        if (empty($clientId)) {
            return false;
        }


        $client = Client::find($clientId);
        if(empty($client)) {
            echo('can not find the client in ClientAreaPage hook');
            return false;
        }

        // get token from tabale if exist
        $token = caasify_get_user_token_from_db($clientId);


        // if there is token in database, then finish
        if($token) {
            return false;
        }
        
        // create new user if can not find Token
        $password = caasify_createPassword($client);
        $CreateResponse = caasify_create_user($BackendUrl, $ResellerToken, $client, $password);
        if(empty($CreateResponse)) {
            echo('create request did not work');
            return false;
        }
        
        $message = property_exists($CreateResponse, 'message');
        if (!empty($message)) {     
            echo($CreateResponse->message);
            return false;
        }

        $CaasifyUserId = $CreateResponse->data->id;
        if(empty($CaasifyUserId)){
            echo('Can not get CaasifyUserId');
            return false;
        }
        
        $CaasifyUserEmail = $CreateResponse->data->email;
        if(empty($CaasifyUserEmail)){
            echo('Can not get CaasifyUserEmail');
            return false;
        }

        // Get Token from API TO RECORD INTO DATABASE
        $requestTokenResponse = caasify_get_user_token_from_api($BackendUrl, $client, $password);
        if(empty($requestTokenResponse)) {
            echo ('can not get the token in login');
            return false;
        }

        $message = property_exists($requestTokenResponse, 'message');
        if(!empty($message)) {  
            echo($requestTokenResponse->message);
            return false;
        }

        $token = $requestTokenResponse->data->token;
        if(empty($token)){
            echo('token received is empty');
            return false;
        }

        // Save token in WHMCS
        $params = ['client_id' => $client->id, 'caasify_user_id' => $CaasifyUserId, 'token' => $token, 'email' => $CaasifyUserEmail, 'password' => $password];

        Capsule::table('tblcaasify_user')
            ->insert($params);
            
    } else {
        return false;
    }

});
