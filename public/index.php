<?php

use App\Core\Router;


require_once __DIR__ . '/../bootstrap.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
//header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: *');
//header('Access-Control-Allow-Headers: Authorization');
//header('Access-Control-Allow-Headers: X-Requested-With');
//header('Access-Control-Allow-Headers: Content-Type');


//ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$uri = str_replace('/public/','', $_SERVER['REQUEST_URI']);


//if (strpos($uri, "/api") === false) {
//    require_once "index.php";
//    die();
//}


try {
    $router = new Router;
    $router->run();
} catch (\Exception $error) {
    echo $error->getMessage();
}






