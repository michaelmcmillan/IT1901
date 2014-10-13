<?php
/**
 * GET /cabins
 * - Returns an array of all cabin-objects
 */
$app->get('/cabins', function () use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    $cabins = R::find('cabins');

    echo json_encode (R::exportAll($cabins), true);
});
