<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\WidthMeasurer;
use Closure;

use function AlecRabbit\WCWidth\wcswidth;

final class WidthMeasurerFactory implements IWidthMeasurerFactory
{
    public function create(): IWidthMeasurer
    {
        return new WidthMeasurer(
            self::measureFunction()
        );
    }

    /**
     * @codeCoverageIgnore
     */
    private static function measureFunction(): Closure
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
