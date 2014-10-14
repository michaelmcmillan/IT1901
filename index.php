<?php
/**
 * Bootstrap
 */
require 'vendor/autoload.php';
require 'rb.php';

/* MySQL when in production & staging*/
if (!getenv('travis')) {

    require 'configuration.php';
    R::setup('mysql:host='.$config['host'].';dbname='.$config['db'],
        $config['user'], $config['pass']);

/* Sqlite when testing */
} else {

    /* Setup sqlitedb */
    R::setup('sqlite:/' . getcwd() . '/tests/sqlite.db');

    /* Scaffold if empty */
    $test = R::load('users', 0);
    if (empty($test->email))
        require 'tests/scaffold.php';

    /* Set url for test */
    $config['url'] = 'http://localhost:1337';
}

/* Bootstrap Slim */
$app = new \Slim\Slim();
$app->config(array(
    'debug' => true,
    'templates.path' => 'views/',
    'url' => $config['url']
));

session_start ();

require 'controllers/serverController.php';
require 'controllers/authenticationController.php';
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
