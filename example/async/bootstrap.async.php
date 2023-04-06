<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.php';

if (!function_exists('finalizeSpinner')) {
    function finalizeSpinner(ISpinner $spinner, int $runTime = 5): void
    {
        $loop = Facade::getLoop();
        $loop->delay(
            $runTime,
            static function () use ($loop, $spinner): void {
                $loop->stop();
                $spinner->finalize();
            }
        );
    }
}
