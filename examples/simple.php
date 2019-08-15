<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\Spinner\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 300;

$spinner = new SnakeSpinner();
// or
//$spinner = new SnakeSpinner('Message');

$spinner->begin();
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep(80000); // Simulating work
    $spinner->spin($i/ITERATIONS);
    // or
    //    $spinner->spin();
}
$spinner->end();
