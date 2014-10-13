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

/**
 * POST /reserve/:cabinId
 * - @param from (date) (string)
 * - @param to   (date) (string)
 */
$app->post('/reserve/:cabinId', function ($cabinId) use ($app) {

    $cabinId = (int)     $cabinId;
    $beds    = (int)     $app->request->post('beds');
    $from    = strtotime($app->request->post('from'));
    $to      = strtotime($app->request->post('to'));

    if (!$from || !$to || !$beds || $beds >= 1 && $beds <= 5)
        $app->error(new Exception('Du må oppgi dato og antall senger.'));

    $reservation = R::dispense('reservations');
    $reservation->userId  = $_SESSION['user']['id'];
    $reservation->cabinId = $cabinId;
    $reservation->beds    = $beds;
    $reservation->from    = date('Y-m-d H:i:s', $from);
    $reservation->to      = date('Y-m-d H:i:s', $to);
    $id = R::store($reservation);

    if (!$id)
        $app->error(new Exception('Noe gikk galt. Prøv igjen senere.'));

    echo json_encode (array ('success' => true), true);
});
