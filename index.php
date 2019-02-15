<?php

require __DIR__ . '/vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use \Dhl\Express\Model\Request\Shipment\ShipmentDetails;
use Dhl\Express\RequestBuilder\ShipmentRequestBuilder;
use Dhl\Express\Webservice\SoapServiceFactory;

$logger = new \Psr\Log\NullLogger();

$serviceFactory = new SoapServiceFactory();
$service = $serviceFactory->createShipmentService('sbhskshvhg', 'y878678', $logger);

$requestBuilder = new ShipmentRequestBuilder();
$requestBuilder->setIsUnscheduledPickup($unscheduledPickup = true)
               ->setTermsOfTrade($termsOfTrade = ShipmentDetails::PAYMENT_TYPE_CFR)
               ->setContentType($contentType = ShipmentDetails::CONTENT_TYPE_NON_DOCUMENTS)
               ->setReadyAtTimestamp($readyAtTimestamp = 238948923)
               ->setNumberOfPieces($numberOfPieces = 12)
               ->setCurrency($currencyCode = 'EUR')
               ->setDescription($description = 'a description.')
               ->setCustomsValue($customsValue = 1.0)
               ->setServiceType($serviceType = 'U')
               ->setPayerAccountNumber($accountNumber = 'XXXXXXX')
               ->setInsurance($insuranceValue = 99.99, $insuranceCurrency = 'EUR')
               ->setShipper(
                   $countryCode = 'DE',
                   $postalCode = '12345',
                   $city = 'Berlin',
                   $streetLines = [
                       'Sample street 5a',
                       'Sample street 5b',
                   ],
                   $name = 'Max Mustermann',
                   $company = 'Acme',
                   $phone = '004922832432423',
                   $email = 'rafa1@yopmail.com'
               )
               ->setRecipient(
                   $countryCode,
                   $postalCode,
                   $city,
                   $streetLines,
                   $name,
                   $company,
                   $phone,
                   $email = 'rafa2@yopmail.com'
               )
               ->setDryIce($unCode = 'UN1845', $weight = 20.53);

$requestBuilder->addPackage(
    1,
    1.123,
    'kg',
    1.123,
    1.123,
    1.123,
    'Cm',
    'Customer References'
);

$request = $requestBuilder->build();

try {
    $response = $service->createShipment($request);
    var_dump($response);
} catch(Exception $e) {
    var_dump($e->getMessage());
}

die();