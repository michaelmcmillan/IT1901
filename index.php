<?php
/**
 * Bootstrap
 */
require 'vendor/autoload.php';
$app = new \Slim\Slim();

require 'controllers/serverController.php';
require 'controllers/authenticationController.php';

$app->error(function (\Exception $e) use ($app) {
    echo $e->getMessage();
});


$app->run();
