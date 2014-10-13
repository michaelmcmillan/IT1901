<?php
/**
 * View: User
 * - Displays the user dashboard
 */
$app->get('/user', $authenticateFor('user'), function () use ($app) {

    $app->render('header.php', array ('url' => $app->config('url')));
    $app->render('user.php');
    $app->render('footer.php', array ('url' => $app->config('url')));

});
