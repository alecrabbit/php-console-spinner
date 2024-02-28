<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;

final readonly class DriverFactory implements IDriverFactory
{
    public function __construct(
        private IDriverMessages $driverMessages,
        private IDriverBuilder $driverBuilder,
        private IIntervalFactory $intervalFactory,
        private IIntervalComparator $intervalComparator,
        private IRenderer $renderer,
    ) {
    }

    public function create(): IDriver
    {
        return $this->driverBuilder
            ->withInitialInterval(
                $this->intervalFactory->createStill()
            )
            ->withDriverMessages($this->driverMessages)
            ->withIntervalComparator($this->intervalComparator)
            ->withRenderer($this->renderer)
            ->build()
        ;
    }
}
