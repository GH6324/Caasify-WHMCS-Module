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

    public function pageView()
    {
        return ['templatefile' => 'views/view'];
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
            $BackendUrl, 'api', 'orders'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

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
            $BackendUrl, 'api', 'profile', 'show'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }





















// New for create page
    public function CaasifyGetDataCenters()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        if($UserToken){
            $response = $this->sendCaasifyGetDataCentersRequest($UserToken);
        }
        $this->response($response);
    }

    public function sendCaasifyGetDataCentersRequest($UserToken)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'common', 'categories'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyGetPlans()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;
        $CategoryID = caasify_get_post('CategoryID');
        
        if($UserToken && $CategoryID){
            $response = $this->sendCaasifyGetPlansRequest($UserToken, $CategoryID);
        }
        $this->response($response);
    }

    public function sendCaasifyGetPlansRequest($UserToken, $CategoryID)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $params = http_build_query([
            'category' => $CategoryID,
        ]);
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'common', 'products', "?{$params}"
        ];

        
        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }

    public function CaasifyCreateOrder()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;
        
        $params = caasify_get_post_array_all();
       
        if($UserToken && $params){
            $response = $this->sendCaasifyCreateOrderRequest($UserToken, $params);
        }

        $this->response($response);
    }
    
    public function sendCaasifyCreateOrderRequest($UserToken, $params)
    {

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'orders', 'create'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

//






















// New for view page
    public function CaasifyGetOrderViews()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        $machineID = caasify_get_post('machineID');

        if($UserToken){
            $response = $this->sendOrderViewsRequest($UserToken, $machineID);
        }

        $this->response($response);
    }

    public function sendOrderViewsRequest($UserToken, $machineID)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $machineID, 'views'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }


    public function CaasifyOrderDoAction()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        $machineID = caasify_get_post('machineID');
        $button_id = caasify_get_post('button_id');

        if($UserToken){
            $response = $this->sendOrderAction($UserToken, $machineID, $button_id);
        }

        $this->response($response);
    }

    public function sendOrderAction($UserToken, $machineID, $button_id)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $params = array(
            'button_id' => $button_id,
        );

        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $machineID, 'action'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }


    public function CaasifyRequestNewView()
    {
        $UserToken = $this->getUserTokenFromDB();
        $response = null;

        $machineID = caasify_get_post('machineID');

        if($UserToken){
            $response = $this->sendNewViewRequest($UserToken, $machineID);
        }

        $this->response($response);
    }

    public function sendNewViewRequest($UserToken, $machineID)
    {
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $UserToken
        ];
        
        $BackendUrl = $this->BackendUrl;
        
        $address = [
            $BackendUrl, 'api', 'orders', $machineID, 'view'
        ];

        return Request::instance()->setAddress($address)->setHeaders($headers)->getResponse()->asObject();
    }















//

















// Trans --------------------------
    public function CreateUnpaidInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E01-Create Invoice)';
        }

        $userId = $this->clientId;
        $currentDateTime = date('Y-m-d');
        $nextDay = date('Y-m-d', strtotime($currentDateTime . ' +1 day'));
        
        if(isset($chargeamount) && isset($userId)){
            $command = 'CreateInvoice';
            $postData = array(
                'userid' => $userId,
                'taxrate' => '0',
                'date' => $currentDateTime,
                'duedate' => $nextDay,
                'itemdescription1' => 'Charge Caasify Account',
                'itemamount1' => $chargeamount,
                'itemtaxed1' => '0',
                'notes' => 'This is an auto created invoice. If it has yet been unpaid, 
                            you should check it with Client Caasify Account and if Transaction has down successfully, 
                            then ask customer to pay this invoice',
                'autoapplycredit' => '0',
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }

    public function markCancelInvoice()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'Can not access Invoice Id (E02-Mark Cancel)';
        }

        $userId = $this->clientId;
        $currentDateTime = date('Y-m-d');

        $command = 'UpdateInvoice';
            $postData = array(
                'invoiceid' => $invoiceid,
                'status' => 'Cancelled',
                'date' => $currentDateTime,
                'notes' => 'This invoice created automatically to charge Caasify Balance, but we have error in Caasify Api request, 
                            so this invoice cancelled automatically, it means that the Caasify balance did not charged',
            );
            $results = localAPI($command, $postData);
            $this->response($results); 
    }

    public function chargeCaasify()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);

        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access invoice id (E03-Charge Caasify)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E03-Charge Caasify)';
        }

        $userId = $this->getCaasifyUserIDFromDB();
        if(empty($userId)){
            return false;
        }
        
        $ResellerToken = $this->ResellerToken;
    
        $response = $this->sendChargeCaasifyRequest($userId, $chargeamount, $invoiceid);
        $this->response($response);
    }

    public function sendChargeCaasifyRequest($userId, $chargeamount, $invoiceid)
    {
        $ResellerToken = $this->ResellerToken;

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $ResellerToken
        ];


        $params = [
            'amount' => $chargeamount,
            'type' => 'balance',
            'invoiceid' => $invoiceid,
            'status' => 'paid'
        ];


        $BackendUrl = $this->BackendUrl;

        $address = [
            $BackendUrl, 'api', 'users', $userId, 'transactions', 'create'
        ];
        
        return Request::instance()->setAddress($address)->setHeaders($headers)->setParams($params)->getResponse()->asObject();
    }

    public function applyTheCredit()
    {
        $requestData = json_decode(file_get_contents("php://input"), true);
        if($requestData['invoiceid']){
            $invoiceid = $requestData['invoiceid'];
        } else {
            echo 'can not access user id (E04-Apply Credit)';
        }
        
        if($requestData['chargeamount']){
            $chargeamount = $requestData['chargeamount'];
        } else {
            echo 'can not access charge amount (E04-Apply Credit)';
        }

        if(isset($chargeamount) && isset($invoiceid)){
            $command = 'ApplyCredit';
            $postData = array(
                'invoiceid' => $invoiceid,
                'amount' => $chargeamount,
            );

            $results = localAPI($command, $postData);
            $this->response($results); 
        } 
    }  
// End Trans --------------------------
























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