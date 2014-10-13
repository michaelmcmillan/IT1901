<?php

/**
 * apiException
 * - Returns a JSON object when thrown
 */
class apiException extends Exception {

}

/**
 * isAvailable
 * - Determines if a cabin is available
 * - @param cabinid (integer)
 * - @param from    (string)
 * - @param to      (string)
 * - @return boolean
 */
$isAvailable = function ($cabinId, $from, $to) {

    

};

/**
 * GET /cabins
 * - Returns an array of all cabin-objects
 */
$app->get('/cabins', function () use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    $cabins = R::find('cabins');
    echo json_encode (R::exportAll($cabins), true);
});

/**
 * POST /reserve/:cabinId
 * - @param from (date) (string)
 * - @param to   (date) (string)
 */
$app->post('/reserve/:cabinId', function ($cabinId) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    $cabinId = (int)     $cabinId;
    $beds    = (int)     $app->request->post('beds');
    $from    = strtotime($app->request->post('from'));
    $to      = strtotime($app->request->post('to'));

    if (!$from || !$to || !$beds)
        $app->error(new apiException('Du må velge noe på alle feltene.'));

    if ($beds < 1 || $beds > 5)
        $app->error(new apiException('Du kan makismalt reservere 5 senger.'));

    $reservation = R::dispense('reservations');
    $reservation->userId  = $_SESSION['user']['id'];
    $reservation->cabinId = $cabinId;
    $reservation->beds    = $beds;
    $reservation->from    = date('Y-m-d H:i:s', $from);
    $reservation->to      = date('Y-m-d H:i:s', $to);
    $id = R::store($reservation);

    if (!$id)
        $app->error(new apiException('Noe gikk galt. Prøv igjen senere.'));

    echo json_encode (array ('message' => 'success'), true);
});
