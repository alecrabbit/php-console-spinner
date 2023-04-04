<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\WidthMeasurer;
use AlecRabbit\Spinner\Core\Factory\Contract\IDeterminerFactory;
use Closure;

use function AlecRabbit\WCWidth\wcswidth;

final class DeterminerFactory implements IDeterminerFactory
{
    public function create(): IWidthMeasurer
    {
        return
            new WidthMeasurer(
                self::determinerFunction()
            );
    }

    /**
     * @codeCoverageIgnore
     */
    private static function determinerFunction(): Closure
    {
        if (function_exists('\AlecRabbit\WCWidth\wcswidth')) {
            return wcswidth(...);
        }
        if (function_exists('\mb_strlen')) {
            return mb_strlen(...);
        }
        return strlen(...);
    }
}