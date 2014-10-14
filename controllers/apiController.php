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

    $reservations = R::exportAll(R::find('reservations',
        ' cabin_id = :cabinId', array (
            ':cabinId' => $cabinId,
        )
    ));

    /* Must be available if no reservations were found */
    if (!$reservations)
        return true;

    /* Find if collision between reservations */
    foreach ($reservations as $key => $reservation) {

        /**
         *    [----]
         *  [----]
         */
        if ((strtotime($from) >= strtotime($reservation['from']))
        &&  (strtotime($from) <= strtotime($reservation['to']))

        /**
         *  [----]
         *    [----]
         */
        || (strtotime($to) <= strtotime($reservation['to']))
        && (strtotime($to) >= strtotime($reservation['from']))) {
            return false;
        }
    }

    return true;
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
$app->post('/reserve/:cabinId', function ($cabinId) use ($app, $isAvailable) {
    $app->response->headers->set('Content-Type', 'application/json');

    $cabinId = (int)     $cabinId;
    $beds    = (int)     $app->request->post('beds');
    $from    =           $app->request->post('from');
    $to      =           $app->request->post('to');

    if (!$from || !$to || !$beds)
        $app->error(new apiException('Du må velge noe på alle feltene.'));

    if ($beds < 1 || $beds > 5)
        $app->error(new apiException('Du kan makismalt reservere 5 senger.'));

    /* Check if cabin is available */
    if ($isAvailable($cabinId, $from, $to) == true) {

        $reservation = R::dispense('reservations');
        $reservation->userId  = $_SESSION['user']['id'];
        $reservation->cabinId = $cabinId;
        $reservation->beds    = $beds;
        $reservation->from    = date('Y-m-d H:i:s', strtotime($from));
        $reservation->to      = date('Y-m-d H:i:s', strtotime($to));
        $id = R::store($reservation);

        if (!$id)
            $app->error(new apiException('Noe gikk galt. Prøv igjen senere.'));

        echo json_encode (array ('message' => 'success'), true);

    /* Cabin is taken */
    } else {

        $app->error(new apiException('Koien er desverre opptatt på de datoene.'));

    }
});
