<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/../tests/bootstrap.php';

use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\SnakeSpinner;

/**
 * It's a very basic example just to show the concept
 */

const ITERATIONS = 300;

$spinner = new SnakeSpinner();
// or
//$spinner = new SnakeSpinner('Message');

echo Cursor::hide();
echo PHP_EOL;

$spinner->begin();
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep(80000); // Simulating work
    $spinner->spin();
    // or
    //$spinner->spin($i/ITERATIONS);
}
$spinner->end();

echo Cursor::show();
echo PHP_EOL;
