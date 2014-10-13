<?php

/**
 * View: Form
 * - Displays the form for authentication
 */
$app->get('/', function () use ($app) {
    $app->render('header.php');
    $app->render('login.php');
    $app->render('footer.php');
});

/**
 * Authentication
 * - Handles authentication logic
 */
$app->post('/authenticate', function () use ($app) {
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
