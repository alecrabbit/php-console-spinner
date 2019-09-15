<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\Spinner\SnakeSpinner;

const ITERATIONS = 50;

$spinner = new SnakeSpinner();

$spinner->begin();
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep(80000); // Simulating work
    $spinner->spin();
}
$spinner->end();
echo PHP_EOL;
// You can continue with your spinner
$spinner->begin();
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep(80000); // Simulating work
    $spinner->spin();
}
$spinner->end();