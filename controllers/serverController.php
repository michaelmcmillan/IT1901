<?php

/**
 * Deploy
 * - Acts when a git hook is invoked
 */
$app->post('/deploy', function () {
    $script = 'cd /home/groupswww/it1901gr16; ./deploy.sh 2>&1';
    $output = shell_exec ($script);
    print_r($output);
});
