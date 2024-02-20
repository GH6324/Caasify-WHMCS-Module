<?php
use WHMCS\Database\Capsule;
use PG\Request\Request;

class ClientCaasifyController
{
    protected $BackendUrl;
    protected $ResellerToken;
    protected $clientId;
    protected $UserToken;

    public function __construct($BackendUrl, $ResellerToken, $clientId)
    {
        $BackendUrl = str_replace(' ', '', $BackendUrl);
        $BackendUrl = preg_replace('/\s+/', '', $BackendUrl);        
        $this->BackendUrl = $BackendUrl;
        
        $this->clientId = $clientId;

        $this->ResellerToken = $ResellerToken;   
        $this->UserToken = $this->getUserTokenFromDB();
    }

    public function getUserTokenFromDB()
    {
        $params = [ 'clientID' => $this->clientId ];
        $user = Capsule::selectOne('SELECT token FROM tblcaasify_user WHERE client_id = :clientID', $params);
        if($user) { 
            return $user->token; 
        }
        
        return null;
    }

    public function getCaasifyUserIDFromDB()
    {
        $params = [ 'clientID' => $this->clientId ];
        $user = Capsule::selectOne('SELECT caasify_user_id FROM tblcaasify_user WHERE client_id = :clientID', $params);
        if($user) { 
            return $user->caasify_user_id; 
        }
        return null;
    }

    public function pageIndex()
    {   
        return ['templatefile' => 'views/index'];
    }

    public function pageCreate()
    {
        return ['templatefile' => 'views/create'];
    }

    public function WhmcsUserInfo()
    {
        $clientId = $this->clientId;
        $response = caasify_get_whmcs_user($clientId);
        $this->response($response);
    }

    public function WhmcsCurrencies()
    {
        $clientId = $this->clientId;
        $response = caasify_get_Whmcs_Currencies($clientId);
        $this->response($response);
    }

    // Orders
    public function UserOrders()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        if($UserToken){
            $response = $this->sendUserOrdersRequest($UserToken);
        }
        
        $this->response($response);
    }

    public function sendUserOrdersRequest($UserToken)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'orders'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    // User Info by Reseller
    public function CaasifyUserInfo()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        if($UserToken){
            $response = $this->sendCaasifyUserInfoRequest($UserToken);
        }
        $this->response($response);
    }

    public function sendCaasifyUserInfoRequest($UserToken)
    {
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'profile', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

























































    // ---------------------------------------------------//
    // Basic Codes to manage Json Request and Responces
    public function response($response)
    {
        header('Content-Type: application/json');
        $response = json_encode($response);
        exit($response);
    }

    // Basic Codes to manage Json Request and Responces
    public function handle($action)
    {
        $class = new ReflectionClass($this);
        $method = $class->getMethod($action);
        if ($method) {
            return $method->invoke($this);
        }
    }
    // ---------------------------------------------------//



































    // just for test
    public function test()
    {
        $response = $this->getUserTokenFromDB();
        // $response = ['data'=> 'value'];
        $this->response($response);
    }
}