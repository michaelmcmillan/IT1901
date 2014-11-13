<?php
/**
 * Bootstrap
 */
date_default_timezone_set('Europe/Oslo');

require 'vendor/autoload.php';
require 'rb.php';
require 'configuration.php';

$app = new \Slim\Slim();
$app->config(array(
    'debug' => 0,
    'templates.path' => 'views/',
    'url' => $config['url']
));

R::setup('mysql:host='.$config['host'].';dbname='.$config['db'],
    $config['user'], $config['pass']);

/* Kick off session */
session_start ();

/* Require controllers */
require 'controllers/authenticationController.php';
require 'controllers/serverController.php';
require 'controllers/adminController.php';
require 'controllers/userController.php';
require 'controllers/apiController.php';

/* Exception handler */
$app->error(function (\Exception $e) use ($app) {
    if ($e instanceof apiException) {
        $app->response->headers->set('Content-Type', 'application/json');
        echo json_encode (array ('message' => $e->getMessage()));
    } else {
        echo $e->getMessage();
    }
});

/* Lift-off */
$app->run();
