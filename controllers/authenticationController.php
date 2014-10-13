<?php

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
 * Authentication
 * - Handles authentication logic
 */
$app->post('/authentication', function () use ($app) {
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
