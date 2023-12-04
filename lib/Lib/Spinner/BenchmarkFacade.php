<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Benchmark\Contract\Factory\IBenchmarkResultsFactory;
use AlecRabbit\Benchmark\Contract\IReportPrinter;
use AlecRabbit\Spinner\Root\A\AFacade;

/**
 * @codeCoverageIgnore
 */
final class BenchmarkFacade extends AFacade
{
    public static function getReportPrinter(): IReportPrinter
    {
        return self::getContainer()->get(IReportPrinter::class);
    }

    public static function getBenchmarkResultsFactory(): IBenchmarkResultsFactory
    {
        return self::getContainer()->get(IBenchmarkResultsFactory::class);
    }
}
