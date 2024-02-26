<?php
use PG\Request\Request;
use WHMCS\Database\Capsule;

class AdminCaasifyController
{
    protected $WhUserId;
    protected $userToken;
    protected $ResellerBackendUrl;
    protected $ResellerToken;

    public function __construct($WhUserId, $userToken, $ResellerBackendUrl, $ResellerToken){
        $this->WhUserId = $WhUserId;
        $this->userToken = $userToken;
        $this->ResellerBackendUrl = $ResellerBackendUrl;
        $this->ResellerToken = $ResellerToken;
    }

    public function admin_getUseIdByToken(){
        $userToken = $this->userToken;

        $params = [
            'token' => $userToken,
        ];
        
        $ResellerBackendUrl = $this->ResellerBackendUrl;
        $address = [
            $ResellerBackendUrl, 'candy', 'frontend', 'auth', 'token', 'login'
        ];
        
        $response = Request::instance()->setAddress($address)->setParams($params)->getResponse()->asObject();
        return $response->data->id;
    }

    public function response($response)
    {
        header('Content-Type: application/json');

        $response = json_encode($response);

        exit($response);
    }

    public function handle($action)
    {
        $class = new ReflectionClass($this);

        $method = $class->getMethod($action);

        if ($method) {
            return $method->invoke($this);
        }
    }
}
