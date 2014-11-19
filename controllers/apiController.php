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
$isAvailable = function ($cabinId, $from, $to, $beds) use ($app) {

    $reservations = R::exportAll(R::find('reservations',
        ' cabin_id = :cabinId', array (
            ':cabinId' => $cabinId,
        )
    ));

    /* Find if collision between reservations */
    $reservationCollisions = array ();
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

            /* Add as a collision */
            $reservationCollisions[] = $reservation;
        }
    }

    /* Presume no beds are taken */
    $bedsAlreadyTaken = 0;

    /* But if collisions were found, find how many beds are already taken */
    if (empty($reservationCollisions) == false) {
        foreach ($reservationCollisions as $reservation) {
            $bedsAlreadyTaken += $reservation['beds'];
        }
    }

    /* Find the total amount of beds on selected cabin */
    $cabin = R::load('cabins', $cabinId);
    $totalBedsAtCabin = $cabin->beds;

    /* Are we exceeding the total available beds with new reservation */
    if ($bedsAlreadyTaken + $beds > $totalBedsAtCabin) {
        $availableBedsLeft = $totalBedsAtCabin - $bedsAlreadyTaken;

        if ($availableBedsLeft > 0)
            $app->error(new apiException(
                'Det er kun '. $availableBedsLeft .' ledige ' .
                'senger igjen.'
            ));

        elseif ($availableBedsLeft == 1)
            $app->error(new apiException(
                'Det er kun '. $availableBedsLeft .' ledig ' .
                'seng igjen.'
            ));

        else
            $app->error(new apiException(
                'Det er dessverre ingen ledige ' .
                'senger igjen på denne koien.'
            ));
    }

    /* It's safe to allow the reservation */
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

    if (strtotime($from) >= strtotime($to))
        $app->error(new apiException('Oppholdets start må være før oppholdets slutt.'));

    if ($beds < 1)
        $app->error(new apiException('Du må reservere minst èn seng.'));

    /* Check if cabin is available (will throw exception) */
    $isAvailable($cabinId, $from, $to, $beds);

    /* Safe to reserve */
    $reservation = R::dispense('reservations');
    $reservation->userId  = $_SESSION['user']['id'];
    $reservation->cabinId = $cabinId;
    $reservation->beds    = $beds;
    $reservation->from    = date('Y-m-d H:i:s', strtotime($from));
    $reservation->to      = date('Y-m-d H:i:s', strtotime($to));
    $id = R::store($reservation);

    /* If database stored the reservation without problems */
    if (!$id)
        $app->error(new apiException('Noe gikk galt. Prøv igjen senere.'));

    /* Build status msg */
     $statusQuery = R::getAll(
         'select * from reservations '.
             'left join reports   on reports.reservation_id = reservations.id '.
             'left join inventory on reports.inventory_id   = inventory.id '.
         'where reservations.cabin_id = :cabinId and '.
         '      received_report = "1" ' .
         'order by reservations.to desc;', array (
             ':cabinId' => (int) $cabinId
     ));

     /* Return the objects as json*/
     $statusString = '';
     $statuses = R::convertToBeans('test', $statusQuery);
     foreach ($statuses as $status) {
         if ($status->broken == 1) {
             $statusString += json_encode ($status);
         }
     }

    /* Send an email confirmation */
    $userEmail = R::load('users', $_SESSION['user']['id'])->email;
    $userEmail = 'email@michaelmcmillan.net';
    $subject = 'Kvittering på koiereservasjon';

    $message = 'Hei! Du har reservert '. R::load('cabins', $cabinId)->name.' fra ' .
               $from . ' til ' . $to . ' for '.$beds.' person(er)!';
    $headers = 'From: michaedm@stud.ntnu.no' . "\r\n" .
        'Reply-To: michaedm@stud.ntnu.no' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($userEmail, $subject, $message, $headers);

    echo json_encode (array ('message' => 'success'), true);

});

/**
 * GET /reservations
 * - Returns an array of all previous reservation by the user
 */
$app->get('/reservations', function () use ($app) {

    /* Must be authenticated */
    if (!isset($_SESSION['user']))
        $app->error(new apiException('Du må være innlogget.'));

    /* Get reservations which are in the past (by currently logged in user) */
    $query = R::getAll(
        'select reservations.*, cabins.name from reservations  '.
        'left join cabins on reservations.cabin_id = cabins.id '.
        'where user_id = :userId and '               .
        'unix_timestamp(reservations.to) <= unix_timestamp(now())', array (
            ':userId' => $_SESSION['user']['id']
    ));

    $reservations = R::convertToBeans('reservations', $query);
    echo json_encode (R::exportAll($reservations), true);

});


/**
 * POST /reservations/:id/report
 * - Stores a report for a given reservation
 */
$app->post('/reservations/:reservationId/report', function ($reservationId) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    /* Must be authenticated */
    if (!isset($_SESSION['user']))
        $app->error(new apiException('Du må være innlogget.'));

    /* The reservation requested must exist */
    $reservation = R::load('reservations', (int) $reservationId);
    if (empty($reservation))
        $app->error(new apiException('Ugyldig reservasjon.'));

    /* There can not exist a previous report on this reservation (one-to-one) */
    if (R::findOne('reports', ' reservation_id = ?', array ($reservationId))

    /* Unless the user is an administrator */
    &&  !isset($_SESSION['user']['admin']))
        $app->error(new apiException('Det finnes allerede en rapport for denne reservasjonen.'));

    /* A user can only report on a reservation belonging to himself */
    if ($reservation->userId !== $_SESSION['user']['id']

    /* ... unless the user is an admin */
    &&  !isset($_SESSION['user']['admin']))
        $app->error(new apiException('Du har ikke lov til å rapportere på dette oppholdet.'));

    /* Retrieve the JSON payload and store each field in the reports table */
    $reportFields = json_decode($app->request->getBody(), true);

    foreach ($reportFields as $reportField) {

        /* Try to load an exisisting report */
        $exisistingReport = R::findOne('reports',
            'reservation_id = ? and inventory_id = ?', array (
                $reservationId,
                $reportField['statusId']
        ));

        /* If we found one, update that one instead of creating a new report */
        if (!empty($exisistingReport)) {
            $report = $exisistingReport;
        }

        /* We found no exisisting report, so let's create a new one */
        else
            $report = R::dispense('reports');

        /* Fill in the attributes from the payload */
        $report->reservationId = (int)  $reservationId;
        $report->inventoryId   = (int)  $reportField['statusId'];
        $report->broken        = (bool) $reportField['broken'];
        $report->comment       =        $reportField['comment'];

        /* Save the changes */
        R::store($report);
    }

    /* Mark the reservation-report as received */
    $reservation->receivedReport = true;
    R::store($reservation);

    /* If user is submitting, alert the admin */
    $adminEmail = 'michaedm@stud.ntnu.no';
    $subject = 'Rapport motatt for koie';
    $koie    = R::load('cabins', $reservation->cabinId);
    $message = 'Hei! En rapport har nettopp blitt registrert på ' . $koie->name . '.';
    $headers = 'From: michaedm@stud.ntnu.no' . "\r\n" .
        'Reply-To: michaedm@stud.ntnu.no' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($adminEmail, $subject, $message, $headers);

    echo json_encode (array ('message' => 'success'), true);
});

/**
 * GET /cabins/:id/inventory
 * - Returns an array of all inventory for a cabin
 */
$app->get('/cabins/:cabinId/inventory', function ($cabinId) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    $query = R::getAll(
        'select inventory_status.*, inventory.name from inventory_status left '.
        'join inventory on inventory_status.inventory_id = inventory.id '.
        'where inventory_status.cabin_id = :cabinId', array (
            ':cabinId' => (int) $cabinId
    ));

    $inventory = R::convertToBeans('inventory_status', $query);
    echo json_encode (R::exportAll($inventory), true);
});

/**
 * GET /cabins/:id/status
 * - Returns a status for a provided cabin
 */
$app->get('/cabins/:cabinId/status', function ($cabinId) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    /* Must be an administrator */
    if (!isset($_SESSION['user']['admin']))
        $app->error(new apiException('Du må være administrator for dette.'));

    /* Return the last report for the given cabin */
    $query = R::getAll(
        'select * from reservations '.
            'left join reports   on reports.reservation_id = reservations.id '.
            'left join inventory on reports.inventory_id   = inventory.id '.
        'where reservations.cabin_id = :cabinId '.
        'and   reservations.to       < now()', array (
            ':cabinId' => (int) $cabinId
    ));

    /* Return the objects as json*/
    $reports = R::convertToBeans('inventory_status', $query);

    /* Filter away unsubmitted reports */
    $reportsToReturn = array ();
    foreach (R::exportAll($reports) as $report)
        if (!empty($report['name']))
            $reportsToReturn[] = $report;

    /* If no reports were found throw exception */
    if (empty($reportsToReturn))
        throw new apiException ('Denne koien har ingen rapporter.');

    echo json_encode ($reportsToReturn, true);
});

/**
 * GET /cabins/:id/statistics
 * - Returns statistics for a provided cabin
 */
$app->get('/cabins/:cabinId/statistics', function ($cabinId) use ($app) {
    $app->response->headers->set('Content-Type', 'application/json');

    /* Must be an administrator */
    if (!isset($_SESSION['user']['admin']))
        $app->error(new apiException('Du må være administrator for dette.'));

    /* Return the last report for the given cabin */
    $query = R::getAll(
        'select * from reservations '.
        'where reservations.cabin_id = :cabinId '.
        'and   reservations.to       > now() - interval 6 month', array (
            ':cabinId' => (int) $cabinId
    ));

    /* Return the objects as json*/
    $stats = R::exportAll(R::convertToBeans('inventory_status', $query));

    /* If no reports were found throw exception */
    if (empty($stats))
        throw new apiException ('Denne koien har ingen statistikk.');

    /* Generate array for months */
    $statsToReturn = array (
        new stdClass(), new stdClass(),
        new stdClass(), new stdClass(),
        new stdClass(), new stdClass(),
        new stdClass(), new stdClass(),
        new stdClass(), new stdClass(),
        new stdClass(), new stdClass(),
    );

    /* Build month object from redbean */
    foreach ($stats as $key => $stat) {
        $monthNumber = (int) date('m', strtotime($stat['to']));
        $month = $statsToReturn[$monthNumber];
        $month->beds += $stat['beds'];
        $month->month = $monthNumber + 1;
    }

    /* Fill in empty stats */
    foreach ($statsToReturn as $key => $statToReturn) {
        $bufferMonth = new stdClass();
        $bufferMonth->beds = 0;
        $bufferMonth->month = $key + 1;
        if (!isset($statToReturn->beds))
            $statsToReturn[$key] = $bufferMonth;
    }

    echo json_encode ($statsToReturn, true);
});
