<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../tests/bootstrap.php';
require_once __DIR__ . '/__include/__functions.php';       // Functions for this demo

use AlecRabbit\SpinnerOld\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 300;

$spinner = new SnakeSpinner();
// or
//$spinner = new SnakeSpinner('Message');

$spinner->begin();
$interval = (int)($spinner->interval() * 1000000);
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep($interval); // Simulating work
//    $spinner
//        ->progress($i / ITERATIONS)   // You can set progress value separately
//                                      // from calling spin() method see below
//        ->spin();
    // or
    $spinner->spin();
    // simulating separate run path
    if (rnd(100) > 70) {
        $spinner
            ->progress($i / ITERATIONS);
    }
    if (rnd(100) > 98) {
        $spinner
            ->message(date('H:i:s') . ' Refreshed');
    }
}
$spinner->end();
