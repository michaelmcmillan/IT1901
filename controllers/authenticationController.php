<?php

/**
 * Middleware: authenticateFor
 * - Checks user role
 */
$authenticateFor = function ($role = 'user') use ($app) {
    return function () use ($role, $app) {

        /* If required role is 'user' */
        if ($role == 'user' && !isset($_SESSION['user']))
            $app->redirect($app->config('url').'/index.php/authenticate');

        /* If required role is 'administrator' */
        if ($role == 'admin' && $_SESSION['user']['admin'] == false)
            $app->redirect($app->config('url').'/index.php/authenticate');
    };
};

/**
 * Funnel the request to correct view
 */
$app->get('/', $authenticateFor(), function () use ($app) {
    if (!empty($_SESSION['user']['admin']))
        $app->redirect($app->config('url').'/index.php/admin');
    else
        $app->redirect($app->config('url').'/index.php/user');
});

/**
 * View: Form
 * - Displays the form for authentication
 */
$app->get('/authenticate', function () use ($app) {
    $app->render('header.php', array ('url' => $app->config('url')));
    $app->render('login.php');
    $app->render('footer.php', array ('url' => $app->config('url')));
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

    /* Check credentials */
    $user = R::findOne('users', ' email = ? ', array ($username));

    if (empty($user))
        $app->error(new Exception('Fant ingen brukere med det brukernavnet.'));

    if ($user->password !== $password)
        $app->error(new Exception('Feil passord.'));

    /* Credentials match, initiate session*/
    $_SESSION['user'] = array (
        'id'    => $user->id,
        'admin' => $user->administrator
    );

    /* Redirect to funnel */
    $app->redirect($app->config('url').'/index.php');
});

/**
 * Logout
 * - Clears session
 */
$app->get('/logout', function () use ($app) {
    // Insert logout logic here.
});
