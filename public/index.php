<?php

require __DIR__ . '/../vendor/autoload.php';

use Gicho\App;
use Symfony\Component\HttpFoundation\Request;


ini_set('display_errors', true);

$rootDirectory = __DIR__ . '/..';
$app = new App($rootDirectory);

$request = Request::createFromGlobals();
$response = $app->run($request);

$response->send();
