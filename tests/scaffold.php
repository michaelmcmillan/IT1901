<?php

/**
 * Create a test-user
 */
$testUser = R::dispense('users');
$testUser->id            = 0;
$testUser->email         = 'it1901@test.ing';
$testUser->password      = 'it1901';
$testUser->administrator = 0;
R::store($testUser);

/**
 * Create a cabin
 */
$testCabin = R::dispense('cabins');
$testCabin->id        = 0;
$testCabin->name      = 'Flåkoia';
$testCabin->latitude  = '63.15729451';
$testCabin->longitude = '10.36541530';
$testCabin->beds      = 5;
R::store($testCabin);

/**
 * Create a reservation
 */
$testReservation = R::dispense('reservations');
$testReservation->id        = 0;
$testReservation->user_id   = 0;
$testReservation->from      = '2014-10-28 00:00:00';
$testReservation->to        = '2014-10-30 00:00:00';
$testReservation->beds      = 1;
R::store($testReservation);
