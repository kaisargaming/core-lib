<?php
require __DIR__ . '/../vendor/autoload.php';

use KGaming\Core\HttpClient;
use KGaming\Core\Messenger;

$http_client = new HttpClient();
$messenger = new Messenger();

$messenger->show('Request GET Method');
// GET Request Method
$http_client->get('https://www.php.net')->exec();
$messenger->show($http_client->getStatusCode());
$messenger->show($http_client->getHeader());

$messenger->show('Request POST Method');
// POST Request Method
$http_client->setPayload('name','Kaisar')
    ->setPayload('Hometown', 'DKI/Jakarta')
    ->post('https://postman-echo.com/post')
    ->form()
    ->setHeader('Accept', 'application/json')
    ->exec();
$messenger->show($http_client->getStatusCode());
$messenger->show($http_client->getHeader());
$messenger->show($http_client->getBody());

$messenger->show('POST JSON Request');
// POST JSON Request
$payload = [
    'title' => 'Post a Json payload',
    'description' => 'Execute an HTTP POST Request with JSON Payload using curl.'
];
$http_client->post('https://postman-echo.com/post', $payload)
    ->json()
    ->exec();
$messenger->show($http_client->getStatusCode());
$messenger->show($http_client->getHeader());
$messenger->show($http_client->getBody());
