<?php
require 'vendor/autoload.php';
$app = new \Slim\Slim();

/**
 * Error handling
 * - Fires when an exception is thrown
 */
$app->error(function (\Exception $e) use ($app) {
    echo $e->getMessage();
});

/**
 * View: Form
 * - Displays the form for authentication
 */
$app->get('/', function () {
    echo '<form method="post" action="authentication">';
    echo '<input type="text" name="username">';
    echo '<input type="password" name="password">';
    echo '<input type="submit" value="Logg inn">';
    echo '</form>';
});

/**
 * Login
 * - Handles authentication logic
 */
$app->post('/login', function () use ($app) {
    $username = $app->request->post('username');
    $password = $app->request->post('password');

    if (!$username || !$password)
        $app->error(new Exception('Vennligst oppgi brukernavn & passord.'));


});

/**
 * Logout
 * - Clears session
 */
$app->get('/logout', function () use ($app) {
    // Insert logout logic here.
});

$app->run();
