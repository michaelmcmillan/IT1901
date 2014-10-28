<?php
/**
 * Bootstrap
 */
require 'vendor/autoload.php';
require 'rb.php';
require 'configuration.php';

$app = new \Slim\Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views/',
    'url' => $config['url']
));

R::setup('mysql:host='.$config['host'].';dbname='.$config['db'],
    $config['user'], $config['pass']);

session_start ();

require 'controllers/authenticationController.php';
require 'controllers/serverController.php';
requrie 'controllers/adminController.php';
require 'controllers/userController.php';
require 'controllers/apiController.php';

$app->error(function (\Exception $e) use ($app) {

    if ($e instanceof apiException) {

        $app->response->headers->set('Content-Type', 'application/json');
        echo json_encode (array ('message' => $e->getMessage()));

    } else {

        echo $e->getMessage();

    }
});

$app->run();
