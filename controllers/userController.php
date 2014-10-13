<?php
/**
 * View: User
 * - Displays the user dashboard
 */
$app->get('/user', $authenticateFor('user'), function () use ($app) {
    echo 'logged inn på bruker';
    
});
