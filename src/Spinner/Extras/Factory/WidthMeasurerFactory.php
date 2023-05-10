<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Extras\WidthMeasurer;
use Closure;

use function AlecRabbit\WCWidth\wcswidth;
use function mb_strlen;

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
