<?php
/**
 * Bootstrap
 */
require 'vendor/autoload.php';
require 'rb.php';
require 'configuration.php';
error_reporting(-1);
ini_set('display_errors', 'On');
$app = new \Slim\Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views/'
));

R::setup('mysql:host='.$config['host'].';dbname='.$config['db'],
    $config['user'], $config['pass']);


require 'controllers/serverController.php';
require 'controllers/authenticationController.php';

$app->error(function (\Exception $e) use ($app) {
    echo $e->getMessage();
});

$app->run();
