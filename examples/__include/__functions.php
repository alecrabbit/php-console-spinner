<?php declare(strict_types=1);

use AlecRabbit\SpinnerOld\Core\Contracts\SpinnerInterface;
use AlecRabbit\SpinnerOld\PercentSpinner;

/**
 * @param int $max
 * @return int
 */
function rnd(int $max): int
{
    try {
        return random_int(0, $max);
    } catch (Exception $e) {
        return 0;
    }
}
