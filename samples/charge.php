<?php

require_once('../vendor/autoload.php');

use Epay\Config;
use Epay\Service\Login;
use Epay\Service\CardCharging;
use Epay\CardType;

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
    echo '-- SessionID: ' . $response->SessionID . '<br />';

    $config->SessionID = $response->SessionID;

    $test_cards = array(
        array(
            'Serial' => '12345778912',
            'CardNo' => '123456789111',
            'Provider' => CardType::VINAPHONE,
        ),
        array(
            'Serial' => '12345678923',
            'CardNo' => '113456789222',
            'Provider' => CardType::MOBIFONE,
        ),
        array(
            'Serial' => '12345678942',
            'CardNo' => '1133557893',
            'Provider' => CardType::FPTGATE,
        ),
        array(
            'Serial' => '12345678911',
            'CardNo' => '1234567891112',
            'Provider' => CardType::VIETTEL,
        ),
        array(
            'Serial' => '12345688911',
            'CardNo' => '123456789121',
            'Provider' => CardType::MEGACARD,
        ),
        array(
            'Serial' => '12345678912',
            'CardNo' => '123456798',
            'Provider' => CardType::VINAPHONE,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::VINAPHONE,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::MOBIFONE,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::ONCASH,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::FPTGATE,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::VIETTEL,
        ),
        array(
            'Serial' => '12345678999',
            'CardNo' => '123456799',
            'Provider' => CardType::MEGACARD,
        ),
    );

    $service = new CardCharging($config);
    foreach ($test_cards as $card) {
        echo sprintf('Charge %s:%s:%s<br />', $card['Serial'], $card['CardNo'], $card['Provider']);
        $response = $service->run($card);

        if ($response->Status == 1) {
            echo '-- Success<br />';
            echo '-- Thong tin giao dich<br />';
            echo '---- So tien: ' . $response->ResponseAmount . '<br />';
            echo '---- Giao dich: ' . $response->TransID . '<br />';
        } else {
            echo '-- Error: ' . $response->Status . ', ' . $response->Message . '<br />';
        }

        ob_flush();
        flush();
    }
}