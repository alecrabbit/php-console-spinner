<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Spinner\Factory;

use AlecRabbit\Benchmark\Spinner\Contract\Factory\IBenchmarkingDriverFactory;
use AlecRabbit\Spinner\Core\Contract\IDriverSetup;
use AlecRabbit\Spinner\Core\Factory\A\ADriverProviderFactory;

final class BenchmarkingDriverProviderFactory extends ADriverProviderFactory
{
    public function __construct(
        IBenchmarkingDriverFactory $driverFactory,
        IDriverSetup $driverSetup,
    ) {
        parent::__construct($driverFactory, $driverSetup);
    }
}
