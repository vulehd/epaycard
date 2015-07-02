<?php

require_once('../vendor/autoload.php');

use Epay\Config;
use Epay\Service\Login;
use Epay\Service\Logout;

$config = new Config(array(
    'EndPoint' => 'http://charging-test.megapay.net.vn:10001/CardChargingGW_V2.0/services/Services?wsdl',
    'PublicKeyFile' => dirname(__FILE__) . '/Epay_Public_key.pem',
    'PrivateKeyFile' => dirname(__FILE__) . '/kh0016_mykey.pem',
    'PartnerID' => 'charging01',
    'PartnerCode' => '00477',
    'MPIN' => 'pajwtlzcb',
    'UserName' => 'charging01',
    'Password' => 'gmwtwjfws',
));

echo 'Login <br />';
$service = new Login($config);
$response = $service->run();

if ($response->Status == 1) {
    echo '-- Success ';
    echo '-- SessionID: '.$response->SessionID . '<br />';

    // logout
    echo 'Logout <br />';
    $config->SessionID = $response->SessionID;

    $service = new Logout($config);
    $response = $service->run();

    if ($response->Status == 1) {
        echo '-- Logout Success<br />';
    } else {
        echo '-- Error: '.$response->Status.', '.$response->Message.'<br />';
    }

}