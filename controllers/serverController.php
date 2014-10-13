<?php

/**
 * Deploy
 * - Acts when a git hook is invoked
 */
$app->post('/deploy', function () {
    $script = '/home/groupswww/it1901gr16/deploy.sh';
    $output = shell_exec ($script);
    print_r($output);
});
