<?php
use WHMCS\Database\Capsule;
use WHMCS\Service\Service;
use WHMCS\User\Client;

$path = dirname(__FILE__);
echo($path);
require_once $path . '/AdminCaasifyController.php';
require_once $path . '/basics.php';

add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
    /** @var \WHMCS\View\Menu\Item $primaryNavbar */
   
    $config = caasify_get_config();
    $DemoMode = $config['DemoMode'];

    if(isset($DemoMode) && $DemoMode == 'on'){
        $newMenu = $primaryNavbar->addChild(
            'uniqueMenuItemName',
            array(
                'name' => 'Caasify Marketplace DEMO',
                'label' => 'Caasify Marketplace DEMO',
                'uri' => '/index.php?m=caasify&action=pageIndex',
                'order' => 99,
                'icon' => '',
            )
        );
    } else {
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
    }
});

// Remove extra menu in demo
add_hook('ClientAreaPrimaryNavbar', 1, function($primaryNavbar) {
    /** @var \WHMCS\View\Menu\Item $primaryNavbar */
    

    $config = caasify_get_config();
    $DemoMode = $config['DemoMode'];  
    
    if(isset($DemoMode) && $DemoMode == 'on'){

        if (!is_null($primaryNavbar->getChild('Store'))){
            $primaryNavbar->removeChild('Store');
        }
        
        if (!is_null($primaryNavbar->getChild('Announcements'))){
            $primaryNavbar->removeChild('Announcements');
        }
        
        if (!is_null($primaryNavbar->getChild('Knowledgebase'))){
            $primaryNavbar->removeChild('Knowledgebase');
        }
        
        if (!is_null($primaryNavbar->getChild('Network Status'))){
            $primaryNavbar->removeChild('Network Status');
        }
        
        if (!is_null($primaryNavbar->getChild('Marketplace'))){
            $primaryNavbar->removeChild('Marketplace');
        }
        
        if (!is_null($primaryNavbar->getChild('Services'))){
            $primaryNavbar->removeChild('Services');
        }
        
        if (!is_null($primaryNavbar->getChild('Domains'))){
            $primaryNavbar->removeChild('Domains');
        }
        
        if (!is_null($primaryNavbar->getChild('Home'))){
            $primaryNavbar->removeChild('Home');
        }
        
        if (!is_null($primaryNavbar->getChild('Contact Us'))){
            $primaryNavbar->removeChild('Contact Us');
        }
        
        if (!is_null($primaryNavbar->getChild('Open Ticket'))){
            $primaryNavbar->removeChild('Open Ticket');
        }
       
        if (!is_null($primaryNavbar->getChild('Support'))){
            $primaryNavbar->removeChild('Support');
        }
       
        if (!is_null($primaryNavbar->getChild('Billing'))){
            $primaryNavbar->removeChild('Billing');
        }

    }

});

// Create User Token in DataBase
add_hook('ClientAreaPage', 100, function($params) {
    $WhUserId = caasify_get_session('uid');
    if(empty($WhUserId)){
        // echo 'can not find WhUserId to construct controller  in ClientAreaPage';
        return false;
    }

    $config = caasify_get_config();
    $ResellerToken = caasify_get_reseller_token();
    $BackendUrl = $config['BackendUrl'];    

    if(empty($config)){
        echo 'can not find config in ClientAreaPage <br>';
        return false;
    }
    
    if(empty($ResellerToken)){
        echo 'can not find ResellerToken to construct controller in ClientAreaPage <br>';
        return false;
    }

    if(empty($BackendUrl)){
        echo 'can not find BackendUrl to construct controller  in ClientAreaPage <br>';
        return false;
    } 


    $UserToken = caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId);
    if(empty($UserToken)){
        echo 'can not get UserToken from handler func in Client hook <br>';
        return false;
    }  
});

add_hook('AdminAreaClientSummaryPage', 1, function($vars) {
    // TODO: Admin view
    
    // Check if it is admin
    $admin = caasify_get_session('adminid');
    if(empty($admin)){
        return false;
    }

    $config = caasify_get_config();
    $ResellerToken = caasify_get_reseller_token();
    $BackendUrl = $config['BackendUrl'];
    $WhUserId = $vars['userid'];

    if(empty($config)){
        echo 'can not find config in AdminHook <br>';
        return false;
    }
    
    if(empty($ResellerToken)){
        echo 'can not find ResellerToken to construct controller in AdminHook <br>';
        return false;
    }

    if(empty($BackendUrl)){
        echo 'can not find BackendUrl to construct controller  in AdminHook <br>';
        return false;
    } 

    if(empty($WhUserId)){
        echo 'can not find WhUserId to construct controller  in AdminHook <br>';
        return false;
    }
    
    // GET token
    $UserToken = caasify_get_token_by_handling($ResellerToken, $BackendUrl, $WhUserId);
    if(empty($UserToken)){
        echo 'can not get UserToken from handler func in AdminHook <br>';
        return false;
    }
    
    $CaasifyUserId = caasify_get_CaasifyUserId_from_WhmUserId($WhUserId);
    if(empty($CaasifyUserId)){
        echo('Can not find caasify user id by WhUserId in BD <br>');
        return false;
    }
    
    $DevelopeMode = $config['DevelopeMode'];
    if(empty($DevelopeMode)){
        $DevelopeMode = 'off';
    }

    $action = caasify_get_query('action');
    if(!empty($action) && !empty($UserToken) && !empty($CaasifyUserId) && !empty($ResellerToken) && !empty($BackendUrl)){
        try {
            $controller = new AdminCaasifyController($BackendUrl, $ResellerToken, $UserToken, $CaasifyUserId, $WhUserId);
            return $controller->handle($action);
        } catch (Exception $e) {
            if($DevelopeMode == 'on'){
                echo "Error run AdminController in admin hook: <br>" . $e . "<br>";
                return false;
            } else {
                echo('Error while run admin controler <br>');
                return false;
            }
        }
    }

    $systemUrl = $config['systemUrl'];
    if(empty($systemUrl)){
        $systemUrl = '';
    }


    $link = $systemUrl . '/modules/addons/caasify/views/view/admin.php?userid=' . $WhUserId;
    $value = '
        <iframe src="' . $link . '" class="caasify"></iframe>
        <style type="text/css"> .caasify{width: 100%; height: 600px;border: none;}</style>
    ';
    
    return $value;

});