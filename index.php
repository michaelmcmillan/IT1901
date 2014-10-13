<?php
/**
 * Bootstrap
 */
require 'vendor/autoload.php';
require 'rb.php';
require 'configuration.php';

$url =
$app = new \Slim\Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views/',
    'url' => $config['url']
));

R::setup('mysql:host='.$config['host'].';dbname='.$config['db'],
    $config['user'], $config['pass']);

session_start ();

require 'controllers/serverController.php';
require 'controllers/authenticationController.php';
require 'controllers/userController.php';

$app->error(function (\Exception $e) use ($app) {
    echo $e->getMessage();
});

$app->run();
