<?php

/**
 * Deploy
 * - Acts when a git hook is invoked
 */
$app->post('/deploy', function () use ($app) {
    $payload = json_decode($app->request->getBody(), true);

    if ($payload['ref'] == 'refs/heads/production') {
        $script = '/home/groupswww/it1901gr16/deploy.sh';
        exec ($script, $output);
        print_r($output);
    }
});
