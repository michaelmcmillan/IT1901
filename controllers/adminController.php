<?php
/**
 * View: User
 * - Displays the user dashboard
 */
$app->get('/admin', $authenticateFor('admin'), function () use ($app) {

    $app->render('header.php', array ('url' => $app->config('url')));
    $app->render('admin.php',  array ('url' => $app->config('url')));
    $app->render('footer.php', array (
        'url'   => $app->config('url'),
        'admin' => true,
        'user'  => false
    ));
});
